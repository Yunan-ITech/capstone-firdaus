<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('jenis_barang', function (Blueprint $table) {
            // Tambahkan kembali kolom kode_barang jika belum ada
            if (!Schema::hasColumn('jenis_barang', 'kode_barang')) {
                $table->string('kode_barang')->after('kategori_id');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('jenis_barang', function (Blueprint $table) {
            if (Schema::hasColumn('jenis_barang', 'kode_barang')) {
                $table->dropColumn('kode_barang');
            }
        });
    }
};
