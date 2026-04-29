@extends('layouts.app')

@section('content')
    <!-- Kita ambil bagian <main> dari temanmu dan masukkan ke sini -->
    <div class="relative isolate flex min-h-screen overflow-hidden w-full">

        <!-- Background Kampus (Disesuaikan path-nya ke folder png) -->
        <div class="absolute inset-0 bg-cover bg-center" style="background-image: url('{{ asset('png/campus.png') }}');"
            aria-hidden="true"></div>

        <!-- Gradient Overlay -->
        <div class="absolute inset-0 bg-[linear-gradient(115deg,rgba(255,239,221,0.9)_0%,rgba(255,255,255,0.42)_44%,rgba(191,219,254,0.84)_100%)]"
            aria-hidden="true"></div>

        <!-- Dekorasi Bulatan Blur -->
        <div class="pointer-events-none absolute -left-24 bottom-[-7rem] h-[22rem] w-[28rem] rounded-[60%_40%_55%_45%/50%_60%_40%_50%] bg-white/55 blur-[2px]"
            aria-hidden="true"></div>
        <div class="pointer-events-none absolute -right-16 -top-16 h-56 w-72 rounded-[45%_55%_40%_60%/55%_45%_60%_40%] bg-white/40"
            aria-hidden="true"></div>
        <div class="pointer-events-none absolute inset-y-0 right-0 hidden w-[46%] bg-[radial-gradient(circle,_rgba(9,16,87,0.18)_1.5px,_transparent_1.5px)] [background-size:20px_20px] opacity-70 md:block"
            aria-hidden="true"></div>

        <div class="relative z-10 mx-auto flex min-h-screen w-full max-w-6xl items-center px-6 py-10 lg:px-10">
            <div
                class="grid w-full gap-10 lg:grid-cols-[minmax(0,1fr)_360px] lg:items-center xl:grid-cols-[minmax(0,1fr)_380px]">

                <!-- Teks Sebelah Kiri -->
                <section class="max-w-xl animate-fade-up [--animation-delay:0.1s]">
                    <div
                        class="mb-5 inline-flex items-center gap-3 rounded-full border border-white/70 bg-white/55 px-4 py-2 text-sm font-semibold text-slate-700 shadow-[0_10px_30px_rgba(15,23,42,0.08)] backdrop-blur-md">
                        <span class="h-2.5 w-2.5 rounded-full bg-orange-500"></span>
                        Portal Login POLTREE
                    </div>

                    <h1 class="max-w-lg text-4xl font-extrabold leading-tight tracking-tight text-[#091057] sm:text-5xl">
                        Selamat Datang!
                    </h1>

                    <p class="mt-4 max-w-md text-lg leading-8 text-slate-700 sm:text-xl">
                        Masukkan Email Portal dan Password Anda untuk melanjutkan ke sistem.
                    </p>

                    <div class="mt-8 hidden max-w-md gap-3 sm:grid">
                        <div
                            class="rounded-2xl border border-white/70 bg-white/45 px-4 py-3 text-sm text-slate-700 shadow-[0_14px_36px_rgba(15,23,42,0.08)] backdrop-blur-md">
                            Akses cepat untuk dosen dan mahasiswa dalam satu portal yang lebih ringkas.
                        </div>
                        <div
                            class="rounded-2xl border border-white/70 bg-white/40 px-4 py-3 text-sm text-slate-600 shadow-[0_14px_36px_rgba(15,23,42,0.06)] backdrop-blur-md">
                            Tampilan login sudah dipadatkan supaya nyaman di laptop maupun mobile.
                        </div>
                    </div>
                </section>

                <!-- Form Glassmorphism Sebelah Kanan -->
                <section
                    class="w-full max-w-sm animate-fade-in rounded-[28px] border border-white/75 bg-white/28 p-5 shadow-[0_20px_60px_rgba(15,23,42,0.14)] backdrop-blur-xl [--animation-delay:0.25s] sm:p-6"
                    aria-label="Form login">
                    <div class="mb-5">
                        <h2 class="text-xl font-bold text-[#091057]">Masuk ke POLTREE</h2>
                        <p class="mt-1 text-sm leading-6 text-slate-600">Gunakan akun Anda untuk mengakses layanan kampus.
                        </p>
                    </div>

                    <!-- Pesan Error Dinamis -->
                    @if ($errors->any())
                        <div class="mb-4 rounded-2xl border border-red-200/80 bg-red-50/85 px-4 py-3 text-sm leading-6 text-red-700 shadow-sm"
                            role="alert">
                            @foreach ($errors->all() as $error)
                                <div>{{ $error }}</div>
                            @endforeach
                        </div>
                    @endif

                    <form method="POST" action="{{ route('login') }}" class="space-y-3" novalidate>
                        @csrf

                        <!-- Input EMAIL (Telah diubah dari username ke email agar sesuai backend kita) -->
                        <div class="space-y-1.5">
                            <label for="email" class="sr-only">Email Portal</label>
                            <div class="group relative">
                                <span
                                    class="pointer-events-none absolute inset-y-0 left-4 flex items-center text-orange-500">
                                    <svg class="h-[18px] w-[18px]" viewBox="0 0 24 24" fill="none" aria-hidden="true">
                                        <path
                                            d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"
                                            fill="currentColor" />
                                    </svg>
                                </span>
                                <input id="email" type="email" name="email" autocomplete="email"
                                    value="{{ old('email') }}" placeholder="email@polibatam.ac.id" required autofocus
                                    class="h-12 w-full rounded-2xl border border-white/80 bg-white/85 pl-12 pr-4 text-sm font-medium text-slate-700 shadow-[inset_0_1px_0_rgba(255,255,255,0.7)] transition duration-200 placeholder:text-slate-400 focus:border-[#091057] focus:bg-white focus:ring-4 focus:ring-[#091057]/10">
                            </div>
                        </div>

                        <!-- Input PASSWORD -->
                        <div class="space-y-1.5">
                            <label for="password" class="sr-only">Kata Sandi</label>
                            <div class="group relative">
                                <span
                                    class="pointer-events-none absolute inset-y-0 left-4 flex items-center text-orange-500">
                                    <svg class="h-[18px] w-[18px]" viewBox="0 0 24 24" fill="none" aria-hidden="true">
                                        <path
                                            d="M7 14q-1.25 0-2.125-.875T4 11t.875-2.125T7 8t2.125.875T10 11t-.875 2.125T7 14m0 4q-2.9 0-4.95-2.05T0 11t2.05-4.95T7 4q2.5 0 4.463 1.45T14.2 9H21l2 2-3 3-2-2-2 2-2-2H14.2q-.775 2.1-2.737 3.55T7 18z"
                                            fill="currentColor" />
                                    </svg>
                                </span>
                                <input id="password" type="password" name="password" autocomplete="current-password"
                                    placeholder="Password" required
                                    class="h-12 w-full rounded-2xl border border-white/80 bg-white/85 pl-12 pr-4 text-sm font-medium text-slate-700 shadow-[inset_0_1px_0_rgba(255,255,255,0.7)] transition duration-200 placeholder:text-slate-400 focus:border-[#091057] focus:bg-white focus:ring-4 focus:ring-[#091057]/10">
                            </div>
                        </div>

                        <button type="submit"
                            class="mt-2 inline-flex h-12 w-full items-center justify-center rounded-2xl bg-[#091057] text-sm font-semibold tracking-[0.03em] text-white shadow-[0_14px_30px_rgba(9,16,87,0.24)] transition duration-200 hover:bg-[#0d1a7a] hover:shadow-[0_18px_34px_rgba(9,16,87,0.28)] active:scale-[0.99]">
                            Masuk
                        </button>

                        <span
                            class="block pt-1 text-center text-sm font-medium text-blue-800 hover:text-[#091057] cursor-pointer transition">
                            Lupa password?
                        </span>
                    </form>
                </section>
            </div>
        </div>
    </div>
@endsection
