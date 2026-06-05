<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\KategoriController;
use App\Http\Controllers\LayananController;
use App\Http\Controllers\KategoriSpesialController;
use App\Http\Controllers\LayananSpesialController;
use App\Http\Controllers\LayananFavoritController;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;

// Halaman Utama Portal
Route::get('/', function () {
    return redirect()->route('login');
});

// Route belum login
// -----------------------------------------------------------------------
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
});

// Route sudah login
// -----------------------------------------------------------------------
Route::middleware('auth')->group(function () {
    // Auth & Dashboard
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Kategori & Layanan
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
