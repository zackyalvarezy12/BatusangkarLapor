<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class FaqSeeder extends Seeder
{
    public function run(): void
    {
        $faqs = [
            [
                'pertanyaan' => 'Bagaimana cara membuat laporan pengaduan?',
                'jawaban'    => 'Login ke akun Anda, lalu klik tombol "Buat Laporan" di dashboard. Isi judul, kategori, wilayah, dan deskripsi masalah dengan lengkap. Anda juga bisa melampirkan foto atau dokumen pendukung. Setelah dikirim, laporan akan diproses oleh petugas.',
                'urutan'     => 1,
                'is_aktif'  => true,
            ],
            [
                'pertanyaan' => 'Bagaimana cara memantau status laporan saya?',
                'jawaban'    => 'Buka menu "Laporan Saya" di dashboard masyarakat. Setiap laporan memiliki status: Belum Ditindak, Sedang Ditindak, Selesai, atau Ditolak. Anda juga akan mendapat notifikasi otomatis setiap kali status laporan berubah.',
                'urutan'     => 2,
                'is_aktif'  => true,
            ],
            [
                'pertanyaan' => 'Apakah data dan identitas saya aman?',
                'jawaban'    => 'Ya. Semua data pribadi seperti NIK, nomor HP, dan alamat dienkripsi menggunakan standar AES-256. Anda juga dapat memilih opsi laporan anonim agar identitas Anda tidak ditampilkan kepada petugas.',
                'urutan'     => 3,
                'is_aktif'  => true,
            ],
            [
                'pertanyaan' => 'Berapa lama laporan saya akan diproses?',
                'jawaban'    => 'Petugas akan meninjau laporan Anda dalam 1×24 jam setelah dikirim. Waktu penyelesaian bergantung pada jenis dan kompleksitas masalah yang dilaporkan. Anda bisa memantau perkembangannya melalui halaman detail laporan.',
                'urutan'     => 4,
                'is_aktif'  => true,
            ],
            [
                'pertanyaan' => 'Apa saja jenis laporan yang bisa diajukan?',
                'jawaban'    => 'Anda dapat melaporkan berbagai masalah sesuai kategori yang tersedia, seperti infrastruktur jalan, fasilitas umum, kebersihan lingkungan, layanan publik, dan lain-lain. Pilih kategori yang paling sesuai saat membuat laporan.',
                'urutan'     => 5,
                'is_aktif'  => true,
            ],
            [
                'pertanyaan' => 'Bagaimana jika laporan saya ditolak?',
                'jawaban'    => 'Laporan bisa ditolak jika tidak sesuai kategori, duplikat, atau tidak memiliki informasi yang cukup. Anda akan mendapat notifikasi beserta keterangan alasan penolakan dari petugas, dan dapat mengajukan laporan baru dengan informasi yang lebih lengkap.',
                'urutan'     => 6,
                'is_aktif'  => true,
            ],
        ];

        foreach ($faqs as $faq) {
            DB::table('faqs')->insert(array_merge($faq, [
                'created_at' => now(),
                'updated_at' => now(),
            ]));
        }
    }
}