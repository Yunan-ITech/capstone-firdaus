<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Asset;
use App\Models\Kategori;
use App\Models\Kondisi;
use App\Models\Tahun;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // Statistik umum
        $totalAssets = Asset::count();
        $totalKategori = Kategori::count();
        $totalRuangan = \App\Models\Ruangan::count();
        
        // Statistik berdasarkan kondisi
        $assetsByCondition = Asset::select('kondisi_id', DB::raw('count(*) as total'))
            ->with('kondisi')
            ->groupBy('kondisi_id')
            ->get();

        // Statistik berdasarkan kategori
        $assetsByCategory = Asset::select('kategori_id', DB::raw('count(*) as total'))
            ->with('kategori')
            ->groupBy('kategori_id')
            ->get();

        // Tahun pengadaan terbaru
        $latestYear = Tahun::orderBy('tahun', 'desc')->first();
        $assetsLatestYear = Asset::where('tahun_id', $latestYear->id ?? 0)->count();

        // Top 5 ruangan dengan aset terbanyak
        $topRuangan = Asset::select('ruangan_id', DB::raw('count(*) as total'))
            ->with('ruangan')
            ->groupBy('ruangan_id')
            ->orderBy('total', 'desc')
            ->limit(5)
            ->get();

        // Kondisi terbaru (5 aset terbaru)
        $recentAssets = Asset::with(['kategori', 'jenisBarang', 'ruangan', 'kondisi'])
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        return view('dashboard', compact(
            'totalAssets',
            'totalKategori',
            'totalRuangan',
            'assetsByCondition',
            'assetsByCategory',
            'latestYear',
            'assetsLatestYear',
            'topRuangan',
            'recentAssets'
        ));
    }
} 