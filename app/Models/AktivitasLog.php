<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AktivitasLog extends Model
{
    protected $table = 'aktivitas_logs';

    protected $fillable = [
        'user_id', 'aksi', 'model', 'model_id',
        'data_lama', 'data_baru', 'ip_address', 'user_agent',
    ];

    protected $casts = [
        'data_lama' => 'array',
        'data_baru' => 'array',
    ];

    public function user() { return $this->belongsTo(User::class); }
}