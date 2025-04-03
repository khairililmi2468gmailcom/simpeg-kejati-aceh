<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pegawai extends Model
{
    use HasFactory;

    protected $table = 'pegawai';
    protected $primaryKey = 'nip';
    public $incrementing = false;
    protected $keyType = 'string';
    protected $fillable = [
        'nip', 'nrp', 'karpeg', 'nama', 'tmpt_lahir', 'tgl_lahir', 'agama', 'suku', 'gol_darah', 'j_kelamin', 
        'status', 'j_anak', 'id_provinsi', 'id_kabupaten', 'id_kecamatan', 'alamat', 'kode_pos', 'hp', 
        'pendidikan', 'universitas', 'jurusan', 't_lulus', 'tahun_masuk', 'foto', 'tmt_jabatan', 
        'id_golongan', 'kode_kantor', 'id_jabatan', 'ket'
    ];

    public function provinsi()
    {
        return $this->belongsTo(Provinsi::class, 'id_provinsi', 'id');
    }

    public function kabupaten()
    {
        return $this->belongsTo(Kabupaten::class, 'id_kabupaten', 'id');
    }

    public function kecamatan()
    {
        return $this->belongsTo(Kecamatan::class, 'id_kecamatan', 'id');
    }

    public function golongan()
    {
        return $this->belongsTo(Golongan::class, 'id_golongan', 'id_golongan');
    }

    public function unitKerja()
    {
        return $this->belongsTo(UnitKerja::class, 'kode_kantor', 'kode_kantor');
    }

    public function jabatan()
    {
        return $this->belongsTo(Jabatan::class, 'id_jabatan', 'id_jabatan');
    }
}
