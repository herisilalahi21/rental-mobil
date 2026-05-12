<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $query = User::where('role', '!=', 'admin');

        // Logic Search
        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('nama', 'like', "%{$request->search}%")
                  ->orWhere('email', 'like', "%{$request->search}%");
            });
        }

        // Logic Filter Role
        if ($request->filled('role')) {
            $query->where('role', $request->role);
        }

        // Logic Filter Status
        if ($request->filled('status')) {
            $query->where('status_akun', $request->status);
        }

        $users = $query->latest()->paginate(10)->withQueryString();

        // Variabel Statistik untuk Box di Atas (Sesuai nama di Blade lo)
        $totalUser = User::where('role', '!=', 'admin')->count();
        $userAktif = User::where('status_akun', 'aktif')->count();
        $roleOwner = User::where('role', 'owner')->count();
        $nonAktif  = User::whereIn('status_akun', ['nonaktif', 'suspend'])->count();

        return view('admin.user_data', compact(
            'users', 
            'totalUser', 
            'userAktif', 
            'roleOwner', 
            'nonAktif'
        ));
    }

    public function detail($id)
    {
        $user = User::where('id_user', $id)->firstOrFail();
        return view('admin.user_detail', compact('user'));
    }
}
