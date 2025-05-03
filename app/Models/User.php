<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use App\Models\PpdbModel;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'name',
        'username',
        'email',
        'phone',
        'password',
        'is_active',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public static function getByUsername(string $username)
    {
        $user = self::where('username', $username)->first();

        // if (empty($user)) {
        //     $ppdb = PpdbModel::where('nik_siswa', $username)->first();
        //     if ($ppdb) {
        //         $userPpdb = self::find($ppdb->user_id);
        //         $user = self::where('username', $userPpdb->username)->first();
        //     }
        // }
        // dd($user);
        return $user;
    }

    public static function getByNikSiswa(string $username)
    {
        $user = null;
        
        $ppdb = PpdbModel::where('nik_siswa', $username)->first();
        if ($ppdb) {
            $userPpdb = self::find($ppdb->user_id);
            $user = self::where('username', $userPpdb->username)->first();
        }
        
        return $user;
    }

    public function roles()
    {
        return $this->belongsToMany(RoleModel::class, 'user_role', 'user_id', 'role_id');
    }
}
