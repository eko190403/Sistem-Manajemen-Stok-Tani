@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h3 class="mb-4">➕ Tambah Stok (Transaksi)</h3>

    <form id="formStok">
        @csrf

        <div class="mb-3">
            <label class="form-label">Nama Barang</label>
            <input type="text" name="nama_barang" class="form-control" required>
        </div>

        <div class="row">
            <div class="col-md-6 mb-3">
                <label class="form-label">Jumlah Asli (Kg)</label>
                <input type="number" name="jumlah_asli" id="jumlah_asli"
                       step="0.01" class="form-control" required>
            </div>

            <div class="col-md-6 mb-3">
                <label class="form-label">Potongan Kualitas (%)</label>
                <input type="number" name="potongan_persen" id="potongan"
                       step="0.01" min="0" max="100"
                       class="form-control" value="0">
            </div>
        </div>

        <div class="mb-3">
            <label class="form-label">Harga per Kg</label>
            <input type="number" name="harga" id="harga"
                   step="0.01" class="form-control" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Jenis Transaksi</label>
            <select name="jenis" class="form-select" required>
                <option value="pemasukan">Pemasukan</option>
                <option value="pengeluaran">Pengeluaran</option>
            </select>
        </div>

        <!-- PREVIEW HITUNGAN -->
        <div class="alert alert-info" id="previewBox">
            Jumlah bersih: <strong>-</strong><br>
            Total uang: <strong>-</strong>
        </div>

        <button type="submit" class="btn btn-success px-4">
            💾 Simpan Transaksi
        </button>
    </form>
</div>

<script>
const jumlahInput   = document.getElementById('jumlah_asli');
const potonganInput = document.getElementById('potongan');
const hargaInput    = document.getElementById('harga');
const previewBox    = document.getElementById('previewBox');
const formStok      = document.getElementById('formStok');

function formatRupiah(number) {
    return 'Rp ' + Number(number).toLocaleString('id-ID', { minimumFractionDigits: 2, maximumFractionDigits: 2 });
}

function updatePreview() {
    const jumlah   = parseFloat(jumlahInput.value) || 0;
    const potongan = parseFloat(potonganInput.value) || 0;
    const harga    = parseFloat(hargaInput.value) || 0;

    if (jumlah <= 0) {
        previewBox.innerHTML = 'Jumlah bersih: <strong>-</strong>';
        return;
    }

    const jumlahBersih = jumlah - (jumlah * potongan / 100);
    const totalUang = jumlahBersih * harga;

    previewBox.innerHTML = `
        Jumlah bersih: <strong>${jumlahBersih.toFixed(2)} kg</strong><br>
        Total uang: <strong>${formatRupiah(totalUang)}</strong>
    `;
}

[jumlahInput, potonganInput, hargaInput].forEach(el =>
    el.addEventListener('input', updatePreview)
);

// ================================
// AJAX SUBMIT
// ================================
formStok.addEventListener('submit', function(e) {
    e.preventDefault();

    const formData = new FormData(this);
    
    axios.post("{{ route('stok.store') }}", formData)
        .then(res => {
            alert(res.data.message);
            this.reset();
            updatePreview(); // reset preview
        })
        .catch(err => {
            if (err.response && err.response.data && err.response.data.errors) {
                const errors = Object.values(err.response.data.errors).flat();
                alert(errors.join("\n"));
            } else {
                alert('Terjadi kesalahan, silakan coba lagi.');
            }
        });
});
</script>
@endsection
