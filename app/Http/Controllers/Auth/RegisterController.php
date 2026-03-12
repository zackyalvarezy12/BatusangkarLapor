<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Wilaya;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;

class RegisterController extends Controller
{
    // ── Step 1: Tampilkan form register ──────────────────────────
    public function showRegisterForm()
    {
        $wilayas = Wilaya::where('is_active', true)->orderBy('nama')->get();
        return view('auth.register', compact('wilayas'));
    }

    // ── Step 2: Validasi data, simpan di session, kirim OTP ──────
    public function register(Request $request)
    {
        $request->validate([
            'name'      => 'required|string|max:100',
            'email'     => 'required|email|unique:users,email',
            'password'  => 'required|min:8|confirmed',
            'no_hp'     => 'nullable|string|max:20',
            'wilaya_id' => 'required|exists:wilayas,id',
            'alamat'    => 'nullable|string|max:500',
        ], [
            'name.required'      => 'Nama lengkap wajib diisi.',
            'email.required'     => 'Email wajib diisi.',
            'email.unique'       => 'Email sudah terdaftar.',
            'password.min'       => 'Password minimal 8 karakter.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
            'wilaya_id.required' => 'Pilih wilayah tempat tinggal Anda.',
            'wilaya_id.exists'   => 'Wilayah tidak valid.',
        ]);

        // Generate OTP 6 digit
        $otp = str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);

        // Simpan data form sementara di session (belum buat user)
        session([
            'reg_data' => [
                'name'      => $request->name,
                'email'     => $request->email,
                'password'  => $request->password,
                'no_hp'     => $request->no_hp,
                'wilaya_id' => $request->wilaya_id,
                'alamat'    => $request->alamat,
            ],
            'reg_otp'         => $otp,
            'reg_otp_expires' => Carbon::now()->addMinutes(10)->timestamp,
        ]);

        // Kirim email OTP
        $nama  = $request->name;
        $email = $request->email;

        try {
            Mail::send('emails.otp', compact('otp', 'nama'), function ($m) use ($email, $nama) {
                $m->to($email, $nama)
                  ->subject('Kode Verifikasi Pendaftaran — BatusangkarLapor');
            });
        } catch (\Exception $e) {
            \Log::warning('OTP mail gagal: ' . $e->getMessage());
        }

        return redirect()->route('register.otp');
    }

    // ── Step 3: Tampilkan halaman input OTP ──────────────────────
    public function showOtpForm()
    {
        if (!session('reg_data') || !session('reg_otp')) {
            return redirect()->route('register')
                ->withErrors(['email' => 'Sesi habis. Silakan daftar ulang.']);
        }

        $email  = session('reg_data')['email'];
        $parts  = explode('@', $email);
        $masked = substr($parts[0], 0, 2)
                  . str_repeat('*', max(strlen($parts[0]) - 2, 3))
                  . '@' . $parts[1];

        return view('auth.otp', compact('masked'));
    }

    // ── Step 4: Verifikasi OTP → buat akun → login ───────────────
    public function verifyOtp(Request $request)
    {
        $request->validate([
            'otp' => 'required|string|size:6',
        ], [
            'otp.required' => 'Kode OTP wajib diisi.',
            'otp.size'     => 'Kode OTP harus 6 digit.',
        ]);

        if (!session('reg_data') || !session('reg_otp')) {
            return redirect()->route('register')
                ->withErrors(['email' => 'Sesi habis. Silakan daftar ulang.']);
        }

        // Cek kadaluarsa
        if (Carbon::now()->timestamp > session('reg_otp_expires')) {
            session()->forget(['reg_data', 'reg_otp', 'reg_otp_expires']);
            return redirect()->route('register')
                ->withErrors(['email' => 'Kode OTP sudah kadaluarsa. Silakan daftar ulang.']);
        }

        // Cek kode OTP
        if ($request->otp !== session('reg_otp')) {
            return back()->withErrors(['otp' => 'Kode OTP tidak valid. Periksa kembali email Anda.']);
        }

        // Buat user baru
        $data = session('reg_data');
        $user = User::create([
            'name'      => $data['name'],
            'email'     => $data['email'],
            'password'  => Hash::make($data['password']),
            'no_hp'     => $data['no_hp'] ?? null,
            'wilaya_id' => $data['wilaya_id'],
            'alamat'    => $data['alamat'] ?? null,
            'role'      => 'masyarakat',
            'is_active' => true,
        ]);

        // Bersihkan session register
        session()->forget(['reg_data', 'reg_otp', 'reg_otp_expires']);

        // Login otomatis
        Auth::login($user);

        return redirect()->route('masyarakat.dashboard')
            ->with('success', 'Selamat datang, ' . $user->name . '! Akun Anda berhasil dibuat.');
    }

    // ── Kirim ulang OTP ──────────────────────────────────────────
    public function resendOtp(Request $request)
    {
        if (!session('reg_data')) {
            return redirect()->route('register')
                ->withErrors(['email' => 'Sesi habis. Silakan daftar ulang.']);
        }

        $otp   = str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);
        $nama  = session('reg_data')['name'];
        $email = session('reg_data')['email'];

        session([
            'reg_otp'         => $otp,
            'reg_otp_expires' => Carbon::now()->addMinutes(10)->timestamp,
        ]);

        try {
            Mail::send('emails.otp', compact('otp', 'nama'), function ($m) use ($email, $nama) {
                $m->to($email, $nama)
                  ->subject('Kode Verifikasi Pendaftaran — BatusangkarLapor');
            });
        } catch (\Exception $e) {
            \Log::warning('OTP resend gagal: ' . $e->getMessage());
        }

        return back()->with('resent', 'Kode OTP baru telah dikirim ke email Anda.');
    }
}