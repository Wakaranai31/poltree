<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        // Ambil data user yang sedang login
        $user = Auth::user();

        // Cek kolom 'role', jika dia admin arahkan ke piring (view) admin
        if ($user->role === 'admin') {
            return view('dashboard.admin');
        }

        // Jika user biasa (mahasiswa/dosen), arahkan ke piring user
        return view('dashboard.user');
    }
}
