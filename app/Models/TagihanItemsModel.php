<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TagihanItemsModel extends Model
{
    use HasFactory;
    protected $table = "tagihan_items";
    protected $fillable = [
        'tagihan_id',
        'nominal',
        'item',
    ];

    public function tagihan()
    {
        return $this->hasOne(TagihanModel::class, 'id', 'tagihan_id');
    }
}
