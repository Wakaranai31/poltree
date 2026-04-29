@extends('layouts.app')

@section('content')
    <h1>Login Portal Polibatam</h1>

    <!-- Menampilkan pesan error jika login gagal -->
    @if ($errors->any())
        <p style="color: red;">{{ $errors->first() }}</p>
    @endif

    <!-- Form Login -->
    <form action="{{ route('login') }}" method="POST">
        @csrf

        <label for="email">Email:</label><br>
        <input type="email" name="email" id="email" required value="{{ old('email') }}"><br><br>

        <label for="password">Password:</label><br>
        <input type="password" name="password" id="password" required><br><br>

        <button type="submit">Masuk</button>
    </form>
@endsection
