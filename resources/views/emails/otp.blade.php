<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kode Verifikasi — BatusangkarLapor</title>
    <style>
        body { margin: 0; padding: 0; background: #f3f6fc; font-family: 'Segoe UI', Arial, sans-serif; }
        .wrapper { max-width: 520px; margin: 40px auto; background: #fff; border-radius: 20px; overflow: hidden; box-shadow: 0 4px 24px rgba(0,0,0,.08); }
        .head { background: linear-gradient(135deg, #0f2654 0%, #1a3a6b 60%, #2352a0 100%); padding: 40px; text-align: center; }
        .head-icon { width: 60px; height: 60px; background: rgba(255,255,255,.12); border: 1px solid rgba(255,255,255,.2); border-radius: 16px; margin: 0 auto 16px; display: flex; align-items: center; justify-content: center; }
        .head h1 { color: #fff; margin: 0; font-size: 20px; font-weight: 800; }
        .head p  { color: rgba(255,255,255,.6); margin: 6px 0 0; font-size: 12px; }
        .body { padding: 40px; }
        .greeting { font-size: 16px; color: #1f2937; font-weight: 700; margin-bottom: 10px; }
        .desc { font-size: 14px; color: #6b7280; line-height: 1.7; margin-bottom: 28px; }
        .otp-box { background: linear-gradient(135deg, #eef2fb, #dce6f7); border: 2px solid #c7d8f5; border-radius: 16px; padding: 28px; text-align: center; margin-bottom: 24px; }
        .otp-label { font-size: 11px; color: #6b7280; font-weight: 700; letter-spacing: 1.5px; text-transform: uppercase; margin-bottom: 12px; }
        .otp-code { font-size: 46px; font-weight: 900; color: #1a3a6b; letter-spacing: 14px; font-family: 'Courier New', monospace; line-height: 1; }
        .otp-exp { font-size: 12px; color: #9ca3af; margin-top: 10px; }
        .warn { background: #fef9ec; border-left: 4px solid #f59e0b; padding: 14px 16px; border-radius: 10px; font-size: 13px; color: #92400e; margin-top: 20px; line-height: 1.6; }
        .foot { background: #f9fafb; padding: 20px 40px; text-align: center; font-size: 12px; color: #9ca3af; border-top: 1px solid #f3f4f6; }
    </style>
</head>
<body>
<div class="wrapper">
    <div class="head">
        <div class="head-icon">
            <svg width="28" height="28" fill="none" stroke="white" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round"
                      d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-2 10v-5a1 1 0 00-1-1h-2a1 1 0 00-1 1v5m4 0H9"/>
            </svg>
        </div>
        <h1>BatusangkarLapor</h1>
        <p>Pemerintah Kabupaten Tanah Datar</p>
    </div>

    <div class="body">
        <p class="greeting">Halo, {{ $nama }} 👋</p>
        <p class="desc">
            Terima kasih telah mendaftar di <strong>BatusangkarLapor</strong>.<br>
            Gunakan kode berikut untuk memverifikasi email Anda dan menyelesaikan pendaftaran.
        </p>

        <div class="otp-box">
            <div class="otp-label">Kode Verifikasi OTP</div>
            <div class="otp-code">{{ $otp }}</div>
            <div class="otp-exp">⏱ Berlaku selama <strong>10 menit</strong></div>
        </div>

        <div class="warn">
            ⚠️ <strong>Jangan bagikan kode ini</strong> kepada siapapun termasuk petugas.
            Jika Anda tidak mendaftar di BatusangkarLapor, abaikan email ini.
        </div>
    </div>

    <div class="foot">
        © {{ date('Y') }} BatusangkarLapor — Pemerintah Kabupaten Tanah Datar<br>
        Email ini dikirim otomatis, jangan dibalas.
    </div>
</div>
</body>
</html>