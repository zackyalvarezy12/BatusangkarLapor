<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PublicController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboard;
use App\Http\Controllers\Admin\PengaduanController as AdminPengaduan;
use App\Http\Controllers\Admin\UserController as AdminUser;
use App\Http\Controllers\Admin\WilayaController as AdminWilaya;
use App\Http\Controllers\Admin\FaqController as AdminFaq;
use App\Http\Controllers\Admin\KritikController as AdminKritik;
use App\Http\Controllers\KritikController;
use App\Http\Controllers\NotifikasiController;
use App\Http\Controllers\Petugas\PengaduanController as PetugasPengaduan;
use App\Http\Controllers\Masyarakat\PengaduanController as MasyarakatPengaduan;
use App\Http\Controllers\Masyarakat\PenilaianController;
use App\Http\Controllers\Masyarakat\ProfilController;

// ═══════════════════════════════════════════════
// PUBLIC ROUTES
// ═══════════════════════════════════════════════

Route::get('/',            [PublicController::class, 'beranda'])->name('beranda');
Route::get('/cek-laporan', [PublicController::class, 'lacak'])->name('lacak');
Route::get('/faq',         [PublicController::class, 'faq'])->name('faq');
Route::get('/kritik-saran',  [KritikController::class, 'create'])->name('kritik.create');
Route::post('/kritik-saran', [KritikController::class, 'store'])->name('kritik.store');

// ═══════════════════════════════════════════════
// AUTH ROUTES (Guest Only)
// ═══════════════════════════════════════════════

Route::middleware('guest')->group(function () {
    Route::get('/login',  [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login']);

    Route::get('/register',  [RegisterController::class, 'showRegisterForm'])->name('register');
    Route::post('/register', [RegisterController::class, 'register'])->name('register.submit');

    Route::get('/register/otp',         [RegisterController::class, 'showOtpForm'])->name('register.otp');
    Route::post('/register/otp/verify', [RegisterController::class, 'verifyOtp'])->name('register.otp.verify');
    Route::post('/register/otp/resend', [RegisterController::class, 'resendOtp'])->name('register.otp.resend');
});

Route::post('/logout', [LoginController::class, 'logout'])
    ->middleware('auth')
    ->name('logout');
    
Route::middleware(['auth', 'must_change_password'])->group(function () {
    Route::get('/ganti-password',  [\App\Http\Controllers\Auth\ChangePasswordController::class, 'show'])->name('password.change');
    Route::post('/ganti-password', [\App\Http\Controllers\Auth\ChangePasswordController::class, 'update'])->name('password.update');
});

// ═══════════════════════════════════════════════
// NOTIFIKASI (semua user auth)
// ═══════════════════════════════════════════════

Route::middleware('auth')->group(function () {
    Route::patch('/notif/{id}/baca', [NotifikasiController::class, 'baca'])->name('notif.baca');
});

// ═══════════════════════════════════════════════
// MASYARAKAT ROUTES
// ═══════════════════════════════════════════════

Route::middleware(['auth', 'role:masyarakat'])
    ->prefix('laporan')
    ->name('masyarakat.')
    ->group(function () {

    Route::get('/', function () {
        return view('masyarakat.dashboard');
    })->name('dashboard');

    Route::get('/semua',          [MasyarakatPengaduan::class, 'index'])->name('pengaduan.index');
    Route::get('/buat',           [MasyarakatPengaduan::class, 'create'])->name('pengaduan.create');
    Route::post('/buat',          [MasyarakatPengaduan::class, 'store'])->name('pengaduan.store');

    Route::get('/profil', [ProfilController::class, 'edit'])->name('profil.edit');
    Route::put('/profil', [ProfilController::class, 'update'])->name('profil.update');
    Route::get('/profil/password', [ProfilController::class, 'editPassword'])->name('password.edit');
    Route::put('/profil/password', [ProfilController::class, 'updatePassword'])->name('password.update');

    Route::get('/{pengaduan}',    [MasyarakatPengaduan::class, 'show'])->name('pengaduan.show');
    Route::delete('/{pengaduan}', [MasyarakatPengaduan::class, 'destroy'])->name('pengaduan.destroy');

    Route::get('/{pengaduan}/chat',       [MasyarakatPengaduan::class, 'chat'])->name('pengaduan.chat');
    Route::post('/{pengaduan}/pesan',     [MasyarakatPengaduan::class, 'kirimPesan'])->name('pengaduan.pesan');
    Route::get('/{pengaduan}/pesan-baru', [MasyarakatPengaduan::class, 'pesanBaru'])->name('pengaduan.pesan.baru');

    Route::post('/{pengaduan}/penilaian', [PenilaianController::class, 'store'])->name('penilaian.store');
});

// ═══════════════════════════════════════════════
// PETUGAS ROUTES
// ═══════════════════════════════════════════════

Route::middleware(['auth', 'role:petugas', 'must_change_password'])
    ->prefix('petugas')
    ->name('petugas.')
    ->group(function () {

    Route::get('/', function () {
        return view('petugas.dashboard');
    })->name('dashboard');

    Route::get('/laporan',                      [PetugasPengaduan::class, 'index'])->name('pengaduan.index');
    Route::get('/laporan/{pengaduan}',          [PetugasPengaduan::class, 'show'])->name('pengaduan.show');
    Route::get('/laporan/{pengaduan}/pdf',     [PetugasPengaduan::class, 'downloadPdf'])->name('pengaduan.pdf');
    Route::patch('/laporan/{pengaduan}/status', [PetugasPengaduan::class, 'updateStatus'])->name('pengaduan.status');
    Route::post('/laporan/{pengaduan}/tanggap', [PetugasPengaduan::class, 'tanggapi'])->name('pengaduan.tanggap');

    Route::get('/laporan/{pengaduan}/chat',       [PetugasPengaduan::class, 'chat'])->name('pengaduan.chat');
    Route::post('/laporan/{pengaduan}/pesan',     [PetugasPengaduan::class, 'kirimPesan'])->name('pengaduan.pesan');
    Route::get('/laporan/{pengaduan}/pesan-baru', [PetugasPengaduan::class, 'pesanBaru'])->name('pengaduan.pesan.baru');

    Route::get('/profil',          [\App\Http\Controllers\Petugas\ProfilController::class, 'edit'])->name('profil.edit');
    Route::put('/profil',          [\App\Http\Controllers\Petugas\ProfilController::class, 'update'])->name('profil.update');
    Route::get('/profil/password', [\App\Http\Controllers\Petugas\ProfilController::class, 'editPassword'])->name('password.edit');
    Route::put('/profil/password', [\App\Http\Controllers\Petugas\ProfilController::class, 'updatePassword'])->name('password.update');

    Route::get('/export',        [\App\Http\Controllers\Petugas\LaporanController::class, 'index'])->name('laporan.index');
    Route::post('/export/cetak', [\App\Http\Controllers\Petugas\LaporanController::class, 'export'])->name('laporan.export');

    // Notifikasi
    Route::patch('/notif/read-all', [NotifikasiController::class, 'readAllPetugas'])->name('notif.readall');
});

// ═══════════════════════════════════════════════
// ADMIN ROUTES
// ═══════════════════════════════════════════════

Route::middleware(['auth', 'role:admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

    Route::get('/dashboard', [AdminDashboard::class, 'index'])->name('dashboard');

    // Wilaya
    Route::get('/wilaya',                   [AdminWilaya::class, 'index'])->name('wilaya.index');
    Route::post('/wilaya',                  [AdminWilaya::class, 'store'])->name('wilaya.store');
    Route::put('/wilaya/{wilaya}',          [AdminWilaya::class, 'update'])->name('wilaya.update');
    Route::delete('/wilaya/{wilaya}',       [AdminWilaya::class, 'destroy'])->name('wilaya.destroy');
    Route::patch('/wilaya/{wilaya}/toggle', [AdminWilaya::class, 'toggle'])->name('wilaya.toggle');

    // User
    Route::get('/user',                 [AdminUser::class, 'index'])->name('user.index');
    Route::get('/user/buat',            [AdminUser::class, 'create'])->name('user.create');
    Route::post('/user',                [AdminUser::class, 'store'])->name('user.store');
    Route::get('/user/{user}/edit',     [AdminUser::class, 'edit'])->name('user.edit');
    Route::put('/user/{user}',          [AdminUser::class, 'update'])->name('user.update');
    Route::delete('/user/{user}',       [AdminUser::class, 'destroy'])->name('user.destroy');
    Route::patch('/user/{user}/toggle', [AdminUser::class, 'toggleActive'])->name('user.toggle');

    // Semua Laporan
    Route::get('/laporan',                        [AdminPengaduan::class, 'index'])->name('pengaduan.index');
    Route::get('/laporan/{pengaduan}',            [AdminPengaduan::class, 'show'])->name('pengaduan.show');
    Route::patch('/laporan/{pengaduan}/status',   [AdminPengaduan::class, 'updateStatus'])->name('pengaduan.status');
    Route::patch('/laporan/{pengaduan}/assign',   [AdminPengaduan::class, 'assignPetugas'])->name('pengaduan.assign');
    Route::delete('/laporan/{pengaduan}',         [AdminPengaduan::class, 'destroy'])->name('pengaduan.destroy');

    Route::get('/laporan/{pengaduan}/chat',       [AdminPengaduan::class, 'chat'])->name('pengaduan.chat');
    Route::post('/laporan/{pengaduan}/pesan',     [AdminPengaduan::class, 'kirimPesan'])->name('pengaduan.pesan');
    Route::get('/laporan/{pengaduan}/pesan-baru', [AdminPengaduan::class, 'pesanBaru'])->name('pengaduan.pesan.baru');

    // Profil Admin
    Route::get('/profil',          [\App\Http\Controllers\Admin\ProfilController::class, 'edit'])->name('profil.edit');
    Route::put('/profil',          [\App\Http\Controllers\Admin\ProfilController::class, 'update'])->name('profil.update');
    Route::get('/profil/password', [\App\Http\Controllers\Admin\ProfilController::class, 'editPassword'])->name('password.edit');
    Route::put('/profil/password', [\App\Http\Controllers\Admin\ProfilController::class, 'updatePassword'])->name('password.update');

    // Kategori
    Route::get('/kategori',                     [\App\Http\Controllers\Admin\KategoriController::class, 'index'])->name('kategori.index');
    Route::post('/kategori',                    [\App\Http\Controllers\Admin\KategoriController::class, 'store'])->name('kategori.store');
    Route::put('/kategori/{kategori}',          [\App\Http\Controllers\Admin\KategoriController::class, 'update'])->name('kategori.update');
    Route::patch('/kategori/{kategori}/toggle', [\App\Http\Controllers\Admin\KategoriController::class, 'toggle'])->name('kategori.toggle');
    Route::delete('/kategori/{kategori}',       [\App\Http\Controllers\Admin\KategoriController::class, 'destroy'])->name('kategori.destroy');

    // FAQ
    Route::get('/faq',                   [AdminFaq::class, 'index'])->name('faq.index');
    Route::post('/faq',                  [AdminFaq::class, 'store'])->name('faq.store');
    Route::put('/faq/{faq}',             [AdminFaq::class, 'update'])->name('faq.update');
    Route::patch('/faq/{faq}/toggle',    [AdminFaq::class, 'toggle'])->name('faq.toggle');
    Route::delete('/faq/{faq}',          [AdminFaq::class, 'destroy'])->name('faq.destroy');

    // Pengumuman
    Route::get('/pengumuman',                        [\App\Http\Controllers\Admin\PengumumanController::class, 'index'])->name('pengumuman.index');
    Route::post('/pengumuman',                       [\App\Http\Controllers\Admin\PengumumanController::class, 'store'])->name('pengumuman.store');
    Route::put('/pengumuman/{pengumuman}',           [\App\Http\Controllers\Admin\PengumumanController::class, 'update'])->name('pengumuman.update');
    Route::patch('/pengumuman/{pengumuman}/toggle',  [\App\Http\Controllers\Admin\PengumumanController::class, 'toggle'])->name('pengumuman.toggle');
    Route::delete('/pengumuman/{pengumuman}',        [\App\Http\Controllers\Admin\PengumumanController::class, 'destroy'])->name('pengumuman.destroy');

    // Kritik & Saran
    Route::get('/kritik',                  [AdminKritik::class, 'index'])->name('kritik.index');
    Route::patch('/kritik/{kritik}/balas', [AdminKritik::class, 'balas'])->name('kritik.balas');
    Route::delete('/kritik/{kritik}',      [AdminKritik::class, 'destroy'])->name('kritik.destroy');

    // Export Laporan
    Route::get('/export',        [\App\Http\Controllers\Admin\LaporanController::class, 'index'])->name('laporan.index');
    Route::post('/export/cetak', [\App\Http\Controllers\Admin\LaporanController::class, 'export'])->name('laporan.export');

    // Notifikasi
    Route::patch('/notif/read-all', [NotifikasiController::class, 'readAllAdmin'])->name('notif.readall');
});