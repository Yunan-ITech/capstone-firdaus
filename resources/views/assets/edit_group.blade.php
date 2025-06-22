@extends('layouts.app')

@section('title', 'Edit Grup Barang - Sistem Manajemen Aset Klinik Firdaus')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-0">Edit Grup Barang</h1>
            <p class="text-muted">Mengubah informasi umum untuk <strong>{{ $kode_inventaris_dasar }}</strong></p>
        </div>
        <a href="{{ route('assets.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left me-2"></i>Kembali
        </a>
    </div>

    <div class="card shadow-sm">
        <div class="card-header">
            <h5 class="mb-0">Form Edit Grup Barang</h5>
        </div>
        <div class="card-body">
            <form action="{{ route('assets.updateGroup', $kode_inventaris_dasar) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="nama_barang" class="form-label">Nama Barang</label>
                        <input type="text" id="nama_barang" class="form-control" value="{{ $asset->jenisBarang->nama_barang ?? '' }}" readonly disabled>
                        <div class="form-text">Nama barang tidak dapat diubah dari sini karena akan memengaruhi kode inventaris.</div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="kategori" class="form-label">Kategori</label>
                        <input type="text" id="kategori" class="form-control" value="{{ $asset->kategori->nama_kategori ?? '' }}" readonly disabled>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="harga_per_unit" class="form-label">Harga Per Unit <span class="text-danger">*</span></label>
                        <input type="number" name="harga_per_unit" id="harga_per_unit" class="form-control @error('harga_per_unit') is-invalid @enderror" value="{{ old('harga_per_unit', $asset->harga_per_unit) }}" required>
                        @error('harga_per_unit')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="mb-3">
                    <label for="deskripsi" class="form-label">Deskripsi</label>
                    <textarea name="deskripsi" id="deskripsi" class="form-control @error('deskripsi') is-invalid @enderror" rows="4">{{ old('deskripsi', $asset->deskripsi) }}</textarea>
                    @error('deskripsi')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="text-end">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save me-2"></i>Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection 