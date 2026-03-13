{{-- ══ SECTION PENILAIAN ══ --}}
{{-- Gunakan di masyarakat/show, admin/show, petugas/show --}}
{{-- Variabel yang dibutuhkan: $pengaduan, $penilaian (optional load dari controller) --}}

@php
    $penilaianData = $pengaduan->penilaians ?? collect();
    $avgNilai      = $penilaianData->count() > 0 ? round($penilaianData->avg('nilai'), 1) : null;
    $myPenilaian   = auth()->check() ? $penilaianData->where('user_id', auth()->id())->first() : null;
    $bolehNilai    = auth()->check()
                     && $pengaduan->status === 'selesai'
                     && auth()->id() === $pengaduan->user_id
                     && !$myPenilaian;
@endphp

@if($pengaduan->status === 'selesai')
<div class="bg-white rounded-3xl border border-gray-100 shadow-sm p-6">

    {{-- Header --}}
    <h3 class="font-bold text-gray-700 text-sm mb-5 flex items-center gap-2">
        <div class="w-6 h-6 bg-amber-100 rounded-lg flex items-center justify-center">
            <svg class="w-3.5 h-3.5 text-amber-500" fill="currentColor" viewBox="0 0 20 20">
                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
            </svg>
        </div>
        Penilaian Layanan
        @if($penilaianData->count() > 0)
        <span class="ml-auto text-xs text-gray-400 font-normal">{{ $penilaianData->count() }} penilaian</span>
        @endif
    </h3>

    {{-- Rata-rata rating --}}
    @if($avgNilai)
    <div class="flex items-center gap-4 bg-amber-50 rounded-2xl p-4 mb-5">
        <div class="text-center">
            <div class="text-4xl font-black text-amber-500 leading-none">{{ $avgNilai }}</div>
            <div class="text-xs text-gray-400 mt-1">dari 5</div>
        </div>
        <div class="flex-1">
            <div class="flex gap-0.5 mb-2">
                @for($i = 1; $i <= 5; $i++)
                <svg class="w-5 h-5 {{ $i <= round($avgNilai) ? 'text-amber-400' : 'text-gray-200' }}" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                </svg>
                @endfor
            </div>
            {{-- Bar per bintang --}}
            @for($bintang = 5; $bintang >= 1; $bintang--)
            @php $jumlah = $penilaianData->where('nilai', $bintang)->count(); $persen = $penilaianData->count() > 0 ? ($jumlah / $penilaianData->count()) * 100 : 0; @endphp
            <div class="flex items-center gap-2 mb-1">
                <span class="text-[10px] text-gray-400 w-3">{{ $bintang }}</span>
                <div class="flex-1 h-1.5 bg-gray-100 rounded-full overflow-hidden">
                    <div class="h-full bg-amber-400 rounded-full transition-all" style="width: {{ $persen }}%"></div>
                </div>
                <span class="text-[10px] text-gray-400 w-4">{{ $jumlah }}</span>
            </div>
            @endfor
        </div>
    </div>
    @else
    <div class="flex flex-col items-center py-4 mb-4">
        <div class="flex gap-0.5 mb-2">
            @for($i = 1; $i <= 5; $i++)
            <svg class="w-6 h-6 text-gray-200" fill="currentColor" viewBox="0 0 20 20">
                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
            </svg>
            @endfor
        </div>
        <p class="text-xs text-gray-400">Belum ada penilaian</p>
    </div>
    @endif

    {{-- Form penilaian — hanya pelapor, hanya sekali --}}
    @if($bolehNilai)
    <form method="POST" action="{{ route('masyarakat.penilaian.store', $pengaduan->slug) }}" class="space-y-4 border-t border-gray-100 pt-4">
        @csrf
        <p class="text-xs font-semibold text-gray-600">Beri penilaian untuk layanan ini:</p>

        {{-- Star picker --}}
        <div class="flex items-center gap-1" id="starPicker">
            @for($i = 1; $i <= 5; $i++)
            <button type="button" onclick="setStar({{ $i }})"
                    class="star-btn w-9 h-9 transition-transform hover:scale-110"
                    data-val="{{ $i }}">
                <svg class="w-9 h-9 text-gray-200 star-icon" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                </svg>
            </button>
            @endfor
            <input type="hidden" name="nilai" id="nilaiInput" required>
            <span id="starLabel" class="text-xs text-gray-400 ml-2"></span>
        </div>

        <textarea name="komentar" rows="3" placeholder="Tulis komentar (opsional)..."
                  class="w-full border border-gray-200 rounded-2xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-amber-400/30 focus:border-amber-400 transition resize-none"></textarea>

        <button type="submit"
                class="w-full bg-gradient-to-r from-amber-400 to-orange-400 hover:from-amber-500 hover:to-orange-500 text-white font-bold text-sm py-2.5 rounded-xl flex items-center justify-center gap-2 transition shadow-md shadow-amber-200">
            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
            </svg>
            Kirim Penilaian
        </button>
    </form>

    <script>
    const labels = ['','Sangat Buruk','Buruk','Cukup','Baik','Sangat Baik'];
    function setStar(val) {
        document.getElementById('nilaiInput').value = val;
        document.getElementById('starLabel').textContent = labels[val];
        document.querySelectorAll('.star-btn').forEach((btn, i) => {
            btn.querySelector('.star-icon').style.color = (i < val) ? '#f59e0b' : '#e5e7eb';
        });
    }
    document.querySelectorAll('.star-btn').forEach(btn => {
        btn.addEventListener('mouseenter', () => {
            const v = parseInt(btn.dataset.val);
            document.querySelectorAll('.star-btn').forEach((b, i) => {
                b.querySelector('.star-icon').style.color = (i < v) ? '#fbbf24' : '#e5e7eb';
            });
        });
        btn.addEventListener('mouseleave', () => {
            const cur = parseInt(document.getElementById('nilaiInput').value) || 0;
            document.querySelectorAll('.star-btn').forEach((b, i) => {
                b.querySelector('.star-icon').style.color = (i < cur) ? '#f59e0b' : '#e5e7eb';
            });
        });
    });
    </script>

    @elseif($myPenilaian)
    {{-- Sudah dinilai --}}
    <div class="border-t border-gray-100 pt-4">
        <div class="flex items-center gap-2 mb-2">
            <div class="flex gap-0.5">
                @for($i = 1; $i <= 5; $i++)
                <svg class="w-4 h-4 {{ $i <= $myPenilaian->nilai ? 'text-amber-400' : 'text-gray-200' }}" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                </svg>
                @endfor
            </div>
            <span class="text-xs font-semibold text-amber-600">Penilaian Anda: {{ $myPenilaian->nilai }}/5</span>
        </div>
        @if($myPenilaian->komentar)
        <p class="text-xs text-gray-500 bg-gray-50 rounded-xl px-3 py-2 italic">"{{ $myPenilaian->komentar }}"</p>
        @endif
        <p class="text-xs text-gray-400 mt-2">Diberikan {{ $myPenilaian->created_at->diffForHumans() }}</p>
    </div>
    @endif

    {{-- Komentar publik --}}
    @php $komentar = $penilaianData->whereNotNull('komentar')->where('komentar','!=','')->take(3); @endphp
    @if($komentar->count() > 0)
    <div class="border-t border-gray-100 pt-4 mt-4 space-y-3">
        <p class="text-xs font-semibold text-gray-500">Komentar Warga</p>
        @foreach($komentar as $pen)
        <div class="bg-gray-50 rounded-2xl px-4 py-3">
            <div class="flex items-center gap-2 mb-1.5">
                <div class="flex gap-0.5">
                    @for($i = 1; $i <= 5; $i++)
                    <svg class="w-3 h-3 {{ $i <= $pen->nilai ? 'text-amber-400' : 'text-gray-200' }}" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                    </svg>
                    @endfor
                </div>
                <span class="text-[10px] text-gray-400">{{ $pen->created_at->format('d M Y') }}</span>
            </div>
            <p class="text-xs text-gray-600 italic">"{{ $pen->komentar }}"</p>
        </div>
        @endforeach
    </div>
    @endif

</div>
@endif