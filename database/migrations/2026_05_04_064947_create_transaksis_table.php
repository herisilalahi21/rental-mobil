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
        Schema::create('transaksis', function (Blueprint $table) {
            // Kita kasih nama primary key-nya id_transaksi biar seragam
            $table->id('id_transaksi'); 

            // Foreign key ke tabel users (Customer yang nyewa)
            $table->unsignedBigInteger('id_user'); 
            
            // Kolom pendukung (Sesuaikan dengan kebutuhan rental lo)
            $table->unsignedBigInteger('id_mobil'); // Jangan lupa nyambung ke mobil mana
            $table->date('tgl_mulai');
            $table->date('tgl_selesai');
            $table->integer('total_harga');
            
            // Kita pakai enum biar statusnya nggak ngasal inputnya
            $table->enum('status', ['pending', 'dibayar', 'berjalan', 'selesai', 'dibatalkan'])
                  ->default('pending');

            $table->timestamps();

            // RELASI KERAMAT: Biar SQL nggak error pas ngetotal transaksi user
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
        Schema::dropIfExists('transaksis');
    }
};
