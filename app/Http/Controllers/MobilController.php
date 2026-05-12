<?php

namespace App\Http\Controllers;

use App\Models\Mobil;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MobilController extends Controller
{
    /**
     * Landing Page
     */
    public function welcome()
    {
        $mobil = Mobil::where('status', 'tersedia')
            ->latest()
            ->take(4)
            ->get();

        return view('welcome', compact('mobil'));
    }

    /**
     * Daftar Mobil
     */
    public function index(Request $request)
    {
        $query = Mobil::query();

        if ($request->filled('search')) {
            $query->where('nama_mobil', 'like', '%' . $request->search . '%');
        }

        if ($request->filled('kategori')) {
            $query->where('kategori', $request->kategori);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $mobil = $query->latest()
            ->paginate(8)
            ->withQueryString();

        return view('daftar_mobil', compact('mobil'));
    }

    /**
     * Detail Mobil
     */
    public function show($id)
    {
        $mobil = Mobil::findOrFail($id);

        return view('detail_mobil', compact('mobil'));
    }

    /**
     * Simpan Mobil (FIX FINAL)
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama_mobil'     => 'required|string|max:255',
            'plat_nomor'     => 'required|unique:armada_mobils,plat_nomor',
            'tahun'          => 'required|numeric',
            'harga_per_hari' => 'required|numeric',
            'kategori'       => 'required',
            'transmisi'      => 'required',
            'deskripsi'      => 'required',
            'foto'           => 'nullable|image|mimes:jpg,png,jpeg|max:2048'
        ]);

        $path = null;

        if ($request->hasFile('foto')) {
            $path = $request->file('foto')->store('armada', 'public');
        }

        Mobil::create([
            'user_id'        => auth()->user()->id_user, // FIX AMAN
            'nama_mobil'     => $request->nama_mobil,
            'plat_nomor'     => $request->plat_nomor,
            'tahun'          => $request->tahun,
            'harga_per_hari' => $request->harga_per_hari,
            'status'         => 'tersedia',
            'kategori'       => $request->kategori,
            'transmisi'      => $request->transmisi,
            'deskripsi'      => $request->deskripsi,
            'foto'           => $path,

            // FIX PENTING: pakai array (bukan json_encode)
            'fitur'          => $request->fitur ?? [],
        ]);

        return redirect()
            ->back()
            ->with('success', 'Mobil berhasil ditambahkan!');
    }
}