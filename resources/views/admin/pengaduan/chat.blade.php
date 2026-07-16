@extends('layouts.admin')
@section('title', 'Chat Laporan')
@section('breadcrumb', 'Chat Laporan')

@section('content')
<div class="py-6 space-y-4 max-w-5xl mx-auto">

    {{-- Header --}}
    <div class="relative overflow-hidden bg-primary rounded-3xl p-6 shadow-lg">
        <div class="absolute inset-0 opacity-5">
            <svg width="100%" height="100%"><defs><pattern id="g" width="40" height="40" patternUnits="userSpaceOnUse">
                <path d="M 40 0 L 0 0 0 40" fill="none" stroke="white" stroke-width="1"/>
            </pattern></defs><rect width="100%" height="100%" fill="url(#g)"/></svg>
        </div>
        <div class="relative flex items-start justify-between flex-wrap gap-4">
            <div class="flex items-start gap-4">
                <a href="{{ route('admin.pengaduan.show', $pengaduan->slug) }}"
                   class="w-10 h-10 bg-white/20 hover:bg-white/30 rounded-xl flex items-center justify-center transition flex-shrink-0">
                    <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                    </svg>
                </a>
                <div>
                    <div class="flex items-center gap-2 mb-1 flex-wrap">
                        <span class="bg-secondary text-gray-900 text-xs font-black px-3 py-0.5 rounded-full">
                            {{ $pengaduan->kode_laporan }}
                        </span>
                        @php $b = $pengaduan->status_badge; @endphp
                        <span class="text-xs font-semibold px-2.5 py-0.5 rounded-full
                            {{ $b['color']==='yellow' ? 'bg-yellow-100 text-yellow-800' : '' }}
                            {{ $b['color']==='blue'   ? 'bg-blue-100 text-blue-800'     : '' }}
                            {{ $b['color']==='green'  ? 'bg-green-100 text-green-800'   : '' }}
                            {{ $b['color']==='red'    ? 'bg-red-100 text-red-800'       : '' }}">
                            {{ $b['label'] }}
                        </span>
                        <span class="bg-white/20 text-white text-xs font-semibold px-2.5 py-0.5 rounded-full">
                            Mode: Admin (Lihat Semua)
                        </span>
                    </div>
                    <h1 class="text-lg font-black text-white">{{ $pengaduan->judul }}</h1>
                    <div class="flex items-center gap-4 mt-1 flex-wrap">
                        <span class="text-blue-200 text-xs flex items-center gap-1">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                            </svg>
                            {{ $pengaduan->user->name }}
                        </span>
                        <span class="text-blue-200 text-xs flex items-center gap-1">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                            </svg>
                            {{ $pengaduan->wilaya->nama ?? '-' }}
                        </span>
                        <span class="text-blue-200 text-xs flex items-center gap-1">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                            </svg>
                            Petugas: {{ $pengaduan->petugas->name ?? 'Belum ditugaskan' }}
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-4">

        {{-- Chat Box --}}
        <div class="lg:col-span-2 bg-white rounded-3xl shadow-sm border border-gray-100 flex flex-col" style="height:600px;">
            <div class="px-5 py-4 border-b border-gray-100 flex items-center gap-3">
                <div class="w-9 h-9 bg-purple-600 rounded-xl flex items-center justify-center">
                    <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
                    </svg>
                </div>
                <div>
                    <p class="font-bold text-gray-800 text-sm">Semua Percakapan</p>
                    <p class="text-gray-400 text-xs flex items-center gap-1">
                        <span class="w-1.5 h-1.5 bg-green-400 rounded-full animate-pulse inline-block"></span>
                        Realtime aktif · Admin view
                    </p>
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
                        @php
                        $roleColor = match($p->user->role) {
                            'admin'   => 'text-purple-500',
                            'petugas' => 'text-blue-500',
                            default   => 'text-green-500',
                        };
                        @endphp
                        <p class="text-xs text-gray-400 font-medium px-1">
                            {{ $p->user->name }}
                            <span class="{{ $roleColor }} ml-1">· {{ ucfirst($p->user->role) }}</span>
                        </p>
                        @endif
                        @if($p->pesan)
                        <div class="px-4 py-3 rounded-2xl text-sm leading-relaxed
                            {{ $isSelf ? 'bg-purple-600 text-white rounded-tr-sm' : 'bg-gray-100 text-gray-800 rounded-tl-sm' }}">
                            {{ $p->pesan }}
                        </div>
                        @endif
                        @foreach($p->lampirans as $l)
                        <div class="rounded-2xl overflow-hidden border {{ $isSelf ? 'border-purple-200' : 'border-gray-200' }}">
                            @if($l->isImage())
                            <a href="{{ $l->url }}" target="_blank">
                                <img src="{{ $l->url }}" class="max-w-[240px] max-h-[200px] object-cover hover:opacity-90 transition">
                            </a>
                            @else
                            <a href="{{ $l->url }}" target="_blank"
                               class="flex items-center gap-3 px-4 py-3 {{ $isSelf ? 'bg-purple-600 text-white' : 'bg-gray-50 text-gray-700' }} hover:opacity-90 transition">
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
                    <div class="w-16 h-16 bg-purple-50 rounded-2xl flex items-center justify-center">
                        <svg class="w-8 h-8 text-purple-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                  d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
                        </svg>
                    </div>
                    <p class="font-semibold text-gray-700 text-sm">Belum ada pesan</p>
                </div>
                @endforelse
                <div id="chatEnd"></div>
            </div>

            {{-- Preview --}}
            <div id="previewArea" class="hidden px-5 py-3 border-t border-gray-100 bg-gray-50">
                <div class="flex items-center justify-between mb-2">
                    <p class="text-xs font-semibold text-gray-600">File terpilih:</p>
                    <button onclick="clearFiles()" class="text-xs text-red-500 hover:underline">Hapus semua</button>
                </div>
                <div id="previewList" class="flex flex-wrap gap-2"></div>
            </div>

            {{-- Input --}}
            <div class="px-5 py-4 border-t border-gray-100">
                <form id="chatForm" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="is_internal" id="isInternal" value="0">
                    <input type="file" id="fileInput" name="lampirans[]" multiple
                           accept="image/*,.pdf,.doc,.docx,.xls,.xlsx" class="hidden"
                           capture="environment">
                    <div class="flex items-end gap-3">
                        <button type="button" onclick="document.getElementById('fileInput').click()"
                                class="w-10 h-10 bg-gray-100 hover:bg-gray-200 rounded-xl flex items-center justify-center flex-shrink-0 transition">
                            <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13"/>
                            </svg>
                        </button>
                        <div class="flex-1">
                            <textarea id="pesanInput" name="pesan" rows="1" placeholder="Tulis pesan sebagai admin..."
                                      class="w-full border border-gray-200 rounded-2xl px-4 py-3 text-sm resize-none focus:outline-none focus:ring-2 focus:ring-purple-300 focus:border-purple-400 transition"
                                      style="max-height:120px"></textarea>
                        </div>
                        <button type="submit" id="sendBtn"
                                class="w-10 h-10 bg-purple-600 hover:bg-purple-700 rounded-xl flex items-center justify-center flex-shrink-0 transition">
                            <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/>
                            </svg>
                        </button>
                    </div>
                </form>
            </div>
        </div>

        {{-- Sidebar --}}
        <div class="space-y-4">
            <div class="bg-white rounded-3xl shadow-sm border border-gray-100 p-5">
                <h3 class="font-bold text-gray-800 text-sm mb-4 flex items-center gap-2">
                    <div class="w-7 h-7 bg-purple-100 rounded-lg flex items-center justify-center">
                        <svg class="w-3.5 h-3.5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
                        </svg>
                    </div>
                    Peserta Chat
                </h3>
                <div class="space-y-3">
                    {{-- Pelapor --}}
                    <div class="flex items-center gap-3 p-3 bg-green-50 rounded-xl">
                        <img src="{{ $pengaduan->user->avatar_url }}" class="w-9 h-9 rounded-xl object-cover">
                        <div class="flex-1 min-w-0">
                            <p class="font-semibold text-gray-800 text-xs truncate">{{ $pengaduan->user->name }}</p>
                            <p class="text-green-600 text-xs">Pelapor</p>
                        </div>
                    </div>
                    {{-- Petugas --}}
                    @if($pengaduan->petugas)
                    <div class="flex items-center gap-3 p-3 bg-blue-50 rounded-xl">
                        <img src="{{ $pengaduan->petugas->avatar_url }}" class="w-9 h-9 rounded-xl object-cover">
                        <div class="flex-1 min-w-0">
                            <p class="font-semibold text-gray-800 text-xs truncate">{{ $pengaduan->petugas->name }}</p>
                            <p class="text-blue-600 text-xs">Petugas · {{ $pengaduan->wilaya->nama ?? '' }}</p>
                        </div>
                    </div>
                    @endif
                    {{-- Admin --}}
                    <div class="flex items-center gap-3 p-3 bg-purple-50 rounded-xl">
                        <img src="{{ auth()->user()->avatar_url }}" class="w-9 h-9 rounded-xl object-cover">
                        <div class="flex-1 min-w-0">
                            <p class="font-semibold text-gray-800 text-xs truncate">{{ auth()->user()->name }}</p>
                            <p class="text-purple-600 text-xs">Admin</p>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Riwayat Status --}}
            <div class="bg-white rounded-3xl shadow-sm border border-gray-100 p-5">
                <h3 class="font-bold text-gray-800 text-sm mb-4 flex items-center gap-2">
                    <div class="w-7 h-7 bg-primary/10 rounded-lg flex items-center justify-center">
                        <svg class="w-3.5 h-3.5 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    Riwayat Status
                </h3>
                @php
                $histories = \App\Models\PengaduanHistory::with('user')
                    ->where('pengaduan_id', $pengaduan->id)
                    ->latest()->take(5)->get();
                @endphp
                <div class="space-y-3">
                    @forelse($histories as $h)
                    <div class="flex gap-3">
                        <div class="w-1.5 flex flex-col items-center">
                            <div class="w-1.5 h-1.5 bg-primary rounded-full mt-1.5 flex-shrink-0"></div>
                            @if(!$loop->last)<div class="w-px flex-1 bg-gray-200 mt-1"></div>@endif
                        </div>
                        <div class="pb-3 flex-1">
                            <p class="text-xs font-semibold text-gray-700">{{ $h->status_baru }}</p>
                            <p class="text-xs text-gray-400">{{ $h->user->name ?? '-' }} · {{ $h->created_at->format('d M H:i') }}</p>
                        </div>
                    </div>
                    @empty
                    <p class="text-xs text-gray-400 text-center py-2">Belum ada riwayat</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
const PESAN_URL   = "{{ route('admin.pengaduan.pesan', $pengaduan->slug) }}";
const POLLING_URL = "{{ route('admin.pengaduan.pesan.baru', $pengaduan->slug) }}";
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
        const isImageFile = file.type.startsWith('image/') || /\.(jpg|jpeg|png|gif|webp|avif|heic|heif)$/i.test(file.name);
        if (isImageFile) {
            const img = document.createElement('img');
            img.src = URL.createObjectURL(file);
            img.className = 'w-8 h-8 rounded-lg object-cover flex-shrink-0';
            div.appendChild(img);
        } else {
            div.innerHTML += `<div class="w-8 h-8 bg-gray-100 rounded-lg flex items-center justify-center"><svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg></div>`;
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

async function compressImage(file) {
    if (!file.type.startsWith('image/')) return file;

    const imageBitmap = await createImageBitmap(file);
    const canvas = document.createElement('canvas');
    const maxWidth = 1280;
    const scale = Math.min(1, maxWidth / Math.max(imageBitmap.width, imageBitmap.height));
    canvas.width = Math.max(1, Math.round(imageBitmap.width * scale));
    canvas.height = Math.max(1, Math.round(imageBitmap.height * scale));

    const ctx = canvas.getContext('2d');
    ctx.drawImage(imageBitmap, 0, 0, canvas.width, canvas.height);

    const blob = await new Promise(resolve => canvas.toBlob(resolve, 'image/jpeg', 0.85));
    if (!blob) return file;

    return new File([blob], file.name.replace(/\.[^.]+$/, '.jpg'), { type: 'image/jpeg' });
}

document.getElementById('chatForm').addEventListener('submit', async function(e) {
    e.preventDefault();
    const pesan = textarea.value.trim();
    const files = Array.from(document.getElementById('fileInput').files);
    if (!pesan && !files.length) return;

    const btn = document.getElementById('sendBtn');
    btn.disabled = true;

    const fd = new FormData();
    fd.append('_token', CSRF);
    if (pesan) fd.append('pesan', pesan);

    for (const file of files) {
        const compressed = await compressImage(file);
        fd.append('lampirans[]', compressed);
    }

    try {
        const response = await fetch(PESAN_URL, {
            method: 'POST',
            body: fd,
            headers: { 'X-Requested-With': 'XMLHttpRequest' }
        });

        let payload = null;
        try { payload = await response.json(); } catch (e) {}

        textarea.value = '';
        textarea.style.height = 'auto';
        clearFiles();

        if (payload?.success && payload?.pesan) {
            renderPesan(payload.pesan);
            lastId = payload.pesan.id;
        } else {
            await pollPesan();
        }
    } catch(err) { console.error(err); }
    finally { btn.disabled = false; textarea.focus(); }
});

function renderPesan(p) {
    const isSelf = p.user_id === AUTH_ID;
    const roleColors = { admin: 'text-purple-500', petugas: 'text-blue-500', masyarakat: 'text-green-500' };
    const bubbleColor = isSelf ? 'bg-purple-600 text-white rounded-tr-sm' : 'bg-gray-100 text-gray-800 rounded-tl-sm';

    const wrap = document.createElement('div');
    wrap.className = `flex ${isSelf ? 'justify-end' : 'justify-start'} gap-2.5`;
    wrap.dataset.id = p.id;

    let html = '';
    if (!isSelf) html += `<img src="${p.avatar}" class="w-8 h-8 rounded-xl object-cover flex-shrink-0 mt-1">`;
    html += `<div class="max-w-[75%] space-y-1">`;
    if (!isSelf) {
        const rc = roleColors[p.role] || 'text-gray-500';
        html += `<p class="text-xs text-gray-400 font-medium px-1">${p.user} <span class="${rc} ml-1">· ${p.role.charAt(0).toUpperCase()+p.role.slice(1)}</span></p>`;
    }
    if (p.pesan) html += `<div class="px-4 py-3 rounded-2xl text-sm leading-relaxed ${bubbleColor}">${p.pesan}</div>`;
    p.lampirans.forEach(l => {
        if (l.is_image) {
            html += `<div class="rounded-2xl overflow-hidden border"><a href="${l.url}" target="_blank"><img src="${l.url}" class="max-w-[240px] max-h-[200px] object-cover"></a></div>`;
        } else {
            html += `<div class="rounded-2xl overflow-hidden border"><a href="${l.url}" target="_blank" class="flex items-center gap-3 px-4 py-3 bg-gray-50 text-gray-700"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg><p class="text-xs font-semibold truncate">${l.nama_file}</p></a></div>`;
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