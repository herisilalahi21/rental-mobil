<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Transaksi extends Model
{
    use HasFactory;

    // 1. Nama tabel di database
    protected $table = 'transaksis';

    // 2. Primary Key kustom (Sesuai migration: id_transaksi)
    protected $primaryKey = 'id_transaksi'; 

    // 3. Set agar Laravel tahu PK ini auto-increment
    public $incrementing = true;
    protected $keyType = 'int';

    // 4. Kolom yang boleh diisi (Mass Assignment)
    protected $fillable = [
        'id_user',
        'id_mobil',
        'tgl_mulai',    // Sesuaikan dengan migration
        'tgl_selesai',  // Sesuaikan dengan migration
        'durasi',
        'total_harga',
        'status',
        'metode_pembayaran',
    ];

    /**
     * Relasi: Transaksi ini milik User siapa?
     */
    public function user(): BelongsTo
    {
        // 'id_user' pertama adalah foreign key di tabel transaksis
        // 'id_user' kedua adalah primary key di tabel users
        return $this->belongsTo(User::class, 'id_user', 'id_user');
    }

    /**
     * Relasi: Transaksi ini untuk Mobil yang mana?
     */
    public function mobil(): BelongsTo
    {
        // 'id_mobil' pertama adalah foreign key di tabel transaksis
        // 'id_mobil' kedua adalah primary key di tabel mobils
        return $this->belongsTo(Mobil::class, 'id_mobil', 'id_mobil');
    }
}