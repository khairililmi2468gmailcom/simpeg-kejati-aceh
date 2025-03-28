<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CutiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('cuti')->insert([
            ['jenis_cuti' => 'Cuti Tahunan', 'created_at' => now(), 'updated_at' => now()],
            ['jenis_cuti' => 'Cuti Sakit', 'created_at' => now(), 'updated_at' => now()],
            ['jenis_cuti' => 'Cuti Melahirkan', 'created_at' => now(), 'updated_at' => now()],
            ['jenis_cuti' => 'Cuti Besar', 'created_at' => now(), 'updated_at' => now()],
            ['jenis_cuti' => 'Cuti Alasan Penting', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}
