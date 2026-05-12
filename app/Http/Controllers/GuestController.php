<?php

namespace App\Http\Controllers;

use App\Models\Mobil;
use Illuminate\Http\Request;

class GuestController extends Controller
{
    /**
     * Halaman Daftar Mobil untuk Guest (Sesuai gambar desain)
     */
    public function index(Request $request)
    {
        $query = Mobil::query();

        // Fitur Search Nama Mobil
        if ($request->filled('search')) {
            $query->where('nama_mobil', 'like', '%' . $request->search . '%');
        }

        // Filter Kategori (SUV, MPV, dll)
        if ($request->filled('kategori')) {
            $query->where('kategori', $request->kategori);
        }

        // Filter Status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Ambil data dengan pagination 8 (biar rapi 4 kolom x 2 baris sesuai gambar)
        $mobil = $query->latest()->paginate(8);

        // Pastikan nama view sesuai dengan file blade lo
        return view('daftar_mobil', compact('mobil'));
    }
}
