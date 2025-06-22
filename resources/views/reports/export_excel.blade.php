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
        @foreach($reportData as $data)
            <tr>
                <td>{{ $data['no'] }}</td>
                <td>{{ $data['kode_inventaris'] }}</td>
                <td>{{ $data['nama_barang'] }}</td>
                <td>{{ $data['kategori'] }}</td>
                <td>{{ $data['ruangan'] }}</td>
                <td>{{ $data['kondisi'] }}</td>
                <td>{{ 'Rp ' . number_format($data['harga_per_unit'], 0, ',', '.') }}</td>
                <td>{{ $data['jumlah'] }}</td>
                <td>{{ $data['tahun_pengadaan'] }}</td>
                <td>{{ 'Rp ' . number_format($data['harga_perolehan'], 0, ',', '.') }}</td>
                <td>{{ $data['deskripsi'] }}</td>
            </tr>
        @endforeach
    </tbody>
</table> 