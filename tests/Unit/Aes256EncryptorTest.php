<?php

namespace Tests\Unit;

use App\Support\Aes256Encryptor;
use PHPUnit\Framework\TestCase;

class Aes256EncryptorTest extends TestCase
{
    public function test_encrypt_and_decrypt_round_trip(): void
    {
        $encryptor = new Aes256Encryptor('0123456789abcdef0123456789abcdef');
        $plainText = 'Laporan rahasia 123';

        $cipherText = $encryptor->encrypt($plainText);

        $this->assertNotSame($plainText, $cipherText);
        $this->assertSame($plainText, $encryptor->decrypt($cipherText));
    }
}
