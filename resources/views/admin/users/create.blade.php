<div class="container-fluid px-4 py-3 fade-in">

<style>
    .form-card {
        background: white;
        border-radius: 16px;
        padding: 40px;
        box-shadow: 0 5px 20px rgba(0,0,0,0.08);
        max-width: 600px;
        margin: 0 auto;
    }
    
    .form-header {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border-radius: 16px;
        padding: 30px;
        color: white;
        margin-bottom: 30px;
        text-align: center;
        box-shadow: 0 8px 25px rgba(102, 126, 234, 0.3);
    }
</style>

<div class="form-header">
    <h3><i class="fas fa-user-plus"></i> Tambah User Baru</h3>
    <p class="mb-0">Tambah anggota kelompok tani singkong</p>
</div>

<div class="form-card">
    <form action="{{ route('users.store') }}" method="POST">
        @csrf
        
        <div class="mb-4">
            <label class="form-label"><i class="fas fa-user"></i> Nama Lengkap</label>
            <input type="text" name="name" class="form-control" value="{{ old('name') }}" required>
            @error('name')<div class="text-danger">{{ $message }}</div>@enderror
        </div>
        
        <div class="mb-4">
            <label class="form-label"><i class="fas fa-envelope"></i> Email</label>
            <input type="email" name="email" class="form-control" value="{{ old('email') }}" required>
            @error('email')<div class="text-danger">{{ $message }}</div>@enderror
        </div>
        
        <div class="mb-4">
            <label class="form-label"><i class="fas fa-lock"></i> Password</label>
            <input type="password" name="password" class="form-control" required>
            @error('password')<div class="text-danger">{{ $message }}</div>@enderror
        </div>
        
        <div class="mb-4">
            <label class="form-label"><i class="fas fa-lock"></i> Konfirmasi Password</label>
            <input type="password" name="password_confirmation" class="form-control" required>
        </div>
        
        <div class="mb-4">
            <label class="form-label"><i class="fas fa-shield-alt"></i> Role</label>
            <select name="role" class="form-control" required>
                <option value="anggota" {{ old('role') === 'anggota' ? 'selected' : '' }}>Anggota</option>
                <option value="admin" {{ old('role') === 'admin' ? 'selected' : '' }}>Admin</option>
            </select>
            @error('role')<div class="text-danger">{{ $message }}</div>@enderror
        </div>
        
        <div class="d-flex gap-2">
            <button type="submit" class="btn btn-primary flex-fill">
                <i class="fas fa-save"></i> Simpan
            </button>
            <a href="{{ route('users.index') }}" class="btn btn-secondary flex-fill">
                <i class="fas fa-arrow-left"></i> Kembali
            </a>
        </div>
    </form>
</div>

</div>
