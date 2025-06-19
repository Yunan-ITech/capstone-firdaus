<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tahun;

class TahunController extends Controller
{
    public function index()
    {
        $tahun = Tahun::withCount('assets')->orderBy('tahun', 'desc')->get();
        return view('master.tahun.index', compact('tahun'));
    }

    public function create()
    {
        return view('master.tahun.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'tahun' => 'required|integer|min:2000|max:2100|unique:tahun',
            'deskripsi' => 'nullable|string'
        ]);

        Tahun::create($request->all());

        return redirect()->route('master.tahun.index')->with('success', 'Tahun berhasil ditambahkan');
    }

    public function edit(Tahun $tahun)
    {
        return view('master.tahun.edit', compact('tahun'));
    }

    public function update(Request $request, Tahun $tahun)
    {
        $request->validate([
            'tahun' => 'required|integer|min:2000|max:2100|unique:tahun,tahun,' . $tahun->id,
            'deskripsi' => 'nullable|string'
        ]);

        $tahun->update($request->all());

        return redirect()->route('master.tahun.index')->with('success', 'Tahun berhasil diperbarui');
    }

    public function destroy(Tahun $tahun)
    {
        if ($tahun->assets()->count() > 0) {
            return redirect()->route('master.tahun.index')->with('error', 'Tahun tidak dapat dihapus karena masih memiliki aset');
        }

        $tahun->delete();
        return redirect()->route('master.tahun.index')->with('success', 'Tahun berhasil dihapus');
    }
} 