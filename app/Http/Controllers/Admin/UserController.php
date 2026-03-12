<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Wilaya;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $users = User::with('wilaya')
            ->when($request->role, fn($q) => $q->where('role', $request->role))
            ->when($request->search, fn($q) => $q->where('name', 'like', "%{$request->search}%")
                ->orWhere('email', 'like', "%{$request->search}%"))
            ->latest()->paginate(15);

        return view('admin.user.index', compact('users'));
    }

    public function create()
    {
        $wilayas = Wilaya::where('is_active', true)->orderBy('nama')->get();
        return view('admin.user.create', compact('wilayas'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'      => 'required|string|max:100',
            'email'     => 'required|email|unique:users,email,NULL,id,deleted_at,NULL',
            'role'      => 'required|in:petugas,masyarakat',
            'no_hp'     => 'nullable|string|max:20',
            'wilaya_id' => 'nullable|exists:wilayas,id',
        ]);

        $passwordSementara = 'BL-' . strtoupper(Str::random(8));

        $user = User::create([
            'name'                 => $request->name,
            'email'                => $request->email,
            'password'             => Hash::make($passwordSementara),
            'role'                 => $request->role,
            'no_hp'                => $request->no_hp,
            'wilaya_id'            => $request->role === 'petugas' ? $request->wilaya_id : null,
            'is_active'            => true,
            'must_change_password' => $request->role === 'petugas',
        ]);

        if ($request->role === 'petugas') {
            try {
                Mail::to($user->email)->send(
                    new \App\Mail\AkunPetugasMail($user, $passwordSementara)
                );
                $pesan = "Akun petugas berhasil dibuat. Email dikirim ke <strong>{$user->email}</strong>.";
            } catch (\Exception $e) {
                $pesan = "Akun berhasil dibuat. Gagal kirim email. Password sementara: <strong>{$passwordSementara}</strong>";
            }
        } else {
            $pesan = "Akun <strong>{$user->name}</strong> berhasil dibuat. Password sementara: <strong>{$passwordSementara}</strong>";
        }

        return redirect()->route('admin.user.index')->with('success', $pesan);
    }

    public function edit(User $user)
    {
        $wilayas = Wilaya::where('is_active', true)->orderBy('nama')->get();
        return view('admin.user.edit', compact('user', 'wilayas'));
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'name'      => 'required|string|max:100',
            'email'     => 'required|email|unique:users,email,' . $user->id,
            'role'      => 'required|in:masyarakat,petugas',
            'wilaya_id' => 'nullable|exists:wilayas,id',
            'no_hp'     => 'nullable|string|max:20',
            'nik'       => 'nullable|string|max:16',
            'alamat'    => 'nullable|string|max:255',
            'password'  => 'nullable|min:6',
        ]);

        $data = [
            'name'      => $request->name,
            'email'     => $request->email,
            'role'      => $request->role,
            'wilaya_id' => $request->wilaya_id,
            'no_hp'     => $request->no_hp,
            'nik'       => $request->nik,
            'alamat'    => $request->alamat,
        ];

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $user->update($data);

        return redirect()->route('admin.user.index')
            ->with('success', "Akun <strong>{$user->name}</strong> berhasil diupdate.");
    }

    public function toggleActive(User $user)
    {
        if ($user->id === auth()->id()) {
            abort(403, 'Tidak bisa menonaktifkan akun sendiri.');
        }

        $user->update(['is_active' => !$user->is_active]);

        $status = $user->is_active ? 'diaktifkan' : 'dinonaktifkan';
        return back()->with('success', "Akun <strong>{$user->name}</strong> berhasil {$status}.");
    }

    public function destroy(User $user)
    {
        if ($user->id === auth()->id()) {
            return back()->with('error', 'Tidak bisa menghapus akun sendiri.');
        }

        $nama = $user->name;
        $user->forceDelete();

        return redirect()->route('admin.user.index')
            ->with('success', "Akun <strong>{$nama}</strong> berhasil dihapus permanen.");
    }
}