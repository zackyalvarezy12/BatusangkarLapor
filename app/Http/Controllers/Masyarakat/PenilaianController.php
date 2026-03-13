<?php

namespace App\Http\Controllers\Masyarakat;

use App\Http\Controllers\Controller;
use App\Models\Pengaduan;
use App\Models\Penilaian;
use Illuminate\Http\Request;

class PenilaianController extends Controller
{
    public function store(Request $request, $slug)
    {
        $pengaduan = Pengaduan::where('slug', $slug)->firstOrFail();

        // Hanya pelapor yang bisa beri penilaian
        if ($pengaduan->user_id !== auth()->id()) {
            return back()->with('error', 'Anda tidak berhak memberikan penilaian untuk laporan ini.');
        }

        // Hanya laporan selesai
        if ($pengaduan->status !== 'selesai') {
            return back()->with('error', 'Penilaian hanya bisa diberikan untuk laporan yang sudah selesai.');
        }

        // Cek sudah pernah dinilai
        if (Penilaian::where('pengaduan_id', $pengaduan->id)->where('user_id', auth()->id())->exists()) {
            return back()->with('error', 'Anda sudah memberikan penilaian untuk laporan ini.');
        }

        $request->validate([
            'nilai'    => 'required|integer|min:1|max:5',
            'komentar' => 'nullable|string|max:500',
        ]);

        Penilaian::create([
            'pengaduan_id' => $pengaduan->id,
            'user_id'      => auth()->id(),
            'nilai'        => $request->nilai,
            'komentar'     => $request->komentar,
        ]);

        return back()->with('success', 'Terima kasih! Penilaian Anda berhasil disimpan.');
    }
}