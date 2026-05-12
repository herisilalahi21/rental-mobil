<?php

namespace App\Http\Controllers;

use App\Models\Mobil;
use Illuminate\Http\Request;

class AdminArmadaController extends Controller
{
    public function index(Request $request)
    {
        // Pakai 'transaksis' sesuai nama fungsi di Model Mobil
        $query = Mobil::with('owner')->withCount('transaksis');

        // Search berdasarkan kolom yang ada di model: nama_mobil & plat_nomor
        if ($request->filled('search')) {
            $query->where(function($q) use ($request) {
                $searchTerm = "%{$request->search}%";
                $q->where('nama_mobil', 'like', $searchTerm)
                  ->orWhere('plat_nomor', 'like', $searchTerm)
                  ->orWhereHas('owner', function($userQuery) use ($searchTerm) {
                      $userQuery->where('nama', 'like', $searchTerm);
                  });
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $mobil = $query->latest()->paginate(10)->withQueryString();

        // Statistik Card
        $totalMobil  = Mobil::count();
        $tersedia    = Mobil::where('status', 'tersedia')->count();
        $disewa      = Mobil::where('status', 'disewa')->count();
        $maintenance = Mobil::where('status', 'maintenance')->count();

        return view('admin.data_mobil', compact(
            'mobil', 
            'totalMobil', 
            'tersedia', 
            'disewa', 
            'maintenance'
        ));
    }

    public function show($id)
    {
        // Pakai 'transaksis' untuk detail juga
        $item = Mobil::with(['owner', 'transaksis.user'])->findOrFail($id);
        return view('admin.mobil_detail', compact('item'));
    }
}

