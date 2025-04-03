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
        'no_sk', 'nip', 'id_jabatan', 'jabatan_l', 'tempat_l', 'tanggal_sk', 'tmt_l', 'tmt_jabatan'
    ];

    public function pegawai()
    {
        return $this->belongsTo(Pegawai::class, 'nip', 'nip');
    }

    public function jabatan()
    {
        return $this->belongsTo(Jabatan::class, 'id_jabatan', 'id_jabatan');
    }
}
