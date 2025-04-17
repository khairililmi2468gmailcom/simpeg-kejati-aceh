<?php

namespace App\Http\Controllers;

use App\Models\Golongan;
use App\Models\Jabatan;
use App\Models\Provinsi;
use App\Models\UnitKerja;
use App\Models\User;
use Illuminate\Http\Request;

class SettingsController extends Controller
{
    public function index(Request $request)
    {
        // Mengambil data untuk Jabatan
        $searchJabatan = $request->searchJabatan;
        $perPageJabatan = $request->per_page_jabatan ?? 5;
        $jabatans = Jabatan::with('unitKerja')
            ->when($searchJabatan, function ($query) use ($searchJabatan) {
                $query->where('nama_jabatan', 'like', "%$searchJabatan%")
                    ->orWhere('ket', 'like', "%$searchJabatan%");
            })
            ->orderBy('nama_jabatan')
            ->paginate($perPageJabatan);
        $searchGolongan = $request->searchGolongan;
        $perPageGolongan = $request->per_page_golongan ?? 5;
        $golongans = Golongan::with('kepangkatans')
            ->when($searchGolongan, function ($query) use ($searchGolongan) {
                $query->where('jabatan_fungsional', 'like', "%$searchGolongan%")
                    ->orWhere('pangkat', 'like', "%$searchGolongan%");
            })
            ->orderBy('id_golongan')
            ->paginate($perPageGolongan);

        // Mengambil data untuk Unit Kerja

        $searchUnitKerja = $request->searchUnitKerja;
        $perPageUnitKerja = $request->per_page_unit_kerja ?? 5;
        $unitkerjas = UnitKerja::with('jabatans')
            ->when($searchUnitKerja, function ($query) use ($searchUnitKerja) {
                $query->where('nama_kantor', 'like', "%$searchUnitKerja%")
                    ->orWhere('kode_kantor', 'like', "%$searchUnitKerja%")
                    ->orWhere('provinsi', 'like', "%$searchUnitKerja%");
            })
            ->orderBy('nama_kantor')
            ->paginate($perPageUnitKerja);

        // Mengambil data untuk Admin
        $searchAdmin = $request->searchAdmin;
        $perPageAdmin = $request->per_page_admin ?? 5;
        $admins = User::when($searchAdmin, function ($query) use ($searchAdmin) {
            $query->where('name', 'like', "%$searchAdmin%")
                ->orWhere('email', 'like', "%$searchAdmin%");
        })
        ->orderBy('id')
        ->paginate($perPageAdmin);
    
        return view('admin.settings.index', compact(
            'jabatans',
            'searchJabatan',
            'perPageJabatan',
            'golongans',
            'searchGolongan',
            'perPageGolongan',
            'unitkerjas',
            'searchUnitKerja',
            'perPageUnitKerja',
            'admins',
            'searchAdmin',
            'perPageAdmin',
        ));
    }



    public function createJabatan()
    {
        $unitKerjas = UnitKerja::all();
        return view('admin.settings.jabatan.create', compact('unitKerjas'));
    }
    public function storeJabatan(Request $request)
    {
        $request->validate([
            'nama_jabatan' => 'required|string|max:255',
            'ket' => 'nullable|string|max:255',
            'kode_kantor' => 'required|exists:unit_kerja,kode_kantor',
        ]);

        Jabatan::create($request->all());

        return redirect()->route('jabatan.index')->with('success', 'Data jabatan berhasil ditambahkan.');
    }
    public function showJabatan($id)
    {
        $jabatan = Jabatan::with('unitKerja')->findOrFail($id);
        return view('admin.settings.jabatan.show', compact('jabatan'));
    }
    public function editJabatan($id)
    {
        $data = Jabatan::findOrFail($id);
        $unitKerjas = UnitKerja::all();
        $provinsi = Provinsi::all();
        return view('admin.settings.jabatan.edit', ['data' => $data, 'unitKerjaList' => $unitKerjas, 'provinsiList' => $provinsi]);
    }
    public function editGolongan($id)
    {
        $golongan = Golongan::findOrFail($id);
        return view('admin.settings.golongan.edit', compact('golongan'));
    }
    public function updateJabatan(Request $request, $id)
    {
        $request->validate([
            'nama_jabatan' => 'required|string|max:100',
            'ket' => 'nullable|string|max:255',
            'kode_kantor' => 'required|exists:unit_kerja,kode_kantor',
        ]);

        $jabatan = Jabatan::findOrFail($id);
        $jabatan->update($request->all());

        return redirect()->route('admin.settings.index')->with('success', 'Data jabatan berhasil diperbarui.');
    }
    public function destroyJabatan($id)
    {
        $jabatan = Jabatan::findOrFail($id);
        $jabatan->delete();

        return redirect()->route('admin.settings.index')->with('success', 'Data jabatan berhasil dihapus.');
    }
}
