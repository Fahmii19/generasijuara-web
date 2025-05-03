<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NewsModel extends Model
{
    use HasFactory;

    protected $table = "news";
    protected $fillable = [
        'title',
        'content',
        'published_for',
        'is_active',
        'created_by',
        'updated_by',
    ];

    protected $cast = [
        'is_active' => 'boolean',
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
