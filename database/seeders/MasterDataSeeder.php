<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Ruangan;
use App\Models\Kategori;
use App\Models\Tahun;
use App\Models\JenisBarang;
use App\Models\Kondisi;

class MasterDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Seed Ruangan
        $ruangan = [
            'Ruang Dokter Umum',
            'Ruang Dokter Gigi',
            'Ruang Laboratorium',
            'Ruang Apotek',
            'Ruang Tunggu',
            'Ruang Administrasi',
            'Ruang Sterilisasi',
            'Ruang Gawat Darurat',
        ];

        foreach ($ruangan as $nama) {
            Ruangan::create(['nama_ruangan' => $nama]);
        }

        // Seed Kategori
        $kategori = [
            ['kode_kategori' => '01', 'nama_kategori' => 'Peralatan Medis'],
            ['kode_kategori' => '02', 'nama_kategori' => 'Furniture'],
            ['kode_kategori' => '03', 'nama_kategori' => 'Elektronik'],
            ['kode_kategori' => '04', 'nama_kategori' => 'Kendaraan'],
            ['kode_kategori' => '05', 'nama_kategori' => 'Bangunan'],
        ];

        foreach ($kategori as $kat) {
            Kategori::create($kat);
        }

        // Seed Tahun
        $tahun = ['2020', '2021', '2022', '2023', '2024', '2025'];
        foreach ($tahun as $thn) {
            Tahun::create(['tahun' => $thn]);
        }

        // Seed Jenis Barang
        $jenisBarang = [
            // Peralatan Medis
            ['kategori_id' => 1, 'kode_barang' => '01', 'nama_barang' => 'Stetoskop'],
            ['kategori_id' => 1, 'kode_barang' => '02', 'nama_barang' => 'Tensimeter'],
            ['kategori_id' => 1, 'kode_barang' => '03', 'nama_barang' => 'Termometer'],
            ['kategori_id' => 1, 'kode_barang' => '04', 'nama_barang' => 'Alat Suntik'],
            
            // Furniture
            ['kategori_id' => 2, 'kode_barang' => '01', 'nama_barang' => 'Meja Dokter'],
            ['kategori_id' => 2, 'kode_barang' => '02', 'nama_barang' => 'Kursi Pasien'],
            ['kategori_id' => 2, 'kode_barang' => '03', 'nama_barang' => 'Lemari Obat'],
            ['kategori_id' => 2, 'kode_barang' => '04', 'nama_barang' => 'Tempat Tidur'],
            
            // Elektronik
            ['kategori_id' => 3, 'kode_barang' => '01', 'nama_barang' => 'Komputer'],
            ['kategori_id' => 3, 'kode_barang' => '02', 'nama_barang' => 'Printer'],
            ['kategori_id' => 3, 'kode_barang' => '03', 'nama_barang' => 'AC'],
            ['kategori_id' => 3, 'kode_barang' => '04', 'nama_barang' => 'Kipas Angin'],
            
            // Kendaraan
            ['kategori_id' => 4, 'kode_barang' => '01', 'nama_barang' => 'Mobil Ambulans'],
            ['kategori_id' => 4, 'kode_barang' => '02', 'nama_barang' => 'Motor'],
            
            // Bangunan
            ['kategori_id' => 5, 'kode_barang' => '01', 'nama_barang' => 'Gedung Utama'],
            ['kategori_id' => 5, 'kode_barang' => '02', 'nama_barang' => 'Gudang'],
        ];

        foreach ($jenisBarang as $jenis) {
            JenisBarang::create($jenis);
        }

        // Seed Kondisi
        $kondisi = [
            'Baik',
            'Rusak Ringan',
            'Rusak Berat',
            'Tidak Layak',
        ];

        foreach ($kondisi as $kond) {
            Kondisi::create(['nama_kondisi' => $kond]);
        }
    }
} 