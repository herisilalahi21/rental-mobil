<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Mobil extends Model
{
    // SESUAI SQL: Tabel lo namanya armada_mobils
    protected $table = 'armada_mobils';
    
    // SESUAI SQL: Primary Key lo adalah 'id'
    protected $primaryKey = 'id';

    protected $fillable = [
        'user_id', 
        'nama_mobil', 
        'plat_nomor', 
        'kategori', 
        'transmisi', 
        'tahun', 
        'harga_per_hari', 
        'deskripsi', 
        'fitur', 
        'foto', 
        'status'
    ];

    protected $casts = [
        'fitur' => 'array', // Karena di SQL tipe datanya TEXT
    ];

    public function owner()
    {
        // Relasi ke users (id_user)
        return $this->belongsTo(User::class, 'user_id', 'id_user');
    }



    /**
     * Galeri mobil
     */
    public function galeri()
    {
        return $this->hasMany(GaleriMobil::class, 'id_mobil', 'id');
    }

    /**
     * Transaksi
     */
    public function transaksis()
    {
        return $this->hasMany(Transaksi::class, 'id_mobil', 'id');
    }

}
