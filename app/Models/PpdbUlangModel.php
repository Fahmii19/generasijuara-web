<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PpdbUlangModel extends Model
{
    use HasFactory;
    protected $table = "ppdb_ulang";
    protected $fillable = [
        'user_id',
        'ppdb_id',
        'type',
        'kelas_sebelum_id',
        'tahun_akademik_id',
        'kelas',
        'semester',
        'peminatan',
        'layanan_kelas_id',
        'paket_kelas_id',
        'paket_spp_id',
        'url_bukti_trf',
        'url_bukti_trf2',
        'biaya_daftar',
        'biaya_spp',
        'biaya',
        'wakaf',
        'infaq',
        'url_bukti_trf_zakat',
        'kelas_id',
        'is_active',
    ];

    public function user_detail()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }

    public function layanan_kelas()
    {
        return $this->hasOne(LayananKelasModel::class, 'id', 'layanan_kelas_id');
    }

    public function paket_kelas()
    {
        return $this->hasOne(PaketKelasModel::class, 'id', 'paket_kelas_id');
    }

    public function paket_spp()
    {
        return $this->hasOne(PaketSppModel::class, 'id', 'paket_spp_id');
    }

    public function kelas_detail()
    {
        return $this->hasOne(KelasModel::class, 'id', 'kelas_id');
    }

    public function ppdb()
    {
        return $this->hasOne(PpdbModel::class, 'id', 'ppdb_id');
    }
}
