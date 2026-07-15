<?php

namespace Tests\Feature;

use App\Models\Pengaduan;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PetugasSearchTest extends TestCase
{
    use RefreshDatabase;

    public function test_petugas_can_find_laporan_by_kode_laporan(): void
    {
        $petugas = User::factory()->create([
            'role' => 'petugas',
            'wilaya_id' => null,
            'is_active' => true,
        ]);

        $pengaduan = Pengaduan::factory()->create([
            'kode_laporan' => 'BL-ABC123',
            'judul' => 'Laporan contoh',
            'wilaya_id' => null,
        ]);

        $response = $this->actingAs($petugas)
            ->get('/petugas/laporan?search=' . $pengaduan->kode_laporan);

        $response->assertOk();
        $response->assertSee($pengaduan->kode_laporan);
    }
}
