<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\JenisBarang;
use App\Models\Kategori;

class JenisBarangController extends Controller
{
    public function index(Request $request)
    {
        // Ambil semua kategori bersama dengan relasi jenisBarang untuk membuat modal edit
        $kategoriWithAllItems = Kategori::with(['jenisBarang' => function($q) {
            $q->orderBy('id', 'desc');
        }])->orderBy('kode_kategori', 'asc')->get();

        // Siapkan data paginasi untuk setiap kategori
        $paginators = [];
        $queryParams = $request->query();

        foreach ($kategoriWithAllItems as $kat) {
            $pageName = 'page_k' . $kat->id; // Nama parameter halaman unik untuk setiap tabel
            
            $paginator = JenisBarang::where('kategori_id', $kat->id)
                ->latest() // Urutkan berdasarkan data terbaru (created_at DESC)
                ->paginate(10, ['*'], $pageName);
            
            // Tambahkan parameter query lain agar tidak hilang saat pindah halaman
            $paginator->appends($queryParams);

            $paginators[$kat->id] = $paginator;
        }

        return view('master.jenis-barang.index', [
            'kategori' => $kategoriWithAllItems,
            'paginators' => $paginators,
        ]);
    }

    public function create()
    {
        $kategori = Kategori::orderBy('nama_kategori')->get();
        return view('master.jenis-barang.create', compact('kategori'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_barang' => 'required|string|max:255|unique:jenis_barang,nama_barang,NULL,id,kategori_id,' . $request->kategori_id,
            'kategori_id' => 'required|exists:kategori,id',
            'kode_barang' => 'required|string|max:10|unique:jenis_barang,kode_barang,NULL,id,kategori_id,' . $request->kategori_id,
            'deskripsi' => 'nullable|string'
        ]);

        $data = $request->all();

        JenisBarang::create($data);

        return redirect()->route('master.jenis-barang.index')->with('success', 'Jenis barang berhasil ditambahkan');
    }

    public function edit(JenisBarang $jenisBarang)
    {
        $kategori = Kategori::orderBy('nama_kategori')->get();
        return view('master.jenis-barang.edit', compact('jenisBarang', 'kategori'));
    }

    public function update(Request $request, JenisBarang $jenisBarang)
    {
        $request->validate([
            'nama_barang' => 'required|string|max:255|unique:jenis_barang,nama_barang,' . $jenisBarang->id . ',id,kategori_id,' . $request->kategori_id,
            'kategori_id' => 'required|exists:kategori,id',
            'kode_barang' => 'required|string|max:10|unique:jenis_barang,kode_barang,' . $jenisBarang->id . ',id,kategori_id,' . $request->kategori_id,
            'deskripsi' => 'nullable|string'
        ]);

        $jenisBarang->update($request->all());

        return redirect()->route('master.jenis-barang.index')->with('success', 'Jenis barang berhasil diperbarui');
    }

    public function destroy(JenisBarang $jenisBarang)
    {
        if ($jenisBarang->assets()->count() > 0) {
            return redirect()->route('master.jenis-barang.index')->with('error', 'Jenis barang tidak dapat dihapus karena masih memiliki aset');
        }

        $jenisBarang->delete();
        return redirect()->route('master.jenis-barang.index')->with('success', 'Jenis barang berhasil dihapus');
    }

    public function getByKategori($kategoriId)
    {
        $jenisBarang = JenisBarang::where('kategori_id', $kategoriId)->get();
        return response()->json($jenisBarang);
    }
} 