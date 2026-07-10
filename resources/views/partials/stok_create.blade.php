<h3 class="mb-4">📦 Tambah Stok Baru</h3>

<form action="{{ route('stok.store') }}" method="POST" class="ajax-form" id="formStok">
    @csrf

    <div class="row">
        <div class="col-md-6 mb-3">
            <label class="form-label text-muted small fw-bold">NAMA BARANG</label>
            <select name="nama_barang" class="form-control" required>
                <option value="">-- Pilih Barang --</option>
                @foreach($barangs as $barang)
                    <option value="{{ $barang->nama_barang }}">{{ $barang->nama_barang }}</option>
                @endforeach
            </select>
        </div>

        <div class="col-md-6 mb-3">
            <label class="form-label text-muted small fw-bold">PEMASOK / PENERIMA</label>
            <select name="nama_pemberi" class="form-control" required>
                <option value="">-- Pilih Pemasok/Penerima --</option>
                @foreach($petanis as $petani)
                    <option value="{{ $petani->nama_petani }}">{{ $petani->nama_petani }}</option>
                @endforeach
            </select>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6 mb-3">
            <label class="form-label">Jumlah Barang</label>
            <div class="input-group">
                <input type="number" name="jumlah_asli" step="0.01" class="form-control" id="jumlah_asli" required>
                <select name="satuan" class="form-select" id="satuan" style="max-width: 100px;" required>
                    <option value="kg">Kg</option>
                    <option value="ton">Ton</option>
                    <option value="kuintal">Kuintal</option>
                </select>
            </div>
        </div>
        <div class="col-md-6 mb-3">
            <label class="form-label">Potongan (%)</label>
            <input type="number" name="potongan_persen" step="0.01" min="0" max="100"
                   class="form-control" id="potongan" placeholder="Contoh: 30" value="0">
        </div>
    </div>

    <div class="mb-3">
        <label class="form-label">Jenis</label>
        <select name="jenis" class="form-control" required>
            <option value="pemasukan">Pemasukan</option>
            <option value="pengeluaran">Pengeluaran</option>
        </select>
    </div>

    <div class="mb-3">
        <label class="form-label">Harga / Kg</label>
        <input type="number" name="harga" step="0.01" class="form-control" required>
    </div>

    {{-- PREVIEW --}}
    <div class="alert alert-info small" id="previewBox">
        Jumlah akhir: <strong>-</strong>
    </div>
                                
    ```````````````````````````````````````````````````````````````````````````
    <button type="submit" class="btn btn-primary btn-modern">💾 Simpan</button>
</form>

<script>
const jumlahInput   = document.getElementById('jumlah_asli');
const potonganInput = document.getElementById('potongan');
const satuanInput   = document.getElementById('satuan');
const previewBox    = document.getElementById('previewBox');

function toKg(jumlah, satuan) {
    if (satuan === 'ton') return jumlah * 1000;
    if (satuan === 'kuintal') return jumlah * 100;
    return jumlah;
}

function updatePreview() {
    const jumlah   = parseFloat(jumlahInput.value) || 0;
    const potongan = parseFloat(potonganInput.value) || 0;
    const satuan   = satuanInput.value;

    if (jumlah <= 0) {
        previewBox.innerHTML = 'Jumlah akhir: <strong>-</strong>';
        return;
    }
    if (potongan < 0 || potongan > 100) {
        previewBox.innerHTML = '<strong>Potongan harus antara 0 - 100%</strong>';
        return;
    }

    const setelahPotongan = jumlah - (jumlah * potongan / 100);
    const kg = toKg(setelahPotongan, satuan);

    previewBox.innerHTML = `
        Jumlah asli: <strong>${jumlah} ${satuan}</strong><br>
        Setelah potongan: <strong>${setelahPotongan.toFixed(2)} ${satuan}</strong><br>
        Konversi ke kg: <strong>${kg.toFixed(2)} kg</strong>
    `;
}

[jumlahInput, potonganInput, satuanInput].forEach(el =>
    el.addEventListener('input', updatePreview)
);

// ================= AJAX SUBMIT =================
document.querySelector('#formStok').addEventListener('submit', async function(e) {
    e.preventDefault();
    const formData = new FormData(this);

    // Validasi frontend
    const jumlah = parseFloat(jumlahInput.value) || 0;
    const potongan = parseFloat(potonganInput.value) || 0;
    if (jumlah <= 0) return showToast('Jumlah harus lebih dari 0', 'error');
    if (potongan < 0 || potongan > 100) return showToast('Potongan harus antara 0 - 100%', 'error');

    try {
        const res = await axios.post(this.action, formData);
        if(res.data.success){
            showToast('Stok berhasil ditambahkan!', 'success');
            loadPage('keuangan');
        } else {
            showToast(res.data.message || 'Gagal menambah stok!', 'error');
        }
    } catch (err) {
        if (err.response?.status === 422) {
            let pesan = 'Gagal menyimpan:<br>';
            for (const key in err.response.data.errors) {
                pesan += '- ' + err.response.data.errors[key][0] + '<br>';
            }
            showToast(pesan, 'error');
        } else {
            showToast('Terjadi kesalahan sistem!', 'error');
        }
    }
});

// init preview
updatePreview();
</script>
