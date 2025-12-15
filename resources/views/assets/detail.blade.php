@extends('layouts.app')

@section('title', 'Detail Barang - Sistem Manajemen Aset Klinik Firdaus')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-0">Detail Barang: {{ $induk->jenisBarang->nama_barang ?? '' }}</h1>
            <p class="text-muted">Manajemen unit untuk: <strong>{{ $kode_inventaris_dasar }}</strong></p>
        </div>
        <a href="{{ route('assets.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left me-2"></i>Kembali
        </a>
    </div>

    <div class="card mb-4">
        <div class="card-header">
            <h5 class="mb-0">Tambah Unit Barang</h5>
        </div>
        <div class="card-body">
            <form action="{{ route('assets.addUnit', ['kode_inventaris_dasar' => $kode_inventaris_dasar]) }}" method="POST">
                @csrf
                <div class="row mb-3">
                    <div class="col-md-2 mb-3">
                        <label for="jumlah" class="form-label">Jumlah <span class="text-danger">*</span></label>
                        <input type="number" class="form-control" id="jumlah" name="jumlah" value="1" min="1" required>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Kode Inventaris Lengkap (Preview)</label>
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
                    <div class="col-md-1 mb-3">
                        <label for="tahun_id" class="form-label">Tahun <span class="text-danger">*</span></label>
                        <select class="form-select" id="tahun_id" disabled>
                            <option value="">Pilih Tahun</option>
                            @foreach($tahun as $t)
                                <option value="{{ $t->id }}" {{ $tahunInduk && $tahunInduk->id == $t->id ? 'selected' : '' }}>{{ $t->tahun }}</option>
                            @endforeach
                        </select>
                        <small class="form-text text-muted">Tahun otomatis mengikuti tahun pengadaan barang induk</small>
                    </div>
                    <div class="col-md-1 mb-3">
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
            <form method="GET" class="row g-2 mb-3">
                <div class="col-md-3">
                    <select class="form-select" name="filter_ruangan">
                        <option value="">Semua Ruangan</option>
                        @foreach($ruangan as $r)
                            <option value="{{ $r->id }}" {{ request('filter_ruangan') == $r->id ? 'selected' : '' }}>{{ $r->nama_ruangan }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3">
                    <select class="form-select" name="filter_tahun">
                        <option value="">Semua Tahun</option>
                        @foreach($tahun as $t)
                            <option value="{{ $t->id }}" {{ request('filter_tahun') == $t->id ? 'selected' : '' }}>{{ $t->tahun }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3">
                    <select class="form-select" name="filter_kondisi">
                        <option value="">Semua Kondisi</option>
                        @foreach($kondisi as $k)
                            <option value="{{ $k->id }}" {{ request('filter_kondisi') == $k->id ? 'selected' : '' }}>{{ $k->nama_kondisi }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3">
                    <button type="submit" class="btn btn-outline-primary w-100"><i class="fas fa-filter me-2"></i>Filter</button>
                </div>
            </form>
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Kode Inventaris Lengkap</th>
                            <th>Ruangan</th>
                            <th>Tahun</th>
                            <th>Kondisi</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($units as $i => $unit)
                            <tr>
                                <td>{{ ($units->currentPage() - 1) * $units->perPage() + $loop->iteration }}</td>
                                <td>{{ $unit->kode_inventaris }}</td>
                                <td>{{ $unit->ruangan->nama_ruangan ?? '-' }}</td>
                                <td>{{ $unit->tahun->tahun ?? '-' }}</td>
                                <td>{{ $unit->kondisi->nama_kondisi ?? '-' }}</td>
                                <td>
                                    <button type="button" class="btn btn-sm btn-info" data-bs-toggle="modal" data-bs-target="#detailIndukModal">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                    <button type="button" class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#editUnitModal{{ $unit->id }}">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <form action="{{ route('assets.deleteUnit', $unit->id) }}" method="POST" class="d-inline" data-item-name="{{ $unit->kode_inventaris }}">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger"><i class="fas fa-trash"></i></button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="d-flex justify-content-center mt-3">
                    {{ $units->onEachSide(1)->links('pagination::bootstrap-5') }}
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Detail Barang Induk -->
<div class="modal fade" id="detailIndukModal" tabindex="-1" aria-labelledby="detailIndukModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="detailIndukModalLabel">Informasi Barang Induk</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <strong>Kode Inventaris Dasar:</strong>
                        <p>{{ $kode_inventaris_dasar }}</p>
                    </div>
                    <div class="col-md-6 mb-3">
                        <strong>Nama Barang:</strong>
                        <p>{{ $induk->jenisBarang->nama_barang ?? '-' }}</p>
                    </div>
                    <div class="col-md-6 mb-3">
                        <strong>Kategori:</strong>
                        <p>{{ $induk->kategori->nama_kategori ?? '-' }}</p>
                    </div>
                    <div class="col-md-6 mb-3">
                        <strong>Tahun Pengadaan:</strong>
                        <p>{{ $induk->tahun->tahun ?? '-' }}</p>
                    </div>
                    <div class="col-md-6 mb-3">
                        <strong>Harga Per Unit:</strong>
                        <p>Rp {{ number_format($induk->harga_per_unit ?? 0, 0, ',', '.') }}</p>
                    </div>
                    <div class="col-md-12">
                        <strong>Deskripsi:</strong>
                        <p class="text-muted">{{ $induk->deskripsi ?? 'Tidak ada deskripsi.' }}</p>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal Edit Unit -->
@foreach($units as $unit)
<div class="modal fade" id="editUnitModal{{ $unit->id }}" tabindex="-1" aria-labelledby="editUnitModalLabel{{ $unit->id }}" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('assets.updateUnit', $unit->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-header">
                    <h5 class="modal-title" id="editUnitModalLabel{{ $unit->id }}">Edit Unit Barang</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Kode Inventaris Lengkap</label>
                        <input type="text" class="form-control" value="{{ $unit->kode_inventaris }}" readonly>
                    </div>
                    <div class="mb-3">
                        <label for="ruangan_id{{ $unit->id }}" class="form-label">Ruangan <span class="text-danger">*</span></label>
                        <select class="form-select" id="ruangan_id{{ $unit->id }}" name="ruangan_id" required>
                            <option value="">Pilih Ruangan</option>
                            @foreach($ruangan as $r)
                                <option value="{{ $r->id }}" {{ $unit->ruangan_id == $r->id ? 'selected' : '' }}>{{ $r->nama_ruangan }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="tahun_id{{ $unit->id }}" class="form-label">Tahun <span class="text-danger">*</span></label>
                        <input type="hidden" name="tahun_id" value="{{ $unit->tahun_id }}">
                        <select class="form-select" id="tahun_id{{ $unit->id }}" disabled>
                            <option value="">Pilih Tahun</option>
                            @foreach($tahun as $t)
                                <option value="{{ $t->id }}" {{ $unit->tahun_id == $t->id ? 'selected' : '' }}>{{ $t->tahun }}</option>
                            @endforeach
                        </select>
                        <small class="form-text text-muted">Tahun tidak dapat diubah</small>
                    </div>
                    <div class="mb-3">
                        <label for="kondisi_id{{ $unit->id }}" class="form-label">Kondisi <span class="text-danger">*</span></label>
                        <select class="form-select" id="kondisi_id{{ $unit->id }}" name="kondisi_id" required>
                            <option value="">Pilih Kondisi</option>
                            @foreach($kondisi as $k)
                                <option value="{{ $k->id }}" {{ $unit->kondisi_id == $k->id ? 'selected' : '' }}>{{ $k->nama_kondisi }}</option>
                            @endforeach
                        </select>
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

@push('styles')
<style>
.pagination { margin-bottom: 0; }
.pagination .page-link { padding: 0.25rem 0.6rem; font-size: 0.85rem; }
</style>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Pastikan tahun terisi otomatis dan tidak bisa diubah
    const tahunSelect = document.getElementById('tahun_id');
    
    if (tahunSelect) {
        // Tambahkan visual indicator bahwa field ini otomatis
        tahunSelect.style.backgroundColor = '#f8f9fa';
        tahunSelect.style.cursor = 'not-allowed';
        
        // Prevent any interaction dengan select
        tahunSelect.addEventListener('click', function(e) {
            e.preventDefault();
            return false;
        });
        
        tahunSelect.addEventListener('keydown', function(e) {
            e.preventDefault();
            return false;
        });
    }
});
</script>
@endpush
@endsection 