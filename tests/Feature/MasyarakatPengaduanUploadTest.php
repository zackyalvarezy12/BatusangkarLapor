<?php

namespace Tests\Feature;

use App\Models\Kategori;
use App\Models\Pengaduan;
use App\Models\User;
use App\Models\Wilaya;
use Illuminate\Http\UploadedFile;
use Tests\TestCase;

class MasyarakatPengaduanUploadTest extends TestCase
{
    public function test_heic_camera_photo_is_accepted_for_pengaduan_lampiran(): void
    {
        $this->withoutMiddleware();

        $user = User::factory()->create();
        $kategori = Kategori::factory()->create();
        $wilaya = Wilaya::factory()->create();

        $response = $this->actingAs($user)->post(route('masyarakat.pengaduan.store'), [
            'judul' => 'Foto dari kamera',
            'kategori_id' => $kategori->id,
            'wilayah_id' => $wilaya->id,
            'deskripsi' => 'Test upload foto dari kamera di ponsel',
            'visibility' => 'publik',
            'lampiran' => [UploadedFile::fake()->create('photo.heic', 2048, 'image/heic')],
        ]);

        $response->assertRedirect();
        $response->assertSessionHasNoErrors();
    }

    public function test_heic_camera_photo_is_accepted_for_chat_lampiran(): void
    {
        $this->withoutMiddleware();

        $user = User::factory()->create();
        $pengaduan = Pengaduan::factory()->create(['user_id' => $user->id]);

        $response = $this->actingAs($user)->withHeaders([
            'X-Requested-With' => 'XMLHttpRequest',
            'Accept' => 'application/json',
        ])->post(route('masyarakat.pengaduan.pesan', $pengaduan->slug), [
            'pesan' => 'Foto dari kamera',
            'lampirans' => [UploadedFile::fake()->create('photo.heic', 2048, 'image/heic')],
        ]);

        $response->assertOk();
        $response->assertJsonPath('success', true);
        $response->assertJsonStructure(['success', 'pesan']);
        $this->assertDatabaseHas('pesan_laporan', [
            'pengaduan_id' => $pengaduan->id,
            'user_id' => $user->id,
        ]);
    }
}
