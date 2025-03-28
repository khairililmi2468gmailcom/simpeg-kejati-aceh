<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class JabatanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('jabatan')->insert([
            ['id_jabatan' => 1, 'nama_jabatan' => 'Jaksa Madya', 'ket' => 'Bertanggung jawab atas kasus menengah', 'kode_kantor' => 'KJ01', 'created_at' => now(), 'updated_at' => now()],
            ['id_jabatan' => 2, 'nama_jabatan' => 'Jaksa Utama', 'ket' => 'Bertanggung jawab atas kasus berat', 'kode_kantor' => 'KJ02', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}
