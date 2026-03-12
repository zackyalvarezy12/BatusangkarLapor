@extends('layouts.petugas')
@section('title', 'Dashboard')
@section('breadcrumb', 'Dashboard')

@section('content')
@php
$q        = \App\Models\Pengaduan::where('wilaya_id', auth()->user()->wilaya_id);
$total    = (clone $q)->count();
$menunggu = (clone $q)->where('status','menunggu')->count();
$proses   = (clone $q)->where('status','proses')->count();
$selesai  = (clone $q)->where('status','selesai')->count();
$ditolak  = (clone $q)->where('status','ditolak')->count();

$laporan  = \App\Models\Pengaduan::with(['kategori','wilaya','user'])
    ->where('wilaya_id', auth()->user()->wilaya_id)
    ->latest()->take(6)->get();

$persen = $total > 0 ? round(($selesai / $total) * 100) : 0;
@endphp

<div class="py-6 space-y-6">

{{-- ══════ HERO ══════ --}}
<div class="relative overflow-hidden rounded-3xl p-8"
     style="background: linear-gradient(135deg, #3b0764 0%, #5b21b6 50%, #7c3aed 100%);">

    {{-- Pattern --}}
    <div class="absolute inset-0 opacity-10">
        <svg width="100%" height="100%" xmlns="http://www.w3.org/2000/svg">
            <defs>
                <pattern id="herogrid" width="32" height="32" patternUnits="userSpaceOnUse">
                    <circle cx="1" cy="1" r="1" fill="white"/>
                </pattern>
            </defs>
            <rect width="100%" height="100%" fill="url(#herogrid)"/>
        </svg>
    </div>

    {{-- Glow blobs --}}
    <div class="absolute -top-16 -right-16 w-64 h-64 bg-violet-400 rounded-full opacity-20 blur-3xl"></div>
    <div class="absolute -bottom-12 -left-12 w-48 h-48 bg-fuchsia-500 rounded-full opacity-15 blur-3xl"></div>

    <div class="relative flex flex-col lg:flex-row items-start lg:items-center justify-between gap-6">
        <div class="flex items-center gap-5">
            {{-- Avatar initial --}}
            <div class="w-16 h-16 rounded-2xl bg-white/15 backdrop-blur border border-white/20 flex items-center justify-center shadow-xl">
                <span class="text-white font-black text-2xl">{{ strtoupper(substr(auth()->user()->name,0,1)) }}</span>
            </div>
            <div>
                <div class="flex items-center gap-2 mb-1.5">
                    <span class="bg-accent text-gray-900 text-xs font-black px-3 py-0.5 rounded-full tracking-wide uppercase">Petugas Lapangan</span>
                    <span class="flex items-center gap-1 text-green-300 text-xs font-medium">
                        <span class="w-1.5 h-1.5 bg-green-400 rounded-full pulse-dot"></span>
                        Aktif
                    </span>
                </div>
                <h1 class="text-2xl lg:text-3xl font-black text-white leading-tight">{{ auth()->user()->name }}</h1>
                <div class="flex items-center gap-3 mt-1">
                    <span class="text-violet-300 text-sm">{{ auth()->user()->email }}</span>
                    <span class="text-violet-500">·</span>
                    <span class="flex items-center gap-1.5 text-violet-200 text-sm">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                        </svg>
                        {{ auth()->user()->wilaya->nama ?? '-' }}
                    </span>
                </div>
            </div>
        </div>

        {{-- Progress ring & tanggal --}}
        <div class="flex items-center gap-6">
            {{-- Completion ring --}}
            <div class="text-center">
                <div class="relative w-20 h-20">
                    <svg class="w-20 h-20 -rotate-90" viewBox="0 0 80 80">
                        <circle cx="40" cy="40" r="32" fill="none" stroke="rgba(255,255,255,0.1)" stroke-width="8"/>
                        <circle cx="40" cy="40" r="32" fill="none" stroke="#f59e0b" stroke-width="8"
                                stroke-linecap="round"
                                stroke-dasharray="{{ round($persen * 2.01) }} 201"
                                style="transition: stroke-dasharray .8s ease"/>
                    </svg>
                    <div class="absolute inset-0 flex items-center justify-center">
                        <span class="text-white font-black text-base">{{ $persen }}%</span>
                    </div>
                </div>
                <div class="text-violet-300 text-xs mt-1 font-medium">Terselesaikan</div>
            </div>

            <div class="text-right hidden sm:block">
                <div class="text-violet-300 text-xs mb-1">Hari ini</div>
                <div class="text-white font-bold text-sm">{{ now()->translatedFormat('l') }}</div>
                <div class="text-violet-200 text-xs">{{ now()->translatedFormat('d F Y') }}</div>
                <a href="{{ route('petugas.pengaduan.index') }}"
                   class="inline-flex items-center gap-2 mt-3 bg-accent hover:bg-yellow-400 text-gray-900 font-bold text-xs px-4 py-2 rounded-xl transition shadow-lg">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h7"/>
                    </svg>
                    Semua Laporan
                </a>
            </div>
        </div>
    </div>
</div>

{{-- ══════ STAT CARDS ══════ --}}
<div class="grid grid-cols-2 lg:grid-cols-5 gap-4">
    @php
    $cards = [
        ['n'=>$total,    'label'=>'Total',    'from'=>'from-violet-500', 'to'=>'to-violet-700', 'icon'=>'M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2', 'ring'=>'ring-violet-200'],
        ['n'=>$menunggu, 'label'=>'Menunggu', 'from'=>'from-amber-400',  'to'=>'to-amber-600',  'icon'=>'M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z',                                                                                         'ring'=>'ring-amber-200'],
        ['n'=>$proses,   'label'=>'Diproses', 'from'=>'from-blue-500',   'to'=>'to-blue-700',   'icon'=>'M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15',                         'ring'=>'ring-blue-200'],
        ['n'=>$selesai,  'label'=>'Selesai',  'from'=>'from-emerald-500','to'=>'to-emerald-700','icon'=>'M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z',                                                                                         'ring'=>'ring-emerald-200'],
        ['n'=>$ditolak,  'label'=>'Ditolak',  'from'=>'from-rose-500',   'to'=>'to-rose-700',   'icon'=>'M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z',                                                               'ring'=>'ring-rose-200'],
    ];
    @endphp

    @foreach($cards as $c)
    <div class="bg-white rounded-2xl p-5 shadow-sm border border-gray-100 card-hover ring-1 {{ $c['ring'] }} ring-opacity-0 hover:ring-opacity-100 transition-all">
        <div class="w-11 h-11 rounded-xl bg-gradient-to-br {{ $c['from'] }} {{ $c['to'] }} flex items-center justify-center mb-3 shadow-md">
            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $c['icon'] }}"/>
            </svg>
        </div>
        <div class="text-3xl font-black text-gray-900">{{ $c['n'] }}</div>
        <div class="text-xs text-gray-500 font-semibold mt-0.5">{{ $c['label'] }}</div>
    </div>
    @endforeach
</div>

{{-- ══════ LAPORAN TERBARU ══════ --}}
<div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden">

    <div class="px-6 py-5 border-b border-gray-50 flex items-center justify-between">
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-violet-500 to-violet-700 flex items-center justify-center shadow-md">
                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                </svg>
            </div>
            <div>
                <h3 class="font-bold text-gray-800">Laporan Terbaru</h3>
                <p class="text-gray-400 text-xs">Di wilayah {{ auth()->user()->wilaya->nama ?? '-' }}</p>
            </div>
        </div>
        <a href="{{ route('petugas.pengaduan.index') }}"
           class="inline-flex items-center gap-1.5 text-violet-600 hover:text-violet-800 text-xs font-semibold transition">
            Lihat Semua
            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
            </svg>
        </a>
    </div>

    <div class="divide-y divide-gray-50">
        @forelse($laporan as $p)
        @php $b = $p->status_badge; @endphp
        <div class="flex items-center gap-4 px-6 py-4 hover:bg-violet-50/30 transition group">
            {{-- Status dot --}}
            <div class="w-2 h-2 rounded-full flex-shrink-0
                {{ $b['color']==='yellow' ? 'bg-amber-400' : '' }}
                {{ $b['color']==='blue'   ? 'bg-blue-500'  : '' }}
                {{ $b['color']==='green'  ? 'bg-emerald-500' : '' }}
                {{ $b['color']==='red'    ? 'bg-rose-500'  : '' }}">
            </div>

            <div class="flex-1 min-w-0">
                <div class="flex items-center gap-2">
                    <a href="{{ route('petugas.pengaduan.show', $p->slug) }}"
                       class="font-semibold text-gray-800 text-sm truncate hover:text-violet-700 transition group-hover:text-violet-700">
                        {{ $p->judul }}
                    </a>
                </div>
                <div class="flex items-center gap-2 mt-0.5 flex-wrap">
                    <span class="font-mono text-xs text-gray-400">{{ $p->kode_laporan }}</span>
                    <span class="text-gray-200">·</span>
                    <span class="text-xs text-gray-400">{{ $p->kategori->nama ?? '-' }}</span>
                    <span class="text-gray-200">·</span>
                    <span class="text-xs text-gray-400">{{ $p->created_at->diffForHumans() }}</span>
                </div>
            </div>

            <span class="inline-flex items-center gap-1.5 text-xs font-semibold px-2.5 py-1 rounded-full flex-shrink-0
                {{ $b['color']==='yellow' ? 'bg-amber-100 text-amber-800'   : '' }}
                {{ $b['color']==='blue'   ? 'bg-blue-100 text-blue-800'     : '' }}
                {{ $b['color']==='green'  ? 'bg-emerald-100 text-emerald-800' : '' }}
                {{ $b['color']==='red'    ? 'bg-rose-100 text-rose-800'     : '' }}">
                {{ $b['label'] }}
            </span>

            <a href="{{ route('petugas.pengaduan.show', $p->slug) }}"
               class="flex-shrink-0 w-8 h-8 bg-violet-100 hover:bg-violet-600 text-violet-600 hover:text-white rounded-xl flex items-center justify-center transition opacity-0 group-hover:opacity-100">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                </svg>
            </a>
        </div>
        @empty
        <div class="py-20 text-center">
            <div class="w-16 h-16 bg-violet-50 rounded-2xl flex items-center justify-center mx-auto mb-4">
                <svg class="w-8 h-8 text-violet-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                          d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                </svg>
            </div>
            <p class="text-gray-500 font-medium text-sm">Belum ada laporan masuk</p>
            <p class="text-gray-400 text-xs mt-1">Laporan di wilayah Anda akan muncul di sini</p>
        </div>
        @endforelse
    </div>
</div>

</div>
@endsection

