<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Asset;
use App\Models\Kategori;
use App\Models\Tahun;
use App\Models\JenisBarang;
use App\Models\Ruangan;
use App\Models\Kondisi;
use Illuminate\Support\Facades\Auth;

class AssetController extends Controller
{
    public function index(Request $request)
    {
        $kategori = Kategori::orderBy('nama_kategori')->get();
        $tahun = Tahun::orderBy('tahun', 'desc')->get();
        $ruangan = Ruangan::orderBy('nama_ruangan')->get();
        $kondisi = Kondisi::orderBy('nama_kondisi')->get();
        $jenisBarang = JenisBarang::orderBy('nama_barang')->get();

        $query = Asset::with(['kategori', 'tahun', 'jenisBarang', 'ruangan', 'kondisi', 'user']);
        if ($request->filled('kategori_id')) {
            $query->where('kategori_id', $request->kategori_id);
        }
        if ($request->filled('jenis_barang_id')) {
            $query->where('jenis_barang_id', $request->jenis_barang_id);
        }
        if ($request->filled('ruangan_id')) {
            $query->where('ruangan_id', $request->ruangan_id);
        }
        if ($request->filled('tahun_id')) {
            $query->where('tahun_id', $request->tahun_id);
        }
        if ($request->filled('kondisi_id')) {
            $query->where('kondisi_id', $request->kondisi_id);
        }
        $assets = $query->orderBy('created_at', 'desc')->get();

        // Grouping berdasarkan kode inventaris dasar (tanpa 3 digit urut di belakang)
        $grouped = $assets->groupBy(function($item) {
            // Ambil kode inventaris dasar (tanpa 3 digit urut di belakang)
            $parts = explode('.', $item->kode_inventaris);
            array_pop($parts); // hapus 3 digit urut
            return implode('.', $parts);
        });

        $dataBarang = [];
        $no = 1;
        foreach ($grouped as $kodeDasar => $items) {
            $first = $items->first();
            $jumlah = $items->count();
            $jumlah_baik = $items->where('kondisi.nama_kondisi', 'Baik')->count();
            $jumlah_rusak = $items->whereIn('kondisi.nama_kondisi', ['Rusak Ringan', 'Rusak Berat', 'Tidak Layak'])->count();
            $dataBarang[] = [
                'no' => $no++,
                'kode_inventaris_dasar' => $kodeDasar,
                'kategori' => $first->kategori->nama_kategori ?? '-',
                'harga_per_unit' => $first->harga_per_unit,
                'jumlah' => $jumlah,
                'jumlah_baik' => $jumlah_baik,
                'jumlah_rusak' => $jumlah_rusak,
                'nama_barang' => $first->jenisBarang->nama_barang ?? '-',
                'units' => $items,
            ];
        }

        return view('assets.index', compact('dataBarang', 'kategori', 'tahun', 'ruangan', 'kondisi', 'jenisBarang'));
    }

    public function create()
    {
        $kategori = Kategori::orderBy('nama_kategori')->get();
        $tahun = Tahun::orderBy('tahun', 'desc')->get();
        $ruangan = Ruangan::orderBy('nama_ruangan')->get();
        $kondisi = Kondisi::orderBy('nama_kondisi')->get();
        $jenisBarang = JenisBarang::orderBy('nama_barang')->get();
        
        return view('assets.create', compact('kategori', 'tahun', 'ruangan', 'kondisi', 'jenisBarang'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'jenis_barang_id' => 'required|exists:jenis_barang,id',
            'kategori_id' => 'required|exists:kategori,id',
            'ruangan_id' => 'required|exists:ruangan,id',
            'tahun_id' => 'required|exists:tahun,id',
            'harga_per_unit' => 'required|numeric|min:0',
            'deskripsi' => 'nullable|string',
        ]);

        $kategori_id = $request->kategori_id;
        $tahun_id = $request->tahun_id;
        $jenis_barang_id = $request->jenis_barang_id;

        $kategori = Kategori::find($kategori_id);
        $tahun = Tahun::find($tahun_id);
        $jenisBarang = JenisBarang::find($jenis_barang_id);

        $kodeDasar = ($kategori->kode_kategori ?? 'XXX') . '.' .
                     ($tahun->tahun ?? '0000') . '.' .
                     ($jenisBarang->kode_barang ?? 'XX');

        // Cari nomor urut terakhir untuk kombinasi kategori, tahun, jenis barang
        $lastAsset = Asset::where('kategori_id', $kategori_id)
            ->where('tahun_id', $tahun_id)
            ->where('jenis_barang_id', $jenis_barang_id)
            ->orderByDesc('nomor_urut')
            ->first();
        $nomorUrut = $lastAsset ? $lastAsset->nomor_urut + 1 : 1;
        $kodeInventaris = $kodeDasar . '.' . str_pad($nomorUrut, 3, '0', STR_PAD_LEFT);

        if (Asset::where('kode_inventaris', $kodeInventaris)->exists()) {
            return back()->withErrors(['jenis_barang_id' => 'Kode inventaris sudah ada, silakan tambah barang lain.'])->withInput();
        }

        $asset = new Asset();
        $asset->kode_inventaris = $kodeInventaris;
        $asset->nomor_urut = $nomorUrut;
        $asset->jenis_barang_id = $jenis_barang_id;
        $asset->kategori_id = $kategori_id;
        $asset->ruangan_id = $request->ruangan_id;
        $asset->tahun_id = $tahun_id;
        $asset->harga_per_unit = $request->harga_per_unit;
        $asset->deskripsi = $request->deskripsi;
        $asset->user_id = auth()->id();
        $asset->save();

        return redirect()->route('assets.index')->with('success', 'Barang berhasil ditambahkan!');
    }

    public function show(Asset $asset)
    {
        $asset->load(['kategori', 'tahun', 'jenisBarang', 'ruangan', 'kondisi', 'user']);
        return view('assets.show', compact('asset'));
    }

    public function edit(Asset $asset)
    {
        $kategori = Kategori::orderBy('nama_kategori')->get();
        $tahun = Tahun::orderBy('tahun', 'desc')->get();
        $ruangan = Ruangan::orderBy('nama_ruangan')->get();
        $kondisi = Kondisi::orderBy('nama_kondisi')->get();
        $jenisBarang = JenisBarang::orderBy('nama_barang')->get();
        
        return view('assets.edit', compact('asset', 'kategori', 'tahun', 'ruangan', 'kondisi', 'jenisBarang'));
    }

    public function update(Request $request, Asset $asset)
    {
        $request->validate([
            'kategori_id' => 'required|exists:kategori,id',
            'tahun_id' => 'required|exists:tahun,id',
            'jenis_barang_id' => 'required|exists:jenis_barang,id',
            'ruangan_id' => 'required|exists:ruangan,id',
            'kondisi_id' => 'required|exists:kondisi,id',
            'nomor_urut' => 'required|integer|min:1',
            'harga_per_unit' => 'required|numeric|min:0',
            'deskripsi' => 'nullable|string',
        ]);

        // Generate kode inventaris otomatis
        $kodeInventaris = Asset::generateKodeInventaris(
            $request->kategori_id,
            $request->tahun_id,
            $request->jenis_barang_id,
            $request->nomor_urut
        );

        // Check if kode inventaris already exists (excluding current asset)
        if (Asset::where('kode_inventaris', $kodeInventaris)->where('id', '!=', $asset->id)->exists()) {
            return back()->withErrors(['nomor_urut' => 'Nomor urut ini sudah digunakan untuk kombinasi kategori, tahun, dan jenis barang yang sama']);
        }

        $asset->kategori_id = $request->kategori_id;
        $asset->tahun_id = $request->tahun_id;
        $asset->jenis_barang_id = $request->jenis_barang_id;
        $asset->ruangan_id = $request->ruangan_id;
        $asset->kondisi_id = $request->kondisi_id;
        $asset->nomor_urut = $request->nomor_urut;
        $asset->harga_per_unit = $request->harga_per_unit;
        $asset->deskripsi = $request->deskripsi;
        $asset->kode_inventaris = $kodeInventaris;
        $asset->save();

        return redirect()->route('assets.index')->with('success', 'Asset berhasil diperbarui');
    }

    public function destroy(Asset $asset)
    {
        $asset->delete();
        return redirect()->route('assets.index')->with('success', 'Asset berhasil dihapus');
    }

    public function getJenisBarang($kategoriId)
    {
        $jenisBarang = JenisBarang::where('kategori_id', $kategoriId)->get();
        return response()->json($jenisBarang);
    }

    public function detail($kode_inventaris_dasar)
    {
        // Ambil semua unit dengan kode inventaris dasar yang sama
        $units = Asset::with(['ruangan', 'tahun', 'kondisi', 'kategori', 'jenisBarang'])
            ->where('kode_inventaris', 'like', $kode_inventaris_dasar . '.%')
            ->orderBy('nomor_urut')
            ->get();
        if ($units->isEmpty()) {
            abort(404);
        }
        $induk = $units->first();
        $ruangan = Ruangan::orderBy('nama_ruangan')->get();
        $tahun = Tahun::orderBy('tahun', 'desc')->get();
        $kondisi = Kondisi::orderBy('nama_kondisi')->get();
        return view('assets.detail', compact('induk', 'units', 'ruangan', 'tahun', 'kondisi', 'kode_inventaris_dasar'));
    }

    public function addUnit(Request $request, $kode_inventaris_dasar)
    {
        $request->validate([
            'ruangan_id' => 'required|exists:ruangan,id',
            'tahun_id' => 'required|exists:tahun,id',
            'kondisi_id' => 'required|exists:kondisi,id',
        ]);
        $units = Asset::where('kode_inventaris', 'like', $kode_inventaris_dasar . '.%')->orderBy('nomor_urut')->get();
        if ($units->isEmpty()) {
            abort(404);
        }
        $induk = $units->first();
        $nomorUrut = $units->max('nomor_urut') + 1;
        $kodeInventaris = $kode_inventaris_dasar . '.' . str_pad($nomorUrut, 3, '0', STR_PAD_LEFT);
        if (Asset::where('kode_inventaris', $kodeInventaris)->exists()) {
            return back()->withErrors(['ruangan_id' => 'Kode inventaris sudah ada, silakan coba lagi.']);
        }
        $asset = new Asset();
        $asset->kode_inventaris = $kodeInventaris;
        $asset->nomor_urut = $nomorUrut;
        $asset->jenis_barang_id = $induk->jenis_barang_id;
        $asset->kategori_id = $induk->kategori_id;
        $asset->ruangan_id = $request->ruangan_id;
        $asset->tahun_id = $request->tahun_id;
        $asset->kondisi_id = $request->kondisi_id;
        $asset->harga_per_unit = $induk->harga_per_unit;
        $asset->deskripsi = $induk->deskripsi;
        $asset->user_id = auth()->id();
        $asset->save();
        return redirect()->route('assets.detail', ['kode_inventaris_dasar' => $kode_inventaris_dasar])->with('success', 'Unit barang berhasil ditambahkan!');
    }
} 