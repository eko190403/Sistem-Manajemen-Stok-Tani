<div class="container-fluid px-4 py-3 fade-in">

<style>
    .log-header {
        background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%);
        border-radius: 16px;
        padding: 30px;
        color: white;
        margin-bottom: 30px;
        box-shadow: 0 8px 25px rgba(17, 153, 142, 0.3);
    }
    
    .log-card {
        background: white;
        border-radius: 16px;
        padding: 30px;
        box-shadow: 0 5px 20px rgba(0,0,0,0.08);
    }
    
    .log-filter {
        background: #f8f9fa;
        padding: 20px;
        border-radius: 12px;
        margin-bottom: 20px;
    }
    
    .log-table th {
        background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%);
        color: white;
        padding: 15px;
        border: none;
        font-weight: 600;
    }
    
    .log-table td {
        padding: 12px 15px;
        vertical-align: middle;
    }
    
    .log-table tr:hover {
        background: #f8f9fa;
    }
    
    .badge-action {
        padding: 6px 12px;
        border-radius: 20px;
        font-size: 11px;
        font-weight: 600;
    }
</style>

<div class="log-header">
    <h3><i class="fas fa-history"></i> Activity Logs</h3>
    <p class="mb-0">Riwayat semua aktivitas di sistem stok singkong</p>
</div>

<div class="log-card">
    <!-- Filter Form -->
    <form method="GET" class="log-filter">
        <div class="row g-3">
            <div class="col-md-3">
                <label class="form-label">User</label>
                <select name="user_id" class="form-control">
                    <option value="">Semua User</option>
                    @foreach($users as $user)
                        <option value="{{ $user->id }}" {{ request('user_id') == $user->id ? 'selected' : '' }}>
                            {{ $user->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2">
                <label class="form-label">Aksi</label>
                <select name="action" class="form-control">
                    <option value="">Semua</option>
                    <option value="create" {{ request('action') == 'create' ? 'selected' : '' }}>Create</option>
                    <option value="update" {{ request('action') == 'update' ? 'selected' : '' }}>Update</option>
                    <option value="delete" {{ request('action') == 'delete' ? 'selected' : '' }}>Delete</option>
                    <option value="login" {{ request('action') == 'login' ? 'selected' : '' }}>Login</option>
                </select>
            </div>
            <div class="col-md-3">
                <label class="form-label">Dari Tanggal</label>
                <input type="date" name="date_from" class="form-control" value="{{ request('date_from') }}">
            </div>
            <div class="col-md-3">
                <label class="form-label">Sampai Tanggal</label>
                <input type="date" name="date_to" class="form-control" value="{{ request('date_to') }}">
            </div>
            <div class="col-md-1">
                <label class="form-label">&nbsp;</label>
                <button type="submit" class="btn btn-primary w-100">
                    <i class="fas fa-search"></i>
                </button>
            </div>
        </div>
    </form>
    
    <!-- Logs Table -->
    <div class="table-responsive">
        <table class="table log-table">
            <thead>
                <tr>
                    <th>Waktu</th>
                    <th>User</th>
                    <th>Aksi</th>
                    <th>Deskripsi</th>
                    <th>IP Address</th>
                    <th>Detail</th>
                </tr>
            </thead>
            <tbody>
                @forelse($logs as $log)
                <tr>
                    <td>{{ $log->created_at->format('d/m/Y H:i') }}</td>
                    <td>
                        <strong>{{ $log->user->name ?? 'System' }}</strong><br>
                        <small class="text-muted">{{ $log->user->email ?? '-' }}</small>
                    </td>
                    <td>
                        <span class="badge-action 
                            @if($log->action === 'create') bg-success
                            @elseif($log->action === 'update') bg-warning
                            @elseif($log->action === 'delete') bg-danger
                            @else bg-info
                            @endif">
                            {{ strtoupper($log->action) }}
                        </span>
                    </td>
                    <td>{{ $log->description }}</td>
                    <td><small>{{ $log->ip_address }}</small></td>
                    <td>
                        <button class="btn btn-sm btn-info" data-bs-toggle="modal" data-bs-target="#logModal{{ $log->id }}">
                            <i class="fas fa-eye"></i> Detail
                        </button>
                    </td>
                </tr>
                
                <!-- Detail Modal -->
                <div class="modal fade" id="logModal{{ $log->id }}" tabindex="-1">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Detail Log #{{ $log->id }}</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                            </div>
                            <div class="modal-body">
                                <table class="table table-sm">
                                    <tr>
                                        <th width="150">User</th>
                                        <td>{{ $log->user->name ?? '-' }}</td>
                                    </tr>
                                    <tr>
                                        <th>Email</th>
                                        <td>{{ $log->user->email ?? '-' }}</td>
                                    </tr>
                                    <tr>
                                        <th>Aksi</th>
                                        <td><strong>{{ strtoupper($log->action) }}</strong></td>
                                    </tr>
                                    <tr>
                                        <th>Model</th>
                                        <td>{{ $log->model ?? '-' }} #{{ $log->model_id ?? '-' }}</td>
                                    </tr>
                                    <tr>
                                        <th>Deskripsi</th>
                                        <td>{{ $log->description }}</td>
                                    </tr>
                                    <tr>
                                        <th>IP Address</th>
                                        <td>{{ $log->ip_address }}</td>
                                    </tr>
                                    <tr>
                                        <th>User Agent</th>
                                        <td><small>{{ $log->user_agent }}</small></td>
                                    </tr>
                                    <tr>
                                        <th>Waktu</th>
                                        <td>{{ $log->created_at->format('d F Y, H:i:s') }}</td>
                                    </tr>
                                    @if($log->old_values)
                                    <tr>
                                        <th>Data Lama</th>
                                        <td><pre class="bg-light p-2">{{ json_encode($log->old_values, JSON_PRETTY_PRINT) }}</pre></td>
                                    </tr>
                                    @endif
                                    @if($log->new_values)
                                    <tr>
                                        <th>Data Baru</th>
                                        <td><pre class="bg-light p-2">{{ json_encode($log->new_values, JSON_PRETTY_PRINT) }}</pre></td>
                                    </tr>
                                    @endif
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                @empty
                <tr>
                    <td colspan="6" class="text-center py-5">
                        <i class="fas fa-history fa-3x text-muted mb-3"></i>
                        <p class="text-muted">Belum ada log aktivitas</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    <div class="mt-3">
        {{ $logs->links() }}
    </div>
</div>
