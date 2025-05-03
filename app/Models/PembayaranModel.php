<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PembayaranModel extends Model
{
    use HasFactory;

    public const TYPE = ['pendaftaran_baru', 'pendaftaran_ulang', 'pendaftaran_alumni'];
    public const TYPE_BARU = 'pendaftaran_baru';
    public const TYPE_ULANG = 'pendaftaran_ulang';
    public const TYPE_ALUMNI = 'pendaftaran_alumni';

    public const SOURCE_TABLE = ['ppdb'];

    protected $table = "pembayaran";
    protected $fillable = [
        'type',
        'keterangan',
        'bank_name',
        'bank_account_number',
        'bank_account_name',
        'source_table',
        'source_id',
        'nominal',
        'tagihan',
        'voucher_id',
        'total_tagihan',
        'note',
        'url_bukti_trf',
        'url_bukti_trf_infaq',
        'is_paid',
        'is_approved',
        'tagihan_id',
    ];

    protected $cast = [
        'is_paid' => 'boolean',
        'is_approved' => 'boolean',
    ];

    public function items()
    {
        return $this->hasMany(PembayaranItemsModel::class, 'pembayaran_id', 'id');
    }

    public function ppdb()
    {
        return $this->hasOne(PpdbModel::class, 'id', 'source_id');
    }

    public function voucher()
    {
        return $this->hasMany(VoucherModel::class, 'id', 'voucher_id');
    }
    
    public function tagihan()
    {
        return $this->hasOne(TagihanModel::class, 'id', 'tagihan_id');
    }
}
