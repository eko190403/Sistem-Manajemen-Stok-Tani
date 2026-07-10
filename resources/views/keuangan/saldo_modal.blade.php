<!-- Modal Tambah Saldo -->
<div class="modal fade" id="modalTambahSaldo" tabindex="-1" aria-labelledby="modalTambahSaldoLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalTambahSaldoLabel">Tambah Saldo</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form id="formTambahSaldo" method="POST" action="{{ route('keuangan.tambahSaldo') }}">
          @csrf
          <div class="mb-3">
            <label for="jumlahSaldo" class="form-label">Jumlah Saldo</label>
            <input type="number" class="form-control" id="jumlahSaldo" name="jumlah_saldo" required min="0">
            <div class="invalid-feedback" id="jumlahSaldoError"></div>
          </div>
          <div class="mb-3">
            <label for="keteranganSaldo" class="form-label">Keterangan</label>
            <input type="text" class="form-control" id="keteranganSaldo" name="keterangan_saldo" required maxlength="255">
            <div class="invalid-feedback" id="keteranganSaldoError"></div>
          </div>
          <div id="saldoFormAlert"></div>
          <button type="submit" class="btn btn-primary">Tambah Saldo</button>
        </form>
      </div>
    </div>
  </div>
</div>
