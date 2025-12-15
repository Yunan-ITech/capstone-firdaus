<?php $__env->startSection('title', 'Detail Barang - Sistem Manajemen Aset Klinik Firdaus'); ?>

<?php $__env->startSection('content'); ?>
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-0">Detail Barang: <?php echo e($induk->jenisBarang->nama_barang ?? ''); ?></h1>
            <p class="text-muted">Manajemen unit untuk: <strong><?php echo e($kode_inventaris_dasar); ?></strong></p>
        </div>
        <a href="<?php echo e(route('assets.index')); ?>" class="btn btn-secondary">
            <i class="fas fa-arrow-left me-2"></i>Kembali
        </a>
    </div>

    <div class="card mb-4">
        <div class="card-header">
            <h5 class="mb-0">Tambah Unit Barang</h5>
        </div>
        <div class="card-body">
            <form action="<?php echo e(route('assets.addUnit', ['kode_inventaris_dasar' => $kode_inventaris_dasar])); ?>" method="POST">
                <?php echo csrf_field(); ?>
                <div class="row mb-3">
                    <div class="col-md-2 mb-3">
                        <label for="jumlah" class="form-label">Jumlah <span class="text-danger">*</span></label>
                        <input type="number" class="form-control" id="jumlah" name="jumlah" value="1" min="1" required>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Kode Inventaris Lengkap (Preview)</label>
                        <input type="text" class="form-control" value="<?php echo e($kode_inventaris_dasar . '.' . str_pad($units->max('nomor_urut')+1, 3, '0', STR_PAD_LEFT)); ?>" readonly>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label for="ruangan_id" class="form-label">Ruangan <span class="text-danger">*</span></label>
                        <select class="form-select" id="ruangan_id" name="ruangan_id" required>
                            <option value="">Pilih Ruangan</option>
                            <?php $__currentLoopData = $ruangan; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $r): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($r->id); ?>"><?php echo e($r->nama_ruangan); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>
                    <div class="col-md-1 mb-3">
                        <label for="tahun_id" class="form-label">Tahun <span class="text-danger">*</span></label>
                        <select class="form-select" id="tahun_id" disabled>
                            <option value="">Pilih Tahun</option>
                            <?php $__currentLoopData = $tahun; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $t): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($t->id); ?>" <?php echo e($tahunInduk && $tahunInduk->id == $t->id ? 'selected' : ''); ?>><?php echo e($t->tahun); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                        <small class="form-text text-muted">Tahun otomatis mengikuti tahun pengadaan barang induk</small>
                    </div>
                    <div class="col-md-1 mb-3">
                        <label for="kondisi_id" class="form-label">Kondisi <span class="text-danger">*</span></label>
                        <select class="form-select" id="kondisi_id" name="kondisi_id" required>
                            <option value="">Pilih Kondisi</option>
                            <?php $__currentLoopData = $kondisi; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $k): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($k->id); ?>"><?php echo e($k->nama_kondisi); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
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
                        <?php $__currentLoopData = $ruangan; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $r): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($r->id); ?>" <?php echo e(request('filter_ruangan') == $r->id ? 'selected' : ''); ?>><?php echo e($r->nama_ruangan); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>
                <div class="col-md-3">
                    <select class="form-select" name="filter_tahun">
                        <option value="">Semua Tahun</option>
                        <?php $__currentLoopData = $tahun; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $t): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($t->id); ?>" <?php echo e(request('filter_tahun') == $t->id ? 'selected' : ''); ?>><?php echo e($t->tahun); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>
                <div class="col-md-3">
                    <select class="form-select" name="filter_kondisi">
                        <option value="">Semua Kondisi</option>
                        <?php $__currentLoopData = $kondisi; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $k): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($k->id); ?>" <?php echo e(request('filter_kondisi') == $k->id ? 'selected' : ''); ?>><?php echo e($k->nama_kondisi); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
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
                        <?php $__currentLoopData = $units; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i => $unit): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr>
                                <td><?php echo e(($units->currentPage() - 1) * $units->perPage() + $loop->iteration); ?></td>
                                <td><?php echo e($unit->kode_inventaris); ?></td>
                                <td><?php echo e($unit->ruangan->nama_ruangan ?? '-'); ?></td>
                                <td><?php echo e($unit->tahun->tahun ?? '-'); ?></td>
                                <td><?php echo e($unit->kondisi->nama_kondisi ?? '-'); ?></td>
                                <td>
                                    <button type="button" class="btn btn-sm btn-info" data-bs-toggle="modal" data-bs-target="#detailIndukModal">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                    <button type="button" class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#editUnitModal<?php echo e($unit->id); ?>">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <form action="<?php echo e(route('assets.deleteUnit', $unit->id)); ?>" method="POST" class="d-inline" data-item-name="<?php echo e($unit->kode_inventaris); ?>">
                                        <?php echo csrf_field(); ?>
                                        <?php echo method_field('DELETE'); ?>
                                        <button type="submit" class="btn btn-sm btn-outline-danger"><i class="fas fa-trash"></i></button>
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tbody>
                </table>
                <div class="d-flex justify-content-center mt-3">
                    <?php echo e($units->onEachSide(1)->links('pagination::bootstrap-5')); ?>

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
                        <p><?php echo e($kode_inventaris_dasar); ?></p>
                    </div>
                    <div class="col-md-6 mb-3">
                        <strong>Nama Barang:</strong>
                        <p><?php echo e($induk->jenisBarang->nama_barang ?? '-'); ?></p>
                    </div>
                    <div class="col-md-6 mb-3">
                        <strong>Kategori:</strong>
                        <p><?php echo e($induk->kategori->nama_kategori ?? '-'); ?></p>
                    </div>
                    <div class="col-md-6 mb-3">
                        <strong>Tahun Pengadaan:</strong>
                        <p><?php echo e($induk->tahun->tahun ?? '-'); ?></p>
                    </div>
                    <div class="col-md-6 mb-3">
                        <strong>Harga Per Unit:</strong>
                        <p>Rp <?php echo e(number_format($induk->harga_per_unit ?? 0, 0, ',', '.')); ?></p>
                    </div>
                    <div class="col-md-12">
                        <strong>Deskripsi:</strong>
                        <p class="text-muted"><?php echo e($induk->deskripsi ?? 'Tidak ada deskripsi.'); ?></p>
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
<?php $__currentLoopData = $units; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $unit): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
<div class="modal fade" id="editUnitModal<?php echo e($unit->id); ?>" tabindex="-1" aria-labelledby="editUnitModalLabel<?php echo e($unit->id); ?>" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="<?php echo e(route('assets.updateUnit', $unit->id)); ?>" method="POST">
                <?php echo csrf_field(); ?>
                <?php echo method_field('PUT'); ?>
                <div class="modal-header">
                    <h5 class="modal-title" id="editUnitModalLabel<?php echo e($unit->id); ?>">Edit Unit Barang</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Kode Inventaris Lengkap</label>
                        <input type="text" class="form-control" value="<?php echo e($unit->kode_inventaris); ?>" readonly>
                    </div>
                    <div class="mb-3">
                        <label for="ruangan_id<?php echo e($unit->id); ?>" class="form-label">Ruangan <span class="text-danger">*</span></label>
                        <select class="form-select" id="ruangan_id<?php echo e($unit->id); ?>" name="ruangan_id" required>
                            <option value="">Pilih Ruangan</option>
                            <?php $__currentLoopData = $ruangan; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $r): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($r->id); ?>" <?php echo e($unit->ruangan_id == $r->id ? 'selected' : ''); ?>><?php echo e($r->nama_ruangan); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="tahun_id<?php echo e($unit->id); ?>" class="form-label">Tahun <span class="text-danger">*</span></label>
                        <input type="hidden" name="tahun_id" value="<?php echo e($unit->tahun_id); ?>">
                        <select class="form-select" id="tahun_id<?php echo e($unit->id); ?>" disabled>
                            <option value="">Pilih Tahun</option>
                            <?php $__currentLoopData = $tahun; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $t): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($t->id); ?>" <?php echo e($unit->tahun_id == $t->id ? 'selected' : ''); ?>><?php echo e($t->tahun); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                        <small class="form-text text-muted">Tahun tidak dapat diubah</small>
                    </div>
                    <div class="mb-3">
                        <label for="kondisi_id<?php echo e($unit->id); ?>" class="form-label">Kondisi <span class="text-danger">*</span></label>
                        <select class="form-select" id="kondisi_id<?php echo e($unit->id); ?>" name="kondisi_id" required>
                            <option value="">Pilih Kondisi</option>
                            <?php $__currentLoopData = $kondisi; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $k): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($k->id); ?>" <?php echo e($unit->kondisi_id == $k->id ? 'selected' : ''); ?>><?php echo e($k->nama_kondisi); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
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
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

<?php $__env->startPush('styles'); ?>
<style>
.pagination { margin-bottom: 0; }
.pagination .page-link { padding: 0.25rem 0.6rem; font-size: 0.85rem; }
</style>
<?php $__env->stopPush(); ?>

<?php $__env->startPush('scripts'); ?>
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
<?php $__env->stopPush(); ?>
<?php $__env->stopSection(); ?> 
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\capstone-firdaus\resources\views/assets/detail.blade.php ENDPATH**/ ?>