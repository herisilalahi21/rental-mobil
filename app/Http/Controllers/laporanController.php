<?php

namespace App\Http\Controllers;

// Import Model yang dibutuhkan
use App\Models\Transaksi;
use App\Models\User;
use App\Models\Mobil;
use Illuminate\Http\Request;

class LaporanController extends Controller
{
    public function index()
    {
        // 1. Ambil Statistik Utama
        $totalTransaksi = Transaksi::where('status', 'lunas')->count();
        $totalPendapatan = Transaksi::where('status', 'lunas')->sum('total_harga') ?? 0;
        $userBaru = User::where('role', 'user')->count();

        // 2. Ambil Data Mobil Terlaris (Top 6)
        $mobilTerlaris = Mobil::withCount(['transaksi as jumlah_sewa' => function($query) {
                $query->where('status', 'lunas');
            }])
            ->withSum(['transaksi as total_pendapatan' => function($query) {
                $query->where('status', 'lunas');
            }], 'total_harga')
            ->orderBy('jumlah_sewa', 'desc')
            ->take(6)
            ->get();

        // 3. Oper ke View
        return view('admin.laporan', compact(
            'totalTransaksi', 
            'totalPendapatan', 
            'userBaru', 
            'mobilTerlaris'
        ));
    }
}
