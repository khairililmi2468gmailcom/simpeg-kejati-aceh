<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KepalaKejaksaan extends Model
{
    use HasFactory;

    protected $table = 'kepala_kejaksaan';

    protected $fillable = [
        'nama',
        'nip',
    ];
}