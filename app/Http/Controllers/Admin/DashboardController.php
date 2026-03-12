<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\{Kategori, Pengaduan, User};

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total'    => \App\Models\Pengaduan::count(),
            'menunggu' => \App\Models\Pengaduan::where('status','menunggu')->count(),
            'proses'   => \App\Models\Pengaduan::where('status','proses')->count(),
            'selesai'  => \App\Models\Pengaduan::where('status','selesai')->count(),
            'ditolak'  => \App\Models\Pengaduan::where('status','ditolak')->count(),
            'users'    => \App\Models\User::count(),
        ];

        $recentPengaduans = \App\Models\Pengaduan::with(['kategori','wilaya'])
            ->latest()->take(10)->get();

        $perKategori = \App\Models\Kategori::withCount('pengaduans')
            ->orderByDesc('pengaduans_count')->get();

        $perBulan = \App\Models\Pengaduan::selectRaw('MONTH(created_at) as bulan, COUNT(*) as total')
            ->whereYear('created_at', date('Y'))
            ->groupBy('bulan')
            ->pluck('total', 'bulan');

        return view('admin.dashboard', compact('stats','recentPengaduans','perKategori','perBulan'));
    }
}