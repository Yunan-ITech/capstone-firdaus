@extends('layouts.app')

@section('title', 'Master Data Tahun - Sistem Manajemen Aset Klinik Firdaus')

@section('content')
<div class="container-fluid">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-0">Master Data Tahun</h1>
            <p class="text-muted">Kelola data tahun pengadaan barang</p>
        </div>
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addTahunModal">
            <i class="fas fa-plus me-2"></i>Tambah Tahun
        </button>
    </div>

    <!-- Alert Messages -->
    

    <!-- Data Table -->
    <div class="card">
        <div class="card-header">
            <h5 class="mb-0"><i class="fas fa-list me-2"></i>Daftar Tahun</h5>
        </div>
        <div class="card-body">
            @if($tahun->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead class="table-light">
                            <tr>
                                <th>No</th>
                                <th>Tahun</th>
                                <th>Deskripsi</th>
                                <th>Jumlah Barang</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($tahun as $index => $item)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>
                                        <strong>{{ $item->tahun }}</strong>
                                    </td>
                                    <td>{{ $item->deskripsi ?? '-' }}</td>
                                    <td>
                                        <span class="badge bg-primary">{{ $item->assets_count ?? 0 }}</span>
                                    </td>
                                    <td>
                                        @if($item->tahun == date('Y'))
                                            <span class="badge bg-success">Tahun Ini</span>
                                        @elseif($item->tahun > date('Y'))
                                            <span class="badge bg-warning">Masa Depan</span>
                                        @else
                                            <span class="badge bg-secondary">Tahun Lalu</span>
                                        @endif
                                    </td>
                                    <td>
                                        <button type="button" class="btn btn-sm btn-outline-primary" 
                                                data-bs-toggle="modal" 
                                                data-bs-target="#editTahunModal{{ $item->id }}">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <form action="{{ route('master.tahun.destroy', $item->id) }}" method="POST" class="d-inline" data-item-name="{{ $item->tahun }}">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="text-center py-4">
                    <i class="fas fa-calendar fa-3x text-muted mb-3"></i>
                    <h5 class="text-muted">Belum ada data tahun</h5>
                    <p class="text-muted">Klik tombol "Tambah Tahun" untuk menambahkan data pertama</p>
                </div>
            @endif
        </div>
    </div>
</div>

<!-- Add Tahun Modal -->
<div class="modal fade" id="addTahunModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('master.tahun.store') }}" method="POST">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title">Tambah Tahun Baru</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="tahun" class="form-label">Tahun <span class="text-danger">*</span></label>
                        <input type="number" class="form-control @error('tahun') is-invalid @enderror" 
                               id="tahun" name="tahun" value="{{ old('tahun', date('Y')) }}" 
                               min="2000" max="2100" required>
                        @error('tahun')
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

<!-- Edit Tahun Modals -->
@foreach($tahun as $item)
<div class="modal fade" id="editTahunModal{{ $item->id }}" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('master.tahun.update', $item->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-header">
                    <h5 class="modal-title">Edit Tahun</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="tahun{{ $item->id }}" class="form-label">Tahun <span class="text-danger">*</span></label>
                        <input type="number" class="form-control" 
                               id="tahun{{ $item->id }}" name="tahun" 
                               value="{{ $item->tahun }}" min="2000" max="2100" required>
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
</script>
@endsection 