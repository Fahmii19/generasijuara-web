<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DistribusiMapelModel extends Model
{
    use HasFactory;
    protected $table = "distribusi_mapel";
    protected $fillable = [
        'mapel_id',
        'tutor_id',
        'kelas_num',
    ];

    public function mata_pelajaran()
    {
        return $this->hasOne(MataPelajaranModel::class, 'id', 'mapel_id');
    }

    public function tutor()
    {
        return $this->hasOne(TutorModel::class, 'id', 'tutor_id');
    }
}
