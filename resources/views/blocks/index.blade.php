<div class="container-fluid mt-2 mt-md-3">

    <h4 class="fw-bold mb-3 fs-6 fs-md-5">⛓ Riwayat Blockchain Stok</h4>

    <!-- Desktop Table View -->
    <div class="table-responsive glass-card p-2 p-md-3 shadow-sm rounded d-none d-md-block">
        <table class="table table-hover align-middle mb-0">
            <thead class="table-dark">
                <tr>
                    <th class="fs-7 fs-md-normal">ID Block</th>
                    <th class="fs-7 fs-md-normal">Stok</th>
                    <th class="fs-7 fs-md-normal">Aksi</th>
                    <th class="fs-7 fs-md-normal">Jumlah</th>
                    <th class="fs-7 fs-md-normal">Satuan</th>
                    <th class="fs-7 fs-md-normal">Keterangan</th>
                    <th class="fs-7 fs-md-normal">Waktu</th>
                </tr>
            </thead>
            <tbody>
                @foreach($blocks as $block)
                    @php
                        $blockData = json_decode($block->data, true);
                    @endphp
                    <tr>
                        <td class="text-center fs-7">{{ $block->id }}</td>
                        <td class="fs-7">{{ $blockData['nama_barang'] ?? '-' }}</td>
                        <td class="fs-7">
                            <span class="badge {{ $block->action === 'create' ? 'bg-success' : 'bg-warning' }}">
                                {{ ucfirst($block->action) }}
                            </span>
                        </td>
                        <td class="fs-7">{{ $blockData['jumlah'] ?? '-' }}</td>
                        <td class="fs-7">{{ $blockData['satuan'] ?? '-' }}</td>
                        <td class="fs-7">{{ $blockData['keterangan'] ?? '-' }}</td>
                        <td class="fs-7">{{ $block->created_at->format('d-m-Y H:i') }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Mobile Card View -->
    <div class="d-md-none">
        @foreach($blocks as $block)
            @php
                $blockData = json_decode($block->data, true);
            @endphp
            <div class="card mb-2 border-0 shadow-sm">
                <div class="card-header bg-dark text-white py-2 px-3">
                    <strong class="fs-8">Block #{{ $block->id }}</strong>
                </div>
                <div class="card-body p-2">
                    <div class="row g-2">
                        <div class="col-6">
                            <small class="text-muted d-block">Stok</small>
                            <strong class="fs-8">{{ $blockData['nama_barang'] ?? '-' }}</strong>
                        </div>
                        <div class="col-6">
                            <small class="text-muted d-block">Aksi</small>
                            <span class="badge {{ $block->action === 'create' ? 'bg-success' : 'bg-warning' }} fs-8">
                                {{ ucfirst($block->action) }}
                            </span>
                        </div>
                        <div class="col-6">
                            <small class="text-muted d-block">Jumlah</small>
                            <strong class="fs-8">{{ $blockData['jumlah'] ?? '-' }}</strong>
                        </div>
                        <div class="col-6">
                            <small class="text-muted d-block">Satuan</small>
                            <strong class="fs-8">{{ $blockData['satuan'] ?? '-' }}</strong>
                        </div>
                        <div class="col-12">
                            <small class="text-muted d-block">Keterangan</small>
                            <strong class="fs-8">{{ $blockData['keterangan'] ?? '-' }}</strong>
                        </div>
                        <div class="col-12">
                            <small class="text-muted d-block">Waktu</small>
                            <strong class="fs-8">{{ $block->created_at->format('d-m-Y H:i') }}</strong>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <!-- Pagination -->
    <div class="mt-3 d-flex justify-content-center pagination-wrapper">
        {{ $blocks->links('pagination.dashboard') }}
    </div>

</div>

<style>
    .fs-7 {
        font-size: 0.85rem !important;
    }

    .fs-8 {
        font-size: 0.75rem !important;
    }

    @media (max-width: 768px) {
        .container-fluid {
            padding: 0.5rem !important;
        }

        h4 {
            font-size: 1rem !important;
        }

        .glass-card {
            padding: 0.75rem !important;
        }

        .card-header {
            padding: 0.5rem 0.75rem !important;
        }

        .card-body {
            padding: 0.5rem !important;
        }

        .badge {
            font-size: 0.65rem !important;
            padding: 0.25rem 0.4rem !important;
        }

        /* Pagination Mobile */
        .pagination-wrapper {
            margin-top: 0.5rem !important;
        }

        .pagination-wrapper nav {
            width: 100%;
        }

        .pagination-wrapper .pagination {
            flex-wrap: wrap;
            gap: 0.15rem;
            margin-bottom: 0;
        }

        .pagination-wrapper .page-link {
            padding: 0.2rem 0.3rem !important;
            font-size: 0.6rem !important;
            min-width: 20px;
            height: 20px;
            line-height: 1;
            text-align: center;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .pagination-wrapper .page-item {
            margin: 0.05rem 0.03rem;
        }

        .pagination-wrapper > div:first-child {
            font-size: 0.6rem !important;
            margin-bottom: 0.3rem;
        }
    }

    @media (max-width: 575px) {
        .card {
            margin-bottom: 0.5rem;
        }

        .card-body {
            padding: 0.5rem !important;
        }

        .fs-8 {
            font-size: 0.7rem !important;
        }
    }
</style>
