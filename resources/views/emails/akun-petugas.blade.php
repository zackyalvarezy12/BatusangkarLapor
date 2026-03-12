<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Akun Petugas BatusangkarLapor</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Segoe UI', Arial, sans-serif; background: #f3f4f6; color: #374151; }
        .wrapper { max-width: 560px; margin: 40px auto; }
        .card { background: white; border-radius: 16px; overflow: hidden; box-shadow: 0 4px 24px rgba(0,0,0,0.08); }
        .header { background: #003580; padding: 36px 40px; text-align: center; }
        .header-logo { display: inline-flex; align-items: center; gap: 10px; margin-bottom: 8px; }
        .header-icon { width: 44px; height: 44px; background: rgba(255,255,255,0.15); border-radius: 12px; display: flex; align-items: center; justify-content: center; }
        .header h1 { color: white; font-size: 22px; font-weight: 800; }
        .header p { color: #93c5fd; font-size: 13px; margin-top: 4px; }
        .body { padding: 36px 40px; }
        .greeting { font-size: 16px; font-weight: 600; color: #1f2937; margin-bottom: 12px; }
        .text { font-size: 14px; color: #6b7280; line-height: 1.7; margin-bottom: 20px; }
        .info-box { background: #f8faff; border: 1px solid #dbeafe; border-radius: 12px; padding: 20px 24px; margin-bottom: 24px; }
        .info-row { display: flex; justify-content: space-between; align-items: center; padding: 8px 0; border-bottom: 1px solid #e5e7eb; }
        .info-row:last-child { border-bottom: none; }
        .info-label { font-size: 12px; color: #9ca3af; font-weight: 500; }
        .info-value { font-size: 13px; color: #1f2937; font-weight: 700; }
        .password-box { background: #003580; border-radius: 12px; padding: 20px 24px; text-align: center; margin-bottom: 24px; }
        .password-label { color: #93c5fd; font-size: 11px; font-weight: 600; text-transform: uppercase; letter-spacing: 1px; margin-bottom: 8px; }
        .password-value { color: white; font-size: 24px; font-weight: 900; font-family: 'Courier New', monospace; letter-spacing: 4px; }
        .btn { display: block; background: #f59e0b; color: #1f2937; text-decoration: none; text-align: center; padding: 14px 32px; border-radius: 12px; font-weight: 800; font-size: 14px; margin-bottom: 24px; }
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
            <div style="text-align:center; margin-bottom:12px;">
                <div style="width:48px;height:48px;background:rgba(255,255,255,0.15);border-radius:14px;display:inline-flex;align-items:center;justify-content:center;">
                    <svg width="24" height="24" fill="none" stroke="white" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-2 10v-5a1 1 0 00-1-1h-2a1 1 0 00-1 1v5m4 0H9"/>
                    </svg>
                </div>
            </div>
            <h1>BatusangkarLapor</h1>
            <p>Sistem Pengaduan Masyarakat Kab. Tanah Datar</p>
        </div>

        {{-- Body --}}
        <div class="body">
            <p class="greeting">Selamat datang, {{ $user->name }}!</p>
            <p class="text">
                Akun petugas Anda di sistem <strong>BatusangkarLapor</strong> telah dibuat oleh administrator.
                Gunakan informasi berikut untuk login pertama kali.
            </p>

            {{-- Info Akun --}}
            <div class="info-box">
                <div class="info-row">
                    <span class="info-label">Nama</span>
                    <span class="info-value">{{ $user->name }}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Email</span>
                    <span class="info-value">{{ $user->email }}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Role</span>
                    <span class="info-value">Petugas</span>
                </div>
                @if($user->wilaya)
                <div class="info-row">
                    <span class="info-label">Daerah Tugas</span>
                    <span class="info-value">{{ $user->wilaya->nama }}</span>
                </div>
                @endif
            </div>

            {{-- Password --}}
            <div class="password-box">
                <div class="password-label">Password Sementara</div>
                <div class="password-value">{{ $passwordSementara }}</div>
            </div>

            {{-- Tombol Login --}}
            <a href="{{ url('/login') }}" class="btn">
                Klik Di Sini Untuk Login →
            </a>

            {{-- Warning --}}
            <div class="warning">
                <strong>Penting!</strong> Setelah login pertama kali, Anda <strong>wajib mengganti password</strong>
                dengan password baru yang lebih aman. Password sementara ini hanya berlaku untuk login pertama.
            </div>

            <p class="text" style="font-size:13px;">
                Jika Anda merasa tidak mendaftar atau tidak mengenal sistem ini, abaikan email ini
                dan hubungi administrator segera.
            </p>
        </div>

        {{-- Footer --}}
        <div class="footer">
            <p>© {{ date('Y') }} BatusangkarLapor — Pemerintah Kabupaten Tanah Datar</p>
            <p style="margin-top:4px;">Email ini dikirim otomatis, jangan balas email ini.</p>
        </div>
    </div>
</div>
</body>
</html>