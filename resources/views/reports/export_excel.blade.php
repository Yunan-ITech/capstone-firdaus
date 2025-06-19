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