<h3 class="mb-3">✏️ Edit Stok: {{ $stok->nama_barang }}</h3>

<form id="formEditStok" action="{{ route('stok.update', $stok->id) }}" method="POST">
    @csrf
    @method('PUT')

    <div class="mb-3">
        <label>Nama Barang</label>
        <select name="nama_barang" class="form-control" required>
            <option value="">-- Pilih Barang --</option>
            @foreach($barangs as $barang)
                <option value="{{ $barang->nama_barang }}" @selected(old('nama_barang', $stok->nama_barang) == $barang->nama_barang)>
                    {{ $barang->nama_barang }}
                </option>
            @endforeach
        </select>
    </div>

    <div class="mb-3">
        <label>Pemasok / Penerima</label>
        <select name="nama_pemberi" class="form-control" required>
            <option value="">-- Pilih Pemasok/Penerima --</option>
            @foreach($petanis as $petani)
                <option value="{{ $petani->nama_petani }}" @selected(old('nama_pemberi', $stok->nama_pemberi) == $petani->nama_petani)>
                    {{ $petani->nama_petani }}
                </option>
            @endforeach
        </select>
    </div>

    <div class="mb-3">
        <label>Jumlah Asli</label>
        <input type="number" step="0.01" name="jumlah" class="form-control"
               value="{{ old('jumlah', optional($stok->keuangan)->jumlah_asli ?? '') }}" required>
    </div>

    <div class="mb-3">
        <label>Potongan (%)</label>
        <input type="number" step="0.01" name="potongan_persen" class="form-control"
               value="{{ old('potongan_persen', optional($stok->keuangan)->potongan_persen ?? 0) }}">
    </div>

    <div class="mb-3">
        <label>Satuan</label>
        <select name="satuan" class="form-control">
            <option value="kg"      @selected($stok->satuan_asli == 'kg')>Kg</option>
            <option value="ton"     @selected($stok->satuan_asli == 'ton')>Ton</option>
            <option value="kuintal" @selected($stok->satuan_asli == 'kuintal')>Kuintal</option>
        </select>
    </div>

    <div class="mb-3">
        <label>Jenis</label>
        <select name="jenis" class="form-control">
            <option value="pemasukan"   @selected($stok->jenis == 'pemasukan')>Pemasukan</option>
            <option value="pengeluaran" @selected($stok->jenis == 'pengeluaran')>Pengeluaran</option>
        </select>
    </div>

    <div class="mb-3">
        <label>Harga / Kg</label>
        <input type="number" name="harga" class="form-control"
               value="{{ old('harga', optional($stok->keuangan)->harga ?? '') }}" required>
    </div>

    <button type="submit" class="btn btn-primary">Update</button>
</form>
