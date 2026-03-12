@extends('layouts.admin')
@section('title', 'Manajemen Pengguna')
@section('breadcrumb', 'Manajemen Pengguna')

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
                              d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
                    </svg>
                </div>
                <div>
                    <span class="bg-secondary text-gray-900 text-xs font-black px-3 py-0.5 rounded-full">
                        Manajemen
                    </span>
                    <h1 class="text-2xl font-black text-white mt-1">Pengguna</h1>
                    <p class="text-blue-200 text-sm">Kelola semua akun pengguna sistem</p>
                </div>
            </div>
            <a href="{{ route('admin.user.create') }}"
               class="inline-flex items-center gap-2 bg-secondary hover:bg-yellow-400 text-gray-900 font-bold text-sm px-5 py-2.5 rounded-xl transition">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
                Tambah Pengguna
            </a>
        </div>
    </div>

    {{-- Filter --}}
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-5">
        <form method="GET" action="{{ route('admin.user.index') }}" class="flex flex-wrap gap-3 items-end">
            <div class="flex-1 min-w-[200px]">
                <label class="block text-xs font-semibold text-gray-500 mb-1.5">Cari Pengguna</label>
                <div class="relative">
                    <svg class="w-4 h-4 text-gray-400 absolute left-3 top-1/2 -translate-y-1/2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                    <input type="text" name="search" value="{{ request('search') }}"
                           placeholder="Nama atau email..."
                           class="w-full pl-9 pr-4 py-2.5 border border-gray-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary transition">
                </div>
            </div>
            <div class="min-w-[150px]">
                <label class="block text-xs font-semibold text-gray-500 mb-1.5">Role</label>
                <select name="role" class="w-full border border-gray-200 rounded-xl px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary transition">
                    <option value="">Semua Role</option>
                    <option value="admin"      {{ request('role')==='admin'      ? 'selected':'' }}>Admin</option>
                    <option value="petugas"    {{ request('role')==='petugas'    ? 'selected':'' }}>Petugas</option>
                    <option value="masyarakat" {{ request('role')==='masyarakat' ? 'selected':'' }}>Masyarakat</option>
                </select>
            </div>
            <div class="flex gap-2">
                <button type="submit"
                        class="inline-flex items-center gap-2 bg-primary hover:bg-blue-900 text-white font-semibold text-sm px-5 py-2.5 rounded-xl transition">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                    Filter
                </button>
                @if(request()->hasAny(['search','role']))
                <a href="{{ route('admin.user.index') }}"
                   class="inline-flex items-center gap-2 bg-gray-100 hover:bg-gray-200 text-gray-600 font-semibold text-sm px-4 py-2.5 rounded-xl transition">
                    Reset
                </a>
                @endif
            </div>
        </form>
    </div>

    {{-- Stat Mini --}}
    @php
    $roleStats = [
        ['label'=>'Admin',      'n'=>\App\Models\User::where('role','admin')->count(),      'bg'=>'bg-purple-100','text'=>'text-purple-700'],
        ['label'=>'Petugas',    'n'=>\App\Models\User::where('role','petugas')->count(),    'bg'=>'bg-blue-100',  'text'=>'text-blue-700'],
        ['label'=>'Masyarakat', 'n'=>\App\Models\User::where('role','masyarakat')->count(), 'bg'=>'bg-green-100', 'text'=>'text-green-700'],
        ['label'=>'Total',      'n'=>\App\Models\User::count(),                             'bg'=>'bg-gray-100',  'text'=>'text-gray-700'],
    ];
    @endphp
    <div class="grid grid-cols-2 sm:grid-cols-4 gap-3">
        @foreach($roleStats as $rs)
        <div class="bg-white rounded-2xl p-4 shadow-sm border border-gray-100 flex items-center gap-3">
            <div class="w-10 h-10 {{ $rs['bg'] }} rounded-xl flex items-center justify-center">
                <span class="font-black text-sm {{ $rs['text'] }}">{{ $rs['n'] }}</span>
            </div>
            <span class="text-sm font-semibold text-gray-600">{{ $rs['label'] }}</span>
        </div>
        @endforeach
    </div>

    {{-- Tabel --}}
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="px-6 py-5 border-b border-gray-100 flex items-center justify-between">
            <div class="flex items-center gap-3">
                <div class="w-9 h-9 bg-primary rounded-xl flex items-center justify-center">
                    <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
                    </svg>
                </div>
                <div>
                    <h3 class="font-bold text-gray-800 text-sm">Daftar Pengguna</h3>
                    <p class="text-gray-400 text-xs">{{ $users->total() }} pengguna ditemukan</p>
                </div>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="bg-gray-50 text-gray-500 uppercase text-xs">
                        <th class="px-6 py-3 text-left font-semibold">Pengguna</th>
                        <th class="px-6 py-3 text-left font-semibold">Role</th>
                        <th class="px-6 py-3 text-left font-semibold">Daerah</th>
                        <th class="px-6 py-3 text-left font-semibold">Status</th>
                        <th class="px-6 py-3 text-left font-semibold">Bergabung</th>
                        <th class="px-6 py-3 text-left font-semibold">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @forelse($users as $u)
                    <tr class="hover:bg-blue-50/20 transition">
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-3">
                                <img src="{{ $u->avatar_url }}" class="w-9 h-9 rounded-xl object-cover flex-shrink-0">
                                <div>
                                    <div class="font-semibold text-gray-800 text-sm">{{ $u->name }}</div>
                                    <div class="text-xs text-gray-400">{{ $u->email }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <span class="inline-flex items-center text-xs font-semibold px-2.5 py-1 rounded-full
                                {{ $u->role==='admin'      ? 'bg-purple-100 text-purple-700' : '' }}
                                {{ $u->role==='petugas'    ? 'bg-blue-100 text-blue-700'     : '' }}
                                {{ $u->role==='masyarakat' ? 'bg-green-100 text-green-700'   : '' }}">
                                {{ ucfirst($u->role) }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-xs text-gray-500">
                            {{ $u->wilaya->nama ?? '-' }}
                        </td>
                        <td class="px-6 py-4">
                            <span class="inline-flex items-center gap-1.5 text-xs font-semibold px-2.5 py-1 rounded-full
                                {{ $u->is_active ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                                <span class="w-1.5 h-1.5 rounded-full {{ $u->is_active ? 'bg-green-500' : 'bg-red-500' }}"></span>
                                {{ $u->is_active ? 'Aktif' : 'Nonaktif' }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-xs text-gray-400 whitespace-nowrap">
                            {{ $u->created_at->format('d M Y') }}
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-2">
                                <a href="{{ route('admin.user.edit', $u) }}"
                                   class="w-8 h-8 bg-primary/10 hover:bg-primary hover:text-white text-primary rounded-lg flex items-center justify-center transition group"
                                   title="Edit">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                              d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                    </svg>
                                </a>
                                @if($u->id !== auth()->id())
                                <form method="POST" action="{{ route('admin.user.toggle', $u) }}">
                                    @csrf @method('PATCH')
                                    <button type="submit"
                                            class="w-8 h-8 rounded-lg flex items-center justify-center transition
                                                {{ $u->is_active ? 'bg-red-50 hover:bg-red-500 text-red-500 hover:text-white' : 'bg-green-50 hover:bg-green-500 text-green-500 hover:text-white' }}"
                                            title="{{ $u->is_active ? 'Nonaktifkan' : 'Aktifkan' }}">
                                        @if($u->is_active)
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                  d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"/>
                                        </svg>
                                        @else
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                  d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                        </svg>
                                        @endif
                                    </button>
                                </form>
                                <form method="POST" action="{{ route('admin.user.destroy', $u) }}"
                                      onsubmit="return confirm('Hapus pengguna {{ $u->name }}?')">
                                    @csrf @method('DELETE')
                                    <button type="submit"
                                            class="w-8 h-8 bg-red-50 hover:bg-red-500 text-red-500 hover:text-white rounded-lg flex items-center justify-center transition"
                                            title="Hapus">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                  d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                        </svg>
                                    </button>
                                </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-6 py-16 text-center">
                            <div class="flex flex-col items-center gap-3">
                                <div class="w-16 h-16 bg-gray-100 rounded-2xl flex items-center justify-center">
                                    <svg class="w-8 h-8 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                              d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    </svg>
                                </div>
                                <p class="text-gray-400 font-medium text-sm">Tidak ada pengguna ditemukan</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($users->hasPages())
        <div class="px-6 py-4 border-t border-gray-100">
            {{ $users->withQueryString()->links() }}
        </div>
        @endif
    </div>
</div>
@endsection