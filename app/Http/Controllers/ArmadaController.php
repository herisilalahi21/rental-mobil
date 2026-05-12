<?php

namespace App\Http\Controllers;

use App\Models\Mobil;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ArmadaController extends Controller
{
    /**
     * Tampilkan semua mobil milik owner yang login
     */
    public function index()
    {
        $daftarMobil = Mobil::where('user_id', Auth::user()->id_user)
            ->latest()
            ->get();

        return view('owner.armada.index', compact('daftarMobil'));
    }

    /**
     * Form tambah mobil baru
     */
    public function create()
    {
        return view('owner.armada.create');
    }

    /**
     * Simpan data mobil ke database
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama_mobil'     => 'required|string|max:255',
            'plat_nomor'     => 'required|string|unique:armada_mobils,plat_nomor',
            'kategori'       => 'required',
            'transmisi'      => 'required',
            'tahun'          => 'required|numeric',
            'harga_per_hari' => 'required|numeric|min:0',
            'foto'           => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        try {
            $fotoPath = null;
            if ($request->hasFile('foto')) {
                $fotoPath = $request->file('foto')->store('armada', 'public');
            }

            Mobil::create([
                'user_id'        => Auth::user()->id_user,
                'nama_mobil'     => $request->nama_mobil,
                'plat_nomor'     => $request->plat_nomor,
                'kategori'       => $request->kategori,
                'transmisi'      => $request->transmisi,
                'tahun'          => $request->tahun,
                'harga_per_hari' => $request->harga_per_hari,
                'deskripsi'      => $request->deskripsi,
                'fitur'          => $request->fitur ?? [],
                'foto'           => $fotoPath,
                'status'         => 'tersedia',
            ]);

            return redirect()->route('armada.index')->with('success', 'Mobil berhasil ditambahkan!');

        } catch (\Exception $e) {
            return back()->withInput()->with('error', 'Gagal simpan ke database: ' . $e->getMessage());
        }
    }

    /**
     * Update data mobil
     */
    public function update(Request $request, $id)
    {
        $mobil = Mobil::where('id', $id)->where('user_id', Auth::user()->id_user)->firstOrFail();

        $request->validate([
            'nama_mobil'     => 'required|string|max:255',
            'plat_nomor'     => 'required|string|unique:armada_mobils,plat_nomor,' . $id,
            'kategori'       => 'required',
            'transmisi'      => 'required',
            'tahun'          => 'required|numeric',
            'harga_per_hari' => 'required|numeric|min:0',
            'foto'           => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        try {
            $fotoPath = $mobil->foto;
            if ($request->hasFile('foto')) {
                if ($mobil->foto) Storage::disk('public')->delete($mobil->foto);
                $fotoPath = $request->file('foto')->store('armada', 'public');
            }

            $mobil->update([
                'nama_mobil'     => $request->nama_mobil,
                'plat_nomor'     => $request->plat_nomor,
                'kategori'       => $request->kategori,
                'transmisi'      => $request->transmisi,
                'tahun'          => $request->tahun,
                'harga_per_hari' => $request->harga_per_hari,
                'deskripsi'      => $request->deskripsi,
                'fitur'          => $request->fitur ?? [],
                'foto'           => $fotoPath,
            ]);

            return redirect()->route('armada.index')->with('success', 'Data mobil diperbarui!');

        } catch (\Exception $e) {
            return back()->withInput()->with('error', 'Update gagal: ' . $e->getMessage());
        }
    }

    /**
     * Hapus mobil
     */
    public function destroy($id)
    {
        $mobil = Mobil::where('id', $id)->where('user_id', Auth::user()->id_user)->firstOrFail();
        
        if ($mobil->foto) Storage::disk('public')->delete($mobil->foto);
        
        $mobil->delete();
        return redirect()->route('armada.index')->with('success', 'Mobil dihapus!');
    }
}
