<?php
// ═══════════════════════════════════════════════════════════
// FILE: app/Http/Controllers/Admin/KategoriController.php
// ═══════════════════════════════════════════════════════════
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Kategori;
use Illuminate\Http\Request;

class KategoriController extends Controller
{
    public function index()
    {
        $kategoris = Kategori::withCount('pengaduans')->orderBy('urutan')->orderBy('nama')->get();
        return view('admin.kategori.index', compact('kategoris'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama'   => 'required|string|max:100|unique:kategoris,nama',
            'deskripsi' => 'nullable|string|max:500',
            'urutan' => 'nullable|integer|min:0',
        ]);

        Kategori::create([
            'nama'      => $request->nama,
            'deskripsi' => $request->deskripsi,
            'urutan'    => $request->urutan ?? 0,
            'is_active' => $request->has('is_active'),
        ]);

        return redirect()->route('admin.kategori.index')
                         ->with('success', "Kategori <strong>{$request->nama}</strong> berhasil ditambahkan.");
    }

    public function update(Request $request, Kategori $kategori)
    {
        $request->validate([
            'nama'   => "required|string|max:100|unique:kategoris,nama,{$kategori->id}",
            'deskripsi' => 'nullable|string|max:500',
            'urutan' => 'nullable|integer|min:0',
        ]);

        $kategori->update([
            'nama'      => $request->nama,
            'deskripsi' => $request->deskripsi,
            'urutan'    => $request->urutan ?? 0,
            'is_active' => $request->has('is_active'),
        ]);

        return redirect()->route('admin.kategori.index')
                         ->with('success', "Kategori <strong>{$request->nama}</strong> berhasil diperbarui.");
    }

    public function toggle(Kategori $kategori)
    {
        $kategori->update(['is_active' => !$kategori->is_active]);
        $status = $kategori->is_active ? 'diaktifkan' : 'dinonaktifkan';
        return back()->with('success', "Kategori <strong>{$kategori->nama}</strong> berhasil {$status}.");
    }

    public function destroy(Kategori $kategori)
    {
        if ($kategori->pengaduans()->count() > 0) {
            return back()->with('error', 'Kategori tidak dapat dihapus karena masih memiliki laporan.');
        }
        $nama = $kategori->nama;
        $kategori->delete();
        return redirect()->route('admin.kategori.index')
                         ->with('success', "Kategori <strong>{$nama}</strong> berhasil dihapus.");
    }
}