<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Hashids\Hashids;

class VoucherModel extends Model
{
    use HasFactory;
    public const TYPE_FIXED = 'fixed_amount';
    public const TYPE_PERCENTAGE = 'percentage';

    protected $table = "voucher";
    protected $fillable = [
        'kode',
        'stok',
        'type',
        'discount',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public static function generateKode()
    {
        $hashids = new Hashids(time(),0,"abcdefghjkmnpqrstuvwxyzABCDEFGHJKLMNPQRSTUVWXYZ23456789");
        return $hashids->encode(1,2,3);
    }
}
