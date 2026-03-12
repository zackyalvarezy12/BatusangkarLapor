@extends('layouts.app')
@section('title', 'FAQ')

@section('content')

<style>
@import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800;900&family=DM+Serif+Display:ital@0;1&display=swap');
* { font-family: 'Plus Jakarta Sans', sans-serif; }

@keyframes fadeUp {
    from { opacity:0; transform:translateY(20px); }
    to   { opacity:1; transform:translateY(0); }
}
.fu { animation: fadeUp .5s cubic-bezier(.22,.61,.36,1) both; }
.fu-2 { animation-delay:.1s; }
.fu-3 { animation-delay:.15s; }

/* Accordion */
.faq-item .faq-answer {
    max-height: 0;
    overflow: hidden;
    transition: max-height .35s cubic-bezier(.4,0,.2,1), opacity .3s ease;
    opacity: 0;
}
.faq-item.open .faq-answer {
    max-height: 400px;
    opacity: 1;
}
.faq-item .faq-icon {
    transition: transform .3s cubic-bezier(.34,1.56,.64,1);
}
.faq-item.open .faq-icon {
    transform: rotate(45deg);
}
.faq-item .faq-btn {
    transition: background .2s;
}
.faq-item.open .faq-btn {
    background: #f0f5ff;
}

/* Avatar bob */
@keyframes bob { 0%,100%{transform:translateY(0)} 50%{transform:translateY(-6px)} }
.avatar-bob { animation: bob 4s ease-in-out infinite; }
@keyframes bob2 { 0%,100%{transform:translateY(0)} 50%{transform:translateY(-5px)} }
.avatar-bob2 { animation: bob2 4.5s ease-in-out infinite .5s; }
@keyframes bob3 { 0%,100%{transform:translateY(0)} 50%{transform:translateY(-4px)} }
.avatar-bob3 { animation: bob3 3.8s ease-in-out infinite 1s; }

/* Floating bubble */
@keyframes floatBubble { 0%,100%{transform:translateY(0) scale(1)} 50%{transform:translateY(-8px) scale(1.02)} }
.bubble-float { animation: floatBubble 5s ease-in-out infinite; }
</style>

{{-- ─── NAVBAR ─── --}}
<nav class="sticky top-0 z-40 bg-white/95 backdrop-blur-xl border-b border-gray-100 shadow-sm">
    <div class="max-w-3xl mx-auto px-4 py-3.5 flex items-center gap-3">
        <a href="{{ route('beranda') }}"
           class="w-9 h-9 bg-gray-100 hover:bg-gray-200 rounded-xl flex items-center justify-center transition flex-shrink-0">
            <svg class="w-4 h-4 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
            </svg>
        </a>
        <div>
            <div class="font-bold text-gray-800 text-sm leading-tight">Pertanyaan Umum</div>
            <div class="text-gray-400 text-[10px]">BatusangkarLapor · FAQ</div>
        </div>
    </div>
</nav>

<div class="min-h-screen bg-[#f3f6fc]">

    {{-- ─── HERO SECTION ─── --}}
    <div class="relative overflow-hidden" style="background:linear-gradient(135deg,#0f2654,#1a3a6b 55%,#1e4d8c);">
        {{-- bg decoration --}}
        <div class="absolute inset-0" style="background-image:linear-gradient(rgba(255,255,255,.03) 1px,transparent 1px),linear-gradient(90deg,rgba(255,255,255,.03) 1px,transparent 1px);background-size:60px 60px;"></div>
        <div class="absolute top-0 right-0 w-80 h-80 rounded-full opacity-10" style="background:radial-gradient(circle,#f59e0b,transparent 70%);transform:translate(30%,-30%);"></div>
        <div class="absolute bottom-0 left-0 w-60 h-60 rounded-full opacity-8" style="background:radial-gradient(circle,#60a5fa,transparent 70%);transform:translate(-30%,30%);"></div>

        <div class="relative max-w-3xl mx-auto px-4 py-14">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 items-center">

                {{-- Left: Text --}}
                <div class="fu">
                    <div class="inline-flex items-center gap-2 bg-white/10 border border-white/20 rounded-full px-3 py-1.5 mb-5">
                        <span class="w-1.5 h-1.5 bg-amber-400 rounded-full animate-pulse"></span>
                        <span class="text-white/70 text-[11px] font-semibold uppercase tracking-widest">Pusat Bantuan</span>
                    </div>
                    <h1 class="font-serif text-white leading-tight mb-3" style="font-size:2.2rem; font-family:'DM Serif Display',serif;">
                        Ada yang ingin<br><em style="background:linear-gradient(135deg,#f59e0b,#fb923c);-webkit-background-clip:text;-webkit-text-fill-color:transparent;background-clip:text;">ditanyakan?</em>
                    </h1>
                    <p class="text-blue-200/70 text-sm leading-relaxed max-w-xs">
                        Temukan jawaban atas pertanyaan umum seputar penggunaan BatusangkarLapor di sini.
                    </p>
                </div>

                {{-- Right: Vector Illustration --}}
                <div class="fu fu-2 hidden md:flex justify-center items-end gap-4 pb-2">

                    {{-- Person 1 --}}
                    <div class="avatar-bob flex flex-col items-center gap-2">
                        <div class="bubble-float bg-white rounded-2xl rounded-bl-sm px-3 py-2 shadow-lg text-xs font-bold text-[#1a3a6b] whitespace-nowrap"
                             style="box-shadow:0 8px 20px rgba(0,0,0,.15);">
                            Gimana cara lapor? 🤔
                        </div>
                        <svg width="60" height="90" viewBox="0 0 60 90" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <!-- Head -->
                            <circle cx="30" cy="18" r="13" fill="#FBBF24" stroke="#F59E0B" stroke-width="1.5"/>
                            <!-- Eyes -->
                            <circle cx="25" cy="16" r="2" fill="#1a3a6b"/>
                            <circle cx="35" cy="16" r="2" fill="#1a3a6b"/>
                            <!-- Smile -->
                            <path d="M25 22 Q30 26 35 22" stroke="#1a3a6b" stroke-width="1.5" stroke-linecap="round" fill="none"/>
                            <!-- Hair -->
                            <path d="M17 14 Q20 6 30 5 Q40 6 43 14" fill="#92400e" stroke="none"/>
                            <!-- Body -->
                            <rect x="16" y="31" width="28" height="30" rx="10" fill="#dbeafe" stroke="#93c5fd" stroke-width="1.5"/>
                            <!-- Legs -->
                            <rect x="18" y="58" width="10" height="22" rx="5" fill="#1e40af"/>
                            <rect x="32" y="58" width="10" height="22" rx="5" fill="#1e40af"/>
                            <!-- Arms -->
                            <rect x="4" y="32" width="12" height="8" rx="4" fill="#dbeafe" stroke="#93c5fd" stroke-width="1.5"/>
                            <rect x="44" y="32" width="12" height="8" rx="4" fill="#dbeafe" stroke="#93c5fd" stroke-width="1.5"/>
                        </svg>
                    </div>

                    {{-- Person 2 (center, taller) --}}
                    <div class="avatar-bob2 flex flex-col items-center gap-2 -mt-4">
                        <div class="bubble-float bg-amber-400 rounded-2xl rounded-br-sm px-3 py-2 shadow-lg text-xs font-bold text-gray-900 whitespace-nowrap"
                             style="box-shadow:0 8px 20px rgba(245,158,11,.35); animation-delay:1s;">
                            Status laporan saya? 📋
                        </div>
                        <svg width="68" height="100" viewBox="0 0 68 100" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <!-- Head -->
                            <circle cx="34" cy="20" r="15" fill="#FDE68A" stroke="#FCD34D" stroke-width="1.5"/>
                            <!-- Eyes -->
                            <circle cx="28" cy="18" r="2.2" fill="#1a3a6b"/>
                            <circle cx="40" cy="18" r="2.2" fill="#1a3a6b"/>
                            <!-- Smile -->
                            <path d="M28 25 Q34 30 40 25" stroke="#1a3a6b" stroke-width="1.5" stroke-linecap="round" fill="none"/>
                            <!-- Hair -->
                            <path d="M20 18 Q19 7 34 6 Q49 7 48 18" fill="#7c3aed" stroke="none"/>
                            <!-- Body -->
                            <rect x="18" y="35" width="32" height="34" rx="12" fill="#c7d2fe" stroke="#a5b4fc" stroke-width="1.5"/>
                            <!-- Badge on shirt -->
                            <rect x="27" y="42" width="14" height="9" rx="3" fill="white" opacity=".6"/>
                            <!-- Legs -->
                            <rect x="20" y="65" width="11" height="25" rx="5.5" fill="#3730a3"/>
                            <rect x="37" y="65" width="11" height="25" rx="5.5" fill="#3730a3"/>
                            <!-- Arms up (holding paper) -->
                            <rect x="4" y="30" width="14" height="9" rx="4.5" fill="#c7d2fe" stroke="#a5b4fc" stroke-width="1.5" transform="rotate(-15 4 30)"/>
                            <rect x="50" y="30" width="14" height="9" rx="4.5" fill="#c7d2fe" stroke="#a5b4fc" stroke-width="1.5" transform="rotate(15 50 30)"/>
                        </svg>
                    </div>

                    {{-- Person 3 --}}
                    <div class="avatar-bob3 flex flex-col items-center gap-2">
                        <div class="bubble-float bg-white rounded-2xl rounded-bl-sm px-3 py-2 shadow-lg text-xs font-bold text-[#1a3a6b] whitespace-nowrap"
                             style="box-shadow:0 8px 20px rgba(0,0,0,.15); animation-delay:2s;">
                            Data saya aman? 🔒
                        </div>
                        <svg width="60" height="90" viewBox="0 0 60 90" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <!-- Head -->
                            <circle cx="30" cy="18" r="13" fill="#FCA5A5" stroke="#F87171" stroke-width="1.5"/>
                            <!-- Eyes -->
                            <circle cx="25" cy="16" r="2" fill="#1a3a6b"/>
                            <circle cx="35" cy="16" r="2" fill="#1a3a6b"/>
                            <!-- Smile -->
                            <path d="M25 22 Q30 26 35 22" stroke="#1a3a6b" stroke-width="1.5" stroke-linecap="round" fill="none"/>
                            <!-- Hair (bun) -->
                            <path d="M18 14 Q17 5 30 4 Q43 5 42 14" fill="#92400e" stroke="none"/>
                            <circle cx="30" cy="5" r="5" fill="#92400e"/>
                            <!-- Body -->
                            <rect x="16" y="31" width="28" height="30" rx="10" fill="#bbf7d0" stroke="#86efac" stroke-width="1.5"/>
                            <!-- Legs -->
                            <rect x="18" y="58" width="10" height="22" rx="5" fill="#166534"/>
                            <rect x="32" y="58" width="10" height="22" rx="5" fill="#166534"/>
                            <!-- Arms -->
                            <rect x="4" y="32" width="12" height="8" rx="4" fill="#bbf7d0" stroke="#86efac" stroke-width="1.5"/>
                            <rect x="44" y="32" width="12" height="8" rx="4" fill="#bbf7d0" stroke="#86efac" stroke-width="1.5"/>
                        </svg>
                    </div>

                </div>
            </div>
        </div>

        {{-- Wave --}}
        <div class="absolute bottom-0 left-0 right-0">
            <svg viewBox="0 0 1440 48" fill="none" preserveAspectRatio="none">
                <path d="M0 48L1440 48L1440 24C1200 48 960 8 720 24C480 40 240 0 0 24L0 48Z" fill="#f3f6fc"/>
            </svg>
        </div>
    </div>

    {{-- ─── FAQ LIST ─── --}}
    <div class="max-w-2xl mx-auto px-4 py-10">

        @php $faqs = \App\Models\Faq::aktif()->get(); @endphp

        @forelse($faqs as $i => $faq)
        <div class="faq-item fu bg-white rounded-2xl border border-gray-100 shadow-sm mb-3 overflow-hidden"
             style="animation-delay: {{ $i * 0.06 }}s;">

            <button type="button"
                    onclick="toggleFaq(this)"
                    class="faq-btn w-full text-left px-6 py-5 flex items-start gap-4 rounded-2xl">

                {{-- Number + mini avatar --}}
                <div class="flex-shrink-0 flex flex-col items-center gap-1.5 pt-0.5">
                    <div class="w-8 h-8 rounded-xl flex items-center justify-center font-black text-xs text-white"
                         style="background:linear-gradient(135deg,#1a3a6b,#2352a0);">
                        {{ str_pad($i+1, 2, '0', STR_PAD_LEFT) }}
                    </div>
                    {{-- Mini person SVG --}}
                    <svg width="22" height="28" viewBox="0 0 22 28" fill="none" class="opacity-40">
                        <circle cx="11" cy="7" r="5.5" fill="#1a3a6b"/>
                        <rect x="3" y="13" width="16" height="15" rx="7" fill="#1a3a6b"/>
                    </svg>
                </div>

                <div class="flex-1 min-w-0">
                    <p class="font-bold text-gray-800 text-sm leading-snug pr-4">{{ $faq->pertanyaan }}</p>
                </div>

                {{-- Plus / X icon --}}
                <div class="faq-icon flex-shrink-0 w-7 h-7 rounded-lg bg-gray-100 flex items-center justify-center mt-0.5">
                    <svg class="w-3.5 h-3.5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/>
                    </svg>
                </div>
            </button>

            <div class="faq-answer">
                <div class="px-6 pb-5 flex gap-4">
                    {{-- Vertical line accent --}}
                    <div class="w-0.5 flex-shrink-0 rounded-full ml-3.5" style="background:linear-gradient(to bottom,#1a3a6b,transparent);"></div>
                    <p class="text-gray-500 text-sm leading-relaxed flex-1">{{ $faq->jawaban }}</p>
                </div>
            </div>
        </div>
        @empty
        <div class="text-center py-16">
            <div class="w-16 h-16 bg-gray-100 rounded-2xl flex items-center justify-center mx-auto mb-4">
                <svg class="w-8 h-8 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
            <p class="text-gray-400 font-medium">Belum ada FAQ tersedia.</p>
        </div>
        @endforelse

        {{-- Still confused CTA --}}
        <div class="mt-8 fu bg-gradient-to-br from-[#0f2654] to-[#1e4d8c] rounded-2xl p-6 flex items-center gap-5">
            <div class="flex-shrink-0">
                <svg width="52" height="60" viewBox="0 0 52 60" fill="none">
                    <circle cx="26" cy="16" r="12" fill="#FDE68A" stroke="#FCD34D" stroke-width="1.5"/>
                    <circle cx="21" cy="14" r="2" fill="#1a3a6b"/>
                    <circle cx="31" cy="14" r="2" fill="#1a3a6b"/>
                    <path d="M21 21 Q26 25 31 21" stroke="#1a3a6b" stroke-width="1.5" stroke-linecap="round" fill="none"/>
                    <path d="M14 16 Q13 7 26 6 Q39 7 38 16" fill="#7c3aed"/>
                    <rect x="12" y="28" width="28" height="26" rx="10" fill="#c7d2fe" stroke="#a5b4fc" stroke-width="1.5"/>
                    <rect x="3" y="29" width="10" height="8" rx="4" fill="#c7d2fe" stroke="#a5b4fc" stroke-width="1.5"/>
                    <rect x="39" y="29" width="10" height="8" rx="4" fill="#c7d2fe" stroke="#a5b4fc" stroke-width="1.5"/>
                </svg>
            </div>
            <div class="flex-1">
                <p class="text-white font-black text-sm mb-1">Masih ada pertanyaan?</p>
                <p class="text-blue-300/70 text-xs mb-3">Hubungi kami langsung atau buat laporan pengaduan.</p>
                <a href="{{ route('beranda') }}"
                   class="inline-flex items-center gap-1.5 text-xs font-bold px-4 py-2 rounded-xl transition-all hover:-translate-y-0.5"
                   style="background:linear-gradient(135deg,#f59e0b,#fb923c); color:#1a1a1a; box-shadow:0 4px 12px rgba(245,158,11,.3);">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                    </svg>
                    Kembali ke Beranda
                </a>
            </div>
        </div>

    </div>
</div>

<script>
function toggleFaq(btn) {
    const item = btn.closest('.faq-item');
    const isOpen = item.classList.contains('open');
    // Close all
    document.querySelectorAll('.faq-item.open').forEach(el => el.classList.remove('open'));
    // Open clicked if was closed
    if (!isOpen) item.classList.add('open');
}
</script>

@endsection     