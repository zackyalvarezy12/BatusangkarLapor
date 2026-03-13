<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Kritik;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\BalasanKritikMail;

class KritikController extends Controller
{
    public function index(Request $request)
    {
        $kritiks = Kritik::latest()
            ->when($request->jenis, fn($q) => $q->where('jenis', $request->jenis))
            ->when($request->status === 'dibalas',   fn($q) => $q->whereNotNull('balasan'))
            ->when($request->status === 'belum',     fn($q) => $q->whereNull('balasan'))
            ->paginate(15);

        $counts = [
            'total'   => Kritik::count(),
            'belum'   => Kritik::whereNull('balasan')->count(),
            'dibalas' => Kritik::whereNotNull('balasan')->count(),
        ];

        return view('admin.kritik.index', compact('kritiks', 'counts'));
    }

    public function balas(Request $request, Kritik $kritik)
    {
        $request->validate([
            'balasan' => 'required|string|max:1000',
        ]);

        $sudahDibalas = $kritik->sudahDibalas();

        $kritik->update([
            'balasan'      => $request->balasan,
            'dibalas_oleh' => auth()->id(),
            'dibalas_at'   => now(),
        ]);

        // Kirim email hanya pertama kali dibalas (bukan update)
        if (!$sudahDibalas) {
            try {
                Mail::to($kritik->email)->send(new BalasanKritikMail($kritik->fresh()));
            } catch (\Exception $e) {
                return back()->with('success', 'Balasan tersimpan, tapi email gagal dikirim: ' . $e->getMessage());
            }
        }

        return back()->with('success', 'Balasan berhasil dikirim' . (!$sudahDibalas ? ' dan email telah dikirim ke ' . $kritik->email : '') . '.');
    }

    public function destroy(Kritik $kritik)
    {
        $kritik->delete();
        return back()->with('success', 'Kritik berhasil dihapus.');
    }
}