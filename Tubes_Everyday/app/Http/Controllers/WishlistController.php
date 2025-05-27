<?php

namespace App\Http\Controllers;
use App\Models\Wishlist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class WishlistController extends Controller
{
    public function ShowWishlistPage()
    {
        $response = Http::get('http://localhost:3000/api/wishlist/getWishlistByUser', [
            // 'user_id' => auth()->id(),
        ]);
    
        if ($response->ok()) {
            $wishlists = $response->json()['data']; 
            return view('wishlist', compact('wishlists'));
        }
    
        return view('wishlist')->with('wishlists', []); 
    }
    // public function showWishlist()
    // {
    //     $response = Http::get('http://localhost:3000/api/wishlist/getWishlist', [
    //         'user_id' => auth()->id(),
    //     ]);

    //     if ($response->ok()) {
    //         $wishlists = $response->json()['data']; 
    //         return view('wishlist', compact('wishlists'));
    //     }
    
    //     return back()->withErrors(['message' => 'Failed to fetch wishlist', 'error' => $response->body()]);
    // }

    public function postWishlist(Request $request)
    {
        $token = session('token');
        Log::info("Token yang digunakan: " . $token);
        if (!$token) {
            return response()->json(['message' => 'Token tidak ditemukan.'], 401);
        }

        $request->validate([
            'product_id' => 'required|exists:Produk,id',
        ]);

        $response = Http::post('http://localhost:3000/api/wishlist/addWishlist', [
            'user_id' => session('user_id'), 
            'product_id' => $request->product_id,
        ]);

        if ($response->ok()) {
            return response()->json($response->json());
        }

        return response()->json(['message' => 'Failed to add product to wishlist', 'error' => $response->body()], 500);
    }

    public function deleteWishlist(Request $request)
    {
        $id = $request->input('id');
    
        $response = Http::delete("http://localhost:3000/api/wishlist/removeWishlist/$id");
    
        if ($response->ok()) {
            return response()->json(['success' => true, 'message' => 'Wishlist item removed successfully']);
        }
    
        return response()->json(['message' => 'Failed to delete wishlist item', 'error' => $response->body()], 500);
    }
    
}