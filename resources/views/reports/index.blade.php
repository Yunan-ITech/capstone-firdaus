@extends('layouts.app')

@section('title', 'Laporan Data Barang - Sistem Manajemen Aset Klinik Firdaus')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-0">Laporan Data Aset</h1>
            <p class="text-muted">Laporan rekapitulasi aset/barang</p>
        </div>
    </div>

    <!-- Filter Card -->
    <div class="card shadow-sm mb-4">
        <div class="card-header">
            <h5 class="mb-0"><i class="fas fa-filter me-2"></i>Filter Laporan</h5>
        </div>
        <div class="card-body">
            <form method="GET" action="{{ route('reports.index') }}" class="row g-3 align-items-end">
                <div class="col-md-3">
                    <label for="kategori_id" class="form-label">Kategori</label>
                    <select class="form-select" id="kategori_id" name="kategori_id">
                        <option value="">Semua Kategori</option>
                        @foreach($kategori as $kat)
                            <option value="{{ $kat->id }}" {{ request('kategori_id') == $kat->id ? 'selected' : '' }}>{{ $kat->nama_kategori }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3">
                    <label for="ruangan_id" class="form-label">Ruangan</label>
                    <select class="form-select" id="ruangan_id" name="ruangan_id">
                        <option value="">Semua Ruangan</option>
                        @foreach($ruangan as $r)
                            <option value="{{ $r->id }}" {{ request('ruangan_id') == $r->id ? 'selected' : '' }}>{{ $r->nama_ruangan }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3">
                    <label for="kondisi_id" class="form-label">Kondisi</label>
                    <select class="form-select" id="kondisi_id" name="kondisi_id">
                        <option value="">Semua Kondisi</option>
                        @foreach($kondisi as $k)
                            <option value="{{ $k->id }}" {{ request('kondisi_id') == $k->id ? 'selected' : '' }}>{{ $k->nama_kondisi }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3 d-flex gap-2">
                    <button type="submit" class="btn btn-primary w-100"><i class="fas fa-search me-2"></i>Terapkan</button>
                    <a href="{{ route('reports.index') }}" class="btn btn-secondary w-100">Reset</a>
                </div>
            </form>
        </div>
    </div>

    <!-- Report Results Card -->
    <div class="card shadow-sm">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0"><i class="fas fa-table me-2"></i>Hasil Laporan</h5>
            <div class="dropdown">
                <button class="btn btn-success btn-sm dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false" {{ count($reportData) == 0 ? 'disabled' : '' }}>
                    <i class="fas fa-download me-2"></i>Download Laporan
                </button>
                <ul class="dropdown-menu dropdown-menu-end">
                    <li><a class="dropdown-item" href="{{ route('reports.export', array_merge(request()->query(), ['format' => 'xlsx'])) }}" target="_blank">Excel (.xlsx)</a></li>
                    <li><a class="dropdown-item" href="{{ route('reports.export', array_merge(request()->query(), ['format' => 'pdf'])) }}" target="_blank">PDF</a></li>
                </ul>
            </div>
        </div>
        <div class="card-body">
            @if(count($reportData) > 0)
                <div class="table-responsive">
                    <table class="table table-hover table-bordered">
                        <thead class="table-light">
                            <tr>
                                <th>No</th>
                                <th>Kode Inventaris</th>
                                <th>Nama Barang</th>
                                <th>Kategori</th>
                                <th>Ruangan</th>
                                <th>Kondisi</th>
                                <th>Harga/Unit</th>
                                <th>Jumlah</th>
                                <th>Th. Pengadaan</th>
                                <th>Harga Perolehan</th>
                                <th>Deskripsi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($reportData as $data)
                                <tr>
                                    <td>{{ $data['no'] }}</td>
                                    <td>{{ $data['kode_inventaris'] }}</td>
                                    <td>{{ $data['nama_barang'] }}</td>
                                    <td>{{ $data['kategori'] }}</td>
                                    <td>{{ $data['ruangan'] }}</td>
                                    <td>{{ $data['kondisi'] }}</td>
                                    <td>{{ 'Rp ' . number_format($data['harga_per_unit'], 0, ',', '.') }}</td>
                                    <td>{{ $data['jumlah'] }}</td>
                                    <td>{{ $data['tahun_pengadaan'] }}</td>
                                    <td>{{ 'Rp ' . number_format($data['harga_perolehan'], 0, ',', '.') }}</td>
                                    <td>{{ $data['deskripsi'] }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="d-flex justify-content-center mt-3">
                    {{ $reportData->links('pagination::bootstrap-5') }}
                </div>
            @else
                <div class="text-center py-5">
                    <i class="fas fa-file-alt fa-3x text-muted mb-3"></i>
                    <h5 class="text-muted">Tidak ada data untuk dilaporkan.</h5>
                    <p class="small text-muted">Silakan sesuaikan filter Anda atau tambahkan data aset.</p>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection 