@extends('layouts.petugas')
@section('title', 'Edit Profil')
@section('breadcrumb', 'Edit Profil')

@section('content')
<div class="py-6 max-w-2xl mx-auto space-y-5">

{{-- Header --}}
<div>
    <h2 class="text-xl font-black text-gray-800">Edit Profil</h2>
    <p class="text-gray-400 text-sm">Perbarui informasi akun Anda</p>
</div>

{{-- Avatar Card --}}
<div class="bg-white rounded-3xl border border-gray-100 shadow-sm p-6">
    <div class="flex items-center gap-5">
        <div class="w-20 h-20 rounded-2xl bg-gradient-to-br from-violet-500 to-violet-700 flex items-center justify-center text-white font-black text-3xl shadow-lg shadow-violet-200 flex-shrink-0">
            {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
        </div>
        <div>
            <h3 class="font-black text-gray-800 text-lg">{{ auth()->user()->name }}</h3>
            <div class="flex items-center gap-2 mt-1">
                <span class="bg-violet-100 text-violet-700 text-xs font-bold px-3 py-0.5 rounded-full">Petugas</span>
                <span class="text-gray-400 text-xs">{{ auth()->user()->wilaya->nama ?? '-' }}</span>
            </div>
            <div class="text-gray-500 text-sm mt-1">{{ auth()->user()->email }}</div>
        </div>
    </div>
</div>

{{-- Form --}}
<div class="bg-white rounded-3xl border border-gray-100 shadow-sm p-6">
    <h3 class="font-bold text-gray-700 text-sm mb-5 flex items-center gap-2">
        <div class="w-6 h-6 bg-violet-100 rounded-lg flex items-center justify-center">
            <svg class="w-3.5 h-3.5 text-violet-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
            </svg>
        </div>
        Informasi Pribadi
    </h3>

    <form method="POST" action="{{ route('petugas.profil.update') }}" class="space-y-4">
        @csrf @method('PUT')

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div>
                <label class="block text-xs font-semibold text-gray-600 mb-1.5">
                    Nama Lengkap <span class="text-red-400">*</span>
                </label>
                <input type="text" name="name" value="{{ old('name', auth()->user()->name) }}" required
                       class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-violet-400/30 focus:border-violet-400 transition @error('name') border-red-400 @enderror">
                @error('name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block text-xs font-semibold text-gray-600 mb-1.5">Email</label>
                <input type="email" value="{{ auth()->user()->email }}" disabled
                       class="w-full border border-gray-100 bg-gray-50 rounded-xl px-4 py-2.5 text-sm text-gray-400 cursor-not-allowed">
                <p class="text-xs text-gray-400 mt-1">Email tidak dapat diubah</p>
            </div>

            <div>
                <label class="block text-xs font-semibold text-gray-600 mb-1.5">No. HP</label>
                <input type="text" name="no_hp" value="{{ old('no_hp', auth()->user()->no_hp) }}"
                       placeholder="08xx-xxxx-xxxx"
                       class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-violet-400/30 focus:border-violet-400 transition">
            </div>

            <div>
                <label class="block text-xs font-semibold text-gray-600 mb-1.5">Daerah Tugas</label>
                <input type="text" value="{{ auth()->user()->wilaya->nama ?? '-' }}" disabled
                       class="w-full border border-gray-100 bg-gray-50 rounded-xl px-4 py-2.5 text-sm text-gray-400 cursor-not-allowed">
                <p class="text-xs text-gray-400 mt-1">Diatur oleh administrator</p>
            </div>
        </div>

        <div>
            <label class="block text-xs font-semibold text-gray-600 mb-1.5">Alamat</label>
            <textarea name="alamat" rows="3" placeholder="Alamat lengkap..."
                      class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-violet-400/30 focus:border-violet-400 transition resize-none">{{ old('alamat', auth()->user()->alamat) }}</textarea>
        </div>

        <div class="flex justify-end pt-2">
            <button type="submit"
                    class="btn-violet inline-flex items-center gap-2 text-white font-bold text-sm px-6 py-3 rounded-xl">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                </svg>
                Simpan Perubahan
            </button>
        </div>
    </form>
</div>

{{-- Quick Links --}}
<div class="bg-violet-50 border border-violet-200 rounded-2xl p-4 flex items-center justify-between">
    <div class="flex items-center gap-3">
        <div class="w-9 h-9 bg-violet-100 rounded-xl flex items-center justify-center">
            <svg class="w-4 h-4 text-violet-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
            </svg>
        </div>
        <div>
            <div class="text-sm font-semibold text-violet-800">Keamanan Akun</div>
            <div class="text-xs text-violet-600">Perbarui password Anda secara berkala</div>
        </div>
    </div>
    <a href="{{ route('petugas.password.edit') }}"
       class="inline-flex items-center gap-1.5 bg-violet-600 hover:bg-violet-700 text-white text-xs font-semibold px-4 py-2 rounded-xl transition">
        Ganti Password
        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
        </svg>
    </a>
</div>

</div>
@endsection
