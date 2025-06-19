<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Data Barang - Klinik Firdaus</title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 12px; }
        .kop { text-align: center; margin-bottom: 10px; }
        .kop h2 { margin: 0; font-size: 20px; }
        .kop p { margin: 0; font-size: 13px; }
        .line { border-bottom: 2px solid #000; margin: 10px 0 20px 0; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { border: 1px solid #333; padding: 5px; text-align: left; }
        th { background: #eee; }
        .filter { margin-bottom: 10px; }
    </style>
</head>
<body>
    <div class="kop">
        <img src="{{ public_path('favicon.ico') }}" alt="Logo" height="40" style="float:left;margin-right:10px;">
        <h2>KLINIK FIRDAUS</h2>
        <p>Jl. Contoh Alamat No. 123, Kota, Provinsi | Telp: (021) 12345678</p>
    </div>
    <div class="line"></div>
    <div class="filter">
        <strong>Filter:</strong>
        @if($ruangan)
            Ruangan: {{ $ruangan->nama_ruangan }} |
        @endif
        @if($kondisi)
            Kondisi: {{ $kondisi->nama_kondisi }} |
        @endif
        Tanggal Cetak: {{ date('d-m-Y H:i') }}
    </div>
    <h4 style="text-align:center; margin-bottom:10px;">LAPORAN DATA BARANG</h4>
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Kode Inventaris</th>
                <th>Nama Barang</th>
                <th>Kategori</th>
                <th>Ruangan</th>
                <th>Kondisi</th>
                <th>Tahun</th>
                <th>Deskripsi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($assets as $index => $asset)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $asset->kode_inventaris }}</td>
                    <td>{{ $asset->jenisBarang->nama_barang ?? '-' }}</td>
                    <td>{{ $asset->kategori->nama_kategori ?? '-' }}</td>
                    <td>{{ $asset->ruangan->nama_ruangan ?? '-' }}</td>
                    <td>{{ $asset->kondisi->nama_kondisi ?? '-' }}</td>
                    <td>{{ $asset->tahun->tahun ?? '-' }}</td>
                    <td>{{ $asset->deskripsi ?? '-' }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html> 