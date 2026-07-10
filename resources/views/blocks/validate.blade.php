<div class="container-fluid py-4">
    <!-- Header dengan Status -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
                        <div>
                            <h4 class="mb-1 fw-bold">
                                <i class="bi bi-shield-lock text-primary"></i>
                                Validasi Blockchain
                            </h4>
                            <p class="text-muted small mb-0">Verifikasi integritas chain blockchain</p>
                        </div>
                        <div class="text-end">
                            <div class="badge {{ $isValid ? 'bg-success' : 'bg-danger' }} fs-5 px-4 py-2 shadow-sm">
                                <i class="bi {{ $isValid ? 'bi-check-circle-fill' : 'bi-x-circle-fill' }}"></i>
                                {{ $isValid ? 'VALID' : 'INVALID' }}
                            </div>
                            <div class="small text-muted mt-2">Total: {{ count($blocks) }} blocks</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Error Alert -->
    @if(!$isValid && $errorMessage)
    <div class="row mb-4">
        <div class="col-12">
            <div class="alert alert-danger alert-dismissible fade show shadow-sm border-0 border-start border-5 border-danger" role="alert">
                <div class="d-flex align-items-start">
                    <i class="bi bi-exclamation-triangle-fill fs-4 me-3"></i>
                    <div>
                        <h5 class="alert-heading mb-2">Chain Integrity Broken!</h5>
                        <p class="mb-0">{{ $errorMessage }}</p>
                    </div>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        </div>
    </div>
    @endif

    <!-- Blockchain Table -->
    <div class="row">
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white border-bottom">
                    <h5 class="mb-0">
                        <i class="bi bi-layers text-primary"></i>
                        Block Chain Details
                    </h5>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th class="text-center" style="width: 80px;">
                                        <i class="bi bi-hash text-primary"></i> ID
                                    </th>
                                    <th style="width: 120px;">
                                        <i class="bi bi-tag text-primary"></i> Action
                                    </th>
                                    <th>
                                        <i class="bi bi-link-45deg text-primary"></i> Previous Hash
                                    </th>
                                    <th>
                                        <i class="bi bi-fingerprint text-primary"></i> Current Hash
                                    </th>
                                    <th class="text-center" style="width: 100px;">
                                        <i class="bi bi-check-circle text-primary"></i> Status
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($blocks as $i => $block)
                                    @php
                                        $hashValid = $block->hash === $block->calculateHash();
                                    @endphp

                                    <tr class="{{ !$hashValid ? 'table-danger bg-opacity-10' : '' }}">
                                        <td class="text-center">
                                            @if($i === 0)
                                                <span class="badge bg-primary bg-gradient">
                                                    <i class="bi bi-star-fill"></i> GENESIS
                                                </span>
                                            @else
                                                <span class="fw-bold text-muted">#{{ $block->id }}</span>
                                            @endif
                                        </td>
                                        
                                        <td>
                                            @if($block->action === 'CREATE')
                                                <span class="badge bg-success bg-gradient px-3 py-2">
                                                    <i class="bi bi-plus-circle"></i> CREATE
                                                </span>
                                            @elseif($block->action === 'UPDATE')
                                                <span class="badge bg-warning bg-gradient px-3 py-2">
                                                    <i class="bi bi-pencil"></i> UPDATE
                                                </span>
                                            @elseif($block->action === 'DELETE')
                                                <span class="badge bg-danger bg-gradient px-3 py-2">
                                                    <i class="bi bi-trash"></i> DELETE
                                                </span>
                                            @else
                                                <span class="badge bg-secondary bg-gradient px-3 py-2">
                                                    {{ strtoupper($block->action ?? 'N/A') }}
                                                </span>
                                            @endif
                                        </td>
                                        
                                        <td>
                                            <div class="d-flex align-items-center gap-2">
                                                <code class="hash-display" title="{{ $block->previous_hash }}">
                                                    {{ Str::limit($block->previous_hash, 30, '...') }}
                                                </code>
                                                <button class="btn btn-sm btn-outline-secondary btn-copy" 
                                                        onclick="copyHash('{{ $block->previous_hash }}')" 
                                                        title="Copy">
                                                    <i class="bi bi-clipboard"></i>
                                                </button>
                                            </div>
                                        </td>
                                        
                                        <td>
                                            <div class="d-flex align-items-center gap-2">
                                                <code class="hash-display {{ !$hashValid ? 'text-danger' : '' }}" 
                                                      title="{{ $block->hash }}">
                                                    {{ Str::limit($block->hash, 30, '...') }}
                                                </code>
                                                <button class="btn btn-sm btn-outline-secondary btn-copy" 
                                                        onclick="copyHash('{{ $block->hash }}')" 
                                                        title="Copy">
                                                    <i class="bi bi-clipboard"></i>
                                                </button>
                                            </div>
                                        </td>
                                        
                                        <td class="text-center">
                                            @if($hashValid)
                                                <span class="badge bg-success bg-gradient px-3 py-2">
                                                    <i class="bi bi-check-circle-fill"></i> OK
                                                </span>
                                            @else
                                                <span class="badge bg-danger bg-gradient px-3 py-2">
                                                    <i class="bi bi-x-circle-fill"></i> BROKEN
                                                </span>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Info Card -->
    <div class="row mt-4">
        <div class="col-md-12">
            <div class="card border-0 shadow-sm bg-light">
                <div class="card-body">
                    <h6 class="fw-bold mb-3">
                        <i class="bi bi-info-circle text-primary"></i> 
                        Informasi Validasi
                    </h6>
                    <div class="row g-3">
                        <div class="col-md-4">
                            <div class="d-flex align-items-center gap-2">
                                <i class="bi bi-check-circle text-success fs-4"></i>
                                <div>
                                    <small class="text-muted d-block">Valid Blocks</small>
                                    <strong class="text-success">{{ $blocks->filter(fn($b) => $b->hash === $b->calculateHash())->count() }}</strong>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="d-flex align-items-center gap-2">
                                <i class="bi bi-x-circle text-danger fs-4"></i>
                                <div>
                                    <small class="text-muted d-block">Invalid Blocks</small>
                                    <strong class="text-danger">{{ $blocks->filter(fn($b) => $b->hash !== $b->calculateHash())->count() }}</strong>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="d-flex align-items-center gap-2">
                                <i class="bi bi-layers text-primary fs-4"></i>
                                <div>
                                    <small class="text-muted d-block">Total Blocks</small>
                                    <strong class="text-primary">{{ count($blocks) }}</strong>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.hash-display {
    background: #f8f9fa;
    padding: 4px 8px;
    border-radius: 4px;
    font-family: 'Courier New', monospace;
    font-size: 12px;
    border: 1px solid #e9ecef;
    display: inline-block;
    max-width: 350px;
    overflow: hidden;
    text-overflow: ellipsis;
    white-space: nowrap;
}

.btn-copy {
    padding: 2px 6px;
    font-size: 12px;
}

.btn-copy:hover {
    background: #e9ecef;
}

.table > :not(caption) > * > * {
    padding: 1rem 0.75rem;
}

.hover-row:hover {
    background-color: rgba(0, 123, 255, 0.05);
    transition: all 0.2s;
}

.card {
    border-radius: 12px;
}

.badge {
    font-weight: 500;
}
</style>

<script>
function copyHash(hash) {
    navigator.clipboard.writeText(hash).then(() => {
        showToast('Hash berhasil dicopy!', 'success');
    }).catch(() => {
        showToast('Gagal copy hash', 'danger');
    });
}
</script>
