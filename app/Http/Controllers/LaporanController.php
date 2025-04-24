<?php

namespace App\Http\Controllers;

use App\Models\Cuti;
use App\Models\Diklat;
use App\Models\Golongan;
use App\Models\Jabatan;
use App\Models\KepalaKejaksaan;
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
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Illuminate\Support\Facades\Storage;

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

    // ============== CETAK PDF LAPORAN ==================
    public function cetakPdfPegawai(Request $request)
    {
        $query = Pegawai::query();

        if ($request->filled('nip')) {
            $query->where('nip', $request->nip);
        }

        if ($request->filled('kode_kantor')) {
            $query->where('kode_kantor', $request->kode_kantor);
        }

        if ($request->filled('id_golongan')) {
            $query->where('id_golongan', $request->id_golongan);
        }

        $pegawai = $query->get();
        $kepalakejaksaan = KepalaKejaksaan::first();
        // QR Code: bisa berisi informasi tanggal cetak + info otentikasi
        $tanggalCetak = Carbon::now()->translatedFormat('d F Y');
        $kepalaInfo = "Kepala Kejaksaan: " . ($kepalakejaksaan->nama ?? 'Tidak Ada Data') . "\nNIP: " . ($kepalakejaksaan->nip ?? '-');
        $qrContent = "Laporan Pegawai - Kejati Aceh\nDicetak pada: $tanggalCetak\n$kepalaInfo";
        $qrCode = base64_encode(QrCode::format('png')->size(100)->generate($qrContent));

        $pdf = Pdf::loadView('exports.pegawai_pdf', [
            'pegawai' => $pegawai,
            'tanggalCetak' => $tanggalCetak,
            'qrCode' => $qrCode,
            'kepalakejaksaan' => $kepalakejaksaan,
        ])->setPaper('A4', 'portrait');

        return $pdf->stream('Laporan_Pegawai_Kejati_Aceh.pdf');
    }
    public function cetakPdfSatuPegawai($id)
    {
        $pegawai = Pegawai::with(['unitKerja', 'golongan'])->findOrFail($id);

        // QR Code
        $qrCode = base64_encode(
            QrCode::format('png')->size(100)->generate("Data Pegawai: {$pegawai->nama} - NIP: {$pegawai->nip}")
        );

        // Base64 foto pegawai
        $fotoPath = storage_path('app/public/' . $pegawai->foto);
        $fotoBase64 = null;

        if (!empty($pegawai->foto) && file_exists($fotoPath)) {
            $ext = pathinfo($fotoPath, PATHINFO_EXTENSION);
            $fotoBase64 = 'data:image/' . $ext . ';base64,' . base64_encode(file_get_contents($fotoPath));
        } else {
            // Opsional: fallback ke foto default
            $defaultPath = public_path('image/default.png');
            if (file_exists($defaultPath)) {
                $fotoBase64 = 'data:image/png;base64,' . base64_encode(file_get_contents($defaultPath));
            }
        }

        $pdf = Pdf::loadView('exports.pegawai_pdf_single', [
            'pegawai' => $pegawai,
            'qrCode' => $qrCode,
            'fotoBase64' => $fotoBase64,
            'title' => 'Data Pegawai - Kejaksaan Tinggi Aceh',
        ]);

        return $pdf->stream("pegawai-{$pegawai->nip}-{$pegawai->nama}.pdf");
    }


    public function cetakPdfCuti(Request $request)
    {
        $query = MenerimaCuti::query();

        if ($request->filled('no_surat')) {
            $query->where('no_surat', $request->no_surat);
        }

        if ($request->filled('nip')) {
            $query->where('nip', $request->nip);
        }

        if ($request->filled('cuti_id')) {
            $query->where('cuti_id', $request->cuti_id);
        }

        $cuti = $query->get();
        $kepalakejaksaan = KepalaKejaksaan::first();

        // QR Code: bisa berisi informasi tanggal cetak + info otentikasi
        $tanggalCetak = Carbon::now()->translatedFormat('d F Y');
        $kepalaInfo = "Kepala Kejaksaan: " . ($kepalakejaksaan->nama ?? 'Tidak Ada Data') . "\nNIP: " . ($kepalakejaksaan->nip ?? '-');
        $qrContent = "Laporan Cuti Pegawai - Kejati Aceh\nDicetak pada: $tanggalCetak\n$kepalaInfo";
        $qrCode = base64_encode(QrCode::format('png')->size(100)->generate($qrContent));

        $pdf = Pdf::loadView('exports.cuti_pdf', [
            'cuti' => $cuti,
            'tanggalCetak' => $tanggalCetak,
            'qrCode' => $qrCode,
            'kepalakejaksaan' => $kepalakejaksaan,
        ])->setPaper('A4', 'portrait');

        return $pdf->stream('Laporan_Cuti_Pegawai_Kejati_Aceh.pdf');
    }

    public function cetakPdfSatuCuti($id)
    {
        $cuti = MenerimaCuti::with(['pegawai', 'cuti'])->findOrFail($id);
        $kepalakejaksaan = KepalaKejaksaan::first();

        // QR Code
        $qrContent = "Data Cuti Pegawai: {$cuti->pegawai->nama} - NIP: {$cuti->nip}\n";
        $qrContent .= "Kepala Kejaksaan: " . ($kepalakejaksaan->nama ?? 'Tidak Ada Data') . "\n";
        $qrContent .= "NIP Kepala Kejaksaan: " . ($kepalakejaksaan->nip ?? '-');

        // Generate QR Code with combined content
        $qrCode = base64_encode(
            QrCode::format('png')->size(100)->generate($qrContent)
        );

        // Base64 foto pegawai
        $fotoPath = storage_path('app/public/' . $cuti->foto);
        $fotoBase64 = null;

        if (!empty($cuti->foto) && file_exists($fotoPath)) {
            $ext = pathinfo($fotoPath, PATHINFO_EXTENSION);
            $fotoBase64 = 'data:image/' . $ext . ';base64,' . base64_encode(file_get_contents($fotoPath));
        } else {
            // Opsional: fallback ke foto default
            $defaultPath = public_path('image/default.png');
            if (file_exists($defaultPath)) {
                $fotoBase64 = 'data:image/png;base64,' . base64_encode(file_get_contents($defaultPath));
            }
        }

        $pdf = Pdf::loadView('exports.cuti_pdf_single', [
            'cuti' => $cuti,
            'qrCode' => $qrCode,
            'fotoBase64' => $fotoBase64,
            'title' => 'Data Cuti - Kejaksaan Tinggi Aceh',
            'kepalakejaksaan' => $kepalakejaksaan,
        ]);

        return $pdf->stream("Cuti-{$cuti->nip}-{$cuti->pegawai->nama}.pdf");
    }


    public function cetakPdfDiklat(Request $request)
    {
        $query = MengikutiDiklat::query();

        if ($request->filled('no_sttpp')) {
            $query->where('no_sttpp', $request->no_sttpp);
        }

        if ($request->filled('nip')) {
            $query->where('nip', $request->nip);
        }

        if ($request->filled('diklat_id')) {
            $query->where('diklat_id', $request->diklat_id);
        }

        $diklat = $query->get();
        $kepalakejaksaan = KepalaKejaksaan::first();
        // QR Code: bisa berisi informasi tanggal cetak + info otentikasi
        $tanggalCetak = Carbon::now()->translatedFormat('d F Y');
        $kepalaInfo = "Kepala Kejaksaan: " . ($kepalakejaksaan->nama ?? 'Tidak Ada Data') . "\nNIP: " . ($kepalakejaksaan->nip ?? '-');
        $qrContent = "Laporan Diklat Pegawai - Kejati Aceh\nDicetak pada: $tanggalCetak\n$kepalaInfo";
        $qrCode = base64_encode(QrCode::format('png')->size(100)->generate($qrContent));

        $pdf = Pdf::loadView('exports.diklat_pdf', [
            'diklat' => $diklat,
            'tanggalCetak' => $tanggalCetak,
            'qrCode' => $qrCode,
            'kepalakejaksaan' => $kepalakejaksaan,
        ])->setPaper('A4', 'portrait');

        return $pdf->stream('Laporan_Diklat_Pegawai_Kejati_Aceh.pdf');
    }

    public function cetakPdfSatuDiklat($id)
    {
        $diklat = MengikutiDiklat::with(['pegawai', 'diklat'])->findOrFail($id);

        $kepalakejaksaan = KepalaKejaksaan::first();

        // QR Code
        $qrContent = "Data Diklat Pegawai: {$diklat->pegawai->nama} - NIP: {$diklat->nip}\n";
        $qrContent .= "Kepala Kejaksaan: " . ($kepalakejaksaan->nama ?? 'Tidak Ada Data') . "\n";
        $qrContent .= "NIP Kepala Kejaksaan: " . ($kepalakejaksaan->nip ?? '-');

        // Generate QR Code with combined content
        $qrCode = base64_encode(
            QrCode::format('png')->size(100)->generate($qrContent)
        );
        // Base64 foto pegawai
        $fotoPath = storage_path('app/public/' . $diklat->foto);
        $fotoBase64 = null;

        if (!empty($diklat->foto) && file_exists($fotoPath)) {
            $ext = pathinfo($fotoPath, PATHINFO_EXTENSION);
            $fotoBase64 = 'data:image/' . $ext . ';base64,' . base64_encode(file_get_contents($fotoPath));
        } else {
            // Opsional: fallback ke foto default
            $defaultPath = public_path('image/default.png');
            if (file_exists($defaultPath)) {
                $fotoBase64 = 'data:image/png;base64,' . base64_encode(file_get_contents($defaultPath));
            }
        }

        $pdf = Pdf::loadView('exports.diklat_pdf_single', [
            'diklat' => $diklat,
            'qrCode' => $qrCode,
            'fotoBase64' => $fotoBase64,
            'title' => 'Data diklat - Kejaksaan Tinggi Aceh',
            'kepalakejaksaan' => $kepalakejaksaan,
        ]);

        return $pdf->stream("Diklat-{$diklat->nip}-{$diklat->pegawai->nama}.pdf");
    }

    public function cetakPdfMutasi(Request $request)
    {
        $query = Mutasi::query();

        if ($request->filled('no_sk')) {
            $query->where('no_sk', $request->no_sk);
        }

        if ($request->filled('nip')) {
            $query->where('nip', $request->nip);
        }

        if ($request->filled('id_jabatan')) {
            $query->where('id_jabatan', $request->id_jabatan);
        }

        $mutasi = $query->with(['pegawai', 'jabatan', 'golonganPegawai'])->get(); // include eager load
        $kepalakejaksaan = KepalaKejaksaan::first();

        // QR Code: bisa berisi informasi tanggal cetak + info otentikasi
        $tanggalCetak = Carbon::now()->translatedFormat('d F Y');
        $kepalaInfo = "Kepala Kejaksaan: " . ($kepalakejaksaan->nama ?? 'Tidak Ada Data') . "\nNIP: " . ($kepalakejaksaan->nip ?? '-');
        $qrContent = "Laporan Mutasi Pegawai - Kejati Aceh\nDicetak pada: $tanggalCetak\n$kepalaInfo";
        $qrCode = base64_encode(QrCode::format('png')->size(100)->generate($qrContent));

        $pdf = Pdf::loadView('exports.mutasi_pdf', [
            'mutasi' => $mutasi,
            'tanggalCetak' => $tanggalCetak,
            'qrCode' => $qrCode,
            'kepalakejaksaan' => $kepalakejaksaan,
        ])->setPaper('A4', 'landscape');

        return $pdf->stream('Laporan_Daftar_Mutasi_Pegawai_Kejati_Aceh.pdf');
    }

    public function cetakPdfSatuMutasi($id)
    {
        $mutasi = Mutasi::with(['pegawai', 'jabatan'])->findOrFail($id);

        $kepalakejaksaan = KepalaKejaksaan::first();

        // QR Code
        $qrContent = "Data Mutasi Pegawai: {$mutasi->pegawai->nama} - NIP: {$mutasi->nip}\n";
        $qrContent .= "Kepala Kejaksaan: " . ($kepalakejaksaan->nama ?? 'Tidak Ada Data') . "\n";
        $qrContent .= "NIP Kepala Kejaksaan: " . ($kepalakejaksaan->nip ?? '-');

        // Generate QR Code with combined content
        $qrCode = base64_encode(
            QrCode::format('png')->size(100)->generate($qrContent)
        );

        // Base64 foto pegawai
        $fotoPath = storage_path('app/public/' . $mutasi->foto);
        $fotoBase64 = null;

        if (!empty($mutasi->foto) && file_exists($fotoPath)) {
            $ext = pathinfo($fotoPath, PATHINFO_EXTENSION);
            $fotoBase64 = 'data:image/' . $ext . ';base64,' . base64_encode(file_get_contents($fotoPath));
        } else {
            // Opsional: fallback ke foto default
            $defaultPath = public_path('image/default.png');
            if (file_exists($defaultPath)) {
                $fotoBase64 = 'data:image/png;base64,' . base64_encode(file_get_contents($defaultPath));
            }
        }

        $pdf = Pdf::loadView('exports.mutasi_pdf_single', [
            'mutasi' => $mutasi,
            'qrCode' => $qrCode,
            'fotoBase64' => $fotoBase64,
            'title' => 'Data mutasi - Kejaksaan Tinggi Aceh',
            'kepalakejaksaan' => $kepalakejaksaan,
        ]);

        return $pdf->stream("Mutasi-{$mutasi->nip}-{$mutasi->pegawai->nama}.pdf");
    }

    public function cetakPdfKepangkatan(Request $request)
    {
        $query = Kepangkatan::query();

        if ($request->filled('no_sk')) {
            $query->where('no_sk', $request->no_sk);
        }

        if ($request->filled('nip')) {
            $query->where('nip', $request->nip);
        }

        if ($request->filled('id_golongan')) {
            $query->where('id_golongan', $request->id_golongan);
        }

        $kepangkatan = $query->get();
        $kepalakejaksaan = KepalaKejaksaan::first();
        // QR Code: bisa berisi informasi tanggal cetak + info otentikasi
        $tanggalCetak = Carbon::now()->translatedFormat('d F Y');
        $kepalaInfo = "Kepala Kejaksaan: " . ($kepalakejaksaan->nama ?? 'Tidak Ada Data') . "\nNIP: " . ($kepalakejaksaan->nip ?? '-');
        $qrContent = "Laporan Kepangkatan Pegawai - Kejati Aceh\nDicetak pada: $tanggalCetak\n$kepalaInfo";
        $qrCode = base64_encode(QrCode::format('png')->size(100)->generate($qrContent));

        $pdf = Pdf::loadView('exports.kepangkatan_pdf', [
            'kepangkatan' => $kepangkatan,
            'tanggalCetak' => $tanggalCetak,
            'qrCode' => $qrCode,
            'kepalakejaksaan' => $kepalakejaksaan,
        ])->setPaper('A4', 'portrait');

        return $pdf->stream('Laporan_Daftar_Kepangkatan_Pegawai_Kejati_Aceh.pdf');
    }

    public function cetakPdfSatuKepangkatan($id)
    {
        $kepangkatan = Kepangkatan::with(['pegawai', 'golongan'])->findOrFail($id);
        $kepalakejaksaan = KepalaKejaksaan::first();

        // QR Code
        $qrContent = "Data Kepangkatan Pegawai: {$kepangkatan->pegawai->nama} - NIP: {$kepangkatan->nip}\n";
        $qrContent .= "Kepala Kejaksaan: " . ($kepalakejaksaan->nama ?? 'Tidak Ada Data') . "\n";
        $qrContent .= "NIP Kepala Kejaksaan: " . ($kepalakejaksaan->nip ?? '-');

        // Generate QR Code with combined content
        $qrCode = base64_encode(
            QrCode::format('png')->size(100)->generate($qrContent)
        );

        // Base64 foto pegawai
        $fotoPath = storage_path('app/public/' . $kepangkatan->pegawai->foto);
        $fotoBase64 = null;

        if (!empty($mutasi->foto) && file_exists($fotoPath)) {
            $ext = pathinfo($fotoPath, PATHINFO_EXTENSION);
            $fotoBase64 = 'data:image/' . $ext . ';base64,' . base64_encode(file_get_contents($fotoPath));
        } else {
            // Opsional: fallback ke foto default
            $defaultPath = public_path('image/default.png');
            if (file_exists($defaultPath)) {
                $fotoBase64 = 'data:image/png;base64,' . base64_encode(file_get_contents($defaultPath));
            }
        }

        $pdf = Pdf::loadView('exports.kepangkatan_pdf_single', [
            'kepangkatan' => $kepangkatan,
            'qrCode' => $qrCode,
            'fotoBase64' => $fotoBase64,
            'title' => 'Data Kepangkatan - Kejaksaan Tinggi Aceh',
            'kepalakejaksaan' => $kepalakejaksaan,
        ]);

        return $pdf->stream("Kepangkatan-{$kepangkatan->nip}-{$kepangkatan->pegawai->nama}.pdf");
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
