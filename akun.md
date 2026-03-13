#cara buat akun

#rolenya ada (admin,petugas,masyarakat)

\App\Models\User::create([
    'name' => 'admin',
    'email' => 'admin@gmail.com',
    'password' => bcrypt('12345678'),
    'role' => 'admin', 
    'email_verified_at' => now(),
]);