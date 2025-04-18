<?php

namespace App\Http\Controllers;

use App\Models\UnitKerja;
use Illuminate\Http\Request;

class UnitKerjaController extends Controller
{
    public function index()
    {
        $unitKerjas = UnitKerja::all();
        return view('admin.settings.unitkerja.index', compact('unitKerjas'));
    }

    public function create()
    {
        return view('admin.settings.unitkerja.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'kode_kantor' => 'required|string|unique:unit_kerja,kode_kantor',
            'nama_kantor' => 'required|string|max:255',
            'id_provinsi' => 'required|exists:provinsi,id',
        ]);

        UnitKerja::create([
            'kode_kantor' => $request->kode_kantor,
            'nama_kantor' => $request->nama_kantor,
            'id_provinsi' => $request->id_provinsi,
        ]);
    
        return redirect()->route('unitkerja.index')->with('success', 'Data unit kerja berhasil ditambahkan.');
    }

    public function show($id)
    {
        $unitKerja = UnitKerja::findOrFail($id);
        return view('admin.settings.unitkerja.show', compact('unitKerja'));
    }

    public function edit($id)
    {
        $unitKerja = UnitKerja::findOrFail($id);
        return view('admin.settings.unitkerja.edit', compact('unitKerja'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_kantor' => 'required|string|max:255',
            'provinsi' => 'required|string|max:255',
        ]);

        $unitKerja = UnitKerja::findOrFail($id);
        $unitKerja->update($request->only(['nama_kantor', 'provinsi']));

        return redirect()->route('admin.settings.unitkerja.index')->with('success', 'Data unit kerja berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $unitKerja = UnitKerja::findOrFail($id);
        $unitKerja->delete();

        return redirect()->route('admin.settings.unitkerja.index')->with('success', 'Data unit kerja berhasil dihapus.');
    }
}
