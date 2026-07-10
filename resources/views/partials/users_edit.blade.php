<div class="fade-in" data-current-page="users_edit">
    <!-- Header -->
    <div class="d-flex align-items-center mb-4">
        <button onclick="loadPage('users')" class="btn btn-sm btn-light border me-3 shadow-sm" style="border-radius: 10px; width: 40px; height: 40px;">
            <i class="bi bi-arrow-left fs-5"></i>
        </button>
        <div>
            <h4 class="mb-0 fw-bold text-dark">Edit Data User</h4>
            <p class="text-muted mb-0 small">Ubah informasi akun dan hak akses pengguna</p>
        </div>
    </div>

    <!-- Form Container -->
    <div class="row g-4">
        <!-- Info Column -->
        <div class="col-lg-4">
            <div class="p-4 h-100" style="background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%); border-radius: 16px; border: 1px solid var(--border-color);">
                <div class="d-flex align-items-center justify-content-center mb-4" style="width: 50px; height: 50px; background: #fef3c7; border-radius: 12px; color: #d97706;">
                    <i class="bi bi-person-lines-fill fs-3"></i>
                </div>
                <h5 class="fw-bold text-dark mb-2">Pembaruan Data</h5>
                <p class="text-muted small mb-4">Gunakan form di samping untuk mengupdate profil pengguna. Anda bisa mengubah nama, email, dan peran.</p>
                
                <h6 class="fw-bold text-dark mb-3" style="font-size: 0.9rem;">Tentang Password</h6>
                <div class="alert alert-warning border-0 d-flex align-items-start" style="background: #fffbeb; border-radius: 12px; padding: 16px;">
                    <i class="bi bi-info-circle-fill text-warning me-2 mt-1"></i>
                    <div style="font-size: 0.85rem; color: #92400e; line-height: 1.5;">
                        Biarkan kolom password <strong>kosong</strong> jika Anda tidak ingin mengubah sandi yang lama.
                    </div>
                </div>
            </div>
        </div>

        <!-- Form Column -->
        <div class="col-lg-8">
            <div class="form-card p-4 p-md-5" style="background: var(--bg-card); border-radius: 16px; border: 1px solid var(--border-color); box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.03);">
                <form id="formEditUser" class="ajax-form" method="POST" action="{{ route('users.update', $user->id) }}">
                    @csrf
                    @method('PUT')
                    
                    <div class="row g-4">
                        <div class="col-md-6">
                            <label class="form-label-modern fw-semibold text-dark mb-2"><i class="bi bi-person me-1 text-primary"></i> Nama Lengkap</label>
                            <input type="text" name="name" class="form-control form-control-lg bg-light border-0" value="{{ $user->name }}" required placeholder="Contoh: Budi Santoso" style="font-size: 0.95rem; border-radius: 10px;">
                        </div>

                        <div class="col-md-6">
                            <label class="form-label-modern fw-semibold text-dark mb-2"><i class="bi bi-envelope me-1 text-primary"></i> Alamat Email</label>
                            <input type="email" name="email" class="form-control form-control-lg bg-light border-0" value="{{ $user->email }}" required placeholder="email@example.com" style="font-size: 0.95rem; border-radius: 10px;">
                        </div>

                        <div class="col-md-12">
                            <label class="form-label-modern fw-semibold text-dark mb-2"><i class="bi bi-shield-check me-1 text-primary"></i> Pilih Role</label>
                            <select name="role" class="form-select form-select-lg bg-light border-0" required style="font-size: 0.95rem; border-radius: 10px; cursor: pointer;">
                                <option value="admin" {{ $user->role === 'admin' ? 'selected' : '' }}>Admin (Akses Penuh)</option>
                                <option value="anggota" {{ $user->role === 'anggota' ? 'selected' : '' }}>Anggota (Hanya Melihat)</option>
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label-modern fw-semibold text-dark mb-2"><i class="bi bi-key me-1 text-primary"></i> Password Baru <span class="text-muted fw-normal" style="font-size:0.8rem;">(Opsional)</span></label>
                            <input type="password" name="password" class="form-control form-control-lg bg-light border-0" placeholder="Biarkan kosong jika tidak diubah" style="font-size: 0.95rem; border-radius: 10px;">
                        </div>

                        <div class="col-md-6">
                            <label class="form-label-modern fw-semibold text-dark mb-2"><i class="bi bi-check2-all me-1 text-primary"></i> Konfirmasi Password</label>
                            <input type="password" name="password_confirmation" class="form-control form-control-lg bg-light border-0" placeholder="Ketik ulang password baru" style="font-size: 0.95rem; border-radius: 10px;">
                        </div>
                    </div>

                    <hr class="my-4" style="border-color: #f1f5f9;">

                    <div class="d-flex gap-3 justify-content-end">
                        <button type="button" onclick="loadPage('users')" class="btn btn-light px-4" style="border-radius: 10px; font-weight: 500;">
                            Batal
                        </button>
                        <button type="submit" class="btn btn-warning px-4 shadow-sm btn-submit text-white" style="border-radius: 10px; font-weight: 600; background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%); border: none;">
                            <i class="bi bi-pencil-square me-1"></i> Simpan Perubahan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<style>
.form-control:focus, .form-select:focus {
    background-color: #ffffff !important;
    border: 1px solid #f59e0b !important;
    box-shadow: 0 0 0 4px rgba(245, 158, 11, 0.1) !important;
}

.btn-submit {
    transition: all 0.3s ease;
}
.btn-submit:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 15px -3px rgba(245, 158, 11, 0.4) !important;
}
</style>

<script>
document.getElementById('formEditUser').addEventListener('submit', function(e) {
    e.preventDefault();
    
    const formData = new FormData(this);
    
    axios.post(this.action, formData)
        .then(res => {
            showToast('User berhasil diupdate', 'success');
            loadPage('users');
        })
        .catch(err => {
            console.error(err);
            if (err.response?.data?.errors) {
                const errors = Object.values(err.response.data.errors).flat();
                showToast(errors.join('<br>'), 'error');
            } else {
                showToast(err.response?.data?.message || 'Gagal mengupdate user', 'error');
            }
        });
});
</script>
