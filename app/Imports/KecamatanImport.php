<?php

namespace App\Imports;

use App\Models\Kecamatan;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Illuminate\Support\Facades\Validator;

class KecamatanImport implements ToCollection
{
    public function collection(Collection $rows)
    {
        foreach ($rows as $index => $row) {
            // Lewati baris header
            if ($index === 0 && strtolower($row[0]) === 'id') {
                continue;
            }

            $providedId = isset($row[0]) ? str_pad($row[0], 6, '0', STR_PAD_LEFT) : null;
            $namaKecamatan = $row[1] ?? null;
            $idKabupaten = $row[2] ?? null;

            $validator = Validator::make([
                'id' => $providedId,
                'nama_kecamatan' => $namaKecamatan,
                'id_kabupaten' => $idKabupaten,
            ], [
                'id' => 'nullable|string|max:6|unique:kecamatan,id',
                'nama_kecamatan' => 'required|string|max:50',
                'id_kabupaten' => 'required|exists:kabupaten,id',
            ]);

            if ($validator->fails()) {
                continue;
            }

            // Cari ID otomatis jika tidak diberikan
            $newId = $providedId;
            if (!$newId) {
                $usedIds = Kecamatan::pluck('id')->toArray();
                for ($i = 100000; $i <= 999999; $i++) {
                    $idStr = str_pad($i, 6, '0', STR_PAD_LEFT);
                    if (!in_array($idStr, $usedIds)) {
                        $newId = $idStr;
                        break;
                    }
                }
            }

            Kecamatan::create([
                'id' => $newId,
                'nama_kecamatan' => $namaKecamatan,
                'id_kabupaten' => $idKabupaten,
            ]);
        }
    }
}
