<?php

namespace App\Http\Controllers\Petugas;

use App\Http\Controllers\Controller;
use App\Models\Pengaduan;
use App\Models\PengaduanHistory;
use App\Models\PesanLaporan;
use App\Models\PesanLampiran;
use App\Models\Notifikasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PengaduanController extends Controller
{
    // Hanya laporan di wilayah petugas ini
    private function queryWilaya()
    {
        $user = auth()->user();
        $query = Pengaduan::with(['user', 'kategori', 'wilaya']);

        // Jika petugas punya wilaya_id, filter by wilayah
        // Jika null (belum ditetapkan), tampilkan semua agar tidak kosong
        if (!is_null($user->wilaya_id)) {
            $query->where('wilaya_id', $user->wilaya_id);
        }

        return $query;
    }

    public function index(Request $request)
    {
        $pengaduans = $this->queryWilaya()
            ->when($request->status, fn($q) => $q->where('status', $request->status))
            ->when($request->search, fn($q) => $q->where('judul', 'like', "%{$request->search}%"))
            ->latest()->paginate(15);

        return view('petugas.pengaduan.index', compact('pengaduans'));
    }

    public function show(Pengaduan $pengaduan)
    {
        $user = auth()->user();
        // Izinkan akses jika wilayah cocok, ATAU petugas belum ada wilayah, ATAU admin
        if (!is_null($user->wilaya_id)
            && $pengaduan->wilaya_id !== $user->wilaya_id
            && $user->role !== 'admin') {
            abort(403, 'Laporan ini bukan wilayah Anda.');
        }
        $pengaduan->load(['user', 'kategori', 'wilaya', 'petugas', 'tanggapans.user', 'histories.user']);
        return view('petugas.pengaduan.show', compact('pengaduan'));
    }

    public function updateStatus(Request $request, Pengaduan $pengaduan)
    {
        $user = auth()->user();
        if (!is_null($user->wilaya_id) && $pengaduan->wilaya_id !== $user->wilaya_id) abort(403);

        $request->validate([
            'status' => 'required|in:menunggu,proses,selesai,ditolak',
        ]);

        $statusLama = $pengaduan->status;
        $pengaduan->update([
            'status'     => $request->status,
            'petugas_id' => auth()->id(),
        ]);

        PengaduanHistory::create([
            'pengaduan_id' => $pengaduan->id,
            'user_id'      => auth()->id(),
            'status_lama'  => $statusLama,
            'status_baru'  => $request->status,
            'keterangan'   => $request->keterangan ?? 'Status diperbarui oleh petugas.',
        ]);

        // Notifikasi ke pelapor
        Notifikasi::create([
            'user_id' => $pengaduan->user_id,
            'judul'   => 'Status laporan diperbarui',
            'pesan'   => "Laporan #{$pengaduan->kode_laporan} kini berstatus: {$request->status}",
            'url'     => route('masyarakat.pengaduan.chat', $pengaduan->slug),
            'tipe'    => 'status',
        ]);

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
        // Boleh akses jika: wilaya_id null (semua wilayah) ATAU wilayah cocok
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
            'lampirans.*'=> 'file|max:10240', // 10MB per file
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

        // Notifikasi ke pelapor
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
                    'id'          => $p->id,
                    'pesan'       => $p->pesan,
                    'user'        => $p->user->name,
                    'user_id'     => $p->user_id,
                    'role'        => $p->user->role,
                    'avatar'      => $p->user->avatar_url,
                    'waktu'       => $p->created_at->format('H:i'),
                    'tanggal'     => $p->created_at->format('d M Y'),
                    'lampirans'   => $p->lampirans->map(fn($l) => [
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