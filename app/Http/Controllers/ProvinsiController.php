<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Provinsi;

class ProvinsiController extends Controller
{
    public function index()
    {
        $provinsi = Provinsi::all();
        return view('admin.provinsi.index', compact('provinsi'));
    }

    public function create()
    {
        return view('admin.provinsi.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'id' => 'required|string|max:2|unique:provinsi,id',
            'nama_provinsi' => 'required|string|max:30',
        ]);

        Provinsi::create($request->all());

        return redirect()->route('provinsi.index')->with('success', 'Provinsi berhasil ditambahkan.');
    }

    public function show($id)
    {
        $provinsi = Provinsi::findOrFail($id);
        return view('admin.provinsi.show', compact('provinsi'));
    }

    public function edit($id)
    {
        $provinsi = Provinsi::findOrFail($id);
        return view('admin.provinsi.edit', compact('provinsi'));
    }

    public function update(Request $request, $id)
    {
        $provinsi = Provinsi::findOrFail($id);

        $request->validate([
            'nama_provinsi' => 'required|string|max:30',
        ]);

        $provinsi->update($request->all());

        return redirect()->route('provinsi.index')->with('success', 'Provinsi berhasil diperbarui.');
    }

    public function destroy($id)
    {
        Provinsi::findOrFail($id)->delete();
        return redirect()->route('provinsi.index')->with('success', 'Provinsi berhasil dihapus.');
    }
}
