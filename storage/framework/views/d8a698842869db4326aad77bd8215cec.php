<?php $__env->startSection('title', 'Laporan Data Barang - Sistem Manajemen Aset Klinik Firdaus'); ?>

<?php $__env->startSection('content'); ?>
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-0">Laporan Data Aset</h1>
            <p class="text-muted">Laporan rekapitulasi aset/barang</p>
        </div>
    </div>

    <!-- Filter Card -->
    <div class="card shadow-sm mb-4">
        <div class="card-header">
            <h5 class="mb-0"><i class="fas fa-filter me-2"></i>Filter Laporan</h5>
        </div>
        <div class="card-body">
            <form method="GET" action="<?php echo e(route('reports.index')); ?>" class="row g-3 align-items-end">
                <div class="col-md-3">
                    <label for="kategori_id" class="form-label">Kategori</label>
                    <select class="form-select" id="kategori_id" name="kategori_id">
                        <option value="">Semua Kategori</option>
                        <?php $__currentLoopData = $kategori; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $kat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($kat->id); ?>" <?php echo e(request('kategori_id') == $kat->id ? 'selected' : ''); ?>><?php echo e($kat->nama_kategori); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>
                <div class="col-md-3">
                    <label for="ruangan_id" class="form-label">Ruangan</label>
                    <select class="form-select" id="ruangan_id" name="ruangan_id">
                        <option value="">Semua Ruangan</option>
                        <?php $__currentLoopData = $ruangan; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $r): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($r->id); ?>" <?php echo e(request('ruangan_id') == $r->id ? 'selected' : ''); ?>><?php echo e($r->nama_ruangan); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>
                <div class="col-md-3">
                    <label for="kondisi_id" class="form-label">Kondisi</label>
                    <select class="form-select" id="kondisi_id" name="kondisi_id">
                        <option value="">Semua Kondisi</option>
                        <?php $__currentLoopData = $kondisi; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $k): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($k->id); ?>" <?php echo e(request('kondisi_id') == $k->id ? 'selected' : ''); ?>><?php echo e($k->nama_kondisi); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>
                <div class="col-md-3 d-flex gap-2">
                    <button type="submit" class="btn btn-primary w-100"><i class="fas fa-search me-2"></i>Terapkan</button>
                    <a href="<?php echo e(route('reports.index')); ?>" class="btn btn-secondary w-100">Reset</a>
                </div>
            </form>
        </div>
    </div>

    <!-- Report Results Card -->
    <div class="card shadow-sm">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0"><i class="fas fa-table me-2"></i>Hasil Laporan</h5>
            <div class="dropdown">
                <button class="btn btn-success btn-sm dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false" <?php echo e(count($reportData) == 0 ? 'disabled' : ''); ?>>
                    <i class="fas fa-download me-2"></i>Download Laporan
                </button>
                <ul class="dropdown-menu dropdown-menu-end">
                    <li><a class="dropdown-item" href="<?php echo e(route('reports.export', array_merge(request()->query(), ['format' => 'xlsx']))); ?>" target="_blank">Excel (.xlsx)</a></li>
                    <li><a class="dropdown-item" href="<?php echo e(route('reports.export', array_merge(request()->query(), ['format' => 'pdf']))); ?>" target="_blank">PDF</a></li>
                </ul>
            </div>
        </div>
        <div class="card-body">
            <?php if(count($reportData) > 0): ?>
                <div class="table-responsive">
                    <table class="table table-hover table-bordered">
                        <thead class="table-light">
                            <tr>
                                <th>No</th>
                                <th>Kode Inventaris</th>
                                <th>Nama Barang</th>
                                <th>Kategori</th>
                                <th>Ruangan</th>
                                <th>Kondisi</th>
                                <th>Harga/Unit</th>
                                <th>Jumlah</th>
                                <th>Th. Pengadaan</th>
                                <th>Harga Perolehan</th>
                                <th>Deskripsi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__currentLoopData = $reportData; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $data): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td><?php echo e($data['no']); ?></td>
                                    <td><?php echo e($data['kode_inventaris']); ?></td>
                                    <td><?php echo e($data['nama_barang']); ?></td>
                                    <td><?php echo e($data['kategori']); ?></td>
                                    <td><?php echo e($data['ruangan']); ?></td>
                                    <td><?php echo e($data['kondisi']); ?></td>
                                    <td><?php echo e('Rp ' . number_format($data['harga_per_unit'], 0, ',', '.')); ?></td>
                                    <td><?php echo e($data['jumlah']); ?></td>
                                    <td><?php echo e($data['tahun_pengadaan']); ?></td>
                                    <td><?php echo e('Rp ' . number_format($data['harga_perolehan'], 0, ',', '.')); ?></td>
                                    <td><?php echo e($data['deskripsi']); ?></td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                    </table>
                </div>
                <div class="d-flex justify-content-center mt-3">
                    <?php echo e($reportData->links('pagination::bootstrap-5')); ?>

                </div>
            <?php else: ?>
                <div class="text-center py-5">
                    <i class="fas fa-file-alt fa-3x text-muted mb-3"></i>
                    <h5 class="text-muted">Tidak ada data untuk dilaporkan.</h5>
                    <p class="small text-muted">Silakan sesuaikan filter Anda atau tambahkan data aset.</p>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?> 
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\capstone-firdaus\resources\views/reports/index.blade.php ENDPATH**/ ?>