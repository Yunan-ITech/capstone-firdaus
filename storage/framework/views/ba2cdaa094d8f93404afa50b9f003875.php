<?php $__env->startSection('title', 'Cetak Label Inventaris - Sistem Manajemen Aset Klinik Firdaus'); ?>

<?php $__env->startSection('content'); ?>
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
                        <?php $__currentLoopData = $ruangan; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $r): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($r->id); ?>" <?php echo e(request('ruangan_id') == $r->id ? 'selected' : ''); ?>><?php echo e($r->nama_ruangan); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>
                <div class="col-md-2">
                    <label for="kondisi_id" class="form-label">Kondisi</label>
                    <select class="form-select" id="kondisi_id" name="kondisi_id">
                        <option value="">Semua</option>
                        <?php $__currentLoopData = $kondisi; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $k): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($k->id); ?>" <?php echo e(request('kondisi_id') == $k->id ? 'selected' : ''); ?>><?php echo e($k->nama_kondisi); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>
                <div class="col-md-2">
                    <label for="tahun_id" class="form-label">Tahun</label>
                    <select class="form-select" id="tahun_id" name="tahun_id">
                        <option value="">Semua</option>
                        <?php $__currentLoopData = $tahun; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $t): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($t->id); ?>" <?php echo e(request('tahun_id') == $t->id ? 'selected' : ''); ?>><?php echo e($t->tahun); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>
                <div class="col-md-2">
                    <label for="kategori_id" class="form-label">Kategori</label>
                    <select class="form-select" id="kategori_id" name="kategori_id">
                        <option value="">Semua</option>
                        <?php $__currentLoopData = $kategori; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $kat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($kat->id); ?>" <?php echo e(request('kategori_id') == $kat->id ? 'selected' : ''); ?>><?php echo e($kat->nama_kategori); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>
                <div class="col-md-2">
                    <label for="jenis_barang_id" class="form-label">Jenis Barang</label>
                    <select class="form-select" id="jenis_barang_id" name="jenis_barang_id">
                        <option value="">Semua</option>
                        <?php $__currentLoopData = $jenisBarang; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $jenis): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($jenis->id); ?>" <?php echo e(request('jenis_barang_id') == $jenis->id ? 'selected' : ''); ?>><?php echo e($jenis->nama_barang); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
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
                <button type="button" class="btn btn-outline-secondary btn-sm" id="previewAllBtn" <?php echo e($assets->count() == 0 ? 'disabled' : ''); ?>><i class="fas fa-eye me-1"></i>Pratinjau Semua</button>
                <button type="button" class="btn btn-outline-info btn-sm" id="previewSelectedBtn" disabled><i class="fas fa-check-double me-1"></i>Pratinjau Terpilih</button>
                <button type="submit" form="printAllForm" class="btn btn-primary btn-sm" <?php echo e($assets->count() == 0 ? 'disabled' : ''); ?>><i class="fas fa-print me-1"></i>Cetak Semua Halaman</button>
            </div>
        </div>
        <div class="card-body">
            <?php if($assets->count() > 0): ?>
                <form method="POST" action="<?php echo e(route('labels.print')); ?>" target="_blank" id="printSelectedForm">
                    <?php echo csrf_field(); ?>
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
                                <?php $__currentLoopData = $assets; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $asset): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr>
                                        <td><input type="checkbox" class="asset-checkbox" name="asset_ids[]" value="<?php echo e($asset->id); ?>"></td>
                                        <td><strong><?php echo e($asset->kode_inventaris); ?></strong></td>
                                        <td><?php echo e($asset->jenisBarang->nama_barang ?? '-'); ?></td>
                                        <td><?php echo e($asset->ruangan->nama_ruangan ?? '-'); ?></td>
                                        <td><?php echo e($asset->kondisi->nama_kondisi ?? '-'); ?></td>
                                    </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </tbody>
                        </table>
                    </div>
                    <div class="d-flex justify-content-between align-items-center mt-3">
                        <button type="submit" class="btn btn-success" id="printSelectedBtn" disabled><i class="fas fa-print me-2"></i>Cetak Label Terpilih</button>
                        <?php echo e($assets->links('pagination::bootstrap-5')); ?>

                    </div>
                </form>
            <?php else: ?>
                <div class="text-center py-5">
                    <i class="fas fa-box-open fa-3x text-muted mb-3"></i>
                    <h5 class="text-muted">Data barang tidak ditemukan.</h5>
                    <p class="text-muted small">Silakan ubah kriteria filter Anda atau tambahkan data barang baru.</p>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<!-- Form untuk Cetak Semua (tersembunyi) -->
<form method="POST" action="<?php echo e(route('labels.print')); ?>" target="_blank" id="printAllForm" class="d-none">
    <?php echo csrf_field(); ?>
    <input type="hidden" name="ruangan_id" value="<?php echo e(request('ruangan_id')); ?>">
    <input type="hidden" name="kondisi_id" value="<?php echo e(request('kondisi_id')); ?>">
    <input type="hidden" name="tahun_id" value="<?php echo e(request('tahun_id')); ?>">
    <input type="hidden" name="kategori_id" value="<?php echo e(request('kategori_id')); ?>">
    <input type="hidden" name="jenis_barang_id" value="<?php echo e(request('jenis_barang_id')); ?>">
    <input type="hidden" name="print_all" value="1">
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
<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // --- Script untuk filter Jenis Barang dinamis ---
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
                    let options = '<option value="">Semua</option>';
                    data.forEach(function(jenis) {
                        options += `<option value="${jenis.id}">${jenis.nama_barang}</option>`;
                    });
                    jenisBarangSelect.innerHTML = options;
                    jenisBarangSelect.disabled = false;
                });
        } else {
            jenisBarangSelect.innerHTML = '<option value="">Semua</option>';
            jenisBarangSelect.disabled = false;
        }
    });

    // --- Script existing (checkbox, preview, dll) ---
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

        fetch("<?php echo e(route('labels.print')); ?>?preview=1", {
            method: 'POST',
            body: params,
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
                'X-CSRF-TOKEN': '<?php echo e(csrf_token()); ?>'
            }
        })
        .then(res => res.text())
        .then(html => {
            previewContent.innerHTML = html;
        });
    }

    if (previewSelectedBtn) {
        previewSelectedBtn.addEventListener('click', () => getPreview('printSelectedForm'));
    }
    
    document.getElementById('previewAllBtn')?.addEventListener('click', () => getPreview('printAllForm'));

    toggleButtons();
});
</script>
<?php $__env->stopSection(); ?> 
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\capstone-firdaus\resources\views/labels/index.blade.php ENDPATH**/ ?>