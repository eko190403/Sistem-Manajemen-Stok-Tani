<div class="fade-in" data-current-page="master_barang">
    <!-- Header -->
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-4 gap-3">
        <div>
            <h4 class="mb-1 fw-bold" style="color: var(--text-main);">
                <i class="bi bi-box text-primary"></i> Master Barang
            </h4>
            <p class="text-muted mb-0 small">Kelola data referensi barang</p>
        </div>
        
        @if(auth()->user()->role === 'admin')
        <button onclick="openBarangModal()" class="btn-stok btn-tambah">
            <i class="bi bi-plus-circle"></i> 
            <span>Tambah Barang</span>
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
                        <i class="bi bi-box-seam text-primary"></i> Nama Barang
                    </th>
                    <th style="width: 35%;">
                        <i class="bi bi-card-text text-primary"></i> Deskripsi
                    </th>
                    <th class="text-center" style="width: 15%;">
                        <i class="bi bi-tag text-primary"></i> Harga Ref
                    </th>
                    @if(auth()->user()->role === 'admin')
                    <th class="text-center" style="width: 15%;">
                        <i class="bi bi-gear text-primary"></i> Aksi
                    </th>
                    @endif
                </tr>
            </thead>
            <tbody>
                @forelse($barangs as $index => $barang)
                <tr class="hover-row">
                    <td class="fw-medium text-muted">{{ $index + 1 }}</td>
                    <td>
                        <strong>{{ $barang->nama_barang }}</strong>
                    </td>
                    <td class="text-muted">{{ $barang->deskripsi ?: '-' }}</td>
                    <td class="text-center">
                        @if($barang->harga_referensi)
                            Rp {{ number_format($barang->harga_referensi, 0, ',', '.') }}
                        @else
                            -
                        @endif
                    </td>
                    @if(auth()->user()->role === 'admin')
                    <td class="text-center">
                        <div class="btn-group" role="group">
                            <button onclick="editBarang({{ $barang->id }}, '{{ addslashes($barang->nama_barang) }}', '{{ addslashes($barang->deskripsi) }}', '{{ $barang->harga_referensi }}')" 
                                    class="btn btn-sm btn-warning" 
                                    title="Edit">
                                <i class="bi bi-pencil"></i>
                            </button>
                            <form action="{{ route('master.barang.destroy', $barang->id) }}" method="POST" class="ajax-form-master" style="display: inline;" onsubmit="return confirm('Hapus barang {{ addslashes($barang->nama_barang) }}?');">
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
                        <p class="text-muted mb-0">Belum ada data barang.</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    <!-- Mobile Card View -->
    <div class="d-md-none">
        @forelse($barangs as $barang)
        <div class="card mb-3 border-0 shadow-sm hover-card">
            <div class="card-body p-3">
                <div class="d-flex align-items-start gap-3 mb-3">
                    <div class="flex-grow-1">
                        <h6 class="mb-1 fw-bold">{{ $barang->nama_barang }}</h6>
                        <small class="text-muted d-block mb-1">{{ $barang->deskripsi ?: '-' }}</small>
                        <small class="text-primary fw-bold">Rp {{ number_format($barang->harga_referensi ?? 0, 0, ',', '.') }}</small>
                    </div>
                </div>
                
                @if(auth()->user()->role === 'admin')
                <div class="d-flex align-items-center justify-content-end">
                    <div class="btn-group" role="group">
                        <button onclick="editBarang({{ $barang->id }}, '{{ addslashes($barang->nama_barang) }}', '{{ addslashes($barang->deskripsi) }}', '{{ $barang->harga_referensi }}')" 
                                class="btn btn-sm btn-warning">
                            <i class="bi bi-pencil"></i>
                        </button>
                        <form action="{{ route('master.barang.destroy', $barang->id) }}" method="POST" class="ajax-form-master" style="display: inline;" onsubmit="return confirm('Hapus barang {{ addslashes($barang->nama_barang) }}?');">
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
                <p class="text-muted mb-0">Belum ada data barang.</p>
            </div>
        </div>
        @endforelse
    </div>
</div>

<!-- Modal Tambah/Edit Barang -->
<div class="modal fade" id="barangModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content border-0 shadow-lg">
            <form id="barangForm" class="ajax-form-master" method="POST">
                @csrf
                <input type="hidden" name="_method" id="barangMethod" value="POST">
                <div class="modal-header bg-light border-0">
                    <h5 class="modal-title fw-bold" id="barangModalTitle">Tambah Barang</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label fw-semibold text-dark">Nama Barang</label>
                        <input type="text" name="nama_barang" id="nama_barang" class="form-control form-control-lg bg-light border-0" required placeholder="Contoh: Singkong">
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold text-dark">Deskripsi (Opsional)</label>
                        <textarea name="deskripsi" id="deskripsi" class="form-control bg-light border-0" rows="2"></textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold text-dark">Harga Referensi (Opsional)</label>
                        <input type="number" name="harga_referensi" id="harga_referensi" class="form-control bg-light border-0" placeholder="0">
                    </div>
                </div>
                <div class="modal-footer border-0 bg-light">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary shadow-sm px-4" id="barangSubmitBtn">Simpan</button>
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
</style>

<script>
    const modalObjBarang = new bootstrap.Modal(document.getElementById('barangModal'));

    function openBarangModal() {
        document.getElementById('barangModalTitle').innerText = 'Tambah Barang';
        document.getElementById('barangMethod').value = 'POST';
        document.getElementById('barangForm').action = "{{ route('master.barang.store') }}";
        document.getElementById('barangForm').reset();
        modalObjBarang.show();
    }

    function editBarang(id, nama, deskripsi, harga) {
        document.getElementById('barangModalTitle').innerText = 'Edit Barang';
        document.getElementById('barangMethod').value = 'PUT';
        document.getElementById('barangForm').action = `/dashboard/master-barang/${id}`;
        
        document.getElementById('nama_barang').value = nama;
        document.getElementById('deskripsi').value = deskripsi !== 'null' ? deskripsi : '';
        document.getElementById('harga_referensi').value = harga !== 'null' ? harga : '';
        
        modalObjBarang.show();
    }

    // Handle form submission via AJAX for master data
    document.querySelectorAll('.fade-in[data-current-page="master_barang"] .ajax-form-master').forEach(form => {
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
                    if (this.id === 'barangForm') {
                        modalObjBarang.hide();
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
                                loadPage('master_barang');
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
                            loadPage('master_barang');
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
