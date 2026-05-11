<?php

namespace App\Http\Controllers;

use App\Models\Mobil;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MobilController extends Controller
{
    /**
     * Menampilkan semua daftar mobil dengan Fitur Search & Filter
     */
    public function index(Request $request) // Tambahin Request $request di sini
    {
        $query = Mobil::query();

        // 1. Logika Search (Cari Nama Mobil)
        if ($request->has('search') && $request->search != '') {
            $query->where('nama_mobil', 'like', '%' . $request->search . '%');
        }

        // 2. Logika Filter Kategori
        if ($request->has('kategori') && $request->kategori != '') {
            $query->where('kategori', $request->kategori);
        }

        // 3. Logika Filter Status
        if ($request->has('status') && $request->status != '') {
            $query->where('status', $request->status);
        }

        /**
         * PERBAIKAN UTAMA:
         * Ganti Mobil::all() menjadi paginate(8).
         * Ini biar error "Method Collection::appends does not exist" hilang!
         */
        $mobils = $query->paginate(8); 

        return view('daftar_mobil', compact('mobils'));
    }

    /**
     * Menyimpan data mobil ke database
     */
    public function store(Request $request)
    {
        // Tambahin 'kategori' dan 'transmisi' di validasi biar sinkron sama desain
        $request->validate([
            'nama_mobil'     => 'required',
            'merk'           => 'required',
            'plat_nomor'     => 'required|unique:mobils',
            'tahun'          => 'required|numeric',
            'harga_per_hari' => 'required|numeric',
            'deskripsi'      => 'required',
            'kategori'       => 'required', // Tambahan
        ]);

        Mobil::create([
            'id_owner'       => Auth::id(),
            'nama_mobil'     => $request->nama_mobil,
            'merk'           => $request->merk,
            'plat_nomor'     => $request->plat_nomor,
            'tahun'          => $request->tahun,
            'harga_sewa'     => $request->harga_per_hari,
            'status'         => 'Tersedia', 
            'kategori'       => $request->kategori,
            'transmisi'      => $request->transmisi ?? 'Manual',
            'deskripsi'      => $request->deskripsi,
        ]);

        return redirect()->route('mobil.index')->with('success', 'Mobil berhasil ditambahkan!');
    }

    
}
