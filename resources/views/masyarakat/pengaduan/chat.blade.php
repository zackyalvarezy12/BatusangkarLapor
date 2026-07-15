@extends('layouts.app')
@section('title', 'Chat Laporan')

@section('content')

{{-- Navbar --}}
<nav class="bg-white/95 backdrop-blur-md shadow-sm border-b border-gray-100 sticky top-[28px] z-40">
    <div class="max-w-5xl mx-auto px-4 py-3 flex items-center justify-between">
        <div class="flex items-center gap-3">
            <a href="{{ route('masyarakat.pengaduan.show', $pengaduan->slug) }}"
               class="w-9 h-9 bg-gray-100 hover:bg-gray-200 rounded-xl flex items-center justify-center transition">
                <svg class="w-4 h-4 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                </svg>
            </a>
            <div class="flex items-center gap-2.5">
                <div class="w-9 h-9 bg-primary rounded-xl flex items-center justify-center">
                    <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
                    </svg>
                </div>
                <div>
                    <p class="font-bold text-gray-800 text-sm truncate max-w-[200px]">{{ $pengaduan->judul }}</p>
                    <div class="flex items-center gap-1.5">
                        <span class="w-1.5 h-1.5 bg-green-400 rounded-full animate-pulse"></span>
                        <span class="text-xs text-gray-400">Realtime aktif</span>
                    </div>
                </div>
            </div>
        </div>
        <div class="flex items-center gap-2">
            @php $b = $pengaduan->status_badge; @endphp
            <span class="inline-flex items-center gap-1.5 text-xs font-semibold px-2.5 py-1 rounded-full
                {{ $b['color']==='yellow' ? 'bg-yellow-100 text-yellow-800' : '' }}
                {{ $b['color']==='blue'   ? 'bg-blue-100 text-blue-800'     : '' }}
                {{ $b['color']==='green'  ? 'bg-green-100 text-green-800'   : '' }}
                {{ $b['color']==='red'    ? 'bg-red-100 text-red-800'       : '' }}">
                <span class="w-1.5 h-1.5 rounded-full
                    {{ $b['color']==='yellow' ? 'bg-yellow-500' : '' }}
                    {{ $b['color']==='blue'   ? 'bg-blue-500'   : '' }}
                    {{ $b['color']==='green'  ? 'bg-green-500'  : '' }}
                    {{ $b['color']==='red'    ? 'bg-red-500'    : '' }}">
                </span>
                {{ $b['label'] }}
            </span>
        </div>
    </div>
</nav>

<div class="max-w-5xl mx-auto px-4 py-6">
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-4">

        {{-- ── Chat Box ── --}}
        <div class="lg:col-span-2 bg-white rounded-3xl shadow-sm border border-gray-100 flex flex-col" style="height:600px;">

            {{-- Header --}}
            <div class="px-5 py-4 border-b border-gray-100 bg-gray-50 rounded-t-3xl">
                <div class="flex items-center gap-3">
                    @if($pengaduan->petugas)
                    <img src="{{ $pengaduan->petugas->avatar_url }}" class="w-10 h-10 rounded-xl object-cover">
                    <div>
                        <p class="font-bold text-gray-800 text-sm">{{ $pengaduan->petugas->name }}</p>
                        <p class="text-xs text-blue-500 font-medium">Petugas {{ $pengaduan->wilaya->nama ?? '' }}</p>
                    </div>
                    @else
                    <div class="w-10 h-10 bg-gray-200 rounded-xl flex items-center justify-center">
                        <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                        </svg>
                    </div>
                    <div>
                        <p class="font-bold text-gray-800 text-sm">Menunggu Petugas</p>
                        <p class="text-xs text-gray-400">Laporan sedang menunggu penugasan</p>
                    </div>
                    @endif
                </div>
            </div>

            {{-- Messages --}}
            <div id="chatBox" class="flex-1 overflow-y-auto px-5 py-4 space-y-4">
                @forelse($pesans as $p)
                @php $isSelf = $p->user_id === auth()->id(); @endphp
                <div class="flex {{ $isSelf ? 'justify-end' : 'justify-start' }} gap-2.5" data-id="{{ $p->id }}">
                    @if(!$isSelf)
                    <img src="{{ $p->user->avatar_url }}" class="w-8 h-8 rounded-xl object-cover flex-shrink-0 mt-1">
                    @endif
                    <div class="max-w-[75%] space-y-1">
                        @if(!$isSelf)
                        <p class="text-xs text-gray-400 font-medium px-1">
                            {{ $p->user->name }}
                            <span class="text-blue-500 ml-1">· {{ ucfirst($p->user->role) }}</span>
                        </p>
                        @endif
                        @if($p->pesan)
                        <div class="px-4 py-3 rounded-2xl text-sm leading-relaxed
                            {{ $isSelf ? 'bg-blue-600 text-white rounded-br-sm' : 'bg-gray-100 text-gray-800 rounded-tl-sm' }}">
                            {{ $p->pesan }}
                        </div>
                        @endif
                        @foreach($p->lampirans as $l)
                        <div class="rounded-2xl overflow-hidden border {{ $isSelf ? 'border-blue-200' : 'border-gray-200' }}">
                            @if($l->isImage())
                            <a href="{{ $l->url }}" target="_blank">
                                <img src="{{ $l->url }}" class="max-w-[240px] max-h-[200px] object-cover hover:opacity-90 transition">
                            </a>
                            @else
                            <a href="{{ $l->url }}" target="_blank"
                               class="flex items-center gap-3 px-4 py-3 {{ $isSelf ? 'bg-blue-600 text-white' : 'bg-gray-50 text-gray-700' }} hover:opacity-90 transition">
                                <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                </svg>
                                <div class="min-w-0">
                                    <p class="text-xs font-semibold truncate">{{ $l->nama_file }}</p>
                                    <p class="text-xs opacity-70">{{ number_format($l->ukuran/1024, 1) }} KB</p>
                                </div>
                            </a>
                            @endif
                        </div>
                        @endforeach
                        <p class="text-xs text-gray-400 {{ $isSelf ? 'text-right' : 'text-left' }} px-1">
                            {{ $p->created_at->format('H:i') }}
                        </p>
                    </div>
                    @if($isSelf)
                    <img src="{{ $p->user->avatar_url }}" class="w-8 h-8 rounded-xl object-cover flex-shrink-0 mt-1">
                    @endif
                </div>
                @empty
                <div class="flex flex-col items-center justify-center h-full gap-3 text-center py-10">
                    <div class="w-16 h-16 bg-blue-50 rounded-2xl flex items-center justify-center">
                        <svg class="w-8 h-8 text-blue-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                  d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
                        </svg>
                    </div>
                    <div>
                        <p class="font-semibold text-gray-700 text-sm">Belum ada pesan</p>
                        <p class="text-gray-400 text-xs mt-1">Kirim pesan pertama untuk memulai percakapan</p>
                    </div>
                </div>
                @endforelse
                <div id="chatEnd"></div>
            </div>

            {{-- Preview Lampiran --}}
            <div id="previewArea" class="hidden px-5 py-3 border-t border-gray-100 bg-gray-50">
                <div class="flex items-center justify-between mb-2">
                    <p class="text-xs font-semibold text-gray-600">File terpilih:</p>
                    <button type="button" onclick="clearFiles()" class="text-xs text-red-500 hover:underline">Hapus semua</button>
                </div>
                <div id="previewList" class="flex flex-wrap gap-2"></div>
            </div>

            {{-- Input --}}
            <div class="px-5 py-4 border-t border-gray-100">
                <form id="chatForm" enctype="multipart/form-data">
                    @csrf
                    <input type="file" id="fileInput" name="lampirans[]" multiple
                           accept="image/*,.pdf,.doc,.docx,.xls,.xlsx" class="hidden">
                    <div class="flex items-end gap-3">
                        <button type="button" onclick="document.getElementById('fileInput').click()"
                                class="w-10 h-10 bg-gray-100 hover:bg-gray-200 rounded-xl flex items-center justify-center flex-shrink-0 transition">
                            <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13"/>
                            </svg>
                        </button>
                        <div class="flex-1">
                            <textarea id="pesanInput" name="pesan" rows="1" placeholder="Tulis pesan..."
                                      class="w-full border border-gray-200 rounded-2xl px-4 py-3 text-sm resize-none focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary transition"
                                      style="max-height:120px"></textarea>
                        </div>
                        <button type="submit" id="sendBtn"
                                class="w-10 h-10 bg-blue-600 hover:bg-blue-700 rounded-xl flex items-center justify-center flex-shrink-0 transition disabled:opacity-50">
                            <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/>
                            </svg>
                        </button>
                    </div>
                </form>
            </div>
        </div>

        {{-- ── Sidebar Info ── --}}
        <div class="space-y-4">

            {{-- Info Laporan --}}
            <div class="bg-white rounded-3xl shadow-sm border border-gray-100 p-5">
                <h3 class="font-bold text-gray-800 text-sm mb-4 flex items-center gap-2">
                    <div class="w-7 h-7 bg-primary/10 rounded-lg flex items-center justify-center">
                        <svg class="w-3.5 h-3.5 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                    </div>
                    Detail Laporan
                </h3>
                <div class="space-y-3">
                    <div>
                        <p class="text-xs text-gray-400 mb-0.5">Kode Laporan</p>
                        <p class="font-mono text-xs font-bold text-primary bg-primary/5 px-2.5 py-1.5 rounded-lg inline-block">
                            {{ $pengaduan->kode_laporan }}
                        </p>
                    </div>
                    <div>
                        <p class="text-xs text-gray-400 mb-0.5">Kategori</p>
                        <p class="text-sm font-semibold text-gray-700">{{ $pengaduan->kategori->nama ?? '-' }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-gray-400 mb-0.5">Daerah</p>
                        <p class="text-sm font-semibold text-gray-700">{{ $pengaduan->wilaya->nama ?? '-' }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-gray-400 mb-0.5">Tanggal Lapor</p>
                        <p class="text-sm font-semibold text-gray-700">{{ $pengaduan->created_at->format('d M Y') }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-gray-400 mb-0.5">Petugas</p>
                        <div class="flex items-center gap-2 mt-1">
                            @if($pengaduan->petugas)
                            <img src="{{ $pengaduan->petugas->avatar_url }}" class="w-7 h-7 rounded-lg object-cover">
                            <p class="text-sm font-semibold text-gray-700">{{ $pengaduan->petugas->name }}</p>
                            @else
                            <span class="text-xs text-gray-400 italic">Belum ditugaskan</span>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            {{-- Panduan --}}
            <div class="bg-blue-50 rounded-3xl border border-blue-100 p-5">
                <h3 class="font-bold text-blue-800 text-sm mb-3 flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    Panduan Chat
                </h3>
                <ul class="space-y-2 text-xs text-blue-700">
                    <li class="flex items-start gap-2">
                        <svg class="w-3.5 h-3.5 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                        </svg>
                        Pesan diperbarui otomatis tiap 3 detik
                    </li>
                    <li class="flex items-start gap-2">
                        <svg class="w-3.5 h-3.5 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                        </svg>
                        Bisa kirim foto, PDF, dan dokumen
                    </li>
                    <li class="flex items-start gap-2">
                        <svg class="w-3.5 h-3.5 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                        </svg>
                        Maksimal 10MB per file
                    </li>
                    <li class="flex items-start gap-2">
                        <svg class="w-3.5 h-3.5 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                        </svg>
                        Enter untuk kirim, Shift+Enter untuk baris baru
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
const PESAN_URL   = "{{ route('masyarakat.pengaduan.pesan', $pengaduan->slug) }}";
const POLLING_URL = "{{ route('masyarakat.pengaduan.pesan.baru', $pengaduan->slug) }}";
const AUTH_ID     = {{ auth()->id() }};
const CSRF        = "{{ csrf_token() }}";
let lastId = {{ $pesans->isNotEmpty() ? $pesans->last()->id : 0 }};

const textarea = document.getElementById('pesanInput');
textarea.addEventListener('input', function() {
    this.style.height = 'auto';
    this.style.height = Math.min(this.scrollHeight, 120) + 'px';
});
textarea.addEventListener('keydown', function(e) {
    if (e.key === 'Enter' && !e.shiftKey) {
        e.preventDefault();
        document.getElementById('chatForm').dispatchEvent(new Event('submit'));
    }
});

document.getElementById('fileInput').addEventListener('change', function() {
    const files = Array.from(this.files);
    if (!files.length) return;
    const previewList = document.getElementById('previewList');
    previewList.innerHTML = '';
    document.getElementById('previewArea').classList.remove('hidden');
    files.forEach(file => {
        const div = document.createElement('div');
        div.className = 'flex items-center gap-2 bg-white border border-gray-200 rounded-xl px-3 py-2 text-xs';
        if (file.type.startsWith('image/')) {
            const img = document.createElement('img');
            img.src = URL.createObjectURL(file);
            img.className = 'w-8 h-8 rounded-lg object-cover flex-shrink-0';
            div.appendChild(img);
        } else {
            div.innerHTML += `<div class="w-8 h-8 bg-gray-100 rounded-lg flex items-center justify-center flex-shrink-0"><svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg></div>`;
        }
        const name = document.createElement('span');
        name.className = 'text-gray-600 truncate max-w-[100px]';
        name.textContent = file.name;
        div.appendChild(name);
        previewList.appendChild(div);
    });
});

function clearFiles() {
    document.getElementById('fileInput').value = '';
    document.getElementById('previewArea').classList.add('hidden');
    document.getElementById('previewList').innerHTML = '';
}

document.getElementById('chatForm').addEventListener('submit', async function(e) {
    e.preventDefault();
    const pesan = textarea.value.trim();
    const files = document.getElementById('fileInput').files;
    if (!pesan && !files.length) return;

    const btn = document.getElementById('sendBtn');
    btn.disabled = true;

    const fd = new FormData();
    fd.append('_token', CSRF);
    if (pesan) fd.append('pesan', pesan);
    Array.from(files).forEach(f => fd.append('lampirans[]', f));

    try {
        await fetch(PESAN_URL, { method: 'POST', body: fd });
        textarea.value = '';
        textarea.style.height = 'auto';
        clearFiles();
        await pollPesan();
    } catch(err) { console.error(err); }
    finally { btn.disabled = false; textarea.focus(); }
});

function renderPesan(p) {
    const isSelf = p.user_id === AUTH_ID;
    const wrap = document.createElement('div');
    wrap.className = `flex ${isSelf ? 'justify-end' : 'justify-start'} gap-2.5`;
    wrap.dataset.id = p.id;

    let html = '';
    if (!isSelf) html += `<img src="${p.avatar}" class="w-8 h-8 rounded-xl object-cover flex-shrink-0 mt-1">`;
    html += `<div class="max-w-[75%] space-y-1">`;
    if (!isSelf) html += `<p class="text-xs text-gray-400 font-medium px-1">${p.user} <span class="text-blue-500 ml-1">· ${p.role.charAt(0).toUpperCase()+p.role.slice(1)}</span></p>`;
    if (p.pesan) html += `<div class="px-4 py-3 rounded-2xl text-sm leading-relaxed ${isSelf ? 'bg-primary text-white rounded-tr-sm' : 'bg-gray-100 text-gray-800 rounded-tl-sm'}">${p.pesan}</div>`;

    p.lampirans.forEach(l => {
        if (l.is_image) {
            html += `<div class="rounded-2xl overflow-hidden border ${isSelf?'border-blue-200':'border-gray-200'}"><a href="${l.url}" target="_blank"><img src="${l.url}" class="max-w-[240px] max-h-[200px] object-cover hover:opacity-90 transition"></a></div>`;
        } else {
            html += `<div class="rounded-2xl overflow-hidden border ${isSelf?'border-blue-200':'border-gray-200'}"><a href="${l.url}" target="_blank" class="flex items-center gap-3 px-4 py-3 ${isSelf?'bg-blue-600 text-white':'bg-gray-50 text-gray-700'} hover:opacity-90 transition"><svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg><div class="min-w-0"><p class="text-xs font-semibold truncate">${l.nama_file}</p></div></a></div>`;
        }
    });

    html += `<p class="text-xs text-gray-400 ${isSelf?'text-right':'text-left'} px-1">${p.waktu}</p></div>`;
    if (isSelf) html += `<img src="${p.avatar}" class="w-8 h-8 rounded-xl object-cover flex-shrink-0 mt-1">`;

    wrap.innerHTML = html;
    document.getElementById('chatEnd').before(wrap);
    document.getElementById('chatBox').scrollTop = document.getElementById('chatBox').scrollHeight;
}

async function pollPesan() {
    try {
        const res  = await fetch(`${POLLING_URL}?last_id=${lastId}`);
        const data = await res.json();
        data.forEach(p => {
            if (!document.querySelector(`[data-id="${p.id}"]`)) {
                renderPesan(p);
                lastId = p.id;
            }
        });
    } catch(e) {}
}

document.getElementById('chatBox').scrollTop = document.getElementById('chatBox').scrollHeight;
setInterval(pollPesan, 3000);
</script>
@endpush
@endsection