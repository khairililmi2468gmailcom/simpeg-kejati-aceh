<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mutasi extends Model
{
    use HasFactory;

    protected $table = 'mutasi';
    protected $primaryKey = 'no_sk';
    public $incrementing = false;
    protected $keyType = 'string';
    protected $fillable = [
        'no_sk', 'nip', 'id_jabatan', 'jabatan_l', 'tempat_l', 'tanggal_sk', 'tmt_l', 'tmt_jabatan', 'nomor_sk'
    ];

    public function pegawai()
    {
        return $this->belongsTo(Pegawai::class, 'nip', 'nip');
    }

    public function jabatan()
    {
        return $this->belongsTo(Jabatan::class, 'id_jabatan', 'id_jabatan');
    }
    public function unitKerja()
    {
        return $this->hasOneThrough(UnitKerja::class, Jabatan::class, 'kode_kantor', 'kode_kantor', 'id_jabatan', 'kode_kantor');
    }
    public function golonganPegawai()
    {
        return $this->hasOneThrough(
            \App\Models\Golongan::class,
            \App\Models\Pegawai::class,
            'nip',          // Foreign key on Pegawai
            'id_golongan',  // Foreign key on Golongan
            'nip',          // Local key on Mutasi
            'id_golongan'   // Local key on Pegawai
        );
    }
    
}
