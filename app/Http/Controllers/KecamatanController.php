<?php

namespace App\Http\Controllers;

use App\Imports\KecamatanImport;
use Illuminate\Http\Request;
use App\Models\Kecamatan;
use App\Models\Kabupaten;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Log;

class KecamatanController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->search;
        $perPage = $request->per_page ?? 5;

        $kecamatan = Kecamatan::with('kabupaten')
            ->when($search, function ($query) use ($search) {
                $query->where('id', 'like', "%$search%")
                    ->orWhere('nama_kecamatan', 'like', "%$search%");
            })
            ->orderBy('id', 'desc')
            ->paginate($perPage);
        $referensi = [
            'kabupaten' => \App\Models\Kabupaten::select('id', 'nama_kabupaten as nama')->get(),
        ];
        return view('admin.kecamatan.index', compact('kecamatan', 'referensi'));
    }

    public function create()
    {
        $kabupaten = Kabupaten::all();
        return view('admin.kecamatan.create', compact('kabupaten'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'id' => 'nullable|string|max:6|unique:kecamatan,id',
            'nama_kecamatan' => 'required|string|max:50',
            'id_kabupaten' => 'required|string|max:4|exists:kabupaten,id',
        ]);

        $newId = $request->id;
        if (!$newId) {
            $existingIds = Kecamatan::pluck('id')->map(fn($id) => intval($id))->sort()->values();
            for ($i = 100000; $i <= 999999; $i++) {
                if (!$existingIds->contains($i)) {
                    $newId = str_pad($i, 6, '0', STR_PAD_LEFT);
                    break;
                }
            }
        }

        Kecamatan::create([
            'id' => $newId,
            'nama_kecamatan' => $request->nama_kecamatan,
            'id_kabupaten' => $request->id_kabupaten,
        ]);

        return redirect()->route('admin.kecamatan.index')->with('success', 'Kecamatan berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $kecamatan = Kecamatan::findOrFail($id);
        $kabupaten = Kabupaten::all();
        return view('admin.kecamatan.edit', compact('kecamatan', 'kabupaten'));
    }

    public function update(Request $request, $id)
    {
        $kecamatan = Kecamatan::findOrFail($id);

        $request->validate([
            'nama_kecamatan' => 'required|string|max:50',
            'id_kabupaten' => 'required|string|max:4|exists:kabupaten,id',
        ]);

        $kecamatan->update($request->all());

        return redirect()->route('admin.kecamatan.index')->with('success', 'Kecamatan berhasil diperbarui.');
    }

    public function destroy($id)
    {
        Kecamatan::findOrFail($id)->delete();
        return redirect()->route('admin.kecamatan.index')->with('success', 'Kecamatan berhasil dihapus.');
    }

    public function bulkDelete(Request $request)
    {
        $request->validate([
            'id' => 'required|array',
            'id.*' => 'string|exists:kecamatan,id',
        ]);

        Kecamatan::whereIn('id', $request->id)->delete();

        return redirect()->route('admin.kecamatan.index')->with('success', count($request->id) . ' data Kecamatan berhasil dihapus.');
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls,csv',
        ]);

        try {
            Excel::import(new KecamatanImport, $request->file('file'));

            // Kembalikan JSON untuk notifikasi sukses
            return response()->json([
                'success' => true,
                'message' => 'Import berhasil.'
            ]);
        } catch (\Exception $e) {
            Log::error('Error saat import Kecamatan: ' . $e->getMessage(), [
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'trace' => $e->getTraceAsString()
            ]);

            // Kembalikan JSON untuk notifikasi gagal
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat import.'
            ]);
        }
    }
    public function downloadTemplate()
    {
        $file = public_path('template/template-kecamatan-fill.xlsx');

        if (!file_exists($file)) {
            abort(404, 'Template tidak ditemukan.');
        }

        return response()->download($file, 'template-kecamatan.xlsx');
    }
}
