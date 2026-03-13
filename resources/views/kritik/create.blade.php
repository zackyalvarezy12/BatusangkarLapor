@extends('layouts.app')
@section('title', 'Kritik & Saran')

@section('content')
<style>
@import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800;900&display=swap');
* { font-family: 'Plus Jakarta Sans', sans-serif; }
</style>

<nav class="sticky top-0 z-40 bg-white/95 backdrop-blur-xl border-b border-gray-100 shadow-sm">
    <div class="max-w-2xl mx-auto px-4 py-3.5 flex items-center gap-3">
        <a href="{{ route('beranda') }}"
           class="w-9 h-9 bg-gray-100 hover:bg-gray-200 rounded-xl flex items-center justify-center transition">
            <svg class="w-4 h-4 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
            </svg>
        </a>
        <div>
            <div class="font-bold text-gray-800 text-sm leading-tight">Kritik & Saran</div>
            <div class="text-gray-400 text-[10px]">BatusangkarLapor</div>
        </div>
    </div>
</nav>

<div class="min-h-screen bg-[#f3f6fc] py-10">
    <div class="max-w-xl mx-auto px-4">

        {{-- Hero --}}
        <div class="text-center mb-8">
            <div class="w-16 h-16 rounded-2xl flex items-center justify-center mx-auto mb-4"
                 style="background:linear-gradient(135deg,#003580,#1e4d8c);">
                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                          d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"/>
                </svg>
            </div>
            <h1 class="font-black text-gray-800 text-2xl mb-2">Kritik & Saran</h1>
            <p class="text-gray-500 text-sm">Masukan Anda sangat berarti untuk meningkatkan pelayanan kami.</p>
        </div>

        @if(session('success'))
        <div class="bg-green-50 border border-green-200 text-green-700 text-sm font-semibold px-4 py-3 rounded-xl mb-5 flex items-center gap-2">
            <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
            </svg>
            {{ session('success') }}
        </div>
        @endif

        <div class="bg-white rounded-3xl shadow-sm border border-gray-100 p-8">
            <form method="POST" action="{{ route('kritik.store') }}" class="space-y-5">
                @csrf

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Nama Lengkap</label>
                        <input type="text" name="nama"
                               value="{{ old('nama', auth()->user()->name ?? '') }}"
                               required placeholder="Nama Anda"
                               class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-blue-100 focus:border-blue-400 transition @error('nama') border-red-400 @enderror">
                        @error('nama')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Email</label>
                        <input type="email" name="email"
                               value="{{ old('email', auth()->user()->email ?? '') }}"
                               required placeholder="email@contoh.com"
                               class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-blue-100 focus:border-blue-400 transition @error('email') border-red-400 @enderror">
                        @error('email')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Jenis</label>
                    <div class="grid grid-cols-3 gap-3">
                        @foreach(['kritik'=>['🔴','Kritik','red'], 'saran'=>['🔵','Saran','blue'], 'pertanyaan'=>['🟣','Pertanyaan','purple']] as $val => $opt)
                        <label class="cursor-pointer">
                            <input type="radio" name="jenis" value="{{ $val }}"
                                   {{ old('jenis')===$val ? 'checked':'' }} class="sr-only peer">
                            <div class="border-2 border-gray-200 peer-checked:border-blue-500 peer-checked:bg-blue-50 rounded-xl p-3 text-center transition">
                                <div class="text-lg mb-1">{{ $opt[0] }}</div>
                                <div class="text-xs font-bold text-gray-700">{{ $opt[1] }}</div>
                            </div>
                        </label>
                        @endforeach
                    </div>
                    @error('jenis')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Isi Pesan</label>
                    <textarea name="isi" required rows="5"
                              placeholder="Tulis kritik, saran, atau pertanyaan Anda di sini..."
                              class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-blue-100 focus:border-blue-400 transition resize-none @error('isi') border-red-400 @enderror">{{ old('isi') }}</textarea>
                    @error('isi')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>

                <button type="submit"
                        class="w-full text-white font-bold py-3.5 rounded-xl transition text-sm"
                        style="background:linear-gradient(135deg,#003580,#1e4d8c);">
                    Kirim Pesan
                </button>
            </form>
        </div>
    </div>
</div>
@endsection