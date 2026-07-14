@extends('layouts.app')
@section('title', 'Lacak Laporan')

@section('content')

<style>
@import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800;900&family=DM+Serif+Display:ital@0;1&display=swap');
* { font-family: 'Plus Jakarta Sans', sans-serif; }
.font-serif { font-family: 'DM Serif Display', serif; }

@keyframes fadeUp {
    from { opacity:0; transform:translateY(18px); }
    to   { opacity:1; transform:translateY(0); }
}
.fu   { animation: fadeUp .5s cubic-bezier(.22,.61,.36,1) both; }
.fu-2 { animation-delay:.08s; }
.fu-3 { animation-delay:.16s; }
.fu-4 { animation-delay:.24s; }

/* Search */
.search-input {
    flex: 1;
    border: 1.5px solid #e5e7eb;
    border-radius: 14px;
    padding: 13px 18px;
    font-size: 14px;
    font-weight: 500;
    color: #1e293b;
    background: #f8faff;
    outline: none;
    transition: all .25s;
    font-family: inherit;
}
.search-input:focus {
    border-color: #1a3a6b;
    background: #fff;
    box-shadow: 0 0 0 4px rgba(26,58,107,.09);
}
.search-input::placeholder { color: #94a3b8; font-weight: 400; }

/* Status badges */
.status-badge {
    display: inline-flex; align-items: center; gap: 5px;
    padding: 5px 12px; border-radius: 999px;
    font-size: 11px; font-weight: 800; letter-spacing: .03em;
}
.badge-yellow { background:#fef9c3; color:#a16207; border:1px solid #fde68a; }
.badge-blue   { background:#dbeafe; color:#1e40af; border:1px solid #bfdbfe; }
.badge-green  { background:#dcfce7; color:#15803d; border:1px solid #bbf7d0; }
.badge-red    { background:#fee2e2; color:#b91c1c; border:1px solid #fecaca; }

/* Timeline */
.tl-dot {
    width: 13px; height: 13px; border-radius: 50%;
    background: #e2e8f0; border: 2px solid #e2e8f0;
    flex-shrink: 0; margin-top: 3px; z-index: 1;
    transition: all .3s;
}
.tl-dot.active {
    background: #1a3a6b; border-color: #1a3a6b;
    box-shadow: 0 0 0 4px rgba(26,58,107,.13);
}
.tl-dot.done {
    background: #10b981; border-color: #10b981;
    box-shadow: 0 0 0 4px rgba(16,185,129,.12);
}
.tl-line {
    width: 2px; flex: 1; min-height: 16px;
    background: linear-gradient(to bottom, #e2e8f0, #f1f5f9);
    margin: 3px auto;
}

/* Progress steps */
.progress-wrap { display:flex; gap:0; margin: 1.25rem 0 0; }
.p-step {
    flex:1; display:flex; flex-direction:column; align-items:center; gap:.35rem;
    position: relative;
}
.p-step::after {
    content:''; position:absolute; top:11px; left:60%; right:-40%;
    height:2px; background:#e5e7eb; z-index:0;
}
.p-step:last-child::after { display:none; }
.p-step.done::after  { background:linear-gradient(90deg,#10b981,#e5e7eb); }
.p-step.active::after { background:linear-gradient(90deg,#1a3a6b,#e5e7eb); }
.p-dot {
    width:22px; height:22px; border-radius:50%; z-index:1;
    border:2px solid #e5e7eb; background:#fff;
    display:flex; align-items:center; justify-content:center;
    font-size:9px; font-weight:800; color:#94a3b8; transition:all .3s;
}
.p-dot.done  { background:#10b981; border-color:#10b981; color:#fff; }
.p-dot.active{ background:#1a3a6b; border-color:#1a3a6b; color:#fff; box-shadow:0 0 0 4px rgba(26,58,107,.16); }
.p-lbl { font-size:9px; font-weight:700; color:#94a3b8; letter-spacing:.02em; }
.p-lbl.done   { color:#10b981; }
.p-lbl.active { color:#1a3a6b; }

/* Hover cards */
.hov-card {
    background:#f8faff; border:1px solid rgba(26,58,107,.07); border-radius:16px; padding:1rem 1.25rem;
    transition: all .25s;
}
.hov-card:hover { background:#fff; border-color:rgba(26,58,107,.14); box-shadow:0 4px 16px rgba(26,58,107,.07); }

/* Step guide */
.step-guide {
    display:flex; align-items:flex-start; gap:.875rem;
    padding:1rem 1.25rem; background:#f8faff;
    border:1px solid rgba(26,58,107,.06); border-radius:16px;
    transition: all .25s;
}
.step-guide:hover { background:#fff; border-color:rgba(26,58,107,.14); box-shadow:0 4px 14px rgba(26,58,107,.07); }

/* Stat card */
.stat-card {
    background:#f8faff; border:1px solid rgba(26,58,107,.07); border-radius:16px; padding:1rem 1.25rem;
    transition:all .25s;
}
.stat-card:hover { background:#fff; border-color:rgba(26,58,107,.15); box-shadow:0 4px 16px rgba(26,58,107,.08); transform:translateY(-1px); }
</style>

{{-- ─── NAVBAR ─── --}}
<nav class="sticky top-0 z-40 bg-white/95 backdrop-blur-xl border-b border-gray-100/80 shadow-[0_1px_12px_rgba(0,0,0,.06)]">
    <div class="max-w-2xl mx-auto px-4 py-3.5 flex items-center gap-3">
        <a href="{{ route('beranda') }}"
           class="w-9 h-9 bg-gray-100 hover:bg-gray-200 rounded-xl flex items-center justify-center transition flex-shrink-0 hover:-translate-x-0.5">
            <svg class="w-4 h-4 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
            </svg>
        </a>
        <div class="flex items-center gap-2.5">
            <div class="w-8 h-8 rounded-xl flex items-center justify-center flex-shrink-0 shadow-sm"
                 style="background:linear-gradient(135deg,#1a3a6b,#2352a0);">
                <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                </svg>
            </div>
            <div>
                <div class="font-bold text-gray-800 text-sm leading-tight">Lacak Laporan</div>
                <div class="text-gray-400 text-[10px]">BatusangkarLapor · Tanah Datar</div>
            </div>
        </div>
        @auth
        <a href="{{ match(auth()->user()->role) { 'admin' => route('admin.dashboard'), 'petugas' => route('petugas.dashboard'), default => route('masyarakat.dashboard') } }}"
           class="ml-auto text-xs font-bold text-[#1a3a6b] bg-[#1a3a6b]/6 hover:bg-[#1a3a6b]/10 px-3 py-1.5 rounded-lg transition">
            Dashboard
        </a>
        @endauth
    </div>
</nav>

<div class="min-h-screen bg-[#f3f6fc]">
<div class="max-w-2xl mx-auto px-4 py-8 space-y-4">

    {{-- ─── SEARCH CARD ─── --}}
    <div class="fu bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden">
        {{-- Accent bar --}}
        <div class="h-1" style="background:linear-gradient(90deg,#1a3a6b,#2352a0,#f59e0b,#fb923c);"></div>

        <div class="p-7">
            <div class="flex flex-col items-center text-center mb-7">
                <div class="w-14 h-14 rounded-2xl flex items-center justify-center mb-4 shadow-lg"
                     style="background:linear-gradient(135deg,#1a3a6b,#2352a0); box-shadow:0 10px 28px rgba(26,58,107,.3);">
                    <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                </div>
                <h1 class="font-serif text-2xl font-bold text-gray-900 mb-1">Lacak <em>Laporan</em> Anda</h1>
                <p class="text-gray-400 text-sm max-w-xs leading-relaxed">Masukkan token pelacak untuk melihat status terkini</p>
            </div>
            <form method="GET" action="{{ route('lacak') }}" class="flex gap-2.5">
                <input type="text" name="token" value="{{ $token ?? '' }}"
                       placeholder="Masukkan token pelacak (contoh: ABCD-EFGH-IJKL)"
                       class="search-input">
                <button type="submit"
                        class="flex-shrink-0 flex items-center gap-2 text-white font-bold px-5 py-3 rounded-2xl text-sm transition-all hover:-translate-y-0.5 hover:shadow-lg"
                        style="background:linear-gradient(135deg,#1a3a6b,#2352a0); box-shadow:0 4px 14px rgba(26,58,107,.35);">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                    Lacak
                </button>
            </form>

            {{-- Tips --}}
            <div class="flex items-center gap-2 mt-4 justify-center flex-wrap">
                <span class="text-[11px] text-gray-400">Format token pelacak:</span>
                <code class="text-[11px] font-bold text-amber-700 bg-amber-50 px-2 py-0.5 rounded-lg">ABCD-EFGH-IJKL</code>
            </div>
        </div>
    </div>

    {{-- ─── TIDAK DITEMUKAN ─── --}}
    @if(isset($notFound) && $notFound)
    <div class="fu fu-2 bg-white rounded-3xl border border-red-100 shadow-sm overflow-hidden">
        <div class="h-1 bg-red-400"></div>
        <div class="p-8 text-center">
            <div class="w-14 h-14 bg-red-50 border border-red-100 rounded-2xl flex items-center justify-center mx-auto mb-4">
                <svg class="w-7 h-7 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
            <p class="font-bold text-gray-800 mb-1.5">Laporan Tidak Ditemukan</p>
            <p class="text-gray-400 text-sm leading-relaxed">
                Token <code class="font-mono font-bold text-gray-700 bg-gray-100 px-2 py-0.5 rounded-lg text-[13px]">{{ $token }}</code>
                tidak terdaftar dalam sistem.
            </p>
            <p class="text-gray-400 text-xs mt-1.5">Pastikan kode atau token yang Anda masukkan sudah benar.</p>
        </div>
    </div>
    @endif

    {{-- ─── HASIL LAPORAN ─── --}}
    @if($pengaduan)
    @php
        $b = $pengaduan->status_badge;
        $stepOrder = ['menunggu'=>0,'diproses'=>1,'selesai'=>2];
        $curStep   = $stepOrder[$pengaduan->status] ?? 0;
        $isDitolak = $pengaduan->status === 'ditolak';
    @endphp

    <div class="fu fu-2 bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden">

        {{-- ── Header biru ── --}}
        <div class="relative overflow-hidden p-7" style="background:linear-gradient(135deg,#0f2654,#1a3a6b 60%,#1e4d8c);">
            <div class="absolute top-0 right-0 w-56 h-56 rounded-full pointer-events-none" style="background:radial-gradient(circle,rgba(245,158,11,.13),transparent 70%);transform:translate(30%,-30%);"></div>
            <div class="absolute bottom-0 left-0 w-40 h-40 rounded-full pointer-events-none" style="background:radial-gradient(circle,rgba(96,165,250,.1),transparent 70%);transform:translate(-30%,30%);"></div>

            <div class="relative z-10">
                {{-- Top row: badge + kode --}}
                <div class="flex items-start justify-between gap-3 flex-wrap mb-4">
                    <span class="status-badge
                        {{ $b['color']==='yellow' ? 'badge-yellow' : '' }}
                        {{ $b['color']==='blue'   ? 'badge-blue'   : '' }}
                        {{ $b['color']==='green'  ? 'badge-green'  : '' }}
                        {{ $b['color']==='red'    ? 'badge-red'    : '' }}">
                        <span class="w-1.5 h-1.5 rounded-full
                            {{ $b['color']==='yellow' ? 'bg-amber-500 animate-pulse' : '' }}
                            {{ $b['color']==='blue'   ? 'bg-blue-500'  : '' }}
                            {{ $b['color']==='green'  ? 'bg-green-500' : '' }}
                            {{ $b['color']==='red'    ? 'bg-red-500'   : '' }}">
                        </span>
                        {{ $b['label'] }}
                    </span>
                    <div class="text-right">
                        <p class="text-blue-300/60 text-[9px] uppercase tracking-widest font-bold mb-1">Kode Laporan</p>
                        <code class="font-mono font-black text-white text-sm bg-white/12 border border-white/20 px-3 py-1.5 rounded-xl">{{ $pengaduan->kode_laporan }}</code>
                    </div>
                </div>

                <h2 class="text-xl font-black text-white leading-snug mb-1">{{ $pengaduan->judul }}</h2>
                <div class="flex items-center gap-2 flex-wrap text-sm text-blue-300/75">
                    <span>{{ $pengaduan->kategori->nama ?? '-' }}</span>
                    @if($pengaduan->wilaya)
                        <span class="text-blue-400/40">·</span>
                        <span>{{ $pengaduan->wilaya->nama }}</span>
                    @endif
                    @if($pengaduan->is_anonim)
                        <span class="text-[10px] font-bold bg-white/10 text-white/60 px-2 py-0.5 rounded-full border border-white/15 ml-1">Anonim</span>
                    @endif
                    <div class="progress-wrap">
                </div>

                {{-- Progress tracker (hanya kalau bukan ditolak) --}}
                @if(!$isDitolak)
                    @foreach([['key'=>'menunggu','label'=>'Menunggu'],['key'=>'diproses','label'=>'Diproses'],['key'=>'selesai','label'=>'Selesai']] as $si => $st)
                    <div class="p-step {{ $si < $curStep ? 'done' : ($si === $curStep ? 'active' : '') }}">
                        <div class="p-dot {{ $si < $curStep ? 'done' : ($si === $curStep ? 'active' : '') }}">
                            @if($si < $curStep) ✓ @else {{ $si+1 }} @endif
                        </div>
                        <span class="p-lbl {{ $si < $curStep ? 'done' : ($si === $curStep ? 'active' : '') }}">{{ $st['label'] }}</span>
                    </div>
                    @endforeach
                </div>
                @endif
            </div>
        </div>

        {{-- ── Stats row ── --}}
        <div class="grid grid-cols-2 sm:grid-cols-4 divide-x divide-y sm:divide-y-0 divide-gray-100 border-b border-gray-100">
            @foreach([
                ['icon'=>'M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z',
                 'label'=>'Tanggal Lapor',  'value'=>$pengaduan->created_at->format('d M Y')],
                ['icon'=>'M17.657 16.657L13.414 20.9a2 2 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0zM15 11a3 3 0 11-6 0 3 3 0 016 0z',
                 'label'=>'Wilayah',        'value'=>$pengaduan->wilaya->nama ?? '-'],
                ['icon'=>'M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z',
                 'label'=>'Petugas',        'value'=>$pengaduan->petugas->name ?? 'Belum ditugaskan'],
                ['icon'=>'M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z',
                 'label'=>'Terakhir Update','value'=>$pengaduan->updated_at->diffForHumans()],
            ] as $stat)
            <div class="px-5 py-4 text-center hover:bg-[#f8faff] transition-colors">
                <div class="w-7 h-7 rounded-lg flex items-center justify-center mx-auto mb-2"
                     style="background:rgba(26,58,107,.07);">
                    <svg class="w-3.5 h-3.5 text-[#1a3a6b]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $stat['icon'] }}"/>
                    </svg>
                </div>
                <p class="text-[9px] text-gray-400 uppercase tracking-wider font-bold mb-0.5">{{ $stat['label'] }}</p>
                <p class="font-bold text-gray-700 text-sm leading-tight">{{ $stat['value'] }}</p>
            </div>
            @endforeach
        </div>

        {{-- ── Alasan tolak ── --}}
        @if($isDitolak && $pengaduan->alasan_tolak)
        <div class="mx-6 mt-5 p-4 bg-red-50 border border-red-100 rounded-2xl flex gap-3">
            <div class="w-8 h-8 bg-red-100 rounded-xl flex items-center justify-center flex-shrink-0">
                <svg class="w-4 h-4 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"/>
                </svg>
            </div>
            <div>
                <p class="text-xs font-black text-red-700 mb-1 uppercase tracking-wide">Alasan Penolakan</p>
                <p class="text-red-600 text-sm leading-relaxed">{{ $pengaduan->alasan_tolak }}</p>
            </div>
        </div>
        @endif

        {{-- ── Riwayat ── --}}
        <div class="p-6 pt-5">
            <div class="flex items-center gap-2.5 mb-5">
                <div class="w-8 h-8 rounded-xl flex items-center justify-center"
                     style="background:rgba(26,58,107,.08);">
                    <svg class="w-4 h-4 text-[#1a3a6b]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <h3 class="font-black text-gray-800 text-sm">Riwayat Perkembangan</h3>
                @php $histories = $pengaduan->histories; @endphp
                @if($histories->count() > 0)
                <span class="ml-auto text-[11px] font-bold text-[#1a3a6b] bg-[#1a3a6b]/7 px-2.5 py-1 rounded-lg">
                    {{ $histories->count() }} update
                </span>
                @endif
            </div>

            @if($histories->isEmpty())
            <div class="text-center py-10 bg-[#f8faff] rounded-2xl border border-gray-100">
                <div class="w-12 h-12 bg-gray-100 rounded-2xl flex items-center justify-center mx-auto mb-3">
                    <svg class="w-6 h-6 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <p class="text-gray-400 text-sm font-medium">Belum ada riwayat perkembangan</p>
                <p class="text-gray-300 text-xs mt-1">Laporan Anda sedang menunggu ditinjau</p>
            </div>
            @else
            <div class="space-y-0">
                @foreach($histories as $h)
                <div class="flex gap-3.5">
                    {{-- Timeline --}}
                    <div class="flex flex-col items-center w-4 flex-shrink-0">
                        <div class="tl-dot {{ $loop->first ? 'active' : 'done' }}">
                        </div>
                        @if(!$loop->last)
                        <div class="tl-line"></div>
                        @endif
                    </div>

                    {{-- Content --}}
                    <div class="pb-4 flex-1">
                        <div class="hov-card">
                            {{-- Transisi status --}}
                            <div class="flex items-center gap-2 flex-wrap mb-2">
                                @if($h->status_lama)
                                <span class="text-[11px] font-bold text-gray-400 capitalize bg-gray-100 px-2 py-0.5 rounded-md">{{ $h->status_lama }}</span>
                                <svg class="w-3 h-3 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"/>
                                </svg>
                                @endif
                                <span class="text-[11px] font-black capitalize px-2 py-0.5 rounded-md
                                    {{ str_contains($h->status_baru,'selesai')  ? 'bg-green-100 text-green-700' :
                                       (str_contains($h->status_baru,'ditolak') ? 'bg-red-100 text-red-700' :
                                       (str_contains($h->status_baru,'diproses')? 'bg-blue-100 text-blue-700' :
                                        'bg-amber-100 text-amber-700')) }}">
                                    {{ $h->status_baru }}
                                </span>
                                @if($loop->first)
                                <span class="ml-auto text-[10px] font-bold text-[#1a3a6b] bg-[#1a3a6b]/8 px-2 py-0.5 rounded-md">Terbaru</span>
                                @endif
                            </div>

                            @if($h->keterangan)
                            <p class="text-gray-600 text-xs leading-relaxed mb-2.5 pl-3 border-l-2 border-[#1a3a6b]/20">{{ $h->keterangan }}</p>
                            @endif

                            <div class="flex items-center gap-2 flex-wrap">
                                @if($h->user)
                                <img src="{{ $h->user->avatar_url }}" class="w-5 h-5 rounded-lg object-cover border border-gray-200" alt="">
                                <span class="text-gray-500 text-xs font-bold">{{ $h->user->name }}</span>
                                <span class="text-gray-200 text-xs">·</span>
                                @endif
                                <span class="text-gray-400 text-xs">{{ $h->created_at->format('d M Y, H:i') }}</span>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            @endif
        </div>
    </div>

    {{-- ── Token salin ── --}}
    <div class="fu fu-3 bg-white rounded-3xl border border-gray-100 shadow-sm p-5">
        <div class="flex items-center gap-3 flex-wrap">
            <div class="w-9 h-9 bg-[#1a3a6b]/8 rounded-xl flex items-center justify-center flex-shrink-0">
                <svg class="w-4 h-4 text-[#1a3a6b]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 5H6a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2v-1M8 5a2 2 0 002 2h2a2 2 0 002-2M8 5a2 2 0 012-2h2a2 2 0 012 2m0 0h2a2 2 0 012 2v3m2 4H10m0 0l3-3m-3 3l3 3"/>
                </svg>
            </div>
            <div class="flex-1 min-w-0">
                <p class="font-bold text-gray-700 text-sm">Token Pelacak</p>
                <p class="text-gray-400 text-xs mt-0.5">Bagikan token ini untuk melacak laporan tanpa perlu login</p>
            </div>
            <code class="font-mono text-xs font-bold text-[#1a3a6b] bg-[#1a3a6b]/6 border border-[#1a3a6b]/12 px-3 py-2 rounded-xl max-w-[150px] truncate">
                {{ $pengaduan->tracking_token ?? $pengaduan->kode_laporan }}
            </code>
            <button onclick="
                navigator.clipboard.writeText('{{ $pengaduan->tracking_token ?? $pengaduan->kode_laporan }}');
                this.innerHTML='<svg class=\'w-3.5 h-3.5\' fill=\'none\' stroke=\'currentColor\' viewBox=\'0 0 24 24\'><path stroke-linecap=\'round\' stroke-linejoin=\'round\' stroke-width=\'2.5\' d=\'M5 13l4 4L19 7\'/></svg> Tersalin!';
                this.classList.add('bg-green-500');
                setTimeout(()=>{this.innerHTML='Salin';this.classList.remove('bg-green-500');},2000);
            "
            class="flex items-center gap-1.5 text-xs font-bold text-white px-3.5 py-2 rounded-xl transition-all hover:-translate-y-0.5 flex-shrink-0"
            style="background:linear-gradient(135deg,#1a3a6b,#2352a0);">
                Salin
            </button>
        </div>
    </div>

    @endif

    {{-- ─── PANDUAN (hanya tampil kalau belum search) ─── --}}
    @if(!$pengaduan && !isset($notFound))

    {{-- Cara lacak --}}
    <div class="fu fu-2 bg-white rounded-3xl border border-gray-100 shadow-sm overflow-hidden">
        <div class="h-1" style="background:linear-gradient(90deg,#1a3a6b,#2352a0,#f59e0b,#fb923c);"></div>
        <div class="p-6">
            <div class="flex items-center gap-2.5 mb-5">
                <div class="w-8 h-8 bg-blue-50 rounded-xl flex items-center justify-center">
                    <svg class="w-4 h-4 text-[#1a3a6b]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <h3 class="font-black text-gray-800 text-sm">Cara Melacak Laporan</h3>
            </div>

            <div class="space-y-2.5">
                @foreach([
                    ['n'=>'1','title'=>'Kode Laporan',   'text'=>'Gunakan kode yang diberikan saat laporan dibuat, contoh: BL-2026-00001','c'=>'#1a3a6b'],
                    ['n'=>'2','title'=>'Token Pelacak',   'text'=>'Atau token unik yang tersedia di halaman detail laporan Anda','c'=>'#d97706'],
                    ['n'=>'3','title'=>'Lihat Status',    'text'=>'Klik Lacak untuk melihat status terkini dan seluruh riwayat perkembangan','c'=>'#059669'],
                ] as $s)
                <div class="step-guide">
                    <span class="w-7 h-7 rounded-xl flex items-center justify-center font-black text-[11px] text-white flex-shrink-0"
                          style="background:{{ $s['c'] }};">{{ $s['n'] }}</span>
                    <div>
                        <p class="font-bold text-gray-700 text-sm">{{ $s['title'] }}</p>
                        <p class="text-gray-400 text-xs leading-relaxed mt-0.5">{{ $s['text'] }}</p>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>

    {{-- Quick stats --}}
    @php
        $totalL = \App\Models\Pengaduan::count();
        $totalS = \App\Models\Pengaduan::where('status','selesai')->count();
        $totalP = \App\Models\Pengaduan::where('status','diproses')->count();
    @endphp
    <div class="fu fu-3 grid grid-cols-3 gap-3">
        @foreach([
            ['n'=>$totalL,'label'=>'Total Laporan','icon'=>'M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z','c'=>'#1a3a6b'],
            ['n'=>$totalS,'label'=>'Diselesaikan', 'icon'=>'M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z','c'=>'#059669'],
            ['n'=>$totalP,'label'=>'Diproses',     'icon'=>'M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z M15 12a3 3 0 11-6 0 3 3 0 016 0z','c'=>'#d97706'],
        ] as $s)
        <div class="stat-card">
            <div class="w-8 h-8 rounded-xl flex items-center justify-center mb-2.5" style="background:{{ $s['c'] }}15;">
                <svg class="w-4 h-4" style="color:{{ $s['c'] }};" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="{{ $s['icon'] }}"/>
                </svg>
            </div>
            <div class="text-xl font-black text-gray-800 leading-none">{{ number_format($s['n']) }}</div>
            <div class="text-[10px] text-gray-400 font-semibold mt-1.5 uppercase tracking-wide leading-tight">{{ $s['label'] }}</div>
        </div>
        @endforeach
    </div>

    @endif

</div>
</div>

@endsection