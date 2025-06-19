<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kategori extends Model
{
    use HasFactory;

    protected $table = 'kategori';
    
    protected $fillable = [
        'kode_kategori',
        'nama_kategori',
        'deskripsi'
    ];

    public function jenisBarang()
    {
        return $this->hasMany(JenisBarang::class);
    }

    public function assets()
    {
        return $this->hasMany(Asset::class);
    }
} 