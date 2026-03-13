<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Pengumuman extends Model
{
    protected $table = 'pengumumans';

    protected $fillable = [
        'judul', 'slug', 'konten', 'gambar',
        'user_id', 'is_aktif', 'diterbitkan_at',
    ];

    protected $casts = [
        'is_aktif'       => 'boolean',
        'diterbitkan_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function scopeAktif($q)
    {
        return $q->where('is_aktif', true)
                 ->whereNotNull('diterbitkan_at')
                 ->where('diterbitkan_at', '<=', now())
                 ->latest('diterbitkan_at');
    }

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            if (empty($model->slug)) {
                $model->slug = Str::slug($model->judul) . '-' . Str::random(5);
            }
        });
    }
}