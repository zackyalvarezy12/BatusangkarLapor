<?php

namespace Database\Factories;

use App\Models\Kategori;
use App\Models\Pengaduan;
use App\Models\User;
use App\Models\Wilaya;
use Illuminate\Database\Eloquent\Factories\Factory;

class PengaduanFactory extends Factory
{
    protected $model = Pengaduan::class;

    public function definition(): array
    {
        return [
            'judul' => $this->faker->sentence(4),
            'slug' => $this->faker->slug(),
            'kode_laporan' => Pengaduan::generateKodeLaporan(),
            'deskripsi' => $this->faker->paragraph(),
            'tracking_token' => Pengaduan::generateTrackingToken(),
            'user_id' => User::factory(),
            'kategori_id' => Kategori::factory(),
            'wilaya_id' => Wilaya::factory(),
            'petugas_id' => null,
            'status' => 'menunggu',
            'alasan_tolak' => null,
            'is_anonim' => false,
            'is_publik' => true,
            'views' => 0,
        ];
    }
}
