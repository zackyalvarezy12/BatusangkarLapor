<?php

namespace Tests\Unit;

use App\Models\PesanLampiran;
use PHPUnit\Framework\TestCase;

class PesanLampiranTest extends TestCase
{
    public function test_heic_attachment_is_treated_as_image_by_extension_fallback(): void
    {
        $lampiran = new PesanLampiran([
            'nama_file' => 'photo.heic',
            'tipe_file' => '',
        ]);

        $this->assertTrue($lampiran->isImage());
    }
}
