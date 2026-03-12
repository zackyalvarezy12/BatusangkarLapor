@extends('layouts.admin')
@section('title', 'Ganti Password')
@section('breadcrumb', 'Ganti Password')

@section('content')
<div class="py-6 max-w-lg space-y-5">

<div>
    <h2 class="text-[20px] font-black text-ink">Ganti Password</h2>
    <p class="text-ink-muted text-[13px] mt-1">Perbarui kata sandi akun Anda</p>
</div>

<div class="card-elevated overflow-hidden">
    {{-- Header stripe --}}
    <div class="px-6 py-5 border-b border-slate-100"
         style="background: linear-gradient(135deg, #040a14, #0B1628);">
        <div class="flex items-center gap-4">
            <div class="w-12 h-12 rounded-2xl bg-white/[0.08] border border-white/[0.12] flex items-center justify-center flex-shrink-0">
                <svg class="w-5 h-5 text-gold" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                </svg>
            </div>
            <div>
                <p class="text-white font-bold text-[14px]">Keamanan Akun</p>
                <p class="text-blue-300/50 text-[12px] mt-0.5">{{ auth()->user()->email }}</p>
            </div>
        </div>
    </div>

    <div class="p-6">
        <form method="POST" action="{{ route('admin.password.update') }}" class="space-y-4">
            @csrf @method('PUT')

            <div>
                <label class="block text-[11px] font-bold text-slate-500 uppercase tracking-wider mb-2">
                    Password Saat Ini <span class="text-rose-400 normal-case tracking-normal">*</span>
                </label>
                <input type="password" name="current_password" required
                       placeholder="Masukkan password saat ini"
                       class="w-full border border-slate-200 rounded-xl px-4 py-2.5 text-[13px] font-medium
                              focus:outline-none focus:ring-2 focus:ring-brand/20 focus:border-brand transition
                              @error('current_password') border-rose-400 @enderror">
                @error('current_password')<p class="text-rose-500 text-[11px] mt-1.5 font-medium">{{ $message }}</p>@enderror
            </div>

            <div class="h-px bg-slate-100"></div>

            <div>
                <label class="block text-[11px] font-bold text-slate-500 uppercase tracking-wider mb-2">
                    Password Baru <span class="text-rose-400 normal-case tracking-normal">*</span>
                </label>
                <input type="password" name="password" required
                       placeholder="Minimal 8 karakter"
                       class="w-full border border-slate-200 rounded-xl px-4 py-2.5 text-[13px] font-medium
                              focus:outline-none focus:ring-2 focus:ring-brand/20 focus:border-brand transition
                              @error('password') border-rose-400 @enderror">
                @error('password')<p class="text-rose-500 text-[11px] mt-1.5 font-medium">{{ $message }}</p>@enderror
            </div>

            <div>
                <label class="block text-[11px] font-bold text-slate-500 uppercase tracking-wider mb-2">
                    Konfirmasi Password Baru <span class="text-rose-400 normal-case tracking-normal">*</span>
                </label>
                <input type="password" name="password_confirmation" required
                       placeholder="Ketik ulang password baru"
                       class="w-full border border-slate-200 rounded-xl px-4 py-2.5 text-[13px] font-medium
                              focus:outline-none focus:ring-2 focus:ring-brand/20 focus:border-brand transition">
            </div>

            {{-- Tips --}}
            <div class="bg-blue-50/80 border border-blue-100 rounded-2xl p-4">
                <p class="text-[11px] font-bold text-blue-700 mb-2.5 uppercase tracking-wider">Tips Password Kuat</p>
                <div class="grid grid-cols-2 gap-1.5">
                    @foreach(['Minimal 8 karakter', 'Huruf besar & kecil', 'Sertakan angka', 'Gunakan simbol'] as $tip)
                    <div class="flex items-center gap-1.5 text-[11px] text-blue-600 font-medium">
                        <svg class="w-3 h-3 text-blue-400 flex-shrink-0" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                        </svg>
                        {{ $tip }}
                    </div>
                    @endforeach
                </div>
            </div>

            <div class="flex gap-3 pt-1">
                <a href="{{ route('admin.profil.edit') }}"
                   class="flex-1 text-center bg-slate-100 hover:bg-slate-200 text-slate-600 font-semibold text-[13px] py-3 rounded-xl transition">
                    Batal
                </a>
                <button type="submit"
                        class="flex-1 bg-navy hover:bg-navy-900 text-white font-bold text-[13px] py-3 rounded-xl
                               flex items-center justify-center gap-2 transition shadow-lg shadow-navy/25">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round"
                              d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                    </svg>
                    Simpan Password
                </button>
            </div>
        </form>
    </div>
</div>

</div>
@endsection