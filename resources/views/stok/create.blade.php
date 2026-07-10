@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h3>Tambah Stok Barang</h3>

    <form action="{{ route('stok.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label>Nama Barang</label>
            <input type="text" name="nama_barang" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Nama Pemberi</label>
            <input type="text" name="nama_pemberi" class="form-control" placeholder="Masukkan nama pemberi stok" required>
        </div>
        <div class="mb-3">
            <label>Jumlah</label>
            <input type="number" name="jumlah" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Satuan</label>
            <select name="satuan" class="form-control" required>
                <option value="kg">kg</option>
                <option value="ton">ton</option>
                <option value="kuintal">kuintal</option>
            </select>
        </div>
        <div class="mb-3">
            <label>Harga</label>
            <input type="number" name="harga" class="form-control">
        </div>
        <div class="mb-3">
            <label>Jenis Transaksi</label>
            <select name="jenis" class="form-control" required>
                <option value="pemasukan">Pemasukan</option>
                <option value="pengeluaran">Pengeluaran</option>
            </select>
        </div>
        <button type="submit" class="btn btn-success">Simpan</button>
        <a href="{{ route('stok.index') }}" class="btn btn-secondary">Kembali</a>
    </form>
</div>
@endsection
