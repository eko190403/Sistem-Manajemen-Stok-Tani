<style>
/* GREETING HERO BANNER */
.greeting-card {
    background: linear-gradient(135deg, #4f46e5 0%, #3b82f6 100%);
    color: #ffffff;
    padding: 35px 30px;
    border-radius: 16px;
    margin-bottom: 30px;
    border: none;
    box-shadow: 0 10px 25px -5px rgba(59, 130, 246, 0.4);
    position: relative;
    overflow: hidden;
}

.greeting-card::before {
    content: "";
    position: absolute;
    top: -50%;
    right: -10%;
    width: 300px;
    height: 300px;
    background: radial-gradient(circle, rgba(255,255,255,0.15) 0%, rgba(255,255,255,0) 70%);
    border-radius: 50%;
}

.greeting-title {
    font-size: 2rem;
    font-weight: 700;
    color: #ffffff;
    margin-bottom: 6px;
}

.greeting-subtitle {
    color: rgba(255, 255, 255, 0.85);
    font-size: 1rem;
    margin-bottom: 25px;
}

/* QUICK ACTION */
.quick-action-btn {
    background: rgba(255, 255, 255, 0.2);
    border: 1px solid rgba(255, 255, 255, 0.3);
    backdrop-filter: blur(8px);
    -webkit-backdrop-filter: blur(8px);
    color: #ffffff;
    padding: 10px 20px;
    border-radius: 12px;
    text-decoration: none;
    display: inline-block;
    margin-right: 12px;
    margin-top: 5px;
    font-weight: 600;
    font-size: 0.95rem;
    transition: all 0.3s ease;
}

.quick-action-btn:hover {
    background: rgba(255, 255, 255, 0.35);
    color: #ffffff;
    transform: translateY(-2px);
    box-shadow: 0 8px 16px rgba(0,0,0,0.1);
}

/* TITLE */
.dashboard-title {
    font-weight: 700;
    color: var(--text-main);
    font-size: 1.25rem;
    padding: 10px 0 20px 0;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

/* CARD UTAMA */
.glass-card {
    background: var(--bg-card);
    border-radius: 16px;
    border: 1px solid #f1f5f9;
    box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.03), 0 2px 4px -1px rgba(0, 0, 0, 0.02);
    height: 100%;
}

/* STAT CARD */
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
    font-size: 1.75rem;
    font-weight: 700;
    color: #0f172a;
    display: block;
    margin: 8px 0;
}

.stat-desc {
    font-size: 0.85rem;
    color: #64748b;
}

/* TRANSAKSI TERBARU */
.transaction-item {
    padding: 14px 16px;
    border-radius: 12px;
    margin-bottom: 12px;
    transition: all 0.2s ease;
    display: flex;
    justify-content: space-between;
    align-items: center;
    border: 1px solid #f1f5f9;
}

.transaction-item:hover {
    background: var(--bg-main);
    border-color: #e2e8f0;
}

.transaction-desc { color: #0f172a; font-weight: 600; font-size: 0.95rem; }
.transaction-date { color: #64748b; font-size: 0.8rem; margin-top: 2px; }

.transaction-amount { font-weight: 700; font-size: 0.95rem; text-align: right; }
.transaction-in { color: #10b981; }
.transaction-out { color: #ef4444; }

/* BLOCKCHAIN STATUS */
.blockchain-item {
    background: var(--bg-main);
    border-radius: 12px;
    padding: 16px;
    margin-bottom: 12px;
    display: flex;
    align-items: center;
    justify-content: space-between;
}

.blockchain-item.valid { border-left: 4px solid #10b981; }
.blockchain-item.invalid { border-left: 4px solid #ef4444; }
.blockchain-item.total { border-left: 4px solid #3b82f6; }

.blockchain-number {
    font-size: 1.5rem;
    font-weight: 700;
    color: #0f172a;
}

.blockchain-label {
    font-size: 0.85rem;
    color: #64748b;
    font-weight: 500;
}

/* MODERN BADGES */
.badge-soft-success {
    background-color: #dcfce7;
    color: #166534;
    border: 1px solid #bbf7d0;
}
.badge-soft-danger {
    background-color: #fee2e2;
    color: #991b1b;
    border: 1px solid #fecaca;
}

/* TABLE MODERN */
.table-modern th {
    padding: 1rem 0.75rem;
    font-size: 0.85rem;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    color: #64748b;
}
.table-modern td {
    padding: 1rem 0.75rem;
    font-size: 0.95rem;
    vertical-align: middle;
}

/* CHART WRAPPER */
.chart-wrapper {
    position: relative;
    height: 300px; /* Batasi tinggi grafik agar tidak terlalu memakan tempat */
    width: 100%;
}
.chart-wrapper canvas {
    max-width: 100% !important;
}
</style>
<div class="container-fluid mt-2">

    <!-- GREETING + QUICK ACTIONS -->
    <div class="greeting-card fade-in">
        <div class="greeting-title">
            @php
                $jam = date('H');
                if ($jam < 12) $sapaan = 'Selamat Pagi';
                elseif ($jam < 15) $sapaan = 'Selamat Siang';
                elseif ($jam < 18) $sapaan = 'Selamat Sore';
                else $sapaan = 'Selamat Malam';
            @endphp
            {{ $sapaan }}, {{ auth()->user()->name ?? 'Pengguna' }}
        </div>
        <div class="greeting-subtitle">
            {{ now()->translatedFormat('l, j F Y') }} • Sistem Kelompok Tani
        </div>
        
        <div class="quick-actions">
            @if(auth()->check() && auth()->user()->role === 'admin')
                <a href="javascript:loadPage('stok_create')" class="quick-action-btn">
                    <i class="bi bi-plus-circle"></i> Tambah Stok
                </a>
            @endif
            <a href="javascript:loadPage('keuangan')" class="quick-action-btn">
                <i class="bi bi-wallet2"></i> Keuangan
            </a>
            <a href="javascript:loadPage('blockchain')" class="quick-action-btn" data-bs-toggle="tooltip" title="Lihat blockchain">
                <i class="bi bi-shield-lock"></i> Blockchain
            </a>
            <div class="dropdown d-inline-block mt-1">
                <button class="quick-action-btn dropdown-toggle m-0" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="bi bi-download"></i> Export Laporan
                </button>
                <ul class="dropdown-menu shadow-sm border-0" style="border-radius: 12px; overflow: hidden;">
                    <li>
                        <a class="dropdown-item py-2" href="#" data-bs-toggle="modal" data-bs-target="#exportStokModalOverview">
                            <i class="bi bi-box-seam me-2 text-primary"></i> Laporan Stok
                        </a>
                    </li>
                    <li>
                        <a class="dropdown-item py-2" href="#" data-bs-toggle="modal" data-bs-target="#exportKeuanganModalOverview">
                            <i class="bi bi-wallet2 me-2 text-success"></i> Laporan Keuangan
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </div>

    <!-- Modals for Export -->
    @include('partials.export_modal', [
        'modalId' => 'exportStokModalOverview',
        'modalTitle' => 'Export Laporan Stok',
        'exportRoute' => route('laporan.export')
    ])

    @include('partials.export_modal', [
        'modalId' => 'exportKeuanganModalOverview',
        'modalTitle' => 'Export Laporan Keuangan',
        'exportRoute' => route('keuangan.export')
    ])

    <h4 class="dashboard-title fade-in" style="font-size: 1.5rem; margin-bottom: 0;">Ringkasan Dashboard</h4>

    <!-- PRIMARY METRICS (TOTAL KESELURUHAN) -->
    <div class="row g-4 fade-in mb-4">
        <!-- Saldo Uang -->
        <div class="col-md-4">
            <div class="stat-card">
                <div class="d-flex justify-content-between align-items-start mb-2">
                    <h6 class="stat-title">Total Keuangan</h6>
                    <div style="background: #ecfdf5; padding: 10px; border-radius: 12px; color: #10b981;">
                        <i class="bi bi-wallet2 fs-4"></i>
                    </div>
                </div>
                <div class="stat-value text-success">
                    Rp {{ number_format($saldoUang ?? 0, 0, ',', '.') }}
                </div>
                <div class="d-flex gap-3 stat-desc mt-3">
                    <div>
                        <i class="bi bi-arrow-down-circle text-success me-1"></i>
                        Masuk: Rp {{ number_format(floor(($totalPemasukan ?? 0) / 1000), 0, ',', '.') }}k
                    </div>
                    <div>
                        <i class="bi bi-arrow-up-circle text-danger me-1"></i>
                        Keluar: Rp {{ number_format(floor(($totalPengeluaran ?? 0) / 1000), 0, ',', '.') }}k
                    </div>
                </div>
            </div>
        </div>

        <!-- Stok Barang -->
        <div class="col-md-4">
            <div class="stat-card">
                <div class="d-flex justify-content-between align-items-start mb-2">
                    <h6 class="stat-title">Saldo Stok Barang</h6>
                    <div style="background: #eff6ff; padding: 10px; border-radius: 12px; color: #3b82f6;">
                        <i class="bi bi-box-seam fs-4"></i>
                    </div>
                </div>
                <div class="stat-value text-primary">
                    {{ number_format($saldoKg ?? 0, 2, ',', '.') }} <span style="font-size: 1rem; color: #64748b;">kg</span>
                </div>
                <div class="d-flex gap-3 stat-desc mt-3">
                    <div>
                        <i class="bi bi-arrow-down-circle text-success me-1"></i>
                        Masuk: {{ number_format($totalMasukKg ?? 0, 1, ',', '.') }} kg
                    </div>
                    <div>
                        <i class="bi bi-arrow-up-circle text-danger me-1"></i>
                        Keluar: {{ number_format($totalKeluarKg ?? 0, 1, ',', '.') }} kg
                    </div>
                </div>
            </div>
        </div>

        <!-- Blockchain Status -->
        <div class="col-md-4">
            <div class="stat-card">
                <div class="d-flex justify-content-between align-items-start mb-2">
                    <h6 class="stat-title">Status Blockchain</h6>
                    <div style="background: #fdf2f8; padding: 10px; border-radius: 12px; color: #ec4899;">
                        <i class="bi bi-diagram-3 fs-4"></i>
                    </div>
                </div>
                <div class="stat-value" style="color: #ec4899;">
                    {{ $validBlocks ?? 0 }} <span style="font-size: 1rem; color: #64748b;">Valid</span>
                </div>
                <div class="d-flex gap-3 stat-desc mt-3">
                    <div>
                        Total Block: <strong class="text-dark">{{ $blocks->count() ?? 0 }}</strong>
                    </div>
                    @if(isset($chainValid) && !$chainValid)
                    <div class="text-danger fw-bold">
                        <i class="bi bi-exclamation-triangle-fill"></i> Tidak Valid: {{ $invalidBlocks ?? 0 }}
                    </div>
                    @else
                    <div class="text-success fw-bold">
                        <i class="bi bi-shield-check"></i> Aman
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- SECONDARY METRICS (HARI INI & BULAN INI) -->
    <h5 class="dashboard-title fade-in mb-0 mt-2" style="font-size: 1rem; color: #64748b;">Aktivitas & Kinerja</h5>
    <div class="row row-cols-1 row-cols-sm-2 row-cols-md-4 g-3 fade-in mb-4">
        <div class="col">
            <div class="stat-card" style="padding: 16px 20px;">
                <div class="d-flex align-items-center gap-3">
                    <div style="background: #f1f5f9; padding: 12px; border-radius: 10px;">
                        <i class="bi bi-calendar-check fs-4" style="color: #64748b;"></i>
                    </div>
                    <div>
                        <h6 class="stat-title mb-1" style="font-size: 0.75rem;">Transaksi Hari Ini</h6>
                        <div class="stat-value" style="font-size: 1.3rem; margin: 0;">{{ $transaksiHariIni ?? 0 }}</div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="stat-card" style="padding: 16px 20px;">
                <div class="d-flex align-items-center gap-3">
                    <div style="background: #ecfdf5; padding: 12px; border-radius: 10px;">
                        <i class="bi bi-cash-coin fs-4" style="color: #10b981;"></i>
                    </div>
                    <div>
                        <h6 class="stat-title mb-1" style="font-size: 0.75rem;">Uang Masuk Hari Ini</h6>
                        <div class="stat-value text-success" style="font-size: 1.15rem; margin: 0;">Rp {{ number_format($uangHariIni ?? 0, 0, ',', '.') }}</div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="stat-card" style="padding: 16px 20px;">
                <div class="d-flex align-items-center gap-3">
                    <div style="background: #fff7ed; padding: 12px; border-radius: 10px;">
                        <i class="bi bi-graph-up fs-4" style="color: #f59e0b;"></i>
                    </div>
                    <div>
                        <h6 class="stat-title mb-1" style="font-size: 0.75rem;">Transaksi Bulan Ini</h6>
                        <div class="stat-value text-warning" style="font-size: 1.3rem; margin: 0;">{{ $transaksiBulanIni ?? 0 }}</div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="stat-card" style="padding: 16px 20px;">
                <div class="d-flex align-items-center gap-3">
                    <div style="background: #fdf2f8; padding: 12px; border-radius: 10px;">
                        <i class="bi bi-people-fill fs-4" style="color: #ec4899;"></i>
                    </div>
                    <div>
                        <h6 class="stat-title mb-1" style="font-size: 0.75rem;">Total Anggota</h6>
                        <div class="stat-value" style="font-size: 1.3rem; margin: 0; color: #ec4899;">{{ $totalAnggota ?? 0 }}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- GRAFIK KEUANGAN & STOK -->
    <div class="row g-4 mb-4 fade-in">
        <!-- GRAFIK KEUANGAN (Kiri) -->
        <div class="col-lg-8">
            <div class="glass-card p-4 h-100">
                <h5 class="fw-semibold mb-3" style="color: var(--text-main); font-size: 1.1rem;">Grafik Keuangan Bulanan</h5>
                <div class="chart-wrapper">
                    <canvas id="grafikKeuangan"></canvas>
                </div>
            </div>
        </div>

        <!-- GRAFIK STOK DOUGHNUT (Kanan) -->
        <div class="col-lg-4">
            <div class="glass-card p-4 h-100">
                <h5 class="fw-semibold mb-3" style="color: var(--text-main); font-size: 1.1rem;">Komposisi Stok Barang</h5>
                <div class="chart-wrapper d-flex justify-content-center align-items-center">
                    @if(isset($stokPerBarang) && count($stokPerBarang) > 0)
                        <canvas id="grafikStokDoughnut"></canvas>
                    @else
                        <div class="text-muted text-center w-100">
                            <i class="bi bi-pie-chart text-secondary mb-2 opacity-50" style="font-size: 3rem;"></i><br>
                            <small>Belum ada stok tersimpan</small>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>




    <!-- REKAP PEMASOK -->
    <div class="glass-card p-0 mb-4 fade-in overflow-hidden">
        <div class="p-4 border-bottom" style="border-color: #f1f5f9;">
            <h5 class="fw-bold mb-0" style="color: #0f172a; font-size: 1.1rem;">Rekap Stok per Pemasok</h5>
        </div>
        <div class="table-responsive">
            <table class="table table-modern table-hover align-middle mb-0 border-0">
                <thead style="background-color: #f8fafc;">
                    <tr>
                        <th>No</th>
                        <th>Nama Pemasok</th>
                        <th>Pemasukan (transaksi)</th>
                        <th>Pengeluaran (transaksi)</th>
                        <th>Total Masuk (kg)</th>
                        <th>Total Keluar (kg)</th>
                        <th>Saldo Stok (kg)</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($rekapPemasok as $i => $pemasok)
                        <tr>
                            <td>{{ $i+1 }}</td>
                            <td>{{ $pemasok->nama_pemberi }}</td>
                            <td class="text-center fw-medium">{{ $pemasok->total_transaksi_masuk ?? 0 }}</td>
                            <td class="text-center fw-medium">{{ $pemasok->total_transaksi_keluar ?? 0 }}</td>
                            <td class="text-success fw-semibold"><i class="bi bi-arrow-down-circle me-1"></i>{{ number_format($pemasok->total_masuk ?? 0, 2, ',', '.') }} kg</td>
                            <td class="text-danger fw-semibold"><i class="bi bi-arrow-up-circle me-1"></i>{{ number_format($pemasok->total_keluar ?? 0, 2, ',', '.') }} kg</td>
                            <td class="text-primary fw-bold" style="font-size: 1.05rem;">{{ number_format($pemasok->saldo_stok ?? 0, 2, ',', '.') }} kg</td>
                        </tr>
                    @empty
                        <tr><td colspan="7" class="text-center text-muted py-4">Belum ada data pemasok</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="row g-4 fade-in">
        <!-- STOK MENIPIS ALERTS (Full Width) -->
        @if(isset($stokMenipis) && $stokMenipis->count() > 0)
        <div class="col-12">
            <div class="alert alert-warning border-warning shadow-sm mb-0 d-flex align-items-center" role="alert" style="border-radius: 12px; border-left: 5px solid #f59e0b;">
                <i class="bi bi-exclamation-triangle-fill fs-4 me-3 text-warning"></i>
                <div>
                    <strong>Peringatan! Stok Menipis (< 10 kg):</strong>
                    <div class="mt-1 d-flex gap-2 flex-wrap">
                        @foreach($stokMenipis as $sm)
                            <span class="badge bg-warning text-dark px-2 py-1" style="font-size: 0.85rem;">
                                {{ $sm->nama_barang }}: {{ number_format($sm->total_kg, 1, ',', '.') }} kg
                            </span>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
        @endif

        <!-- RECENT TRANSACTIONS -->
        <div class="col-md-6 d-flex">
            <div class="glass-card p-4 flex-fill">
                <h5 class="fw-bold mb-4" style="color: #0f172a; font-size: 1.1rem;">Transaksi Terbaru Keuangan</h5>
                <div id="recentTransactions">
                    @if($stoks && $stoks->count() > 0)
                        @forelse($stoks->take(5) as $stok)
                            <div class="transaction-item">
                                <div class="transaction-date">
                                    {{ $stok->created_at->translatedFormat('d M Y H:i') }}
                                </div>
                                <div class="transaction-desc">
                                    {{ $stok->nama_barang }}
                                    <span class="badge badge-soft-{{ $stok->jenis === 'pemasukan' ? 'success' : 'danger' }} ms-2">
                                        {{ $stok->jenis === 'pemasukan' ? 'Masuk' : 'Keluar' }}
                                    </span>
                                </div>
                                <div class="transaction-amount {{ $stok->jenis === 'pemasukan' ? 'transaction-in' : 'transaction-out' }}">
                                    {{ $stok->jenis === 'pemasukan' ? '+' : '-' }}{{ $stok->jumlah }} kg
                                    <div style="font-size: 0.75rem; font-weight: 500; color: #64748b;">@ Rp {{ number_format($stok->harga, 0, ',', '.') }}/kg</div>
                                </div>
                            </div>
                        @empty
                            <div class="no-data">Belum ada data transaksi stok</div>
                        @endforelse
                    @else
                        <div class="no-data">Belum ada data transaksi</div>
                    @endif
                </div>
            </div>
        </div>

        <!-- BLOCKCHAIN STATUS -->
        <div class="col-md-6 d-flex">
            <div class="glass-card p-4 flex-fill d-flex flex-column">
                <h5 class="fw-bold mb-4" style="color: #0f172a; font-size: 1.1rem;">Status Blockchain</h5>
                
                <div class="blockchain-status flex-grow-1">
                    <div class="blockchain-item valid">
                        <div class="blockchain-number">{{ $validBlocks ?? 0 }}</div>
                        <div class="blockchain-label"><i class="bi bi-check-circle-fill text-success me-1"></i> Block Valid</div>
                    </div>
                    <div class="blockchain-item invalid">
                        <div class="blockchain-number">{{ $invalidBlocks ?? 0 }}</div>
                        <div class="blockchain-label"><i class="bi bi-exclamation-triangle-fill text-warning me-1"></i> Block Invalid</div>
                    </div>
                    <div class="blockchain-item">
                        <div class="blockchain-number">{{ $blocks->count() ?? 0 }}</div>
                        <div class="blockchain-label"><i class="bi bi-diagram-3-fill text-primary me-1"></i> Total Block</div>
                    </div>
                </div>

                <div style="margin-top: 15px; padding: 12px; background: var(--bg-main); border-radius: 8px; border: 1px solid var(--border-color);">
                    @if(isset($chainValid) && $chainValid)
                        <div style="color: #10B981; font-weight: 500; font-size: 13px;">
                            <i class="bi bi-shield-check me-1"></i> Chain valid - Sistem aman
                        </div>
                    @elseif(isset($chainValid) && !$chainValid)
                        <div style="color: #EF4444; font-weight: 500; font-size: 13px;">
                            <i class="bi bi-shield-exclamation me-1"></i> Chain rusak - Ada {{ $invalidBlocks ?? 0 }} block yang tidak valid
                        </div>
                    @else
                        <div style="color: #6B7280; font-weight: 500; font-size: 13px;">
                            <i class="bi bi-info-circle me-1"></i> Belum ada data block
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

</div>

{{-- Chart.js Script --}}
<script>
(function() {
    // ============ GRAFIK KEUANGAN ============
    const ctxKeuangan = document.getElementById('grafikKeuangan');
    if (ctxKeuangan) {
        // Hapus instance lama jika ada (mencegah error saat pindah halaman / reload AJAX)
        let chartKeuanganLama = Chart.getChart("grafikKeuangan");
        if (chartKeuanganLama) {
            chartKeuanganLama.destroy();
        }

        fetch("{{ route('keuangan.grafik') }}")
            .then(res => res.json())
            .then(data => {
                const formattedLabels = data.labels.map(l => {
                    const [y, m] = l.split('-');
                    const bulan = new Date(y, m-1).toLocaleString('id-ID', { month: 'short', year: 'numeric' });
                    return bulan;
                });

                new Chart(ctxKeuangan, {
                    type: 'line',
                    data: {
                        labels: formattedLabels,
                        datasets: [
                            {
                                label: 'Pemasukan',
                                data: data.pemasukan || [],
                                borderColor: '#10B981',
                                backgroundColor: 'rgba(16, 185, 129, .1)',
                                tension: 0.4,
                                fill: true,
                                pointRadius: 5,
                                pointBackgroundColor: '#10B981',
                                pointBorderColor: '#fff',
                                pointBorderWidth: 2
                            },
                            {
                                label: 'Pengeluaran',
                                data: data.pengeluaran || [],
                                borderColor: '#EF4444',
                                backgroundColor: 'rgba(239, 68, 68, .1)',
                                tension: 0.4,
                                fill: true,
                                pointRadius: 5,
                                pointBackgroundColor: '#EF4444',
                                pointBorderColor: '#fff',
                                pointBorderWidth: 2
                            }
                        ]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: { position: 'bottom', labels: { usePointStyle: true, padding: 15 } },
                            tooltip: { 
                                mode: 'index', 
                                intersect: false,
                                callbacks: {
                                    label: function(context) {
                                        return context.dataset.label + ': Rp ' + context.parsed.y.toLocaleString('id-ID');
                                    }
                                }
                            }
                        },
                        scales: {
                            y: { 
                                beginAtZero: true, 
                                ticks: { 
                                    callback: v => 'Rp ' + (v/1000000).toFixed(0) + 'M'
                                }
                            }
                        }
                    }
                });
            })
            .catch(err => console.error('Error loading keuangan grafik:', err));
    }

    // Tooltip Bootstrap
    const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
    });

    // ============ GRAFIK STOK (DOUGHNUT) ============
    const ctxStok = document.getElementById('grafikStokDoughnut');
    if (ctxStok) {
        // Hapus instance lama jika ada
        let chartStokLama = Chart.getChart("grafikStokDoughnut");
        if (chartStokLama) {
            chartStokLama.destroy();
        }

        const labelsStok = [
            @if(isset($stokPerBarang))
                @foreach($stokPerBarang as $sb)
                    "{{ $sb->nama_barang }}",
                @endforeach
            @endif
        ];
        const dataStok = [
            @if(isset($stokPerBarang))
                @foreach($stokPerBarang as $sb)
                    {{ $sb->total_kg }},
                @endforeach
            @endif
        ];

        new Chart(ctxStok, {
            type: 'doughnut',
            data: {
                labels: labelsStok,
                datasets: [{
                    data: dataStok,
                    backgroundColor: [
                        '#3b82f6', '#10b981', '#f59e0b', '#ec4899', '#8b5cf6'
                    ],
                    borderWidth: 0,
                    hoverOffset: 4
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                cutout: '70%',
                plugins: {
                    legend: {
                        position: 'right',
                        labels: { 
                            usePointStyle: true, 
                            padding: 15, 
                            font: { size: 10 },
                            boxWidth: 8
                        }
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                return ' ' + context.label + ': ' + context.parsed.toLocaleString('id-ID') + ' kg';
                            }
                        }
                    }
                }
            }
        });
    }
})();
</script>

</div>
