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
            // Primary Key: id_mobil
            $table->id('id_mobil');

            /**
             * Foreign Key: id_user (Owner/Pemilik Mobil)
             * Menghubungkan ke kolom id_user di tabel users
             */
            $table->unsignedBigInteger('id_user');

            // Informasi Kendaraan
            $table->string('nama_mobil'); // Contoh: Toyota Avanza
            $table->string('brand');      // Contoh: Toyota, Honda
            $table->string('plat_nomor')->unique();
            $table->string('warna');
            $table->integer('tahun');
            $table->enum('transmisi', ['Manual', 'Otomatis']);
            $table->integer('kapasitas_penumpang');

            // Harga dan Deskripsi
            $table->integer('harga_sewa'); // Harga per hari
            $table->text('deskripsi')->nullable();
            
            // Status Mobil
            $table->enum('status', ['tersedia', 'disewa', 'maintenance'])->default('tersedia');

            $table->timestamps();

            /**
             * RELASI:
             * Jika user (owner) dihapus, maka data mobilnya juga ikut terhapus (onDelete cascade)
             */
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
