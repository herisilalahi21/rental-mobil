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
        Schema::create('bookings', function (Blueprint $table) {
            // PK menggunakan id_booking sesuai keinginan lo
            $table->id('id_booking');
            
            // FK ke tabel USER (Penyewa/Customer)
            $table->unsignedBigInteger('id_user');
            
            // FK ke tabel MOBIL
            $table->unsignedBigInteger('id_mobil');
            
            // Data Transaksi
            $table->date('tanggal_mulai');
            $table->date('tanggal_selesai');
            $table->integer('total_harga');
            $table->enum('status_booking', ['pending', 'dikonfirmasi', 'selesai', 'dibatalkan'])->default('pending');
            
            $table->timestamps();

            // Definisi Foreign Key
            $table->foreign('id_user')
                  ->references('id_user')
                  ->on('users')
                  ->onDelete('cascade');

            $table->foreign('id_mobil')
                  ->references('id_mobil')
                  ->on('mobils')
                  ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bookings');
    }
};
