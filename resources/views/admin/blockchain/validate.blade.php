<div class="container-fluid px-3 py-2 fade-in">

<style>
    .blockchain-header {
        background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
        border-radius: 12px;
        padding: 18px 20px;
        color: white;
        margin-bottom: 15px;
        box-shadow: 0 4px 15px rgba(240, 147, 251, 0.3);
    }
    
    .blockchain-header h4 {
        font-size: 1.25rem;
        margin-bottom: 0.25rem;
    }
    
    .blockchain-header p {
        font-size: 0.9rem;
        margin-bottom: 0;
    }
    
    .status-card {
        background: white;
        border-radius: 12px;
        padding: 15px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.08);
        margin-bottom: 15px;
        transition: all 0.3s ease;
    }
    
    .status-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 15px rgba(0,0,0,0.12);
    }
    
    .status-card.valid {
        border-left: 4px solid #28a745;
    }
    
    .status-card.invalid {
        border-left: 4px solid #dc3545;
    }
    
    .block-item {
        background: #f8f9fa;
        border-radius: 8px;
        padding: 12px;
        margin-bottom: 10px;
        transition: all 0.3s ease;
    }
    
    .block-item.valid {
        border-left: 3px solid #28a745;
    }
    
    .block-item.invalid {
        border-left: 3px solid #dc3545;
        background: #ffe6e6;
    }
    
    .block-item:hover {
        transform: translateX(3px);
        box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    }
    
    .chain-status {
        font-size: 36px;
        margin-bottom: 10px;
    }
</style>

<div class="blockchain-header">
    <h4><i class="fas fa-link"></i> Blockchain Validation</h4>
    <p class="mb-0">Validasi integritas blockchain stok singkong</p>
</div>

@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show py-2">
        <i class="fas fa-check-circle"></i> {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

<!-- Chain Status -->
<div class="row mb-3">
    <div class="col-md-3">
        <div class="status-card">
            <h6 class="text-muted mb-1 small">Total Blocks</h6>
            <h4 class="mb-0">{{ $totalBlocks }}</h4>
        </div>
    </div>
    <div class="col-md-3">
        <div class="status-card valid">
            <h6 class="text-success mb-1 small">Valid Blocks</h6>
            <h4 class="mb-0 text-success">{{ $validBlocks }}</h4>
        </div>
    </div>
    <div class="col-md-3">
        <div class="status-card invalid">
            <h6 class="text-danger mb-1 small">Invalid Blocks</h6>
            <h4 class="mb-0 text-danger">{{ $invalidBlocks }}</h4>
        </div>
    </div>
    <div class="col-md-3">
        <div class="status-card {{ $chainValid ? 'valid' : 'invalid' }}">
            <h6 class="{{ $chainValid ? 'text-success' : 'text-danger' }} mb-1 small">Chain Status</h6>
            <div class="chain-status">
                @if($chainValid)
                    <i class="fas fa-check-circle text-success"></i>
                @else
                    <i class="fas fa-exclamation-triangle text-danger"></i>
                @endif
            </div>
            <strong class="{{ $chainValid ? 'text-success' : 'text-danger' }}">
                {{ $chainValid ? 'VALID' : 'BROKEN' }}
            </strong>
        </div>
    </div>
</div>

<!-- Actions -->
<div class="mb-4">
    <form action="{{ route('blockchain.recalculate') }}" method="POST" class="d-inline">
        @csrf
        <button type="submit" class="btn btn-warning btn-lg" onclick="return confirm('Yakin ingin recalculate semua hash? Ini akan memperbaiki block yang corrupt.')">
            <i class="fas fa-sync-alt"></i> Recalculate & Fix Blockchain
        </button>
    </form>
    
    <a href="{{ route('blocks.index') }}" class="btn btn-info btn-lg">
        <i class="fas fa-list"></i> Lihat Semua Blocks
    </a>
</div>

<!-- Validation Results -->
<div class="status-card">
    <h5 class="mb-4"><i class="fas fa-clipboard-check"></i> Hasil Validasi Per Block</h5>
    
    @forelse($validationResults as $result)
        <div class="block-item {{ $result['is_valid'] ? 'valid' : 'invalid' }}">
          
               
                        <h6 class="mb-0 me-3">Block #{{ $result['block']->id }}</h6>
                        @if($result['is_valid'])
                            <span class="badge bg-success">
                                <i class="fas fa-check"></i> VALID
                            </span>
                        @else
                            <span class="badge bg-danger">
                                <i class="fas fa-times"></i> INVALID
                            </span>
                        @endif
                    </div>
                    
                    <table class="table table-sm table-borderless mb-0">
                        <tr>
                            <td width="150"><small class="text-muted">Stok ID:</small></td>
                            <td><small><strong>#{{ $result['block']->stok_id }}</strong></small></td>
                        </tr>
                        <tr>
                            <td><small class="text-muted">Action:</small></td>
                            <td><small><code>{{ $result['block']->action }}</code></small></td>
                        </tr>
                        <tr>
                            <td><small class="text-muted">Previous Hash:</small></td>
                            <td><small><code class="text-primary">{{ Str::limit($result['block']->previous_hash, 32) }}</code></small></td>
                        </tr>
                        <tr>
                            <td><small class="text-muted">Current Hash:</small></td>
                            <td><small><code class="text-info">{{ Str::limit($result['block']->hash, 32) }}</code></small></td>
                        </tr>
                        <tr>
                            <td><small class="text-muted">Timestamp:</small></td>
                            <td><small>{{ $result['block']->timestamp }}</small></td>
                        </tr>
                        <tr>
                            <td><small class="text-muted">Status:</small></td>
                            <td>
                                <small class="{{ $result['is_valid'] ? 'text-success' : 'text-danger' }}">
                                    <strong>{{ $result['message'] }}</strong>
                                </small>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    @empty
        <div class="text-center py-5">
            <i class="fas fa-cube fa-3x text-muted mb-3"></i>
            <p class="text-muted">Belum ada block dalam blockchain</p>
        </div>
    @endforelse
</div>
