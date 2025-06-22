<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('master_barang', function (Blueprint $table) {
            $table->id();
            $table->string('kode_inventaris_dasar')->unique();
            $table->foreignId('kategori_id')->constrained('kategori')->onDelete('cascade');
            $table->foreignId('jenis_barang_id')->constrained('jenis_barang')->onDelete('cascade');
            $table->decimal('harga_per_unit', 16, 2)->default(0);
            $table->integer('jumlah')->default(0);
            $table->integer('jumlah_baik')->default(0);
            $table->integer('jumlah_rusak')->default(0);
            $table->timestamps();
        });
    }
    public function down()
    {
        Schema::dropIfExists('master_barang');
    }
}; 