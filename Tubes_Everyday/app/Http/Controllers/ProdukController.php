<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use SebastianBergmann\CodeCoverage\Report\Html\Dashboard;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;

class ProdukController extends Controller {
    public function ShowAddProduk()
    {
        return view('tambahProduk');
    }

    public function addProduk(Request $request)
    {
        try {
            // Validasi input
            $request->validate([
                'img_path' => 'required|file|mimes:jpg,jpeg,png|max:2048',
                'nama_produk' => 'required|string|max:255',
                'harga_produk' => 'required|numeric|min:0',
                'stok' => 'required|integer|min:0',
                'kategori' => 'required|string',
                'sub_kategori' => 'required|string',
                'deskripsi' => 'required|string',
            ]);

            if ($request->hasFile('img_path')) {
                $file = $request->file('img_path');
                $slugifiedName = preg_replace('/[^a-z0-9]+/i', '-', strtolower($request->nama_produk));
                $filename = time() . '_' . $slugifiedName . '.' . $file->getClientOriginalExtension();
                $file->move(public_path('images/product'), $filename);
            } else {
                return response()->json(['message' => 'File gambar tidak valid atau tidak ada.'], 400);
            }

            // Ambil token dari session
            $token = session('token');
            if (!$token) {
                return response()->json(['message' => 'Token tidak ditemukan.'], 401);
            }

            // Siapkan data untuk dikirim ke Node.js
            $data = [
                'idPenjual' => session('user_id'), 
                'img_path' => $filename,  // Menyimpan path gambar
                'nama_produk' => $request->nama_produk,
                'harga_produk' => $request->harga_produk,
                'stok' => $request->stok,
                'kategori' => $request->kategori,
                'sub_kategori' => $request->sub_kategori,
                'deskripsi' => $request->deskripsi,
            ];

            // Log data yang akan dikirim
            Log::info("Data dikirim ke Node.js API: " . json_encode($data));

            // Kirim data ke API Node.js
            $response = Http::withToken($token)->post('http://localhost:3000/api/produk/addProduk', $data);

            // Log respons dari API
            Log::info("Respons dari Node.js API: " . $response->body());

            // Periksa respons API
            if ($response->successful()) {
                return redirect()->route('dashboard');
            } else {
                // Jika API gagal, log error dan tampilkan pesan kesalahan
                Log::error("API Node.js error: " . $response->body());
                return response()->json(['message' => 'Gagal menambahkan produk.', 'details' => $response->body()], $response->status());
            }
        } catch (\Exception $e) {
            // Tangani kesalahan yang terjadi dalam proses
            Log::error("Error: " . $e->getMessage());
            return response()->json(['message' => 'Terjadi kesalahan.'], 500);
        }
    }

    public function getProduk(Request $request)
    {
        $response = Http::get('http://localhost:3000/api/produk/getProduk');

        if ($response->ok()) {
            return $response->json();
        }

        return response()->json(['message' => 'Failed to fetch products'], 500);
    }

    public function getProdukExDesc(Request $request)
    {
        $response = Http::get('http://localhost:3000/api/produk/getProdukExDesc');

        if ($response->ok()) {
            return $response->json();
        }

        return response()->json(['message' => 'Failed to fetch products'], 500);
    }

    public function getProdukbyCategory(Request $request)
    {
        $response = http::get('http://localhost:3000/api/produk/getProduk/{$kategori}');

        if ($response->ok()) {
            return $response->json();
        }

        return response()->json(['message' => 'Failed to fetch products'], 500);
    }

    public function getProdukPending(Request $request)
    {
        $response = http::get('http://localhost:3000/api/produk/getProdukPending');

        if ($response->ok()) {
            $data = $response->json();
            return view('admin', ['products' => $data['data'] ?? []]);
        }

        return response()->json(['message' => 'Failed to fetch products'], 500);
    }

    public function getCategory(Request $request)
    {
        $response = Http::get('http://localhost:3000/api/produk/getCategory');

        if ($response->ok()) {
            return $response->json();
        }

        return response()->json(['message' => 'Failed to fetch kategori'], 500);
    }

    public function showDashboard()
    {
        return view('Dashboard');
    }

    public function showHalamanProduk(Request $request)
    {
        $productId = $request->query('id');

        if (!$productId) {
            return redirect()->route('dashboard')->withErrors('ID produk tidak ditemukan.');
        }

        $apiUrl = "http://localhost:3000/api/produk/getProdukById/{$productId}";
        $response = Http::get($apiUrl);

        if ($response->failed()) {
            return redirect()->route('dashboard')->withErrors('Gagal memuat detail produk.');
        }

        $product = $response->json()['data'][0] ?? null;

        if (!$product) {
            return redirect()->route('dashboard')->withErrors('Produk tidak ditemukan.');
        }
        
        return view('halamanProduk', compact('product'));
    }

    public function search(Request $request)
    {
        $query = $request->input('searchTerm');

        if (!$query) {
            return view('search', [
                'products' => [],
                'message' => 'Kata kunci tidak boleh kosong.',
                'searchTerm' => $query,
            ]);
        }

        try {
            // Panggil API Node.js
            $response = Http::get('http://localhost:3000/api/search/searchProduk', [
                'searchTerm' => $query,
            ]);

            if ($response->successful()) {
                Log::info('API Response:', $response->json());
                $data = $response->json();
                $products = $data['data'] ?? [];
                $message = 'Hasil pencarian untuk "' . $query . '"';
            } else {
                Log::warning('API Error: ' . $response->body());
                $products = [];
                $message = $response->json()['message'] ?? 'Gagal mengambil data dari API.';
            }
        } catch (\Exception $e) {
            Log::error('Exception: ' . $e->getMessage());
            $products = [];
            $message = 'Terjadi kesalahan saat menghubungi API: ' . $e->getMessage();
        }

        return view('search', [
            'products' => $products,
            'message' => $message,
            'searchTerm' => $query,
        ]);
    }
    public function updateProduk(Request $request)
    {
        $id = $request->input('id');
        $status = $request->input('status');

        // Panggil API untuk update status produk
        $response = Http::put("http://localhost:3000/api/produk/updateProduk/$id", [
            'status' => $status,
        ]);

        if ($response->successful()) {
            return redirect()->back()->with('success', 'Status produk berhasil diubah.');
        }

        return redirect()->back()->with('error', 'Gagal mengubah status produk.');
    }

    public function deleteProduk(Request $request)
    {
        $id = $request->input('id');

        $response = Http::delete("http://localhost:3000/api/produk/deleteProduk/$id");

        if ($response->successful()) {
            return redirect()->back()->with('success', 'Produk berhasil dihapus.');
        }

        return redirect()->back()->with('error', 'Gagal menghapus produk.');
    }


}
