<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\AktivitasLog;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required',
        ]);

        $user = User::where('email', $request->email)->first();

        if ($user && !$user->is_active) {
            return back()->withErrors(['email' => 'Akun Anda telah dinonaktifkan.'])->withInput();
        }

        if (!Auth::attempt($request->only('email', 'password'), $request->boolean('remember'))) {
            return back()->withErrors(['email' => 'Email atau password salah.'])->withInput();
        }

        $user = Auth::user();

        AktivitasLog::create([
            'user_id'    => $user->id,
            'aksi'       => 'login',
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
        ]);

        $url = match ($user->role) {
            'admin'   => route('admin.dashboard'),
            'petugas' => route('petugas.dashboard'),
            default   => route('masyarakat.dashboard'),
        };

        return redirect($url);
    }

    public function showOtpForm()
    {
        if (!session('otp_user_id')) {
            return redirect()->route('login');
        }
        return view('auth.otp');
    }

    public function verifyOtp(Request $request)
    {
        $request->validate(['otp' => 'required|digits:6']);

        $user = User::find(session('otp_user_id'));

        if (!$user || !$user->isOtpValid($request->otp)) {
            return back()->withErrors(['otp' => 'Kode OTP tidak valid atau sudah kadaluarsa.']);
        }

        $user->update(['otp_verified' => true, 'otp_code' => null]);
        session()->forget(['otp_user_id', 'otp_remember']);

        Auth::login($user, session('otp_remember', false));

        AktivitasLog::create([
            'user_id'    => $user->id,
            'aksi'       => 'login',
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
        ]);

        return redirect($this->redirectPath($user));
    }

    public function resendOtp()
    {
        $user = User::find(session('otp_user_id'));
        if (!$user) return redirect()->route('login');

        $otp = $user->generateOtp();
        Mail::to($user->email)->send(new \App\Mail\OtpMail($otp, $user->name));

        return back()->with('success', 'Kode OTP baru telah dikirim.');
    }

    public function logout(Request $request)
    {
        auth()->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('beranda');
    }

    private function redirectPath(User $user): string
    {
        return match ($user->role) {
            'admin'   => route('admin.dashboard'),
            'petugas' => route('petugas.dashboard'),
            default   => route('masyarakat.dashboard'),
        };
    }
}