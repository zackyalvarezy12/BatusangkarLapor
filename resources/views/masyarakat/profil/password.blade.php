@extends('layouts.app')
@section('title', 'Ganti Password')

@section('content')
<div class="min-h-screen bg-gray-50 py-10 px-4 sm:px-6 lg:px-8">
    <div class="mx-auto max-w-lg">
        <div class="mb-8 text-center">
            <h1 class="text-3xl font-bold text-slate-900">Ganti Password</h1>
            <p class="mt-2 text-sm text-slate-500">Masukkan password lama dan password baru yang aman.</p>
        </div>

        <div class="overflow-hidden rounded-3xl bg-white shadow-xl shadow-slate-200/80 border border-slate-200">
            <div class="border-b border-slate-200 bg-slate-50 px-6 py-5">
                <h2 class="text-sm font-semibold uppercase tracking-[0.18em] text-slate-600">Keamanan Akun</h2>
            </div>

            <form method="POST" action="{{ route('masyarakat.password.update') }}" class="space-y-5 px-6 py-7">
                @csrf @method('PUT')

                <div>
                    <label class="mb-2 block text-sm font-semibold text-slate-700">Password Saat Ini <span class="text-rose-500">*</span></label>
                    <input type="password" name="current_password" required
                           class="w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-900 outline-none transition focus:border-blue-500 focus:ring-2 focus:ring-blue-200"
                           placeholder="Masukkan password saat ini">
                    @error('current_password')
                    <p class="mt-2 text-xs text-rose-500">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="mb-2 block text-sm font-semibold text-slate-700">Password Baru <span class="text-rose-500">*</span></label>
                    <input type="password" name="password" required
                           class="w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-900 outline-none transition focus:border-blue-500 focus:ring-2 focus:ring-blue-200"
                           placeholder="Minimal 8 karakter">
                    @error('password')
                    <p class="mt-2 text-xs text-rose-500">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="mb-2 block text-sm font-semibold text-slate-700">Konfirmasi Password Baru <span class="text-rose-500">*</span></label>
                    <input type="password" name="password_confirmation" required
                           class="w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-900 outline-none transition focus:border-blue-500 focus:ring-2 focus:ring-blue-200"
                           placeholder="Ulangi password baru">
                </div>

                <button type="submit" class="w-full rounded-2xl bg-blue-600 px-4 py-3 text-sm font-bold text-white transition hover:bg-blue-700">
                    Simpan Password Baru
                </button>
            </form>
        </div>
    </div>
</div>
@endsection
