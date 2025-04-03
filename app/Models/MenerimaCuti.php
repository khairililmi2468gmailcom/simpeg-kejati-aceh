<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MenerimaCuti extends Model
{
    use HasFactory;

    protected $table = 'menerima_cuti';
    protected $primaryKey = 'no_surat';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'no_surat', 'nip', 'cuti_id', 'tanggal_mulai', 'tanggal_selesai', 'jumlah_cuti', 'keterangan'
    ];

    public function pegawai()
    {
        return $this->belongsTo(Pegawai::class, 'nip', 'nip');
    }

    public function cuti()
    {
        return $this->belongsTo(Cuti::class, 'cuti_id', 'id');
    }
}
