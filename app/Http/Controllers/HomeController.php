<?php

namespace App\Http\Controllers;

use App\Models\Diklat;
use Illuminate\Http\Request;
use App\Models\Pegawai;
use App\Models\UnitKerja;
use App\Models\Jabatan;
use App\Models\Golongan;
use App\Models\Kabupaten;
use App\Models\Kecamatan;
use App\Models\Provinsi;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        $unitKerjaFilter = $request->input('unit_kerja');
        $kabupatenFilter = $request->input('kabupaten');
        $warnaFilter = $request->input('warna');

        $totalUnit = UnitKerja::count();
        $totalJabatan = Jabatan::count();
        $totalGolongan = Golongan::count();
        $unitKerjaList = UnitKerja::all();
        $kabupatenList = Kabupaten::pluck('nama_kabupaten', 'id');
        $totalKabupaten = Kabupaten::count();
        $totalKecamatan = Kecamatan::count();
        $totalProvinsi = Provinsi::count();
        $totalDiklat = Diklat::count();
        // Total Pegawai (Filtered)
        $totalPegawai = Pegawai::when($unitKerjaFilter, fn($q) => $q->where('kode_kantor', $unitKerjaFilter))
            ->when($kabupatenFilter, fn($q) => $q->where('id_kabupaten', $kabupatenFilter))
            ->count();

        // Bar Chart Data
        $pegawaiPerUnit = Pegawai::select('unit_kerja.nama_kantor as unit', DB::raw('COUNT(*) as total'))
            ->join('unit_kerja', 'pegawai.kode_kantor', '=', 'unit_kerja.kode_kantor')
            ->when($unitKerjaFilter, fn($q) => $q->where('pegawai.kode_kantor', $unitKerjaFilter))
            ->when($kabupatenFilter, fn($q) => $q->where('pegawai.id_kabupaten', $kabupatenFilter))
            ->groupBy('unit_kerja.nama_kantor')
            ->orderBy('unit')
            ->get();
        // Data tambahan
        $pegawaiPerBulan = Pegawai::selectRaw('MONTH(created_at) as bulan, COUNT(*) as total')
            ->when($unitKerjaFilter, fn($q) => $q->where('kode_kantor', $unitKerjaFilter))
            ->when($kabupatenFilter, fn($q) => $q->where('id_kabupaten', $kabupatenFilter))
            ->groupBy('bulan')
            ->orderBy('bulan')
            ->get();

        $pegawaiPerGolongan = Pegawai::select('golongan.jabatan_fungsional', DB::raw('COUNT(*) as total'))
            ->join('golongan', 'pegawai.id_golongan', '=', 'golongan.id_golongan')
            ->groupBy('golongan.jabatan_fungsional')
            ->get();

        $pegawaiPerJabatan = Pegawai::select('jabatan.nama_jabatan', DB::raw('COUNT(*) as total'))
            ->join('jabatan', 'pegawai.id_jabatan', '=', 'jabatan.id_jabatan')
            ->groupBy('jabatan.nama_jabatan')
            ->get();

        return view('admin.home.index', [
            'totalPegawai' => $totalPegawai,
            'totalUnit' => $totalUnit,
            'totalJabatan' => $totalJabatan,
            'totalGolongan' => $totalGolongan,
            'totalKabupaten' => $totalKabupaten,
            'totalProvinsi' => $totalProvinsi,
            'totalKecamatan' => $totalKecamatan,
            'totalDiklat'=> $totalDiklat,
            'pegawaiPerUnit' => $pegawaiPerUnit,
            'unitKerjaList' => $unitKerjaList,
            'kabupatenList' => $kabupatenList,
            'unitKerjaFilter' => request('unit_kerja'),
            'kabupatenFilter' => request('kabupaten'),
            'pegawaiPerBulan' => $pegawaiPerBulan,
            'pegawaiPerGolongan' => $pegawaiPerGolongan,
            'pegawaiPerJabatan' => $pegawaiPerJabatan
        ]);
    }
}
