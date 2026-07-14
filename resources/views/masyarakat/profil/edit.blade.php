@extends('layouts.app')
@section('title', 'Profil Saya')

@section('content')
<div class="min-h-screen bg-gray-50 py-10 px-4 sm:px-6 lg:px-8">
    <div class="mx-auto max-w-lg">
        <div class="mb-8 text-center">
            <h1 class="text-3xl font-bold text-slate-900">Profil Saya</h1>
            <p class="mt-2 text-sm text-slate-500">Perbarui data akun masyarakat Anda.</p>
        </div>

        <div class="overflow-hidden rounded-3xl bg-white shadow-xl shadow-slate-200/80 border border-slate-200">
            <div class="border-b border-slate-200 bg-slate-50 px-6 py-5">
                <h2 class="text-sm font-semibold uppercase tracking-[0.18em] text-slate-600">Informasi Akun</h2>
            </div>

            <form method="POST" action="{{ route('masyarakat.profil.update') }}" class="space-y-5 px-6 py-7">
                @csrf @method('PUT')

                <div>
                    <label class="mb-2 block text-sm font-semibold text-slate-700">Nama Lengkap <span class="text-rose-500">*</span></label>
                    <input type="text" name="name" value="{{ old('name', auth()->user()->name) }}" required
                           class="w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-900 outline-none transition focus:border-blue-500 focus:ring-2 focus:ring-blue-200"
                           placeholder="Nama lengkap Anda">
                    @error('name')
                    <p class="mt-2 text-xs text-rose-500">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="mb-2 block text-sm font-semibold text-slate-700">No. HP</label>
                    <input type="text" name="no_hp" value="{{ old('no_hp', auth()->user()->no_hp) }}"
                           class="w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-900 outline-none transition focus:border-blue-500 focus:ring-2 focus:ring-blue-200"
                           placeholder="Nomor HP">
                    @error('no_hp')
                    <p class="mt-2 text-xs text-rose-500">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="mb-2 block text-sm font-semibold text-slate-700">Alamat</label>
                    <textarea name="alamat" rows="3"
                              class="w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-900 outline-none transition focus:border-blue-500 focus:ring-2 focus:ring-blue-200"
                              placeholder="Alamat tempat tinggal">{{ old('alamat', auth()->user()->alamat) }}</textarea>
                    @error('alamat')
                    <p class="mt-2 text-xs text-rose-500">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex gap-3 pt-2">
                    <a href="{{ route('masyarakat.password.edit') }}"
                       class="flex-1 rounded-2xl border border-slate-200 bg-white text-center text-sm font-semibold text-slate-700 py-3 transition hover:bg-slate-50">
                        Ubah Password
                    </a>
                    <button type="submit" class="flex-1 rounded-2xl bg-blue-600 px-4 py-3 text-sm font-bold text-white transition hover:bg-blue-700">
                        Simpan Profil
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
