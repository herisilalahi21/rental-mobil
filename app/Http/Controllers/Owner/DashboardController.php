<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Mobil;
use App\Models\Booking; // Atau model Transaksi, sesuaikan namanya

class DashboardController extends Controller
{
   public function index()
{
    $userId = Auth::id();

    // 1. Hitung mobil berdasarkan id_owner
    $totalMobil = Mobil::where('id_owner', $userId)->count();

    // 2. Hitung booking pending berdasarkan id_owner di tabel mobil
    $totalBooking = Booking::whereHas('mobil', function ($query) use ($userId) {
        $query->where('id_owner', $userId);
    })->where('status_booking', 'pending')->count(); // Sesuaikan 'pending' dengan isi DB lo

    // 3. Pendapatan
    $pendapatan = Booking::whereHas('mobil', function ($query) use ($userId) {
        $query->where('id_owner', $userId);
    })
    ->where('status_booking', 'selesai') // Sesuaikan statusnya
    ->sum('total_harga');

    // 4. List Booking Terbaru
    $bookings = Booking::with(['user', 'mobil'])
        ->whereHas('mobil', function ($query) use ($userId) {
            $query->where('id_owner', $userId);
        })
        ->latest()
        ->take(5)
        ->get();

    return view('owner.dashboard', compact('totalMobil', 'totalBooking', 'pendapatan', 'bookings'));
}
}