@extends('layouts.app')
@section('title', 'Dashboard')

@section('content')
<style>
    @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800;900&display=swap');

    .dash-root { font-family: 'Plus Jakarta Sans', sans-serif; background: #f0f4f8; min-height: 100vh; }

    /* Topbar */
    .topbar {
        background: linear-gradient(135deg, #040f2e 0%, #0b1e5c 60%, #0f2a72 100%);
        position: sticky; top: 0; z-index: 50;
        border-bottom: 1px solid rgba(255,255,255,.06);
    }

    /* Hero */
    .hero-card {
        background: linear-gradient(135deg, #040f2e 0%, #0b1e5c 55%, #1a3a8f 100%);
        border-radius: 20px;
        position: relative; overflow: hidden;
    }
    .hero-card::before {
        content: '';
        position: absolute; inset: 0;
        background:
            radial-gradient(ellipse 70% 80% at 85% -10%, rgba(245,158,11,.15) 0%, transparent 55%),
            radial-gradient(ellipse 50% 60% at 5% 110%,  rgba(99,179,237,.10) 0%, transparent 55%);
        pointer-events: none;
    }
    .hero-grid {
        position: absolute; inset: 0;
        background-image:
            linear-gradient(rgba(255,255,255,.025) 1px, transparent 1px),
            linear-gradient(90deg, rgba(255,255,255,.025) 1px, transparent 1px);
        background-size: 48px 48px;
        pointer-events: none;
    }

    /* Avatar fallback */
    .avatar-wrap { position: relative; flex-shrink: 0; }
    .avatar-img {
        width: 60px; height: 60px;
        border-radius: 16px;
        object-fit: cover;
        border: 2px solid rgba(255,255,255,.22);
        box-shadow: 0 6px 20px rgba(0,0,0,.3);
        display: block;
        background: #1e3a8a;
    }
    .avatar-online {
        position: absolute; bottom: -3px; right: -3px;
        width: 14px; height: 14px;
        background: #34d399;
        border-radius: 50%;
        border: 2px solid #040f2e;
    }

    /* Progress strip */
    .strip {
        background: rgba(255,255,255,.07);
        border: 1px solid rgba(255,255,255,.1);
        border-radius: 16px;
        padding: 16px 20px;
    }
    .progress-bar-bg { height: 6px; background: rgba(255,255,255,.12); border-radius: 99px; overflow: hidden; margin-top: 6px; }
    .progress-bar-fill { height: 6px; background: linear-gradient(90deg,#34d399,#10b981); border-radius: 99px; transition: width 1s ease; }

    /* Stat cards */
    .stat-card {
        background: white;
        border-radius: 16px;
        padding: 18px 16px;
        border: 1px solid #e8edf4;
        box-shadow: 0 1px 3px rgba(0,0,0,.04);
        transition: transform .2s, box-shadow .2s;
        position: relative; overflow: hidden;
    }
    .stat-card:hover { transform: translateY(-2px); box-shadow: 0 6px 20px rgba(0,0,0,.08); }
    .stat-card::after {
        content: ''; position: absolute;
        bottom: 0; left: 0; right: 0; height: 3px;
        border-radius: 0 0 16px 16px;
    }
    .s-total::after  { background: linear-gradient(90deg,#3b82f6,#6366f1); }
    .s-tunggu::after { background: linear-gradient(90deg,#f59e0b,#ef4444); }
    .s-proses::after { background: linear-gradient(90deg,#8b5cf6,#3b82f6); }
    .s-selesai::after{ background: linear-gradient(90deg,#10b981,#3b82f6); }

    .stat-icon {
        width: 42px; height: 42px;
        border-radius: 12px;
        display: flex; align-items: center; justify-content: center;
        margin-bottom: 14px;
    }

    /* Quick actions */
    .qa-card {
        background: white;
        border: 1px solid #e8edf4;
        border-radius: 14px;
        padding: 16px;
        display: flex; align-items: center; gap: 12px;
        text-decoration: none; color: inherit;
        transition: all .2s;
        box-shadow: 0 1px 3px rgba(0,0,0,.04);
    }
    .qa-card:hover {
        border-color: #3b82f6;
        box-shadow: 0 0 0 3px rgba(59,130,246,.1);
        transform: translateY(-1px);
    }
    .qa-icon {
        width: 42px; height: 42px;
        border-radius: 12px;
        display: flex; align-items: center; justify-content: center;
        flex-shrink: 0;
    }

    /* List card */
    .list-card {
        background: white;
        border-radius: 16px;
        border: 1px solid #e8edf4;
        box-shadow: 0 1px 3px rgba(0,0,0,.04);
        overflow: hidden;
    }
    .laporan-row {
        display: flex; align-items: center; gap: 12px;
        padding: 14px 20px;
        border-bottom: 1px solid #f3f6fa;
        text-decoration: none; color: inherit;
        transition: background .15s;
    }
    .laporan-row:last-child { border-bottom: none; }
    .laporan-row:hover { background: #f8faff; }
    .row-arrow { color: #d1d5db; transition: transform .2s, color .2s; flex-shrink: 0; }
    .laporan-row:hover .row-arrow { color: #3b82f6; transform: translateX(3px); }

    /* Badge */
    .badge {
        display: inline-flex; align-items: center; gap: 5px;
        font-size: 11px; font-weight: 700;
        padding: 3px 9px; border-radius: 99px; white-space: nowrap;
    }
    .bdot { width: 5px; height: 5px; border-radius: 50%; }
    .badge-menunggu { background:#fef3c7; color:#92400e; }
    .badge-menunggu .bdot { background:#f59e0b; }
    .badge-proses   { background:#dbeafe; color:#1e40af; }
    .badge-proses   .bdot { background:#3b82f6; animation: blink 1.4s ease-in-out infinite; }
    .badge-selesai  { background:#d1fae5; color:#065f46; }
    .badge-selesai  .bdot { background:#10b981; }
    .badge-ditolak  { background:#fee2e2; color:#991b1b; }
    .badge-ditolak  .bdot { background:#ef4444; }

    @keyframes blink { 0%,100%{opacity:1;transform:scale(1)} 50%{opacity:.4;transform:scale(1.5)} }

    /* Fade-up */
    @keyframes fadeUp {
        from { opacity:0; transform:translateY(16px); }
        to   { opacity:1; transform:translateY(0); }
    }
    .fu  { animation: fadeUp .45s cubic-bezier(.22,.61,.36,1) both; }
    .d1  { animation-delay:.05s; }
    .d2  { animation-delay:.10s; }
    .d3  { animation-delay:.15s; }
    .d4  { animation-delay:.20s; }
    .d5  { animation-delay:.25s; }
</style>

<div class="dash-root">

{{-- ══ TOPBAR ══════════════════════════════════════════════ --}}
<nav class="topbar">
    <div class="max-w-5xl mx-auto px-4 py-3 flex items-center justify-between gap-3">

        {{-- Logo --}}
        <div class="flex items-center gap-2.5 min-w-0">
            <div class="w-8 h-8 rounded-xl flex items-center justify-center flex-shrink-0"
                 style="background:rgba(255,255,255,.1);border:1px solid rgba(255,255,255,.15);">
                <svg class="w-4.5 h-4.5 text-white" style="width:18px;height:18px" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-2 10v-5a1 1 0 00-1-1h-2a1 1 0 00-1 1v5m4 0H9"/>
                </svg>
            </div>
            <div class="min-w-0">
                <div class="text-white font-black text-sm leading-tight truncate">BatusangkarLapor</div>
                <div class="text-[10px] hidden xs:block" style="color:rgba(255,255,255,.4)">Kab. Tanah Datar</div>
            </div>
        </div>

        {{-- Actions --}}
        <div class="flex items-center gap-2 flex-shrink-0">
            <a href="{{ route('masyarakat.pengaduan.create') }}"
               class="inline-flex items-center gap-1.5 text-xs font-bold px-3 py-2 rounded-xl transition"
               style="background:#f59e0b;color:#000;">
                <svg style="width:14px;height:14px;flex-shrink:0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/>
                </svg>
                <span class="hidden sm:inline">Buat Laporan</span>
                <span class="sm:hidden">Laporan</span>
            </a>
            <a href="{{ route('masyarakat.profil.edit') }}"
               class="inline-flex items-center gap-1.5 text-xs font-bold px-3 py-2 rounded-xl transition"
               style="background:rgba(255,255,255,.12);color:#ffffff;border:1px solid rgba(255,255,255,.18);">
                <svg style="width:14px;height:14px;flex-shrink:0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5.121 17.804A9 9 0 1118.88 6.196 9 9 0 015.121 17.804z"/>
                </svg>
                <span class="hidden sm:inline">Profil</span>
                <span class="sm:hidden">Akun</span>
            </a>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit"
                        class="flex items-center gap-1 text-xs font-semibold px-2.5 py-2 rounded-xl transition"
                        style="color:rgba(255,255,255,.5);background:rgba(255,255,255,.07);">
                    <svg style="width:14px;height:14px" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                    </svg>
                    <span class="hidden sm:inline">Keluar</span>
                </button>
            </form>
        </div>
    </div>
</nav>

{{-- ══ CONTENT ══════════════════════════════════════════════ --}}
<div class="max-w-5xl mx-auto px-4 py-6 space-y-5">

    {{-- ── HERO ──────────────────────────────────────────── --}}
    @php
        $total   = auth()->user()->pengaduans()->count();
        $selesai = auth()->user()->pengaduans()->where('status','selesai')->count();
        $pct     = $total > 0 ? round($selesai / $total * 100) : 0;
    @endphp

    <div class="hero-card fu d1">
        <div class="hero-grid"></div>
        <div class="relative p-5 sm:p-7">

            {{-- Profil baris --}}
            <div class="flex items-center gap-4 mb-5">
                <div class="avatar-wrap">
                    <img src="{{ auth()->user()->avatar_url }}"
                         class="avatar-img"
                         alt="{{ auth()->user()->name }}"
                         onerror="this.style.display='none';this.nextElementSibling.style.display='flex'">
                    {{-- Fallback initial --}}
                    <div style="display:none;width:60px;height:60px;border-radius:16px;background:#1e3a8a;border:2px solid rgba(255,255,255,.22);align-items:center;justify-content:center;font-size:22px;font-weight:900;color:white;flex-shrink:0;">
                        {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                    </div>
                    <div class="avatar-online"></div>
                </div>

                <div class="flex-1 min-w-0">
                    <span class="inline-block text-[10px] font-black px-2.5 py-0.5 rounded-full mb-1.5 uppercase tracking-wider"
                          style="background:rgba(245,158,11,.2);color:#fbbf24;border:1px solid rgba(245,158,11,.3);">
                        Masyarakat
                    </span>
                    <h1 class="text-xl font-black text-white leading-tight truncate">
                        Halo, {{ auth()->user()->name }}
                    </h1>
                    <p class="text-xs mt-0.5 truncate" style="color:rgba(255,255,255,.5)">
                        {{ auth()->user()->email }}
                    </p>
                </div>

                {{-- Wilaya (desktop) --}}
                @if(auth()->user()->wilaya)
                <div class="hidden sm:flex items-center gap-1.5 px-3 py-1.5 rounded-xl text-xs font-semibold flex-shrink-0"
                     style="background:rgba(255,255,255,.08);color:rgba(255,255,255,.65);border:1px solid rgba(255,255,255,.1);">
                    <svg style="width:13px;height:13px;color:#fbbf24;flex-shrink:0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                    </svg>
                    {{ auth()->user()->wilaya->nama }}
                </div>
                @endif
            </div>

            {{-- Stats strip --}}
            <div class="strip">
                <div class="flex items-start justify-between gap-4">
                    {{-- Total --}}
                    <div>
                        <div class="text-xs font-semibold" style="color:rgba(255,255,255,.45)">Total Laporan</div>
                        <div class="text-3xl font-black text-white leading-none mt-1">{{ $total }}</div>
                    </div>

                    {{-- Progress (tengah) --}}
                    <div class="flex-1 min-w-0 pt-0.5">
                        <div class="flex justify-between text-xs font-semibold mb-1" style="color:rgba(255,255,255,.5)">
                            <span>Penyelesaian</span>
                            <span class="text-white font-black">{{ $pct }}%</span>
                        </div>
                        <div class="progress-bar-bg">
                            <div class="progress-bar-fill" style="width:{{ $pct }}%"></div>
                        </div>
                        @if(auth()->user()->wilaya)
                        <div class="flex items-center gap-1 mt-2 sm:hidden">
                            <svg style="width:11px;height:11px;color:#fbbf24;flex-shrink:0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                            </svg>
                            <span class="text-[11px]" style="color:rgba(255,255,255,.5)">{{ auth()->user()->wilaya->nama }}</span>
                        </div>
                        @endif
                    </div>

                    {{-- Selesai --}}
                    <div class="text-right">
                        <div class="text-xs font-semibold" style="color:rgba(255,255,255,.45)">Selesai</div>
                        <div class="text-3xl font-black leading-none mt-1" style="color:#34d399">{{ $selesai }}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- ── STAT CARDS ────────────────────────────────────── --}}
    @php
    $stats = [
        ['label'=>'Total',    'val'=>$total,                                                                         'cls'=>'s-total',   'bg'=>'#eff6ff','ic'=>'#3b82f6','path'=>'M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z'],
        ['label'=>'Menunggu', 'val'=>auth()->user()->pengaduans()->where('status','menunggu')->count(),               'cls'=>'s-tunggu',  'bg'=>'#fffbeb','ic'=>'#f59e0b','path'=>'M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z'],
        ['label'=>'Diproses', 'val'=>auth()->user()->pengaduans()->where('status','proses')->count(),                 'cls'=>'s-proses',  'bg'=>'#f5f3ff','ic'=>'#8b5cf6','path'=>'M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15'],
        ['label'=>'Selesai',  'val'=>$selesai,                                                                        'cls'=>'s-selesai', 'bg'=>'#ecfdf5','ic'=>'#10b981','path'=>'M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z'],
    ];
    @endphp

    <div class="grid grid-cols-2 sm:grid-cols-4 gap-3 fu d2">
        @foreach($stats as $s)
        <div class="stat-card {{ $s['cls'] }}">
            <div class="stat-icon" style="background:{{ $s['bg'] }}">
                <svg style="width:20px;height:20px" fill="none" stroke="{{ $s['ic'] }}" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $s['path'] }}"/>
                </svg>
            </div>
            <div class="text-3xl font-black text-gray-800 leading-none">{{ $s['val'] }}</div>
            <div class="text-xs font-semibold text-gray-400 mt-1.5">{{ $s['label'] }}</div>
        </div>
        @endforeach
    </div>

    {{-- ── QUICK ACTIONS ─────────────────────────────────── --}}
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-3 fu d3">
        <a href="{{ route('masyarakat.pengaduan.create') }}" class="qa-card">
            <div class="qa-icon" style="background:linear-gradient(135deg,#3b82f6,#6366f1)">
                <svg style="width:20px;height:20px" fill="none" stroke="white" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/>
                </svg>
            </div>
            <div>
                <div class="text-sm font-bold text-gray-800">Buat Laporan Baru</div>
                <div class="text-xs text-gray-400 mt-0.5">Sampaikan pengaduan Anda</div>
            </div>
        </a>

        <a href="{{ route('masyarakat.pengaduan.index') }}" class="qa-card">
            <div class="qa-icon" style="background:linear-gradient(135deg,#8b5cf6,#ec4899)">
                <svg style="width:20px;height:20px" fill="none" stroke="white" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16"/>
                </svg>
            </div>
            <div>
                <div class="text-sm font-bold text-gray-800">Semua Laporan</div>
                <div class="text-xs text-gray-400 mt-0.5">Lihat riwayat pengaduan</div>
            </div>
        </a>

        <a href="{{ route('lacak') }}" class="qa-card">
            <div class="qa-icon" style="background:linear-gradient(135deg,#f59e0b,#ef4444)">
                <svg style="width:20px;height:20px" fill="none" stroke="white" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                </svg>
            </div>
            <div>
                <div class="text-sm font-bold text-gray-800">Lacak Laporan</div>
                <div class="text-xs text-gray-400 mt-0.5">Cek status dengan token</div>
            </div>
        </a>

        <a href="{{ route('kritik.create') }}" class="qa-card">
            <div class="qa-icon" style="background:linear-gradient(135deg,#8b5cf6,#6d28d9)">
                <svg style="width:20px;height:20px" fill="none" stroke="white" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"/>
                </svg>
            </div>
            <div>
                <div class="text-sm font-bold text-gray-800">Kritik & Saran</div>
                <div class="text-xs text-gray-400 mt-0.5">Kirim masukan Anda</div>
            </div>
        </a>
    </div>

    {{-- ── LAPORAN TERBARU ──────────────────────────────── --}}
    @php
    $pengaduans = auth()->user()->pengaduans()->with('kategori','wilaya')->latest()->take(5)->get();
    @endphp

    <div class="list-card fu d4">
        {{-- Header --}}
        <div class="px-5 py-4 flex items-center justify-between border-b border-gray-50">
            <div class="flex items-center gap-3">
                <div class="w-8 h-8 rounded-xl flex items-center justify-center"
                     style="background:linear-gradient(135deg,#040f2e,#0b1e5c);">
                    <svg style="width:15px;height:15px" fill="none" stroke="white" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                    </svg>
                </div>
                <div>
                    <div class="font-bold text-gray-800 text-sm">Laporan Terbaru</div>
                    <div class="text-xs text-gray-400">5 laporan terakhir</div>
                </div>
            </div>
            <a href="{{ route('masyarakat.pengaduan.index') }}"
               class="inline-flex items-center gap-1 text-xs font-bold px-3 py-1.5 rounded-lg"
               style="background:#eff6ff;color:#3b82f6;">
                Semua
                <svg style="width:13px;height:13px" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"/>
                </svg>
            </a>
        </div>

        {{-- Rows --}}
        @forelse($pengaduans as $p)
        @php
            $bc = match($p->status) {
                'proses'   => 'badge-proses',
                'selesai'  => 'badge-selesai',
                'ditolak'  => 'badge-ditolak',
                default    => 'badge-menunggu',
            };
            $bl = match($p->status) {
                'proses'   => 'Diproses',
                'selesai'  => 'Selesai',
                'ditolak'  => 'Ditolak',
                default    => 'Menunggu',
            };
        @endphp
        <a href="{{ route('masyarakat.pengaduan.show', $p->slug) }}" class="laporan-row">
            <div class="w-9 h-9 rounded-xl flex items-center justify-center flex-shrink-0" style="background:#f0f4ff;">
                <svg style="width:17px;height:17px;color:#3b82f6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                </svg>
            </div>

            <div class="flex-1 min-w-0">
                <div class="font-semibold text-gray-800 text-sm truncate">{{ $p->judul }}</div>
                <div class="flex items-center gap-1.5 mt-0.5 flex-wrap">
                    <span class="font-mono text-[11px] text-gray-400">{{ $p->kode_laporan }}</span>
                    @if($p->kategori)
                    <span class="text-gray-300 text-xs">·</span>
                    <span class="text-[11px] text-gray-400 truncate">{{ $p->kategori->nama }}</span>
                    @endif
                </div>
            </div>

            <div class="flex flex-col items-end gap-1.5 flex-shrink-0">
                <span class="badge {{ $bc }}">
                    <span class="bdot"></span>{{ $bl }}
                </span>
                <span class="text-[11px] text-gray-400">{{ $p->created_at->diffForHumans() }}</span>
            </div>

            <svg class="row-arrow" style="width:16px;height:16px" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
            </svg>
        </a>
        @empty
        <div class="py-16 flex flex-col items-center gap-4 text-center px-4">
            <div class="w-16 h-16 rounded-2xl flex items-center justify-center" style="background:#f0f4ff;">
                <svg style="width:30px;height:30px;color:#bfdbfe" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                          d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                </svg>
            </div>
            <div>
                <p class="font-bold text-gray-700 mb-1">Belum ada laporan</p>
                <p class="text-sm text-gray-400">Buat laporan pertama Anda sekarang</p>
            </div>
            <a href="{{ route('masyarakat.pengaduan.create') }}"
               class="inline-flex items-center gap-2 text-white text-sm font-bold px-5 py-2.5 rounded-xl"
               style="background:linear-gradient(135deg,#040f2e,#1a3a8f);">
                <svg style="width:14px;height:14px" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/>
                </svg>
                Buat Laporan
            </a>
        </div>
        @endforelse
    </div>

</div>
</div>

@endsection