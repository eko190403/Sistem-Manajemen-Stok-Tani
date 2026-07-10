@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h3>Daftar Stok Barang</h3>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="mb-3">
        <a href="{{ route('stok.create') }}" class="btn btn-primary">Tambah Stok</a>
        <a href="{{ route('keuangan.index') }}" class="btn btn-success">Lihat Keuangan</a>
        <a href="{{ route('blocks.index') }}" class="btn btn-info">Lihat Blockchain</a>
    </div>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nama Barang</th>
                <th>Nama Pemberi</th>
                <th>Jumlah</th>
                <th>Satuan</th>
                <th>Harga</th>
                <th>Jenis Transaksi</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($stoks as $stok)
                <tr>
                    <td>{{ $stok->id }}</td>
                    <td>{{ $stok->nama_barang }}</td>
                    <td>{{ $stok->nama_pemberi }}</td>
                    <td>{{ $stok->jumlah }}</td>
                    <td>{{ $stok->satuan }}</td>
                    <td>
                        Rp {{ number_format($stok->harga, 0, ',', '.') }} / {{ $stok->satuan }} <br>
                        <small class="text-muted">
                            (Total: Rp {{ number_format($stok->jumlah * $stok->harga, 0, ',', '.') }})
                        </small>
                    </td>
                    <td>{{ ucfirst($stok->jenis) }}</td>
                    <td>
                        <a href="{{ route('stok.struk', $stok->id) }}" target="_blank" class="btn btn-secondary btn-sm" title="Cetak Struk">Print</a>
                        <a href="{{ route('stok.edit', $stok->id) }}" class="btn btn-warning btn-sm">Edit</a>
                        <form action="{{ route('stok.destroy', $stok->id) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-danger btn-sm" onclick="return confirm('Yakin hapus?')">Hapus</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <nav aria-label="Page navigation">
        <ul class="pagination justify-content-center">
            {{-- Tombol Prev --}}
            <li class="page-item {{ $stoks->onFirstPage() ? 'disabled' : '' }}">
                <a class="page-link" href="{{ $stoks->previousPageUrl() ?? '#' }}" tabindex="-1">Prev</a>
            </li>
            {{-- Nomor Halaman --}}
            @foreach ($stoks->getUrlRange(1, $stoks->lastPage()) as $page => $url)
                <li class="page-item {{ $page == $stoks->currentPage() ? 'active' : '' }}">
                    <a class="page-link" href="{{ $url }}">{{ $page }}</a>
                </li>
            @endforeach
            {{-- Tombol Next --}}
            <li class="page-item {{ !$stoks->hasMorePages() ? 'disabled' : '' }}">
                <a class="page-link" href="{{ $stoks->nextPageUrl() ?? '#' }}">Next</a>
            </li>
        </ul>
    </nav>
</div>
@endsection
