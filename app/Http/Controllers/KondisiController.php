<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Kondisi;

class KondisiController extends Controller
{
    public function index()
    {
        $kondisi = Kondisi::withCount('assets')->orderBy('nama_kondisi')->get();
        return view('master.kondisi.index', compact('kondisi'));
    }

    public function create()
    {
        return view('master.kondisi.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_kondisi' => 'required|string|max:255|unique:kondisi',
            'deskripsi' => 'nullable|string',
            'warna' => 'nullable|string|max:7'
        ]);

        Kondisi::create($request->all());

        return redirect()->route('master.kondisi.index')->with('success', 'Kondisi berhasil ditambahkan');
    }

    public function edit(Kondisi $kondisi)
    {
        return view('master.kondisi.edit', compact('kondisi'));
    }

    public function update(Request $request, Kondisi $kondisi)
    {
        $request->validate([
            'nama_kondisi' => 'required|string|max:255|unique:kondisi,nama_kondisi,' . $kondisi->id,
            'deskripsi' => 'nullable|string',
            'warna' => 'nullable|string|max:7'
        ]);

        $kondisi->update($request->all());

        return redirect()->route('master.kondisi.index')->with('success', 'Kondisi berhasil diperbarui');
    }

    public function destroy(Kondisi $kondisi)
    {
        if ($kondisi->assets()->count() > 0) {
            return redirect()->route('master.kondisi.index')->with('error', 'Kondisi tidak dapat dihapus karena masih memiliki aset');
        }

        $kondisi->delete();
        return redirect()->route('master.kondisi.index')->with('success', 'Kondisi berhasil dihapus');
    }
} 