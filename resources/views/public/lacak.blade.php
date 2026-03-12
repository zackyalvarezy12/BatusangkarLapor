@extends('layouts.app')
@section('title', 'Lacak Laporan')

@section('content')

<style>
@import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800;900&family=DM+Serif+Display:ital@0;1&display=swap');
* { font-family: 'Plus Jakarta Sans', sans-serif; }

@keyframes fadeUp {
    from { opacity:0; transform:translateY(20px); }
    to   { opacity:1; transform:translateY(0); }
}
.fu { animation: fadeUp .5s cubic-bezier(.22,.61,.36,1) both; }
.fu-2 { animation-delay:.08s; }
.fu-3 { animation-delay:.16s; }
.fu-4 { animation-delay:.24s; }

/* Timeline */
.timeline-dot {
    width: 12px; height: 12px;
    border-radius: 50%;
    background: #1a3a6b;
    flex-shrink: 0;
    margin-top: 3px;
    position: relative;
    z-index: 1;
}
.timeline-dot.first {
    background: #1a3a6b;
    box-shadow: 0 0 0 4px rgba(26,58,107,.15);
}
.timeline-line {
    width: 2px;
    flex: 1;
    background: linear-gradient(to bottom, #e5e7eb, #f3f4f6);
    margin: 4px auto;
}

/* Status badge */
.badge {
    display: inline-flex; align-items: center; gap: 5px;
    padding: 4px 10px; border-radius: 999px;
    font-size: 11px; font-weight: 700;
}

/* Search input */
.search-input {
    flex: 1;
    border: 1.5px solid #e5e7eb;
    border-radius: 14px;
    padding: 12px 16px;
    font-size: 0.875rem;
    color: #1f2937;
    background: #f9fafb;
    outline: none;
    transition: all .2s;
    font-family: inherit;
}
.search-input:focus {
    border-color: #1a3a6b;
    background: #fff;
    box-shadow: 0 0 0 3px rgba(26,58,107,.08);
}
</style>

{{-- ─── NAVBAR ─── --}}
<nav class="sticky top-0 z-40 bg-white/95 backdrop-blur-xl border-b border-gray-100 shadow-sm">
    <div class="max-w-2xl mx-auto px-4 py-3.5 flex items-center gap-3">
        <a href="{{ route('beranda') }}"
           class="w-9 h-9 bg-gray-100 hover:bg-gray-200 rounded-xl flex items-center justify-center transition flex-shrink-0">
            <svg class="w-4 h-4 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
            </svg>
        </a>
        <div>
            <div class="font-bold text-gray-800 text-sm leading-tight">Lacak Laporan</div>
            <div class="text-gray-400 text-[10px]">BatusangkarLapor · Tanah Datar</div>
        </div>
    </div>
</nav>

<div class="min-h-screen bg-[#f3f6fc]">
<div class="max-w-2xl mx-auto px-4 py-10 space-y-5">

    {{-- ─── SEARCH CARD ─── --}}
    <div class="fu bg-white rounded-3xl shadow-sm border border-gray-100 p-8">
        <div class="flex flex-col items-center text-center mb-7">
            <div class="w-14 h-14 rounded-2xl flex items-center justify-center mb-4"
                 style="background:linear-gradient(135deg,#1a3a6b,#2352a0); box-shadow:0 8px 24px rgba(26,58,107,.3);">
                <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                </svg>
            </div>
            <h1 class="text-xl font-black text-gray-900">Lacak Laporan Anda</h1>
            <p class="text-gray-400 text-sm mt-1">Masukkan kode laporan atau token pelacak</p>
        </div>

        <form method="GET" action="{{ route('lacak') }}" class="flex gap-2.5">
            <input type="text" name="kode" value="{{ $kode ?? '' }}"
                   placeholder="Contoh: BL-2026-00001 atau token pelacak"
                   class="search-input">
            <button type="submit"
                    class="flex items-center gap-2 text-white font-bold px-5 py-3 rounded-2xl transition-all text-sm hover:-translate-y-0.5 flex-shrink-0"
                    style="background:linear-gradient(135deg,#1a3a6b,#2352a0); box-shadow:0 4px 14px rgba(26,58,107,.35);">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                </svg>
                Lacak
            </button>
        </form>
    </div>

    {{-- ─── TIDAK DITEMUKAN ─── --}}
    @if(isset($notFound) && $notFound)
    <div class="fu bg-white rounded-3xl border border-red-100 p-8 text-center">
        <div class="w-14 h-14 bg-red-50 border border-red-100 rounded-2xl flex items-center justify-center mx-auto mb-4">
            <svg class="w-7 h-7 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
        </div>
        <p class="font-bold text-gray-800 mb-1">Laporan tidak ditemukan</p>
        <p class="text-gray-400 text-sm">Kode <span class="font-mono font-bold text-gray-600 bg-gray-100 px-2 py-0.5 rounded-lg">{{ $kode }}</span> tidak terdaftar dalam sistem.</p>
    </div>
    @endif

    {{-- ─── HASIL LAPORAN ─── --}}
    @if($pengaduan)
    @php $b = $pengaduan->status_badge; @endphp
    <div class="fu fu-2 bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden">

        {{-- Header biru --}}
        <div class="relative overflow-hidden p-7" style="background:linear-gradient(135deg,#0f2654,#1a3a6b 60%,#1e4d8c);">
            {{-- bg decoration --}}
            <div class="absolute top-0 right-0 w-48 h-48 rounded-full opacity-10" style="background:radial-gradient(circle,#f59e0b,transparent 70%); transform:translate(30%,-30%);"></div>
            <div class="absolute bottom-0 left-0 w-32 h-32 rounded-full opacity-8" style="background:radial-gradient(circle,#60a5fa,transparent 70%); transform:translate(-30%,30%);"></div>

            <div class="relative flex items-start justify-between gap-4 flex-wrap">
                <div class="flex-1 min-w-0">
                    {{-- Status badge --}}
                    <span class="badge mb-3
                        {{ $b['color']==='yellow' ? 'bg-amber-100 text-amber-800' : '' }}
                        {{ $b['color']==='blue'   ? 'bg-blue-100 text-blue-800'   : '' }}
                        {{ $b['color']==='green'  ? 'bg-green-100 text-green-800' : '' }}
                        {{ $b['color']==='red'    ? 'bg-red-100 text-red-800'     : '' }}">
                        <span class="w-1.5 h-1.5 rounded-full
                            {{ $b['color']==='yellow' ? 'bg-amber-500' : '' }}
                            {{ $b['color']==='blue'   ? 'bg-blue-500'  : '' }}
                            {{ $b['color']==='green'  ? 'bg-green-500' : '' }}
                            {{ $b['color']==='red'    ? 'bg-red-500'   : '' }}">
                        </span>
                        {{ $b['label'] }}
                    </span>
                    <h2 class="text-xl font-black text-white leading-tight mb-1">{{ $pengaduan->judul }}</h2>
                    <p class="text-blue-300/80 text-sm">{{ $pengaduan->kategori->nama ?? '-' }}
                        @if($pengaduan->wilaya) · {{ $pengaduan->wilaya->nama }} @endif
                    </p>
                </div>
                <div class="text-right flex-shrink-0">
                    <p class="text-blue-400/70 text-[10px] uppercase tracking-widest font-semibold mb-1">Kode Laporan</p>
                    <p class="font-mono font-black text-white text-base bg-white/10 border border-white/20 px-3 py-1.5 rounded-xl">{{ $pengaduan->kode_laporan }}</p>
                </div>
            </div>
        </div>

        {{-- Stats row --}}
        <div class="grid grid-cols-2 sm:grid-cols-4 divide-x divide-y sm:divide-y-0 divide-gray-100 border-b border-gray-100">
            @foreach([
                ['label' => 'Tanggal Lapor',    'value' => $pengaduan->created_at->format('d M Y')],
                ['label' => 'Daerah',            'value' => $pengaduan->wilaya->nama ?? '-'],
                ['label' => 'Petugas',           'value' => $pengaduan->petugas->name ?? 'Belum ditugaskan'],
                ['label' => 'Terakhir Update',   'value' => $pengaduan->updated_at->diffForHumans()],
            ] as $stat)
            <div class="px-5 py-4 text-center">
                <p class="text-[10px] text-gray-400 uppercase tracking-wider font-semibold mb-1">{{ $stat['label'] }}</p>
                <p class="font-bold text-gray-700 text-sm leading-tight">{{ $stat['value'] }}</p>
            </div>
            @endforeach
        </div>

        {{-- Riwayat --}}
        <div class="p-7">
            <h3 class="font-black text-gray-800 text-sm mb-6 flex items-center gap-2.5">
                <div class="w-8 h-8 rounded-xl flex items-center justify-center" style="background:rgba(26,58,107,.08);">
                    <svg class="w-4 h-4 text-[#1a3a6b]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                Riwayat Perkembangan
            </h3>

            @php $histories = $pengaduan->histories; @endphp

            @if($histories->isEmpty())
            <div class="text-center py-8">
                <div class="w-12 h-12 bg-gray-100 rounded-2xl flex items-center justify-center mx-auto mb-3">
                    <svg class="w-6 h-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <p class="text-gray-400 text-sm">Belum ada riwayat perkembangan</p>
            </div>
            @else
            <div class="space-y-0">
                @foreach($histories as $h)
                <div class="flex gap-4">
                    {{-- Timeline visual --}}
                    <div class="flex flex-col items-center w-5 flex-shrink-0">
                        <div class="timeline-dot {{ $loop->first ? 'first' : '' }}"></div>
                        @if(!$loop->last)
                        <div class="timeline-line"></div>
                        @endif
                    </div>

                    {{-- Content --}}
                    <div class="pb-6 flex-1 {{ $loop->first ? 'pt-0' : '' }}">
                        <div class="bg-gray-50 hover:bg-gray-100/80 transition-colors rounded-2xl p-4 border border-gray-100">
                            {{-- Status transition --}}
                            <div class="flex items-center gap-2 flex-wrap mb-2">
                                <span class="font-black text-gray-800 text-sm capitalize">{{ $h->status_baru }}</span>
                                @if($h->status_lama)
                                <svg class="w-3.5 h-3.5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                                </svg>
                                <span class="text-gray-400 text-xs capitalize">{{ $h->status_lama }}</span>
                                @endif
                            </div>

                            @if($h->keterangan)
                            <p class="text-gray-600 text-xs leading-relaxed mb-2.5">{{ $h->keterangan }}</p>
                            @endif

                            <div class="flex items-center gap-2 flex-wrap">
                                @if($h->user)
                                <img src="{{ $h->user->avatar_url }}" class="w-5 h-5 rounded-lg object-cover border border-gray-200">
                                <span class="text-gray-500 text-xs font-semibold">{{ $h->user->name }}</span>
                                <span class="text-gray-300 text-xs">·</span>
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

        {{-- Alasan tolak --}}
        @if($pengaduan->status === 'ditolak' && $pengaduan->alasan_tolak)
        <div class="mx-7 mb-7 p-4 bg-red-50 border border-red-100 rounded-2xl flex gap-3">
            <svg class="w-5 h-5 text-red-400 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"/>
            </svg>
            <div>
                <p class="text-xs font-bold text-red-700 mb-1">Alasan Penolakan</p>
                <p class="text-red-600 text-sm">{{ $pengaduan->alasan_tolak }}</p>
            </div>
        </div>
        @endif
    </div>
    @endif

    {{-- ─── INFO / PANDUAN ─── --}}
    @if(!$pengaduan && !isset($notFound))
    <div class="fu fu-3 bg-white rounded-3xl border border-gray-100 shadow-sm p-7">
        <h3 class="font-black text-gray-800 text-sm mb-5 flex items-center gap-2.5">
            <div class="w-8 h-8 bg-blue-50 rounded-xl flex items-center justify-center">
                <svg class="w-4 h-4 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
            Cara Melacak Laporan
        </h3>
        <div class="space-y-3">
            @foreach([
                ['num'=>'1','text'=>'Masukkan <strong>Kode Laporan</strong> (contoh: BL-2026-00001) yang diberikan saat laporan dibuat'],
                ['num'=>'2','text'=>'Atau gunakan <strong>Token Pelacak</strong> yang tersedia di halaman detail laporan Anda'],
                ['num'=>'3','text'=>'Klik tombol <strong>Lacak</strong> untuk melihat status dan riwayat perkembangan laporan'],
            ] as $step)
            <div class="flex items-start gap-3 p-3.5 bg-gray-50 rounded-2xl">
                <span class="w-6 h-6 rounded-lg flex items-center justify-center font-black text-[11px] flex-shrink-0 text-white"
                      style="background:linear-gradient(135deg,#1a3a6b,#2352a0);">{{ $step['num'] }}</span>
                <p class="text-gray-600 text-sm leading-relaxed">{!! $step['text'] !!}</p>
            </div>
            @endforeach
        </div>
    </div>
    @endif

</div>
</div>

@endsection