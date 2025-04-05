<?php

namespace App\Exports;

use App\Models\Pegawai;
use Maatwebsite\Excel\Concerns\FromView;
use Illuminate\Contracts\View\View;

class PegawaiExport implements FromView
{
    public function view(): View
    {
        $pegawais = Pegawai::with(['provinsi', 'kabupaten', 'kecamatan', 'golongan', 'jabatan', 'unitKerja'])->get();
        return view('exports.pegawai', compact('pegawais'));
    }
}
