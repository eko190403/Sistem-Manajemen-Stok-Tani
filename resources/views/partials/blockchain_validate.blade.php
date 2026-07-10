<style>
    .fade-in { animation: fadeIn 0.5s ease-in-out; }
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(10px); }
        to { opacity: 1; transform: translateY(0); }
    }

    .glass-card {
        background: var(--bg-card);
        border-radius: 16px;
        border: 1px solid #f1f5f9;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.03), 0 2px 4px -1px rgba(0, 0, 0, 0.02);
        padding: 24px;
    }

    .table-modern {
        width: 100%;
        border-collapse: separate;
        border-spacing: 0;
        margin-bottom: 0;
    }
    .table-modern thead th {
        background-color: #f8fafc;
        color: #64748b;
        font-weight: 600;
        font-size: 13px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        padding: 16px;
        border-bottom: 1px solid #e2e8f0;
        border-top: none;
    }
    .table-modern tbody td {
        padding: 16px;
        vertical-align: middle;
        color: #334155;
        font-size: 14px;
        border-bottom: 1px solid #f1f5f9;
        background: white;
    }
    .table-modern tbody tr:last-child td { border-bottom: none; }
    .table-modern tbody tr:hover td { background-color: #f8fafc; }

    .hash-display {
        background: #f1f5f9;
        padding: 6px 10px;
        border-radius: 6px;
        font-family: 'Courier New', monospace;
        font-size: 13px;
        border: 1px solid var(--border-color);
        display: inline-block;
        max-width: 250px;
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
        color: #475569;
        font-weight: 600;
    }

    .hash-display.broken {
        background: #fee2e2;
        color: #991b1b;
        border-color: #fca5a5;
    }

    .btn-copy {
        background: white;
        border: 1px solid var(--border-color);
        color: #64748b;
        padding: 6px 10px;
        border-radius: 6px;
        transition: all 0.2s;
    }
    .btn-copy:hover {
        background: var(--bg-main);
        color: #3b82f6;
        border-color: #bfdbfe;
    }

    .stat-box {
        background: var(--bg-main);
        border-radius: 12px;
        padding: 16px;
        border: 1px solid #f1f5f9;
    }
</style>

<div class="container-fluid px-4 fade-in py-4">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="page-title fs-3 fw-bold mb-1 text-dark">
                <i class="bi bi-shield-lock text-primary me-2"></i>Validasi Blockchain
            </h1>
            <p class="text-muted small mb-0">Memverifikasi integritas hash dan chain secara menyeluruh</p>
        </div>
        <div class="text-end">
            @if($isValid)
                <div class="bg-success text-white px-4 py-2 rounded-pill shadow-sm d-inline-block fw-bold fs-6">
                    <i class="bi bi-check-circle-fill me-2"></i> CHAIN VALID
                </div>
            @else
                <div class="bg-danger text-white px-4 py-2 rounded-pill shadow-sm d-inline-block fw-bold fs-6">
                    <i class="bi bi-x-circle-fill me-2"></i> CHAIN BROKEN
                </div>
            @endif
        </div>
    </div>

    <!-- Error Alert -->
    @if(!$isValid && $errorMessage)
    <div class="alert alert-danger shadow-sm border-0 mb-4" style="border-radius: 12px; background: linear-gradient(to right, #fef2f2, #fff);">
        <div class="d-flex align-items-center">
            <div class="bg-danger text-white rounded-circle p-2 me-3 d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                <i class="bi bi-exclamation-triangle-fill fs-5"></i>
            </div>
            <div>
                <h6 class="fw-bold text-danger mb-1">Integritas Blockchain Rusak!</h6>
                <p class="mb-0 text-danger small">{{ $errorMessage }}</p>
            </div>
        </div>
    </div>
    @endif

    <!-- Info Stats -->
    <div class="glass-card mb-4">
        <h6 class="fw-bold text-dark mb-4"><i class="bi bi-info-circle-fill text-primary me-2"></i>Statistik Validasi</h6>
        <div class="row g-4">
            <div class="col-md-4">
                <div class="stat-box d-flex align-items-center">
                    <div class="bg-success bg-opacity-10 text-success rounded-circle p-3 me-3">
                        <i class="bi bi-check-circle-fill fs-4"></i>
                    </div>
                    <div>
                        <span class="text-muted small d-block mb-1">Blok Valid</span>
                        <h4 class="fw-bold mb-0 text-dark">{{ $validCount }}</h4>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="stat-box d-flex align-items-center">
                    <div class="bg-danger bg-opacity-10 text-danger rounded-circle p-3 me-3">
                        <i class="bi bi-x-circle-fill fs-4"></i>
                    </div>
                    <div>
                        <span class="text-muted small d-block mb-1">Blok Invalid / Rusak</span>
                        <h4 class="fw-bold mb-0 text-dark">{{ $invalidCount }}</h4>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="stat-box d-flex align-items-center">
                    <div class="bg-primary bg-opacity-10 text-primary rounded-circle p-3 me-3">
                        <i class="bi bi-layers-fill fs-4"></i>
                    </div>
                    <div>
                        <span class="text-muted small d-block mb-1">Total Blok</span>
                        <h4 class="fw-bold mb-0 text-dark">{{ $totalBlocks }}</h4>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Tabel -->
    <div class="glass-card mb-4 p-0 overflow-hidden">
        <div class="table-responsive">
            <table class="table table-modern">
                <thead>
                    <tr>
                        <th width="10%">ID Blok</th>
                        <th width="15%">Aksi</th>
                        <th width="30%">Hash Sebelumnya</th>
                        <th width="30%">Hash Saat Ini</th>
                        <th width="15%" class="text-center">Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($blocks as $i => $block)
                        @php
                            $hashValid = $block->hash === $block->calculateHash();
                        @endphp

                        <tr class="{{ !$hashValid ? 'bg-danger bg-opacity-10' : '' }}">
                            <td>
                                @if($i === 0)
                                    <span class="badge bg-primary bg-gradient rounded-pill px-3 py-2">
                                        <i class="bi bi-star-fill me-1"></i> GENESIS
                                    </span>
                                @else
                                    <span class="fw-bold text-dark fs-6">#{{ str_pad($block->id, 5, '0', STR_PAD_LEFT) }}</span>
                                @endif
                            </td>
                            
                            <td>
                                @if(strtolower($block->action) === 'create')
                                    <span class="badge" style="background: #d1fae5; color: #065f46; border: 1px solid #a7f3d0; padding: 6px 12px; border-radius: 6px;">CREATE</span>
                                @elseif(strtolower($block->action) === 'update')
                                    <span class="badge" style="background: #fef3c7; color: #92400e; border: 1px solid #fde68a; padding: 6px 12px; border-radius: 6px;">UPDATE</span>
                                @elseif(strtolower($block->action) === 'delete')
                                    <span class="badge" style="background: #fee2e2; color: #991b1b; border: 1px solid #fecaca; padding: 6px 12px; border-radius: 6px;">DELETE</span>
                                @else
                                    <span class="badge" style="background: #f1f5f9; color: #475569; padding: 6px 12px; border-radius: 6px;">{{ strtoupper($block->action ?? 'N/A') }}</span>
                                @endif
                            </td>
                            
                            <td>
                                <div class="d-flex align-items-center gap-2">
                                    <code class="hash-display" title="{{ $block->previous_hash }}">
                                        {{ Str::limit($block->previous_hash, 25, '...') }}
                                    </code>
                                    <button class="btn-copy" onclick="copyHash('{{ $block->previous_hash }}')" title="Copy Hash">
                                        <i class="bi bi-clipboard"></i>
                                    </button>
                                </div>
                            </td>
                            
                            <td>
                                <div class="d-flex align-items-center gap-2">
                                    <code class="hash-display {{ !$hashValid ? 'broken' : '' }}" title="{{ $block->hash }}">
                                        {{ Str::limit($block->hash, 25, '...') }}
                                    </code>
                                    <button class="btn-copy" onclick="copyHash('{{ $block->hash }}')" title="Copy Hash">
                                        <i class="bi bi-clipboard"></i>
                                    </button>
                                </div>
                            </td>
                            
                            <td class="text-center">
                                @if($hashValid)
                                    <span style="color: #10b981; font-weight: 600;"><i class="bi bi-check-circle-fill me-1"></i> OK</span>
                                @else
                                    <span style="color: #ef4444; font-weight: 600;"><i class="bi bi-x-circle-fill me-1"></i> BROKEN</span>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        <div class="d-flex justify-content-center mt-4 border-top pt-4">
            {{ $blocks->links('pagination::bootstrap-5') }}
        </div>
    </div>
</div>

<script>
function copyHash(hash) {
    navigator.clipboard.writeText(hash).then(() => {
        showToast('Hash berhasil dicopy!', 'success');
    }).catch(() => {
        showToast('Gagal copy hash', 'danger');
    });
}
</script>
