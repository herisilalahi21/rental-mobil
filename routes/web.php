<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MobilController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\OwnerController;
use App\Http\Controllers\TransaksiController;
use App\Http\Controllers\BookingController; 
use App\Http\Controllers\GuestController;
use App\Http\Controllers\ArmadaController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AdminArmadaController;

/*
|--------------------------------------------------------------------------
| Web Routes - RentaCar System
|--------------------------------------------------------------------------
*/

// --- 1. HALAMAN PUBLIK ---
Route::get('/', [MobilController::class, 'welcome'])->name('home');
Route::get('/daftar-mobil', [GuestController::class, 'index'])->name('mobil.umum');
Route::get('/mobil/detail/{id}', [MobilController::class, 'show'])->name('mobil.detail');

// --- 2. KHUSUS GUEST (Belum Login) ---
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});

// --- 3. SEMUA USER LOGIN (Auth Middleware) ---
Route::middleware('auth')->group(function () {
    
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // ==========================================
    // A. ROUTE GROUP ADMIN 
    // (Gue gabungin semua ke sini biar gak mencar-mencar)
    // ==========================================
    Route::prefix('admin')->name('admin.')->group(function () {
        // Dashboard
        Route::get('/dashboard', [AdminController::class, 'index'])->name('dashboard');
        
        // Manajemen User (Sekarang pakai UserController sesuai permintaan lo)
        Route::get('/users', [UserController::class, 'index'])->name('users');
        Route::get('/users/detail/{id}', [UserController::class, 'detail'])->name('users.detail');
        Route::get('/users/edit/{id}', [AdminController::class, 'userEdit'])->name('users.edit');
        Route::put('/users/update/{id}', [AdminController::class, 'userUpdate'])->name('users.update');
        Route::get('/users/export', [AdminController::class, 'exportUser'])->name('users.export');

        // Lain-lain
        Route::get('/mobil', [AdminController::class, 'manageMobil'])->name('mobil');
        Route::get('/transactions', [TransaksiController::class, 'index'])->name('transactions');
        Route::get('/reports', [AdminController::class, 'reports'])->name('reports');
    });

    // ==========================================
    // B. ROUTE GROUP OWNER
    // ==========================================
    Route::middleware(['isOwner'])->prefix('owner')->name('owner.')->group(function () {
        Route::get('/dashboard', [OwnerController::class, 'index'])->name('dashboard');
        
        // Manajemen Armada
        Route::get('/daftar-mobil', [OwnerController::class, 'daftarMobil'])->name('daftar_mobil');
        Route::get('/mobil/create', [OwnerController::class, 'createMobil'])->name('mobil.create');
        Route::post('/mobil/store', [MobilController::class, 'store'])->name('mobil.store');
        Route::get('/mobil/detail/{id}', [MobilController::class, 'show'])->name('mobil.show');
        Route::get('/mobil/edit/{id}', [OwnerController::class, 'editMobil'])->name('mobil.edit');
        Route::put('/mobil/update/{id}', [MobilController::class, 'update'])->name('mobil.update');
        Route::delete('/mobil/delete/{id}', [OwnerController::class, 'destroyMobil'])->name('mobil.destroy');
        
        // Tambahan Resource kalau lo mau pake ArmadaController
        Route::resource('armada', ArmadaController::class)->except(['show']); 
    });

    // ==========================================
    // C. ROUTE CUSTOMER & BOOKING
    // ==========================================
    Route::prefix('customer')->name('customer.')->group(function () {
        Route::get('/riwayat-sewa', [TransaksiController::class, 'history'])->name('riwayat');
    });

    Route::get('/booking/{id}', [BookingController::class, 'create'])->name('booking.create');
    Route::post('/booking/store', [BookingController::class, 'store'])->name('booking.store');


  

Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {
    
    // Route List Mobil
    Route::get('/mobil', [AdminArmadaController::class, 'index'])->name('mobil');
    
    // Route Detail Mobil (PASTIKAN ADA .name('mobil.detail'))
    Route::get('/mobil/detail/{id}', [AdminArmadaController::class, 'show'])->name('mobil.detail');
    
});
});
