<div class="fade-in" data-current-page="users">
    <!-- Header -->
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-4 gap-3">
        <div>
            <h4 class="mb-1 fw-bold" style="color: var(--text-main);">
                <i class="bi bi-people-fill text-primary"></i> Manajemen User
            </h4>
            <p class="text-muted mb-0 small">Kelola pengguna sistem</p>
        </div>
        
        @if(auth()->user()->role === 'admin')
        <button onclick="loadPage('users_create')" class="btn-stok btn-tambah">
            <i class="bi bi-person-plus"></i> 
            <span>Tambah User</span>
        </button>
        @endif
    </div>

    <!-- Stats Cards -->
    <div class="row g-3 mb-4">
        <div class="col-md-4">
            <div class="stats-card stats-primary">
                <div class="stats-icon">
                    <i class="bi bi-people"></i>
                </div>
                <div class="stats-info">
                    <h3>{{ $users->total() }}</h3>
                    <p>Total User</p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="stats-card stats-success">
                <div class="stats-icon">
                    <i class="bi bi-shield-check"></i>
                </div>
                <div class="stats-info">
                    <h3>{{ $users->where('role', 'admin')->count() }}</h3>
                    <p>Admin</p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="stats-card stats-info">
                <div class="stats-icon">
                    <i class="bi bi-person-badge"></i>
                </div>
                <div class="stats-info">
                    <h3>{{ $users->where('role', 'anggota')->count() }}</h3>
                    <p>Anggota</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Tabel Desktop -->
    <div class="table-responsive shadow-sm rounded d-none d-md-block" style="background: white;">
        <table class="table table-modern table-hover align-middle mb-0">
            <thead>
                <tr>
                    <th style="width: 5%;">#</th>
                    <th style="width: 25%;">
                        <i class="bi bi-person text-primary"></i> Nama
                    </th>
                    <th style="width: 25%;">
                        <i class="bi bi-envelope text-primary"></i> Email
                    </th>
                    <th class="text-center" style="width: 15%;">
                        <i class="bi bi-shield text-primary"></i> Role
                    </th>
                    <th class="text-center" style="width: 15%;">
                        <i class="bi bi-calendar text-primary"></i> Terdaftar
                    </th>
                    @if(auth()->user()->role === 'admin')
                    <th class="text-center" style="width: 15%;">
                        <i class="bi bi-gear text-primary"></i> Aksi
                    </th>
                    @endif
                </tr>
            </thead>
            <tbody>
                @forelse($users as $index => $user)
                <tr class="hover-row">
                    <td class="fw-medium text-muted">{{ $users->firstItem() + $index }}</td>
                    <td>
                        <div class="d-flex align-items-center gap-2">
                            <div class="user-avatar-small">
                                {{ strtoupper(substr($user->name, 0, 1)) }}
                            </div>
                            <strong>{{ $user->name }}</strong>
                        </div>
                    </td>
                    <td>{{ $user->email }}</td>
                    <td class="text-center">
                        @if($user->role === 'admin')
                            <span class="badge bg-danger bg-gradient">
                                <i class="bi bi-shield-fill-check"></i> Admin
                            </span>
                        @else
                            <span class="badge bg-success bg-gradient">
                                <i class="bi bi-person-check"></i> Anggota
                            </span>
                        @endif
                    </td>
                    <td class="text-center text-muted small">
                        {{ $user->created_at->format('d M Y') }}
                    </td>
                    @if(auth()->user()->role === 'admin')
                    <td class="text-center">
                        <div class="btn-group" role="group">
                            <button onclick="loadPage('users_edit', {{ $user->id }})" 
                                    class="btn btn-sm btn-warning" 
                                    title="Edit">
                                <i class="bi bi-pencil"></i>
                            </button>
                            @if($user->id !== auth()->id())
                            <form action="/users/{{ $user->id }}" method="POST" style="display: inline;" onsubmit="return confirm('Apakah Anda yakin ingin menghapus user \"{{ addslashes($user->name) }}\"?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger" title="Hapus">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </form>
                            @endif
                        </div>
                    </td>
                    @endif
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="text-center py-5">
                        <i class="bi bi-inbox fs-1 d-block mb-2 text-muted opacity-50"></i>
                        <p class="text-muted mb-0">Belum ada data user.</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Card Mobile -->
    <div class="d-md-none">
        @forelse($users as $user)
        <div class="card mb-3 border-0 shadow-sm hover-card">
            <div class="card-body p-3">
                <div class="d-flex align-items-start gap-3 mb-3">
                    <div class="user-avatar-mobile">
                        {{ strtoupper(substr($user->name, 0, 1)) }}
                    </div>
                    <div class="flex-grow-1">
                        <h6 class="mb-1 fw-bold">{{ $user->name }}</h6>
                        <small class="text-muted d-block mb-2">{{ $user->email }}</small>
                        @if($user->role === 'admin')
                            <span class="badge bg-danger bg-gradient">
                                <i class="bi bi-shield-fill-check"></i> Admin
                            </span>
                        @else
                            <span class="badge bg-success bg-gradient">
                                <i class="bi bi-person-check"></i> Anggota
                            </span>
                        @endif
                    </div>
                </div>
                
                <div class="d-flex align-items-center justify-content-between">
                    <small class="text-muted">
                        <i class="bi bi-calendar"></i> {{ $user->created_at->format('d M Y') }}
                    </small>
                    @if(auth()->user()->role === 'admin')
                    <div class="btn-group" role="group">
                        <button onclick="loadPage('users_edit', {{ $user->id }})" 
                                class="btn btn-sm btn-warning">
                            <i class="bi bi-pencil"></i>
                        </button>
                        @if($user->id !== auth()->id())
                        <form action="/users/{{ $user->id }}" method="POST" style="display: inline;" onsubmit="return confirm('Apakah Anda yakin ingin menghapus user \"{{ addslashes($user->name) }}\"?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger">
                                <i class="bi bi-trash"></i>
                            </button>
                        </form>
                        @endif
                    </div>
                    @endif
                </div>
            </div>
        </div>
        @empty
        <div class="card border-0 shadow-sm text-center py-5">
            <div class="card-body">
                <i class="bi bi-inbox fs-1 d-block mb-3 text-muted opacity-50"></i>
                <p class="text-muted mb-0">Belum ada data user.</p>
            </div>
        </div>
        @endforelse
    </div>

    <!-- Pagination -->
    @if($users->hasPages())
    <div class="d-flex justify-content-center mt-4">
        <div class="pagination-wrapper">
            {{ $users->links('pagination.dashboard') }}
        </div>
    </div>
    @endif
</div>

<style>
/* Stats Cards */
.stats-card {
    background: white;
    border-radius: 12px;
    padding: 1.5rem;
    box-shadow: 0 2px 8px rgba(0,0,0,0.08);
    display: flex;
    align-items: center;
    gap: 1rem;
    transition: all 0.3s ease;
}

.stats-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 4px 16px rgba(0,0,0,0.12);
}

.stats-icon {
    width: 60px;
    height: 60px;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.75rem;
    color: white;
}

.stats-primary .stats-icon {
    background: linear-gradient(135deg, #2563EB, #1D4ED8);
}

.stats-success .stats-icon {
    background: linear-gradient(135deg, #10B981, #059669);
}

.stats-info .stats-icon {
    background: linear-gradient(135deg, #0891B2, #0E7490);
}

.stats-info h3 {
    margin: 0;
    font-size: 2rem;
    font-weight: 700;
    color: var(--text-main);
}

.stats-info p {
    margin: 0;
    color: #6B7280;
    font-size: 0.875rem;
}

/* User Avatar */
.user-avatar-small {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    background: linear-gradient(135deg, #667eea, #764ba2);
    color: white;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: 600;
    font-size: 1rem;
}

.user-avatar-mobile {
    width: 50px;
    height: 50px;
    border-radius: 50%;
    background: linear-gradient(135deg, #667eea, #764ba2);
    color: white;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: 600;
    font-size: 1.25rem;
    flex-shrink: 0;
}

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

/* Table Styles */
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

.pagination-wrapper {
    background: white;
    padding: 0.75rem 1rem;
    border-radius: 8px;
    box-shadow: 0 2px 4px rgba(0,0,0,0.05);
}
</style>

<script>
// ...existing code...
</script>
