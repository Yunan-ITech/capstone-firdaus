<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JenisBarang extends Model
{
    use HasFactory;

    protected $table = 'jenis_barang';
    
    protected $fillable = [
        'kategori_id',
        'nama_barang',
        'deskripsi',
        'kode_barang'
    ];

    public function kategori()
    {
        return $this->belongsTo(Kategori::class);
    }

    public function assets()
    {
        return $this->hasMany(Asset::class);
    }
} 