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
        $mime = strtolower((string) $this->tipe_file);
        if (str_starts_with($mime, 'image/')) {
            return true;
        }

        $name = strtolower((string) ($this->nama_file ?? ''));
        $imageExtensions = ['jpg', 'jpeg', 'png', 'gif', 'webp', 'avif', 'heic', 'heif'];

        foreach ($imageExtensions as $ext) {
            if (str_ends_with($name, '.' . $ext)) {
                return true;
            }
        }

        return false;
    }

    public function getUrlAttribute(): string
    {
        $path = trim((string) $this->path_file, '/');
        $path = ltrim($path, 'storage/');

        return asset('storage/' . $path);
    }
}