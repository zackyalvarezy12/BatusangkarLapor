<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Dashboard') — BatusangkarLapor</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Sora:wght@400;500;600;700;800&family=JetBrains+Mono:wght@400;500&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4"></script>
    <script>
    tailwind.config = {
        theme: {
            extend: {
                fontFamily: {
                    sans: ['Sora', 'sans-serif'],
                    mono: ['JetBrains Mono', 'monospace'],
                },
                colors: {
                    navy:   { DEFAULT:'#0B1628', 50:'#f0f4ff', 100:'#dbe4f8', 900:'#040a14' },
                    brand:  { DEFAULT:'#1E3A8A', light:'#3B5FCB', muted:'#1e3a8a20' },
                    gold:   { DEFAULT:'#F59E0B', light:'#FCD34D', dark:'#D97706' },
                    ink:    { DEFAULT:'#0F172A', muted:'#64748B', faint:'#CBD5E1' },
                },
            }
        }
    }
    </script>
    <style>
        *, *::before, *::after { box-sizing: border-box; }
        body { font-family: 'Sora', sans-serif; background: #F8FAFF; }
        code, .mono { font-family: 'JetBrains Mono', monospace; }

        /* Scrollbar */
        ::-webkit-scrollbar { width: 4px; height: 4px; }
        ::-webkit-scrollbar-track { background: transparent; }
        ::-webkit-scrollbar-thumb { background: #C7D2FE; border-radius: 99px; }

        /* Sidebar */
        #sidebar {
            background: linear-gradient(175deg, #0B1628 0%, #0F1E3A 55%, #0B1628 100%);
        }
        #sidebar::before {
            content: '';
            position: absolute;
            inset: 0;
            background: radial-gradient(ellipse at 0% 30%, rgba(59,95,203,0.18) 0%, transparent 65%),
                        radial-gradient(ellipse at 100% 80%, rgba(245,158,11,0.06) 0%, transparent 60%);
            pointer-events: none;
        }

        /* Nav items */
        .nav-link {
            display: flex; align-items: center; gap: 11px;
            padding: 9px 11px; border-radius: 10px;
            font-size: 13px; font-weight: 500;
            color: rgba(203,213,225,0.65);
            text-decoration: none;
            transition: all .18s ease;
            position: relative;
        }
        .nav-link:hover { color: #fff; background: rgba(255,255,255,0.06); }
        .nav-link.active {
            color: #fff;
            background: rgba(59,95,203,0.22);
            box-shadow: inset 2.5px 0 0 #F59E0B;
        }
        .nav-icon {
            width: 30px; height: 30px;
            border-radius: 8px;
            display: flex; align-items: center; justify-content: center;
            flex-shrink: 0;
            transition: all .18s ease;
        }
        .nav-link .nav-icon    { background: rgba(255,255,255,0.06); color: rgba(203,213,225,0.5); }
        .nav-link:hover .nav-icon { background: rgba(255,255,255,0.1); color: #e2e8f0; }
        .nav-link.active .nav-icon { background: #F59E0B; color: #0B1628; }

        .nav-section-label {
            font-size: 10px; font-weight: 700; letter-spacing: .12em;
            text-transform: uppercase; color: rgba(148,163,184,0.4);
            padding: 0 11px; margin: 18px 0 5px;
        }

        /* Cards */
        .card { background: #fff; border: 1px solid #E8EFF8; border-radius: 18px; }
        .card-elevated { background: #fff; border: 1px solid #E8EFF8; border-radius: 18px; box-shadow: 0 2px 12px rgba(14,30,62,0.06); }

        /* Stat card hover */
        .stat-card { transition: transform .2s ease, box-shadow .2s ease; }
        .stat-card:hover { transform: translateY(-3px); box-shadow: 0 10px 30px rgba(14,30,62,0.1); }

        /* Page enter */
        main { animation: pageIn .22s ease; }
        @keyframes pageIn { from { opacity:0; transform:translateY(8px); } to { opacity:1; transform:none; } }

        /* Alert animations */
        .alert-in { animation: alertIn .3s ease; }
        @keyframes alertIn { from { opacity:0; transform:translateY(-6px); } to { opacity:1; transform:none; } }

        /* Badge */
        .badge-pending { background:#FEF3C7; color:#92400E; font-size:11px; font-weight:700; padding:2px 8px; border-radius:99px; }

        /* Active sidebar glow */
        .nav-link.active::after {
            content: '';
            position: absolute; right: 0; top: 50%; transform: translateY(-50%);
            width: 3px; height: 60%; border-radius: 99px;
            background: rgba(245,158,11,0.3);
        }
    </style>
    @stack('styles')
</head>
<body class="flex h-screen overflow-hidden">

{{-- Mobile overlay backdrop --}}
<div id="sidebar-overlay" onclick="closeSidebar()" class="fixed inset-0 z-40 bg-black/50 backdrop-blur-sm hidden lg:hidden opacity-0 transition-opacity duration-250"></div>

{{-- ══════════════════ SIDEBAR ══════════════════ --}}
<aside id="sidebar" class="fixed inset-y-0 left-0 z-50 w-[228px] flex flex-col transition-transform duration-300 -translate-x-full lg:translate-x-0 flex-shrink-0">

    {{-- Brand --}}
    <div class="flex items-center gap-3 px-4 py-5 border-b border-white/[0.07]">
        <div class="w-9 h-9 bg-gold rounded-xl flex items-center justify-center flex-shrink-0 shadow-lg shadow-amber-900/30">
            <svg class="w-[18px] h-[18px] text-navy" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-2 10v-5a1 1 0 00-1-1h-2a1 1 0 00-1 1v5m4 0H9"/>
            </svg>
        </div>
        <div class="min-w-0">
            <div class="text-white font-bold text-[13px] leading-tight truncate">BatusangkarLapor</div>
            <div class="text-blue-400/60 text-[11px] font-mono mt-0.5">Panel Admin</div>
        </div>
        <button onclick="toggleSidebar()" class="lg:hidden ml-auto text-white/30 hover:text-white/70 p-1 transition">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
            </svg>
        </button>
    </div>

    {{-- Navigation --}}
    <nav class="flex-1 overflow-y-auto px-3 py-2 relative z-10">

        <p class="nav-section-label">Utama</p>
        <a href="{{ route('admin.dashboard') }}"
           class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
            <span class="nav-icon">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                </svg>
            </span>
            Dashboard
        </a>

        <p class="nav-section-label">Pengelolaan</p>
        <a href="{{ route('admin.pengaduan.index') }}"
           class="nav-link {{ request()->routeIs('admin.pengaduan*') ? 'active' : '' }}">
            <span class="nav-icon">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                </svg>
            </span>
            Semua Laporan
            @php try { $pendingCount = \App\Models\Pengaduan::where('status','menunggu')->count(); } catch(\Exception $e) { $pendingCount = 0; } @endphp
            @if($pendingCount > 0)
            <span class="ml-auto badge-pending">{{ $pendingCount }}</span>
            @endif
        </a>

        <a href="{{ route('admin.laporan.index') }}"
           class="nav-link {{ request()->routeIs('admin.laporan*') ? 'active' : '' }}">
            <span class="nav-icon">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                </svg>
            </span>
            Export Laporan
        </a>

        <a href="{{ route('admin.user.index') }}"
           class="nav-link {{ request()->routeIs('admin.user*') ? 'active' : '' }}">
            <span class="nav-icon">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
                </svg>
            </span>
            Manajemen User
        </a>

        <a href="{{ route('admin.kategori.index') }}"
           class="nav-link {{ request()->routeIs('admin.kategori*') ? 'active' : '' }}">
            <span class="nav-icon">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
                </svg>
            </span>
            Kategori
        </a>

        <a href="{{ route('admin.wilaya.index') }}"
           class="nav-link {{ request()->routeIs('admin.wilaya*') ? 'active' : '' }}">
            <span class="nav-icon">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                </svg>
            </span>
            Wilayah
        </a>

        <a href="{{ route('admin.faq.index') }}"
           class="nav-link {{ request()->routeIs('admin.faq*') ? 'active' : '' }}">
            <span class="nav-icon">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </span>
            FAQ
        </a>

        <a href="{{ route('admin.pengumuman.index') }}"
           class="nav-link {{ request()->routeIs('admin.pengumuman*') ? 'active' : '' }}">
            <span class="nav-icon">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z"/>
                </svg>
            </span>
            Pengumuman
        </a>

        <a href="{{ route('admin.kritik.index') }}"
           class="nav-link {{ request()->routeIs('admin.kritik*') ? 'active' : '' }}">
            <span class="nav-icon">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"/>
                </svg>
            </span>
            Kritik & Saran
            @php $unread = \App\Models\Kritik::whereNull('balasan')->count(); @endphp
            @if($unread > 0)
            <span class="ml-auto bg-red-500 text-white text-xs font-bold px-2 py-0.5 rounded-full">{{ $unread }}</span>
            @endif
        </a>

        <p class="nav-section-label">Akun</p>
        <a href="{{ route('admin.profil.edit') }}"
           class="nav-link {{ request()->routeIs('admin.profil*') ? 'active' : '' }}">
            <span class="nav-icon">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                </svg>
            </span>
            Edit Profil
        </a>
        <a href="{{ route('admin.password.edit') }}"
           class="nav-link {{ request()->routeIs('admin.password*') ? 'active' : '' }}">
            <span class="nav-icon">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                </svg>
            </span>
            Ganti Password
        </a>
    </nav>

    {{-- User footer --}}
    <div class="relative z-10 px-3 pb-4 pt-3 border-t border-white/[0.07]">
        <div class="flex items-center gap-2.5 px-2 mb-3">
            <div class="w-8 h-8 rounded-xl bg-gold flex items-center justify-center text-navy font-black text-xs flex-shrink-0">
                {{ strtoupper(substr(auth()->user()->name ?? 'A', 0, 1)) }}
            </div>
            <div class="min-w-0 flex-1">
                <div class="text-white text-[12px] font-semibold truncate">{{ auth()->user()->name ?? 'Admin' }}</div>
                <div class="text-blue-400/50 text-[11px]">Administrator</div>
            </div>
            <span class="w-2 h-2 rounded-full bg-emerald-400 flex-shrink-0 shadow-sm shadow-emerald-400/50"></span>
        </div>
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="nav-link w-full justify-center text-xs opacity-50 hover:opacity-80">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                </svg>
                Keluar
            </button>
        </form>
    </div>
</aside>

{{-- ══════════════════ MAIN CONTENT ══════════════════ --}}
<div class="flex-1 lg:ml-[228px] flex flex-col min-h-screen overflow-y-auto">

    {{-- Topbar --}}
    <header class="sticky top-0 z-40 bg-white/90 backdrop-blur-md border-b border-slate-200/60 px-5 lg:px-7 py-3.5 flex items-center justify-between">
        <div class="flex items-center gap-3">
            <button onclick="toggleSidebar()" class="lg:hidden w-9 h-9 hover:bg-slate-100 rounded-xl flex items-center justify-center transition">
                <svg class="w-4 h-4 text-slate-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16"/>
                </svg>
            </button>
            <div class="hidden lg:flex items-center gap-2 text-sm">
                <span class="text-brand font-semibold text-[13px]">Admin</span>
                <svg class="w-3 h-3 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"/>
                </svg>
                <span class="text-slate-500 text-[13px]">@yield('breadcrumb', 'Dashboard')</span>
            </div>
        </div>
        <div class="flex items-center gap-2">
            <button class="relative w-9 h-9 hover:bg-slate-100 rounded-xl flex items-center justify-center transition">
                <svg class="w-4 h-4 text-slate-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
                </svg>
                @php try { $notifCount = \App\Models\Notifikasi::where('user_id', auth()->id())->whereNull('dibaca_at')->count(); } catch(\Exception $e) { $notifCount = 0; } @endphp
                @if($notifCount > 0)
                <span class="absolute -top-0.5 -right-0.5 w-[18px] h-[18px] bg-red-500 text-white text-[10px] font-bold rounded-full flex items-center justify-center">{{ $notifCount }}</span>
                @endif
            </button>
            <a href="{{ route('admin.profil.edit') }}" class="flex items-center gap-2.5 bg-slate-50 hover:bg-slate-100 border border-slate-200 px-3 py-2 rounded-xl transition">
                <div class="w-6 h-6 rounded-lg bg-brand flex items-center justify-center text-white font-bold text-[11px]">
                    {{ strtoupper(substr(auth()->user()->name ?? 'A', 0, 1)) }}
                </div>
                <span class="hidden sm:block text-[13px] font-semibold text-slate-700 max-w-[120px] truncate">{{ auth()->user()->name ?? 'Admin' }}</span>
                <svg class="w-3 h-3 text-slate-400 hidden sm:block" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                </svg>
            </a>
        </div>
    </header>

    {{-- Flash messages --}}
    @if(session('success') || session('error') || $errors->any())
    <div class="px-5 lg:px-7 pt-4 space-y-2 alert-in">
        @if(session('success'))
        <div class="flex items-center gap-3 bg-emerald-50 border border-emerald-200/80 text-emerald-800 px-4 py-3 rounded-2xl text-sm font-medium">
            <svg class="w-4 h-4 text-emerald-500 flex-shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            {!! session('success') !!}
        </div>
        @endif
        @if(session('error'))
        <div class="flex items-center gap-3 bg-red-50 border border-red-200/80 text-red-800 px-4 py-3 rounded-2xl text-sm font-medium">
            <svg class="w-4 h-4 text-red-400 flex-shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            {!! session('error') !!}
        </div>
        @endif
        @if($errors->any())
        <div class="flex items-start gap-3 bg-red-50 border border-red-200/80 text-red-700 px-4 py-3 rounded-2xl text-sm">
            <svg class="w-4 h-4 text-red-400 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            <ul class="space-y-0.5">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
        </div>
        @endif
    </div>
    @endif

    <main class="flex-1 px-5 lg:px-7 pb-10">
        @yield('content')
    </main>
</div>

<script>
function toggleSidebar() {
    const sidebar = document.getElementById('sidebar');
    sidebar.classList.contains('-translate-x-full') ? openSidebar() : closeSidebar();
}
function openSidebar() {
    document.getElementById('sidebar').classList.remove('-translate-x-full');
    const overlay = document.getElementById('sidebar-overlay');
    if (overlay) {
        overlay.classList.remove('hidden');
        requestAnimationFrame(() => overlay.classList.remove('opacity-0'));
    }
    document.body.style.overflow = 'hidden';
}
function closeSidebar() {
    document.getElementById('sidebar').classList.add('-translate-x-full');
    const overlay = document.getElementById('sidebar-overlay');
    if (overlay) {
        overlay.classList.add('opacity-0');
        setTimeout(() => overlay.classList.add('hidden'), 250);
    }
    document.body.style.overflow = '';
}
// Auto-close when clicking nav link on mobile
document.addEventListener('DOMContentLoaded', () => {
    document.querySelectorAll('#sidebar .nav-link').forEach(link => {
        link.addEventListener('click', () => {
            if (window.innerWidth < 1024) closeSidebar();
        });
    });
});
</script>
@stack('scripts')
</body>
</html>