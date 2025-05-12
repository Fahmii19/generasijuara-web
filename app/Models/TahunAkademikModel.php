<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\AlumniModel;

class TahunAkademikModel extends Model
{
    use HasFactory;
    public $timestamps = true;
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
        'is_generate_rombel',
    ];

    public function alumni()
    {
        return $this->hasMany(AlumniModel::class, 'tahun_akademik_id');
    }
    // Relasi ke tabel ppdb
    public function ppdb()
    {
        return $this->hasMany(PpdbModel::class, 'tahun_akademik_id');
    }

    public static function getActive()
    {
        return self::where('is_active', true)->first();
    }
}
