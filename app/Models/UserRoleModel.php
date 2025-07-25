<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserRoleModel extends Model
{
    use HasFactory;
    protected $table = 'user_role';
    protected $fillable = [
        'user_id',
        'role_id',
    ];
}
