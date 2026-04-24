<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Login — {{ config('app.name', 'POLTREE') }}</title>
    <meta name="description" content="Masuk ke sistem POLTREE dengan NIP dan kata sandi Anda.">

    <!-- Poppins Font -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        /* Reset dasar */
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        /* Tampilan halaman */
        body {
            font-family: 'Poppins', sans-serif;
            min-height: 100vh;
            overflow: hidden;
        }

        /* Layout halaman */
        .login-page {
            position: relative;
            width: 100%;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        /* Foto latar */
        .login-bg-photo {
            position: absolute;
            inset: 0;
            background-image: url('/campus.png');
            background-size: cover;
            background-position: center top;
            background-repeat: no-repeat;
        }

        /* Lapisan warna */
        .login-bg-overlay {
            position: absolute;
            inset: 0;
            background:
                linear-gradient(244deg, rgba(134, 167, 252, 0.40) 0%, rgba(255, 255, 255, 0.28) 55%, rgba(255, 152, 67, 0.35) 81%),
                linear-gradient(0deg, rgba(255, 255, 255, 0.55) 0%, rgba(255, 255, 255, 0.55) 100%);
        }

        /* Dekorasi bulat */
        .blob {
            position: absolute;
            border-radius: 50%;
            pointer-events: none;
        }

        /* Dekorasi kiri bawah */
        .blob-left {
            bottom: -120px;
            left: -80px;
            width: 520px;
            height: 420px;
            background: rgba(255, 255, 255, 0.55);
            border-radius: 60% 40% 55% 45% / 50% 60% 40% 50%;
        }

        /* Dekorasi kanan atas */
        .blob-top-right {
            top: -80px;
            right: -60px;
            width: 340px;
            height: 300px;
            background: rgba(255, 255, 255, 0.40);
            border-radius: 45% 55% 40% 60% / 55% 45% 60% 40%;
        }

        /* Pola titik */
        .dot-pattern {
            position: absolute;
            top: 0;
            right: 0;
            width: 55%;
            height: 60%;
            background-image: radial-gradient(circle, rgba(9, 16, 87, 0.2) 1.5px, transparent 1.5px);
            background-size: 22px 22px;
            pointer-events: none;
        }

        /* Konten utama */
        .login-content {
            position: relative;
            z-index: 10;
            width: 100%;
            max-width: 1200px;
            padding: 0 48px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 40px;
        }

        /* Teks sambutan */
        .login-hero {
            flex: 1;
        }

        .login-hero h1 {
            font-size: clamp(2rem, 4vw, 3.2rem);
            font-weight: 700;
            color: #091057;
            line-height: 1.15;
            margin-bottom: 16px;
            opacity: 0;
            animation: fade-up 0.8s 0.1s ease forwards;
        }

        .login-hero p {
            font-size: clamp(0.9rem, 1.5vw, 1.1rem);
            color: #46484d;
            line-height: 1.5;
            max-width: 340px;
            opacity: 0;
            animation: fade-up 0.8s 0.25s ease forwards;
        }

        /* Kartu login */
        .login-card {
            width: 100%;
            max-width: 360px;
            background: rgba(255, 255, 255, 0.30);
            border: 1.5px solid rgba(255, 255, 255, 0.70);
            border-radius: 28px;
            padding: 40px 32px;
            box-shadow:
                0 8px 32px rgba(9, 16, 87, 0.12),
                inset 0 1px 0 rgba(255, 255, 255, 0.8),
                inset -2px -2px 8px rgba(0, 0, 0, 0.06),
                inset 3px 3px 10px rgba(255, 255, 255, 0.60);
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            opacity: 0;
            animation: fade-in 0.9s 0.35s ease forwards;
        }

        /* Grup input */
        .input-group {
            position: relative;
            margin-bottom: 16px;
        }

        .input-group input {
            width: 100%;
            height: 52px;
            background: rgba(255, 255, 255, 0.85);
            border: 1.5px solid rgba(255, 255, 255, 0.9);
            border-radius: 10px;
            padding: 0 16px 0 48px;
            font-family: 'Poppins', sans-serif;
            font-size: 14px;
            color: #46484d;
            transition: border-color 0.2s, box-shadow 0.2s, background 0.2s;
        }

        .input-group input:focus {
            background: rgba(255, 255, 255, 0.98);
            border-color: #091057;
            box-shadow: 0 0 0 3px rgba(9, 16, 87, 0.10);
        }

        .input-group input::placeholder {
            color: #9ca3af;
            font-size: 13px;
        }

        /* Ikon input */
        .input-icon {
            position: absolute;
            left: 14px;
            top: 50%;
            transform: translateY(-50%);
            display: flex;
            align-items: center;
            pointer-events: none;
        }

        /* Label tersembunyi */
        .sr-only {
            position: absolute;
            width: 1px;
            height: 1px;
            padding: 0;
            margin: -1px;
            overflow: hidden;
            clip: rect(0, 0, 0, 0);
            white-space: nowrap;
            border: 0;
        }

        /* Pesan error */
        .alert-error {
            background: rgba(220, 53, 69, 0.10);
            border: 1px solid rgba(220, 53, 69, 0.35);
            border-radius: 8px;
            color: #c0392b;
            padding: 10px 14px;
            font-size: 12px;
            margin-bottom: 16px;
            line-height: 1.5;
        }

        /* Pesan sukses */
        .alert-success {
            background: rgba(34, 197, 94, 0.12);
            border-color: rgba(34, 197, 94, 0.35);
            color: #15803d;
        }

        /* Tombol masuk */
        .btn-masuk {
            width: 100%;
            height: 52px;
            margin-top: 8px;
            background: #091057;
            color: white;
            border-radius: 10px;
            font-family: 'Poppins', sans-serif;
            font-size: 14px;
            font-weight: 400;
            letter-spacing: 0.03em;
            cursor: pointer;
            border: none;
            transition: background 0.2s, transform 0.1s, box-shadow 0.2s;
        }

        .btn-masuk:hover {
            background: #0d1a7a;
            box-shadow: 0 4px 18px rgba(9, 16, 87, 0.30);
        }

        .btn-masuk:active {
            transform: scale(0.98);
        }

        /* Link lupa password */
        .btn-lupa {
            display: block;
            width: 100%;
            text-align: center;
            margin-top: 12px;
            font-family: 'Poppins', sans-serif;
            font-size: 13px;
            color: #2e61e1ff;
            background: none;
            border: none;
            cursor: pointer;
            text-decoration: none;
            transition: color 0.2s;
        }

        .btn-lupa:hover {
            color: #091057;
        }

        /* Tampilan link nonaktif */
        .btn-lupa-disabled {
            cursor: default;
        }
    </style>
</head>

<body>
    <div class="login-page">

        {{-- Latar belakang --}}
        <div class="login-bg-photo"></div>
        <div class="login-bg-overlay"></div>

        {{-- Dekorasi halaman --}}
        <div class="blob blob-left"></div>
        <div class="blob blob-top-right"></div>

        {{-- Pola titik --}}
        <div class="dot-pattern"></div>

        {{-- Konten login --}}
        <div class="login-content">

            {{-- Teks sambutan --}}
            <section class="login-hero" aria-labelledby="login-heading">
                <h1 id="login-heading">Selamat Datang!</h1>
                <p>Masukkan NIK dan Password untuk melanjutkan ke sistem.</p>
            </section>

            {{-- Form login --}}
            <section class="login-card" aria-label="Form login">

                {{-- Pesan error --}}
                @if ($errors->any())
                    <div class="alert-error" role="alert">
                        @foreach ($errors->all() as $error)
                            {{ $error }}<br>
                        @endforeach
                    </div>
                @endif

                {{-- Pesan sukses --}}
                @if (session('success'))
                    <div class="alert-error alert-success" role="status">
                        ✓ {{ session('success') }}
                    </div>
                @endif

                {{-- Form autentikasi --}}
                <form method="POST" action="{{ route('login') }}" novalidate>
                    @csrf

                    {{-- Input username --}}
                    <div class="input-group">
                        <label for="username" class="sr-only">NIP / Username</label>
                        <span class="input-icon" aria-hidden="true">
                            {{-- Ikon username --}}
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none">
                                <path
                                    d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"
                                    fill="#e55a2b" />
                            </svg>
                        </span>
                        <input id="username" type="text" name="username" autocomplete="username"
                            value="{{ old('username') }}" placeholder="username" required autofocus>
                    </div>

                    {{-- Input password --}}
                    <div class="input-group">
                        <label for="password" class="sr-only">Kata Sandi</label>
                        <span class="input-icon" aria-hidden="true">
                            {{-- Ikon password --}}
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none">
                                <path
                                    d="M7 14q-1.25 0-2.125-.875T4 11t.875-2.125T7 8t2.125.875T10 11t-.875 2.125T7 14m0 4q-2.9 0-4.95-2.05T0 11t2.05-4.95T7 4q2.5 0 4.463 1.45T14.2 9H21l2 2-3 3-2-2-2 2-2-2H14.2q-.775 2.1-2.737 3.55T7 18z"
                                    fill="#e55a2b" />
                            </svg>
                        </span>
                        <input id="password" type="password" name="password" autocomplete="current-password"
                            placeholder="password" required>
                    </div>

                    {{-- Tombol submit --}}
                    <button type="submit" class="btn-masuk">masuk</button>

                    {{-- Link lupa password --}}
                    @if (Route::has('password.request'))
                        <a href="{{ route('password.request') }}" class="btn-lupa">lupa password?</a>
                    @else
                        <span class="btn-lupa btn-lupa-disabled">lupa password?</span>
                    @endif

                </form>
            </section>

        </div>
    </div>
</body>

</html>
