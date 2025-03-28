<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kabupaten extends Model
{
    use HasFactory;

    protected $table = 'kabupaten';
    protected $primaryKey = 'id';
    public $incrementing = false; // Karena ID adalah string (4 karakter)
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
}
