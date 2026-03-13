<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pengumuman;
use Illuminate\Http\Request;

class PengumumanController extends Controller
{
    public function index()
    {
        $pengumumans = Pengumuman::with('user')->latest()->paginate(15);
        return view('admin.pengumuman.index', compact('pengumumans'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'judul'   => 'required|string|max:255',
            'konten'  => 'required|string',
            'terbitkan' => 'nullable|boolean',
        ]);

        Pengumuman::create([
            'judul'          => $request->judul,
            'konten'         => $request->konten,
            'user_id'        => auth()->id(),
            'is_aktif'       => true,
            'diterbitkan_at' => $request->boolean('terbitkan') ? now() : null,
        ]);

        return back()->with('success', 'Pengumuman berhasil ditambahkan.');
    }

    public function update(Request $request, Pengumuman $pengumuman)
    {
        $request->validate([
            'judul'  => 'required|string|max:255',
            'konten' => 'required|string',
        ]);

        $pengumuman->update([
            'judul'  => $request->judul,
            'konten' => $request->konten,
            'diterbitkan_at' => $request->boolean('terbitkan')
                ? ($pengumuman->diterbitkan_at ?? now())
                : null,
        ]);

        return back()->with('success', 'Pengumuman berhasil diupdate.');
    }

    public function toggle(Pengumuman $pengumuman)
    {
        $pengumuman->update(['is_aktif' => !$pengumuman->is_aktif]);
        $status = $pengumuman->is_aktif ? 'diaktifkan' : 'dinonaktifkan';
        return back()->with('success', "Pengumuman berhasil {$status}.");
    }

    public function destroy(Pengumuman $pengumuman)
    {
        $pengumuman->delete();
        return back()->with('success', 'Pengumuman berhasil dihapus.');
    }
}