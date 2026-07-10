<div class="modal-header">
    <h5 class="modal-title">Tambah Saldo</h5>
    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
</div>
<div class="modal-body">
    <form action="{{ route('keuangan.tambahSaldo') }}" method="POST" class="ajax-form">
        @csrf
        <div class="mb-3">
            <label>Jumlah Saldo (Rp)</label>
            <input type="number" step="0.01" name="jumlah_saldo" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Keterangan</label>
            <input type="text" name="keterangan_saldo" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-success w-100">Simpan</button>
    </form>
</div>
