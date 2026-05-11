<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class OwnerController extends Controller
{
    public function index()
    {
        // 1. Ambil SEMUA user dengan role 'owner' dari database lo
        $owners = User::where('role', 'owner')
                      ->orderBy('created_at', 'desc')
                      ->get();

        // 2. Hitung khusus yang 'pending' untuk angka di badge sidebar
        $ownerPendingCount = User::where('role', 'owner')
                                 ->where('status_akun', 'pending')
                                 ->count();

        // Pastikan view mengarah ke resources/views/admin/owner.blade.php
        return view('admin.owner', compact('owners', 'ownerPendingCount'));
    }

    public function approve($id)
    {
        // Menggunakan id_user sesuai kolom di database lo
        $user = User::where('id_user', $id)->firstOrFail();
        $user->update(['status_akun' => 'aktif']);

        return redirect()->back()->with('success', 'Owner berhasil disetujui!');
    }

    public function reject($id)
    {
        $user = User::where('id_user', $id)->firstOrFail();
        $user->update(['status_akun' => 'ditolak']);

        return redirect()->back()->with('error', 'Owner telah ditolak.');
    }
}
