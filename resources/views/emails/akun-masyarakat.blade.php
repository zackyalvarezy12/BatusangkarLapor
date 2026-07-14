<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Akun BatusangkarLapor Anda</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Segoe UI', Arial, sans-serif; background: #f3f4f6; color: #374151; }
        .wrapper { max-width: 560px; margin: 40px auto; }
        .card { background: white; border-radius: 16px; overflow: hidden; box-shadow: 0 4px 24px rgba(0,0,0,0.08); }
        .header { background: linear-gradient(135deg, #040f2e 0%, #0b1e5c 55%, #1a3a8f 100%); padding: 36px 40px; text-align: center; }
        .header h1 { color: white; font-size: 22px; font-weight: 800; }
        .header p { color: #93c5fd; font-size: 13px; margin-top: 4px; }
        .body { padding: 36px 40px; }
        .greeting { font-size: 16px; font-weight: 600; color: #1f2937; margin-bottom: 12px; }
        .text { font-size: 14px; color: #6b7280; line-height: 1.7; margin-bottom: 20px; }
        .info-box { background: #f8faff; border: 1px solid #dbeafe; border-radius: 12px; padding: 20px 24px; margin-bottom: 24px; }
        .info-row { display: flex; justify-content: space-between; align-items: center; padding: 8px 0; border-bottom: 1px solid #e5e7eb; }
        .info-row:last-child { border-bottom: none; }
        .info-label { font-size: 12px; color: #9ca3af; font-weight: 500; }
        .info-value { font-size: 13px; color: white; font-weight: 700; }
        .password-box { background: linear-gradient(135deg, #040f2e 0%, #0b1e5c 55%, #1a3a8f 100%); border-radius: 12px; padding: 20px 24px; text-align: center; margin-bottom: 24px; }
        .password-label { color: #93c5fd; font-size: 11px; font-weight: 600; text-transform: uppercase; letter-spacing: 1px; margin-bottom: 8px; }
        .password-value { color: white; font-size: 24px; font-weight: 900; font-family: 'Courier New', monospace; letter-spacing: 4px; }
        .btn { display: inline-block; background: #003580; color: white; text-decoration: none; padding: 14px 32px; border-radius: 12px; font-weight: 800; font-size: 14px; margin-bottom: 24px; }
        .btn:hover { background: #002366; }
        .warning { background: #fffbeb; border: 1px solid #fde68a; border-radius: 10px; padding: 14px 18px; font-size: 13px; color: #92400e; line-height: 1.6; margin-bottom: 20px; }
        .warning strong { color: #78350f; }
        .footer { background: #f9fafb; padding: 20px 40px; text-align: center; border-top: 1px solid #e5e7eb; }
        .footer p { font-size: 12px; color: #9ca3af; line-height: 1.6; }
    </style>
</head>
<body>
<div class="wrapper">
    <div class="card">
        {{-- Header --}}
        <div class="header">
            <h1>BatusangkarLapor</h1>
            <p>Sistem Pengaduan Masyarakat Kab. Tanah Datar</p>
        </div>

        {{-- Body --}}
        <div class="body">
            <p class="greeting">Halo {{ $user->name }},</p>
            
            <p class="text">
                Akun Anda telah berhasil dibuat di Sistem Pengaduan Masyarakat BatusangkarLapor. 
                Silakan gunakan kredensial di bawah untuk melakukan login dan membuat laporan pengaduan Anda.
            </p>

            {{-- Informasi Login --}}
            <div class="info-box">
                <div class="info-row">
                    <span class="info-label">Email</span>
                    <span class="info-value">{{ $user->email }}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Password Sementara</span>
                    <span class="info-value">{{ $passwordSementara }}</span>
                </div>
            </div>

            {{-- Password Box --}}
            <div class="password-box">
                <div class="password-label">Password Sementara Anda</div>
                <div class="password-value">{{ $passwordSementara }}</div>
            </div>

            {{-- Warning --}}
            <div class="warning">
                <strong>⚠️ Penting:</strong> Pastikan Anda mengubah password ini setelah login untuk keamanan akun Anda.
            </div>

            {{-- Instructions --}}
            <p class="text">
                <strong>Langkah selanjutnya:</strong>
            </p>
            <ol style="font-size: 14px; color: #6b7280; line-height: 1.7; margin-bottom: 20px; padding-left: 20px;">
                <li style="margin-bottom: 8px;">Kunjungi halaman login di website BatusangkarLapor</li>
                <li style="margin-bottom: 8px;">Masukkan email: <strong>{{ $user->email }}</strong></li>
                <li style="margin-bottom: 8px;">Masukkan password: <strong>{{ $passwordSementara }}</strong></li>
                <li style="margin-bottom: 8px;">Login dan ubah password Anda ke password yang lebih aman</li>
                <li>Mulai buat laporan pengaduan Anda</li>
            </ol>

            {{-- Help Text --}}
            <p class="text">
                Jika Anda memiliki pertanyaan atau membutuhkan bantuan, silakan hubungi admin sistem atau kunjungi halaman FAQ kami.
            </p>
        </div>

        {{-- Footer --}}
        <div class="footer">
            <p>
                Email ini dikirim otomatis oleh sistem BatusangkarLapor.<br>
                Silakan jangan balas email ini. Gunakan form kontak di website kami untuk pertanyaan lebih lanjut.
            </p>
            <p style="margin-top: 12px; color: #d1d5db;">
                © 2026 Pemerintah Kabupaten Tanah Datar. Semua hak dilindungi.
            </p>
        </div>
    </div>
</div>
</body>
</html>
