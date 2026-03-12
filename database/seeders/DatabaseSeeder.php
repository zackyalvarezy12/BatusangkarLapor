<?php

namespace Database\Seeders;

use App\Models\{Faq, Kategori, Pengumuman, User, Wilaya};
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // ── Wilayas DULU (sebelum user, karena user FK ke wilayas) ──
        $kecamatans = ['Lima Kaum', 'Batusangkar', 'Sungai Tarab', 'Sungayang', 'Pariangan', 'Rambatan'];
        $wilayaIds  = [];
        foreach ($kecamatans as $kec) {
            $w = Wilaya::create(['nama' => $kec, 'tipe' => 'kecamatan', 'is_active' => true]);
            $wilayaIds[$kec] = $w->id;
        }

        // ── Users ──
        $admin = User::create([
            'name'              => 'Administrator',
            'email'             => 'admin@batusangkarlapor.test',
            'password'          => 'password123',
            'role'              => 'admin',
            'wilaya_id'         => null,
            'is_active'         => true,
            'otp_verified'      => true,
            'email_verified_at' => now(),
        ]);

        User::create([
            'name'              => 'Petugas Satu',
            'email'             => 'petugas@batusangkarlapor.test',
            'password'          => 'password123',
            'role'              => 'petugas',
            'wilaya_id'         => $wilayaIds['Lima Kaum'], // petugas terikat Lima Kaum
            'is_active'         => true,
            'otp_verified'      => true,
            'email_verified_at' => now(),
        ]);

        User::create([
            'name'              => 'Budi Santoso',
            'email'             => 'masyarakat@batusangkarlapor.test',
            'password'          => 'password123',
            'role'              => 'masyarakat',
            'wilaya_id'         => $wilayaIds['Lima Kaum'], // masyarakat di Lima Kaum
            'is_active'         => true,
            'otp_verified'      => true,
            'nik'               => '1306010101900001',
            'no_hp'             => '08234567890',
            'alamat'            => 'Jorong Dalam, Nagari Lima Kaum',
            'email_verified_at' => now(),
        ]);

        // ── Kategoris ──
        $kategoris = [
            ['nama' => 'Infrastruktur & Jalan',   'ikon' => 'wrench-screwdriver', 'warna' => '#003580', 'urutan' => 1],
            ['nama' => 'Pendidikan',               'ikon' => 'academic-cap',       'warna' => '#15803d', 'urutan' => 2],
            ['nama' => 'Kesehatan',                'ikon' => 'heart',              'warna' => '#b91c1c', 'urutan' => 3],
            ['nama' => 'Lingkungan & Sanitasi',    'ikon' => 'leaf',               'warna' => '#166534', 'urutan' => 4],
            ['nama' => 'Keamanan & Ketertiban',    'ikon' => 'shield-check',       'warna' => '#1d4ed8', 'urutan' => 5],
            ['nama' => 'Pelayanan Publik',         'ikon' => 'building-office',    'warna' => '#c8a000', 'urutan' => 6],
            ['nama' => 'Lainnya',                  'ikon' => 'ellipsis-horizontal','warna' => '#6b7280', 'urutan' => 7],
        ];
        foreach ($kategoris as $k) {
            Kategori::create(array_merge($k, ['is_active' => true]));
        }

        // ── FAQs ──
        $faqs = [
            ['pertanyaan' => 'Bagaimana cara membuat laporan?',
             'jawaban'    => 'Login ke akun Anda, klik "Buat Laporan", isi formulir dengan lengkap lalu kirim. Anda akan mendapat kode laporan dan token pelacak.'],
            ['pertanyaan' => 'Berapa lama laporan diproses?',
             'jawaban'    => 'Laporan ditinjau dalam 1x24 jam. Proses penanganan umumnya 7-14 hari kerja.'],
            ['pertanyaan' => 'Apakah laporan saya bisa anonim?',
             'jawaban'    => 'Ya, centang opsi "Kirim sebagai Anonim" saat membuat laporan.'],
            ['pertanyaan' => 'Bagaimana cara melacak laporan tanpa login?',
             'jawaban'    => 'Gunakan halaman Cek Laporan dengan token pelacak atau kode laporan Anda.'],
            ['pertanyaan' => 'Apakah data pribadi saya aman?',
             'jawaban'    => 'Ya. Data sensitif disimpan terenkripsi AES-256. Hanya admin yang dapat mengaksesnya.'],
        ];
        foreach ($faqs as $i => $faq) {
            Faq::create(array_merge($faq, ['urutan' => $i + 1, 'is_aktif' => true]));
        }

        // Pengumuman
        Pengumuman::create([
            'judul'          => 'Selamat Datang di BatusangkarLapor',
            'konten'         => '<p>BatusangkarLapor adalah platform pengaduan masyarakat resmi Pemerintah Kabupaten Tanah Datar.</p>',
            'user_id'        => $admin->id,
            'is_aktif'       => true,
            'diterbitkan_at' => now(),
        ]);
    }
}