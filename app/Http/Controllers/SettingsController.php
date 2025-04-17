<?php

namespace App\Http\Controllers;

use App\Models\Golongan;
use App\Models\Jabatan;
use App\Models\Mutasi;
use App\Models\Pegawai;
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
            ->orderBy('id_jabatan', 'desc')
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
        $provinsi = Provinsi::all();
        return view('admin.settings.jabatan.create', ['unitKerjaList' => $unitKerjas, 'provinsiList' => $provinsi]);
    }

    public function createUnitKerja()
    {
        $unitKerjas = UnitKerja::all();
        $provinsi = Provinsi::all();
        return view('admin.settings.unitkerja.create', ['unitKerjaList' => $unitKerjas, 'provinsiList' => $provinsi]);
    }
    public function storeUnitKerja(Request $request)
    {
        $request->validate([
            'kode_kantor' => 'required|string|max:10|unique:unit_kerja,kode_kantor',
            'nama_kantor' => 'required|string|max:100',
            'id_provinsi' => 'required|exists:provinsi,id',
        ]);

        UnitKerja::create([
            'kode_kantor' => $request->kode_kantor,
            'nama_kantor' => $request->nama_kantor,
            'id_provinsi' => $request->id_provinsi,
        ]);

        return redirect()->route('admin.settings.index')->with('success', 'Data unit kerja berhasil ditambahkan.');
    }


    public function storeJabatan(Request $request)
    {
        $request->validate([
            'nama_jabatan' => 'required|string|max:100',
            'ket' => 'nullable|string|max:255',
            'kode_kantor' => 'required|exists:unit_kerja,kode_kantor',
        ]);

        Jabatan::create($request->all());

        return redirect()->route('admin.settings.index')->with('success', 'Data jabatan berhasil ditambahkan.');
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

    public function editUnitKerja($id)
    {
        $data = UnitKerja::findOrFail($id);
        $provinsi = Provinsi::all();

        return view('admin.settings.unitkerja.edit', ['data' => $data, 'provinsiList' => $provinsi]);
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

    public function updateUnitKerja(Request $request, $id)
    {
        $request->validate([
            'nama_kantor' => 'required|string|max:100',
            'id_provinsi' => 'required|exists:provinsi,id',
        ]);

        $unitkerjas = UnitKerja::findOrFail($id);
        $unitkerjas->update($request->all());

        return redirect()->route('admin.settings.index')->with('success', 'Data unitkerja berhasil diperbarui.');
    }

    public function destroyJabatan($id)
    {
        $jabatan = Jabatan::findOrFail($id);
        // Kosongkan jabatan pegawai terkait
        Pegawai::where('id_jabatan', $jabatan->id_jabatan)->update(['id_jabatan' => null]);
        Mutasi::where('id_jabatan', $jabatan->id_jabatan)->update(['id_jabatan' => null]);

        $jabatan->delete();

        return redirect()->route('admin.settings.index')->with('success', 'Data jabatan berhasil dihapus.');
    }

    public function bulkDeleteJabatan(Request $request)
    {
        try {
            $request->validate([
                'id' => 'required|array',
                'id.*' => 'exists:jabatan,id_jabatan',
            ]);
            // Set id_jabatan pegawai terkait menjadi null
            Pegawai::whereIn('id_jabatan', $request->id)->update(['id_jabatan' => null]);
            Mutasi::whereIn('id_jabatan', $request->id)->update(['id_jabatan' => null]);
            // Hapus data jabatan
            Jabatan::whereIn('id_jabatan', $request->id)->delete();

            return redirect()->route('admin.settings.index')
                ->with('success', count($request->id) . ' data berhasil dihapus');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Error: ' . $e->getMessage());
        }
    }
}
