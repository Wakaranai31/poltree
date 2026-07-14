<header class="admin-topbar">
                <button type="button" class="mobile-sidebar-toggle" id="sidebarToggle" aria-label="Menu navigasi">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" style="width: 20px; height: 20px;">
    {!! config('icons.ui_menu') !!}\n</svg>
                </button>
                <div class="admin-topbar-title">{{ $topbarTitle ?? 'Dashboard' }}</div>

                @php $profileIconAsset = $resolveIconAsset('profile'); @endphp
                <div class="profile-menu-wrap" style="display: flex; align-items: center; gap: 16px;">
                    <span style="font-size: 13.5px; font-weight: 600; color: #1e2243; font-family: 'Poppins', sans-serif; margin-right: 8px;">
                        {{ auth('admin')->user()->nama }}
                    </span>
                    <button type="button" class="admin-profile-button" aria-label="Profil admin" data-profile-toggle style="padding: 0; overflow: hidden; display: grid; place-items: center;">
                        @if(auth('admin')->user()->foto)
                            <img src="{{ asset(auth('admin')->user()->foto) }}" style="width: 100% !important; height: 100% !important; object-fit: cover !important; border-radius: 50%;">
                        @else
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" style="width: 20px; height: 20px; color: var(--navy);">
                                <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2m8-10a4 4 0 1 0 0-8 4 4 0 0 0 0 8z" />
                            </svg>
                        @endif
                    </button>

                    {{-- Panel profil dropdown --}}
                    <div class="profile-panel" data-profile-panel hidden style="right: 0; left: auto;">
                        <div class="profile-panel-header">
                            <div class="profile-panel-avatar">
                                @if(auth('admin')->user()->foto)
                                    <img src="{{ asset(auth('admin')->user()->foto) }}" alt="Avatar" style="width: 100% !important; height: 100% !important; object-fit: cover !important; border-radius: 50%;">
                                @else
                                    <span style="font-weight: 700;">{{ strtoupper(substr(auth('admin')->user()->nama, 0, 1)) }}</span>
                                @endif
                            </div>
                            <div class="profile-panel-info">
                                <div class="profile-panel-name">{{ auth('admin')->user()->nama }}</div>
                                <div class="profile-panel-role">Administrator</div>
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
            </header>