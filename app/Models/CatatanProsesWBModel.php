<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CatatanProsesWBModel extends Model
{
    use HasFactory;
    protected $table = "catatan_proses_wb";
    protected $fillable = [
        'dimensi_id',
        'kelas_wb_id',
        'catatan_proses',
    ];
}
