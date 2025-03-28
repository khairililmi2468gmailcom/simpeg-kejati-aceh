<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Kecamatan;
use App\Models\Kabupaten;

class KecamatanController extends Controller
{
    public function index()
    {
        $kecamatan = Kecamatan::with('kabupaten')->get();
        return view('admin.kecamatan.index', compact('kecamatan'));
    }

    public function create()
    {
        $kabupaten = Kabupaten::all();
        return view('admin.kecamatan.create', compact('kabupaten'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'id' => 'required|string|max:7|unique:kecamatan,id',
            'nama_kecamatan' => 'required|string|max:50',
            'id_kabupaten' => 'required|string|max:4|exists:kabupaten,id',
        ]);

        Kecamatan::create($request->all());

        return redirect()->route('kecamatan.index')->with('success', 'Kecamatan berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $kecamatan = Kecamatan::findOrFail($id);
        $kabupaten = Kabupaten::all();
        return view('admin.kecamatan.edit', compact('kecamatan', 'kabupaten'));
    }

    public function update(Request $request, $id)
    {
        $kecamatan = Kecamatan::findOrFail($id);

        $request->validate([
            'nama_kecamatan' => 'required|string|max:50',
            'id_kabupaten' => 'required|string|max:4|exists:kabupaten,id',
        ]);

        $kecamatan->update($request->all());

        return redirect()->route('kecamatan.index')->with('success', 'Kecamatan berhasil diperbarui.');
    }

    public function destroy($id)
    {
        Kecamatan::findOrFail($id)->delete();
        return redirect()->route('kecamatan.index')->with('success', 'Kecamatan berhasil dihapus.');
    }
}
