<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="csrf-token" content="{{ csrf_token() }}">
<title>Dashboard Admin</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">

<style>
    :root {
        --bg-main: #f8fafc;
        --bg-sidebar: #0f172a;
        --text-sidebar: #e2e8f0;
        --text-main: #1e293b;
        --bg-card: #ffffff;
        --border-color: #f1f5f9;
        --text-muted: #64748b;
    }

    [data-theme="dark"] {
        --bg-main: #121212;
        --bg-sidebar: #1e1e1e;
        --text-sidebar: #e0e0e0;
        --text-main: #f8fafc;
        --bg-card: #1e1e1e;
        --border-color: #333333;
        --text-muted: #a0aec0;
    }

    body { 
        min-height: 100vh;
        overflow-x: hidden;
        background-color: var(--bg-main);
        color: var(--text-main);
        transition: background-color 0.3s ease, color 0.3s ease;
    }

    .glass-card, .stat-card, .modal-content, .card, .table-responsive {
        background-color: var(--bg-card) !important;
        border-color: var(--border-color) !important;
        color: var(--text-main) !important;
    }

    .table {
        color: var(--text-main);
    }
    .table-modern th, .table-light {
        background-color: var(--bg-main) !important;
        color: var(--text-main) !important;
        border-color: var(--border-color) !important;
    }

    [data-theme="dark"] .bg-white,
    [data-theme="dark"] .bg-light {
        background-color: var(--bg-card) !important;
    }

    [data-theme="dark"] .text-dark {
        color: var(--text-main) !important;
    }

    [data-theme="dark"] .border,
    [data-theme="dark"] .border-bottom,
    [data-theme="dark"] .border-top,
    [data-theme="dark"] hr {
        border-color: var(--border-color) !important;
    }

    [data-theme="dark"] input.bg-light,
    [data-theme="dark"] select.bg-light,
    [data-theme="dark"] textarea.bg-light,
    [data-theme="dark"] input.form-control,
    [data-theme="dark"] select.form-select,
    [data-theme="dark"] select.form-control,
    [data-theme="dark"] textarea.form-control {
        background-color: #2d2d2d !important;
        border-color: var(--border-color) !important;
        color: var(--text-main) !important;
    }

    [data-theme="dark"] input.form-control:focus,
    [data-theme="dark"] select.form-select:focus,
    [data-theme="dark"] select.form-control:focus,
    [data-theme="dark"] textarea.form-control:focus {
        background-color: #333 !important;
        color: var(--text-main) !important;
    }

    [data-theme="dark"] .modal-header,
    [data-theme="dark"] .modal-footer,
    [data-theme="dark"] .modal-body {
        background-color: var(--bg-card) !important;
        border-color: var(--border-color) !important;
    }

    [data-theme="dark"] .text-muted {
        color: var(--text-muted) !important;
    }

    [data-theme="dark"] .btn-light {
        background-color: #333 !important;
        color: var(--text-main) !important;
        border-color: var(--border-color) !important;
    }

    [data-theme="dark"] .btn-light:hover {
        background-color: #444 !important;
        color: #fff !important;
    }
    
    [data-theme="dark"] .alert-warning {
        background-color: rgba(245, 158, 11, 0.1) !important;
        color: #fcd34d !important;
        border-color: rgba(245, 158, 11, 0.2) !important;
    }
    
    [data-theme="dark"] .alert-info {
        background-color: rgba(59, 130, 246, 0.1) !important;
        color: #93c5fd !important;
        border-color: rgba(59, 130, 246, 0.2) !important;
    }

    .sidebar { 
        min-height: 100vh; 
        background-color: var(--bg-sidebar); 
        color: var(--text-sidebar);
        border-right: 1px solid var(--border-color);
        transition: background-color 0.3s ease;
    }

    .sidebar a { 
        color: #94a3b8; 
        text-decoration: none;
        transition: all 0.2s ease;
        display: flex;
        align-items: center;
        padding: 10px 12px;
        border-radius: 8px;
        font-weight: 500;
        font-size: 0.95rem;
    }

    .sidebar a i {
        margin-right: 10px;
        font-size: 1.1rem;
    }

    .sidebar a:hover, .sidebar a.active { 
        background: rgba(255, 255, 255, 0.05);
        color: #ffffff;
    }

    .main-content { 
        flex: 1; 
        padding: 20px; 
    }

    /* Responsive untuk tablet dan mobile */
    @media (max-width: 768px) {
        .main-wrapper {
            flex-direction: column;
        }

        .sidebar {
            width: 100% !important;
            min-height: auto;
            position: sticky;
            top: 0;
            z-index: 100;
            padding: 0.75rem !important;
            border-bottom: 2px solid rgba(255,255,255,0.2);
        }

        .sidebar h4 {
            font-size: 1rem;
            margin-bottom: 0.5rem !important;
        }

        .sidebar-menu-collapse {
            display: none;
            width: 100%;
            animation: fadeIn 0.3s ease;
        }

        .sidebar-menu-collapse.show {
            display: block;
        }

        .sidebar ul {
            display: flex;
            flex-direction: column;
            gap: 0.25rem;
            align-items: stretch;
            padding-bottom: 10px;
        }

        .sidebar li {
            margin-bottom: 0 !important;
            width: 100%;
        }

        .sidebar a {
            font-size: 0.9rem;
            padding: 0.75rem 1rem;
            display: block;
            border-radius: 8px;
        }

        .main-content {
            padding: 1rem !important;
        }

        .navbar-nav {
            flex-direction: row !important;
        }

        .modal-lg {
            max-width: 95% !important;
        }
    }

    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(-10px); }
        to { opacity: 1; transform: translateY(0); }
    }

    /* Extra small devices */
    @media (max-width: 575px) {
        .sidebar {
            padding: 0.5rem !important;
        }

        .sidebar h4 {
            font-size: 0.85rem;
        }

        .sidebar a {
            font-size: 0.75rem;
            padding: 0.3rem 0.5rem;
        }

        .main-content {
            padding: 0.5rem !important;
        }
    }
</style>
</head>

<body>

<div class="d-flex main-wrapper">

    <!-- SIDEBAR -->
    <div class="sidebar p-4 w-md-100">
        <div class="d-flex align-items-center justify-content-between mb-4">
            <div class="d-flex align-items-center">
                <i class="bi bi-box-seam text-primary fs-4 me-2"></i>
                <h5 class="mb-0 fw-bold text-white tracking-wide" style="letter-spacing: -0.5px;">Dashboard</h5>
            </div>
            <button class="btn btn-outline-light d-md-none border-0" id="mobileMenuToggle" style="background: rgba(255,255,255,0.1);">
                <i class="bi bi-list fs-4"></i>
            </button>
        </div>
        
        <div id="sidebarMenu" class="sidebar-menu-collapse d-md-block">
            <div class="text-xs fw-semibold text-uppercase text-muted mb-3 mt-4 px-2" style="font-size: 0.75rem; letter-spacing: 1px; color: #64748b !important;">Menu Utama</div>
            <ul class="list-unstyled">
                <li class="mb-1"><a href="#" onclick="loadPage('overview')"><i class="bi bi-grid-1x2"></i> Overview</a></li>
                <li class="mb-1"><a href="#" onclick="loadPage('stok')"><i class="bi bi-box2"></i> Stok</a></li>
                <li class="mb-1"><a href="#" onclick="loadPage('keuangan')"><i class="bi bi-wallet2"></i> Keuangan</a></li>
                <li class="mb-1"><a href="#" onclick="loadPage('blockchain')"><i class="bi bi-diagram-3"></i> Blockchain</a></li>
                @if(auth()->check() && auth()->user()->role === 'admin')
                <li class="mt-4 mb-1 px-2 text-xs fw-semibold text-uppercase text-muted" style="font-size: 0.75rem; letter-spacing: 1px; color: #64748b !important;">Master Data</li>
                <li class="mb-1"><a href="#" onclick="loadPage('master_barang')"><i class="bi bi-box"></i> Master Barang</a></li>
                <li class="mb-1"><a href="#" onclick="loadPage('master_petani')"><i class="bi bi-person-lines-fill"></i> Master Petani</a></li>
                <li class="mb-1"><a href="#" onclick="loadPage('users')"><i class="bi bi-people"></i> Manajemen User</a></li>
                <li class="mb-1"><a href="#" onclick="loadPage('activity_logs')"><i class="bi bi-clock-history"></i> Log Aktivitas</a></li>
                @endif
                <li class="mt-4 mb-1 px-2 text-xs fw-semibold text-uppercase text-muted" style="font-size: 0.75rem; letter-spacing: 1px; color: #64748b !important;">Akun</li>
                <li class="mb-1"><a href="#" onclick="loadProfile()"><i class="bi bi-person"></i> Profil</a></li>
                <li class="mt-4 mb-1 px-2 text-xs fw-semibold text-uppercase text-muted" style="font-size: 0.75rem; letter-spacing: 1px; color: #64748b !important;">Pengaturan</li>
                <li class="mb-1">
                    <a href="#" onclick="toggleDarkMode()">
                        <i class="bi bi-moon-stars" id="darkModeIcon"></i> <span id="darkModeText">Dark Mode</span>
                    </a>
                </li>
                <li class="mt-3 px-2">
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button class="btn btn-outline-danger w-100 btn-sm text-start" style="padding: 10px 12px; border-color: rgba(239, 68, 68, 0.2); color: #ef4444;">
                            <i class="bi bi-box-arrow-right me-2"></i> Logout
                        </button>
                    </form>
                </li>
            </ul>
        </div>
    </div>

    <!-- MAIN CONTENT -->
    <div id="main-content" class="main-content flex-fill">
        Loading...
    </div>

</div>

<!-- MODAL -->
<div class="modal fade" id="formModal" tabindex="-1">
  <div class="modal-dialog modal-lg">
    <div class="modal-content" id="modal-content"></div>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
// Setup CSRF Token untuk Axios
const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content || '{{ csrf_token() }}';
axios.defaults.headers.common['X-CSRF-TOKEN'] = csrfToken;
axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

let chartKeuangan = null;
const formModal = new bootstrap.Modal(document.getElementById('formModal'));

function loadPage(page, id = null) {
    let url = `/dashboard/content/${page}`;
    if (id) {
        url += `?id=${id}`;
    }
    
    axios.get(url)
        .then(res => {
            document.getElementById('main-content').innerHTML = res.data;
            
            // Evaluasi script yang ada di dalam response HTML
            const scripts = document.getElementById('main-content').querySelectorAll('script');
            scripts.forEach(oldScript => {
                const newScript = document.createElement('script');
                Array.from(oldScript.attributes).forEach(attr => newScript.setAttribute(attr.name, attr.value));
                newScript.appendChild(document.createTextNode(oldScript.innerHTML));
                oldScript.parentNode.replaceChild(newScript, oldScript);
            });
        })
        .catch(err => {
            console.error('Error loading page:', err);
            document.getElementById('main-content').innerHTML =
                '<p class="text-danger">Gagal load halaman</p>';
        });
}

// Toast notification function
function showToast(message, type = 'info') {
    const toastHtml = `
        <div class="toast align-items-center text-white bg-${type === 'success' ? 'success' : type === 'error' ? 'danger' : 'info'} border-0" role="alert" style="position: fixed; top: 20px; right: 20px; z-index: 9999;">
            <div class="d-flex">
                <div class="toast-body">${message}</div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
            </div>
        </div>
    `;
    
    const tempDiv = document.createElement('div');
    tempDiv.innerHTML = toastHtml;
    const toastElement = tempDiv.firstElementChild;
    document.body.appendChild(toastElement);
    
    const toast = new bootstrap.Toast(toastElement);
    toast.show();
    
    toastElement.addEventListener('hidden.bs.toast', () => {
        toastElement.remove();
    });
    
    setTimeout(() => {
        toastElement.remove();
    }, 6000);
}

function loadProfile() {
    axios.get('/profile')
        .then(res => {
            document.getElementById('main-content').innerHTML = res.data;
        })
        .catch(() => {
            document.getElementById('main-content').innerHTML = '<p class="text-danger">Gagal load profil</p>';
        });
}

function filterKeuanganTable() {
    const filterType = document.getElementById('filterType');
    if (!filterType) return;
    const type = filterType.value;
    
    let url = `/dashboard/content/keuangan?filter=${type}`;
    if (type === 'tahun' || type === 'bulan') {
        const year = document.getElementById('yearSelect').value;
        url += `&year=${year}`;
    }
    if (type === 'bulan') {
        const month = document.getElementById('monthSelect').value;
        url += `&month=${month}`;
    }
    if (type === 'tanggal') {
        const tanggal = document.getElementById('dateSelect').value;
        url += `&tanggal=${tanggal}`;
    }
    
    axios.get(url)
        .then(res => {
            document.getElementById('main-content').innerHTML = res.data;
        })
        .catch(err => {
            console.error('Error filter keuangan:', err);
            showToast('Gagal memuat filter', 'error');
        });
}

// Global AJAX Pagination Interceptor
document.addEventListener('click', function(e) {
    const link = e.target.closest('.pagination a');
    if (!link) return;

    e.preventDefault();
    axios.get(link.href)
        .then(res => {
            document.getElementById('main-content').innerHTML = res.data;
            document.getElementById('main-content').scrollIntoView({ behavior: 'smooth', block: 'start' });
        })
        .catch(err => {
            console.error('Pagination Error:', err);
            showToast('Gagal memuat halaman', 'error');
        });
});

// Toggle Mobile Menu
document.getElementById('mobileMenuToggle')?.addEventListener('click', function() {
    document.getElementById('sidebarMenu').classList.toggle('show');
});

// Auto-hide mobile menu when a link is clicked
document.querySelectorAll('#sidebarMenu a').forEach(link => {
    link.addEventListener('click', function() {
        if (window.innerWidth <= 768) {
            document.getElementById('sidebarMenu').classList.remove('show');
        }
    });
});

// Dark mode toggle
function toggleDarkMode() {
    const html = document.documentElement;
    const currentTheme = html.getAttribute('data-theme');
    const newTheme = currentTheme === 'dark' ? 'light' : 'dark';
    
    html.setAttribute('data-theme', newTheme);
    localStorage.setItem('theme', newTheme);
    updateDarkModeUI(newTheme);
}

function updateDarkModeUI(theme) {
    const icon = document.getElementById('darkModeIcon');
    const text = document.getElementById('darkModeText');
    if (icon && text) {
        if (theme === 'dark') {
            icon.className = 'bi bi-sun';
            text.innerText = 'Light Mode';
        } else {
            icon.className = 'bi bi-moon-stars';
            text.innerText = 'Dark Mode';
        }
    }
}

// Load theme on startup
const savedTheme = localStorage.getItem('theme') || 'light';
document.documentElement.setAttribute('data-theme', savedTheme);
document.addEventListener('DOMContentLoaded', () => {
    updateDarkModeUI(savedTheme);
    loadPage('overview');
});
</script>

</body>
</html>
