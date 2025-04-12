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
            if ($index === 0 && strtolower($row[0]) === 'nama_kabupaten') {
                continue;
            }

            $validator = Validator::make([
                'nama_kabupaten' => $row[0],
                'id_provinsi' => $row[1],
            ], [
                'nama_kabupaten' => 'required|string|max:30|unique:kabupaten,nama_kabupaten',
                'id_provinsi' => 'required|exists:provinsi,id',
            ]);

            if ($validator->fails()) {
                continue; // Skip baris jika tidak valid
            }

            // Cari ID otomatis dari missing ID antara 1000–9999
            $existingIds = Kabupaten::orderBy('id')->pluck('id')->toArray();
            for ($i = 1000; $i <= 9999; $i++) {
                $newId = str_pad($i, 4, '0', STR_PAD_LEFT);
                if (!in_array($newId, $existingIds)) {
                    break;
                }
            }

            Kabupaten::create([
                'id' => $newId,
                'nama_kabupaten' => $row[0],
                'id_provinsi' => $row[1],
            ]);
        }
    }
}
