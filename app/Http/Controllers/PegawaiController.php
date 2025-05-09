<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pegawai;
use App\Models\Provinsi;
use App\Models\Golongan;
use App\Models\UnitKerja;
use App\Models\Jabatan;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\PegawaiExport;
use App\Imports\PegawaiImport;
use PDF;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class PegawaiController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->search;
        $perPage = $request->per_page ?? 5;

        $pegawai = Pegawai::with(['golongan', 'jabatan', 'unitKerja'])
            ->when($search, function ($query) use ($search) {
                $query->where('nip', 'like', "%$search%")
                    ->orWhere('nama', 'like', "%$search%");
            })
            ->orderBy('created_at', 'desc')
            ->paginate($perPage);
        $referensi = [
            'provinsi' => \App\Models\Provinsi::select('id', 'nama_provinsi as nama')->get(),
            'kabupaten' => \App\Models\Kabupaten::select(
                'kabupaten.id as id',
                'kabupaten.nama_kabupaten as nama',
                'kabupaten.id_provinsi',
                'provinsi.nama_provinsi as nama_provinsi'
            )
                ->join('provinsi', 'kabupaten.id_provinsi', '=', 'provinsi.id')
                ->get(),

            'kecamatan' => \App\Models\Kecamatan::select(
                'kecamatan.id as id',
                'kecamatan.nama_kecamatan as nama',
                'kecamatan.id_kabupaten',
                'kabupaten.nama_kabupaten as nama_kabupaten'
            )
                ->join('kabupaten', 'kecamatan.id_kabupaten', '=', 'kabupaten.id')
                ->get(),
            'golongan' => \App\Models\Golongan::select('id_golongan as id', 'jabatan_fungsional as nama')->get(),
            'jabatan' => \App\Models\Jabatan::select('id_jabatan as id', 'nama_jabatan as nama')->get(),
            'unitkerja' => \App\Models\UnitKerja::select('kode_kantor as id', 'nama_kantor as nama')->get(),
        ];
        return view('admin.pegawai.index', compact('pegawai', 'referensi'));
    }

    public function create()
    {
        $provinsi = Provinsi::all();
        $golongan = Golongan::all();
        $unitKerja = UnitKerja::all();
        $jabatan = Jabatan::all();

        return view('admin.pegawai.create', compact('provinsi', 'golongan', 'unitKerja', 'jabatan'));
    }
    public function store(Request $request)
    {
        $request->validate([
            'nip' => 'required|unique:pegawai,nip|max:18',
            'nrp' => 'nullable|string|max:20',
            'karpeg' => 'nullable|string|max:20',
            'nama' => 'required|string|max:100',
            'tmpt_lahir' => 'nullable|string|max:25',
            'tgl_lahir' => 'nullable|date',
            'agama' => 'nullable|string|max:25',
            'suku' => 'nullable|string|max:25',
            'gol_darah' => 'nullable|string|max:5',
            'j_kelamin' => 'nullable|string|max:25',
            'status' => 'nullable|string|max:25',
            'j_anak' => 'nullable|integer',
            'id_provinsi' => 'nullable|string|max:2|exists:provinsi,id',
            'alamat' => 'nullable|string|max:100',
            'kode_pos' => 'nullable|string|max:12',
            'hp' => 'nullable|string|max:12',
            'pendidikan' => 'nullable|string|max:25',
            'universitas' => 'nullable|string|max:100',
            'jurusan' => 'nullable|string|max:100',
            't_lulus' => 'nullable|integer',
            'tahun_masuk' => 'nullable|integer',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'tmt_jabatan' => 'nullable|date',
            'id_golongan' => 'nullable|string|exists:golongan,id_golongan',
            'kode_kantor' => 'nullable|string|max:10|exists:unit_kerja,kode_kantor',
            'id_jabatan' => 'nullable|integer|exists:jabatan,id_jabatan',
            'ket' => 'nullable|string|max:150'
        ]);

        $fotoPath = null;
        if ($request->hasFile('foto')) {
            $fotoPath = $request->file('foto')->store('pegawai', 'public');
        }

        $data = $request->except(['id_jabatan', 'kode_kantor', 'tmt_jabatan']);
        $data['foto'] = $fotoPath;

        $pegawai = Pegawai::create($data);

        return redirect()->route('admin.pegawai.index')->with('success', 'Pegawai berhasil ditambahkan.');
    }


    public function show($nip)
    {
        $pegawai = Pegawai::with(['provinsi', 'golongan', 'unitKerja', 'jabatan'])->findOrFail($nip);
        return view('admin.pegawai.show', compact('pegawai'));
    }

    public function edit($nip)
    {
        $pegawai = Pegawai::findOrFail($nip);
        $pegawai->tgl_lahir = \Carbon\Carbon::parse($pegawai->tgl_lahir)->format('Y-m-d');
        $provinsi = Provinsi::all();
        $golongan = Golongan::all();
        $unitKerja = UnitKerja::all();
        $jabatan = Jabatan::all();

        return view('admin.pegawai.edit', compact('pegawai', 'provinsi', 'golongan', 'unitKerja', 'jabatan'));
    }

    public function update(Request $request, $nip)
    {
        $pegawai = Pegawai::findOrFail($nip);

        $request->validate([
            'nama' => 'required|string|max:100',
            'tmpt_lahir' => 'nullable|string|max:25',
            'tgl_lahir' => 'nullable|date',
            'agama' => 'nullable|string|max:25',
            'suku' => 'nullable|string|max:25',
            'gol_darah' => 'nullable|string|max:5',
            'j_kelamin' => 'nullable|string|max:25',
            'status' => 'nullable|string|max:25',
            'j_anak' => 'nullable|integer',
            'id_provinsi' => 'nullable|string|max:2|exists:provinsi,id',
            'alamat' => 'nullable|string|max:100',
            'kode_pos' => 'nullable|string|max:12',
            'hp' => 'nullable|string|max:12',
            'pendidikan' => 'nullable|string|max:25',
            'universitas' => 'nullable|string|max:100',
            'jurusan' => 'nullable|string|max:100',
            't_lulus' => 'nullable|integer',
            'tahun_masuk' => 'nullable|integer',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'tmt_jabatan' => 'nullable|date',
            'id_golongan' => 'nullable|string|exists:golongan,id_golongan',
            'kode_kantor' => 'nullable|string|max:10|exists:unit_kerja,kode_kantor',
            'id_jabatan' => 'nullable|integer|exists:jabatan,id_jabatan',
            'ket' => 'nullable|string|max:150'
        ]);
        $data = $request->except(['id_jabatan', 'kode_kantor', 'tmt_jabatan']);

        if ($request->hasFile('foto')) {
            if ($pegawai->foto) {
                Storage::delete('public/' . $pegawai->foto);
            }
            $data['foto'] = $request->file('foto')->store('pegawai', 'public');
        }

        $pegawai->update($data);


        return redirect()->route('admin.pegawai.index')->with('success', 'Data pegawai berhasil diperbarui!');
    }

    public function destroy($nip)
    {
        $pegawai = Pegawai::findOrFail($nip);

        if ($pegawai->foto) {
            Storage::delete('public/' . $pegawai->foto);
        }

        $pegawai->delete();
        return redirect()->route('admin.pegawai.index')->with('success', 'Pegawai berhasil dihapus.');
    }
    public function bulkDelete(Request $request)
    {
        $nips = $request->nips;

        if (!$nips || !is_array($nips)) {
            return redirect()->back()->with('error', 'Tidak ada data yang dipilih.');
        }

        $pegawaiList = Pegawai::whereIn('nip', $nips)->get();

        foreach ($pegawaiList as $pegawai) {
            if ($pegawai->foto) {
                Storage::delete('public/' . $pegawai->foto);
            }
            $pegawai->delete();
        }

        return redirect()->route('admin.pegawai.index')->with('success', count($nips) . ' data pegawai berhasil dihapus.');
    }
    public function exportPdf()
    {
        $pegawai = Pegawai::with(['golongan', 'jabatan', 'unitKerja'])->get();
        $pdf = PDF::loadView('admin.pegawai.export_pdf', compact('pegawai'));
        return $pdf->download('data_pegawai.pdf');
    }

    public function exportExcel()
    {
        return Excel::download(new PegawaiExport, 'data_pegawai.xlsx');
    }

    public function importExcel(Request $request)
    {
        if (!$request->hasFile('file')) {
            Log::error('No file uploaded for import.');
            return redirect()->route('admin.pegawai.index')->with('error', 'Tidak ada file yang diupload.');
        }

        try {
            Log::info('Mulai import pegawai...');

            Excel::import(new PegawaiImport, $request->file('file'));

            Log::info('Import pegawai selesai.');
            return redirect()->route('admin.pegawai.index')->with('success', 'Data pegawai berhasil diimpor!');
        } catch (\Maatwebsite\Excel\Validators\ValidationException $e) {
            $failures = $e->failures();

            $messages = collect($failures)->map(function ($fail) {
                return 'Baris ' . $fail->row() . ': ' . implode(', ', $fail->errors());
            })->implode('<br>');

            return redirect()->route('admin.pegawai.index')->with('error', $messages);
        } catch (\Throwable $e) {
            Log::error('Gagal import pegawai: ' . $e->getMessage());
            return redirect()->route('admin.pegawai.index')->with('error', 'Terjadi kesalahan saat mengimpor data.');
        }
    }
}
