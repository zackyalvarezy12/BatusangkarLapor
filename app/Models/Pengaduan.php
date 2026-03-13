<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;
use Vinkla\Hashids\Facades\Hashids;

class Pengaduan extends Model
{
    use HasFactory, HasSlug, SoftDeletes;

    protected $fillable = [
        'judul', 'slug', 'kode_laporan', 'deskripsi', 'lampiran',
        'tracking_token', 'user_id', 'kategori_id', 'wilaya_id',
        'petugas_id', 'status', 'alasan_tolak',
        'is_anonim', 'is_publik', 'views',
    ];

    protected $casts = [
        'is_anonim' => 'boolean',
        'is_publik' => 'boolean',
        'deskripsi' => 'encrypted',
        'lampiran'  => 'encrypted',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (empty($model->kode_laporan)) {
                $model->kode_laporan = static::generateKodeLaporan();
            }
            if (empty($model->tracking_token)) {
                $model->tracking_token = static::generateTrackingToken();
            }
        });
    }

    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('judul')
            ->saveSlugsTo('slug')
            ->slugsShouldBeNoLongerThan(80)
            ->doNotGenerateSlugsOnUpdate();
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    public function getHashidAttribute(): string
    {
        return Hashids::encode($this->id);
    }

    public static function findByHashid(string $hash): ?self
    {
        $ids = Hashids::decode($hash);
        if (empty($ids)) return null;
        return static::find($ids[0]);
    }

    public static function generateKodeLaporan(): string
    {
        $chars = 'ABCDEFGHJKLMNPQRSTUVWXYZ23456789';
        do {
            $acak = '';
            for ($i = 0; $i < 10; $i++) {
                $acak .= $chars[random_int(0, strlen($chars) - 1)];
            }
            $kode = 'BL-' . $acak;
        } while (static::withTrashed()->where('kode_laporan', $kode)->exists());
        return $kode;
    }

    public static function generateTrackingToken(): string
    {
        do {
            $token = Str::upper(Str::random(4)) . '-'
                   . Str::upper(Str::random(4)) . '-'
                   . Str::upper(Str::random(4));
        } while (static::where('tracking_token', $token)->exists());
        return $token;
    }

    public function getStatusBadgeAttribute(): array
    {
        return match ($this->status) {
            'menunggu' => ['label' => 'Belum Ditindak',  'color' => 'yellow'],
            'proses'   => ['label' => 'Sedang Ditindak', 'color' => 'blue'],
            'selesai'  => ['label' => 'Selesai',         'color' => 'green'],
            'ditolak'  => ['label' => 'Ditolak',         'color' => 'red'],
            default    => ['label' => $this->status,     'color' => 'gray'],
        };
    }

    public function scopePublik($q)   { return $q->where('is_publik', true); }
    public function scopeMenunggu($q) { return $q->where('status', 'menunggu'); }
    public function scopeProses($q)   { return $q->where('status', 'proses'); }
    public function scopeSelesai($q)  { return $q->where('status', 'selesai'); }
    public function scopeDitolak($q)  { return $q->where('status', 'ditolak'); }

    // ── Relasi ────────────────────────────────────────────
    public function user()       { return $this->belongsTo(User::class); }
    public function petugas()    { return $this->belongsTo(User::class, 'petugas_id'); }
    public function kategori()   { return $this->belongsTo(Kategori::class); }
    public function wilaya()     { return $this->belongsTo(Wilaya::class); }
    public function tanggapans() { return $this->hasMany(Tanggapan::class); }
    public function histories()  { return $this->hasMany(PengaduanHistory::class)->latest(); }
    public function penilaian()  { return $this->hasOne(Penilaian::class); }
    public function penilaians() { return $this->hasMany(Penilaian::class); }  // ← BARU
    public function pesans()     { return $this->hasMany(PesanLaporan::class); }
}