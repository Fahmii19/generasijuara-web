<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\AssesmentModel;
use App\Models\SubsectionPointModel;

class ElemenModel extends Model
{
    use HasFactory;

    protected $table = 'elemen';

    protected $fillable = [
        'dimensi_id',
        'elemen_name',
    ];

    public function dimensi()
    {
        return $this->belongsTo(DimensiModel::class, 'dimensi_id');
    }

    public function points()
    {
        return $this->hasMany(PointModel::class, 'elemen_id');
    }
}
