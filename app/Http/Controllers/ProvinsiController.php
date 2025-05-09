<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Provinsi;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\ProvinsiImport;

class ProvinsiController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->search;
        $perPage = $request->per_page ?? 5;

        $provinsi = Provinsi::query()
            ->when($search, function ($query) use ($search) {
                $query->where('id', 'like', "%$search%")
                    ->orWhere('nama_provinsi', 'like', "%$search%");
            })
            ->orderBy('nama_provinsi', 'asc')
            ->paginate($perPage)
            ->appends($request->all()); // penting untuk tetap menyimpan query string saat pagination

        return view('admin.provinsi.index', compact('provinsi'));
    }


    public function create()
    {
        return view('admin.provinsi.create');
    }


    private function getNextAvailableId()
    {
        $usedIds = Provinsi::orderBy('id')->pluck('id')->toArray();

        for ($i = 1; $i <= 99; $i++) {
            if (!in_array($i, $usedIds)) {
                return $i;
            }
        }

        throw new \Exception("ID provinsi sudah penuh sampai 99.");
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_provinsi' => 'required|string|max:30|unique:provinsi,nama_provinsi',
            'id' => 'nullable|string|max:2|unique:provinsi,id',
        ]);

        $data = $request->all();

        if (empty($data['id'])) {
            $usedIds = Provinsi::pluck('id')->toArray();
            for ($i = 1; $i <= 99; $i++) {
                $iStr = str_pad($i, 2, '0', STR_PAD_LEFT);
                if (!in_array($iStr, $usedIds)) {
                    $data['id'] = $iStr;
                    break;
                }
            }
        }

        Provinsi::create($data);

        return redirect()->route('admin.provinsi.index')->with('success', 'Provinsi berhasil ditambahkan.');
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
            'nama_provinsi' => 'required|string|max:30|unique:provinsi,nama_provinsi,' . $id . ',id',
        ]);

        $provinsi->update([
            'nama_provinsi' => $request->nama_provinsi,
        ]);

        return redirect()->route('admin.provinsi.index')->with('success', 'Provinsi berhasil diperbarui.');
    }


    public function destroy($id)
    {
        Provinsi::findOrFail($id)->delete();
        return redirect()->route('admin.provinsi.index')->with('success', 'Provinsi berhasil dihapus.');
    }
    public function bulkDelete(Request $request)
    {
        $id = $request->id;

        if (!$id || !is_array($id)) {
            return redirect()->back()->with('error', 'Tidak ada data yang dipilih.');
        }

        $provinsiList = Provinsi::whereIn('id', $id)->get();

        foreach ($provinsiList as $provinsi) {

            $provinsi->delete();
        }

        return redirect()->route('admin.provinsi.index')->with('success', count($id) . ' data provinsi berhasil dihapus.');
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls,csv',
        ]);

        try {
            Excel::import(new ProvinsiImport, $request->file('file'));

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
        $file = public_path('template/template-provinsi-fill.xlsx');

        if (!file_exists($file)) {
            abort(404, 'Template tidak ditemukan.');
        }

        return response()->download($file, 'template-provinsi.xlsx');
    }
}
