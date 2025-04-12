<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Provinsi;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\ProvinsiImport;

class ProvinsiController extends Controller
{
    public function index()
    {
        $provinsi = Provinsi::all();
        return view('admin.provinsi.index', compact('provinsi'));
    }

    public function search(Request $request)
    {
        // Ambil keyword pencarian dari input user
        $query = $request->input('search');
    
        // Cari provinsi berdasarkan nama atau ID
        $provinsi = Provinsi::where('id', 'like', "%$query%")
            ->orWhere('nama_provinsi', 'like', "%$query%")
            ->get();
    
        // Kembalikan hasil pencarian ke view dengan data provinsi
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
                return str_pad($i, 2, '0', STR_PAD_LEFT); // hasilkan id seperti '01', '02', dst
            }
        }

        throw new \Exception("ID provinsi sudah penuh sampai 99.");
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_provinsi' => 'required|string|max:30|unique:provinsi,nama_provinsi',
        ]);

        $data = $request->all();
        $data['id'] = $this->getNextAvailableId();

        Provinsi::create($data);

        return redirect()->route('admin.provinsi')->with('success', 'Provinsi berhasil ditambahkan.');
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
            'nama_provinsi' => 'required|string|max:30',
        ]);

        $provinsi->update($request->all());

        return redirect()->route('admin.provinsi')->with('success', 'Provinsi berhasil diperbarui.');
    }

    public function destroy($id)
    {
        Provinsi::findOrFail($id)->delete();
        return redirect()->route('admin.provinsi')->with('success', 'Provinsi berhasil dihapus.');
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

        return redirect()->route('admin.provinsi')->with('success', count($id) . ' data provinsi berhasil dihapus.');
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
        $file = public_path('template/template-provinsi.xlsx');

        if (!file_exists($file)) {
            abort(404, 'Template tidak ditemukan.');
        }

        return response()->download($file, 'template-provinsi.xlsx');
    }
}
