<div class="d-flex justify-content-between align-items-center mb-3">
    <h3>Daftar Stok</h3>
    <button class="btn btn-primary"
        onclick="loadPage('/dashboard/content/stok_create')">
        ➕ Tambah Stok
    </button>
</div>

<table class="table table-striped">
    <thead>
        <tr>
            <th>#</th>
            <th>Nama Barang</th>
            <th>Nama Pemberi</th>
            <th>Jumlah</th>
            <th>Satuan</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        @foreach($stoks as $stok)
        <tr>
            <td>{{ $loop->iteration }}</td>
            <td>{{ $stok->nama_barang }}</td>
            <td>{{ $stok->nama_pemberi }}</td>
            <td>{{ $stok->jumlah }}</td>
            <td>{{ $stok->satuan }}</td>
            <td class="d-flex gap-1">

                <!-- ✅ EDIT (FIXED) -->
                <button
                    onclick="loadPage('/dashboard/content/stok_edit?id={{ $stok->id }}')"
                    class="btn btn-warning btn-sm">
                    ✏️ Edit
                </button>

                <!-- DELETE -->
                <form action="{{ route('stok.destroy', $stok->id) }}"
                    method="POST"
                    class="ajax-form">
                    @csrf
                    @method('DELETE')
                    <button class="btn btn-sm btn-danger" type="submit">
                        🗑 Hapus
                    </button>
                </form>

            </td>
        </tr>
        @endforeach
    </tbody>
</table>
