<table>
    <thead>
        <tr>
            <th>No</th>
            <th>Kode Inventaris</th>
            <th>Nama Barang</th>
            <th>Kategori</th>
            <th>Ruangan</th>
            <th>Kondisi</th>
            <th>Harga Per Unit</th>
            <th>Jumlah</th>
            <th>Tahun Pengadaan</th>
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
</table> <?php /**PATH D:\laragon\www\capstone-firdaus\resources\views/reports/export_excel.blade.php ENDPATH**/ ?>