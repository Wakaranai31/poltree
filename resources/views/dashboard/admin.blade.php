@extends('layouts.app')

@section('content')
    <h1>Dashboard Admin</h1>
    <p>Selamat datang, {{ auth()->user()->name }}! Anda login sebagai Administrator.</p>

    <hr>

    <h3>Menu Admin:</h3>
    <ul>
        <li><a href="{{ route('kategori.index') }}">Kelola Kategori</a></li>
        <li><a href="{{ route('layanan.index') }}">Kelola Layanan Utama</a></li>
    </ul>

    <br>

    <!-- Tombol Logout -->
    <form action="{{ route('logout') }}" method="POST">
        @csrf
        <button type="submit">Logout</button>
    </form>
@endsection
