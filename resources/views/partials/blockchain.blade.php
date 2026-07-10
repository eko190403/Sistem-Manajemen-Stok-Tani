<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Blockchain</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

    <style>
        body {
            background-color: #f8fafc;
            font-family: 'Inter', sans-serif;
        }

        .fade-in {
            animation: fadeIn 0.5s ease-in-out;
        }
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }

        /* CARD UTAMA */
        .glass-card {
            background: var(--bg-card);
            border-radius: 16px;
            border: 1px solid #f1f5f9;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.03), 0 2px 4px -1px rgba(0, 0, 0, 0.02);
            padding: 24px;
        }

        .page-title {
            font-size: 24px;
            font-weight: 700;
            color: #0f172a;
            margin-bottom: 0;
        }

        .btn-validate {
            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
            border: none;
            color: white;
            padding: 10px 20px;
            border-radius: 8px;
            font-weight: 600;
            transition: all 0.3s ease;
            box-shadow: 0 4px 6px -1px rgba(16, 185, 129, 0.2);
        }
        .btn-validate:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 12px -1px rgba(16, 185, 129, 0.3);
            color: white;
        }

        /* TABEL MODERN */
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
        .table-modern tbody tr:last-child td {
            border-bottom: none;
        }
        .table-modern tbody tr:hover td {
            background-color: #f8fafc;
        }

        /* BADGES */
        .badge-create { background-color: #d1fae5; color: #065f46; border: 1px solid #a7f3d0; }
        .badge-update { background-color: #fef3c7; color: #92400e; border: 1px solid #fde68a; }
        .badge-delete { background-color: #fee2e2; color: #991b1b; border: 1px solid #fecaca; }
        
        .badge-valid { background-color: #d1fae5; color: #065f46; padding: 6px 12px; border-radius: 6px; font-weight: 600; font-size: 12px;}
        .badge-invalid { background-color: #fee2e2; color: #991b1b; padding: 6px 12px; border-radius: 6px; font-weight: 600; font-size: 12px;}

        /* ID Hash Styling */
        .hash-id {
            font-family: 'Courier New', Courier, monospace;
            background: #f1f5f9;
            padding: 4px 8px;
            border-radius: 4px;
            color: #475569;
            font-size: 13px;
            font-weight: 600;
        }

        /* Modal Customizations */
        .modal-content {
            border-radius: 16px;
            border: none;
            overflow: hidden;
        }
        .modal-header-gradient {
            background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
            color: white;
            border-bottom: none;
        }
        .json-block {
            background: #0f172a;
            color: #e2e8f0;
            padding: 16px;
            border-radius: 8px;
            font-family: 'Courier New', Courier, monospace;
            font-size: 13px;
            overflow-x: auto;
        }
    </style>
</head>

<body>
<div class="container-fluid px-4 fade-in">

    {{-- HEADER --}}
    <div class="d-flex justify-content-between align-items-center mb-4 mt-3">
        <div>
            <h1 class="page-title"><i class="bi bi-link-45deg text-primary me-2"></i>Blockchain Explorer</h1>
            <p class="text-muted small mb-0 mt-1">Sistem pencatatan transaksi terdesentralisasi anti-manipulasi</p>
        </div>

        <button onclick="loadPage('blockchain_validate')" class="btn-validate">
            <i class="bi bi-shield-check me-1"></i> Validasi Blockchain
        </button>
    </div>

    {{-- Pesan sukses/error --}}
    @if(session('success'))
        <div class="alert alert-success mt-2">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger mt-2">{{ session('error') }}</div>
    @endif

    {{-- Table Container --}}
    <div class="glass-card mb-4">
        <div class="table-responsive">
            <table class="table table-modern">
                <thead>
                    <tr>
                        <th width="15%">ID Blok</th>
                        <th width="15%">Aktor</th>
                        <th width="10%">Aksi</th>
                        <th width="30%">Keterangan</th>
                        <th width="15%">Waktu</th>
                        <th width="10%">Status</th>
                        <th width="5%">Detail</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($blocks as $b)
                        @php
                            $blockData = json_decode($b->data, true);
                            $actor = $blockData['actor'] ?? '-';
                            $nama_barang = $blockData['nama_barang'] ?? '-';
                            
                            $jumlah = $blockData['jumlah'] ?? $blockData['jumlah_asli'] ?? null;
                            if (is_numeric($jumlah)) {
                                $jumlah_formatted = number_format($jumlah, 0, ',', '.');
                            } else {
                                $jumlah_formatted = $jumlah;
                            }
                            $satuan = $blockData['satuan'] ?? $blockData['satuan_asli'] ?? '';
                            $jumlah_barang = trim($jumlah_formatted . ' ' . $satuan);
                            
                            $actionClass = match($b->action) {
                                'create' => 'badge-create',
                                'update' => 'badge-update',
                                'delete' => 'badge-delete',
                                default => 'badge-create',
                            };
                            
                            $keterangan = $blockData['keterangan'] ?? (
                                match($b->action) {
                                    'create' => "Menambahkan stok: $nama_barang ($jumlah_barang)",
                                    'update' => "Mengubah stok: $nama_barang ($jumlah_barang)",
                                    'delete' => "Menghapus stok: $nama_barang ($jumlah_barang)",
                                    default => ucfirst($b->action),
                                }
                            );

                            $isValid = \App\Services\BlockchainService::validateBlock($b);
                        @endphp

                        <tr>
                            <td>
                                <span class="hash-id">#{{ str_pad($b->id, 5, '0', STR_PAD_LEFT) }}</span>
                            </td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="bg-light rounded-circle p-2 me-2">
                                        <i class="bi bi-person text-secondary"></i>
                                    </div>
                                    <span class="fw-medium">{{ $actor }}</span>
                                </div>
                            </td>
                            <td>
                                <span class="badge {{ $actionClass }} px-3 py-2 rounded-pill">
                                    {{ ucfirst($b->action) }}
                                </span>
                            </td>
                            <td><span class="text-muted">{{ $keterangan }}</span></td>
                            <td>
                                <div class="text-dark fw-medium">{{ $b->created_at->format('d M Y') }}</div>
                                <div class="text-muted small">{{ $b->created_at->format('H:i') }} WIB</div>
                            </td>
                            <td>
                                @if($isValid)
                                    <span class="badge-valid"><i class="bi bi-check-circle-fill me-1"></i> Valid</span>
                                @else
                                    <span class="badge-invalid"><i class="bi bi-x-circle-fill me-1"></i> Invalid</span>
                                @endif
                            </td>
                            <td>
                                <button class="btn btn-sm btn-light text-primary border-0 rounded-circle p-2" data-bs-toggle="modal" data-bs-target="#blockDetail{{ $b->id }}" title="Lihat Detail">
                                    <i class="bi bi-arrow-right-short fs-5"></i>
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center py-5">
                                <i class="bi bi-box text-muted fs-1 mb-3 d-block"></i>
                                <span class="text-muted">Belum ada blok yang tercatat.</span>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        <div class="d-flex justify-content-center mt-4 border-top pt-4">
            {{ $blocks->links('pagination::bootstrap-5') }}
        </div>
    </div>

<!-- DETAIL MODAL -->
@foreach($blocks as $b)
    @php
        $isValid = \App\Services\BlockchainService::validateBlock($b);
    @endphp
    <div class="modal fade" id="blockDetail{{ $b->id }}" tabindex="-1">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content shadow-lg">
                <div class="modal-header modal-header-gradient">
                    <h5 class="modal-title fw-bold"><i class="bi bi-box me-2"></i> Rincian Blok #{{ str_pad($b->id, 5, '0', STR_PAD_LEFT) }}</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body p-4 bg-light">
                    
                    <!-- Info Header -->
                    <div class="row g-3 mb-4">
                        <div class="col-md-6">
                            <div class="bg-white p-3 rounded-3 border">
                                <small class="text-muted d-block mb-1">Aksi Transaksi</small>
                                <span class="fw-bold text-dark fs-5">{{ ucfirst($b->action) }}</span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="bg-white p-3 rounded-3 border">
                                <small class="text-muted d-block mb-1">Waktu Dibuat</small>
                                <span class="fw-bold text-dark fs-5">{{ $b->created_at->format('d M Y, H:i:s') }}</span>
                            </div>
                        </div>
                    </div>

                    <!-- Hash Info -->
                    <div class="bg-white p-3 rounded-3 border mb-4">
                        <div class="mb-3">
                            <small class="text-muted d-block mb-1 fw-medium"><i class="bi bi-link me-1"></i>Hash Sebelumnya (Previous Hash):</small>
                            <code class="d-block bg-light p-2 rounded text-break text-secondary" style="font-size:12px;">{{ $b->previous_hash }}</code>
                        </div>
                        <div>
                            <small class="text-muted d-block mb-1 fw-medium"><i class="bi bi-shield-lock me-1"></i>Hash Blok Ini:</small>
                            <code class="d-block bg-light p-2 rounded text-break text-dark fw-bold" style="font-size:12px;">{{ $b->hash }}</code>
                        </div>
                    </div>

                    <!-- Raw Data -->
                    <div class="mb-4">
                        <small class="text-muted d-block mb-2 fw-medium"><i class="bi bi-code-slash me-1"></i>Data Transaksi Mentah (Raw Data):</small>
                        <div class="json-block">
<pre class="m-0">{{ json_encode(json_decode($b->data, true), JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) }}</pre>
                        </div>
                    </div>

                    <!-- Validity Check -->
                    @if($isValid)
                        <div class="alert alert-success d-flex align-items-center mb-0 border-0 shadow-sm">
                            <i class="bi bi-shield-check fs-3 me-3"></i>
                            <div>
                                <h6 class="mb-0 fw-bold">Blok Valid & Aman</h6>
                                <small>Hash blok cocok dengan data transaksi dan hash sebelumnya.</small>
                            </div>
                        </div>
                    @else
                        <div class="alert alert-danger d-flex align-items-center mb-0 border-0 shadow-sm">
                            <i class="bi bi-shield-x fs-3 me-3"></i>
                            <div>
                                <h6 class="mb-0 fw-bold">Blok Terindikasi Dimanipulasi!</h6>
                                <small>Hash blok tidak cocok dengan isi data saat ini.</small>
                            </div>
                        </div>
                    @endif

                </div>
                <div class="modal-footer border-top-0 bg-light p-3">
                    <button type="button" class="btn btn-secondary rounded-pill px-4" data-bs-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>
@endforeach

</div>
</body>
</html>
