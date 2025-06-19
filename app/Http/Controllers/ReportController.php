<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Asset;
use App\Models\Kategori;
use App\Models\Ruangan;
use App\Models\Kondisi;
use App\Models\Tahun;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        $kategori = Kategori::orderBy('nama_kategori')->get();
        $ruangan = Ruangan::orderBy('nama_ruangan')->get();
        $kondisi = Kondisi::orderBy('nama_kondisi')->get();
        $tahun = Tahun::orderBy('tahun', 'desc')->get();

        $query = Asset::with(['kategori', 'tahun', 'jenisBarang', 'ruangan', 'kondisi']);
        if ($request->filled('ruangan_id')) {
            $query->where('ruangan_id', $request->ruangan_id);
        }
        if ($request->filled('kondisi_id')) {
            $query->where('kondisi_id', $request->kondisi_id);
        }
        $assets = $query->orderBy('created_at', 'desc')->get();

        return view('reports.index', compact('kategori', 'ruangan', 'kondisi', 'tahun', 'assets'));
    }

    public function assets(Request $request)
    {
        $query = Asset::with(['kategori', 'tahun', 'jenisBarang', 'ruangan', 'kondisi']);

        // Apply filters
        if ($request->filled('kategori_id')) {
            $query->where('kategori_id', $request->kategori_id);
        }

        if ($request->filled('ruangan_id')) {
            $query->where('ruangan_id', $request->ruangan_id);
        }

        if ($request->filled('kondisi_id')) {
            $query->where('kondisi_id', $request->kondisi_id);
        }

        if ($request->filled('tahun_id')) {
            $query->where('tahun_id', $request->tahun_id);
        }

        $assets = $query->orderBy('created_at', 'desc')->get();

        return view('reports.assets', compact('assets'));
    }

    public function export(Request $request)
    {
        $query = Asset::with(['kategori', 'tahun', 'jenisBarang', 'ruangan', 'kondisi']);
        if ($request->filled('ruangan_id')) {
            $query->where('ruangan_id', $request->ruangan_id);
        }
        if ($request->filled('kondisi_id')) {
            $query->where('kondisi_id', $request->kondisi_id);
        }
        $assets = $query->orderBy('created_at', 'desc')->get();

        $format = $request->get('format', 'excel');
        $filename = 'laporan_aset_' . now()->format('Ymd_His');

        if ($format === 'csv') {
            return Excel::download(new \App\Exports\AssetsExport($assets), $filename.'.csv');
        } elseif ($format === 'pdf') {
            $pdf = Pdf::loadView('reports.pdf', [
                'assets' => $assets,
                'ruangan' => $request->filled('ruangan_id') ? Ruangan::find($request->ruangan_id) : null,
                'kondisi' => $request->filled('kondisi_id') ? Kondisi::find($request->kondisi_id) : null,
            ]);
            return $pdf->download($filename.'.pdf');
        } else {
            return Excel::download(new \App\Exports\AssetsExport($assets), $filename.'.xlsx');
        }
    }
} 