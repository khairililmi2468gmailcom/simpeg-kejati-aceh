<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            ProvinsiSeeder::class,
            KabupatenSeeder::class,
            KecamatanSeeder::class,
            GolonganSeeder::class,
            UnitKerjaSeeder::class,
            JabatanSeeder::class,
            PegawaiSeeder::class,
            KepangkatanSeeder::class,
            CutiSeeder::class,
            MenerimaCutiSeeder::class,
            DiklatSeeder::class,
            MengikutiDiklatSeeder::class,
            MutasiSeeder::class,
        ]);
    }
}
