@extends('layouts.petugas')
@section('title', 'Detail Laporan')
@section('breadcrumb', 'Detail Laporan')

@section('content')
@php $b = $pengaduan->status_badge; @endphp

<div class="py-6 space-y-5">

{{-- Back + Header --}}
<div class="flex items-center gap-3">
    <a href="{{ route('petugas.pengaduan.index') }}"
       class="w-9 h-9 bg-white border border-gray-200 hover:border-violet-300 hover:bg-violet-50 rounded-xl flex items-center justify-center transition">
        <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
        </svg>
    </a>
    <div>
        <div class="flex items-center gap-2">
            <span class="font-mono text-xs text-violet-600 bg-violet-100 px-2.5 py-1 rounded-lg font-semibold">
                {{ $pengaduan->kode_laporan }}
            </span>
            <span class="inline-flex items-center gap-1.5 text-xs font-semibold px-2.5 py-1 rounded-full
                {{ $b['color']==='yellow' ? 'bg-amber-100 text-amber-800'     : '' }}
                {{ $b['color']==='blue'   ? 'bg-blue-100 text-blue-800'       : '' }}
                {{ $b['color']==='green'  ? 'bg-emerald-100 text-emerald-800' : '' }}
                {{ $b['color']==='red'    ? 'bg-rose-100 text-rose-800'       : '' }}">
                <span class="w-1.5 h-1.5 rounded-full
                    {{ $b['color']==='yellow' ? 'bg-amber-500'   : '' }}
                    {{ $b['color']==='blue'   ? 'bg-blue-500'    : '' }}
                    {{ $b['color']==='green'  ? 'bg-emerald-500' : '' }}
                    {{ $b['color']==='red'    ? 'bg-rose-500'    : '' }}">
                </span>
                {{ $b['label'] }}
            </span>
        </div>
        <h2 class="font-black text-gray-800 text-lg mt-0.5">{{ $pengaduan->judul }}</h2>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-5">

    {{-- ── KIRI: Detail + Deskripsi ── --}}
    <div class="lg:col-span-2 space-y-5">

        {{-- Info Grid --}}
        <div class="bg-white rounded-3xl border border-gray-100 shadow-sm p-6">
            <h3 class="font-bold text-gray-700 text-sm mb-4 flex items-center gap-2">
                <div class="w-6 h-6 bg-violet-100 rounded-lg flex items-center justify-center">
                    <svg class="w-3.5 h-3.5 text-violet-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                Informasi Laporan
            </h3>
            <div class="grid grid-cols-2 gap-4">
                @foreach([
                    ['label'=>'Kategori',   'val'=>$pengaduan->kategori->nama ?? '-'],
                    ['label'=>'Wilayah',    'val'=>$pengaduan->wilaya->nama ?? '-'],
                    ['label'=>'Pelapor',    'val'=>$pengaduan->is_anonim ? 'Anonim' : ($pengaduan->user->name ?? '-')],
                    ['label'=>'Tanggal',    'val'=>$pengaduan->created_at->format('d M Y, H:i')],
                    ['label'=>'Publik',     'val'=>$pengaduan->is_publik ? 'Ya' : 'Tidak'],
                    ['label'=>'Views',      'val'=>$pengaduan->views . 'x dilihat'],
                ] as $row)
                <div class="bg-gray-50 rounded-2xl p-4">
                    <div class="text-xs text-gray-400 font-medium mb-1">{{ $row['label'] }}</div>
                    <div class="text-sm font-semibold text-gray-800">{{ $row['val'] }}</div>
                </div>
                @endforeach
            </div>
        </div>

        {{-- Deskripsi --}}
        <div class="bg-white rounded-3xl border border-gray-100 shadow-sm p-6">
            <h3 class="font-bold text-gray-700 text-sm mb-4 flex items-center gap-2">
                <div class="w-6 h-6 bg-violet-100 rounded-lg flex items-center justify-center">
                    <svg class="w-3.5 h-3.5 text-violet-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h8"/>
                    </svg>
                </div>
                Deskripsi Masalah
            </h3>
            <div class="bg-gray-50 rounded-2xl p-5 text-sm text-gray-700 leading-relaxed">
                {{ $pengaduan->deskripsi }}
            </div>
        </div>

        {{-- Lampiran --}}
        @if($pengaduan->lampiran)
        <div class="bg-white rounded-3xl border border-gray-100 shadow-sm p-6">
            <h3 class="font-bold text-gray-700 text-sm mb-4 flex items-center gap-2">
                <div class="w-6 h-6 bg-violet-100 rounded-lg flex items-center justify-center">
                    <svg class="w-3.5 h-3.5 text-violet-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13"/>
                    </svg>
                </div>
                Lampiran
            </h3>
            @php $files = is_array($pengaduan->lampiran) ? $pengaduan->lampiran : json_decode($pengaduan->lampiran, true) ?? []; @endphp
            <div class="grid grid-cols-2 sm:grid-cols-3 gap-3">
                @foreach($files as $file)
                @php $isImg = preg_match('/\.(jpg|jpeg|png|gif|webp)$/i', $file); @endphp
                @if($isImg)
                <a href="{{ asset('storage/'.$file) }}" target="_blank"
                   class="aspect-square rounded-2xl overflow-hidden border border-gray-100 hover:border-violet-300 transition group">
                    <img src="{{ asset('storage/'.$file) }}" class="w-full h-full object-cover group-hover:scale-105 transition" alt="Lampiran">
                </a>
                @else
                <a href="{{ asset('storage/'.$file) }}" target="_blank"
                   class="flex items-center gap-3 p-3 bg-gray-50 hover:bg-violet-50 border border-gray-100 hover:border-violet-200 rounded-2xl transition">
                    <div class="w-10 h-10 bg-violet-100 rounded-xl flex items-center justify-center">
                        <svg class="w-5 h-5 text-violet-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                    </div>
                    <span class="text-xs font-medium text-gray-600 truncate">{{ basename($file) }}</span>
                </a>
                @endif
                @endforeach
            </div>
        </div>
        @endif

        {{-- Form Tanggapi --}}
        @if(in_array($pengaduan->status, ['menunggu','proses']))
        <div class="bg-white rounded-3xl border border-gray-100 shadow-sm p-6">
            <h3 class="font-bold text-gray-700 text-sm mb-4 flex items-center gap-2">
                <div class="w-6 h-6 bg-violet-100 rounded-lg flex items-center justify-center">
                    <svg class="w-3.5 h-3.5 text-violet-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"/>
                    </svg>
                </div>
                Berikan Tanggapan
            </h3>
            <form method="POST" action="{{ route('petugas.pengaduan.tanggap', $pengaduan->slug) }}"
                  enctype="multipart/form-data" class="space-y-4">
                @csrf
                <textarea name="isi" rows="4" required
                          placeholder="Tulis tanggapan resmi terhadap laporan ini..."
                          class="w-full border border-gray-200 rounded-2xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-violet-400/30 focus:border-violet-400 transition resize-none">{{ old('isi') }}</textarea>
                <div class="flex items-center justify-between flex-wrap gap-3">
                    <label class="flex items-center gap-2 text-sm text-gray-500 cursor-pointer hover:text-violet-600 transition">
                        <input type="checkbox" name="is_internal" value="1" class="rounded accent-violet-600">
                        <span class="text-xs font-medium">Tanggapan Internal (tidak terlihat pelapor)</span>
                    </label>
                    <button type="submit"
                            class="btn-violet inline-flex items-center gap-2 text-white font-semibold text-sm px-5 py-2.5 rounded-xl">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/>
                        </svg>
                        Kirim Tanggapan
                    </button>
                </div>
            </form>
        </div>
        @endif
    </div>

    {{-- ── KANAN: Aksi + Timeline ── --}}
    <div class="space-y-5">

        {{-- Update Status --}}
        @if($pengaduan->status !== 'selesai' && $pengaduan->status !== 'ditolak')
        <div class="bg-white rounded-3xl border border-gray-100 shadow-sm p-6">
            <h3 class="font-bold text-gray-700 text-sm mb-4">Update Status</h3>
            <form method="POST" action="{{ route('petugas.pengaduan.status', $pengaduan->slug) }}" class="space-y-3">
                @csrf @method('PATCH')
                <select name="status" required
                        class="w-full border border-gray-200 rounded-xl px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-violet-400/30 focus:border-violet-400 transition">
                    <option value="">Pilih Status Baru</option>
                    @if($pengaduan->status === 'menunggu')
                    <option value="proses">Mulai Proses</option>
                    @endif
                    @if(in_array($pengaduan->status, ['menunggu','proses']))
                    <option value="selesai">Tandai Selesai</option>
                    <option value="ditolak">Tolak Laporan</option>
                    @endif
                </select>
                <textarea name="keterangan" rows="2" placeholder="Catatan (opsional)..."
                          class="w-full border border-gray-200 rounded-xl px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-violet-400/30 focus:border-violet-400 transition resize-none"></textarea>
                <button type="submit"
                        class="w-full btn-violet text-white font-semibold text-sm py-2.5 rounded-xl flex items-center justify-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                    </svg>
                    Update Status
                </button>
            </form>
        </div>
        @endif

        {{-- Chat --}}
        <a href="{{ route('petugas.pengaduan.chat', $pengaduan->slug) }}"
           class="flex items-center gap-3 bg-violet-600 hover:bg-violet-700 text-white rounded-2xl p-5 transition shadow-md shadow-violet-200 group">
            <div class="w-10 h-10 bg-white/20 rounded-xl flex items-center justify-center">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
                </svg>
            </div>
            <div class="flex-1">
                <div class="font-bold text-sm">Chat dengan Pelapor</div>
                <div class="text-violet-300 text-xs">Komunikasi langsung</div>
            </div>
            <svg class="w-4 h-4 text-violet-300 group-hover:translate-x-1 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
            </svg>
        </a>

        {{-- Riwayat Status --}}
        <div class="bg-white rounded-3xl border border-gray-100 shadow-sm p-6">
            <h3 class="font-bold text-gray-700 text-sm mb-5 flex items-center gap-2">
                <div class="w-6 h-6 bg-violet-100 rounded-lg flex items-center justify-center">
                    <svg class="w-3.5 h-3.5 text-violet-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                Riwayat Status
            </h3>
            <div class="space-y-4">
                {{-- Created --}}
                <div class="flex gap-3">
                    <div class="flex flex-col items-center">
                        <div class="w-7 h-7 rounded-full bg-violet-600 flex items-center justify-center flex-shrink-0 shadow-md shadow-violet-200">
                            <svg class="w-3.5 h-3.5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                            </svg>
                        </div>
                        @if($pengaduan->histories->count() > 0)
                        <div class="w-0.5 h-full bg-violet-100 mt-1"></div>
                        @endif
                    </div>
                    <div class="pb-4 flex-1">
                        <div class="text-xs font-bold text-gray-700">Laporan Dibuat</div>
                        <div class="text-xs text-gray-400 mt-0.5">{{ $pengaduan->created_at->format('d M Y, H:i') }}</div>
                        @if(!$pengaduan->is_anonim)
                        <div class="text-xs text-violet-600 mt-0.5">oleh {{ $pengaduan->user->name ?? '-' }}</div>
                        @endif
                    </div>
                </div>

                @foreach($pengaduan->histories->sortBy('created_at') as $h)
                @php
                $colors = ['menunggu'=>'amber','proses'=>'blue','selesai'=>'emerald','ditolak'=>'rose'];
                $c = $colors[$h->status_baru] ?? 'gray';
                @endphp
                <div class="flex gap-3">
                    <div class="flex flex-col items-center">
                        <div class="w-7 h-7 rounded-full bg-{{ $c }}-100 border-2 border-{{ $c }}-400 flex items-center justify-center flex-shrink-0">
                            <div class="w-2 h-2 rounded-full bg-{{ $c }}-500"></div>
                        </div>
                        @if(!$loop->last)
                        <div class="w-0.5 flex-1 bg-gray-100 mt-1"></div>
                        @endif
                    </div>
                    <div class="pb-4 flex-1">
                        <div class="text-xs font-bold text-gray-700 capitalize">{{ $h->status_baru }}</div>
                        @if($h->keterangan)
                        <div class="text-xs text-gray-500 mt-0.5 bg-gray-50 rounded-xl px-3 py-2">{{ $h->keterangan }}</div>
                        @endif
                        <div class="text-xs text-gray-400 mt-1">{{ $h->created_at->format('d M Y, H:i') }}</div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>

        {{-- Penilaian --}}
        @include('components.penilaian-section')
    </div>
</div>
</div>
@endsection