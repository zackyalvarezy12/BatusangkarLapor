<?php

namespace App\Http\Controllers\Masyarakat;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ProfilController extends Controller
{
    public function edit()
    {
        return view('masyarakat.profil.edit');
    }

    public function update(Request $request)
    {
        $request->validate([
            'name'   => 'required|string|max:100',
            'no_hp'  => 'nullable|string|max:20',
            'alamat' => 'nullable|string|max:255',
        ]);

        auth()->user()->update($request->only('name', 'no_hp', 'alamat'));

        return back()->with('success', 'Profil berhasil diperbarui.');
    }

    public function editPassword()
    {
        return view('masyarakat.profil.password');
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'nullable',
            'password'         => 'required|min:8|confirmed',
        ]);

        $user = auth()->user();
        $currentPassword = (string) $request->input('current_password', '');

        $isTemporaryPassword = $this->isTemporaryPassword($user, $currentPassword);

        if (!$isTemporaryPassword && $currentPassword !== '' && !Hash::check($currentPassword, $user->password)) {
            return back()->withErrors(['current_password' => 'Password saat ini salah.']);
        }

        if ($currentPassword === '' && !$this->isTemporaryPassword($user, '')) {
            return back()->withErrors(['current_password' => 'Password saat ini wajib diisi.']);
        }

        $user->update([
            'password'             => Hash::make($request->password),
            'must_change_password' => false,
        ]);

        return redirect()->route('masyarakat.dashboard')
                         ->with('success', 'Password berhasil diperbarui!');
    }

    private function isTemporaryPassword(User $user, string $currentPassword): bool
    {
        if (!$user->email) {
            return false;
        }

        $patterns = [
            '/^BL-[A-Z0-9]{8}$/',
        ];

        foreach ($patterns as $pattern) {
            if (preg_match($pattern, $currentPassword) === 1) {
                return true;
            }
        }

        return false;
    }
}
