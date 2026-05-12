<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Mobil;
use App\Models\Transaksi;
use Illuminate\Http\Request;
use Carbon\Carbon;

class AdminController extends Controller
{
    /**
     * Dashboard Utama Admin
     */
    public function index()
    {
        // Statistik User
        $jumlahUser  = User::where('role', 'customer')->count();
        $jumlahOwner = User::where('role', 'owner')->count();

        // Statistik Mobil
        $jumlahMobil = Mobil::count();

        // 🔥 FIX: status sesuai database (HANYA "selesai")
        $totalPendapatan = Transaksi::where('status', 'selesai')
            ->sum('total_harga') ?? 0;

        $ownerPendingCount = User::where('role', 'owner')
            ->where('status_akun', 'pending')
            ->count();

        // Aktivitas terbaru
        $aktivitasTerbaru = Transaksi::with([
                'user:id_user,nama,email'
            ])
            ->latest()
            ->take(5)
            ->get();

        // Grafik 12 bulan
        $pendapatanBulanan = [];
        $labelBulan = [];

        for ($i = 11; $i >= 0; $i--) {
            $bulan = Carbon::now()->subMonths($i);

            $total = Transaksi::where('status', 'selesai')
                ->whereYear('created_at', $bulan->year)
                ->whereMonth('created_at', $bulan->month)
                ->sum('total_harga');

            $pendapatanBulanan[] = (int) $total;
            $labelBulan[] = $bulan->format('M');
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
     * Kelola Data User
     */
    public function dataUser(Request $request)
    {
        $query = User::where('role', '!=', 'admin');

        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('nama', 'like', "%{$request->search}%")
                  ->orWhere('email', 'like', "%{$request->search}%");
            });
        }

        if ($request->filled('role')) {
            $query->where('role', $request->role);
        }

        if ($request->filled('status')) {
            $query->where('status_akun', $request->status);
        }

        $users = $query->latest()->paginate(10);

        $stats = [
            'total'    => User::where('role', '!=', 'admin')->count(),
            'aktif'    => User::where('status_akun', 'aktif')->count(),
            'owner'    => User::where('role', 'owner')->count(),
            'pending'  => User::where('role', 'owner')->where('status_akun', 'pending')->count(),
            'nonAktif' => User::whereIn('status_akun', ['nonaktif', 'suspend'])->count(),
        ];

        return view('admin.user_data', compact('users', 'stats'));
    }

    /**
     * Detail user
     */
    public function userDetail($id)
    {
        $user = User::where('id_user', $id)->firstOrFail();
        return view('admin.user_detail', compact('user'));
    }

    /**
     * Update user
     */
    public function userUpdate(Request $request, $id)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'status_akun' => 'required|in:aktif,suspend,nonaktif,pending',
        ]);

        $user = User::where('id_user', $id)->firstOrFail();

        $user->update([
            'nama'        => $request->nama,
            'status_akun' => $request->status_akun,
            'role'        => $request->role,
            'no_hp'       => $request->no_hp,
            'alamat'      => $request->alamat,
        ]);

        return redirect()
            ->route('admin.users')
            ->with('success', 'User berhasil diperbarui!');
    }

    /**
     * Kelola Mobil
     */
    public function manageMobil()
    {
        $mobil = Mobil::with('owner')->latest()->paginate(10);

        $stats = [
            'total'      => Mobil::count(),
            'tersedia'   => Mobil::where('status', 'tersedia')->count(),
            'disewa'     => Mobil::where('status', 'disewa')->count(),
            'maintenance'=> Mobil::where('status', 'maintenance')->count(),
        ];

        return view('admin.data_mobil', compact('mobil', 'stats'));
    }

    /**
     * Export CSV
     */
    public function exportUser()
    {
        $fileName = 'Laporan_User_' . now()->format('Ymd_His') . '.csv';
        $users = User::where('role', '!=', 'admin')->get();

        $headers = [
            "Content-type" => "text/csv",
            "Content-Disposition" => "attachment; filename=$fileName",
        ];

        $callback = function () use ($users) {
            $file = fopen('php://output', 'w');

            fputcsv($file, ['ID', 'Nama', 'Email', 'Role', 'Status', 'Tanggal']);

            foreach ($users as $user) {
                fputcsv($file, [
                    $user->id_user,
                    $user->nama,
                    $user->email,
                    $user->role,
                    $user->status_akun,
                    $user->created_at?->format('d/m/Y'),
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}