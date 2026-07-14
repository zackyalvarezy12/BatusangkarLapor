<?php

namespace App\Support;

class Aes256Encryptor
{
    private string $key;

    public function __construct(string $key)
    {
        $this->key = hash('sha256', $key, true);
    }

    public function encrypt(string $value): string
    {
        $iv = openssl_random_pseudo_bytes(16);
        $cipherText = openssl_encrypt($value, 'aes-256-cbc', $this->key, 0, $iv);

        if ($cipherText === false) {
            throw new \RuntimeException('Gagal mengenkripsi data.');
        }

        return base64_encode($iv . $cipherText);
    }

    public function decrypt(string $value): string
    {
        $data = base64_decode($value, true);
        if ($data === false) {
            throw new \RuntimeException('Format data terenkripsi tidak valid.');
        }

        $iv = substr($data, 0, 16);
        $cipherText = substr($data, 16);
        $plainText = openssl_decrypt($cipherText, 'aes-256-cbc', $this->key, 0, $iv);

        if ($plainText === false) {
            throw new \RuntimeException('Gagal mendekripsi data.');
        }

        return $plainText;
    }
}
