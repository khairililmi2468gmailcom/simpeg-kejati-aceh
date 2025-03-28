<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DiklatSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('diklat')->insert([
            ['nama_diklat' => 'Diklat Teknis Peradilan', 'jenis_diklat' => 'Teknis', 'created_at' => now(), 'updated_at' => now()],
            ['nama_diklat' => 'Diklat Manajemen Kejaksaan', 'jenis_diklat' => 'Manajemen', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}
