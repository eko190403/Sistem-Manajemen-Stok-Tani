@extends('layouts.app')

@section('content')
<div class="card p-4">

    {{-- HEADER + BUTTON --}}
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3 class="m-0">⛓ Daftar Blockchain</h3>

        <a href="{{ url('/blockchain/validate') }}"
           class="btn btn-success btn-sm">
            🔍 Validasi Blockchain
        </a>
    </div>

    {{-- TABLE --}}
    <div class="table-responsive mt-3">
        <table class="table table-bordered table-hover">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Barang</th>
                    <th>Aksi</th>
                    <th>Jumlah</th>
                    <th>Satuan</th>
                    <th>Keterangan</th>
                    <th>Waktu</th>
                </tr>
            </thead>

            <tbody>
                @foreach($blocks as $b)
                    @php
                        $d = json_decode($b->data, true);
                        $nama   = $d['nama_barang'] ?? '-';
                        $jumlah = $d['jumlah'] ?? '-';
                        $satuan = $d['satuan'] ?? '-';

                        $ket = match($b->action) {
                            'create' => "Menambah stok $nama ($jumlah $satuan)",
                            'update' => "Mengupdate $nama ($jumlah $satuan)",
                            'delete' => "Menghapus $nama",
                            default  => ucfirst($b->action)
                        };
                    @endphp

                    <tr>
                        <td>{{ $b->id }}</td>
                        <td>{{ $nama }}</td>
                        <td>{{ ucfirst($b->action) }}</td>
                        <td>{{ $jumlah }}</td>
                        <td>{{ $satuan }}</td>
                        <td>{{ $ket }}</td>
                        <td>{{ $b->created_at->format('d-m-Y H:i') }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    {{-- PAGINATION --}}
    <div class="mt-3">
        {!! $blocks->links('pagination.dashboard') !!}
    </div>

</div>
@endsection
