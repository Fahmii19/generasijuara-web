<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RombelModel extends Model
{
    use HasFactory;
    protected $table = "rombel";
    protected $fillable = [
        'ppdb_id',
        'tahun_akademik_id',
        'kelas_id',
        'status_wb',
        'is_active',
        'keterangan',
    ];

    public function ppdb()
    {
        return $this->hasOne(PpdbModel::class, 'id', 'ppdb_id');
    }

    public function tahun_akademik()
    {
        return $this->hasOne(TahunAkademikModel::class, 'id', 'tahun_akademik_id');
    }

    public function kelas()
    {
        return $this->hasOne(KelasModel::class, 'id', 'kelas_id');
    }
}
