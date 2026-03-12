<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PesanLampiran extends Model
{
    protected $table = 'pesan_lampiran';

    protected $fillable = [
        'pesan_id', 'nama_file', 'path_file', 'tipe_file', 'ukuran',
    ];

    public function pesan()
    {
        return $this->belongsTo(PesanLaporan::class, 'pesan_id');
    }

    public function isImage(): bool
    {
        return str_starts_with($this->tipe_file, 'image/');
    }

    public function getUrlAttribute(): string
    {
        return asset('storage/' . $this->path_file);
    }
}