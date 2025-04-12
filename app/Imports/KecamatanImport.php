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
            // Lewati baris header jika cocok
            if ($index === 0 && strtolower($row[0]) === 'nama_kecamatan') {
                continue;
            }

            $validator = Validator::make([
                'nama_kecamatan' => $row[0],
                'id_kabupaten' => $row[1],
            ], [
                'nama_kecamatan' => 'required|string|max:30|unique:kecamatan,nama_kecamatan',
                'id_kabupaten' => 'required|exists:kabupaten,id',
            ]);

            if ($validator->fails()) {
                continue; // Skip baris jika tidak valid
            }

            // Cari ID otomatis dari missing ID antara 1000–9999
            $existingIds = Kecamatan::orderBy('id')->pluck('id')->toArray();
            for ($i = 1000000; $i <= 9999999; $i++) {
                $newId = str_pad($i, 7, '0', STR_PAD_LEFT);
                if (!in_array($newId, $existingIds)) {
                    break;
                }
            }

            Kecamatan::create([
                'id' => $newId,
                'nama_kecamatan' => $row[0],
                'id_kabupaten' => $row[1],
            ]);
        }
    }
}
