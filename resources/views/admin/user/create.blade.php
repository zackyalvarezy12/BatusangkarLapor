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
        <div>
            <h1 class="font-black text-gray-800 text-xl">Tambah Pengguna</h1>
            <p class="text-gray-400 text-xs">Buat akun baru untuk petugas atau masyarakat</p>
        </div>
    </div>

    <div class="bg-white rounded-3xl shadow-sm border border-gray-100 p-8">
        <form method="POST" action="{{ route('admin.user.store') }}" class="space-y-5">
            @csrf

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                        Nama Lengkap <span class="text-red-400">*</span>
                    </label>
                    <input type="text" name="name" value="{{ old('name') }}" required
                           placeholder="Masukkan nama lengkap"
                           class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary transition @error('name') border-red-400 @enderror">
                    @error('name')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                        Email <span class="text-red-400">*</span>
                    </label>
                    <input type="email" name="email" value="{{ old('email') }}" required
                           placeholder="contoh@email.com"
                           class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary transition @error('email') border-red-400 @enderror">
                    @error('email')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">No. HP</label>
                    <input type="text" name="no_hp" value="{{ old('no_hp') }}"
                           placeholder="08xxxxxxxxxx"
                           class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary transition">
                </div>
                <div class="flex items-end">
                    <div class="w-full p-3.5 bg-amber-50 border border-amber-200 rounded-xl">
                        <div class="flex items-start gap-2">
                            <svg class="w-4 h-4 text-amber-500 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"/>
                            </svg>
                            <div>
                                <p class="text-xs font-semibold text-amber-700">Password Auto-Generate</p>
                                <p class="text-xs text-amber-600 mt-0.5">Password sementara akan dikirim ke email pengguna secara otomatis.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                        Role <span class="text-red-400">*</span>
                    </label>
                    <select name="role" id="roleSelect" required
                            class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary transition">
                        <option value="">Pilih Role</option>
                        <option value="petugas"    {{ old('role')==='petugas'    ? 'selected':'' }}>Petugas</option>
                        <option value="masyarakat" {{ old('role')==='masyarakat' ? 'selected':'' }}>Masyarakat</option>
                    </select>
                    @error('role')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>
                <div id="wilayaField" class="{{ old('role')==='petugas' ? '' : 'hidden' }}">
                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                        Daerah Tugas
                        <span class="text-gray-400 font-normal">(opsional)</span>
                    </label>
                    <select name="wilaya_id"
                            class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary transition">
                        <option value="">Pilih Daerah</option>
                        @foreach($wilayas as $w)
                        <option value="{{ $w->id }}" {{ old('wilaya_id')==$w->id ? 'selected':'' }}>
                            {{ $w->nama }}
                        </option>
                        @endforeach
                    </select>
                    @error('wilaya_id')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>
            </div>

            {{-- Info Role --}}
            <div id="infoPetugas" class="hidden p-4 bg-blue-50 border border-blue-100 rounded-2xl text-xs text-blue-700">
                <strong>Petugas</strong> — Hanya dapat melihat dan menangani laporan di daerah yang ditugaskan.
            </div>
            <div id="infoMasyarakat" class="hidden p-4 bg-green-50 border border-green-100 rounded-2xl text-xs text-green-700">
                <strong>Masyarakat</strong> — Dapat membuat laporan dan memantau perkembangan laporan mereka.
            </div>

            <div class="flex gap-3 pt-2">
                <a href="{{ route('admin.user.index') }}"
                   class="flex-1 text-center bg-gray-100 hover:bg-gray-200 text-gray-700 font-semibold py-3 rounded-xl transition text-sm">
                    Batal
                </a>
                <button type="submit"
                        class="flex-1 text-white font-semibold py-3 rounded-xl transition text-sm flex items-center justify-center gap-2"
                        style="background:#003580;">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/>
                    </svg>
                    Tambah Pengguna
                </button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
const roleSelect = document.getElementById('roleSelect');
function handleRole() {
    const v = roleSelect.value;
    document.getElementById('wilayaField').classList.toggle('hidden', v !== 'petugas');
    document.getElementById('infoPetugas').classList.toggle('hidden', v !== 'petugas');
    document.getElementById('infoMasyarakat').classList.toggle('hidden', v !== 'masyarakat');
}
roleSelect.addEventListener('change', handleRole);
handleRole();
</script>
@endpush
@endsection