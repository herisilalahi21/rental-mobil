<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    protected $table = 'users';

    protected $primaryKey = 'id_user'; // 🔥 PENTING

    public $incrementing = true;
    protected $keyType = 'int';

    protected $fillable = [
        'nama',
        'email',
        'password',
        'role',
        'status_akun',
        'no_hp',
        'alamat',
        'ktp_file',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];
}