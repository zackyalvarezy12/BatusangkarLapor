@extends('layouts.admin')
@section('title', 'Semua Laporan')
@section('breadcrumb', 'Semua Laporan')

@section('content')
<div class="py-6 space-y-6">

    {{-- Header --}}
    <div class="relative overflow-hidden bg-primary rounded-3xl p-8 shadow-lg">
        <div class="absolute inset-0 opacity-5">
            <svg width="100%" height="100%"><defs><pattern id="g" width="40" height="40" patternUnits="userSpaceOnUse">
                <path d="M 40 0 L 0 0 0 40" fill="none" stroke="white" stroke-width="1"/>
            </pattern></defs><rect width="100%" height="100%" fill="url(#g)"/></svg>
        </div>
        <div class="relative flex items-center justify-between flex-wrap gap-4">
            <div class="flex items-center gap-4">
                <div class="w-14 h-14 bg-white/20 rounded-2xl flex items-center justify-center border border-white/30">
                    <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                              d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                </div>
                <div>
                    <span class="bg-secondary text-gray-900 text-xs font-black px-3 py-0.5 rounded-full">
                        Manajemen
                    </span>
                    <h1 class="text-2xl font-black text-white mt-1">Semua Laporan</h1>
                    <p class="text-blue-200 text-sm">Kelola dan tindaklanjuti laporan masyarakat</p>
                </div>
            </div>
            <div class="text-right hidden sm:block">
                <div class="text-3xl font-black text-white">{{ $pengaduans->total() }}</div>
                <div class="text-blue-200 text-xs">Total laporan</div>
            </div>
        </div>
    </div>

    {{-- Filter --}}
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-5">
        <form method="GET" action="{{ route('admin.pengaduan.index') }}" class="flex flex-wrap gap-3 items-end">

            <div class="flex-1 min-w-[200px]">
                <label class="block text-xs font-semibold text-gray-500 mb-1.5">Cari Laporan</label>
                <div class="relative">
                    <svg class="w-4 h-4 text-gray-400 absolute left-3 top-1/2 -translate-y-1/2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                    <input type="text" name="search" value="{{ request('search') }}"
                           placeholder="Judul atau kode laporan..."
                           class="w-full pl-9 pr-4 py-2.5 border border-gray-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary transition">
                </div>
            </div>

            <div class="min-w-[140px]">
                <label class="block text-xs font-semibold text-gray-500 mb-1.5">Status</label>
                <select name="status" class="w-full border border-gray-200 rounded-xl px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary transition">
                    <option value="">Semua Status</option>
                    <option value="menunggu" {{ request('status')==='menunggu' ? 'selected':'' }}>Menunggu</option>
                    <option value="proses"   {{ request('status')==='proses'   ? 'selected':'' }}>Diproses</option>
                    <option value="selesai"  {{ request('status')==='selesai'  ? 'selected':'' }}>Selesai</option>
                    <option value="ditolak"  {{ request('status')==='ditolak'  ? 'selected':'' }}>Ditolak</option>
                </select>
            </div>

            <div class="min-w-[160px]">
                <label class="block text-xs font-semibold text-gray-500 mb-1.5">Kategori</label>
                <select name="kategori" class="w-full border border-gray-200 rounded-xl px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary transition">
                    <option value="">Semua Kategori</option>
                    @foreach(\App\Models\Kategori::orderBy('nama')->get() as $k)
                    <option value="{{ $k->id }}" {{ request('kategori')==$k->id ? 'selected':'' }}>{{ $k->nama }}</option>
                    @endforeach
                </select>
            </div>

            <div class="flex gap-2">
                <button type="submit"
                        class="inline-flex items-center gap-2 bg-primary hover:bg-blue-900 text-white font-semibold text-sm px-5 py-2.5 rounded-xl transition">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2a1 1 0 01-.293.707L13 13.414V19a1 1 0 01-.553.894l-4 2A1 1 0 017 21v-7.586L3.293 6.707A1 1 0 013 6V4z"/>
                    </svg>
                    Filter
                </button>
                @if(request()->hasAny(['search','status','kategori']))
                <a href="{{ route('admin.pengaduan.index') }}"
                   class="inline-flex items-center gap-2 bg-gray-100 hover:bg-gray-200 text-gray-600 font-semibold text-sm px-4 py-2.5 rounded-xl transition">
                    Reset
                </a>
                @endif
            </div>
        </form>
    </div>

    {{-- Tabel --}}
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="px-6 py-5 border-b border-gray-100 flex items-center justify-between flex-wrap gap-3">
            <div class="flex items-center gap-3">
                <div class="w-9 h-9 bg-primary rounded-xl flex items-center justify-center">
                    <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                </div>
                <div>
                    <h3 class="font-bold text-gray-800 text-sm">Daftar Laporan</h3>
                    <p class="text-gray-400 text-xs">
                        Menampilkan {{ $pengaduans->firstItem() }}–{{ $pengaduans->lastItem() }}
                        dari {{ $pengaduans->total() }} laporan
                    </p>
                </div>
            </div>

            {{-- Status Badges Ringkasan --}}
            <div class="flex items-center gap-2 flex-wrap">
                @foreach([
                    ['status'=>'menunggu','label'=>'Menunggu', 'cls'=>'bg-yellow-100 text-yellow-700'],
                    ['status'=>'proses',  'label'=>'Diproses', 'cls'=>'bg-blue-100 text-blue-700'],
                    ['status'=>'selesai', 'label'=>'Selesai',  'cls'=>'bg-green-100 text-green-700'],
                    ['status'=>'ditolak', 'label'=>'Ditolak',  'cls'=>'bg-red-100 text-red-700'],
                ] as $st)
                <a href="{{ route('admin.pengaduan.index', ['status'=>$st['status']]) }}"
                   class="text-xs font-semibold px-3 py-1 rounded-full {{ $st['cls'] }} hover:opacity-80 transition">
                    {{ $st['label'] }}:
                    {{ \App\Models\Pengaduan::where('status',$st['status'])->count() }}
                </a>
                @endforeach
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="bg-gray-50 text-gray-500 uppercase text-xs">
                        <th class="px-6 py-3 text-left font-semibold">Kode</th>
                        <th class="px-6 py-3 text-left font-semibold">Laporan</th>
                        <th class="px-6 py-3 text-left font-semibold">Pelapor</th>
                        <th class="px-6 py-3 text-left font-semibold">Daerah</th>
                        <th class="px-6 py-3 text-left font-semibold">Petugas</th>
                        <th class="px-6 py-3 text-left font-semibold">Status</th>
                        <th class="px-6 py-3 text-left font-semibold">Tanggal</th>
                        <th class="px-6 py-3 text-left font-semibold">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @forelse($pengaduans as $p)
                    <tr class="hover:bg-blue-50/20 transition">
                        <td class="px-6 py-4">
                            <span class="font-mono text-xs text-gray-400 bg-gray-50 px-2 py-1 rounded-lg whitespace-nowrap">
                                {{ $p->kode_laporan }}
                            </span>
                        </td>
                        <td class="px-6 py-4">
                            <div class="font-semibold text-gray-800 text-sm truncate max-w-[180px]">{{ $p->judul }}</div>
                            <div class="text-xs text-gray-400 mt-0.5">
                                <span class="bg-gray-100 px-2 py-0.5 rounded-full">{{ $p->kategori->nama ?? '-' }}</span>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-2">
                                <img src="{{ $p->user->avatar_url }}" class="w-7 h-7 rounded-lg object-cover">
                                <div>
                                    <div class="text-xs font-semibold text-gray-700">
                                        {{ $p->is_anonim ? 'Anonim' : $p->user->name }}
                                    </div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 text-xs text-gray-500 whitespace-nowrap">
                            {{ $p->wilaya->nama ?? '-' }}
                        </td>
                        <td class="px-6 py-4">
                            @if($p->petugas)
                            <div class="flex items-center gap-1.5">
                                <img src="{{ $p->petugas->avatar_url }}" class="w-6 h-6 rounded-lg object-cover">
                                <span class="text-xs text-gray-600 font-medium">{{ $p->petugas->name }}</span>
                            </div>
                            @else
                            <span class="text-xs text-gray-400 italic">Belum ditugaskan</span>
                            @endif
                        </td>
                        <td class="px-6 py-4">
                            @php $b = $p->status_badge; @endphp
                            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-semibold
                                {{ $b['color']==='yellow' ? 'bg-yellow-100 text-yellow-800' : '' }}
                                {{ $b['color']==='blue'   ? 'bg-blue-100 text-blue-800'     : '' }}
                                {{ $b['color']==='green'  ? 'bg-green-100 text-green-800'   : '' }}
                                {{ $b['color']==='red'    ? 'bg-red-100 text-red-800'       : '' }}">
                                <span class="w-1.5 h-1.5 rounded-full
                                    {{ $b['color']==='yellow' ? 'bg-yellow-500' : '' }}
                                    {{ $b['color']==='blue'   ? 'bg-blue-500'   : '' }}
                                    {{ $b['color']==='green'  ? 'bg-green-500'  : '' }}
                                    {{ $b['color']==='red'    ? 'bg-red-500'    : '' }}">
                                </span>
                                {{ $b['label'] }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-gray-400 text-xs whitespace-nowrap">
                            {{ $p->created_at->format('d M Y') }}
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-1.5">
                                <a href="{{ route('admin.pengaduan.show', $p->slug) }}"
                                   class="w-8 h-8 bg-primary/10 hover:bg-primary text-primary hover:text-white rounded-lg flex items-center justify-center transition"
                                   title="Lihat Detail">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                              d="M15 12a3 3 0 11-6 0 3 3 0 016 0z M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                    </svg>
                                </a>
                                <a href="{{ route('admin.pengaduan.chat', $p->slug) }}"
                                   class="w-8 h-8 bg-blue-50 hover:bg-blue-500 text-blue-500 hover:text-white rounded-lg flex items-center justify-center transition"
                                   title="Chat">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                              d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
                                    </svg>
                                </a>
                                <form method="POST" action="{{ route('admin.pengaduan.destroy', $p->slug) }}"
                                      onsubmit="return confirm('Hapus laporan ini?')">
                                    @csrf @method('DELETE')
                                    <button type="submit"
                                            class="w-8 h-8 bg-red-50 hover:bg-red-500 text-red-500 hover:text-white rounded-lg flex items-center justify-center transition"
                                            title="Hapus">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                  d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                        </svg>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="px-6 py-16 text-center">
                            <div class="flex flex-col items-center gap-3">
                                <div class="w-16 h-16 bg-gray-100 rounded-2xl flex items-center justify-center">
                                    <svg class="w-8 h-8 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                              d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                    </svg>
                                </div>
                                <p class="text-gray-400 font-medium text-sm">Tidak ada laporan ditemukan</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($pengaduans->hasPages())
        <div class="px-6 py-4 border-t border-gray-100">
            {{ $pengaduans->withQueryString()->links() }}
        </div>
        @endif
    </div>
</div>
@endsection