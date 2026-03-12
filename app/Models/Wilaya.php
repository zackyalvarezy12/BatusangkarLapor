<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class Wilaya extends Model
{
    use HasSlug;

    protected $table = 'wilayas';

    protected $fillable = ['nama', 'slug', 'tipe', 'parent_id', 'is_active'];

    protected $casts = ['is_active' => 'boolean'];

    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('nama')
            ->saveSlugsTo('slug');
    }

    public function parent()     { return $this->belongsTo(Wilaya::class, 'parent_id'); }
    public function children()   { return $this->hasMany(Wilaya::class, 'parent_id'); }
    public function pengaduans() { return $this->hasMany(Pengaduan::class, 'wilaya_id'); }

    public function scopeAktif($q)     { return $q->where('is_active', true); }
    public function scopeKecamatan($q) { return $q->where('tipe', 'kecamatan'); }
    public function scopeNagari($q)    { return $q->where('tipe', 'nagari'); }
}