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

    <div class="card mb-3">
        <div class="card-body">
            <form method="GET" action="{{ route('assets.index') }}" class="row g-3 align-items-end">
                <div class="col-md-3">
                    <label for="kategori_id" class="form-label">Filter Berdasarkan Kategori</label>
                    <select class="form-select" id="kategori_id" name="kategori_id">
                        <option value="">Semua Kategori</option>
                        @foreach($kategori as $kat)
                            <option value="{{ $kat->id }}" {{ request('kategori_id') == $kat->id ? 'selected' : '' }}>{{ $kat->nama_kategori }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-primary w-100"><i class="fas fa-filter me-2"></i>Filter</button>
                </div>
                <div class="col-md-2">
                    <a href="{{ route('assets.index') }}" class="btn btn-outline-secondary w-100"><i class="fas fa-sync-alt me-2"></i>Reset</a>
                </div>
            </form>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <h5 class="mb-0"><i class="fas fa-boxes me-2"></i>Daftar Barang</h5>
        </div>
        <div class="card-body">
            @if(count($dataBarang) > 0)
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead class="table-light">
                            <tr>
                                <th>No</th>
                                <th>Kode Inventaris</th>
                                <th>Jenis Barang</th>
                                <th>Kategori</th>
                                <th>Harga Per Unit</th>
                                <th>Jumlah</th>
                                <th>Jumlah Baik</th>
                                <th>Jumlah Rusak</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($dataBarang as $barang)
                                <tr>
                                    <td>{{ $barang['no'] }}</td>
                                    <td>{{ $barang['kode_inventaris_dasar'] }}</td>
                                    <td>{{ $barang['nama_barang'] }}</td>
                                    <td>{{ $barang['kategori'] }}</td>
                                    <td>Rp {{ number_format($barang['harga_per_unit'] ?? 0, 0, ',', '.') }}</td>
                                    <td>{{ $barang['jumlah'] }}</td>
                                    <td>{{ $barang['jumlah_baik'] }}</td>
                                    <td>{{ $barang['jumlah_rusak'] }}</td>
                                    <td>
                                        <a href="{{ route('assets.detail', ['kode_inventaris_dasar' => $barang['kode_inventaris_dasar']]) }}" class="btn btn-sm btn-info" title="Lihat Detail Unit">
                                            <i class="fas fa-info-circle me-1"></i> Detail
                                        </a>
                                        <a href="{{ route('assets.editGroup', ['kode_inventaris_dasar' => $barang['kode_inventaris_dasar']]) }}" class="btn btn-sm btn-outline-primary" title="Edit Grup Barang">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        @php
                                            $firstUnit = \App\Models\Asset::where('kode_inventaris', 'like', $barang['kode_inventaris_dasar'] . '.%')->orderBy('nomor_urut')->first();
                                        @endphp
                                        @if($firstUnit)
                                            <form action="{{ route('assets.destroy', $firstUnit->id) }}" method="POST" class="d-inline" data-item-name="{{ $barang['kode_inventaris_dasar'] }}">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-outline-danger" title="Hapus Grup Barang"><i class="fas fa-trash"></i></button>
                                            </form>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="d-flex justify-content-center mt-3">
                    {{ $dataBarang->onEachSide(1)->links('pagination::bootstrap-5') }}
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

@push('styles')
<style>
.pagination { margin-bottom: 0; }
.pagination .page-link { padding: 0.25rem 0.6rem; font-size: 0.85rem; }
</style>
@endpush 