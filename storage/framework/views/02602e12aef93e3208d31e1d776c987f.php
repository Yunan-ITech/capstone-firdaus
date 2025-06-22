<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Aset</title>
    <style>
        body { font-family: 'Helvetica', sans-serif; font-size: 10px; color: #333; }
        .header-table { width: 100%; border-bottom: 2px solid #000; padding-bottom: 10px; margin-bottom: 20px; }
        .header-table td { vertical-align: middle; border: none; }
        .logo { width: 70px; height: auto; }
        .clinic-info { text-align: center; }
        .clinic-info h2 { margin: 0 0 5px 0; font-size: 18px; font-weight: bold; }
        .clinic-info p { margin: 0; font-size: 12px; line-height: 1.4; }
        .report-title { text-align: center; margin-bottom: 20px; }
        .report-title h3 { margin: 0; text-transform: uppercase; text-decoration: underline; }
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid #ddd; padding: 6px; text-align: left; }
        th { background-color: #f2f2f2; }
        .text-right { text-align: right; }
        .footer { position: fixed; bottom: 0; width: 100%; text-align: center; font-size: 9px; color: #888; }
        tfoot tr td { font-weight: bold; background-color: #f2f2f2; border: 1px solid #ddd; }
    </style>
</head>
<body>
    <table class="header-table">
        <tr>
            <td style="width: 80px;">
                <img src="<?php echo e(public_path('images/logo-klinik-firdaus.jpg')); ?>" alt="Logo" class="logo">
            </td>
            <td class="clinic-info">
                <h2>KLINIK PRATAMA 24 JAM FIRDAUS</h2>
                <p>Jl. Kapten Piere Tendean No. 56, Wirobrajan, Kota Yogyakarta,<br>
                Daerah Istimewa Yogyakarta 55252</p>
                <p>HP: 0812-2866-0300&emsp;|&emsp;Email: klinik.pratama.firdaus@gmail.com</p>
            </td>
        </tr>
    </table>

    <div class="report-title">
        <h3>Laporan Rekapitulasi Aset</h3>
    </div>

    <?php if($filters['kategori'] || $filters['ruangan'] || $filters['kondisi']): ?>
        <p><strong>Filter Aktif:</strong>
            <?php if($filters['kategori']): ?> Kategori: <?php echo e($filters['kategori']->nama_kategori); ?>. <?php endif; ?>
            <?php if($filters['ruangan']): ?> Ruangan: <?php echo e($filters['ruangan']->nama_ruangan); ?>. <?php endif; ?>
            <?php if($filters['kondisi']): ?> Kondisi: <?php echo e($filters['kondisi']->nama_kondisi); ?>. <?php endif; ?>
        </p>
    <?php endif; ?>

    <table>
        <thead>
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
            <?php $__empty_1 = true; $__currentLoopData = $reportData; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $data): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <tr>
                    <td><?php echo e($data['no']); ?></td>
                    <td><?php echo e($data['kode_inventaris']); ?></td>
                    <td><?php echo e($data['nama_barang']); ?></td>
                    <td><?php echo e($data['kategori']); ?></td>
                    <td><?php echo e($data['ruangan']); ?></td>
                    <td><?php echo e($data['kondisi']); ?></td>
                    <td class="text-right"><?php echo e('Rp ' . number_format($data['harga_per_unit'], 0, ',', '.')); ?></td>
                    <td><?php echo e($data['jumlah']); ?></td>
                    <td><?php echo e($data['tahun_pengadaan']); ?></td>
                    <td class="text-right"><?php echo e('Rp ' . number_format($data['harga_perolehan'], 0, ',', '.')); ?></td>
                    <td><?php echo e($data['deskripsi']); ?></td>
                </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <tr>
                    <td colspan="11" style="text-align: center;">Tidak ada data yang sesuai dengan filter.</td>
                </tr>
            <?php endif; ?>
        </tbody>
        <tfoot>
            <tr>
                <td colspan="9" style="text-align: right;">TOTAL KESELURUHAN</td>
                <td class="text-right"><?php echo e('Rp ' . number_format($totalPerolehan, 0, ',', '.')); ?></td>
                <td></td>
            </tr>
        </tfoot>
    </table>

    <div class="footer">
        Laporan ini digenerate oleh Sistem Manajemen Aset Klinik Firdaus | Dicetak pada <?php echo e(now()->translatedFormat('d F Y H:i:s')); ?>

    </div>
</body>
</html> <?php /**PATH D:\laragon\www\capstone-firdaus\resources\views/reports/pdf.blade.php ENDPATH**/ ?>