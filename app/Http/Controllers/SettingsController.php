<?php

namespace App\Http\Controllers;

use App\Models\Golongan;
use App\Models\Jabatan;
use App\Models\Kepangkatan;
use App\Models\Mutasi;
use App\Models\Pegawai;
use App\Models\Provinsi;
use App\Models\UnitKerja;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

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
                    ->orWhere('id_provinsi', 'like', "%$searchUnitKerja%");
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


    // ======= CREATE ===========
    public function createJabatan()
    {
        $unitKerjas = UnitKerja::all();
        $provinsi = Provinsi::all();
        return view('admin.settings.jabatan.create', ['unitKerjaList' => $unitKerjas, 'provinsiList' => $provinsi]);
    }
    public function createUnitKerja()
    {
        $provinsi = Provinsi::all();
        return view('admin.settings.unitkerja.create', ['provinsiList' => $provinsi]);
    }
    public function createGolongan()
    {
        return view('admin.settings.golongan.create');
    }
    public function createAdmin()
    {
        return view('admin.settings.admin.create');
    }


    // ======= STORE ===========

    public function storeAdmin(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => $request->password, // Laravel akan hash otomatis dari $casts
        ]);

        return redirect()->route('admin.settings.index')->with('success', 'Admin baru berhasil ditambahkan.');
    }

    public function storeGolongan(Request $request)
    {
        $request->validate([
            'id_golongan' => 'required|string|max:5|unique:golongan,id_golongan',
            'jabatan_fungsional' => 'required|string|max:25',
            'pangkat' => 'required|string|max:25',
        ]);

        Golongan::create([
            'id_golongan' => $request->id_golongan,
            'jabatan_fungsional' => $request->jabatan_fungsional,
            'pangkat' => $request->pangkat,
        ]);

        return redirect()->route('admin.settings.index')->with('success', 'Data unit kerja berhasil ditambahkan.');
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

        return redirect()->route('admin.settings.index')->with('success', 'Data golongan berhasil ditambahkan.');
    }
    public function showJabatan($id)
    {
        $jabatan = Jabatan::with('unitKerja')->findOrFail($id);
        return view('admin.settings.jabatan.show', compact('jabatan'));
    }

    // ======= EDIT ===========
    public function editAdmin($id)
    {
        $admin = User::findOrFail($id);

        return view('admin.settings.admin.edit', compact('admin'));
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
        $data = Golongan::findOrFail($id);
        return view('admin.settings.golongan.edit', compact('data'));
    }

    public function editUnitKerja($id)
    {
        $data = UnitKerja::findOrFail($id);
        $provinsi = Provinsi::all();

        return view('admin.settings.unitkerja.edit', ['data' => $data, 'provinsiList' => $provinsi]);
    }


    // ======= UPDATE ===========
    public function updateGolongan(Request $request, $id)
    {
        $request->validate([
            'jabatan_fungsional' => 'required|string|max:25',
            'pangkat' => 'nullable|string|max:25',
        ]);

        $golongan = Golongan::findOrFail($id);
        $golongan->update($request->all());

        return redirect()->route('admin.settings.index')->with('success', 'Data golongan berhasil diperbarui.');
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

    public function updateAdmin(Request $request, $id)
    {
        // Mencari admin berdasarkan ID
        $admin = User::findOrFail($id);

        // Validasi input
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $admin->id,
            'password' => 'nullable|string|min:8|confirmed', // Password opsional jika tidak ingin mengganti
        ]);

        // Update data admin
        $admin->name = $request->name;
        $admin->email = $request->email;

        // Jika password diisi, maka kita hash dan update
        if ($request->password) {
            $admin->password = bcrypt($request->password);
        }

        $admin->save(); // Simpan perubahan

        return redirect()->route('admin.settings.index')->with('success', 'Admin berhasil diperbarui.');
    }

    // ======= DESTROY ===========
    public function destroyAdmin($id)
    {
        // Mencari admin berdasarkan ID
        $admin = User::findOrFail($id);

        // Hapus data admin
        $admin->delete();

        return redirect()->route('admin.settings.index')->with('success', 'Admin berhasil dihapus.');
    }

    public function destroyJabatan($id)
    {
        $jabatan = Jabatan::findOrFail($id);

        // Kosongkan id_jabatan di Pegawai jika ada yang terkait
        if (Pegawai::where('id_jabatan', $jabatan->id_jabatan)->exists()) {
            Pegawai::where('id_jabatan', $jabatan->id_jabatan)->update(['id_jabatan' => null]);
        }

        // Kosongkan id_jabatan di Mutasi jika ada yang terkait
        if (Mutasi::where('id_jabatan', $jabatan->id_jabatan)->exists()) {
            Mutasi::where('id_jabatan', $jabatan->id_jabatan)->update(['id_jabatan' => null]);
        }

        // Hapus data jabatan
        $jabatan->delete();

        return redirect()->route('admin.settings.index')
            ->with('success', 'Data jabatan berhasil dihapus.');
    }


    public function destroyGolongan($id)
    {
        $golongan = Golongan::findOrFail($id);

        // Kosongkan id_golongan di Pegawai jika ada yang terkait
        if (Pegawai::where('id_golongan', $golongan->id_golongan)->exists()) {
            Pegawai::where('id_golongan', $golongan->id_golongan)->update(['id_golongan' => null]);
        }

        // Kosongkan id_golongan di Kepangkatan jika ada yang terkait
        if (Kepangkatan::where('id_golongan', $golongan->id_golongan)->exists()) {
            Kepangkatan::where('id_golongan', $golongan->id_golongan)->update(['id_golongan' => null]);
        }

        // Hapus data golongan
        $golongan->delete();

        return redirect()->route('admin.settings.index')
            ->with('success', 'Data golongan berhasil dihapus.');
    }


    public function destroyUnitKerja($id)
    {
        $unitkerja = UnitKerja::findOrFail($id);

        // Kosongkan kode_kantor di Pegawai jika ada yang terkait
        if (Pegawai::where('kode_kantor', $unitkerja->kode_kantor)->exists()) {
            Pegawai::where('kode_kantor', $unitkerja->kode_kantor)->update(['kode_kantor' => null]);
        }

        // Kosongkan kode_kantor di Jabatan jika ada yang terkait
        if (Jabatan::where('kode_kantor', $unitkerja->kode_kantor)->exists()) {
            Jabatan::where('kode_kantor', $unitkerja->kode_kantor)->update(['kode_kantor' => null]);
        }

        // Hapus unit kerja
        $unitkerja->delete();

        return redirect()->route('admin.settings.index')
            ->with('success', 'Data unit kerja berhasil dihapus.');
    }


    // ======= BULK DELETE ===========
    public function bulkDeleteAdmin(Request $request)
    {
        // Log::info('Mulai bulk delete admin');
        // Log::debug('Request data:', $request->all());

        try {
            $validated = $request->validate([
                'id' => 'required|array|min:1',
                'id.*' => 'exists:users,id',
            ]);

            // Log::debug('Validasi berhasil:', $validated);

            $deletedCount = User::whereIn('id', $validated['id'])->delete();

            // Log::info("Berhasil menghapus {$deletedCount} admin");

            return redirect()->route('admin.settings.index')->with('success', 'Admin yang dipilih berhasil dihapus.');
        } catch (\Exception $e) {
            Log::error('Terjadi kesalahan saat bulk delete admin:', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);

            return redirect()->back()->with('error', 'Terjadi kesalahan saat menghapus admin.');
        }
    }
    public function bulkDeleteGolongan(Request $request)
    {
        try {
            $request->validate([
                'id' => 'required|array',
                'id.*' => 'exists:golongan,id_golongan',
            ]);

            // Update Pegawai jika ada yang cocok
            if (Pegawai::whereIn('id_golongan', $request->id)->exists()) {
                Pegawai::whereIn('id_golongan', $request->id)->update(['id_golongan' => null]);
            }

            // Update Kepangkatan jika ada yang cocok
            if (Kepangkatan::whereIn('id_golongan', $request->id)->exists()) {
                Kepangkatan::whereIn('id_golongan', $request->id)->update(['id_golongan' => null]);
            }

            // Hapus data golongan
            Golongan::whereIn('id_golongan', $request->id)->delete();

            return redirect()->route('admin.settings.index')
                ->with('success', count($request->id) . ' data berhasil dihapus');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Error: ' . $e->getMessage());
        }
    }

    public function bulkDeleteJabatan(Request $request)
    {
        try {
            $request->validate([
                'id' => 'required|array',
                'id.*' => 'exists:jabatan,id_jabatan',
            ]);

            // Update Pegawai jika ada yang cocok
            if (Pegawai::whereIn('id_jabatan', $request->id)->exists()) {
                Pegawai::whereIn('id_jabatan', $request->id)->update(['id_jabatan' => null]);
            }

            // Update Mutasi jika ada yang cocok
            if (Mutasi::whereIn('id_jabatan', $request->id)->exists()) {
                Mutasi::whereIn('id_jabatan', $request->id)->update(['id_jabatan' => null]);
            }

            // Hapus data Jabatan
            Jabatan::whereIn('id_jabatan', $request->id)->delete();

            return redirect()->route('admin.settings.index')
                ->with('success', count($request->id) . ' data berhasil dihapus');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Error: ' . $e->getMessage());
        }
    }

    public function bulkDeleteUnitKerja(Request $request)
    {
        try {
            $request->validate([
                'id' => 'required|array',
                'id.*' => 'exists:unit_kerja,kode_kantor',
            ]);

            // Update Pegawai jika ada yang cocok
            if (Pegawai::whereIn('kode_kantor', $request->id)->exists()) {
                Pegawai::whereIn('kode_kantor', $request->id)->update(['kode_kantor' => null]);
            }

            // Update Jabatan jika ada yang cocok
            if (Jabatan::whereIn('kode_kantor', $request->id)->exists()) {
                Jabatan::whereIn('kode_kantor', $request->id)->update(['kode_kantor' => null]);
            }

            // Hapus data Unit Kerja
            UnitKerja::whereIn('kode_kantor', $request->id)->delete();

            return redirect()->route('admin.settings.index')
                ->with('success', count($request->id) . ' data berhasil dihapus');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Error: ' . $e->getMessage());
        }
    }
}
