@extends('layouts.app')
@section('title', 'Kritik & Saran')

@section('content')
<style>
@import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800;900&family=Fraunces:ital,wght@0,400;0,700;1,400;1,700&display=swap');

:root {
    --navy: #0B1D3A;
    --navy-mid: #153060;
    --blue: #1E4FC2;
    --blue-light: #3B6FE8;
    --gold: #F59E0B;
    --gold-light: #FCD34D;
    --surface: #F0F4FF;
    --white: #FFFFFF;
}

* { font-family: 'Plus Jakarta Sans', sans-serif; }
.font-display { font-family: 'Fraunces', serif; }

/* ── Animated background ── */
.page-bg {
    background: var(--surface);
    min-height: 100vh;
    position: relative;
    overflow: hidden;
}
.page-bg::before {
    content: '';
    position: fixed;
    top: -30%;
    right: -20%;
    width: 600px;
    height: 600px;
    border-radius: 50%;
    background: radial-gradient(circle, rgba(30,79,194,.10) 0%, transparent 70%);
    pointer-events: none;
    animation: blobFloat 12s ease-in-out infinite;
}
.page-bg::after {
    content: '';
    position: fixed;
    bottom: -20%;
    left: -15%;
    width: 500px;
    height: 500px;
    border-radius: 50%;
    background: radial-gradient(circle, rgba(245,158,11,.08) 0%, transparent 70%);
    pointer-events: none;
    animation: blobFloat 16s ease-in-out infinite reverse;
}
@keyframes blobFloat {
    0%,100% { transform: translate(0,0) scale(1); }
    50% { transform: translate(30px,-30px) scale(1.05); }
}

/* ── Navbar ── */
.topnav {
    position: sticky;
    top: 0;
    z-index: 50;
    background: rgba(255,255,255,.92);
    backdrop-filter: blur(16px);
    border-bottom: 1px solid rgba(30,79,194,.08);
    box-shadow: 0 1px 20px rgba(11,29,58,.06);
}

/* ── Card ── */
.form-card {
    background: var(--white);
    border-radius: 28px;
    border: 1px solid rgba(30,79,194,.08);
    box-shadow:
        0 2px 0 rgba(30,79,194,.04),
        0 16px 48px rgba(11,29,58,.08),
        0 0 0 1px rgba(255,255,255,.8) inset;
    overflow: hidden;
    animation: cardIn .6s cubic-bezier(.22,.61,.36,1) both;
}
@keyframes cardIn {
    from { opacity: 0; transform: translateY(24px); }
    to   { opacity: 1; transform: none; }
}

/* ── Card header stripe ── */
.card-header {
    background: linear-gradient(135deg, var(--navy) 0%, var(--navy-mid) 60%, #1E4FC2 100%);
    padding: 36px 36px 32px;
    position: relative;
    overflow: hidden;
}
.card-header::before {
    content: '';
    position: absolute;
    top: -40px; right: -40px;
    width: 160px; height: 160px;
    border-radius: 50%;
    background: rgba(245,158,11,.12);
}
.card-header::after {
    content: '';
    position: absolute;
    bottom: -20px; left: 30%;
    width: 120px; height: 120px;
    border-radius: 50%;
    background: rgba(59,111,232,.15);
}

/* ── Input styles ── */
.field-wrap { position: relative; }
.field-wrap input,
.field-wrap textarea,
.field-wrap select {
    width: 100%;
    border: 1.5px solid #E2E8F0;
    border-radius: 14px;
    padding: 13px 16px;
    font-size: 14px;
    font-family: 'Plus Jakarta Sans', sans-serif;
    color: #1a202c;
    background: #FAFBFF;
    transition: all .2s ease;
    outline: none;
}
.field-wrap input:focus,
.field-wrap textarea:focus {
    border-color: var(--blue);
    background: #fff;
    box-shadow: 0 0 0 4px rgba(30,79,194,.08);
}
.field-wrap input.error,
.field-wrap textarea.error {
    border-color: #EF4444;
}

/* ── Jenis radio ── */
.jenis-label {
    cursor: pointer;
    display: block;
}
.jenis-label input { display: none; }
.jenis-card {
    border: 2px solid #E2E8F0;
    border-radius: 16px;
    padding: 14px 10px;
    text-align: center;
    transition: all .2s cubic-bezier(.34,1.56,.64,1);
    background: #FAFBFF;
    user-select: none;
}
.jenis-label input:checked + .jenis-card {
    border-color: var(--blue);
    background: linear-gradient(135deg, rgba(30,79,194,.06), rgba(59,111,232,.04));
    box-shadow: 0 4px 16px rgba(30,79,194,.12);
    transform: translateY(-3px);
}
.jenis-label:hover .jenis-card {
    border-color: #93C5FD;
    transform: translateY(-2px);
}
.jenis-emoji {
    font-size: 22px;
    display: block;
    margin-bottom: 5px;
    line-height: 1;
}
.jenis-text {
    font-size: 11px;
    font-weight: 700;
    color: #374151;
    text-transform: uppercase;
    letter-spacing: .05em;
}

/* ── Submit button ── */
.btn-submit {
    width: 100%;
    background: linear-gradient(135deg, var(--navy) 0%, var(--blue) 100%);
    color: white;
    font-weight: 800;
    font-size: 14px;
    padding: 15px 24px;
    border-radius: 14px;
    border: none;
    cursor: pointer;
    transition: all .25s cubic-bezier(.34,1.56,.64,1);
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
    letter-spacing: .02em;
    position: relative;
    overflow: hidden;
}
.btn-submit::before {
    content: '';
    position: absolute;
    inset: 0;
    background: linear-gradient(135deg, rgba(255,255,255,.1), transparent);
    opacity: 0;
    transition: opacity .2s;
}
.btn-submit:hover {
    transform: translateY(-3px);
    box-shadow: 0 12px 32px rgba(11,29,58,.35);
}
.btn-submit:hover::before { opacity: 1; }
.btn-submit:active { transform: translateY(0); }

/* ── Info strip ── */
.info-strip {
    background: linear-gradient(135deg, rgba(245,158,11,.08), rgba(30,79,194,.05));
    border: 1px solid rgba(245,158,11,.2);
    border-radius: 14px;
    padding: 12px 16px;
    display: flex;
    align-items: flex-start;
    gap: 10px;
}

/* ── Particles ── */
.particle {
    position: absolute;
    border-radius: 50%;
    background: white;
    animation: twinkle var(--dur,3s) ease-in-out infinite;
    animation-delay: var(--del,0s);
    pointer-events: none;
}
@keyframes twinkle {
    0%,100% { opacity:.15; transform: scale(1); }
    50% { opacity: .5; transform: scale(1.4); }
}

/* ── Fade animations ── */
.fade-up { animation: fadeUp .6s cubic-bezier(.22,.61,.36,1) both; }
.fade-up-1 { animation-delay: .05s; }
.fade-up-2 { animation-delay: .12s; }
.fade-up-3 { animation-delay: .2s; }
@keyframes fadeUp {
    from { opacity: 0; transform: translateY(16px); }
    to   { opacity: 1; transform: none; }
}

/* ── Character counter ── */
.char-counter {
    font-size: 11px;
    color: #9CA3AF;
    text-align: right;
    margin-top: 4px;
    font-weight: 500;
}
</style>

{{-- Navbar --}}
<nav class="topnav">
    <div class="max-w-2xl mx-auto px-4 py-3 flex items-center gap-3">
        <a href="{{ route('beranda') }}"
           class="w-9 h-9 bg-gray-100 hover:bg-[#0B1D3A]/8 rounded-xl flex items-center justify-center transition">
            <svg class="w-4 h-4 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
            </svg>
        </a>
        <div class="flex items-center gap-2.5">
            <div class="w-7 h-7 rounded-lg flex items-center justify-center"
                 style="background:linear-gradient(135deg,#0B1D3A,#1E4FC2);">
                <svg class="w-3.5 h-3.5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"/>
                </svg>
            </div>
            <div>
                <div class="font-bold text-gray-800 text-sm leading-none">Kritik & Saran</div>
                <div class="text-gray-400 text-[10px] mt-0.5">BatusangkarLapor</div>
            </div>
        </div>
    </div>
</nav>

<div class="page-bg py-10 px-4">
    <div class="max-w-lg mx-auto relative z-10">

        {{-- Success Alert --}}
        @if(session('success'))
        <div class="mb-6 flex items-center gap-3 bg-emerald-50 border border-emerald-200 text-emerald-800 px-5 py-4 rounded-2xl shadow-sm fade-up">
            <div class="w-8 h-8 bg-emerald-100 rounded-xl flex items-center justify-center flex-shrink-0">
                <svg class="w-4 h-4 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/>
                </svg>
            </div>
            <div>
                <div class="font-bold text-sm">Terkirim!</div>
                <div class="text-xs text-emerald-600 mt-0.5">{{ session('success') }}</div>
            </div>
        </div>
        @endif

        {{-- Main Card --}}
        <div class="form-card">

            {{-- Card Header --}}
            <div class="card-header relative z-10">
                {{-- Particles --}}
                <div class="particle" style="--dur:3.2s;--del:0s;  width:3px;height:3px;top:20%;left:15%;"></div>
                <div class="particle" style="--dur:4s;  --del:1s;  width:2px;height:2px;top:60%;left:75%;"></div>
                <div class="particle" style="--dur:2.8s;--del:.5s; width:2px;height:2px;top:35%;left:85%;"></div>
                <div class="particle" style="--dur:3.5s;--del:2s;  width:3px;height:3px;top:75%;left:25%;"></div>

                <div class="flex items-start gap-4 relative z-10">
                    <div class="w-14 h-14 rounded-2xl bg-white/10 border border-white/20 flex items-center justify-center flex-shrink-0 shadow-lg">
                        <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                  d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"/>
                        </svg>
                    </div>
                    <div>
                        <div class="inline-flex items-center gap-1.5 bg-white/10 border border-white/15 rounded-full px-3 py-1 mb-2">
                            <span class="w-1.5 h-1.5 bg-amber-400 rounded-full animate-pulse"></span>
                            <span class="text-white/70 text-[10px] font-bold uppercase tracking-widest">Layanan Publik</span>
                        </div>
                        <h1 class="font-display font-bold text-white text-2xl leading-tight">
                            Kritik & Saran
                        </h1>
                        <p class="text-white/60 text-sm mt-1 leading-relaxed">
                            Suara Anda penting bagi kami untuk terus berkembang.
                        </p>
                    </div>
                </div>
            </div>

            {{-- Form Body --}}
            <div class="p-7">

                {{-- Info strip --}}
                <div class="info-strip mb-6 fade-up fade-up-1">
                    <svg class="w-4 h-4 text-amber-500 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <p class="text-xs text-gray-600 leading-relaxed">
                        Pastikan email yang dimasukkan aktif — Admin akan membalas langsung ke email tersebut.
                    </p>
                </div>

                <form method="POST" action="{{ route('kritik.store') }}" class="space-y-5">
                    @csrf

                    {{-- Nama & Email --}}
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 fade-up fade-up-1">
                        <div>
                            <label class="block text-xs font-bold text-gray-500 uppercase tracking-widest mb-2">Nama Lengkap</label>
                            <div class="field-wrap">
                                <input type="text" name="nama"
                                       value="{{ old('nama', auth()->user()->name ?? '') }}"
                                       required placeholder="Nama Anda"
                                       class="{{ $errors->has('nama') ? 'error' : '' }}">
                            </div>
                            @error('nama')<p class="text-red-500 text-xs mt-1.5 flex items-center gap-1"><svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/></svg>{{ $message }}</p>@enderror
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-gray-500 uppercase tracking-widest mb-2">Email Aktif</label>
                            <div class="field-wrap">
                                <input type="email" name="email"
                                       value="{{ old('email', auth()->user()->email ?? '') }}"
                                       required placeholder="email@contoh.com"
                                       class="{{ $errors->has('email') ? 'error' : '' }}">
                            </div>
                            @error('email')<p class="text-red-500 text-xs mt-1.5 flex items-center gap-1"><svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/></svg>{{ $message }}</p>@enderror
                        </div>
                    </div>

                    {{-- Jenis --}}
                    <div class="fade-up fade-up-2">
                        <label class="block text-xs font-bold text-gray-500 uppercase tracking-widest mb-3">Jenis Pesan</label>
                        <div class="grid grid-cols-3 gap-3">
                            @foreach([
                                'kritik'     => ['🔴', 'Kritik',     'Keluhan'],
                                'saran'      => ['🔵', 'Saran',      'Masukan'],
                                'pertanyaan' => ['🟣', 'Pertanyaan', 'Tanya'],
                            ] as $val => $opt)
                            <label class="jenis-label">
                                <input type="radio" name="jenis" value="{{ $val }}"
                                       {{ old('jenis', 'saran') === $val ? 'checked' : '' }}>
                                <div class="jenis-card">
                                    <span class="jenis-emoji">{{ $opt[0] }}</span>
                                    <span class="jenis-text">{{ $opt[1] }}</span>
                                    <span class="block text-[10px] text-gray-400 mt-0.5">{{ $opt[2] }}</span>
                                </div>
                            </label>
                            @endforeach
                        </div>
                        @error('jenis')<p class="text-red-500 text-xs mt-1.5">{{ $message }}</p>@enderror
                    </div>

                    {{-- Isi Pesan --}}
                    <div class="fade-up fade-up-3">
                        <label class="block text-xs font-bold text-gray-500 uppercase tracking-widest mb-2">Isi Pesan</label>
                        <div class="field-wrap">
                            <textarea name="isi" required rows="5" id="isiPesan"
                                      placeholder="Tulis kritik, saran, atau pertanyaan Anda di sini dengan jelas dan sopan..."
                                      oninput="updateCounter(this)"
                                      class="{{ $errors->has('isi') ? 'error' : '' }}">{{ old('isi') }}</textarea>
                        </div>
                        <div class="flex items-center justify-between mt-1">
                            @error('isi')
                            <p class="text-red-500 text-xs flex items-center gap-1"><svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/></svg>{{ $message }}</p>
                            @else
                            <span></span>
                            @enderror
                            <span class="char-counter" id="charCount">0 / 1000</span>
                        </div>
                    </div>

                    {{-- Submit --}}
                    <div class="fade-up fade-up-3 pt-1">
                        <button type="submit" class="btn-submit">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                      d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/>
                            </svg>
                            Kirim Pesan
                        </button>
                    </div>

                    {{-- Privacy note --}}
                    <p class="text-center text-[11px] text-gray-400 leading-relaxed fade-up fade-up-3">
                        Pesan Anda akan dijaga kerahasiaannya dan hanya dibaca oleh Admin.
                        <br>Balasan akan dikirim ke email yang Anda masukkan.
                    </p>

                </form>
            </div>
        </div>

        {{-- Bottom link --}}
        <div class="text-center mt-6 fade-up fade-up-3">
            <a href="{{ route('faq') }}" class="inline-flex items-center gap-2 text-sm text-gray-500 hover:text-[#1E4FC2] transition font-semibold">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                Cek FAQ sebelum bertanya
            </a>
        </div>

    </div>
</div>

<script>
function updateCounter(el) {
    const len = el.value.length;
    const counter = document.getElementById('charCount');
    counter.textContent = len + ' / 1000';
    counter.style.color = len > 900 ? '#EF4444' : len > 700 ? '#F59E0B' : '#9CA3AF';
    if (len > 1000) el.value = el.value.substring(0, 1000);
}
// Init counter
document.addEventListener('DOMContentLoaded', () => {
    const t = document.getElementById('isiPesan');
    if (t) updateCounter(t);
});
</script>
@endsection