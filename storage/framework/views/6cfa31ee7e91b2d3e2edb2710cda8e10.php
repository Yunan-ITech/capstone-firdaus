<?php $__env->startSection('title', 'Master Data Kategori - Sistem Manajemen Aset Klinik Firdaus'); ?>

<?php $__env->startSection('content'); ?>
<div class="container-fluid">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-0">Master Kategori</h1>
            <p class="text-muted">Daftar seluruh kategori barang</p>
        </div>
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addKategoriModal">
            <i class="fas fa-plus me-2"></i>Tambah Kategori
        </button>
    </div>

    <!-- Alert Messages -->
    

    <!-- Data Table -->
    <div class="card">
        <div class="card-header">
            <h5 class="mb-0"><i class="fas fa-list me-2"></i>Daftar Kategori</h5>
        </div>
        <div class="card-body">
            <?php if($kategori->count() > 0): ?>
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead class="table-light">
                            <tr>
                                <th>No</th>
                                <th>Nama Kategori</th>
                                <th>Deskripsi</th>
                                <th>Jumlah Barang</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__currentLoopData = $kategori; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td><?php echo e($index + 1); ?></td>
                                    <td>
                                        <strong><?php echo e($item->nama_kategori); ?></strong>
                                    </td>
                                    <td><?php echo e($item->deskripsi ?? '-'); ?></td>
                                    <td>
                                        <span class="badge bg-primary"><?php echo e($item->assets_count ?? 0); ?></span>
                                    </td>
                                    <td>
                                        <button type="button" class="btn btn-sm btn-outline-primary" 
                                                data-bs-toggle="modal" 
                                                data-bs-target="#editKategoriModal<?php echo e($item->id); ?>">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <button type="button" class="btn btn-sm btn-outline-danger" 
                                                onclick="confirmDelete(<?php echo e($item->id); ?>, '<?php echo e($item->nama_kategori); ?>')">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                    </table>
                </div>
            <?php else: ?>
                <div class="text-center py-4">
                    <i class="fas fa-tags fa-3x text-muted mb-3"></i>
                    <h5 class="text-muted">Belum ada data kategori</h5>
                    <p class="text-muted">Klik tombol "Tambah Kategori" untuk menambahkan data pertama</p>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<!-- Add Kategori Modal -->
<div class="modal fade" id="addKategoriModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="<?php echo e(route('master.kategori.store')); ?>" method="POST">
                <?php echo csrf_field(); ?>
                <div class="modal-header">
                    <h5 class="modal-title">Tambah Kategori</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="kode_kategori" class="form-label">Kode Kategori <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="kode_kategori" name="kode_kategori" maxlength="10" required>
                    </div>
                    <div class="mb-3">
                        <label for="id_kategori" class="form-label">ID Kategori <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="id_kategori" name="id_kategori" maxlength="10" required>
                    </div>
                    <div class="mb-3">
                        <label for="nama_kategori" class="form-label">Nama Kategori <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="nama_kategori" name="nama_kategori" required>
                    </div>
                    <div class="mb-3">
                        <label for="deskripsi" class="form-label">Deskripsi</label>
                        <textarea class="form-control" id="deskripsi" name="deskripsi" rows="3"></textarea>
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

<!-- Edit Kategori Modals -->
<?php $__currentLoopData = $kategori; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
<div class="modal fade" id="editKategoriModal<?php echo e($item->id); ?>" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="<?php echo e(route('master.kategori.update', $item->id)); ?>" method="POST">
                <?php echo csrf_field(); ?>
                <?php echo method_field('PUT'); ?>
                <div class="modal-header">
                    <h5 class="modal-title">Edit Kategori</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="nama_kategori<?php echo e($item->id); ?>" class="form-label">Nama Kategori <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" 
                               id="nama_kategori<?php echo e($item->id); ?>" name="nama_kategori" 
                               value="<?php echo e($item->nama_kategori); ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="deskripsi<?php echo e($item->id); ?>" class="form-label">Deskripsi</label>
                        <textarea class="form-control" 
                                  id="deskripsi<?php echo e($item->id); ?>" name="deskripsi" 
                                  rows="3"><?php echo e($item->deskripsi); ?></textarea>
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

<!-- Delete Form -->
<form id="deleteForm" method="POST" style="display: none;">
    <?php echo csrf_field(); ?>
    <?php echo method_field('DELETE'); ?>
</form>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>
<script>
function confirmDelete(id, nama) {
    if (confirm(`Apakah Anda yakin ingin menghapus kategori "${nama}"?`)) {
        const form = document.getElementById('deleteForm');
        form.action = `/master/kategori/${id}`;
        form.submit();
    }
}
</script>
<?php $__env->stopSection(); ?> 
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\laragon\www\capstone-firdaus\resources\views/master/kategori/index.blade.php ENDPATH**/ ?>