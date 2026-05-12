<?php

namespace App\Http\Controllers;

use App\Models\Mobil;
use App\Models\Transaksi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class OwnerController extends Controller
{
    /**
     * Dashboard Owner
     */
    public function index()
    {
        $user = Auth::user();

        // Count mobil berdasarkan user_id (id_user)
        $jumlahMobil = Mobil::where('user_id', $user->id_user)->count();

        // Total Pendapatan dari transaksi mobil milik owner
        $totalPendapatan = Transaksi::whereHas('mobil', function ($q) use ($user) {
                $q->where('user_id', $user->id_user);
            })
            ->whereIn('status', ['selesai', 'dibayar', 'berjalan'])
            ->sum('total_harga');

        // 5 Transaksi terbaru
        $bookings = Transaksi::with(['user', 'mobil'])
            ->whereHas('mobil', function ($q) use ($user) {
                $q->where('user_id', $user->id_user);
            })
            ->latest()
            ->take(5)
            ->get();

        return view('owner.dashboard', compact(
            'bookings',
            'jumlahMobil',
            'totalPendapatan'
        ));
    }

    /**
     * List mobil milik owner
     */
    public function daftarMobil()
    {
        $user = Auth::user();

        $daftarMobil = Mobil::where('user_id', $user->id_user)
            ->latest()
            ->get();

        $jumlahMobil = $daftarMobil->count();

        return view('owner.daftar_mobil', compact(
            'daftarMobil',
            'jumlahMobil'
        ));
    }

    /**
     * Form tambah mobil
     */
    public function createMobil()
    {
        return view('owner.manage_mobil');
    }

    /**
     * Simpan mobil ke tabel armada_mobils
     */
    public function storeMobil(Request $request)
    {
        $request->validate([
            'nama_mobil'     => 'required|string|max:255',
            'plat_nomor'     => 'required|string|unique:armada_mobils,plat_nomor',
            'kategori'       => 'required|string',
            'transmisi'      => 'required|string',
            'tahun'          => 'required|numeric',
            'harga_per_hari' => 'required|numeric|min:0',
            'foto'           => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        try {
            $fotoPath = null;
            if ($request->hasFile('foto')) {
                // Simpan ke folder public/armada
                $fotoPath = $request->file('foto')->store('armada', 'public');
            }

            // Eksekusi Create ke Tabel armada_mobils
            Mobil::create([
                'user_id'        => Auth::user()->id_user,
                'nama_mobil'     => $request->nama_mobil,
                'plat_nomor'     => $request->plat_nomor,
                'kategori'       => $request->kategori,
                'transmisi'      => $request->transmisi,
                'tahun'          => $request->tahun,
                'harga_per_hari' => $request->harga_per_hari,
                'deskripsi'      => $request->deskripsi,
                'fitur'          => $request->fitur ?? [], // Pastikan di Model Mobil sudah ada $casts array
                'foto'           => $fotoPath,
                'status'         => 'tersedia',
            ]);

            return redirect()
                ->route('owner.daftar_mobil')
                ->with('success', 'Mobil berhasil ditambahkan ke armada!');

        } catch (\Exception $e) {
            // Jika ada error database, balikkan ke form dengan pesan error
            return back()->withInput()->with('error', 'Gagal Simpan Data: ' . $e->getMessage());
        }
    }

    /**
     * Detail mobil
     */
    public function showMobil($id)
    {
        // Cari berdasarkan id (Primary Key armada_mobils)
        $mobil = Mobil::with('galeri')
            ->where('id', $id)
            ->firstOrFail();

        return view('owner.detail_mobil', compact('mobil'));
    }

    /**
     * Form edit mobil
     */
    public function editMobil($id)
    {
        $mobil = Mobil::where('id', $id)->firstOrFail();

        return view('owner.manage_mobil', compact('mobil'));
    }

    /**
     * Update mobil
     */
    public function updateMobil(Request $request, $id)
    {
        $mobil = Mobil::where('id', $id)->firstOrFail();

        $request->validate([
            'nama_mobil'     => 'required|string|max:255',
            'plat_nomor'     => 'required|string|unique:armada_mobils,plat_nomor,' . $id,
            'kategori'       => 'required|string',
            'transmisi'      => 'required|string',
            'tahun'          => 'required|numeric',
            'harga_per_hari' => 'required|numeric|min:0',
            'foto'           => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        try {
            $fotoPath = $mobil->foto;

            if ($request->hasFile('foto')) {
                // Hapus foto lama jika ada
                if ($mobil->foto) {
                    Storage::disk('public')->delete($mobil->foto);
                }
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

            return redirect()
                ->route('owner.daftar_mobil')
                ->with('success', 'Data mobil berhasil diperbarui!');

        } catch (\Exception $e) {
            return back()->withInput()->with('error', 'Gagal Update Data: ' . $e->getMessage());
        }
    }

    /**
     * Hapus mobil
     */
    public function destroyMobil($id)
    {
        try {
            $mobil = Mobil::with('galeri')->where('id', $id)->firstOrFail();

            // Hapus File Foto Utama
            if ($mobil->foto) {
                Storage::disk('public')->delete($mobil->foto);
            }

            // Hapus Foto di Galeri
            foreach ($mobil->galeri as $g) {
                if ($g->foto) {
                    Storage::disk('public')->delete($g->foto);
                }
            }

            $mobil->delete();

            return redirect()
                ->route('owner.daftar_mobil')
                ->with('success', 'Mobil berhasil dihapus dari sistem!');

        } catch (\Exception $e) {
            return back()->with('error', 'Gagal Hapus Mobil: ' . $e->getMessage());
        }
    }
}