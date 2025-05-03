<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NilaiKegiatanModel extends Model
{
    use HasFactory;

    protected $table = "nilai_kegiatan";
    protected $fillable = [
        'kwb_id',
        'jenis_kegiatan',
        'prestasi',
        'created_by',
        'updated_by',
    ];

    public function kwb_detail()
    {
        return $this->hasOne(KelasWbModel::class, 'id', 'kwb_id');
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
