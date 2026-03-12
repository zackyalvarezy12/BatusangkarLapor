<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Penilaian extends Model
{
    protected $table = 'penilaians';

    protected $fillable = ['pengaduan_id', 'user_id', 'nilai', 'komentar'];

    public function pengaduan() { return $this->belongsTo(Pengaduan::class); }
    public function user()      { return $this->belongsTo(User::class); }
}