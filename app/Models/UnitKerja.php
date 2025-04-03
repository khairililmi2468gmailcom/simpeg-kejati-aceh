<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UnitKerja extends Model
{
    use HasFactory;

    protected $table = 'unit_kerja';
    protected $primaryKey = 'kode_kantor';
    public $incrementing = false;
    protected $keyType = 'string';
    protected $fillable = ['kode_kantor', 'nama_kantor', 'provinsi'];

    public function jabatans()
    {
        return $this->hasMany(Jabatan::class, 'kode_kantor', 'kode_kantor');
    }
}
