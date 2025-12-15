@extends('layouts.app')

@section('title', 'Master Data Kondisi - Sistem Manajemen Aset Klinik Firdaus')

@section('content')
<div class="container-fluid">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-0">Master Data Kondisi</h1>
            <p class="text-muted">Kelola data kondisi barang</p>
        </div>
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addKondisiModal">
            <i class="fas fa-plus me-2"></i>Tambah Kondisi
        </button>
    </div>

    <!-- Alert Messages -->
    

    <!-- Data Table -->
    <div class="card">
        <div class="card-header">
            <h5 class="mb-0"><i class="fas fa-list me-2"></i>Daftar Kondisi</h5>
        </div>
        <div class="card-body">
            @if($kondisi->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead class="table-light">
                            <tr>
                                <th>No</th>
                                <th>Nama Kondisi</th>
                                <th>Deskripsi</th>
                                <th>Warna</th>
                                <th>Jumlah Barang</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($kondisi as $index => $item)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>
                                        <strong>{{ $item->nama_kondisi }}</strong>
                                    </td>
                                    <td>{{ $item->deskripsi ?? '-' }}</td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="color-preview me-2" 
                                                 style="width: 20px; height: 20px; background-color: {{ $item->warna ?? '#6c757d' }}; border-radius: 4px;"></div>
                                            <span class="text-muted">{{ $item->warna ?? '#6c757d' }}</span>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="badge bg-primary">{{ $item->assets_count ?? 0 }}</span>
                                    </td>
                                    <td>
                                        <button type="button" class="btn btn-sm btn-outline-primary" 
                                                data-bs-toggle="modal" 
                                                data-bs-target="#editKondisiModal{{ $item->id }}">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <form action="{{ route('master.kondisi.destroy', $item->id) }}" method="POST" class="d-inline" data-item-name="{{ $item->nama_kondisi }}">
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
                    <i class="fas fa-clipboard-check fa-3x text-muted mb-3"></i>
                    <h5 class="text-muted">Belum ada data kondisi</h5>
                    <p class="text-muted">Klik tombol "Tambah Kondisi" untuk menambahkan data pertama</p>
                </div>
            @endif
        </div>
    </div>
</div>

<!-- Add Kondisi Modal -->
<div class="modal fade" id="addKondisiModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('master.kondisi.store') }}" method="POST">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title">Tambah Kondisi Baru</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="nama_kondisi" class="form-label">Nama Kondisi <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('nama_kondisi') is-invalid @enderror" 
                               id="nama_kondisi" name="nama_kondisi" value="{{ old('nama_kondisi') }}" required>
                        @error('nama_kondisi')
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
                    <div class="mb-3">
                        <label for="warna" class="form-label">Warna</label>
                        <input type="color" class="form-control form-control-color @error('warna') is-invalid @enderror" 
                               id="warna" name="warna" value="{{ old('warna', '#6c757d') }}" title="Pilih warna">
                        @error('warna')
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

<!-- Edit Kondisi Modals -->
@foreach($kondisi as $item)
<div class="modal fade" id="editKondisiModal{{ $item->id }}" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('master.kondisi.update', $item->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-header">
                    <h5 class="modal-title">Edit Kondisi</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="nama_kondisi{{ $item->id }}" class="form-label">Nama Kondisi <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" 
                               id="nama_kondisi{{ $item->id }}" name="nama_kondisi" 
                               value="{{ $item->nama_kondisi }}" required>
                    </div>
                    <div class="mb-3">
                        <label for="deskripsi{{ $item->id }}" class="form-label">Deskripsi</label>
                        <textarea class="form-control" 
                                  id="deskripsi{{ $item->id }}" name="deskripsi" 
                                  rows="3">{{ $item->deskripsi }}</textarea>
                    </div>
                    <div class="mb-3">
                        <label for="warna{{ $item->id }}" class="form-label">Warna</label>
                        <input type="color" class="form-control form-control-color" 
                               id="warna{{ $item->id }}" name="warna" 
                               value="{{ $item->warna ?? '#6c757d' }}" title="Pilih warna">
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

<div class="modal fade" id="deleteKondisiModal{{ $item->id }}" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('master.kondisi.destroy', $item->id) }}" method="POST">
                @csrf
                @method('DELETE')
                <div class="modal-header">
                    <h5 class="modal-title">Hapus Kondisi</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <p>Apakah Anda yakin ingin menghapus kondisi "{{ $item->nama_kondisi }}"?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-danger">Hapus</button>
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
    if (confirm(`Apakah Anda yakin ingin menghapus kondisi "${nama}"?`)) {
        const form = document.getElementById('deleteForm');
        form.action = `/master/kondisi/${id}`;
        form.submit();
    }
}
</script>
@endsection 