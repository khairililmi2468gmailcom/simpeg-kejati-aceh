<?php

namespace App\Http\Controllers;

use App\Models\Cuti;
use Illuminate\Http\Request;

class CutiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->search;
        $perPage = $request->per_page ?? 5;
    
        $cuti = Cuti::when($search, function ($query) use ($search) {
                $query->where('jenis_cuti', 'like', "%$search%");
            })
            ->orderBy('id', 'desc')
            ->paginate($perPage);
    
        return view('admin.cuti.jeniscuti.index', compact('cuti'));
    }
    

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.cuti.jeniscuti.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'jenis_cuti' => 'required|string|max:50',
        ]);

        Cuti::create($request->only('jenis_cuti'));

        return redirect()->route('admin.cuti.jeniscuti.index')->with('success', 'Data cuti berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $cuti = Cuti::findOrFail($id);
        return view('admin.cuti.jeniscuti.show', compact('cuti'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $cuti = Cuti::findOrFail($id);
        return view('admin.cuti.jeniscuti.edit', compact('cuti'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'jenis_cuti' => 'required|string|max:50',
        ]);

        $cuti = Cuti::findOrFail($id);
        $cuti->update($request->only('jenis_cuti'));

        return redirect()->route('admin.cuti.jeniscuti.index')->with('success', 'Data cuti berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $cuti = Cuti::findOrFail($id);
        $cuti->delete();

        return redirect()->route('admin.cuti.jeniscuti.index')->with('success', 'Data cuti berhasil dihapus.');
    }

    public function bulkDelete(Request $request)
    {
        $request->validate([
            'id' => 'required|array',
            'id.*' => 'integer|exists:diklat,id', 
        ]);
    
        Cuti::whereIn('id', $request->id)->delete();
    
        return redirect()->route('admin.cuti.jeniscuti.index')->with('success', count($request->id) . ' data cuti berhasil dihapus.');
    }
}
