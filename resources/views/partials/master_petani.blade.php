<div class="fade-in" data-current-page="master_petani">
    <!-- Header -->
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-4 gap-3">
        <div>
            <h4 class="mb-1 fw-bold" style="color: var(--text-main);">
                <i class="bi bi-person-lines-fill text-primary"></i> Master Petani
            </h4>
            <p class="text-muted mb-0 small">Kelola data referensi petani / pemasok</p>
        </div>
        
        @if(auth()->user()->role === 'admin')
        <button onclick="openPetaniModal()" class="btn-stok btn-tambah">
            <i class="bi bi-person-plus-fill"></i> 
            <span>Tambah Petani</span>
        </button>
        @endif
    </div>

    <!-- Tabel Desktop -->
    <div class="table-responsive shadow-sm rounded d-none d-md-block" style="background: white;">
        <table class="table table-modern table-hover align-middle mb-0">
            <thead>
                <tr>
                    <th style="width: 5%;">#</th>
                    <th style="width: 30%;">
                        <i class="bi bi-person text-primary"></i> Nama Petani
                    </th>
                    <th style="width: 25%;">
                        <i class="bi bi-telephone text-primary"></i> No HP
                    </th>
                    <th style="width: 25%;">
                        <i class="bi bi-geo-alt text-primary"></i> Alamat
                    </th>
                    @if(auth()->user()->role === 'admin')
                    <th class="text-center" style="width: 15%;">
                        <i class="bi bi-gear text-primary"></i> Aksi
                    </th>
                    @endif
                </tr>
            </thead>
            <tbody>
                @forelse($petanis as $index => $petani)
                <tr class="hover-row">
                    <td class="fw-medium text-muted">{{ $index + 1 }}</td>
                    <td>
                        <div class="d-flex align-items-center gap-2">
                            <div class="user-avatar-small" style="background: linear-gradient(135deg, #10B981, #059669);">
                                {{ strtoupper(substr($petani->nama_petani, 0, 1)) }}
                            </div>
                            <strong>{{ $petani->nama_petani }}</strong>
                        </div>
                    </td>
                    <td class="text-muted">{{ $petani->no_hp ?: '-' }}</td>
                    <td class="text-muted">{{ $petani->alamat ?: '-' }}</td>
                    @if(auth()->user()->role === 'admin')
                    <td class="text-center">
                        <div class="btn-group" role="group">
                            <button onclick="editPetani({{ $petani->id }}, '{{ addslashes($petani->nama_petani) }}', '{{ addslashes($petani->no_hp) }}', '{{ addslashes($petani->alamat) }}')" 
                                    class="btn btn-sm btn-warning" 
                                    title="Edit">
                                <i class="bi bi-pencil"></i>
                            </button>
                            <form action="{{ route('master.petani.destroy', $petani->id) }}" method="POST" class="ajax-form-master" style="display: inline;" onsubmit="return confirm('Hapus petani {{ addslashes($petani->nama_petani) }}?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger" title="Hapus">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                    @endif
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="text-center py-5">
                        <i class="bi bi-inbox fs-1 d-block mb-2 text-muted opacity-50"></i>
                        <p class="text-muted mb-0">Belum ada data petani.</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    <!-- Mobile Card View -->
    <div class="d-md-none">
        @forelse($petanis as $petani)
        <div class="card mb-3 border-0 shadow-sm hover-card">
            <div class="card-body p-3">
                <div class="d-flex align-items-start gap-3 mb-3">
                    <div class="user-avatar-mobile" style="background: linear-gradient(135deg, #10B981, #059669);">
                        {{ strtoupper(substr($petani->nama_petani, 0, 1)) }}
                    </div>
                    <div class="flex-grow-1">
                        <h6 class="mb-1 fw-bold">{{ $petani->nama_petani }}</h6>
                        <small class="text-muted d-block mb-1"><i class="bi bi-telephone"></i> {{ $petani->no_hp ?: '-' }}</small>
                        <small class="text-muted d-block"><i class="bi bi-geo-alt"></i> {{ $petani->alamat ?: '-' }}</small>
                    </div>
                </div>
                
                @if(auth()->user()->role === 'admin')
                <div class="d-flex align-items-center justify-content-end">
                    <div class="btn-group" role="group">
                        <button onclick="editPetani({{ $petani->id }}, '{{ addslashes($petani->nama_petani) }}', '{{ addslashes($petani->no_hp) }}', '{{ addslashes($petani->alamat) }}')" 
                                class="btn btn-sm btn-warning">
                            <i class="bi bi-pencil"></i>
                        </button>
                        <form action="{{ route('master.petani.destroy', $petani->id) }}" method="POST" class="ajax-form-master" style="display: inline;" onsubmit="return confirm('Hapus petani {{ addslashes($petani->nama_petani) }}?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger">
                                <i class="bi bi-trash"></i>
                            </button>
                        </form>
                    </div>
                </div>
                @endif
            </div>
        </div>
        @empty
        <div class="card border-0 shadow-sm text-center py-5">
            <div class="card-body">
                <i class="bi bi-inbox fs-1 d-block mb-3 text-muted opacity-50"></i>
                <p class="text-muted mb-0">Belum ada data petani.</p>
            </div>
        </div>
        @endforelse
    </div>
</div>

<!-- Modal Tambah/Edit Petani -->
<div class="modal fade" id="petaniModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content border-0 shadow-lg">
            <form id="petaniForm" class="ajax-form-master" method="POST">
                @csrf
                <input type="hidden" name="_method" id="petaniMethod" value="POST">
                <div class="modal-header bg-light border-0">
                    <h5 class="modal-title fw-bold" id="petaniModalTitle">Tambah Petani</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label fw-semibold text-dark">Nama Petani / Pemasok</label>
                        <input type="text" name="nama_petani" id="nama_petani" class="form-control form-control-lg bg-light border-0" required placeholder="Contoh: Pak Budi">
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold text-dark">No HP / WhatsApp (Opsional)</label>
                        <input type="text" name="no_hp" id="no_hp" class="form-control bg-light border-0" placeholder="0812...">
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold text-dark">Alamat (Opsional)</label>
                        <textarea name="alamat" id="alamat" class="form-control bg-light border-0" rows="2"></textarea>
                    </div>
                </div>
                <div class="modal-footer border-0 bg-light">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary shadow-sm px-4">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
/* Button Styles */
.btn-tambah {
    background: #10B981 !important;
    color: white !important;
    box-shadow: 0 2px 4px rgba(16,185,129,.2);
    padding: 0.5rem 1.25rem;
    font-size: 0.875rem;
    font-weight: 500;
    border-radius: 8px;
    border: none;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 0.5rem;
    transition: all 0.2s ease;
    cursor: pointer;
}

.btn-tambah:hover {
    background: #059669 !important;
    transform: translateY(-1px);
    box-shadow: 0 4px 8px rgba(16,185,129,.3);
}

.hover-row {
    transition: all 0.2s ease;
}

.hover-row:hover {
    background-color: #F9FAFB !important;
    transform: scale(1.005);
}

.hover-card {
    transition: all 0.2s ease;
}

.hover-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(0,0,0,0.1) !important;
}

.form-control:focus {
    background-color: #ffffff !important;
    border: 1px solid #3b82f6 !important;
    box-shadow: 0 0 0 4px rgba(59, 130, 246, 0.1) !important;
}

.user-avatar-small {
    width: 35px;
    height: 35px;
    border-radius: 50%;
    color: white;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: 600;
    font-size: 0.9rem;
}

.user-avatar-mobile {
    width: 45px;
    height: 45px;
    border-radius: 50%;
    color: white;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: 600;
    font-size: 1.1rem;
    flex-shrink: 0;
}
</style>

<script>
    const modalObjPetani = new bootstrap.Modal(document.getElementById('petaniModal'));

    function openPetaniModal() {
        document.getElementById('petaniModalTitle').innerText = 'Tambah Petani';
        document.getElementById('petaniMethod').value = 'POST';
        document.getElementById('petaniForm').action = "{{ route('master.petani.store') }}";
        document.getElementById('petaniForm').reset();
        modalObjPetani.show();
    }

    function editPetani(id, nama, no_hp, alamat) {
        document.getElementById('petaniModalTitle').innerText = 'Edit Petani';
        document.getElementById('petaniMethod').value = 'PUT';
        document.getElementById('petaniForm').action = `/dashboard/master-petani/${id}`;
        
        document.getElementById('nama_petani').value = nama;
        document.getElementById('no_hp').value = no_hp !== 'null' ? no_hp : '';
        document.getElementById('alamat').value = alamat !== 'null' ? alamat : '';
        
        modalObjPetani.show();
    }

    // Handle form submission via AJAX for master data
    document.querySelectorAll('.fade-in[data-current-page="master_petani"] .ajax-form-master').forEach(form => {
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            
            const submitBtn = this.querySelector('button[type="submit"]');
            const originalText = submitBtn ? submitBtn.innerHTML : '';
            if(submitBtn) {
                submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>...';
                submitBtn.disabled = true;
            }

            const formData = new FormData(this);
            
            axios.post(this.action, formData)
                .then(res => {
                    if (this.id === 'petaniForm') {
                        modalObjPetani.hide();
                        setTimeout(() => {
                            // clean up any leftover backdrop just in case
                            document.querySelectorAll('.modal-backdrop').forEach(el => el.remove());
                            document.body.classList.remove('modal-open');
                            document.body.style.overflow = '';
                            document.body.style.paddingRight = '';

                            Swal.fire({
                                icon: 'success',
                                title: 'Berhasil!',
                                text: res.data.message || 'Berhasil disimpan',
                                showConfirmButton: false,
                                timer: 1500
                            }).then(() => {
                                loadPage('master_petani');
                            });
                        }, 300);
                    } else {
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil!',
                            text: res.data.message || 'Berhasil dihapus',
                            showConfirmButton: false,
                            timer: 1500
                        }).then(() => {
                            loadPage('master_petani');
                        });
                    }
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
                    if(submitBtn) {
                        submitBtn.innerHTML = originalText;
                        submitBtn.disabled = false;
                    }
                });
        });
    });
</script>
