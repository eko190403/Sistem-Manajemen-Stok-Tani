<div class="fade-in" data-current-page="users_create">
    <!-- Header -->
    <div class="d-flex align-items-center mb-4">
        <button onclick="loadPage('users')" class="btn btn-sm btn-light border me-3 shadow-sm" style="border-radius: 10px; width: 40px; height: 40px;">
            <i class="bi bi-arrow-left fs-5"></i>
        </button>
        <div>
            <h4 class="mb-0 fw-bold text-dark">Tambah User Baru</h4>
            <p class="text-muted mb-0 small">Tambahkan anggota atau admin baru ke dalam sistem</p>
        </div>
    </div>

    <!-- Form Container -->
    <div class="row g-4">
        <!-- Info Column -->
        <div class="col-lg-4">
            <div class="p-4 h-100" style="background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%); border-radius: 16px; border: 1px solid var(--border-color);">
                <div class="d-flex align-items-center justify-content-center mb-4" style="width: 50px; height: 50px; background: #e0e7ff; border-radius: 12px; color: #4f46e5;">
                    <i class="bi bi-shield-lock-fill fs-3"></i>
                </div>
                <h5 class="fw-bold text-dark mb-2">Informasi Akun</h5>
                <p class="text-muted small mb-4">Pastikan alamat email yang didaftarkan aktif dan password memiliki kombinasi yang kuat (minimal 8 karakter).</p>
                
                <h6 class="fw-bold text-dark mb-3" style="font-size: 0.9rem;">Penjelasan Hak Akses (Role)</h6>
                <div class="d-flex align-items-start mb-3">
                    <i class="bi bi-check-circle-fill text-primary me-2 mt-1"></i>
                    <div>
                        <strong class="d-block small text-dark">Admin</strong>
                        <span class="text-muted" style="font-size: 0.8rem; line-height: 1.4; display: block;">Akses penuh ke semua menu, termasuk tambah stok, kelola keuangan, dan manajemen user.</span>
                    </div>
                </div>
                <div class="d-flex align-items-start">
                    <i class="bi bi-check-circle-fill text-secondary me-2 mt-1"></i>
                    <div>
                        <strong class="d-block small text-dark">Anggota</strong>
                        <span class="text-muted" style="font-size: 0.8rem; line-height: 1.4; display: block;">Hanya dapat melihat laporan, riwayat stok, riwayat keuangan, dan mengecek blokchain.</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Form Column -->
        <div class="col-lg-8">
            <div class="form-card p-4 p-md-5" style="background: var(--bg-card); border-radius: 16px; border: 1px solid var(--border-color); box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.03);">
                <form id="formCreateUser" class="ajax-form" method="POST" action="{{ route('users.store') }}">
                    @csrf
                    
                    <div class="row g-4">
                        <div class="col-md-6">
                            <label class="form-label-modern fw-semibold text-dark mb-2"><i class="bi bi-person me-1 text-primary"></i> Nama Lengkap</label>
                            <input type="text" name="name" class="form-control form-control-lg bg-light border-0" required placeholder="Contoh: Budi Santoso" style="font-size: 0.95rem; border-radius: 10px;">
                        </div>

                        <div class="col-md-6">
                            <label class="form-label-modern fw-semibold text-dark mb-2"><i class="bi bi-envelope me-1 text-primary"></i> Alamat Email</label>
                            <input type="email" name="email" class="form-control form-control-lg bg-light border-0" required placeholder="email@example.com" style="font-size: 0.95rem; border-radius: 10px;">
                        </div>

                        <div class="col-md-12">
                            <label class="form-label-modern fw-semibold text-dark mb-2"><i class="bi bi-shield-check me-1 text-primary"></i> Pilih Role</label>
                            <select name="role" class="form-select form-select-lg bg-light border-0" required style="font-size: 0.95rem; border-radius: 10px; cursor: pointer;">
                                <option value="" disabled selected>-- Pilih Hak Akses --</option>
                                <option value="admin">Admin (Akses Penuh)</option>
                                <option value="anggota">Anggota (Hanya Melihat)</option>
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label-modern fw-semibold text-dark mb-2"><i class="bi bi-key me-1 text-primary"></i> Password</label>
                            <input type="password" name="password" class="form-control form-control-lg bg-light border-0" required placeholder="Minimal 8 karakter" style="font-size: 0.95rem; border-radius: 10px;">
                        </div>

                        <div class="col-md-6">
                            <label class="form-label-modern fw-semibold text-dark mb-2"><i class="bi bi-check2-all me-1 text-primary"></i> Konfirmasi Password</label>
                            <input type="password" name="password_confirmation" class="form-control form-control-lg bg-light border-0" required placeholder="Ketik ulang password" style="font-size: 0.95rem; border-radius: 10px;">
                        </div>
                    </div>

                    <hr class="my-4" style="border-color: #f1f5f9;">

                    <div class="d-flex gap-3 justify-content-end">
                        <button type="button" onclick="loadPage('users')" class="btn btn-light px-4" style="border-radius: 10px; font-weight: 500;">
                            Batal
                        </button>
                        <button type="submit" class="btn btn-primary px-4 shadow-sm btn-submit" style="border-radius: 10px; font-weight: 600; background: linear-gradient(135deg, #4f46e5 0%, #3b82f6 100%); border: none;">
                            <i class="bi bi-person-plus-fill me-1"></i> Simpan User Baru
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
    border: 1px solid #3b82f6 !important;
    box-shadow: 0 0 0 4px rgba(59, 130, 246, 0.1) !important;
}

.btn-submit {
    transition: all 0.3s ease;
}
.btn-submit:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 15px -3px rgba(59, 130, 246, 0.4) !important;
}
</style>

<script>
document.getElementById('formCreateUser').addEventListener('submit', function(e) {
    e.preventDefault();
    
    const formData = new FormData(this);
    
    axios.post(this.action, formData)
        .then(res => {
            showToast('User berhasil ditambahkan', 'success');
            loadPage('users');
        })
        .catch(err => {
            console.error(err);
            if (err.response?.data?.errors) {
                const errors = Object.values(err.response.data.errors).flat();
                showToast(errors.join('<br>'), 'error');
            } else {
                showToast(err.response?.data?.message || 'Gagal menambahkan user', 'error');
            }
        });
});
</script>
