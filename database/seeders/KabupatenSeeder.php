<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class KabupatenSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('kabupaten')->delete();
        DB::table('kabupaten')->insert([
            ['id' => '1101', 'nama_kabupaten' => 'Kabupaten Simeulue', 'id_provinsi' => '11'],
            ['id' => '1102', 'nama_kabupaten' => 'Kabupaten Aceh Singkil', 'id_provinsi' => '11'],
            ['id' => '1201', 'nama_kabupaten' => 'Kabupaten Nias', 'id_provinsi' => '12'],
            ['id' => '1202', 'nama_kabupaten' => 'Kabupaten Mandailing Natal', 'id_provinsi' => '12'],
        ]);
    }
}
