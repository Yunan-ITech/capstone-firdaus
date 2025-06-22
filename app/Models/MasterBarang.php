<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MasterBarang extends Model
{
    use HasFactory;
    protected $table = 'master_barang';
    protected $fillable = [
        'kode_inventaris_dasar',
        'kategori_id',
        'jenis_barang_id',
        'harga_per_unit',
        'jumlah',
        'jumlah_baik',
        'jumlah_rusak',
    ];

    public function kategori()
    {
        return $this->belongsTo(Kategori::class);
    }
    public function jenisBarang()
    {
        return $this->belongsTo(JenisBarang::class);
    }
} 