<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Cetak Label Inventaris</title>
    <style>
        @media print {
            body { margin: 0; }
        }
        body {
            background: #fff;
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 0;
        }
        .labels-grid {
            display: flex;
            flex-wrap: wrap;
            justify-content: flex-start;
            padding: 1cm 0.5cm;
            box-sizing: border-box;
        }
        .label {
            width: 10cm;
            height: 4cm;
            border: 1.5px solid #000;
            margin: 0 0.5cm 1cm 0.5cm;
            display: flex;
            flex-direction: row;
            padding: 0;
            font-family: 'Courier New', Courier, monospace;
            page-break-inside: avoid;
            background: #fff;
        }
        .label-logo {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 0.4cm;
            border-right: 1.5px solid #000;
        }
        .label-logo img {
            max-width: 100%;
            height: auto;
            object-fit: contain;
        }
        .label-info {
            flex: 3;
            display: flex;
            flex-direction: column;
            text-align: center;
        }
        .info-row {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 0 0.5cm;
            font-size: 1.4em;
            font-weight: bold;
        }
        .room-name {
            border-bottom: 1.5px solid #000;
        }
        .inventory-code {
            letter-spacing: 0.08em;
        }
        .preview-info {
            width: 100%;
            text-align: center;
            padding: 1em;
            color: #555;
            background: #f0f0f0;
        }
    </style>
</head>
<body <?php if(empty($isPreview) || !$isPreview): ?> onload="window.print()" <?php endif; ?>>
    <?php if(!empty($isPreview) && $isPreview): ?>
        <div class="preview-info">Ini adalah pratinjau. Pastikan label tidak terpotong dan proporsional sebelum mencetak.</div>
    <?php endif; ?>
    <div class="labels-grid">
        <?php $__currentLoopData = $assets; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $asset): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="label">
                <div class="label-logo">
                    <img src="<?php echo e(asset('images/logo-klinik-firdaus.jpg')); ?>" alt="Logo Klinik">
                </div>
                <div class="label-info">
                    <div class="info-row room-name">
                        <?php echo e($asset->ruangan->nama_ruangan ?? 'N/A'); ?>

                    </div>
                    <div class="info-row inventory-code">
                        <?php echo e($asset->kode_inventaris); ?>

                    </div>
                </div>
            </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>
</body>
</html> <?php /**PATH C:\laragon\www\capstone-firdaus\resources\views/labels/print.blade.php ENDPATH**/ ?>