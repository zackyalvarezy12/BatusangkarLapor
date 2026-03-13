<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Balasan Kritik & Saran</title>
</head>
<body style="margin:0;padding:0;background:#f3f6fc;font-family:'Segoe UI',Arial,sans-serif;">
<table width="100%" cellpadding="0" cellspacing="0" style="background:#f3f6fc;padding:40px 20px;">
    <tr>
        <td align="center">
            <table width="580" cellpadding="0" cellspacing="0" style="background:#ffffff;border-radius:20px;overflow:hidden;box-shadow:0 4px 24px rgba(0,0,0,.08);">

                {{-- Header --}}
                <tr>
                    <td style="background:linear-gradient(135deg,#003580,#1e4d8c);padding:36px 40px;text-align:center;">
                        <div style="font-size:13px;font-weight:700;letter-spacing:2px;color:rgba(255,255,255,.6);text-transform:uppercase;margin-bottom:8px;">BatusangkarLapor</div>
                        <div style="font-size:22px;font-weight:900;color:#ffffff;">Balasan {{ ucfirst($kritik->jenis) }} Anda</div>
                        <div style="margin-top:8px;font-size:13px;color:rgba(255,255,255,.6);">Pemerintah Kabupaten Tanah Datar</div>
                    </td>
                </tr>

                {{-- Body --}}
                <tr>
                    <td style="padding:36px 40px;">
                        <p style="margin:0 0 16px;font-size:15px;color:#374151;">
                            Halo, <strong>{{ $kritik->nama }}</strong>,
                        </p>
                        <p style="margin:0 0 24px;font-size:14px;color:#6b7280;line-height:1.7;">
                            Terima kasih telah menyampaikan {{ $kritik->jenis }} kepada kami. Berikut adalah balasan dari tim BatusangkarLapor:
                        </p>

                        {{-- Pesan asli --}}
                        <div style="background:#f9fafb;border-left:4px solid #d1d5db;border-radius:8px;padding:16px 20px;margin-bottom:24px;">
                            <div style="font-size:11px;font-weight:700;color:#9ca3af;text-transform:uppercase;letter-spacing:1px;margin-bottom:8px;">
                                {{ ucfirst($kritik->jenis) }} Anda
                            </div>
                            <p style="margin:0;font-size:14px;color:#6b7280;line-height:1.6;">{{ $kritik->isi }}</p>
                        </div>

                        {{-- Balasan --}}
                        <div style="background:#eff6ff;border-left:4px solid #003580;border-radius:8px;padding:16px 20px;margin-bottom:24px;">
                            <div style="font-size:11px;font-weight:700;color:#003580;text-transform:uppercase;letter-spacing:1px;margin-bottom:8px;">
                                Balasan Admin · {{ $kritik->dibalas_at->format('d M Y, H:i') }}
                            </div>
                            <p style="margin:0;font-size:14px;color:#1e3a5f;line-height:1.6;">{{ $kritik->balasan }}</p>
                        </div>

                        <p style="margin:0;font-size:13px;color:#9ca3af;line-height:1.6;">
                            Jika Anda masih memiliki pertanyaan atau ingin menyampaikan laporan, silakan kunjungi
                            <a href="{{ url('/') }}" style="color:#003580;font-weight:600;">BatusangkarLapor</a>.
                        </p>
                    </td>
                </tr>

                {{-- Footer --}}
                <tr>
                    <td style="background:#f9fafb;border-top:1px solid #f3f4f6;padding:24px 40px;text-align:center;">
                        <p style="margin:0;font-size:12px;color:#9ca3af;">
                            © {{ date('Y') }} BatusangkarLapor — Pemerintah Kabupaten Tanah Datar<br>
                            Email ini dikirim otomatis, mohon tidak membalas email ini.
                        </p>
                    </td>
                </tr>

            </table>
        </td>
    </tr>
</table>
</body>
</html>