<?php

namespace App\Http\Controllers\Petugas;

use App\Http\Controllers\Controller;
use App\Mail\StatusLaporanMail;
use App\Models\Pengaduan;
use App\Models\PengaduanHistory;
use App\Models\PesanLaporan;
use App\Models\PesanLampiran;
use App\Models\Notifikasi;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;

class PengaduanController extends Controller
{
    private function queryWilaya()
    {
        $user = auth()->user();
        $query = Pengaduan::with(['user', 'kategori', 'wilaya']);
        if (!is_null($user->wilaya_id)) {
            $query->where('wilaya_id', $user->wilaya_id);
        }
        return $query;
    }

    public function index(Request $request)
    {
        $search = trim((string) $request->search);

        $pengaduans = $this->queryWilaya()
            ->when($request->filled('status'), fn($q) => $q->where('status', $request->status))
            ->when($search !== '', function ($q) use ($search) {
                $q->where(function ($sub) use ($search) {
                    $sub->where('judul', 'like', "%{$search}%")
                        ->orWhere('kode_laporan', 'like', "%{$search}%");
                });
            })
            ->latest()
            ->paginate(15)
            ->withQueryString();

        return view('petugas.pengaduan.index', compact('pengaduans'));
    }

    public function show(Pengaduan $pengaduan)
    {
        $user = auth()->user();
        if (!is_null($user->wilaya_id)
            && $pengaduan->wilaya_id !== $user->wilaya_id
            && $user->role !== 'admin') {
            abort(403, 'Laporan ini bukan wilayah Anda.');
        }

        $pengaduan->load([
            'user', 'kategori', 'wilaya', 'petugas',
            'tanggapans.user', 'histories.user',
            'penilaians.user',
        ]);

        return view('petugas.pengaduan.show', compact('pengaduan'));
    }

    public function downloadPdf(Pengaduan $pengaduan)
    {
        $user = auth()->user();
        if (!is_null($user->wilaya_id) && $pengaduan->wilaya_id !== $user->wilaya_id) {
            abort(403, 'Laporan ini bukan wilayah Anda.');
        }

        $pengaduan->load(['user', 'kategori', 'wilaya', 'petugas', 'tanggapans.user', 'histories.user']);

        $lampiran = [];
        if ($pengaduan->lampiran) {
            $files = is_array($pengaduan->lampiran) ? $pengaduan->lampiran : json_decode($pengaduan->lampiran, true) ?? [];
            foreach ($files as $file) {
                $lampiran[] = [
                    'path' => $file,
                    'nama' => basename($file),
                    'isImage' => preg_match('/\.(jpg|jpeg|png|gif|webp)$/i', $file),
                ];
            }
        }

        $pdf = Pdf::loadView('petugas.pengaduan.pdf', [
            'pengaduan' => $pengaduan,
            'petugas' => auth()->user(),
            'lampiran' => $lampiran,
            'tanggalCetak' => now()->translatedFormat('d F Y'),
        ])->setPaper('a4', 'portrait');

        // Allow DomPDF to read local files (storage) and set chroot to workspace
        try {
            $pdf->setOptions([
                'isRemoteEnabled' => true,
                'chroot' => base_path(),
            ]);
        } catch (\Exception $e) {
            // ignore if option not supported in this environment
        }

        return $pdf->download('Laporan-Pengaduan-' . $pengaduan->kode_laporan . '.pdf');
    }

    public function updateStatus(Request $request, $pengaduan)
    {
        $pengaduan = $pengaduan instanceof Pengaduan
            ? $pengaduan
            : Pengaduan::where('slug', $pengaduan)->firstOrFail();

        $user = auth()->user();
        if (!is_null($user->wilaya_id) && $pengaduan->wilaya_id !== $user->wilaya_id) abort(403);

        $request->validate([
            'status'     => 'required|in:menunggu,proses,selesai,ditolak',
            'keterangan' => 'nullable|string|max:500',
            // allow images, pdf, office documents and common archives up to 50MB
            'bukti_file' => 'nullable|file|mimes:jpg,jpeg,png,gif,webp,pdf,doc,docx,xls,xlsx,zip,rar|max:51200',
        ]);

        $statusLama = $pengaduan->status;

        $data = [
            'status'     => $request->status,
            'petugas_id' => auth()->id(),
        ];

        if ($request->status === 'selesai') {
            if ($request->hasFile('bukti_file')) {
                $file = $request->file('bukti_file');
                $path = $file->store('bukti-selesai', 'public');
                $data['bukti_selesai_path'] = $path;
                $data['bukti_selesai_nama'] = $file->getClientOriginalName();
                $data['bukti_selesai_tipe'] = $file->getMimeType();
                $data['bukti_selesai_ukuran'] = $file->getSize();
            } else {
                return back()->withErrors(['bukti_file' => 'Bukti penyelesaian wajib diunggah saat menandai laporan selesai.']);
            }
        }

        $pengaduan->update($data);
        $pengaduan->refresh();

        PengaduanHistory::create([
            'pengaduan_id' => $pengaduan->id,
            'user_id'      => auth()->id(),
            'status_lama'  => $statusLama,
            'status_baru'  => $request->status,
            'keterangan'   => $request->keterangan ?? 'Status diperbarui oleh petugas.',
        ]);

        // Notifikasi in-app
        Notifikasi::create([
            'user_id' => $pengaduan->user_id,
            'judul'   => 'Status laporan diperbarui',
            'pesan'   => "Laporan #{$pengaduan->kode_laporan} kini berstatus: {$pengaduan->status_badge['label']}",
            'url'     => route('masyarakat.pengaduan.show', $pengaduan->slug),
            'tipe'    => 'status',
        ]);

        // Kirim email ke pelapor
        $pelapor = $pengaduan->user;
        if ($pelapor && $pelapor->email) {
            try {
                Mail::to($pelapor->email)
                    ->send(new StatusLaporanMail($pengaduan, $statusLama, $request->keterangan, $pengaduan->bukti_selesai_path));
            } catch (\Exception $e) {
                // Gagal kirim email tidak boleh hentikan proses
                \Log::warning('Gagal kirim email status laporan: ' . $e->getMessage());
            }
        }

        return back()->with('success', 'Status laporan berhasil diperbarui.');
    }

    public function tanggapi(Request $request, Pengaduan $pengaduan)
    {
        $request->validate(['isi' => 'required|string']);
        \App\Models\Tanggapan::create([
            'pengaduan_id' => $pengaduan->id,
            'user_id'      => auth()->id(),
            'isi'          => $request->isi,
            'is_internal'  => $request->boolean('is_internal'),
        ]);
        return back()->with('success', 'Tanggapan berhasil dikirim.');
    }

    public function chat(Pengaduan $pengaduan)
    {
        $user = auth()->user();
        if (!is_null($user->wilaya_id) && $pengaduan->wilaya_id !== $user->wilaya_id) {
            abort(403);
        }
        $pengaduan->load(['user', 'kategori', 'wilaya', 'petugas']);
        $pesans = PesanLaporan::with(['user', 'lampirans'])
            ->where('pengaduan_id', $pengaduan->id)
            ->oldest()->get();

        return view('petugas.pengaduan.chat', compact('pengaduan', 'pesans'));
    }

    public function kirimPesan(Request $request, Pengaduan $pengaduan)
    {
        $user = auth()->user();
        if (!is_null($user->wilaya_id) && $pengaduan->wilaya_id !== $user->wilaya_id) {
            abort(403);
        }

        $request->validate([
            'pesan'      => 'nullable|string|max:2000',
            'lampirans'  => 'nullable|array',
            'lampirans.*'=> 'file|max:10240',
        ]);

        if (!$request->filled('pesan') && !$request->hasFile('lampirans')) {
            return back()->withErrors(['pesan' => 'Pesan atau lampiran wajib diisi.']);
        }

        $pesan = PesanLaporan::create([
            'pengaduan_id' => $pengaduan->id,
            'user_id'      => auth()->id(),
            'pesan'        => $request->pesan,
            'is_internal'  => false,
        ]);

        if ($request->hasFile('lampirans')) {
            foreach ($request->file('lampirans') as $file) {
                $path = $file->store('chat-lampiran', 'public');
                PesanLampiran::create([
                    'pesan_id'   => $pesan->id,
                    'nama_file'  => $file->getClientOriginalName(),
                    'path_file'  => $path,
                    'tipe_file'  => $file->getMimeType(),
                    'ukuran'     => $file->getSize(),
                ]);
            }
        }

        Notifikasi::create([
            'user_id' => $pengaduan->user_id,
            'judul'   => 'Pesan baru dari petugas',
            'pesan'   => "Ada pesan baru di laporan #{$pengaduan->kode_laporan}",
            'url'     => route('masyarakat.pengaduan.chat', $pengaduan->slug),
            'tipe'    => 'pesan',
        ]);

        if ($request->ajax()) {
            return response()->json(['success' => true, 'pesan_id' => $pesan->id]);
        }
        return back()->with('success', 'Pesan terkirim.');
    }

    public function pesanBaru(Request $request, Pengaduan $pengaduan)
    {
        $lastId = $request->last_id ?? 0;
        $pesans = PesanLaporan::with(['user', 'lampirans'])
            ->where('pengaduan_id', $pengaduan->id)
            ->where('id', '>', $lastId)
            ->oldest()
            ->get()
            ->map(function ($p) {
                return [
                    'id'        => $p->id,
                    'pesan'     => $p->pesan,
                    'user'      => $p->user->name,
                    'user_id'   => $p->user_id,
                    'role'      => $p->user->role,
                    'avatar'    => $p->user->avatar_url,
                    'waktu'     => $p->created_at->format('H:i'),
                    'tanggal'   => $p->created_at->format('d M Y'),
                    'lampirans' => $p->lampirans->map(fn($l) => [
                        'id'        => $l->id,
                        'nama_file' => $l->nama_file,
                        'url'       => $l->url,
                        'tipe_file' => $l->tipe_file,
                        'is_image'  => $l->isImage(),
                    ]),
                ];
            });

        return response()->json($pesans);
    }
}