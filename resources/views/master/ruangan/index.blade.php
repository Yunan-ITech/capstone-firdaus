@extends('layouts.app')

@section('title', 'Master Data Ruangan - Sistem Manajemen Aset Klinik Firdaus')

@section('content')
<div class="container-fluid">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-0">Master Data Ruangan</h1>
            <p class="text-muted">Kelola data ruangan klinik</p>
        </div>
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addRuanganModal">
            <i class="fas fa-plus me-2"></i>Tambah Ruangan
        </button>
    </div>

    <!-- Alert Messages -->
    

    <!-- Data Table -->
    <div class="card">
        <div class="card-header">
            <h5 class="mb-0"><i class="fas fa-list me-2"></i>Daftar Ruangan</h5>
        </div>
        <div class="card-body">
            @if($ruangan->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead class="table-light">
                            <tr>
                                <th>No</th>
                                <th>Nama Ruangan</th>
                                <th>Deskripsi</th>
                                <th>Jumlah Barang</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($ruangan as $index => $item)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>
                                        <strong>{{ $item->nama_ruangan }}</strong>
                                    </td>
                                    <td>{{ $item->deskripsi ?? '-' }}</td>
                                    <td>
                                        <span class="badge bg-primary">{{ $item->assets_count ?? 0 }}</span>
                                    </td>
                                    <td>
                                        <button type="button" class="btn btn-sm btn-outline-primary" 
                                                data-bs-toggle="modal" 
                                                data-bs-target="#editRuanganModal{{ $item->id }}">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <button type="button" class="btn btn-sm btn-outline-danger" 
                                                onclick="confirmDelete({{ $item->id }}, '{{ $item->nama_ruangan }}')">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="text-center py-4">
                    <i class="fas fa-door-open fa-3x text-muted mb-3"></i>
                    <h5 class="text-muted">Belum ada data ruangan</h5>
                    <p class="text-muted">Klik tombol "Tambah Ruangan" untuk menambahkan data pertama</p>
                </div>
            @endif
        </div>
    </div>
</div>

<!-- Add Ruangan Modal -->
<div class="modal fade" id="addRuanganModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('master.ruangan.store') }}" method="POST">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title">Tambah Ruangan Baru</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="nama_ruangan" class="form-label">Nama Ruangan <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('nama_ruangan') is-invalid @enderror" 
                               id="nama_ruangan" name="nama_ruangan" value="{{ old('nama_ruangan') }}" required>
                        @error('nama_ruangan')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="deskripsi" class="form-label">Deskripsi</label>
                        <textarea class="form-control @error('deskripsi') is-invalid @enderror" 
                                  id="deskripsi" name="deskripsi" rows="3">{{ old('deskripsi') }}</textarea>
                        @error('deskripsi')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
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

<!-- Edit Ruangan Modals -->
@foreach($ruangan as $item)
<div class="modal fade" id="editRuanganModal{{ $item->id }}" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('master.ruangan.update', $item->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-header">
                    <h5 class="modal-title">Edit Ruangan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="nama_ruangan{{ $item->id }}" class="form-label">Nama Ruangan <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" 
                               id="nama_ruangan{{ $item->id }}" name="nama_ruangan" 
                               value="{{ $item->nama_ruangan }}" required>
                    </div>
                    <div class="mb-3">
                        <label for="deskripsi{{ $item->id }}" class="form-label">Deskripsi</label>
                        <textarea class="form-control" 
                                  id="deskripsi{{ $item->id }}" name="deskripsi" 
                                  rows="3">{{ $item->deskripsi }}</textarea>
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

<!-- Delete Form -->
<form id="deleteForm" method="POST" style="display: none;">
    @csrf
    @method('DELETE')
</form>
@endsection

@section('scripts')
<script>
function confirmDelete(id, nama) {
    if (confirm(`Apakah Anda yakin ingin menghapus ruangan "${nama}"?`)) {
        const form = document.getElementById('deleteForm');
        form.action = `/master/ruangan/${id}`;
        form.submit();
    }
}
</script>
@endsection 