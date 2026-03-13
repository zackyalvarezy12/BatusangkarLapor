<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pengaduan;
use App\Models\User;
use App\Models\Wilaya;
use App\Models\Kategori;
use App\Models\NomorSurat;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;

class LaporanController extends Controller
{
    public function index(Request $request)
    {
        $petugas    = User::where('role', 'petugas')->orderBy('name')->get();
        $masyarakat = User::where('role', 'masyarakat')->orderBy('name')->get();
        $wilayas    = Wilaya::orderBy('nama')->get();
        $kategoris  = Kategori::orderBy('nama')->get();

        $stats = [
            'total'    => Pengaduan::count(),
            'menunggu' => Pengaduan::where('status', 'menunggu')->count(),
            'proses'   => Pengaduan::where('status', 'proses')->count(),
            'selesai'  => Pengaduan::where('status', 'selesai')->count(),
            'ditolak'  => Pengaduan::where('status', 'ditolak')->count(),
        ];

        $preview    = null;
        $filterInfo = [];
        $hasFilter  = $request->hasAny(['tanggal_dari','tanggal_sampai','status','wilaya_id','kategori_id','petugas_id','masyarakat_id']);

        if ($hasFilter) {
            $query = Pengaduan::with(['user', 'kategori', 'wilaya', 'petugas'])->orderBy('created_at','desc');
            $this->applyFilters($query, $request);
            $preview    = $query->get();
            $filterInfo = $this->buildFilterInfo($request);
        }

        return view('admin.laporan.index', compact(
            'petugas','masyarakat','wilayas','kategoris','stats','preview','filterInfo','hasFilter'
        ));
    }

    public function export(Request $request)
    {
        $request->validate([
            'tanggal_dari'  => 'nullable|date',
            'tanggal_sampai'=> 'nullable|date|after_or_equal:tanggal_dari',
            'status'        => 'nullable|in:menunggu,proses,selesai,ditolak',
            'wilaya_id'     => 'nullable|exists:wilayas,id',
            'kategori_id'   => 'nullable|exists:kategoris,id',
            'petugas_id'    => 'nullable|exists:users,id',
            'masyarakat_id' => 'nullable|exists:users,id',
            'logo_kiri'     => 'nullable|image|max:2048',
            'logo_kanan'    => 'nullable|image|max:2048',
        ]);

        $query = Pengaduan::with(['user', 'kategori', 'wilaya', 'petugas'])->orderBy('created_at','desc');
        $this->applyFilters($query, $request);
        $pengaduans = $query->get();
        $filterInfo = $this->buildFilterInfo($request);
        $nomorSurat = NomorSurat::generate('admin');

        // Proses logo — convert ke base64 untuk embed di PDF
        $logoKiri   = $this->imageToBase64($request->file('logo_kiri'));
        $logoKanan  = $this->imageToBase64($request->file('logo_kanan'));

        $pdf = Pdf::loadView('admin.laporan.pdf', [
            'pengaduans'   => $pengaduans,
            'filterInfo'   => $filterInfo,
            'nomorSurat'   => $nomorSurat,
            'dicetak_at'   => now()->format('d F Y, H:i'),
            'dicetak_oleh' => auth()->user()->name,
            'logoKiri'     => $logoKiri,
            'logoKanan'    => $logoKanan,
        ])->setPaper('a4', 'portrait');

        return $pdf->download('Laporan-Pengaduan-' . now()->format('d-M-Y') . '.pdf');
    }

    private function applyFilters($query, Request $request): void
    {
        if ($request->filled('tanggal_dari'))   $query->whereDate('created_at', '>=', $request->tanggal_dari);
        if ($request->filled('tanggal_sampai')) $query->whereDate('created_at', '<=', $request->tanggal_sampai);
        if ($request->filled('status'))         $query->where('status', $request->status);
        if ($request->filled('wilaya_id'))      $query->where('wilaya_id', $request->wilaya_id);
        if ($request->filled('kategori_id'))    $query->where('kategori_id', $request->kategori_id);
        if ($request->filled('petugas_id'))     $query->where('petugas_id', $request->petugas_id);
        if ($request->filled('masyarakat_id'))  $query->where('user_id', $request->masyarakat_id);
    }

    private function buildFilterInfo(Request $request): array
    {
        $info = [];
        if ($request->filled('tanggal_dari') || $request->filled('tanggal_sampai')) {
            $dari   = $request->tanggal_dari   ? Carbon::parse($request->tanggal_dari)->format('d M Y')   : '—';
            $sampai = $request->tanggal_sampai ? Carbon::parse($request->tanggal_sampai)->format('d M Y') : '—';
            $info[] = "Periode: {$dari} s/d {$sampai}";
        }
        if ($request->filled('status')) {
            $labels = ['menunggu'=>'Belum Ditindak','proses'=>'Sedang Ditindak','selesai'=>'Selesai','ditolak'=>'Ditolak'];
            $info[] = "Status: " . ($labels[$request->status] ?? $request->status);
        }
        if ($request->filled('wilaya_id'))     $info[] = "Wilayah: "  . (Wilaya::find($request->wilaya_id)?->nama   ?? '-');
        if ($request->filled('kategori_id'))   $info[] = "Kategori: " . (Kategori::find($request->kategori_id)?->nama ?? '-');
        if ($request->filled('petugas_id'))    $info[] = "Petugas: "  . (User::find($request->petugas_id)?->name    ?? '-');
        if ($request->filled('masyarakat_id')) $info[] = "Pelapor: "  . (User::find($request->masyarakat_id)?->name ?? '-');
        return $info;
    }

    private function imageToBase64($file): ?string
    {
        if (!$file) return null;
        $mime = $file->getMimeType();
        $data = base64_encode(file_get_contents($file->getRealPath()));
        return "data:{$mime};base64,{$data}";
    }
}