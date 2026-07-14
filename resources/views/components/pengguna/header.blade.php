<header class="topbar">
    <div class="topbar-inner">
        <button type="button" class="mobile-menu-btn" data-mobile-menu-toggle aria-label="Menu">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round">
    {!! config('icons.ui_menu') !!}\n</svg>
        </button>

        <form class="search-box" role="search" action="{{ route('pengguna.dashboard') }}" method="GET">
            <input type="hidden" name="role" value="{{ $activeRole }}">
            <svg viewBox="0 0 24 24" fill="none" aria-hidden="true">
                <path d="M10.8 18.1a7.3 7.3 0 1 1 0-14.6 7.3 7.3 0 0 1 0 14.6Zm6-1.3 3.7 3.7" stroke="currentColor" stroke-width="2" stroke-linecap="round" />
            </svg>
            <input type="text" name="q" value="{{ $search ?? '' }}" placeholder="Cari.." aria-label="Cari">
            <button type="submit">Cari</button>
        </form>

        <div class="profile-menu-wrap">
            <button type="button" class="profile-icon" aria-label="Profil pengguna" aria-expanded="false" data-profile-toggle style="padding: 0; overflow: hidden; display: grid; place-items: center;">
                @if(auth('pengguna')->user()->foto)
                <img src="{{ asset(auth('pengguna')->user()->foto) }}" style="width: 100% !important; height: 100% !important; object-fit: cover !important; border-radius: 50%;">
                @else
                <svg viewBox="0 0 24 24" fill="none" aria-hidden="true" style="width: 20px; height: 20px; color: var(--orange);">
                    <path d="M12 12.2a4.4 4.4 0 1 0 0-8.8 4.4 4.4 0 0 0 0 8.8Zm-7 8.4c.9-3.5 3.5-5.4 7-5.4s6.1 1.9 7 5.4" stroke="currentColor" stroke-width="2" stroke-linecap="round" />
                </svg>
                @endif
            </button>

            <div class="profile-panel" data-profile-panel hidden style="right: 0; left: auto;">
                <div class="profile-panel-header">
                    <div class="profile-panel-avatar">
                        @if(auth('pengguna')->user()->foto)
                        <img src="{{ asset(auth('pengguna')->user()->foto) }}" alt="Avatar" style="width: 100% !important; height: 100% !important; object-fit: cover !important; border-radius: 50%;">
                        @else
                        <span style="font-weight: 700;">{{ strtoupper(substr(auth('pengguna')->user()->nama_pengguna ?? 'P', 0, 1)) }}</span>
                        @endif
                    </div>
                    <div class="profile-panel-info">
                        <div class="profile-panel-name">{{ auth('pengguna')->user()->nama_pengguna }}</div>
                        <div class="profile-panel-role">{{ auth('pengguna')->user()->jabatan ?? 'Pengguna' }}</div>
                    </div>
                </div>
                <hr class="profile-panel-divider">
                <div class="profile-panel-actions">
                    <button type="button" class="profile-panel-btn" onclick="openProfileModal()">
                        <div class="btn-icon-wrap">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round">
                                <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2m8-10a4 4 0 1 0 0-8 4 4 0 0 0 0 8z" />
                            </svg>
                        </div>
                        <span>Profil Saya</span>
                    </button>

                    <button type="button" class="profile-panel-btn" onclick="openPasswordModal()">
                        <div class="btn-icon-wrap">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                                <rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect>
                                <path d="M7 11V7a5 5 0 0 1 10 0v4"></path>
                            </svg>
                        </div>
                        <span>Ubah Kata Sandi</span>
                    </button>

                    <hr class="profile-panel-divider">

                    <form action="{{ route('logout') }}" method="POST" class="profile-panel-form">
                        @csrf
                        <button type="submit" class="profile-panel-btn logout-btn">
                            <div class="btn-icon-wrap">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
    {!! config('icons.ui_keluar') !!}\n</svg>
                            </div>
                            <span>Keluar</span>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</header>
