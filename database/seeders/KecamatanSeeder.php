<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class KecamatanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('kecamatan')->truncate();

        DB::table('kecamatan')->insert([
            ['id' => '1101010', 'nama_kecamatan' => 'Teupah Selatan', 'id_kabupaten' => '1101'],
            ['id' => '1101020', 'nama_kecamatan' => 'Simeulue Timur', 'id_kabupaten' => '1101'],
            ['id' => '1201010', 'nama_kecamatan' => 'Gunungsitoli', 'id_kabupaten' => '1201'],
            ['id' => '1201020', 'nama_kecamatan' => 'Gunungsitoli Selatan', 'id_kabupaten' => '1201'],
        ]);
    }
}
