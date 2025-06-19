@extends('layouts.app')

@section('title', 'Laporan Data Barang - Sistem Manajemen Aset Klinik Firdaus')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-0">Laporan Data Barang</h1>
            <p class="text-muted">Laporan aset/barang berdasarkan filter ruangan dan kondisi</p>
        </div>
    </div>

    <form method="GET" action="{{ route('reports.index') }}" class="row g-3 mb-4 align-items-end">
        <div class="col-md-4">
            <label for="ruangan_id" class="form-label">Filter Ruangan</label>
            <select class="form-select" id="ruangan_id" name="ruangan_id">
                <option value="">Semua Ruangan</option>
                @foreach($ruangan as $r)
                    <option value="{{ $r->id }}" {{ request('ruangan_id') == $r->id ? 'selected' : '' }}>{{ $r->nama_ruangan }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-4">
            <label for="kondisi_id" class="form-label">Filter Kondisi</label>
            <select class="form-select" id="kondisi_id" name="kondisi_id">
                <option value="">Semua Kondisi</option>
                @foreach($kondisi as $k)
                    <option value="{{ $k->id }}" {{ request('kondisi_id') == $k->id ? 'selected' : '' }}>{{ $k->nama_kondisi }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-4 d-flex gap-2">
            <button type="submit" class="btn btn-primary"><i class="fas fa-filter me-2"></i>Filter</button>
            <a href="{{ route('reports.index') }}" class="btn btn-secondary">Reset</a>
            <div class="dropdown ms-auto">
                <button class="btn btn-success dropdown-toggle" type="button" id="downloadDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="fas fa-download me-2"></i>Download
                </button>
                <ul class="dropdown-menu" aria-labelledby="downloadDropdown">
                    <li><a class="dropdown-item" href="{{ route('reports.export', array_merge(request()->all(), ['format' => 'excel'])) }}">Excel</a></li>
                    <li><a class="dropdown-item" href="{{ route('reports.export', array_merge(request()->all(), ['format' => 'csv'])) }}">CSV</a></li>
                    <li><a class="dropdown-item" href="{{ route('reports.export', array_merge(request()->all(), ['format' => 'pdf'])) }}">PDF</a></li>
                </ul>
            </div>
        </div>
    </form>

    <div class="card">
        <div class="card-header">
            <h5 class="mb-0"><i class="fas fa-table me-2"></i>Hasil Laporan</h5>
        </div>
        <div class="card-body">
            @if($assets->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead class="table-light">
                            <tr>
                                <th>No</th>
                                <th>Kode Inventaris</th>
                                <th>Nama Barang</th>
                                <th>Kategori</th>
                                <th>Ruangan</th>
                                <th>Kondisi</th>
                                <th>Tahun</th>
                                <th>Deskripsi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($assets as $index => $asset)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $asset->kode_inventaris }}</td>
                                    <td>{{ $asset->jenisBarang->nama_barang ?? '-' }}</td>
                                    <td>{{ $asset->kategori->nama_kategori ?? '-' }}</td>
                                    <td>{{ $asset->ruangan->nama_ruangan ?? '-' }}</td>
                                    <td>{{ $asset->kondisi->nama_kondisi ?? '-' }}</td>
                                    <td>{{ $asset->tahun->tahun ?? '-' }}</td>
                                    <td>{{ $asset->deskripsi ?? '-' }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="text-center py-4">
                    <i class="fas fa-file-alt fa-3x text-muted mb-3"></i>
                    <h5 class="text-muted">Tidak ada data sesuai filter</h5>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection 