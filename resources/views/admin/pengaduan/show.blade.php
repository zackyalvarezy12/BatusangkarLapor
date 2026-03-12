@extends('layouts.admin')
@section('title', 'Detail Laporan')
@section('breadcrumb', 'Detail Laporan')

@section('content')
<div class="py-6 space-y-5 max-w-5xl">

{{-- ══ HEADER ══ --}}
<div class="flex items-center justify-between flex-wrap gap-3">
    <div class="flex items-center gap-3">
        <a href="{{ route('admin.pengaduan.index') }}"
           class="w-9 h-9 bg-white border border-slate-200 hover:bg-slate-50 rounded-xl flex items-center justify-center transition shadow-sm">
            <svg class="w-4 h-4 text-slate-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/>
            </svg>
        </a>
        <div>
            <div class="flex items-center gap-2">
                <span class="font-mono text-[12px] text-slate-400 bg-slate-100 border border-slate-200 px-2.5 py-0.5 rounded-lg">
                    {{ $pengaduan->kode_laporan }}
                </span>
                @php $b = $pengaduan->status_badge;
                $sc = ['yellow'=>'bg-amber-50 text-amber-700 border-amber-200','blue'=>'bg-blue-50 text-blue-700 border-blue-200','green'=>'bg-emerald-50 text-emerald-700 border-emerald-200','red'=>'bg-rose-50 text-rose-700 border-rose-200'][$b['color']] ?? 'bg-slate-100 text-slate-600 border-slate-200';
                $dc = ['yellow'=>'bg-amber-400','blue'=>'bg-blue-400','green'=>'bg-emerald-400','red'=>'bg-rose-400'][$b['color']] ?? 'bg-slate-400';
                @endphp
                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-[11px] font-bold border {{ $sc }}">
                    <span class="w-1.5 h-1.5 rounded-full {{ $dc }}"></span>
                    {{ $b['label'] }}
                </span>
            </div>
            <h2 class="text-[18px] font-black text-ink mt-1 leading-tight">{{ $pengaduan->judul }}</h2>
        </div>
    </div>

    {{-- Actions --}}
    <div class="flex items-center gap-2">
        <a href="{{ route('admin.pengaduan.chat', $pengaduan->slug) }}"
           class="inline-flex items-center gap-2 bg-brand text-white text-[12px] font-bold px-4 py-2.5 rounded-xl hover:bg-brand-light transition shadow-md shadow-brand/20">
            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
            </svg>
            Chat
        </a>
        <form method="POST" action="{{ route('admin.pengaduan.destroy', $pengaduan->slug) }}"
              onsubmit="return confirm('Hapus laporan ini secara permanen?')">
            @csrf @method('DELETE')
            <button type="submit"
                    class="inline-flex items-center gap-2 bg-rose-50 hover:bg-rose-100 text-rose-600 text-[12px] font-bold px-4 py-2.5 rounded-xl transition border border-rose-200">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                </svg>
                Hapus
            </button>
        </form>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-5">

    {{-- ══ MAIN COLUMN ══ --}}
    <div class="lg:col-span-2 space-y-5">

        {{-- Detail Laporan --}}
        <div class="card-elevated p-6">
            <h3 class="font-bold text-[13px] text-ink mb-5 pb-4 border-b border-slate-100 flex items-center gap-2">
                <div class="w-6 h-6 bg-brand/10 rounded-lg flex items-center justify-center">
                    <svg class="w-3.5 h-3.5 text-brand" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                </div>
                Detail Laporan
            </h3>

            <div class="grid grid-cols-2 gap-4 mb-5">
                @foreach([
                    ['label'=>'Tracking Token','val'=> $pengaduan->tracking_token, 'mono'=>true],
                    ['label'=>'Tanggal Lapor', 'val'=> $pengaduan->created_at->format('d M Y, H:i')],
                    ['label'=>'Kategori',      'val'=> $pengaduan->kategori->nama ?? '—'],
                    ['label'=>'Wilayah',       'val'=> $pengaduan->wilaya->nama ?? '—'],
                ] as $row)
                <div>
                    <p class="text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-1">{{ $row['label'] }}</p>
                    <p class="text-[13px] font-semibold text-ink {{ isset($row['mono']) ? 'font-mono' : '' }}">{{ $row['val'] }}</p>
                </div>
                @endforeach
            </div>

            <div>
                <p class="text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-2">Deskripsi</p>
                <div class="bg-slate-50 border border-slate-100 rounded-xl p-4 text-[13px] text-slate-700 leading-relaxed whitespace-pre-wrap">{{ $pengaduan->deskripsi }}</div>
            </div>

            {{-- Lampiran --}}
            @php
                $lampiranList = [];
                if ($pengaduan->lampiran) {
                    $decoded = is_array($pengaduan->lampiran)
                        ? $pengaduan->lampiran
                        : json_decode($pengaduan->lampiran, true);
                    if (is_array($decoded)) {
                        $lampiranList = $decoded;
                    } elseif (is_string($pengaduan->lampiran)) {
                        $lampiranList = [$pengaduan->lampiran];
                    }
                }
            @endphp
            @if(count($lampiranList) > 0)
            <div class="mt-5">
                <p class="text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-3">
                    Lampiran ({{ count($lampiranList) }} file)
                </p>
                <div class="flex flex-wrap gap-3">
                    @foreach($lampiranList as $idx => $lmp)
                    @php
                        $ext = strtolower(pathinfo($lmp, PATHINFO_EXTENSION));
                        $isImage = in_array($ext, ['jpg','jpeg','png','gif','webp']);
                        $url = asset('storage/' . $lmp);
                    @endphp
                    @if($isImage)
                    <a href="{{ $url }}" target="_blank" class="block group">
                        <img src="{{ $url }}" alt="Lampiran {{ $idx+1 }}"
                             class="w-32 h-24 object-cover rounded-xl border border-slate-200 group-hover:opacity-80 transition shadow-sm">
                    </a>
                    @else
                    <a href="{{ $url }}" target="_blank"
                       class="inline-flex items-center gap-2 bg-blue-50 hover:bg-blue-100 border border-blue-200 text-blue-700 text-[12px] font-semibold px-4 py-2.5 rounded-xl transition">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13"/>
                        </svg>
                        Lampiran {{ $idx+1 }} (.{{ $ext }})
                    </a>
                    @endif
                    @endforeach
                </div>
            </div>
            @endif
        </div>

        {{-- Update Status & Assign --}}
        <div class="card-elevated p-6">
            <h3 class="font-bold text-[13px] text-ink mb-5 pb-4 border-b border-slate-100 flex items-center gap-2">
                <div class="w-6 h-6 bg-amber-50 rounded-lg flex items-center justify-center">
                    <svg class="w-3.5 h-3.5 text-amber-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                    </svg>
                </div>
                Kelola Laporan
            </h3>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">

                {{-- Update Status --}}
                <div class="bg-slate-50 border border-slate-100 rounded-2xl p-4">
                    <p class="text-[11px] font-bold text-slate-500 uppercase tracking-wider mb-3">Ubah Status</p>
                    <form method="POST" action="{{ route('admin.pengaduan.status', $pengaduan->slug) }}" class="space-y-3">
                        @csrf @method('PATCH')
                        <select name="status"
                                class="w-full border border-slate-200 rounded-xl px-3 py-2.5 text-[13px] font-semibold text-ink bg-white focus:outline-none focus:ring-2 focus:ring-brand/20 focus:border-brand transition">
                            @foreach(['menunggu'=>'Belum Ditindak','proses'=>'Sedang Ditindak','selesai'=>'Selesai','ditolak'=>'Ditolak'] as $val => $label)
                            <option value="{{ $val }}" {{ $pengaduan->status === $val ? 'selected' : '' }}>{{ $label }}</option>
                            @endforeach
                        </select>
                        <textarea name="keterangan" rows="2" placeholder="Keterangan (opsional)..."
                                  class="w-full border border-slate-200 rounded-xl px-3 py-2.5 text-[12px] text-ink bg-white focus:outline-none focus:ring-2 focus:ring-brand/20 focus:border-brand transition resize-none"></textarea>
                        <button type="submit"
                                class="w-full bg-navy hover:bg-navy-900 text-white font-bold text-[12px] py-2.5 rounded-xl transition shadow-md shadow-navy/20">
                            Update Status
                        </button>
                    </form>
                </div>

                {{-- Assign Petugas --}}
                <div class="bg-slate-50 border border-slate-100 rounded-2xl p-4">
                    <p class="text-[11px] font-bold text-slate-500 uppercase tracking-wider mb-3">Tugaskan Petugas</p>
                    <form method="POST" action="{{ route('admin.pengaduan.assign', $pengaduan->slug) }}" class="space-y-3">
                        @csrf @method('PATCH')
                        <select name="petugas_id"
                                class="w-full border border-slate-200 rounded-xl px-3 py-2.5 text-[13px] font-semibold text-ink bg-white focus:outline-none focus:ring-2 focus:ring-brand/20 focus:border-brand transition">
                            <option value="">— Belum ditugaskan —</option>
                            @foreach($petugas as $p)
                            <option value="{{ $p->id }}" {{ $pengaduan->petugas_id === $p->id ? 'selected' : '' }}>
                                {{ $p->name }} {{ $p->wilaya ? '('.$p->wilaya->nama.')' : '' }}
                            </option>
                            @endforeach
                        </select>
                        @if($pengaduan->petugas)
                        <div class="flex items-center gap-2 text-[11px] text-emerald-700 bg-emerald-50 border border-emerald-200 px-3 py-2 rounded-xl">
                            <span class="w-2 h-2 rounded-full bg-emerald-400"></span>
                            Saat ini: <strong>{{ $pengaduan->petugas->name }}</strong>
                        </div>
                        @endif
                        <button type="submit"
                                class="w-full bg-navy hover:bg-navy-900 text-white font-bold text-[12px] py-2.5 rounded-xl transition shadow-md shadow-navy/20">
                            Tugaskan
                        </button>
                    </form>
                </div>
            </div>
        </div>

        {{-- Tanggapan --}}
        @if($pengaduan->tanggapans && $pengaduan->tanggapans->count() > 0)
        <div class="card-elevated p-6">
            <h3 class="font-bold text-[13px] text-ink mb-4 pb-4 border-b border-slate-100 flex items-center gap-2">
                <div class="w-6 h-6 bg-violet-50 rounded-lg flex items-center justify-center">
                    <svg class="w-3.5 h-3.5 text-violet-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z"/>
                    </svg>
                </div>
                Tanggapan Petugas
                <span class="ml-auto text-[10px] font-bold bg-violet-100 text-violet-700 px-2 py-0.5 rounded-full">
                    {{ $pengaduan->tanggapans->count() }}
                </span>
            </h3>
            <div class="space-y-3">
                @foreach($pengaduan->tanggapans as $t)
                <div class="bg-slate-50 border border-slate-100 rounded-xl p-4">
                    <div class="flex items-center justify-between mb-2">
                        <span class="text-[12px] font-bold text-ink">{{ $t->user->name ?? '—' }}</span>
                        <span class="text-[11px] text-slate-400">{{ $t->created_at->format('d M Y, H:i') }}</span>
                    </div>
                    <p class="text-[13px] text-slate-600 leading-relaxed">{{ $t->isi }}</p>
                </div>
                @endforeach
            </div>
        </div>
        @endif
    </div>

    {{-- ══ SIDEBAR ══ --}}
    <div class="space-y-5">

        {{-- Info Pelapor --}}
        <div class="card-elevated p-5">
            <h3 class="font-bold text-[13px] text-ink mb-4 pb-3 border-b border-slate-100">Info Pelapor</h3>
            @if($pengaduan->is_anonim)
            <div class="flex items-center gap-3 mb-4">
                <div class="w-11 h-11 rounded-xl bg-slate-200 flex items-center justify-center flex-shrink-0">
                    <svg class="w-5 h-5 text-slate-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                    </svg>
                </div>
                <div>
                    <p class="font-bold text-ink text-[13px]">Anonim</p>
                    <p class="text-slate-400 text-[11px]">Identitas disembunyikan</p>
                </div>
            </div>
            @else
            <div class="flex items-center gap-3 mb-4">
                <div class="w-11 h-11 rounded-xl bg-brand flex items-center justify-center text-white font-black text-sm flex-shrink-0">
                    {{ strtoupper(substr($pengaduan->user->name ?? 'U', 0, 1)) }}
                </div>
                <div>
                    <p class="font-bold text-ink text-[13px]">{{ $pengaduan->user->name ?? '—' }}</p>
                    <p class="text-slate-400 text-[11px]">{{ $pengaduan->user->email ?? '—' }}</p>
                </div>
            </div>
            @endif
            <div class="space-y-2.5 text-[12px]">
                @foreach([
                    ['label'=>'Wilayah', 'val'=> $pengaduan->wilaya->nama ?? '—'],
                    ['label'=>'Kategori','val'=> $pengaduan->kategori->nama ?? '—'],
                    ['label'=>'Tanggal', 'val'=> $pengaduan->created_at->format('d M Y')],
                    ['label'=>'Petugas', 'val'=> $pengaduan->petugas->name ?? 'Belum ditugaskan'],
                ] as $row)
                <div class="flex justify-between items-center py-1.5 border-b border-slate-50">
                    <span class="text-slate-400 font-medium">{{ $row['label'] }}</span>
                    <span class="font-semibold text-ink text-right max-w-[55%]">{{ $row['val'] }}</span>
                </div>
                @endforeach
            </div>
        </div>

        {{-- Riwayat Status --}}
        <div class="card-elevated p-5">
            <h3 class="font-bold text-[13px] text-ink mb-4 pb-3 border-b border-slate-100">Riwayat Status</h3>
            @php
            $histories = \App\Models\PengaduanHistory::with('user')
                ->where('pengaduan_id', $pengaduan->id)
                ->orderBy('created_at','asc')->get();
            @endphp
            <div class="space-y-3">
                @forelse($histories as $h)
                @php
                $hc = ['menunggu'=>'amber','proses'=>'blue','selesai'=>'emerald','ditolak'=>'rose'][$h->status_baru] ?? 'slate';
                @endphp
                <div class="flex gap-3">
                    <div class="flex flex-col items-center">
                        <div class="w-4 h-4 rounded-full bg-{{ $hc }}-100 border-2 border-{{ $hc }}-400 flex-shrink-0 mt-0.5"></div>
                        @if(!$loop->last)
                        <div class="w-px flex-1 bg-slate-100 mt-1 mb-1 min-h-[12px]"></div>
                        @endif
                    </div>
                    <div class="{{ $loop->last ? '' : 'pb-2' }} flex-1 min-w-0">
                        <p class="text-[12px] font-bold text-ink capitalize">{{ $h->status_baru }}</p>
                        @if($h->keterangan)
                        <p class="text-[11px] text-slate-500 mt-0.5">{{ $h->keterangan }}</p>
                        @endif
                        <p class="text-[11px] text-slate-400 mt-0.5">{{ $h->user->name ?? '—' }} · {{ $h->created_at->format('d M H:i') }}</p>
                    </div>
                </div>
                @empty
                <p class="text-[12px] text-slate-400 text-center py-3">Belum ada riwayat</p>
                @endforelse
            </div>
        </div>

        {{-- Penilaian --}}
        @if($pengaduan->penilaian)
        <div class="card-elevated p-5">
            <h3 class="font-bold text-[13px] text-ink mb-3 pb-3 border-b border-slate-100">Penilaian Masyarakat</h3>
            <div class="flex items-center gap-2 mb-2">
                @for($i = 1; $i <= 5; $i++)
                <svg class="w-5 h-5 {{ $i <= $pengaduan->penilaian->bintang ? 'text-amber-400' : 'text-slate-200' }}"
                     fill="currentColor" viewBox="0 0 20 20">
                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                </svg>
                @endfor
                <span class="text-[13px] font-bold text-ink">{{ $pengaduan->penilaian->bintang }}/5</span>
            </div>
            @if($pengaduan->penilaian->komentar)
            <p class="text-[12px] text-slate-500 italic">"{{ $pengaduan->penilaian->komentar }}"</p>
            @endif
        </div>
        @endif

    </div>
</div>
</div>
@endsection