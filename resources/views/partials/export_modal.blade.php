<!-- Modal Export Laporan -->
<div class="modal fade" id="{{ $modalId ?? 'modalExport' }}" tabindex="-1" aria-labelledby="{{ $modalId ?? 'modalExport' }}Label" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg" style="border-radius: 16px; overflow: hidden;">
            <div class="modal-header text-white" style="background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%); border-bottom: none;">
                <h5 class="modal-title fw-bold" id="{{ $modalId ?? 'modalExport' }}Label"><i class="bi bi-file-earmark-excel me-2"></i> {{ $modalTitle ?? 'Download Laporan Excel' }}</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ $exportRoute ?? route('laporan.export') }}" method="GET">
                <div class="modal-body p-4">
                    <p class="text-muted small mb-4">Pilih rentang waktu data yang ingin Anda unduh.</p>
                    
                    @php $uniqueSuffix = $modalId ?? 'export'; @endphp
                    
                    <div class="mb-3">
                        <label class="form-label fw-semibold text-dark">Pilih Filter Waktu</label>
                        <select name="filterType" id="exportFilterType_{{ $uniqueSuffix }}" class="form-select" onchange="toggleExportInputs_{{ $uniqueSuffix }}()">
                            <option value="semua">Semua Waktu (Seluruh Data)</option>
                            <option value="bulan" selected>Bulan Ini</option>
                            <option value="tahun">Tahun Ini</option>
                            <option value="rentang">Rentang Tanggal Khusus</option>
                        </select>
                    </div>

                    <!-- Input Bulan -->
                    <div class="mb-3" id="exportInputMonth_{{ $uniqueSuffix }}" style="display: block;">
                        <label class="form-label fw-semibold text-dark">Bulan</label>
                        <select name="month" class="form-select">
                            @foreach(['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'] as $i => $m)
                                <option value="{{ $i+1 }}" {{ ($i+1) == date('n') ? 'selected' : '' }}>{{ $m }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Input Tahun (muncul di filter bulan dan tahun) -->
                    <div class="mb-3" id="exportInputYear_{{ $uniqueSuffix }}" style="display: block;">
                        <label class="form-label fw-semibold text-dark">Tahun</label>
                        <select name="year" class="form-select">
                            @for($y = date('Y')-5; $y <= date('Y'); $y++)
                                <option value="{{ $y }}" {{ $y == date('Y') ? 'selected' : '' }}>{{ $y }}</option>
                            @endfor
                        </select>
                    </div>

                    <!-- Input Rentang Tanggal -->
                    <div class="row g-2 mb-3" id="exportInputDate_{{ $uniqueSuffix }}" style="display: none;">
                        <div class="col-6">
                            <label class="form-label fw-semibold text-dark">Dari Tanggal</label>
                            <input type="date" name="startDate" class="form-control" value="{{ date('Y-m-01') }}">
                        </div>
                        <div class="col-6">
                            <label class="form-label fw-semibold text-dark">Sampai Tanggal</label>
                            <input type="date" name="endDate" class="form-control" value="{{ date('Y-m-t') }}">
                        </div>
                    </div>
                </div>
                <div class="modal-footer bg-light" style="border-top: 1px solid #f1f5f9;">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary" style="background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%); border: none; font-weight: 600;">
                        <i class="bi bi-download me-1"></i> Download Excel
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function toggleExportInputs_{{ $uniqueSuffix }}() {
    const type = document.getElementById('exportFilterType_{{ $uniqueSuffix }}').value;
    
    document.getElementById('exportInputMonth_{{ $uniqueSuffix }}').style.display = (type === 'bulan') ? 'block' : 'none';
    
    document.getElementById('exportInputYear_{{ $uniqueSuffix }}').style.display = (type === 'bulan' || type === 'tahun') ? 'block' : 'none';
    
    document.getElementById('exportInputDate_{{ $uniqueSuffix }}').style.display = (type === 'rentang') ? 'flex' : 'none';
}
</script>
