<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <style>
        body { font-family: 'DejaVu Sans', sans-serif; font-size: 11px; color: #111; margin: 0; padding: 0; }
        .page { width: 100%; padding: 28px 36px; }
        .kop { border-bottom: 2px solid #111; padding-bottom: 8px; margin-bottom: 16px; }
        .kop h1 { font-size: 16px; text-align: center; margin: 2px 0; text-transform: uppercase; }
        .kop h2 { font-size: 13px; text-align: center; margin: 2px 0; }
        .kop .sub { font-size: 9px; text-align: center; color: #444; }
        .title { text-align: center; margin: 12px 0 14px; font-size: 14px; font-weight: bold; text-decoration: underline; }
        .meta { margin-bottom: 10px; font-size: 10px; }
        .meta td { padding: 2px 4px; vertical-align: top; }
        .label { font-weight: bold; width: 140px; }
        .box { border: 1px solid #111; padding: 8px 10px; margin-top: 8px; }
        .box h3 { font-size: 11px; margin: 0 0 6px; text-transform: uppercase; }
        .content { font-size: 10px; line-height: 1.5; }
        .footer { margin-top: 24px; text-align: right; font-size: 10px; }
        .ttd { margin-top: 28px; width: 100%; }
        .ttd td { vertical-align: top; }
        .ttd .nama { font-weight: bold; text-decoration: underline; margin-top: 70px; }
    </style>
</head>
<body>
    <div class="page">
        <div class="kop">
            <h1>PEMERINTAH KABUPATEN TANAH DATAR</h1>
            <h2>BADAN PENGEMBANGAN SUMBER DAYA MANUSIA</h2>
            <div class="sub">Sistem Informasi Pengaduan Masyarakat BatusangkarLapor</div>
        </div>

        <div class="title">SURAT PENYERAHAN LAPORAN</div>

        <table class="meta" width="100%">
            <tr>
                <td class="label">Nomor</td>
                <td>: {{ $pengaduan->kode_laporan }}</td>
            </tr>
            <tr>
                <td class="label">Perihal</td>
                <td>: Penyerahan laporan pengaduan masyarakat</td>
            </tr>
            <tr>
                <td class="label">Tanggal</td>
                <td>: {{ $tanggalCetak }}</td>
            </tr>
            <tr>
                <td class="label">Pelapor</td>
                <td>: {{ $namaPelapor }}</td>
            </tr>
            <tr>
                <td class="label">Kategori</td>
                <td>: {{ $pengaduan->kategori->nama ?? '-' }}</td>
            </tr>
            <tr>
                <td class="label">Wilayah</td>
                <td>: {{ $pengaduan->wilaya->nama ?? '-' }}</td>
            </tr>
            <tr>
                <td class="label">Status</td>
                <td>: {{ ['menunggu' => 'Menunggu', 'proses' => 'Proses', 'selesai' => 'Selesai', 'ditolak' => 'Ditolak'][$pengaduan->status] ?? $pengaduan->status }}</td>
            </tr>
        </table>

        <div class="box">
            <h3>Data Laporan</h3>
            <div class="content">
                <strong>Judul</strong>: {{ $pengaduan->judul }}<br>
                <strong>Deskripsi</strong>: {{ $pengaduan->deskripsi }}
            </div>
        </div>

        <div class="box">
            <h3>Catatan Penyerahan</h3>
            <div class="content">
                Laporan ini diserahkan untuk diproses lebih lanjut oleh instansi atau dinas terkait sesuai dengan wilayah dan kategori pengaduan.
            </div>
        </div>

        <table class="ttd" width="100%">
            <tr>
                <td width="60%"></td>
                <td style="text-align:center;">
                    <div>Batusangkar, {{ $tanggalCetak }}</div>
                    <div style="margin-top:70px; font-weight:bold; text-decoration:underline;">{{ $namaPelapor }}</div>
                    <div>Pelapor</div>
                </td>
            </tr>
        </table>

        <div class="footer">
            Dokumen ini dicetak otomatis oleh sistem BatusangkarLapor.
        </div>
    </div>
</body>
</html>
