<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class PegawaiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('pegawai')->insert([
            [
                'nip' => '197501012001011001',
                'nrp' => '123456',
                'karpeg' => 'KP001',
                'nama' => 'Ahmad Fauzi',
                'tmpt_lahir' => 'Banda Aceh',
                'tgl_lahir' => '1975-01-01',
                'agama' => 'Islam',
                'suku' => 'Aceh',
                'gol_darah' => 'O',
                'j_kelamin' => 'Laki-laki',
                'status' => 'Menikah',
                'j_anak' => 3,
                'id_provinsi' => '11', // Aceh
                'alamat' => 'Jl. Teuku Umar No. 10, Banda Aceh',
                'kode_pos' => '23111',
                'hp' => '08123456789',
                'pendidikan' => 'S2 Hukum',
                'universitas' => 'Universitas Syiah Kuala',
                'jurusan' => 'Ilmu Hukum',
                't_lulus' => '2000',
                'tahun_masuk' => '2001',
                'foto' => 'pegawai_ahmad.jpg',
                'tmt_jabatan' => '2010-06-15',
                'id_golongan' => '1A',
                'kode_kantor' => 'KJ01',
                'id_jabatan' => 1,
                'ket' => 'Jaksa Madya',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nip' => '198205152002011002',
                'nrp' => '654321',
                'karpeg' => 'KP002',
                'nama' => 'Zulfikar Syahputra',
                'tmpt_lahir' => 'Lhokseumawe',
                'tgl_lahir' => '1982-05-15',
                'agama' => 'Islam',
                'suku' => 'Aceh',
                'gol_darah' => 'B',
                'j_kelamin' => 'Laki-laki',
                'status' => 'Menikah',
                'j_anak' => 2,
                'id_provinsi' => '11', // Aceh
                'alamat' => 'Jl. Merdeka No. 23, Lhokseumawe',
                'kode_pos' => '24311',
                'hp' => '085267891234',
                'pendidikan' => 'S2 Hukum',
                'universitas' => 'Universitas Malikussaleh',
                'jurusan' => 'Ilmu Hukum',
                't_lulus' => '2005',
                'tahun_masuk' => '2002',
                'foto' => 'pegawai_zulfikar.jpg',
                'tmt_jabatan' => '2015-08-20',
                'id_golongan' => '2A',
                'kode_kantor' => 'KJ02',
                'id_jabatan' => 2,
                'ket' => 'Jaksa Utama',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}