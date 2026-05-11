<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('mobils', function (Blueprint $table) {
            // Gunakan id_mobil sebagai primary key biar rapi
            $table->id('id_mobil');
            
            // KOLOM KRUSIAL: Ini yang dicari Laravel tadi
            $table->unsignedBigInteger('id_user'); 
            
            // Data Mobil
            $table->string('nama_mobil');
            $table->string('brand');
            $table->string('plat_nomor')->unique();
            $table->integer('harga_sewa');
            $table->enum('status', ['tersedia', 'disewa', 'maintenance'])->default('tersedia');
            $table->timestamps();

            // Relasi ke tabel users
            $table->foreign('id_user')
                  ->references('id_user')
                  ->on('users')
                  ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mobils');
    }
};