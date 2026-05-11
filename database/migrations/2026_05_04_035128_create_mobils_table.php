<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Mobil;
use App\Models\Booking;

class DashboardController extends Controller
{
    public function index()
    {
        // Ambil ID user yang login (ini nilainya dari kolom id_user di tabel users)
        $userId = Auth::id();

        // 1. Ganti 'user_id' jadi 'id_user' sesuai migration lo
        $totalMobil = Mobil::where('id_user', $userId)->count();

        // 2. Query Booking (Pastikan kolom di tabel booking juga sinkron)
        $totalBooking = Booking::whereHas('mobil', function ($query) use ($userId) {
            $query->where('id_user', $userId);
        })->where('status', 'pending')->count();

        // 3. Total Pendapatan
        $pendapatan = Booking::whereHas('mobil', function ($query) use ($userId) {
            $query->where('id_user', $userId);
        })
        ->where('status', 'selesai')
        ->whereMonth('created_at', date('m'))
        ->sum('total_harga');

        // 4. List Booking Terbaru
        $bookings = Booking::with(['user', 'mobil'])
            ->whereHas('mobil', function ($query) use ($userId) {
                $query->where('id_user', $userId);
            })
            ->where('status', 'pending')
            ->latest()
            ->take(5)
            ->get();

        return view('owner.dashboard', compact('totalMobil', 'totalBooking', 'pendapatan', 'bookings'));
    }
}