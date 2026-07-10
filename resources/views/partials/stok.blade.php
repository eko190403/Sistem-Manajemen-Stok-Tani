<!-- NOTIFIKASI GLOBAL -->
<div id="globalAlertContainer"></div>
<style>
/* MODERN ALERTS */
.modern-alert {
    border-radius: 12px;
    font-size: 1rem;
    padding: 14px 18px;
    border: none;
    box-shadow: 0 2px 12px rgba(16,185,129,0.07);
    background: linear-gradient(90deg, #F0FDF4 0%, #DCFCE7 100%);
    color: #166534;
    font-weight: 500;
    transition: all 0.3s;
}
.alert-success.modern-alert {
    background: linear-gradient(90deg, #F0FDF4 0%, #DCFCE7 100%);
    color: #166534;
    border-left: 6px solid #10B981;
}
.alert-danger.modern-alert {
    background: linear-gradient(90deg, #FEF2F2 0%, #FEE2E2 100%);
    color: #991B1B;
    border-left: 6px solid #EF4444;
}
.alert-info.modern-alert {
    background: linear-gradient(90deg, #ECFEFF 0%, #CFFAFE 100%);
    color: #0E7490;
    border-left: 6px solid #06B6D4;
}
.fade-in-top {
    animation: fadeInTop 0.7s cubic-bezier(.39,.575,.565,1.000) both;
}
@keyframes fadeInTop {
    0% { opacity: 0; transform: translateY(-30px); }
    100% { opacity: 1; transform: translateY(0); }
}
</style>

<script>
// NOTIFIKASI AJAX-FRIENDLY
function showGlobalAlert(type, message) {
    const icons = {
        success: 'check-circle-fill',
        error: 'x-circle-fill',
        info: 'info-circle-fill'
    };
    const alertClass = {
        success: 'alert-success',
        error: 'alert-danger',
        info: 'alert-info'
    };
    const html = `
        <div id="globalAlert" class="${alertClass[type]} modern-alert alert shadow-sm d-flex align-items-center gap-2 mb-3 fade-in-top" role="alert">
            <i class="bi bi-${icons[type]} me-2"></i>
            <div>
                ${message}
            </div>
            <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    `;
    const container = document.getElementById('globalAlertContainer');
    if(container) {
        container.innerHTML = html;
        setTimeout(() => {
            const alertEl = document.getElementById('globalAlert');
            if(alertEl) {
                alertEl.style.opacity = 0;
                setTimeout(() => alertEl.remove(), 600);
            }
        }, 4000);
    }
}

// ...existing code...

// ...existing code...
// Contoh penggunaan notifikasi AJAX setelah tambah saldo/stok
// Misal pada event submit form tambah saldo:
//
(function() {
    var formTambahSaldo = document.getElementById('formTambahSaldo');
    if(formTambahSaldo) {
        formTambahSaldo.addEventListener('submit', function(e) {
            e.preventDefault();
            var formData = new FormData(formTambahSaldo);
            axios.post(formTambahSaldo.action, formData)
                .then(function(res) {
                    if(res.data.success) {
                        showToast('Saldo berhasil ditambah!', 'success');
                        
                        // tutup modal
                        var modalEl = document.getElementById('modalTambahSaldo');
                        if (modalEl) {
                            var modal = bootstrap.Modal.getInstance(modalEl);
                            if (modal) {
                                modal.hide();
                                // Bersihkan backdrop manual jika Bootstrap nge-bug
                                const backdrops = document.querySelectorAll('.modal-backdrop');
                                backdrops.forEach(b => b.remove());
                                document.body.classList.remove('modal-open');
                                document.body.style = '';
                            }
                        }
                        
                        // Refresh halaman ke keuangan
                        loadPage('keuangan');
                    } else {
                        showToast(res.data.message || 'Gagal menambah saldo!', 'error');
                    }
                })
                .catch(function(err) {
                    console.error(err);
                    showToast('Terjadi kesalahan server!', 'error');
                });
        });
    }
})();
})();

// Contoh penggunaan notifikasi AJAX langsung dengan axios.post untuk tambah stok
// Misal pada aksi tambah stok:
//
function tambahStok(data) {
    axios.post('/url-tambah-stok', data)
        .then(res => {
            if(res.data.success) {
                showGlobalAlert('success', 'Stok berhasil ditambah!');
                // Refresh tabel stok otomatis tanpa reload halaman
                refreshTabelStok();
            } else {
                showGlobalAlert('error', 'Gagal menambah stok!');
            }
        })
        .catch(() => {
            showGlobalAlert('error', 'Terjadi kesalahan server!');
        });
}

// Fungsi untuk refresh tabel stok otomatis
function refreshTabelStok() {
    // Ganti selector dan URL sesuai kebutuhan
    axios.get('/dashboard/content/stok')
        .then(res => {
            // Asumsikan #main-content adalah container tabel stok
            if(document.getElementById('main-content')) {
                document.getElementById('main-content').innerHTML = res.data;
                if (typeof initAfterLoad === 'function') initAfterLoad();
            }
        });
}

</script>
<!-- Info Saldo dan Stok Sekarang dihapus atas permintaan karena sudah ada di Dashboard -->
<!-- Bootstrap CSS untuk AJAX/standalone -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</div>

<script>
if (typeof gotoPage !== 'function') {
    function gotoPage(page) {
        const container = document.querySelector('[data-current-page]');
        const pageName = container ? container.getAttribute('data-current-page') : 'stok';
        axios.get(`/dashboard/content/${pageName}?page=${page}`)
            .then(res => {
                document.getElementById('main-content').innerHTML = res.data;
                document.getElementById('main-content').scrollIntoView({ behavior: 'smooth', block: 'start' });
                if (typeof initAfterLoad === 'function') initAfterLoad();
            })
            .catch(() => {
                if (typeof showToast === 'function') showToast('Gagal memuat halaman', 'error');
            });
    }
}
</script>
<div class="glass-card p-3 p-md-4 fade-in" data-current-page="stok">

    <!-- HEADER -->
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-4 gap-3">
        <div>
            <h4 class="mb-1 fw-bold" style="color: #0f172a; text-transform: uppercase; font-size: 1.3rem; letter-spacing: 0.5px;">
                <i class="bi bi-box-seam text-primary me-2"></i> Daftar Stok
            </h4>
            <p class="text-muted mb-0 small">Riwayat pemasukan & pengeluaran barang</p>
        </div>

        <!-- Tombol -->
        <div class="d-flex gap-2 flex-wrap">
            @if(auth()->check() && auth()->user()->role === 'admin')
                <button class="btn btn-stok btn-outline-primary shadow-sm fw-semibold" data-bs-toggle="modal" data-bs-target="#modalTambahSaldo" style="border-radius: 10px;">
                    <i class="bi bi-cash-plus"></i> Tambah Saldo
                </button>
                @include('keuangan.saldo_modal')
                
                <button onclick="loadPage('stok_create')" class="btn-stok btn-tambah">
                    <i class="bi bi-plus-circle"></i> 
                    <span class="d-none d-sm-inline">Tambah Stok</span>
                    <span class="d-inline d-sm-none">Tambah</span>
                </button>
            @endif

            <button class="btn-stok btn-download" data-bs-toggle="modal" data-bs-target="#modalExport">
                <i class="bi bi-download"></i> 
                <span class="d-none d-sm-inline">Laporan</span>
                <span class="d-inline d-sm-none">Download</span>
            </button>
        </div>
    </div>
    
    @include('partials.export_modal', ['exportRoute' => route('laporan.export')])


    <!-- Tabel Desktop -->
    <div class="table-responsive bg-white rounded shadow-sm d-none d-md-block" style="border: 1px solid #f1f5f9;">
        <table class="table table-modern table-hover align-middle mb-0 border-0">
            <thead class="table-light text-secondary text-uppercase" style="font-size: 0.85rem; letter-spacing: 0.5px;">
                <tr>
                    <th class="text-nowrap py-3" style="width: 30%;">
                        <i class="bi bi-box text-primary me-1"></i> Nama Barang
                    </th>
                    <th class="text-nowrap py-3" style="width: 25%;">
                        <i class="bi bi-person text-primary me-1"></i> Nama Pemasok
                    </th>
                    <th class="text-nowrap text-center py-3" style="width: 15%;">
                        <i class="bi bi-hash text-primary me-1"></i> Jumlah
                    </th>
                    <th class="text-nowrap text-center py-3" style="width: 15%;">
                        <i class="bi bi-tag text-primary me-1"></i> Jenis
                    </th>
                    <th class="text-nowrap text-end py-3" style="width: 15%;">
                        <i class="bi bi-cash text-primary me-1"></i> Harga
                    </th>
                    <th class="text-nowrap text-center py-3" style="width: 10%;">
                        <i class="bi bi-gear text-primary me-1"></i> Aksi
                    </th>
                </tr>
            </thead>

            <tbody style="font-size: 0.95rem;">
                @forelse($stoks as $stok)
                <tr class="hover-row">
                    <td class="fw-medium text-dark">{{ $stok->nama_barang }}</td>
                    <td class="text-muted">{{ $stok->nama_pemberi }}</td>
                    <td class="text-center fw-semibold text-dark">{{ number_format(abs($stok->jumlah), 2, ',', '.') }} <span class="text-muted fw-normal">Kg</span></td>
                    <td class="text-center">
                        @if($stok->jenis === 'pemasukan')
                            <span class="badge bg-success-subtle text-success border border-success-subtle px-3 py-2 rounded-pill">
                                <i class="bi bi-arrow-down-circle me-1"></i> Pemasukan
                            </span>
                        @else
                            <span class="badge bg-danger-subtle text-danger border border-danger-subtle px-3 py-2 rounded-pill">
                                <i class="bi bi-arrow-up-circle me-1"></i> Pengeluaran
                            </span>
                        @endif
                    </td>
                    <td class="text-end fw-bold text-primary">
                        Rp {{ number_format($stok->harga, 0, ',', '.') }}
                    </td>
                    <td class="text-center">
                        <a href="{{ route('stok.struk', $stok->id) }}" target="_blank" class="btn btn-sm btn-outline-info" title="Cetak Struk">
                            <i class="bi bi-printer"></i>
                        </a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="text-center py-5">
                        <div class="text-muted">
                            <i class="bi bi-inbox fs-1 d-block mb-2 opacity-50"></i>
                            <p class="mb-0">Belum ada data stok.</p>
                            <small>Silakan tambahkan stok baru untuk memulai.</small>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
            <tfoot class="table-light">
                <tr style="border-top: 2px solid #e2e8f0;">
                    <td colspan="6" class="py-3 pe-4">
                        <div class="d-flex flex-wrap justify-content-end gap-4 align-items-center" style="font-size: 0.95rem;">
                            <div class="text-success fw-bold">
                                <span class="text-muted fw-normal me-2">Total Masuk:</span>
                                <i class="bi bi-arrow-down-circle me-1"></i>{{ number_format($totalStokMasuk ?? 0, 2, ',', '.') }} Kg
                            </div>
                            <div class="text-danger fw-bold">
                                <span class="text-muted fw-normal me-2">Total Keluar:</span>
                                <i class="bi bi-arrow-up-circle me-1"></i>{{ number_format($totalStokKeluar ?? 0, 2, ',', '.') }} Kg
                            </div>
                            <div class="text-primary fw-bold ms-md-2" style="font-size: 1.05rem; border-left: 2px solid #cbd5e1; padding-left: 1rem;">
                                <span class="text-dark fw-bold me-2">Saldo Akhir:</span>
                                {{ number_format($stokSekarang ?? 0, 2, ',', '.') }} Kg
                            </div>
                        </div>
                    </td>
                </tr>
            </tfoot>
        </table>
    </div>

    <!-- Tabel Mobile (Card View) -->
    <div class="d-md-none">
        @forelse($stoks as $stok)
        <div class="card mb-3 border-0 shadow-sm hover-card">
            <div class="card-body p-3">
                <!-- Header Card -->
                <div class="d-flex justify-content-between align-items-start mb-3">
                    <div class="flex-grow-1">
                        <h6 class="mb-1 fw-bold text-dark">{{ $stok->nama_barang }}</h6>
                        <div class="small text-muted">Pemasok: {{ $stok->nama_pemberi }}</div>
                        <!-- Rekap Detail Pemasok -->
                        <div class="small mt-2">
                            <div>
                                <i class="bi bi-arrow-down-circle text-success"></i> Total Masuk:
                                @if($stok->nama_pemberi && isset($rekapPemasok[$stok->nama_pemberi]))
                                    <strong class="text-success">{{ number_format($rekapPemasok[$stok->nama_pemberi]['total_masuk'] ?? 0, 2, ',', '.') }} Kg</strong>
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </div>
                            <div>
                                <i class="bi bi-arrow-up-circle text-danger"></i> Total Keluar:
                                @if($stok->nama_pemberi && isset($rekapPemasok[$stok->nama_pemberi]))
                                    <strong class="text-danger">{{ number_format($rekapPemasok[$stok->nama_pemberi]['total_keluar'] ?? 0, 2, ',', '.') }} Kg</strong>
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </div>
                            <div>
                                <i class="bi bi-archive text-primary"></i> Saldo:
                                @if($stok->nama_pemberi && isset($rekapPemasok[$stok->nama_pemberi]))
                                    <strong class="fw-bold {{ ($rekapPemasok[$stok->nama_pemberi]['saldo'] ?? 0) < 0 ? 'text-danger' : 'text-success' }}">
                                        {{ number_format($rekapPemasok[$stok->nama_pemberi]['saldo'] ?? 0, 2, ',', '.') }} Kg
                                    </strong>
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </div>
                        </div>
                        @if($stok->jenis === 'pemasukan')
                            <span class="badge bg-success bg-gradient d-inline-flex align-items-center gap-1 mt-2">
                                <i class="bi bi-arrow-down-circle"></i> Pemasukan
                            </span>
                        @else
                            <span class="badge bg-danger bg-gradient d-inline-flex align-items-center gap-1 mt-2">
                                <i class="bi bi-arrow-up-circle"></i> Pengeluaran
                            </span>
                        @endif
                    </div>
                    <div>
                        <a href="{{ route('stok.struk', $stok->id) }}" target="_blank" class="btn btn-sm btn-outline-info" title="Cetak Struk">
                            <i class="bi bi-printer"></i>
                        </a>
                    </div>
                </div>

                <!-- Info Grid -->
                <div class="row g-3">
                    <div class="col-6">
                        <div class="d-flex align-items-center gap-2">
                            <i class="bi bi-hash text-primary"></i>
                            <div>
                                <small class="text-muted d-block" style="font-size: 0.75rem;">Jumlah</small>
                                <strong class="text-dark">{{ number_format(abs($stok->jumlah), 2, ',', '.') }} Kg</strong>
                            </div>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="d-flex align-items-center gap-2">
                            <i class="bi bi-cash text-primary"></i>
                            <div>
                                <small class="text-muted d-block" style="font-size: 0.75rem;">Harga</small>
                                <strong class="text-primary">Rp {{ number_format($stok->harga, 0, ',', '.') }}</strong>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @empty
        <div class="card border-0 shadow-sm text-center py-5">
            <div class="card-body">
                <i class="bi bi-inbox fs-1 d-block mb-3 text-muted opacity-50"></i>
                <p class="text-muted mb-1">Belum ada data stok.</p>
                <small class="text-muted">Silakan tambahkan stok baru untuk memulai.</small>
            </div>
        </div>
        @endforelse
    </div>

    <!-- Pagination -->
    @if($stoks->hasPages())
    <div class="d-flex justify-content-center mt-4">
        <div class="pagination-wrapper">
            {{ $stoks->links('pagination::bootstrap-5') }}
        </div>
    </div>
    @endif
</div>

<style>
/* STAT CARD (Premium Design) */
.stat-card {
    background: var(--bg-card);
    border-radius: 16px;
    padding: 24px;
    border: 1px solid #f1f5f9;
    box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.03), 0 2px 4px -1px rgba(0, 0, 0, 0.02);
    transition: all 0.3s ease;
    height: 100%;
}

.stat-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 12px 20px -5px rgba(0, 0, 0, 0.08), 0 8px 10px -5px rgba(0, 0, 0, 0.04);
}

.stat-title {
    font-size: 0.85rem;
    font-weight: 600;
    color: #64748b;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.stat-value {
    font-weight: 700;
    display: block;
    margin: 4px 0 0 0;
}

/* Tombol Stok - Base */
.btn-stok {
    padding: 0.65rem 1.25rem;
    font-size: 0.9rem;
    font-weight: 600;
    border-radius: 10px;
    border: none;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 0.5rem;
    transition: all 0.2s ease;
    cursor: pointer;
    white-space: nowrap;
}

/* Tabel Modern */
.table-modern th {
    padding: 1.25rem 1rem;
    font-size: 0.85rem;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    color: #64748b;
    background-color: #f8fafc !important;
    border-bottom: 2px solid #e2e8f0;
}
.table-modern td {
    padding: 1rem;
    font-size: 0.95rem;
    vertical-align: middle;
    border-bottom: 1px solid #f1f5f9;
}

/* Tombol Tambah - HIJAU */
.btn-tambah {
    background: linear-gradient(135deg, #10b981 0%, #059669 100%) !important;
    color: white !important;
    box-shadow: 0 4px 6px -1px rgba(16, 185, 129, 0.2);
}

.btn-tambah:hover {
    transform: translateY(-2px);
    box-shadow: 0 10px 15px -3px rgba(16, 185, 129, 0.3);
    color: white !important;
}

/* Tombol Download - BIRU */
.btn-download {
    background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%) !important;
    color: white !important;
    box-shadow: 0 4px 6px -1px rgba(59, 130, 246, 0.2);
}

.btn-download:hover {
    transform: translateY(-2px);
    box-shadow: 0 10px 15px -3px rgba(59, 130, 246, 0.3);
    color: white !important;
    text-decoration: none;
}

/* Hover effect untuk row tabel */
.hover-row {
    transition: all 0.2s ease;
}

.hover-row:hover {
    background-color: #F9FAFB !important;
    transform: scale(1.01);
    box-shadow: 0 2px 8px rgba(0,0,0,0.05);
}

/* Hover effect untuk card mobile */
.hover-card {
    transition: all 0.2s ease;
}

.hover-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(0,0,0,0.1) !important;
}

/* Styling untuk badge */
.badge.bg-gradient {
    padding: 0.4rem 0.75rem;
    font-weight: 500;
    font-size: 0.75rem;
}

/* Pagination wrapper */
.pagination-wrapper {
    background: white;
    padding: 0.75rem 1rem;
    border-radius: 8px;
    box-shadow: 0 2px 4px rgba(0,0,0,0.05);
}
</style>
