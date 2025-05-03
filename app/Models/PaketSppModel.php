<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaketSppModel extends Model
{
    use HasFactory;
    protected $table = "paket_spp";
    protected $fillable = [
        'layanan_kelas_id',
        'paket_kelas_id',
        'cabang_id',
        'semester',
        'semester_khusus',
        'kelas',
        'biaya',
        'biaya_program',
        'biaya_pendaftaran',
        'jenis_pendaftaran',
        'keterangan',
        'is_active',
        'biaya_kk',
        'selected_kk',
        'jumlah_smt_kk',
        'type',
        'created_by',
        'updated_by',
    ];

    protected $cast = [
        'is_active' => 'boolean',
    ];

    public function layanan_kelas_detail()
    {
        return $this->hasOne(LayananKelasModel::class, 'id', 'layanan_kelas_id');
    }

    public function paket_kelas_detail()
    {
        return $this->hasOne(PaketKelasModel::class, 'id', 'paket_kelas_id');
    }

    public function created_by_detail()
    {
        return $this->hasOne(User::class, 'id', 'created_by');
    }

    public function updated_by_detail()
    {
        return $this->hasOne(User::class, 'id', 'updated_by');
    }

    public function cabang()
    {
        return $this->hasOne(CabangModel::class, 'id', 'cabang_id');
    }
}
