<?php

namespace App\Http\Controllers;

use App\Models\Golongan;
use Illuminate\Http\Request;

class GolonganController extends Controller
{
    public function index()
    {
        $golongans = Golongan::all();
        return view('golongan.index', compact('golongans'));
    }

    public function create()
    {
        return view('golongan.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_golongan' => 'required|string|unique:golongan,id_golongan',
            'jabatan_fungsional' => 'required|string|max:255',
            'pangkat' => 'required|string|max:255',
        ]);

        Golongan::create($request->all());

        return redirect()->route('golongan.index')->with('success', 'Data golongan berhasil ditambahkan.');
    }

    public function show($id)
    {
        $golongan = Golongan::findOrFail($id);
        return view('golongan.show', compact('golongan'));
    }

    public function edit($id)
    {
        $golongan = Golongan::findOrFail($id);
        return view('golongan.edit', compact('golongan'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'jabatan_fungsional' => 'required|string|max:255',
            'pangkat' => 'required|string|max:255',
        ]);

        $golongan = Golongan::findOrFail($id);
        $golongan->update($request->only(['jabatan_fungsional', 'pangkat']));

        return redirect()->route('golongan.index')->with('success', 'Data golongan berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $golongan = Golongan::findOrFail($id);
        $golongan->delete();

        return redirect()->route('golongan.index')->with('success', 'Data golongan berhasil dihapus.');
    }
}
