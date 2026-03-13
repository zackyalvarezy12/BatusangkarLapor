<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NomorSurat extends Model
{
    protected $table = 'nomor_surats';
    protected $fillable = ['jenis', 'nomor', 'bulan', 'tahun'];

    /**
     * Ambil dan increment nomor urut untuk bulan/tahun ini
     */
    public static function generate(string $jenis): string
    {
        $bulan = now()->month;
        $tahun = now()->year;

        $record = self::firstOrCreate(
            ['jenis' => $jenis, 'bulan' => $bulan, 'tahun' => $tahun],
            ['nomor' => 0]
        );

        $record->increment('nomor');
        $record->refresh();

        $prefix = $jenis === 'admin' ? 'BL-RPT' : 'BL-RPT-PTG';
        $nomor  = str_pad($record->nomor, 3, '0', STR_PAD_LEFT);
        $bln    = str_pad($bulan, 2, '0', STR_PAD_LEFT);

        return "{$nomor}/{$prefix}/{$bln}/{$tahun}";
    }
}