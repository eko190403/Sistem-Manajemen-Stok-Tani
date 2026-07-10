<div class="fade-in" data-current-page="profile">
    <!-- Header -->
    <div class="mb-4">
        <h4 class="mb-1 fw-bold" style="color: var(--text-main);">
            <i class="bi bi-person-circle text-primary"></i> Profil Pengguna
        </h4>
        <p class="text-muted mb-0 small">Kelola informasi akun dan keamanan Anda</p>
    </div>

    <!-- Profile Overview Card -->
    <div class="profile-overview-card mb-4">
        <div class="d-flex align-items-center gap-4">
            <div class="profile-avatar">
                <i class="bi bi-person-fill"></i>
            </div>
            <div class="flex-grow-1">
                <h5 class="mb-1 fw-bold text-dark">{{ $user->name }}</h5>
                <p class="text-muted mb-2 small">{{ $user->email }}</p>
                <div class="d-flex gap-2 align-items-center flex-wrap">
                    <span class="profile-badge {{ $user->role === 'admin' ? 'badge-admin' : 'badge-user' }}">
                        <i class="bi {{ $user->role === 'admin' ? 'bi-shield-check' : 'bi-person-badge' }}"></i>
                        {{ ucfirst($user->role) }}
                    </span>
                    <span class="text-muted small">
                        <i class="bi bi-calendar-check"></i> 
                        Bergabung {{ $user->created_at?->format('d M Y') }}
                    </span>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-4">
        <!-- Informasi Akun -->
        <div class="col-lg-6">
            <div class="profile-card">
                <div class="card-header-profile">
                    <i class="bi bi-person-lines-fill text-primary"></i>
                    <h5 class="mb-0">Informasi Akun</h5>
                </div>
                <div class="card-body-profile">
                    <form class="ajax-form" method="POST" action="{{ route('profile.update') }}">
                        @csrf
                        <div class="mb-4">
                            <label class="form-label-modern fw-semibold text-dark mb-2"><i class="bi bi-person me-1 text-primary"></i> Nama Lengkap</label>
                            <input type="text" 
                                   name="name" 
                                   class="form-control form-control-lg bg-light border-0" 
                                   value="{{ $user->name }}" 
                                   required 
                                   placeholder="Masukkan nama lengkap" style="font-size: 0.95rem; border-radius: 10px;">
                        </div>
                        <div class="mb-4">
                            <label class="form-label-modern fw-semibold text-dark mb-2"><i class="bi bi-envelope me-1 text-primary"></i> Email</label>
                            <input type="email" 
                                   name="email" 
                                   class="form-control form-control-lg bg-light border-0" 
                                   value="{{ $user->email }}" 
                                   required 
                                   placeholder="email@example.com" style="font-size: 0.95rem; border-radius: 10px;">
                        </div>
                        <button type="submit" class="btn-profile btn-save">
                            <i class="bi bi-check-circle"></i> 
                            <span>Simpan Perubahan</span>
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Ubah Password -->
        <div class="col-lg-6">
            <div class="profile-card h-100">
                <div class="card-header-profile">
                    <i class="bi bi-shield-lock text-warning"></i>
                    <h5 class="mb-0">Keamanan Akun</h5>
                </div>
                <div class="card-body-profile">
                    <form class="ajax-form" method="POST" action="{{ route('profile.password') }}">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label-modern fw-semibold text-dark mb-2"><i class="bi bi-lock me-1 text-warning"></i> Password Saat Ini</label>
                            <input type="password" 
                                   name="current_password" 
                                   class="form-control form-control-lg bg-light border-0" 
                                   required 
                                   placeholder="••••••••" style="font-size: 0.95rem; border-radius: 10px;">
                        </div>
                        <div class="mb-3">
                            <label class="form-label-modern fw-semibold text-dark mb-2"><i class="bi bi-key me-1 text-warning"></i> Password Baru</label>
                            <input type="password" 
                                   name="password" 
                                   class="form-control form-control-lg bg-light border-0" 
                                   required 
                                   placeholder="Minimal 8 karakter" style="font-size: 0.95rem; border-radius: 10px;">
                        </div>
                        <div class="mb-4">
                            <label class="form-label-modern fw-semibold text-dark mb-2"><i class="bi bi-check2-all me-1 text-warning"></i> Konfirmasi Password</label>
                            <input type="password" 
                                   name="password_confirmation" 
                                   class="form-control form-control-lg bg-light border-0" 
                                   required 
                                   placeholder="Ketik ulang password baru" style="font-size: 0.95rem; border-radius: 10px;">
                        </div>
                        <button type="submit" class="btn-profile btn-update">
                            <i class="bi bi-shield-check"></i> 
                            <span>Ubah Password</span>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Detail Info Card -->
    <div class="profile-card mt-4">
        <div class="card-header-profile">
            <i class="bi bi-info-circle text-info"></i>
            <h5 class="mb-0">Informasi Detail</h5>
        </div>
        <div class="card-body-profile">
            <div class="row g-3">
                <div class="col-md-6">
                    <div class="info-item">
                        <div class="info-icon bg-primary">
                            <i class="bi bi-person"></i>
                        </div>
                        <div class="info-content">
                            <small class="text-muted">Nama Pengguna</small>
                            <strong class="d-block text-dark">{{ $user->name }}</strong>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="info-item">
                        <div class="info-icon bg-success">
                            <i class="bi bi-envelope"></i>
                        </div>
                        <div class="info-content">
                            <small class="text-muted">Email</small>
                            <strong class="d-block text-dark">{{ $user->email }}</strong>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="info-item">
                        <div class="info-icon bg-info">
                            <i class="bi bi-calendar-plus"></i>
                        </div>
                        <div class="info-content">
                            <small class="text-muted">Tanggal Daftar</small>
                            <strong class="d-block text-dark">{{ $user->created_at?->format('d M Y, H:i') }}</strong>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="info-item">
                        <div class="info-icon bg-warning">
                            <i class="bi bi-clock-history"></i>
                        </div>
                        <div class="info-content">
                            <small class="text-muted">Terakhir Diubah</small>
                            <strong class="d-block text-dark">{{ $user->updated_at?->format('d M Y, H:i') }}</strong>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
/* Profile Overview Card */
.profile-overview-card {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    padding: 2rem;
    border-radius: 16px;
    box-shadow: 0 10px 30px rgba(102, 126, 234, 0.3);
    color: white;
}

.profile-avatar {
    width: 80px;
    height: 80px;
    background: rgba(255, 255, 255, 0.2);
    border: 3px solid rgba(255, 255, 255, 0.3);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 2.5rem;
    color: white;
}

.profile-badge {
    padding: 0.4rem 0.85rem;
    border-radius: 20px;
    font-size: 0.75rem;
    font-weight: 500;
    display: inline-flex;
    align-items: center;
    gap: 0.4rem;
}

.badge-admin {
    background: rgba(239, 68, 68, 0.9);
    color: white;
}

.badge-user {
    background: rgba(16, 185, 129, 0.9);
    color: white;
}

/* Profile Card */
.profile-card {
    background: white;
    border-radius: 12px;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
    overflow: hidden;
    transition: all 0.3s ease;
}

.profile-card:hover {
    box-shadow: 0 4px 16px rgba(0, 0, 0, 0.12);
    transform: translateY(-2px);
}

.card-header-profile {
    background: linear-gradient(135deg, #F9FAFB 0%, #F3F4F6 100%);
    padding: 1.25rem 1.5rem;
    border-bottom: 2px solid #E5E7EB;
    display: flex;
    align-items: center;
    gap: 0.75rem;
}

.card-header-profile i {
    font-size: 1.5rem;
}

.card-header-profile h5 {
    color: var(--text-main);
    font-weight: 600;
    font-size: 1.1rem;
}

.card-body-profile {
    padding: 1.5rem;
}

/* Form Modern */
.form-label-modern {
    color: #374151;
    font-weight: 500;
    font-size: 0.875rem;
    margin-bottom: 0.5rem;
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.form-control:focus {
    background-color: #ffffff !important;
    border: 1px solid #3b82f6 !important;
    box-shadow: 0 0 0 4px rgba(59, 130, 246, 0.1) !important;
}

/* Button Profile */
.btn-profile {
    padding: 0.75rem 1.5rem;
    border-radius: 8px;
    border: none;
    font-weight: 500;
    font-size: 0.9rem;
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    transition: all 0.2s ease;
    cursor: pointer;
    width: 100%;
    justify-content: center;
}

.btn-save {
    background: linear-gradient(135deg, #10B981 0%, #059669 100%);
    color: white;
    box-shadow: 0 4px 12px rgba(16, 185, 129, 0.3);
}

.btn-save:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 16px rgba(16, 185, 129, 0.4);
}

.btn-update {
    background: linear-gradient(135deg, #2563EB 0%, #1D4ED8 100%);
    color: white;
    box-shadow: 0 4px 12px rgba(37, 99, 235, 0.3);
}

.btn-update:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 16px rgba(37, 99, 235, 0.4);
}

/* Info Item */
.info-item {
    display: flex;
    align-items: center;
    gap: 1rem;
    padding: 1rem;
    background: #F9FAFB;
    border-radius: 10px;
    transition: all 0.2s ease;
}

.info-item:hover {
    background: #F3F4F6;
    transform: translateX(4px);
}

.info-icon {
    width: 48px;
    height: 48px;
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 1.25rem;
}

.info-icon.bg-primary {
    background: linear-gradient(135deg, #2563EB, #1D4ED8);
}

.info-icon.bg-success {
    background: linear-gradient(135deg, #10B981, #059669);
}

.info-icon.bg-info {
    background: linear-gradient(135deg, #0891B2, #0E7490);
}

.info-icon.bg-warning {
    background: linear-gradient(135deg, #F59E0B, #D97706);
}

.info-content small {
    font-size: 0.75rem;
    display: block;
    margin-bottom: 0.25rem;
}

.info-content strong {
    font-size: 0.95rem;
}

/* Responsive */
@media (max-width: 768px) {
    .profile-overview-card {
        padding: 1.5rem;
    }
    
    .profile-avatar {
        width: 60px;
        height: 60px;
        font-size: 2rem;
    }
    
    .card-header-profile h5 {
        font-size: 1rem;
    }
}
</style>

<script>
// Handle form submission via AJAX for profile page
document.querySelectorAll('.fade-in[data-current-page="profile"] .ajax-form').forEach(form => {
    form.addEventListener('submit', function(e) {
        e.preventDefault();
        
        const submitBtn = this.querySelector('button[type="submit"]');
        const originalText = submitBtn.innerHTML;
        submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Menyimpan...';
        submitBtn.disabled = true;

        const formData = new FormData(this);
        
        axios.post(this.action, formData)
            .then(res => {
                showToast(res.data.message || 'Berhasil disimpan', 'success');
                // Reload profile page to reflect changes
                loadProfile();
            })
            .catch(err => {
                console.error(err);
                if (err.response?.data?.errors) {
                    const errors = Object.values(err.response.data.errors).flat();
                    showToast(errors.join('<br>'), 'error');
                } else {
                    showToast(err.response?.data?.message || 'Gagal menyimpan', 'error');
                }
            })
            .finally(() => {
                submitBtn.innerHTML = originalText;
                submitBtn.disabled = false;
            });
    });
});
</script>
