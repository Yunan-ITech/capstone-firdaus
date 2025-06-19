<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Asset extends Model
{
    use HasFactory;

    protected $fillable = [
        'kategori_id',
        'tahun_id',
        'jenis_barang_id',
        'ruangan_id',
        'kondisi_id',
        'nomor_urut',
        'kode_inventaris',
        'keterangan'
    ];

    public function kategori()
    {
        return $this->belongsTo(Kategori::class);
    }

    public function tahun()
    {
        return $this->belongsTo(Tahun::class);
    }

    public function jenisBarang()
    {
        return $this->belongsTo(JenisBarang::class);
    }

    public function ruangan()
    {
        return $this->belongsTo(Ruangan::class);
    }

    public function kondisi()
    {
        return $this->belongsTo(Kondisi::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function maintenanceRecords()
    {
        return $this->hasMany(MaintenanceRecord::class);
    }

    // Method untuk generate kode inventaris otomatis
    public static function generateKodeInventaris($kategoriId, $tahunId, $jenisBarangId, $nomorUrut)
    {
        $kategori = Kategori::find($kategoriId);
        $tahun = Tahun::find($tahunId);
        $jenisBarang = JenisBarang::find($jenisBarangId);

        return "{$kategori->kode_kategori}.{$tahun->tahun}.{$jenisBarang->kode_barang}." . str_pad($nomorUrut, 3, '0', STR_PAD_LEFT);
    }
} 