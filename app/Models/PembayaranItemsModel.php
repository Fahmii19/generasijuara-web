<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PembayaranItemsModel extends Model
{
    use HasFactory;

    protected $table = "pembayaran_items";
    protected $fillable = [
        'pembayaran_id',
        'item',
        'nominal',
    ];

    public function pembayaran()
    {
        return $this->hasOne(PembayaranModel::class, 'id', 'pembayaran_id');
    }
}
