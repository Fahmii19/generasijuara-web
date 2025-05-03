<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\AlumniModel;

class TahunAkademikModel extends Model
{
    use HasFactory;
    protected $table = "tahun_akademik";
    protected $fillable = [
        'kode',
        'tahun_ajar',
        'keterangan',
        'periode_start',
        'periode_end',
        'tgl_cover_raport',
        'tgl_raport',
        'is_active',
    ];

    public function alumni()
    {
        return $this->hasMany(AlumniModel::class, 'tahun_akademik_id');
    }
}
