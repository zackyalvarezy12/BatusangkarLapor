<?php

namespace Tests\Feature;

use App\Models\Pengaduan;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PetugasPengaduanPdfExportTest extends TestCase
{
    use RefreshDatabase;

    public function test_petugas_can_download_formal_report_pdf(): void
    {
        $petugas = User::factory()->create([
            'role' => 'petugas',
            'wilaya_id' => null,
            'is_active' => true,
        ]);

        $pelapor = User::factory()->create();
        $pengaduan = Pengaduan::factory()->create([
            'user_id' => $pelapor->id,
            'status' => 'proses',
            'is_publik' => true,
            'wilaya_id' => null,
        ]);

        $response = $this->actingAs($petugas)
            ->get('/petugas/laporan/' . $pengaduan->slug . '/pdf');

        $response->assertOk();
        $response->assertHeader('content-type', 'application/pdf');
        $contentDisposition = $response->headers->get('content-disposition');
        $this->assertNotNull($contentDisposition);
        $this->assertStringContainsString('Laporan-Pengaduan-', $contentDisposition);
    }

    public function test_masyarakat_cannot_access_petugas_pdf_export(): void
    {
        $user = User::factory()->create([
            'role' => 'masyarakat',
            'is_active' => true,
        ]);

        $pengaduan = Pengaduan::factory()->create([
            'user_id' => $user->id,
            'status' => 'proses',
            'is_publik' => true,
            'wilaya_id' => null,
        ]);

        $response = $this->actingAs($user)
            ->get('/petugas/laporan/' . $pengaduan->slug . '/pdf');

        $response->assertStatus(403);
    }
}
