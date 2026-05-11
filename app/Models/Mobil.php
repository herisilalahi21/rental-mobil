<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mobil extends Model
{
    use HasFactory;

    protected $table = 'mobils';
    protected $primaryKey = 'id_mobil'; // Sesuai migration lo
    public $incrementing = true;

    protected $fillable = [
        'id_user', 'nama_mobil', 'brand', 'plat_nomor', 'harga_sewa', 'status'
    ];

    // Relasi balik ke Owner
    public function user()
    {
        return $this->belongsTo(User::class, 'id_user', 'id_user');
    }

    // Di dalam app/Models/Mobil.php, ubah bagian relasi user
public function owner()
{
    // FK adalah id_owner yang merujuk ke id_user di tabel users
    return $this->belongsTo(User::class, 'id_owner', 'id_user');
}
}

