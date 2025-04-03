<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cuti extends Model
{
    use HasFactory;

    protected $table = 'cuti';

    protected $fillable = ['jenis_cuti'];

    public function penerimaCuti()
    {
        return $this->hasMany(MenerimaCuti::class, 'cuti_id', 'id');
    }
}
