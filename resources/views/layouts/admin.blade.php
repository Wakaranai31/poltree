<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $pageTitle ?? ('Admin - '.config('app.name', 'POLTREE')) }}</title>
    <meta name="description" content="Dashboard admin POLTREE untuk mengelola layanan, pengguna, dan kategori.">
    {{-- Google Fonts: Poppins --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    {{-- Vite: Tailwind + CSS + JS --}}
    @vite(['resources/css/app.css', 'resources/css/admin.css', 'resources/js/app.js'])
    @stack('styles')
</head>

<body>
    {{-- ═══════════════════════════════════════════════════════
         Icon paths & asset resolver (dipakai sidebar & topbar)
         ═══════════════════════════════════════════════════════ --}}
    @php
    $iconAssets = [
    'home' => 'icons/admin/home.svg',
    'sparkles' => 'icons/admin/services.svg',
    'user' => 'icons/admin/user.svg',
    'chain' => 'icons/admin/links.svg',
    'folder' => 'icons/admin/categories.svg',
    'profile' => 'icons/admin/profile.svg',
    'tag' => 'icons/admin/tag.svg',
    ];

    $resolveIconAsset = static function (string $key) use ($iconAssets): ?string {
    $path = $iconAssets[$key] ?? null;
    if (! $path) return null;
    return file_exists(public_path($path)) ? asset($path) : null;
    };
    @endphp

    <div class="sidebar-overlay" id="sidebarOverlay"></div>

    <div class="admin-shell">
        {{-- ═══════════════════════════════════════════════════
             SIDEBAR: Logo + Navigasi admin
             ═══════════════════════════════════════════════════ --}}
        @include('components.admin.sidebar')

        <div class="admin-main">
            {{-- ═══════════════════════════════════════════════
                 TOPBAR: Judul halaman + Profil
                 ═══════════════════════════════════════════════ --}}
            @include('components.admin.header')

            {{-- ═══════════════════════════════════════════════
                 MODAL: Ubah Kata Sandi Admin
                 ═══════════════════════════════════════════════ --}}
            @include('components.admin.modal-password')

            {{-- Container for premium global toasts --}}
            <div id="toastContainer" class="toast-container"></div>

            @if (session('success'))
            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    showToast("{{ session('success') }}", 'success');
                });
            </script>
            @endif

            @if ($errors->any())
            @php
            $semuaError = $errors->all();
            @endphp
            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    const errorList = @json($semuaError);
                    errorList.forEach(function(error) {
                        showToast(error, 'error');
                    });
                });
            </script>
            @endif


            @if (session('error'))
            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    showToast("{{ session('error') }}", 'error');
                });
            </script>
            @endif

            {{-- Konten halaman admin --}}
            <main class="admin-content">
                @yield('content')
            </main>

            {{-- Footer Global --}}
            @include('components.shared.footer')
        </div>
    </div>

    {{-- ═══════════════════════════════════════════════════════
         MODAL: Konfirmasi Hapus (Global - Premium Style)
         ═══════════════════════════════════════════════════════ --}}
    <div id="confirmDeleteModal" class="hidden premium-modal-overlay">
        <div class="premium-modal-shell">
            <div class="premium-modal-card">
                <button type="button" onclick="closeConfirmModal()" class="premium-modal-close-btn" aria-label="Tutup">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
    {!! config('icons.ui_tutup') !!}\n</svg>
                </button>

                <h2 class="premium-modal-title">Konfirmasi Hapus</h2>

                <div style="text-align: center; margin-bottom: 24px;">
                    <div style="width: 56px; height: 56px; margin: 0 auto 16px; border-radius: 50%; background: #fff0ed; display: flex; align-items: center; justify-content: center;">
                        <svg viewBox="0 0 24 24" fill="none" stroke="#ff3f0a" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" style="width: 28px; height: 28px;">
    {!! config('icons.ui_peringatan') !!}\n</svg>
                    </div>
                    <p id="confirmDeleteMessage" style="font-size: 14px; color: #555b77; line-height: 1.6; font-weight: 500;">Apakah Anda yakin ingin menghapus data ini? Tindakan ini tidak dapat dibatalkan.</p>
                </div>

                <div class="premium-modal-actions">
                    <button type="button" class="premium-modal-btn btn-cancel" onclick="closeConfirmModal()">Batal</button>
                    <button type="button" class="premium-modal-btn btn-save" style="background: #ff3f0a; box-shadow: 0 6px 18px rgba(255, 63, 10, 0.2);" id="confirmDeleteBtn" onclick="executeDelete()">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" style="margin-right: 6px; display: inline-block; vertical-align: middle;">
    {!! config('icons.ui_hapus') !!}\n</svg>
                        <span style="vertical-align: middle;">Hapus</span>
                    </button>
                </div>
            </div>
        </div>
    </div>

    {{-- ═══════════════════════════════════════════════════════
         MODAL: Profil Saya (Premium Style)
         ═══════════════════════════════════════════════════════ --}}
    <div id="profileModal" class="hidden premium-modal-overlay">
        <div class="premium-modal-shell">
            <div class="premium-modal-card" style="max-width: 440px; padding: 28px 24px 20px;">
                <button type="button" onclick="closeProfileModal()" class="premium-modal-close-btn" aria-label="Tutup">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
    {!! config('icons.ui_tutup') !!}\n</svg>
                </button>

                <h2 class="premium-modal-title" style="margin-bottom: 20px;">Profil Saya</h2>

                <form id="profileForm" action="{{ route('admin.profile.update') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="profile-avatar-section" style="text-align: center; margin-bottom: 20px;">
                        <div class="profile-avatar-wrapper" onclick="triggerProfilePhotoUpload()" style="position: relative; width: 80px; height: 80px; margin: 0 auto 12px; cursor: default; transition: all 0.2s ease;">
                            <div id="profileAvatarCircle" style="width: 100%; height: 100%; border-radius: 50%; overflow: hidden; background: linear-gradient(135deg, #080d5f, #0f179e); display: flex; align-items: center; justify-content: center; box-shadow: 0 8px 20px rgba(8, 13, 95, 0.15); border: 2px solid #fff;">
                                @if(auth('admin')->user()->foto)
                                <img id="profileAvatarImg" src="{{ asset(auth('admin')->user()->foto) }}" style="width: 100%; height: 100%; object-fit: cover;">
                                @else
                                <span id="profileAvatarInitials" style="font-size: 28px; font-weight: 700; color: white; text-transform: uppercase;">
                                    {{ substr(auth('admin')->user()->nama_admin ?? 'A', 0, 1) }}
                                </span>
                                @endif
                            </div>
                            {{-- Camera Edit Overlay --}}
                            <div class="avatar-edit-overlay" style="display: none; position: absolute; inset: 0; background: rgba(0, 0, 0, 0.4); border-radius: 50%; align-items: center; justify-content: center; color: #fff; font-size: 11px; font-weight: bold; pointer-events: none;">
                                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M23 19a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h4l2-3h6l2 3h4a2 2 0 0 1 2 2z"></path>
                                    <circle cx="12" cy="13" r="4"></circle>
                                </svg>
                            </div>
                            <input type="file" name="foto" id="profilePhotoInput" accept="image/*" style="display: none;" onchange="previewProfilePhoto(this)">
                        </div>

                        <h3 class="profile-view-only" style="font-size: 16.5px; font-weight: 700; color: #1e2243; margin-bottom: 4px;">
                            {{ auth('admin')->user()->nama_admin ?? '-' }}
                        </h3>

                        <div class="profile-edit-only" style="display: none; flex-direction: column; align-items: stretch; width: 100%; max-width: 280px; margin: 0 auto 10px;">
                            <label class="premium-modal-label" style="text-align: left; font-size: 11px; margin-bottom: 4px;">Nama Lengkap</label>
                            <input type="text" name="nama_admin" value="{{ auth('admin')->user()->nama_admin }}" required class="premium-modal-input" style="width: 100%; text-align: center; font-weight: 700; font-size: 14.5px; height: 38px; border-radius: 10px;">
                        </div>

                        <span style="display: inline-block; font-size: 10.5px; font-weight: 700; padding: 4px 12px; border-radius: 20px; background: #eef1f8; color: #080d5f; text-transform: uppercase; letter-spacing: 0.5px;">
                            Administrator
                        </span>
                    </div>

                    <div class="profile-info-grid" style="display: flex; flex-direction: column; gap: 12px; margin-bottom: 24px; background: #f8fafc; border-radius: 14px; padding: 16px; border: 1px solid rgba(8, 13, 95, 0.04);">
                        <div style="display: flex; justify-content: space-between; align-items: center; border-bottom: 1px dashed rgba(8, 13, 95, 0.08); padding-bottom: 8px;">
                            <span style="font-size: 12.5px; font-weight: 600; color: #8a8fa5;">Nomor Induk (NIK)</span>
                            <span style="font-size: 12.5px; font-weight: 700; color: #1e2243;">
                                {{ auth('admin')->user()->nik_admin ?? '-' }}
                            </span>
                        </div>

                        <div style="display: flex; justify-content: space-between; align-items: center; border-bottom: 1px dashed rgba(8, 13, 95, 0.08); padding-bottom: 8px;">
                            <span style="font-size: 12.5px; font-weight: 600; color: #8a8fa5; display: flex; align-items: center; gap: 4px;">
                                Alamat Email
                                <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" class="opacity-50" style="vertical-align: middle;" title="Email tidak dapat diubah">
                                    <rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect>
                                    <path d="M7 11V7a5 5 0 0 1 10 0v4"></path>
                                </svg>
                            </span>
                            <span style="font-size: 12.5px; font-weight: 700; color: #8a8fa5;">
                                {{ auth('admin')->user()->email ?? '-' }}
                            </span>
                        </div>

                        <div style="display: flex; justify-content: space-between; align-items: center;">
                            <span style="font-size: 12.5px; font-weight: 600; color: #8a8fa5;">Status Akun</span>
                            <span style="display: flex; align-items: center; gap: 6px; font-size: 12.5px; font-weight: 700; color: #10b981;">
                                <span style="width: 8px; height: 8px; border-radius: 50%; background: #10b981;"></span>
                                Aktif
                            </span>
                        </div>
                    </div>

                    <div class="premium-modal-actions" style="margin-top: 0; display: flex; gap: 12px; width: 100%;">
                        <div class="profile-view-only" style="display: flex; gap: 12px; width: 100%;">
                            <button type="button" onclick="toggleProfileEditMode(true)" class="flex-1 h-11 rounded-xl bg-[#080d5f] cursor-pointer font-semibold text-white hover:bg-[#0c148f] transition-all duration-200" style="font-size: 14px; border: none;">
                                Edit Profil
                            </button>
                            <button type="button" onclick="closeProfileModal()" class="flex-1 h-11 rounded-xl border border-gray-200 bg-white cursor-pointer font-semibold text-[#1e2243] hover:bg-gray-50 transition-all duration-200" style="font-size: 14px;">
                                Tutup
                            </button>
                        </div>
                        <div class="profile-edit-only" style="display: none; gap: 12px; width: 100%;">
                            <button type="submit" class="flex-1 h-11 rounded-xl bg-[#10b981] cursor-pointer font-semibold text-white hover:bg-[#0d9668] transition-all duration-200" style="font-size: 14px; border: none;">
                                Simpan
                            </button>
                            <button type="button" onclick="toggleProfileEditMode(false)" class="flex-1 h-11 rounded-xl border border-gray-200 bg-white cursor-pointer font-semibold text-[#1e2243] hover:bg-gray-50 transition-all duration-200" style="font-size: 14px;">
                                Batal
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- ═══════════════════════════════════════════════════════
         SCRIPT: Profil toggle & Password modal
         ═══════════════════════════════════════════════════════ --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const profileToggle = document.querySelector('[data-profile-toggle]');
            const profilePanel = document.querySelector('[data-profile-panel]');

            if (profileToggle && profilePanel) {
                profileToggle.addEventListener('click', function(e) {
                    e.stopPropagation();
                    const isHidden = profilePanel.hasAttribute('hidden');
                    if (isHidden) {
                        profilePanel.removeAttribute('hidden');
                    } else {
                        profilePanel.setAttribute('hidden', '');
                    }
                });

                document.addEventListener('click', function(e) {
                    if (!profilePanel.hasAttribute('hidden') && !profilePanel.contains(e.target) && e.target !== profileToggle) {
                        profilePanel.setAttribute('hidden', '');
                    }
                });
            }
        });

        function openProfileModal() {
            const m = document.getElementById('profileModal');
            m.classList.remove('hidden');
            m.classList.add('flex');

            // Close topbar profile panel
            const profilePanel = document.querySelector('[data-profile-panel]');
            if (profilePanel) {
                profilePanel.setAttribute('hidden', '');
            }
        }

        function closeProfileModal() {
            const m = document.getElementById('profileModal');
            if (!m) return;
            m.classList.add('closing');
            setTimeout(() => {
                m.classList.add('hidden');
                m.classList.remove('flex', 'closing');
                toggleProfileEditMode(false); // Reset to view mode on close
            }, 300);
        }

        function toggleProfileEditMode(isEdit) {
            const modal = document.getElementById('profileModal');
            const viewGroup = modal.querySelectorAll('.profile-view-only');
            const editGroup = modal.querySelectorAll('.profile-edit-only');
            const overlay = modal.querySelector('.avatar-edit-overlay');
            const wrapper = modal.querySelector('.profile-avatar-wrapper');

            if (isEdit) {
                viewGroup.forEach(el => el.style.setProperty('display', 'none', 'important'));
                editGroup.forEach(el => el.style.setProperty('display', 'flex', 'important'));
                if (overlay) overlay.style.display = 'flex';
                if (wrapper) wrapper.style.cursor = 'pointer';
            } else {
                viewGroup.forEach(el => el.style.setProperty('display', '', ''));
                editGroup.forEach(el => el.style.setProperty('display', 'none', 'important'));
                if (overlay) overlay.style.display = 'none';
                if (wrapper) wrapper.style.cursor = 'default';

                // Reset form
                document.getElementById('profileForm').reset();

                // Restore original preview
                const originalFoto = "{{ auth('admin')->user()->foto ? asset(auth('admin')->user()->foto) : '' }}";
                const originalInitials = "{{ substr(auth('admin')->user()->nama_admin ?? 'A', 0, 1) }}";
                const circle = document.getElementById('profileAvatarCircle');
                if (originalFoto) {
                    circle.innerHTML = `<img id="profileAvatarImg" src="${originalFoto}" style="width: 100%; height: 100%; object-fit: cover;">`;
                } else {
                    circle.innerHTML = `<span id="profileAvatarInitials" style="font-size: 28px; font-weight: 700; color: white; text-transform: uppercase;">${originalInitials}</span>`;
                }
            }
        }

        function triggerProfilePhotoUpload() {
            const modal = document.getElementById('profileModal');
            const editGroup = modal.querySelector('.profile-edit-only');
            // Only trigger in edit mode
            if (editGroup && editGroup.style.display !== 'none') {
                document.getElementById('profilePhotoInput').click();
            }
        }

        function previewProfilePhoto(input) {
            const file = input.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    const circle = document.getElementById('profileAvatarCircle');
                    circle.innerHTML = `<img id="profileAvatarImg" src="${e.target.result}" style="width: 100%; height: 100%; object-fit: cover;">`;
                };
                reader.readAsDataURL(file);
            }
        }

        function openPasswordModal() {
            const m = document.getElementById('passwordModal');
            m.classList.remove('hidden');
            m.classList.add('flex');
        }

        function closePasswordModal() {
            const m = document.getElementById('passwordModal');
            if (!m) return;
            m.classList.add('closing');
            setTimeout(() => {
                m.classList.add('hidden');
                m.classList.remove('flex', 'closing');
            }, 300);
        }

        /* ── Confirm Delete Modal ─────────────────────────────── */
        let _pendingDeleteForm = null;

        function confirmDelete(formElement, message) {
            _pendingDeleteForm = formElement;
            const modal = document.getElementById('confirmDeleteModal');
            const msgEl = document.getElementById('confirmDeleteMessage');
            msgEl.textContent = message || 'Apakah Anda yakin ingin menghapus data ini? Tindakan ini tidak dapat dibatalkan.';
            modal.classList.remove('hidden');
            modal.classList.add('flex');
        }

        function closeConfirmModal() {
            const modal = document.getElementById('confirmDeleteModal');
            if (!modal) return;
            modal.classList.add('closing');
            setTimeout(() => {
                _pendingDeleteForm = null;
                modal.classList.add('hidden');
                modal.classList.remove('flex', 'closing');
            }, 300);
        }

        function executeDelete() {
            if (_pendingDeleteForm) {
                _pendingDeleteForm.submit();
            }
            closeConfirmModal();
        }

        /* ── Premium Toast Notification Utility ────────────────── */
        window.showToast = function(message, type = 'success') {
            const container = document.getElementById('toastContainer');
            if (!container) return;

            const toast = document.createElement('div');
            toast.className = `premium-toast ${type}`;

            let icon = '';
            if (type === 'success') {
                icon = `
                    <svg class="toast-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path>
                        <polyline points="22 4 12 14.01 9 11.01"></polyline>
                    </svg>
                `;
            } else if (type === 'error') {
                icon = `
                    <svg class="toast-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
    {!! config('icons.ui_peringatan') !!}\n</svg>
                `;
            } else {
                icon = `
                    <svg class="toast-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
    {!! config('icons.ui_peringatan_alt') !!}\n</svg>
                `;
            }

            toast.innerHTML = `
                <div class="toast-content">
                    <div class="toast-icon-wrap">${icon}</div>
                    <div class="toast-message">${message}</div>
                    <button type="button" class="toast-close-btn" onclick="this.parentElement.parentElement.remove()" aria-label="Tutup">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
    {!! config('icons.ui_tutup') !!}\n</svg>
                    </button>
                </div>
                <div class="toast-progress-bar"></div>
            `;

            container.appendChild(toast);

            // Auto dismiss after 4 seconds
            setTimeout(() => {
                toast.classList.add('hide');
                setTimeout(() => {
                    toast.remove();
                }, 400);
            }, 4000);
        };

        // ── Premium Custom Select ──
        window.initPremiumSelect = function(selectEl) {
            if (!selectEl || selectEl.dataset.premiumSelectInitialized) {
                return;
            }

            // Hide original select
            selectEl.style.display = 'none';

            // Create wrapper
            const wrapper = document.createElement('div');
            wrapper.className = 'premium-select-wrapper';

            // Insert wrapper before selectEl
            selectEl.parentNode.insertBefore(wrapper, selectEl);
            wrapper.appendChild(selectEl); // move selectEl inside wrapper

            // Create trigger
            const trigger = document.createElement('div');
            trigger.className = 'premium-select-trigger';
            trigger.setAttribute('tabindex', '0');

            const triggerText = document.createElement('span');
            triggerText.className = 'trigger-text';

            const currentOption = selectEl.options[selectEl.selectedIndex];
            triggerText.textContent = currentOption ? currentOption.textContent : 'Pilih...';

            const triggerArrow = document.createElement('span');
            triggerArrow.className = 'trigger-arrow';
            triggerArrow.innerHTML = `<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" style="width:14px; height:14px;">
    {!! config('icons.ui_panah_bawah') !!}\n</svg>`;

            trigger.appendChild(triggerText);
            trigger.appendChild(triggerArrow);
            wrapper.appendChild(trigger);

            // Create options container - Append to document.body to avoid clipping
            const optionsContainer = document.createElement('div');
            optionsContainer.className = 'premium-select-options';
            document.body.appendChild(optionsContainer);

            // Build option items function
            const buildOptions = function() {
                optionsContainer.innerHTML = '';
                Array.from(selectEl.options).forEach(function(opt, idx) {
                    const optEl = document.createElement('div');
                    optEl.className = 'premium-select-option';
                    if (opt.selected) {
                        optEl.classList.add('is-selected');
                    }
                    optEl.dataset.value = opt.value;
                    optEl.dataset.index = idx;

                    const optText = document.createElement('span');
                    optText.textContent = opt.textContent;

                    const optCheck = document.createElement('span');
                    optCheck.className = 'option-check';
                    optCheck.innerHTML = `<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round" style="width:12px; height:12px;">
    {!! config('icons.ui_centang') !!}\n</svg>`;

                    optEl.appendChild(optText);
                    optEl.appendChild(optCheck);

                    optEl.addEventListener('click', function(e) {
                        e.stopPropagation();
                        selectEl.selectedIndex = idx;
                        triggerText.textContent = opt.textContent;

                        // Trigger change event on original select
                        const event = new Event('change', {
                            bubbles: true
                        });
                        selectEl.dispatchEvent(event);

                        closeDropdown();
                    });

                    optionsContainer.appendChild(optEl);
                });
            };

            const toggleDropdown = function() {
                const isOpen = optionsContainer.classList.contains('is-open');
                if (isOpen) {
                    closeDropdown();
                } else {
                    openDropdown();
                }
            };

            const openDropdown = function() {
                // Close all other open premium selects first
                document.querySelectorAll('.premium-select-options.is-open').forEach(function(el) {
                    if (el !== optionsContainer) {
                        el.classList.remove('is-open');
                        const triggerEl = document.querySelector('.premium-select-trigger.is-active');
                        if (triggerEl) {
                            triggerEl.classList.remove('is-active');
                        }
                    }
                });

                buildOptions(); // Rebuild options to reflect current selection/state

                // Position options list right under the trigger
                const rect = trigger.getBoundingClientRect();
                optionsContainer.style.position = 'fixed';
                optionsContainer.style.top = `${rect.bottom + 6}px`;
                optionsContainer.style.left = `${rect.left}px`;
                optionsContainer.style.width = `${rect.width}px`;
                optionsContainer.style.zIndex = '99999';

                optionsContainer.classList.add('is-open');
                trigger.classList.add('is-active');
            };

            const closeDropdown = function() {
                optionsContainer.classList.remove('is-open');
                trigger.classList.remove('is-active');
            };

            trigger.addEventListener('click', function(e) {
                e.stopPropagation();
                toggleDropdown();
            });

            // Focus and keyboard navigation
            trigger.addEventListener('keydown', function(e) {
                if (e.key === ' ' || e.key === 'Enter') {
                    e.preventDefault();
                    toggleDropdown();
                } else if (e.key === 'Escape') {
                    closeDropdown();
                }
            });

            // Close on click outside
            document.addEventListener('click', function(e) {
                if (!wrapper.contains(e.target) && !optionsContainer.contains(e.target)) {
                    closeDropdown();
                }
            });

            // Close dropdowns on scroll or window resize to prevent floating issues
            window.addEventListener('scroll', closeDropdown, true);
            window.addEventListener('resize', closeDropdown);

            // Mark as initialized
            selectEl.dataset.premiumSelectInitialized = 'true';

            // Add reference on original select element so we can manually trigger update/refresh
            selectEl.refreshPremiumSelect = function() {
                const opt = selectEl.options[selectEl.selectedIndex];
                triggerText.textContent = opt ? opt.textContent : 'Pilih...';
            };
        };

        // Automatically initialize all custom selects on DOMContentLoaded
        document.addEventListener('DOMContentLoaded', function() {
            const selects = document.querySelectorAll('select.premium-modal-input, select.services-select');
            selects.forEach(function(select) {
                window.initPremiumSelect(select);
            });

            // ── Mobile Sidebar Toggle ──
            const sidebarToggle = document.getElementById('sidebarToggle');
            const sidebar = document.querySelector('.admin-sidebar');
            const sidebarOverlay = document.getElementById('sidebarOverlay');

            if (sidebarToggle && sidebar && sidebarOverlay) {
                const openSidebar = () => {
                    sidebar.classList.add('open');
                    sidebarOverlay.classList.add('active');
                    document.body.style.overflow = 'hidden';
                };

                const closeSidebar = () => {
                    sidebar.classList.remove('open');
                    sidebarOverlay.classList.remove('active');
                    document.body.style.overflow = '';
                };

                sidebarToggle.addEventListener('click', (e) => {
                    e.stopPropagation();
                    if (sidebar.classList.contains('open')) {
                        closeSidebar();
                    } else {
                        openSidebar();
                    }
                });

                sidebarOverlay.addEventListener('click', closeSidebar);
            }
        });

        // Global View Mode Toggle Handler
        window.initializeViewModeToggle = function(pageKey) {
            const wrapper = document.querySelector('.view-wrapper');
            if (!wrapper) return;

            // Get stored preference (default: table)
            const savedMode = localStorage.getItem(`poltree_view_mode_${pageKey}`) || 'table';

            // Apply saved mode
            wrapper.classList.remove('view-mode-table', 'view-mode-card');
            wrapper.classList.add(`view-mode-${savedMode}`);

            // Update active state of buttons
            document.querySelectorAll('.view-toggle-btn').forEach(btn => {
                const mode = btn.getAttribute('data-view-mode');
                if (mode === savedMode) {
                    btn.classList.add('active');
                } else {
                    btn.classList.remove('active');
                }

                // Add click listener
                btn.addEventListener('click', function() {
                    const selectedMode = this.getAttribute('data-view-mode');
                    localStorage.setItem(`poltree_view_mode_${pageKey}`, selectedMode);

                    wrapper.classList.remove('view-mode-table', 'view-mode-card');
                    wrapper.classList.add(`view-mode-${selectedMode}`);

                    document.querySelectorAll('.view-toggle-btn').forEach(b => {
                        b.classList.remove('active');
                    });
                    this.classList.add('active');
                });
            });
        };
    </script>
    @stack('modals')
    @stack('scripts')
</body>

</html>
