<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MataPelajaranModel extends Model
{
    use HasFactory;
    protected $table = "mata_pelajaran";
    protected $fillable = [
        'nama',
        'kelompok',
        'sub_kelompok',
        'is_mapel_ekskul',
        'is_active',
        'created_by',
        'updated_by',
    ];

    public function created_by_detail()
    {
        return $this->hasOne(User::class, 'id', 'created_by');
    }

    public function updated_by_detail()
    {
        return $this->hasOne(User::class, 'id', 'updated_by');
    }
}
