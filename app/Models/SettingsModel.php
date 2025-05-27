<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SettingsModel extends Model
{
    use HasFactory;
    protected $table = "settings";
    protected $fillable = [
        'key',
        'value',
        'datatype',
    ];

    public static function getByKey($key)
    {
        $setting = self::where('key', $key)->first();
        return !empty($setting) ? $setting->value : null;
    }

    public static function getValue($key, $default = null)
    {
        $setting = self::where('key', $key)->first();
        return $setting ? $setting->value : $default;
    }
}
