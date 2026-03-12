<?php

namespace App\Http\Controllers;

use App\Models\Kategori;
use App\Models\Pengaduan;
use App\Models\Faq;
use Illuminate\Http\Request;

class PublicController extends Controller
{
    public function beranda()
    {
        $kategoris = Kategori::where('is_active', true)->orderBy('urutan')->get();
        $stats = [
            'total'   => Pengaduan::count(),
            'selesai' => Pengaduan::where('status', 'selesai')->count(),
            'proses'  => Pengaduan::where('status', 'proses')->count(),
        ];
        return view('public.beranda', compact('kategoris', 'stats'));
    }

    public function lacak(Request $request)
    {
        $pengaduan = null;
        $kode      = $request->kode;
        $notFound  = false;

        if ($kode) {
            $pengaduan = Pengaduan::with([
                    'kategori', 'wilaya', 'petugas', 'histories.user'
                ])
                ->where(function($q) use ($kode) {
                    $q->where('kode_laporan', $kode)
                      ->orWhere('tracking_token', $kode);
                })
                ->first();

            if (!$pengaduan) $notFound = true;
        }

        return view('public.lacak', compact('pengaduan', 'kode', 'notFound'));
    }

    public function faq()
    {
        $faqs = Faq::where('is_aktif', true)->orderBy('urutan')->get();
        return view('public.faq', compact('faqs'));
    }
}