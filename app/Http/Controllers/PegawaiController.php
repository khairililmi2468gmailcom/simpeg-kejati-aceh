<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pegawai;
use App\Models\Provinsi;
use App\Models\Golongan;
use App\Models\UnitKerja;
use App\Models\Jabatan;
use Illuminate\Support\Facades\Storage;

class PegawaiController extends Controller
{
    public function index()
    {
        $pegawai = Pegawai::with(['provinsi', 'golongan', 'unitKerja', 'jabatan'])->get();
        $golongan = Golongan::all();
        $jabatan = Jabatan::all();
        return view('admin.pegawai.index', compact('pegawai', 'golongan', 'jabatan'));
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
            'tmt_jabatan' => 'required|date',
            'id_golongan' => 'required|string|exists:golongan,id_golongan',
            'kode_kantor' => 'nullable|string|max:10|exists:unit_kerja,kode_kantor',
            'id_jabatan' => 'nullable|integer|exists:jabatan,id_jabatan',
            'ket' => 'nullable|string|max:25'
        ]);

        // Simpan foto jika ada
        $fotoPath = null;
        if ($request->hasFile('foto')) {
            $fotoPath = $request->file('foto')->store('pegawai', 'public');
        }

        $pegawai = Pegawai::create(array_merge($request->all(), ['foto' => $fotoPath]));

        return redirect()->route('admin.pegawai')->with('success', 'Pegawai berhasil ditambahkan.');
    }

    public function show($nip)
    {
        $pegawai = Pegawai::with(['provinsi', 'golongan', 'unitKerja', 'jabatan'])->findOrFail($nip);
        return view('admin.pegawai.show', compact('pegawai'));
    }

    public function edit($nip)
    {
        $pegawai = Pegawai::findOrFail($nip);
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
            'tmt_jabatan' => 'required|date',
            'id_golongan' => 'required|string|exists:golongan,id_golongan',
            'kode_kantor' => 'nullable|string|max:10|exists:unit_kerja,kode_kantor',
            'id_jabatan' => 'nullable|integer|exists:jabatan,id_jabatan',
            'ket' => 'nullable|string|max:25'
        ]);

        $data = $request->all();

        if ($request->hasFile('foto')) {
            if ($pegawai->foto) {
                Storage::delete('public/' . $pegawai->foto);
            }
            $data['foto'] = $request->file('foto')->store('pegawai', 'public');
        }

        $pegawai->update($data);


        return redirect()->route('admin.pegawai')->with('success', 'Data pegawai berhasil diperbarui!');
    }

    public function destroy($nip)
    {
        $pegawai = Pegawai::findOrFail($nip);

        if ($pegawai->foto) {
            Storage::delete('public/' . $pegawai->foto);
        }

        $pegawai->delete();
        return redirect()->route('admin.pegawai')->with('success', 'Pegawai berhasil dihapus.');
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

        return redirect()->route('admin.pegawai')->with('success', count($nips) . ' data pegawai berhasil dihapus.');
    }
}
