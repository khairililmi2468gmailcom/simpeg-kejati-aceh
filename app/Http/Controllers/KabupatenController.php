<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Kabupaten;
use App\Models\Provinsi;

class KabupatenController extends Controller
{
    public function index()
    {
        $kabupaten = Kabupaten::with('provinsi')->get();
        return view('admin.kabupaten.index', compact('kabupaten'));
    }

    public function create()
    {
        $provinsi = Provinsi::all();
        return view('admin.kabupaten.create', compact('provinsi'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'id' => 'required|string|max:4|unique:kabupaten,id',
            'nama_kabupaten' => 'required|string|max:50',
            'id_provinsi' => 'required|string|max:2|exists:provinsi,id',
        ]);

        Kabupaten::create($request->all());

        return redirect()->route('kabupaten.index')->with('success', 'Kabupaten berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $kabupaten = Kabupaten::findOrFail($id);
        $provinsi = Provinsi::all();
        return view('admin.kabupaten.edit', compact('kabupaten', 'provinsi'));
    }

    public function update(Request $request, $id)
    {
        $kabupaten = Kabupaten::findOrFail($id);

        $request->validate([
            'nama_kabupaten' => 'required|string|max:50',
            'id_provinsi' => 'required|string|max:2|exists:provinsi,id',
        ]);

        $kabupaten->update($request->all());

        return redirect()->route('kabupaten.index')->with('success', 'Kabupaten berhasil diperbarui.');
    }

    public function destroy($id)
    {
        Kabupaten::findOrFail($id)->delete();
        return redirect()->route('kabupaten.index')->with('success', 'Kabupaten berhasil dihapus.');
    }
}
