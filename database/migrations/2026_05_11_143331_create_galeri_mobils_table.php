<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    
  
    public function up()
{
    Schema::create('galeri_mobils', function (Blueprint $table) {
        $table->id();
        $table->foreignId('id_mobil')->constrained('armada_mobils')->onDelete('cascade');
        $table->string('foto');
        $table->timestamps();
    });
}
      
     
    public function down(): void
    {
        Schema::dropIfExists('galeri_mobils');
    }
};
