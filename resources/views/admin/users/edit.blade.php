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
        background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
        border-radius: 16px;
        padding: 30px;
        color: white;
        margin-bottom: 30px;
        text-align: center;
        box-shadow: 0 8px 25px rgba(240, 147, 251, 0.3);
    }
</style>

<div class="form-header">
    <h3><i class="fas fa-user-edit"></i> Edit User</h3>
    <p class="mb-0">Update data anggota kelompok tani</p>
</div>

<div class="form-card">
    <form action="{{ route('users.update', $user->id) }}" method="POST">
        @csrf
        @method('PUT')
        
        <div class="mb-4">
            <label class="form-label"><i class="fas fa-user"></i> Nama Lengkap</label>
            <input type="text" name="name" class="form-control" value="{{ old('name', $user->name) }}" required>
            @error('name')<div class="text-danger">{{ $message }}</div>@enderror
        </div>
        
        <div class="mb-4">
            <label class="form-label"><i class="fas fa-envelope"></i> Email</label>
            <input type="email" name="email" class="form-control" value="{{ old('email', $user->email) }}" required>
            @error('email')<div class="text-danger">{{ $message }}</div>@enderror
        </div>
        
        <div class="mb-4">
            <label class="form-label"><i class="fas fa-shield-alt"></i> Role</label>
            <select name="role" class="form-control" required>
                <option value="anggota" {{ old('role', $user->role) === 'anggota' ? 'selected' : '' }}>Anggota</option>
                <option value="admin" {{ old('role', $user->role) === 'admin' ? 'selected' : '' }}>Admin</option>
            </select>
            @error('role')<div class="text-danger">{{ $message }}</div>@enderror
        </div>
        
        <div class="d-flex gap-2">
            <button type="submit" class="btn btn-primary flex-fill">
                <i class="fas fa-save"></i> Update
            </button>
            <a href="{{ route('users.index') }}" class="btn btn-secondary flex-fill">
                <i class="fas fa-arrow-left"></i> Kembali
            </a>
        </div>
    </form>
</div>

</div>
