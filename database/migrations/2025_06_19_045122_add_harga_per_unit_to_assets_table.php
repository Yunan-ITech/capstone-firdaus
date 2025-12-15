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
        Schema::table('assets', function (Blueprint $table) {
            // Tambahkan kolom harga_per_unit jika belum ada
            if (!Schema::hasColumn('assets', 'harga_per_unit')) {
                $table->decimal('harga_per_unit', 15, 2)->nullable()->after('kode_inventaris');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('assets', function (Blueprint $table) {
            if (Schema::hasColumn('assets', 'harga_per_unit')) {
                $table->dropColumn('harga_per_unit');
            }
        });
    }
};
