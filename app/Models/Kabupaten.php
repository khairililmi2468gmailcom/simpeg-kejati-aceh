<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kabupaten extends Model
{
    use HasFactory;

    protected $table = 'kabupaten';
    protected $primaryKey = 'id';
    public $incrementing = false;
    protected $keyType = 'string';
    protected $fillable = ['id', 'nama_kabupaten', 'id_provinsi'];

    public function provinsi()
    {
        return $this->belongsTo(Provinsi::class, 'id_provinsi', 'id');
    }

    public function kecamatan()
    {
        return $this->hasMany(Kecamatan::class, 'id_kabupaten', 'id');
    }

    public function pegawai()
    {
        return $this->hasMany(Pegawai::class, 'id_kabupaten', 'id');
    }
}
