<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\Pengguna;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;

class LoginController extends Controller
{
    /**
     * Tampilkan halaman login.
     */
    public function create()
    {
        return view('auth.login');
    }

    /**
     * Proses login — cek t_admin dulu, lalu t_pengguna (Hash::check dengan plaintext fallback).
     */
    public function store(Request $request)
    {
        $request->validate([
            'nik' => ['required', 'string'],
            'password' => ['required', 'string'],
        ], [
            'nik.required' => 'NIK wajib diisi.',
            'password.required' => 'Password wajib diisi.',
        ]);

        $nip      = $request->nik;
        $password = $request->password;

        // ── 1. Coba login sebagai Admin (t_admin) ──────────────────────────
        $admin = Admin::where('nik_admin', $nip)
            ->first();

        if ($admin && (Hash::check($password, $admin->password) || $admin->password === $password)) {
            Auth::guard('admin')->login($admin, $request->boolean('remember'));
            $request->session()->regenerate();

            return redirect()->route('admin.dashboard');
        }

        // ── 2. Coba login sebagai Pengguna (t_pengguna) ────────────────────
        $pengguna = Pengguna::where('nik', $nip)
            ->first();

        if ($pengguna && (Hash::check($password, $pengguna->password) || $pengguna->password === $password)) {
            Auth::guard('pengguna')->login($pengguna, $request->boolean('remember'));
            $request->session()->regenerate();

            return redirect()->route('pengguna.dashboard');
        }

        // ── 3. Gagal ───────────────────────────────────────────────────────
        return back()
            ->withInput($request->only('nik'))
            ->withErrors([
                'nik' => 'NIK atau password salah.',
            ]);
    }

    /**
     * Logout semua guard.
     */
    public function destroy(Request $request)
    {
        Auth::guard('admin')->logout();
        Auth::guard('pengguna')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }

    /**
     * Tampilkan halaman lupa password.
     */
    public function showForgotPassword()
    {
        return view('auth.forgot-password');
    }

    /**
     * Kirim tautan reset password via email.
     */
    public function handleForgotPassword(Request $request)
    {
        $request->validate([
            'nik' => ['required', 'string'],
        ], [
            'nik.required' => 'NIK wajib diisi.',
        ]);

        $identity = $request->nik;

        // ── 1. Cek Admin (t_admin) ─────────────────────────────────────────
        $admin = Admin::where('nik_admin', $identity)
            ->first();

        if ($admin) {
            if (empty($admin->email)) {
                return back()->withErrors([
                    'nik' => 'Akun ini belum memiliki alamat email. Hubungi administrator.'
                ]);
            }

            $status = Password::broker('admins')->sendResetLink(['email' => $admin->email]);

            return $status === Password::RESET_LINK_SENT
                ? back()->with('status', 'Tautan reset password telah dikirim ke email Anda.')
                : back()->withErrors(['nik' => 'Gagal mengirim tautan reset. Silakan coba lagi nanti.']);
        }

        // ── 2. Cek Pengguna (t_pengguna) ───────────────────────────────────
        $pengguna = Pengguna::where('nik', $identity)
            ->first();

        if ($pengguna) {
            if (empty($pengguna->email)) {
                return back()->withErrors([
                    'nik' => 'Akun ini belum memiliki alamat email. Hubungi administrator.'
                ]);
            }

            $status = Password::broker('pengguna')->sendResetLink(['email' => $pengguna->email]);

            return $status === Password::RESET_LINK_SENT
                ? back()->with('status', 'Tautan reset password telah dikirim ke email Anda.')
                : back()->withErrors(['nik' => 'Gagal mengirim tautan reset. Silakan coba lagi nanti.']);
        }

        // ── 3. Tidak ditemukan ─────────────────────────────────────────────
        return back()->withErrors([
            'nik' => 'NIK tidak terdaftar dalam sistem.'
        ]);
    }

    /**
     * Tampilkan halaman atur ulang password.
     */
    public function showResetPassword(Request $request, $token)
    {
        return view('auth.reset-password', ['token' => $token, 'email' => $request->email]);
    }

    /**
     * Proses pembaruan kata sandi baru.
     */
    public function handleResetPassword(Request $request)
    {
        $request->validate([
            'token' => ['required'],
            'email' => ['required', 'email'],
            'password' => ['required', 'string', 'min:6', 'confirmed'],
        ], [
            'email.required' => 'Alamat email wajib disertakan.',
            'email.email' => 'Format email tidak valid.',
            'password.required' => 'Password baru wajib diisi.',
            'password.min' => 'Password minimal harus 6 karakter.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
        ]);

        $resetCallback = function ($user, $password) {
            $user->password = Hash::make($password);
            $user->save();
        };

        // Coba di broker admins
        $status = Password::broker('admins')->reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            $resetCallback
        );

        if ($status === Password::PASSWORD_RESET) {
            return redirect()->route('login')->with('success', 'Kata sandi Anda berhasil diperbarui! Silakan masuk.');
        }

        // Jika tidak, coba di broker penggunas
        $status = Password::broker('pengguna')->reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            $resetCallback
        );

        if ($status === Password::PASSWORD_RESET) {
            return redirect()->route('login')->with('success', 'Kata sandi Anda berhasil diperbarui! Silakan masuk.');
        }

        return back()->withErrors(['email' => 'Gagal mereset password. Token tidak valid atau kedaluwarsa.']);
    }
}
