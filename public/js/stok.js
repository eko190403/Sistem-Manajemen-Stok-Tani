document.addEventListener('submit', function (e) {
    if (e.target.id !== 'formTambahSaldo') return;
    e.preventDefault();
    const data = new FormData(e.target);
    // Reset error
    if (document.getElementById('jumlahSaldo')) document.getElementById('jumlahSaldo').classList.remove('is-invalid');
    if (document.getElementById('jumlahSaldoError')) document.getElementById('jumlahSaldoError').innerText = '';
    if (document.getElementById('keteranganSaldo')) document.getElementById('keteranganSaldo').classList.remove('is-invalid');
    if (document.getElementById('keteranganSaldoError')) document.getElementById('keteranganSaldoError').innerText = '';
    if (document.getElementById('saldoFormAlert')) document.getElementById('saldoFormAlert').innerHTML = '';
    axios.post('/keuangan/tambah-saldo', data)
        .then(res => {
            if (res.data.success) {
                if (document.getElementById('saldoFormAlert')) document.getElementById('saldoFormAlert').innerHTML = '<div class="alert alert-success">Saldo berhasil ditambah!';
                setTimeout(() => {
                    if (document.getElementById('modalTambahSaldo')) bootstrap.Modal.getOrCreateInstance(document.getElementById('modalTambahSaldo')).hide();
                    refreshSaldoSekarang();
                }, 1200);
            } else {
                if (document.getElementById('saldoFormAlert')) document.getElementById('saldoFormAlert').innerHTML = '<div class="alert alert-danger">'+(res.data.message || 'Gagal menambah saldo')+'</div>';
            }
        })
        .catch(err => {
            if (err.response && err.response.status === 422 && err.response.data && err.response.data.errors) {
                const errors = err.response.data.errors;
                if (errors.jumlah_saldo && document.getElementById('jumlahSaldo')) {
                    document.getElementById('jumlahSaldo').classList.add('is-invalid');
                    document.getElementById('jumlahSaldoError').innerText = errors.jumlah_saldo[0];
                }
                if (errors.keterangan_saldo && document.getElementById('keteranganSaldo')) {
                    document.getElementById('keteranganSaldo').classList.add('is-invalid');
                    document.getElementById('keteranganSaldoError').innerText = errors.keterangan_saldo[0];
                }
            } else {
                if (document.getElementById('saldoFormAlert')) document.getElementById('saldoFormAlert').innerHTML = '<div class="alert alert-danger">Terjadi kesalahan server</div>';
            }
        });
});

function refreshSaldoSekarang() {
    axios.get('/keuangan/fragment-saldo')
        .then(res => {
            if (res.data.saldoSekarang !== undefined) {
                document.getElementById('saldoSekarang').innerText = 'Rp ' + Number(res.data.saldoSekarang).toLocaleString('id-ID');
            }
        });
}
