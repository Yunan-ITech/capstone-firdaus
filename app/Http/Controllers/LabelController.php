<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Asset;
use App\Models\Ruangan;
use App\Models\Kondisi;
use App\Models\Tahun;
use App\Models\Kategori;
use App\Models\JenisBarang;

class LabelController extends Controller
{
    public function index(Request $request)
    {
        $ruangan = Ruangan::orderBy('nama_ruangan')->get();
        $kondisi = Kondisi::orderBy('nama_kondisi')->get();
        $tahun = Tahun::orderBy('tahun', 'desc')->get();
        $kategori = Kategori::orderBy('nama_kategori')->get();
        $jenisBarang = JenisBarang::orderBy('nama_barang')->get();

        $query = Asset::with(['kategori', 'jenisBarang', 'ruangan', 'tahun', 'kondisi']);
        if ($request->filled('ruangan_id')) {
            $query->where('ruangan_id', $request->ruangan_id);
        }
        if ($request->filled('kondisi_id')) {
            $query->where('kondisi_id', $request->kondisi_id);
        }
        if ($request->filled('tahun_id')) {
            $query->where('tahun_id', $request->tahun_id);
        }
        if ($request->filled('kategori_id')) {
            $query->where('kategori_id', $request->kategori_id);
        }
        if ($request->filled('jenis_barang_id')) {
            $query->where('jenis_barang_id', $request->jenis_barang_id);
        }
        $assets = $query->orderBy('kode_inventaris')->paginate(10)->appends($request->except('page'));

        return view('labels.index', compact('assets', 'ruangan', 'kondisi', 'tahun', 'kategori', 'jenisBarang'));
    }

    public function print(Request $request)
    {
        $isPreview = $request->has('preview');
        $printAll = $request->has('print_all');
        $assets = collect();
        if ($printAll) {
            $query = Asset::with(['kategori', 'jenisBarang', 'ruangan', 'tahun']);
            // Filter jika ada
            if ($request->filled('ruangan_id')) {
                $query->where('ruangan_id', $request->ruangan_id);
            }
            if ($request->filled('kondisi_id')) {
                $query->where('kondisi_id', $request->kondisi_id);
            }
            if ($request->filled('tahun_id')) {
                $query->where('tahun_id', $request->tahun_id);
            }
            if ($request->filled('kategori_id')) {
                $query->where('kategori_id', $request->kategori_id);
            }
            if ($request->filled('jenis_barang_id')) {
                $query->where('jenis_barang_id', $request->jenis_barang_id);
            }
            $assets = $query->orderBy('kode_inventaris')->get();
        } else {
            $ids = $request->input('asset_ids', []);
            $assets = Asset::with(['kategori', 'jenisBarang', 'ruangan', 'tahun'])
                ->whereIn('id', $ids)
                ->orderBy('kode_inventaris')
                ->get();
        }
        if ($isPreview) {
            return view('labels.print', compact('assets'))->with('isPreview', true);
        }
        return view('labels.print', compact('assets'))->with('isPreview', false);
    }
} 