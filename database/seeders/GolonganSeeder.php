<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class GolonganSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('golongan')->insert([
            ['id_golongan' => '1A', 'jabatan_fungsional' => 'Pengatur Muda', 'pangkat' => 'Juru Muda'],
            ['id_golongan' => '1B', 'jabatan_fungsional' => 'Pengatur Muda Tk. I', 'pangkat' => 'Juru Muda Tk. I'],
            ['id_golongan' => '2A', 'jabatan_fungsional' => 'Pengatur', 'pangkat' => 'Juru'],
            ['id_golongan' => '2B', 'jabatan_fungsional' => 'Pengatur Tk. I', 'pangkat' => 'Juru Tk. I'],
            ['id_golongan' => '3A', 'jabatan_fungsional' => 'Penata Muda', 'pangkat' => 'Penata Muda'],
        ]);
    }
}
