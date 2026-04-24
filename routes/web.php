<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;

// Root -> login
Route::get('/', function () {
    return redirect()->route('login');
});

// Auth
Route::middleware('guest:admin,pengguna')->group(function () {
    Route::get('/login', [LoginController::class, 'create'])->name('login');
    Route::post('/login', [LoginController::class, 'store']);
});

Route::post('/logout', [LoginController::class, 'destroy'])->name('logout');

// Dashboard Pengguna
Route::middleware('auth:pengguna')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'pengguna'])
        ->name('pengguna.dashboard');
});
