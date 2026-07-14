@extends('layouts.app')
@section('title', 'Beranda')

@section('content')

<style>
@import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800;900&family=DM+Serif+Display:ital@0;1&display=swap');

* { font-family: 'Plus Jakarta Sans', sans-serif; }
.font-serif { font-family: 'DM Serif Display', serif; }

:root {
    --primary: #1a3a6b;
    --primary-light: #2352a0;
    --accent: #f59e0b;
    --accent-warm: #fb923c;
    --surface: #f8faff;
}

/* ─── Animated gradient bg ─── */
.hero-bg {
    background: linear-gradient(145deg, #071429 0%, #0f2654 35%, #1a3a6b 65%, #0d1f45 100%);
    position: relative;
}

/* ─── Noise ─── */
.noise-overlay::after {
    content: '';
    position: absolute;
    inset: 0;
    background-image: url("data:image/svg+xml,%3Csvg viewBox='0 0 256 256' xmlns='http://www.w3.org/2000/svg'%3E%3Cfilter id='noise'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='0.9' numOctaves='4' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='100%25' height='100%25' filter='url(%23noise)' opacity='0.04'/%3E%3C/svg%3E");
    pointer-events: none;
    opacity: 0.5;
}

/* ─── Orb floats ─── */
@keyframes float1 { 0%,100%{transform:translate(0,0) scale(1)} 50%{transform:translate(-30px,20px) scale(1.05)} }
@keyframes float2 { 0%,100%{transform:translate(0,0) scale(1)} 50%{transform:translate(20px,-25px) scale(0.95)} }
@keyframes float3 { 0%,100%{transform:translate(0,0)} 50%{transform:translate(-15px,30px)} }
.orb1 { animation: float1 14s ease-in-out infinite; }
.orb2 { animation: float2 10s ease-in-out infinite; }
.orb3 { animation: float3 17s ease-in-out infinite; }

/* ─── Particle dots ─── */
@keyframes twinkle {
    0%, 100% { opacity: 0.15; transform: scale(1); }
    50% { opacity: 0.6; transform: scale(1.3); }
}
.particle { position: absolute; border-radius: 50%; background: white; animation: twinkle var(--dur, 3s) ease-in-out infinite; animation-delay: var(--del, 0s); }

/* ─── Hero card float ─── */
@keyframes cardFloat {
    0%, 100% { transform: translateY(0px) rotate(-1deg); }
    50% { transform: translateY(-12px) rotate(-1deg); }
}
@keyframes badgeFloat1 {
    0%, 100% { transform: translateY(0px) rotate(3deg); }
    50% { transform: translateY(-8px) rotate(3deg); }
}
@keyframes badgeFloat2 {
    0%, 100% { transform: translateY(0px) rotate(-2deg); }
    50% { transform: translateY(6px) rotate(-2deg); }
}
.card-float { animation: cardFloat 6s ease-in-out infinite; }
.badge-float-1 { animation: badgeFloat1 4s ease-in-out infinite; }
.badge-float-2 { animation: badgeFloat2 5s ease-in-out infinite 0.5s; }

/* ─── Fade in up animations ─── */
@keyframes fadeInUp {
    from { opacity: 0; transform: translateY(28px); }
    to   { opacity: 1; transform: translateY(0); }
}
@keyframes fadeInRight {
    from { opacity: 0; transform: translateX(-20px); }
    to   { opacity: 1; transform: translateX(0); }
}
.fade-up-1 { animation: fadeInUp .65s cubic-bezier(.22,.61,.36,1) both; }
.fade-up-2 { animation: fadeInUp .65s .12s cubic-bezier(.22,.61,.36,1) both; }
.fade-up-3 { animation: fadeInUp .65s .24s cubic-bezier(.22,.61,.36,1) both; }
.fade-up-4 { animation: fadeInUp .65s .36s cubic-bezier(.22,.61,.36,1) both; }
.fade-up-5 { animation: fadeInUp .65s .48s cubic-bezier(.22,.61,.36,1) both; }
.fade-up-6 { animation: fadeInUp .65s .60s cubic-bezier(.22,.61,.36,1) both; }

/* ─── Gradient text ─── */
.grad-text {
    background: linear-gradient(135deg, #fcd34d 0%, #f59e0b 50%, #fb923c 100%);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
}

/* ─── Stat card ─── */
.stat-card {
    background: rgba(255,255,255,.07);
    border: 1px solid rgba(255,255,255,.12);
    backdrop-filter: blur(16px);
    transition: all .25s ease;
    position: relative;
    overflow: hidden;
}
.stat-card::before {
    content: '';
    position: absolute;
    inset: 0;
    background: linear-gradient(135deg, rgba(245,158,11,.06) 0%, transparent 60%);
    opacity: 0;
    transition: opacity .25s;
}
.stat-card:hover { background: rgba(255,255,255,.12); transform: translateY(-2px); }
.stat-card:hover::before { opacity: 1; }

/* ─── Badge pill ─── */
.badge-pill {
    background: rgba(255,255,255,.1);
    border: 1px solid rgba(255,255,255,.18);
    backdrop-filter: blur(12px);
}

/* ─── Marquee ─── */
@keyframes marquee { from{transform:translateX(0)} to{transform:translateX(-50%)} }
.marquee-track { display:flex; animation: marquee 28s linear infinite; width:max-content; }
.marquee-track:hover { animation-play-state: paused; }

/* ─── Scroll reveal ─── */
.reveal { opacity: 0; transform: translateY(24px); transition: opacity .65s ease, transform .65s ease; }
.reveal.visible { opacity: 1; transform: none; }
.reveal-2 { transition-delay: .1s; }
.reveal-3 { transition-delay: .2s; }
.reveal-4 { transition-delay: .3s; }

/* ─── Step card ─── */
.step-card {
    position: relative;
    background: white;
    border-radius: 24px;
    padding: 28px 24px;
    box-shadow: 0 2px 0 0 rgba(0,0,0,.04), 0 8px 24px rgba(26,58,107,.07);
    border: 1px solid rgba(0,0,0,.05);
    transition: all .35s cubic-bezier(.34,1.56,.64,1);
    overflow: hidden;
    cursor: default;
}
.step-card::before {
    content: '';
    position: absolute;
    top: 0; left: 0; right: 0; height: 3px;
    background: var(--step-color, #1a3a6b);
    transform: scaleX(0);
    transform-origin: left;
    transition: transform .35s ease;
}
.step-card:hover { transform: translateY(-8px); box-shadow: 0 24px 48px rgba(26,58,107,.14); }
.step-card:hover::before { transform: scaleX(1); }

/* ─── Feature card ─── */
.feat-card {
    border: 1px solid rgba(0,0,0,.06);
    border-radius: 20px;
    background: white;
    transition: all .3s cubic-bezier(.34,1.56,.64,1);
    overflow: hidden;
    position: relative;
}
.feat-card::after {
    content: '';
    position: absolute;
    inset: 0;
    background: linear-gradient(135deg, transparent 60%, rgba(245,158,11,.03) 100%);
    opacity: 0;
    transition: opacity .3s;
}
.feat-card:hover { transform: translateY(-8px) scale(1.01); border-color: rgba(26,58,107,.12); box-shadow: 0 20px 50px rgba(26,58,107,.12); }
.feat-card:hover::after { opacity: 1; }
.feat-card .feat-bar {
    width: 32px; height: 3px; border-radius: 99px; margin-top: 16px;
    transition: width .4s ease, opacity .4s ease;
    opacity: 0.4;
}
.feat-card:hover .feat-bar { width: 56px; opacity: 0.85; }

/* ─── CTA section ─── */
.cta-section {
    background: linear-gradient(140deg, #071429 0%, #0f2654 40%, #1a3a6b 80%, #071429 100%);
    position: relative;
    overflow: hidden;
}
.cta-section::before {
    content: '';
    position: absolute;
    top: -40%;
    left: -10%;
    width: 50%;
    height: 180%;
    background: radial-gradient(ellipse, rgba(245,158,11,.12) 0%, transparent 65%);
    pointer-events: none;
}
.cta-section::after {
    content: '';
    position: absolute;
    bottom: -30%;
    right: -10%;
    width: 45%;
    height: 160%;
    background: radial-gradient(ellipse, rgba(37,99,235,.1) 0%, transparent 65%);
    pointer-events: none;
}

/* ─── Step number ─── */
.step-num-label {
    font-family: 'DM Serif Display', serif;
    font-style: italic;
    font-size: 4rem;
    line-height: 1;
    opacity: .07;
    position: absolute;
    bottom: 10px;
    right: 16px;
    color: var(--step-color, #1a3a6b);
    -webkit-text-fill-color: var(--step-color, #1a3a6b);
    pointer-events: none;
}

/* ─── Wave ─── */
.wave-path {
    fill: var(--surface);
}

/* ─── Glow ring ─── */
.glow-ring {
    position: absolute;
    border-radius: 50%;
    border: 1px solid;
    pointer-events: none;
    animation: ringPulse 4s ease-in-out infinite;
}
@keyframes ringPulse {
    0%, 100% { opacity: 0.12; transform: scale(1); }
    50% { opacity: 0.05; transform: scale(1.04); }
}

/* ─── Separator ─── */
.sep-line {
    height: 1px;
    background: linear-gradient(90deg, transparent, rgba(255,255,255,.12), transparent);
}

/* ─── Progress bar in card ─── */
.prog-bar {
    height: 3px;
    background: rgba(0,0,0,.06);
    border-radius: 99px;
    overflow: hidden;
    margin-top: 8px;
}
.prog-fill {
    height: 100%;
    border-radius: 99px;
    background: linear-gradient(90deg, #1a3a6b, #2352a0);
    transition: width .8s ease;
}

/* ─── Shimmering skeleton ─── */
@keyframes shimmer {
    from { background-position: -200% 0; }
    to { background-position: 200% 0; }
}
.shimmer-line {
    background: linear-gradient(90deg, rgba(255,255,255,.04) 25%, rgba(255,255,255,.1) 50%, rgba(255,255,255,.04) 75%);
    background-size: 200% 100%;
    animation: shimmer 2.5s linear infinite;
    border-radius: 4px;
}
</style>

{{-- ═══ NAVBAR ═══ --}}
<nav class="sticky top-0 z-40 bg-white/95 backdrop-blur-xl border-b border-gray-100/80 shadow-[0_1px_12px_rgba(0,0,0,.06)]">
    <div class="max-w-7xl mx-auto px-4 lg:px-8 py-3.5 flex items-center justify-between">

        {{-- Brand --}}
        <a href="{{ route('beranda') }}" class="flex items-center gap-3 group">
            <div class="relative">
                <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-[#1a3a6b] to-[#2352a0] flex items-center justify-center shadow-md group-hover:shadow-lg transition-all group-hover:-translate-y-0.5">
                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-2 10v-5a1 1 0 00-1-1h-2a1 1 0 00-1 1v5m4 0H9"/>
                    </svg>
                </div>
                <div class="absolute -top-1 -right-1 w-3 h-3 bg-amber-400 rounded-full border-2 border-white animate-pulse"></div>
            </div>
            <div>
                <div class="font-black text-[#1a3a6b] text-sm leading-tight tracking-tight">BatusangkarLapor</div>
                <div class="text-gray-400 text-[10px] font-medium">Kabupaten Tanah Datar</div>
            </div>
        </a>

        {{-- Nav links desktop --}}
        <div class="hidden md:flex items-center gap-1">
            <a href="{{ route('lacak') }}" class="text-sm text-gray-500 hover:text-[#1a3a6b] font-semibold px-4 py-2 rounded-lg hover:bg-[#1a3a6b]/5 transition">Cek Laporan</a>
            <a href="{{ route('faq') }}" class="text-sm text-gray-500 hover:text-[#1a3a6b] font-semibold px-4 py-2 rounded-lg hover:bg-[#1a3a6b]/5 transition">FAQ</a>
            <a href="{{ route('kritik.create') }}" class="text-sm text-gray-500 hover:text-[#1a3a6b] font-semibold px-4 py-2 rounded-lg hover:bg-[#1a3a6b]/5 transition">Kritik & Saran</a>
        </div>

        {{-- Auth desktop --}}
        <div class="hidden md:flex items-center gap-2">
            @auth
                <span class="text-sm text-gray-500 font-medium">{{ auth()->user()->name }}</span>
                <a href="{{ match(auth()->user()->role) {
                    'admin'   => route('admin.dashboard'),
                    'petugas' => route('petugas.dashboard'),
                    default   => route('masyarakat.dashboard'),
                } }}"
                class="text-sm bg-gradient-to-br from-[#1a3a6b] to-[#2352a0] hover:from-[#0f2654] hover:to-[#1a3a6b] text-white font-bold px-5 py-2.5 rounded-xl shadow-sm hover:shadow-md transition-all hover:-translate-y-0.5 flex items-center gap-1.5">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                    </svg>
                    Dashboard
                </a>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="text-sm text-gray-400 hover:text-red-500 font-medium transition px-2 py-2">Keluar</button>
                </form>
            @else
                <a href="{{ route('login') }}" class="text-sm text-[#1a3a6b] font-bold hover:text-[#2352a0] px-4 py-2 rounded-lg hover:bg-[#1a3a6b]/5 transition">Masuk</a>
                <a href="{{ route('register') }}" class="text-sm bg-gradient-to-br from-[#1a3a6b] to-[#2352a0] hover:from-[#0f2654] hover:to-[#1a3a6b] text-white font-bold px-5 py-2.5 rounded-xl shadow-sm hover:shadow-[0_6px_20px_rgba(26,58,107,.35)] transition-all hover:-translate-y-0.5">
                    Daftar Sekarang
                </a>
            @endauth
        </div>

        {{-- Hamburger mobile --}}
        <button id="mob-menu-btn" class="md:hidden w-9 h-9 flex items-center justify-center rounded-xl bg-gray-100 hover:bg-gray-200 transition"
                onclick="toggleMobMenu()">
            <svg id="ham-icon" class="w-5 h-5 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
            </svg>
        </button>
    </div>

    {{-- Mobile dropdown menu --}}
    <div id="mob-menu" class="hidden md:hidden border-t border-gray-100 bg-white px-4 py-3 space-y-1 shadow-lg">
        <a href="{{ route('lacak') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-semibold text-gray-600 hover:bg-gray-50 hover:text-[#1a3a6b] transition">
            <svg class="w-4 h-4 text-[#1a3a6b]/50" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
            Cek Laporan
        </a>
        <a href="{{ route('faq') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-semibold text-gray-600 hover:bg-gray-50 hover:text-[#1a3a6b] transition">
            <svg class="w-4 h-4 text-[#1a3a6b]/50" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            FAQ
        </a>
        <a href="{{ route('kritik.create') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-semibold text-gray-600 hover:bg-gray-50 hover:text-[#1a3a6b] transition">
            <svg class="w-4 h-4 text-[#1a3a6b]/50" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"/></svg>
            Kritik & Saran
        </a>
        <div class="border-t border-gray-100 my-1 pt-2">
            @auth
                <div class="px-3 py-1.5 text-xs text-gray-400 font-semibold uppercase tracking-wide">{{ auth()->user()->name }}</div>
                <a href="{{ match(auth()->user()->role) {
                    'admin'   => route('admin.dashboard'),
                    'petugas' => route('petugas.dashboard'),
                    default   => route('masyarakat.dashboard'),
                } }}"
                class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-bold text-white transition mb-1"
                style="background:linear-gradient(135deg,#1a3a6b,#2352a0);">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                    Dashboard
                </a>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="w-full flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-semibold text-red-500 hover:bg-red-50 transition">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                        Keluar
                    </button>
                </form>
            @else
                <a href="{{ route('login') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-bold text-[#1a3a6b] hover:bg-blue-50 transition">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"/></svg>
                    Masuk
                </a>
                <a href="{{ route('register') }}"
                   class="flex items-center justify-center gap-2 px-3 py-2.5 rounded-xl text-sm font-bold text-white transition mt-1"
                   style="background:linear-gradient(135deg,#1a3a6b,#2352a0);">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/></svg>
                    Daftar Sekarang
                </a>
            @endauth
        </div>
    </div>
</nav>

{{-- ═══ HERO ═══ --}}
<section class="hero-bg noise-overlay relative overflow-hidden min-h-[94vh] flex items-center">

    {{-- Particle dots --}}
    <div class="particle" style="--dur:3.2s;--del:0s;  width:2px;height:2px;top:15%;left:20%;"></div>
    <div class="particle" style="--dur:4.1s;--del:0.8s;width:3px;height:3px;top:25%;left:60%;"></div>
    <div class="particle" style="--dur:2.9s;--del:1.5s;width:2px;height:2px;top:70%;left:35%;"></div>
    <div class="particle" style="--dur:3.7s;--del:0.4s;width:2px;height:2px;top:55%;left:80%;"></div>
    <div class="particle" style="--dur:4.5s;--del:2s;  width:3px;height:3px;top:82%;left:12%;"></div>
    <div class="particle" style="--dur:3.0s;--del:1.2s;width:2px;height:2px;top:40%;left:90%;"></div>
    <div class="particle" style="--dur:5s;  --del:0.6s;width:2px;height:2px;top:10%;left:75%;"></div>
    <div class="particle" style="--dur:3.4s;--del:2.4s;width:2px;height:2px;top:88%;left:55%;"></div>

    {{-- Orbs --}}
    <div class="orb1 absolute top-[8%] right-[4%] w-[520px] h-[520px] rounded-full" style="background:radial-gradient(circle, rgba(245,158,11,.16) 0%, transparent 70%);"></div>
    <div class="orb2 absolute bottom-[8%] left-[8%] w-[360px] h-[360px] rounded-full" style="background:radial-gradient(circle, rgba(59,130,246,.14) 0%, transparent 70%);"></div>
    <div class="orb3 absolute top-[50%] left-[50%] w-[180px] h-[180px] rounded-full" style="background:radial-gradient(circle, rgba(255,255,255,.05) 0%, transparent 70%);"></div>

    {{-- Glow rings --}}
    <div class="glow-ring" style="width:700px;height:700px;border-color:rgba(245,158,11,.08);top:50%;left:55%;transform:translate(-50%,-50%);"></div>
    <div class="glow-ring" style="width:480px;height:480px;border-color:rgba(37,99,235,.1);top:50%;left:55%;transform:translate(-50%,-50%);animation-delay:2s;"></div>

    {{-- Grid lines --}}
    <div class="absolute inset-0 opacity-[0.035]" style="background-image: linear-gradient(rgba(255,255,255,.7) 1px, transparent 1px), linear-gradient(90deg, rgba(255,255,255,.7) 1px, transparent 1px); background-size: 72px 72px;"></div>

    <div class="relative max-w-7xl mx-auto px-4 lg:px-8 py-28 w-full z-10">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-16 items-center">

            {{-- LEFT COPY --}}
            <div>
                {{-- Badge --}}
                <div class="fade-up-1 inline-flex items-center gap-2.5 badge-pill rounded-full px-4 py-2 text-white/80 text-xs font-semibold mb-8">
                    <span class="relative flex h-2 w-2">
                        <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-amber-400 opacity-75"></span>
                        <span class="relative inline-flex rounded-full h-2 w-2 bg-amber-400"></span>
                    </span>
                    Sistem Resmi Pengaduan Masyarakat
                </div>

                {{-- Headline --}}
                <h1 class="fade-up-2 font-serif text-white leading-[1.08] mb-6" style="font-size: clamp(2.8rem, 6vw, 4.8rem);">
                    Aspirasi Anda,<br>
                    <span class="grad-text italic">Prioritas</span><br>
                    Kami.
                </h1>

                <p class="fade-up-3 text-blue-200/75 text-lg leading-relaxed mb-10 max-w-md">
                    Platform pengaduan digital resmi Pemerintah Kabupaten Tanah Datar —
                    <span class="text-white/90 font-semibold">transparan, cepat, dan terukur.</span>
                </p>

                {{-- Stats --}}
                @php
                    $totalLaporan = \App\Models\Pengaduan::count();
                    $totalSelesai = \App\Models\Pengaduan::where('status','selesai')->count();
                    $totalUser    = \App\Models\User::where('role','masyarakat')->count();
                @endphp
                <div class="fade-up-4 grid grid-cols-3 gap-3 mb-10">
                    @foreach([
                        ['n' => $totalLaporan, 'label' => 'Total Laporan', 'icon' => 'M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z'],
                        ['n' => $totalSelesai, 'label' => 'Diselesaikan', 'icon' => 'M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z'],
                        ['n' => $totalUser,    'label' => 'Pengguna', 'icon' => 'M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0'],
                    ] as $s)
                    <div class="stat-card flex flex-col gap-2 rounded-2xl px-4 py-3.5">
                        <svg class="w-4 h-4 text-amber-400 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="{{ $s['icon'] }}"/>
                        </svg>
                        <div>
                            <div class="text-2xl font-black text-white leading-none">{{ number_format($s['n']) }}</div>
                            <div class="text-blue-300/60 text-[11px] font-medium mt-1">{{ $s['label'] }}</div>
                        </div>
                    </div>
                    @endforeach
                </div>

                {{-- CTAs --}}
                <div class="fade-up-5 flex flex-wrap gap-3">
                    @auth
                    <a href="{{ route('masyarakat.pengaduan.create') }}"
                       class="inline-flex items-center gap-2 font-bold px-7 py-4 rounded-2xl text-sm transition-all shadow-lg shadow-amber-500/25 hover:shadow-amber-500/40 hover:-translate-y-1"
                       style="background: linear-gradient(135deg, #fcd34d 0%, #f59e0b 50%, #fb923c 100%); color: #1a1a1a;">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/>
                        </svg>
                        Buat Laporan
                    </a>
                    @else
                    <a href="{{ route('register') }}"
                       class="inline-flex items-center gap-2 font-bold px-7 py-4 rounded-2xl text-sm transition-all shadow-lg shadow-amber-500/25 hover:shadow-amber-500/40 hover:-translate-y-1"
                       style="background: linear-gradient(135deg, #fcd34d 0%, #f59e0b 50%, #fb923c 100%); color: #1a1a1a;">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/>
                        </svg>
                        Buat Laporan
                    </a>
                    @endauth
                    <a href="{{ route('lacak') }}"
                       class="inline-flex items-center gap-2 bg-white/10 hover:bg-white/16 border border-white/20 hover:border-white/35 text-white font-semibold px-7 py-4 rounded-2xl transition-all text-sm hover:-translate-y-1">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-4.35-4.35M17 11A6 6 0 105 11a6 6 0 0012 0z"/>
                        </svg>
                        Lacak Laporan
                    </a>
                </div>
            </div>

            {{-- RIGHT: FLOATING CARD --}}
            <div class="hidden lg:flex justify-center items-center">
                <div class="relative w-full max-w-[380px]">

                    {{-- Decorative rings --}}
                    <div class="absolute -inset-8 rounded-[44px] border border-white/[0.07]"></div>
                    <div class="absolute -inset-16 rounded-[56px] border border-white/[0.04]"></div>

                    {{-- Main card --}}
                    <div class="card-float bg-white rounded-3xl relative z-10"
                         style="box-shadow: 0 40px 80px rgba(0,0,0,.4), 0 0 0 1px rgba(255,255,255,.1), inset 0 1px 0 rgba(255,255,255,.6);">

                        {{-- Card header --}}
                        <div class="flex items-center gap-3 px-5 pt-5 pb-4 border-b border-gray-100">
                            <div class="w-10 h-10 bg-gradient-to-br from-[#1a3a6b] to-[#2352a0] rounded-xl flex items-center justify-center shadow-sm">
                                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                </svg>
                            </div>
                            <div>
                                <div class="font-bold text-gray-800 text-sm">Laporan Terbaru</div>
                                <div class="text-gray-400 text-xs">Real-time update</div>
                            </div>
                            <span class="ml-auto flex items-center gap-1.5 bg-green-50 border border-green-200/60 rounded-full px-2.5 py-1 text-[10px] text-green-600 font-bold">
                                <span class="w-1.5 h-1.5 bg-green-500 rounded-full animate-pulse"></span>
                                Live
                            </span>
                        </div>

                        @php $laporans = \App\Models\Pengaduan::with('kategori')->latest()->take(3)->get(); @endphp

                        <div class="px-4 py-3 space-y-2">
                            @forelse($laporans as $li => $l)
                            @php $b = $l->status_badge; @endphp
                            <div class="flex items-center gap-3 p-3 bg-slate-50/80 hover:bg-slate-100 rounded-2xl transition-all cursor-default group"
                                 style="animation: fadeInUp .5s {{ $li * 0.12 }}s cubic-bezier(.22,.61,.36,1) both;">
                                <div class="w-9 h-9 bg-[#1a3a6b]/8 group-hover:bg-[#1a3a6b]/12 rounded-xl flex items-center justify-center flex-shrink-0 transition-colors">
                                    <svg class="w-4 h-4 text-[#1a3a6b]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                    </svg>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <div class="text-xs font-semibold text-gray-800 truncate">{{ $l->judul }}</div>
                                    <div class="text-[10px] text-gray-400 mt-0.5">{{ $l->kategori->nama ?? '-' }}</div>
                                    <div class="prog-bar">
                                        <div class="prog-fill" style="width:{{ $b['color']==='green' ? '100%' : ($b['color']==='blue' ? '60%' : '20%') }}; background: {{ $b['color']==='green' ? 'linear-gradient(90deg,#10b981,#059669)' : ($b['color']==='blue' ? 'linear-gradient(90deg,#1a3a6b,#2352a0)' : 'linear-gradient(90deg,#f59e0b,#fb923c)') }}"></div>
                                    </div>
                                </div>
                                <span class="text-[10px] px-2.5 py-1 rounded-full font-bold flex-shrink-0
                                    {{ $b['color']==='yellow' ? 'bg-amber-100 text-amber-700' : '' }}
                                    {{ $b['color']==='blue'   ? 'bg-blue-100 text-blue-700'   : '' }}
                                    {{ $b['color']==='green'  ? 'bg-green-100 text-green-700' : '' }}
                                    {{ $b['color']==='red'    ? 'bg-red-100 text-red-700'     : '' }}">
                                    {{ $b['label'] }}
                                </span>
                            </div>
                            @empty
                            <div class="text-center text-gray-400 text-xs py-6">
                                <div class="w-10 h-10 bg-gray-100 rounded-2xl flex items-center justify-center mx-auto mb-3">
                                    <svg class="w-5 h-5 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                    </svg>
                                </div>
                                Belum ada laporan
                            </div>
                            @endforelse
                        </div>

                        {{-- Card footer --}}
                        <div class="px-5 pb-5 pt-1">
                            <a href="{{ route('lacak') }}" class="w-full flex items-center justify-center gap-2 bg-[#1a3a6b]/5 hover:bg-[#1a3a6b]/10 text-[#1a3a6b] text-xs font-bold py-2.5 rounded-xl transition">
                                Lacak Laporan
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"/></svg>
                            </a>
                        </div>
                    </div>

                    {{-- Floating badge 1 --}}
                    <div class="badge-float-1 absolute -top-5 -right-6 z-20 bg-amber-400 text-gray-900 rounded-2xl px-3.5 py-2.5 shadow-xl shadow-amber-400/30">
                        <div class="flex items-center gap-1.5">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                            </svg>
                            <span class="text-[11px] font-black">Terenkripsi AES-256</span>
                        </div>
                    </div>

                    {{-- Floating badge 2 --}}
                    <div class="badge-float-2 absolute -bottom-5 -left-6 z-20 bg-white rounded-2xl px-3.5 py-2.5 shadow-2xl border border-gray-100">
                        <div class="flex items-center gap-1.5">
                            <div class="w-6 h-6 bg-green-100 rounded-lg flex items-center justify-center">
                                <svg class="w-3.5 h-3.5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                                </svg>
                            </div>
                            <span class="text-[11px] font-black text-gray-800">Status Terpantau</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Wave --}}
    <div class="absolute bottom-0 left-0 right-0 pointer-events-none">
        <svg viewBox="0 0 1440 90" fill="none" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="none">
            <path d="M0 90L1440 90L1440 45C1200 90 960 18 720 45C480 72 240 0 0 45L0 90Z" fill="#f8faff"/>
        </svg>
    </div>
</section>

{{-- ═══ MARQUEE ═══ --}}
<div class="overflow-hidden bg-[#f8faff] py-4 border-y border-gray-200/50">
    <div class="marquee-track gap-8 text-[11px] font-bold text-gray-400 uppercase tracking-widest select-none">
        @foreach(array_fill(0, 2, ['✦ Laporan Real-Time', '✦ Respon Cepat', '✦ Data Terenkripsi', '✦ Akuntabel & Transparan', '✦ Mode Anonim Tersedia', '✦ Notifikasi Otomatis', '✦ Layanan 24/7', '✦ OTP Verifikasi']) as $items)
            @foreach($items as $item)
            <span class="whitespace-nowrap px-4 hover:text-[#1a3a6b] transition-colors cursor-default">{{ $item }}</span>
            @endforeach
        @endforeach
    </div>
</div>

{{-- ═══ PENGUMUMAN ═══ --}}
@php $pengumumans = \App\Models\Pengumuman::aktif()->latest('diterbitkan_at')->take(4)->get(); @endphp
@if($pengumumans->count() > 0)
<section class="relative py-20 px-4 overflow-hidden" style="background: linear-gradient(160deg, #f0f6ff 0%, #fefefe 40%, #fffbf0 100%);">

    {{-- Decorative background blobs --}}
    <div class="absolute top-0 left-0 w-96 h-96 rounded-full opacity-[0.06] pointer-events-none"
         style="background: radial-gradient(circle, #1a3a6b, transparent); transform: translate(-30%, -30%);"></div>
    <div class="absolute bottom-0 right-0 w-80 h-80 rounded-full opacity-[0.05] pointer-events-none"
         style="background: radial-gradient(circle, #f59e0b, transparent); transform: translate(30%, 30%);"></div>

    <div class="max-w-6xl mx-auto relative z-10">

        {{-- Header --}}
        <div class="flex flex-col sm:flex-row sm:items-end justify-between gap-4 mb-12">
            <div class="reveal">
                <div class="inline-flex items-center gap-2.5 mb-4 px-4 py-2 rounded-full text-xs font-black uppercase tracking-widest"
                     style="background: linear-gradient(135deg, rgba(245,158,11,.12), rgba(251,146,60,.08)); border: 1px solid rgba(245,158,11,.2); color: #b45309;">
                    <span class="relative flex h-2 w-2">
                        <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-amber-400 opacity-75"></span>
                        <span class="relative inline-flex rounded-full h-2 w-2 bg-amber-500"></span>
                    </span>
                    Pengumuman Resmi
                </div>
                <h2 class="font-serif text-3xl lg:text-4xl text-gray-800 leading-tight">
                    Informasi <em class="grad-text">Terkini</em>
                </h2>
                <p class="text-gray-400 text-sm mt-2 max-w-sm">Pengumuman dan informasi resmi dari Pemerintah Kabupaten Tanah Datar.</p>
            </div>
            <div class="reveal reveal-2 flex-shrink-0">
                <span class="inline-flex items-center gap-2 text-xs text-[#1a3a6b] font-bold bg-[#1a3a6b]/6 px-4 py-2.5 rounded-xl">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    {{ $pengumumans->count() }} Pengumuman Aktif
                </span>
            </div>
        </div>

        {{-- Cards Grid --}}
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-5">
            @foreach($pengumumans as $i => $p)
            @php
                $palettes = [
                    ['from' => '#1a3a6b', 'to' => '#2352a0', 'badge_bg' => 'rgba(26,58,107,.08)', 'badge_text' => '#1a3a6b', 'border' => 'rgba(26,58,107,.1)', 'icon_bg' => 'linear-gradient(135deg,#1a3a6b,#2352a0)'],
                    ['from' => '#b45309', 'to' => '#d97706', 'badge_bg' => 'rgba(245,158,11,.08)', 'badge_text' => '#b45309', 'border' => 'rgba(245,158,11,.15)', 'icon_bg' => 'linear-gradient(135deg,#b45309,#d97706)'],
                    ['from' => '#065f46', 'to' => '#059669', 'badge_bg' => 'rgba(5,150,105,.08)', 'badge_text' => '#065f46', 'border' => 'rgba(5,150,105,.12)', 'icon_bg' => 'linear-gradient(135deg,#065f46,#059669)'],
                    ['from' => '#6d28d9', 'to' => '#7c3aed', 'badge_bg' => 'rgba(109,40,217,.08)', 'badge_text' => '#5b21b6', 'border' => 'rgba(109,40,217,.12)', 'icon_bg' => 'linear-gradient(135deg,#6d28d9,#7c3aed)'],
                ];
                $pal = $palettes[$i % 4];
            @endphp

            <div class="reveal reveal-{{ ($i % 3) + 2 }} group relative bg-white rounded-3xl overflow-hidden transition-all duration-300 hover:-translate-y-1.5 hover:shadow-2xl"
                 style="border: 1px solid {{ $pal['border'] }}; box-shadow: 0 2px 12px rgba(0,0,0,.05);">

                {{-- Top accent bar --}}
                <div class="h-1 w-full" style="background: linear-gradient(90deg, {{ $pal['from'] }}, {{ $pal['to'] }});"></div>

                <div class="p-6">
                    <div class="flex items-start gap-4">

                        {{-- Icon --}}
                        <div class="flex-shrink-0 w-12 h-12 rounded-2xl flex items-center justify-center shadow-md transition-transform duration-300 group-hover:scale-110"
                             style="background: {{ $pal['icon_bg'] }};">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                                      d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z"/>
                            </svg>
                        </div>

                        <div class="flex-1 min-w-0">
                            {{-- Badge + date row --}}
                            <div class="flex items-center justify-between gap-2 mb-2.5 flex-wrap">
                                <span class="inline-flex items-center gap-1.5 text-[10px] font-black uppercase tracking-widest px-2.5 py-1 rounded-lg"
                                      style="background: {{ $pal['badge_bg'] }}; color: {{ $pal['badge_text'] }};">
                                    @if($i === 0)
                                    <span class="relative flex h-1.5 w-1.5">
                                        <span class="animate-ping absolute inline-flex h-full w-full rounded-full opacity-75" style="background:{{ $pal['from'] }};"></span>
                                        <span class="relative inline-flex rounded-full h-1.5 w-1.5" style="background:{{ $pal['from'] }};"></span>
                                    </span>
                                    Terbaru
                                    @else
                                    Pengumuman
                                    @endif
                                </span>
                                <span class="text-[11px] text-gray-400 font-medium flex items-center gap-1">
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                    </svg>
                                    {{ $p->diterbitkan_at->format('d M Y') }}
                                </span>
                            </div>

                            {{-- Title --}}
                            <h3 class="font-bold text-gray-800 text-[15px] leading-snug mb-2 line-clamp-2 transition-colors group-hover:opacity-80">
                                {{ $p->judul }}
                            </h3>

                            {{-- Content --}}
                            <p class="text-gray-500 text-[13px] leading-relaxed line-clamp-2">
                                {{ $p->konten }}
                            </p>
                        </div>
                    </div>

                    {{-- Footer --}}
                    <div class="mt-4 pt-4 flex items-center justify-between"
                         style="border-top: 1px dashed {{ $pal['border'] }};">
                        <div class="flex items-center gap-1.5 text-[11px] text-gray-400">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-2 10v-5a1 1 0 00-1-1h-2a1 1 0 00-1 1v5m4 0H9"/>
                            </svg>
                            Pemkab Tanah Datar
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        {{-- Bottom line --}}
        <div class="mt-12 flex items-center gap-4 reveal">
            <div class="flex-1 h-px" style="background: linear-gradient(90deg, transparent, rgba(26,58,107,.12), transparent);"></div>
            <span class="text-[11px] text-gray-400 font-bold uppercase tracking-widest flex items-center gap-2">
                <svg class="w-3.5 h-3.5 text-amber-400" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"/>
                </svg>
                Diperbarui secara berkala
            </span>
            <div class="flex-1 h-px" style="background: linear-gradient(90deg, transparent, rgba(26,58,107,.12), transparent);"></div>
        </div>
    </div>
</section>
@endif

{{-- ═══ CARA KERJA ═══ --}}

<section class="py-28 px-4 bg-[#f8faff] overflow-hidden">
    <div class="max-w-6xl mx-auto">
        <div class="text-center mb-16 reveal">
            <span class="inline-flex items-center gap-2 bg-[#1a3a6b]/8 text-[#1a3a6b] text-xs font-black px-4 py-2 rounded-full mb-5 uppercase tracking-widest">
                <span class="w-1.5 h-1.5 bg-[#1a3a6b] rounded-full"></span>
                Alur Pengaduan
            </span>
            <h2 class="font-serif text-4xl lg:text-5xl text-gray-800 mb-4">Cara Kerja <em>BatusangkarLapor</em></h2>
            <p class="text-gray-500 max-w-md mx-auto text-base leading-relaxed">Proses mudah, transparan, dan bisa dipantau secara real-time dari mana saja.</p>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5 relative">
            {{-- Connector line desktop --}}
            <div class="hidden lg:block absolute top-11 left-[12.5%] right-[12.5%] h-0.5 rounded-full opacity-20"
                 style="background: linear-gradient(90deg, #1a3a6b, #f59e0b, #fb923c, #16a34a);"></div>

            @foreach([
                ['step' => '01', 'title' => 'Daftar & Login', 'desc' => 'Buat akun gratis dan verifikasi email via OTP 6 digit yang aman.', 'color' => '#1a3a6b', 'bg' => '#eff6ff', 'icon' => 'M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z'],
                ['step' => '02', 'title' => 'Buat Laporan', 'desc' => 'Isi formulir dengan detail masalah, lokasi, dan lampirkan bukti foto.', 'color' => '#d97706', 'bg' => '#fffbeb', 'icon' => 'M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z'],
                ['step' => '03', 'title' => 'Diproses', 'desc' => 'Petugas wilayah menerima notifikasi dan menindaklanjuti laporan Anda.', 'color' => '#ea580c', 'bg' => '#fff7ed', 'icon' => 'M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z M15 12a3 3 0 11-6 0 3 3 0 016 0z'],
                ['step' => '04', 'title' => 'Terselesaikan', 'desc' => 'Masalah ditangani & Anda mendapat notifikasi penyelesaian resmi.', 'color' => '#16a34a', 'bg' => '#f0fdf4', 'icon' => 'M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z'],
            ] as $i => $s)
            <div class="reveal reveal-{{ $i+2 }} step-card" style="--step-color: {{ $s['color'] }};">
                <div class="flex items-start gap-4 mb-4">
                    <div class="w-14 h-14 rounded-2xl flex items-center justify-center flex-shrink-0 shadow-sm"
                         style="background: {{ $s['bg'] }};">
                        <svg class="w-7 h-7" style="color: {{ $s['color'] }};" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="{{ $s['icon'] }}"/>
                        </svg>
                    </div>
                    <div>
                        <div class="text-[10px] font-black uppercase tracking-widest mb-1" style="color: {{ $s['color'] }}; opacity:.5;">Langkah {{ $s['step'] }}</div>
                        <div class="font-bold text-gray-800 text-sm leading-snug">{{ $s['title'] }}</div>
                    </div>
                </div>
                <p class="text-gray-500 text-[13px] leading-relaxed pl-0">{{ $s['desc'] }}</p>
                <span class="step-num-label">{{ $s['step'] }}</span>
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- ═══ FITUR UNGGULAN ═══ --}}
<section class="py-28 px-4 bg-white overflow-hidden">
    <div class="max-w-6xl mx-auto">
        <div class="flex flex-col lg:flex-row lg:items-end justify-between gap-6 mb-16">
            <div class="reveal">
                <span class="inline-flex items-center gap-2 bg-[#1a3a6b]/8 text-[#1a3a6b] text-xs font-black px-4 py-2 rounded-full mb-5 uppercase tracking-widest">
                    <span class="w-1.5 h-1.5 bg-[#1a3a6b] rounded-full"></span>
                    Keunggulan Platform
                </span>
                <h2 class="font-serif text-4xl lg:text-5xl text-gray-800">Kenapa <em>BatusangkarLapor?</em></h2>
            </div>
            <p class="reveal reveal-2 text-gray-500 text-sm max-w-xs leading-relaxed lg:text-right">Setiap fitur dirancang untuk memberikan pengalaman pelaporan yang mudah, aman, dan terpercaya.</p>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5">
            @foreach([
                ['title' => 'Keamanan Tinggi', 'desc' => 'Data sensitif dienkripsi AES-256. Login dilindungi OTP dua faktor untuk keamanan maksimal.', 'gradient' => 'from-blue-500 to-blue-700', 'icon' => 'M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z'],
                ['title' => 'Lacak Real-time', 'desc' => 'Pantau status laporan kapan saja menggunakan token pelacak unik yang diberikan sistem.', 'gradient' => 'from-emerald-500 to-emerald-700', 'icon' => 'M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z M15 11a3 3 0 11-6 0 3 3 0 016 0z'],
                ['title' => 'Notifikasi Otomatis', 'desc' => 'Terima notifikasi email setiap ada pembaruan status pada laporan yang Anda buat.', 'gradient' => 'from-amber-400 to-orange-500', 'icon' => 'M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9'],
                ['title' => 'Mode Anonim', 'desc' => 'Laporan dapat dikirim secara anonim untuk melindungi identitas pelapor tetap terjaga.', 'gradient' => 'from-violet-500 to-purple-700', 'icon' => 'M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21'],
                ['title' => 'Transparan & Terbuka', 'desc' => 'Laporan publik dapat dilihat semua warga untuk mendorong akuntabilitas pemerintah.', 'gradient' => 'from-rose-500 to-pink-600', 'icon' => 'M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z'],
                ['title' => 'Respon Cepat', 'desc' => 'Petugas mendapat notifikasi instan dan memiliki target penyelesaian 7–14 hari kerja.', 'gradient' => 'from-sky-500 to-indigo-600', 'icon' => 'M13 10V3L4 14h7v7l9-11h-7z'],
            ] as $i => $f)
            <div class="reveal reveal-{{ ($i % 3) + 2 }} feat-card p-6 shadow-sm hover:shadow-xl group cursor-default">
                <div class="w-12 h-12 rounded-2xl flex items-center justify-center mb-5 bg-gradient-to-br {{ $f['gradient'] }} shadow-md group-hover:scale-110 transition-transform duration-300">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="{{ $f['icon'] }}"/>
                    </svg>
                </div>
                <h3 class="font-bold text-gray-800 mb-2 text-[15px]">{{ $f['title'] }}</h3>
                <p class="text-gray-500 text-sm leading-relaxed">{{ $f['desc'] }}</p>
                <div class="feat-bar bg-gradient-to-r {{ $f['gradient'] }}"></div>
            </div>
            @endforeach
        </div>
    </div>
</section>


{{-- ═══ TESTIMONIAL / PENILAIAN ═══ --}}
@php
    $ulasanPublik = \App\Models\Penilaian::with(['user','pengaduan'])
        ->whereNotNull('komentar')
        ->where('komentar', '!=', '')
        ->whereHas('pengaduan', fn($q) => $q->where('is_publik', true))
        ->latest()
        ->take(6)
        ->get();
    $avgRating = \App\Models\Penilaian::avg('nilai');
    $totalPenilaian = \App\Models\Penilaian::count();
@endphp

@if($ulasanPublik->count() > 0)
<section class="py-24 px-4 overflow-hidden" style="background: linear-gradient(160deg, #fefefe 0%, #f8faff 50%, #fffbf0 100%);">
    <div class="max-w-6xl mx-auto">

        {{-- Header --}}
        <div class="text-center mb-14 reveal">
            <span class="inline-flex items-center gap-2 bg-amber-50 border border-amber-100 text-amber-700 text-xs font-black px-4 py-2 rounded-full mb-5 uppercase tracking-widest">
                <svg class="w-3.5 h-3.5 text-amber-500" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                </svg>
                Ulasan Warga
            </span>
            <h2 class="font-serif text-4xl lg:text-5xl text-gray-800 mb-3">
                Komentar Warga Tanah Datar
            </h2>
            <p class="text-gray-400 text-sm max-w-sm mx-auto">Penilaian nyata dari masyarakat yang telah menggunakan layanan BatusangkarLapor.</p>

            {{-- Overall rating --}}
            @if($avgRating && $totalPenilaian > 0)
            <div class="inline-flex items-center gap-3 mt-5 bg-white border border-amber-100 rounded-2xl px-5 py-3 shadow-sm">
                <div class="text-3xl font-black text-amber-500">{{ number_format($avgRating, 1) }}</div>
                <div>
                    <div class="flex gap-0.5 mb-1">
                        @for($i = 1; $i <= 5; $i++)
                        <svg class="w-4 h-4 {{ $i <= round($avgRating) ? 'text-amber-400' : 'text-gray-200' }}" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                        </svg>
                        @endfor
                    </div>
                    <div class="text-xs text-gray-400">dari {{ $totalPenilaian }} penilaian</div>
                </div>
            </div>
            @endif
        </div>

        {{-- Grid ulasan --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5">
            @foreach($ulasanPublik as $i => $ul)
            <div class="reveal reveal-{{ ($i % 3) + 2 }} bg-white rounded-3xl border border-gray-100 p-6 shadow-sm hover:shadow-lg hover:-translate-y-1 transition-all duration-300">

                {{-- Bintang --}}
                <div class="flex gap-0.5 mb-4">
                    @for($s = 1; $s <= 5; $s++)
                    <svg class="w-4 h-4 {{ $s <= $ul->nilai ? 'text-amber-400' : 'text-gray-100' }}" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                    </svg>
                    @endfor
                </div>

                {{-- Komentar --}}
                <p class="text-gray-600 text-sm leading-relaxed mb-5 italic">"{{ Str::limit($ul->komentar, 120) }}"</p>

                {{-- Tentang laporan --}}
                <div class="flex items-center gap-3 pt-4 border-t border-gray-50">
                    <div class="w-9 h-9 rounded-xl bg-gradient-to-br from-[#1a3a6b] to-[#2352a0] flex items-center justify-center flex-shrink-0">
                        <span class="text-xs font-black text-white">{{ strtoupper(substr($ul->user?->name ?? 'A', 0, 1)) }}</span>
                    </div>
                    <div class="min-w-0">
                        <div class="text-xs font-bold text-gray-700 truncate">
                            {{ $ul->pengaduan?->is_anonim ? 'Warga Anonim' : ($ul->user?->name ?? 'Warga') }}
                        </div>
                        <div class="text-[10px] text-gray-400 truncate">
                            {{ Str::limit($ul->pengaduan?->judul ?? '-', 35) }}
                        </div>
                    </div>
                    <span class="ml-auto text-[10px] text-gray-300 flex-shrink-0">{{ $ul->created_at->format('d M Y') }}</span>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>
@endif

{{-- ═══ CTA BANNER ═══ --}}
<section class="cta-section py-28 px-4 relative z-0 overflow-hidden">

    {{-- Particle dots --}}
    <div class="particle" style="--dur:3s;--del:0s;  width:2px;height:2px;top:20%;left:10%;"></div>
    <div class="particle" style="--dur:4s;--del:1s;  width:2px;height:2px;top:70%;left:85%;"></div>
    <div class="particle" style="--dur:3.5s;--del:2s;width:3px;height:3px;top:50%;left:50%;"></div>
    <div class="particle" style="--dur:2.8s;--del:0.5s;width:2px;height:2px;top:30%;left:70%;"></div>

    {{-- Grid --}}
    <div class="absolute inset-0 opacity-[0.03]" style="background-image: linear-gradient(rgba(255,255,255,.5) 1px, transparent 1px), linear-gradient(90deg, rgba(255,255,255,.5) 1px, transparent 1px); background-size: 80px 80px; pointer-events:none;"></div>

    <div class="max-w-3xl mx-auto text-center relative z-10">
        <div class="reveal inline-flex items-center gap-2.5 badge-pill rounded-full px-4 py-2 text-white/70 text-xs font-bold uppercase tracking-widest mb-7">
            <span class="relative flex h-2 w-2">
                <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-amber-400 opacity-75"></span>
                <span class="relative inline-flex rounded-full h-2 w-2 bg-amber-400"></span>
            </span>
            Bergabung Sekarang 
        </div>
        <h2 class="reveal font-serif text-4xl lg:text-5xl text-white mb-5 leading-[1.1]">
            Siap Menyampaikan<br><em class="grad-text">Aspirasi Anda?</em>
        </h2>
        <p class="reveal reveal-2 text-blue-200/70 mb-10 text-lg max-w-lg mx-auto leading-relaxed">
            Bergabunglah dengan warga Tanah Datar yang telah mempercayakan aspirasinya kepada kami.
        </p>
        <div class="reveal reveal-3 flex flex-col sm:flex-row gap-4 justify-center">
            @auth
            <a href="{{ route('masyarakat.pengaduan.create') }}"
               class="inline-flex items-center justify-center gap-2 font-bold px-8 py-4 rounded-2xl text-sm transition-all shadow-lg hover:shadow-amber-500/30 hover:-translate-y-1"
               style="background: linear-gradient(135deg, #fcd34d 0%, #f59e0b 50%, #fb923c 100%); color: #1a1a1a;">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/>
                </svg>
                Buat Laporan Sekarang
            </a>
            @else
            <a href="{{ route('register') }}"
               class="inline-flex items-center justify-center gap-2 font-bold px-8 py-4 rounded-2xl text-sm transition-all shadow-lg hover:shadow-amber-500/30 hover:-translate-y-1"
               style="background: linear-gradient(135deg, #fcd34d 0%, #f59e0b 50%, #fb923c 100%); color: #1a1a1a;">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/>
                </svg>
                Daftar & Buat Laporan
            </a>
            @endauth
            <a href="{{ route('lacak') }}"
               class="inline-flex items-center justify-center gap-2 bg-white/10 hover:bg-white/18 border border-white/20 hover:border-white/35 text-white font-semibold px-8 py-4 rounded-2xl transition-all text-sm hover:-translate-y-1">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-4.35-4.35M17 11A6 6 0 105 11a6 6 0 0012 0z"/>
                </svg>
                Lacak Laporan Saya
            </a>
        </div>
    </div>
</section>

{{-- ═══ FOOTER ═══ --}}
<footer class="bg-gray-950 text-gray-400 pt-16 pb-8 px-4">
    <div class="max-w-6xl mx-auto">
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-10 mb-12">

            {{-- Brand --}}
            <div>
                <div class="flex items-center gap-2.5 mb-4">
                    <div class="w-10 h-10 bg-gradient-to-br from-[#1a3a6b] to-[#2352a0] rounded-xl flex items-center justify-center shadow-md">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-2 10v-5a1 1 0 00-1-1h-2a1 1 0 00-1 1v5m4 0H9"/>
                        </svg>
                    </div>
                    <span class="text-white font-black text-base">BatusangkarLapor</span>
                </div>
                <p class="text-sm leading-relaxed text-gray-500">Sistem Informasi Pengaduan Masyarakat resmi Pemerintah Kabupaten Tanah Datar, Sumatera Barat.</p>
                <div class="flex items-center gap-1.5 mt-4">
                    <div class="w-2 h-2 bg-green-500 rounded-full animate-pulse"></div>
                    <span class="text-xs text-green-400 font-medium">Sistem aktif & berjalan</span>
                </div>
            </div>

            {{-- Links --}}
            <div>
                <div class="text-white font-bold mb-4 text-sm uppercase tracking-wide">Tautan Cepat</div>
                <div class="space-y-2.5 text-sm">
                    @foreach([['Beranda', 'beranda'], ['Cek Laporan', 'lacak'], ['FAQ', 'faq'], ['Kritik & Saran', 'kritik.create'], ['Daftar Akun', 'register']] as $l)
                    <div>
                        <a href="{{ route($l[1]) }}" class="hover:text-white transition-colors flex items-center gap-2 group">
                            <svg class="w-3 h-3 text-amber-400 opacity-0 group-hover:opacity-100 -translate-x-1 group-hover:translate-x-0 transition-all" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"/>
                            </svg>
                            {{ $l[0] }}
                        </a>
                    </div>
                    @endforeach
                </div>
            </div>

            {{-- Contact --}}
            <div>
                <div class="text-white font-bold mb-4 text-sm uppercase tracking-wide">Kontak</div>
                <div class="space-y-3 text-sm">
                    <a href="https://www.google.com/maps?sca_esv=b67966820d436860&output=search&q=kantor+bupati+tanah+datar&source=lnms&entry=mc"
                       target="_blank" rel="noopener"
                       class="flex items-start gap-3 hover:text-white transition-colors group">
                        <svg class="w-4 h-4 flex-shrink-0 mt-0.5 text-amber-400 group-hover:text-amber-300 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 14v3m4-3v3m4-3v3M3 21h18M3 10h18M3 7l9-4 9 4M4 10h16v11H4V10z"/>
                        </svg>
                        <span>Kantor Bupati Tanah Datar</span>
                    </a>
                    <a href="https://www.google.com/maps/place/Batusangkar,+Baringin,+Kec.+Lima+Kaum,+Kabupaten+Tanah+Datar,+Sumatera+Barat/@-0.4577941,100.5713967,14z/data=!4m6!3m5!1s0x2fd52d6c912f19e5:0x3425e9d27053fd72!8m2!3d-0.4577941!4d100.5919963!16zL20vMGRsZ3Z4!5m1!1e4?entry=ttu&g_ep=EgoyMDI2MDMxOC4xIKXMDSoASAFQAw%3D%3D"
                       target="_blank" rel="noopener"
                       class="flex items-start gap-3 hover:text-white transition-colors group">
                        <svg class="w-4 h-4 flex-shrink-0 mt-0.5 text-amber-400 group-hover:text-amber-300 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                        </svg>
                        <span>Batusangkar, Sumatera Barat</span>
                    </a>
                    <div class="flex items-start gap-3">
                        <svg class="w-4 h-4 flex-shrink-0 mt-0.5 text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9"/>
                        </svg>
                        <a href="https://www.tanahdatar.go.id/beranda" target="_blank" rel="noopener" class="hover:text-white transition-colors">www.tanahdatar.go.id</a>
                    </div>
                </div>
            </div>
        </div>

        <div class="border-t border-gray-800/60 pt-7 flex flex-col sm:flex-row items-center justify-between gap-2 text-xs text-gray-600">
            <span>© {{ date('Y') }} BatusangkarLapor — Pemerintah Kabupaten Tanah Datar. Hak Cipta Dilindungi | zacky alvarezy</span>
            <span class="flex items-center gap-1.5">
                Dibuat dengan warga batusangkar yang peduli <svg class="w-3.5 h-3.5 text-red-500" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z" clip-rule="evenodd"/>
                </svg>
                <svg class="w-3.5 h-3.5 text-red-500" fill="currentColor" viewBox="0 0 20 20">
            </span>
        </div>
    </div>
</footer>

{{-- ═══ SCRIPTS ═══ --}}
<script>
// Scroll reveal
(function() {
    const obs = new IntersectionObserver((entries) => {
        entries.forEach(e => {
            if (e.isIntersecting) {
                e.target.classList.add('visible');
                obs.unobserve(e.target);
            }
        });
    }, { threshold: 0.1 });
    document.querySelectorAll('.reveal').forEach(el => obs.observe(el));
})();

// Mobile menu toggle
function toggleMobMenu() {
    const menu = document.getElementById('mob-menu');
    menu.classList.toggle('hidden');
}

// Close mobile menu on outside click
document.addEventListener('click', function(e) {
    const menu = document.getElementById('mob-menu');
    const btn = document.getElementById('mob-menu-btn');
    if (!menu.contains(e.target) && !btn.contains(e.target)) {
        menu.classList.add('hidden');
    }
});

// Animate progress bars on scroll
const progObserver = new IntersectionObserver((entries) => {
    entries.forEach(e => {
        if (e.isIntersecting) {
            e.target.querySelectorAll('.prog-fill').forEach(bar => {
                const w = bar.style.width;
                bar.style.width = '0';
                setTimeout(() => { bar.style.width = w; }, 100);
            });
        }
    });
}, { threshold: 0.3 });
document.querySelectorAll('.card-float').forEach(el => progObserver.observe(el));
</script>

@endsection