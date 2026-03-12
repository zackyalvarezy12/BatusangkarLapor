<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes;

    protected $fillable = [
        'name', 'email', 'password',
        'nik', 'no_hp', 'alamat',
        'role', 'wilaya_id', 'is_active', 'avatar',
        'otp_code', 'otp_expires_at', 'otp_verified',
        'must_change_password',
    ];

    protected $hidden = [
        'password', 'remember_token', 'otp_code',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'otp_expires_at'    => 'datetime',
        'otp_verified'      => 'boolean',
        'is_active'         => 'boolean',
        'password'          => 'hashed',
        'nik'               => 'encrypted',
        'no_hp'             => 'encrypted',
        'alamat'            => 'encrypted',
    ];

    // ── Role Helpers ──────────────────────────────────────
    public function isAdmin(): bool      { return $this->role === 'admin'; }
    public function isPetugas(): bool    { return $this->role === 'petugas'; }
    public function isMasyarakat(): bool { return $this->role === 'masyarakat'; }

    // ── Relasi ────────────────────────────────────────────
    public function pengaduans()   { return $this->hasMany(Pengaduan::class); }
    public function tanggapans()   { return $this->hasMany(Tanggapan::class); }
    public function notifikasis()  { return $this->hasMany(Notifikasi::class); }
    public function penilaians()   { return $this->hasMany(Penilaian::class); }

    // ── OTP ───────────────────────────────────────────────
    public function generateOtp(): string
    {
        $otp = str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);
        $this->update([
            'otp_code'       => $otp,
            'otp_expires_at' => now()->addMinutes(10),
            'otp_verified'   => false,
        ]);
        return $otp;
    }

    public function isOtpValid(string $kode): bool
    {
        return $this->otp_code === $kode
            && $this->otp_expires_at
            && $this->otp_expires_at->isFuture();
    }

    // ── Avatar ────────────────────────────────────────────
    public function getAvatarUrlAttribute(): string
    {
        if ($this->avatar) {
            return asset('storage/' . $this->avatar);
        }
        $name = urlencode(substr($this->name, 0, 1));
        return "https://ui-avatars.com/api/?name={$name}&background=003580&color=fff&size=128";
    }

    // ── Notifikasi belum dibaca ───────────────────────────
    public function unreadNotifikasiCount(): int
    {
        return $this->notifikasis()->whereNull('dibaca_at')->count();
    }

    // ── Relasi Wilayah (untuk masyarakat) ───────────────────────────
    public function wilaya()
    {
        return $this->belongsTo(Wilaya::class);
    }
}