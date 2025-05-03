<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KuisionerResponModel extends Model
{
    use HasFactory;
    protected $table = 'kuisioner_respon';
    protected $fillable = [
        'kuisioner_wb_id',
        'kuisioner_item_id',
        'value',
    ];

    public function kuisioner_item()
    {
        return $this->hasOne(KuisionerItemsModel::class, 'id', 'kuisioner_item_id');
    }

    public function wb()
    {
        return $this->hasOne(KuisionerWbModel::class, 'id', 'kuisioner_wb_id');
    }
}
