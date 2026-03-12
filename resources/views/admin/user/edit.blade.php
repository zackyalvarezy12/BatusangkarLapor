@extends('layouts.admin')
@section('title', 'Edit Pengguna')
@section('breadcrumb', 'Edit Pengguna')

@section('content')
<div class="py-6 max-w-2xl mx-auto space-y-6">

    <div class="flex items-center gap-3">
        <a href="{{ route('admin.user.index') }}"
           class="w-9 h-9 bg-white border border-gray-200 rounded-xl flex items-center justify-center hover:bg-gray-50 transition shadow-sm">
            <svg class="w-4 h-4 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
            </svg>
        </a>
        <h1 class="font-black text-gray-800 text-xl">Edit Pengguna</h1>
    </div>

    {{-- Avatar --}}
    <div class="bg-white rounded-3xl shadow-sm border border-gray-100 p-6 flex items-center gap-5">
        <img src="{{ $user->avatar_url }}" class="w-16 h-16 rounded-2xl object-cover shadow-sm"
             onerror="this.style.display='none';this.nextElementSibling.style.display='flex'"
        >
        <div style="display:none;width:64px;height:64px;border-radius:16px;background:#1e3a8a;align-items:center;justify-content:center;font-size:22px;font-weight:900;color:white;flex-shrink:0;">
            {{ strtoupper(substr($user->name, 0, 1)) }}
        </div>
        <div>
            <p class="font-bold text-gray-800">{{ $user->name }}</p>
            <p class="text-gray-400 text-sm">{{ $user->email }}</p>
            <span class="inline-block mt-1 text-xs font-semibold px-2.5 py-0.5 rounded-full
                {{ $user->role==='admin'      ? 'bg-purple-100 text-purple-700' : '' }}
                {{ $user->role==='petugas'    ? 'bg-blue-100 text-blue-700'     : '' }}
                {{ $user->role==='masyarakat' ? 'bg-green-100 text-green-700'   : '' }}">
                {{ ucfirst($user->role) }}
            </span>
        </div>
    </div>

    {{-- ── FORM UTAMA ── --}}
    <div class="bg-white rounded-3xl shadow-sm border border-gray-100 p-8">
        <form method="POST" action="{{ route('admin.user.update', $user) }}" class="space-y-5">
            @csrf @method('PUT')

            {{-- Nama & Email --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Nama Lengkap</label>
                    <input type="text" name="name" value="{{ old('name', $user->name) }}" required
                           class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-blue-100 focus:border-blue-400 transition @error('name') border-red-400 @enderror">
                    @error('name')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Email</label>
                    <input type="email" name="email" value="{{ old('email', $user->email) }}" required
                           class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-blue-100 focus:border-blue-400 transition @error('email') border-red-400 @enderror">
                    @error('email')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>
            </div>

            {{-- Password & No HP --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                        Password Baru
                        <span class="text-gray-400 font-normal">(kosongkan jika tidak diubah)</span>
                    </label>
                    <input type="password" name="password" placeholder="Minimal 6 karakter"
                           class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-blue-100 focus:border-blue-400 transition @error('password') border-red-400 @enderror">
                    @error('password')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">No. HP</label>
                    <input type="text" name="no_hp" value="{{ old('no_hp', $user->no_hp) }}"
                           placeholder="08xxxxxxxxxx"
                           class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-blue-100 focus:border-blue-400 transition">
                </div>
            </div>

            {{-- NIK & Alamat --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">NIK</label>
                    <input type="text" name="nik" value="{{ old('nik', $user->nik) }}"
                           placeholder="16 digit NIK" maxlength="16"
                           class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-blue-100 focus:border-blue-400 transition">
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Alamat</label>
                    <input type="text" name="alamat" value="{{ old('alamat', $user->alamat) }}"
                           placeholder="Alamat lengkap"
                           class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-blue-100 focus:border-blue-400 transition">
                </div>
            </div>

            {{-- Role & Wilayah --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Role</label>
                    <select name="role" required
                            class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-blue-100 focus:border-blue-400 transition">
                        <option value="petugas"    {{ old('role',$user->role)==='petugas'    ? 'selected':'' }}>Petugas</option>
                        <option value="masyarakat" {{ old('role',$user->role)==='masyarakat' ? 'selected':'' }}>Masyarakat</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Wilayah</label>
                    <select name="wilaya_id"
                            class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-blue-100 focus:border-blue-400 transition">
                        <option value="">— Tidak ada —</option>
                        @foreach($wilayas as $w)
                        <option value="{{ $w->id }}" {{ old('wilaya_id', $user->wilaya_id)==$w->id ? 'selected':'' }}>
                            {{ $w->nama }}
                        </option>
                        @endforeach
                    </select>
                    <p class="text-xs text-gray-400 mt-1">Wajib diisi untuk petugas</p>
                </div>
            </div>

            {{-- Tombol --}}
            <div class="flex gap-3 pt-2">
                <a href="{{ route('admin.user.index') }}"
                   class="flex-1 text-center bg-gray-100 hover:bg-gray-200 text-gray-700 font-semibold py-3 rounded-xl transition text-sm">
                    Batal
                </a>
                <button type="submit"
                        class="flex-1 text-white font-semibold py-3 rounded-xl transition text-sm"
                        style="background:#003580;">
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </div>

    {{-- ── STATUS AKUN — form terpisah di luar form utama ── --}}
    @if($user->id !== auth()->id())
    <div class="bg-white rounded-3xl shadow-sm border border-gray-100 p-5 flex items-center gap-4">
        <div class="w-9 h-9 bg-gray-100 rounded-xl flex items-center justify-center flex-shrink-0">
            <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
            </svg>
        </div>
        <div class="flex-1">
            <p class="text-sm font-semibold text-gray-700">Status Akun</p>
            <p class="text-xs text-gray-400">Saat ini:
                <span class="font-semibold {{ $user->is_active ? 'text-green-600' : 'text-red-600' }}">
                    {{ $user->is_active ? 'Aktif' : 'Nonaktif' }}
                </span>
            </p>
        </div>
        <form method="POST" action="{{ route('admin.user.toggle', $user) }}">
            @csrf @method('PATCH')
            <button type="submit"
                    class="text-xs font-semibold px-4 py-2 rounded-xl transition
                    {{ $user->is_active ? 'bg-red-100 hover:bg-red-200 text-red-700' : 'bg-green-100 hover:bg-green-200 text-green-700' }}">
                {{ $user->is_active ? 'Nonaktifkan' : 'Aktifkan' }}
            </button>
        </form>
    </div>
    @endif

</div>
@endsection