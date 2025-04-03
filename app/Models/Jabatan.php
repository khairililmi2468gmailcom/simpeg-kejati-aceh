<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Jabatan extends Model
{
    use HasFactory;

    protected $table = 'jabatan';
    protected $primaryKey = 'id_jabatan';
    public $incrementing = true;
    protected $fillable = ['nama_jabatan', 'ket', 'kode_kantor'];

    public function unitKerja()
    {
        return $this->belongsTo(UnitKerja::class, 'kode_kantor', 'kode_kantor');
    }
}
