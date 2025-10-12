<?php $__env->startSection('title', 'Data Barang - Sistem Manajemen Aset Klinik Firdaus'); ?>

<?php $__env->startSection('content'); ?>
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-0">Data Barang</h1>
            <p class="text-muted">Daftar seluruh aset/barang milik klinik</p>
        </div>
        <a href="<?php echo e(route('assets.create')); ?>" class="btn btn-primary">
            <i class="fas fa-plus me-2"></i>Tambah Barang
        </a>
    </div>

    <div class="card mb-3">
        <div class="card-body">
            <form method="GET" action="<?php echo e(route('assets.index')); ?>" class="row g-3 align-items-end">
                <div class="col-md-3">
                    <label for="kategori_id" class="form-label">Filter Berdasarkan Kategori</label>
                    <select class="form-select" id="kategori_id" name="kategori_id">
                        <option value="">Semua Kategori</option>
                        <?php $__currentLoopData = $kategori; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $kat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($kat->id); ?>" <?php echo e(request('kategori_id') == $kat->id ? 'selected' : ''); ?>><?php echo e($kat->nama_kategori); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-primary w-100"><i class="fas fa-filter me-2"></i>Filter</button>
                </div>
                <div class="col-md-2">
                    <a href="<?php echo e(route('assets.index')); ?>" class="btn btn-outline-secondary w-100"><i class="fas fa-sync-alt me-2"></i>Reset</a>
                </div>
            </form>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <h5 class="mb-0"><i class="fas fa-boxes me-2"></i>Daftar Barang</h5>
        </div>
        <div class="card-body">
            <?php if(count($dataBarang) > 0): ?>
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
                            <?php $__currentLoopData = $dataBarang; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $barang): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td><?php echo e($barang['no']); ?></td>
                                    <td><?php echo e($barang['kode_inventaris_dasar']); ?></td>
                                    <td><?php echo e($barang['nama_barang']); ?></td>
                                    <td><?php echo e($barang['kategori']); ?></td>
                                    <td>Rp <?php echo e(number_format($barang['harga_per_unit'] ?? 0, 0, ',', '.')); ?></td>
                                    <td><?php echo e($barang['jumlah']); ?></td>
                                    <td><?php echo e($barang['jumlah_baik']); ?></td>
                                    <td><?php echo e($barang['jumlah_rusak']); ?></td>
                                    <td>
                                        <a href="<?php echo e(route('assets.detail', ['kode_inventaris_dasar' => $barang['kode_inventaris_dasar']])); ?>" class="btn btn-sm btn-info" title="Lihat Detail Unit">
                                            <i class="fas fa-info-circle me-1"></i> Detail
                                        </a>
                                        <a href="<?php echo e(route('assets.editGroup', ['kode_inventaris_dasar' => $barang['kode_inventaris_dasar']])); ?>" class="btn btn-sm btn-outline-primary" title="Edit Grup Barang">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <?php
                                            $firstUnit = \App\Models\Asset::where('kode_inventaris', 'like', $barang['kode_inventaris_dasar'] . '.%')->orderBy('nomor_urut')->first();
                                        ?>
                                        <?php if($firstUnit): ?>
                                            <form action="<?php echo e(route('assets.destroy', $firstUnit->id)); ?>" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus barang ini beserta seluruh unitnya?')">
                                                <?php echo csrf_field(); ?>
                                                <?php echo method_field('DELETE'); ?>
                                                <button type="submit" class="btn btn-sm btn-outline-danger" title="Hapus Grup Barang"><i class="fas fa-trash"></i></button>
                                            </form>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                    </table>
                </div>
                <div class="d-flex justify-content-center mt-3">
                    <?php echo e($dataBarang->onEachSide(1)->links('pagination::bootstrap-5')); ?>

                </div>
            <?php else: ?>
                <div class="text-center py-4">
                    <i class="fas fa-boxes fa-3x text-muted mb-3"></i>
                    <h5 class="text-muted">Belum ada data barang</h5>
                    <p class="text-muted">Klik tombol "Tambah Barang" untuk menambahkan data pertama</p>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('styles'); ?>
<style>
.pagination { margin-bottom: 0; }
.pagination .page-link { padding: 0.25rem 0.6rem; font-size: 0.85rem; }
</style>
<?php $__env->stopPush(); ?> 
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\laragon\www\capstone-firdaus\resources\views/assets/index.blade.php ENDPATH**/ ?>