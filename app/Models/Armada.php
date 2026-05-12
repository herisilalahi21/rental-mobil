<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mobil extends Model
{
    use HasFactory;

    /**
     * Nama tabel
     */
    protected $table = 'armada_mobils';

    /**
     * Primary key
     */
    protected $primaryKey = 'id';

    /**
     * Auto increment
     */
    public $incrementing = true;

    /**
     * Type PK
     */
    protected $keyType = 'int';

    /**
     * Kolom yang boleh diisi
     */
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

    /**
     * Cast array fitur
     */
    protected $casts = [
        'fitur' => 'array',
    ];

    /**
     * Relasi owner
     */
    public function owner()
    {
        return $this->belongsTo(User::class, 'user_id', 'id_user');
    }

    /**
     * Relasi galeri
     */
    public function galeri()
    {
        return $this->hasMany(GaleriMobil::class, 'id_mobil', 'id');
    }

    /**
     * Relasi transaksi
     */
    public function transaksis()
    {
        return $this->hasMany(Transaksi::class, 'id_mobil', 'id');
    }
}
