<?php

namespace App\Http\Controllers;

use App\Models\Notifikasi;
use Illuminate\Http\Request;

class NotifikasiController extends Controller
{
    // Mark satu notifikasi sebagai dibaca (AJAX)
    public function baca($id)
    {
        $notif = Notifikasi::where('id', $id)
            ->where('user_id', auth()->id())
            ->first();

        if ($notif && is_null($notif->dibaca_at)) {
            $notif->update(['dibaca_at' => now()]);
        }

        return response()->json(['ok' => true]);
    }

    // Tandai semua dibaca (admin)
    public function readAllAdmin()
    {
        Notifikasi::where('user_id', auth()->id())
            ->whereNull('dibaca_at')
            ->update(['dibaca_at' => now()]);

        return back()->with('success', 'Semua notifikasi telah ditandai dibaca.');
    }

    // Tandai semua dibaca (petugas)
    public function readAllPetugas()
    {
        Notifikasi::where('user_id', auth()->id())
            ->whereNull('dibaca_at')
            ->update(['dibaca_at' => now()]);

        return back()->with('success', 'Semua notifikasi telah ditandai dibaca.');
    }
}