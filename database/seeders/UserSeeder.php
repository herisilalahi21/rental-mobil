<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'nama'        => 'Super Admin RentaCar',
            'email'       => 'admin@gmail.com',
            'password'    => Hash::make('admin123'), // Ganti sesuai keinginan
            'role'        => 'admin',
            'status_akun' => 'aktif',
            'no_hp'       => '08123456789',
            'alamat'      => 'Kantor Pusat RentaCar',
        ]);
    }
}
