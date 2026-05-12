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
        Schema::create('users', function (Blueprint $table) { 
            // Primary Key menggunakan id_user sesuai rencana
            $table->id('id_user'); 
            $table->string('nama');
            $table->string('email')->unique();
            $table->string('password');
            $table->enum('role', ['admin', 'customer', 'owner'])->default('customer');
            $table->enum('status_akun', ['aktif', 'nonaktif', 'pending'])->default('aktif');
            
            // Kolom tambahan untuk data Owner sesuai desain registrasi
            $table->string('no_hp')->nullable();
            $table->text('alamat')->nullable();
            $table->string('ktp_file')->nullable();
            
            $table->rememberToken();
            $table->timestamps();
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
