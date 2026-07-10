<div class="fade-in" data-current-page="activity_logs">
    <!-- Header -->
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-4 gap-3">
        <div>
            <h4 class="mb-1 fw-bold" style="color: var(--text-main);">
                <i class="bi bi-clock-history text-primary"></i> Log Aktivitas
            </h4>
            <p class="text-muted mb-0 small">Riwayat aktivitas pengguna dalam sistem</p>
        </div>
    </div>

    <!-- Tabel Desktop -->
    <div class="table-responsive shadow-sm rounded d-none d-md-block" style="background: white;">
        <table class="table table-modern table-hover align-middle mb-0">
            <thead>
                <tr>
                    <th style="width: 20%;">
                        <i class="bi bi-calendar3 text-primary"></i> Waktu
                    </th>
                    <th style="width: 20%;">
                        <i class="bi bi-person text-primary"></i> Pengguna
                    </th>
                    <th style="width: 15%;">
                        <i class="bi bi-tag text-primary"></i> Aksi
                    </th>
                    <th style="width: 45%;">
                        <i class="bi bi-card-text text-primary"></i> Deskripsi
                    </th>
                </tr>
            </thead>
            <tbody>
                @forelse($logs as $log)
                <tr class="hover-row">
                    <td class="text-muted small">
                        {{ $log->created_at->format('d M Y, H:i') }}
                    </td>
                    <td>
                        <div class="d-flex align-items-center gap-2">
                            <div class="user-avatar-small" style="background: linear-gradient(135deg, #6366f1, #4f46e5); width: 30px; height: 30px; font-size: 0.8rem;">
                                {{ strtoupper(substr($log->user->name ?? '?', 0, 1)) }}
                            </div>
                            <strong>{{ $log->user->name ?? 'System' }}</strong>
                        </div>
                    </td>
                    <td>
                        @if($log->action === 'create')
                            <span class="badge bg-success bg-gradient"><i class="bi bi-plus"></i> Create</span>
                        @elseif($log->action === 'update')
                            <span class="badge bg-warning bg-gradient text-dark"><i class="bi bi-pencil"></i> Update</span>
                        @elseif($log->action === 'delete')
                            <span class="badge bg-danger bg-gradient"><i class="bi bi-trash"></i> Delete</span>
                        @elseif($log->action === 'login')
                            <span class="badge bg-info bg-gradient text-dark"><i class="bi bi-box-arrow-in-right"></i> Login</span>
                        @elseif($log->action === 'logout')
                            <span class="badge bg-secondary bg-gradient"><i class="bi bi-box-arrow-right"></i> Logout</span>
                        @else
                            <span class="badge bg-secondary bg-gradient">{{ strtoupper($log->action) }}</span>
                        @endif
                    </td>
                    <td class="text-muted">{{ $log->description }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="text-center py-5">
                        <i class="bi bi-inbox fs-1 d-block mb-2 text-muted opacity-50"></i>
                        <p class="text-muted mb-0">Belum ada riwayat aktivitas.</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Mobile Card View -->
    <div class="d-md-none">
        @forelse($logs as $log)
        <div class="card mb-3 border-0 shadow-sm hover-card">
            <div class="card-body p-3">
                <div class="d-flex align-items-start gap-3 mb-2">
                    <div class="flex-grow-1">
                        <div class="d-flex justify-content-between align-items-center mb-1">
                            <strong class="d-block">{{ $log->user->name ?? 'System' }}</strong>
                            <small class="text-muted">{{ $log->created_at->format('d M, H:i') }}</small>
                        </div>
                        
                        @if($log->action === 'create')
                            <span class="badge bg-success bg-gradient mb-2"><i class="bi bi-plus"></i> Create</span>
                        @elseif($log->action === 'update')
                            <span class="badge bg-warning bg-gradient text-dark mb-2"><i class="bi bi-pencil"></i> Update</span>
                        @elseif($log->action === 'delete')
                            <span class="badge bg-danger bg-gradient mb-2"><i class="bi bi-trash"></i> Delete</span>
                        @elseif($log->action === 'login')
                            <span class="badge bg-info bg-gradient text-dark mb-2"><i class="bi bi-box-arrow-in-right"></i> Login</span>
                        @elseif($log->action === 'logout')
                            <span class="badge bg-secondary bg-gradient mb-2"><i class="bi bi-box-arrow-right"></i> Logout</span>
                        @else
                            <span class="badge bg-secondary bg-gradient mb-2">{{ strtoupper($log->action) }}</span>
                        @endif

                        <p class="text-muted mb-0 small">{{ $log->description }}</p>
                    </div>
                </div>
            </div>
        </div>
        @empty
        <div class="card border-0 shadow-sm text-center py-5">
            <div class="card-body">
                <i class="bi bi-inbox fs-1 d-block mb-3 text-muted opacity-50"></i>
                <p class="text-muted mb-0">Belum ada riwayat aktivitas.</p>
            </div>
        </div>
        @endforelse
    </div>

    <!-- Pagination -->
    @if($logs->hasPages())
    <div class="d-flex justify-content-center mt-4">
        <div class="pagination-wrapper">
            {{ $logs->links('pagination.dashboard') }}
        </div>
    </div>
    @endif
</div>

<style>
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
.user-avatar-small {
    border-radius: 50%;
    color: white;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: 600;
}
.pagination-wrapper {
    background: white;
    padding: 0.75rem 1rem;
    border-radius: 8px;
    box-shadow: 0 2px 4px rgba(0,0,0,0.05);
}
</style>
