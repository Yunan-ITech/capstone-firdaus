@extends('layouts.app')

@section('title', 'Data Barang - Sistem Manajemen Aset Klinik Firdaus')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-0">Data Barang</h1>
            <p class="text-muted">Daftar seluruh aset/barang milik klinik</p>
        </div>
        <a href="{{ route('assets.create') }}" class="btn btn-primary">
            <i class="fas fa-plus me-2"></i>Tambah Barang
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="fas fa-exclamation-circle me-2"></i>{{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="card mb-3">
        <div class="card-body">
            <form method="GET" action="{{ route('assets.index') }}" class="row g-3 align-items-end">
                <div class="col-md-2">
                    <label for="kategori_id" class="form-label">Kategori</label>
                    <select class="form-select" id="kategori_id" name="kategori_id">
                        <option value="">Semua</option>
                        @foreach($kategori as $kat)
                            <option value="{{ $kat->id }}" {{ request('kategori_id') == $kat->id ? 'selected' : '' }}>{{ $kat->nama_kategori }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2">
                    <label for="jenis_barang_id" class="form-label">Nama Barang</label>
                    <select class="form-select" id="jenis_barang_id" name="jenis_barang_id">
                        <option value="">Semua</option>
                        @foreach($jenisBarang as $jenis)
                            <option value="{{ $jenis->id }}" {{ request('jenis_barang_id') == $jenis->id ? 'selected' : '' }}>{{ $jenis->nama_barang }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2">
                    <label for="ruangan_id" class="form-label">Ruangan</label>
                    <select class="form-select" id="ruangan_id" name="ruangan_id">
                        <option value="">Semua</option>
                        @foreach($ruangan as $r)
                            <option value="{{ $r->id }}" {{ request('ruangan_id') == $r->id ? 'selected' : '' }}>{{ $r->nama_ruangan }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2">
                    <label for="tahun_id" class="form-label">Tahun</label>
                    <select class="form-select" id="tahun_id" name="tahun_id">
                        <option value="">Semua</option>
                        @foreach($tahun as $t)
                            <option value="{{ $t->id }}" {{ request('tahun_id') == $t->id ? 'selected' : '' }}>{{ $t->tahun }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2">
                    <label for="kondisi_id" class="form-label">Kondisi</label>
                    <select class="form-select" id="kondisi_id" name="kondisi_id">
                        <option value="">Semua</option>
                        @foreach($kondisi as $k)
                            <option value="{{ $k->id }}" {{ request('kondisi_id') == $k->id ? 'selected' : '' }}>{{ $k->nama_kondisi }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-primary w-100"><i class="fas fa-filter me-2"></i>Filter</button>
                </div>
            </form>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <h5 class="mb-0"><i class="fas fa-boxes me-2"></i>Daftar Barang</h5>
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
                                <th>Jumlah Aset</th>
                                <th>Ruangan</th>
                                <th>Kondisi</th>
                                <th>Harga Per Unit</th>
                                <th>Tahun</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($assets as $index => $asset)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $asset->kode_inventaris }}</td>
                                    <td>{{ $asset->jenisBarang->nama_barang ?? '-' }}</td>
                                    <td>{{ $asset->kategori->nama_kategori ?? '-' }}</td>
                                    <td>1</td>
                                    <td>{{ $asset->ruangan->nama_ruangan ?? '-' }}</td>
                                    <td>{{ $asset->kondisi->nama_kondisi ?? '-' }}</td>
                                    <td>Rp {{ number_format($asset->harga_per_unit ?? 0, 0, ',', '.') }}</td>
                                    <td>{{ $asset->tahun->tahun ?? '-' }}</td>
                                    <td>
                                        <a href="{{ route('assets.edit', $asset->id) }}" class="btn btn-sm btn-outline-primary"><i class="fas fa-edit"></i></a>
                                        <form action="{{ route('assets.destroy', $asset->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus barang ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger"><i class="fas fa-trash"></i></button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="text-center py-4">
                    <i class="fas fa-boxes fa-3x text-muted mb-3"></i>
                    <h5 class="text-muted">Belum ada data barang</h5>
                    <p class="text-muted">Klik tombol "Tambah Barang" untuk menambahkan data pertama</p>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection 