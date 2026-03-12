@extends('layouts.admin')
@section('title', 'Kategori')
@section('breadcrumb', 'Kategori')

@section('content')
<div class="py-6 space-y-5">

{{-- Header --}}
<div class="flex items-center justify-between flex-wrap gap-3">
    <div>
        <h2 class="text-[20px] font-black text-ink">Manajemen Kategori</h2>
        <p class="text-ink-muted text-[13px] mt-0.5">{{ $kategoris->count() }} kategori terdaftar</p>
    </div>
    <button onclick="openModal('modalTambah')"
            class="inline-flex items-center gap-2 bg-navy hover:bg-navy-900 text-white font-bold text-[13px] px-5 py-2.5 rounded-xl transition shadow-lg shadow-navy/25">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/>
        </svg>
        Tambah Kategori
    </button>
</div>

{{-- Grid --}}
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
    @forelse($kategoris as $k)
    @php
        $colors = ['bg-blue-500','bg-emerald-500','bg-violet-500','bg-amber-500','bg-rose-500','bg-cyan-500','bg-orange-500','bg-pink-500'];
        $bg = $colors[$loop->index % count($colors)];
    @endphp
    <div class="card-elevated p-5 hover:shadow-md transition-all duration-200 hover:-translate-y-0.5 group">
        <div class="flex items-start justify-between gap-3 mb-4">
            <div class="flex items-center gap-3 min-w-0">
                {{-- Color dot instead of emoji --}}
                <div class="w-11 h-11 rounded-xl {{ $bg }} flex items-center justify-center flex-shrink-0 shadow-md">
                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round"
                              d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
                    </svg>
                </div>
                <div class="min-w-0">
                    <h3 class="font-bold text-ink text-[14px] truncate">{{ $k->nama }}</h3>
                    <p class="text-ink-muted text-[12px] mt-0.5">{{ $k->pengaduans_count ?? 0 }} laporan</p>
                </div>
            </div>
            <span class="flex-shrink-0 text-[10px] font-bold px-2.5 py-1 rounded-full border
                {{ $k->is_active
                    ? 'bg-emerald-50 text-emerald-700 border-emerald-200'
                    : 'bg-slate-100 text-slate-500 border-slate-200' }}">
                {{ $k->is_active ? 'Aktif' : 'Nonaktif' }}
            </span>
        </div>

        @if($k->deskripsi)
        <p class="text-[12px] text-slate-500 mb-4 line-clamp-2 leading-relaxed">{{ $k->deskripsi }}</p>
        @endif

        {{-- Urutan badge --}}
        <div class="flex items-center gap-1 mb-4">
            <span class="text-[10px] text-slate-400 font-mono">Urutan: {{ $k->urutan ?? 0 }}</span>
        </div>

        <div class="flex items-center gap-2 pt-3 border-t border-slate-100">
            <button onclick="openEdit({{ $k->id }}, '{{ addslashes($k->nama) }}', '{{ addslashes($k->deskripsi ?? '') }}', {{ $k->urutan ?? 0 }}, {{ $k->is_active ? 'true':'false' }})"
                    class="flex-1 bg-blue-50 hover:bg-blue-100 text-blue-700 text-[11px] font-bold py-2 rounded-xl transition text-center">
                Edit
            </button>
            <form method="POST" action="{{ route('admin.kategori.toggle', $k->id) }}" class="flex-1">
                @csrf @method('PATCH')
                <button type="submit"
                        class="w-full text-[11px] font-bold py-2 rounded-xl transition
                               {{ $k->is_active
                                   ? 'bg-amber-50 hover:bg-amber-100 text-amber-700'
                                   : 'bg-emerald-50 hover:bg-emerald-100 text-emerald-700' }}">
                    {{ $k->is_active ? 'Nonaktifkan' : 'Aktifkan' }}
                </button>
            </form>
            <form method="POST" action="{{ route('admin.kategori.destroy', $k->id) }}"
                  onsubmit="return confirm('Hapus kategori \'{{ $k->nama }}\'?')">
                @csrf @method('DELETE')
                <button type="submit"
                        class="w-10 h-9 bg-rose-50 hover:bg-rose-100 text-rose-500 rounded-xl transition flex items-center justify-center">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round"
                              d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                    </svg>
                </button>
            </form>
        </div>
    </div>
    @empty
    <div class="col-span-3 card py-20 text-center">
        <div class="w-14 h-14 bg-slate-100 rounded-2xl flex items-center justify-center mx-auto mb-4">
            <svg class="w-7 h-7 text-slate-300" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round"
                      d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
            </svg>
        </div>
        <p class="text-slate-500 font-semibold">Belum ada kategori</p>
        <button onclick="openModal('modalTambah')"
                class="mt-4 text-brand text-sm font-semibold hover:underline">
            Tambah kategori pertama
        </button>
    </div>
    @endforelse
</div>

</div>

{{-- ══ MODAL TAMBAH ══ --}}
<div id="modalTambah" class="hidden fixed inset-0 z-50 bg-ink/40 backdrop-blur-sm flex items-center justify-center p-4">
    <div class="bg-white rounded-3xl shadow-2xl w-full max-w-md animate-in">
        <div class="flex items-center justify-between px-6 py-5 border-b border-slate-100">
            <h3 class="font-black text-ink text-[16px]">Tambah Kategori</h3>
            <button onclick="closeModal('modalTambah')"
                    class="w-8 h-8 hover:bg-slate-100 rounded-xl flex items-center justify-center transition">
                <svg class="w-4 h-4 text-slate-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>
        <form method="POST" action="{{ route('admin.kategori.store') }}" class="px-6 py-5 space-y-4">
            @csrf
            <div>
                <label class="block text-[11px] font-bold text-slate-500 uppercase tracking-wider mb-2">
                    Nama Kategori <span class="text-rose-400 normal-case tracking-normal">*</span>
                </label>
                <input type="text" name="nama" required placeholder="Contoh: Infrastruktur & Jalan"
                       class="w-full border border-slate-200 rounded-xl px-4 py-2.5 text-[13px] font-medium focus:outline-none focus:ring-2 focus:ring-brand/20 focus:border-brand transition">
            </div>
            <div>
                <label class="block text-[11px] font-bold text-slate-500 uppercase tracking-wider mb-2">Deskripsi</label>
                <textarea name="deskripsi" rows="2" placeholder="Deskripsi singkat..."
                          class="w-full border border-slate-200 rounded-xl px-4 py-2.5 text-[13px] font-medium focus:outline-none focus:ring-2 focus:ring-brand/20 focus:border-brand transition resize-none"></textarea>
            </div>
            <div>
                <label class="block text-[11px] font-bold text-slate-500 uppercase tracking-wider mb-2">Urutan Tampil</label>
                <input type="number" name="urutan" value="0" min="0"
                       class="w-full border border-slate-200 rounded-xl px-4 py-2.5 text-[13px] font-medium focus:outline-none focus:ring-2 focus:ring-brand/20 focus:border-brand transition">
            </div>
            <label class="flex items-center gap-2.5 cursor-pointer select-none">
                <input type="checkbox" name="is_active" value="1" checked
                       class="w-4 h-4 rounded accent-brand">
                <span class="text-[13px] text-ink font-medium">Aktifkan kategori sekarang</span>
            </label>
            <div class="flex gap-3 pt-2">
                <button type="button" onclick="closeModal('modalTambah')"
                        class="flex-1 bg-slate-100 hover:bg-slate-200 text-slate-600 font-semibold text-[13px] py-3 rounded-xl transition">Batal</button>
                <button type="submit"
                        class="flex-1 bg-navy hover:bg-navy-900 text-white font-bold text-[13px] py-3 rounded-xl transition shadow-lg shadow-navy/20">
                    Simpan
                </button>
            </div>
        </form>
    </div>
</div>

{{-- ══ MODAL EDIT ══ --}}
<div id="modalEdit" class="hidden fixed inset-0 z-50 bg-ink/40 backdrop-blur-sm flex items-center justify-center p-4">
    <div class="bg-white rounded-3xl shadow-2xl w-full max-w-md">
        <div class="flex items-center justify-between px-6 py-5 border-b border-slate-100">
            <h3 class="font-black text-ink text-[16px]">Edit Kategori</h3>
            <button onclick="closeModal('modalEdit')"
                    class="w-8 h-8 hover:bg-slate-100 rounded-xl flex items-center justify-center transition">
                <svg class="w-4 h-4 text-slate-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>
        <form id="formEdit" method="POST" class="px-6 py-5 space-y-4">
            @csrf @method('PUT')
            <div>
                <label class="block text-[11px] font-bold text-slate-500 uppercase tracking-wider mb-2">
                    Nama Kategori <span class="text-rose-400 normal-case tracking-normal">*</span>
                </label>
                <input type="text" id="editNama" name="nama" required
                       class="w-full border border-slate-200 rounded-xl px-4 py-2.5 text-[13px] font-medium focus:outline-none focus:ring-2 focus:ring-brand/20 focus:border-brand transition">
            </div>
            <div>
                <label class="block text-[11px] font-bold text-slate-500 uppercase tracking-wider mb-2">Deskripsi</label>
                <textarea id="editDeskripsi" name="deskripsi" rows="2"
                          class="w-full border border-slate-200 rounded-xl px-4 py-2.5 text-[13px] font-medium focus:outline-none focus:ring-2 focus:ring-brand/20 focus:border-brand transition resize-none"></textarea>
            </div>
            <div>
                <label class="block text-[11px] font-bold text-slate-500 uppercase tracking-wider mb-2">Urutan Tampil</label>
                <input type="number" id="editUrutan" name="urutan" min="0"
                       class="w-full border border-slate-200 rounded-xl px-4 py-2.5 text-[13px] font-medium focus:outline-none focus:ring-2 focus:ring-brand/20 focus:border-brand transition">
            </div>
            <label class="flex items-center gap-2.5 cursor-pointer select-none">
                <input type="checkbox" id="editIsActive" name="is_active" value="1"
                       class="w-4 h-4 rounded accent-brand">
                <span class="text-[13px] text-ink font-medium">Kategori aktif</span>
            </label>
            <div class="flex gap-3 pt-2">
                <button type="button" onclick="closeModal('modalEdit')"
                        class="flex-1 bg-slate-100 hover:bg-slate-200 text-slate-600 font-semibold text-[13px] py-3 rounded-xl transition">Batal</button>
                <button type="submit"
                        class="flex-1 bg-navy hover:bg-navy-900 text-white font-bold text-[13px] py-3 rounded-xl transition shadow-lg shadow-navy/20">
                    Update
                </button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
function openModal(id)  { document.getElementById(id).classList.remove('hidden'); }
function closeModal(id) { document.getElementById(id).classList.add('hidden'); }

function openEdit(id, nama, deskripsi, urutan, isActive) {
    document.getElementById('formEdit').action = `/admin/kategori/${id}`;
    document.getElementById('editNama').value      = nama;
    document.getElementById('editDeskripsi').value = deskripsi;
    document.getElementById('editUrutan').value    = urutan;
    document.getElementById('editIsActive').checked = isActive;
    openModal('modalEdit');
}

// Close modal on backdrop click
['modalTambah','modalEdit'].forEach(id => {
    document.getElementById(id).addEventListener('click', function(e) {
        if (e.target === this) closeModal(id);
    });
});
</script>
@endpush
@endsection