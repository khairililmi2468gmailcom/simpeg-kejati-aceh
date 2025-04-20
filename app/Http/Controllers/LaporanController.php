<?php

namespace App\Http\Controllers;

use App\Models\Diklat;
use App\Models\Golongan;
use App\Models\Jabatan;
use App\Models\Kepangkatan;
use App\Models\MenerimaCuti;
use App\Models\MengikutiDiklat;
use App\Models\Mutasi;
use App\Models\Pegawai;
use App\Models\Provinsi;
use App\Models\UnitKerja;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class LaporanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
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
        $unitkerjasValues = UnitKerja::orderBy('nama_kantor')->get();

        $searchPegawai = $request->searchPegawai;
        $unitKerja = $request->unit_kerja;
        $jabatanFungsional = $request->jabatan_fungsional;
        $perPagePegawai = $request->per_page_pegawai ?? 5;
        $pegawais = Pegawai::with(['golongan', 'jabatan', 'unitkerja'])
            ->when($searchPegawai, function ($query) use ($searchPegawai) {
                $query->where('nip', 'like', "%$searchPegawai%")
                    ->orWhere('nama', 'like', "%$searchPegawai%");
            })
            ->when($unitKerja, function ($query) use ($unitKerja) {
                $query->where('kode_kantor', $unitKerja);
            })
            ->when($jabatanFungsional, function ($query) use ($jabatanFungsional) {
                $query->where('id_golongan', $jabatanFungsional);
            })
            ->orderBy('created_at', 'desc')
            ->paginate($perPagePegawai);

        $searchCuti = $request->searchCuti;
        $tahunCuti = $request->tahun_cuti;
        $perPageCuti = $request->per_page_cuti ?? 5;
        $menerimaCuti = MenerimaCuti::with(['pegawai', 'cuti'])
            ->when($searchCuti, function ($query) use ($searchCuti) {
                $query->whereHas('pegawai', function ($q) use ($searchCuti) {
                    $q->where('nama', 'like', "%$searchCuti%")
                        ->orWhere('nip', 'like', "%$searchCuti%");
                })->orWhereHas('cuti', function ($q) use ($searchCuti) {
                    $q->where('jenis_cuti', 'like', "%$searchCuti%");
                });
            })
            ->when($tahunCuti, function ($query) use ($tahunCuti) {
                $query->whereYear('tanggal_mulai', $tahunCuti);
            })
            ->orderBy('tanggal_mulai', 'desc')
            ->paginate($perPageCuti);

        // Untuk dropdown tahun
        $tahunList = MenerimaCuti::selectRaw('YEAR(tanggal_mulai) as tahun')
            ->distinct()
            ->orderBy('tahun', 'desc')
            ->pluck('tahun');

        $searchDiklat = $request->searchDiklat;
        $tahunDiklat = $request->tahun_diklat;
        $jenisDiklat = $request->nama_diklat;
        $perPageDiklat = $request->per_page_diklat ?? 5;
        $mengikutiDiklat = MengikutiDiklat::with(['pegawai', 'diklat'])
            ->when($searchDiklat, function ($query) use ($searchDiklat) {
                $query->whereHas('pegawai', function ($q) use ($searchDiklat) {
                    $q->where('nama', 'like', "%$searchDiklat%")
                        ->orWhere('nip', 'like', "%$searchDiklat%");
                })->orWhereHas('diklat', function ($q) use ($searchDiklat) {
                    $q->where('nama_diklat', 'like', "%$searchDiklat%")
                        ->orWhere('jenis_diklat', 'like', "%$searchDiklat%");
                });
            })
            ->when($jenisDiklat, function ($query) use ($jenisDiklat) {
                $query->whereHas('diklat', function ($q) use ($jenisDiklat) {
                    $q->where('nama_diklat', $jenisDiklat);
                });
            })
            ->when($tahunDiklat, function ($query) use ($tahunDiklat) {
                $query->whereYear('tanggal_mulai', $tahunDiklat);
            })
            ->orderBy('tanggal_mulai', 'desc')
            ->paginate($perPageDiklat);
        $diklatValues = Diklat::orderBy('nama_diklat')->get();
        $tahunListDiklat = MengikutiDiklat::selectRaw('YEAR(tanggal_mulai) as tahun')
            ->distinct()
            ->orderBy('tahun', 'desc')
            ->pluck('tahun');

        $searchMutasi = $request->searchMutasi;
        $tahunMutasi = $request->tahun_mutasi;
        $perPageMutasi = $request->per_page_mutasi ?? 5;
        $mutasi = Mutasi::with(['pegawai', 'jabatan'])
            ->when($searchMutasi, function ($query) use ($searchMutasi) {
                $query->whereHas('pegawai', function ($q) use ($searchMutasi) {
                    $q->where('nama', 'like', "%$searchMutasi%");
                })->orWhereHas('jabatan', function ($q) use ($searchMutasi) {
                    $q->where('nama_jabatan', 'like', "%$searchMutasi%")
                        ->orWhere('ket', 'like', "%$searchMutasi%");
                })->orWhere('nip', 'like', "%$searchMutasi%");
            })
            ->when($tahunMutasi, function ($query) use ($tahunMutasi) {
                $query->whereYear('tanggal_sk', $tahunMutasi);
            })
            ->orderBy('created_at', 'desc')
            ->paginate($perPageMutasi);
        $tahunMutasi = Mutasi::selectRaw('YEAR(tanggal_sk) as tahun')
            ->distinct()
            ->orderBy('tahun', 'desc')
            ->pluck('tahun');

        $searchKepangkatan = $request->searchKepangkatan;
        $jenisUsulan = $request->jenis_usulan;
        $tahunKepangkatan = $request->tahun_kepangkatan;
        $perPageKepangkatan = $request->per_page_kepangkatan ?? 5;
        $kepangkatan = Kepangkatan::with(['pegawai', 'golongan'])
            ->when($searchKepangkatan, function ($query) use ($searchKepangkatan) {
                $query->whereHas('pegawai', function ($q) use ($searchKepangkatan) {
                    $q->where('nama', 'like', "%$searchKepangkatan%");
                })->orWhereHas('golongan', function ($q) use ($searchKepangkatan) {
                    $q->where('jabatan_fungsional', 'like', "%$searchKepangkatan%")
                        ->orWhere('pangkat', 'like', "%$searchKepangkatan%")
                        ->orWhere('id_golongan', 'like', "%$searchKepangkatan%");
                })->orWhere('nip', 'like', "%$searchKepangkatan%");
            })
            ->when($jenisUsulan, function ($query) use ($jenisUsulan) {
                $query->where('jenis_usulan', $jenisUsulan);
            })
            ->when($tahunKepangkatan, function ($query) use ($tahunKepangkatan) {
                $query->whereYear('tanggal_sk', $tahunKepangkatan);
            })
            ->orderBy('created_at', 'desc')
            ->paginate($perPageKepangkatan);

        $kepangkatanValues = Kepangkatan::orderBy('jenis_usulan')->get();
        $tahunListKepangkatan = Kepangkatan::selectRaw('YEAR(tanggal_sk) as tahun')
            ->distinct()
            ->orderBy('tahun', 'desc')
            ->pluck('tahun');
            
        return view('admin.laporan.index', compact(
            'jabatans',
            'searchJabatan',
            'perPageJabatan',
            'golongans',
            'searchGolongan',
            'perPageGolongan',
            'unitkerjas',
            'unitkerjasValues',
            'searchUnitKerja',
            'perPageUnitKerja',
            'pegawais',
            'searchPegawai',
            'perPagePegawai',
            'menerimaCuti',
            'tahunList',
            'searchCuti',
            'perPageCuti',
            'mengikutiDiklat',
            'searchDiklat',
            'perPageDiklat',
            'tahunListDiklat',
            'diklatValues',
            'mutasi',
            'searchMutasi',
            'tahunMutasi',
            'perPageMutasi',
            'kepangkatan',
            'kepangkatanValues',
            'tahunListKepangkatan',
            'searchKepangkatan',
            'perPageKepangkatan'
        ));
    }



    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show($nip)
    {
        $pegawai = Pegawai::with(['provinsi', 'golongan', 'unitKerja', 'jabatan'])->findOrFail($nip);
        return view('admin.pegawai.show', compact('pegawai'));
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
