@extends('layouts.app')

@section('title', 'Master Data Jenis Barang - Sistem Manajemen Aset Klinik Firdaus')

@section('content')
<div class="container-fluid">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-0">Master Data Jenis Barang</h1>
            <p class="text-muted">Kelola data jenis barang klinik</p>
        </div>
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addJenisBarangModal">
            <i class="fas fa-plus me-2"></i>Tambah Jenis Barang
        </button>
    </div>

    <!-- Alert Messages -->
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

    <!-- Data Table -->
    @foreach($kategori as $kat)
        <div class="card mb-4">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0">Kategori: {{ $kat->kode_kategori }} ({{ str_pad($loop->iteration, 2, '0', STR_PAD_LEFT) }})</h5>
            </div>
            <div class="card-body">
                @if($kat->jenisBarang->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover">
                            <thead class="table-light">
                                <tr>
                                    <th>No</th>
                                    <th>Kode Barang</th>
                                    <th>Nama Barang</th>
                                    <th>Deskripsi</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($kat->jenisBarang as $index => $item)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>{{ $item->kode_barang }}</td>
                                        <td>{{ $item->nama_barang }}</td>
                                        <td>{{ $item->deskripsi ?? '-' }}</td>
                                        <td>
                                            <button type="button" class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#editJenisBarangModal{{ $item->id }}">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                            <form action="{{ route('master.jenis-barang.destroy', $item->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus jenis barang ini?')">
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
                    <div class="text-center py-3 text-muted">Belum ada jenis barang untuk kategori ini.</div>
                @endif
            </div>
        </div>
    @endforeach
</div>

<!-- Add Jenis Barang Modal -->
<div class="modal fade" id="addJenisBarangModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('master.jenis-barang.store') }}" method="POST">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title">Tambah Jenis Barang</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="kategori_id" class="form-label">Kategori <span class="text-danger">*</span></label>
                        <select class="form-select" id="kategori_id" name="kategori_id" required>
                            <option value="">Pilih Kategori</option>
                            @foreach($kategori as $kat)
                                <option value="{{ $kat->id }}">{{ $kat->nama_kategori }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="kode_barang" class="form-label">Kode Barang <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="kode_barang" name="kode_barang" maxlength="10" required>
                    </div>
                    <div class="mb-3">
                        <label for="nama_barang" class="form-label">Nama Barang <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="nama_barang" name="nama_barang" required>
                    </div>
                    <div class="mb-3">
                        <label for="deskripsi" class="form-label">Deskripsi</label>
                        <textarea class="form-control" id="deskripsi" name="deskripsi" rows="3"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Edit Jenis Barang Modals -->
@foreach($kategori as $kat)
    @foreach($kat->jenisBarang as $item)
        <div class="modal fade" id="editJenisBarangModal{{ $item->id }}" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form action="{{ route('master.jenis-barang.update', $item->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="modal-header">
                            <h5 class="modal-title">Edit Jenis Barang</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body">
                            <div class="mb-3">
                                <label for="nama_barang{{ $item->id }}" class="form-label">Nama Barang <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="nama_barang{{ $item->id }}" name="nama_barang" value="{{ $item->nama_barang }}" required>
                            </div>
                            <div class="mb-3">
                                <label for="kategori_id{{ $item->id }}" class="form-label">Kategori <span class="text-danger">*</span></label>
                                <select class="form-select" id="kategori_id{{ $item->id }}" name="kategori_id" required>
                                    <option value="">Pilih Kategori</option>
                                    @foreach($kategori as $katOpt)
                                        <option value="{{ $katOpt->id }}" {{ $item->kategori_id == $katOpt->id ? 'selected' : '' }}>{{ $katOpt->nama_kategori }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="kode_barang{{ $item->id }}" class="form-label">Kode Barang <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="kode_barang{{ $item->id }}" name="kode_barang" value="{{ $item->kode_barang }}" maxlength="10" required>
                            </div>
                            <div class="mb-3">
                                <label for="deskripsi{{ $item->id }}" class="form-label">Deskripsi</label>
                                <textarea class="form-control" id="deskripsi{{ $item->id }}" name="deskripsi" rows="3">{{ $item->deskripsi }}</textarea>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                            <button type="submit" class="btn btn-primary">Update</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endforeach
@endforeach

<!-- Delete Form -->
<form id="deleteForm" method="POST" style="display: none;">
    @csrf
    @method('DELETE')
</form>
@endsection

@section('scripts')
<script>
function confirmDelete(id, nama) {
    if (confirm(`Apakah Anda yakin ingin menghapus jenis barang "${nama}"?`)) {
        const form = document.getElementById('deleteForm');
        form.action = `/master/jenis-barang/${id}`;
        form.submit();
    }
}
</script>
@endsection 