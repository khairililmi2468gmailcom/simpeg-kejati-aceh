<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class KepangkatanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('kepangkatan')->insert([
            [
                'no_sk' => 'SK123456',
                'nip' => '197501012001011001',
                'alasan' => 'Kenaikan pangkat berkala',
                'no_pertimbangan' => 'PERT123',
                'tanggal_sk' => '2023-06-10',
                'pembuat_sk' => 'BKN Jakarta',
                'tmt_sk_pangkat' => '2023-07-01',
                'no_usulan' => 'USUL567',
                'jenis_usulan' => 'Reguler',
                'pangkat_l' => 'Penata Muda',
                'id_golongan' => '3A',
            ],
        ]);
    }
}
