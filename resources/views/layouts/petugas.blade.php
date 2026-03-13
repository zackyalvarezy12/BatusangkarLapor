<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Petugas') — BatusangkarLapor</title>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700;800&family=DM+Mono:wght@400;500&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        violet:  { 50:'#f5f3ff', 100:'#ede9fe', 200:'#ddd6fe', 300:'#c4b5fd', 400:'#a78bfa', 500:'#8b5cf6', 600:'#7c3aed', 700:'#6d28d9', 800:'#5b21b6', 900:'#4c1d95' },
                        accent:  { DEFAULT:'#f59e0b' },
                        surface: { DEFAULT:'#faf9ff', card:'#ffffff' },
                    },
                    fontFamily: { sans: ['DM Sans', 'sans-serif'], mono: ['DM Mono', 'monospace'] },
                }
            }
        }
    </script>
    <style>
        * { font-family: 'DM Sans', sans-serif; }
        code, .mono { font-family: 'DM Mono', monospace; }

        /* Scrollbar */
        ::-webkit-scrollbar { width: 4px; height: 4px; }
        ::-webkit-scrollbar-track { background: transparent; }
        ::-webkit-scrollbar-thumb { background: #c4b5fd; border-radius: 99px; }

        /* Sidebar gradient */
        #sidebar-petugas {
            background: linear-gradient(175deg, #3b0764 0%, #4c1d95 40%, #5b21b6 100%);
        }

        /* Active nav glow */
        .nav-active {
            background: rgba(255,255,255,0.15);
            box-shadow: inset 3px 0 0 #f59e0b;
        }

        /* Card hover */
        .card-hover { transition: transform .2s ease, box-shadow .2s ease; }
        .card-hover:hover { transform: translateY(-2px); box-shadow: 0 8px 30px rgba(109,40,217,.12); }

        /* Violet glow button */
        .btn-violet {
            background: linear-gradient(135deg, #7c3aed, #6d28d9);
            box-shadow: 0 4px 14px rgba(109,40,217,.35);
        }
        .btn-violet:hover {
            background: linear-gradient(135deg, #6d28d9, #5b21b6);
            box-shadow: 0 6px 20px rgba(109,40,217,.45);
        }

        /* Noise overlay sidebar */
        #sidebar-petugas::before {
            content: '';
            position: absolute;
            inset: 0;
            background-image: url("data:image/svg+xml,%3Csvg viewBox='0 0 256 256' xmlns='http://www.w3.org/2000/svg'%3E%3Cfilter id='noise'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='0.9' numOctaves='4' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='100%25' height='100%25' filter='url(%23noise)' opacity='0.04'/%3E%3C/svg%3E");
            pointer-events: none;
            border-radius: inherit;
        }

        .pulse-dot { animation: pulse-violet 2s ease-in-out infinite; }
        @keyframes pulse-violet {
            0%, 100% { opacity:1; transform:scale(1); }
            50% { opacity:.6; transform:scale(1.4); }
        }

        /* Page fade in */
        main { animation: fadeUp .3s ease; }
        @keyframes fadeUp {
            from { opacity:0; transform:translateY(8px); }
            to   { opacity:1; transform:translateY(0); }
        }
    </style>
    @stack('styles')
</head>
<body class="bg-violet-50/50">

{{-- Mobile Overlay --}}
<div id="sidebar-overlay"
     onclick="closeSidebar()"
     class="fixed inset-0 z-40 bg-black/50 backdrop-blur-sm hidden lg:hidden"></div>

{{-- ══════════════════════════ SIDEBAR ══════════════════════════ --}}
<aside id="sidebar-petugas"
       class="fixed inset-y-0 left-0 z-50 w-[260px] flex flex-col transition-transform duration-300 -translate-x-full lg:translate-x-0 overflow-hidden">

    {{-- Logo --}}
    <div class="flex items-center gap-3 px-5 py-5 border-b border-white/10">
        <div class="w-10 h-10 bg-accent rounded-xl flex items-center justify-center font-black text-gray-900 text-xs shadow-lg">BL</div>
        <div>
            <div class="font-bold text-white text-sm leading-tight">BatusangkarLapor</div>
            <div class="text-violet-300 text-xs font-medium">Portal Petugas</div>
        </div>
        <button onclick="closeSidebar()"
                class="lg:hidden ml-auto text-violet-300 hover:text-white p-1">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
            </svg>
        </button>
    </div>

    {{-- Wilayah Badge --}}
    <div class="mx-4 mt-4 bg-white/10 backdrop-blur rounded-xl px-4 py-3 border border-white/10">
        <div class="flex items-center gap-2.5">
            <div class="w-8 h-8 bg-accent/20 rounded-lg flex items-center justify-center flex-shrink-0">
                <svg class="w-4 h-4 text-accent" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                </svg>
            </div>
            <div class="min-w-0">
                <div class="text-violet-300 text-xs">Daerah Tugas</div>
                @if(auth()->user()->wilaya_id)
                <div class="text-white font-bold text-xs truncate">{{ auth()->user()->wilaya->nama }}</div>
                @else
                <div class="flex items-center gap-1 mt-0.5">
                    <span class="inline-flex items-center gap-1 text-xs font-black px-2 py-0.5 rounded-full"
                          style="background:rgba(245,158,11,.25);color:#fbbf24;">
                        <svg style="width:10px;height:10px" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                  d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064"/>
                        </svg>
                        Semua Wilayah
                    </span>
                </div>
                @endif
            </div>
        </div>
    </div>

    {{-- Nav --}}
    <nav class="flex-1 overflow-y-auto px-3 py-4 space-y-0.5 relative z-10">
        <div class="text-violet-400 text-xs font-semibold uppercase tracking-widest px-3 mb-2">Menu</div>

        @php
        $menu = [
            ['route' => 'petugas.dashboard',       'label' => 'Dashboard',       'icon' => 'M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6'],
            ['route' => 'petugas.pengaduan.index', 'label' => 'Laporan Masuk',   'icon' => 'M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z'],
            ['route' => 'petugas.laporan.index',   'label' => 'Export Laporan',  'icon' => 'M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4'],
        ];
        @endphp

        @foreach($menu as $item)
        @php $active = request()->routeIs($item['route'].'*'); @endphp
        <a href="{{ route($item['route']) }}"
           class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition-all
                  {{ $active ? 'nav-active text-white' : 'text-violet-200 hover:bg-white/10 hover:text-white' }}">
            <div class="w-8 h-8 rounded-lg flex items-center justify-center flex-shrink-0
                        {{ $active ? 'bg-accent text-gray-900' : 'bg-white/10 text-violet-300' }}">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="{{ $item['icon'] }}"/>
                </svg>
            </div>
            {{ $item['label'] }}
            @if($item['route'] === 'petugas.pengaduan.index')
            @php
                $pendingQuery = \App\Models\Pengaduan::where('status','menunggu');
                if(auth()->user()->wilaya_id) {
                    $pendingQuery->where('wilaya_id', auth()->user()->wilaya_id);
                }
                $pending = $pendingQuery->count();
            @endphp
            @if($pending > 0)
            <span class="ml-auto bg-red-500 text-white text-xs font-bold px-2 py-0.5 rounded-full">{{ $pending }}</span>
            @endif
            @endif
        </a>
        @endforeach

        <div class="text-violet-400 text-xs font-semibold uppercase tracking-widest px-3 mt-4 mb-2">Akun</div>

        <a href="{{ route('petugas.profil.edit') }}"
           class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition-all
                  {{ request()->routeIs('petugas.profil*') ? 'nav-active text-white' : 'text-violet-200 hover:bg-white/10 hover:text-white' }}">
            <div class="w-8 h-8 rounded-lg flex items-center justify-center flex-shrink-0
                        {{ request()->routeIs('petugas.profil*') ? 'bg-accent text-gray-900' : 'bg-white/10 text-violet-300' }}">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                          d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                </svg>
            </div>
            Edit Profil
        </a>

        <a href="{{ route('petugas.password.edit') }}"
           class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition-all
                  {{ request()->routeIs('petugas.password*') ? 'nav-active text-white' : 'text-violet-200 hover:bg-white/10 hover:text-white' }}">
            <div class="w-8 h-8 rounded-lg flex items-center justify-center flex-shrink-0
                        {{ request()->routeIs('petugas.password*') ? 'bg-accent text-gray-900' : 'bg-white/10 text-violet-300' }}">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                          d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                </svg>
            </div>
            Ganti Password
        </a>
    </nav>

    {{-- User Footer --}}
    <div class="px-4 py-4 border-t border-white/10 relative z-10">
        <div class="flex items-center gap-3 mb-3">
            <div class="w-9 h-9 rounded-xl bg-gradient-to-br from-violet-400 to-violet-600 flex items-center justify-center text-white font-black text-sm shadow-md flex-shrink-0">
                {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
            </div>
            <div class="min-w-0">
                <div class="text-white text-xs font-bold truncate">{{ auth()->user()->name }}</div>
                <div class="text-violet-300 text-xs truncate">{{ auth()->user()->email }}</div>
            </div>
            <span class="flex-shrink-0">
                <span class="w-2 h-2 bg-green-400 rounded-full block pulse-dot"></span>
            </span>
        </div>
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button class="w-full flex items-center gap-2 text-xs text-violet-300 hover:text-white bg-white/5 hover:bg-white/10 rounded-xl py-2.5 px-3 transition font-medium">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                </svg>
                Keluar dari Akun
            </button>
        </form>
    </div>
</aside>

{{-- ══════════════════════════ MAIN ══════════════════════════ --}}
<div class="lg:ml-[260px]">

    {{-- Topbar --}}
    <header class="sticky top-0 z-40 bg-white/80 backdrop-blur-md border-b border-violet-100 px-4 lg:px-6 py-3 flex items-center justify-between">
        <div class="flex items-center gap-3">
            <button onclick="openSidebar()"
                    class="lg:hidden w-9 h-9 bg-violet-100 hover:bg-violet-200 rounded-xl flex items-center justify-center transition">
                <svg class="w-4 h-4 text-violet-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                </svg>
            </button>
            <div class="hidden lg:flex items-center gap-2 text-sm">
                <span class="text-violet-600 font-semibold">Petugas</span>
                <svg class="w-3.5 h-3.5 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                </svg>
                <span class="text-gray-500">@yield('breadcrumb', 'Dashboard')</span>
            </div>
        </div>

        <div class="flex items-center gap-2">
            {{-- Notifikasi --}}
            <button class="w-9 h-9 bg-violet-50 hover:bg-violet-100 rounded-xl flex items-center justify-center relative transition">
                <svg class="w-4 h-4 text-violet-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
                </svg>
                @php $notif = \App\Models\Notifikasi::where('user_id', auth()->id())->whereNull('dibaca_at')->count(); @endphp
                @if($notif > 0)
                <span class="absolute -top-0.5 -right-0.5 w-4 h-4 bg-red-500 text-white text-xs rounded-full flex items-center justify-center font-bold">{{ $notif }}</span>
                @endif
            </button>

            {{-- Avatar --}}
            <a href="{{ route('petugas.profil.edit') }}"
               class="flex items-center gap-2.5 bg-violet-50 hover:bg-violet-100 rounded-xl px-3 py-2 transition">
                <div class="w-7 h-7 rounded-lg bg-gradient-to-br from-violet-500 to-violet-700 flex items-center justify-center text-white font-bold text-xs">
                    {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                </div>
                <span class="text-sm font-semibold text-violet-800 hidden sm:block max-w-[120px] truncate">
                    {{ auth()->user()->name }}
                </span>
            </a>
        </div>
    </header>

    {{-- Alerts --}}
    <div class="px-4 lg:px-6 pt-4 space-y-3">
        @if(session('success'))
        <div class="flex items-center gap-3 bg-emerald-50 border border-emerald-200 text-emerald-800 px-4 py-3 rounded-2xl text-sm">
            <svg class="w-5 h-5 text-emerald-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            {!! session('success') !!}
        </div>
        @endif
        @if($errors->any())
        <div class="flex items-start gap-3 bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-2xl text-sm">
            <svg class="w-5 h-5 text-red-500 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            <ul class="list-disc list-inside space-y-0.5">
                @foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach
            </ul>
        </div>
        @endif
    </div>

    <main class="px-4 lg:px-6 pb-8 pt-2">
        @yield('content')
    </main>
</div>

@stack('scripts')
<script>
    function openSidebar() {
        document.getElementById('sidebar-petugas').classList.remove('-translate-x-full');
        document.getElementById('sidebar-overlay').classList.remove('hidden');
        document.body.classList.add('overflow-hidden');
    }
    function closeSidebar() {
        document.getElementById('sidebar-petugas').classList.add('-translate-x-full');
        document.getElementById('sidebar-overlay').classList.add('hidden');
        document.body.classList.remove('overflow-hidden');
    }
</script>
</body>
</html>