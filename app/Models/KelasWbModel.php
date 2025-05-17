<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KelasWbModel extends Model
{
    use HasFactory;
    protected $table = "kelas_wb";
    protected $fillable = [
        'kelas_id',
        'wb_id',
        'catatan_pj_rombel',
        'tanggapan_wali',
        'catatan',
        'catatan_perkembangan_profil_pelajar',
        'catatan_perkembangan_pemberdayaan',
        'catatan_perkembangan_keterampilan',
        'izin',
        'sakit',
        'alpa',
        'is_active',
        'created_by',
        'updated_by',
    ];

    public function kelas_detail()
    {
        return $this->hasOne(KelasModel::class, 'id', 'kelas_id');
    }

    public function wb_detail()
    {
        return $this->hasOne(PpdbModel::class, 'id', 'wb_id');
    }

    public function nilai_points()
    {
        return $this->hasMany(NilaiPointModel::class, 'kelas_wb_id');
    }

    // relasin ke tabel point
    public function point()
    {
        return $this->hasMany(PointModel::class, 'id', 'point_id');
    }

    public function created_by_detail()
    {
        return $this->hasOne(User::class, 'id', 'created_by');
    }

    public function updated_by_detail()
    {
        return $this->hasOne(User::class, 'id', 'updated_by');
    }
}
