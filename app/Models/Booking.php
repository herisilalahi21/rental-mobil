<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory;

    protected $table = 'bookings'; // Pastikan nama tabel di DB jamak atau tunggal (cek phpMyAdmin)
    protected $primaryKey = 'id_booking';

    protected $fillable = [
        'id_user',
        'id_mobil',
        'tanggal_mulai',
        'tanggal_selesai',
        'total_harga',
        'status_booking'
    ];

    // Relasi: Booking ini milik siapa (Customer)
    public function user()
    {
        return $this->belongsTo(User::class, 'id_user', 'id_user');
    }

    // Relasi: Booking ini untuk mobil apa
    public function mobil()
    {
        return $this->belongsTo(Mobil::class, 'id_mobil', 'id_mobil');
    }
}