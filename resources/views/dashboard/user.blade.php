@extends('layouts.app')

@section('content')
    <h1>Dashboard Pengguna</h1>
    <p>Selamat datang, {{ auth()->user()->name }}! Anda login sebagai Pengguna Biasa.</p>

    <hr>

    <h3>Menu Pengguna:</h3>
    <ul>
        <li><a href="{{ route('kategori-spesial.index') }}">Kelola Kategori Spesial Saya</a></li>
        <li><a href="{{ route('layanan-spesial.index') }}">Kelola Layanan Spesial Saya</a></li>
        <li><a href="{{ route('layanan-favorit.index') }}">Layanan Favorit Saya</a></li>
    </ul>

    <br>

    <!-- Tombol Logout -->
    <form action="{{ route('logout') }}" method="POST">
        @csrf
        <button type="submit">Logout</button>
    </form>
@endsection
