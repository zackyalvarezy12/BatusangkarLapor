<?php

namespace App\Http\Controllers\Petugas;

use App\Http\Controllers\Controller;
use App\Models\Pengaduan;
use App\Models\User;
use App\Models\NomorSurat;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;

class LaporanController extends Controller
{
    public function index()
    {
        $user       = auth()->user();
        $masyarakat = User::where('role', 'masyarakat')->orderBy('name')->get();
        $baseQuery  = Pengaduan::where('petugas_id', $user->id);

        $stats = [
            'total'    => (clone $baseQuery)->count(),
            'menunggu' => (clone $baseQuery)->where('status', 'menunggu')->count(),
            'proses'   => (clone $baseQuery)->where('status', 'proses')->count(),
            'selesai'  => (clone $baseQuery)->where('status', 'selesai')->count(),
            'ditolak'  => (clone $baseQuery)->where('status', 'ditolak')->count(),
        ];

        $laporanSelesai = Pengaduan::with(['user', 'kategori', 'wilaya'])
            ->where('petugas_id', $user->id)
            ->where('status', 'selesai')
            ->latest('updated_at')
            ->take(10)->get();

        return view('petugas.laporan.index', compact('masyarakat', 'stats', 'laporanSelesai'));
    }

    public function export(Request $request)
    {
        $request->validate([
            'filter_tipe'   => 'required|in:harian,mingguan,bulanan,tahunan,custom',
            'minggu'        => 'nullable|integer|min:1|max:53',
            'bulan'         => 'nullable|integer|min:1|max:12',
            'tahun'         => 'nullable|integer|min:2020|max:2099',
            'tanggal_dari'  => 'nullable|date',
            'tanggal_sampai'=> 'nullable|date|after_or_equal:tanggal_dari',
            'status'        => 'nullable|in:menunggu,proses,selesai,ditolak',
            'masyarakat_id' => 'nullable|exists:users,id',
            'logo_kiri'     => 'nullable|image|max:2048',
            'logo_kanan'    => 'nullable|image|max:2048',
        ]);

        $user  = auth()->user();
        $query = Pengaduan::with(['user', 'kategori', 'wilaya', 'petugas'])
            ->where('petugas_id', $user->id)
            ->orderBy('created_at', 'desc');

        $tahun        = $request->tahun ?? now()->year;
        $bulan        = $request->bulan ?? now()->month;
        $periodeLabel = '';

        switch ($request->filter_tipe) {
            case 'harian':
                $tanggal = $request->tanggal_dari ?? now()->toDateString();
                $query->whereDate('created_at', $tanggal);
                $periodeLabel = 'Harian: ' . Carbon::parse($tanggal)->format('d M Y');
                break;
            case 'mingguan':
                $minggu = $request->minggu ?? now()->weekOfYear;
                $dari   = Carbon::now()->setISODate($tahun, $minggu)->startOfWeek();
                $sampai = Carbon::now()->setISODate($tahun, $minggu)->endOfWeek();
                $query->whereBetween('created_at', [$dari, $sampai]);
                $periodeLabel = "Minggu ke-{$minggu} Tahun {$tahun} ({$dari->format('d M')} – {$sampai->format('d M Y')})";
                break;
            case 'bulanan':
                $query->whereYear('created_at', $tahun)->whereMonth('created_at', $bulan);
                $periodeLabel = Carbon::create($tahun, $bulan)->translatedFormat('F Y');
                break;
            case 'tahunan':
                $query->whereYear('created_at', $tahun);
                $periodeLabel = "Tahun {$tahun}";
                break;
            case 'custom':
                if ($request->filled('tanggal_dari'))   $query->whereDate('created_at', '>=', $request->tanggal_dari);
                if ($request->filled('tanggal_sampai')) $query->whereDate('created_at', '<=', $request->tanggal_sampai);
                $dari         = $request->tanggal_dari   ? Carbon::parse($request->tanggal_dari)->format('d M Y')   : '—';
                $sampai       = $request->tanggal_sampai ? Carbon::parse($request->tanggal_sampai)->format('d M Y') : '—';
                $periodeLabel = "{$dari} s/d {$sampai}";
                break;
        }

        if ($request->filled('status'))        $query->where('status', $request->status);
        if ($request->filled('masyarakat_id')) $query->where('user_id', $request->masyarakat_id);

        $pengaduans = $query->get();
        $nomorSurat = NomorSurat::generate('petugas');

        $filterInfo = array_values(array_filter([
            $periodeLabel,
            $request->filled('status')        ? ('Status: ' . ['menunggu'=>'Belum Ditindak','proses'=>'Sedang Ditindak','selesai'=>'Selesai','ditolak'=>'Ditolak'][$request->status]) : null,
            $request->filled('masyarakat_id') ? ('Pelapor: ' . (User::find($request->masyarakat_id)?->name ?? '-')) : null,
        ]));

        $logoKiri  = $this->imageToBase64($request->file('logo_kiri'));
        $logoKanan = $this->imageToBase64($request->file('logo_kanan'));

        $pdf = Pdf::loadView('petugas.laporan.pdf', [
            'pengaduans'   => $pengaduans,
            'filterInfo'   => $filterInfo,
            'nomorSurat'   => $nomorSurat,
            'dicetak_at'   => now()->format('d F Y, H:i'),
            'dicetak_oleh' => $user->name,
            'wilaya'       => $user->wilaya?->nama ?? 'Semua Wilayah',
            'logoKiri'     => $logoKiri,
            'logoKanan'    => $logoKanan,
        ])->setPaper('a4', 'portrait');

        return $pdf->download('Laporan-Petugas-' . now()->format('d-M-Y') . '.pdf');
    }

    private function imageToBase64($file): ?string
    {
        if (!$file) return null;
        $mime = $file->getMimeType();
        $data = base64_encode(file_get_contents($file->getRealPath()));
        return "data:{$mime};base64,{$data}";
    }
}