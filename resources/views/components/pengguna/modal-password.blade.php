<div id="passwordModal" class="hidden premium-modal-overlay">
    <div class="premium-modal-shell">
        <div class="premium-modal-card">
            <button type="button" onclick="closePasswordModal()" class="premium-modal-close-btn" aria-label="Tutup">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
    {!! config('icons.ui_tutup') !!}\n</svg>
            </button>

            <h2 class="premium-modal-title">Ubah Kata Sandi</h2>

            <form action="{{ route('pengguna.password.update') }}" method="POST">
                @csrf
                @method('PUT')

                <div class="premium-modal-form-group">
                    <label class="premium-modal-label">Kata Sandi Lama</label>
                    <input type="password" name="old_password" required class="premium-modal-input" placeholder="Masukkan kata sandi lama">
                </div>

                <div class="premium-modal-form-group">
                    <label class="premium-modal-label">Kata Sandi Baru</label>
                    <input type="password" name="password" required class="premium-modal-input" placeholder="Masukkan kata sandi baru">
                </div>

                <div class="premium-modal-form-group">
                    <label class="premium-modal-label">Konfirmasi Kata Sandi Baru</label>
                    <input type="password" name="password_confirmation" required class="premium-modal-input" placeholder="Ulangi kata sandi baru">
                </div>

                <div class="premium-modal-actions">
                    <button type="button" onclick="closePasswordModal()" class="premium-modal-btn btn-cancel">Batal</button>
                    <button type="submit" class="premium-modal-btn btn-save">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>
