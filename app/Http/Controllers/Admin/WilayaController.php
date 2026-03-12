<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Wilaya;
use Illuminate\Http\Request;

class WilayaController extends Controller
{
    public function index()
    {
        $wilayas = Wilaya::withCount('pengaduans')
                        ->orderBy('nama')
                        ->paginate(20);
        return view('admin.wilaya.index', compact('wilayas'));
    }

    public function store(Request $request)
    {
        $request->validate(['nama' => 'required|string|max:100|unique:wilayas,nama']);
        Wilaya::create([
            'nama'      => $request->nama,
            'slug'      => \Str::slug($request->nama),
            'tipe'      => 'kecamatan',
            'is_active' => true,
        ]);
        return back()->with('success', 'Daerah berhasil ditambahkan.');
    }

    public function update(Request $request, Wilaya $wilaya)
    {
        $request->validate(['nama' => 'required|string|max:100|unique:wilayas,nama,' . $wilaya->id]);
        $wilaya->update([
            'nama' => $request->nama,
            'slug' => \Str::slug($request->nama),
        ]);
        return back()->with('success', 'Daerah berhasil diupdate.');
    }

    public function destroy(Wilaya $wilaya)
    {
        if ($wilaya->users()->count() > 0) {
            return back()->withErrors(['error' => 'Daerah masih memiliki petugas, tidak bisa dihapus.']);
        }
        $wilaya->delete();
        return back()->with('success', 'Daerah berhasil dihapus.');
    }

    public function toggle(Wilaya $wilaya)
    {
        $wilaya->update(['is_active' => !$wilaya->is_active]);
        return back()->with('success', 'Status daerah diperbarui.');
    }
}