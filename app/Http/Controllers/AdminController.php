<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Mobil;
use App\Models\Transaksi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class AdminController extends Controller
{
    /**
     * Dashboard Utama Admin
     */
    public function index()
    {
        // Proteksi Role
        if (!Auth::check() || Auth::user()->role !== 'admin') {
            return redirect('/')->with('error', 'Akses ditolak!');
        }

        // 1. Statistik Cards
        $jumlahUser = User::where('role', 'customer')->count();
        $jumlahOwner = User::where('role', 'owner')->count();
        $jumlahMobil = Mobil::count();
        
        // Menghitung total pendapatan dari transaksi yang sukses/selesai
        $totalPendapatan = Transaksi::whereIn('status', ['selesai', 'berhasil'])->sum('total_harga');
        
        // Menghitung owner yang butuh verifikasi
        $ownerPendingCount = User::where('role', 'owner')
                                 ->where('status_akun', 'pending')
                                 ->count();

        // 2. Aktivitas Terbaru (Ambil 5 transaksi terakhir beserta data usernya)
        $aktivitasTerbaru = Transaksi::with('user')
                                     ->latest()
                                     ->take(5)
                                     ->get();

        // 3. Logika Grafik Pendapatan (12 Bulan Terakhir)
        $pendapatanBulanan = [];
        $labelBulan = [];

        for ($i = 11; $i >= 0; $i--) {
            $bulan = Carbon::now()->subMonths($i);
            
            $total = Transaksi::whereIn('status', ['selesai', 'berhasil'])
                              ->whereYear('created_at', $bulan->year)
                              ->whereMonth('created_at', $bulan->month)
                              ->sum('total_harga');

            $pendapatanBulanan[] = (int) $total;
            $labelBulan[] = $bulan->format('M'); // Contoh: Jan, Feb, Mar
        }

        return view('admin.dashboard', compact(
            'jumlahUser', 
            'jumlahOwner', 
            'jumlahMobil', 
            'totalPendapatan',
            'ownerPendingCount', 
            'aktivitasTerbaru', 
            'pendapatanBulanan',
            'labelBulan'
        ));
    }

    /**
     * Halaman Kelola Data User
     */
    public function dataUser(Request $request)
    {
        $query = User::where('role', '!=', 'admin');

        // Filter Pencarian
        if ($request->filled('search')) {
            $query->where(function($q) use ($request) {
                $q->where('nama', 'like', '%' . $request->search . '%')
                  ->orWhere('email', 'like', '%' . $request->search . '%');
            });
        }

        // Filter Role & Status
        if ($request->filled('role')) { $query->where('role', $request->role); }
        if ($request->filled('status')) { $query->where('status_akun', $request->status); }

        $users = $query->latest()
                       ->paginate(10)
                       ->appends($request->only(['search', 'role', 'status']));

        // Statistik untuk Halaman User Data
        $totalUser = User::whereIn('role', ['customer', 'owner'])->count();
        $userAktif = User::whereIn('role', ['customer', 'owner'])->where('status_akun', 'aktif')->count();
        $roleOwner = User::where('role', 'owner')->count();
        $nonAktif  = User::whereIn('role', ['customer', 'owner'])
                         ->whereIn('status_akun', ['nonaktif', 'suspend'])
                         ->count();

        $ownerPendingCount = User::where('role', 'owner')
                                 ->where('status_akun', 'pending')
                                 ->count();

        return view('admin.user_data', compact(
            'users', 'totalUser', 'userAktif', 'roleOwner', 
            'nonAktif', 'ownerPendingCount'
        ));
    }

    /**
     * Detail User
     */
    public function showUser($id)
    {
        // Mengasumsikan di Model User sudah ada function transaksi() dan mobils()
        $user = User::withCount(['transaksi', 'mobils'])->findOrFail($id);
        return view('admin.user_detail', compact('user'));
    }

    /**
     * Update Status User
     */
    public function updateUser(Request $request, $id)
    {
        $request->validate([
            'status_akun' => 'required|in:aktif,suspend,nonaktif',
        ]);

        $user = User::findOrFail($id);
        $user->status_akun = $request->status_akun;
        $user->save();

        return redirect()->route('admin.users')->with('success', 'Status akun ' . $user->nama . ' berhasil diperbarui!');
    }
      //data mobil//
   public function manageMobil()
{
    // 1. Ambil data mobil beserta relasi ownernya
    $mobil = Mobil::with('owner')->paginate(10); 
    
    // 2. Hitung statistik sesuai kategori di dashboard
    $stats = [
        'total'      => Mobil::count(),
        'tersedia'   => Mobil::where('status', 'tersedia')->count(),
        'disewa'     => Mobil::where('status', 'disewa')->count(),
        'bermasalah' => Mobil::where('status', 'bermasalah')->count(),
    ];

    // 3. Kirim ke view (Pastikan file ada di resources/views/admin/data_mobil/index.blade.php)
    return view('admin.data_mobil', compact('mobil', 'stats'));
}


public function showMobil($id_mobil)
{
    // Mengambil data mobil beserta relasinya
    $mobil = Mobil::with(['owner', 'transaksi'])->where('id_mobil', $id_mobil)->firstOrFail();
    
    // Kirim ke view detail_mobil.blade.php
    return view('admin.detail_mobil', compact('mobil'));
}

    /**
     * Export User ke CSV
     */
    public function exportUser(Request $request) 
    {
        $fileName = 'Data_User_RentaCar_' . date('Ymd_His') . '.csv';
        $users = User::where('role', '!=', 'admin')->get();

        $headers = [
            "Content-type"        => "text/csv",
            "Content-Disposition" => "attachment; filename=$fileName",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0"
        ];

        $columns = ['ID User', 'Nama', 'Email', 'Role', 'Status Akun', 'Tanggal Bergabung'];

        $callback = function() use($users, $columns) {
            $file = fopen('php://output', 'w');
            fputs($file, (chr(0xEF) . chr(0xBB) . chr(0xBF))); // BOM untuk Excel
            fputcsv($file, $columns);
            
            foreach ($users as $user) {
                fputcsv($file, [
                    'USR-' . str_pad($user->id_user ?? $user->id, 5, '0', STR_PAD_LEFT), 
                    $user->nama, 
                    $user->email, 
                    ucfirst($user->role), 
                    ucfirst($user->status_akun), 
                    $user->created_at->format('d-m-Y H:i')
                ]);
            }
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}