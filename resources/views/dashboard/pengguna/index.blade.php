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
            {!! config('icons.home') !!}
        </svg>
        <span>Halaman Saya</span>
    </button>

    <button type="button" class="tab-btn" data-tab-kategori>
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
            {!! config('icons.grid') !!}
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
            {!! config('icons.ui_tutup') !!}\n</svg>
    </button>
</div>

{{-- ═══════════════════════════════════════════════════════
                    VIEW: Halaman Saya
═══════════════════════════════════════════════════════ --}}
<div id="view-tersimpan" class="section-block">
    {{-- Layanan Utama --}}
    @if (!$adminServices->isEmpty())
    <div class="section-block" data-section="official">
        <div class="section-header">
            <div class="section-header-left">
                <h2>Layanan Resmi</h2>
                <p>Akses cepat ke layanan Politeknik Negeri Batam</p>
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
                    {!! $iconPaths['plus'] !!}
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
                {!! config('icons.ui_tautan') !!}\n</svg>
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
                    {!! config('icons.ui_edit') !!}\n</svg>
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
                        {!! $iconPaths['plus'] !!}
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


{{-- ═══════════════════════════════════════════════════════
        MODAL TAMBAH KATEGORI
    ═══════════════════════════════════════════════════════ --}}
<div class="hidden premium-modal-overlay" data-category-builder-modal>
    <div class="premium-modal-shell" style="max-width: 500px;">
        <div class="premium-modal-card" role="dialog" aria-modal="true" aria-labelledby="category-builder-title-label">
            <button type="button" class="premium-modal-close-btn" data-category-builder-close aria-label="Tutup">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                    {!! config('icons.ui_tutup') !!}\n</svg>
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

            <!-- <div class="premium-modal-form-group" style="margin-bottom: 12px;">
                <label class="premium-modal-label">Pilih Layanan (Link)</label>
                <div class="max-h-[200px] overflow-y-auto border border-[#080d5f]/10 rounded-xl p-3 bg-slate-50" data-category-builder-links>
                    @foreach ($allLinkTitles as $link)
                        <label class="modal-link-item flex items-center gap-2 p-2 rounded-lg cursor-pointer transition-all duration-200 mb-1 hover:bg-slate-100" onclick="const cb = this.querySelector('.link-checkbox'); this.classList.toggle('bg-[#080d5f]/5', cb.checked); this.classList.toggle('text-[#080d5f]', cb.checked);">
                            <input type="checkbox" value="{{ $link }}" class="link-checkbox w-4 h-4 accent-[#080d5f]" onchange="const p = this.parentElement; p.classList.toggle('bg-[#080d5f]/5', this.checked); p.classList.toggle('text-[#080d5f]', this.checked);" data-category-builder-link-checkbox>
                            <span class="modal-link-label text-[13px] font-semibold text-[#1e2243]">{{ $link }}</span>
                        </label>
                    @endforeach
                </div>
            </div> -->

            <div class="premium-modal-actions">
                <button type="button" class="premium-modal-btn btn-cancel" data-category-builder-close>Batal</button>
                <button type="button" class="premium-modal-btn btn-save" data-category-builder-save>
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" style="margin-right: 6px;">
                        {!! config('icons.ui_simpan') !!}\n</svg>
                    Simpan Kategori
                </button>
            </div>

            {{-- Delete button (only visible in edit mode) --}}
            <div class="cb-delete-section" data-category-builder-delete-section style="display: none;">
                <button type="button" class="cb-delete-btn" data-category-builder-reset>
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                        {!! config('icons.ui_hapus') !!}\n</svg>
                    Hapus Kategori
                </button>
            </div>
        </div>
    </div>
</div>


@endsection