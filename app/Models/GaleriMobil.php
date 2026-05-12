<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GaleriMobil extends Model
{
    use HasFactory;

    // Nama tabel di database
    protected $table = 'galeri_mobils';

    // PENTING: Tambahin id_mobil di sini biar bisa simpan banyak data sekaligus
    protected $fillable = [
        'id_mobil', 
        'foto'
    ];

    // Relasi balik ke Armada (Opsional tapi bagus buat ada)
    public function armada()
    {
        return $this->belongsTo(Armada::class, 'id_mobil', 'id_mobil');
    }
}
