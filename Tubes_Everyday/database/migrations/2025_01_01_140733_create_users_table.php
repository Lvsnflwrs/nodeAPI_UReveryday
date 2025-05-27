<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
public function up()
{
    Schema::create('users', function (Blueprint $table) {
        $table->id();
        $table->string('nama_depan');
        $table->string('nama_belakang');
        $table->string('no_telpon');
        $table->text('alamat');
        $table->string('username')->unique();
        $table->string('email')->unique();
        $table->string('password');
        $table->string('img_path')->nullable(); // atau profilePic sebelumnya
        $table->timestamps(); // untuk created_at dan updated_at
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
