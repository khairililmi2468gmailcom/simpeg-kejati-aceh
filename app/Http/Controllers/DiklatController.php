<?php

namespace App\Http\Controllers;

use App\Models\Diklat;
use Illuminate\Http\Request;

class DiklatController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->search;
        $perPage = $request->per_page ?? 5;
    
        $diklat = \App\Models\Diklat::when($search, function ($query) use ($search) {
                $query->where('nama_diklat', 'like', "%$search%")
                      ->orWhere('jenis_diklat', 'like', "%$search%");
            })
            ->orderBy('id', 'desc')
            ->paginate($perPage);
    
        return view('admin.diklat.master.index', compact('diklat'));
    }
    
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.diklat.master.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama_diklat' => 'required|string|max:100',
            'jenis_diklat' => 'required|string|max:50',
        ]);

        Diklat::create([
            'nama_diklat' => $request->nama_diklat,
            'jenis_diklat' => $request->jenis_diklat,
        ]);

        return redirect()->route('admin.diklat.master.index')->with('success', 'Data diklat berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $diklat = Diklat::findOrFail($id);
        return view('admin.diklat.master.show', compact('diklat'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $diklat = Diklat::findOrFail($id);
        return view('admin.diklat.master.edit', compact('diklat'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'nama_diklat' => 'required|string|max:100',
            'jenis_diklat' => 'required|string|max:100',
        ]);

        $diklat = Diklat::findOrFail($id);
        $diklat->update([
            'nama_diklat' => $request->nama_diklat,
            'jenis_diklat' => $request->jenis_diklat,
        ]);

        return redirect()->route('admin.diklat.master.index')->with('success', 'Data diklat berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $diklat = Diklat::findOrFail($id);

        // Optional: Cek apakah diklat ini masih digunakan di MengikutiDiklat
        if ($diklat->pesertaDiklat()->count() > 0) {
            return redirect()->route('admin.diklat.master.index')->with('error', 'Tidak bisa menghapus diklat yang sedang digunakan.');
        }

        $diklat->delete();

        return redirect()->route('admin.diklat.master')->with('success', 'Data diklat berhasil dihapus.');
    }
    public function bulkDelete(Request $request)
    {
        $request->validate([
            'id' => 'required|array',
            'id.*' => 'integer|exists:diklat,id', 
        ]);
    
        Diklat::whereIn('id', $request->id)->delete();
    
        return redirect()->route('admin.diklat.master.index')->with('success', count($request->id) . ' data Diklat berhasil dihapus.');
    }
}
