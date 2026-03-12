@extends('layouts.app')
@section('title', 'Detail Laporan')

@section('content')

{{-- Navbar --}}
<nav class="bg-white/95 backdrop-blur-md shadow-sm border-b border-gray-100 sticky top-[28px] z-40">
    <div class="max-w-4xl mx-auto px-4 py-3 flex items-center gap-3">
        <a href="{{ route('masyarakat.dashboard') }}"
           class="w-9 h-9 bg-gray-100 hover:bg-gray-200 rounded-xl flex items-center justify-center transition">
            <svg class="w-4 h-4 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
            </svg>
        </a>
        <div class="flex items-center gap-2.5 flex-1 min-w-0">
            <div class="w-9 h-9 bg-primary rounded-xl flex items-center justify-center flex-shrink-0">
                <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                </svg>
            </div>
            <div class="min-w-0">
                <p class="font-bold text-gray-800 text-sm truncate">{{ $pengaduan->judul }}</p>
                <p class="text-gray-400 text-xs font-mono">{{ $pengaduan->kode_laporan }}</p>
            </div>
        </div>
        <a href="{{ route('masyarakat.pengaduan.chat', $pengaduan->slug) }}"
           class="inline-flex items-center gap-2 bg-primary hover:bg-blue-900 text-white text-xs font-semibold px-4 py-2 rounded-xl transition flex-shrink-0">
            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
            </svg>
            Chat
        </a>
    </div>
</nav>

<div class="max-w-4xl mx-auto px-4 py-8 space-y-5">

    @if(session('success'))
    <div class="bg-green-50 border border-green-200 text-green-700 px-5 py-4 rounded-2xl text-sm font-medium flex items-start gap-3">
        <svg class="w-5 h-5 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
        </svg>
        <div>
            <p class="font-bold mb-0.5">Laporan berhasil dikirim!</p>
            <p>{{ session('success') }}</p>
        </div>
    </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-5">

        {{-- Konten Utama --}}
        <div class="lg:col-span-2 space-y-5">

            {{-- Header Laporan --}}
            <div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="bg-primary p-6">
                    <div class="flex items-start justify-between gap-4 flex-wrap">
                        <div class="flex-1">
                            @php $b = $pengaduan->status_badge; @endphp
                            <span class="inline-flex items-center gap-1.5 text-xs font-semibold px-3 py-1 rounded-full mb-3
                                {{ $b['color']==='yellow' ? 'bg-yellow-100 text-yellow-800' : '' }}
                                {{ $b['color']==='blue'   ? 'bg-blue-100 text-blue-800'     : '' }}
                                {{ $b['color']==='green'  ? 'bg-green-100 text-green-800'   : '' }}
                                {{ $b['color']==='red'    ? 'bg-red-100 text-red-800'       : '' }}">
                                <span class="w-1.5 h-1.5 rounded-full
                                    {{ $b['color']==='yellow' ? 'bg-yellow-500' : '' }}
                                    {{ $b['color']==='blue'   ? 'bg-blue-500'   : '' }}
                                    {{ $b['color']==='green'  ? 'bg-green-500'  : '' }}
                                    {{ $b['color']==='red'    ? 'bg-red-500'    : '' }}">
                                </span>
                                {{ $b['label'] }}
                            </span>
                            <h1 class="text-xl font-black text-white mb-2">{{ $pengaduan->judul }}</h1>
                            <div class="flex items-center gap-3 flex-wrap">
                                <span class="bg-white/20 text-white text-xs px-2.5 py-1 rounded-full font-medium">
                                    {{ $pengaduan->kategori->nama ?? '-' }}
                                </span>
                                <span class="bg-white/20 text-white text-xs px-2.5 py-1 rounded-full font-medium flex items-center gap-1">
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                              d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                    </svg>
                                    {{ $pengaduan->wilaya->nama ?? '-' }}
                                </span>
                                <span class="text-blue-200 text-xs">
                                    {{ $pengaduan->created_at->format('d M Y, H:i') }}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Kode & Token --}}
                <div class="grid grid-cols-2 divide-x divide-gray-100 border-b border-gray-100">
                    <div class="p-4 text-center">
                        <p class="text-xs text-gray-400 mb-1">Kode Laporan</p>
                        <p class="font-mono font-black text-primary text-sm tracking-wider">
                            {{ $pengaduan->kode_laporan }}
                        </p>
                    </div>
                    <div class="p-4 text-center">
                        <p class="text-xs text-gray-400 mb-1">Token Pelacak</p>
                        <p class="font-mono font-black text-gray-700 text-sm tracking-wider">
                            {{ $pengaduan->tracking_token }}
                        </p>
                    </div>
                </div>

                {{-- Deskripsi --}}
                <div class="p-6">
                    <h3 class="font-bold text-gray-800 text-sm mb-3 flex items-center gap-2">
                        <div class="w-6 h-6 bg-primary/10 rounded-lg flex items-center justify-center">
                            <svg class="w-3 h-3 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M4 6h16M4 12h16M4 18h7"/>
                            </svg>
                        </div>
                        Deskripsi Laporan
                    </h3>
                    <p class="text-gray-600 text-sm leading-relaxed whitespace-pre-line">
                        {{ $pengaduan->deskripsi }}
                    </p>
                </div>

                {{-- Alasan Tolak --}}
                @if($pengaduan->status === 'ditolak' && $pengaduan->alasan_tolak)
                <div class="mx-6 mb-6 p-4 bg-red-50 border border-red-200 rounded-2xl">
                    <p class="text-xs font-bold text-red-700 mb-1 flex items-center gap-1.5">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        Alasan Penolakan
                    </p>
                    <p class="text-red-600 text-sm">{{ $pengaduan->alasan_tolak }}</p>
                </div>
                @endif
            </div>

            {{-- Riwayat Status --}}
            <div class="bg-white rounded-3xl shadow-sm border border-gray-100 p-6">
                <h3 class="font-bold text-gray-800 text-sm mb-5 flex items-center gap-2">
                    <div class="w-7 h-7 bg-primary/10 rounded-lg flex items-center justify-center">
                        <svg class="w-3.5 h-3.5 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    Riwayat Perkembangan
                </h3>

                @php $histories = $pengaduan->histories; @endphp

                @if($histories->isEmpty())
                <p class="text-gray-400 text-sm text-center py-4">Belum ada riwayat</p>
                @else
                <div class="space-y-0">
                    @foreach($histories as $h)
                    <div class="flex gap-4">
                        <div class="flex flex-col items-center">
                            <div class="w-3 h-3 rounded-full bg-primary mt-1 flex-shrink-0 shadow-sm"></div>
                            @if(!$loop->last)
                            <div class="w-px flex-1 bg-gray-200 my-1"></div>
                            @endif
                        </div>
                        <div class="pb-5 flex-1">
                            <div class="flex items-center gap-2 flex-wrap">
                                <span class="font-bold text-gray-800 text-sm">{{ $h->status_baru }}</span>
                                @if($h->status_lama)
                                <span class="text-gray-300 text-xs">←</span>
                                <span class="text-gray-400 text-xs">{{ $h->status_lama }}</span>
                                @endif
                            </div>
                            @if($h->keterangan)
                            <p class="text-gray-500 text-xs mt-0.5">{{ $h->keterangan }}</p>
                            @endif
                            <div class="flex items-center gap-2 mt-1">
                                @if($h->user)
                                <img src="{{ $h->user->avatar_url }}" class="w-4 h-4 rounded-md object-cover">
                                <span class="text-gray-400 text-xs">{{ $h->user->name }}</span>
                                <span class="text-gray-300">·</span>
                                @endif
                                <span class="text-gray-400 text-xs">{{ $h->created_at->format('d M Y, H:i') }}</span>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
                @endif
            </div>
        </div>

        {{-- Sidebar --}}
        <div class="space-y-5">

            {{-- Info Laporan --}}
            <div class="bg-white rounded-3xl shadow-sm border border-gray-100 p-5">
                <h3 class="font-bold text-gray-800 text-sm mb-4 flex items-center gap-2">
                    <div class="w-7 h-7 bg-primary/10 rounded-lg flex items-center justify-center">
                        <svg class="w-3.5 h-3.5 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    Info Laporan
                </h3>
                <div class="space-y-3 text-sm">
                    <div class="flex justify-between items-start gap-2">
                        <span class="text-gray-400 text-xs flex-shrink-0">Kategori</span>
                        <span class="font-semibold text-gray-700 text-xs text-right">{{ $pengaduan->kategori->nama ?? '-' }}</span>
                    </div>
                    <div class="flex justify-between items-start gap-2">
                        <span class="text-gray-400 text-xs flex-shrink-0">Daerah</span>
                        <span class="font-semibold text-gray-700 text-xs text-right">{{ $pengaduan->wilaya->nama ?? '-' }}</span>
                    </div>
                    <div class="flex justify-between items-start gap-2">
                        <span class="text-gray-400 text-xs flex-shrink-0">Tanggal</span>
                        <span class="font-semibold text-gray-700 text-xs text-right">{{ $pengaduan->created_at->format('d M Y') }}</span>
                    </div>
                    <div class="flex justify-between items-start gap-2">
                        <span class="text-gray-400 text-xs flex-shrink-0">Visibilitas</span>
                        <span class="font-semibold text-xs {{ $pengaduan->is_publik ? 'text-green-600' : 'text-gray-500' }}">
                            {{ $pengaduan->is_publik ? 'Publik' : 'Privat' }}
                        </span>
                    </div>
                    <div class="flex justify-between items-start gap-2">
                        <span class="text-gray-400 text-xs flex-shrink-0">Identitas</span>
                        <span class="font-semibold text-xs {{ $pengaduan->is_anonim ? 'text-yellow-600' : 'text-gray-600' }}">
                            {{ $pengaduan->is_anonim ? 'Anonim' : 'Ditampilkan' }}
                        </span>
                    </div>
                    <div class="flex justify-between items-start gap-2">
                        <span class="text-gray-400 text-xs flex-shrink-0">Dilihat</span>
                        <span class="font-semibold text-gray-700 text-xs">{{ $pengaduan->views }}x</span>
                    </div>
                </div>
            </div>

            {{-- Petugas --}}
            <div class="bg-white rounded-3xl shadow-sm border border-gray-100 p-5">
                <h3 class="font-bold text-gray-800 text-sm mb-4 flex items-center gap-2">
                    <div class="w-7 h-7 bg-blue-50 rounded-lg flex items-center justify-center">
                        <svg class="w-3.5 h-3.5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                        </svg>
                    </div>
                    Petugas
                </h3>
                @if($pengaduan->petugas)
                <div class="flex items-center gap-3">
                    <img src="{{ $pengaduan->petugas->avatar_url }}" class="w-10 h-10 rounded-xl object-cover">
                    <div>
                        <p class="font-semibold text-gray-800 text-sm">{{ $pengaduan->petugas->name }}</p>
                        <p class="text-blue-500 text-xs">{{ $pengaduan->wilaya->nama ?? '' }}</p>
                    </div>
                </div>
                @else
                <div class="flex items-center gap-3 p-3 bg-gray-50 rounded-2xl">
                    <div class="w-9 h-9 bg-gray-200 rounded-xl flex items-center justify-center">
                        <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                        </svg>
                    </div>
                    <div>
                        <p class="text-sm font-semibold text-gray-500">Belum ditugaskan</p>
                        <p class="text-xs text-gray-400">Menunggu penugasan admin</p>
                    </div>
                </div>
                @endif
            </div>

            {{-- Simpan Kode --}}
            <div class="bg-primary/5 border border-primary/10 rounded-3xl p-5">
                <h3 class="font-bold text-primary text-sm mb-3 flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
                    </svg>
                    Simpan Kode Ini!
                </h3>
                <p class="text-primary/70 text-xs mb-3">Gunakan kode berikut untuk melacak laporan Anda di halaman utama.</p>
                <div class="bg-white rounded-xl p-3 text-center border border-primary/20 mb-3">
                    <p class="font-mono font-black text-primary text-lg tracking-widest">
                        {{ $pengaduan->kode_laporan }}
                    </p>
                </div>
                <a href="{{ route('lacak') }}?kode={{ $pengaduan->kode_laporan }}"
                   class="w-full inline-flex items-center justify-center gap-2 bg-primary hover:bg-blue-900 text-white text-xs font-semibold px-4 py-2.5 rounded-xl transition">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                    Lacak di Halaman Utama
                </a>
            </div>

            {{-- Aksi --}}
            <div class="bg-white rounded-3xl shadow-sm border border-gray-100 p-5 space-y-2">
                <a href="{{ route('masyarakat.pengaduan.chat', $pengaduan->slug) }}"
                   class="w-full inline-flex items-center justify-center gap-2 bg-primary hover:bg-blue-900 text-white text-sm font-semibold px-4 py-3 rounded-xl transition">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
                    </svg>
                    Buka Chat
                </a>
                @if(in_array($pengaduan->status, ['menunggu']))
                <form method="POST" action="{{ route('masyarakat.pengaduan.destroy', $pengaduan->slug) }}"
                      onsubmit="return confirm('Hapus laporan ini? Tindakan tidak dapat dibatalkan.')">
                    @csrf @method('DELETE')
                    <button type="submit"
                            class="w-full inline-flex items-center justify-center gap-2 bg-red-50 hover:bg-red-500 text-red-500 hover:text-white text-sm font-semibold px-4 py-3 rounded-xl transition">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                        </svg>
                        Hapus Laporan
                    </button>
                </form>
                @endif
            </div>

        </div>
    </div>
</div>
@endsection