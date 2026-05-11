<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

// BARIS DI BAWAH INI DIHAPUS SAJA
// use Laravel\Sanctum\HasApiTokens; 

class User extends Authenticatable
{
    // Hapus HasApiTokens dari sini juga
    use HasFactory, Notifiable;

    protected $table = 'users';
    protected $primaryKey = 'id_user'; 
    public $incrementing = true;

    protected $fillable = [
        'nama', 'email', 'password', 'role', 'status_akun', 'no_hp', 'alamat', 'ktp_file',
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function mobils()
    {
        return $this->hasMany(Mobil::class, 'id_user', 'id_user');
    }

    public function transaksi() 
    {
        return $this->hasMany(Transaksi::class, 'id_user', 'id_user');
    }
}