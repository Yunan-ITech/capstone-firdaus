<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tahun extends Model
{
    use HasFactory;

    protected $table = 'tahun';
    
    protected $fillable = [
        'tahun',
        'deskripsi'
    ];

    public function assets()
    {
        return $this->hasMany(Asset::class);
    }
} 