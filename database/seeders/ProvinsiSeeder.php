<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProvinsiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('provinsi')->delete();
        DB::table('provinsi')->insert([
            ['id' => '11', 'nama_provinsi' => 'Aceh'],
            ['id' => '12', 'nama_provinsi' => 'Sumatera Utara'],
            ['id' => '13', 'nama_provinsi' => 'Sumatera Barat'],
            ['id' => '14', 'nama_provinsi' => 'Riau'],
            ['id' => '15', 'nama_provinsi' => 'Jambi'],
            ['id' => '16', 'nama_provinsi' => 'Sumatera Selatan'],
            ['id' => '17', 'nama_provinsi' => 'Bengkulu'],
            ['id' => '18', 'nama_provinsi' => 'Lampung'],
        ]);
    }
}
