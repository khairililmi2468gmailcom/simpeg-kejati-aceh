<?php

namespace App\Http\Controllers;

use App\Imports\KabupatenImport;
use Illuminate\Http\Request;
use App\Models\Kabupaten;
use App\Models\Provinsi;
use Maatwebsite\Excel\Facades\Excel;


class KabupatenController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->search;
        $perPage = $request->per_page ?? 5;

        $kabupaten = Kabupaten::with('provinsi')
            ->when($search, function ($query) use ($search) {
                $query->where('id', 'like', "%$search%")
                    ->orWhere('nama_kabupaten', 'like', "%$search%");
            })
            ->orderBy('id')
            ->paginate($perPage);
        $referensi = [
            'provinsi' => \App\Models\Provinsi::select('id', 'nama_provinsi as nama')->get(),
        ];
        return view('admin.kabupaten.index', compact('kabupaten', 'referensi'));
    }

    public function create()
    {
        $provinsi = Provinsi::all();
        return view('admin.kabupaten.create', compact('provinsi'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_kabupaten' => 'required|string|max:50|unique:kabupaten,nama_kabupaten',
            'id_provinsi' => 'required|string|max:2|exists:provinsi,id',
        ]);

        // Ambil semua ID yang sudah dipakai, lalu ubah ke array angka
        $existingIds = Kabupaten::pluck('id')->map(fn($id) => intval($id))->sort()->values();

        // Cari id kosong pertama
        $newId = null;
        for ($i = 1000; $i <= 9999; $i++) {
            if (!$existingIds->contains($i)) {
                $newId = str_pad($i, 4, '0', STR_PAD_LEFT);
                break;
            }
        }

        Kabupaten::create([
            'id' => $newId,
            'nama_kabupaten' => $request->nama_kabupaten,
            'id_provinsi' => $request->id_provinsi,
        ]);

        return redirect()->route('admin.kabupaten')->with('success', 'Kabupaten berhasil ditambahkan.');
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

        return redirect()->route('admin.kabupaten')->with('success', 'Kabupaten berhasil diperbarui.');
    }

    public function destroy($id)
    {
        Kabupaten::findOrFail($id)->delete();
        return redirect()->route('admin.kabupaten')->with('success', 'Kabupaten berhasil dihapus.');
    }

    public function bulkDelete(Request $request)
    {
        $request->validate([
            'id' => 'required|array',
            'id.*' => 'string|exists:kabupaten,id',
        ]);

        Kabupaten::whereIn('id', $request->id)->delete();

        return redirect()->route('admin.kabupaten')->with('success', count($request->id) . ' data kabupaten berhasil dihapus.');
    }
    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls,csv',
        ]);

        try {
            Excel::import(new KabupatenImport, $request->file('file'));

            // Kembalikan JSON untuk notifikasi sukses
            return response()->json([
                'success' => true,
                'message' => 'Import berhasil.'
            ]);
        } catch (\Exception $e) {
            // Kembalikan JSON untuk notifikasi gagal
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat import.'
            ]);
        }
    }

    public function downloadTemplate()
    {
        $file = public_path('template/template-kabupaten.xlsx');

        if (!file_exists($file)) {
            abort(404, 'Template tidak ditemukan.');
        }

        return response()->download($file, 'template-kabupaten.xlsx');
    }
}
