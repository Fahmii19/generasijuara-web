<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TutorModel extends Model
{
    use HasFactory;
    protected $table = "tutor";
    protected $fillable = [
        'nip',
        'user_id',
        'created_by',
        'updated_by',
    ];

    public function user_detail()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
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
