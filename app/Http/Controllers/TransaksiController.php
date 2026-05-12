<?php

namespace App\Http\Controllers;

use App\Models\Transaksi;
use App\Models\Mobil;
use App\Models\User;
use Illuminate\Http\Request;

class TransaksiController extends Controller
{
    public function index()
    {
        // 1. Ambil data transaksi beserta relasi user dan mobil
        // Pastikan di Model Transaksi relasinya sudah menggunakan foreign key yang benar
        $transaksi = Transaksi::with(['user', 'mobil'])->latest()->paginate(10);

        // 2. Statistik
        // Di sini biasanya tidak ada masalah kolom selama lo tidak melakukan filter whereHas
        $stats = [
            'total'            => Transaksi::count(),
            'lunas'            => Transaksi::where('status', 'lunas')->count(),
            'pending'          => Transaksi::where('status', 'pending')->count(),
            'total_pendapatan' => Transaksi::where('status', 'lunas')->sum('total_harga') ?? 0,
            'hari_ini'         => Transaksi::whereDate('created_at', now())->count(),
            'nilai_hari_ini'   => Transaksi::whereDate('created_at', now())
                                            ->where('status', 'lunas')
                                            ->sum('total_harga') ?? 0,
            'bermasalah'       => Transaksi::where('status', 'bermasalah')->count(), 
        ];

        return view('admin.transaksi', compact('transaksi', 'stats'));
    }
}