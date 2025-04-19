<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Pegawai;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class NotifikasiController extends Controller
{
    public function pensiun()
    {
        try {
            Log::info('Masuk ke method pensiun');
            $today = Carbon::today();
            $batasUsiaPensiun = 60;
            $usiaMulaiNotifikasi = 55;

            $tanggalLahirAwal = $today->copy()->subYears($batasUsiaPensiun);
            $tanggalLahirAkhir = $today->copy()->subYears($usiaMulaiNotifikasi);
            // Log::info('Tanggal lahir awal: ' . $tanggalLahirAwal . ' Tanggal lahir akhir: ' . $tanggalLahirAkhir);

            $pegawaiPensiun = Pegawai::whereBetween('tgl_lahir', [$tanggalLahirAwal, $tanggalLahirAkhir])
                ->get()
                ->map(function ($pegawai) use ($today, $batasUsiaPensiun) {
                    if (!$pegawai->tgl_lahir) {
                        Log::warning("Pegawai dengan NIP {$pegawai->nip} tidak memiliki tgl_lahir.");
                        return null;
                    }

                    try {
                        $tglPensiun = Carbon::parse($pegawai->tgl_lahir)->addYears($batasUsiaPensiun);
                    } catch (\Exception $e) {
                        Log::error("Gagal memparse tgl_lahir untuk Pegawai NIP {$pegawai->nip}: " . $e->getMessage());
                        return null;
                    }

                    $sisaHari = $today->diffInDays($tglPensiun, false);

                    return [
                        'nama' => $pegawai->nama,
                        'nip' => $pegawai->nip,
                        'tgl_pensiun' => $tglPensiun->format('Y-m-d'), // ISO format
                        'tgl_lahir' => $pegawai->tgl_lahir ? Carbon::parse($pegawai->tgl_lahir)->format('Y-m-d') : null,
                        'sisa_hari' => $sisaHari,
                        'foto' => $pegawai->foto ? asset('storage/' . $pegawai->foto) : asset('/image/logo.png'), // Tambahkan asset() untuk default

                    ];
                })
                ->filter();

            // Log::info('Hasil query: ', $pegawaiPensiun->toArray());
            return response()->json($pegawaiPensiun);
        } catch (\Exception $e) {
            Log::error("Error pada method pensiun: " . $e->getMessage());
            return response()->json(['error' => 'Terjadi kesalahan server.'], 500);
        }
    }
}
