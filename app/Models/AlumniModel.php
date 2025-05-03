<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\TahunAkademikModel;

class AlumniModel extends Model
{
    use HasFactory;

    protected $table = "alumni";
    protected $fillable = [
        'nis',
        'nisn',
        'email',
        'jenis_kelamin',
        'nama',
        'no_hp',
        'paket',
        'tahun_akademik_id',
        'lanjut_kuliah',
        'nama_sekolah',
        'surat_penerimaan',
        'prodi',
        'usaha',
        'sertifikat',
    ];

    public function tahunAkademik()
    {
        return $this->belongsTo(TahunAkademikModel::class, 'tahun_akademik_id');
    }
}
