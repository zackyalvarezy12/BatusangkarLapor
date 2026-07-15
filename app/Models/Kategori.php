<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class Kategori extends Model
{
    use HasSlug;

    protected $table = 'kategoris';

    protected $fillable = ['nama', 'slug', 'ikon', 'warna', 'deskripsi', 'is_active', 'urutan'];

    protected $casts = ['is_active' => 'boolean'];

    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('nama')
            ->saveSlugsTo('slug');
    }

    public function getRouteKeyName(): string { return 'id'; }

    public function pengaduans() { return $this->hasMany(Pengaduan::class, 'kategori_id'); }

    public function scopeAktif($q) { return $q->where('is_active', true)->orderBy('urutan'); }
}