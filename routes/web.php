<?php

use Illuminate\Support\Facades\Route;

// Koki Layanan & Kategori
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\LayananController;
use App\Http\Controllers\KategoriSpesialController;
use App\Http\Controllers\LayananSpesialController;
use App\Http\Controllers\LayananFavoritController;

// Koki Auth & Dashboard Baru
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;

// Halaman Utama Portal (Bisa diarahkan ke login atau halaman selamat datang)
Route::get('/', function () {
    return redirect()->route('login');
});

// -----------------------------------------------------------------------
// RUTE TAMU (Belum Login)
// -----------------------------------------------------------------------
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
});

// -----------------------------------------------------------------------
// RUTE PENGGUNA (Sudah Login)
// -----------------------------------------------------------------------
Route::middleware('auth')->group(function () {
    // Auth & Dashboard
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Master Data (Kategori & Layanan)
    Route::resource('kategori', KategoriController::class);
    Route::resource('layanan', LayananController::class);
    Route::resource('kategori-spesial', KategoriSpesialController::class);
    Route::resource('layanan-spesial', LayananSpesialController::class);

    // Layanan Favorit
    Route::get('/layanan-favorit', [LayananFavoritController::class, 'index'])->name('layanan-favorit.index');
    Route::post('/layanan-favorit/toggle', [LayananFavoritController::class, 'toggle'])->name('layanan-favorit.toggle');
    Route::put('/layanan-favorit/{layananFavorit}/kategori', [LayananFavoritController::class, 'updateCategory'])->name('layanan-favorit.updateCategory');
    Route::delete('/layanan-favorit/{layananFavorit}', [LayananFavoritController::class, 'destroy'])->name('layanan-favorit.destroy');
});
