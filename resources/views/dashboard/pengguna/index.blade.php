@php
$iconPaths = config('icons');
@endphp

@extends('layouts.pengguna')

@section('content')
{{-- ═══════════════════════════════════════════════════════
                    HERO BANNER
                ═══════════════════════════════════════════════════════ --}}
<section class="hero-banner" aria-label="Foto kampus Politeknik Negeri Batam">
    @php
    $heroStep = 3;
    $heroDuration = max($heroImages->count() * $heroStep, $heroStep);
    @endphp

    @foreach ($heroImages as $index => $image)
    <span
        class="hero-slide {{ $heroImages->count() === 1 ? 'only' : '' }}"
        style="background-image: url('{{ $image }}'); --hero-duration: {{ $heroDuration }}s; animation-delay: -{{ $index * $heroStep }}s;"
        aria-hidden="true"></span>
    @endforeach

    <div class="hero-text">
        <h1>Selamat Datang, <span class="hero-name">{{ auth('pengguna')->user()->nama_pengguna ?? 'Pengguna' }}</span></h1>
        <p>Akses semua layanan Polibatam lebih mudah dalam satu tempat.</p>
    </div>
</section>

{{-- ═══════════════════════════════════════════════════════
                    TAB NAVIGATION
                ═══════════════════════════════════════════════════════ --}}
<nav class="tab-nav" aria-label="Tab navigasi">
    <button type="button" class="tab-btn active" data-shortcut-saved-toggle>
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" aria-hidden="true">
            <path d="M5 5h14v16l-7-4-7 4V5a2 2 0 0 1 2-2h10a2 2 0 0 1 2 2v16" stroke-linejoin="round" />
        </svg>
        <span>Tersimpan</span>
    </button>

    <button type="button" class="tab-btn" data-tab-kategori>
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
            <path d="M3 3h7v7H3V3Zm11 0h7v7h-7V3ZM3 14h7v7H3v-7Zm11 0h7v7h-7v-7Z" />
        </svg>
        <span>Kategori</span>
    </button>
</nav>

{{-- Active Category Filter Banner --}}
<div id="category-filter-indicator" class="filter-indicator-bar" style="display: none;">
    <div class="filter-indicator-content">
        <span class="filter-indicator-dot"></span>
        <span class="filter-indicator-text">Kategori Aktif: <strong data-shortcut-category-label></strong></span>
    </div>
    <button type="button" class="filter-indicator-clear" id="clear-category-filter-btn" aria-label="Hapus filter">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
            <line x1="18" y1="6" x2="6" y2="18"></line>
            <line x1="6" y1="6" x2="18" y2="18"></line>
        </svg>
    </button>
</div>

{{-- ═══════════════════════════════════════════════════════
                    VIEW: TERSIMPAN
                ═══════════════════════════════════════════════════════ --}}
<div id="view-tersimpan" class="section-block">
    {{-- Layanan Utama --}}
    @if (!$adminServices->isEmpty())
    <div class="section-block" data-section="official">
        <div class="section-header">
            <div class="section-header-left">
                <h2><span class="section-title-highlight">Lay</span>anan Resmi</h2>
                <p>Akses cepat ke layanan resmi Politeknik Negeri Batam</p>
            </div>
        </div>
        <div class="cards-grid">
            @foreach ($adminServices as $service)
            @include('components.pengguna.service_card', ['service' => $service])
            @endforeach
        </div>
    </div>
    @endif

    {{-- Layanan Pribadi --}}
    <div class="section-block" data-section="personal">
        <div class="section-header">
            <div class="section-header-left">
                <h2>Layanan Pribadi</h2>
                <p>Tautan website kustom buatan Anda sendiri</p>
            </div>
            <button type="button" class="section-add-btn" onclick="openLinkModal()">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                    <line x1="12" y1="5" x2="12" y2="19"></line>
                    <line x1="5" y1="12" x2="19" y2="12"></line>
                </svg>
                <span>Link</span>
            </button>
        </div>

        @if (!$userServices->isEmpty())
        <div class="cards-grid">
            @foreach ($userServices as $service)
            @include('components.pengguna.service_card', ['service' => $service])
            @endforeach
        </div>
        @else
        <div class="premium-dashed-empty">
            <svg width="44" height="44" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.3" stroke-linecap="round" stroke-linejoin="round">
                <path d="M10 13a5 5 0 0 0 7.54.54l3-3a5 5 0 0 0-7.07-7.07l-1.72 1.71"></path>
                <path d="M14 11a5 5 0 0 0-7.54-.54l-3 3a5 5 0 0 0 7.07 7.07l1.71-1.71"></path>
            </svg>
            <div class="empty-title">Belum ada link pribadi ditambahkan</div>
            <div class="empty-desc">Tautan website kustom buatan Anda akan muncul di sini. Silakan klik tombol "+ Link" di atas untuk menambahkan.</div>
        </div>
        @endif
    </div>

    {{-- Premium Empty State --}}
    <div id="empty-state-card" class="empty-state-container" data-shortcut-empty style="display: none;">
        <div class="empty-state-icon">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                <circle cx="12" cy="12" r="10"></circle>
                <line x1="8" y1="12" x2="16" y2="12"></line>
            </svg>
        </div>
        <h3 class="empty-state-title">Tidak Ada Layanan Ditemukan</h3>
        <p class="empty-state-desc">Silakan periksa kategori lain atau tambahkan link pribadi baru.</p>
    </div>
</div>

{{-- ═══════════════════════════════════════════════════════
                    VIEW: KATEGORI
                ═══════════════════════════════════════════════════════ --}}
<div id="view-kategori" class="section-block hidden">
    <div class="section-header">
        <div class="section-header-left">
            <h2>Kategori Layanan</h2>
            <p>Temukan layanan berdasarkan klasifikasi folder</p>
        </div>
    </div>

    <div class="folder-grid">
        @foreach ($categoriesList as $category)
        @php
        $catLinks = $category->links;
        $totalLinks = $catLinks->count();
        $displayLinks = $catLinks->take(4);
        @endphp
        <div class="folder-card" data-category-folder="{{ $category->nama_kategori }}" data-category-id="{{ $category->id_kategori }}" data-category-nik="{{ $category->nik ?? '' }}">
            {{-- Tombol edit folder kategori (hanya untuk kategori milik pengguna) --}}
            @if($category->nik === auth('pengguna')->user()->nik)
            <button type="button" class="folder-edit-btn" data-category-edit-toggle="{{ $category->nama_kategori }}" data-category-db-id="{{ $category->id_kategori }}" aria-label="Edit Kategori">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path>
                    <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4L18.5 2.5z"></path>
                </svg>
            </button>
            @endif
            <div class="folder-header">
                <div class="category-folder-icon-wrapper" style="display: flex; align-items: center; justify-content: center; width: 48px; height: 48px; border-radius: 12px; background: rgba(8, 13, 95, 0.04); color: #080d5f; transition: all 0.2s;">
                    @if($category->icon && array_key_exists($category->icon, $iconPaths))
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        {!! $iconPaths[$category->icon] !!}
                    </svg>
                    @else
                    <img src="{{ asset('images/logo-polibatam.png') }}" alt="Logo" style="width: 32px; height: 32px; object-fit: contain;">
                    @endif
                </div>
            </div>
            <div class="folder-body">
                <h3 class="folder-title">{{ $category->nama_kategori }}</h3>
                <p class="folder-count">{{ $totalLinks }} Layanan</p>
            </div>
        </div>
        @endforeach

        {{-- Tambah Kategori Card --}}
        <div class="folder-card dashed-folder" onclick="openCategoryBuilder('shortcut')">
            <div class="folder-header">
                <div class="dashed-folder-icon">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                        <line x1="12" y1="5" x2="12" y2="19"></line>
                        <line x1="5" y1="12" x2="19" y2="12"></line>
                    </svg>
                </div>
            </div>
            <div class="folder-body">
                <h3 class="folder-title">Tambah Kategori</h3>
                <p class="folder-count">Buat baru</p>
            </div>
        </div>
    </div>
</div>

@if ($services->isEmpty())
<div class="flex flex-col items-center justify-center py-20 text-gray-400">
    <svg width="64" height="64" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1" stroke-linecap="round" stroke-linejoin="round" class="mb-4 opacity-20">
        <circle cx="12" cy="12" r="10"></circle>
        <line x1="8" y1="12" x2="16" y2="12"></line>
    </svg>
    <p class="text-lg font-medium">Belum ada layanan tersedia</p>
</div>
@endif
</div>
</div>
</div>

{{-- ═══════════════════════════════════════════════════════
        CATEGORY BUILDER MODAL (Premium Style)
    ═══════════════════════════════════════════════════════ --}}
<div class="hidden premium-modal-overlay" data-category-builder-modal>
    <div class="premium-modal-shell" style="max-width: 500px;">
        <div class="premium-modal-card" role="dialog" aria-modal="true" aria-labelledby="category-builder-title-label">
            <button type="button" class="premium-modal-close-btn" data-category-builder-close aria-label="Tutup">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                    <line x1="18" y1="6" x2="6" y2="18"></line>
                    <line x1="6" y1="6" x2="18" y2="18"></line>
                </svg>
            </button>

            <h2 id="category-builder-title-label" class="premium-modal-title" data-category-builder-modal-title>Tambah Kategori</h2>

            <div class="premium-modal-form-group">
                <label class="premium-modal-label">Nama Kategori</label>
                <input type="text" class="premium-modal-input" placeholder="Masukkan nama kategori.." data-category-builder-title>
            </div>

            <div class="premium-modal-form-group">
                <label class="premium-modal-label">Pilih Ikon</label>
                <div class="category-builder-icon-grid" id="user-builder-icon-picker">
                    <label class="cb-icon-option is-active" title="Default (Polibatam)">
                        <input type="radio" name="builder_icon" value="" checked onchange="selectUserBuilderIcon(this)">
                        <img src="{{ asset('images/logo-polibatam.png') }}" alt="Default" style="width: 20px; height: 20px; object-fit: contain;">
                    </label>
                    @foreach(['home', 'grid', 'sparkles', 'user', 'chain', 'folder', 'tag', 'book', 'globe', 'settings', 'briefcase', 'heart'] as $iconName)
                    <label class="cb-icon-option" data-icon-value="{{ $iconName }}" title="{{ $iconName }}">
                        <input type="radio" name="builder_icon" value="{{ $iconName }}" onchange="selectUserBuilderIcon(this)">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            {!! $iconPaths[$iconName] !!}
                        </svg>
                    </label>
                    @endforeach
                </div>
            </div>

            <div class="premium-modal-form-group" style="margin-bottom: 12px;">
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 8px;">
                    <label class="premium-modal-label" style="margin-bottom: 0;">Link Terkait</label>
                    <button type="button" class="cb-add-link-btn" data-category-builder-link-add>
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round">
                            <line x1="12" y1="5" x2="12" y2="19"></line>
                            <line x1="5" y1="12" x2="19" y2="12"></line>
                        </svg>
                        Tambah Link
                    </button>
                </div>
                <div class="cb-links-container" data-category-builder-links></div>
                <p class="cb-empty-state" data-category-builder-empty>Belum ada link ditambahkan</p>
            </div>

            <div class="premium-modal-actions">
                <button type="button" class="premium-modal-btn btn-cancel" data-category-builder-close>Batal</button>
                <button type="button" class="premium-modal-btn btn-save" data-category-builder-save>
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" style="margin-right: 6px;">
                        <path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"></path>
                        <polyline points="17 21 17 13 7 13 7 21"></polyline>
                        <polyline points="7 3 7 8 15 8"></polyline>
                    </svg>
                    Simpan Kategori
                </button>
            </div>

            {{-- Delete button (only visible in edit mode) --}}
            <div class="cb-delete-section" data-category-builder-delete-section style="display: none;">
                <button type="button" class="cb-delete-btn" data-category-builder-reset>
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                        <polyline points="3 6 5 6 21 6"></polyline>
                        <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path>
                    </svg>
                    Hapus Kategori
                </button>
            </div>
        </div>
    </div>
</div>


@endsection
