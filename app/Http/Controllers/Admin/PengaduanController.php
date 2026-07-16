<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Mail\StatusLaporanMail;
use App\Models\{Notifikasi, Pengaduan, PengaduanHistory, User};
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class PengaduanController extends Controller
{
    public function index(Request $request)
    {
        $query = Pengaduan::with(['user', 'kategori', 'wilaya', 'petugas']);
        if ($request->filled('status'))   $query->where('status', $request->status);
        if ($request->filled('kategori')) $query->where('kategori_id', $request->kategori);
        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('judul', 'like', '%'.$request->search.'%')
                  ->orWhere('kode_laporan', 'like', '%'.$request->search.'%');
            });
        }
        $pengaduans = $query->latest()->paginate(20)->withQueryString();
        $petugas    = User::where('role', 'petugas')->get();
        return view('admin.pengaduan.index', compact('pengaduans', 'petugas'));
    }

    public function show(Pengaduan $pengaduan)
    {
        $pengaduan->load([
            'user', 'kategori', 'wilaya',
            'tanggapans.user', 'histories.user', 'petugas',
            'penilaians.user',
        ]);
        $petugas = User::where('role', 'petugas')->get();
        return view('admin.pengaduan.show', compact('pengaduan', 'petugas'));
    }

    public function updateStatus(Request $request, Pengaduan $pengaduan)
    {
        $request->validate([
            'status'     => 'required|in:menunggu,proses,selesai,ditolak',
            'keterangan' => 'nullable|string|max:500',
            'petugas_id' => 'nullable|exists:users,id',
        ]);

        $statusLama = $pengaduan->status;

        $pengaduan->update([
            'status'       => $request->status,
            'petugas_id'   => $request->petugas_id ?? $pengaduan->petugas_id,
            'alasan_tolak' => $request->status === 'ditolak' ? $request->keterangan : null,
        ]);

        PengaduanHistory::create([
            'pengaduan_id' => $pengaduan->id,
            'user_id'      => Auth::id(),
            'status_lama'  => $statusLama,
            'status_baru'  => $request->status,
            'keterangan'   => $request->keterangan,
        ]);

        $badge = $pengaduan->status_badge;

        // ── Notifikasi ke pelapor ──────────────────────────────
        Notifikasi::create([
            'user_id' => $pengaduan->user_id,
            'judul'   => 'Status Laporan Diperbarui',
            'pesan'   => "Laporan \"{$pengaduan->judul}\" sekarang berstatus: {$badge['label']}.",
            'url'     => route('masyarakat.pengaduan.show', $pengaduan->slug),
            'tipe'    => $badge['color'] === 'green' ? 'success' : ($badge['color'] === 'red' ? 'danger' : 'info'),
        ]);

        // ── Notifikasi ke petugas yang ditugaskan ──────────────
        $petugasId = $request->petugas_id ?? $pengaduan->petugas_id;
        if ($petugasId && $petugasId !== Auth::id()) {
            Notifikasi::create([
                'user_id' => $petugasId,
                'judul'   => 'Status Laporan Diubah Admin',
                'pesan'   => "Admin mengubah status laporan \"{$pengaduan->judul}\" menjadi: {$badge['label']}.",
                'url'     => route('petugas.pengaduan.show', $pengaduan->slug),
                'tipe'    => 'info',
            ]);
        }

        // ── Email ke pelapor ───────────────────────────────────
        $pelapor = $pengaduan->user;
        if ($pelapor && $pelapor->email) {
            try {
                Mail::to($pelapor->email)
                    ->send(new StatusLaporanMail($pengaduan, $statusLama, $request->keterangan));
            } catch (\Exception $e) {
                \Log::warning('Gagal kirim email status laporan: ' . $e->getMessage());
            }
        }

        return back()->with('success', 'Status laporan berhasil diperbarui.');
    }

    public function assignPetugas(Request $request, Pengaduan $pengaduan)
    {
        $request->validate(['petugas_id' => 'required|exists:users,id']);

        $pengaduan->update(['petugas_id' => $request->petugas_id]);
        $petugas = User::find($request->petugas_id);

        // ── Notifikasi ke petugas yang ditugaskan ──────────────
        Notifikasi::create([
            'user_id' => $request->petugas_id,
            'judul'   => 'Laporan Ditugaskan ke Anda',
            'pesan'   => "Anda ditugaskan menangani laporan: \"{$pengaduan->judul}\".",
            'url'     => route('petugas.pengaduan.show', $pengaduan->slug),
            'tipe'    => 'info',
        ]);

        // ── Notifikasi ke pelapor ──────────────────────────────
        Notifikasi::create([
            'user_id' => $pengaduan->user_id,
            'judul'   => 'Petugas Ditugaskan',
            'pesan'   => "Laporan Anda \"{$pengaduan->judul}\" kini ditangani oleh {$petugas->name}.",
            'url'     => route('masyarakat.pengaduan.show', $pengaduan->slug),
            'tipe'    => 'info',
        ]);

        return back()->with('success', "Laporan berhasil ditugaskan ke {$petugas->name}.");
    }

    public function destroy(Pengaduan $pengaduan)
    {
        // ── Notifikasi ke pelapor sebelum dihapus ─────────────
        Notifikasi::create([
            'user_id' => $pengaduan->user_id,
            'judul'   => 'Laporan Dihapus',
            'pesan'   => "Laporan \"{$pengaduan->judul}\" telah dihapus oleh admin.",
            'url'     => route('masyarakat.pengaduan.index'),
            'tipe'    => 'danger',
        ]);

        $pengaduan->delete();
        return redirect()->route('admin.pengaduan.index')
            ->with('success', 'Laporan berhasil dihapus.');
    }

    public function chat(Pengaduan $pengaduan)
    {
        $pengaduan->load(['user', 'kategori', 'wilaya', 'petugas']);
        $pesans = \App\Models\PesanLaporan::with(['user', 'lampirans'])
            ->where('pengaduan_id', $pengaduan->id)
            ->oldest()->get();
        return view('admin.pengaduan.chat', compact('pengaduan', 'pesans'));
    }

    public function kirimPesan(Request $request, Pengaduan $pengaduan)
    {
        $request->validate([
            'pesan'       => 'nullable|string|max:2000',
            'lampirans'   => 'nullable|array',
            'lampirans.*' => 'file|mimes:jpg,jpeg,png,pdf,heic,heif,webp,avif,gif|max:15360',
        ]);
        $pesan = \App\Models\PesanLaporan::create([
            'pengaduan_id' => $pengaduan->id,
            'user_id'      => auth()->id(),
            'pesan'        => $request->pesan,
            'is_internal'  => $request->boolean('is_internal'),
        ]);
        if ($request->hasFile('lampirans')) {
            foreach ($request->file('lampirans') as $file) {
                $path = $file->store('chat-lampiran', 'public');
                \App\Models\PesanLampiran::create([
                    'pesan_id'  => $pesan->id,
                    'nama_file' => $file->getClientOriginalName(),
                    'path_file' => $path,
                    'tipe_file' => $file->getMimeType(),
                    'ukuran'    => $file->getSize(),
                ]);
            }
        }
        if ($request->ajax()) return response()->json(['success' => true]);
        return back();
    }

    public function pesanBaru(Request $request, Pengaduan $pengaduan)
    {
        $lastId = $request->last_id ?? 0;
        $pesans = \App\Models\PesanLaporan::with(['user', 'lampirans'])
            ->where('pengaduan_id', $pengaduan->id)
            ->where('id', '>', $lastId)
            ->oldest()->get()
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