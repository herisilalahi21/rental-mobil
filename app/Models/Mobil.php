<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Mobil extends Model
{
    use HasFactory;

    // 1. Nama Tabel
    protected $table = 'mobils';

    // 2. Definisi Primary Key Kustom
    protected $primaryKey = 'id_mobil'; 

    // PENTING: Karena PK bukan 'id', kasih tau Laravel kalau ini auto-incrementing
    public $incrementing = true;
    protected $keyType = 'int';

    // 3. Mass Assignment
    protected $fillable = [
        'id_user',      // Ini FK ke Owner (User)
        'nama_mobil', 
        'brand', 
        'plat_nomor', 
        'harga_sewa', 
        'status'
    ];

    /**
     * Relasi ke Transaksi
     * Satu mobil bisa memiliki banyak catatan transaksi
     */
    public function transaksi(): HasMany
    {
        // Parameter 2: Foreign Key di tabel 'transaksis'
        // Parameter 3: Local Key di tabel 'mobils'
        return $this->hasMany(Transaksi::class, 'id_mobil', 'id_mobil');
    }

    /**
     * Relasi ke User (Owner Mobil)
     * Mobil ini dimiliki oleh siapa?
     */
    public function user(): BelongsTo
    {
        // Berdasarkan gambar lo, id_user adalah FK yang merujuk ke tabel users
        return $this->belongsTo(User::class, 'id_user', 'id_user');
    }
}

