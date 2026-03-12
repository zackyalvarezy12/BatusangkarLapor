@extends('layouts.admin')
@section('title', 'Edit Profil')
@section('breadcrumb', 'Edit Profil')

@section('content')
<div class="py-6 max-w-2xl space-y-5">

<div>
    <h2 class="text-[20px] font-black text-ink">Edit Profil</h2>
    <p class="text-ink-muted text-[13px] mt-1">Perbarui informasi akun administrator Anda</p>
</div>

{{-- Avatar card --}}
<div class="card-elevated p-6">
    <div class="flex items-center gap-5">
        <div class="w-[72px] h-[72px] rounded-2xl flex items-center justify-center text-white font-black text-3xl flex-shrink-0 shadow-xl"
             style="background: linear-gradient(135deg, #0B1628, #1E3A8A);">
            {{ strtoupper(substr(auth()->user()->name ?? 'A', 0, 1)) }}
        </div>
        <div>
            <h3 class="font-black text-ink text-[18px]">{{ auth()->user()->name }}</h3>
            <div class="flex items-center gap-2 mt-1.5">
                <span class="bg-brand/[0.08] text-brand text-[11px] font-bold px-2.5 py-0.5 rounded-full border border-brand/20">
                    Administrator
                </span>
                <span class="flex items-center gap-1 text-emerald-600 text-[11px] font-semibold">
                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-400 shadow-sm shadow-emerald-400/50"></span>
                    Aktif
                </span>
            </div>
            <p class="text-ink-muted text-[12px] mt-1.5">{{ auth()->user()->email }}</p>
        </div>
    </div>
</div>

{{-- Form profil --}}
<div class="card-elevated p-6">
    <h3 class="font-bold text-[13px] text-ink mb-5 pb-4 border-b border-slate-100">Informasi Pribadi</h3>
    <form method="POST" action="{{ route('admin.profil.update') }}" class="space-y-4">
        @csrf @method('PUT')
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div>
                <label class="block text-[11px] font-bold text-slate-500 uppercase tracking-wider mb-2">
                    Nama Lengkap <span class="text-rose-400 normal-case tracking-normal">*</span>
                </label>
                <input type="text" name="name" value="{{ old('name', auth()->user()->name) }}" required
                       class="w-full border border-slate-200 rounded-xl px-4 py-2.5 text-[13px] text-ink font-medium
                              focus:outline-none focus:ring-2 focus:ring-brand/20 focus:border-brand transition
                              @error('name') border-rose-400 @enderror">
                @error('name')<p class="text-rose-500 text-[11px] mt-1.5 font-medium">{{ $message }}</p>@enderror
            </div>
            <div>
                <label class="block text-[11px] font-bold text-slate-500 uppercase tracking-wider mb-2">Email</label>
                <input type="email" value="{{ auth()->user()->email }}" disabled
                       class="w-full border border-slate-100 bg-slate-50 rounded-xl px-4 py-2.5 text-[13px] text-slate-400 cursor-not-allowed">
                <p class="text-[11px] text-slate-400 mt-1.5">Email tidak dapat diubah</p>
            </div>
            <div>
                <label class="block text-[11px] font-bold text-slate-500 uppercase tracking-wider mb-2">No. Handphone</label>
                <input type="text" name="no_hp" value="{{ old('no_hp', auth()->user()->no_hp) }}"
                       placeholder="08xx-xxxx-xxxx"
                       class="w-full border border-slate-200 rounded-xl px-4 py-2.5 text-[13px] text-ink font-medium
                              focus:outline-none focus:ring-2 focus:ring-brand/20 focus:border-brand transition">
            </div>
            <div>
                <label class="block text-[11px] font-bold text-slate-500 uppercase tracking-wider mb-2">NIK</label>
                <input type="text" name="nik" value="{{ old('nik', auth()->user()->nik) }}"
                       placeholder="16 digit NIK" maxlength="16"
                       class="w-full border border-slate-200 rounded-xl px-4 py-2.5 text-[13px] text-ink font-medium
                              focus:outline-none focus:ring-2 focus:ring-brand/20 focus:border-brand transition">
            </div>
        </div>
        <div>
            <label class="block text-[11px] font-bold text-slate-500 uppercase tracking-wider mb-2">Alamat</label>
            <textarea name="alamat" rows="3"
                      placeholder="Alamat lengkap..."
                      class="w-full border border-slate-200 rounded-xl px-4 py-2.5 text-[13px] text-ink font-medium
                             focus:outline-none focus:ring-2 focus:ring-brand/20 focus:border-brand transition resize-none">{{ old('alamat', auth()->user()->alamat) }}</textarea>
        </div>
        <div class="flex justify-between items-center pt-2">
            <a href="{{ route('admin.password.edit') }}"
               class="text-[12px] text-brand font-semibold hover:underline flex items-center gap-1">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                </svg>
                Ganti Password
            </a>
            <button type="submit"
                    class="inline-flex items-center gap-2 bg-navy text-white font-bold text-[13px] px-6 py-3 rounded-xl
                           hover:bg-navy-900 transition shadow-lg shadow-navy/25">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                </svg>
                Simpan Perubahan
            </button>
        </div>
    </form>
</div>

</div>
@endsection