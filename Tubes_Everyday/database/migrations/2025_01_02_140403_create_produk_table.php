<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('produk', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('idPenjual');
            $table->string('img_path');
            $table->string('nama_produk');
            $table->integer('harga_produk');
            $table->integer('stok');
            $table->string('kategori');
            $table->string('sub_kategori');
            $table->string('deskripsi');
            $table->enum('status', ['accepted', 'pending', 'rejected'])->default('pending');
            $table->timestamps();
            
            $table->foreign('idPenjual')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('produk');
    }
};
