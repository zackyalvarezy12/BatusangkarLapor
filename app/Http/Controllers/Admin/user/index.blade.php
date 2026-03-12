@extends('layouts.admin')
@section('title', 'Tambah Pengguna')
@section('breadcrumb', 'Tambah Pengguna')

@section('content')
<div class="py-6 max-w-2xl mx-auto space-y-6">

    <div class="flex items-center gap-3">
        <a href="{{ route('admin.user.index') }}"
           class="w-9 h-9 bg-white border border-gray-200 rounded-xl flex items-center justify-center hover:bg-gray-50 transition shadow-sm">
            <svg class="w-4 h-4 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
            </svg>
        </a>
        <h1 class="font-black text-gray-800 text-xl">Tambah Pengguna</h1>
    </div>

    <div class="bg-white rounded-3xl shadow-sm border border-gray-100 p-8">
        <form method="POST" action="{{ route('admin.user.store') }}" class="space-y-5">
            @csrf

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Nama Lengkap</label>
                    <input type="text" name="name" value="{{ old('name') }}" required placeholder="Nama lengkap"
                           class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary transition @error('name') border-red-400 @enderror">
                    @error('name')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Email</label>
                    <input type="email" name="email" value="{{ old('email') }}" required placeholder="email@contoh.com"
                           class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary transition @error('email') border-red-400 @enderror">
                    @error('email')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Password</label>
                    <input type="password" name="password" required placeholder="Minimal 6 karakter"
                           class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary transition @error('password') border-red-400 @enderror">
                    @error('password')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">No. HP</label>
                    <input type="text" name="no_hp" value="{{ old('no_hp') }}" placeholder="08xxxxxxxxxx"
                           class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary transition">
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Role</label>
                    <select name="role" id="roleSelect" required
                            class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary transition">
                        <option value="">Pilih Role</option>
                        <option value="admin"      {{ old('role')==='admin'      ? 'selected' : '' }}>Admin</option>
                        <option value="petugas"    {{ old('role')==='petugas'    ? 'selected' : '' }}>Petugas</option>
                        <option value="masyarakat" {{ old('role')==='masyarakat' ? 'selected' : '' }}>Masyarakat</option>
                    </select>
                </div>
                <div id="wilayaField" class="{{ old('role')==='petugas' ? '' : 'hidden' }}">
                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                        Daerah Tugas
                        <span class="text-red-400">*</span>
                    </label>
                    <select name="wilaya_id"
                            class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary transition">
                        <option value="">Pilih Daerah</option>
                        @foreach($wilayas as $w)
                        <option value="{{ $w->id }}" {{ old('wilaya_id')==$w->id ? 'selected' : '' }}>
                            {{ $w->nama }}
                        </option>
                        @endforeach
                    </select>
                    @error('wilaya_id')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>
            </div>

            {{-- Info Box --}}
            <div id="infoBox" class="hidden bg-blue-50 border border-blue-100 rounded-2xl p-4">
                <div class="flex items-start gap-3">
                    <div class="w-8 h-8 bg-blue-100 rounded-lg flex items-center justify-center flex-shrink-0 mt-0.5">
                        <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <div>
                        <p class="text-blue-800 text-xs font-semibold">Petugas Daerah</p>
                        <p class="text-blue-600 text-xs mt-0.5">Petugas hanya dapat melihat dan menangani laporan di daerah yang ditentukan.</p>
                    </div>
                </div>
            </div>

            <div class="flex gap-3 pt-2">
                <a href="{{ route('admin.user.index') }}"
                   class="flex-1 text-center bg-gray-100 hover:bg-gray-200 text-gray-700 font-semibold py-3 rounded-xl transition text-sm">
                    Batal
                </a>
                <button type="submit"
                        class="flex-1 bg-primary hover:bg-blue-900 text-white font-semibold py-3 rounded-xl transition text-sm">
                    Simpan Pengguna
                </button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
document.getElementById('roleSelect').addEventListener('change', function() {
    const isPetugas = this.value === 'petugas';
    document.getElementById('wilayaField').classList.toggle('hidden', !isPetugas);
    document.getElementById('infoBox').classList.toggle('hidden', !isPetugas);
});
</script>
@endpush
@endsection