<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kepangkatan extends Model
{
    use HasFactory;

    protected $table = 'kepangkatan';
    protected $primaryKey = 'no_sk';
    public $incrementing = false;
    protected $keyType = 'string';
    protected $fillable = [
        'no_sk', 'nip', 'alasan', 'no_pertimbangan', 'tanggal_sk', 'pembuat_sk', 
        'tmt_sk_pangkat', 'no_usulan', 'jenis_usulan', 'pangkat_l', 'id_golongan'
    ];

    public function pegawai()
    {
        return $this->belongsTo(Pegawai::class, 'nip', 'nip');
    }

    public function golongan()
    {
        return $this->belongsTo(Golongan::class, 'id_golongan', 'id_golongan');
    }
}
