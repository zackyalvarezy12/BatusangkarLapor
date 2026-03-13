@extends('layouts.admin')
@section('title', 'Export Laporan')
@section('breadcrumb', 'Export Laporan')

@section('content')
<div class="py-6 space-y-6">

    <div>
        <h1 class="font-black text-gray-800 text-xl">Export Laporan PDF</h1>
        <p class="text-gray-400 text-sm mt-0.5">Filter dan cetak laporan pengaduan sesuai kebutuhan</p>
    </div>

    {{-- Statistik Ringkas --}}
    <div class="grid grid-cols-2 sm:grid-cols-5 gap-3">
        @foreach([
            ['label'=>'Total','value'=>$stats['total'],'color'=>'#003580','bg'=>'#eff6ff'],
            ['label'=>'Belum Ditindak','value'=>$stats['menunggu'],'color'=>'#d97706','bg'=>'#fffbeb'],
            ['label'=>'Sedang Ditindak','value'=>$stats['proses'],'color'=>'#2563eb','bg'=>'#eff6ff'],
            ['label'=>'Selesai','value'=>$stats['selesai'],'color'=>'#16a34a','bg'=>'#f0fdf4'],
            ['label'=>'Ditolak','value'=>$stats['ditolak'],'color'=>'#dc2626','bg'=>'#fef2f2'],
        ] as $s)
        <div class="bg-white rounded-2xl border border-gray-100 p-4 text-center shadow-sm">
            <div class="text-2xl font-black mb-1" style="color:{{ $s['color'] }}">{{ $s['value'] }}</div>
            <div class="text-xs text-gray-500 font-medium">{{ $s['label'] }}</div>
        </div>
        @endforeach
    </div>

    {{-- Form Filter — pakai GET supaya bisa preview tabel --}}
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
        <h2 class="font-bold text-gray-800 mb-5">Filter Laporan</h2>
        <form method="GET" action="{{ route('admin.laporan.index') }}" id="formFilter" class="space-y-5">

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Tanggal Dari</label>
                    <input type="date" name="tanggal_dari" value="{{ request('tanggal_dari') }}"
                           class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-blue-100 focus:border-blue-400 transition">
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Tanggal Sampai</label>
                    <input type="date" name="tanggal_sampai" value="{{ request('tanggal_sampai') }}"
                           class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-blue-100 focus:border-blue-400 transition">
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Status</label>
                    <select name="status" class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-blue-100 focus:border-blue-400 transition bg-white">
                        <option value="">Semua Status</option>
                        @foreach(['menunggu'=>'Belum Ditindak','proses'=>'Sedang Ditindak','selesai'=>'Selesai','ditolak'=>'Ditolak'] as $val => $lbl)
                        <option value="{{ $val }}" {{ request('status') === $val ? 'selected' : '' }}>{{ $lbl }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Wilayah</label>
                    <select name="wilaya_id" class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-blue-100 focus:border-blue-400 transition bg-white">
                        <option value="">Semua Wilayah</option>
                        @foreach($wilayas as $w)
                        <option value="{{ $w->id }}" {{ request('wilaya_id') == $w->id ? 'selected' : '' }}>{{ $w->nama }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Kategori</label>
                    <select name="kategori_id" class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-blue-100 focus:border-blue-400 transition bg-white">
                        <option value="">Semua Kategori</option>
                        @foreach($kategoris as $k)
                        <option value="{{ $k->id }}" {{ request('kategori_id') == $k->id ? 'selected' : '' }}>{{ $k->nama }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Petugas</label>
                    <select name="petugas_id" class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-blue-100 focus:border-blue-400 transition bg-white">
                        <option value="">Semua Petugas</option>
                        @foreach($petugas as $p)
                        <option value="{{ $p->id }}" {{ request('petugas_id') == $p->id ? 'selected' : '' }}>{{ $p->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">Pelapor (Masyarakat)</label>
                <select name="masyarakat_id" class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-blue-100 focus:border-blue-400 transition bg-white">
                    <option value="">Semua Masyarakat</option>
                    @foreach($masyarakat as $m)
                    <option value="{{ $m->id }}" {{ request('masyarakat_id') == $m->id ? 'selected' : '' }}>{{ $m->name }}</option>
                    @endforeach
                </select>
            </div>


            {{-- Upload Logo --}}
            <div class="border-t border-gray-100 pt-5">
                <p class="text-sm font-bold text-gray-700 mb-3">Logo Kop Surat <span class="text-gray-400 font-normal">(opsional — tampil di PDF)</span></p>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Logo Kiri</label>
                        <input type="file" id="logoKiriInput" accept="image/*" onchange="previewLogo(this,'prevKiri')"
                               class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm text-gray-500 file:mr-3 file:py-1 file:px-3 file:rounded-lg file:border-0 file:bg-blue-50 file:text-blue-700 file:font-semibold hover:file:bg-blue-100 transition">
                        <div id="prevKiri" class="mt-2 hidden">
                            <img class="h-14 object-contain border border-gray-200 rounded-lg p-1" src="">
                        </div>
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Logo Kanan</label>
                        <input type="file" id="logoKananInput" accept="image/*" onchange="previewLogo(this,'prevKanan')"
                               class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm text-gray-500 file:mr-3 file:py-1 file:px-3 file:rounded-lg file:border-0 file:bg-blue-50 file:text-blue-700 file:font-semibold hover:file:bg-blue-100 transition">
                        <div id="prevKanan" class="mt-2 hidden">
                            <img class="h-14 object-contain border border-gray-200 rounded-lg p-1" src="">
                        </div>
                    </div>
                </div>
            </div>

            <div class="pt-2 flex gap-3">
                <a href="{{ route('admin.laporan.index') }}"
                   class="px-6 py-3 bg-gray-100 hover:bg-gray-200 text-gray-700 font-semibold rounded-xl text-sm transition">
                    Reset Filter
                </a>
                <button type="submit"
                        class="flex items-center gap-2 text-white font-semibold py-3 px-6 rounded-xl text-sm transition"
                        style="background:#003580;">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2a1 1 0 01-.293.707L13 13.414V19a1 1 0 01-.553.894l-4 2A1 1 0 017 21v-7.586L3.293 6.707A1 1 0 013 6V4z"/>
                    </svg>
                    Terapkan Filter
                </button>
                @if($hasFilter)
                <button type="button" onclick="downloadPdf()"
                        class="flex items-center gap-2 font-semibold py-3 px-6 rounded-xl text-sm transition text-white"
                        style="background:#16a34a;">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                    </svg>
                    Download PDF ({{ $preview?->count() ?? 0 }})
                </button>
                @endif
            </div>
        </form>

        {{-- Form POST tersembunyi untuk download PDF --}}
        @if($hasFilter)
        <form id="formExport" method="POST" action="{{ route('admin.laporan.export') }}" target="_blank" class="hidden" enctype="multipart/form-data">
            @csrf
            @foreach(request()->only(['tanggal_dari','tanggal_sampai','status','wilaya_id','kategori_id','petugas_id','masyarakat_id']) as $key => $val)
            @if($val) <input type="hidden" name="{{ $key }}" value="{{ $val }}"> @endif
            @endforeach
            <input type="file" name="logo_kiri"  id="exportLogoKiri"  class="hidden">
            <input type="file" name="logo_kanan" id="exportLogoKanan" class="hidden">
        </form>
        @endif
    </div>

    {{-- Preview Tabel --}}
    @if($hasFilter)
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-100 flex items-center justify-between flex-wrap gap-3">
            <div>
                <h2 class="font-bold text-gray-800">Preview Data</h2>
                @if(!empty($filterInfo))
                <p class="text-gray-400 text-xs mt-0.5">{{ implode(' · ', $filterInfo) }}</p>
                @endif
            </div>
            <div class="flex items-center gap-3">
                <span class="text-sm font-bold text-gray-600">
                    {{ $preview->count() }} laporan ditemukan
                </span>
                @foreach([
                    ['menunggu','Belum Ditindak','#854d0e','#fef9c3'],
                    ['proses','Sedang Ditindak','#1e40af','#dbeafe'],
                    ['selesai','Selesai','#166534','#dcfce7'],
                    ['ditolak','Ditolak','#991b1b','#fee2e2'],
                ] as [$key,$lbl,$color,$bg])
                @php $count = $preview->where('status',$key)->count(); @endphp
                @if($count > 0)
                <span class="text-xs font-bold px-2 py-1 rounded-full"
                      style="background:{{ $bg }};color:{{ $color }}">
                    {{ $lbl }}: {{ $count }}
                </span>
                @endif
                @endforeach
            </div>
        </div>

        @if($preview->isEmpty())
        <div class="py-16 text-center">
            <div class="w-12 h-12 bg-gray-100 rounded-2xl flex items-center justify-center mx-auto mb-3">
                <svg class="w-6 h-6 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                          d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                </svg>
            </div>
            <p class="text-gray-400 text-sm font-medium">Tidak ada data untuk filter yang dipilih.</p>
        </div>
        @else
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="bg-gray-50 border-b border-gray-100">
                        <th class="text-left px-4 py-3 text-xs font-bold text-gray-500 uppercase tracking-wider">No</th>
                        <th class="text-left px-4 py-3 text-xs font-bold text-gray-500 uppercase tracking-wider">Kode</th>
                        <th class="text-left px-4 py-3 text-xs font-bold text-gray-500 uppercase tracking-wider">Judul</th>
                        <th class="text-left px-4 py-3 text-xs font-bold text-gray-500 uppercase tracking-wider">Pelapor</th>
                        <th class="text-left px-4 py-3 text-xs font-bold text-gray-500 uppercase tracking-wider">Kategori</th>
                        <th class="text-left px-4 py-3 text-xs font-bold text-gray-500 uppercase tracking-wider">Wilayah</th>
                        <th class="text-left px-4 py-3 text-xs font-bold text-gray-500 uppercase tracking-wider">Petugas</th>
                        <th class="text-left px-4 py-3 text-xs font-bold text-gray-500 uppercase tracking-wider">Tgl Lapor</th>
                        <th class="text-left px-4 py-3 text-xs font-bold text-gray-500 uppercase tracking-wider">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @foreach($preview as $i => $p)
                    <tr class="hover:bg-gray-50 transition">
                        <td class="px-4 py-3 text-gray-400 text-xs">{{ $i + 1 }}</td>
                        <td class="px-4 py-3">
                            <span class="font-mono text-xs bg-blue-50 text-blue-700 px-2 py-1 rounded-lg font-bold">
                                {{ $p->kode_laporan }}
                            </span>
                        </td>
                        <td class="px-4 py-3">
                            <a href="{{ route('admin.pengaduan.show', $p->slug) }}"
                               class="font-semibold text-gray-700 hover:text-blue-600 transition text-xs" target="_blank">
                                {{ Str::limit($p->judul, 50) }}
                            </a>
                        </td>
                        <td class="px-4 py-3 text-gray-500 text-xs">{{ $p->user?->name ?? '-' }}</td>
                        <td class="px-4 py-3 text-gray-500 text-xs">{{ $p->kategori?->nama ?? '-' }}</td>
                        <td class="px-4 py-3 text-gray-500 text-xs">{{ $p->wilaya?->nama ?? '-' }}</td>
                        <td class="px-4 py-3 text-gray-500 text-xs">{{ $p->petugas?->name ?? '-' }}</td>
                        <td class="px-4 py-3 text-gray-400 text-xs">{{ $p->created_at->format('d M Y') }}</td>
                        <td class="px-4 py-3">
                            @php
                            $badge = ['menunggu'=>['Belum Ditindak','bg-yellow-100 text-yellow-800'],
                                      'proses'  =>['Sedang Ditindak','bg-blue-100 text-blue-800'],
                                      'selesai' =>['Selesai','bg-green-100 text-green-800'],
                                      'ditolak' =>['Ditolak','bg-red-100 text-red-800']][$p->status] ?? [$p->status,'bg-gray-100 text-gray-600'];
                            @endphp
                            <span class="text-xs font-bold px-2 py-1 rounded-full {{ $badge[1] }}">{{ $badge[0] }}</span>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="px-6 py-3 bg-gray-50 border-t border-gray-100 flex items-center justify-between">
            <span class="text-xs text-gray-400">Total {{ $preview->count() }} laporan</span>
            <button onclick="downloadPdf()"
                    class="flex items-center gap-2 text-white font-semibold py-2 px-5 rounded-xl text-xs transition"
                    style="background:#003580;">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                </svg>
                Download PDF
            </button>
        </div>
        @endif
    </div>
    @else
    <div class="bg-blue-50 border border-blue-100 rounded-2xl p-6 text-center">
        <svg class="w-8 h-8 text-blue-300 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                  d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2a1 1 0 01-.293.707L13 13.414V19a1 1 0 01-.553.894l-4 2A1 1 0 017 21v-7.586L3.293 6.707A1 1 0 013 6V4z"/>
        </svg>
        <p class="text-blue-500 text-sm font-medium">Terapkan filter untuk melihat preview data dan tombol download PDF.</p>
    </div>
    @endif

</div>

@push('scripts')
<script>
function previewLogo(input, previewId) {
    const prev = document.getElementById(previewId);
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = e => {
            prev.querySelector('img').src = e.target.result;
            prev.classList.remove('hidden');
        };
        reader.readAsDataURL(input.files[0]);
    } else {
        prev.classList.add('hidden');
    }
}

function downloadPdf() {
    // Transfer file logo ke formExport
    transferFile('logoKiriInput', 'exportLogoKiri');
    transferFile('logoKananInput', 'exportLogoKanan');
    document.getElementById('formExport').submit();
}

function transferFile(sourceId, targetId) {
    const source = document.getElementById(sourceId);
    const target = document.getElementById(targetId);
    if (source && source.files[0] && target) {
        const dt = new DataTransfer();
        dt.items.add(source.files[0]);
        target.files = dt.files;
    }
}
</script>
@endpush
@endsection