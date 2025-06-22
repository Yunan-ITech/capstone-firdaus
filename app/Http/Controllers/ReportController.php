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
    private function getReportData(Request $request)
    {
        $query = Asset::with(['kategori', 'tahun', 'jenisBarang', 'ruangan', 'kondisi']);

        if ($request->filled('kategori_id')) {
            $query->where('kategori_id', $request->kategori_id);
        }
        if ($request->filled('ruangan_id')) {
            $query->where('ruangan_id', $request->ruangan_id);
        }
        if ($request->filled('kondisi_id')) {
            $query->where('kondisi_id', $request->kondisi_id);
        }

        $assets = $query->orderBy('kode_inventaris')->get();

        // Group by kode inventaris dasar
        $grouped = $assets->groupBy(function($item) {
            $parts = explode('.', $item->kode_inventaris);
            array_pop($parts); // hapus 3 digit urut
            return implode('.', $parts);
        });

        $reportData = [];
        $no = 1;
        foreach ($grouped as $kodeDasar => $items) {
            $first = $items->first();
            $jumlah = $items->count();
            $hargaPerUnit = $first->harga_per_unit ?? 0;
            
            // Mengumpulkan nama ruangan dan kondisi unik
            $ruanganUnik = $items->pluck('ruangan.nama_ruangan')->unique()->filter()->implode(', ');
            $kondisiSummary = $items->map(function($item) {
                return $item->kondisi->nama_kondisi ?? null;
            })->filter()->countBy()->map(function($count, $name) {
                return "$count $name";
            })->implode(', ');
            
            $reportData[] = [
                'no' => $no++,
                'kode_inventaris' => $kodeDasar,
                'nama_barang' => $first->jenisBarang->nama_barang ?? '-',
                'kategori' => $first->kategori->nama_kategori ?? '-',
                'ruangan' => $ruanganUnik,
                'kondisi' => $kondisiSummary,
                'harga_per_unit' => $hargaPerUnit,
                'jumlah' => $jumlah,
                'tahun_pengadaan' => $first->tahun->tahun ?? '-',
                'deskripsi' => $first->deskripsi ?? '-',
                'harga_perolehan' => $jumlah * $hargaPerUnit,
            ];
        }
        
        return $reportData;
    }

    public function index(Request $request)
    {
        $kategori = Kategori::orderBy('nama_kategori')->get();
        $ruangan = Ruangan::orderBy('nama_ruangan')->get();
        $kondisi = Kondisi::orderBy('nama_kondisi')->get();

        $reportData = $this->getReportData($request);
        
        $perPage = 15;
        $page = request()->get('page', 1);
        $paginatedData = new \Illuminate\Pagination\LengthAwarePaginator(
            array_slice($reportData, ($page - 1) * $perPage, $perPage),
            count($reportData),
            $perPage,
            $page,
            ['path' => request()->url(), 'query' => $request->query()]
        );

        return view('reports.index', [
            'reportData' => $paginatedData,
            'kategori' => $kategori,
            'ruangan' => $ruangan,
            'kondisi' => $kondisi,
        ]);
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
        $reportData = $this->getReportData($request);
        $totalPerolehan = array_sum(array_column($reportData, 'harga_perolehan'));

        $filters = [
            'kategori' => $request->filled('kategori_id') ? Kategori::find($request->kategori_id) : null,
            'ruangan' => $request->filled('ruangan_id') ? Ruangan::find($request->ruangan_id) : null,
            'kondisi' => $request->filled('kondisi_id') ? Kondisi::find($request->kondisi_id) : null,
        ];
        
        $format = $request->get('format', 'excel');
        $filename = 'laporan_aset_' . now()->format('Ymd_His');

        if ($format === 'pdf') {
            $pdf = Pdf::loadView('reports.pdf', [
                'reportData' => $reportData,
                'filters' => $filters,
                'totalPerolehan' => $totalPerolehan
            ])->setPaper('a4', 'landscape');
            return $pdf->download($filename.'.pdf');
        } else {
            // Untuk Excel dan CSV, kita perlu membuat view export terpisah
            // Mari kita asumsikan namanya 'reports.export_excel'
            return Excel::download(new \App\Exports\AssetsExport($reportData), $filename.'.xlsx');
        }
    }
} 