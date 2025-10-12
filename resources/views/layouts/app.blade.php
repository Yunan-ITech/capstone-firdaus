<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Sistem Manajemen Aset Klinik Firdaus')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        :root {
            --sidebar-width: 280px;
            --primary-color: #667eea;
            --secondary-color: #764ba2;
        }
        
        body {
            background-color: #f8f9fa;
        }
        
        .sidebar {
            position: fixed;
            top: 0;
            left: 0;
            height: 100vh;
            width: var(--sidebar-width);
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%);
            z-index: 1000;
            transition: all 0.3s ease;
            overflow-y: auto;
        }
        
        .sidebar-header {
            padding: 1.5rem;
            text-align: center;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }
        
        .sidebar-header h3 {
            color: white;
            margin: 0;
            font-weight: 700;
        }
        
        .sidebar-header p {
            color: rgba(255, 255, 255, 0.8);
            margin: 0;
            font-size: 0.9rem;
        }
        
        .nav-link {
            color: rgba(255, 255, 255, 0.8);
            padding: 0.75rem 1.5rem;
            transition: all 0.3s ease;
            border: none;
            background: transparent;
            text-decoration: none;
        }
        
        .nav-link:hover, .nav-link.active {
            color: white;
            background: rgba(255, 255, 255, 0.1);
            transform: translateX(5px);
        }
        
        .nav-link i {
            width: 20px;
            margin-right: 10px;
        }
        
        .nav-item.has-submenu .nav-link {
            position: relative;
        }
        
        /* Ubah selector agar arrow hanya muncul di Master Data */
        .nav-item.has-submenu > .nav-link::after {
            content: '\f107';
            font-family: 'Font Awesome 6 Free';
            font-weight: 900;
            position: absolute;
            right: 1.5rem;
            transition: transform 0.3s ease;
        }
        
        .nav-item.has-submenu.open > .nav-link::after {
            transform: rotate(180deg);
        }
        
        .submenu {
            background: rgba(0, 0, 0, 0.1);
            max-height: 0;
            overflow: hidden;
            transition: max-height 0.3s ease;
        }
        
        .nav-item.has-submenu.open .submenu {
            max-height: 500px;
        }
        
        .submenu .nav-link {
            padding-left: 3rem;
            font-size: 0.9rem;
        }
        
        .main-content {
            margin-left: var(--sidebar-width);
            min-height: 100vh;
        }
        
        .navbar {
            background: white;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            padding: 1rem 2rem;
        }
        
        .content-wrapper {
            padding: 2rem;
        }
        
        .card {
            border: none;
            border-radius: 15px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.08);
        }
        
        .btn-primary {
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%);
            border: none;
            border-radius: 10px;
        }
        
        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(102, 126, 234, 0.4);
        }
        
        @media (max-width: 768px) {
            .sidebar {
                transform: translateX(-100%);
            }
            
            .sidebar.show {
                transform: translateX(0);
            }
            
            .main-content {
                margin-left: 0;
            }
        }
    </style>
    @stack('styles')
    @yield('styles')
</head>
<body>
    <!-- Sidebar -->
    <nav class="sidebar">
        <div class="sidebar-header">
            <img src="{{ asset('images/logo-klinik-firdaus.jpg') }}" alt="Logo Klinik Firdaus" style="width: 80px; height: auto; margin-bottom: 10px;">
            <h3>Klinik Firdaus</h3>
            <p>Sistem Manajemen Aset</p>
        </div>
        
        <ul class="nav flex-column">
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}" href="{{ route('dashboard') }}">
                    <i class="fas fa-tachometer-alt"></i> Dashboard
                </a>
            </li>
            
            <li class="nav-item has-submenu
                {{ request()->routeIs('master.ruangan.*') || 
                   request()->routeIs('master.kategori.*') || 
                   request()->routeIs('master.tahun.*') || 
                   request()->routeIs('master.jenis-barang.*') || 
                   request()->routeIs('master.kondisi.*') ? 'open' : '' }}">
                <a class="nav-link" href="#" onclick="toggleSubmenu(this)">
                    <i class="fas fa-database"></i> Master Data
                </a>
                <div class="submenu">
                    <a class="nav-link {{ request()->routeIs('master.ruangan.*') ? 'active' : '' }}" href="{{ route('master.ruangan.index') }}">
                        <i class="fas fa-door-open"></i> Ruangan
                    </a>
                    <a class="nav-link {{ request()->routeIs('master.kategori.*') ? 'active' : '' }}" href="{{ route('master.kategori.index') }}">
                        <i class="fas fa-tags"></i> Kategori
                    </a>
                    <a class="nav-link {{ request()->routeIs('master.tahun.*') ? 'active' : '' }}" href="{{ route('master.tahun.index') }}">
                        <i class="fas fa-calendar"></i> Tahun
                    </a>
                    <a class="nav-link {{ request()->routeIs('master.jenis-barang.*') ? 'active' : '' }}" href="{{ route('master.jenis-barang.index') }}">
                        <i class="fas fa-box"></i> Jenis Barang
                    </a>
                    <a class="nav-link {{ request()->routeIs('master.kondisi.*') ? 'active' : '' }}" href="{{ route('master.kondisi.index') }}">
                        <i class="fas fa-check-circle"></i> Kondisi
                    </a>
                </div>
            </li>
            
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('assets.*') ? 'active' : '' }}" href="{{ route('assets.index') }}">
                    <i class="fas fa-boxes"></i> Data Barang
                </a>
            </li>
            
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('reports.*') ? 'active' : '' }}" href="{{ route('reports.index') }}">
                    <i class="fas fa-chart-bar"></i> Laporan
                </a>
            </li>
            
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('labels.*') ? 'active' : '' }}" href="{{ route('labels.index') }}">
                    <i class="fas fa-print"></i> Cetak Label
                </a>
            </li>
        </ul>
    </nav>

    <!-- Main Content -->
    <div class="main-content">
        <!-- Navbar -->
        <nav class="navbar">
            <div class="container-fluid">
                <button class="btn btn-link d-md-none" id="sidebarToggle">
                    <i class="fas fa-bars"></i>
                </button>
                
                <div class="ms-auto">
                    <div class="dropdown">
                        <button class="btn btn-link dropdown-toggle text-dark" type="button" id="userDropdown" data-bs-toggle="dropdown">
                            <i class="fas fa-user-circle me-2"></i>{{ Auth::user()->name ?? 'User' }}
                        </button>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="#"><i class="fas fa-user me-2"></i>Profil</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <form method="POST" action="{{ route('logout') }}" class="d-inline">
                                    @csrf
                                    <button type="submit" class="dropdown-item">
                                        <i class="fas fa-sign-out-alt me-2"></i>Logout
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </nav>

        <!-- Content -->
        <div class="content-wrapper">
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @yield('content')
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Sidebar toggle for mobile
        document.getElementById('sidebarToggle').addEventListener('click', function() {
            document.querySelector('.sidebar').classList.toggle('show');
        });

        // Submenu toggle
        function toggleSubmenu(element) {
            const navItem = element.parentElement;
            navItem.classList.toggle('open');
        }

        // Auto open submenu if current page is in submenu
        document.addEventListener('DOMContentLoaded', function() {
            const currentPath = window.location.pathname;
            const submenuItems = document.querySelectorAll('.submenu .nav-link');
            
            submenuItems.forEach(item => {
                if (item.getAttribute('href') === currentPath) {
                    item.parentElement.parentElement.classList.add('open');
                }
            });
        });
    </script>
    @stack('scripts')
    @yield('scripts')
</body>
</html> 