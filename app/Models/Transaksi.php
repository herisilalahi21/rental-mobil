<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
    use HasFactory;

    protected $table = 'transaksis';

    protected $primaryKey = 'id';

    protected $fillable = [
        'id_user',
        'id_mobil',
        'tgl_mulai',
        'tgl_selesai',
        'durasi',
        'total_harga',
        'status',
        'metode_pembayaran',
    ];

    /**
     * Relasi user
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'id_user', 'id_user');
    }

    /**
     * Relasi mobil
     */
    public function mobil()
    {
        return $this->belongsTo(Mobil::class, 'id_mobil', 'id');
    }
}