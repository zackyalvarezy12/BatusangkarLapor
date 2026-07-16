@extends('layouts.app')
@section('title', 'Buat Laporan')

@section('content')
<nav class="bg-white/95 backdrop-blur-md shadow-sm border-b border-gray-100 sticky top-[28px] z-40">
    <div class="max-w-3xl mx-auto px-4 py-3 flex items-center gap-3">
        <a href="{{ route('masyarakat.dashboard') }}"
           class="w-9 h-9 bg-gray-100 hover:bg-gray-200 rounded-xl flex items-center justify-center transition">
            <svg class="w-4 h-4 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
            </svg>
        </a>
        <div class="flex items-center gap-2.5">
            <div class="w-9 h-9 bg-primary rounded-xl flex items-center justify-center">
                <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                </svg>
            </div>
            <div>
                <p class="font-bold text-gray-800 text-sm">Buat Laporan Baru</p>
                <p class="text-gray-400 text-xs">Isi formulir dengan lengkap dan jelas</p>
            </div>
        </div>
    </div>
</nav>

<div class="max-w-3xl mx-auto px-4 py-8 space-y-6">

    <div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden">

        {{-- Progress Steps --}}
        <div class="px-8 pt-8 pb-6 border-b border-gray-100">
            <div class="flex items-center gap-2">
                @foreach(['Informasi Dasar', 'Detail Laporan', 'Lampiran'] as $i => $step)
                <div class="flex items-center {{ $i < 2 ? 'flex-1' : '' }}">
                    <div class="flex items-center gap-2">
                        <div class="w-7 h-7 rounded-full flex items-center justify-center text-xs font-bold
                            bg-primary text-white">
                            {{ $i + 1 }}
                        </div>
                        <span class="text-xs font-semibold text-gray-600 hidden sm:block">{{ $step }}</span>
                    </div>
                    @if($i < 2)
                    <div class="flex-1 h-px bg-gray-200 mx-3"></div>
                    @endif
                </div>
                @endforeach
            </div>
        </div>

        <form method="POST" action="{{ route('masyarakat.pengaduan.store') }}"
              enctype="multipart/form-data" class="p-8 space-y-6">
            @csrf

            {{-- Judul --}}
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">
                    Judul Laporan <span class="text-red-400">*</span>
                </label>
                <input type="text" name="judul" value="{{ old('judul') }}" required
                       placeholder="Tuliskan judul laporan secara singkat dan jelas"
                       class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary transition @error('judul') border-red-400 @enderror">
                @error('judul')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>

            {{-- Kategori & Daerah --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                        Kategori <span class="text-red-400">*</span>
                    </label>
                    <select name="kategori_id" required
                            class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary transition @error('kategori_id') border-red-400 @enderror">
                        <option value="">Pilih Kategori</option>
                        @foreach($kategoris as $k)
                        <option value="{{ $k->id }}" {{ old('kategori_id')==$k->id ? 'selected':'' }}>
                            {{ $k->nama }}
                        </option>
                        @endforeach
                    </select>
                    @error('kategori_id')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                        Daerah / Wilayah <span class="text-red-400">*</span>
                    </label>
                    <select name="wilayah_id" required
                            class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary transition @error('wilayah_id') border-red-400 @enderror">
                        <option value="">Pilih Wilayah</option>
                        @foreach($wilayas as $w)
                        <option value="{{ $w->id }}" {{ old('wilayah_id', $userWilaya?->id) == $w->id ? 'selected' : '' }}>
                            {{ $w->nama }}
                        </option>
                        @endforeach
                    </select>
                    @error('wilayah_id')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                    <p class="text-xs text-gray-400 mt-1.5">Pilih wilayah tempat kejadian berlangsung</p>
                </div>
            </div>

            {{-- Deskripsi --}}
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">
                    Deskripsi Laporan <span class="text-red-400">*</span>
                </label>
                <textarea name="deskripsi" rows="5" required
                          placeholder="Jelaskan masalah secara detail: lokasi, waktu kejadian, dan dampak yang dirasakan..."
                          class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary transition resize-none @error('deskripsi') border-red-400 @enderror">{{ old('deskripsi') }}</textarea>
                @error('deskripsi')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>

            {{-- Lampiran Foto --}}
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">
                    Foto / Bukti Pendukung
                    <span class="text-gray-400 font-normal">(opsional, maks. 5 file)</span>
                </label>
                <div id="dropZone"
                     class="border-2 border-dashed border-gray-200 rounded-2xl p-8 text-center cursor-pointer hover:border-primary/40 hover:bg-blue-50/30 transition"
                     onclick="document.getElementById('fotoInput').click()">
                    <div class="w-12 h-12 bg-gray-100 rounded-xl flex items-center justify-center mx-auto mb-3">
                        <svg class="w-6 h-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                  d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                    </div>
                    <p class="text-sm font-semibold text-gray-600">Klik untuk upload foto</p>
                    <p class="text-xs text-gray-400 mt-1">PNG, JPG, HEIC/HEIF, WEBP, PDF — Maks. 15MB per file</p>
                    <input type="file" id="fotoInput" name="lampiran[]" multiple
                           accept="image/*,.pdf" class="hidden"
                           capture="environment"
                           onchange="previewFoto(this)">
                </div>
                <div id="fotoPreview" class="hidden mt-3 grid grid-cols-3 sm:grid-cols-5 gap-3"></div>
            </div>

            {{-- Opsi --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <label class="flex items-center gap-3 p-4 border border-gray-200 rounded-2xl cursor-pointer hover:border-primary/30 hover:bg-blue-50/20 transition">
                    <input type="radio" name="visibility" value="anonim"
                           {{ old('visibility', 'publik') === 'anonim' ? 'checked' : '' }}
                           class="w-4 h-4 text-primary rounded">
                    <div>
                        <p class="text-sm font-semibold text-gray-700">Laporan Anonim</p>
                        <p class="text-xs text-gray-400">Identitas tidak ditampilkan ke publik</p>
                    </div>
                </label>
                <label class="flex items-center gap-3 p-4 border border-gray-200 rounded-2xl cursor-pointer hover:border-primary/30 hover:bg-blue-50/20 transition">
                    <input type="radio" name="visibility" value="publik"
                           {{ old('visibility', 'publik') === 'publik' ? 'checked' : '' }}
                           class="w-4 h-4 text-primary rounded">
                    <div>
                        <p class="text-sm font-semibold text-gray-700">Laporan Publik</p>
                        <p class="text-xs text-gray-400">Bisa dilihat masyarakat lain</p>
                    </div>
                </label>
            </div>

            {{-- Info --}}
            <div class="bg-blue-50 border border-blue-100 rounded-2xl p-4 flex items-start gap-3">
                <div class="w-8 h-8 bg-blue-100 rounded-lg flex items-center justify-center flex-shrink-0 mt-0.5">
                    <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <div>
                    <p class="text-blue-800 text-xs font-semibold">Informasi Penting</p>
                    <p class="text-blue-600 text-xs mt-0.5">Laporan akan diteruskan ke petugas di daerah yang Anda pilih. Anda akan mendapat kode laporan dan token pelacak via notifikasi.</p>
                </div>
            </div>

            <div class="flex gap-3 pt-2">
                <a href="{{ route('masyarakat.dashboard') }}"
                   class="flex-1 text-center bg-gray-100 hover:bg-gray-200 text-gray-700 font-semibold py-3.5 rounded-xl transition text-sm">
                    Batal
                </a>
                <button type="submit"
                        class="flex-1 bg-blue-700 hover:bg-blue-800 text-white font-bold py-3.5 rounded-xl transition text-sm flex items-center justify-center gap-2 shadow-lg shadow-blue-700/30">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/>
                    </svg>
                    Kirim Laporan
                </button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
function previewFoto(input) {
    const preview = document.getElementById('fotoPreview');
    preview.innerHTML = '';
    const files = Array.from(input.files).slice(0, 5);
    if (!files.length) { preview.classList.add('hidden'); return; }
    preview.classList.remove('hidden');
    files.forEach(file => {
        const div = document.createElement('div');
        div.className = 'relative aspect-square rounded-xl overflow-hidden border border-gray-200 bg-gray-50';
        if (file.type.startsWith('image/')) {
            const img = document.createElement('img');
            img.src = URL.createObjectURL(file);
            img.className = 'w-full h-full object-cover';
            div.appendChild(img);
        } else {
            div.className += ' flex flex-col items-center justify-center p-2';
            div.innerHTML = `<svg class="w-6 h-6 text-gray-400 mb-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg><p class="text-xs text-gray-500 truncate w-full text-center">${file.name}</p>`;
        }
        preview.appendChild(div);
    });
}
</script>
@endpush
@endsection