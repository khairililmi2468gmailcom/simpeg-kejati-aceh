<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UnitKerjaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('unit_kerja')->insert([
            ['kode_kantor' => 'KJ01', 'nama_kantor' => 'Kejaksaan Negeri Banda Aceh', 'id_provinsi' => '11', 'created_at' => now(), 'updated_at' => now()],
            ['kode_kantor' => 'KJ02', 'nama_kantor' => 'Kejaksaan Negeri Lhokseumawe', 'id_provinsi' => '11', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}
