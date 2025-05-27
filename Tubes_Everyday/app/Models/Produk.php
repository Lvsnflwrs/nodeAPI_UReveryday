<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Produk extends Model
{
    use HasFactory;

    protected $table = 'Produk';

    protected $fillable = [
        'idPenjual',
        'img_path',
        'nama_produk',
        'harga_produk',
        'stok',
        'kategori',
        'sub_kategori',
        'deskripsi'
    ];

    public function penjual()
    {
        return $this->belongsTo(User::class, 'idPenjual');
    }

    public function wishlists()
    {
        return $this->hasMany(Wishlist::class, 'product_id', 'id');
    }

}