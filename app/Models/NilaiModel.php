<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NilaiModel extends Model
{
    use HasFactory;
    protected $table = "nilai";
    protected $fillable = [
        'kelas_id',
        'kmp_id',
        'wb_id',
        'p_tugas_1',
        'p_ujian_1',
        'p_nilai_1',
        'p_predikat_1',
        'k_nilai_1',
        'k_predikat_1',
        'p_tugas_2',
        'p_ujian_2',
        'p_nilai_2',
        'p_predikat_2',
        'k_nilai_2',
        'k_predikat_2',
        'p_tugas_3',
        'p_ujian_3',
        'p_nilai_3',
        'p_predikat_3',
        'k_nilai_3',
        'k_predikat_3',
        'sikap_spiritual',
        'sikap_spiritual_desc',
        'sikap_sosial',
        'sikap_sosial_desc',
        'capaian_kompetensi',
        'susulan_remedial',
        'p_susulan_1',
        'p_susulan_2',
        'p_susulan_3',
        'k_susulan_1',
        'k_susulan_2',
        'k_susulan_3',
        'p_remedial_1',
        'p_remedial_2',
        'p_remedial_3',
        'k_remedial_1',
        'k_remedial_2',
        'k_remedial_3',
        'created_by',
        'updated_by',
    ];

    public function kelas()
    {
        return $this->hasOne(KelasModel::class, 'id', 'kelas_id');
    }

    public function kmp()
    {
        return $this->hasOne(KelasMataPelajaranModel::class, 'id', 'kmp_id');
    }

    public function wb()
    {
        return $this->hasOne(PpdbModel::class, 'id', 'wb_id');
    }

    public function items()
    {
        return $this->hasOne(NilaiItemsModel::class, 'nilai_id', 'id');
    }
}
