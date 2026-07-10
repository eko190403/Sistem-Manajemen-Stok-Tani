@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h3>📊 Laporan & Statistik</h3>

    {{-- Filter Tanggal --}}
    <form class="row g-2 mb-4" method="GET">
        <div class="col-md-3"><input type="date" name="startDate" class="form-control" value="{{ request('startDate') }}"></div>
        <div class="col-md-3"><input type="date" name="endDate" class="form-control" value="{{ request('endDate') }}"></div>
        <div class="col-md-2"><button type="submit" class="btn btn-primary">Tampilkan</button></div>
        <div class="col-md-2">
            <a href="{{ route('laporan.exportExcel', request()->all()) }}" class="btn btn-success">Export Excel</a>
        </div>
    </form>

    {{-- Ringkasan --}}
    <div class="row g-4 mb-4">
        <div class="col-md-4">
            <div class="glass-card p-3">
                <h5>Pemasukan</h5>
                <p>Rp {{ number_format($totalPemasukan ?? 0, 2, ',', '.') }}</p>
            </div>
        </div>
        <div class="col-md-4">
            <div class="glass-card p-3">
                <h5>Pengeluaran</h5>
                <p>Rp {{ number_format($totalPengeluaran ?? 0, 2, ',', '.') }}</p>
            </div>
        </div>
        <div class="col-md-4">
            <div class="glass-card p-3">
                <h5>Saldo</h5>
                <p>Rp {{ number_format($saldo ?? 0, 2, ',', '.') }}</p>
            </div>
        </div>
    </div>

    {{-- Grafik --}}
    <div class="glass-card p-3 mb-4">
        <h5>Grafik Keuangan</h5>
        <canvas id="chartKeuangan"></canvas>
    </div>

    {{-- Tabel Detail --}}
    <div class="glass-card p-3">
        <h5>Detail Transaksi</h5>
        <table class="table table-hover">
            <thead>
                <tr>
                    <th>Tanggal</th>
                    <th>Nama Barang</th>
                    <th>Jumlah</th>
                    <th>Harga</th>
                    <th>Jenis</th>
                    <th>Keterangan</th>
                </tr>
            </thead>
            <tbody>
                @forelse($transaksi as $t)
                    <tr>
                        <td>{{ $t->created_at->format('d-m-Y') }}</td>
                        <td>{{ $t->stok->nama_barang ?? '-' }}</td>
                        <td>{{ $t->jumlah }}</td>
                        <td>Rp {{ number_format($t->harga ?? 0,2,',','.') }}</td>
                        <td>{{ ucfirst($t->jenis) }}</td>
                        <td>{{ $t->keterangan }}</td>
                    </tr>
                @empty
                    <tr><td colspan="6" class="text-center py-3">Tidak ada transaksi</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
const ctx = document.getElementById('chartKeuangan').getContext('2d');
new Chart(ctx, {
    type: 'bar',
    data: {
        labels: {!! json_encode($chartLabels) !!},
        datasets: [
            {
                label: 'Pemasukan',
                data: {!! json_encode(array_values($chartPemasukan)) !!},
                backgroundColor: 'rgba(40, 167, 69, 0.6)'
            },
            {
                label: 'Pengeluaran',
                data: {!! json_encode(array_values($chartPengeluaran)) !!},
                backgroundColor: 'rgba(220, 53, 69, 0.6)'
            }
        ]
    },
    options: {
        responsive: true,
        scales: {
            y: { beginAtZero: true }
        }
    }
});
</script>
@endsection
