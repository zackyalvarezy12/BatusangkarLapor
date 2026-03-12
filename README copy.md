# 🏛️ BatusangkarLapor

**Sistem Informasi Pengaduan Masyarakat**  
Pemerintah Kabupaten Tanah Datar — Batusangkar, Sumatera Barat

> _"Aspirasi Anda, Prioritas Kami"_

---

## 🛠 Stack Teknologi

| Layer     | Teknologi                              |
|-----------|----------------------------------------|
| Backend   | Laravel 10 (PHP 8.1+), MVC            |
| Database  | MySQL 8.0                              |
| Frontend  | Blade Templates + Tailwind CSS 3       |
| Email     | SMTP Gmail + OTP                       |
| Slug      | `spatie/laravel-sluggable`             |
| Enkripsi  | Laravel AES-256 Cast + `vinkla/hashids`|
| Icons     | Heroicons v2                           |
| Charts    | Chart.js 4                             |
| Font      | Plus Jakarta Sans                      |

---

## 🚀 Cara Setup

### 1. Clone & Install

```bash
# Masuk ke folder project
cd batusangkarlapor

# Install dependencies
composer install

# Copy .env
cp .env.example .env

# Generate app key (PENTING untuk enkripsi)
php artisan key:generate
```

### 2. Konfigurasi Database

Edit `.env`:

```env
DB_DATABASE=batusangkarlapor
DB_USERNAME=root
DB_PASSWORD=your_password
```

Buat database:
```sql
CREATE DATABASE batusangkarlapor CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
```

### 3. Konfigurasi Email (Gmail OTP)

Di Gmail: aktifkan **2-Step Verification** → buat **App Password**

```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=your@gmail.com
MAIL_PASSWORD=xxxx_xxxx_xxxx_xxxx   # App Password Gmail
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=your@gmail.com
MAIL_FROM_NAME="BatusangkarLapor"
```

### 4. Konfigurasi Enkripsi Hashids

```env
HASHIDS_SALT=batusangkarlapor_secret_2026   # Ganti dengan string acak Anda
HASHIDS_LENGTH=10
```

### 5. Migrate & Seed

```bash
php artisan migrate --seed
```

### 6. Storage Link

```bash
php artisan storage:link
```

### 7. Jalankan Server

```bash
php artisan serve
```

Akses: **http://localhost:8000**

---

## 👤 Akun Default (Setelah Seeder)

| Role       | Email                              | Password      |
|------------|------------------------------------|---------------|
| Admin      | admin@batusangkarlapor.test        | password123   |
| Petugas    | petugas@batusangkarlapor.test      | password123   |
| Masyarakat | masyarakat@batusangkarlapor.test   | password123   |

> ⚠️ **Catatan:** Login memerlukan OTP. Di mode development, cek OTP di Laravel log: `storage/logs/laravel.log`

---

## 🔒 Fitur Keamanan

### Enkripsi Data Sensitif (AES-256-CBC)
Kolom berikut dienkripsi otomatis via Laravel `encrypted` cast:
- `users.nik`
- `users.no_hp`
- `users.alamat`
- `pengaduans.deskripsi`
- `pengaduans.lampiran`

### Hashids (ID Publik)
ID asli database disembunyikan di URL publik:
```
/laporan/abc1234xyz  →  bukan  /laporan/42
```

### Slug SEO-Friendly
URL laporan otomatis dari judul:
```
/laporan/jalan-rusak-depan-pasar-batusangkar-2026
```

### OTP Login (2FA via Email)
Setiap login memerlukan verifikasi OTP 6 digit yang dikirim ke email.

### Token Pelacak
Setiap laporan mendapat token unik `XXXX-XXXX-XXXX` untuk tracking tanpa login.

---

## 📁 Struktur Penting

```
app/
├── Http/
│   ├── Controllers/
│   │   ├── Auth/         ← Login, Register, OTP
│   │   ├── Admin/        ← Dashboard, Pengaduan, User
│   │   ├── Petugas/      ← Pengaduan, Tanggapi
│   │   └── Masyarakat/   ← Pengaduan, Lacak
│   └── Middleware/
│       └── RoleMiddleware.php   ← Proteksi per role
├── Models/
│   ├── User.php          ← encrypted: nik, no_hp, alamat
│   ├── Pengaduan.php     ← slug, hashid, encrypted: deskripsi
│   └── ...
├── Mail/
│   └── OtpMail.php
database/
├── migrations/           ← 12 tabel
└── seeders/
    └── DatabaseSeeder.php
resources/views/
├── layouts/
│   ├── app.blade.php     ← Layout publik
│   └── admin.blade.php   ← Layout admin (dark sidebar)
├── auth/                 ← login, register, otp
├── admin/                ← dashboard, pengaduan, user
├── petugas/
├── masyarakat/
└── public/               ← beranda, lacak
routes/
└── web.php               ← Semua route dengan slug binding
```

---

## 🔗 Daftar Route Utama

| Method | URL                              | Keterangan               |
|--------|----------------------------------|--------------------------|
| GET    | `/`                              | Beranda publik           |
| GET    | `/cek-laporan`                   | Lacak laporan publik     |
| GET    | `/login`                         | Form login               |
| POST   | `/login`                         | Proses login → kirim OTP |
| GET    | `/otp`                           | Form verifikasi OTP      |
| POST   | `/otp`                           | Verifikasi OTP           |
| GET    | `/register`                      | Form daftar              |
| GET    | `/laporan/buat`                  | Form buat laporan        |
| GET    | `/laporan/{slug}`                | Detail laporan (slug!)   |
| GET    | `/admin/dashboard`               | Dashboard admin          |
| GET    | `/admin/laporan`                 | List semua laporan       |
| GET    | `/dev/register`                  | Dev page testing         |

---

## 🧪 Dev Page

Untuk testing tanpa OTP, gunakan endpoint:
```
GET /dev/register
```
Kode Dev: `BATUSANGKARLAPOR_DEV_2026`

---

## 📦 Setelah Setup, Install Tambahan

```bash
# Jika belum ada di vendor (jalankan setelah composer install):
php artisan vendor:publish --provider="Spatie\Sluggable\SlugServiceProvider"
```

---

## 🆘 Troubleshooting

**OTP tidak terkirim:**
→ Pastikan Gmail App Password benar, bukan password biasa.
→ Test: `php artisan tinker` → `Mail::raw('test', fn($m)=>$m->to('test@test.com')->subject('test'));`

**Enkripsi error `DecryptException`:**
→ Pastikan `APP_KEY` sudah di-generate (`php artisan key:generate`)
→ Jangan ganti APP_KEY setelah data terenkripsi tersimpan!

**Slug duplikat:**
→ spatie/laravel-sluggable otomatis menambah suffix angka: `judul-laporan-2`
