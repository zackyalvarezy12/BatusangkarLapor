<?php

namespace Tests\Feature;

use App\Mail\StatusLaporanMail;
use App\Models\Pengaduan;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class PetugasCompletionProofTest extends TestCase
{
    use RefreshDatabase, WithoutMiddleware;

    public function test_petugas_must_upload_bukti_when_marking_laporan_selesai(): void
    {
        Storage::fake('public');
        Mail::fake();

        $petugas = User::factory()->create([
            'role' => 'petugas',
            'wilaya_id' => null,
            'is_active' => true,
        ]);

        $pelapor = User::factory()->create();

        $pengaduan = Pengaduan::factory()->create([
            'user_id' => $pelapor->id,
            'wilaya_id' => null,
            'status' => 'proses',
        ]);

        $file = UploadedFile::fake()->image('bukti-selesai.jpg');

        $response = $this->actingAs($petugas)
            ->patch("/petugas/laporan/{$pengaduan->slug}/status", [
                'status' => 'selesai',
                'keterangan' => 'Pekerjaan selesai dan terverifikasi.',
                'bukti_file' => $file,
            ]);

        $response->assertRedirect();
        $response->assertSessionHas('success');

        $pengaduan->refresh();
        $this->assertNotNull($pengaduan->bukti_selesai_path);
        $this->assertSame('bukti-selesai.jpg', $pengaduan->bukti_selesai_nama);
        Storage::disk('public')->assertExists($pengaduan->bukti_selesai_path);

        Mail::assertSent(StatusLaporanMail::class, function ($mail) use ($pelapor, $pengaduan): bool {
            return $mail->hasTo($pelapor->email)
                && $mail->pengaduan->id === $pengaduan->id
                && $mail->buktiFilePath === $pengaduan->bukti_selesai_path;
        });
    }
}
