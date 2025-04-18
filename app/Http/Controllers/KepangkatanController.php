<?php

namespace App\Http\Controllers;

use App\Models\Kepangkatan;
use App\Models\Pegawai;
use App\Models\Golongan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class KepangkatanController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->search;
        $perPage = $request->per_page ?? 5;


        $data = Kepangkatan::with(['pegawai', 'golongan'])
            ->when($search, function ($query) use ($search) {
                $query->whereHas('pegawai', function ($q) use ($search) {
                    $q->where('nama', 'like', "%$search%");
                })->orWhereHas('golongan', function ($q) use ($search) {
                    $q->where('jabatan_fungsional', 'like', "%$search%")
                        ->orWhere('pangkat', 'like', "%$search%")
                        ->orWhere('id_golongan', 'like', "%$search%");
                })->orWhere('nip', 'like', "%$search%");
            })
            ->orderBy('created_at', 'desc')
            ->paginate($perPage);
        
        $lastKepangkatan = Kepangkatan::select('nip', \DB::raw('MAX(created_at) as latest_created'))
            ->groupBy('nip')
            ->get()
            ->keyBy('nip');
        foreach($data as $kepangkatan){
            $latestCreated = $lastKepangkatan[$kepangkatan->nip]->latest_created ?? null;
            $kepangkatan->is_last = $kepangkatan->created_at == $latestCreated;
        }
        return view('admin.kepangkatan.index', compact('data'));
    }

    public function create()
    {
        $pegawais = Pegawai::all();
        $golongans = Golongan::all();
        return view('admin.kepangkatan.create', ['pegawaiList' => $pegawais, 'golonganList' => $golongans]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'no_sk' => 'required|string|unique:kepangkatan,no_sk',
            'nip' => 'required|exists:pegawai,nip',
            'alasan' => 'nullable|string|max:255',
            'no_pertimbangan' => 'nullable|string|max:60',
            'tanggal_sk' => 'nullable|date',
            'pembuat_sk' => 'nullable|string|max:50',
            'tmt_sk_pangkat' => 'required|date',
            'no_usulan' => 'nullable|string|max:50',
            'jenis_usulan' => 'nullable|string|max:25',
            'pangkat_l' => 'nullable|string|max:25',
            'id_golongan' => 'required|exists:golongan,id_golongan',
        ]);

        $pegawai = Pegawai::findOrFail($request->nip);

        $pangkatLama = null;
        if ($pegawai->id_golongan) {
            $pangkatLama = Golongan::find($pegawai->id_golongan);
        }

        $kepangkatanData = $request->all();
        $kepangkatanData['pangkat_l'] = $pangkatLama?->pangkat;

        $kepangkatan = Kepangkatan::create($kepangkatanData);
        Log::info('Data kepangkatan berhasil disimpan:', $kepangkatan->toArray());

        return redirect()->route('admin.kepangkatan.index')->with('success', 'Data kepangkatan berhasil ditambahkan.');
    }

    public function show($id)
    {
        $data = Kepangkatan::with(['pegawai', 'golongan'])->findOrFail($id);
        return view('admin.kepangkatan.show', compact('data'));
    }

    public function edit($id)
    {
        $data = Kepangkatan::findOrFail($id);
        $pegawai = Pegawai::findOrFail($data->nip);
        $golongan = $pegawai->id_golongan ? Golongan::find($pegawai->id_golongan) : null;

        $pegawais = Pegawai::all();
        $golongans = Golongan::all();

        return view('admin.kepangkatan.edit', [
            'data' => $data,
            'pegawaiList' => $pegawais,
            'golonganList' => $golongans,
            'pegawai' => $pegawai,
            'pangkat_l' => $golongan?->jabatan_fungsional
        ]);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nip' => 'required|exists:pegawai,nip',
            'alasan' => 'nullable|string|max:255',
            'no_pertimbangan' => 'nullable|string|max:255',
            'tanggal_sk' => 'nullable|date',
            'pembuat_sk' => 'nullable|string|max:255',
            'tmt_sk_pangkat' => 'nullable|date',
            'no_usulan' => 'nullable|string|max:255',
            'jenis_usulan' => 'nullable|string|max:255',
            'pangkat_l' => 'nullable|string|max:255',
            'id_golongan' => 'required|exists:golongan,id_golongan',
        ]);

        $kepangkatan = Kepangkatan::findOrFail($id);
        $pegawai = Pegawai::findOrFail($request->nip);
        $pangkatLama = $pegawai->id_golongan ? Golongan::find($pegawai->id_golongan) : null;
        $pangkatBaru = $request->id_golongan ? Golongan::find($request->id_golongan) : null;
        $request->merge([
            'pangkat_l' => $pangkatLama ? $pangkatLama->pangkat : null,
        ]);

        $kepangkatan->update($request->except('no_sk')); // `no_sk` tidak diubah
        $pegawai->update([
            'id_golongan' => $pangkatBaru->id_golongan,
        ]);
        return redirect()->route('admin.kepangkatan.index')->with('success', 'Data kepangkatan berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $kepangkatan = Kepangkatan::findOrFail($id);

        $kepangkatan->delete();

        return redirect()->route('admin.kepangkatan.index')->with('success', 'Data kepangkatan berhasil dihapus.');
    }

    public function bulkDelete(Request $request)
    {
        // Validasi input
        $request->validate([
            'id' => 'required|array',
            'id.*' => 'string|exists:kepangkatan,no_sk', // Pastikan id yang dikirim valid
        ]);

        // Proses penghapusan data
        $deletedCount = Kepangkatan::destroy($request->id);

        // Mengirim pesan flash ke session untuk sukses atau gagal
        if ($deletedCount) {
            return redirect()->route('admin.kepangkatan.index')
                ->with('success', $deletedCount . ' data kepangkatan berhasil dihapus');
        } else {
            return redirect()->route('admin.kepangkatan.index')
                ->with('error', 'Gagal menghapus data kepangkatan');
        }
    }
}
