<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\ElemenModel;

class DimensiModel extends Model
{
    use HasFactory;

    protected $table = 'dimensi';

    protected $fillable = [
        'dimensi_name',
        'updated_at',
        'created_at',
    ];

    public function elemens()
    {
        return $this->hasMany(ElemenModel::class, 'dimensi_id');
    }
}
