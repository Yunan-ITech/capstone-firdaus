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
                <img src="{{ public_path('images/logo-klinik-firdaus.jpg') }}" alt="Logo" class="logo">
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

    @if($filters['kategori'] || $filters['ruangan'] || $filters['kondisi'])
        <p><strong>Filter Aktif:</strong>
            @if($filters['kategori']) Kategori: {{ $filters['kategori']->nama_kategori }}. @endif
            @if($filters['ruangan']) Ruangan: {{ $filters['ruangan']->nama_ruangan }}. @endif
            @if($filters['kondisi']) Kondisi: {{ $filters['kondisi']->nama_kondisi }}. @endif
        </p>
    @endif

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
            @forelse($reportData as $data)
                <tr>
                    <td>{{ $data['no'] }}</td>
                    <td>{{ $data['kode_inventaris'] }}</td>
                    <td>{{ $data['nama_barang'] }}</td>
                    <td>{{ $data['kategori'] }}</td>
                    <td>{{ $data['ruangan'] }}</td>
                    <td>{{ $data['kondisi'] }}</td>
                    <td class="text-right">{{ 'Rp ' . number_format($data['harga_per_unit'], 0, ',', '.') }}</td>
                    <td>{{ $data['jumlah'] }}</td>
                    <td>{{ $data['tahun_pengadaan'] }}</td>
                    <td class="text-right">{{ 'Rp ' . number_format($data['harga_perolehan'], 0, ',', '.') }}</td>
                    <td>{{ $data['deskripsi'] }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="11" style="text-align: center;">Tidak ada data yang sesuai dengan filter.</td>
                </tr>
            @endforelse
        </tbody>
        <tfoot>
            <tr>
                <td colspan="9" style="text-align: right;">TOTAL KESELURUHAN</td>
                <td class="text-right">{{ 'Rp ' . number_format($totalPerolehan, 0, ',', '.') }}</td>
                <td></td>
            </tr>
        </tfoot>
    </table>

    <div class="footer">
        Laporan ini digenerate oleh Sistem Manajemen Aset Klinik Firdaus | Dicetak pada {{ now()->translatedFormat('d F Y H:i:s') }}
    </div>
</body>
</html> 