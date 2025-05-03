<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KuisionerItemsModel extends Model
{
    use HasFactory;
    protected $table = 'kuisioner_items';

    public function kuisioner()
    {
        return $this->hasOne(KuisionerModel::class, 'id', 'kuisioner_id');
    }

    public function kuisioner_respon()
    {
        return $this->hasMany(KuisionerResponModel::class, 'kuisioner_items_id', 'id');
    }
}
