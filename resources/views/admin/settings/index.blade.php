<div class="container-fluid px-4 py-3 fade-in">

<style>
    .settings-header {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border-radius: 16px;
        padding: 30px;
        color: white;
        margin-bottom: 30px;
        box-shadow: 0 8px 25px rgba(102, 126, 234, 0.3);
    }
    
    .settings-card {
        background: white;
        border-radius: 16px;
        padding: 40px;
        box-shadow: 0 5px 20px rgba(0,0,0,0.08);
    }
    
    .settings-section {
        border-bottom: 2px solid #e2e8f0;
        padding-bottom: 30px;
        margin-bottom: 30px;
    }
    
    .settings-section:last-child {
        border-bottom: none;
        margin-bottom: 0;
        padding-bottom: 0;
    }
    
    .settings-section h5 {
        color: #2d3748;
        font-weight: 600;
        margin-bottom: 20px;
    }
</style>

<div class="settings-header">
    <h3><i class="fas fa-cog"></i> Pengaturan Sistem</h3>
    <p class="mb-0">Konfigurasi sistem stok singkong kelompok tani</p>
</div>

@if(isset($tableNotExists) && $tableNotExists)
    <div class="alert alert-warning alert-dismissible fade show">
        <i class="fas fa-exclamation-triangle"></i> 
        <strong>Tabel settings belum ada!</strong><br>
        Jalankan perintah <code>php artisan migrate</code> untuk membuat tabel settings.
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show">
        <i class="fas fa-check-circle"></i> {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

@if(!isset($tableNotExists) || !$tableNotExists)

<div class="settings-card">
    <form action="{{ route('settings.update') }}" method="POST">
        @csrf
        
        <!-- Informasi Aplikasi -->
        <div class="settings-section">
            <h5><i class="fas fa-info-circle text-primary"></i> Informasi Aplikasi</h5>
            
            <div class="mb-4">
                <label class="form-label">Nama Kelompok Tani</label>
                <input type="text" name="app_name" class="form-control" 
                       value="{{ $settings['app_name']->value ?? 'Kelompok Tani Singkong' }}" required>
                <small class="text-muted">Nama kelompok tani yang akan ditampilkan di aplikasi</small>
            </div>
            
            <div class="mb-4">
                <label class="form-label">Deskripsi</label>
                <textarea name="app_description" class="form-control" rows="3">{{ $settings['app_description']->value ?? '' }}</textarea>
                <small class="text-muted">Deskripsi singkat tentang kelompok tani</small>
            </div>
        </div>
        
        <!-- Kontak -->
        <div class="settings-section">
            <h5><i class="fas fa-phone text-success"></i> Informasi Kontak</h5>
            
            <div class="row">
                <div class="col-md-6 mb-4">
                    <label class="form-label">Email</label>
                    <input type="email" name="contact_email" class="form-control" 
                           value="{{ $settings['contact_email']->value ?? '' }}">
                </div>
                
                <div class="col-md-6 mb-4">
                    <label class="form-label">Nomor Telepon</label>
                    <input type="text" name="contact_phone" class="form-control" 
                           value="{{ $settings['contact_phone']->value ?? '' }}">
                </div>
            </div>
            
            <div class="mb-4">
                <label class="form-label">Alamat</label>
                <textarea name="address" class="form-control" rows="3">{{ $settings['address']->value ?? '' }}</textarea>
            </div>
        </div>
        
        <!-- Notifikasi Stok -->
        <div class="settings-section">
            <h5><i class="fas fa-bell text-warning"></i> Notifikasi Stok Singkong</h5>
            
            <div class="mb-4">
                <label class="form-label">Batas Minimum Stok (Kg)</label>
                <input type="number" name="min_stock_alert" class="form-control" step="0.01"
                       value="{{ $settings['min_stock_alert']->value ?? 100 }}" required>
                <small class="text-muted">Sistem akan memberi notifikasi jika stok singkong di bawah angka ini</small>
            </div>
            
            <div class="mb-4">
                <div class="form-check form-switch">
                    <input class="form-check-input" type="checkbox" name="enable_notifications" 
                           id="enableNotifications" value="1"
                           {{ ($settings['enable_notifications']->value ?? '1') == '1' ? 'checked' : '' }}>
                    <label class="form-check-label" for="enableNotifications">
                        <strong>Aktifkan Notifikasi Stok Menipis</strong>
                    </label>
                </div>
                <small class="text-muted">Notifikasi akan muncul di dashboard jika stok singkong menipis</small>
            </div>
        </div>
        
        <!-- Submit Button -->
        <div class="text-end">
            <button type="submit" class="btn btn-primary btn-lg px-5">
                <i class="fas fa-save"></i> Simpan Pengaturan
            </button>
        </div>
    </form>
</div>
@endif
