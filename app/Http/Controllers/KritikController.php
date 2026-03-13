<?php

namespace App\Http\Controllers;

use App\Models\Kritik;
use Illuminate\Http\Request;

class KritikController extends Controller
{
    public function create()
    {
        return view('kritik.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama'  => 'required|string|max:100',
            'email' => 'required|email|max:100',
            'jenis' => 'required|in:kritik,saran,pertanyaan',
            'isi'   => 'required|string|min:10|max:2000',
        ]);

        Kritik::create([
            'user_id' => auth()->id(),
            'nama'    => $request->nama,
            'email'   => $request->email,
            'jenis'   => $request->jenis,
            'isi'     => $request->isi,
        ]);

        return back()->with('success', 'Terima kasih! Kritik/saran Anda telah kami terima.');
    }
}