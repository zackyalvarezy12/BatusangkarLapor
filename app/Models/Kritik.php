<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kritik extends Model
{
    protected $table = 'kritiks';

    protected $fillable = ['user_id', 'nama', 'email', 'jenis', 'isi', 'balasan', 'dibalas_oleh', 'dibalas_at'];

    protected $casts = ['dibalas_at' => 'datetime'];

    public function user()    { return $this->belongsTo(User::class); }
    public function petugas() { return $this->belongsTo(User::class, 'dibalas_oleh'); }
}