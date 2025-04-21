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
        DB::table('kecamatan')->delete(); // Ganti truncate() dengan delete()
    
        DB::table('kecamatan')->insert([
            ['id' => '110101', 'nama_kecamatan' => 'Teupah Selatan', 'id_kabupaten' => '1101'],
            ['id' => '110102', 'nama_kecamatan' => 'Simeulue Timur', 'id_kabupaten' => '1101'],
            ['id' => '120101', 'nama_kecamatan' => 'Gunungsitoli', 'id_kabupaten' => '1201'],
            ['id' => '120102', 'nama_kecamatan' => 'Gunungsitoli Selatan', 'id_kabupaten' => '1201'],
        ]);
    }
    
}
