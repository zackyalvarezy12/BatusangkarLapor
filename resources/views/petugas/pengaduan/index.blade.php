@extends('layouts.petugas')
@section('title', 'Laporan Masuk')
@section('breadcrumb', 'Laporan Masuk')

@section('content')
<div class="py-6 space-y-5">

{{-- Header --}}
<div class="flex items-center justify-between flex-wrap gap-3">
    <div>
        <h2 class="text-xl font-black text-gray-800">Laporan Masuk</h2>
        <p class="text-gray-400 text-sm">Wilayah {{ auth()->user()->wilaya->nama ?? '-' }}</p>
    </div>
    <div class="flex items-center gap-2">
        @php
        $counts = [
            'all'      => \App\Models\Pengaduan::where('wilaya_id', auth()->user()->wilaya_id)->count(),
            'menunggu' => \App\Models\Pengaduan::where('wilaya_id', auth()->user()->wilaya_id)->where('status','menunggu')->count(),
            'proses'   => \App\Models\Pengaduan::where('wilaya_id', auth()->user()->wilaya_id)->where('status','proses')->count(),
            'selesai'  => \App\Models\Pengaduan::where('wilaya_id', auth()->user()->wilaya_id)->where('status','selesai')->count(),
        ];
        @endphp
        @foreach([
            ['val'=>'',         'label'=>'Semua',    'n'=>$counts['all'],      'bg'=>'bg-violet-600 text-white',         'off'=>'bg-white text-gray-600 hover:bg-violet-50'],
            ['val'=>'menunggu', 'label'=>'Menunggu', 'n'=>$counts['menunggu'], 'bg'=>'bg-amber-500 text-white',          'off'=>'bg-white text-gray-600 hover:bg-amber-50'],
            ['val'=>'proses',   'label'=>'Diproses', 'n'=>$counts['proses'],   'bg'=>'bg-blue-500 text-white',           'off'=>'bg-white text-gray-600 hover:bg-blue-50'],
            ['val'=>'selesai',  'label'=>'Selesai',  'n'=>$counts['selesai'],  'bg'=>'bg-emerald-500 text-white',        'off'=>'bg-white text-gray-600 hover:bg-emerald-50'],
        ] as $f)
        <a href="{{ route('petugas.pengaduan.index', array_merge(request()->query(), ['status'=>$f['val']])) }}"
           class="inline-flex items-center gap-1.5 text-xs font-semibold px-3 py-2 rounded-xl border border-gray-200 transition
                  {{ request('status')===$f['val'] ? $f['bg'] : $f['off'] }}">
            {{ $f['label'] }}
            <span class="font-black">{{ $f['n'] }}</span>
        </a>
        @endforeach
    </div>
</div>

{{-- Filter Bar --}}
<div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-4">
    <form method="GET" action="{{ route('petugas.pengaduan.index') }}"
          class="flex flex-wrap items-end gap-3">
        <div class="flex-1 min-w-[200px]">
            <label class="block text-xs font-semibold text-gray-500 mb-1.5">Cari Laporan</label>
            <div class="relative">
                <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                </svg>
                <input type="text" name="search" value="{{ request('search') }}"
                       placeholder="Kode, judul laporan..."
                       class="w-full border border-gray-200 rounded-xl pl-9 pr-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-violet-400/30 focus:border-violet-400 transition">
            </div>
        </div>
        <div class="min-w-[160px]">
            <label class="block text-xs font-semibold text-gray-500 mb-1.5">Status</label>
            <select name="status"
                    class="w-full border border-gray-200 rounded-xl px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-violet-400/30 focus:border-violet-400 transition">
                <option value="">Semua Status</option>
                <option value="menunggu" {{ request('status')==='menunggu'?'selected':'' }}>Belum Ditindak</option>
                <option value="proses"   {{ request('status')==='proses'  ?'selected':'' }}>Sedang Ditindak</option>
                <option value="selesai"  {{ request('status')==='selesai' ?'selected':'' }}>Selesai</option>
                <option value="ditolak"  {{ request('status')==='ditolak' ?'selected':'' }}>Ditolak</option>
            </select>
        </div>
        <div class="flex gap-2">
            <button type="submit"
                    class="btn-violet inline-flex items-center gap-1.5 text-white font-semibold text-sm px-4 py-2.5 rounded-xl transition">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                </svg>
                Filter
            </button>
            @if(request()->hasAny(['search','status']))
            <a href="{{ route('petugas.pengaduan.index') }}"
               class="inline-flex items-center bg-gray-100 hover:bg-gray-200 text-gray-600 font-semibold text-sm px-4 py-2.5 rounded-xl transition">
                Reset
            </a>
            @endif
        </div>
    </form>
</div>

{{-- Table --}}
<div class="bg-white rounded-3xl border border-gray-100 shadow-sm overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead>
                <tr class="bg-violet-50/50 border-b border-violet-100">
                    <th class="px-6 py-4 text-left text-xs font-bold text-violet-600 uppercase tracking-wider">Kode</th>
                    <th class="px-6 py-4 text-left text-xs font-bold text-violet-600 uppercase tracking-wider">Laporan</th>
                    <th class="px-6 py-4 text-left text-xs font-bold text-violet-600 uppercase tracking-wider">Daerah</th>
                    <th class="px-6 py-4 text-left text-xs font-bold text-violet-600 uppercase tracking-wider">Pelapor</th>
                    <th class="px-6 py-4 text-left text-xs font-bold text-violet-600 uppercase tracking-wider">Status</th>
                    <th class="px-6 py-4 text-left text-xs font-bold text-violet-600 uppercase tracking-wider">Tanggal</th>
                    <th class="px-6 py-4 text-left text-xs font-bold text-violet-600 uppercase tracking-wider">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50">
                @forelse($pengaduans as $p)
                @php $b = $p->status_badge; @endphp
                <tr class="hover:bg-violet-50/20 transition group">
                    <td class="px-6 py-4">
                        <span class="font-mono text-xs text-gray-500 bg-gray-50 border border-gray-100 px-2.5 py-1.5 rounded-lg">
                            {{ $p->kode_laporan }}
                        </span>
                    </td>
                    <td class="px-6 py-4">
                        <div class="font-semibold text-gray-800 truncate max-w-[220px] group-hover:text-violet-700 transition">
                            {{ $p->judul }}
                        </div>
                        <div class="text-xs text-gray-400 mt-0.5">{{ $p->kategori->nama ?? '-' }}</div>
                    </td>
                    <td class="px-6 py-4">
                        @if($p->wilaya)
                        <span class="inline-flex items-center gap-1.5 text-xs font-semibold px-2.5 py-1.5 rounded-full bg-violet-50 text-violet-700">
                            <svg class="w-3 h-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                            </svg>
                            {{ $p->wilaya->nama }}
                        </span>
                        @else
                        <span class="text-xs text-gray-400">—</span>
                        @endif
                    </td>
                    <td class="px-6 py-4">
                        @if($p->is_anonim)
                        <span class="inline-flex items-center gap-1 text-xs text-gray-400 bg-gray-100 px-2.5 py-1 rounded-full">
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"/>
                            </svg>
                            Anonim
                        </span>
                        @else
                        <div class="flex items-center gap-2">
                            <div class="w-7 h-7 rounded-lg bg-violet-100 flex items-center justify-center text-violet-700 font-bold text-xs flex-shrink-0">
                                {{ strtoupper(substr($p->user->name ?? 'U', 0, 1)) }}
                            </div>
                            <span class="text-xs text-gray-600 font-medium truncate max-w-[100px]">{{ $p->user->name ?? '-' }}</span>
                        </div>
                        @endif
                    </td>
                    <td class="px-6 py-4">
                        <span class="inline-flex items-center gap-1.5 text-xs font-semibold px-2.5 py-1.5 rounded-full
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
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-xs text-gray-600 font-medium">{{ $p->created_at->format('d M Y') }}</div>
                        <div class="text-xs text-gray-400">{{ $p->created_at->format('H:i') }}</div>
                    </td>
                    <td class="px-6 py-4">
                        <a href="{{ route('petugas.pengaduan.show', $p->slug) }}"
                           class="inline-flex items-center gap-1.5 btn-violet text-white text-xs font-semibold px-3.5 py-2 rounded-xl transition">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M15 12a3 3 0 11-6 0 3 3 0 016 0z M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                            </svg>
                            Tangani
                        </a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="py-20 text-center">
                        <div class="flex flex-col items-center gap-3">
                            <div class="w-16 h-16 bg-violet-50 rounded-2xl flex items-center justify-center">
                                <svg class="w-8 h-8 text-violet-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                          d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                </svg>
                            </div>
                            <div>
                                <p class="font-semibold text-gray-600 text-sm">Tidak ada laporan</p>
                                <p class="text-gray-400 text-xs mt-0.5">Belum ada laporan yang cocok dengan filter</p>
                            </div>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($pengaduans->hasPages())
    <div class="px-6 py-4 border-t border-gray-100 bg-gray-50/50">
        {{ $pengaduans->withQueryString()->links() }}
    </div>
    @endif
</div>

</div>
@endsection