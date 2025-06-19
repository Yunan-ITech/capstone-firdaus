<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\JenisBarang;
use App\Models\Kategori;

class JenisBarangController extends Controller
{
    public function index()
    {
        $kategori = Kategori::with(['jenisBarang' => function($q) {
            $q->orderBy('nama_barang');
        }])->orderBy('kode_kategori', 'asc')->get();
        return view('master.jenis-barang.index', compact('kategori'));
    }

    public function create()
    {
        $kategori = Kategori::orderBy('nama_kategori')->get();
        return view('master.jenis-barang.create', compact('kategori'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_barang' => 'required|string|max:255|unique:jenis_barang',
            'kategori_id' => 'required|exists:kategori,id',
            'deskripsi' => 'nullable|string'
        ]);

        JenisBarang::create($request->all());

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
            'nama_barang' => 'required|string|max:255|unique:jenis_barang,nama_barang,' . $jenisBarang->id,
            'kategori_id' => 'required|exists:kategori,id',
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