<?php
namespace App\Http\Controllers\Petugas;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ProfilController extends Controller
{
    public function edit() { return view('petugas.profil.edit'); }

    public function update(Request $request)
    {
        $request->validate(['name' => 'required|string|max:100']);
        auth()->user()->update($request->only('name','no_hp','alamat'));
        return back()->with('success', 'Profil berhasil diperbarui.');
    }

    public function editPassword() { return view('petugas.profil.password'); }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'password'         => 'required|min:8|confirmed',
        ]);
        if (!Hash::check($request->current_password, auth()->user()->password)) {
            return back()->withErrors(['current_password' => 'Password saat ini salah.']);
        }
        auth()->user()->update(['password' => Hash::make($request->password)]);
        return back()->with('success', 'Password berhasil diperbarui!');
    }
}