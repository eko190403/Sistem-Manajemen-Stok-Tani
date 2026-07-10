!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Penerapan Blockchain pada Pengelolaan Stok dan Keuangan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background: #f5f7fa; }
        .fade-in { animation: fadeIn 0.6s ease-out; }
        @keyframes fadeIn { from { opacity: 0; } to { opacity: 1; } }
        .accordion-button:focus { box-shadow: none; }
    </style>
</head>
<body>
<div class="container py-5 fade-in">

    <!-- Header -->
    <div class="text-center mb-5">
        <h1 class="fw-bold text-primary">📊 Sistem Stok & Keuangan Kelompok Tani Mesuji</h1>
        <p class="lead">Penerapan blockchain pada pengelolaan stok dan keuangan menggunakan framework Laravel</p>
        <a href="{{ route('login') }}" class="btn btn-lg btn-success mt-3">🚀 Mulai Sistem / Login</a>
    </div>

    <!-- README / Tentang Sistem -->
    <div class="accordion" id="accordionTentang">

        <!-- Modul Sistem -->
        <div class="accordion-item">
            <h2 class="accordion-header" id="headingModul">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseModul" aria-expanded="false">
                    Modul Sistem
                </button>
            </h2>
            <div id="collapseModul" class="accordion-collapse collapse" aria-labelledby="headingModul" data-bs-parent="#accordionTentang">
                <div class="accordion-body">
                    <ul>
                        <li><strong>Dashboard:</strong> Ringkasan stok, grafik keuangan, status blockchain.</li>
                        <li><strong>Stok:</strong> Tambah, edit, hapus barang, tracking stok masuk/keluar.</li>
                        <li><strong>Keuangan:</strong> Input pemasukan/pengeluaran, export laporan Excel, grafik bulanan.</li>
                        <li><strong>Blockchain:</strong> Validasi transaksi, menandai block valid/rusak.</li>
                        <li><strong>Login / Logout:</strong> Keamanan akses sistem.</li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- Alur Sistem -->
        <div class="accordion-item">
            <h2 class="accordion-header" id="headingAlur">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseAlur" aria-expanded="false">
                    Alur Sistem
                </button>
            </h2>
            <div id="collapseAlur" class="accordion-collapse collapse" aria-labelledby="headingAlur" data-bs-parent="#accordionTentang">
                <div class="accordion-body">
                    <ol>
                        <li>User login → masuk dashboard.</li>
                        <li>Dashboard menampilkan ringkasan stok, grafik keuangan, status blockchain.</li>
                        <li>Stok → tambah/edit/hapus → transaksi otomatis tercatat di blockchain.</li>
                        <li>Keuangan → input pemasukan/pengeluaran → tercatat blockchain.</li>
                        <li>Blockchain → menampilkan semua block, memeriksa validitas hash.</li>
                        <li>Export laporan → pilih periode → unduh Excel.</li>
                    </ol>
                </div>
            </div>
        </div>

        <!-- Teknologi -->
        <div class="accordion-item">
            <h2 class="accordion-header" id="headingTeknologi">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTeknologi" aria-expanded="false">
                    Teknologi Digunakan
                </button>
            </h2>
            <div id="collapseTeknologi" class="accordion-collapse collapse" aria-labelledby="headingTeknologi" data-bs-parent="#accordionTentang">
                <div class="accordion-body">
                    <ul>
                        <li>Laravel 10</li>
                        <li>MySQL</li>
                        <li>Chart.js untuk grafik</li>
                        <li>Maatwebsite Excel untuk export laporan</li>
                        <li>Blockchain sederhana berbasis SHA256</li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- Struktur Folder -->
        <div class="accordion-item">
            <h2 class="accordion-header" id="headingStruktur">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseStruktur" aria-expanded="false">
                    Struktur Folder
                </button>
            </h2>
            <div id="collapseStruktur" class="accordion-collapse collapse" aria-labelledby="headingStruktur" data-bs-parent="#accordionTentang">
                <div class="accordion-body">
                    <ul>
                        <li>app/Http/Controllers/ → Controller utama</li>
                        <li>app/Exports/ → KeuanganExport</li>
                        <li>resources/views/ → Blade templates</li>
                        <li>routes/web.php → Routing sistem</li>
                    </ul>
                </div>
            </div>
        </div>

    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
