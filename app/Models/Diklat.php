<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Diklat extends Model
{
    use HasFactory;

    protected $table = 'diklat';

    protected $fillable = ['nama_diklat', 'jenis_diklat'];

    public function pesertaDiklat()
    {
        return $this->hasMany(MengikutiDiklat::class, 'diklat_id', 'id');
    }
}
