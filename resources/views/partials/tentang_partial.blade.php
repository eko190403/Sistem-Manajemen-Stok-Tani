<div style="padding: 0;">

    <!-- Header -->
    <div style="text-align: center; margin-bottom: 20px; padding-bottom: 15px; border-bottom: 2px solid rgba(255,255,255,0.2);">
        <h3 style="margin: 0; color: #fff; font-size: 18px; font-weight: 700; margin-bottom: 8px;">📊 Sistem Stok & Keuangan</h3>
        <p style="margin: 0; color: rgba(255,255,255,0.85); font-size: 13px;">Kelompok Tani Mesuji dengan teknologi Blockchain</p>
    </div>

    <!-- Modul Sistem -->
    <div style="margin-bottom: 15px;">
        <h4 style="color: #9bb8ff; font-size: 14px; font-weight: 600; margin: 0 0 8px 0; cursor: pointer;" class="tentang-toggle" onclick="toggleSection(this)">
            ▶ Modul Sistem
        </h4>
        <div class="tentang-content" style="display: none; padding-left: 12px; border-left: 3px solid #4c6ef5;">
            <ul style="margin: 0; padding-left: 20px; color: rgba(255,255,255,0.9); font-size: 12px; line-height: 1.8;">
                <li><strong style="color: #9bb8ff;">Dashboard:</strong> Ringkasan stok, grafik keuangan, status blockchain</li>
                <li><strong style="color: #9bb8ff;">Stok:</strong> Tambah barang baru, tracking masuk/keluar, tidak bisa edit/hapus (immutable blockchain)</li>
                <li><strong style="color: #9bb8ff;">Keuangan:</strong> Input pemasukan/pengeluaran, export Excel, grafik</li>
                <li><strong style="color: #9bb8ff;">Blockchain:</strong> Validasi transaksi, tandai block valid/rusak</li>
                <li><strong style="color: #9bb8ff;">Keamanan:</strong> Login/logout dengan enkripsi password</li>
            </ul>
        </div>
    </div>

    <!-- Alur Sistem -->
    <div style="margin-bottom: 15px;">
        <h4 style="color: #9bb8ff; font-size: 14px; font-weight: 600; margin: 0 0 8px 0; cursor: pointer;" class="tentang-toggle" onclick="toggleSection(this)">
            ▶ Alur Sistem
        </h4>
        <div class="tentang-content" style="display: none; padding-left: 12px; border-left: 3px solid #4c6ef5;">
            <ol style="margin: 0; padding-left: 20px; color: rgba(255,255,255,0.9); font-size: 12px; line-height: 1.8;">
                <li>User login → masuk dashboard</li>
                <li>Dashboard tampilkan ringkasan stok & grafik keuangan</li>
                <li>Stok → tambah barang baru → otomatis tercatat di blockchain (immutable)</li>
                <li>Keuangan → input pemasukan/pengeluaran → tercatat blockchain</li>
                <li>Blockchain → lihat semua block, periksa validitas hash</li>
                <li>Export laporan → pilih periode → unduh Excel</li>
            </ol>
        </div>
    </div>

    <!-- Teknologi -->
    <div style="margin-bottom: 15px;">
        <h4 style="color: #9bb8ff; font-size: 14px; font-weight: 600; margin: 0 0 8px 0; cursor: pointer;" class="tentang-toggle" onclick="toggleSection(this)">
            ▶ Teknologi Digunakan
        </h4>
        <div class="tentang-content" style="display: none; padding-left: 12px; border-left: 3px solid #4c6ef5;">
            <ul style="margin: 0; padding-left: 20px; color: rgba(255,255,255,0.9); font-size: 12px; line-height: 1.8;">
                <li>🔷 <strong>Laravel 10</strong> - Framework backend</li>
                <li>🔷 <strong>MySQL</strong> - Database</li>
                <li>🔷 <strong>Chart.js</strong> - Grafik interaktif</li>
                <li>🔷 <strong>Bootstrap 5</strong> - UI framework</li>
                <li>🔷 <strong>Blockchain SHA256</strong> - Keamanan data</li>
                <li>🔷 <strong>Maatwebsite Excel</strong> - Export laporan</li>
            </ul>
        </div>
    </div>

    <!-- Fitur Unggulan -->
    <div style="margin-bottom: 15px;">
        <h4 style="color: #9bb8ff; font-size: 14px; font-weight: 600; margin: 0 0 8px 0; cursor: pointer;" class="tentang-toggle" onclick="toggleSection(this)">
            ▶ Fitur Unggulan
        </h4>
        <div class="tentang-content" style="display: none; padding-left: 12px; border-left: 3px solid #4c6ef5;">
            <ul style="margin: 0; padding-left: 20px; color: rgba(255,255,255,0.9); font-size: 12px; line-height: 1.8;">
                <li>✨ <strong>Real-time Dashboard</strong> - Data terupdate secara langsung</li>
                <li>✨ <strong>Blockchain Immutable</strong> - Data tidak dapat diubah</li>
                <li>✨ <strong>Laporan Excel</strong> - Export data dalam format profesional</li>
                <li>✨ <strong>Responsif Mobile</strong> - Akses dari HP atau PC</li>
                <li>✨ <strong>Grafik Bulanan</strong> - Analisis keuangan visual</li>
                <li>✨ <strong>Validasi Block</strong> - Deteksi transaksi yang bermasalah</li>
            </ul>
        </div>
    </div>

    <!-- Keamanan -->
    <div style="margin-bottom: 0;">
        <h4 style="color: #9bb8ff; font-size: 14px; font-weight: 600; margin: 0 0 8px 0; cursor: pointer;" class="tentang-toggle" onclick="toggleSection(this)">
            ▶ Keamanan Data
        </h4>
        <div class="tentang-content" style="display: none; padding-left: 12px; border-left: 3px solid #4c6ef5;">
            <ul style="margin: 0; padding-left: 20px; color: rgba(255,255,255,0.9); font-size: 12px; line-height: 1.8;">
                <li>🔒 Password ter-enkripsi dengan BCrypt</li>
                <li>🔒 Setiap transaksi ter-record di blockchain</li>
                <li>🔒 Hash SHA256 untuk validasi block</li>
                <li>🔒 Akses terbatas berdasarkan role user</li>
                <li>🔒 Log audit untuk setiap aktivitas</li>
            </ul>
        </div>
    </div>

</div>

<style>
    .tentang-toggle {
        transition: color 0.3s ease;
        user-select: none;
    }

    .tentang-toggle:hover {
        color: #d9e4ff !important;
    }

    .tentang-toggle.active::before {
        content: '▼ ' !important;
    }

    .tentang-content {
        animation: slideDown 0.3s ease-out;
    }

    @keyframes slideDown {
        from {
            opacity: 0;
            max-height: 0;
        }
        to {
            opacity: 1;
            max-height: 500px;
        }
    }
</style>

<script>
    function toggleSection(element) {
        const content = element.nextElementSibling;
        element.classList.toggle('active');
        
        if (content.style.display === 'none') {
            content.style.display = 'block';
        } else {
            content.style.display = 'none';
        }
    }
</script>
