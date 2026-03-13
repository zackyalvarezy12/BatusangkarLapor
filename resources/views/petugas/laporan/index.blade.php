@extends('layouts.petugas')
@section('title', 'Export Laporan')

@section('content')
<div class="py-6 space-y-6">

    <div>
        <h1 class="font-black text-gray-800 text-xl">Export Laporan PDF</h1>
        <p class="text-gray-400 text-sm mt-0.5">Laporan yang Anda tangani sendiri</p>
    </div>

    {{-- Statistik --}}
    <div class="grid grid-cols-2 sm:grid-cols-5 gap-3">
        @foreach([
            ['label'=>'Total Ditangani','value'=>$stats['total'],'color'=>'#7c3aed','bg'=>'#f5f3ff'],
            ['label'=>'Belum Ditindak','value'=>$stats['menunggu'],'color'=>'#d97706','bg'=>'#fffbeb'],
            ['label'=>'Sedang Ditindak','value'=>$stats['proses'],'color'=>'#2563eb','bg'=>'#eff6ff'],
            ['label'=>'Selesai','value'=>$stats['selesai'],'color'=>'#16a34a','bg'=>'#f0fdf4'],
            ['label'=>'Ditolak','value'=>$stats['ditolak'],'color'=>'#dc2626','bg'=>'#fef2f2'],
        ] as $s)
        <div class="rounded-2xl border p-4 text-center" style="background:{{ $s['bg'] }}; border-color:{{ $s['bg'] }};">
            <div class="text-2xl font-black mb-1" style="color:{{ $s['color'] }}">{{ $s['value'] }}</div>
            <div class="text-xs font-medium" style="color:{{ $s['color'] }}; opacity:.7;">{{ $s['label'] }}</div>
        </div>
        @endforeach
    </div>

    {{-- Form Export --}}
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
        <h2 class="font-bold text-gray-800 mb-5">Filter & Download PDF</h2>
        <form method="POST" action="{{ route('petugas.laporan.export') }}" target="_blank" class="space-y-5" enctype="multipart/form-data">
            @csrf

            {{-- Tipe Filter --}}
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-3">Periode</label>
                <div class="flex flex-wrap gap-2">
                    @foreach(['harian'=>'Harian','mingguan'=>'Mingguan','bulanan'=>'Bulanan','tahunan'=>'Tahunan','custom'=>'Rentang Tanggal'] as $val => $lbl)
                    <label class="cursor-pointer">
                        <input type="radio" name="filter_tipe" value="{{ $val }}" class="sr-only filter-radio"
                               {{ $val === 'bulanan' ? 'checked' : '' }}>
                        <span class="filter-tab inline-block px-4 py-2 rounded-xl text-sm font-semibold border-2 transition
                            {{ $val === 'bulanan' ? 'border-violet-500 bg-violet-50 text-violet-700' : 'border-gray-200 bg-gray-50 text-gray-600' }}">
                            {{ $lbl }}
                        </span>
                    </label>
                    @endforeach
                </div>
            </div>

            {{-- Panel Harian --}}
            <div id="panel-harian" class="hidden">
                <label class="block text-sm font-semibold text-gray-700 mb-2">Tanggal</label>
                <input type="date" id="tanggal_harian" value="{{ now()->toDateString() }}"
                       class="w-full sm:w-64 border border-gray-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-violet-100 focus:border-violet-400 transition">
            </div>

            {{-- Panel Mingguan --}}
            <div id="panel-mingguan" class="hidden">
                <div class="grid grid-cols-2 gap-4 max-w-sm">
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Minggu ke-</label>
                        <input type="number" name="minggu" min="1" max="53" value="{{ now()->weekOfYear }}"
                               class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-violet-100 focus:border-violet-400 transition">
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Tahun</label>
                        <input type="number" id="tahun_minggu" min="2020" max="2099" value="{{ now()->year }}"
                               class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-violet-100 focus:border-violet-400 transition">
                    </div>
                </div>
            </div>

            {{-- Panel Bulanan --}}
            <div id="panel-bulanan">
                <div class="grid grid-cols-2 gap-4 max-w-sm">
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Bulan</label>
                        <select name="bulan" class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-violet-100 focus:border-violet-400 transition bg-white">
                            @foreach(['Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember'] as $i => $bln)
                            <option value="{{ $i+1 }}" {{ $i+1 == now()->month ? 'selected' : '' }}>{{ $bln }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Tahun</label>
                        <input type="number" name="tahun" min="2020" max="2099" value="{{ now()->year }}"
                               class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-violet-100 focus:border-violet-400 transition">
                    </div>
                </div>
            </div>

            {{-- Panel Tahunan --}}
            <div id="panel-tahunan" class="hidden">
                <label class="block text-sm font-semibold text-gray-700 mb-2">Tahun</label>
                <input type="number" id="tahun_only" min="2020" max="2099" value="{{ now()->year }}"
                       class="w-full sm:w-40 border border-gray-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-violet-100 focus:border-violet-400 transition">
            </div>

            {{-- Panel Custom --}}
            <div id="panel-custom" class="hidden">
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 max-w-lg">
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Dari Tanggal</label>
                        <input type="date" id="tanggal_dari_custom"
                               class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-violet-100 focus:border-violet-400 transition">
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Sampai Tanggal</label>
                        <input type="date" name="tanggal_sampai"
                               class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-violet-100 focus:border-violet-400 transition">
                    </div>
                </div>
            </div>

            {{-- Hidden inputs untuk dikirim ke controller --}}
            <input type="hidden" name="tanggal_dari" id="input_tanggal_dari">

            <div class="border-t border-gray-100 pt-5 grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Status</label>
                    <select name="status" class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-violet-100 focus:border-violet-400 transition bg-white">
                        <option value="">Semua Status</option>
                        <option value="menunggu">Belum Ditindak</option>
                        <option value="proses">Sedang Ditindak</option>
                        <option value="selesai">Selesai</option>
                        <option value="ditolak">Ditolak</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Pelapor</label>
                    <select name="masyarakat_id" class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-violet-100 focus:border-violet-400 transition bg-white">
                        <option value="">Semua Masyarakat</option>
                        @foreach($masyarakat as $m)
                        <option value="{{ $m->id }}">{{ $m->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>


            {{-- Upload Logo --}}
            <div class="border-t border-gray-100 pt-5">
                <p class="text-sm font-bold text-gray-700 mb-3">Logo Kop Surat <span class="text-gray-400 font-normal">(opsional — tampil di PDF)</span></p>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Logo Kiri</label>
                        <input type="file" name="logo_kiri" id="logoKiriPtg" accept="image/*" onchange="previewLogo(this,'prevKiriPtg')"
                               class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm text-gray-500 file:mr-3 file:py-1 file:px-3 file:rounded-lg file:border-0 file:bg-violet-50 file:text-violet-700 file:font-semibold hover:file:bg-violet-100 transition">
                        <div id="prevKiriPtg" class="mt-2 hidden">
                            <img class="h-14 object-contain border border-gray-200 rounded-lg p-1" src="">
                        </div>
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Logo Kanan</label>
                        <input type="file" name="logo_kanan" id="logoKananPtg" accept="image/*" onchange="previewLogo(this,'prevKananPtg')"
                               class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm text-gray-500 file:mr-3 file:py-1 file:px-3 file:rounded-lg file:border-0 file:bg-violet-50 file:text-violet-700 file:font-semibold hover:file:bg-violet-100 transition">
                        <div id="prevKananPtg" class="mt-2 hidden">
                            <img class="h-14 object-contain border border-gray-200 rounded-lg p-1" src="">
                        </div>
                    </div>
                </div>
            </div>

            <div class="flex gap-3 pt-2">
                <button type="reset" onclick="showPanel('bulanan')"
                        class="px-6 py-3 bg-gray-100 hover:bg-gray-200 text-gray-700 font-semibold rounded-xl text-sm transition">
                    Reset
                </button>
                <button type="submit"
                        class="flex-1 flex items-center justify-center gap-2 text-white font-semibold py-3 px-6 rounded-xl text-sm transition"
                        style="background:linear-gradient(135deg,#7c3aed,#6d28d9);">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                    </svg>
                    Download PDF
                </button>
            </div>
        </form>
    </div>

    {{-- Tabel Laporan yang Sudah Diselesaikan --}}
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-100 flex items-center justify-between">
            <div>
                <h2 class="font-bold text-gray-800">Laporan yang Saya Selesaikan</h2>
                <p class="text-gray-400 text-xs mt-0.5">10 laporan terakhir yang berhasil ditangani</p>
            </div>
            <span class="text-xs font-bold px-3 py-1 rounded-full bg-green-100 text-green-700">
                {{ $stats['selesai'] }} Selesai
            </span>
        </div>

        @if($laporanSelesai->isEmpty())
        <div class="py-14 text-center">
            <div class="w-12 h-12 rounded-2xl bg-gray-100 flex items-center justify-center mx-auto mb-3">
                <svg class="w-6 h-6 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                          d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
            <p class="text-gray-400 text-sm font-medium">Belum ada laporan yang diselesaikan.</p>
        </div>
        @else
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="bg-gray-50 border-b border-gray-100">
                        <th class="text-left px-6 py-3 text-xs font-bold text-gray-500 uppercase tracking-wider">Kode</th>
                        <th class="text-left px-6 py-3 text-xs font-bold text-gray-500 uppercase tracking-wider">Judul</th>
                        <th class="text-left px-6 py-3 text-xs font-bold text-gray-500 uppercase tracking-wider">Pelapor</th>
                        <th class="text-left px-6 py-3 text-xs font-bold text-gray-500 uppercase tracking-wider">Kategori</th>
                        <th class="text-left px-6 py-3 text-xs font-bold text-gray-500 uppercase tracking-wider">Wilayah</th>
                        <th class="text-left px-6 py-3 text-xs font-bold text-gray-500 uppercase tracking-wider">Tgl Selesai</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @foreach($laporanSelesai as $p)
                    <tr class="hover:bg-gray-50 transition">
                        <td class="px-6 py-4">
                            <span class="font-mono text-xs bg-green-50 text-green-700 px-2 py-1 rounded-lg font-bold">
                                {{ $p->kode_laporan }}
                            </span>
                        </td>
                        <td class="px-6 py-4">
                            <a href="{{ route('petugas.pengaduan.show', $p->slug) }}"
                               class="font-semibold text-gray-700 hover:text-violet-600 transition line-clamp-1">
                                {{ $p->judul }}
                            </a>
                        </td>
                        <td class="px-6 py-4 text-gray-500">{{ $p->user?->name ?? '-' }}</td>
                        <td class="px-6 py-4 text-gray-500">{{ $p->kategori?->nama ?? '-' }}</td>
                        <td class="px-6 py-4 text-gray-500">{{ $p->wilaya?->nama ?? '-' }}</td>
                        <td class="px-6 py-4 text-gray-400 text-xs">{{ $p->updated_at->format('d M Y') }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @if($stats['selesai'] > 10)
        <div class="px-6 py-3 bg-gray-50 text-xs text-gray-400 text-center border-t border-gray-100">
            Menampilkan 10 dari {{ $stats['selesai'] }} laporan selesai. Download PDF untuk melihat semua.
        </div>
        @endif
        @endif
    </div>
</div>

@push('scripts')
<script>
const panels = ['harian','mingguan','bulanan','tahunan','custom'];

function showPanel(val) {
    panels.forEach(p => {
        document.getElementById('panel-' + p).classList.toggle('hidden', p !== val);
    });
    document.querySelectorAll('.filter-tab').forEach(t => {
        const r = t.previousElementSibling;
        if (r.value === val) {
            t.className = t.className.replace('border-gray-200 bg-gray-50 text-gray-600', 'border-violet-500 bg-violet-50 text-violet-700');
        } else {
            t.className = t.className.replace('border-violet-500 bg-violet-50 text-violet-700', 'border-gray-200 bg-gray-50 text-gray-600');
        }
    });
}

document.querySelectorAll('.filter-radio').forEach(r => r.addEventListener('change', () => showPanel(r.value)));

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

document.querySelector('form').addEventListener('submit', function() {
    const tipe = document.querySelector('.filter-radio:checked').value;
    const inputDari = document.getElementById('input_tanggal_dari');

    if (tipe === 'harian') {
        inputDari.value = document.getElementById('tanggal_harian').value;
    } else if (tipe === 'mingguan') {
        document.querySelector('[name=tahun]').value = document.getElementById('tahun_minggu').value;
    } else if (tipe === 'tahunan') {
        document.querySelector('[name=tahun]').value = document.getElementById('tahun_only').value;
    } else if (tipe === 'custom') {
        inputDari.value = document.getElementById('tanggal_dari_custom').value;
    }
});
</script>
@endpush
@endsection