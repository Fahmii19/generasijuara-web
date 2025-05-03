<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PerkembanganModel extends Model
{
    use HasFactory;

    protected $table = 'perkembangan';
    protected $fillable = [
        'ppdb_id',
        'kelas_id',
        'kmp_id',
        'laporan',
        'deskripsi'
    ];

    public function ppdb()
    {
        return $this->hasOne(PpdbModel::class, 'id', 'ppdb_id');
    }

    public function kelas()
    {
        return $this->hasOne(KelasModel::class, 'id', 'kelas_id');
    }

    public function kmp()
    {
        return $this->hasOne(KelasMataPelajaranModel::class, 'id', 'kmp_id');
    }
}
