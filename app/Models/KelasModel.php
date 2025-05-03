<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KelasModel extends Model
{
    use HasFactory;
    
    protected $table = "kelas";
    protected $fillable = [
        'layanan_kelas_id',
        'nama',
        'kode',
        'type',
        'biaya',
        'is_active',
        'kelas',
        'semester',
        'tahun_akademik_id',
        'paket_kelas_id',
        'created_by',
        'updated_by',
        'is_lock_nilai',
        'jurusan',
        'jenis_rapor',
    ];

    public function mata_pelajaran()
    {
        return $this->hasMany(KelasMataPelajaranModel::class, 'kelas_id', 'id');
    }
    public function warga_belajar()
    {
        return $this->hasMany(KelasWbModel::class, 'kelas_id', 'id');
    }

    public function layanan_kelas()
    {
        return $this->hasOne(LayananKelasModel::class, 'id', 'layanan_kelas_id');
    }

    public function paket_kelas()
    {
        return $this->hasOne(PaketKelasModel::class, 'id', 'paket_kelas_id');
    }

    public function tahun_akademik()
    {
        return $this->hasOne(TahunAkademikModel::class, 'id', 'tahun_akademik_id');
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
