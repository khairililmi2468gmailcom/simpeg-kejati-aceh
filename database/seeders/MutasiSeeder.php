<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MutasiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('mutasi')->insert([
            ['no_sk' => 'SK001', 'nip' => '197501012001011001', 'id_jabatan' => 2, 'jabatan_l' => 'Jaksa Madya', 'tempat_l' => 'Kejaksaan Negeri Banda Aceh', 'tanggal_sk' => '2020-01-15', 'tmt_l' => '2020-02-01', 'tmt_jabatan' => '2020-02-10', 'created_at' => now(), 'updated_at' => now()],
            ['no_sk' => 'SK002', 'nip' => '198205152002011002', 'id_jabatan' => 1, 'jabatan_l' => 'Jaksa Utama', 'tempat_l' => 'Kejaksaan Negeri Lhokseumawe', 'tanggal_sk' => '2021-03-10', 'tmt_l' => '2021-04-01', 'tmt_jabatan' => '2021-04-15', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}
