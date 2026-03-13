@extends('layouts.admin')
@section('title', 'Kritik & Saran')
@section('breadcrumb', 'Kritik & Saran')

@section('content')
<div class="py-6 space-y-6">

    <div class="flex items-center justify-between">
        <div>
            <h1 class="font-black text-gray-800 text-xl">Kritik & Saran</h1>
            <p class="text-gray-400 text-sm mt-0.5">Masukan dari masyarakat</p>
        </div>
    </div>

    @if(session('success'))
    <div class="bg-green-50 border border-green-200 text-green-700 text-sm font-medium px-4 py-3 rounded-xl">
        {{ session('success') }}
    </div>
    @endif

    {{-- Stat Cards --}}
    <div class="grid grid-cols-3 gap-4">
        @foreach([
            ['label'=>'Total', 'val'=>$counts['total'], 'bg'=>'bg-blue-50', 'txt'=>'text-blue-700'],
            ['label'=>'Belum Dibalas', 'val'=>$counts['belum'], 'bg'=>'bg-amber-50', 'txt'=>'text-amber-700'],
            ['label'=>'Sudah Dibalas', 'val'=>$counts['dibalas'], 'bg'=>'bg-green-50', 'txt'=>'text-green-700'],
        ] as $s)
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-5 flex items-center gap-4">
            <div class="flex-1">
                <p class="text-xs text-gray-400 font-semibold">{{ $s['label'] }}</p>
                <p class="text-2xl font-black {{ $s['txt'] }}">{{ $s['val'] }}</p>
            </div>
        </div>
        @endforeach
    </div>

    {{-- Filter --}}
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-4">
        <form method="GET" class="flex flex-wrap gap-3">
            <select name="jenis"
                    class="border border-gray-200 rounded-xl px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-100 focus:border-blue-400 transition">
                <option value="">Semua Jenis</option>
                <option value="kritik"     {{ request('jenis')==='kritik'     ? 'selected':'' }}>Kritik</option>
                <option value="saran"      {{ request('jenis')==='saran'      ? 'selected':'' }}>Saran</option>
                <option value="pertanyaan" {{ request('jenis')==='pertanyaan' ? 'selected':'' }}>Pertanyaan</option>
            </select>
            <select name="status"
                    class="border border-gray-200 rounded-xl px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-100 focus:border-blue-400 transition">
                <option value="">Semua Status</option>
                <option value="belum"   {{ request('status')==='belum'   ? 'selected':'' }}>Belum Dibalas</option>
                <option value="dibalas" {{ request('status')==='dibalas' ? 'selected':'' }}>Sudah Dibalas</option>
            </select>
            <button type="submit"
                    class="text-white font-semibold text-sm px-4 py-2.5 rounded-xl transition"
                    style="background:#003580;">
                Filter
            </button>
            @if(request()->hasAny(['jenis','status']))
            <a href="{{ route('admin.kritik.index') }}"
               class="bg-gray-100 hover:bg-gray-200 text-gray-600 font-semibold text-sm px-4 py-2.5 rounded-xl transition">
                Reset
            </a>
            @endif
        </form>
    </div>

    {{-- List --}}
    <div class="space-y-4">
        @forelse($kritiks as $k)
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
            <div class="p-6">
                <div class="flex items-start justify-between gap-4 mb-3">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-xl flex items-center justify-center font-black text-white text-sm flex-shrink-0"
                             style="background:#003580;">
                            {{ strtoupper(substr($k->nama, 0, 1)) }}
                        </div>
                        <div>
                            <p class="font-bold text-gray-800 text-sm">{{ $k->nama }}</p>
                            <p class="text-gray-400 text-xs">{{ $k->email }}</p>
                        </div>
                    </div>
                    <div class="flex items-center gap-2">
                        <span class="text-xs font-semibold px-2.5 py-1 rounded-full
                            {{ $k->jenis==='kritik' ? 'bg-red-100 text-red-700' : '' }}
                            {{ $k->jenis==='saran' ? 'bg-blue-100 text-blue-700' : '' }}
                            {{ $k->jenis==='pertanyaan' ? 'bg-purple-100 text-purple-700' : '' }}">
                            {{ ucfirst($k->jenis) }}
                        </span>
                        <span class="text-xs font-semibold px-2.5 py-1 rounded-full
                            {{ $k->sudahDibalas() ? 'bg-green-100 text-green-700' : 'bg-amber-100 text-amber-700' }}">
                            {{ $k->sudahDibalas() ? 'Dibalas' : 'Belum Dibalas' }}
                        </span>
                        <span class="text-xs text-gray-400">{{ $k->created_at->format('d M Y, H:i') }}</span>
                    </div>
                </div>

                {{-- Isi --}}
                <p class="text-gray-600 text-sm leading-relaxed bg-gray-50 rounded-xl px-4 py-3">
                    {{ $k->isi }}
                </p>

                {{-- Balasan yang sudah ada --}}
                @if($k->sudahDibalas())
                <div class="mt-3 bg-blue-50 border border-blue-100 rounded-xl px-4 py-3">
                    <p class="text-xs font-semibold text-blue-600 mb-1">
                        Balasan Admin · {{ $k->dibalas_at->format('d M Y, H:i') }}
                    </p>
                    <p class="text-sm text-blue-800">{{ $k->balasan }}</p>
                </div>
                @endif

                {{-- Form balas --}}
                <div class="mt-4 flex items-start gap-3">
                    <form method="POST" action="{{ route('admin.kritik.balas', $k) }}" class="flex-1 flex gap-3">
                        @csrf @method('PATCH')
                        <input type="text" name="balasan"
                               value="{{ $k->balasan }}"
                               placeholder="{{ $k->sudahDibalas() ? 'Edit balasan...' : 'Tulis balasan...' }}"
                               class="flex-1 border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-100 focus:border-blue-400 transition">
                        <button type="submit"
                                class="text-white font-semibold text-sm px-4 py-2.5 rounded-xl transition flex-shrink-0"
                                style="background:#003580;">
                            {{ $k->sudahDibalas() ? 'Update' : 'Balas' }}
                        </button>
                    </form>
                    <form method="POST" action="{{ route('admin.kritik.destroy', $k) }}"
                          onsubmit="return confirm('Hapus kritik ini?')">
                        @csrf @method('DELETE')
                        <button type="submit"
                                class="w-10 h-10 bg-red-50 hover:bg-red-100 text-red-500 rounded-xl flex items-center justify-center transition flex-shrink-0">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
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
                          d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"/>
                </svg>
            </div>
            <p class="text-gray-400 font-medium text-sm">Belum ada kritik atau saran masuk.</p>
        </div>
        @endforelse
    </div>

    @if($kritiks->hasPages())
    <div>{{ $kritiks->withQueryString()->links() }}</div>
    @endif

</div>
@endsection