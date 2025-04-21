<?php

namespace App\Imports;

use App\Models\Kabupaten;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Illuminate\Support\Facades\Validator;

class KabupatenImport implements ToCollection
{
    public function collection(Collection $rows)
    {
        foreach ($rows as $index => $row) {
            // Lewati baris header jika cocok
            if ($index === 0 && strtolower($row[0]) === 'id') {
                continue;
            }

            $providedId = isset($row[0]) ? str_pad($row[0], 4, '0', STR_PAD_LEFT) : null;
            $namaKabupaten = $row[1] ?? null;
            $idProvinsi = $row[2] ?? null;

            $validator = Validator::make([
                'id' => $providedId,
                'nama_kabupaten' => $namaKabupaten,
                'id_provinsi' => $idProvinsi,
            ], [
                'id' => 'nullable|string|max:4|unique:kabupaten,id',
                'nama_kabupaten' => 'required|string|max:50',
                'id_provinsi' => 'required|exists:provinsi,id',
            ]);

            if ($validator->fails()) {
                continue;
            }

            $newId = $providedId;
            if (!$newId) {
                $usedIds = Kabupaten::pluck('id')->toArray();
                for ($i = 1000; $i <= 9999; $i++) {
                    $idStr = str_pad($i, 4, '0', STR_PAD_LEFT);
                    if (!in_array($idStr, $usedIds)) {
                        $newId = $idStr;
                        break;
                    }
                }
            }

            Kabupaten::create([
                'id' => $newId,
                'nama_kabupaten' => $namaKabupaten,
                'id_provinsi' => $idProvinsi,
            ]);
        }
    }
}
