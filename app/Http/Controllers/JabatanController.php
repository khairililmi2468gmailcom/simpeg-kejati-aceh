<?php

namespace App\Http\Controllers;

use App\Models\Jabatan;
use App\Models\UnitKerja;
use Illuminate\Http\Request;

class JabatanController extends Controller
{
    public function index()
    {
        $jabatans = Jabatan::with('unitKerja')->get();
        return view('admin.jabatan.index', compact('jabatans'));
    }

    public function create()
    {
        $unitKerjas = UnitKerja::all();
        return view('admin.jabatan.create', compact('unitKerjas'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_jabatan' => 'required|string|max:255',
            'ket' => 'nullable|string|max:255',
            'kode_kantor' => 'required|exists:unit_kerja,kode_kantor',
        ]);

        Jabatan::create($request->all());

        return redirect()->route('jabatan.index')->with('success', 'Data jabatan berhasil ditambahkan.');
    }

    public function show($id)
    {
        $jabatan = Jabatan::with('unitKerja')->findOrFail($id);
        return view('admin.jabatan.show', compact('jabatan'));
    }

    public function edit($id)
    {
        $jabatan = Jabatan::findOrFail($id);
        $unitKerjas = UnitKerja::all();
        return view('admin.jabatan.edit', compact('jabatan', 'unitKerjas'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_jabatan' => 'required|string|max:255',
            'ket' => 'nullable|string|max:255',
            'kode_kantor' => 'required|exists:unit_kerja,kode_kantor',
        ]);

        $jabatan = Jabatan::findOrFail($id);
        $jabatan->update($request->all());

        return redirect()->route('jabatan.index')->with('success', 'Data jabatan berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $jabatan = Jabatan::findOrFail($id);
        $jabatan->delete();

        return redirect()->route('jabatan.index')->with('success', 'Data jabatan berhasil dihapus.');
    }
}
