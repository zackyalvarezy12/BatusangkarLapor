<?php

namespace App\Http\Controllers\Masyarakat;

use App\Http\Controllers\Controller;
use App\Models\{Kategori, Notifikasi, Pengaduan, PengaduanHistory, User, Wilaya};
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PengaduanController extends Controller
{
    public function index(Request $request)
    {
        $pengaduans = Pengaduan::where('user_id', Auth::id())
            ->with(['kategori', 'wilaya', 'petugas'])
            ->when($request->status, fn($q) => $q->where('status', $request->status))
            ->when($request->search, fn($q) => $q
                ->where('judul', 'like', "%{$request->search}%")
                ->orWhere('kode_laporan', 'like', "%{$request->search}%")
            )
            ->latest()
            ->paginate(10);

        return view('masyarakat.pengaduan.index', compact('pengaduans'));
    }

    public function create()
    {
        $kategoris  = \App\Models\Kategori::aktif()->orderBy('urutan')->get();
        $wilayas    = \App\Models\Wilaya::orderBy('nama')->get();
        $userWilaya = auth()->user()->load('wilaya')->wilaya;
        return view('masyarakat.pengaduan.create', compact('kategoris', 'wilayas', 'userWilaya'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'judul'       => 'required|string|max:200',
            'kategori_id' => 'required|exists:kategoris,id',
            'wilayah_id'  => 'required|exists:wilayas,id',
            'deskripsi'   => 'required|string',
            'lampiran'    => 'nullable|array|max:5',
            'lampiran.*'  => 'file|mimes:jpg,jpeg,png,pdf,heic,heif,webp,avif,gif|max:15360',
            'visibility'  => 'required|in:anonim,publik',
        ]);

        $lampiranPaths = [];
        if ($request->hasFile('lampiran')) {
            foreach ($request->file('lampiran') as $file) {
                $lampiranPaths[] = $file->store('lampiran-pengaduan', 'public');
            }
        }

        $pengaduan = Pengaduan::create([
            'judul'        => $request->judul,
            'user_id'      => auth()->id(),
            'kategori_id'  => $request->kategori_id,
            'wilaya_id'    => $request->wilayah_id,
            'deskripsi'    => $request->deskripsi,
            'lampiran'     => !empty($lampiranPaths) ? json_encode($lampiranPaths) : null,
            'is_anonim'    => $request->visibility === 'anonim',
            'is_publik'    => $request->visibility === 'publik',
            'status'       => 'menunggu',
        ]);

        PengaduanHistory::create([
            'pengaduan_id' => $pengaduan->id,
            'user_id'      => auth()->id(),
            'status_lama'  => null,
            'status_baru'  => 'menunggu',
            'keterangan'   => 'Laporan baru dibuat.',
        ]);

        // ── Notifikasi ke semua Admin ──────────────────────────
        $pelapor = auth()->user()->name;
        $admins  = User::where('role', 'admin')->get();
        foreach ($admins as $admin) {
            Notifikasi::create([
                'user_id' => $admin->id,
                'judul'   => 'Laporan Baru Masuk',
                'pesan'   => "Laporan baru dari {$pelapor}: \"{$pengaduan->judul}\".",
                'url'     => route('admin.pengaduan.show', $pengaduan->slug),
                'tipe'    => 'info',
            ]);
        }

        // ── Notifikasi ke Petugas wilayah ──────────────────────
        $petugas = User::where('role', 'petugas')
            ->where(function($q) use ($pengaduan) {
                $q->where('wilaya_id', $pengaduan->wilaya_id)
                  ->orWhereNull('wilaya_id'); // petugas semua wilayah
            })->get();
        foreach ($petugas as $p) {
            Notifikasi::create([
                'user_id' => $p->id,
                'judul'   => 'Laporan Baru di Wilayah Anda',
                'pesan'   => "Ada laporan baru: \"{$pengaduan->judul}\".",
                'url'     => route('petugas.pengaduan.show', $pengaduan->slug),
                'tipe'    => 'info',
            ]);
        }

        return redirect()->route('masyarakat.pengaduan.show', $pengaduan->slug)
            ->with('success', "Laporan berhasil dikirim! Kode: {$pengaduan->kode_laporan}");
    }

    public function show(Pengaduan $pengaduan)
    {
        abort_if(
            (int) $pengaduan->user_id !== (int) Auth::id() && !$pengaduan->is_publik,
            403
        );

        $pengaduan->increment('views');
        $pengaduan->load([
            'kategori', 'wilaya', 'tanggapans.user',
            'histories.user', 'petugas',
            'penilaians.user',
        ]);

        return view('masyarakat.pengaduan.show', compact('pengaduan'));
    }

    public function lacak(Request $request)
    {
        $pengaduan = null;
        if ($request->filled('token')) {
            $pengaduan = Pengaduan::where('tracking_token', $request->token)
                ->with(['kategori', 'wilaya', 'histories'])->first();
        }
        if ($request->filled('kode')) {
            $pengaduan = Pengaduan::where('kode_laporan', strtoupper($request->kode))
                ->with(['kategori', 'wilaya', 'histories'])->first();
        }
        return view('public.lacak', compact('pengaduan'));
    }

    public function destroy(Pengaduan $pengaduan)
    {
        abort_if((int) $pengaduan->user_id !== (int) Auth::id(), 403);
        abort_if($pengaduan->status !== 'menunggu', 403, 'Laporan yang sedang diproses tidak dapat dihapus.');
        $pengaduan->delete();
        return redirect()->route('masyarakat.pengaduan.index')
            ->with('success', 'Laporan berhasil dihapus.');
    }

    public function chat(Pengaduan $pengaduan)
    {
        if ((int) $pengaduan->user_id !== (int) auth()->id()) abort(403);
        $pengaduan->load(['kategori', 'wilaya', 'petugas']);
        $pesans = \App\Models\PesanLaporan::with(['user', 'lampirans'])
            ->where('pengaduan_id', $pengaduan->id)
            ->oldest()->get();
        return view('masyarakat.pengaduan.chat', compact('pengaduan', 'pesans'));
    }

    public function kirimPesan(Request $request, Pengaduan $pengaduan)
    {
        if ((int) $pengaduan->user_id !== (int) auth()->id()) {
            abort(403);
        }
        $request->validate([
            'pesan'       => 'nullable|string|max:2000',
            'lampirans'   => 'nullable|array',
            'lampirans.*' => 'file|mimes:jpg,jpeg,png,pdf,heic,heif,webp,avif,gif|max:15360',
        ]);
        if (!$request->filled('pesan') && !$request->hasFile('lampirans')) {
            return back()->withErrors(['pesan' => 'Pesan atau lampiran wajib diisi.']);
        }
        $pesan = \App\Models\PesanLaporan::create([
            'pengaduan_id' => $pengaduan->id,
            'user_id'      => auth()->id(),
            'pesan'        => $request->pesan,
            'is_internal'  => false,
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
        if ($request->ajax() || $request->expectsJson()) {
            $pesan->load('lampirans');
            return response()->json([
                'success' => true,
                'pesan' => [
                    'id' => $pesan->id,
                    'pesan' => $pesan->pesan,
                    'user_id' => $pesan->user_id,
                    'user' => auth()->user()->name,
                    'role' => auth()->user()->role,
                    'avatar' => auth()->user()->avatar_url,
                    'waktu' => $pesan->created_at->format('H:i'),
                    'tanggal' => $pesan->created_at->format('d M Y'),
                    'lampirans' => $pesan->lampirans->map(fn($l) => [
                        'nama_file' => $l->nama_file,
                        'url' => $l->url,
                        'tipe_file' => $l->tipe_file,
                        'is_image' => $l->isImage(),
                    ]),
                ],
            ]);
        }
        return back();
    }

    public function pesanBaru(Request $request, Pengaduan $pengaduan)
    {
        if ((int) $pengaduan->user_id !== (int) auth()->id()) abort(403);
        $lastId = $request->last_id ?? 0;
        $pesans = \App\Models\PesanLaporan::with(['user', 'lampirans'])
            ->where('pengaduan_id', $pengaduan->id)
            ->where('id', '>', $lastId)
            ->where('is_internal', false)
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