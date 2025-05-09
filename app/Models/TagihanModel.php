<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TagihanModel extends Model
{
    public const STATUS_LUNAS = 'lunas';
    public const STATUS_LUNAS_SEBAGIAN = 'lunas sebagian';
    public const BELUM_LUNAS = 'belum lunas';
    public const BELUM_DIKONFIRMASI = 'belum dikonfirmasi';

    public const TYPE_DAFTAR_BARU = 'pendaftaran_baru';
    public const TYPE_DAFTAR_ULANG = 'pendaftaran_ulang';
    public const TYPE_SUSULAN_REMEDIAL = 'susulan_remedial';

    use HasFactory;
    protected $table = "tagihan";
    protected $fillable = [
        'type',
        'keterangan',
        'source_table',
        'source_id',
        'ppdb_id',
        'tagihan',
        'voucher_id',
        'total_tagihan',
        'nominal',
        'status',
    ];
    
    public function ppdb()
    {
        return $this->hasOne(PpdbModel::class, 'id', 'ppdb_id');
    }

    public function pembayaran()
    {
        return $this->hasOne(PembayaranModel::class, 'tagihan_id', 'id');
    }

    public function items()
    {
        return $this->hasMany(TagihanItemsModel::class, 'tagihan_id', 'id');
    }

    public function voucher()
    {
        return $this->hasOne(VoucherModel::class, 'id', 'voucher_id');
    }
}
