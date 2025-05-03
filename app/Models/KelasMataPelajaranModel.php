<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KelasMataPelajaranModel extends Model
{
    use HasFactory;
    protected $table = "kelas_mata_pelajaran";
    protected $fillable = [
        'kelas_id',
        'mata_pelajaran_id',
        'tutor_id',
        'created_by',
        'updated_by',
    ];

    public function kelas_detail()
    {
        return $this->hasOne(KelasModel::class, 'id', 'kelas_id');
    }

    public function mata_pelajaran_detail()
    {
        return $this->hasOne(MataPelajaranModel::class, 'id', 'mata_pelajaran_id');
    }

    public function tutor_detail()
    {
        return $this->hasOne(TutorModel::class, 'id', 'tutor_id');
    }

    public function kmp_setting()
    {
        return $this->hasOne(KmpSettingModel::class, 'kmp_id', 'id');
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
