<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Faq extends Model
{
    protected $table = 'faqs';

    protected $fillable = ['pertanyaan', 'jawaban', 'urutan', 'is_aktif'];

    protected $casts = ['is_aktif' => 'boolean'];

    public function scopeAktif($q) { return $q->where('is_aktif', true)->orderBy('urutan'); }
}