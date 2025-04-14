<?php

namespace App\Http\Controllers;

use App\Models\MenerimaCuti;
use App\Models\Pegawai;
use App\Models\Cuti;
use Illuminate\Http\Request;

class MenerimaCutiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->search;
        $perPage = $request->per_page ?? 5;

        $menerimaCuti = MenerimaCuti::with(['pegawai', 'cuti'])
            ->when($search, function ($query) use ($search) {
                $query->whereHas('pegawai', function ($q) use ($search) {
                    $q->where('nama', 'like', "%$search%");
                })->orWhereHas('cuti', function ($q) use ($search) {
                    $q->where('jenis_cuti', 'like', "%$search%");
                });
            })
            ->orderBy('tanggal_mulai', 'desc')
            ->paginate($perPage);

        return view('admin.cuti.riwayatcuti.index', compact('menerimaCuti', 'search', 'perPage'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $pegawai = Pegawai::all();
        $cuti = Cuti::all();

        return view('admin.cuti.riwayatcuti.create', [
            'pegawaiList' => $pegawai,
            'cutiList' => $cuti
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nip' => 'required|exists:pegawai,nip',
            'cuti_id' => 'required|exists:cuti,id',
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'required|date|after_or_equal:tanggal_mulai',
            'jumlah_cuti' => 'required|integer|min:1',
            'keterangan' => 'nullable|string',
        ]);

        // Generate no_surat otomatis: CT001, CT002, ...
        $last = \App\Models\MenerimaCuti::orderBy('no_surat', 'desc')->first();
        $lastNumber = $last ? intval(substr($last->no_surat, 2)) : 0;
        $newNumber = $lastNumber + 1;
        $noSuratBaru = 'CT' . str_pad($newNumber, 3, '0', STR_PAD_LEFT);

        // Simpan data
        MenerimaCuti::create([
            'no_surat' => $noSuratBaru,
            'nip' => $request->nip,
            'cuti_id' => $request->cuti_id,
            'tanggal_mulai' => $request->tanggal_mulai,
            'tanggal_selesai' => $request->tanggal_selesai,
            'jumlah_cuti' => $request->jumlah_cuti,
            'keterangan' => $request->keterangan,
        ]);

        return redirect()->route('admin.cuti.riwayatcuti.index')->with('success', 'Data cuti pegawai berhasil ditambahkan.');
    }


    /**
     * Display the specified resource.
     */
    public function show(string $no_surat)
    {
        $data = MenerimaCuti::with(['pegawai', 'cuti'])->findOrFail($no_surat);
        return view('admin.cuti.riwayatcuti.show', compact('data'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $no_surat)
    {
        $data = MenerimaCuti::findOrFail($no_surat);
        $pegawai = Pegawai::all();
        $cuti = Cuti::all();

        return view('admin.cuti.riwayatcuti.edit', [
            'data' => $data,
            'pegawaiList' => $pegawai,
            'cutiList' => $cuti
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $no_surat)
    {
        $request->validate([
            'nip' => 'required|exists:pegawai,nip',
            'cuti_id' => 'required|exists:cuti,id',
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'required|date|after_or_equal:tanggal_mulai',
            'jumlah_cuti' => 'required|integer|min:1',
            'keterangan' => 'nullable|string',
        ]);

        $data = MenerimaCuti::findOrFail($no_surat);
        $data->update($request->all());

        return redirect()->route('admin.cuti.riwayatcuti.index')->with('success', 'Data cuti pegawai berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $no_surat)
    {
        $data = MenerimaCuti::findOrFail($no_surat);
        $data->delete();

        return redirect()->route('admin.cuti.riwayatcuti.index')->with('success', 'Data cuti pegawai berhasil dihapus.');
    }
}
