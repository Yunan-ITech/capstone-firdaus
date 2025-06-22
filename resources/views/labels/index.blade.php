@extends('layouts.app')

@section('title', 'Cetak Label Inventaris - Sistem Manajemen Aset Klinik Firdaus')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-0">Cetak Label Inventaris</h1>
            <p class="text-muted">Pilih atau filter barang untuk mencetak label.</p>
        </div>
    </div>

    <!-- Filter Card -->
    <div class="card shadow-sm mb-4">
        <div class="card-header">
            <h5 class="mb-0"><i class="fas fa-filter me-2"></i>Filter Data Barang</h5>
        </div>
        <div class="card-body">
            <form method="GET" class="row g-3">
                <div class="col-md-2">
                    <label for="ruangan_id" class="form-label">Ruangan</label>
                    <select class="form-select" id="ruangan_id" name="ruangan_id">
                        <option value="">Semua</option>
                        @foreach($ruangan as $r)
                            <option value="{{ $r->id }}" {{ request('ruangan_id') == $r->id ? 'selected' : '' }}>{{ $r->nama_ruangan }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2">
                    <label for="kondisi_id" class="form-label">Kondisi</label>
                    <select class="form-select" id="kondisi_id" name="kondisi_id">
                        <option value="">Semua</option>
                        @foreach($kondisi as $k)
                            <option value="{{ $k->id }}" {{ request('kondisi_id') == $k->id ? 'selected' : '' }}>{{ $k->nama_kondisi }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2">
                    <label for="tahun_id" class="form-label">Tahun</label>
                    <select class="form-select" id="tahun_id" name="tahun_id">
                        <option value="">Semua</option>
                        @foreach($tahun as $t)
                            <option value="{{ $t->id }}" {{ request('tahun_id') == $t->id ? 'selected' : '' }}>{{ $t->tahun }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2">
                    <label for="kategori_id" class="form-label">Kategori</label>
                    <select class="form-select" id="kategori_id" name="kategori_id">
                        <option value="">Semua</option>
                        @foreach($kategori as $kat)
                            <option value="{{ $kat->id }}" {{ request('kategori_id') == $kat->id ? 'selected' : '' }}>{{ $kat->nama_kategori }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2">
                    <label for="jenis_barang_id" class="form-label">Jenis Barang</label>
                    <select class="form-select" id="jenis_barang_id" name="jenis_barang_id">
                        <option value="">Semua</option>
                        @foreach($jenisBarang as $jenis)
                            <option value="{{ $jenis->id }}" {{ request('jenis_barang_id') == $jenis->id ? 'selected' : '' }}>{{ $jenis->nama_barang }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2 d-flex align-items-end">
                    <button type="submit" class="btn btn-primary w-100"><i class="fas fa-search me-2"></i>Cari</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Results Card -->
    <div class="card shadow-sm">
        <div class="card-header d-flex justify-content-between align-items-center flex-wrap">
            <h5 class="mb-0"><i class="fas fa-tags me-2"></i>Hasil Pencarian</h5>
            <div class="mt-2 mt-md-0">
                <button type="button" class="btn btn-outline-secondary btn-sm" id="previewAllBtn" {{ $assets->count() == 0 ? 'disabled' : '' }}><i class="fas fa-eye me-1"></i>Pratinjau Semua</button>
                <button type="button" class="btn btn-outline-info btn-sm" id="previewSelectedBtn" disabled><i class="fas fa-check-double me-1"></i>Pratinjau Terpilih</button>
                <button type="submit" form="printAllForm" class="btn btn-primary btn-sm" {{ $assets->count() == 0 ? 'disabled' : '' }}><i class="fas fa-print me-1"></i>Cetak Semua Halaman</button>
            </div>
        </div>
        <div class="card-body">
            @if($assets->count() > 0)
                <form method="POST" action="{{ route('labels.print') }}" target="_blank" id="printSelectedForm">
                    @csrf
                    <div class="table-responsive">
                        <table class="table table-hover align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th><input type="checkbox" id="checkAll"></th>
                                    <th>Kode Inventaris</th>
                                    <th>Nama Barang</th>
                                    <th>Ruangan</th>
                                    <th>Kondisi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($assets as $asset)
                                    <tr>
                                        <td><input type="checkbox" class="asset-checkbox" name="asset_ids[]" value="{{ $asset->id }}"></td>
                                        <td><strong>{{ $asset->kode_inventaris }}</strong></td>
                                        <td>{{ $asset->jenisBarang->nama_barang ?? '-' }}</td>
                                        <td>{{ $asset->ruangan->nama_ruangan ?? '-' }}</td>
                                        <td>{{ $asset->kondisi->nama_kondisi ?? '-' }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="d-flex justify-content-between align-items-center mt-3">
                        <button type="submit" class="btn btn-success" id="printSelectedBtn" disabled><i class="fas fa-print me-2"></i>Cetak Label Terpilih</button>
                        {{ $assets->links('pagination::bootstrap-5') }}
                    </div>
                </form>
            @else
                <div class="text-center py-5">
                    <i class="fas fa-box-open fa-3x text-muted mb-3"></i>
                    <h5 class="text-muted">Data barang tidak ditemukan.</h5>
                    <p class="text-muted small">Silakan ubah kriteria filter Anda atau tambahkan data barang baru.</p>
                </div>
            @endif
        </div>
    </div>
</div>

<!-- Form untuk Cetak Semua (tersembunyi) -->
<form method="POST" action="{{ route('labels.print') }}" target="_blank" id="printAllForm" class="d-none">
    @csrf
    @foreach($assets as $asset)
        <input type="hidden" name="asset_ids[]" value="{{ $asset->id }}">
    @endforeach
</form>

<!-- Modal Pratinjau -->
<div class="modal fade" id="previewModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Pratinjau Label</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body" id="previewContent">
        <!-- Konten pratinjau akan dimuat di sini -->
      </div>
    </div>
  </div>
</div>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const checkAll = document.getElementById('checkAll');
    const assetCheckboxes = document.querySelectorAll('.asset-checkbox');
    const printSelectedBtn = document.getElementById('printSelectedBtn');
    const previewSelectedBtn = document.getElementById('previewSelectedBtn');

    function toggleButtons() {
        const checkedCount = document.querySelectorAll('.asset-checkbox:checked').length;
        if (printSelectedBtn) {
            printSelectedBtn.disabled = checkedCount === 0;
        }
        if (previewSelectedBtn) {
            previewSelectedBtn.disabled = checkedCount === 0;
        }
    }

    if (checkAll) {
        checkAll.addEventListener('change', function() {
            assetCheckboxes.forEach(cb => cb.checked = this.checked);
            toggleButtons();
        });
    }

    assetCheckboxes.forEach(cb => {
        cb.addEventListener('change', toggleButtons);
    });

    function getPreview(formId) {
        const form = document.getElementById(formId);
        if (!form) return;

        const formData = new FormData(form);
        const params = new URLSearchParams(formData).toString();

        const modal = new bootstrap.Modal(document.getElementById('previewModal'));
        const previewContent = document.getElementById('previewContent');
        previewContent.innerHTML = '<div class="text-center p-5"><span class="spinner-border"></span><p class="mt-2">Memuat pratinjau...</p></div>';
        modal.show();

        fetch("{{ route('labels.print') }}?preview=1", {
            method: 'POST',
            body: params,
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            }
        })
        .then(res => res.text())
        .then(html => {
            previewContent.innerHTML = `<iframe srcdoc="${html.replace(/"/g, '&quot;')}" style="width:100%; height: 60vh; border:none;"></iframe>`;
        });
    }

    if (previewSelectedBtn) {
        previewSelectedBtn.addEventListener('click', () => getPreview('printSelectedForm'));
    }
    
    document.getElementById('previewAllBtn')?.addEventListener('click', () => getPreview('printAllForm'));

    toggleButtons();
});
</script>
@endsection 