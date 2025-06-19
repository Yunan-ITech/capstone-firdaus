<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::table('kondisi', function (Blueprint $table) {
            $table->text('deskripsi')->nullable()->after('nama_kondisi');
            $table->string('warna', 7)->nullable()->after('deskripsi');
        });
    }

    public function down()
    {
        Schema::table('kondisi', function (Blueprint $table) {
            $table->dropColumn(['deskripsi', 'warna']);
        });
    }
}; 