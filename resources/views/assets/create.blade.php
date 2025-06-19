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
                        <label for="nomor_urut" class="form-label">Nomor Urut <span class="text-danger">*</span></label>
                        <input type="number" class="form-control @error('nomor_urut') is-invalid @enderror" id="nomor_urut" name="nomor_urut" value="{{ old('nomor_urut') }}" required>
                        @error('nomor_urut')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-6 mb-3">
                        <label for="jenis_barang_id" class="form-label">Nama Barang <span class="text-danger">*</span></label>
                        <select class="form-select @error('jenis_barang_id') is-invalid @enderror" id="jenis_barang_id" name="jenis_barang_id" required>
                            <option value="">Pilih Jenis Barang</option>
                            @foreach($jenisBarang as $jenis)
                                <option value="{{ $jenis->id }}" {{ old('jenis_barang_id') == $jenis->id ? 'selected' : '' }}>{{ $jenis->nama_barang }}</option>
                            @endforeach
                        </select>
                        @error('jenis_barang_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
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
                        <label for="kondisi_id" class="form-label">Kondisi <span class="text-danger">*</span></label>
                        <select class="form-select @error('kondisi_id') is-invalid @enderror" id="kondisi_id" name="kondisi_id" required>
                            <option value="">Pilih Kondisi</option>
                            @foreach($kondisi as $k)
                                <option value="{{ $k->id }}" {{ old('kondisi_id') == $k->id ? 'selected' : '' }}>{{ $k->nama_kondisi }}</option>
                            @endforeach
                        </select>
                        @error('kondisi_id')
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