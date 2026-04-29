<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Portal Login - POLTREE')</title>

    <!-- Memanggil Font Poppins dari desain Figma temanmu -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- INI YANG PALING PENTING: Memanggil Mesin Tailwind (Vite) -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="min-h-screen overflow-x-hidden bg-slate-100 font-sans text-slate-900 antialiased flex flex-col">

    <!-- Tempat Konten Login/Dashboard Diselipkan -->
    @yield('content')

</body>

</html>
