<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CabangModel extends Model
{
    use HasFactory;
    protected $table = "cabang";
    protected $fillable = [
        'nama_cabang',
    ];
}
