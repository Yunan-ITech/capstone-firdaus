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

        // Seed Kategori (hanya K01-K04, id_kategori 01-04)
        $kategori = [
            ['kode_kategori' => 'K01', 'id_kategori' => '01', 'nama_kategori' => 'Barang Kantor'],
            ['kode_kategori' => 'K02', 'id_kategori' => '02', 'nama_kategori' => 'Alat Kesehatan'],
            ['kode_kategori' => 'K03', 'id_kategori' => '03', 'nama_kategori' => 'Alat Rumah Tangga'],
            ['kode_kategori' => 'K04', 'id_kategori' => '04', 'nama_kategori' => 'Alat Bangunan'],
        ];

        // Ambil id kategori berdasarkan kode_kategori
        $kategoriMap = [];
        foreach ($kategori as $kat) {
            $kategoriMap[$kat['kode_kategori']] = Kategori::where('kode_kategori', $kat['kode_kategori'])->first()->id;
        }

        // Seed Jenis Barang
        $jenisBarang = [
            // Barang Kantor (K01)
            ['kategori_kode' => 'K01', 'kode_barang' => '01', 'nama_barang' => 'Meja Kantor'],
            ['kategori_kode' => 'K01', 'kode_barang' => '02', 'nama_barang' => 'Kursi Kantor'],
            // Alat Kesehatan (K02)
            ['kategori_kode' => 'K02', 'kode_barang' => '01', 'nama_barang' => 'Stetoskop'],
            ['kategori_kode' => 'K02', 'kode_barang' => '02', 'nama_barang' => 'Tensimeter'],
            // Alat Rumah Tangga (K03)
            ['kategori_kode' => 'K03', 'kode_barang' => '01', 'nama_barang' => 'Sapu'],
            ['kategori_kode' => 'K03', 'kode_barang' => '02', 'nama_barang' => 'Ember'],
            // Alat Bangunan (K04)
            ['kategori_kode' => 'K04', 'kode_barang' => '01', 'nama_barang' => 'Palu'],
            ['kategori_kode' => 'K04', 'kode_barang' => '02', 'nama_barang' => 'Obeng'],
        ];
        foreach ($jenisBarang as $jenis) {
            JenisBarang::create([
                'kategori_id' => $kategoriMap[$jenis['kategori_kode']],
                'kode_barang' => $jenis['kode_barang'],
                'nama_barang' => $jenis['nama_barang'],
            ]);
        }

        // Seed Tahun
        $tahun = ['2020', '2021', '2022', '2023', '2024', '2025'];
        foreach ($tahun as $thn) {
            Tahun::create(['tahun' => $thn]);
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

        // Pastikan kategori K01 (Barang Kantor) ada
        $kategoriK01 = \App\Models\Kategori::firstOrCreate(
            ['kode_kategori' => 'K01'],
            ['nama_kategori' => 'Barang Kantor']
        );

        // Tambahkan satu jenis barang contoh untuk K01
        \App\Models\JenisBarang::firstOrCreate(
            [
                'kategori_id' => $kategoriK01->id,
                'kode_barang' => '01',
                'nama_barang' => 'Meja Kantor'
            ],
            [
                'deskripsi' => 'Meja kantor standar'
            ]
        );
    }
} 