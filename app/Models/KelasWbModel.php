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

    // Relasi ke kelas (ubah ke belongsTo karena kelas_id adalah foreign key)
    public function kelas_detail()
    {
        return $this->belongsTo(KelasModel::class, 'kelas_id');
    }

    // Relasi ke wb_detail (ubah ke belongsTo karena wb_id adalah foreign key)
    public function wb_detail()
    {
        return $this->belongsTo(PpdbModel::class, 'wb_id');
    }

    // Relasi ke nilai_points
    public function nilai_points()
    {
        return $this->hasMany(NilaiPointModel::class, 'kelas_wb_id')->with('point');
    }

    // Tambahkan relasi ini untuk mengatasi error
    public function catatan_proses_wb()
    {
        return $this->hasMany(CatatanProsesWBModel::class, 'kelas_wb_id');
    }

    // Relasi ke user yang membuat
    public function created_by_detail()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    // Relasi ke user yang mengupdate
    public function updated_by_detail()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }
}
