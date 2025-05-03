<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KmpSettingModel extends Model
{
    use HasFactory;
    
    protected $table = "kmp_setting";
    protected $fillable = [
        'kmp_id',
        'persentase_tm',
        'persentase_um',
        'k_persentase_tm',
        'k_persentase_um',
        'jumlah_modul',
        'need_nilai_sikap',
        'skk',
        'kkm',
        'created_by',
        'updated_by',
    ];

    public function kelas_mata_pelajaran()
    {
        return $this->hasOne(LayananKelasModel::class, 'id', 'kmp_id');
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
