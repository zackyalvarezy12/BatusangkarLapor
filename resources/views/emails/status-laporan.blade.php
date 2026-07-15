<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Status Laporan Diperbarui</title>
<style>
    * { margin: 0; padding: 0; box-sizing: border-box; }
    body { font-family: 'Segoe UI', Arial, sans-serif; background: #f0f4f8; color: #1a202c; }
    .wrapper { max-width: 580px; margin: 32px auto; background: #fff; border-radius: 16px; overflow: hidden; box-shadow: 0 4px 24px rgba(0,0,0,.08); }

    .header { background: linear-gradient(135deg, #1a3a6b 0%, #2352a0 100%); padding: 32px 36px; text-align: center; }
    .header .logo { display: inline-flex; align-items: center; gap: 10px; margin-bottom: 6px; }
    .header .logo-icon { width: 40px; height: 40px; background: rgba(255,255,255,.15); border-radius: 10px; display: flex; align-items: center; justify-content: center; }
    .header h1 { font-size: 22px; font-weight: 800; color: #fff; letter-spacing: -.3px; }
    .header p  { font-size: 12px; color: rgba(255,255,255,.6); margin-top: 2px; }

    .body { padding: 32px 36px; }

    .greeting { font-size: 15px; color: #374151; margin-bottom: 18px; }
    .greeting strong { color: #1a3a6b; }

    .status-badge { display: inline-block; padding: 5px 14px; border-radius: 99px; font-size: 12px; font-weight: 700; letter-spacing: .3px; }
    .status-menunggu { background: #fef3c7; color: #92400e; }
    .status-proses   { background: #dbeafe; color: #1e40af; }
    .status-selesai  { background: #d1fae5; color: #065f46; }
    .status-ditolak  { background: #fee2e2; color: #991b1b; }

    .info-card { background: #f8faff; border: 1px solid #e5e7f0; border-radius: 12px; padding: 20px; margin: 20px 0; }
    .info-row { display: flex; justify-content: space-between; align-items: flex-start; padding: 8px 0; border-bottom: 1px solid #eef0f6; }
    .info-row:last-child { border-bottom: none; padding-bottom: 0; }
    .info-label { font-size: 12px; color: #6b7280; font-weight: 600; width: 130px; flex-shrink: 0; }
    .info-value { font-size: 13px; color: #1f2937; font-weight: 500; text-align: right; flex: 1; }

    .arrow { display: inline-flex; align-items: center; gap: 8px; font-size: 13px; }
    .arrow .from { opacity: .5; text-decoration: line-through; }
    .arrow .sep  { color: #9ca3af; }

    .keterangan { background: #fffbeb; border-left: 3px solid #f59e0b; border-radius: 0 8px 8px 0; padding: 12px 16px; margin: 16px 0; font-size: 13px; color: #78350f; line-height: 1.6; }

    .cta { text-align: center; margin: 28px 0 16px; }
    .btn { display: inline-block; background: linear-gradient(135deg, #1a3a6b, #2352a0); color: #fff !important; text-decoration: none; font-size: 14px; font-weight: 700; padding: 13px 32px; border-radius: 10px; letter-spacing: .2px; }

    .tracking { background: #f3f4f6; border-radius: 8px; padding: 12px 16px; text-align: center; margin: 16px 0; }
    .tracking p { font-size: 11px; color: #6b7280; margin-bottom: 4px; }
    .tracking code { font-size: 15px; font-weight: 700; color: #1a3a6b; letter-spacing: 2px; font-family: monospace; }

    .footer { padding: 20px 36px 28px; text-align: center; font-size: 11px; color: #9ca3af; line-height: 1.7; border-top: 1px solid #f0f0f0; }
    .footer a { color: #6b7280; text-decoration: none; }
</style>
</head>
<body>
<div class="wrapper">

    {{-- Header --}}
    <div class="header">
        <div class="logo">
            <div class="logo-icon">
                <svg width="20" height="20" fill="none" stroke="white" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-2 10v-5a1 1 0 00-1-1h-2a1 1 0 00-1 1v5m4 0H9"/>
                </svg>
            </div>
            <h1>BatusangkarLapor</h1>
        </div>
        <p>Sistem Informasi Pengaduan — Kab. Tanah Datar</p>
    </div>

    {{-- Body --}}
    <div class="body">
        <p class="greeting">
            Yth. <strong>{{ $pengaduan->is_anonim ? 'Pelapor' : ($pengaduan->user?->name ?? 'Pelapor') }}</strong>,
        </p>
        <p style="font-size:14px; color:#4b5563; line-height:1.7; margin-bottom:18px;">
            Status laporan pengaduan Anda telah diperbarui. Berikut adalah informasi terkini mengenai laporan Anda.
        </p>

        {{-- Info Card --}}
        <div class="info-card">
            <div class="info-row">
                <span class="info-label">Kode Laporan</span>
                <span class="info-value" style="font-family:monospace; font-weight:700; color:#1a3a6b;">{{ $pengaduan->kode_laporan }}</span>
            </div>
            <div class="info-row">
                <span class="info-label">Judul</span>
                <span class="info-value">{{ $pengaduan->judul }}</span>
            </div>
            <div class="info-row">
                <span class="info-label">Kategori</span>
                <span class="info-value">{{ $pengaduan->kategori?->nama ?? '-' }}</span>
            </div>
            <div class="info-row">
                <span class="info-label">Wilayah</span>
                <span class="info-value">{{ $pengaduan->wilaya?->nama ?? '-' }}</span>
            </div>
            <div class="info-row">
                <span class="info-label">Status</span>
                <span class="info-value">
                    <span class="arrow">
                        @php
                            $labelLama = ['menunggu'=>'Belum Ditindak','proses'=>'Sedang Ditindak','selesai'=>'Selesai','ditolak'=>'Ditolak'][$statusLama] ?? $statusLama;
                            $labelBaru = $pengaduan->status_badge['label'];
                        @endphp
                        <span class="from">{{ $labelLama }}</span>
                        <span class="sep">→</span>
                        <span class="status-badge status-{{ $pengaduan->status }}">{{ $labelBaru }}</span>
                    </span>
                </span>
            </div>
            <div class="info-row">
                <span class="info-label">Diperbarui</span>
                <span class="info-value">{{ now()->format('d M Y, H:i') }} WIB</span>
            </div>
        </div>

        {{-- Keterangan --}}
        @if($keterangan)
        <div class="keterangan">
            <strong style="display:block; margin-bottom:4px;">Catatan dari Petugas:</strong>
            {{ $keterangan }}
        </div>
        @endif

        {{-- Pesan khusus berdasarkan status --}}
        @if($pengaduan->status === 'selesai')
        <div style="background:#d1fae5; border-radius:10px; padding:14px 18px; margin:16px 0; font-size:13px; color:#065f46; line-height:1.6;">
            🎉 <strong>Laporan Anda telah diselesaikan!</strong> Kami harap masalah yang Anda laporkan sudah tertangani. Silakan berikan penilaian layanan kami melalui tautan di bawah.
        </div>
        @elseif($pengaduan->status === 'proses')
        <div style="background:#dbeafe; border-radius:10px; padding:14px 18px; margin:16px 0; font-size:13px; color:#1e40af; line-height:1.6;">
            ⚙️ <strong>Laporan Anda sedang ditindaklanjuti.</strong> Petugas kami sedang bekerja menangani laporan Anda. Pantau perkembangan melalui tautan di bawah.
        </div>
        @elseif($pengaduan->status === 'ditolak')
        <div style="background:#fee2e2; border-radius:10px; padding:14px 18px; margin:16px 0; font-size:13px; color:#991b1b; line-height:1.6;">
            ❌ <strong>Laporan Anda tidak dapat diproses.</strong> Mohon maaf atas ketidaknyamanan ini. Silakan hubungi kami untuk informasi lebih lanjut.
        </div>
        @endif

        {{-- Tracking token --}}
        <div class="tracking">
            <p>Token Pelacak Laporan Anda</p>
            <code>{{ $pengaduan->tracking_token }}</code>
        </div>

        @if($buktiFilePath)
        <div style="background:#f8fafc; border:1px solid #e2e8f0; border-radius:10px; padding:14px 18px; margin:16px 0; font-size:13px; color:#334155; line-height:1.6;">
            <strong>Bukti penyelesaian terlampir:</strong><br>
            <a href="{{ asset('storage/' . $buktiFilePath) }}" style="color:#1a3a6b; font-weight:600;">{{ basename($buktiFilePath) }}</a>
        </div>
        @endif

        {{-- CTA Button --}}
        <div class="cta">
            <a href="{{ route('masyarakat.pengaduan.show', $pengaduan->slug) }}" class="btn">
                Lihat Detail Laporan
            </a>
        </div>

        <p style="font-size:12px; color:#9ca3af; text-align:center; margin-top:8px;">
            Atau lacak tanpa login di:
            <a href="{{ route('lacak') }}" style="color:#1a3a6b;">{{ route('lacak') }}</a>
        </p>
    </div>

    {{-- Footer --}}
    <div class="footer">
        <p>Email ini dikirim otomatis oleh sistem <strong>BatusangkarLapor</strong>.</p>
        <p>Jangan balas email ini. Untuk bantuan, hubungi kami melalui website.</p>
        <p style="margin-top:8px;">
            <a href="{{ route('beranda') }}">batusangkarlapor.go.id</a> &nbsp;·&nbsp;
            Pemerintah Kabupaten Tanah Datar &copy; {{ now()->year }}
        </p>
    </div>
</div>
</body>
</html>