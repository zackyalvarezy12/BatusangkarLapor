<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kritik extends Model
{
    protected $fillable = [
        'user_id', 'nama', 'email', 'jenis', 'isi',
        'balasan', 'dibalas_oleh', 'dibalas_at',
    ];

    protected $casts = [
        'dibalas_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function pembalas()
    {
        return $this->belongsTo(User::class, 'dibalas_oleh');
    }

    public function sudahDibalas(): bool
    {
        return !is_null($this->balasan);
    }
}