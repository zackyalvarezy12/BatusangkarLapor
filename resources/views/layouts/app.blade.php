<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'BatusangkarLapor')</title>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800;900&family=DM+Serif+Display:ital@0;1&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>body { font-family: 'Plus Jakarta Sans', sans-serif; }</style>
    @stack('styles')
</head>
<body class="bg-gray-50">

{{-- ─── Top Bar ─── --}}
<div style="background:linear-gradient(90deg,#0f2654,#1a3a6b);" class="text-white text-xs py-1.5 px-4 flex items-center justify-between">
    <span class="flex items-center gap-1.5">
        <svg class="w-3.5 h-3.5 text-amber-400 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 14v3m4-3v3m4-3v3M3 21h18M3 10h18M3 7l9-4 9 4M4 10h16v11H4V10z"/>
        </svg>
        <strong>Pemerintah Kabupaten Tanah Datar</strong>
        <span class="text-white/50 hidden sm:inline">—</span>
        <span class="text-white/70 hidden sm:inline">Batusangkar, Sumatera Barat</span>
    </span>
    <span class="hidden sm:flex items-center gap-1.5 text-white/60">
        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
        </svg>
        Laman Resmi Pengaduan Masyarakat
    </span>
</div>

@yield('content')

{{-- ─── Toast ─── --}}
@if(session('success'))
<div id="toast" class="fixed bottom-5 right-5 z-50 text-white px-5 py-3.5 rounded-2xl shadow-2xl flex items-center gap-3 max-w-sm"
     style="background:linear-gradient(135deg,#16a34a,#15803d); box-shadow:0 8px 30px rgba(22,163,74,.4);">
    <div class="w-7 h-7 bg-white/20 rounded-xl flex items-center justify-center flex-shrink-0">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/>
        </svg>
    </div>
    <span class="text-sm font-semibold">{!! session('success') !!}</span>
</div>
@endif

@if(session('error'))
<div id="toast" class="fixed bottom-5 right-5 z-50 text-white px-5 py-3.5 rounded-2xl shadow-2xl flex items-center gap-3 max-w-sm"
     style="background:linear-gradient(135deg,#dc2626,#b91c1c); box-shadow:0 8px 30px rgba(220,38,38,.4);">
    <div class="w-7 h-7 bg-white/20 rounded-xl flex items-center justify-center flex-shrink-0">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"/>
        </svg>
    </div>
    <span class="text-sm font-semibold">{!! session('error') !!}</span>
</div>
@endif

<script>
    setTimeout(() => {
        const t = document.getElementById('toast');
        if (t) { t.style.opacity = '0'; t.style.transition = 'opacity 0.5s'; setTimeout(() => t.remove(), 500); }
    }, 5000);
</script>
@stack('scripts')
</body>
</html>