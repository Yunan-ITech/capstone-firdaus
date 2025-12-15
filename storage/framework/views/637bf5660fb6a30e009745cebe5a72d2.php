<?php $__env->startSection('title', 'Master Data Kondisi - Sistem Manajemen Aset Klinik Firdaus'); ?>

<?php $__env->startSection('content'); ?>
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
            <?php if($kondisi->count() > 0): ?>
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
                            <?php $__currentLoopData = $kondisi; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td><?php echo e($index + 1); ?></td>
                                    <td>
                                        <strong><?php echo e($item->nama_kondisi); ?></strong>
                                    </td>
                                    <td><?php echo e($item->deskripsi ?? '-'); ?></td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="color-preview me-2" 
                                                 style="width: 20px; height: 20px; background-color: <?php echo e($item->warna ?? '#6c757d'); ?>; border-radius: 4px;"></div>
                                            <span class="text-muted"><?php echo e($item->warna ?? '#6c757d'); ?></span>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="badge bg-primary"><?php echo e($item->assets_count ?? 0); ?></span>
                                    </td>
                                    <td>
                                        <button type="button" class="btn btn-sm btn-outline-primary" 
                                                data-bs-toggle="modal" 
                                                data-bs-target="#editKondisiModal<?php echo e($item->id); ?>">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <form action="<?php echo e(route('master.kondisi.destroy', $item->id)); ?>" method="POST" class="d-inline" data-item-name="<?php echo e($item->nama_kondisi); ?>">
                                            <?php echo csrf_field(); ?>
                                            <?php echo method_field('DELETE'); ?>
                                            <button type="submit" class="btn btn-sm btn-outline-danger">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                    </table>
                </div>
            <?php else: ?>
                <div class="text-center py-4">
                    <i class="fas fa-clipboard-check fa-3x text-muted mb-3"></i>
                    <h5 class="text-muted">Belum ada data kondisi</h5>
                    <p class="text-muted">Klik tombol "Tambah Kondisi" untuk menambahkan data pertama</p>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<!-- Add Kondisi Modal -->
<div class="modal fade" id="addKondisiModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="<?php echo e(route('master.kondisi.store')); ?>" method="POST">
                <?php echo csrf_field(); ?>
                <div class="modal-header">
                    <h5 class="modal-title">Tambah Kondisi Baru</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="nama_kondisi" class="form-label">Nama Kondisi <span class="text-danger">*</span></label>
                        <input type="text" class="form-control <?php $__errorArgs = ['nama_kondisi'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                               id="nama_kondisi" name="nama_kondisi" value="<?php echo e(old('nama_kondisi')); ?>" required>
                        <?php $__errorArgs = ['nama_kondisi'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <div class="invalid-feedback"><?php echo e($message); ?></div>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>
                    <div class="mb-3">
                        <label for="deskripsi" class="form-label">Deskripsi</label>
                        <textarea class="form-control <?php $__errorArgs = ['deskripsi'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                  id="deskripsi" name="deskripsi" rows="3"><?php echo e(old('deskripsi')); ?></textarea>
                        <?php $__errorArgs = ['deskripsi'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <div class="invalid-feedback"><?php echo e($message); ?></div>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>
                    <div class="mb-3">
                        <label for="warna" class="form-label">Warna</label>
                        <input type="color" class="form-control form-control-color <?php $__errorArgs = ['warna'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                               id="warna" name="warna" value="<?php echo e(old('warna', '#6c757d')); ?>" title="Pilih warna">
                        <?php $__errorArgs = ['warna'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <div class="invalid-feedback"><?php echo e($message); ?></div>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
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
<?php $__currentLoopData = $kondisi; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
<div class="modal fade" id="editKondisiModal<?php echo e($item->id); ?>" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="<?php echo e(route('master.kondisi.update', $item->id)); ?>" method="POST">
                <?php echo csrf_field(); ?>
                <?php echo method_field('PUT'); ?>
                <div class="modal-header">
                    <h5 class="modal-title">Edit Kondisi</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="nama_kondisi<?php echo e($item->id); ?>" class="form-label">Nama Kondisi <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" 
                               id="nama_kondisi<?php echo e($item->id); ?>" name="nama_kondisi" 
                               value="<?php echo e($item->nama_kondisi); ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="deskripsi<?php echo e($item->id); ?>" class="form-label">Deskripsi</label>
                        <textarea class="form-control" 
                                  id="deskripsi<?php echo e($item->id); ?>" name="deskripsi" 
                                  rows="3"><?php echo e($item->deskripsi); ?></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="warna<?php echo e($item->id); ?>" class="form-label">Warna</label>
                        <input type="color" class="form-control form-control-color" 
                               id="warna<?php echo e($item->id); ?>" name="warna" 
                               value="<?php echo e($item->warna ?? '#6c757d'); ?>" title="Pilih warna">
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

<div class="modal fade" id="deleteKondisiModal<?php echo e($item->id); ?>" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="<?php echo e(route('master.kondisi.destroy', $item->id)); ?>" method="POST">
                <?php echo csrf_field(); ?>
                <?php echo method_field('DELETE'); ?>
                <div class="modal-header">
                    <h5 class="modal-title">Hapus Kondisi</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <p>Apakah Anda yakin ingin menghapus kondisi "<?php echo e($item->nama_kondisi); ?>"?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-danger">Hapus</button>
                </div>
            </form>
        </div>
    </div>
</div>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

<!-- Delete Form -->
<form id="deleteForm" method="POST" style="display: none;">
    <?php echo csrf_field(); ?>
    <?php echo method_field('DELETE'); ?>
</form>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>
<script>
function confirmDelete(id, nama) {
    if (confirm(`Apakah Anda yakin ingin menghapus kondisi "${nama}"?`)) {
        const form = document.getElementById('deleteForm');
        form.action = `/master/kondisi/${id}`;
        form.submit();
    }
}
</script>
<?php $__env->stopSection(); ?> 
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\capstone-firdaus\resources\views/master/kondisi/index.blade.php ENDPATH**/ ?>