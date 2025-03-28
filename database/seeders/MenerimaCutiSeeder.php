<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MenerimaCutiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('menerima_cuti')->insert([
            [
                'no_surat' => 'CT001',
                'nip' => '197501012001011001',
                'cuti_id' => 1, // Cuti Tahunan
                'tanggal_mulai' => '2024-06-01',
                'tanggal_selesai' => '2024-06-10',
                'jumlah_cuti' => 10,
                'keterangan' => 'Cuti tahunan untuk liburan keluarga',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'no_surat' => 'CT002',
                'nip' => '198205152002011002',
                'cuti_id' => 3, // Cuti Melahirkan
                'tanggal_mulai' => '2024-07-01',
                'tanggal_selesai' => '2024-09-30',
                'jumlah_cuti' => 90,
                'keterangan' => 'Cuti melahirkan',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
