<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{

    // =========================================================
    //  PELANGGAN — Login
    // =========================================================

    /**
     * Tampilkan halaman login pelanggan.
     */
    public function showLoginPelanggan()
    {
        if (Auth::check() && Auth::user()->role === 'pelanggan') {
            return redirect('/status-box');
        }

        return view('auth.login');
    }

    /**
     * Proses login pelanggan.
     */
    public function loginPelanggan(Request $request)
    {
        $request->validate([
            'email'    => ['required', 'email'],
            'password' => ['required', 'string', 'min:6'],
        ], [
            'email.required'    => 'Email wajib diisi.',
            'email.email'       => 'Format email tidak valid.',
            'password.required' => 'Password wajib diisi.',
            'password.min'      => 'Password minimal 6 karakter.',
        ]);

        $credentials = $request->only('email', 'password');
        $remember    = $request->boolean('remember');

        if (Auth::attempt($credentials, $remember)) {
            $user = Auth::user();

            // Hanya role pelanggan yang boleh masuk lewat halaman ini
            if ($user->role !== 'pelanggan') {
                Auth::logout();
                return back()->withErrors([
                    'email' => 'Akun ini bukan akun pelanggan.',
                ])->withInput($request->only('email'));
            }

            $request->session()->regenerate();

            return redirect('/status-box')
                ->with('success', 'Selamat datang kembali, ' . $user->name . '!');
        }

        return back()
            ->withInput($request->only('email'))
            ->withErrors([
                'email' => 'Email atau password salah.',
            ]);
    }

    /**
     * Logout pelanggan.
     */
    public function logoutPelanggan(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login')->with('success', 'Kamu berhasil keluar.');
    }

    public function showRegister()
    {
        if (Auth::check() && Auth::user()->role === 'pelanggan') {
            return redirect('/status-box');
        }

        return view('auth.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'name'          => 'required|string|max:255',
            'no_hp'         => 'required|string|max:20',
            'email'         => 'required|email|unique:users,email',
            'password'      => 'required|string|min:8|confirmed',
            'jenis_kelamin' => 'required|in:pria,wanita',
            'tanggal_lahir' => 'nullable|date|before:-10 years',
            'setuju'        => 'accepted',
        ], [
            'name.required'          => 'Nama lengkap wajib diisi.',
            'no_hp.required'         => 'Nomor HP wajib diisi.',
            'email.required'         => 'Email wajib diisi.',
            'email.unique'           => 'Email sudah terdaftar.',
            'password.min'           => 'Password minimal 8 karakter.',
            'password.confirmed'     => 'Konfirmasi password tidak cocok.',
            'jenis_kelamin.required' => 'Jenis kelamin wajib dipilih.',
            'setuju.accepted'        => 'Kamu harus menyetujui syarat & ketentuan.',
        ]);

        $user = User::create([
            'name'          => $request->name,
            'no_hp'         => $request->no_hp,
            'email'         => $request->email,
            'password'      => Hash::make($request->password),
            'role'          => 'pelanggan',
            'status'        => 'aktif',
        ]);

        Auth::login($user);

        return redirect('/preferensi')
            ->with('success', 'Akun berhasil dibuat! Lengkapi preferensi fashion kamu.');
    }



    public function showLoginKurator()
    {
        if (Auth::check() && Auth::user()->role === 'kurator') {
            return redirect('/kurator/pelanggan');
        }

        return view('auth.login-kurator');
    }

    public function loginKurator(Request $request)
    {
        $request->validate([
            'email'    => ['required', 'email'],
            'password' => ['required', 'string', 'min:6'],
        ], [
            'email.required'    => 'Email wajib diisi.',
            'email.email'       => 'Format email tidak valid.',
            'password.required' => 'Password wajib diisi.',
            'password.min'      => 'Password minimal 6 karakter.',
        ]);

        $credentials = $request->only('email', 'password');
        $remember    = $request->boolean('remember');

        if (Auth::attempt($credentials, $remember)) {
            $user = Auth::user();

            if ($user->role !== 'kurator') {
                Auth::logout();
                return back()->withErrors([
                    'email' => 'Akun ini bukan akun kurator.',
                ])->withInput($request->only('email'));
            }

            $request->session()->regenerate();

            return redirect('/kurator/pelanggan')
                ->with('success', 'Selamat datang, ' . $user->name . '!');
        }

        return back()
            ->withInput($request->only('email'))
            ->withErrors(['email' => 'Email atau password salah.']);
    }

    public function logoutKurator(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/kurator/login')->with('success', 'Berhasil keluar.');
    }



    /**
     * Tampilkan halaman login admin.
     */
    public function showLogin()
    {
        // Kalau sudah login sebagai admin, langsung redirect ke dashboard
        if (Auth::check() && Auth::user()->role === 'admin') {
            return redirect('/admin/dashboard');
        }

        return view('auth.login-admin');
    }

    /**
     * Proses login admin.
     */
    public function login(Request $request)
    {
        $request->validate([
            'email'    => ['required', 'email'],
            'password' => ['required', 'string', 'min:6'],
        ], [
            'email.required'    => 'Email wajib diisi.',
            'email.email'       => 'Format email tidak valid.',
            'password.required' => 'Password wajib diisi.',
            'password.min'      => 'Password minimal 6 karakter.',
        ]);

        $credentials = $request->only('email', 'password');
        $remember    = $request->boolean('remember');

        // Coba login
        if (Auth::attempt($credentials, $remember)) {
            $user = Auth::user();

            // Pastikan yang login adalah admin
            if ($user->role !== 'admin') {
                Auth::logout();
                return back()->withErrors([
                    'email' => 'Akun ini tidak memiliki akses ke panel admin.',
                ]);
            }

            $request->session()->regenerate();

            return redirect('/admin/dashboard')
                ->with('success', 'Selamat datang, ' . $user->name . '!');
        }

        // Login gagal
        return back()
            ->withInput($request->only('email'))
            ->withErrors([
                'email' => 'Email atau password salah.',
            ]);
    }

    /**
     * Logout admin.
     */
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/admin/login')->with('success', 'Berhasil keluar dari panel admin.');
    }
}
