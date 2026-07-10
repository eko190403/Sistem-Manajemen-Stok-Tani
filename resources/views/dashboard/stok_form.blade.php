<div class="modal-header">
    <h5 class="modal-title">{{ $stok->id ? 'Edit Stok' : 'Tambah Stok' }}</h5>
    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
</div>

<div class="modal-body">
    <form action="{{ $stok->id ? route('stok.update', $stok->id) : route('stok.store') }}"
          method="POST" class="ajax-form">

        @csrf
        @if($stok->id)
            @method('PUT')
        @endif

        <div class="mb-3">
            <label>Nama Barang</label>
            <input type="text" name="nama_barang" class="form-control"
                   value="{{ $stok->nama_barang ?? '' }}" required>
        </div>

        <div class="mb-3">
            <label>Jumlah</label>
            <input type="number" step="0.01" name="jumlah" class="form-control"
                   value="{{ $stok->jumlah ?? '' }}" required>
        </div>

        <div class="mb-3">
            <label>Satuan</label>
            <select name="satuan" class="form-control">
                <option value="kg" {{ ($stok->satuan ?? '') == 'kg' ? 'selected' : '' }}>Kg</option>
                <option value="ton" {{ ($stok->satuan ?? '') == 'ton' ? 'selected' : '' }}>Ton</option>
                <option value="buah" {{ ($stok->satuan ?? '') == 'buah' ? 'selected' : '' }}>Buah</option>
            </select>
        </div>

        <div class="mb-3">
            <label>Jenis Transaksi</label>
            <select name="jenis" class="form-control" required>
                <option value="pemasukan" {{ ($stok->jenis ?? '') == 'pemasukan' ? 'selected' : '' }}>Pemasukan</option>
                <option value="pengeluaran" {{ ($stok->jenis ?? '') == 'pengeluaran' ? 'selected' : '' }}>Pengeluaran</option>
            </select>
        </div>

        <div class="mb-3">
            <label>Harga Satuan</label>
            <input type="number" step="0.01" name="harga" class="form-control"
                   value="{{ $stok->harga ?? '' }}" required>
        </div>

        <button type="submit" class="btn btn-success w-100">
            {{ $stok->id ? 'Update' : 'Simpan' }}
        </button>
    </form>
</div>
