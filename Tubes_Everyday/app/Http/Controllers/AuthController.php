<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    // Menampilkan form login
    public function showLoginForm()
    {
        return view('auth.login');
    }


    // Menampilkan form signup
    public function showSignupForm()
    {
        return view('auth.signup');
    }

    // Menampilkan form Halaman Utama
    public function showHalamanUtama()
    {
        return view('dashboard');
    }

    public function showHalamanAdmin()
    {
        return view('admin');
    }
    
    // Proses login
    public function login(Request $request)
    {
        $validated = $request->validate([
            'username' => 'required_without:username|string|max:255',
            'password' => 'required',
        ]);

        try {
            $response = Http::post('http://localhost:3000/api/auth/loginAdmin', [
                'username' => $request->username,
                'password' => $request->password,
            ]);
            $body = json_decode($response->getBody(), true);
            $token = $body['token'];

            session(
                ['token' => $token]);

            if ($response->successful()) {
                return redirect()->route('admin');
            }

            return back()->withErrors(['message' => 'Username atau password salah.']);
        } catch (\Exception $e) {
            return back()->withErrors(['message' => 'Tidak dapat menghubungi server Node.js.']);
        }
    }

    // Proses signup
    public function signup(Request $request)
    {
        // Validasi input
        $validated = $request->validate([
            'username' => 'required|string|max:255|unique:users', // Menambahkan validasi untuk username
            'email' => 'required|email',
            'password' => 'required|min:8',
            'nomorWA' => 'required|string' // Password confirmation sudah otomatis ada dari form
        ]);

        // Mengirim data signup ke API Node.js
        try {
            $response = Http::post('http://localhost:3000/api/auth/signup', [
                'username' => $request->username, // Pastikan username disertakan
                'email' => $request->email,
                'password' => $request->password,
                'nomorWA' => $request->nomorWA
            ]);

            // Periksa jika signup berhasil
            if ($response->successful()) {
                // Jika signup berhasil, redirect ke login
                return redirect()->route('login')->with('status', 'Signup berhasil! Silakan login.');
            }

            // Jika signup gagal, kembali dengan error
            return back()->withErrors(['message' => 'Signup gagal. Silakan coba lagi.']);
        } catch (\Exception $e) {
            // Jika terjadi kesalahan koneksi, beri respons error
            return back()->withErrors(['message' => 'Tidak dapat menghubungi server Node.js.']);
        }
    }

    public function me()
    {
        $token = session('token');

        if (!$token) {
            return back()->withErrors(['message' => 'Token tidak ditemukan, silakan login ulang.']);
        }

        try {
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $token,
            ])->get('http://localhost:3000/api/auth/me');
            if ($response->successful()) {

                return $response->json();
            }

            return back()->withErrors(['message' => 'Gagal mengambil data dari API.']);
        } catch (\Exception $e) {
            return back()->withErrors(['message' => 'Terjadi kesalahan saat mengakses API.']);
        }
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        if ($request->expectsJson()) {
            return response()->json(['success' => true]);
        }
        return redirect()->route('login');
    }
}

