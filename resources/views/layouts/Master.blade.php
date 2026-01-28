<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard | STMC Digital Klinik</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">

    <style>
        :root {
            /* --stmc-gradient: linear-gradient(135deg, #0d6efd 0%, #18bc9c 100%); */
            --stmc-gradient: #0d6efd;
            --stmc-dark: #2c3e50;
        }

        body {
            background-color: #f0f2f5;
            font-family: 'Inter', sans-serif;
            overflow-x: hidden;
        }

        /* Sidebar Modern */
        .sidebar {
            width: 280px;
            min-height: 100vh;
            background: var(--stmc-dark);
            color: white;
            transition: all 0.3s;
            z-index: 1000;
        }

        .sidebar-header {
            padding: 30px 20px;
            background: rgba(0, 0, 0, 0.1);
            text-align: center;
        }

        .nav-link {
            color: rgba(255, 255, 255, 0.7);
            margin: 5px 15px;
            border-radius: 10px;
            padding: 12px 20px;
            transition: 0.3s;
        }

        .nav-link:hover {
            background: rgba(255, 255, 255, 0.1);
            color: white;
        }

        .nav-link.active {
            background: var(--stmc-gradient) !important;
            color: white !important;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
        }

        /* Navbar & Content */
        .navbar {
            background: white;
            box-shadow: 0 2px 15px rgba(0, 0, 0, 0.05);
            padding: 15px 30px;
        }

        .main-content {
            flex-grow: 1;
            min-width: 0;
        }

        /* Card Styling agar senada */
        .card {
            border: none;
            border-radius: 15px;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.05);
        }

        .btn-stmc {
            background: var(--stmc-gradient);
            color: white;
            border: none;
            border-radius: 8px;
            transition: 0.3s;
        }

        .btn-stmc:hover {
            opacity: 0.9;
            color: white;
            transform: translateY(-2px);
        }
    </style>
</head>

<body class="d-flex">

    <nav class="sidebar shadow">
        <div class="sidebar-header">
            <img src="{{ asset('Images/logoST.png') }}" alt="Logo" width="50" class="mb-2">
            <h6 class="fw-bold mb-0">STMC DIGITAL</h6>
            <small class="opacity-50 text-uppercase" style="font-size: 10px; letter-spacing: 1px;">Klinik
                Management</small>
        </div>

        <div class="mt-4">
            <div class="small text-white-50 px-4 mb-2 text-uppercase" style="font-size: 11px;">Utama</div>
            <a href="/dashboard" class="nav-link {{ Request::is('dashboard') ? 'active' : '' }}">
                <i class="bi bi-grid-1x2-fill me-2"></i> Dashboard
            </a>
            <a href="/profile" class="nav-link {{ Request::is('profile') ? 'active' : '' }}">
                <i class="bi bi-person-badge-fill me-2"></i> Profil Saya
            </a>

            <div class="small text-white-50 px-4 mt-4 mb-2 text-uppercase" style="font-size: 11px;">Arsip Surat</div>
            <a href="/surat/input" class="nav-link {{ Request::is('surat/input') ? 'active' : '' }}">
                <i class="bi bi-plus-square-fill me-2"></i> Input Surat
            </a>
            <a href="/surat/masuk" class="nav-link {{ Request::is('surat/masuk*') ? 'active' : '' }}">
                <i class="bi bi-arrow-down-left-circle-fill me-2"></i> Surat Masuk
            </a>
            <a href="/surat/keluar" class="nav-link {{ Request::is('surat/keluar*') ? 'active' : '' }}">
                <i class="bi bi-arrow-up-right-circle-fill me-2"></i> Surat Keluar
            </a>

            @if (auth()->user() && auth()->user()->role == 'admin')
                <div class="small text-white-50 px-4 mt-4 mb-2 text-uppercase" style="font-size: 11px;">Administrator
                </div>
                <a href="{{ route('admin.users.list') }}"
                    class="nav-link {{ Request::routeIs('admin.users.list') ? 'active' : '' }}">
                    <i class="bi bi-person-gear me-2"></i> Manajemen Pengguna
                </a>
                <a href="{{ route('admin.users.index') }}"
                    class="nav-link {{ Request::routeIs('admin.users.index') ? 'active' : '' }}">
                    <i class="bi bi-person-check-fill me-2"></i> Verifikasi Pengguna
                </a>
                <a href="/admin/logs" class="nav-link {{ Request::is('admin/logs*') ? 'active' : '' }}">
                    <i class="bi bi-terminal-fill me-2"></i> Riwayat Aktivitas
                </a>
                <a href="{{ route('admin.users.trash') }}"
                    class="nav-link {{ Request::routeIs('admin.users.trash') ? 'active' : '' }}">
                    <i class="bi bi-trash3-fill me-2 text-danger"></i> Arship Pengguna
                </a>
            @endif
        </div>

        <div class="p-4 mt-auto">
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="btn btn-outline-light btn-sm w-100 rounded-pill">
                    <i class="bi bi-box-arrow-left me-2"></i> Keluar
                </button>
            </form>
        </div>
    </nav>

    <div class="main-content">
        <nav class="navbar navbar-expand-lg">
            <div class="container-fluid">
                <span class="text-muted small fw-medium">
                    <i class="bi bi-calendar-event me-1"></i> {{ date('d F Y') }}
                </span>
                <div class="ms-auto d-flex align-items-center">
                    <div class="text-end me-3 d-none d-sm-block">
                        <div class="fw-bold mb-0" style="font-size: 14px;">{{ auth()->user()->nama_lengkap }}</div>
                        <div class="text-muted" style="font-size: 11px;">{{ strtoupper(auth()->user()->role) }}</div>
                    </div>
                    <div class="bg-primary rounded-circle d-flex align-items-center justify-content-center text-white shadow-sm"
                        style="width: 40px; height: 40px; background: var(--stmc-gradient) !important;">
                        <i class="bi bi-person-fill"></i>
                    </div>
                </div>
            </div>
        </nav>

        <div class="container-fluid p-4">
            @yield('content')
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
