<?php

namespace App\Imports;

use App\Models\Provinsi;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Illuminate\Support\Facades\Validator;

class ProvinsiImport implements ToCollection
{
    public function collection(Collection $rows)
    {
        foreach ($rows as $index => $row) {
            if ($index === 0 && strtolower($row[0]) === 'nama_provinsi') {
                continue;
            }

            $namaProvinsi = $row[0];
            $providedId = isset($row[1]) ? (string) $row[1] : null;

            $validator = Validator::make([
                'nama_provinsi' => $namaProvinsi,
            ], [
                'nama_provinsi' => 'required|string|max:30|unique:provinsi,nama_provinsi',
            ]);

            if ($validator->fails()) {
                continue;
            }

            $newId = $providedId;
            if (!$newId) {
                // Cari ID otomatis (varchar 2)
                $usedIds = Provinsi::pluck('id')->toArray();
                for ($i = 1; $i <= 99; $i++) {
                    $iStr = str_pad($i, 2, '0', STR_PAD_LEFT);
                    if (!in_array($iStr, $usedIds)) {
                        $newId = $iStr;
                        break;
                    }
                }
            }

            Provinsi::create([
                'id' => $newId,
                'nama_provinsi' => $namaProvinsi,
            ]);
        }
    }
}
