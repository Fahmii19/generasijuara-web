<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaketKelasModel extends Model
{
    use HasFactory;
    protected $table = "paket_kelas";
    protected $fillable = [
        'nama',
        'kode',
        'is_active',
        'type',
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
