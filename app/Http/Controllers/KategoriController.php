<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Kategori;

class KategoriController extends Controller
{
    public function index()
    {
        $kategori = Kategori::withCount('assets')->orderBy('nama_kategori')->get();
        return view('master.kategori.index', compact('kategori'));
    }

    public function create()
    {
        return view('master.kategori.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'kode_kategori' => 'required|string|max:10|unique:kategori',
            'id_kategori' => 'required|string|max:10|unique:kategori',
            'nama_kategori' => 'required|string|max:255|unique:kategori',
            'deskripsi' => 'nullable|string'
        ]);

        Kategori::create($request->all());

        return redirect()->route('master.kategori.index')->with('success', 'Kategori berhasil ditambahkan');
    }

    public function edit(Kategori $kategori)
    {
        return view('master.kategori.edit', compact('kategori'));
    }

    public function update(Request $request, Kategori $kategori)
    {
        $request->validate([
            'kode_kategori' => 'required|string|max:10|unique:kategori,kode_kategori,' . $kategori->id,
            'id_kategori' => 'required|string|max:10|unique:kategori,id_kategori,' . $kategori->id,
            'nama_kategori' => 'required|string|max:255|unique:kategori,nama_kategori,' . $kategori->id,
            'deskripsi' => 'nullable|string'
        ]);

        $kategori->update($request->all());

        return redirect()->route('master.kategori.index')->with('success', 'Kategori berhasil diperbarui');
    }

    public function destroy(Kategori $kategori)
    {
        if ($kategori->assets()->count() > 0) {
            return redirect()->route('master.kategori.index')->with('error', 'Kategori tidak dapat dihapus karena masih memiliki aset');
        }

        $kategori->delete();
        return redirect()->route('master.kategori.index')->with('success', 'Kategori berhasil dihapus');
    }
} 