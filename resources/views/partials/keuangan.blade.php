
<style>
/* CARD UTAMA */
.glass-card {
    background: var(--bg-card);
    border-radius: 16px;
    border: 1px solid #f1f5f9;
    box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.03), 0 2px 4px -1px rgba(0, 0, 0, 0.02);
}

/* Tombol Download - BIRU */
.btn-download {
    background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%) !important;
    color: white !important;
    box-shadow: 0 4px 6px -1px rgba(59, 130, 246, 0.2);
    border: none;
    padding: 0.65rem 1.25rem;
    font-size: 0.9rem;
    font-weight: 600;
    border-radius: 10px;
    transition: all 0.3s ease;
}
.btn-download:hover {
    transform: translateY(-2px);
    box-shadow: 0 10px 15px -3px rgba(59, 130, 246, 0.3);
    color: white !important;
}

/* Tombol Filter - HIJAU */
.btn-filter {
    background: linear-gradient(135deg, #10b981 0%, #059669 100%) !important;
    color: white !important;
    border: none;
    border-radius: 10px;
    font-weight: 600;
    padding: 0.65rem 1.25rem;
    transition: all 0.3s ease;
}
.btn-filter:hover {
    transform: translateY(-2px);
    box-shadow: 0 10px 15px -3px rgba(16, 185, 129, 0.3);
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
</style>

<div class="glass-card p-3 p-md-4 fade-in" data-current-page="keuangan">

    <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-4 gap-3">
        <div>
            <h4 class="mb-1 fw-bold" style="color: #0f172a; text-transform: uppercase; font-size: 1.3rem; letter-spacing: 0.5px;">
                <i class="bi bi-wallet2 text-primary me-2"></i> Riwayat Keuangan
            </h4>
            <p class="text-muted mb-0 small">Daftar transaksi pemasukan dan pengeluaran</p>
        </div>

        <div class="m-0">
            <button type="button" class="btn btn-download" data-bs-toggle="modal" data-bs-target="#modalExport">
                <i class="bi bi-download me-1"></i> Laporan
            </button>
        </div>
    </div>
    
    @include('partials.export_modal', ['exportRoute' => route('keuangan.export')])

        <!-- Filter Modern -->
        <div class="mb-3">
            @php
                $selectedFilter = request('filter', 'all');
                $selectedYear = request('year', date('Y'));
                $selectedMonth = request('month', date('n'));
                $selectedDate = request('tanggal', date('Y-m-d'));
            @endphp
            <div class="row g-2 align-items-center">
                <div class="col-auto">
                    <select id="filterType" class="form-select" onchange="toggleFilterInputs()">
                        <option value="all" {{ $selectedFilter == 'all' ? 'selected' : '' }}>Semua Waktu</option>
                        <option value="tahun" {{ $selectedFilter == 'tahun' ? 'selected' : '' }}>Tahunan</option>
                        <option value="bulan" {{ $selectedFilter == 'bulan' ? 'selected' : '' }}>Bulanan</option>
                        <option value="tanggal" {{ $selectedFilter == 'tanggal' ? 'selected' : '' }}>Harian</option>
                    </select>
                </div>
                
                <!-- Input Tahun -->
                <div class="col-auto filter-input" id="inputYear" style="display: {{ in_array($selectedFilter, ['tahun', 'bulan']) ? 'block' : 'none' }}">
                    <select id="yearSelect" class="form-select">
                        @for($y = date('Y')-5; $y <= date('Y'); $y++)
                            <option value="{{ $y }}" {{ $y == $selectedYear ? 'selected' : '' }}>{{ $y }}</option>
                        @endfor
                    </select>
                </div>

                <!-- Input Bulan -->
                <div class="col-auto filter-input" id="inputMonth" style="display: {{ $selectedFilter == 'bulan' ? 'block' : 'none' }}">
                    <select id="monthSelect" class="form-select">
                        @foreach(['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'] as $i => $m)
                            <option value="{{ $i+1 }}" {{ ($i+1) == $selectedMonth ? 'selected' : '' }}>{{ $m }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Input Tanggal -->
                <div class="col-auto filter-input" id="inputDate" style="display: {{ $selectedFilter == 'tanggal' ? 'block' : 'none' }}">
                    <input type="date" id="dateSelect" class="form-control" value="{{ $selectedDate }}">
                </div>

                <div class="col-auto">
                    <button type="button" id="btnFilterKeuangan" class="btn btn-filter" onclick="filterKeuanganTable()">
                        <i class="bi bi-funnel me-1"></i> Terapkan Filter
                    </button>
                </div>
            </div>
        </div>

        <script>
            function toggleFilterInputs() {
                const type = document.getElementById('filterType').value;
                document.getElementById('inputYear').style.display = (type === 'tahun' || type === 'bulan') ? 'block' : 'none';
                document.getElementById('inputMonth').style.display = (type === 'bulan') ? 'block' : 'none';
                document.getElementById('inputDate').style.display = (type === 'tanggal') ? 'block' : 'none';
            }
        </script>

        <div class="table-responsive bg-white rounded shadow-sm" style="border: 1px solid #f1f5f9;">
            <table class="table table-modern table-hover align-middle mb-0 border-0 table-keuangan">
                <thead style="background-color: #f8fafc;">
                    <tr>
                        <th class="text-nowrap">Kategori</th>
                        <th class="text-nowrap">Nama Barang</th>
                        <th class="text-nowrap text-center">Jumlah Barang</th>
                        <th class="text-nowrap text-center">Potongan (%)</th>
                        <th class="text-nowrap text-end">Harga / Kg</th>
                        <th class="text-nowrap text-center">Jumlah Bersih (kg)</th>
                        <th class="text-nowrap text-end">Pemasukan</th>
                        <th class="text-nowrap text-end">Pengeluaran</th>
                        <th class="text-nowrap">Keterangan</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($keuangans as $k)
                        @if(str_contains($k->keterangan ?? '', 'Stok dihapus') && $k->kategori !== 'saldo')
                            @continue
                        @endif
                        @if($k->kategori === 'saldo' || $k->jenis === 'modal' || $k->kategori === 'modal')
                        <tr class="table-info fw-bold">
                            <td><span class="badge bg-info">Modal/Saldo</span></td>
                            <td>Saldo Awal/Modal</td>
                            <td class="text-center">-</td>
                            <td class="text-center">-</td>
                            <td class="text-end">-</td>
                            <td class="text-center">-</td>
                            <td class="text-end text-success">{{ 'Rp ' . number_format($k->total_uang ?? 0, 2, ',', '.') }}</td>
                            <td class="text-end text-danger">Rp 0,00</td>
                            <td>{{ $k->keterangan ?? '-' }}</td>
                        </tr>
                        @else
                        <tr>
                            <td>
                                @if($k->kategori === 'saldo')
                                    <span class="badge bg-info">Saldo</span>
                                @elseif($k->kategori === 'modal' || $k->jenis === 'modal')
                                    <span class="badge bg-primary">Modal</span>
                                @else
                                    <span class="badge bg-success">Stok</span>
                                @endif
                            </td>
                            <td>
                                @if($k->kategori === 'saldo')
                                    Saldo Awal/Modal
                                @elseif($k->kategori === 'modal' || $k->jenis === 'modal')
                                    Modal
                                @elseif(isset($k->stok) && isset($k->stok->nama_barang))
                                    {{ $k->stok->nama_barang }}
                                @else
                                    -
                                @endif
                            </td>
                            <td class="text-center">
                                {{ $k->jenis === 'modal' ? '-' : (number_format($k->jumlah_asli ?? 0, 2, ',', '.') . ' ' . ($k->stok->satuan_asli ?? 'kg')) }}
                            </td>
                            <td class="text-center">
                                {{ $k->jenis === 'modal' ? '-' : number_format($k->potongan_persen ?? 0, 2, ',', '.') }}
                            </td>
                            <td class="text-end">
                                {{ $k->jenis === 'modal' ? '-' : ('Rp ' . number_format($k->harga ?? 0, 2, ',', '.')) }}
                            </td>
                            <td class="text-center">
                                {{ $k->jenis === 'modal' ? '-' : number_format($k->jumlah_bersih ?? 0, 2, ',', '.') }}
                            </td>
                            <td class="text-end text-success">
                                {{ ($k->jenis === 'pemasukan' || $k->jenis === 'modal')
                                    ? 'Rp ' . number_format($k->total_uang ?? 0, 2, ',', '.')
                                    : 'Rp 0,00'
                                }}
                            </td>
                            <td class="text-end text-danger">
                                {{ $k->jenis === 'pengeluaran'
                                    ? 'Rp ' . number_format($k->total_uang ?? 0, 2, ',', '.')
                                    : 'Rp 0,00'
                                }}
                            </td>
                            <td>{{ $k->keterangan ?? '-' }}</td>
                        </tr>
                        @endif
                    @empty
                        <tr>
                            <td colspan="10" class="text-center text-muted">
                                Belum ada transaksi keuangan.
                            </td>
                        </tr>
                    @endforelse
                </tbody>

                <tfoot class="table-light">
                    <tr style="border-top: 2px solid #e2e8f0;">
                        <td colspan="9" class="py-3 pe-4">
                            <div class="d-flex flex-wrap justify-content-end gap-4 align-items-center" style="font-size: 0.95rem;">
                                <div class="text-success fw-bold">
                                    <span class="text-muted fw-normal me-2">Total Pemasukan:</span>
                                    <i class="bi bi-arrow-down-circle me-1"></i>Rp {{ number_format($totalPemasukan ?? 0, 0, ',', '.') }}
                                </div>
                                <div class="text-danger fw-bold">
                                    <span class="text-muted fw-normal me-2">Total Pengeluaran:</span>
                                    <i class="bi bi-arrow-up-circle me-1"></i>Rp {{ number_format($totalPengeluaran ?? 0, 0, ',', '.') }}
                                </div>
                                <div class="text-primary fw-bold ms-md-2" style="font-size: 1.15rem; border-left: 2px solid #cbd5e1; padding-left: 1rem;">
                                    <span class="text-dark fw-bold me-2">Total Saldo:</span>
                                    Rp {{ number_format($saldo ?? 0, 0, ',', '.') }}
                                </div>
                            </div>
                        </td>
                    </tr>
                </tfoot>
            </table>
        </div>

        <div class="mt-4 d-flex justify-content-center">
            {{ $keuangans->links('pagination::bootstrap-5') }}
        </div>

    </div>
</div>
