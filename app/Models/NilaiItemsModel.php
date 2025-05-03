<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NilaiItemsModel extends Model
{
    use HasFactory;
    protected $table = "nilai_items";
    protected $fillable = [
        'nilai_id',
        'p_susulan_tugas_1',
        'p_susulan_tugas_2',
        'p_susulan_tugas_3',
        'k_susulan_tugas_1',
        'k_susulan_tugas_2',
        'k_susulan_tugas_3',
        'p_susulan_ujian_1',
        'p_susulan_ujian_2',
        'p_susulan_ujian_3',
        'k_susulan_ujian_1',
        'k_susulan_ujian_2',
        'k_susulan_ujian_3',
        'p_remedial_tugas_1',
        'p_remedial_tugas_2',
        'p_remedial_tugas_3',
        'k_remedial_tugas_1',
        'k_remedial_tugas_2',
        'k_remedial_tugas_3',
        'p_remedial_ujian_1',
        'p_remedial_ujian_2',
        'p_remedial_ujian_3',
        'k_remedial_ujian_1',
        'k_remedial_ujian_2',
        'k_remedial_ujian_3',
    ];

    public function nilai()
    {
        return $this->hasOne(NilaiModel::class, 'id', 'nilai_id');
    }
}
