<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        .glass-card {
            background: rgba(255, 255, 255, 0.15);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.3);
            border-radius: 18px;
            box-shadow: 0 4px 30px rgba(0,0,0,0.1);
            padding: 20px;
        }
        .fade-in {
            animation: fadeIn 0.6s ease-out forwards;
            opacity: 0;
        }
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }
        #sidebar { min-width: 220px; }
        #main-content { flex: 1; padding: 20px; }
        .sidebar-link { cursor: pointer; }
    </style>
</head>

<body>
<div class="d-flex">

    <!-- SIDEBAR -->
    <div id="sidebar" class="bg-dark text-white p-3">
        <h4 class="mb-4">Dashboard Admin</h4>
        <ul class="list-unstyled">
            <li class="mb-2"><span class="sidebar-link" onclick="loadPage('overview')">🏠 Overview</span></li>
            <li class="mb-2"><span class="sidebar-link" onclick="loadPage('stok')">📦 Stok</span></li>
            <li class="mb-2"><span class="sidebar-link" onclick="loadPage('keuangan')">💰 Keuangan</span></li>
            <li class="mb-2"><span class="sidebar-link" onclick="loadPage('blockchain')">⛓ Blockchain</span></li>
            <li class="mb-2"><a class="text-white text-decoration-none" href="{{ route('profile.show') }}" onclick="event.preventDefault(); loadProfile();">👤 Profil</a></li>
            <li class="mt-4">
                <a href="{{ route('logout') }}"
                   onclick="event.preventDefault();document.getElementById('logout-form').submit();"
                   class="text-white">Logout</a>
            </li>
        </ul>
        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">@csrf</form>
    </div>

    <!-- MAIN -->
    <div id="main-content">
        <p>Loading...</p>
    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
/* =============================
   LOAD PAGE (ANTI DOUBLE)
============================= */
function loadPage(page) {
    axios.get(`/dashboard/content/${page}`)
        .then(res => {
            const main = document.getElementById('main-content');
            main.innerHTML = res.data;
            initChart();
        })
        .catch(() => {
            document.getElementById('main-content').innerHTML =
                '<div class="alert alert-danger">Gagal memuat halaman</div>';
        });
}

function loadProfile() {
    axios.get('{{ route('profile.show') }}')
        .then(res => {
            document.getElementById('main-content').innerHTML = res.data;
        })
        .catch(() => {
            document.getElementById('main-content').innerHTML = '<div class="alert alert-danger">Gagal memuat profil</div>';
        });
}

document.addEventListener('DOMContentLoaded', () => {
    loadPage('overview');
});

/* =============================
   GLOBAL AJAX FORM (TIDAK PINDAH)
============================= */
document.addEventListener('submit', function(e) {

    if (!e.target.classList.contains('ajax-form')) return;

    e.preventDefault();
    const form = e.target;

    form.querySelectorAll('.alert').forEach(a => a.remove());

    const btn = form.querySelector('button[type="submit"]');
    const text = btn.innerHTML;
    btn.disabled = true;
    btn.innerHTML = 'Menyimpan...';

    axios({
        method: form.method,
        url: form.action,
        data: new FormData(form)
    })
    .then(res => {
        const alert = document.createElement('div');
        alert.className = 'alert alert-success mb-3';
        alert.innerHTML = '✔ ' + (res.data.message || 'Berhasil');
        form.prepend(alert);

        // reset jika TAMBAH
        if (!form.querySelector('input[name="_method"]')) {
            form.reset();
        }

        setTimeout(() => alert.remove(), 2000);
    })
    .catch(err => {
        const alert = document.createElement('div');
        alert.className = 'alert alert-danger mb-3';
        alert.innerHTML = err.response?.data?.message || 'Terjadi kesalahan';
        form.prepend(alert);
    })
    .finally(() => {
        btn.disabled = false;
        btn.innerHTML = text;
    });
});

/* =============================
   PAGINATION AJAX
============================= */
document.addEventListener('click', function(e) {
    const link = e.target.closest('.pagination a');
    if (!link) return;

    e.preventDefault();
    axios.get(link.href).then(res => {
        document.getElementById('main-content').innerHTML = res.data;
        window.scrollTo(0,0);
    });
});

/* =============================
   CHART INIT (ANTI DUPLIKASI)
============================= */
let chartInstance = null;
function initChart() {
    const canvas = document.getElementById('grafikKeuangan');
    if (!canvas) return;

    if (chartInstance) chartInstance.destroy();

    axios.get('{{ route("keuangan.grafik") }}').then(res => {
        chartInstance = new Chart(canvas, {
            type: 'line',
            data: {
                labels: res.data.labels,
                datasets: [
                    { label: 'Pemasukan', data: res.data.pemasukan, tension: 0.4 },
                    { label: 'Pengeluaran', data: res.data.pengeluaran, tension: 0.4 }
                ]
            },
            options: { responsive: true }
        });
    });
}
</script>

@stack('scripts')
</body>
</html>
