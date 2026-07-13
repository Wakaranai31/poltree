<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Atur Ulang Kata Sandi - {{ config('app.name', 'POLTREE') }}</title>
    <meta name="description" content="Atur ulang kata sandi akun POLTREE Anda.">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&display=swap"
        rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="min-h-screen overflow-x-hidden bg-slate-100 font-sans text-slate-900 antialiased">
    <main class="relative isolate flex min-h-screen overflow-hidden">
        <div class="absolute inset-0 bg-cover bg-center" style="background-image: url('{{ asset('campus.png') }}');"
            aria-hidden="true"></div>
            
        <div class="absolute inset-0 bg-gradient-to-r from-[#091057] to-transparent opacity-90" aria-hidden="true"></div>
        <div class="absolute inset-0 bg-gradient-to-l from-[#ff6900] to-transparent opacity-40" aria-hidden="true"></div>

        <div class="relative z-10 mx-auto flex min-h-screen w-full max-w-6xl items-center px-6 py-10 lg:px-10">
            <div class="grid w-full gap-10 justify-items-center lg:justify-items-stretch lg:grid-cols-[minmax(0,1fr)_360px] lg:items-center xl:grid-cols-[minmax(0,1fr)_380px]">
                <section class="max-w-xl mx-auto lg:mx-0 text-center lg:text-left">
                    <div class="inline-flex flex-col items-stretch gap-4">

                        <!-- Bungkus Pertama: Kotak Badge (Logo & H1) -->
                        <div class="flex items-center justify-center gap-4 rounded-[28px] border border-slate/70 bg-[#f9f6ed] px-6 py-4">
                            <img src="{{ asset('LogoPoltree_512_512.png') }}" alt="Logo" class="h-24 w-auto object-contain">
                            <h1 class="text-4xl font-extrabold leading-tight tracking-tight text-[#091057] sm:text-5xl">
                                POLTREE
                            </h1>
                        </div>

                        <!-- Bungkus Kedua: Teks Penjelasan -->
                        <div class="flex items-center justify-center rounded-[14px] border border-slate/70 bg-[#f9f6ed] px-6 py-4">
                            <p class="max-w-md text-center text-sm leading-6 text-[#091057] sm:text-lg font-semibold">
                                Atur Ulang Sandi.<br>Buat kata sandi baru Anda.
                            </p>
                        </div>
                    </div>
                </section>

                <section
                    class="w-full max-w-sm mx-auto lg:mx-0 animate-fade-in rounded-[28px] border border-slate/75 bg-[#f9f6ed] p-5 [--animation-delay:0.25s] sm:p-6"
                    aria-label="Form Reset Password">
                    <div class="mb-5 text-center lg:text-left">
                        <h2 class="text-xl font-bold text-[#091057]">Kata Sandi Baru</h2>
                        <p class="mt-1 text-sm leading-6 text-slate-600">Buat kata sandi baru untuk akun Anda.</p>
                    </div>

                    @if ($errors->any())
                    <div class="mb-4 rounded-2xl border border-red-200/80 bg-red-50/85 px-4 py-3 text-sm leading-6 text-red-700 shadow-sm"
                        role="alert">
                        @foreach ($errors->all() as $error)
                        <div>{{ $error }}</div>
                        @endforeach
                    </div>
                    @endif

                    <form method="POST" action="{{ route('password.update.post') }}" class="space-y-3" novalidate>
                        @csrf
                        <input type="hidden" name="token" value="{{ $token }}">

                        <div class="space-y-1.5">
                            <label for="email" class="sr-only">Alamat Email</label>
                            <div class="group relative">
                                <span class="pointer-events-none absolute inset-y-0 left-4 flex items-center text-orange-500">
                                    <svg class="h-[18px] w-[18px]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <rect x="3" y="5" width="18" height="14" rx="2" ry="2"></rect>
                                        <polyline points="3 7 12 13 21 7"></polyline>
                                    </svg>
                                </span>
                                <input id="email" type="email" name="email" value="{{ $email ?? old('email') }}" placeholder="Alamat Email" required
                                    class="h-12 w-full rounded-2xl border border-orange bg-white/85 pl-12 pr-4 text-sm font-medium text-slate-700 shadow-[inset_0_1px_0_rgba(255,255,255,0.7)] transition duration-200 placeholder:text-slate-400 focus:border-[#091057] focus:bg-white focus:ring-4 focus:ring-[#091057]/10">
                            </div>
                        </div>

                        <div class="space-y-1.5">
                            <label for="password" class="sr-only">Password Baru</label>
                            <div class="group relative">
                                <span class="pointer-events-none absolute inset-y-0 left-4 flex items-center text-orange-500">
                                    <svg class="h-[18px] w-[18px]" viewBox="0 0 24 24" fill="none" aria-hidden="true">
                                        <path d="M18 8h-1V6c0-2.76-2.24-5-5-5S7 3.24 7 6v2H6c-1.1 0-2 .9-2 2v10c0 1.1.9 2 2 2h12c1.1 0 2-.9 2-2V10c0-1.1-.9-2-2-2zM9 6c0-1.66 1.34-3 3-3s3 1.34 3 3v2H9V6zm9 14H6V10h12v10zm-6-3c1.1 0 2-.9 2-2s-.9-2-2-2-2 .9-2 2 .9 2 2 2z" fill="currentColor" />
                                    </svg>
                                </span>
                                <input id="password" type="password" name="password" placeholder="Password Baru" required autofocus
                                    class="h-12 w-full rounded-2xl border border-orange bg-white/85 pl-12 pr-4 text-sm font-medium text-slate-700 shadow-[inset_0_1px_0_rgba(255,255,255,0.7)] transition duration-200 placeholder:text-slate-400 focus:border-[#091057] focus:bg-white focus:ring-4 focus:ring-[#091057]/10">
                            </div>
                        </div>

                        <div class="space-y-1.5">
                            <label for="password_confirmation" class="sr-only">Konfirmasi Password</label>
                            <div class="group relative">
                                <span class="pointer-events-none absolute inset-y-0 left-4 flex items-center text-orange-500">
                                    <svg class="h-[18px] w-[18px]" viewBox="0 0 24 24" fill="none" aria-hidden="true">
                                        <path d="M18 8h-1V6c0-2.76-2.24-5-5-5S7 3.24 7 6v2H6c-1.1 0-2 .9-2 2v10c0 1.1.9 2 2 2h12c1.1 0 2-.9 2-2V10c0-1.1-.9-2-2-2zM9 6c0-1.66 1.34-3 3-3s3 1.34 3 3v2H9V6zm9 14H6V10h12v10zm-6-3c1.1 0 2-.9 2-2s-.9-2-2-2-2 .9-2 2 .9 2 2 2z" fill="currentColor" />
                                    </svg>
                                </span>
                                <input id="password_confirmation" type="password" name="password_confirmation" placeholder="Ulangi Password Baru" required
                                    class="h-12 w-full rounded-2xl border border-orange bg-white/85 pl-12 pr-4 text-sm font-medium text-slate-700 shadow-[inset_0_1px_0_rgba(255,255,255,0.7)] transition duration-200 placeholder:text-slate-400 focus:border-[#091057] focus:bg-white focus:ring-4 focus:ring-[#091057]/10">
                            </div>
                        </div>

                        <button type="submit"
                            class="mt-2 inline-flex h-12 w-full items-center justify-center rounded-2xl bg-[#091057] text-sm font-semibold tracking-[0.03em] text-white shadow-[0_14px_30px_rgba(9,16,87,0.24)] transition duration-200 hover:bg-[#0d1a7a] hover:shadow-[0_18px_34px_rgba(9,16,87,0.28)] active:scale-[0.99]">
                            Simpan Kata Sandi Baru
                        </button>
                    </form>
                </section>
            </div>
        </div>
        
        {{-- Footer --}}
        <div class="absolute bottom-0 left-0 w-full z-20">
            @include('components.shared.footer')
        </div>
    </main>

    <!-- GSAP CDN & Premium Animations -->
    <script src="https://cdn.jsdelivr.net/npm/gsap@3.12.5/dist/gsap.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            // Animate background overlay & blobs
            gsap.fromTo('.absolute.bg-cover', {
                opacity: 0,
                scale: 1.1
            }, {
                opacity: 1,
                scale: 1,
                duration: 1.6,
                ease: 'power2.out'
            });
            gsap.from('.pointer-events-none', {
                opacity: 0,
                scale: 0.8,
                duration: 1.5,
                stagger: 0.2,
                ease: 'back.out(1.7)'
            });

            // Create timeline for smooth stagger
            const tl = gsap.timeline({
                defaults: {
                    ease: 'power3.out'
                }
            });

            // Animate Welcome Section
            tl.from('section:nth-child(1) > div', {
                    opacity: 0,
                    y: -25,
                    duration: 0.8
                }, '+=0.2')
                .from('section:nth-child(1) > h1', {
                    opacity: 0,
                    x: -35,
                    duration: 0.8
                }, '-=0.6')
                .from('section:nth-child(1) > p', {
                    opacity: 0,
                    x: -35,
                    duration: 0.8
                }, '-=0.6');

            // Animate Reset Password Card
            tl.from('section:nth-child(2)', {
                opacity: 0,
                y: 50,
                scale: 0.95,
                duration: 1,
                ease: 'back.out(1.2)'
            }, '-=0.8');

            // Animate Form Content
            tl.from('section:nth-child(2) > div', {
                    opacity: 0,
                    y: 15,
                    duration: 0.5
                }, '-=0.5')
                .from('form > .space-y-1.5', {
                    opacity: 0,
                    y: 15,
                    stagger: 0.15,
                    duration: 0.5
                }, '-=0.3')
                .from('form > button', {
                    opacity: 0,
                    y: 15,
                    duration: 0.5
                }, '-=0.2');
        });
    </script>
</body>

</html>