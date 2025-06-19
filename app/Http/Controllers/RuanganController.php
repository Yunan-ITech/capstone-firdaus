<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ruangan;

class RuanganController extends Controller
{
    public function index()
    {
        $ruangan = Ruangan::withCount('assets')->orderBy('nama_ruangan')->get();
        return view('master.ruangan.index', compact('ruangan'));
    }

    public function create()
    {
        return view('master.ruangan.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_ruangan' => 'required|string|max:255|unique:ruangan',
            'deskripsi' => 'nullable|string'
        ]);

        Ruangan::create($request->all());

        return redirect()->route('master.ruangan.index')->with('success', 'Ruangan berhasil ditambahkan');
    }

    public function edit(Ruangan $ruangan)
    {
        return view('master.ruangan.edit', compact('ruangan'));
    }

    public function update(Request $request, Ruangan $ruangan)
    {
        $request->validate([
            'nama_ruangan' => 'required|string|max:255|unique:ruangan,nama_ruangan,' . $ruangan->id,
            'deskripsi' => 'nullable|string'
        ]);

        $ruangan->update($request->all());

        return redirect()->route('master.ruangan.index')->with('success', 'Ruangan berhasil diperbarui');
    }

    public function destroy(Ruangan $ruangan)
    {
        if ($ruangan->assets()->count() > 0) {
            return redirect()->route('master.ruangan.index')->with('error', 'Ruangan tidak dapat dihapus karena masih memiliki aset');
        }

        $ruangan->delete();
        return redirect()->route('master.ruangan.index')->with('success', 'Ruangan berhasil dihapus');
    }
} 