<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Masuk — BatusangkarLapor</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800;900&family=DM+Serif+Display:ital@0;1&display=swap" rel="stylesheet">
    <style>
        * { font-family: 'Plus Jakarta Sans', sans-serif; }

        body { min-height: 100vh; margin: 0; }

        .login-wrapper {
            display: flex;
            flex-direction: row;
            min-height: 100vh;
        }

        @media (max-width: 1023px) {
            .login-wrapper { flex-direction: column; }
        }

        .panel-left {
            background: linear-gradient(155deg, #0f2654 0%, #1a3a6b 45%, #1e4d8c 80%, #0f3460 100%);
            position: relative;
            overflow: hidden;
        }
        .panel-left::before {
            content: '';
            position: absolute;
            inset: 0;
            background:
                radial-gradient(ellipse 80% 60% at 80% 20%, rgba(245,158,11,.18) 0%, transparent 55%),
                radial-gradient(ellipse 60% 60% at 10% 90%, rgba(99,179,237,.12) 0%, transparent 55%);
            pointer-events: none;
        }
        .panel-left::after {
            content: '';
            position: absolute;
            inset: 0;
            background-image:
                linear-gradient(rgba(255,255,255,.04) 1px, transparent 1px),
                linear-gradient(90deg, rgba(255,255,255,.04) 1px, transparent 1px);
            background-size: 60px 60px;
            pointer-events: none;
        }

        @keyframes floatA { 0%,100%{transform:translate(0,0)} 50%{transform:translate(-20px,25px)} }
        @keyframes floatB { 0%,100%{transform:translate(0,0)} 50%{transform:translate(15px,-20px)} }
        .orb-a { animation: floatA 11s ease-in-out infinite; }
        .orb-b { animation: floatB 8s ease-in-out infinite; }

        @keyframes fadeUp {
            from { opacity:0; transform:translateY(24px); }
            to   { opacity:1; transform:translateY(0); }
        }
        .fu-1 { animation: fadeUp .6s cubic-bezier(.22,.61,.36,1) both; }
        .fu-2 { animation: fadeUp .6s .1s cubic-bezier(.22,.61,.36,1) both; }
        .fu-3 { animation: fadeUp .6s .2s cubic-bezier(.22,.61,.36,1) both; }
        .fu-4 { animation: fadeUp .6s .3s cubic-bezier(.22,.61,.36,1) both; }
        .fu-5 { animation: fadeUp .6s .4s cubic-bezier(.22,.61,.36,1) both; }

        .form-input {
            width: 100%;
            border: 1.5px solid #e5e7eb;
            border-radius: 12px;
            padding: 11px 14px 11px 42px;
            font-size: 0.875rem;
            color: #1f2937;
            background: #f9fafb;
            transition: border-color .2s, background .2s, box-shadow .2s;
            outline: none;
            font-family: inherit;
        }
        .form-input:focus {
            border-color: #1a3a6b;
            background: #fff;
            box-shadow: 0 0 0 3px rgba(26,58,107,.1);
        }
        .form-input::placeholder { color: #9ca3af; }

        .pw-wrap { position: relative; }
        .pw-toggle {
            position: absolute; right: 12px; top: 50%;
            transform: translateY(-50%);
            cursor: pointer; color: #9ca3af;
            transition: color .15s;
            background: none; border: none; padding: 0; line-height: 0;
        }
        .pw-toggle:hover { color: #1a3a6b; }

        .btn-submit {
            width: 100%;
            background: linear-gradient(135deg, #1a3a6b, #2352a0);
            color: white; font-weight: 800; font-size: 0.9rem;
            padding: 13px; border-radius: 14px; border: none;
            cursor: pointer;
            transition: transform .2s, box-shadow .2s;
            box-shadow: 0 6px 20px rgba(26,58,107,.35);
            font-family: inherit;
        }
        .btn-submit:hover { transform: translateY(-2px); box-shadow: 0 10px 28px rgba(26,58,107,.4); }
        .btn-submit:active { transform: translateY(0); }

        @keyframes bob { 0%,100%{transform:translateY(0)} 50%{transform:translateY(-8px)} }
        @keyframes bob2 { 0%,100%{transform:translateY(0)} 50%{transform:translateY(-6px)} }
        .bob1 { animation: bob 4s ease-in-out infinite; }
        .bob2 { animation: bob2 4.8s ease-in-out infinite .6s; }

        @keyframes wave {
            0%{transform:rotate(0deg)} 15%{transform:rotate(20deg)} 30%{transform:rotate(-10deg)}
            45%{transform:rotate(15deg)} 60%{transform:rotate(-5deg)} 75%{transform:rotate(10deg)} 100%{transform:rotate(0deg)}
        }
        .wave-hand { animation: wave 2.5s ease-in-out infinite 1s; transform-origin: 70% 90%; }
    </style>
</head>
<body>

<div class="login-wrapper">

    {{-- ═══ LEFT PANEL ═══ --}}
    <div class="panel-left hidden lg:flex lg:w-[44%] xl:w-[40%] flex-col justify-between p-12 relative z-10">
        <div class="orb-a absolute top-[15%] right-[10%] w-72 h-72 rounded-full" style="background:radial-gradient(circle,rgba(245,158,11,.15) 0%,transparent 70%);"></div>
        <div class="orb-b absolute bottom-[15%] left-[5%] w-52 h-52 rounded-full" style="background:radial-gradient(circle,rgba(99,179,237,.13) 0%,transparent 70%);"></div>

        {{-- Logo --}}
        <a href="{{ route('beranda') }}" class="inline-flex items-center gap-3 group relative z-10">
            <div class="w-11 h-11 rounded-xl bg-white/10 border border-white/20 flex items-center justify-center backdrop-blur group-hover:bg-white/15 transition">
                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-2 10v-5a1 1 0 00-1-1h-2a1 1 0 00-1 1v5m4 0H9"/>
                </svg>
            </div>
            <div>
                <div class="text-white font-black text-sm">BatusangkarLapor</div>
                <div class="text-white/50 text-[10px]">Kabupaten Tanah Datar</div>
            </div>
        </a>

        {{-- Middle --}}
        <div class="space-y-8 relative z-10">
            <div>
                <div class="inline-flex items-center gap-2 bg-white/10 border border-white/20 rounded-full px-3 py-1.5 mb-5">
                    <span class="w-1.5 h-1.5 bg-amber-400 rounded-full animate-pulse"></span>
                    <span class="text-white/70 text-[11px] font-semibold uppercase tracking-widest">Selamat Datang Kembali</span>
                </div>
                <h2 class="text-white leading-[1.15] mb-3" style="font-size:2.4rem; font-family:'DM Serif Display',serif;">
                    Senang<br>
                    melihat Anda<br>
                    <em style="background:linear-gradient(135deg,#f59e0b,#fb923c);-webkit-background-clip:text;-webkit-text-fill-color:transparent;background-clip:text;">kembali.</em>
                </h2>
                <p class="text-blue-200/70 text-sm leading-relaxed max-w-xs">
                    Masuk untuk memantau laporan, melihat perkembangan terbaru, dan menyampaikan aspirasi baru.
                </p>
            </div>

            {{-- Illustration --}}
            <div class="flex items-end gap-5">
                <div class="bob1">
                    <svg width="64" height="88" viewBox="0 0 64 88" fill="none">
                        <circle cx="32" cy="18" r="14" fill="#FDE68A" stroke="#FCD34D" stroke-width="1.5"/>
                        <circle cx="26" cy="16" r="2.2" fill="#1a3a6b"/>
                        <circle cx="38" cy="16" r="2.2" fill="#1a3a6b"/>
                        <path d="M26 23 Q32 28 38 23" stroke="#1a3a6b" stroke-width="1.5" stroke-linecap="round" fill="none"/>
                        <path d="M18 16 Q17 6 32 5 Q47 6 46 16" fill="#7c3aed"/>
                        <rect x="16" y="32" width="32" height="30" rx="12" fill="#c7d2fe" stroke="#a5b4fc" stroke-width="1.5"/>
                        <rect x="24" y="40" width="16" height="10" rx="4" fill="white" opacity=".5"/>
                        <rect x="18" y="59" width="12" height="24" rx="6" fill="#3730a3"/>
                        <rect x="34" y="59" width="12" height="24" rx="6" fill="#3730a3"/>
                        <g class="wave-hand">
                            <rect x="48" y="28" width="13" height="9" rx="4.5" fill="#c7d2fe" stroke="#a5b4fc" stroke-width="1.5"/>
                        </g>
                        <rect x="3" y="32" width="13" height="9" rx="4.5" fill="#c7d2fe" stroke="#a5b4fc" stroke-width="1.5"/>
                    </svg>
                </div>
                <div class="bob2 mb-4">
                    <div class="bg-amber-400 rounded-2xl rounded-bl-sm px-4 py-2.5 shadow-lg"
                         style="box-shadow:0 8px 20px rgba(245,158,11,.35);">
                        <p class="text-gray-900 font-black text-xs">Halo! Apa kabar? 👋</p>
                        <p class="text-gray-700 text-[10px] mt-0.5">Laporan Anda menunggu.</p>
                    </div>
                </div>
            </div>

            {{-- Stats --}}
            <div class="grid grid-cols-2 gap-3">
                @php
                    $totalSelesai = \App\Models\Pengaduan::where('status','selesai')->count();
                    $totalLaporan = \App\Models\Pengaduan::count();
                @endphp
                <div class="rounded-2xl p-4 backdrop-blur" style="background:rgba(255,255,255,.08);border:1px solid rgba(255,255,255,.12);">
                    <div class="text-2xl font-black text-white">{{ number_format($totalSelesai) }}</div>
                    <div class="text-blue-300/70 text-xs mt-0.5">Laporan Selesai</div>
                </div>
                <div class="rounded-2xl p-4 backdrop-blur" style="background:rgba(255,255,255,.08);border:1px solid rgba(255,255,255,.12);">
                    <div class="text-2xl font-black text-white">{{ number_format($totalLaporan) }}</div>
                    <div class="text-blue-300/70 text-xs mt-0.5">Total Laporan</div>
                </div>
            </div>
        </div>

        {{-- Bottom dots --}}
        <div class="flex items-center gap-2 relative z-10">
            <div class="w-2 h-2 bg-amber-400 rounded-full"></div>
            <div class="w-2 h-2 rounded-full" style="background:rgba(255,255,255,.2)"></div>
            <div class="w-2 h-2 rounded-full" style="background:rgba(255,255,255,.2)"></div>
            <span class="text-[11px] font-medium ml-2" style="color:rgba(255,255,255,.4)">Akses Dashboard Anda</span>
        </div>
    </div>

    {{-- ═══ RIGHT PANEL ═══ --}}
    <div class="flex-1 flex items-center justify-center bg-[#f3f6fc] px-5 py-16 overflow-y-auto">
        <div class="w-full max-w-md">

            {{-- Mobile logo --}}
            <div class="lg:hidden text-center mb-8">
                <a href="{{ route('beranda') }}" class="inline-flex items-center gap-2">
                    <div class="w-10 h-10 rounded-xl bg-[#1a3a6b] flex items-center justify-center">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-2 10v-5a1 1 0 00-1-1h-2a1 1 0 00-1 1v5m4 0H9"/>
                        </svg>
                    </div>
                    <span class="font-black text-[#1a3a6b]">BatusangkarLapor</span>
                </a>
            </div>

            {{-- Card --}}
            <div class="fu-1 bg-white rounded-3xl p-8 border border-gray-100" style="box-shadow:0 20px 60px rgba(100,116,139,.15);">

                <div class="fu-2 mb-7">
                    <h1 class="text-2xl font-black text-gray-900 leading-tight mb-1" style="font-family:'DM Serif Display',serif;">
                        Masuk ke Akun
                    </h1>
                    <p class="text-gray-400 text-sm">Selamat datang kembali di BatusangkarLapor</p>
                </div>

                {{-- Error --}}
                @if($errors->any())
                <div class="fu-2 bg-red-50 border border-red-200 text-red-700 rounded-xl px-4 py-3 mb-5 text-sm flex items-center gap-2">
                    <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    {{ $errors->first() }}
                </div>
                @endif

                {{-- Success --}}
                @if(session('success'))
                <div class="fu-2 bg-green-50 border border-green-200 text-green-700 rounded-xl px-4 py-3 mb-5 text-sm flex items-center gap-2">
                    <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    {{ session('success') }}
                </div>
                @endif

                <form method="POST" action="{{ route('login') }}" class="space-y-4">
                    @csrf

                    {{-- Email --}}
                    <div class="fu-3">
                        <label class="block text-xs font-bold text-gray-700 mb-1.5 tracking-wide">Email</label>
                        <div class="relative">
                            <span class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-400 pointer-events-none">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                </svg>
                            </span>
                            <input type="email" name="email" value="{{ old('email') }}" required
                                   placeholder="nama@email.com"
                                   class="form-input">
                        </div>
                    </div>

                    {{-- Password --}}
                    <div class="fu-4">
                        <label class="block text-xs font-bold text-gray-700 mb-1.5 tracking-wide">Password</label>
                        <div class="pw-wrap">
                            <span class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-400 z-10 pointer-events-none">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                                </svg>
                            </span>
                            <input type="password" name="password" id="pw" required
                                   placeholder="••••••••"
                                   class="form-input" style="padding-right:42px;">
                            <button type="button" class="pw-toggle" onclick="togglePw()" tabindex="-1">
                                <svg id="eye-icon" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                </svg>
                            </button>
                        </div>
                    </div>

                    {{-- Remember --}}
                    <div class="fu-4 flex items-center gap-2">
                        <input type="checkbox" name="remember" id="remember"
                               class="w-4 h-4 rounded border-gray-300 cursor-pointer accent-[#1a3a6b]">
                        <label for="remember" class="text-sm text-gray-500 cursor-pointer select-none">Ingat saya di perangkat ini</label>
                    </div>

                    {{-- Submit --}}
                    <div class="fu-5 pt-1">
                        <button type="submit" class="btn-submit">
                            <span class="flex items-center justify-center gap-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"/>
                                </svg>
                                Masuk
                            </span>
                        </button>
                    </div>
                </form>

                <p class="text-center text-sm text-gray-400 mt-6">
                    Belum punya akun?
                    <a href="{{ route('register') }}" class="text-[#1a3a6b] font-bold hover:underline ml-1">Daftar Sekarang →</a>
                </p>
            </div>

            {{-- Back to beranda --}}
            <p class="text-center mt-5">
                <a href="{{ route('beranda') }}" class="text-xs text-gray-400 hover:text-gray-600 transition flex items-center justify-center gap-1.5">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                    </svg>
                    Kembali ke Beranda
                </a>
            </p>
        </div>
    </div>
</div>

<script>
function togglePw() {
    const input = document.getElementById('pw');
    input.type = input.type === 'password' ? 'text' : 'password';
}
</script>

</body>
</html>