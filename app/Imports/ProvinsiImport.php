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
        // Skip header jika ada
        foreach ($rows as $index => $row) {
            if ($index === 0 && strtolower($row[0]) === 'nama_provinsi') {
                continue;
            }

            $validator = Validator::make([
                'nama_provinsi' => $row[0],
            ], [
                'nama_provinsi' => 'required|string|max:30|unique:provinsi,nama_provinsi',
            ]);

            if ($validator->fails()) {
                continue; // Skip jika invalid
            }

            // Ambil ID otomatis
            $lastId = Provinsi::orderBy('id')->pluck('id')->toArray();
            for ($i = 1; $i <= 99; $i++) {
                if (!in_array($i, $lastId)) {
                    $newId = $i;
                    break;
                }
            }

            Provinsi::create([
                'id' => $newId,
                'nama_provinsi' => $row[0],
            ]);
        }
    }
}
