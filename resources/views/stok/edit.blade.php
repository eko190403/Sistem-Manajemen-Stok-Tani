@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h3>Edit Stok Barang</h3>

    <form action="{{ route('stok.update', $stok->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label>Nama Barang</label>
            <input type="text" name="nama_barang" class="form-control" value="{{ $stok->nama_barang }}" required>
        </div>

        <div class="mb-3">
            <label>Jumlah</label>
            <input type="number" name="jumlah" class="form-control" value="{{ $stok->jumlah }}" required>
        </div>

        <div class="mb-3">
            <label>Satuan</label>
            <select name="satuan" class="form-control" required>
                <option value="kg" {{ $stok->satuan=='kg' ? 'selected' : '' }}>kg</option>
                <option value="ton" {{ $stok->satuan=='ton' ? 'selected' : '' }}>ton</option>
                <option value="kuintal" {{ $stok->satuan=='kuintal' ? 'selected' : '' }}>kuintal</option>
            </select>
        </div>

        <div class="mb-3">
            <label>Harga</label>
            <input type="number" name="harga" class="form-control" value="{{ $stok->harga }}">
        </div>

        <div class="mb-3">
            <label>Jenis Transaksi</label>
            <select name="jenis" class="form-control" required>
                <option value="pemasukan" {{ $stok->jenis=='pemasukan' ? 'selected' : '' }}>Pemasukan</option>
                <option value="pengeluaran" {{ $stok->jenis=='pengeluaran' ? 'selected' : '' }}>Pengeluaran</option>
            </select>
        </div>

        <button type="submit" class="btn btn-success">Update</button>
        <a href="{{ route('stok.index') }}" class="btn btn-secondary">Kembali</a>
    </form>
</div>
@endsection
