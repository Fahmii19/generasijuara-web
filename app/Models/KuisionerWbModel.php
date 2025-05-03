<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KuisionerWbModel extends Model
{
    use HasFactory;
    protected $table = 'kuisioner_wb';

    public function ppdb()
    {
        return $this->hasOne(PpdbModel::class, 'id', 'ppdb_id');
    }

    public function kuisioner()
    {
        return $this->hasOne(KuisionerModel::class, 'id', 'kuisioner_id');
    }
}
