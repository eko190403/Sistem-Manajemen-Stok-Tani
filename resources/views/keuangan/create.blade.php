@extends('layouts.app')

@section('content')
<h2>Tambah Transaksi</h2>
<form method="POST" action="{{ route('keuangan.store') }}">
    @csrf
    <div class="mb-3">
        <label>Tanggal</label>
        <input type="date" name="tanggal" class="form-control" required>
    </div>
    <div class="mb-3">
        <label>Barang</label>
        <select name="stok_id" class="form-control" required>
            @foreach($stok as $item)
                <option value="{{ $item->id }}">{{ $item->nama_barang }}</option>
            @endforeach
        </select>
    </div>
    <div class="mb-3">
        <label>Keterangan</label>
        <input type="text" name="keterangan" class="form-control" required>
    </div>
    <div class="mb-3">
        <label>Jenis</label>
        <select name="jenis" class="form-control" required>
            <option value="pemasukan">Pemasukan</option>
            <option value="pengeluaran">Pengeluaran</option>
        </select>
    </div>
    <div class="mb-3">
        <label>Jumlah</label>
        <input type="number" name="jumlah" class="form-control" required>
    </div>
    <div class="mb-3">
        <label>Harga Satuan</label>
        <input type="number" name="harga" class="form-control" required>
    </div>
    <div class="mb-3">
        <label>Potongan (%)</label>
        <input type="number" name="potongan_persen" class="form-control" value="0">
    </div>
    <button class="btn btn-success">Simpan</button>
</form>
@endsection
