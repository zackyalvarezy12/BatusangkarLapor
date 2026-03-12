<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PesanLaporan extends Model
{
    protected $table = 'pesan_laporan';

    protected $fillable = [
        'pengaduan_id', 'user_id', 'pesan', 'is_internal',
    ];

    public function pengaduan()
    {
        return $this->belongsTo(Pengaduan::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function lampirans()
    {
        return $this->hasMany(PesanLampiran::class, 'pesan_id');
    }
}