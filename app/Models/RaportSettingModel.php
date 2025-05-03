<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RaportSettingModel extends Model
{
    use HasFactory;

    public const TYPE_PJ_ROMBEL = 'pj_rombel';
    public const TYPE_KETUA_PKBM = 'ketua_pkbm';

    protected $table = 'raport_setting';
    protected $fillable = [
        'kelas_id',
        'nama_ketua_pkbm',
        'nip_ketua_pkbm',
        'url_ttd_ketua',
        'nama_pj_rombel',
        'nip_pj_rombel',
        'url_ttd_pj',
    ];
}
