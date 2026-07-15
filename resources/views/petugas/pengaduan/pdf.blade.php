<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <style>
        @page {
            size: A4 portrait;
            margin: 2cm;
        }
        html, body {
            margin: 0;
            padding: 0;
            width: auto;
            min-height: 100%;
        }
        * {
            box-sizing: border-box;
        }

        body {
            font-family: 'Times New Roman', Times, serif;
            font-size: 8.5px;
            color: #111;
            line-height: 1.12;
            margin: 0;
            padding: 0;
        }

        .page {
            width: auto;
            min-height: auto;
            padding: 2cm;
            box-sizing: border-box;
        }

        table {
            border-collapse: collapse;
            page-break-inside: avoid;
            width: 100%;
            border-spacing: 0;
        }

        img {
            max-width: 100%;
            max-height: 100px;
            height: auto;
            display: block;
            object-fit: contain;
        }

        table { border-collapse: collapse; page-break-inside: avoid; }

        /* =============== KOP SURAT (native table, bukan CSS display:table) =============== */
        table.kop-table { width: 100%; table-layout: fixed; border-bottom: 2px solid #1a1a1a; padding-bottom: 4px; margin-bottom: 4px; page-break-inside: avoid; }
        table.kop-table td { vertical-align: top; padding: 0; }
        .kop-logo-cell { width: 44px; text-align: center; padding-top: 2px; }
        .kop-logo-badge {
            width: 42px; height: 42px; border-radius: 50%;
            background-color: #003580; color: #ffffff;
            font-weight: bold; font-size: 16px;
            text-align: center; line-height: 42px;
        }
        .kop-text-cell { text-align: center; padding: 0 4px; }
        .kop-text-cell .prop { font-size: 7.6px; letter-spacing: 1.6px; font-weight: bold; }
        .kop-text-cell .kabupaten { font-size: 12px; font-weight: bold; text-transform: uppercase; letter-spacing: 0.35px; }
        .kop-text-cell .unit { font-size: 8.2px; font-weight: bold; margin-top: 1px; color: #003580; }
        .kop-text-cell .alamat { font-size: 6.6px; color: #444; margin-top: 2px; }
        .kop-spacer-cell { width: 18px; }

        /* =============== META BARIS (native table) =============== */
        table.meta-table { width: 100%; margin: 5px 0 3px 0; font-size: 8.4px; }
        table.meta-table td { padding: 0; vertical-align: top; }
        table.meta-table td:first-child { width: 64%; }
        table.meta-table td.meta-right { width: 36%; text-align: right; }
        table.meta-table .meta-right { text-align: right; }
        .kode-mono { font-family: 'Courier New', monospace; }

        .judul-wrap { text-align: center; margin: 4px 0 2px 0; }
        .judul { font-weight: bold; font-size: 12px; text-decoration: underline; text-transform: uppercase; margin-bottom: 2px; }
        .judul-sub { font-size: 7.8px; font-family: 'Courier New', monospace; color: #333; margin-top: 1px; }

        .tujuan { margin: 4px 0 2px 0; font-size: 8.4px; }
        .tujuan p { margin: 0; }
        .perihal { margin: 2px 0 4px 0; font-size: 8.4px; font-weight: bold; }
        .pembuka { font-size: 8.6px; text-align: justify; margin-bottom: 6px; }

        .section-title {
            font-weight: bold; font-size: 9.2px; margin: 6px 0 2px 0;
            padding-bottom: 1px; border-bottom: 1px solid #999;
            text-transform: uppercase;
        }

        /* =============== INFO / DATA TABLES =============== */
        table.kv-table { width: 100%; border: 1px solid #999; background: #fafafa; font-size: 8.4px; }
        table.kv-table td { padding: 2px 3px; vertical-align: top; }
        table.kv-table td.kv-label { font-weight: bold; width: 24%; white-space: nowrap; }
        table.kv-table td.kv-sep { width: 4px; }

        .field-title { font-weight: bold; font-size: 8.6px; margin: 0 0 2px 0; }
        .field-value { font-size: 8.6px; text-align: justify; margin: 0 0 4px 0; }
        .field-value.strong { font-weight: bold; }

        /* =============== TABEL RIWAYAT =============== */
        table.data-table { width: 100%; border: 1px solid #1a1a1a; margin: 3px 0 2px 0; font-size: 8.6px; }
        table.data-table th {
            background-color: #003580; color: #ffffff; border: 1px solid #1a1a1a;
            padding: 3px 4px; font-size: 8.2px; font-weight: bold; text-align: center;
        }
        table.data-table td { border: 1px solid #999; padding: 3px 4px; font-size: 8.2px; }

        /* =============== LAMPIRAN (grid via native table, thumbnail terkontrol) =============== */
        table.lampiran-grid { width: 100%; margin: 3px 0; }
        table.lampiran-grid td {
            width: 50%; border: 1px solid #999; padding: 3px; text-align: center; vertical-align: top;
        }
        .lampiran-grid .lbl { font-size: 7.8px; font-weight: bold; display: block; margin-bottom: 2px; text-align: left; }
        .lampiran-grid .filename { font-size: 7px; color: #666; margin-top: 2px; }

        .penutup { margin: 6px 0 3px 0; font-size: 8.6px; text-align: justify; }

        /* =============== TANDA TANGAN (native table) =============== */
        table.ttd-table { width: 100%; margin-top: 10px; }
        table.ttd-table td { width: 50%; text-align: center; vertical-align: top; font-size: 9px; }
        .ttd-table .jabatan { font-weight: bold; font-size: 8.8px; margin-bottom: 30px; }
        .ttd-table .nama { font-weight: bold; font-size: 9.6px; text-decoration: underline; }
        .ttd-table .nip { font-size: 8px; color: #333; margin-top: 1px; }

        .verifikasi {
            margin-top: 12px; border-top: 1px dashed #999; padding-top: 4px;
            font-size: 7.4px; color: #555; text-align: center;
        }
        .kode-verif { font-family: 'Courier New', monospace; font-weight: bold; color: #333; }

        .footer {
            margin-top: 6px; padding-top: 4px; border-top: 1px solid #ccc;
            font-size: 7.2px; text-align: center; color: #777;
        }
        .footer p { margin: 0; }
    </style>
</head>
<body>
<div class="page">
    {{-- KOP SURAT --}}
    <table class="kop-table">
        <tr>
            <td class="kop-logo-cell">
            </td>
            <td class="kop-text-cell">
                <div class="prop">PEMERINTAH KABUPATEN TANAH DATAR</div>
                <div class="kabupaten">Kabupaten Tanah Datar</div>
                <div class="unit">SISTEM INFORMASI PENGADUAN MASYARAKAT (SIPM) BATUSANGKARLAPOR</div>
                <div class="alamat">Jl. Sultan Alam Bagagarsyah No. 4, Batusangkar 27213 &nbsp;&bull;&nbsp; Telp. (0752) 71038 &nbsp;&bull;&nbsp; batusangkarlapor.go.id</div>
            </td>
            <td class="kop-spacer-cell">&nbsp;</td>
        </tr>
    </table>

    {{-- META --}}
    <table class="meta-table">
        <tr>
            <td>Sifat&nbsp;: Resmi &nbsp;&nbsp;|&nbsp;&nbsp; Lampiran&nbsp;: {{ count($lampiran ?? []) }} berkas</td>
            <td class="meta-right">Nomor: <span class="kode-mono">{{ $pengaduan->kode_laporan }}/SIPM-BATUSANGKAR/{{ now()->format('Y') }}</span></td>
        </tr>
    </table>

    <div class="judul-wrap">
        <div class="judul">Surat Penyerahan Laporan Pengaduan</div>
        <div class="judul-sub">Ref: {{ $pengaduan->kode_laporan }}</div>
    </div>

    <div class="tujuan">
        <p>Kepada Yth. Kepala Dinas Terkait,</p>
        <p>di Tempat</p>
    </div>

    <div class="perihal">Perihal&nbsp;: Penyerahan Laporan Pengaduan Masyarakat</div>

    <p class="pembuka">Dengan hormat, bersama surat ini kami sampaikan detail laporan pengaduan masyarakat yang telah diterima dan tercatat pada Sistem Informasi Pengaduan Masyarakat BatusangkarLapor, untuk dapat ditindaklanjuti sebagaimana mestinya.</p>

    {{-- INFO UMUM --}}
    <table class="kv-table">
        <tr>
            <td class="kv-label">Tanggal Laporan</td><td class="kv-sep">:</td>
            <td>{{ $pengaduan->created_at->translatedFormat('d F Y, H:i') }} WIB</td>
            <td class="kv-label">Status Saat Ini</td><td class="kv-sep">:</td>
            <td>
                @php
                    $statusMap = ['menunggu' => 'Belum Ditindak', 'proses' => 'Sedang Ditindak', 'selesai' => 'Selesai', 'ditolak' => 'Ditolak'];
                @endphp
                <strong>{{ strtoupper($statusMap[$pengaduan->status] ?? $pengaduan->status) }}</strong>
            </td>
        </tr>
        <tr>
            <td class="kv-label">Nomor Referensi</td><td class="kv-sep">:</td>
            <td>{{ $pengaduan->kode_laporan }}</td>
            <td class="kv-label">Token Pelacakan</td><td class="kv-sep">:</td>
            <td>{{ $pengaduan->tracking_token }}</td>
        </tr>
    </table>

    {{-- DATA PELAPOR --}}
    <p class="section-title">I. Data Pelapor</p>
    <table class="kv-table">
        <tr>
            <td class="kv-label">Nama Pelapor</td><td class="kv-sep">:</td>
            <td>{{ $pengaduan->is_anonim ? 'ANONIM' : ($pengaduan->user->name ?? '-') }}</td>
            <td class="kv-label">Kategori</td><td class="kv-sep">:</td>
            <td>{{ $pengaduan->kategori->nama ?? '-' }}</td>
        </tr>
        <tr>
            <td class="kv-label">Email</td><td class="kv-sep">:</td>
            <td>{{ $pengaduan->is_anonim ? '-' : ($pengaduan->user->email ?? '-') }}</td>
            <td class="kv-label">Wilayah</td><td class="kv-sep">:</td>
            <td>{{ $pengaduan->wilaya->nama ?? '-' }}</td>
        </tr>
        <tr>
            <td class="kv-label">Visibilitas</td><td class="kv-sep">:</td>
            <td colspan="4">{{ $pengaduan->is_publik ? 'PUBLIK' : 'PRIVAT' }}</td>
        </tr>
    </table>

    {{-- DETAIL LAPORAN --}}
    <p class="section-title">II. Detail Laporan</p>
    <div class="field-title">Judul Laporan</div>
    <p class="field-value strong">{{ $pengaduan->judul }}</p>
    <div class="field-title">Deskripsi Masalah</div>
    <p class="field-value">{{ $pengaduan->deskripsi }}</p>

    {{-- RIWAYAT --}}
    <p class="section-title">III. Riwayat Penanganan</p>
    <table class="data-table">
        <thead>
            <tr>
                <th style="width: 6%">No</th>
                <th style="width: 20%">Status</th>
                <th style="width: 18%">Tanggal</th>
                <th style="width: 56%">Keterangan</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td style="text-align: center;">1</td>
                <td>Laporan Dibuat</td>
                <td>{{ $pengaduan->created_at->translatedFormat('d M Y, H:i') }}</td>
                <td>Laporan baru diterima dan terdaftar dalam sistem</td>
            </tr>
            @foreach($pengaduan->histories as $i => $h)
            <tr>
                <td style="text-align: center;">{{ $i + 2 }}</td>
                <td>{{ ucfirst($h->status_baru) }}</td>
                <td>{{ $h->created_at->translatedFormat('d M Y, H:i') }}</td>
                <td>{{ $h->keterangan ?? '-' }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    {{-- LAMPIRAN: grid 2 kolom, thumbnail ukuran tetap agar tidak memenuhi halaman --}}
    @if(count($lampiran) > 0)
    <p class="section-title">IV. Lampiran Laporan</p>
    @php $lampiranRows = array_chunk($lampiran, 2); $lampiranIdx = 0; @endphp
    <table class="lampiran-grid">
        @foreach($lampiranRows as $row)
        <tr>
            @foreach($row as $file)
            @php $lampiranIdx++; @endphp
            <td>
                <span class="lbl">Lampiran {{ $lampiranIdx }}: {{ $file['nama'] }}</span>
                @if($file['isImage'])
                    <img src="{{ str_replace('\\', '/', storage_path('app/public/' . $file['path'])) }}" width="200" height="120" style="border:1px solid #ccc;">
                @else
                    <div class="filename">File terlampir pada sistem (bukan gambar)</div>
                @endif
            </td>
            @endforeach
            @if(count($row) === 1)<td>&nbsp;</td>@endif
        </tr>
        @endforeach
    </table>
    @endif

    @if($pengaduan->bukti_selesai_path)
    <p class="section-title">V. Bukti Penyelesaian</p>
    @php $isProofImage = preg_match('/\.(jpg|jpeg|png|gif|webp)$/i', $pengaduan->bukti_selesai_nama ?? ''); @endphp
    <table class="lampiran-grid">
        <tr>
            <td>
                <span class="lbl">{{ $pengaduan->bukti_selesai_nama ?? basename($pengaduan->bukti_selesai_path) }}</span>
                @if($isProofImage)
                    <img src="{{ str_replace('\\', '/', storage_path('app/public/' . $pengaduan->bukti_selesai_path)) }}" width="200" height="120" style="border:1px solid #ccc;">
                @else
                    <div class="filename">File bukti telah dilampirkan di sistem.</div>
                @endif
            </td>
            <td>&nbsp;</td>
        </tr>
    </table>
    @endif

    {{-- PENUTUP --}}
    <p class="penutup">Demikian laporan detail pengaduan masyarakat ini kami buat dengan sebenar-benarnya untuk dipergunakan sebagaimana mestinya dan sebagai bahan rujukan dalam penindaklanjutan lebih lanjut. Atas perhatian dan kerja samanya, kami ucapkan terima kasih.</p>

    {{-- TANDA TANGAN --}}
    <table class="ttd-table">
        <tr>
            <td>
                <div>Batusangkar, {{ $tanggalCetak }}</div>
                <div class="jabatan">Petugas Penanganan Laporan</div>
                <div class="nama">{{ $petugas->name }}</div>
                
            </td>
            <td>
                <div>Mengetahui,</div>
                <div class="jabatan">Kepala SIPM BatusangkarLapor</div>
                <div class="nama">_______________________</div>
                <div class="nip">NIP: _______________________</div>
            </td>
        </tr>
    </table>

    <div class="verifikasi">
        Dokumen ini dapat diverifikasi keasliannya melalui token pelacakan <span class="kode-verif">{{ $pengaduan->tracking_token }}</span> pada laman resmi batusangkarlapor.go.id
    </div>

    <div class="footer">
        <p>Dokumen ini dicetak otomatis oleh Sistem Informasi Pengaduan Masyarakat (SIPM) BatusangkarLapor pada {{ $tanggalCetak }}</p>
        <p>Pemerintah Kabupaten Tanah Datar &copy; {{ now()->format('Y') }}</p>
    </div>
</div>

</body>
</html>