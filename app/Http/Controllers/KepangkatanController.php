<?php

namespace App\Http\Controllers;

use App\Models\Kepangkatan;
use App\Models\Pegawai;
use App\Models\Golongan;
use Illuminate\Http\Request;

class KepangkatanController extends Controller
{
    public function index()
    {
        $kepangkatans = Kepangkatan::with(['pegawai', 'golongan'])->get();
        return view('admin.kepangkatan.index', compact('kepangkatans'));
    }

    public function create()
    {
        $pegawais = Pegawai::all();
        $golongans = Golongan::all();
        return view('admin.kepangkatan.create', compact('pegawais', 'golongans'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'no_sk' => 'required|string|unique:kepangkatan,no_sk',
            'nip' => 'required|exists:pegawai,nip',
            'alasan' => 'nullable|string|max:255',
            'no_pertimbangan' => 'nullable|string|max:255',
            'tanggal_sk' => 'required|date',
            'pembuat_sk' => 'required|string|max:255',
            'tmt_sk_pangkat' => 'required|date',
            'no_usulan' => 'nullable|string|max:255',
            'jenis_usulan' => 'nullable|string|max:255',
            'pangkat_l' => 'nullable|string|max:255',
            'id_golongan' => 'required|exists:golongan,id_golongan',
        ]);

        Kepangkatan::create($request->all());

        return redirect()->route('kepangkatan.index')->with('success', 'Data kepangkatan berhasil ditambahkan.');
    }

    public function show($id)
    {
        $kepangkatan = Kepangkatan::with(['pegawai', 'golongan'])->findOrFail($id);
        return view('admin.kepangkatan.show', compact('kepangkatan'));
    }

    public function edit($id)
    {
        $kepangkatan = Kepangkatan::findOrFail($id);
        $pegawais = Pegawai::all();
        $golongans = Golongan::all();
        return view('admin.kepangkatan.edit', compact('kepangkatan', 'pegawais', 'golongans'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nip' => 'required|exists:pegawai,nip',
            'alasan' => 'nullable|string|max:255',
            'no_pertimbangan' => 'nullable|string|max:255',
            'tanggal_sk' => 'required|date',
            'pembuat_sk' => 'required|string|max:255',
            'tmt_sk_pangkat' => 'required|date',
            'no_usulan' => 'nullable|string|max:255',
            'jenis_usulan' => 'nullable|string|max:255',
            'pangkat_l' => 'nullable|string|max:255',
            'id_golongan' => 'required|exists:golongan,id_golongan',
        ]);

        $kepangkatan = Kepangkatan::findOrFail($id);
        $kepangkatan->update($request->except('no_sk')); // `no_sk` tidak diubah

        return redirect()->route('kepangkatan.index')->with('success', 'Data kepangkatan berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $kepangkatan = Kepangkatan::findOrFail($id);
        $kepangkatan->delete();

        return redirect()->route('kepangkatan.index')->with('success', 'Data kepangkatan berhasil dihapus.');
    }
}
