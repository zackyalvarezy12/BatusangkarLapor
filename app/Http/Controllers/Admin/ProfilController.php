<?php
// ═══════════════════════════════════════════════════════════
// FILE: app/Http/Controllers/Admin/ProfilController.php
// ═══════════════════════════════════════════════════════════
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ProfilController extends Controller
{
    public function edit()
    {
        return view('admin.profil.edit');
    }

    public function update(Request $request)
    {
        $request->validate([
            'name'   => 'required|string|max:255',
            'no_hp'  => 'nullable|string|max:20',
            'nik'    => 'nullable|string|max:16',
            'alamat' => 'nullable|string|max:500',
        ]);

        $user = auth()->user();
        $user->update($request->only('name', 'no_hp', 'nik', 'alamat'));

        return redirect()->route('admin.profil.edit')
                         ->with('success', 'Profil berhasil diperbarui.');
    }

    public function editPassword()
    {
        return view('admin.profil.password');
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'password'         => 'required|min:8|confirmed',
        ]);

        $user = auth()->user();

        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'Password saat ini tidak sesuai.']);
        }

        $user->update(['password' => Hash::make($request->password)]);

        return redirect()->route('admin.profil.edit')
                         ->with('success', 'Password berhasil diubah.');
    }
}