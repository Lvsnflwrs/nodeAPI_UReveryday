<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class UserController extends Controller
{
    public function updateProfile(Request $request)
    {
        $request->validate([
            'nama_depan' => 'required|string|max:255',
            'nama_belakang' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'no_telpon' => 'required|string|max:15',
            'alamat' => 'required|string',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $data = $request->only(['nama_depan', 'nama_belakang', 'email', 'no_telpon', 'alamat']);
        $file = $request->file('foto');

        try {
            $token = session('token');
            
            if (!$token) {
                return redirect()->back()->with('error', 'Token autentikasi tidak ditemukan.');
            }

            if ($file) {
                $response = Http::withHeaders([
                    'Authorization' => 'Bearer ' . $token,
                    'Accept' => 'application/json'
                ])->attach(
                    'foto',
                    file_get_contents($file->getPathname()),
                    $file->getClientOriginalName()
                )->put('http://localhost:3000/api/users/updateProfile', $data);
            } else {
                $response = Http::withHeaders([
                    'Authorization' => 'Bearer ' . $token,
                    'Accept' => 'application/json'
                ])->put('http://localhost:3000/api/users/updateProfile', $data);
            }
            
            

            if ($response->successful()) {
                return redirect()->back()->with('success', 'Profile berhasil diperbarui.');
            } else {
                return redirect()->back()->with('error', 'Gagal memperbarui profile. ' . ($response->json()['message'] ?? ''));
            }
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
}