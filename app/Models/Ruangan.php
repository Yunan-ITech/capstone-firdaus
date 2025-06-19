<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ruangan extends Model
{
    use HasFactory;

    protected $table = 'ruangan';
    
    protected $fillable = [
        'nama_ruangan',
        'deskripsi'
    ];

    public function assets()
    {
        return $this->hasMany(Asset::class);
    }
} 