@extends('layouts.admin')
@section('title', 'Dashboard')
@section('breadcrumb', 'Dashboard')

@section('content')
<div class="py-6 space-y-6">

{{-- ══ HERO BANNER ══ --}}
<div class="relative overflow-hidden rounded-2xl p-7 shadow-2xl shadow-navy/30"
     style="background: linear-gradient(135deg, #040a14 0%, #0B1628 45%, #0F2050 100%);">
    {{-- Dot grid --}}
    <div class="absolute inset-0 opacity-[0.06]"
         style="background-image: radial-gradient(circle, #fff 1px, transparent 1px); background-size: 28px 28px;"></div>
    {{-- Glows --}}
    <div class="absolute -top-16 -right-16 w-64 h-64 bg-brand/30 rounded-full blur-3xl pointer-events-none"></div>
    <div class="absolute -bottom-20 left-1/4 w-48 h-48 bg-gold/10 rounded-full blur-3xl pointer-events-none"></div>

    <div class="relative flex items-center justify-between flex-wrap gap-5">
        <div class="flex items-center gap-5">
            {{-- Avatar initial --}}
            <div class="w-14 h-14 rounded-2xl bg-white/[0.08] border border-white/[0.12] backdrop-blur-sm flex items-center justify-center flex-shrink-0 shadow-inner">
                <span class="text-white font-black text-2xl tracking-tight">
                    {{ strtoupper(substr(auth()->user()->name ?? 'A', 0, 1)) }}
                </span>
            </div>
            <div>
                <div class="flex items-center gap-2 mb-1.5">
                    <div class="flex items-center gap-1.5 bg-gold/[0.15] border border-gold/30 rounded-full px-2.5 py-0.5">
                        <div class="w-1.5 h-1.5 rounded-full bg-gold"></div>
                        <span class="text-gold text-[10px] font-bold tracking-widest uppercase">Administrator</span>
                    </div>
                </div>
                <h1 class="text-[22px] font-black text-white leading-tight">{{ auth()->user()->name ?? 'Admin' }}</h1>
                <p class="text-blue-300/60 text-sm font-medium mt-0.5">{{ now()->translatedFormat('l, d F Y') }}</p>
            </div>
        </div>
        <div class="flex flex-wrap items-center gap-2">
            <a href="{{ route('admin.wilaya.index') }}"
               class="inline-flex items-center gap-2 bg-white/[0.08] hover:bg-white/[0.14] border border-white/[0.12] text-white/80 hover:text-white text-xs font-semibold px-4 py-2.5 rounded-xl transition">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                </svg>
                Kelola Wilayah
            </a>
            <a href="{{ route('admin.kategori.index') }}"
               class="inline-flex items-center gap-2 bg-white/[0.08] hover:bg-white/[0.14] border border-white/[0.12] text-white/80 hover:text-white text-xs font-semibold px-4 py-2.5 rounded-xl transition">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
                </svg>
                Kategori
            </a>
            <a href="{{ route('admin.user.create') }}"
               class="inline-flex items-center gap-2 bg-gold hover:bg-gold-light text-navy text-xs font-black px-5 py-2.5 rounded-xl transition shadow-lg shadow-gold/25">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/>
                </svg>
                Tambah Petugas
            </a>
        </div>
    </div>
</div>

{{-- ══ STAT CARDS ══ --}}
@php
$cards = [
    ['label'=>'Total Laporan',  'value'=>$stats['total'],    'gradient'=>'from-blue-500 to-blue-700',    'shadow'=>'shadow-blue-500/20',   'icon'=>'M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z'],
    ['label'=>'Menunggu',       'value'=>$stats['menunggu'], 'gradient'=>'from-amber-400 to-amber-600',  'shadow'=>'shadow-amber-400/20',  'icon'=>'M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z'],
    ['label'=>'Diproses',       'value'=>$stats['proses'],   'gradient'=>'from-orange-400 to-orange-600','shadow'=>'shadow-orange-400/20', 'icon'=>'M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15'],
    ['label'=>'Selesai',        'value'=>$stats['selesai'],  'gradient'=>'from-emerald-500 to-emerald-700','shadow'=>'shadow-emerald-500/20','icon'=>'M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z'],
    ['label'=>'Ditolak',        'value'=>$stats['ditolak'],  'gradient'=>'from-rose-500 to-rose-700',    'shadow'=>'shadow-rose-500/20',   'icon'=>'M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z'],
    ['label'=>'Total Pengguna', 'value'=>$stats['users'],    'gradient'=>'from-violet-500 to-violet-700','shadow'=>'shadow-violet-500/20', 'icon'=>'M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z'],
];
@endphp
<div class="grid grid-cols-2 lg:grid-cols-3 xl:grid-cols-6 gap-4">
    @foreach($cards as $c)
    <div class="stat-card card-elevated p-5 cursor-default">
        <div class="w-10 h-10 rounded-xl bg-gradient-to-br {{ $c['gradient'] }} flex items-center justify-center mb-4 shadow-lg {{ $c['shadow'] }}">
            <svg class="w-[18px] h-[18px] text-white" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="{{ $c['icon'] }}"/>
            </svg>
        </div>
        <div class="text-[26px] font-black text-ink tabular-nums leading-none">{{ number_format($c['value']) }}</div>
        <div class="text-[12px] text-ink-muted font-semibold mt-1.5">{{ $c['label'] }}</div>
    </div>
    @endforeach
</div>

{{-- ══ CHARTS ROW ══ --}}
<div class="grid grid-cols-1 lg:grid-cols-3 gap-5">

    {{-- Monthly chart --}}
    <div class="lg:col-span-2 card-elevated p-6">
        <div class="flex items-center justify-between mb-6">
            <div>
                <h3 class="font-bold text-ink text-[15px]">Laporan per Bulan</h3>
                <p class="text-ink-muted text-[12px] mt-0.5">Statistik tahun {{ date('Y') }}</p>
            </div>
            <span class="bg-brand/[0.08] text-brand text-[11px] font-bold px-3 py-1 rounded-full border border-brand/20">
                {{ date('Y') }}
            </span>
        </div>
        <canvas id="chartBulan" height="105"></canvas>
    </div>

    {{-- Per kategori --}}
    <div class="card-elevated p-6 flex flex-col">
        <div class="flex items-center justify-between mb-6">
            <div>
                <h3 class="font-bold text-ink text-[15px]">Per Kategori</h3>
                <p class="text-ink-muted text-[12px] mt-0.5">Distribusi laporan</p>
            </div>
            <a href="{{ route('admin.kategori.index') }}"
               class="text-[11px] text-brand font-bold hover:underline">Kelola →</a>
        </div>
        <div class="space-y-4 flex-1">
            @forelse($perKategori as $kat)
            @php $max = $perKategori->max('pengaduans_count'); $pct = $max > 0 ? ($kat->pengaduans_count / $max * 100) : 0; @endphp
            <div>
                <div class="flex justify-between items-center mb-1.5">
                    <span class="text-[12px] text-slate-600 font-medium truncate max-w-[155px]">{{ $kat->nama }}</span>
                    <span class="text-[12px] font-black text-ink tabular-nums ml-2">{{ $kat->pengaduans_count }}</span>
                </div>
                <div class="h-1.5 bg-slate-100 rounded-full overflow-hidden">
                    <div class="h-full rounded-full transition-all duration-700"
                         style="width:{{ $pct }}%; background: linear-gradient(90deg, #1E3A8A, #3B5FCB)"></div>
                </div>
            </div>
            @empty
            <p class="text-ink-muted text-sm text-center py-6">Belum ada data</p>
            @endforelse
        </div>
    </div>
</div>

{{-- ══ LAPORAN TERBARU ══ --}}
<div class="card-elevated overflow-hidden">
    <div class="px-6 py-5 border-b border-slate-100 flex items-center justify-between">
        <div>
            <h3 class="font-bold text-ink text-[15px]">Laporan Terbaru</h3>
            <p class="text-ink-muted text-[12px] mt-0.5">10 laporan terakhir masuk</p>
        </div>
        <a href="{{ route('admin.pengaduan.index') }}"
           class="text-[12px] text-brand font-bold hover:underline flex items-center gap-1">
            Lihat Semua
            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/>
            </svg>
        </a>
    </div>
    <div class="overflow-x-auto">
        <table class="w-full">
            <thead>
                <tr style="background: #F8FAFF;">
                    <th class="px-6 py-3.5 text-left text-[10px] font-bold text-slate-400 uppercase tracking-widest">Kode</th>
                    <th class="px-6 py-3.5 text-left text-[10px] font-bold text-slate-400 uppercase tracking-widest">Judul</th>
                    <th class="px-6 py-3.5 text-left text-[10px] font-bold text-slate-400 uppercase tracking-widest">Kategori</th>
                    <th class="px-6 py-3.5 text-left text-[10px] font-bold text-slate-400 uppercase tracking-widest">Daerah</th>
                    <th class="px-6 py-3.5 text-left text-[10px] font-bold text-slate-400 uppercase tracking-widest">Status</th>
                    <th class="px-6 py-3.5 text-left text-[10px] font-bold text-slate-400 uppercase tracking-widest">Tanggal</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-50">
                @forelse($recentPengaduans as $p)
                <tr class="hover:bg-blue-50/30 transition group">
                    <td class="px-6 py-4">
                        <span class="font-mono text-[11px] text-slate-400 bg-slate-50 border border-slate-100 px-2.5 py-1 rounded-lg">
                            {{ $p->kode_laporan }}
                        </span>
                    </td>
                    <td class="px-6 py-4">
                        <a href="{{ route('admin.pengaduan.show', $p->slug) }}"
                           class="text-[13px] font-semibold text-ink hover:text-brand transition truncate block max-w-[200px]">
                            {{ $p->judul }}
                        </a>
                    </td>
                    <td class="px-6 py-4">
                        <span class="text-[11px] text-slate-500 bg-slate-100/80 px-2.5 py-1 rounded-full font-semibold">
                            {{ $p->kategori->nama ?? '—' }}
                        </span>
                    </td>
                    <td class="px-6 py-4 text-[12px] text-slate-500 font-medium">{{ $p->wilaya->nama ?? '—' }}</td>
                    <td class="px-6 py-4">
                        @php $b = $p->status_badge; @endphp
                        @php $sc = [
                            'yellow' => 'bg-amber-50 text-amber-700 border-amber-200',
                            'blue'   => 'bg-blue-50 text-blue-700 border-blue-200',
                            'green'  => 'bg-emerald-50 text-emerald-700 border-emerald-200',
                            'red'    => 'bg-rose-50 text-rose-700 border-rose-200',
                        ][$b['color']] ?? 'bg-slate-50 text-slate-600 border-slate-200'; @endphp
                        @php $dc = [
                            'yellow' => 'bg-amber-400',
                            'blue'   => 'bg-blue-400',
                            'green'  => 'bg-emerald-400',
                            'red'    => 'bg-rose-400',
                        ][$b['color']] ?? 'bg-slate-400'; @endphp
                        <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-[11px] font-bold border {{ $sc }}">
                            <span class="w-1.5 h-1.5 rounded-full {{ $dc }}"></span>
                            {{ $b['label'] }}
                        </span>
                    </td>
                    <td class="px-6 py-4 text-[12px] text-slate-400 font-medium whitespace-nowrap">
                        {{ $p->created_at->format('d M Y') }}
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="py-20 text-center">
                        <div class="w-12 h-12 bg-slate-100 rounded-2xl flex items-center justify-center mx-auto mb-3">
                            <svg class="w-6 h-6 text-slate-300" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                            </svg>
                        </div>
                        <p class="text-slate-400 font-semibold text-sm">Belum ada laporan</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

</div>
@push('scripts')
<script>
const labels = ['Jan','Feb','Mar','Apr','Mei','Jun','Jul','Agu','Sep','Okt','Nov','Des'];
const rawData = @json($perBulan);
const values = labels.map((_, i) => rawData[i + 1] ?? 0);

const ctx = document.getElementById('chartBulan');
new Chart(ctx, {
    type: 'bar',
    data: {
        labels,
        datasets: [{
            label: 'Laporan',
            data: values,
            backgroundColor: (context) => {
                const chart = context.chart;
                const {ctx: c, chartArea} = chart;
                if (!chartArea) return '#1E3A8A';
                const gradient = c.createLinearGradient(0, chartArea.top, 0, chartArea.bottom);
                gradient.addColorStop(0, '#1E3A8A');
                gradient.addColorStop(1, '#3B82F6');
                return gradient;
            },
            borderRadius: 8,
            borderSkipped: false,
            maxBarThickness: 42,
        }]
    },
    options: {
        responsive: true,
        plugins: {
            legend: { display: false },
            tooltip: {
                backgroundColor: '#0B1628',
                titleFont: { family: 'Sora', size: 12, weight: '700' },
                bodyFont:  { family: 'Sora', size: 12 },
                padding: 12,
                cornerRadius: 10,
                callbacks: {
                    label: (ctx) => ` ${ctx.parsed.y} laporan`,
                }
            }
        },
        scales: {
            y: {
                beginAtZero: true,
                grid: { color: '#F1F5F9', drawBorder: false },
                ticks: { precision: 0, font: { family: 'Sora', size: 11 }, color: '#94A3B8' },
                border: { display: false },
            },
            x: {
                grid: { display: false },
                ticks: { font: { family: 'Sora', size: 11 }, color: '#94A3B8' },
                border: { display: false },
            }
        }
    }
});
</script>
@endpush
@endsection