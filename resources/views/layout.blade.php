<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Kelompok Tani')</title>

    <!-- CSS -->
    <link href="/vendor/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="/vendor/bootstrap-icons.css">

    <style>
        body {
            overflow-x: hidden;
            background: #F9FAFB;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            min-height: 100vh;
            padding-bottom: 40px;
            color: var(--text-main);
        }
        .container { max-width: 1200px; }

        /* Navbar */
        .main-navbar { box-shadow: 0 2px 8px rgba(0,0,0,0.1); }
        .main-navbar .nav-link { color: #fff; }
        .main-navbar .btn-danger { margin-left: 1rem; }

        /* AJAX content placeholder */
        #main-content { padding: 2rem; }

        @yield('custom_style')
    </style>

    <script src="/vendor/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>

<!-- NAVBAR -->
<nav class="main-navbar navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container-fluid">
        <a class="navbar-brand fw-bold" href="#"><span style="color:#ffd700;">🌾</span> Kelompok Tani</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNavbar">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="mainNavbar">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item"><a class="nav-link" href="javascript:void(0)" onclick="loadPage('overview')">🏠 Overview</a></li>
                <li class="nav-item"><a class="nav-link" href="javascript:void(0)" onclick="loadPage('stok')">📦 Stok</a></li>
                <li class="nav-item"><a class="nav-link" href="javascript:void(0)" onclick="loadPage('keuangan')">💰 Keuangan</a></li>
                <li class="nav-item"><a class="nav-link" href="javascript:void(0)" onclick="loadPage('blockchain')">⛓ Blockchain</a></li>
                @if(auth()->check() && auth()->user()->role === 'admin')
                <li class="nav-item"><a class="nav-link" href="javascript:void(0)" onclick="loadPage('users')">👥 Manajemen User</a></li>
                @endif
                <li class="nav-item"><a class="nav-link" href="javascript:void(0)" onclick="loadPage('profile')">👤 Profil</a></li>
            </ul>
            <form class="d-flex" action="{{ route('logout') }}" method="POST">
                @csrf
                <button class="btn btn-danger" type="submit">🚪 Logout</button>
            </form>
        </div>
    </div>
</nav>

<!-- AJAX CONTENT -->
<div id="main-content">
    @yield('content')
</div>

<!-- TOAST CONTAINER -->
<div id="toastContainer" style="position: fixed; top: 20px; right: 20px; z-index: 9999;"></div>

<script>
/* =================== TOAST =================== */
function showToast(message, type = 'info') {
    const container = document.getElementById('toastContainer');
    const toast = document.createElement('div');
    const icons = { success: '✅', error: '❌', warning: '⚠️', info: 'ℹ️' };
    toast.className = `toast-message ${type}`;
    toast.innerHTML = `<span class="toast-icon">${icons[type]}</span><div class="toast-content">${message}</div><button class="toast-close" onclick="this.parentElement.remove()">×</button>`;
    container.appendChild(toast);
    setTimeout(() => { if(toast.parentElement) toast.remove(); }, 4000);
}

/* =================== AJAX PAGE LOADER =================== */
function loadPage(target, id = null) {
    let url = target.startsWith('http') ? target : (id ? `/dashboard/content/${target}?id=${id}` : `/dashboard/content/${target}`);
    axios.get(url)
        .then(res => {
            document.getElementById('main-content').innerHTML = res.data;
            if (typeof initAfterLoad === 'function') initAfterLoad();
            showToast('Halaman dimuat', 'success');
        })
        .catch(err => {
            console.error(err);
            showToast('Gagal memuat halaman', 'error');
        });
}

/* =================== FIRST LOAD =================== */
document.addEventListener('DOMContentLoaded', () => { loadPage('overview'); });
</script>

@stack('scripts')
</body>
</html>
