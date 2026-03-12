@extends('layouts.petugas')
@section('title', 'Chat Laporan')
@section('breadcrumb', 'Chat Laporan')

@section('content')
<div class="py-6 space-y-4 max-w-5xl mx-auto">

    {{-- Header --}}
    <div class="relative overflow-hidden rounded-3xl p-6 shadow-lg"
         style="background: linear-gradient(135deg, #3b0764 0%, #5b21b6 50%, #7c3aed 100%);">
        <div class="absolute inset-0 opacity-10">
            <svg width="100%" height="100%"><defs><pattern id="g" width="32" height="32" patternUnits="userSpaceOnUse">
                <circle cx="1" cy="1" r="1" fill="white"/>
            </pattern></defs><rect width="100%" height="100%" fill="url(#g)"/></svg>
        </div>
        <div class="relative flex items-start justify-between flex-wrap gap-4">
            <div class="flex items-start gap-4">
                <a href="{{ route('petugas.pengaduan.show', $pengaduan->slug) }}"
                   class="w-10 h-10 bg-white/20 hover:bg-white/30 rounded-xl flex items-center justify-center transition flex-shrink-0 mt-0.5">
                    <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                    </svg>
                </a>
                <div>
                    <div class="flex items-center gap-2 mb-1 flex-wrap">
                        <span class="bg-yellow-400 text-gray-900 text-xs font-black px-3 py-0.5 rounded-full">
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
                    </div>
                    <h1 class="text-lg font-black text-white">{{ $pengaduan->judul }}</h1>
                    <div class="flex items-center gap-4 mt-1 flex-wrap">
                        <span class="text-violet-200 text-xs flex items-center gap-1">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                            </svg>
                            {{ $pengaduan->is_anonim ? 'Anonim' : ($pengaduan->user->name ?? '-') }}
                        </span>
                        <span class="text-violet-200 text-xs flex items-center gap-1">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                            </svg>
                            {{ $pengaduan->wilaya->nama ?? '-' }}
                        </span>
                    </div>
                </div>
            </div>

            {{-- Update Status Form --}}
            @if(!in_array($pengaduan->status, ['selesai','ditolak']))
            <form method="POST" action="{{ route('petugas.pengaduan.status', $pengaduan->slug) }}"
                  class="flex items-center gap-2 flex-shrink-0">
                @csrf @method('PATCH')
                <select name="status"
                        class="text-xs font-semibold bg-white/20 text-white border border-white/30 rounded-xl px-3 py-2.5 focus:outline-none focus:ring-2 focus:ring-white/30 backdrop-blur">
                    <option value="menunggu" {{ $pengaduan->status==='menunggu'?'selected':'' }} class="text-gray-800 bg-white">Belum Ditindak</option>
                    <option value="proses"   {{ $pengaduan->status==='proses'  ?'selected':'' }} class="text-gray-800 bg-white">Sedang Ditindak</option>
                    <option value="selesai"  {{ $pengaduan->status==='selesai' ?'selected':'' }} class="text-gray-800 bg-white">Selesai</option>
                    <option value="ditolak"  {{ $pengaduan->status==='ditolak' ?'selected':'' }} class="text-gray-800 bg-white">Ditolak</option>
                </select>
                <button type="submit"
                        class="bg-yellow-400 hover:bg-yellow-300 text-gray-900 text-xs font-bold px-4 py-2.5 rounded-xl transition whitespace-nowrap">
                    Update
                </button>
            </form>
            @endif
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-4">

        {{-- ── Chat Box ── --}}
        <div class="lg:col-span-2 bg-white rounded-3xl shadow-sm border border-gray-100 flex flex-col" style="height:600px;">

            {{-- Chat Header --}}
            <div class="px-5 py-4 border-b border-gray-100 flex items-center gap-3">
                <div class="w-9 h-9 bg-violet-600 rounded-xl flex items-center justify-center">
                    <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
                    </svg>
                </div>
                <div>
                    <p class="font-bold text-gray-800 text-sm">Percakapan</p>
                    <p class="text-gray-400 text-xs flex items-center gap-1">
                        <span class="w-1.5 h-1.5 bg-green-400 rounded-full inline-block"></span>
                        Realtime aktif
                    </p>
                </div>
            </div>

            {{-- Messages --}}
            <div id="chatBox" class="flex-1 overflow-y-auto px-5 py-4 space-y-4">
                @foreach($pesans as $p)
                @php $isSelf = $p->user_id === auth()->id(); @endphp
                <div class="flex {{ $isSelf ? 'justify-end' : 'justify-start' }} gap-2.5 items-end" data-id="{{ $p->id }}">

                    {{-- Avatar kiri (orang lain) --}}
                    @if(!$isSelf)
                    <div class="w-8 h-8 rounded-xl flex-shrink-0 flex items-center justify-center text-white font-bold text-xs
                                {{ $p->user->role === 'admin' ? 'bg-purple-600' : ($p->user->role === 'petugas' ? 'bg-violet-600' : 'bg-blue-500') }}">
                        {{ strtoupper(substr($p->user->name ?? 'U', 0, 1)) }}
                    </div>
                    @endif

                    <div class="max-w-[75%] space-y-1">
                        @if(!$isSelf)
                        <p class="text-xs text-gray-400 font-medium px-1">
                            {{ $p->user->name ?? 'User' }}
                            <span class="text-gray-300 mx-1">·</span>
                            <span class="{{ $p->user->role==='admin' ? 'text-purple-500' : 'text-violet-500' }}">
                                {{ ucfirst($p->user->role) }}
                            </span>
                        </p>
                        @endif

                        @if($p->pesan)
                        <div class="px-4 py-3 rounded-2xl text-sm leading-relaxed
                            {{ $isSelf ? 'bg-violet-600 text-white rounded-br-sm' : 'bg-gray-100 text-gray-800 rounded-bl-sm' }}">
                            {{ $p->pesan }}
                        </div>
                        @endif

                        @foreach($p->lampirans as $l)
                        <div class="rounded-2xl overflow-hidden border {{ $isSelf ? 'border-violet-200' : 'border-gray-200' }}">
                            @if($l->isImage())
                            <a href="{{ $l->url }}" target="_blank">
                                <img src="{{ $l->url }}" class="max-w-[240px] max-h-[200px] object-cover hover:opacity-90 transition">
                            </a>
                            @else
                            <a href="{{ $l->url }}" target="_blank"
                               class="flex items-center gap-3 px-4 py-3 {{ $isSelf ? 'bg-violet-600 text-white' : 'bg-gray-50 text-gray-700' }} hover:opacity-90 transition">
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

                    {{-- Avatar kanan (self) --}}
                    @if($isSelf)
                    <div class="w-8 h-8 rounded-xl flex-shrink-0 flex items-center justify-center text-white font-bold text-xs bg-violet-600">
                        {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                    </div>
                    @endif
                </div>
                @endforeach
                <div id="chatEnd"></div>
            </div>

            {{-- Preview Lampiran --}}
            <div id="previewArea" class="hidden px-5 py-3 border-t border-gray-100 bg-violet-50/50">
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
                                class="w-10 h-10 bg-violet-100 hover:bg-violet-200 rounded-xl flex items-center justify-center flex-shrink-0 transition">
                            <svg class="w-5 h-5 text-violet-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13"/>
                            </svg>
                        </button>
                        <div class="flex-1">
                            <textarea id="pesanInput" name="pesan" rows="1" placeholder="Tulis pesan..."
                                      class="w-full border border-gray-200 rounded-2xl px-4 py-3 text-sm resize-none focus:outline-none focus:ring-2 focus:ring-violet-400/30 focus:border-violet-400 transition"
                                      style="max-height:120px"></textarea>
                        </div>
                        <button type="submit" id="sendBtn"
                                class="w-10 h-10 bg-violet-600 hover:bg-violet-700 rounded-xl flex items-center justify-center flex-shrink-0 transition disabled:opacity-50">
                            <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/>
                            </svg>
                        </button>
                    </div>
                </form>
            </div>
        </div>

        {{-- ── Sidebar ── --}}
        <div class="space-y-4">

            {{-- Info Pelapor --}}
            <div class="bg-white rounded-3xl shadow-sm border border-gray-100 p-5">
                <h3 class="font-bold text-gray-800 text-sm mb-4 flex items-center gap-2">
                    <div class="w-7 h-7 bg-violet-100 rounded-lg flex items-center justify-center">
                        <svg class="w-3.5 h-3.5 text-violet-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                        </svg>
                    </div>
                    Info Pelapor
                </h3>
                <div class="flex items-center gap-3 mb-4">
                    <div class="w-11 h-11 rounded-xl bg-blue-500 flex items-center justify-center text-white font-bold text-sm flex-shrink-0">
                        {{ strtoupper(substr($pengaduan->user->name ?? 'U', 0, 1)) }}
                    </div>
                    <div>
                        <p class="font-semibold text-gray-800 text-sm">{{ $pengaduan->is_anonim ? 'Anonim' : ($pengaduan->user->name ?? '-') }}</p>
                        <p class="text-gray-400 text-xs">{{ $pengaduan->is_anonim ? '—' : ($pengaduan->user->email ?? '-') }}</p>
                    </div>
                </div>
                <div class="space-y-2 text-xs">
                    @foreach([
                        ['label'=>'Daerah',      'val'=> $pengaduan->wilaya->nama ?? '-'],
                        ['label'=>'Tanggal Lapor','val'=> $pengaduan->created_at->format('d M Y')],
                        ['label'=>'Kategori',    'val'=> $pengaduan->kategori->nama ?? '-'],
                        ['label'=>'Petugas',     'val'=> $pengaduan->petugas->name ?? 'Belum ditugaskan'],
                    ] as $row)
                    <div class="flex justify-between items-center py-1.5 border-b border-gray-50">
                        <span class="text-gray-400">{{ $row['label'] }}</span>
                        <span class="font-semibold text-gray-700 text-right max-w-[55%]">{{ $row['val'] }}</span>
                    </div>
                    @endforeach
                </div>
            </div>

            {{-- Riwayat Status --}}
            <div class="bg-white rounded-3xl shadow-sm border border-gray-100 p-5">
                <h3 class="font-bold text-gray-800 text-sm mb-4 flex items-center gap-2">
                    <div class="w-7 h-7 bg-violet-100 rounded-lg flex items-center justify-center">
                        <svg class="w-3.5 h-3.5 text-violet-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    Riwayat Status
                </h3>
                @php
                $histories = \App\Models\PengaduanHistory::with('user')
                    ->where('pengaduan_id', $pengaduan->id)
                    ->orderBy('created_at','asc')->get();
                @endphp
                <div class="space-y-3">
                    @forelse($histories as $h)
                    @php
                    $hColors = ['menunggu'=>'amber','proses'=>'blue','selesai'=>'emerald','ditolak'=>'rose'];
                    $hc = $hColors[$h->status_baru] ?? 'gray';
                    @endphp
                    <div class="flex gap-3">
                        <div class="flex flex-col items-center">
                            <div class="w-5 h-5 rounded-full bg-{{ $hc }}-100 border-2 border-{{ $hc }}-400 flex items-center justify-center flex-shrink-0">
                                <div class="w-1.5 h-1.5 rounded-full bg-{{ $hc }}-500"></div>
                            </div>
                            @if(!$loop->last)
                            <div class="w-px flex-1 bg-gray-100 mt-1 mb-1"></div>
                            @endif
                        </div>
                        <div class="{{ $loop->last ? '' : 'pb-3' }} flex-1">
                            <p class="text-xs font-bold text-gray-700 capitalize">{{ $h->status_baru }}</p>
                            @if($h->keterangan)
                            <p class="text-xs text-gray-500 mt-0.5">{{ $h->keterangan }}</p>
                            @endif
                            <p class="text-xs text-gray-400 mt-0.5">{{ $h->user->name ?? '-' }} · {{ $h->created_at->format('d M H:i') }}</p>
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
const PESAN_URL   = "{{ route('petugas.pengaduan.pesan', $pengaduan->slug) }}";
const POLLING_URL = "{{ route('petugas.pengaduan.pesan.baru', $pengaduan->slug) }}";
const AUTH_ID     = {{ auth()->id() }};
const CSRF        = "{{ csrf_token() }}";

let lastId = {{ $pesans->isNotEmpty() ? $pesans->last()->id : 0 }};
let pollingTimer;

// Auto resize textarea
const textarea = document.getElementById('pesanInput');
textarea.addEventListener('input', function() {
    this.style.height = 'auto';
    this.style.height = Math.min(this.scrollHeight, 120) + 'px';
});

// Enter = kirim, Shift+Enter = newline
textarea.addEventListener('keydown', function(e) {
    if (e.key === 'Enter' && !e.shiftKey) {
        e.preventDefault();
        document.getElementById('chatForm').dispatchEvent(new Event('submit'));
    }
});

// File preview
document.getElementById('fileInput').addEventListener('change', function() {
    const files = Array.from(this.files);
    if (!files.length) return;
    const previewArea = document.getElementById('previewArea');
    const previewList = document.getElementById('previewList');
    previewList.innerHTML = '';
    previewArea.classList.remove('hidden');
    files.forEach(file => {
        const div = document.createElement('div');
        div.className = 'flex items-center gap-2 bg-white border border-violet-200 rounded-xl px-3 py-2 text-xs';
        if (file.type.startsWith('image/')) {
            const img = document.createElement('img');
            img.src = URL.createObjectURL(file);
            img.className = 'w-8 h-8 rounded-lg object-cover flex-shrink-0';
            div.appendChild(img);
        } else {
            const icon = document.createElement('div');
            icon.className = 'w-8 h-8 bg-violet-100 rounded-lg flex items-center justify-center flex-shrink-0';
            icon.innerHTML = `<svg class="w-4 h-4 text-violet-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>`;
            div.appendChild(icon);
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

// Kirim pesan
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
    } catch(err) {
        console.error(err);
    } finally {
        btn.disabled = false;
        textarea.focus();
    }
});

// Render pesan baru dari polling
function renderPesan(p) {
    const isSelf = p.user_id === AUTH_ID;
    const wrap = document.createElement('div');
    wrap.className = `flex ${isSelf ? 'justify-end' : 'justify-start'} gap-2.5 items-end`;
    wrap.dataset.id = p.id;

    // Warna avatar
    const roleColors = { admin: 'bg-purple-600', petugas: 'bg-violet-600', masyarakat: 'bg-blue-500' };
    const avatarBg = roleColors[p.role] || 'bg-gray-500';
    const initial = (p.user || 'U').charAt(0).toUpperCase();

    let html = '';

    if (!isSelf) {
        html += `<div class="w-8 h-8 rounded-xl flex-shrink-0 flex items-center justify-center text-white font-bold text-xs ${avatarBg}">${initial}</div>`;
    }

    html += `<div class="max-w-[75%] space-y-1">`;

    if (!isSelf) {
        const roleLabel = p.role ? p.role.charAt(0).toUpperCase() + p.role.slice(1) : '';
        const roleColor = p.role === 'admin' ? 'text-purple-500' : 'text-violet-500';
        html += `<p class="text-xs text-gray-400 font-medium px-1">${p.user} <span class="text-gray-300 mx-1">·</span><span class="${roleColor}">${roleLabel}</span></p>`;
    }

    if (p.pesan) {
        html += `<div class="px-4 py-3 rounded-2xl text-sm leading-relaxed ${isSelf ? 'bg-violet-600 text-white rounded-br-sm' : 'bg-gray-100 text-gray-800 rounded-bl-sm'}">${p.pesan}</div>`;
    }

    (p.lampirans || []).forEach(l => {
        if (l.is_image) {
            html += `<div class="rounded-2xl overflow-hidden border ${isSelf ? 'border-violet-200' : 'border-gray-200'}">
                <a href="${l.url}" target="_blank"><img src="${l.url}" class="max-w-[240px] max-h-[200px] object-cover hover:opacity-90 transition"></a>
            </div>`;
        } else {
            html += `<div class="rounded-2xl overflow-hidden border ${isSelf ? 'border-violet-200' : 'border-gray-200'}">
                <a href="${l.url}" target="_blank" class="flex items-center gap-3 px-4 py-3 ${isSelf ? 'bg-violet-600 text-white' : 'bg-gray-50 text-gray-700'} hover:opacity-90 transition">
                    <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                    <div class="min-w-0"><p class="text-xs font-semibold truncate">${l.nama_file}</p></div>
                </a>
            </div>`;
        }
    });

    html += `<p class="text-xs text-gray-400 ${isSelf ? 'text-right' : 'text-left'} px-1">${p.waktu}</p>`;
    html += `</div>`;

    if (isSelf) {
        html += `<div class="w-8 h-8 rounded-xl flex-shrink-0 flex items-center justify-center text-white font-bold text-xs bg-violet-600">${initial}</div>`;
    }

    wrap.innerHTML = html;
    document.getElementById('chatEnd').before(wrap);
    scrollToBottom();
}

function scrollToBottom() {
    const box = document.getElementById('chatBox');
    box.scrollTop = box.scrollHeight;
}

async function pollPesan() {
    try {
        const res  = await fetch(`${POLLING_URL}?last_id=${lastId}`);
        const data = await res.json();
        if (data.length) {
            data.forEach(p => {
                if (!document.querySelector(`[data-id="${p.id}"]`)) {
                    renderPesan(p);
                    lastId = p.id;
                }
            });
        }
    } catch(e) { /* silent */ }
}

scrollToBottom();
pollingTimer = setInterval(pollPesan, 3000);
</script>
@endpush
@endsection