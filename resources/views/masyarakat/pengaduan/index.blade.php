@extends('layouts.app')
@section('title', 'Semua Laporan Saya')

@section('content')

{{-- Navbar --}}
<nav class="bg-white/95 backdrop-blur-md shadow-sm border-b border-gray-100 sticky top-[28px] z-40">
    <div class="max-w-5xl mx-auto px-4 py-3 flex items-center gap-3">
        <a href="{{ route('masyarakat.dashboard') }}"
           class="w-9 h-9 bg-gray-100 hover:bg-gray-200 rounded-xl flex items-center justify-center transition">
            <svg class="w-4 h-4 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
            </svg>
        </a>
        <div class="flex items-center gap-2.5 flex-1">
            <div class="w-9 h-9 bg-primary rounded-xl flex items-center justify-center">
                <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                </svg>
            </div>
            <div>
                <p class="font-bold text-gray-800 text-sm">Semua Laporan Saya</p>
                <p class="text-gray-400 text-xs">{{ $pengaduans->total() }} laporan ditemukan</p>
            </div>
        </div>
        <a href="{{ route('masyarakat.pengaduan.create') }}"
           class="inline-flex items-center gap-2 bg-primary hover:bg-blue-900 text-white text-xs font-semibold px-4 py-2.5 rounded-xl transition">
            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
            </svg>
            Buat Laporan
        </a>
    </div>
</nav>

<div class="max-w-5xl mx-auto px-4 py-8 space-y-4">

    {{-- Filter --}}
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-4">
        <form method="GET" action="{{ route('masyarakat.pengaduan.index') }}"
              class="flex flex-wrap gap-3 items-end">
            <div class="flex-1 min-w-[180px]">
                <label class="block text-xs font-semibold text-gray-500 mb-1.5">Cari</label>
                <input type="text" name="search" value="{{ request('search') }}"
                       placeholder="Judul atau kode laporan..."
                       class="w-full border border-gray-200 rounded-xl px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary transition">
            </div>
            <div class="min-w-[140px]">
                <label class="block text-xs font-semibold text-gray-500 mb-1.5">Status</label>
                <select name="status"
                        class="w-full border border-gray-200 rounded-xl px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary transition">
                    <option value="">Semua Status</option>
                    <option value="menunggu" {{ request('status')==='menunggu' ? 'selected':'' }}>Belum Ditindak</option>
                    <option value="proses"   {{ request('status')==='proses'   ? 'selected':'' }}>Sedang Ditindak</option>
                    <option value="selesai"  {{ request('status')==='selesai'  ? 'selected':'' }}>Selesai</option>
                    <option value="ditolak"  {{ request('status')==='ditolak'  ? 'selected':'' }}>Ditolak</option>
                </select>
            </div>
            <div class="flex gap-2">
                <button type="submit"
                        class="inline-flex items-center gap-1.5 bg-primary hover:bg-blue-900 text-white font-semibold text-sm px-4 py-2.5 rounded-xl transition">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                    Filter
                </button>
                @if(request()->hasAny(['search','status']))
                <a href="{{ route('masyarakat.pengaduan.index') }}"
                   class="inline-flex items-center bg-gray-100 hover:bg-gray-200 text-gray-600 font-semibold text-sm px-4 py-2.5 rounded-xl transition">
                    Reset
                </a>
                @endif
            </div>
        </form>
    </div>

    {{-- List Laporan --}}
    <div class="space-y-3">
        @forelse($pengaduans as $p)
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 hover:border-primary/20 hover:shadow-md transition group">
            <div class="p-5">
                <div class="flex items-start gap-4">
                    {{-- Icon Kategori --}}
                    <div class="w-11 h-11 bg-primary/10 rounded-xl flex items-center justify-center flex-shrink-0 mt-0.5">
                        <svg class="w-5 h-5 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                    </div>

                    {{-- Info --}}
                    <div class="flex-1 min-w-0">
                        <div class="flex items-start justify-between gap-3 flex-wrap">
                            <div class="flex-1 min-w-0">
                                <a href="{{ route('masyarakat.pengaduan.show', $p->slug) }}"
                                   class="font-bold text-gray-800 text-sm hover:text-primary transition truncate block">
                                    {{ $p->judul }}
                                </a>
                                <div class="flex items-center gap-2 mt-1 flex-wrap">
                                    <span class="font-mono text-xs text-gray-400 bg-gray-50 px-2 py-0.5 rounded-lg">
                                        {{ $p->kode_laporan }}
                                    </span>
                                    <span class="text-gray-300">·</span>
                                    <span class="text-xs text-gray-400">{{ $p->kategori->nama ?? '-' }}</span>
                                    <span class="text-gray-300">·</span>
                                    <span class="text-xs text-gray-400">{{ $p->wilaya->nama ?? '-' }}</span>
                                </div>
                            </div>
                            @php $b = $p->status_badge; @endphp
                            <span class="inline-flex items-center gap-1.5 text-xs font-semibold px-2.5 py-1 rounded-full flex-shrink-0
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
                        </div>

                        <div class="flex items-center justify-between mt-3 flex-wrap gap-2">
                            <div class="flex items-center gap-3 text-xs text-gray-400">
                                <span class="flex items-center gap-1">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                              d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                    {{ $p->created_at->diffForHumans() }}
                                </span>
                                @if($p->petugas)
                                <span class="flex items-center gap-1">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                              d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                    </svg>
                                    {{ $p->petugas->name }}
                                </span>
                                @endif
                                <span class="flex items-center gap-1">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                              d="M15 12a3 3 0 11-6 0 3 3 0 016 0z M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                    </svg>
                                    {{ $p->views }}x dilihat
                                </span>
                            </div>
                            <div class="flex items-center gap-2">
                                <a href="{{ route('masyarakat.pengaduan.chat', $p->slug) }}"
                                   class="inline-flex items-center gap-1.5 text-xs font-semibold text-blue-600 hover:text-blue-800 transition">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                              d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
                                    </svg>
                                    Chat
                                </a>
                                <span class="text-gray-200">|</span>
                                <a href="{{ route('masyarakat.pengaduan.show', $p->slug) }}"
                                   class="inline-flex items-center gap-1.5 text-xs font-semibold text-primary hover:text-blue-900 transition">
                                    Detail
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                    </svg>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @empty
        <div class="bg-white rounded-2xl p-16 text-center shadow-sm border border-gray-100">
            <div class="flex flex-col items-center gap-4">
                <div class="w-16 h-16 bg-gray-100 rounded-2xl flex items-center justify-center">
                    <svg class="w-8 h-8 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                              d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                </div>
                <div>
                    <p class="font-semibold text-gray-700 mb-1">Belum ada laporan</p>
                    <p class="text-gray-400 text-sm">Buat laporan pertama Anda sekarang</p>
                </div>
                <a href="{{ route('masyarakat.pengaduan.create') }}"
                   class="inline-flex items-center gap-2 bg-primary hover:bg-blue-900 text-white text-sm font-semibold px-6 py-3 rounded-xl transition">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                    </svg>
                    Buat Laporan
                </a>
            </div>
        </div>
        @endforelse
    </div>

    {{-- Pagination --}}
    @if($pengaduans->hasPages())
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-4">
        {{ $pengaduans->withQueryString()->links() }}
    </div>
    @endif

</div>
@endsection