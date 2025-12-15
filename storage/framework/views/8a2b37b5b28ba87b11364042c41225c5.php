<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $__env->yieldContent('title', 'Sistem Manajemen Aset Klinik Firdaus'); ?></title>
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
    <?php echo $__env->yieldPushContent('styles'); ?>
    <?php echo $__env->yieldContent('styles'); ?>
</head>
<body>
    <!-- Sidebar -->
    <nav class="sidebar">
        <div class="sidebar-header">
            <img src="<?php echo e(asset('images/logo-klinik-firdaus.jpg')); ?>" alt="Logo Klinik Firdaus" style="width: 80px; height: auto; margin-bottom: 10px;">
            <h3>Klinik Firdaus</h3>
            <p>Sistem Manajemen Aset</p>
        </div>
        
        <ul class="nav flex-column">
            <li class="nav-item">
                <a class="nav-link <?php echo e(request()->routeIs('dashboard') ? 'active' : ''); ?>" href="<?php echo e(route('dashboard')); ?>">
                    <i class="fas fa-tachometer-alt"></i> Dashboard
                </a>
            </li>
            
            <li class="nav-item has-submenu
                <?php echo e(request()->routeIs('master.ruangan.*') || 
                   request()->routeIs('master.kategori.*') || 
                   request()->routeIs('master.tahun.*') || 
                   request()->routeIs('master.jenis-barang.*') || 
                   request()->routeIs('master.kondisi.*') ? 'open' : ''); ?>">
                <a class="nav-link" href="#" onclick="toggleSubmenu(this)">
                    <i class="fas fa-database"></i> Master Data
                </a>
                <div class="submenu">
                    <a class="nav-link <?php echo e(request()->routeIs('master.ruangan.*') ? 'active' : ''); ?>" href="<?php echo e(route('master.ruangan.index')); ?>">
                        <i class="fas fa-door-open"></i> Ruangan
                    </a>
                    <a class="nav-link <?php echo e(request()->routeIs('master.kategori.*') ? 'active' : ''); ?>" href="<?php echo e(route('master.kategori.index')); ?>">
                        <i class="fas fa-tags"></i> Kategori
                    </a>
                    <a class="nav-link <?php echo e(request()->routeIs('master.tahun.*') ? 'active' : ''); ?>" href="<?php echo e(route('master.tahun.index')); ?>">
                        <i class="fas fa-calendar"></i> Tahun
                    </a>
                    <a class="nav-link <?php echo e(request()->routeIs('master.jenis-barang.*') ? 'active' : ''); ?>" href="<?php echo e(route('master.jenis-barang.index')); ?>">
                        <i class="fas fa-box"></i> Jenis Barang
                    </a>
                    <a class="nav-link <?php echo e(request()->routeIs('master.kondisi.*') ? 'active' : ''); ?>" href="<?php echo e(route('master.kondisi.index')); ?>">
                        <i class="fas fa-check-circle"></i> Kondisi
                    </a>
                </div>
            </li>
            
            <li class="nav-item">
                <a class="nav-link <?php echo e(request()->routeIs('assets.*') ? 'active' : ''); ?>" href="<?php echo e(route('assets.index')); ?>">
                    <i class="fas fa-boxes"></i> Data Barang
                </a>
            </li>
            
            <li class="nav-item">
                <a class="nav-link <?php echo e(request()->routeIs('reports.*') ? 'active' : ''); ?>" href="<?php echo e(route('reports.index')); ?>">
                    <i class="fas fa-chart-bar"></i> Laporan
                </a>
            </li>
            
            <li class="nav-item">
                <a class="nav-link <?php echo e(request()->routeIs('labels.*') ? 'active' : ''); ?>" href="<?php echo e(route('labels.index')); ?>">
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
                        <button class="btn dropdown-toggle text-dark" type="button" id="userDropdown" data-bs-toggle="dropdown">
                            <i class="fas fa-user-circle me-2"></i><?php echo e(Auth::user()->name ?? 'User'); ?>

                        </button>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="<?php echo e(route('profile.show')); ?>"><i class="fas fa-user me-2"></i>Profil</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <form method="POST" action="<?php echo e(route('logout')); ?>" class="d-inline">
                                    <?php echo csrf_field(); ?>
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
            <?php if(session('success')): ?>
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <?php echo e(session('success')); ?>

                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            <?php endif; ?>

            <?php if(session('error')): ?>
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <?php echo e(session('error')); ?>

                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            <?php endif; ?>

            <?php echo $__env->yieldContent('content'); ?>
        </div>
    </div>

    <!-- Global Delete Confirmation Modal -->
    <div class="modal fade" id="confirmDeleteModal" tabindex="-1" aria-labelledby="confirmDeleteLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow">
                <div class="modal-header" style="background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));">
                    <h5 class="modal-title text-white" id="confirmDeleteLabel">
                        <i class="fas fa-exclamation-triangle me-2"></i>Konfirmasi Hapus
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p class="mb-1">
                        Apakah Anda yakin ingin menghapus data ini
                        <span id="deleteItemNameWrapper" style="display:none;">
                            : "<span id="deleteItemName"></span>"
                        </span>
                        ?
                    </p>
                    <small class="text-muted">Tindakan ini tidak dapat dibatalkan.</small>
                </div>
                <div class="modal-footer d-flex justify-content-between">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">
                        <i class="fas fa-times me-1"></i>Batal
                    </button>
                    <button type="button" class="btn btn-danger" id="confirmDeleteButton">
                        <i class="fas fa-trash-alt me-1"></i>Hapus
                    </button>
                </div>
            </div>
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

            // Konfirmasi global untuk semua form DELETE menggunakan modal
            const deleteForms = document.querySelectorAll('form');
            const modalElement = document.getElementById('confirmDeleteModal');
            const confirmButton = document.getElementById('confirmDeleteButton');
            const deleteItemNameSpan = document.getElementById('deleteItemName');
            const deleteItemNameWrapper = document.getElementById('deleteItemNameWrapper');
            let formToSubmit = null;

            if (modalElement && confirmButton) {
                const bsModal = new bootstrap.Modal(modalElement);

                deleteForms.forEach(form => {
                    const methodInput = form.querySelector('input[name="_method"][value="DELETE"]');
                    if (methodInput) {
                        form.addEventListener('submit', function(e) {
                            // Tahan submit default
                            e.preventDefault();
                            formToSubmit = form;

                            if (deleteItemNameSpan && deleteItemNameWrapper) {
                                const itemName = form.getAttribute('data-item-name');
                                if (itemName) {
                                    deleteItemNameSpan.textContent = itemName;
                                    deleteItemNameWrapper.style.display = 'inline';
                                } else {
                                    deleteItemNameSpan.textContent = '';
                                    deleteItemNameWrapper.style.display = 'none';
                                }
                            }

                            bsModal.show();
                        });
                    }
                });

                confirmButton.addEventListener('click', function() {
                    if (formToSubmit) {
                        bsModal.hide();
                        formToSubmit.submit();
                        formToSubmit = null;
                    }
                });
            }
        });
    </script>
    <?php echo $__env->yieldPushContent('scripts'); ?>
    <?php echo $__env->yieldContent('scripts'); ?>
</body>
</html> <?php /**PATH C:\laragon\www\capstone-firdaus\resources\views/layouts/app.blade.php ENDPATH**/ ?>