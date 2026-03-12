@extends('layouts.admin')
@section('title', 'Kelola FAQ')
@section('breadcrumb', 'FAQ')

@section('content')
<div class="py-6 space-y-6">

    <div class="flex items-center justify-between">
        <div>
            <h1 class="font-black text-gray-800 text-xl">Kelola FAQ</h1>
            <p class="text-gray-400 text-sm mt-0.5">Pertanyaan umum yang tampil di halaman publik</p>
        </div>
        <button onclick="document.getElementById('modalTambah').classList.remove('hidden')"
                class="inline-flex items-center gap-2 text-white text-sm font-semibold px-4 py-2.5 rounded-xl transition"
                style="background:#003580;">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
            </svg>
            Tambah FAQ
        </button>
    </div>

    @if(session('success'))
    <div class="bg-green-50 border border-green-200 text-green-700 text-sm font-medium px-4 py-3 rounded-xl">
        {!! session('success') !!}
    </div>
    @endif

    {{-- List FAQ --}}
    <div class="space-y-3">
        @forelse($faqs as $i => $faq)
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
            <div class="p-5 flex items-start gap-4">
                {{-- Nomor --}}
                <div class="w-9 h-9 rounded-xl flex items-center justify-center font-black text-xs text-white flex-shrink-0"
                     style="background:#003580;">
                    {{ str_pad($i+1, 2, '0', STR_PAD_LEFT) }}
                </div>

                {{-- Konten --}}
                <div class="flex-1 min-w-0">
                    <p class="font-bold text-gray-800 text-sm">{{ $faq->pertanyaan }}</p>
                    <p class="text-gray-500 text-xs mt-1.5 leading-relaxed line-clamp-2">{{ $faq->jawaban }}</p>
                    <div class="flex items-center gap-2 mt-2">
                        <span class="text-xs px-2 py-0.5 rounded-full font-semibold
                            {{ $faq->is_aktif ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-500' }}">
                            {{ $faq->is_aktif ? 'Aktif' : 'Nonaktif' }}
                        </span>
                        <span class="text-xs text-gray-400">Urutan: {{ $faq->urutan ?? '-' }}</span>
                    </div>
                </div>

                {{-- Aksi --}}
                <div class="flex items-center gap-2 flex-shrink-0">
                    {{-- Edit --}}
                    <button onclick="openEdit({{ $faq->id }}, {{ json_encode($faq->pertanyaan) }}, {{ json_encode($faq->jawaban) }}, {{ $faq->urutan ?? 0 }})"
                            class="w-8 h-8 bg-blue-50 hover:bg-blue-100 text-blue-600 rounded-xl flex items-center justify-center transition">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                        </svg>
                    </button>
                    {{-- Toggle --}}
                    <form method="POST" action="{{ route('admin.faq.toggle', $faq) }}">
                        @csrf @method('PATCH')
                        <button type="submit"
                                class="w-8 h-8 rounded-xl flex items-center justify-center transition
                                {{ $faq->is_aktif ? 'bg-amber-50 hover:bg-amber-100 text-amber-600' : 'bg-green-50 hover:bg-green-100 text-green-600' }}">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                @if($faq->is_aktif)
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"/>
                                @else
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                @endif
                            </svg>
                        </button>
                    </form>
                    {{-- Hapus --}}
                    <form method="POST" action="{{ route('admin.faq.destroy', $faq) }}"
                          onsubmit="return confirm('Hapus FAQ ini?')">
                        @csrf @method('DELETE')
                        <button type="submit"
                                class="w-8 h-8 bg-red-50 hover:bg-red-100 text-red-500 rounded-xl flex items-center justify-center transition">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                            </svg>
                        </button>
                    </form>
                </div>
            </div>
        </div>
        @empty
        <div class="bg-white rounded-2xl border border-gray-100 p-16 text-center">
            <div class="w-14 h-14 bg-gray-100 rounded-2xl flex items-center justify-center mx-auto mb-3">
                <svg class="w-7 h-7 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                          d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
            <p class="text-gray-400 font-medium text-sm">Belum ada FAQ. Tambah sekarang!</p>
        </div>
        @endforelse
    </div>
</div>

{{-- ── MODAL TAMBAH ── --}}
<div id="modalTambah" class="hidden fixed inset-0 z-50 flex items-center justify-center p-4"
     style="background:rgba(0,0,0,.5);">
    <div class="bg-white rounded-3xl shadow-2xl w-full max-w-lg p-8">
        <div class="flex items-center justify-between mb-6">
            <h2 class="font-black text-gray-800 text-lg">Tambah FAQ</h2>
            <button onclick="document.getElementById('modalTambah').classList.add('hidden')"
                    class="w-8 h-8 bg-gray-100 hover:bg-gray-200 rounded-xl flex items-center justify-center transition">
                <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>
        <form method="POST" action="{{ route('admin.faq.store') }}" class="space-y-4">
            @csrf
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">Pertanyaan</label>
                <input type="text" name="pertanyaan" required placeholder="Tulis pertanyaan..."
                       class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-blue-100 focus:border-blue-400 transition">
            </div>
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">Jawaban</label>
                <textarea name="jawaban" required rows="4" placeholder="Tulis jawaban lengkap..."
                          class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-blue-100 focus:border-blue-400 transition resize-none"></textarea>
            </div>
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">Urutan <span class="text-gray-400 font-normal">(opsional)</span></label>
                <input type="number" name="urutan" min="1" placeholder="1, 2, 3..."
                       class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-blue-100 focus:border-blue-400 transition">
            </div>
            <div class="flex gap-3 pt-2">
                <button type="button" onclick="document.getElementById('modalTambah').classList.add('hidden')"
                        class="flex-1 bg-gray-100 hover:bg-gray-200 text-gray-700 font-semibold py-3 rounded-xl text-sm transition">
                    Batal
                </button>
                <button type="submit"
                        class="flex-1 text-white font-semibold py-3 rounded-xl text-sm transition"
                        style="background:#003580;">
                    Simpan FAQ
                </button>
            </div>
        </form>
    </div>
</div>

{{-- ── MODAL EDIT ── --}}
<div id="modalEdit" class="hidden fixed inset-0 z-50 flex items-center justify-center p-4"
     style="background:rgba(0,0,0,.5);">
    <div class="bg-white rounded-3xl shadow-2xl w-full max-w-lg p-8">
        <div class="flex items-center justify-between mb-6">
            <h2 class="font-black text-gray-800 text-lg">Edit FAQ</h2>
            <button onclick="document.getElementById('modalEdit').classList.add('hidden')"
                    class="w-8 h-8 bg-gray-100 hover:bg-gray-200 rounded-xl flex items-center justify-center transition">
                <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>
        <form method="POST" id="formEdit" class="space-y-4">
            @csrf @method('PUT')
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">Pertanyaan</label>
                <input type="text" name="pertanyaan" id="editPertanyaan" required
                       class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-blue-100 focus:border-blue-400 transition">
            </div>
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">Jawaban</label>
                <textarea name="jawaban" id="editJawaban" required rows="4"
                          class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-blue-100 focus:border-blue-400 transition resize-none"></textarea>
            </div>
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">Urutan</label>
                <input type="number" name="urutan" id="editUrutan" min="1"
                       class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-blue-100 focus:border-blue-400 transition">
            </div>
            <div class="flex gap-3 pt-2">
                <button type="button" onclick="document.getElementById('modalEdit').classList.add('hidden')"
                        class="flex-1 bg-gray-100 hover:bg-gray-200 text-gray-700 font-semibold py-3 rounded-xl text-sm transition">
                    Batal
                </button>
                <button type="submit"
                        class="flex-1 text-white font-semibold py-3 rounded-xl text-sm transition"
                        style="background:#003580;">
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
function openEdit(id, pertanyaan, jawaban, urutan) {
    document.getElementById('editPertanyaan').value = pertanyaan;
    document.getElementById('editJawaban').value = jawaban;
    document.getElementById('editUrutan').value = urutan || '';
    document.getElementById('formEdit').action = '/admin/faq/' + id;
    document.getElementById('modalEdit').classList.remove('hidden');
}
</script>
@endpush
@endsection