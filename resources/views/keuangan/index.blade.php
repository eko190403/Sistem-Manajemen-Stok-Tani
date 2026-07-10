<div class="container-fluid mt-2 mt-md-4">
    <h3 class="mb-3 fs-5 fs-md-4">💰 Daftar Keuangan</h3>
    
    <!-- Desktop Table View -->
    <div class="table-responsive shadow-sm rounded d-none d-md-block">
        <table class="table table-bordered table-hover align-middle mb-0">
            <thead class="table-light">
                <tr>
                    <th class="fs-7 fs-md-normal">Kategori</th>
                    <th class="fs-7 fs-md-normal">Nama Barang</th>
                    <th class="fs-7 fs-md-normal">Jumlah Barang</th>
                    <th class="fs-7 fs-md-normal">Potongan (%)</th>
                    <th class="fs-7 fs-md-normal">Harga / Kg</th>
                    <th class="fs-7 fs-md-normal">Jumlah Bersih (kg)</th>
                    <th class="fs-7 fs-md-normal">Pemasukan</th>
                    <th class="fs-7 fs-md-normal">Pengeluaran</th>
                    <th class="fs-7 fs-md-normal">Keterangan</th>
                    <th class="fs-7 fs-md-normal">Aksi</th>
                </tr>
            </thead>
            <tbody id="keuanganTableBody"></tbody>
            <tfoot class="table-light fw-bold">
                <tr>
                    <th colspan="2">Total Keseluruhan</th>
                    <th id="totalUang">Rp 0</th>
                    <th id="totalPemasukan">Rp 0</th>
                    <th id="totalPengeluaran">Rp 0</th>
                </tr>
                <tr>
                    <th colspan="4" class="text-end">Saldo</th>
                    <th id="saldo" colspan="2">Rp 0</th>
                </tr>
            </tfoot>
        </table>
    </div>

    <!-- Mobile Card View -->
    <div class="d-md-none" id="keuanganCardView"></div>

    <!-- Filter Section Dihapus -->
    <!-- Filter Tahun Sederhana -->
    <div class="mb-3">
        <div class="row g-2 align-items-center">
            <div class="col-auto">
                <select id="yearSelect" class="form-select">
                    @for($y = date('Y')-5; $y <= date('Y'); $y++)
                        <option value="{{ $y }}" {{ $y == date('Y') ? 'selected' : '' }}>{{ $y }}</option>
                    @endfor
                </select>
            </div>
            <div class="col-auto">
                <button type="button" id="btnFilterTahun" class="btn btn-success">Filter</button>
            </div>
        </div>
    </div>

<style>
    .fs-7 {
        font-size: 0.85rem !important;
    }

    @media (max-width: 768px) {
        .container-fluid {
            padding: 0.5rem !important;
        }

        h3 {
            font-size: 1rem !important;
        }

        .keuangan-card {
            margin-bottom: 0.75rem;
            border-radius: 8px;
            overflow: hidden;
        }

        .card-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 0.75rem;
            font-weight: 600;
            font-size: 0.9rem;
        }

        .card-body {
            padding: 0.75rem;
        }

        .info-row {
            display: flex;
            justify-content: space-between;
            padding: 0.5rem 0;
            border-bottom: 1px solid #e9ecef;
            font-size: 0.85rem;
        }

        .info-row:last-child {
            border-bottom: none;
        }

        .info-label {
            color: #6c757d;
            font-weight: 500;
        }

        .info-value {
            font-weight: 600;
            color: #333;
        }

        .summary-card {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 1rem;
            border-radius: 8px;
            margin-top: 1rem;
            text-align: center;
        }

        .summary-item {
            padding: 0.75rem 0;
            border-bottom: 1px solid rgba(255,255,255,0.2);
            font-size: 0.9rem;
        }

        .summary-item:last-child {
            border-bottom: none;
        }

        .summary-label {
            display: block;
            font-size: 0.8rem;
            opacity: 0.9;
            margin-bottom: 0.25rem;
        }

        .summary-value {
            font-size: 1rem;
            font-weight: 700;
        }
    }
</style>

<script>
function formatRupiah(number) {
    return 'Rp ' + Number(number).toLocaleString('id-ID', {
        minimumFractionDigits: 0,
        maximumFractionDigits: 0
    });
}

function loadKeuangan(year = null) {
    let params = {};
    if (year) params.year = year;
    axios.get("{{ route('keuangan.data') }}", { params })
    .then(res => {
        let tbody = '';
        res.data.data.forEach(item => {
            tbody += `
                <tr>
                    <td>${item.kategori ?? ''}</td>
                    <td>${item.nama_barang ?? ''}</td>
                    <td>${item.jumlah_asli ?? '-'}</td>
                    <td>${item.potongan_persen ?? '-'}</td>
                    <td>${formatRupiah(item.harga ?? 0)}</td>
                    <td>${item.jumlah_bersih ?? '-'}</td>
                    <td>${item.jenis === 'pemasukan' ? formatRupiah(item.total_uang) : '-'}</td>
                    <td>${item.jenis === 'pengeluaran' ? formatRupiah(item.total_uang) : '-'}</td>
                    <td>${item.keterangan ?? ''}</td>
                    <td>
                        <a href="/keuangan/${item.id}/struk" target="_blank" class="btn btn-sm btn-outline-info" title="Cetak Struk">
                            <i class="bi bi-printer"></i>
                        </a>
                    </td>
                </tr>
            `;
        });
        document.getElementById('keuanganTableBody').innerHTML = tbody;
        document.getElementById('totalPemasukan').innerText = formatRupiah(res.data.totalPemasukan);
        document.getElementById('totalPengeluaran').innerText = formatRupiah(res.data.totalPengeluaran);
        document.getElementById('saldo').innerText = formatRupiah(res.data.saldo);
    })
    .catch(err => console.error(err));
}

// Load data saat halaman tampil
document.addEventListener('DOMContentLoaded', function() {
    loadKeuangan();
});
</script>
