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
    public function index()
    {
        $assets = Asset::with(['kategori', 'tahun', 'jenisBarang', 'ruangan', 'kondisi', 'user'])
            ->orderBy('created_at', 'desc')
            ->paginate(10);
        return view('assets.index', compact('assets'));
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
            'nomor_urut' => 'required|integer|min:1',
            'jenis_barang_id' => 'required|exists:jenis_barang,id',
            'kategori_id' => 'required|exists:kategori,id',
            'ruangan_id' => 'required|exists:ruangan,id',
            'tahun_id' => 'required|exists:tahun,id',
            'kondisi_id' => 'required|exists:kondisi,id',
            'deskripsi' => 'nullable|string',
        ]);

        $kategori = Kategori::find($request->kategori_id);
        $tahun = Tahun::find($request->tahun_id);
        $jenisBarang = JenisBarang::find($request->jenis_barang_id);
        $nomorUrut = str_pad($request->nomor_urut, 3, '0', STR_PAD_LEFT);

        $kodeInventaris = strtoupper(substr($kategori->nama_kategori, 0, 3)) . '-' .
                          $tahun->tahun . '-' .
                          strtoupper(substr($jenisBarang->nama_barang, 0, 4)) . '-' .
                          $nomorUrut;

        // Pastikan kode inventaris unik
        if (\App\Models\Asset::where('kode_inventaris', $kodeInventaris)->exists()) {
            return back()->withErrors(['nomor_urut' => 'Kode inventaris sudah ada, silakan gunakan nomor urut lain.'])->withInput();
        }

        $asset = new Asset();
        $asset->kode_inventaris = $kodeInventaris;
        $asset->nomor_urut = $request->nomor_urut;
        $asset->jenis_barang_id = $request->jenis_barang_id;
        $asset->kategori_id = $request->kategori_id;
        $asset->ruangan_id = $request->ruangan_id;
        $asset->tahun_id = $request->tahun_id;
        $asset->kondisi_id = $request->kondisi_id;
        $asset->deskripsi = $request->deskripsi;
        $asset->user_id = auth()->id();
        $asset->save();

        return redirect()->route('assets.index')->with('success', 'Barang berhasil ditambahkan! Kode Inventaris: ' . $kodeInventaris);
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
            'keterangan' => 'nullable|string'
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

        $asset->update($request->all());
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
} 