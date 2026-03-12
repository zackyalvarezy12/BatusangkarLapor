<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verifikasi OTP — BatusangkarLapor</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    <style>
        * { font-family: 'Plus Jakarta Sans', sans-serif; }
        body { min-height: 100vh; background: #f3f6fc; display: flex; align-items: center; justify-content: center; padding: 24px; }

        .card {
            background: white; border-radius: 24px;
            box-shadow: 0 8px 40px rgba(26,58,107,.10), 0 1px 4px rgba(0,0,0,.04);
            padding: 48px 44px; width: 100%; max-width: 460px;
        }

        @keyframes fadeUp {
            from { opacity:0; transform:translateY(20px); }
            to   { opacity:1; transform:translateY(0); }
        }
        .fu-1 { animation: fadeUp .5s cubic-bezier(.22,.61,.36,1) both; }
        .fu-2 { animation: fadeUp .5s .07s cubic-bezier(.22,.61,.36,1) both; }
        .fu-3 { animation: fadeUp .5s .14s cubic-bezier(.22,.61,.36,1) both; }
        .fu-4 { animation: fadeUp .5s .21s cubic-bezier(.22,.61,.36,1) both; }
        .fu-5 { animation: fadeUp .5s .28s cubic-bezier(.22,.61,.36,1) both; }

        .otp-input {
            width: 52px; height: 60px;
            border: 2px solid #e5e7eb; border-radius: 14px;
            font-size: 1.7rem; font-weight: 800; text-align: center;
            color: #1a3a6b; background: #f9fafb;
            transition: border-color .2s, box-shadow .2s, background .2s;
            outline: none;
        }
        .otp-input:focus { border-color: #1a3a6b; background: #fff; box-shadow: 0 0 0 3px rgba(26,58,107,.12); }
        .otp-input.filled { border-color: #1a3a6b; background: #eef2fb; }
        .otp-input.error  { border-color: #f87171; background: #fff5f5; }

        .btn-verify {
            width: 100%; background: linear-gradient(135deg, #1a3a6b, #2352a0);
            color: white; font-weight: 800; font-size: .9rem;
            padding: 13px; border-radius: 14px; border: none; cursor: pointer;
            transition: transform .2s, box-shadow .2s, opacity .2s;
            box-shadow: 0 6px 20px rgba(26,58,107,.35);
            display: flex; align-items: center; justify-content: center; gap: 8px;
        }
        .btn-verify:hover:not(:disabled) { transform: translateY(-2px); box-shadow: 0 10px 28px rgba(26,58,107,.4); }
        .btn-verify:disabled { opacity: .45; cursor: not-allowed; }

        @keyframes pulse-shield { 0%,100%{transform:scale(1)} 50%{transform:scale(1.06)} }
        .pulse-shield { animation: pulse-shield 2.4s ease-in-out infinite; }
    </style>
</head>
<body>

<div class="card">

    {{-- Logo --}}
    <div class="fu-1 flex items-center gap-2.5 mb-8">
        <div class="w-9 h-9 rounded-xl flex items-center justify-center"
             style="background:linear-gradient(135deg,#1a3a6b,#2352a0);">
            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-2 10v-5a1 1 0 00-1-1h-2a1 1 0 00-1 1v5m4 0H9"/>
            </svg>
        </div>
        <div>
            <div class="font-black text-sm text-gray-800">BatusangkarLapor</div>
            <div class="text-[10px] text-gray-400">Kabupaten Tanah Datar</div>
        </div>
    </div>

    {{-- Shield icon --}}
    <div class="fu-2 flex justify-center mb-6">
        <div class="pulse-shield w-20 h-20 rounded-2xl flex items-center justify-center"
             style="background:linear-gradient(135deg,#eef2fb,#dce6f7);">
            <svg class="w-10 h-10" style="color:#1a3a6b" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                      d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
            </svg>
        </div>
    </div>

    {{-- Heading --}}
    <div class="fu-3 text-center mb-6">
        <h1 class="text-2xl font-black text-gray-900 mb-2">Verifikasi Email</h1>
        <p class="text-sm text-gray-500 leading-relaxed">
            Kode 6 digit telah dikirim ke<br>
            <span class="font-bold text-gray-700">{{ $masked }}</span>
        </p>
    </div>

    {{-- Alert resent --}}
    @if(session('resent'))
    <div class="fu-3 mb-4 flex items-center gap-2 rounded-xl px-4 py-3 text-sm font-semibold text-emerald-700 bg-emerald-50 border border-emerald-200">
        <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
        </svg>
        {{ session('resent') }}
    </div>
    @endif

    {{-- Alert error --}}
    @if($errors->any())
    <div class="mb-4 flex items-start gap-2 rounded-xl px-4 py-3 text-sm font-semibold text-red-600 bg-red-50 border border-red-200">
        <svg class="w-4 h-4 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
        </svg>
        <span>{{ $errors->first() }}</span>
    </div>
    @endif

    {{-- OTP Form --}}
    <form action="{{ route('register.otp.verify') }}" method="POST" id="otp-form" class="fu-4">
        @csrf

        <div class="flex justify-center gap-3 mb-6">
            @for($i = 0; $i < 6; $i++)
            <input type="text" inputmode="numeric" maxlength="1"
                   class="otp-input {{ $errors->has('otp') ? 'error' : '' }}"
                   id="otp-{{ $i }}" autocomplete="off">
            @endfor
        </div>

        {{-- Hidden gabungan --}}
        <input type="hidden" name="otp" id="otp-value">

        <button type="submit" id="btn-verify" class="btn-verify" disabled>
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/>
            </svg>
            Verifikasi &amp; Buat Akun
        </button>
    </form>

    {{-- Footer actions --}}
    <div class="fu-5 text-center mt-6 space-y-2">
        {{-- Countdown --}}
        <p class="text-xs text-gray-400">
            Kode berlaku selama <span id="timer" class="font-bold text-gray-600">10:00</span>
        </p>

        {{-- Resend --}}
        <form action="{{ route('register.otp.resend') }}" method="POST">
            @csrf
            <button type="submit" id="btn-resend"
                    class="text-sm font-bold text-[#1a3a6b] hover:underline disabled:opacity-40 disabled:cursor-not-allowed"
                    disabled>
                Kirim ulang kode
            </button>
        </form>

        {{-- Kembali --}}
        <a href="{{ route('register') }}"
           class="block text-xs text-gray-400 hover:text-gray-600 transition pt-1">
            ← Kembali &amp; ubah data
        </a>
    </div>
</div>

<script>
// ── OTP Input ─────────────────────────────────────────────────
const inputs    = document.querySelectorAll('.otp-input');
const btnVerify = document.getElementById('btn-verify');
const otpHidden = document.getElementById('otp-value');

inputs.forEach((inp, idx) => {
    inp.addEventListener('input', () => {
        inp.value = inp.value.replace(/\D/g, '').slice(-1);
        inp.classList.toggle('filled', inp.value !== '');
        if (inp.value && idx < inputs.length - 1) inputs[idx + 1].focus();
        sync();
    });
    inp.addEventListener('keydown', e => {
        if (e.key === 'Backspace' && !inp.value && idx > 0) {
            inputs[idx - 1].value = '';
            inputs[idx - 1].classList.remove('filled');
            inputs[idx - 1].focus();
            sync();
        }
    });
    inp.addEventListener('paste', e => {
        e.preventDefault();
        const txt = (e.clipboardData || window.clipboardData).getData('text').replace(/\D/g, '');
        txt.split('').slice(0, 6).forEach((ch, i) => {
            if (inputs[i]) { inputs[i].value = ch; inputs[i].classList.add('filled'); }
        });
        inputs[Math.min(txt.length, 5)].focus();
        sync();
    });
});

function sync() {
    const val = Array.from(inputs).map(i => i.value).join('');
    otpHidden.value = val;
    btnVerify.disabled = val.length < 6;
}

// ── Countdown 10 menit ───────────────────────────────────────
const timerEl   = document.getElementById('timer');
const btnResend = document.getElementById('btn-resend');
let seconds = 600;

const tick = setInterval(() => {
    seconds--;
    const m = String(Math.floor(seconds / 60)).padStart(2, '0');
    const s = String(seconds % 60).padStart(2, '0');
    timerEl.textContent = m + ':' + s;

    if (seconds <= 60) timerEl.style.color = '#ef4444';

    if (seconds <= 0) {
        clearInterval(tick);
        timerEl.closest('p').innerHTML =
            '<span class="text-red-500 font-semibold text-xs">Kode sudah kadaluarsa.</span>';
        btnVerify.disabled = true;
    }
}, 1000);

// Aktifkan resend setelah 60 detik
setTimeout(() => { btnResend.disabled = false; }, 60000);

// Focus input pertama
inputs[0].focus();
</script>

</body>
</html>