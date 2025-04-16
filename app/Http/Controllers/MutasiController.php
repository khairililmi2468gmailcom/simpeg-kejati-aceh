<?php

namespace App\Http\Controllers;

use App\Models\Mutasi;
use App\Models\Pegawai;
use App\Models\Jabatan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class MutasiController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->search;
        $perPage = $request->per_page ?? 5;

        $data = Mutasi::with(['pegawai', 'jabatan'])
            ->when($search, function ($query) use ($search) {
                $query->whereHas('pegawai', function ($q) use ($search) {
                    $q->where('nama', 'like', "%$search%");
                })->orWhereHas('jabatan', function ($q) use ($search) {
                    $q->where('nama_jabatan', 'like', "%$search%")
                        ->orWhere('ket', 'like', "%$search%");
                });
            })
            ->orderBy('created_at', 'desc')
            ->paginate($perPage);

        return view('admin.mutasi.index', compact('data'));
    }

    public function create()
    {
        $pegawais = Pegawai::all();
        $jabatans = Jabatan::all();
        return view('admin.mutasi.create', [
            'pegawaiList' => $pegawais,
            'jabatanList' => $jabatans,

        ]);
    }

    public function store(Request $request)
    {
        Log::info('Mulai proses penyimpanan mutasi.', $request->all());

        $request->validate([
            'no_sk' => 'required|string|unique:mutasi,no_sk',
            'nip' => 'required|exists:pegawai,nip',
            'id_jabatan' => 'required|exists:jabatan,id_jabatan',
            'tanggal_sk' => 'required|date',
            'tmt_jabatan' => 'required|date',
        ]);

        $pegawai = Pegawai::findOrFail($request->nip);
        Log::info('Data pegawai ditemukan:', $pegawai->toArray());

        $jabatanLama = Jabatan::findOrFail($pegawai->id_jabatan);
        Log::info('Jabatan lama pegawai:', $jabatanLama->toArray());

        $jabatanBaru = Jabatan::findOrFail($request->id_jabatan);
        Log::info('Jabatan baru yang dipilih:', $jabatanBaru->toArray());

        $unitKerja = \App\Models\UnitKerja::where('kode_kantor', $pegawai->kode_kantor)->first();
        $namaKantor = $unitKerja ? $unitKerja->nama_kantor : null;
        Log::info('Unit kerja lama ditemukan:', ['nama_kantor' => $namaKantor]);

        $mutasiData = $request->all();
        $mutasiData['jabatan_l'] = $jabatanLama->nama_jabatan;
        $mutasiData['tmt_l'] = $pegawai->tmt_jabatan;
        $mutasiData['tempat_l'] = $namaKantor;

        Log::info('Data yang akan disimpan ke tabel mutasi:', $mutasiData);

        $mutasi = Mutasi::create($mutasiData);
        Log::info('Data mutasi berhasil disimpan:', $mutasi->toArray());

        $pegawai->update([
            'id_jabatan' => $jabatanBaru->id_jabatan,
            'kode_kantor' => $jabatanBaru->kode_kantor,
            'tmt_jabatan' => $request->tmt_jabatan,
        ]);
        Log::info('Data pegawai berhasil diperbarui:', $pegawai->toArray());

        return redirect()->route('admin.mutasi.index')->with('success', 'Data mutasi berhasil ditambahkan dan pegawai diperbarui.');
    }

    public function show($id)
    {
        $data = Mutasi::with(['pegawai', 'jabatan'])->findOrFail($id);
        return view('admin.mutasi.show', compact('data'));
    }

    public function edit($id)
    {
        $data = Mutasi::findOrFail($id);
        $pegawai = Pegawai::findOrFail($data->nip);
        $jabatan = Jabatan::findOrFail($pegawai->id_jabatan);

        $pegawais = Pegawai::all();
        $jabatans = Jabatan::all();
        return view('admin.mutasi.edit', [
            'data' => $data,
            'pegawaiList' => $pegawais,
            'jabatanList' => $jabatans,
            'pegawai' => $pegawai,
            'jabatan_l' => $jabatan->nama_jabatan // Mengirimkan nama jabatan ke view

        ]);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nip' => 'required|exists:pegawai,nip',
            'id_jabatan' => 'required|exists:jabatan,id_jabatan',
            'jabatan_l' => 'nullable|string|max:255',
            'tempat_l' => 'nullable|string|max:255',
            'tanggal_sk' => 'required|date',
            'tmt_l' => 'required|date',
            'tmt_jabatan' => 'required|date',
        ]);

        // Temukan mutasi yang akan diperbarui
        $mutasi = Mutasi::findOrFail($id);

        // Ambil pegawai berdasarkan nip
        $pegawai = Pegawai::findOrFail($request->nip);

        // Ambil jabatan baru dari request, bukan dari pegawai
        $jabatanBaru = Jabatan::findOrFail($request->id_jabatan);

        // Simpan nama jabatan lama dari pegawai saat ini
        $jabatanLama = Jabatan::findOrFail($pegawai->id_jabatan);

        // Masukkan nama jabatan lama ke dalam jabatan_l
        $request->merge([
            'jabatan_l' => $jabatanLama->nama_jabatan,
        ]);

        // Update data mutasi
        $mutasi->update($request->all());

        // Update pegawai dengan jabatan dan kode kantor baru dari form
        $pegawai->update([
            'id_jabatan' => $jabatanBaru->id_jabatan,
            'kode_kantor' => $jabatanBaru->kode_kantor,
            'tmt_jabatan' => $request->tmt_jabatan,
        ]);
        return redirect()->route('admin.mutasi.index')->with('success', 'Data mutasi berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $mutasi = Mutasi::findOrFail($id);
        $mutasi->delete();

        return redirect()->route('admin.mutasi.index')->with('success', 'Data mutasi berhasil dihapus.');
    }

    public function bulkDelete(Request $request)
    {

        $request->validate([
            'id' => 'required|array',
            'id.*' => 'string|exists:mutasi,no_sk',
        ]);
        return redirect()->route('admin.mutasi.index')->with('succes', count($request->id) . ' data mutasi berhasil dihapus');
    }
}
