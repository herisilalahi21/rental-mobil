<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    // Menampilkan Form Login
    public function showLogin() 
    { 
        return view('auth.login'); 
    }

    // Proses Login
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email'    => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials, $request->has('remember'))) {
            $request->session()->regenerate();
            
            $user = Auth::user();

            // 1. Redirect untuk Admin
            if ($user->role === 'admin') {
                session()->flash('success', 'Selamat datang Admin, ' . $user->nama . '!');
                return redirect('/admin/dashboard');
            }
            
            // 2. Redirect untuk Owner
            if ($user->role === 'owner') {
                // Opsional: Cek jika akun masih pending
                if ($user->status_akun !== 'aktif') {
                    Auth::logout();
                    return back()->withErrors([
                        'loginError' => 'Akun Owner Anda masih dalam tahap verifikasi oleh Admin.',
                    ]);
                }
                
                session()->flash('success', 'Selamat datang kembali, ' . $user->nama . '!');
                return redirect('/owner/dashboard');
            }
            
            // 3. Redirect untuk Customer (Default)
            session()->flash('success', 'Selamat datang, ' . $user->nama . '!');
            return redirect('/'); 
        }

        return back()->withErrors([
            'loginError' => 'Email atau password salah.',
        ])->onlyInput('email');
    }

    // Menampilkan Form Register
    public function showRegister() 
    { 
        return view('auth.register'); 
    }

    // Proses Register
    public function register(Request $request)
    {
        $request->validate([
            'nama'     => 'required|string|max:255',
            'email'    => 'required|string|email|max:255|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
            'role'     => 'required|in:customer,owner',
            'no_hp'    => 'required_if:role,owner',
            'alamat'   => 'required_if:role,owner',
            'ktp_file' => 'nullable|image|mimes:jpg,png,jpeg|max:2048', 
        ]);

        try {
            $ktpPath = null;
            if ($request->hasFile('ktp_file')) {
                $ktpPath = $request->file('ktp_file')->store('uploads/ktp', 'public');
            }

            User::create([
                'nama'        => $request->nama,
                'email'       => $request->email,
                'password'    => Hash::make($request->password), 
                'role'        => $request->role,
                'status_akun' => ($request->role === 'owner') ? 'pending' : 'aktif',
                'no_hp'       => $request->no_hp,
                'alamat'      => $request->alamat,
                'ktp_file'    => $ktpPath,
            ]);

            return redirect()->route('login')->with('success', 'Registrasi berhasil! Silakan login.');
            
        } catch (\Exception $e) {
            return back()->withErrors(['msg' => 'Gagal registrasi: ' . $e->getMessage()])->withInput();
        }
    }

    // Proses Logout
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        
        return redirect('/login')->with('success', 'Berhasil keluar.');
    }
}
