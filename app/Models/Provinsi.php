<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Provinsi extends Model
{
    use HasFactory;

    protected $table = 'provinsi';
    protected $primaryKey = 'id';
    public $incrementing = false; // Karena ID adalah string (bukan auto-increment)
    protected $keyType = 'string';
    protected $fillable = ['id', 'nama_provinsi'];

    public function pegawai()
    {
        return $this->hasMany(Pegawai::class, 'id_provinsi', 'id');
    }
    
}
