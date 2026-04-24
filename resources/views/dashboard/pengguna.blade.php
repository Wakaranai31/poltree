<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Dashboard Pengguna - {{ config('app.name', 'POLTREE') }}</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        /* Warna utama */
        :root {
            --navy: #080d5f;
            --orange: #ff3f0a;
            --muted: #777b87;
            --line: #8f8f8f;
            --chip: #d8d9dd;
            --green: #13e533;
        }

        /* Reset elemen */
        * {
            box-sizing: border-box;
        }

        /* Tampilan halaman */
        body {
            margin: 0;
            min-height: 100vh;
            background: #ffffff;
            color: var(--navy);
            font-family: 'Poppins', sans-serif;
        }

        body.modal-open {
            overflow: hidden;
        }

        button,
        input,
        a {
            font: inherit;
        }

        a {
            color: inherit;
            text-decoration: none;
        }

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

        /* Layout dashboard */
        .dashboard-page {
            width: 100%;
            min-height: 100vh;
            overflow-x: hidden;
            background: #ffffff;
        }

        /* Header dashboard */
        .topbar {
            position: relative;
            z-index: 8;
            min-height: 78px;
            display: flex;
            align-items: center;
            gap: 26px;
            padding: 16px 42px;
            background: #ffffff;
            border-bottom: 3px solid #2418b8;
        }

        /* Logo aplikasi */
        .brand {
            display: flex;
            align-items: center;
            gap: 10px;
            font-size: 21px;
            font-weight: 800;
            letter-spacing: 0.01em;
        }

        /* Titik logo */
        .brand-dot {
            width: 29px;
            height: 29px;
            border-radius: 999px;
            background: var(--orange);
        }

        /* Teks logo */
        .brand-orange {
            color: var(--orange);
        }

        /* Tombol navigasi */
        .nav-pill {
            min-width: 136px;
            height: 42px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border: 2px solid var(--navy);
            border-radius: 999px;
            background: #ffffff;
            color: var(--navy);
            font-size: 16px;
            font-weight: 800;
            box-shadow: 0 4px 10px rgba(8, 13, 95, 0.18);
        }

        /* Aksi header */
        .topbar-actions {
            margin-left: auto;
            display: flex;
            align-items: center;
            gap: 22px;
        }

        /* Form pencarian */
        .search-box {
            width: clamp(360px, 36vw, 600px);
            height: 42px;
            display: flex;
            align-items: center;
            gap: 14px;
            padding: 0 18px;
            border: 2px solid var(--navy);
            border-radius: 999px;
            background: #ffffff;
            box-shadow: 0 4px 10px rgba(8, 13, 95, 0.18);
        }

        /* Tombol cari */
        .search-box button {
            border: 0;
            background: transparent;
            color: var(--navy);
            cursor: pointer;
            font-size: 14px;
            font-weight: 800;
            padding: 0;
        }

        /* Ikon cari */
        .search-box svg {
            width: 18px;
            height: 18px;
            color: var(--navy);
            flex: 0 0 auto;
        }

        /* Input cari */
        .search-box input {
            width: 100%;
            border: 0;
            outline: 0;
            background: transparent;
            color: #33384f;
            font-size: 14px;
        }

        /* Placeholder cari */
        .search-box input::placeholder {
            color: #8d8f9c;
        }

        /* Tombol ikon */
        .profile-menu-wrap {
            position: relative;
        }

        .profile-icon {
            width: 42px;
            height: 42px;
            display: grid;
            place-items: center;
            border: 0;
            background: transparent;
            color: var(--orange);
            padding: 0;
            cursor: pointer;
        }

        .profile-icon svg {
            width: 32px;
            height: 32px;
        }

        .profile-panel {
            position: absolute;
            top: calc(100% + 18px);
            right: -10px;
            width: min(288px, calc(100vw - 36px));
            padding: 18px;
            border: 2px solid rgba(255, 255, 255, 0.92);
            border-radius: 26px;
            background: rgba(206, 190, 194, 0.94);
            box-shadow: 0 18px 36px rgba(8, 13, 95, 0.2);
        }

        .profile-panel-actions {
            display: grid;
            gap: 12px;
        }

        .profile-panel-form {
            margin: 0;
        }

        .profile-panel-btn {
            width: 100%;
            min-height: 50px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            padding: 10px 18px;
            border: 0;
            border-radius: 18px;
            background: #ffffff;
            color: var(--orange);
            box-shadow: 0 8px 18px rgba(8, 13, 95, 0.08);
            font-size: 16px;
            font-weight: 700;
            cursor: pointer;
            text-align: center;
        }

        .profile-panel-btn svg {
            width: 20px;
            height: 20px;
            color: currentColor;
            flex: 0 0 auto;
        }

        /* Modal logout */
        .logout-modal {
            position: fixed;
            inset: 0;
            z-index: 50;
            display: none;
            align-items: center;
            justify-content: center;
            padding: 24px;
            background: rgba(20, 28, 84, 0.22);
            backdrop-filter: blur(7px);
        }

        /* Modal logout aktif */
        .logout-modal:target {
            display: flex;
        }

        /* Bungkus modal */
        .logout-shell {
            width: min(100%, 440px);
            padding: 18px;
            border-radius: 18px;
            background: rgba(8, 13, 95, 0.72);
            box-shadow: 0 12px 30px rgba(8, 13, 95, 0.28);
        }

        /* Kartu modal */
        .logout-card {
            padding: 18px 26px 16px;
            border-radius: 16px;
            background: #ffffff;
            text-align: center;
            box-shadow: inset 0 0 0 1px rgba(8, 13, 95, 0.06);
        }

        /* Judul modal */
        .logout-card h2 {
            margin: 0 0 16px;
            color: var(--navy);
            font-size: 15px;
            font-weight: 800;
        }

        /* Aksi modal */
        .logout-actions {
            display: flex;
            justify-content: center;
            gap: 18px;
        }

        /* Tombol modal */
        .logout-btn {
            min-width: 72px;
            height: 28px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border: 1.5px solid #c8cedf;
            border-radius: 8px;
            background: #ffffff;
            color: var(--navy);
            box-shadow: 0 2px 4px rgba(8, 13, 95, 0.16);
            font-size: 12px;
            font-weight: 700;
            cursor: pointer;
        }

        /* Banner utama */
        .hero {
            position: relative;
            height: 465px;
            overflow: hidden;
            background: #dce7ef;
        }

        /* Lapisan banner */
        .hero::after {
            content: "";
            position: absolute;
            inset: 0;
        }

        /* Gambar banner */
        .hero-slide {
            position: absolute;
            inset: 0;
            opacity: 0;
            background-position: center 42%;
            background-size: cover;
            background-repeat: no-repeat;
            transform: scale(1.08);
            animation: campus-slide var(--hero-duration, 16s) ease-in-out infinite;
        }

        /* Gambar banner tunggal */
        .hero-slide.only {
            opacity: 1;
            animation: campus-pan 3s ease-in-out infinite alternate;
        }

        /* Overlay banner */
        .hero::after {
            background: linear-gradient(180deg, rgba(255, 255, 255, 0.28) 0%, rgba(255, 255, 255, 0.34) 62%, rgba(8, 13, 95, 0.78) 100%);
            z-index: 1;
        }

        /* Animasi slider */
        @keyframes campus-slide {
            0% {
                opacity: 0;
                background-position: 38% 42%;
            }

            8%,
            30% {
                opacity: 1;
            }

            42%,
            100% {
                opacity: 0;
                background-position: 62% 42%;
            }
        }

        /* Animasi banner tunggal */
        @keyframes campus-pan {
            0% {
                background-position: 38% 42%;
            }

            100% {
                background-position: 62% 42%;
            }
        }

        /* Filter kategori */
        .role-switcher {
            position: absolute;
            z-index: 2;
            left: 50%;
            bottom: 64px;
            width: 728px;
            height: 101px;
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            align-items: center;
            gap: 28px;
            padding: 13px 43px;
            border-radius: 999px;
            background: #ffffff;
            transform: translateX(-50%);
        }

        /* Tombol kategori */
        .role-item {
            height: 55px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 9px;
            border: 0;
            border-radius: 999px;
            background: transparent;
            color: var(--navy);
            cursor: pointer;
            font-size: 16px;
            font-weight: 800;
        }

        /* Kategori aktif */
        .role-item.active {
            background: var(--navy);
            color: #ffffff;
        }

        /* Ikon kategori */
        .role-item svg {
            width: 21px;
            height: 21px;
            color: currentColor;
        }

        /* Menu shortcut */
        .shortcut-bar {
            position: relative;
            z-index: 6;
            height: 67px;
            display: grid;
            grid-template-columns: repeat(3, 264px);
            justify-content: space-between;
            align-items: center;
            padding: 0 67px;
            background: var(--navy);
            overflow: visible;
        }

        .shortcut-group {
            position: relative;
            width: 264px;
        }

        /* Tombol shortcut */
        .shortcut {
            width: 100%;
            height: 41px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 9px;
            border: 0;
            border-radius: 6px;
            background: #ffffff;
            color: var(--navy);
            font-size: 16px;
            font-weight: 800;
        }

        .shortcut.is-menu {
            justify-content: space-between;
            padding: 0 18px 0 22px;
        }

        .shortcut-main {
            display: inline-flex;
            align-items: center;
            gap: 9px;
        }

        .shortcut-caret {
            width: 18px;
            height: 18px;
            flex: 0 0 auto;
        }

        /* Ikon shortcut */
        .shortcut svg {
            width: 20px;
            height: 20px;
            color: currentColor;
        }

        .shortcut-category-menu {
            position: absolute;
            top: calc(100% + 14px);
            left: 0;
            width: 360px;
            max-width: min(360px, calc(100vw - 48px));
            padding: 18px 18px 20px;
            border-radius: 16px;
            background: #ffffff;
            box-shadow: 0 18px 36px rgba(8, 13, 95, 0.18);
        }

        .shortcut-category-menu .service-category-list {
            max-height: 260px;
        }

        /* Bagian kartu layanan */
        .cards-section {
            padding: 62px 55px 44px;
        }

        /* Grid kartu layanan */
        .cards-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(306px, 1fr));
            gap: 34px;
        }

        /* Kartu layanan */
        .service-card {
            position: relative;
            overflow: hidden;
            height: 194px;
            padding: 27px 21px 19px;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            border: 2px solid var(--line);
            border-radius: 8px;
            background: #ffffff;
            box-shadow: 3px 4px 4px rgba(0, 0, 0, 0.35);
            transition: transform 0.14s ease, box-shadow 0.14s ease;
        }

        .service-card>*:not(.service-card-trigger) {
            position: relative;
            z-index: 1;
            pointer-events: none;
        }

        .service-card-trigger {
            position: absolute;
            inset: 0;
            z-index: 2;
            border-radius: inherit;
        }

        .service-card-trigger:focus-visible {
            outline: 3px solid rgba(8, 13, 95, 0.34);
            outline-offset: -3px;
        }

        /* Efek hover kartu */
        .service-card:hover {
            transform: translateY(-3px);
            box-shadow: 5px 7px 6px rgba(0, 0, 0, 0.28);
        }

        /* Header kartu */
        .card-heading {
            display: flex;
            align-items: center;
            gap: 13px;
            margin-bottom: 15px;
        }

        /* Logo mini kartu */
        .polibatam-mini {
            position: relative;
            width: 29px;
            height: 23px;
            flex: 0 0 29px;
        }

        /* Bentuk logo mini */
        .polibatam-mini::before {
            content: "";
            position: absolute;
            top: 1px;
            left: 5px;
            width: 21px;
            height: 13px;
            border-radius: 999px 999px 999px 2px;
            background: #67d8ee;
            transform: rotate(-8deg);
        }

        /* Teks logo mini */
        .polibatam-mini::after {
            content: "pol";
            position: absolute;
            left: 1px;
            bottom: 2px;
            color: #f05a28;
            font-size: 7px;
            font-weight: 800;
            letter-spacing: -0.06em;
        }

        /* Judul kartu */
        .card-heading h2 {
            margin: 0;
            color: var(--navy);
            font-size: 17px;
            line-height: 1.1;
            font-weight: 800;
        }

        /* Deskripsi layanan */
        .service-card p {
            width: min(100%, 270px);
            margin: 0;
            color: var(--muted);
            font-size: 9.2px;
            line-height: 1.35;
            letter-spacing: -0.01em;
        }

        /* Metadata layanan */
        .card-meta {
            display: flex;
            align-items: center;
            gap: 8px;
            min-height: 14px;
        }

        /* Status layanan */
        .status-dot {
            width: 12px;
            height: 12px;
            border-radius: 999px;
            background: var(--green);
            flex: 0 0 auto;
        }

        /* Status offline */
        .status-dot.offline {
            background: #ff3f0a;
        }

        /* Tag layanan */
        .tag {
            min-width: 31px;
            height: 8px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: 999px;
            background: var(--chip);
            color: #6e7280;
            font-size: 4.8px;
            font-weight: 800;
            line-height: 1;
        }

        /* Titik tag */
        .tag::before {
            content: "";
            width: 5px;
            height: 5px;
            margin-right: 3px;
            border-radius: 999px;
            background: var(--navy);
        }

        /* Kartu kosong */
        .empty-card {
            grid-column: 1 / -1;
            height: 120px;
            display: grid;
            place-items: center;
            border: 2px dashed var(--line);
            border-radius: 8px;
            color: var(--muted);
            font-size: 14px;
            font-weight: 600;
        }

        /* Modal detail layanan */
        .service-modal {
            position: fixed;
            inset: 0;
            z-index: 55;
            display: none;
            align-items: center;
            justify-content: center;
            padding: 24px;
            background: rgba(20, 28, 84, 0.22);
            backdrop-filter: blur(7px);
        }

        .service-modal.is-open {
            display: flex;
        }

        .service-modal-shell {
            width: min(100%, 1220px);
            padding: 14px;
            border-radius: 32px;
            background: rgba(255, 255, 255, 0.82);
            box-shadow: 0 18px 45px rgba(8, 13, 95, 0.2);
        }

        .service-modal-card {
            position: relative;
            padding: 44px 48px 34px;
            border-radius: 28px;
            background: linear-gradient(180deg, #141b75 0%, #10176f 100%);
            color: #ffffff;
        }

        .service-modal-close {
            position: absolute;
            top: 18px;
            right: 18px;
            width: 42px;
            height: 42px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border: 0;
            border-radius: 999px;
            background: rgba(255, 255, 255, 0.14);
            color: #ffffff;
            cursor: pointer;
        }

        .service-modal-close svg {
            width: 18px;
            height: 18px;
        }

        .service-modal-header {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 18px;
            margin-bottom: 30px;
            padding-right: 48px;
        }

        .service-modal-logo {
            position: relative;
            width: 52px;
            height: 40px;
            flex: 0 0 52px;
        }

        .service-modal-logo::before {
            content: "";
            position: absolute;
            top: 4px;
            left: 7px;
            width: 38px;
            height: 24px;
            border-radius: 999px 999px 999px 3px;
            background: linear-gradient(135deg, #96f6ff 0%, #55d0ea 70%);
            transform: rotate(-9deg);
        }

        .service-modal-logo::after {
            content: "polibatam";
            position: absolute;
            left: 0;
            bottom: -2px;
            color: #f39c7a;
            font-size: 9px;
            font-weight: 700;
            letter-spacing: -0.04em;
        }

        .service-modal-title {
            margin: 0;
            font-size: clamp(24px, 2.8vw, 30px);
            line-height: 1.18;
            font-weight: 800;
        }

        .service-modal-description {
            margin: 0;
            padding: 16px 22px;
            border-radius: 16px;
            background: #ffffff;
            color: var(--navy);
            font-size: clamp(18px, 2.1vw, 22px);
            line-height: 1.55;
            box-shadow: inset 0 0 0 1px rgba(8, 13, 95, 0.06);
        }

        .service-modal-footer {
            margin-top: 28px;
            display: grid;
            grid-template-columns: minmax(0, 1fr) minmax(360px, 430px) minmax(280px, 330px);
            align-items: start;
            gap: 24px;
        }

        .service-modal-meta {
            display: flex;
            align-items: center;
            gap: 14px;
            flex-wrap: wrap;
        }

        .service-modal-status-dot {
            width: 34px;
            height: 34px;
            border-radius: 999px;
            background: var(--green);
            box-shadow: 0 0 18px rgba(19, 229, 51, 0.38);
            flex: 0 0 auto;
        }

        .service-modal-status-dot.offline {
            background: var(--orange);
            box-shadow: 0 0 18px rgba(255, 63, 10, 0.32);
        }

        .service-modal-category {
            min-height: 34px;
            display: inline-flex;
            align-items: center;
            gap: 10px;
            padding: 4px 16px 4px 8px;
            border-radius: 999px;
            background: #e4e6ec;
            color: var(--navy);
            font-size: 15px;
            font-weight: 600;
        }

        .service-modal-category::before {
            content: "";
            width: 22px;
            height: 22px;
            border-radius: 999px;
            background: var(--navy);
        }

        .service-modal-pill {
            min-height: 34px;
            display: inline-flex;
            align-items: center;
            padding: 6px 14px;
            border-radius: 999px;
            background: rgba(255, 255, 255, 0.16);
            color: #ffffff;
            font-size: 14px;
            font-weight: 600;
        }

        .service-modal-action-group {
            position: relative;
            width: 100%;
        }

        .service-modal-secondary,
        .service-modal-primary {
            min-width: 220px;
            min-height: 56px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            padding: 0 20px;
            border: 0;
            border-radius: 14px;
            font-size: 14px;
            font-weight: 700;
            cursor: pointer;
            text-decoration: none;
        }

        .service-modal-secondary {
            width: 100%;
            min-width: 0;
            min-height: 56px;
            justify-content: space-between;
            padding: 0 20px 0 22px;
            border-radius: 16px;
            background: #b6bad8;
            color: var(--navy);
            box-shadow: 0 10px 22px rgba(5, 12, 71, 0.18);
        }

        .service-modal-secondary[aria-expanded="true"] {
            background: #ffffff;
        }

        .service-modal-primary {
            width: 100%;
            background: var(--orange);
            color: #ffffff;
            box-shadow: 0 8px 18px rgba(255, 63, 10, 0.28);
        }

        .service-modal-secondary svg,
        .service-modal-primary svg {
            width: 18px;
            height: 18px;
            color: currentColor;
        }

        .service-modal-primary.is-disabled {
            opacity: 0.62;
            pointer-events: none;
        }

        .service-modal-secondary-main {
            display: inline-flex;
            align-items: center;
            gap: 12px;
        }

        .service-modal-secondary-main svg {
            width: 22px;
            height: 22px;
        }

        .service-modal-secondary-label {
            font-size: 18px;
            font-weight: 800;
        }

        .service-modal-url {
            margin: 18px 0 0;
            color: rgba(255, 255, 255, 0.78);
            font-size: 13px;
            line-height: 1.5;
            word-break: break-all;
        }

        .service-category-menu {
            position: absolute;
            top: calc(100% + 14px);
            left: 0;
            width: 100%;
            min-width: 0;
            padding: 20px 18px 18px;
            border-radius: 18px;
            background: #ffffff;
            box-shadow: 0 18px 36px rgba(5, 12, 71, 0.22);
            z-index: 4;
            overflow: hidden;
        }

        .service-category-search {
            width: 100%;
            min-height: 58px;
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 0 20px;
            border: 0;
            border-radius: 16px;
            background: #141b75;
            color: #ffffff;
            box-shadow: 0 8px 18px rgba(5, 12, 71, 0.22);
        }

        .service-category-search svg {
            width: 20px;
            height: 20px;
            color: #ffffff;
            flex: 0 0 auto;
        }

        .service-category-search input {
            width: 100%;
            border: 0;
            outline: 0;
            background: transparent;
            color: #ffffff;
            font-size: 15px;
            font-weight: 500;
        }

        .service-category-search input::placeholder {
            color: rgba(255, 255, 255, 0.84);
        }

        .service-category-list {
            margin-top: 18px;
            display: grid;
            gap: 12px;
            max-height: 260px;
            overflow-y: auto;
            padding-right: 8px;
        }

        .service-category-option {
            width: 100%;
            min-height: 72px;
            display: grid;
            grid-template-columns: 24px minmax(0, 1fr) 18px;
            align-items: center;
            justify-content: stretch;
            column-gap: 14px;
            padding: 16px 18px;
            border: 0;
            border-radius: 16px;
            background: #ffffff;
            color: var(--navy);
            box-shadow: 0 6px 14px rgba(5, 12, 71, 0.16);
            font-size: 15px;
            font-weight: 700;
            text-align: left;
            cursor: pointer;
        }

        .service-category-option-label {
            flex: 1 1 auto;
            min-width: 0;
            line-height: 1.35;
            white-space: normal;
            overflow-wrap: anywhere;
        }

        .service-category-option-check {
            width: 18px;
            height: 18px;
            border-radius: 999px;
            background: transparent;
            box-shadow: inset 0 0 0 2px #bcc4d8;
            flex: 0 0 auto;
        }

        .service-category-option.is-active {
            background: #eef0ff;
        }

        .service-category-option.is-active .service-category-option-check {
            background: var(--navy);
            box-shadow: inset 0 0 0 2px #ffffff;
        }

        .service-category-option-icon {
            width: 24px;
            height: 24px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            color: var(--navy);
            flex: 0 0 auto;
        }

        .service-category-option-icon svg {
            width: 22px;
            height: 22px;
        }

        .service-category-empty {
            display: none;
            margin-top: 18px;
            padding: 14px 16px;
            border-radius: 14px;
            background: #f4f6fb;
            color: var(--muted);
            font-size: 14px;
            font-weight: 600;
            text-align: center;
        }

        .service-category-empty.is-visible {
            display: block;
        }

        .service-category-add {
            width: 100%;
            height: 54px;
            margin-top: 18px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 12px;
            border: 0;
            border-radius: 16px;
            background: #141b75;
            color: #ffffff;
            box-shadow: 0 8px 18px rgba(5, 12, 71, 0.24);
            font-size: 16px;
            font-weight: 700;
            cursor: pointer;
        }

        .service-category-add svg {
            width: 18px;
            height: 18px;
        }

        .category-builder-modal {
            position: fixed;
            inset: 0;
            z-index: 60;
            display: none;
            align-items: center;
            justify-content: center;
            padding: 24px;
            background: rgba(10, 17, 84, 0.18);
            backdrop-filter: blur(4px);
        }

        .category-builder-modal.is-open {
            display: flex;
        }

        .category-builder-shell {
            width: min(100%, 760px);
            padding: 12px;
            border: 3px solid #1a1d75;
            border-radius: 22px;
            background: rgba(255, 255, 255, 0.96);
            box-shadow: 0 22px 42px rgba(8, 13, 95, 0.18);
        }

        .category-builder-card {
            min-height: 340px;
            padding: 30px 28px 24px;
            display: flex;
            flex-direction: column;
            border-radius: 20px;
            background: #1b2078;
            box-shadow: 0 12px 24px rgba(8, 13, 95, 0.24);
        }

        .category-builder-header {
            width: min(100%, 560px);
            margin: 0 auto;
            display: grid;
            grid-template-columns: minmax(0, 1fr) auto;
            gap: 14px;
            align-items: center;
        }

        .category-builder-title-wrap {
            position: relative;
            width: 100%;
            margin: 0;
        }

        .category-builder-title {
            width: 100%;
            height: 58px;
            padding: 0 52px 0 18px;
            border: 0;
            outline: 0;
            border-radius: 16px;
            background: rgba(212, 214, 233, 0.72);
            color: #ffffff;
            font-size: 17px;
            font-weight: 600;
        }

        .category-builder-title::placeholder {
            color: rgba(255, 255, 255, 0.84);
        }

        .category-builder-title-icon {
            position: absolute;
            top: 50%;
            right: 14px;
            transform: translateY(-50%);
            width: 22px;
            height: 22px;
            color: rgba(255, 255, 255, 0.92);
            pointer-events: none;
        }

        .category-builder-reset {
            width: 48px;
            height: 48px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border: 0;
            border-radius: 14px;
            background: rgba(255, 255, 255, 0.14);
            color: #ffffff;
            cursor: pointer;
        }

        .category-builder-reset svg {
            width: 28px;
            height: 28px;
        }

        .category-builder-body {
            width: min(100%, 560px);
            margin: 28px auto 0;
            display: grid;
            gap: 16px;
        }

        .category-builder-link-add {
            width: 100%;
            min-height: 58px;
            margin: 0;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 14px;
            border: 0;
            border-radius: 16px;
            background: #ececef;
            color: var(--navy);
            box-shadow: 0 8px 18px rgba(8, 13, 95, 0.18);
            font-size: 17px;
            font-weight: 700;
            cursor: pointer;
        }

        .category-builder-link-add svg {
            width: 24px;
            height: 24px;
        }

        .category-builder-links {
            display: grid;
            gap: 14px;
        }

        .category-builder-link-row {
            display: grid;
            grid-template-columns: minmax(0, 1fr) auto;
            gap: 12px;
            align-items: center;
        }

        .category-builder-link-input {
            width: 100%;
            min-height: 54px;
            padding: 0 18px;
            border: 0;
            outline: 0;
            border-radius: 14px;
            background: rgba(255, 255, 255, 0.96);
            color: var(--navy);
            font-size: 16px;
            font-weight: 500;
            box-shadow: 0 8px 18px rgba(8, 13, 95, 0.16);
        }

        .category-builder-link-input::placeholder {
            color: #9ba2ba;
        }

        .category-builder-link-remove {
            width: 50px;
            height: 50px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border: 0;
            border-radius: 14px;
            background: rgba(255, 255, 255, 0.18);
            color: #ffffff;
            cursor: pointer;
        }

        .category-builder-link-remove svg {
            width: 20px;
            height: 20px;
        }

        .category-builder-empty {
            margin: 0;
            color: rgba(255, 255, 255, 0.8);
            font-size: 15px;
            text-align: center;
        }

        .category-builder-footer {
            width: min(100%, 560px);
            margin: 24px auto 0;
            padding-top: 0;
            display: flex;
            justify-content: flex-end;
        }

        .category-builder-save {
            min-width: 190px;
            height: 56px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border: 0;
            border-radius: 16px;
            background: #e7e8ef;
            color: var(--navy);
            box-shadow: 0 8px 18px rgba(8, 13, 95, 0.18);
            font-size: 18px;
            font-weight: 700;
            cursor: pointer;
        }

        /* Tampilan responsif */
        @media (max-width: 980px) {
            .topbar {
                height: auto;
                flex-direction: column;
                align-items: stretch;
                padding: 16px 24px;
            }

            .topbar-actions {
                margin-left: 0;
                flex-wrap: wrap;
                justify-content: flex-end;
                gap: 16px;
            }

            .nav-pill {
                min-width: 120px;
            }

            .profile-panel {
                right: 0;
            }

            .role-switcher {
                width: min(728px, calc(100% - 34px));
                height: auto;
                grid-template-columns: 1fr;
                gap: 8px;
                border-radius: 30px;
            }

            .shortcut-bar,
            .cards-grid {
                grid-template-columns: 1fr;
            }

            .shortcut-bar {
                height: auto;
                gap: 14px;
                padding: 14px 24px;
            }

            .shortcut-group {
                width: 100%;
            }

            .shortcut,
            .service-card {
                width: 100%;
            }

            .shortcut-category-menu {
                width: min(100%, 360px);
            }

            .cards-section {
                padding: 32px 24px;
            }

            .service-modal {
                padding: 18px;
            }

            .service-modal-card {
                padding: 62px 20px 22px;
            }

            .service-modal-header {
                justify-content: flex-start;
                margin-bottom: 22px;
                padding-right: 0;
            }

            .service-modal-footer {
                grid-template-columns: 1fr;
            }

            .service-modal-secondary,
            .service-modal-primary {
                width: 100%;
                min-width: 0;
            }

            .service-modal-action-group {
                width: 100%;
            }

            .category-builder-card {
                padding: 28px 20px 24px;
            }

            .category-builder-header {
                width: 100%;
                grid-template-columns: 1fr auto;
            }

            .category-builder-body,
            .category-builder-footer {
                width: 100%;
            }
        }

        @media (max-width: 640px) {
            .topbar {
                padding: 14px 18px;
            }

            .topbar-actions {
                justify-content: flex-start;
            }

            .nav-pill,
            .search-box {
                width: 100%;
            }

            .profile-menu-wrap {
                align-self: flex-end;
            }

            .shortcut-bar {
                padding: 14px 18px;
            }

            .shortcut-category-menu {
                width: 100%;
                max-width: none;
            }

            .category-builder-modal {
                padding: 16px;
            }

            .category-builder-shell {
                padding: 8px;
            }

            .category-builder-card {
                min-height: 340px;
                padding: 22px 14px 20px;
            }

            .category-builder-header {
                width: 100%;
                gap: 12px;
            }

            .category-builder-title-wrap {
                width: 100%;
            }

            .category-builder-body,
            .category-builder-footer {
                width: 100%;
            }

            .category-builder-link-add,
            .category-builder-save {
                width: 100%;
            }

            .category-builder-link-row {
                grid-template-columns: 1fr;
            }

            .service-modal-shell {
                padding: 10px;
                border-radius: 24px;
            }

            .service-modal-card {
                border-radius: 22px;
            }

            .service-modal-header {
                flex-direction: column;
                align-items: flex-start;
                gap: 10px;
            }

            .service-modal-description {
                font-size: 16px;
                padding: 16px 18px;
            }
        }
    </style>
</head>

<body>
    <div class="dashboard-page">
        {{-- Header dashboard --}}
        <header class="topbar">
            <div class="brand" aria-label="POLTREE">
                <span class="brand-dot"></span>
                <span>Pol<span class="brand-orange">Tree</span></span>
            </div>

            {{-- Aksi header --}}
            <div class="topbar-actions">
                <button type="button" class="nav-pill">Laporan</button>

                {{-- Form pencarian --}}
                <form class="search-box" role="search" action="{{ route('pengguna.dashboard') }}" method="GET">
                    <input type="hidden" name="role" value="{{ $activeRole }}">
                    <svg viewBox="0 0 24 24" fill="none" aria-hidden="true">
                        <path d="M10.8 18.1a7.3 7.3 0 1 1 0-14.6 7.3 7.3 0 0 1 0 14.6Zm6-1.3 3.7 3.7" stroke="currentColor" stroke-width="2" stroke-linecap="round" />
                    </svg>
                    <input type="text" name="q" value="{{ $search }}" placeholder="Cari.." aria-label="Cari">
                    <button type="submit">Cari</button>
                </form>

                {{-- Tombol profil --}}
                <div class="profile-menu-wrap">
                    <button
                        type="button"
                        class="profile-icon"
                        aria-label="Profil pengguna"
                        aria-expanded="false"
                        data-profile-toggle
                    >
                        <svg viewBox="0 0 24 24" fill="none" aria-hidden="true">
                            <path d="M12 12.2a4.4 4.4 0 1 0 0-8.8 4.4 4.4 0 0 0 0 8.8Zm-7 8.4c.9-3.5 3.5-5.4 7-5.4s6.1 1.9 7 5.4" stroke="currentColor" stroke-width="2" stroke-linecap="round" />
                        </svg>
                    </button>

                    <div class="profile-panel" data-profile-panel hidden>
                        <div class="profile-panel-actions">
                            <button type="button" class="profile-panel-btn" data-profile-placeholder title="Fitur profil belum tersedia">
                                <svg viewBox="0 0 24 24" fill="none" aria-hidden="true">
                                    <path d="M12 12.2a4.4 4.4 0 1 0 0-8.8 4.4 4.4 0 0 0 0 8.8Zm-7 8.4c.9-3.5 3.5-5.4 7-5.4s6.1 1.9 7 5.4" stroke="currentColor" stroke-width="2" stroke-linecap="round" />
                                </svg>
                                <span>Profil</span>
                            </button>

                            <button type="button" class="profile-panel-btn" data-profile-placeholder title="Fitur ubah kata sandi belum tersedia">
                                <svg viewBox="0 0 24 24" fill="none" aria-hidden="true">
                                    <path d="M7 11V8a5 5 0 0 1 10 0v3M6 11h12v8H6v-8Zm5 4h2" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                </svg>
                                <span>Ubah Kata Sandi</span>
                            </button>

                            <form action="{{ route('logout') }}" method="POST" class="profile-panel-form">
                                @csrf
                                <button type="submit" class="profile-panel-btn">
                                    <svg viewBox="0 0 24 24" fill="none" aria-hidden="true">
                                        <path d="M10 6H7a2 2 0 0 0-2 2v8a2 2 0 0 0 2 2h3M14 8l4 4-4 4M18 12H9" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                    </svg>
                                    <span>Keluar</span>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </header>

        {{-- Banner dashboard --}}
        <section class="hero" aria-label="Foto kampus Politeknik Negeri Batam">
            {{-- Durasi slider banner --}}
            @php
                $heroStep = 3;
                $heroDuration = max($heroImages->count() * $heroStep, $heroStep);
            @endphp

            {{-- Gambar banner --}}
            @foreach ($heroImages as $index => $image)
                <span
                    class="hero-slide {{ $heroImages->count() === 1 ? 'only' : '' }}"
                    style="background-image: url('{{ $image }}'); --hero-duration: {{ $heroDuration }}s; animation-delay: -{{ $index * $heroStep }}s;"
                    aria-hidden="true"
                ></span>
            @endforeach

            {{-- Filter role pengguna --}}
            <div class="role-switcher" aria-label="Kategori pengguna">
                @foreach ($roles as $role)
                    <a
                        href="{{ route('pengguna.dashboard', ['role' => $role, 'q' => $search]) }}"
                        class="role-item {{ $activeRole === $role ? 'active' : '' }}"
                    >
                        @if ($role === 'Dosen')
                            <svg viewBox="0 0 24 24" fill="none" aria-hidden="true">
                                <path d="M4 18V9h16v9M7 9V6h10v3M9 18v-5h6v5" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                        @elseif ($role === 'Tata Usaha')
                            <svg viewBox="0 0 24 24" fill="none" aria-hidden="true">
                                <path d="M8 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6Zm8.5 1a2.5 2.5 0 1 0 0-5 2.5 2.5 0 0 0 0 5ZM3 20v-1.2A5.8 5.8 0 0 1 8.8 13h1.4M14 20v-1a4 4 0 0 1 4-4h.5" stroke="currentColor" stroke-width="2" stroke-linecap="round" />
                            </svg>
                        @else
                            <svg viewBox="0 0 24 24" fill="none" aria-hidden="true">
                                <path d="M9 3v6l-5.5 9.5A2 2 0 0 0 5.2 21h13.6a2 2 0 0 0 1.7-2.5L15 9V3M8 3h8M7.2 16h9.6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                        @endif
                        <span>{{ $role }}</span>
                    </a>
                @endforeach
            </div>
        </section>

        {{-- Menu shortcut --}}
        <section class="shortcut-bar" aria-label="Menu dashboard">
            <div class="shortcut-group">
                <button
                    type="button"
                    class="shortcut is-menu"
                    aria-expanded="false"
                    data-shortcut-category-toggle
                >
                    <span class="shortcut-main">
                        <svg viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                            <path d="M3 3h8v8H3V3Zm10 0h8v8h-8V3ZM3 13h8v8H3v-8Zm10 0h8v8h-8v-8Z" />
                        </svg>
                        <span data-shortcut-category-label>Kategori</span>
                    </span>
                    <svg class="shortcut-caret" viewBox="0 0 24 24" fill="none" aria-hidden="true">
                        <path d="m6 9 6 6 6-6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                </button>

                <div class="shortcut-category-menu" data-shortcut-category-menu hidden>
                    <label class="service-category-search">
                        <svg viewBox="0 0 24 24" fill="none" aria-hidden="true">
                            <path d="M10.8 18.1a7.3 7.3 0 1 1 0-14.6 7.3 7.3 0 0 1 0 14.6Zm6-1.3 3.7 3.7" stroke="currentColor" stroke-width="2" stroke-linecap="round" />
                        </svg>
                        <input type="text" placeholder="Cari..." data-category-search-input autocomplete="off" aria-label="Cari kategori shortcut">
                    </label>

                    <div class="service-category-list" data-category-list>
                        @foreach ($categories as $categoryOption)
                            @php
                                $categoryOptionLower = strtolower((string) $categoryOption);
                            @endphp
                            <button
                                type="button"
                                class="service-category-option"
                                data-category-option="{{ $categoryOption }}"
                            >
                                <span class="service-category-option-icon" aria-hidden="true">
                                    @if (str_contains($categoryOptionLower, 'akadem'))
                                        <svg viewBox="0 0 24 24" fill="none">
                                            <path d="M4 6.5A2.5 2.5 0 0 1 6.5 4H11v15H6.5A2.5 2.5 0 0 0 4 21V6.5ZM20 6.5A2.5 2.5 0 0 0 17.5 4H13v15h4.5A2.5 2.5 0 0 1 20 21V6.5Z" stroke="currentColor" stroke-width="1.8" stroke-linejoin="round" />
                                        </svg>
                                    @elseif (str_contains($categoryOptionLower, 'umum'))
                                        <svg viewBox="0 0 24 24" fill="none">
                                            <path d="M12 3a9 9 0 1 0 0 18 9 9 0 0 0 0-18Zm0 0c2.2 2.2 3.5 5.4 3.5 9S14.2 18.8 12 21m0-18C9.8 5.2 8.5 8.4 8.5 12S9.8 18.8 12 21m-8-9h16" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" />
                                        </svg>
                                    @else
                                        <svg viewBox="0 0 24 24" fill="none">
                                            <path d="M4 7.5A2.5 2.5 0 0 1 6.5 5H10l2 2h5.5A2.5 2.5 0 0 1 20 9.5v7a2.5 2.5 0 0 1-2.5 2.5h-11A2.5 2.5 0 0 1 4 16.5v-9Z" stroke="currentColor" stroke-width="1.8" stroke-linejoin="round" />
                                        </svg>
                                    @endif
                                </span>
                                <span class="service-category-option-label">{{ $categoryOption }}</span>
                                <span class="service-category-option-check" aria-hidden="true"></span>
                            </button>
                        @endforeach
                    </div>

                    <div class="service-category-empty" data-category-empty>
                        Kategori tidak ditemukan.
                    </div>

                    <button type="button" class="service-category-add" data-category-add>
                        <svg viewBox="0 0 24 24" fill="none" aria-hidden="true">
                            <path d="M12 5v14M5 12h14" stroke="currentColor" stroke-width="2" stroke-linecap="round" />
                        </svg>
                        <span>Tambah Kategori</span>
                    </button>
                </div>
            </div>

            <button type="button" class="shortcut">
                <svg viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                    <path d="M6 3h12a1 1 0 0 1 1 1v17l-7-4-7 4V4a1 1 0 0 1 1-1Z" />
                </svg>
                <span>Simpan</span>
            </button>

            <button type="button" class="shortcut">
                <svg viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                    <path d="M12 2a10 10 0 1 1-7.1 3H2V3h6v6H6V6.4A8 8 0 1 0 12 4V2Zm1 5v5.2l4 2.4-1 1.7-5-3V7h2Z" />
                </svg>
                <span>Riwayat</span>
            </button>
        </section>

        {{-- Daftar layanan --}}
        <main class="cards-section">
            <div class="cards-grid">
                @forelse ($services as $service)
                    {{-- Kartu layanan --}}
                    <article class="service-card" data-service-card-item>
                        <a
                            href="{{ $service['url'] }}"
                            target="_blank"
                            rel="noopener"
                            class="service-card-trigger"
                            data-service-modal-trigger
                            data-title="{{ $service['title'] }}"
                            data-description="{{ $service['description'] }}"
                            data-url="{{ $service['url'] }}"
                            data-status="{{ $service['status'] }}"
                            data-category="{{ $service['category'] }}"
                            aria-label="Lihat detail {{ $service['title'] }}"
                        ></a>
                        <div>
                            <div class="card-heading">
                                <span class="polibatam-mini" aria-hidden="true"></span>
                                <h2>{{ $service['title'] }}</h2>
                            </div>
                            <p>{{ $service['description'] }}</p>
                        </div>

                        <div class="card-meta">
                            <span class="status-dot {{ $service['status'] === 'aktif' ? '' : 'offline' }}" aria-hidden="true"></span>
                            @foreach ($service['tags'] as $tag)
                                <span class="tag">{{ $tag }}</span>
                            @endforeach
                        </div>
                    </article>
                    {{-- Pesan data kosong --}}
                @empty
                    <div class="empty-card">Link tidak ditemukan untuk pencarian ini.</div>
                @endforelse
                @if ($services->isNotEmpty())
                    <div class="empty-card" data-shortcut-empty hidden>Tidak ada layanan pada kategori yang dipilih.</div>
                @endif
            </div>
        </main>
    </div>

    {{-- Modal detail layanan --}}
    <section class="service-modal" aria-hidden="true" data-service-modal>
        <div class="service-modal-shell">
            <div
                class="service-modal-card"
                role="dialog"
                aria-modal="true"
                aria-labelledby="service-modal-title"
                aria-describedby="service-modal-description"
            >
                <button type="button" class="service-modal-close" data-service-modal-close aria-label="Tutup detail layanan">
                    <svg viewBox="0 0 24 24" fill="none" aria-hidden="true">
                        <path d="M6 6l12 12M18 6 6 18" stroke="currentColor" stroke-width="2" stroke-linecap="round" />
                    </svg>
                </button>

                <div class="service-modal-header">
                    <span class="service-modal-logo" aria-hidden="true"></span>
                    <h2 id="service-modal-title" class="service-modal-title" data-service-modal-title>Detail Layanan</h2>
                </div>

                <p id="service-modal-description" class="service-modal-description" data-service-modal-description>
                    Informasi layanan akan tampil di sini saat kartu dipilih.
                </p>

                <div class="service-modal-footer">
                    <div class="service-modal-meta">
                        <span class="service-modal-status-dot" data-service-modal-status-dot aria-hidden="true"></span>
                        <span class="service-modal-category" data-service-modal-category>Layanan</span>
                        <span class="service-modal-pill" data-service-modal-status-label>Aktif</span>
                    </div>

                    <div class="service-modal-action-group">
                        <button type="button" class="service-modal-secondary" data-category-toggle aria-expanded="false">
                            <span class="service-modal-secondary-main">
                                <svg viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                                    <path d="M3 3h8v8H3V3Zm10 0h8v8h-8V3ZM3 13h8v8H3v-8Zm10 0h8v8h-8v-8Z" />
                                </svg>
                                <span class="service-modal-secondary-label" data-category-toggle-text>Kategori</span>
                            </span>
                            <svg viewBox="0 0 24 24" fill="none" aria-hidden="true">
                                <path d="m6 9 6 6 6-6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                        </button>

                        <div class="service-category-menu" data-category-menu hidden>
                            <label class="service-category-search">
                                <svg viewBox="0 0 24 24" fill="none" aria-hidden="true">
                                    <path d="M10.8 18.1a7.3 7.3 0 1 1 0-14.6 7.3 7.3 0 0 1 0 14.6Zm6-1.3 3.7 3.7" stroke="currentColor" stroke-width="2" stroke-linecap="round" />
                                </svg>
                                <input type="text" placeholder="Cari..." data-category-search-input autocomplete="off" aria-label="Cari kategori">
                            </label>

                            <div class="service-category-list" data-category-list>
                                @foreach ($categories as $categoryOption)
                                    @php
                                        $categoryOptionLower = strtolower((string) $categoryOption);
                                    @endphp
                                    <button
                                        type="button"
                                        class="service-category-option"
                                        data-category-option="{{ $categoryOption }}"
                                    >
                                        <span class="service-category-option-icon" aria-hidden="true">
                                            @if (str_contains($categoryOptionLower, 'akadem'))
                                                <svg viewBox="0 0 24 24" fill="none">
                                                    <path d="M4 6.5A2.5 2.5 0 0 1 6.5 4H11v15H6.5A2.5 2.5 0 0 0 4 21V6.5ZM20 6.5A2.5 2.5 0 0 0 17.5 4H13v15h4.5A2.5 2.5 0 0 1 20 21V6.5Z" stroke="currentColor" stroke-width="1.8" stroke-linejoin="round" />
                                                </svg>
                                            @elseif (str_contains($categoryOptionLower, 'umum'))
                                                <svg viewBox="0 0 24 24" fill="none">
                                                    <path d="M12 3a9 9 0 1 0 0 18 9 9 0 0 0 0-18Zm0 0c2.2 2.2 3.5 5.4 3.5 9S14.2 18.8 12 21m0-18C9.8 5.2 8.5 8.4 8.5 12S9.8 18.8 12 21m-8-9h16" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" />
                                                </svg>
                                            @else
                                                <svg viewBox="0 0 24 24" fill="none">
                                                    <path d="M4 7.5A2.5 2.5 0 0 1 6.5 5H10l2 2h5.5A2.5 2.5 0 0 1 20 9.5v7a2.5 2.5 0 0 1-2.5 2.5h-11A2.5 2.5 0 0 1 4 16.5v-9Z" stroke="currentColor" stroke-width="1.8" stroke-linejoin="round" />
                                                </svg>
                                            @endif
                                        </span>
                                        <span class="service-category-option-label">{{ $categoryOption }}</span>
                                        <span class="service-category-option-check" aria-hidden="true"></span>
                                    </button>
                                @endforeach
                            </div>

                            <div class="service-category-empty" data-category-empty>
                                Kategori tidak ditemukan.
                            </div>

                            <button type="button" class="service-category-add" data-category-add>
                                <svg viewBox="0 0 24 24" fill="none" aria-hidden="true">
                                    <path d="M12 5v14M5 12h14" stroke="currentColor" stroke-width="2" stroke-linecap="round" />
                                </svg>
                                <span>Tambah Kategori</span>
                            </button>
                        </div>
                    </div>

                    <a href="#" target="_blank" rel="noopener" class="service-modal-primary" data-service-modal-link>
                        <svg viewBox="0 0 24 24" fill="none" aria-hidden="true">
                            <path d="M14 5h5v5M10 14 19 5M19 13v4a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V7a2 2 0 0 1 2-2h4" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                        <span>Kunjungi Website</span>
                    </a>
                </div>

                <p class="service-modal-url" data-service-modal-url hidden></p>
            </div>
        </div>
    </section>

    <section class="category-builder-modal" aria-hidden="true" data-category-builder-modal>
        <div class="category-builder-shell">
            <div
                class="category-builder-card"
                role="dialog"
                aria-modal="true"
                aria-labelledby="category-builder-title-label"
            >
                <div class="category-builder-header">
                    <label class="category-builder-title-wrap">
                        <span id="category-builder-title-label" class="sr-only">Judul kategori baru</span>
                        <input
                            type="text"
                            class="category-builder-title"
                            placeholder="Tambahkan Judul Kategori.."
                            data-category-builder-title
                        >
                        <svg class="category-builder-title-icon" viewBox="0 0 24 24" fill="none" aria-hidden="true">
                            <path d="m4 20 4.5-1 9-9a2.1 2.1 0 1 0-3-3l-9 9L4 20Z" stroke="currentColor" stroke-width="2" stroke-linejoin="round" />
                            <path d="m13.5 6.5 4 4" stroke="currentColor" stroke-width="2" stroke-linecap="round" />
                        </svg>
                    </label>

                    <button type="button" class="category-builder-reset" data-category-builder-reset aria-label="Reset kategori baru">
                        <svg viewBox="0 0 24 24" fill="none" aria-hidden="true">
                            <path d="M5 7h14M9 7V5h6v2M8 7v11m8-11v11M6 7l1 13a1 1 0 0 0 1 .9h8a1 1 0 0 0 1-.9l1-13" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                    </button>
                </div>

                <div class="category-builder-body">
                    <button type="button" class="category-builder-link-add" data-category-builder-link-add>
                        <span>Tambahkan link</span>
                        <svg viewBox="0 0 24 24" fill="none" aria-hidden="true">
                            <path d="M12 5v14M5 12h14" stroke="currentColor" stroke-width="2" stroke-linecap="round" />
                        </svg>
                    </button>

                    <div class="category-builder-links" data-category-builder-links></div>
                    <p class="category-builder-empty" data-category-builder-empty>Belum ada link tambahan.</p>
                </div>

                <div class="category-builder-footer">
                    <button type="button" class="category-builder-save" data-category-builder-save>Simpan</button>
                </div>
            </div>
        </div>
    </section>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const modal = document.querySelector('[data-service-modal]');
            const triggers = Array.from(document.querySelectorAll('[data-service-modal-trigger]'));
            const serviceCards = Array.from(document.querySelectorAll('[data-service-card-item]'));
            const shortcutEmptyCard = document.querySelector('[data-shortcut-empty]');
            const title = modal ? modal.querySelector('[data-service-modal-title]') : null;
            const description = modal ? modal.querySelector('[data-service-modal-description]') : null;
            const category = modal ? modal.querySelector('[data-service-modal-category]') : null;
            const statusLabel = modal ? modal.querySelector('[data-service-modal-status-label]') : null;
            const statusDot = modal ? modal.querySelector('[data-service-modal-status-dot]') : null;
            const urlText = modal ? modal.querySelector('[data-service-modal-url]') : null;
            const visitLink = modal ? modal.querySelector('[data-service-modal-link]') : null;
            const closeButtons = modal ? Array.from(modal.querySelectorAll('[data-service-modal-close]')) : [];
            const categoryStorageKey = 'poltree-service-categories';
            const customCategoryStorageKey = 'poltree-custom-categories';
            const shortcutFilterStorageKey = 'poltree-shortcut-category-filter';
            const profileToggle = document.querySelector('[data-profile-toggle]');
            const profilePanel = document.querySelector('[data-profile-panel]');
            const profilePlaceholderButtons = Array.from(document.querySelectorAll('[data-profile-placeholder]'));
            const modalCategoryControls = modal ? {
                toggle: modal.querySelector('[data-category-toggle]'),
                menu: modal.querySelector('[data-category-menu]'),
                list: modal.querySelector('[data-category-list]'),
                searchInput: modal.querySelector('[data-category-search-input]'),
                empty: modal.querySelector('[data-category-empty]'),
                addButton: modal.querySelector('[data-category-add]'),
            } : null;
            const shortcutCategoryMenu = document.querySelector('[data-shortcut-category-menu]');
            const shortcutCategoryControls = {
                toggle: document.querySelector('[data-shortcut-category-toggle]'),
                menu: shortcutCategoryMenu,
                list: shortcutCategoryMenu ? shortcutCategoryMenu.querySelector('[data-category-list]') : null,
                searchInput: shortcutCategoryMenu ? shortcutCategoryMenu.querySelector('[data-category-search-input]') : null,
                empty: shortcutCategoryMenu ? shortcutCategoryMenu.querySelector('[data-category-empty]') : null,
                addButton: shortcutCategoryMenu ? shortcutCategoryMenu.querySelector('[data-category-add]') : null,
                label: document.querySelector('[data-shortcut-category-label]'),
            };
            const categoryBuilder = {
                modal: document.querySelector('[data-category-builder-modal]'),
                titleInput: document.querySelector('[data-category-builder-title]'),
                resetButton: document.querySelector('[data-category-builder-reset]'),
                addLinkButton: document.querySelector('[data-category-builder-link-add]'),
                links: document.querySelector('[data-category-builder-links]'),
                empty: document.querySelector('[data-category-builder-empty]'),
                saveButton: document.querySelector('[data-category-builder-save]'),
            };
            const categoryBuilderState = {
                source: 'shortcut',
            };
            let activeTrigger = null;

            const readStoredCategories = function () {
                try {
                    return JSON.parse(window.localStorage.getItem(categoryStorageKey) || '{}');
                } catch (error) {
                    return {};
                }
            };

            const writeStoredCategories = function (items) {
                window.localStorage.setItem(categoryStorageKey, JSON.stringify(items));
            };

            const readCustomCategories = function () {
                try {
                    return JSON.parse(window.localStorage.getItem(customCategoryStorageKey) || '[]');
                } catch (error) {
                    return [];
                }
            };

            const writeCustomCategories = function (items) {
                window.localStorage.setItem(customCategoryStorageKey, JSON.stringify(items));
            };

            const readShortcutFilter = function () {
                return (window.localStorage.getItem(shortcutFilterStorageKey) || '').trim();
            };

            const writeShortcutFilter = function (value) {
                const normalizedFilter = normalizeCategoryName(value);

                if (normalizedFilter) {
                    window.localStorage.setItem(shortcutFilterStorageKey, normalizedFilter);
                    return;
                }

                window.localStorage.removeItem(shortcutFilterStorageKey);
            };

            const getServiceKey = function (trigger) {
                return (trigger?.dataset.url || trigger?.dataset.title || '').trim();
            };

            const normalizeCategoryName = function (value) {
                return (value || '').replace(/\s+/g, ' ').trim();
            };

            const updateBodyLock = function () {
                const hasOpenServiceModal = modal ? modal.classList.contains('is-open') : false;
                const hasOpenCategoryBuilder = categoryBuilder.modal ? categoryBuilder.modal.classList.contains('is-open') : false;

                document.body.classList.toggle('modal-open', hasOpenServiceModal || hasOpenCategoryBuilder);
            };

            const findTriggerByTitle = function (serviceTitle) {
                const normalizedTitle = normalizeCategoryName(serviceTitle).toLowerCase();

                if (!normalizedTitle) {
                    return null;
                }

                return triggers.find(function (trigger) {
                    return normalizeCategoryName(trigger.dataset.title || '').toLowerCase() === normalizedTitle;
                }) || null;
            };

            const getCategoryOptions = function (list) {
                return list ? Array.from(list.querySelectorAll('[data-category-option]')) : [];
            };

            const categoryExists = function (list, categoryName) {
                const normalizedCategory = normalizeCategoryName(categoryName).toLowerCase();

                return getCategoryOptions(list).some(function (option) {
                    return normalizeCategoryName(option.dataset.categoryOption).toLowerCase() === normalizedCategory;
                });
            };

            const getCategoryIconMarkup = function (categoryName) {
                const lowerCategory = normalizeCategoryName(categoryName).toLowerCase();

                if (lowerCategory.includes('akadem')) {
                    return '<svg viewBox="0 0 24 24" fill="none" aria-hidden="true"><path d="M4 6.5A2.5 2.5 0 0 1 6.5 4H11v15H6.5A2.5 2.5 0 0 0 4 21V6.5ZM20 6.5A2.5 2.5 0 0 0 17.5 4H13v15h4.5A2.5 2.5 0 0 1 20 21V6.5Z" stroke="currentColor" stroke-width="1.8" stroke-linejoin="round"/></svg>';
                }

                if (lowerCategory.includes('umum')) {
                    return '<svg viewBox="0 0 24 24" fill="none" aria-hidden="true"><path d="M12 3a9 9 0 1 0 0 18 9 9 0 0 0 0-18Zm0 0c2.2 2.2 3.5 5.4 3.5 9S14.2 18.8 12 21m0-18C9.8 5.2 8.5 8.4 8.5 12S9.8 18.8 12 21m-8-9h16" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/></svg>';
                }

                return '<svg viewBox="0 0 24 24" fill="none" aria-hidden="true"><path d="M4 7.5A2.5 2.5 0 0 1 6.5 5H10l2 2h5.5A2.5 2.5 0 0 1 20 9.5v7a2.5 2.5 0 0 1-2.5 2.5h-11A2.5 2.5 0 0 1 4 16.5v-9Z" stroke="currentColor" stroke-width="1.8" stroke-linejoin="round"/></svg>';
            };

            const buildCategoryOption = function (categoryName) {
                const option = document.createElement('button');

                option.type = 'button';
                option.className = 'service-category-option';
                option.dataset.categoryOption = categoryName;
                option.innerHTML =
                    '<span class="service-category-option-icon" aria-hidden="true">' + getCategoryIconMarkup(categoryName) + '</span>' +
                    '<span class="service-category-option-label"></span>' +
                    '<span class="service-category-option-check" aria-hidden="true"></span>';
                option.querySelector('.service-category-option-label').textContent = categoryName;

                return option;
            };

            const ensureCategoryOption = function (list, categoryName) {
                const normalizedCategory = normalizeCategoryName(categoryName);

                if (!list || !normalizedCategory || categoryExists(list, normalizedCategory)) {
                    return;
                }

                list.appendChild(buildCategoryOption(normalizedCategory));
            };

            const syncCustomCategories = function () {
                readCustomCategories().forEach(function (categoryName) {
                    ensureCategoryOption(modalCategoryControls?.list, categoryName);
                    ensureCategoryOption(shortcutCategoryControls.list, categoryName);
                });
            };

            const updateCategoryFilter = function (controls) {
                if (!controls?.list) {
                    return;
                }

                const keyword = normalizeCategoryName(controls.searchInput?.value || '').toLowerCase();
                let visibleCount = 0;

                getCategoryOptions(controls.list).forEach(function (option) {
                    const matches = normalizeCategoryName(option.dataset.categoryOption).toLowerCase().includes(keyword);

                    option.hidden = !matches;

                    if (matches) {
                        visibleCount += 1;
                    }
                });

                if (controls.empty) {
                    controls.empty.classList.toggle('is-visible', visibleCount === 0);
                }
            };

            const setActiveCategoryOption = function (controls, categoryName) {
                getCategoryOptions(controls?.list).forEach(function (option) {
                    option.classList.toggle('is-active', option.dataset.categoryOption === categoryName);
                });
            };

            const getResolvedCategoryForTrigger = function (trigger) {
                const storedCategories = readStoredCategories();

                return normalizeCategoryName(storedCategories[getServiceKey(trigger)] || trigger?.dataset.category || 'Layanan');
            };

            const applyCategory = function (categoryName) {
                const fallbackCategory = activeTrigger?.dataset.category || 'Layanan';
                const currentCategory = categoryName || fallbackCategory;

                if (!category) {
                    return;
                }

                category.textContent = currentCategory;
                setActiveCategoryOption(modalCategoryControls, currentCategory);
            };

            const applyShortcutFilter = function (categoryName) {
                const currentFilter = normalizeCategoryName(categoryName);

                writeShortcutFilter(currentFilter);

                if (shortcutCategoryControls.label) {
                    shortcutCategoryControls.label.textContent = currentFilter || 'Kategori';
                }

                setActiveCategoryOption(shortcutCategoryControls, currentFilter);

                if (!serviceCards.length) {
                    return;
                }

                let visibleCount = 0;

                serviceCards.forEach(function (card) {
                    const trigger = card.querySelector('[data-service-modal-trigger]');
                    const resolvedCategory = getResolvedCategoryForTrigger(trigger);
                    const matches = !currentFilter || resolvedCategory.toLowerCase() === currentFilter.toLowerCase();

                    card.hidden = !matches;

                    if (matches) {
                        visibleCount += 1;
                    }
                });

                if (shortcutEmptyCard) {
                    shortcutEmptyCard.hidden = visibleCount !== 0;
                }
            };

            const updateCategoryBuilderEmptyState = function () {
                if (!categoryBuilder.empty || !categoryBuilder.links) {
                    return;
                }

                categoryBuilder.empty.hidden = categoryBuilder.links.children.length !== 0;
            };

            const buildCategoryLinkRow = function (value) {
                const row = document.createElement('div');

                row.className = 'category-builder-link-row';
                row.innerHTML =
                    '<input type="text" class="category-builder-link-input" placeholder="Masukkan judul link..." data-category-builder-link-input>' +
                    '<button type="button" class="category-builder-link-remove" data-category-builder-link-remove aria-label="Hapus link">' +
                    '<svg viewBox="0 0 24 24" fill="none" aria-hidden="true"><path d="M6 6l12 12M18 6 6 18" stroke="currentColor" stroke-width="2" stroke-linecap="round"/></svg>' +
                    '</button>';
                row.querySelector('[data-category-builder-link-input]').value = value || '';

                return row;
            };

            const resetCategoryBuilderForm = function () {
                if (categoryBuilder.titleInput) {
                    categoryBuilder.titleInput.value = '';
                }

                if (categoryBuilder.links) {
                    categoryBuilder.links.innerHTML = '';
                }

                updateCategoryBuilderEmptyState();
            };

            const closeCategoryBuilder = function () {
                if (!categoryBuilder.modal || !categoryBuilder.modal.classList.contains('is-open')) {
                    return;
                }

                categoryBuilder.modal.classList.remove('is-open');
                categoryBuilder.modal.setAttribute('aria-hidden', 'true');
                updateBodyLock();
            };

            const openCategoryBuilder = function (source) {
                if (!categoryBuilder.modal) {
                    return;
                }

                categoryBuilderState.source = source || 'shortcut';
                closeCategoryMenu(modalCategoryControls);
                closeCategoryMenu(shortcutCategoryControls);
                closeProfilePanel();
                resetCategoryBuilderForm();
                categoryBuilder.modal.classList.add('is-open');
                categoryBuilder.modal.setAttribute('aria-hidden', 'false');
                updateBodyLock();

                if (categoryBuilder.titleInput) {
                    window.requestAnimationFrame(function () {
                        categoryBuilder.titleInput.focus();
                    });
                }
            };

            const getCategoryBuilderLinks = function () {
                if (!categoryBuilder.links) {
                    return [];
                }

                return Array.from(categoryBuilder.links.querySelectorAll('[data-category-builder-link-input]'))
                    .map(function (input) {
                        return normalizeCategoryName(input.value);
                    })
                    .filter(Boolean);
            };

            const closeCategoryMenu = function (controls) {
                if (!controls?.toggle || !controls.menu) {
                    return;
                }

                controls.menu.hidden = true;
                controls.toggle.setAttribute('aria-expanded', 'false');

                if (controls.searchInput) {
                    controls.searchInput.value = '';
                }

                updateCategoryFilter(controls);
            };

            const openCategoryMenu = function (controls) {
                if (!controls?.toggle || !controls.menu) {
                    return;
                }

                if (controls !== modalCategoryControls) {
                    closeCategoryMenu(modalCategoryControls);
                }

                if (controls !== shortcutCategoryControls) {
                    closeCategoryMenu(shortcutCategoryControls);
                }

                closeProfilePanel();
                closeCategoryBuilder();
                syncCustomCategories();
                controls.menu.hidden = false;
                controls.toggle.setAttribute('aria-expanded', 'true');
                updateCategoryFilter(controls);

                if (controls.searchInput) {
                    window.requestAnimationFrame(function () {
                        controls.searchInput.focus();
                    });
                }
            };

            const toggleCategoryMenu = function (controls) {
                if (!controls?.toggle || !controls.menu) {
                    return;
                }

                const isOpen = controls.toggle.getAttribute('aria-expanded') === 'true';

                if (isOpen) {
                    closeCategoryMenu(controls);
                    return;
                }

                openCategoryMenu(controls);
            };

            function closeProfilePanel() {
                if (!profileToggle || !profilePanel || profilePanel.hidden) {
                    return;
                }

                profilePanel.hidden = true;
                profileToggle.setAttribute('aria-expanded', 'false');
            }

            const openProfilePanel = function () {
                if (!profileToggle || !profilePanel) {
                    return;
                }

                closeCategoryMenu(modalCategoryControls);
                closeCategoryMenu(shortcutCategoryControls);
                closeCategoryBuilder();
                profilePanel.hidden = false;
                profileToggle.setAttribute('aria-expanded', 'true');
            };

            const toggleProfilePanel = function () {
                if (!profileToggle || !profilePanel) {
                    return;
                }

                if (profilePanel.hidden) {
                    openProfilePanel();
                    return;
                }

                closeProfilePanel();
            };

            const persistCustomCategory = function (categoryName) {
                const normalizedCategory = normalizeCategoryName(categoryName);

                if (!normalizedCategory) {
                    return '';
                }

                if (!categoryExists(modalCategoryControls?.list, normalizedCategory) && !categoryExists(shortcutCategoryControls.list, normalizedCategory)) {
                    const storedCustomCategories = readCustomCategories();

                    storedCustomCategories.push(normalizedCategory);
                    writeCustomCategories(Array.from(new Set(storedCustomCategories)));
                }

                ensureCategoryOption(modalCategoryControls?.list, normalizedCategory);
                ensureCategoryOption(shortcutCategoryControls.list, normalizedCategory);

                return normalizedCategory;
            };

            const assignCategoryToActiveService = function (categoryName) {
                if (!activeTrigger) {
                    return;
                }

                const normalizedCategory = normalizeCategoryName(categoryName);

                if (!normalizedCategory) {
                    return;
                }

                const storedCategories = readStoredCategories();

                storedCategories[getServiceKey(activeTrigger)] = normalizedCategory;
                writeStoredCategories(storedCategories);
                ensureCategoryOption(modalCategoryControls?.list, normalizedCategory);
                ensureCategoryOption(shortcutCategoryControls.list, normalizedCategory);
                applyCategory(normalizedCategory);
                applyShortcutFilter(readShortcutFilter());
            };

            const saveCategoryBuilder = function () {
                const newCategoryName = persistCustomCategory(categoryBuilder.titleInput?.value || '');
                const selectedLinkTitles = getCategoryBuilderLinks();

                if (!newCategoryName) {
                    if (categoryBuilder.titleInput) {
                        categoryBuilder.titleInput.focus();
                    }

                    return;
                }

                const targetTriggers = [];

                if (categoryBuilderState.source === 'service' && activeTrigger) {
                    targetTriggers.push(activeTrigger);
                }

                selectedLinkTitles.forEach(function (linkTitle) {
                    const matchedTrigger = findTriggerByTitle(linkTitle);

                    if (matchedTrigger) {
                        targetTriggers.push(matchedTrigger);
                    }
                });

                if (targetTriggers.length) {
                    const storedCategories = readStoredCategories();

                    targetTriggers.forEach(function (trigger) {
                        storedCategories[getServiceKey(trigger)] = newCategoryName;
                    });

                    writeStoredCategories(storedCategories);
                }

                if (categoryBuilderState.source === 'service' && activeTrigger) {
                    applyCategory(newCategoryName);
                }

                applyShortcutFilter(categoryBuilderState.source === 'shortcut' ? newCategoryName : readShortcutFilter());
                closeCategoryBuilder();
            };

            const openModal = function (trigger) {
                const serviceUrl = (trigger.dataset.url || '#').trim() || '#';
                const serviceStatus = (trigger.dataset.status || '').trim().toLowerCase();
                const isUnavailable = serviceUrl === '#';
                const currentCategory = getResolvedCategoryForTrigger(trigger);

                activeTrigger = trigger;
                ensureCategoryOption(modalCategoryControls?.list, currentCategory);
                ensureCategoryOption(shortcutCategoryControls.list, currentCategory);

                if (title) {
                    title.textContent = trigger.dataset.title || 'Detail Layanan';
                }

                if (description) {
                    description.textContent = trigger.dataset.description || 'Informasi layanan belum tersedia.';
                }

                applyCategory(currentCategory);

                if (statusLabel) {
                    statusLabel.textContent = serviceStatus ? serviceStatus.charAt(0).toUpperCase() + serviceStatus.slice(1) : 'Aktif';
                }

                if (statusDot) {
                    statusDot.classList.toggle('offline', serviceStatus !== 'aktif');
                }

                if (visitLink) {
                    visitLink.href = serviceUrl;
                    visitLink.classList.toggle('is-disabled', isUnavailable);
                    visitLink.setAttribute('aria-disabled', isUnavailable ? 'true' : 'false');
                }

                if (urlText) {
                    urlText.hidden = isUnavailable;
                    urlText.textContent = isUnavailable ? '' : serviceUrl;
                }

                closeCategoryMenu(modalCategoryControls);
                closeProfilePanel();
                closeCategoryBuilder();

                if (!modal) {
                    return;
                }

                modal.classList.add('is-open');
                modal.setAttribute('aria-hidden', 'false');
                updateBodyLock();

                window.requestAnimationFrame(function () {
                    const firstCloseButton = modal.querySelector('[data-service-modal-close]');

                    if (firstCloseButton) {
                        firstCloseButton.focus();
                    }
                });
            };

            const closeModal = function () {
                if (!modal || !modal.classList.contains('is-open')) {
                    return;
                }

                modal.classList.remove('is-open');
                modal.setAttribute('aria-hidden', 'true');
                updateBodyLock();
                closeCategoryMenu(modalCategoryControls);

                if (activeTrigger) {
                    activeTrigger.focus();
                }
            };

            triggers.forEach(function (trigger) {
                trigger.addEventListener('click', function (event) {
                    event.preventDefault();
                    openModal(trigger);
                });
            });

            closeButtons.forEach(function (button) {
                button.addEventListener('click', function (event) {
                    event.preventDefault();
                    closeModal();
                });
            });

            if (visitLink) {
                visitLink.addEventListener('click', function (event) {
                    if (visitLink.classList.contains('is-disabled')) {
                        event.preventDefault();
                    }
                });
            }

            if (modalCategoryControls?.toggle) {
                modalCategoryControls.toggle.addEventListener('click', function (event) {
                    event.preventDefault();
                    toggleCategoryMenu(modalCategoryControls);
                });
            }

            if (modalCategoryControls?.searchInput) {
                modalCategoryControls.searchInput.addEventListener('input', function () {
                    updateCategoryFilter(modalCategoryControls);
                });
            }

            if (modalCategoryControls?.list) {
                modalCategoryControls.list.addEventListener('click', function (event) {
                    const option = event.target.closest('[data-category-option]');

                    if (!option || !activeTrigger) {
                        return;
                    }

                    const selectedCategory = option.dataset.categoryOption;

                    assignCategoryToActiveService(selectedCategory);
                    closeCategoryMenu(modalCategoryControls);
                });
            }

            if (modalCategoryControls?.addButton) {
                modalCategoryControls.addButton.addEventListener('click', function () {
                    openCategoryBuilder('service');
                });
            }

            if (shortcutCategoryControls.toggle) {
                shortcutCategoryControls.toggle.addEventListener('click', function (event) {
                    event.preventDefault();
                    toggleCategoryMenu(shortcutCategoryControls);
                });
            }

            if (shortcutCategoryControls.searchInput) {
                shortcutCategoryControls.searchInput.addEventListener('input', function () {
                    updateCategoryFilter(shortcutCategoryControls);
                });
            }

            if (shortcutCategoryControls.list) {
                shortcutCategoryControls.list.addEventListener('click', function (event) {
                    const option = event.target.closest('[data-category-option]');

                    if (!option) {
                        return;
                    }

                    const selectedCategory = normalizeCategoryName(option.dataset.categoryOption);
                    const currentFilter = normalizeCategoryName(readShortcutFilter());

                    applyShortcutFilter(currentFilter.toLowerCase() === selectedCategory.toLowerCase() ? '' : selectedCategory);
                    closeCategoryMenu(shortcutCategoryControls);
                });
            }

            if (shortcutCategoryControls.addButton) {
                shortcutCategoryControls.addButton.addEventListener('click', function () {
                    openCategoryBuilder('shortcut');
                });
            }

            if (categoryBuilder.addLinkButton) {
                categoryBuilder.addLinkButton.addEventListener('click', function () {
                    if (!categoryBuilder.links) {
                        return;
                    }

                    const row = buildCategoryLinkRow('');

                    categoryBuilder.links.appendChild(row);
                    updateCategoryBuilderEmptyState();

                    const input = row.querySelector('[data-category-builder-link-input]');

                    if (input) {
                        input.focus();
                    }
                });
            }

            if (categoryBuilder.resetButton) {
                categoryBuilder.resetButton.addEventListener('click', function () {
                    resetCategoryBuilderForm();

                    if (categoryBuilder.titleInput) {
                        categoryBuilder.titleInput.focus();
                    }
                });
            }

            if (categoryBuilder.links) {
                categoryBuilder.links.addEventListener('click', function (event) {
                    const removeButton = event.target.closest('[data-category-builder-link-remove]');

                    if (!removeButton) {
                        return;
                    }

                    const row = removeButton.closest('.category-builder-link-row');

                    if (row) {
                        row.remove();
                        updateCategoryBuilderEmptyState();
                    }
                });
            }

            if (categoryBuilder.saveButton) {
                categoryBuilder.saveButton.addEventListener('click', function () {
                    saveCategoryBuilder();
                });
            }

            if (profileToggle) {
                profileToggle.addEventListener('click', function (event) {
                    event.preventDefault();
                    toggleProfilePanel();
                });
            }

            profilePlaceholderButtons.forEach(function (button) {
                button.addEventListener('click', function () {
                    closeProfilePanel();
                });
            });

            if (modal) {
                modal.addEventListener('click', function (event) {
                    if (event.target === modal) {
                        closeModal();
                    }
                });
            }

            if (categoryBuilder.modal) {
                categoryBuilder.modal.addEventListener('click', function (event) {
                    if (event.target === categoryBuilder.modal) {
                        closeCategoryBuilder();
                    }
                });
            }

            document.addEventListener('click', function (event) {
                if (profilePanel && !profilePanel.hidden && !event.target.closest('.profile-menu-wrap')) {
                    closeProfilePanel();
                }

                if (modalCategoryControls?.menu && !modalCategoryControls.menu.hidden && !event.target.closest('.service-modal-action-group')) {
                    closeCategoryMenu(modalCategoryControls);
                }

                if (shortcutCategoryControls.menu && !shortcutCategoryControls.menu.hidden && !event.target.closest('.shortcut-group')) {
                    closeCategoryMenu(shortcutCategoryControls);
                }
            });

            document.addEventListener('keydown', function (event) {
                if (event.key !== 'Escape') {
                    return;
                }

                if (profilePanel && !profilePanel.hidden) {
                    closeProfilePanel();
                    return;
                }

                if (categoryBuilder.modal && categoryBuilder.modal.classList.contains('is-open')) {
                    closeCategoryBuilder();
                    return;
                }

                if (modalCategoryControls?.toggle && modalCategoryControls.toggle.getAttribute('aria-expanded') === 'true') {
                    closeCategoryMenu(modalCategoryControls);
                    return;
                }

                if (shortcutCategoryControls.toggle && shortcutCategoryControls.toggle.getAttribute('aria-expanded') === 'true') {
                    closeCategoryMenu(shortcutCategoryControls);
                    return;
                }

                closeModal();
            });

            syncCustomCategories();
            updateCategoryFilter(modalCategoryControls);
            updateCategoryFilter(shortcutCategoryControls);
            updateCategoryBuilderEmptyState();
            applyShortcutFilter(readShortcutFilter());
            updateBodyLock();
        });
    </script>
</body>

</html>
