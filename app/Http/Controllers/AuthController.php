<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
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
