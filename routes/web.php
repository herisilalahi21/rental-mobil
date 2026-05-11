<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MobilController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\Admin\OwnerController;
use App\Http\Controllers\TransaksiController;
use App\Http\Controllers\LaporanController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// --- HALAMAN PUBLIK ---
Route::get('/', function () { 
    return view('welcome'); 
})->name('home');

Route::get('/daftar-mobil', [MobilController::class, 'index'])->name('mobil.index');

// --- KHUSUS GUEST (BELUM LOGIN) ---
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});

// --- KHUSUS AUTH (SUDAH LOGIN) ---
Route::middleware('auth')->group(function () {
    
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // --- GROUP ADMIN (Semua route di sini otomatis punya prefix 'admin/' dan nama 'admin.') ---
    Route::prefix('admin')->name('admin.')->group(function () {
        
        // Dashboard Utama
        Route::get('/dashboard', [AdminController::class, 'index'])->name('dashboard');
        
        // --- USER MANAGEMENT ---
        Route::get('/users', [AdminController::class, 'dataUser'])->name('users');
        
        // Detail User
        Route::get('/users/detail/{id_user}', [AdminController::class, 'showUser'])->name('users.detail');
        
        // Edit & Update User (Gunakan id_user agar sinkron dengan database)
        Route::get('/users/edit/{id_user}', [AdminController::class, 'editUser'])->name('users.edit');
        Route::put('/users/update/{id_user}', [AdminController::class, 'updateUser'])->name('users.update');
        
        // Export Data
        Route::get('/users/export', [AdminController::class, 'exportUser'])->name('users.export');
        
        // --- OWNER MANAGEMENT (Verifikasi & Kelola) ---
        Route::get('/owner', [OwnerController::class, 'index'])->name('owner');
        Route::patch('/owner/{id}/approve', [OwnerController::class, 'approve'])->name('owner.approve');
        Route::patch('/owner/{id}/reject', [OwnerController::class, 'reject'])->name('owner.reject');

        // --- TRANSAKSI & MOBIL ---
        Route::get('/transaksi', [AdminController::class, 'manageTransactions'])->name('transactions');
        Route::get('/mobil', [AdminController::class, 'manageMobil'])->name('mobil');


        // Di dalam Route::prefix('admin')->name('admin.')->group(function () { ... })

Route::get('/mobil', [AdminController::class, 'manageMobil'])->name('mobil');
Route::get('/mobil/detail/{id_mobil}', [AdminController::class, 'showMobil'])->name('mobil.detail');
Route::delete('/mobil/delete/{id_mobil}', [AdminController::class, 'destroyMobil'])->name('mobil.delete');
        
    });
          //route transaksi
Route::prefix('admin')->name('admin.')->group(function () {
    // ... rute lainnya
    
    // Ubah dari AdminController ke TransaksiController
    Route::get('/transaksi', [TransaksiController::class, 'index'])->name('transactions');
});

Route::middleware('auth')->group(function () {
    Route::prefix('admin')->name('admin.')->group(function () {
        
        // Pastikan baris ini ada dan namanya tepat 'laporan'
        Route::get('/laporan', [LaporanController::class, 'index'])->name('laporan');
        
    });
    });


});
