<?php

namespace App\Http\Controllers;

use App\Models\Mutasi;
use App\Models\Pegawai;
use App\Models\Jabatan;
use App\Models\UnitKerja;
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
                })->orWhere('nip', 'like', "%$search%");
            })
            ->orderBy('created_at', 'desc')
            ->paginate($perPage);

        // Ambil mutasi terakhir berdasarkan created_at (waktu pencatatan mutasi)
        $lastMutasi = Mutasi::select('nip', \DB::raw('MAX(created_at) as latest_created'))
            ->groupBy('nip')
            ->get()
            ->keyBy('nip');

        // Tandai mutasi terakhir
        foreach ($data as $mutasi) {
            $latestCreated = $lastMutasi[$mutasi->nip]->latest_created ?? null;
            $mutasi->is_last = $mutasi->created_at == $latestCreated;
        }


        return view('admin.mutasi.index', compact('data'));
    }


    public function create()
    {
        $pegawais = Pegawai::all();
        $jabatans = Jabatan::all();
        $jabatanTerisi = Pegawai::whereNotNull('id_jabatan')->pluck('id_jabatan')->toArray();

        return view('admin.mutasi.create', [
            'pegawaiList' => $pegawais,
            'jabatanList' => $jabatans,
            'jabatanTerisi' => $jabatanTerisi,

        ]);
    }

    public function store(Request $request)
    {
        Log::info('Mulai proses penyimpanan mutasi.', $request->all());

        $request->validate([
            'nip' => 'required|exists:pegawai,nip',
            'id_jabatan' => 'required|exists:jabatan,id_jabatan',
            'tanggal_sk' => 'nullable|date',
            'tmt_jabatan' => 'nullable|date',
            'nomor_sk' => 'nullable|string',
        ]);


        $pegawai = Pegawai::findOrFail($request->nip);
        Log::info('Data pegawai ditemukan:', $pegawai->toArray());

        $jabatanLama = null;
        if ($pegawai->id_jabatan) {
            $jabatanLama = Jabatan::find($pegawai->id_jabatan);
            Log::info('Jabatan lama pegawai:', optional($jabatanLama)->toArray());
        }
        $jabatanBaru = Jabatan::findOrFail($request->id_jabatan);
        Log::info('Jabatan baru yang dipilih:', $jabatanBaru->toArray());

        $unitKerja = null;
        $namaKantor = null;
        if ($pegawai->kode_kantor) {
            $unitKerja = UnitKerja::where('kode_kantor', $pegawai->kode_kantor)->first();
            $namaKantor = $unitKerja ? $unitKerja->nama_kantor : null;
            Log::info('Unit kerja lama ditemukan:', ['nama_kantor' => $namaKantor]);
        }

        // Cari no_sk otomatis dari 1 hingga tak terbatas
        $usedNoSk = Mutasi::pluck('no_sk')->map(fn($val) => (int) $val)->sort()->values();

        $noSkBaru = 1;
        foreach ($usedNoSk as $number) {
            if ($number == $noSkBaru) {
                $noSkBaru++;
            } else {
                break;
            }
        }

        $mutasiData = $request->all();
        $mutasiData['no_sk'] = (string) $noSkBaru; 
        $mutasiData['jabatan_l'] = $jabatanLama?->nama_jabatan;
        $mutasiData['tmt_l'] = $pegawai->tmt_jabatan ?? null;
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

        // Cek apakah pegawai punya id_jabatan
        $jabatan = $pegawai->id_jabatan ? Jabatan::find($pegawai->id_jabatan) : null;

        $pegawais = Pegawai::all();
        $jabatans = Jabatan::all();
        $jabatanTerisi = Pegawai::whereNotNull('id_jabatan')
            ->where('id_jabatan', '!=', $pegawai->id_jabatan)
            ->pluck('id_jabatan')
            ->toArray();
        return view('admin.mutasi.edit', [
            'data' => $data,
            'pegawaiList' => $pegawais,
            'jabatanList' => $jabatans,
            'pegawai' => $pegawai,
            'jabatan_l' => $jabatan?->nama_jabatan,
            'jabatanTerisi' => $jabatanTerisi,

        ]);
    }


    public function update(Request $request, $id)
    {
        $request->validate([
            'nip' => 'required|exists:pegawai,nip',
            'id_jabatan' => 'required|exists:jabatan,id_jabatan',
            'tanggal_sk' => 'nullable|date',
            'tmt_jabatan' => 'nullable|date',
            'nomor_sk' => 'nullable|string',
        ]);

        // Temukan mutasi yang akan diperbarui
        $mutasi = Mutasi::findOrFail($id);

        // Ambil pegawai berdasarkan nip
        $pegawai = Pegawai::findOrFail($request->nip);
        $jabatanLama = $pegawai->id_jabatan ? Jabatan::find($pegawai->id_jabatan) : null;
        $jabatanBaru = $request->id_jabatan ? Jabatan::find($request->id_jabatan) : null;
        $unitKerja = UnitKerja::where('kode_kantor', $pegawai->kode_kantor)->first();
        $namaKantor = $unitKerja ? $unitKerja->nama_kantor : null;


        // Masukkan nama jabatan lama ke dalam jabatan_l
        $request->merge([
            'jabatan_l' => $jabatanLama ? $jabatanLama->nama_jabatan : null,
            'tmt_l' => $pegawai->tmt_jabatan,
            'tempat_l' => $namaKantor,
        ]);

        // Update data mutasi
        $mutasiData = $request->only([
            'nip', 'id_jabatan', 'tanggal_sk', 'tmt_jabatan',
            'nomor_sk', 'jabatan_l', 'tmt_l', 'tempat_l'
        ]);
        $mutasi->update($mutasiData);

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
        // Validasi input
        $request->validate([
            'id' => 'required|array',
            'id.*' => 'string|exists:mutasi,no_sk', // Pastikan id yang dikirim valid
        ]);

        // Proses penghapusan data
        $deletedCount = Mutasi::destroy($request->id);

        // Mengirim pesan flash ke session untuk sukses atau gagal
        if ($deletedCount) {
            return redirect()->route('admin.mutasi.index')
                ->with('success', $deletedCount . ' data mutasi berhasil dihapus');
        } else {
            return redirect()->route('admin.mutasi.index')
                ->with('error', 'Gagal menghapus data mutasi');
        }
    }
}
