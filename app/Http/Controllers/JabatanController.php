<?php

namespace App\Http\Controllers;

use App\Models\Jabatan;
use App\Models\UnitKerja;
use Illuminate\Http\Request;

class JabatanController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->search;
        $perPage = $request->per_page ?? 5;

        $jabatans = Jabatan::with('unitKerja')
            ->when($search, function ($query) use ($search) {
                $query->where('nama_jabatan', 'like', "%$search%")
                    ->orWhere('ket', 'like', "%$search%");
            })
            ->orderBy('nama_jabatan')
            ->paginate($perPage);

        return view('admin.settings.jabatan.index', compact('jabatans', 'search', 'perPage'));
    }



    public function create()
    {
        $unitKerjas = UnitKerja::all();
        return view('admin.settings.jabatan.create', compact('unitKerjas'));
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
        return view('admin.settings.jabatan.show', compact('jabatan'));
    }

    public function edit($id)
    {
        $jabatan = Jabatan::findOrFail($id);
        $unitKerjas = UnitKerja::all();
        return view('admin.settings.jabatan.edit', compact('jabatan', 'unitKerjas'));
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

        return redirect()->route('admin.settings.jabatan.index')->with('success', 'Data jabatan berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $jabatan = Jabatan::findOrFail($id);
        $jabatan->delete();

        return redirect()->route('admin.settings.jabatan.index')->with('success', 'Data jabatan berhasil dihapus.');
    }
}
