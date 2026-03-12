<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PengaduanHistory extends Model
{
    protected $table = 'pengaduan_histories';

    protected $fillable = ['pengaduan_id', 'user_id', 'status_lama', 'status_baru', 'keterangan'];

    public function pengaduan() { return $this->belongsTo(Pengaduan::class); }
    public function user()      { return $this->belongsTo(User::class); }
}