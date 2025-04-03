<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Golongan extends Model
{
    use HasFactory;

    protected $table = 'golongan';
    protected $primaryKey = 'id_golongan';
    public $incrementing = false;
    protected $keyType = 'string';
    protected $fillable = ['id_golongan', 'jabatan_fungsional', 'pangkat'];

    public function kepangkatans()
    {
        return $this->hasMany(Kepangkatan::class, 'id_golongan', 'id_golongan');
    }

    public function pegawais()
    {
        return $this->hasMany(Pegawai::class, 'id_golongan', 'id_golongan');
    }
}
