@extends('layouts.app')

@section('title', 'Tambah Barang - Sistem Manajemen Aset Klinik Firdaus')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-0">Tambah Barang</h1>
            <p class="text-muted">Formulir untuk menambah data aset/barang baru</p>
        </div>
        <a href="{{ route('assets.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left me-2"></i>Kembali
        </a>
    </div>

    <div class="card">
        <div class="card-header">
            <h5 class="mb-0"><i class="fas fa-plus me-2"></i>Form Tambah Barang</h5>
        </div>
        <div class="card-body">
            <form action="{{ route('assets.store') }}" method="POST">
                @csrf
                <div class="row mb-3">
                    <div class="col-md-6 mb-3">
                        <label for="kategori_id" class="form-label">Kategori <span class="text-danger">*</span></label>
                        <select class="form-select @error('kategori_id') is-invalid @enderror" id="kategori_id" name="kategori_id" required>
                            <option value="">Pilih Kategori</option>
                            @foreach($kategori as $kat)
                                <option value="{{ $kat->id }}" {{ old('kategori_id') == $kat->id ? 'selected' : '' }}>{{ $kat->nama_kategori }}</option>
                            @endforeach
                        </select>
                        @error('kategori_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="jenis_barang_id" class="form-label">Nama Barang <span class="text-danger">*</span></label>
                        <select class="form-select @error('jenis_barang_id') is-invalid @enderror" id="jenis_barang_id" name="jenis_barang_id" required disabled>
                            <option value="">Pilih Kategori terlebih dahulu</option>
                        </select>
                        @error('jenis_barang_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-4 mb-3">
                        <label for="ruangan_id" class="form-label">Ruangan <span class="text-danger">*</span></label>
                        <select class="form-select @error('ruangan_id') is-invalid @enderror" id="ruangan_id" name="ruangan_id" required>
                            <option value="">Pilih Ruangan</option>
                            @foreach($ruangan as $r)
                                <option value="{{ $r->id }}" {{ old('ruangan_id') == $r->id ? 'selected' : '' }}>{{ $r->nama_ruangan }}</option>
                            @endforeach
                        </select>
                        @error('ruangan_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-4 mb-3">
                        <label for="tahun_id" class="form-label">Tahun <span class="text-danger">*</span></label>
                        <select class="form-select @error('tahun_id') is-invalid @enderror" id="tahun_id" name="tahun_id" required>
                            <option value="">Pilih Tahun</option>
                            @foreach($tahun as $t)
                                <option value="{{ $t->id }}" {{ old('tahun_id') == $t->id ? 'selected' : '' }}>{{ $t->tahun }}</option>
                            @endforeach
                        </select>
                        @error('tahun_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-4 mb-3">
                        <label for="harga_per_unit" class="form-label">Harga Per Unit <span class="text-danger">*</span></label>
                        <input type="number" class="form-control @error('harga_per_unit') is-invalid @enderror" id="harga_per_unit" name="harga_per_unit" value="{{ old('harga_per_unit') }}" min="0" step="0.01" required>
                        @error('harga_per_unit')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-6 mb-3">
                        <label for="deskripsi" class="form-label">Keterangan/Deskripsi</label>
                        <textarea class="form-control @error('deskripsi') is-invalid @enderror" id="deskripsi" name="deskripsi" rows="3">{{ old('deskripsi') }}</textarea>
                        @error('deskripsi')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="text-end">
                    <button type="submit" class="btn btn-primary"><i class="fas fa-save me-2"></i>Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const kategoriSelect = document.getElementById('kategori_id');
        const jenisBarangSelect = document.getElementById('jenis_barang_id');

        kategoriSelect.addEventListener('change', function() {
            const kategoriId = this.value;
            jenisBarangSelect.innerHTML = '<option value="">Memuat data...</option>';
            jenisBarangSelect.disabled = true;
            if (kategoriId) {
                fetch(`/assets/get-jenis-barang/${kategoriId}`)
                    .then(response => response.json())
                    .then(data => {
                        let options = '<option value="">Pilih Jenis Barang</option>';
                        data.forEach(function(jenis) {
                            options += `<option value="${jenis.id}">${jenis.nama_barang}</option>`;
                        });
                        jenisBarangSelect.innerHTML = options;
                        jenisBarangSelect.disabled = false;
                    });
            } else {
                jenisBarangSelect.innerHTML = '<option value="">Pilih Kategori terlebih dahulu</option>';
                jenisBarangSelect.disabled = true;
            }
        });
    });
</script>
@endsection 