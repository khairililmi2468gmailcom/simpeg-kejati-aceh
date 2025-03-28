<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MengikutiDiklatSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('mengikuti_diklat')->insert([
            [
                'no_sttpp' => 'STTPP-2024-001',
                'nip' => '197501012001011001',
                'diklat_id' => 1,
                'tempat_diklat' => 'Banda Aceh',
                'penyelenggara' => 'Kejaksaan Agung',
                'angkatan' => 'XII',
                'tanggal_mulai' => '2024-01-10',
                'tanggal_selesai' => '2024-01-20',
                'jumlah_jam' => 40,
                'tanggal_sttpp' => '2024-01-22',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
