@extends('layouts.app')

@section('title', 'Detail Barang - Sistem Manajemen Aset Klinik Firdaus')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-0">Detail Barang</h1>
            <p class="text-muted">Informasi dan manajemen unit barang</p>
        </div>
        <a href="{{ route('assets.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left me-2"></i>Kembali
        </a>
    </div>

    <div class="card mb-4">
        <div class="card-header">
            <h5 class="mb-0">Informasi Barang Induk</h5>
        </div>
        <div class="card-body row">
            <div class="col-md-6">
                <strong>Kode Inventaris Dasar:</strong> {{ $kode_inventaris_dasar }}<br>
                <strong>Nama Barang:</strong> {{ $induk->jenisBarang->nama_barang ?? '-' }}<br>
                <strong>Kategori:</strong> {{ $induk->kategori->nama_kategori ?? '-' }}<br>
                <strong>Harga Per Unit:</strong> Rp {{ number_format($induk->harga_per_unit ?? 0, 0, ',', '.') }}<br>
            </div>
            <div class="col-md-6">
                <strong>Deskripsi:</strong> {{ $induk->deskripsi ?? '-' }}<br>
                <strong>Tahun Pengadaan:</strong> {{ $induk->tahun->tahun ?? '-' }}<br>
            </div>
        </div>
    </div>

    <div class="card mb-4">
        <div class="card-header">
            <h5 class="mb-0">Tambah Unit Barang</h5>
        </div>
        <div class="card-body">
            <form action="{{ route('assets.addUnit', ['kode_inventaris_dasar' => $kode_inventaris_dasar]) }}" method="POST">
                @csrf
                <div class="row mb-3">
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Kode Inventaris Lengkap</label>
                        <input type="text" class="form-control" value="{{ $kode_inventaris_dasar . '.' . str_pad($units->max('nomor_urut')+1, 3, '0', STR_PAD_LEFT) }}" readonly>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label for="ruangan_id" class="form-label">Ruangan <span class="text-danger">*</span></label>
                        <select class="form-select" id="ruangan_id" name="ruangan_id" required>
                            <option value="">Pilih Ruangan</option>
                            @foreach($ruangan as $r)
                                <option value="{{ $r->id }}">{{ $r->nama_ruangan }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-2 mb-3">
                        <label for="tahun_id" class="form-label">Tahun <span class="text-danger">*</span></label>
                        <select class="form-select" id="tahun_id" name="tahun_id" required>
                            <option value="">Pilih Tahun</option>
                            @foreach($tahun as $t)
                                <option value="{{ $t->id }}">{{ $t->tahun }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-2 mb-3">
                        <label for="kondisi_id" class="form-label">Kondisi <span class="text-danger">*</span></label>
                        <select class="form-select" id="kondisi_id" name="kondisi_id" required>
                            <option value="">Pilih Kondisi</option>
                            @foreach($kondisi as $k)
                                <option value="{{ $k->id }}">{{ $k->nama_kondisi }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="text-end">
                    <button type="submit" class="btn btn-primary"><i class="fas fa-plus me-2"></i>Tambah Unit</button>
                </div>
            </form>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <h5 class="mb-0">Daftar Unit Barang</h5>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Kode Inventaris Lengkap</th>
                            <th>Ruangan</th>
                            <th>Tahun</th>
                            <th>Kondisi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($units as $i => $unit)
                            <tr>
                                <td>{{ $i + 1 }}</td>
                                <td>{{ $unit->kode_inventaris }}</td>
                                <td>{{ $unit->ruangan->nama_ruangan ?? '-' }}</td>
                                <td>{{ $unit->tahun->tahun ?? '-' }}</td>
                                <td>{{ $unit->kondisi->nama_kondisi ?? '-' }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection 