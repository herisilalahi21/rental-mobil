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
    Schema::create('armada_mobils', function (Blueprint $table) {
        // Ganti baris ini Boy!
        $table->id('id_mobil'); 

        $table->foreignId('user_id')
              ->constrained('users', 'id_user')
              ->onDelete('cascade');


        $table->string('nama_mobil');
        $table->string('plat_nomor')->unique();
        $table->string('kategori');
        $table->string('transmisi');
        $table->integer('tahun');
        $table->bigInteger('harga_per_hari');
        $table->text('deskripsi')->nullable();
        $table->text('fitur')->nullable();
        $table->string('foto')->nullable();
        $table->string('status')->default('tersedia');
        
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Menghapus tabel jika migration ditarik mundur (rollback)
        Schema::dropIfExists('armada_mobils');
    }
};