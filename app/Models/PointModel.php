<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\ElemenModel;
use App\Models\NilaiPointModel;

class PointModel extends Model
{
    use HasFactory;

    protected $table = 'point';

    protected $fillable = [
        'elemen_id',
        'point_name',
        'fase'
    ];

    public function elemen()
    {
        return $this->belongsTo(ElemenModel::class, 'elemen_id');
    }

    public function nilai_points()
    {
        return $this->hasMany(NilaiPointModel::class, 'point_id');
    }
}
