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
    // 1. Ganti get() jadi paginate(10) - angka 10 berarti 10 data per halaman
    $transaksi = Transaksi::with(['user', 'mobil'])->latest()->paginate(10);

    // 2. Lengkapi stats (tetap sama kayak sebelumnya)
    $stats = [
        'total'            => Transaksi::count(),
        'lunas'            => Transaksi::where('status', 'lunas')->count(),
        'pending'          => Transaksi::where('status', 'pending')->count(),
        'total_pendapatan' => Transaksi::where('status', 'lunas')->sum('total_harga') ?? 0,
        'hari_ini'         => Transaksi::whereDate('created_at', now()->today())->count(),
        'nilai_hari_ini'   => Transaksi::whereDate('created_at', now()->today())
                                        ->where('status', 'lunas')
                                        ->sum('total_harga') ?? 0,
        'bermasalah'       => Transaksi::where('status', 'bermasalah')->count(), 
    ];

    return view('admin.transaksi', compact('transaksi', 'stats'));
}
    // 3. Kirim ke view
 
}
