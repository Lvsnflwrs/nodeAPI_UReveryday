<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProdukController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\WishlistController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/', [AuthController::class, 'showLoginForm'])->name('login');
Route::get('/signup', [AuthController::class, 'showSignupForm'])->name('signup');
Route::get('/dashboard', [AuthController::class, 'showHalamanUtama'])->name('dashboard');
Route::get('/admin', [AuthController::class, 'showHalamanAdmin'])->name('admin');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
Route::post('/signup', [AuthController::class, 'signup']);

Route::get('/getProduk', [ProdukController::class, 'getProduk']);
Route::get('/getProdukExDesc', [ProdukController::class, 'getProdukExDesc']);
Route::get('/admin', function () {
    $response = Http::get('http://localhost:3000/api/produk/getProdukPending');
    $data = $response->ok() ? $response->json()['data'] : [];

    return view('admin', ['products' => $data]);
})->name('admin');
Route::post('/produk/update-status', [ProdukController::class, 'updateProduk'])->name('produk.status.update');
Route::post('/produk/deleteProduk', [ProdukController::class, 'deleteProduk'])->name('produk.status.reject');

Route::get('/getProduk/{kategori}', [ProdukController::class, 'getProdukbyCategory']);
Route::get('/getCategory', [ProdukController::class, 'getCategory']);
Route::get('/dashboard', [ProdukController::class, 'showDashboard'])->name('dashboard');
Route::get('/halamanProduk', [ProdukController::class, 'showHalamanProduk'])->name('halamanProduk');
Route::post('/addProduk', [ProdukController::class, 'addProduk']);
Route::get('/ShowAddProduk', [ProdukController::class, 'ShowAddProduk'])->name('ShowAddProduk');

Route::get('/ShowWishlistPage', [WishlistController::class, 'ShowWishlistPage'])->name('ShowWishlistPage');
Route::get('/Showwishlist', [WishlistController::class, 'showWishlist'])->name('Wishlist');   
Route::post('/wishlist', [WishlistController::class, 'postWishlist'])->name('addWishlist');   
Route::delete('/wishlist/:id', [WishlistController::class, 'deleteWishlist'])->name('removeWishlist');   

Route::get('/search', [ProdukController::class, 'search'])->name('search.produk');
Route::post('/signup', [AuthController::class, 'signup']);

Route::get('/getUserLogin', [AuthController::class, 'me']);
Route::get('/profilePage', function () {
    return view('profilePage');
})->name('profilePage');
Route::post('/updateProfile', [UserController::class, 'updateProfile'])->name('updateProfile');
