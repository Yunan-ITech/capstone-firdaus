@extends('layouts.app')

@section('title', 'Dashboard - Sistem Manajemen Aset Klinik Firdaus')

@section('styles')
<link href="https://cdn.jsdelivr.net/npm/chart.js@3.9.1/dist/chart.min.css" rel="stylesheet">
<style>
    .stat-card {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        border-radius: 15px;
        padding: 1.5rem;
        margin-bottom: 1rem;
        transition: transform 0.3s ease;
    }
    
    .stat-card:hover {
        transform: translateY(-5px);
    }
    
    .stat-card h3 {
        font-size: 2.5rem;
        font-weight: 700;
        margin: 0;
    }
    
    .stat-card p {
        margin: 0;
        opacity: 0.9;
    }
    
    .stat-card i {
        font-size: 2rem;
        opacity: 0.8;
    }
    
    .chart-container {
        background: white;
        border-radius: 15px;
        padding: 1.5rem;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.08);
        margin-bottom: 1.5rem;
        height: 400px;
    }
    
    .recent-item {
        background: white;
        border-radius: 10px;
        padding: 1rem;
        margin-bottom: 0.5rem;
        border-left: 4px solid #667eea;
        transition: all 0.3s ease;
    }
    
    .recent-item:hover {
        transform: translateX(5px);
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
    }
    
    .status-badge {
        padding: 0.25rem 0.75rem;
        border-radius: 20px;
        font-size: 0.8rem;
        font-weight: 600;
    }
    
    .status-baik { background: #d4edda; color: #155724; }
    .status-rusak-ringan { background: #fff3cd; color: #856404; }
    .status-rusak-berat { background: #f8d7da; color: #721c24; }
    .status-tidak-layak { background: #f8d7da; color: #721c24; }
    
    /* Batas tinggi untuk dashboard */
    .dashboard-container {
        max-height: calc(100vh - 200px);
        overflow-y: auto;
        padding-right: 10px;
    }
    
    .dashboard-container::-webkit-scrollbar {
        width: 8px;
    }
    
    .dashboard-container::-webkit-scrollbar-track {
        background: #f1f1f1;
        border-radius: 10px;
    }
    
    .dashboard-container::-webkit-scrollbar-thumb {
        background: #667eea;
        border-radius: 10px;
    }
    
    .dashboard-container::-webkit-scrollbar-thumb:hover {
        background: #764ba2;
    }
    
    /* Batas tinggi untuk card content */
    .card-body {
        max-height: 300px;
        overflow-y: auto;
    }
    
    .card-body::-webkit-scrollbar {
        width: 6px;
    }
    
    .card-body::-webkit-scrollbar-track {
        background: #f1f1f1;
        border-radius: 10px;
    }
    
    .card-body::-webkit-scrollbar-thumb {
        background: #667eea;
        border-radius: 10px;
    }
    
    .card-body::-webkit-scrollbar-thumb:hover {
        background: #764ba2;
    }
</style>
@endsection

@section('content')
<div class="dashboard-container">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-0">Dashboard</h1>
            <p class="text-muted">Selamat datang di Sistem Manajemen Aset Klinik Firdaus</p>
        </div>
        <div class="text-end">
            <p class="mb-0 text-muted">Tanggal: {{ now()->format('d F Y') }}</p>
            <p class="mb-0 text-muted">Waktu: {{ now()->format('H:i') }}</p>
        </div>
    </div>

    <!-- Statistik Cards -->
    <div class="row mb-4">
        <div class="col-xl-3 col-md-6">
            <div class="stat-card">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h3>{{ $totalAssets }}</h3>
                        <p>Total Barang</p>
                    </div>
                    <i class="fas fa-boxes"></i>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="stat-card" style="background: linear-gradient(135deg, #28a745 0%, #20c997 100%);">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h3>{{ $totalKategori }}</h3>
                        <p>Kategori</p>
                    </div>
                    <i class="fas fa-tags"></i>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="stat-card" style="background: linear-gradient(135deg, #ffc107 0%, #fd7e14 100%);">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h3>{{ $totalRuangan }}</h3>
                        <p>Ruangan</p>
                    </div>
                    <i class="fas fa-door-open"></i>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="stat-card" style="background: linear-gradient(135deg, #dc3545 0%, #e83e8c 100%);">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h3>{{ $assetsLatestYear }}</h3>
                        <p>Barang {{ $latestYear->tahun ?? '2025' }}</p>
                    </div>
                    <i class="fas fa-calendar"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Charts Row -->
    <div class="row mb-4">
        <div class="col-xl-6">
            <div class="chart-container">
                <h5 class="mb-3">Barang berdasarkan Kategori</h5>
                <canvas id="categoryChart" height="300"></canvas>
            </div>
        </div>
        <div class="col-xl-6">
            <div class="chart-container">
                <h5 class="mb-3">Barang berdasarkan Kondisi</h5>
                <canvas id="conditionChart" height="300"></canvas>
            </div>
        </div>
    </div>

    <!-- Recent Activities Row -->
    <div class="row">
        <div class="col-xl-6">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0"><i class="fas fa-history me-2"></i>Barang Terbaru</h5>
                </div>
                <div class="card-body">
                    @if($recentAssets->count() > 0)
                        @foreach($recentAssets as $asset)
                            <div class="recent-item">
                                <div class="d-flex justify-content-between align-items-start">
                                    <div>
                                        <h6 class="mb-1">{{ $asset->jenisBarang->nama_barang }}</h6>
                                        <p class="mb-1 text-muted">{{ $asset->kategori->nama_kategori }} - {{ $asset->ruangan->nama_ruangan }}</p>
                                        <small class="text-muted">Kode: {{ $asset->kode_inventaris }}</small>
                                    </div>
                                    <span class="status-badge status-{{ strtolower(str_replace(' ', '-', $asset->kondisi->nama_kondisi)) }}">
                                        {{ $asset->kondisi->nama_kondisi }}
                                    </span>
                                </div>
                            </div>
                        @endforeach
                    @else
                        <p class="text-muted text-center">Belum ada data barang</p>
                    @endif
                </div>
            </div>
        </div>
        
        <div class="col-xl-6">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0"><i class="fas fa-door-open me-2"></i>Ruangan dengan Barang Terbanyak</h5>
                </div>
                <div class="card-body">
                    @if($topRuangan->count() > 0)
                        @foreach($topRuangan as $ruangan)
                            <div class="recent-item">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <h6 class="mb-1">{{ $ruangan->ruangan->nama_ruangan }}</h6>
                                        <p class="mb-0 text-muted">{{ $ruangan->total }} barang</p>
                                    </div>
                                    <span class="badge bg-primary">{{ $ruangan->total }}</span>
                                </div>
                            </div>
                        @endforeach
                    @else
                        <p class="text-muted text-center">Belum ada data ruangan</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js@3.9.1/dist/chart.min.js"></script>
<script>
// Chart untuk kategori barang
const categoryCtx = document.getElementById('categoryChart').getContext('2d');
const categoryChart = new Chart(categoryCtx, {
    type: 'doughnut',
    data: {
        labels: {!! json_encode($assetsByCategory->pluck('kategori.nama_kategori')) !!},
        datasets: [{
            data: {!! json_encode($assetsByCategory->pluck('total')) !!},
            backgroundColor: [
                '#667eea',
                '#764ba2',
                '#f093fb',
                '#f5576c',
                '#4facfe',
                '#00f2fe'
            ],
            borderWidth: 0
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            legend: {
                position: 'bottom'
            }
        }
    }
});

// Chart untuk kondisi barang
const conditionCtx = document.getElementById('conditionChart').getContext('2d');
const conditionChart = new Chart(conditionCtx, {
    type: 'bar',
    data: {
        labels: {!! json_encode($assetsByCondition->pluck('kondisi.nama_kondisi')) !!},
        datasets: [{
            label: 'Jumlah Barang',
            data: {!! json_encode($assetsByCondition->pluck('total')) !!},
            backgroundColor: [
                '#28a745',
                '#ffc107',
                '#fd7e14',
                '#dc3545'
            ],
            borderWidth: 0,
            borderRadius: 5
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            legend: {
                display: false
            }
        },
        scales: {
            y: {
                beginAtZero: true,
                ticks: {
                    stepSize: 1
                }
            }
        }
    }
});
</script>
@endsection 