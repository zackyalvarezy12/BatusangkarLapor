@extends('layouts.admin')
@section('title', 'Kelola Daerah')
@section('breadcrumb', 'Kelola Daerah')

@section('content')
<div class="py-6 space-y-6">

    {{-- Header --}}
    <div class="relative overflow-hidden bg-primary rounded-3xl p-8 shadow-lg">
        <div class="absolute inset-0 opacity-5">
            <svg width="100%" height="100%"><defs><pattern id="g" width="40" height="40" patternUnits="userSpaceOnUse">
                <path d="M 40 0 L 0 0 0 40" fill="none" stroke="white" stroke-width="1"/>
            </pattern></defs><rect width="100%" height="100%" fill="url(#g)"/></svg>
        </div>
        <div class="relative flex items-center justify-between flex-wrap gap-4">
            <div class="flex items-center gap-4">
                <div class="w-14 h-14 bg-white/20 rounded-2xl flex items-center justify-center border border-white/30">
                    <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                              d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0zM15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                    </svg>
                </div>
                <div>
                    <span class="bg-secondary text-gray-900 text-xs font-black px-3 py-0.5 rounded-full">
                        Manajemen
                    </span>
                    <h1 class="text-2xl font-black text-white mt-1">Kelola Daerah</h1>
                    <p class="text-blue-200 text-sm">Atur wilayah penugasan petugas lapangan</p>
                </div>
            </div>
            <button onclick="openModal('modalTambah')"
                    class="inline-flex items-center gap-2 bg-secondary hover:bg-yellow-400 text-gray-900 font-bold text-sm px-5 py-2.5 rounded-xl transition">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
                Tambah Daerah
            </button>
        </div>
    </div>

    @if(session('success'))
    <div class="bg-green-50 border border-green-200 text-green-700 px-5 py-3 rounded-2xl text-sm font-medium flex items-center gap-2">
        <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
        </svg>
        {{ session('success') }}
    </div>
    @endif
    @if(session('error'))
    <div class="bg-red-50 border border-red-200 text-red-700 px-5 py-3 rounded-2xl text-sm font-medium flex items-center gap-2">
        <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
        </svg>
        {{ session('error') }}
    </div>
    @endif

    {{-- Grid Daerah --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
        @forelse($wilayas as $w)
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-5 hover:shadow-md transition group">
            <div class="flex items-start justify-between mb-4">
                <div class="w-12 h-12 {{ $w->is_active ? 'bg-primary' : 'bg-gray-300' }} rounded-xl flex items-center justify-center transition">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                              d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0zM15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                    </svg>
                </div>
                <div class="flex items-center gap-1.5">
                    <button onclick="openEdit({{ $w->id }}, '{{ addslashes($w->nama) }}')"
                            class="w-8 h-8 bg-gray-100 hover:bg-primary hover:text-white text-gray-500 rounded-lg flex items-center justify-center transition">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                        </svg>
                    </button>
                    <form method="POST" action="{{ route('admin.wilaya.toggle', $w) }}">
                        @csrf @method('PATCH')
                        <button type="submit"
                                class="w-8 h-8 rounded-lg flex items-center justify-center transition
                                    {{ $w->is_active ? 'bg-yellow-50 hover:bg-yellow-500 text-yellow-600 hover:text-white' : 'bg-green-50 hover:bg-green-500 text-green-600 hover:text-white' }}"
                                title="{{ $w->is_active ? 'Nonaktifkan' : 'Aktifkan' }}">
                            @if($w->is_active)
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M10 9v6m4-6v6m7-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            @else
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            @endif
                        </button>
                    </form>
                    <form method="POST" action="{{ route('admin.wilaya.destroy', $w) }}"
                          onsubmit="return confirm('Hapus daerah {{ $w->nama }}?')">
                        @csrf @method('DELETE')
                        <button type="submit"
                                class="w-8 h-8 bg-red-50 hover:bg-red-500 text-red-500 hover:text-white rounded-lg flex items-center justify-center transition">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                            </svg>
                        </button>
                    </form>
                </div>
            </div>

            <h3 class="font-bold text-gray-800 text-base mb-1">{{ $w->nama }}</h3>
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-1.5 text-xs text-gray-400">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                    {{ $w->pengaduans_count }} laporan
                </div>
                <span class="text-xs font-semibold px-2.5 py-1 rounded-full
                    {{ $w->is_active ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-500' }}">
                    {{ $w->is_active ? 'Aktif' : 'Nonaktif' }}
                </span>
            </div>
        </div>
        @empty
        <div class="col-span-3 bg-white rounded-2xl p-16 text-center shadow-sm border border-gray-100">
            <div class="w-16 h-16 bg-gray-100 rounded-2xl flex items-center justify-center mx-auto mb-4">
                <svg class="w-8 h-8 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                          d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0zM15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                </svg>
            </div>
            <p class="font-semibold text-gray-700 mb-1">Belum ada daerah</p>
            <p class="text-gray-400 text-sm mb-4">Tambahkan daerah untuk mulai menugaskan petugas</p>
            <button onclick="openModal('modalTambah')"
                    class="inline-flex items-center gap-2 bg-primary hover:bg-blue-900 text-white font-semibold text-sm px-5 py-2.5 rounded-xl transition">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
                Tambah Daerah Pertama
            </button>
        </div>
        @endforelse
    </div>

    {{-- Pagination --}}
    @if($wilayas->hasPages())
    <div>{{ $wilayas->links() }}</div>
    @endif
</div>

{{-- Modal Tambah --}}
<div id="modalTambah" class="hidden fixed inset-0 z-50 flex items-center justify-center p-4">
    <div class="absolute inset-0 bg-black/50 backdrop-blur-sm" onclick="closeModal('modalTambah')"></div>
    <div class="relative bg-white rounded-3xl shadow-2xl w-full max-w-md p-8 z-10">
        <div class="flex items-center gap-3 mb-6">
            <div class="w-10 h-10 bg-primary rounded-xl flex items-center justify-center">
                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0zM15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                </svg>
            </div>
            <div>
                <h3 class="font-bold text-gray-800">Tambah Daerah Baru</h3>
                <p class="text-gray-400 text-xs">Isi nama daerah / wilayah</p>
            </div>
        </div>
        <form method="POST" action="{{ route('admin.wilaya.store') }}" class="space-y-4">
            @csrf
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">
                    Nama Daerah <span class="text-red-400">*</span>
                </label>
                <input type="text" name="nama" required autofocus
                       placeholder="Contoh: Kecamatan Batusangkar"
                       class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary transition">
                @error('nama')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>
            <div class="flex gap-3 pt-2">
                <button type="button" onclick="closeModal('modalTambah')"
                        class="flex-1 bg-gray-100 hover:bg-gray-200 text-gray-700 font-semibold py-3 rounded-xl transition text-sm">
                    Batal
                </button>
                <button type="submit"
                        class="flex-1 bg-primary hover:bg-blue-900 text-white font-semibold py-3 rounded-xl transition text-sm">
                    Simpan Daerah
                </button>
            </div>
        </form>
    </div>
</div>

{{-- Modal Edit --}}
<div id="modalEdit" class="hidden fixed inset-0 z-50 flex items-center justify-center p-4">
    <div class="absolute inset-0 bg-black/50 backdrop-blur-sm" onclick="closeModal('modalEdit')"></div>
    <div class="relative bg-white rounded-3xl shadow-2xl w-full max-w-md p-8 z-10">
        <div class="flex items-center gap-3 mb-6">
            <div class="w-10 h-10 bg-secondary rounded-xl flex items-center justify-center">
                <svg class="w-5 h-5 text-gray-900" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                </svg>
            </div>
            <div>
                <h3 class="font-bold text-gray-800">Edit Daerah</h3>
                <p class="text-gray-400 text-xs">Ubah nama daerah</p>
            </div>
        </div>
        <form method="POST" id="editForm" class="space-y-4">
            @csrf @method('PUT')
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">
                    Nama Daerah <span class="text-red-400">*</span>
                </label>
                <input type="text" name="nama" id="editNama" required
                       class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary transition">
            </div>
            <div class="flex gap-3 pt-2">
                <button type="button" onclick="closeModal('modalEdit')"
                        class="flex-1 bg-gray-100 hover:bg-gray-200 text-gray-700 font-semibold py-3 rounded-xl transition text-sm">
                    Batal
                </button>
                <button type="submit"
                        class="flex-1 bg-primary hover:bg-blue-900 text-white font-semibold py-3 rounded-xl transition text-sm">
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
function openModal(id) {
    document.getElementById(id).classList.remove('hidden');
    document.body.style.overflow = 'hidden';
}
function closeModal(id) {
    document.getElementById(id).classList.add('hidden');
    document.body.style.overflow = '';
}
function openEdit(id, nama) {
    document.getElementById('editForm').action = `/admin/wilaya/${id}`;
    document.getElementById('editNama').value = nama;
    openModal('modalEdit');
}
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        closeModal('modalTambah');
        closeModal('modalEdit');
    }
});
</script>
@endpush
@endsection