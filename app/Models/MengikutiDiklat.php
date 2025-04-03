<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MengikutiDiklat extends Model
{
    use HasFactory;

    protected $table = 'mengikuti_diklat';
    protected $primaryKey = 'no_sttpp';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'no_sttpp', 'nip', 'diklat_id', 'tempat_diklat', 'penyelenggara', 
        'angkatan', 'tanggal_mulai', 'tanggal_selesai', 'jumlah_jam', 'tanggal_sttpp'
    ];

    public function pegawai()
    {
        return $this->belongsTo(Pegawai::class, 'nip', 'nip');
    }

    public function diklat()
    {
        return $this->belongsTo(Diklat::class, 'diklat_id', 'id');
    }
}
