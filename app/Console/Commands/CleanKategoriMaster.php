<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Kategori;

class CleanKategoriMaster extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'master:clean-kategori';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Bersihkan dan pastikan hanya kategori K01-K04 yang ada di database';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Nonaktifkan foreign key checks...');
        \DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        $this->info('Menghapus seluruh data assets...');
        \DB::table('assets')->truncate();
        $this->info('Menghapus seluruh data jenis_barang...');
        \DB::table('jenis_barang')->truncate();
        $this->info('Menghapus seluruh data kategori...');
        Kategori::truncate();
        \DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $kategoriList = [
            'K01' => ['nama' => 'Barang Kantor', 'id_kategori' => '01'],
            'K02' => ['nama' => 'Alat Kesehatan', 'id_kategori' => '02'],
            'K03' => ['nama' => 'Alat Rumah Tangga', 'id_kategori' => '03'],
            'K04' => ['nama' => 'Alat Bangunan', 'id_kategori' => '04'],
        ];
        foreach ($kategoriList as $kode => $data) {
            $kat = Kategori::create([
                'kode_kategori' => $kode,
                'id_kategori' => $data['id_kategori'],
                'nama_kategori' => $data['nama']
            ]);
            $this->line("Kategori $kode - {$data['nama']} dibuat/id: $kat->id, id_kategori: {$data['id_kategori']}");
        }
        $this->info('Kategori master sudah bersih dan rapi!');
        return 0;
    }
}
