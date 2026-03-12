@extends('layouts.petugas')
@section('title', 'Ganti Password')
@section('breadcrumb', 'Ganti Password')

@section('content')
<div class="py-6 max-w-lg mx-auto space-y-5">

<div>
    <h2 class="text-xl font-black text-gray-800">Ganti Password</h2>
    <p class="text-gray-400 text-sm">Pastikan password baru Anda kuat dan mudah diingat</p>
</div>

<div class="bg-white rounded-3xl border border-gray-100 shadow-sm p-6">
    <div class="flex items-center gap-3 mb-6 pb-5 border-b border-gray-100">
        <div class="w-12 h-12 rounded-2xl bg-gradient-to-br from-violet-500 to-violet-700 flex items-center justify-center shadow-lg shadow-violet-200">
            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
            </svg>
        </div>
        <div>
            <div class="font-bold text-gray-800">Keamanan Akun</div>
            <div class="text-gray-400 text-xs">{{ auth()->user()->name }}</div>
        </div>
    </div>

    <form method="POST" action="{{ route('petugas.password.update') }}" class="space-y-4">
        @csrf @method('PUT')

        <div>
            <label class="block text-xs font-semibold text-gray-600 mb-1.5">
                Password Saat Ini <span class="text-red-400">*</span>
            </label>
            <input type="password" name="current_password" required
                   placeholder="Masukkan password saat ini"
                   class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-violet-400/30 focus:border-violet-400 transition @error('current_password') border-red-400 @enderror">
            @error('current_password') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
        </div>

        <div class="h-px bg-gray-100"></div>

        <div>
            <label class="block text-xs font-semibold text-gray-600 mb-1.5">
                Password Baru <span class="text-red-400">*</span>
            </label>
            <input type="password" name="password" required
                   placeholder="Minimal 8 karakter"
                   class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-violet-400/30 focus:border-violet-400 transition @error('password') border-red-400 @enderror">
            @error('password') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
        </div>

        <div>
            <label class="block text-xs font-semibold text-gray-600 mb-1.5">
                Konfirmasi Password Baru <span class="text-red-400">*</span>
            </label>
            <input type="password" name="password_confirmation" required
                   placeholder="Ulangi password baru"
                   class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-violet-400/30 focus:border-violet-400 transition">
        </div>

        {{-- Tips --}}
        <div class="bg-violet-50 border border-violet-100 rounded-2xl p-4 space-y-2">
            <p class="text-xs font-bold text-violet-700">Tips password kuat:</p>
            @foreach(['Minimal 8 karakter', 'Kombinasi huruf besar & kecil', 'Sertakan angka dan simbol (!@#$)', 'Jangan gunakan tanggal lahir'] as $tip)
            <div class="flex items-center gap-2 text-xs text-violet-600">
                <svg class="w-3.5 h-3.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                </svg>
                {{ $tip }}
            </div>
            @endforeach
        </div>

        <div class="flex gap-3 pt-2">
            <a href="{{ route('petugas.profil.edit') }}"
               class="flex-1 text-center bg-gray-100 hover:bg-gray-200 text-gray-600 font-semibold text-sm py-3 rounded-xl transition">
                Batal
            </a>
            <button type="submit"
                    class="flex-1 btn-violet text-white font-bold text-sm py-3 rounded-xl flex items-center justify-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                </svg>
                Simpan Password
            </button>
        </div>
    </form>
</div>

</div>
@endsection
