<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\PointModel;

class NilaiPointModel extends Model
{
    use HasFactory;
    protected $table = "nilai_point";
    protected $fillable = [
        'point_id',
        'kelas_wb_id',
        'point_nilai',
    ];

    public function point()
    {
        return $this->belongsTo(PointModel::class, 'point_id');
    }
}
