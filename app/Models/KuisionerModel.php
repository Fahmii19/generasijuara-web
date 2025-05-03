<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KuisionerModel extends Model
{
    use HasFactory;
    protected $table = 'kuisioner';

    protected $fillable = [
        'tahun_akademik_id',
        'is_published'
    ];

    
    public function tahun_akademik()
    {
        return $this->hasOne(TahunAkademikModel::class, 'id', 'tahun_akademik_id');
    }

    public function items()
    {
        return $this->hasMany(KuisionerItemsModel::class, 'kuisioner_id', 'id');
    }

    public function wb()
    {
        return $this->hasMany(KuisionerWbModel::class, 'kuisioner_id', 'id');
    }
}
