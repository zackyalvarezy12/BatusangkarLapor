<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Daftar — BatusangkarLapor</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800;900&family=DM+Serif+Display:ital@0;1&display=swap" rel="stylesheet">
    <style>
        * { font-family: 'Plus Jakarta Sans', sans-serif; }
        body { min-height: 100vh; margin: 0; }

        .register-wrapper { display: flex; min-height: 100vh; }
        @media (max-width: 1023px) { .register-wrapper { flex-direction: column; } }

        .panel-left {
            background: linear-gradient(155deg, #0f2654 0%, #1a3a6b 45%, #1e4d8c 80%, #0f3460 100%);
            position: relative; overflow: hidden;
        }
        .panel-left::before {
            content: ''; position: absolute; inset: 0;
            background:
                radial-gradient(ellipse 80% 60% at 80% 20%, rgba(245,158,11,.18) 0%, transparent 55%),
                radial-gradient(ellipse 60% 60% at 10% 90%, rgba(99,179,237,.12) 0%, transparent 55%);
            pointer-events: none;
        }
        .panel-left::after {
            content: ''; position: absolute; inset: 0;
            background-image:
                linear-gradient(rgba(255,255,255,.04) 1px, transparent 1px),
                linear-gradient(90deg, rgba(255,255,255,.04) 1px, transparent 1px);
            background-size: 60px 60px; pointer-events: none;
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
        .fu-2 { animation: fadeUp .6s .08s cubic-bezier(.22,.61,.36,1) both; }
        .fu-3 { animation: fadeUp .6s .16s cubic-bezier(.22,.61,.36,1) both; }
        .fu-4 { animation: fadeUp .6s .24s cubic-bezier(.22,.61,.36,1) both; }
        .fu-5 { animation: fadeUp .6s .32s cubic-bezier(.22,.61,.36,1) both; }
        .fu-6 { animation: fadeUp .6s .40s cubic-bezier(.22,.61,.36,1) both; }
        .fu-7 { animation: fadeUp .6s .48s cubic-bezier(.22,.61,.36,1) both; }

        .form-input {
            width: 100%;
            border: 1.5px solid #e5e7eb;
            border-radius: 12px;
            padding: 10px 14px 10px 40px;
            font-size: .8125rem;
            color: #1f2937;
            background: #f9fafb;
            transition: border-color .2s, background .2s, box-shadow .2s;
            outline: none;
            font-family: inherit;
            box-sizing: border-box;
        }
        .form-input:focus {
            border-color: #1a3a6b;
            background: #fff;
            box-shadow: 0 0 0 3px rgba(26,58,107,.1);
        }
        .form-input::placeholder { color: #9ca3af; }
        .form-input.has-right  { padding-right: 40px; }
        .form-input.error-field { border-color: #f87171; background: #fff5f5; }
        select.form-input { padding-right: 36px; appearance: none; cursor: pointer; }
        textarea.form-input { padding-top: 9px; padding-bottom: 9px; }

        .pw-wrap { position: relative; }
        .pw-toggle {
            position: absolute; right: 12px; top: 50%; transform: translateY(-50%);
            cursor: pointer; color: #9ca3af; transition: color .15s;
            background: none; border: none; padding: 0; line-height: 0;
        }
        .pw-toggle:hover { color: #1a3a6b; }

        .btn-submit {
            width: 100%;
            background: linear-gradient(135deg, #1a3a6b, #2352a0);
            color: white; font-weight: 800; font-size: .9rem;
            padding: 13px; border-radius: 14px; border: none;
            cursor: pointer;
            transition: transform .2s, box-shadow .2s;
            box-shadow: 0 6px 20px rgba(26,58,107,.35);
            font-family: inherit;
            display: flex; align-items: center; justify-content: center; gap: 8px;
        }
        .btn-submit:hover { transform: translateY(-2px); box-shadow: 0 10px 28px rgba(26,58,107,.4); }
        .btn-submit:active { transform: translateY(0); }

        @keyframes bob  { 0%,100%{transform:translateY(0)} 50%{transform:translateY(-8px)} }
        @keyframes bob2 { 0%,100%{transform:translateY(0)} 50%{transform:translateY(-5px)} }
        .bob1 { animation: bob  4s ease-in-out infinite; }
        .bob2 { animation: bob2 4.8s ease-in-out infinite .6s; }
    </style>
</head>
<body>

<div class="register-wrapper">

    {{-- ═══ LEFT PANEL ═══ --}}
    <div class="panel-left hidden lg:flex lg:w-[40%] xl:w-[38%] flex-col justify-between p-12 relative z-10">

        <div class="orb-a absolute top-[10%] right-[8%] w-80 h-80 rounded-full"
             style="background:radial-gradient(circle,rgba(245,158,11,.13) 0%,transparent 70%);"></div>
        <div class="orb-b absolute bottom-[10%] left-[5%] w-56 h-56 rounded-full"
             style="background:radial-gradient(circle,rgba(99,179,237,.12) 0%,transparent 70%);"></div>

        {{-- Logo --}}
        <a href="{{ route('beranda') }}" class="inline-flex items-center gap-3 group relative z-10">
            <div class="w-11 h-11 rounded-xl flex items-center justify-center transition group-hover:bg-white/15"
                 style="background:rgba(255,255,255,.1);border:1px solid rgba(255,255,255,.2);">
                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-2 10v-5a1 1 0 00-1-1h-2a1 1 0 00-1 1v5m4 0H9"/>
                </svg>
            </div>
            <div>
                <div class="text-white font-black text-sm">BatusangkarLapor</div>
                <div class="text-[10px]" style="color:rgba(255,255,255,.5)">Kabupaten Tanah Datar</div>
            </div>
        </a>

        {{-- Middle content --}}
        <div class="space-y-7 relative z-10">
            <div>
                <div class="inline-flex items-center gap-2 rounded-full px-3 py-1.5 mb-5"
                     style="background:rgba(255,255,255,.1);border:1px solid rgba(255,255,255,.2);">
                    <span class="w-1.5 h-1.5 bg-amber-400 rounded-full animate-pulse"></span>
                    <span class="text-[11px] font-semibold uppercase tracking-widest"
                          style="color:rgba(255,255,255,.7)">Bergabung Sekarang</span>
                </div>
                <h2 class="text-white leading-[1.15] mb-3"
                    style="font-size:2.3rem;font-family:'DM Serif Display',serif;">
                    Jadilah bagian<br>
                    dari perubahan<br>
                    <em style="background:linear-gradient(135deg,#f59e0b,#fb923c);-webkit-background-clip:text;-webkit-text-fill-color:transparent;background-clip:text;">nyata.</em>
                </h2>
                <p class="text-sm leading-relaxed max-w-xs" style="color:rgba(147,197,253,.7)">
                    Buat akun gratis dan mulai laporkan masalah di sekitar Anda.
                    Petugas wilayah siap menangani setiap laporan.
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
                        <path d="M18 16 Q17 6 32 5 Q47 6 46 16" fill="#059669"/>
                        <rect x="16" y="32" width="32" height="30" rx="12" fill="#a7f3d0" stroke="#6ee7b7" stroke-width="1.5"/>
                        <rect x="24" y="40" width="16" height="10" rx="4" fill="white" opacity=".5"/>
                        <rect x="18" y="59" width="12" height="24" rx="6" fill="#065f46"/>
                        <rect x="34" y="59" width="12" height="24" rx="6" fill="#065f46"/>
                        <rect x="48" y="28" width="13" height="9" rx="4.5" fill="#a7f3d0" stroke="#6ee7b7" stroke-width="1.5"/>
                        <rect x="3"  y="32" width="13" height="9" rx="4.5" fill="#a7f3d0" stroke="#6ee7b7" stroke-width="1.5"/>
                    </svg>
                </div>
                <div class="bob2 mb-4">
                    <div class="bg-amber-400 rounded-2xl rounded-bl-sm px-4 py-2.5"
                         style="box-shadow:0 8px 20px rgba(245,158,11,.35);">
                        <p class="text-gray-900 font-black text-xs">Akun baru? 🎉</p>
                        <p class="text-gray-700 text-[10px] mt-0.5">Yuk mulai laporan pertamamu!</p>
                    </div>
                </div>
            </div>

            {{-- Feature list --}}
            <div class="space-y-3">
                @foreach([
                    ['icon'=>'M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z',
                     'text'=>'Laporan langsung ke petugas wilayah Anda'],
                    ['icon'=>'M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9',
                     'text'=>'Notifikasi perkembangan laporan real-time'],
                    ['icon'=>'M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z',
                     'text'=>'Chat langsung dengan petugas penanganan'],
                ] as $f)
                <div class="flex items-center gap-3">
                    <div class="w-7 h-7 rounded-lg flex items-center justify-center flex-shrink-0"
                         style="background:rgba(255,255,255,.1);">
                        <svg class="w-3.5 h-3.5 text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $f['icon'] }}"/>
                        </svg>
                    </div>
                    <span class="text-xs" style="color:rgba(147,197,253,.75)">{{ $f['text'] }}</span>
                </div>
                @endforeach
            </div>
        </div>

        {{-- Bottom dots --}}
        <div class="flex items-center gap-2 relative z-10">
            <div class="w-2 h-2 rounded-full" style="background:rgba(255,255,255,.2)"></div>
            <div class="w-2 h-2 bg-amber-400 rounded-full"></div>
            <div class="w-2 h-2 rounded-full" style="background:rgba(255,255,255,.2)"></div>
            <span class="text-[11px] font-medium ml-2" style="color:rgba(255,255,255,.4)">Buat Akun Anda</span>
        </div>
    </div>

    {{-- ═══ RIGHT PANEL ═══ --}}
    <div class="flex-1 flex items-center justify-center bg-[#f3f6fc] px-5 py-10 overflow-y-auto">
        <div class="w-full max-w-lg">

            {{-- Mobile logo --}}
            <div class="lg:hidden text-center mb-6">
                <a href="{{ route('beranda') }}" class="inline-flex items-center gap-2">
                    <div class="w-10 h-10 rounded-xl bg-[#1a3a6b] flex items-center justify-center">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-2 10v-5a1 1 0 00-1-1h-2a1 1 0 00-1 1v5m4 0H9"/>
                        </svg>
                    </div>
                    <span class="font-black text-[#1a3a6b]">BatusangkarLapor</span>
                </a>
            </div>

            {{-- Card --}}
            <div class="fu-1 bg-white rounded-3xl p-7 border border-gray-100"
                 style="box-shadow:0 20px 60px rgba(100,116,139,.15);">

                <div class="fu-2 mb-6">
                    <h1 class="text-2xl font-black text-gray-900 leading-tight mb-1"
                        style="font-family:'DM Serif Display',serif;">
                        Buat Akun Baru
                    </h1>
                    <p class="text-gray-400 text-sm">Daftarkan diri sebagai warga Kabupaten Tanah Datar</p>
                </div>

                {{-- Errors --}}
                @if($errors->any())
                <div class="fu-2 bg-red-50 border border-red-200 text-red-700 rounded-xl px-4 py-3 mb-5 text-sm flex items-start gap-2">
                    <svg class="w-4 h-4 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <ul class="space-y-0.5">
                        @foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach
                    </ul>
                </div>
                @endif

                <form method="POST" action="{{ route('register.submit') }}" class="space-y-4">
                    @csrf

                    {{-- Nama --}}
                    <div class="fu-3">
                        <label class="block text-xs font-bold text-gray-700 mb-1.5 tracking-wide">
                            Nama Lengkap <span class="text-red-400">*</span>
                        </label>
                        <div class="relative">
                            <span class="absolute left-3.5 top-1/2 -translate-y-1/2 text-gray-400 pointer-events-none">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                </svg>
                            </span>
                            <input type="text" name="name" value="{{ old('name') }}" required
                                   placeholder="Masukkan nama lengkap"
                                   class="form-input {{ $errors->has('name') ? 'error-field' : '' }}">
                        </div>
                    </div>

                    {{-- Email --}}
                    <div class="fu-3">
                        <label class="block text-xs font-bold text-gray-700 mb-1.5 tracking-wide">
                            Alamat Email <span class="text-red-400">*</span>
                        </label>
                        <div class="relative">
                            <span class="absolute left-3.5 top-1/2 -translate-y-1/2 text-gray-400 pointer-events-none">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                </svg>
                            </span>
                            <input type="email" name="email" value="{{ old('email') }}" required
                                   placeholder="nama@email.com"
                                   class="form-input {{ $errors->has('email') ? 'error-field' : '' }}">
                        </div>
                    </div>

                    {{-- No HP + Wilayah --}}
                    <div class="fu-4 grid grid-cols-1 sm:grid-cols-2 gap-4">

                        {{-- No HP --}}
                        <div>
                            <label class="block text-xs font-bold text-gray-700 mb-1.5 tracking-wide">No. HP / WhatsApp</label>
                            <div class="relative">
                                <span class="absolute left-3.5 top-1/2 -translate-y-1/2 text-gray-400 pointer-events-none">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                              d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                                    </svg>
                                </span>
                                <input type="text" name="no_hp" value="{{ old('no_hp') }}"
                                       placeholder="08xx-xxxx-xxxx"
                                       class="form-input">
                            </div>
                        </div>

                        {{-- Wilayah --}}
                        <div>
                            <label class="block text-xs font-bold text-gray-700 mb-1.5 tracking-wide">
                                Wilayah <span class="text-red-400">*</span>
                            </label>
                            <div class="relative">
                                <span class="absolute left-3.5 top-1/2 -translate-y-1/2 text-gray-400 pointer-events-none z-10">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                              d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    </svg>
                                </span>
                                <select name="wilaya_id" required
                                        class="form-input {{ $errors->has('wilaya_id') ? 'error-field' : '' }}">
                                    <option value="">— Pilih wilayah —</option>
                                    @foreach($wilayas as $w)
                                    <option value="{{ $w->id }}" {{ old('wilaya_id') == $w->id ? 'selected' : '' }}>
                                        {{ $w->nama }}
                                    </option>
                                    @endforeach
                                </select>
                                <span class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 pointer-events-none">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                                    </svg>
                                </span>
                            </div>
                        </div>
                    </div>

                    {{-- Alamat --}}
                    <div class="fu-4">
                        <label class="block text-xs font-bold text-gray-700 mb-1.5 tracking-wide">Alamat Lengkap</label>
                        <div class="relative">
                            <span class="absolute left-3.5 top-3 text-gray-400 pointer-events-none">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                                </svg>
                            </span>
                            <textarea name="alamat" rows="2"
                                      placeholder="Jalan, RT/RW, Kelurahan/Nagari..."
                                      class="form-input resize-none">{{ old('alamat') }}</textarea>
                        </div>
                    </div>

                    {{-- Password --}}
                    <div class="fu-5 grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-bold text-gray-700 mb-1.5 tracking-wide">
                                Password <span class="text-red-400">*</span>
                            </label>
                            <div class="pw-wrap">
                                <span class="absolute left-3.5 top-1/2 -translate-y-1/2 text-gray-400 z-10 pointer-events-none">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                              d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                                    </svg>
                                </span>
                                <input type="password" name="password" id="pw1" required
                                       placeholder="Min. 8 karakter"
                                       class="form-input has-right {{ $errors->has('password') ? 'error-field' : '' }}">
                                <button type="button" class="pw-toggle" onclick="togglePw('pw1')" tabindex="-1">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                              d="M15 12a3 3 0 11-6 0 3 3 0 016 0z M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                    </svg>
                                </button>
                            </div>
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-gray-700 mb-1.5 tracking-wide">
                                Konfirmasi Password <span class="text-red-400">*</span>
                            </label>
                            <div class="pw-wrap">
                                <span class="absolute left-3.5 top-1/2 -translate-y-1/2 text-gray-400 z-10 pointer-events-none">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                              d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                                    </svg>
                                </span>
                                <input type="password" name="password_confirmation" id="pw2" required
                                       placeholder="Ulangi password"
                                       class="form-input has-right">
                                <button type="button" class="pw-toggle" onclick="togglePw('pw2')" tabindex="-1">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                              d="M15 12a3 3 0 11-6 0 3 3 0 016 0z M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </div>

                    {{-- Submit --}}
                    <div class="fu-6 pt-1">
                        <button type="submit" class="btn-submit">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                      d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/>
                            </svg>
                            Buat Akun Sekarang
                        </button>
                    </div>
                </form>

                <p class="fu-7 text-center text-sm text-gray-400 mt-5">
                    Sudah punya akun?
                    <a href="{{ route('login') }}" class="text-[#1a3a6b] font-bold hover:underline ml-1">Masuk di sini →</a>
                </p>
            </div>

            {{-- Back --}}
            <p class="text-center mt-5">
                <a href="{{ route('beranda') }}"
                   class="text-xs text-gray-400 hover:text-gray-600 transition flex items-center justify-center gap-1.5">
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
function togglePw(id) {
    const input = document.getElementById(id);
    input.type = input.type === 'password' ? 'text' : 'password';
}
</script>

</body>
</html>