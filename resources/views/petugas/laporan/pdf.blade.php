<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<style>
    * { margin: 0; padding: 0; box-sizing: border-box; }
    body { font-family: 'DejaVu Sans', sans-serif; font-size: 10px; color: #000; background: #fff; }

    .kop { padding: 10px 30px 8px; border-bottom: 3px solid #000; }
    .kop-inner { display: flex; align-items: center; }
    .kop-logo { width: 65px; height: 65px; flex-shrink: 0; text-align: center; }
    .kop-logo img { width: 65px; height: 65px; object-fit: contain; }
    .kop-logo-empty { width: 65px; height: 65px; flex-shrink: 0; }
    .kop-text { text-align: center; flex: 1; padding: 0 10px; }
    .kop-text .prop   { font-size: 9px; }
    .kop-text .kab    { font-size: 15px; font-weight: bold; letter-spacing: 1px; text-transform: uppercase; }
    .kop-text .unit   { font-size: 10px; font-weight: bold; }
    .kop-text .alamat { font-size: 7.5px; color: #333; margin-top: 2px; }
    .garis2 { border-top: 1px solid #000; margin: 3px 30px 0; }

    .judul-dok { text-align: center; margin: 12px 30px 8px; }
    .judul-dok .nomor   { font-size: 8.5px; margin-bottom: 4px; }
    .judul-dok h2       { font-size: 11px; font-weight: bold; text-transform: uppercase; letter-spacing: 1px; text-decoration: underline; }
    .judul-dok .periode { font-size: 8.5px; margin-top: 3px; color: #333; }

    .info-box { margin: 0 30px 8px; border: 1px solid #000; padding: 5px 8px; }
    .info-tbl { width: 100%; border: none; border-collapse: collapse; }
    .info-tbl td { font-size: 8.5px; padding: 1px 3px; border: none; background: transparent; }
    .info-tbl .lbl { font-weight: bold; width: 100px; }

    .stats-wrap { margin: 0 30px 8px; }
    .stats-wrap table { width: 100%; border-collapse: collapse; border: 1px solid #000; }
    .stats-wrap th { background: #e0e0e0; border: 1px solid #000; padding: 4px; font-size: 8px; text-align: center; font-weight: bold; }
    .stats-wrap td { border: 1px solid #000; padding: 4px; font-size: 9px; text-align: center; font-weight: bold; }

    .tabel-wrap { margin: 0 30px; }
    .tabel-wrap table { width: 100%; border-collapse: collapse; border: 1px solid #000; }
    .tabel-wrap thead tr { background: #c8c8c8; }
    .tabel-wrap thead th { border: 1px solid #000; padding: 4px 3px; font-size: 8px; font-weight: bold; text-align: center; }
    .tabel-wrap tbody td { border: 1px solid #000; padding: 3px 3px; font-size: 7.5px; vertical-align: top; }
    .tabel-wrap tbody tr:nth-child(even) { background: #f5f5f5; }
    .total-row { margin: 3px 30px 0; font-size: 8px; font-weight: bold; text-align: right; }

    .penutup  { margin: 12px 30px 0; font-size: 8.5px; line-height: 1.6; }
    .ttd-wrap { margin: 10px 30px 0; display: flex; justify-content: flex-end; }
    .ttd-box  { text-align: center; font-size: 8.5px; width: 190px; }
    .ttd-jabatan { font-weight: bold; margin-bottom: 55px; margin-top: 2px; }
    .ttd-nama    { font-weight: bold; text-decoration: underline; }
    .ttd-nip     { font-size: 7.5px; margin-top: 2px; }
    .footer { margin: 14px 30px 0; padding-top: 5px; border-top: 1px solid #aaa; display: flex; justify-content: space-between; font-size: 7px; color: #666; }
</style>
</head>
<body>

{{-- ══ KOP SURAT ══ --}}
<table style="width:100%; border-collapse:collapse; border-bottom:3px solid #000; margin-bottom:0;">
    <tr>
        <td style="width:70px; vertical-align:middle; padding:8px 5px 8px 30px;">
            @if(!empty($logoKiri))
                <img src="{{ $logoKiri }}" style="width:62px; height:62px; object-fit:contain; display:block;">
            @endif
        </td>
        <td style="text-align:center; vertical-align:middle; padding:8px 8px;">
            <div style="font-size:9px;">PEMERINTAH KABUPATEN TANAH DATAR</div>
            <div style="font-size:15px; font-weight:bold; letter-spacing:1px; text-transform:uppercase; margin:1px 0;">Kabupaten Tanah Datar</div>
            <div style="font-size:9.5px; font-weight:bold;">Sistem Informasi Pengaduan Masyarakat — BatusangkarLapor</div>
            <div style="font-size:7.5px; color:#333; margin-top:2px;">Jl. Sultan Alam Bagagarsyah No. 4, Batusangkar, Sumatera Barat 27213</div>
            <div style="font-size:7.5px; color:#333;">Telp. (0752) 71038 &nbsp;|&nbsp; batusangkarlapor.go.id</div>
        </td>
        <td style="width:70px; vertical-align:middle; padding:8px 30px 8px 5px; text-align:right;">
            @if(!empty($logoKanan))
                <img src="{{ $logoKanan }}" style="width:62px; height:62px; object-fit:contain; display:block; margin-left:auto;">
            @endif
        </td>
    </tr>
</table>
<div style="border-top:1px solid #000; margin:1px 30px 0;"></div>

{{-- ══ JUDUL ══ --}}
<div class="judul-dok">
    <div class="nomor">Nomor: {{ $nomorSurat }}</div>
    <h2>Laporan Kinerja Penanganan Pengaduan</h2>
    <div class="periode">
        Petugas: {{ $dicetak_oleh }} &nbsp;|&nbsp; Wilayah: {{ $wilaya }}
        @if(!empty($filterInfo)) &nbsp;|&nbsp; {{ implode(' | ', $filterInfo) }} @endif
    </div>
</div>

{{-- ══ INFO ══ --}}
<div class="info-box">
    <table class="info-tbl">
        <tr>
            <td class="lbl">Nama Petugas</td><td>: {{ $dicetak_oleh }}</td>
            <td style="width:30px"></td>
            <td class="lbl">Tanggal Cetak</td><td>: {{ $dicetak_at }}</td>
        </tr>
        <tr>
            <td class="lbl">Wilayah Tugas</td><td>: {{ $wilaya }}</td>
            <td></td>
            <td class="lbl">Jumlah Data</td><td>: {{ $pengaduans->count() }} laporan</td>
        </tr>
    </table>
</div>

{{-- ══ STATISTIK ══ --}}
@php
    $total    = $pengaduans->count();
    $menunggu = $pengaduans->where('status','menunggu')->count();
    $proses   = $pengaduans->where('status','proses')->count();
    $selesai  = $pengaduans->where('status','selesai')->count();
    $ditolak  = $pengaduans->where('status','ditolak')->count();
    $persen   = $total > 0 ? round(($selesai / $total) * 100, 1) : 0;
@endphp
<div class="stats-wrap">
    <table>
        <thead>
            <tr>
                <th>Total Ditangani</th><th>Belum Ditindak</th><th>Sedang Ditindak</th>
                <th>Selesai</th><th>Ditolak</th><th>Tingkat Penyelesaian</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>{{ $total }}</td><td>{{ $menunggu }}</td><td>{{ $proses }}</td>
                <td>{{ $selesai }}</td><td>{{ $ditolak }}</td><td>{{ $persen }}%</td>
            </tr>
        </tbody>
    </table>
</div>

{{-- ══ TABEL DATA ══ --}}
<div class="tabel-wrap" style="margin-top:8px;">
    @if($pengaduans->isEmpty())
        <p style="text-align:center;padding:18px;font-style:italic;font-size:9px;">Tidak ada data untuk filter yang dipilih.</p>
    @else
    <table>
        <thead>
            <tr>
                <th style="width:3%">No</th>
                <th style="width:13%">Kode Laporan</th>
                <th style="width:22%">Judul Laporan</th>
                <th style="width:14%">Pelapor</th>
                <th style="width:11%">Kategori</th>
                <th style="width:10%">Wilayah</th>
                <th style="width:9%">Tgl Lapor</th>
                <th style="width:11%">Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach($pengaduans as $i => $p)
            <tr>
                <td style="text-align:center;">{{ $i + 1 }}</td>
                <td style="font-family:monospace;font-size:7px;text-align:center;">{{ $p->kode_laporan }}</td>
                <td>{{ Str::limit($p->judul, 55) }}</td>
                <td>{{ $p->user?->name ?? '-' }}</td>
                <td style="text-align:center;">{{ $p->kategori?->nama ?? '-' }}</td>
                <td style="text-align:center;">{{ $p->wilaya?->nama ?? '-' }}</td>
                <td style="text-align:center;">{{ $p->created_at->format('d/m/Y') }}</td>
                <td style="text-align:center;font-weight:bold;">
                    {{ ['menunggu'=>'Belum Ditindak','proses'=>'Sedang Ditindak','selesai'=>'Selesai','ditolak'=>'Ditolak'][$p->status] ?? $p->status }}
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    <div class="total-row">Total: {{ $pengaduans->count() }} laporan</div>
    @endif
</div>

<div class="penutup">
    <p>Demikian laporan kinerja penanganan pengaduan masyarakat ini dibuat dengan sebenar-benarnya untuk dipergunakan sebagaimana mestinya.</p>
</div>

<div class="ttd-wrap">
    <div class="ttd-box">
        <p>Batusangkar, {{ now()->format('d F Y') }}</p>
        <p class="ttd-jabatan">Petugas Lapangan</p>
        <p class="ttd-nama">{{ $dicetak_oleh }}</p>
        <p class="ttd-nip">NIP. ................................</p>
    </div>
</div>

<div class="footer">
    <span>Dokumen ini dicetak secara otomatis oleh Sistem BatusangkarLapor</span>
    <span>Pemerintah Kabupaten Tanah Datar &copy; {{ now()->year }}</span>
</div>

</body>
</html>