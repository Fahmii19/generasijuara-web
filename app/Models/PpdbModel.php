<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PpdbModel extends Model
{
    use HasFactory;
    protected $table = "ppdb";
    protected $fillable = [
        'id',
        'cabang_id',
        'type',
        'nis',
        'nama',
        'kelamin',
        'nama_ibu',
        'nama_ayah',
        'nik_siswa',
        'nik_ayah',
        'nik_ibu',
        'tempat_lahir',
        'tanggal_lahir',
        'status_dalam_keluarga',
        'anak_ke',
        'alamat_peserta_didik',
        'alamat_domisili',
        'alamat_orang_tua',
        'no_telp_rumah',
        'satuan_pendidikan_asal',
        'agama',
        'pekerjaan_ayah',
        'pekerjaan_ibu',
        'hp_siswa',
        'hp_ayah',
        'hp_ibu',
        'telegram_siswa',
        'telegram_ayah',
        'telegram_ibu',
        'nama_wali',
        'no_telp_wali',
        'alamat_wali',
        'pekerjaan_wali',
        'email',
        'tahun_akademik_id',
        'layanan_kelas_id',
        'paket_kelas_id',
        'tipe_kelas_sebelum',
        'kelas_sebelum',
        'smt_kelas_sebelum',
        'kelas',
        'smt_kelas',
        'lulusan',
        'tahun_lulus',
        'paket_spp_id',
        'dokumen_ktp_orang_tua',
        'dokumen_akta_kelahiran',
        'dokumen_shun_skhun',
        'dokumen_kartu_keluarga',
        'dokumen_ijasah',
        'is_ktp_approved',
        'is_akta_approved',
        'is_shun_skhun_approved',
        'is_kk_approved',
        'is_ijasah_approved',
        'url_bukti_trf',
        'url_bukti_trf2',
        'biaya_daftar',
        'biaya_program',
        'biaya_spp',
        'biaya',
        'peminatan',
        'wakaf',
        'infaq',
        'url_bukti_trf_zakat',
        'kelas_id',
        'is_active',
        'is_approved',
        'created_by',
        'updated_by',
        'nisn',
        'no_induk',
        'user_id',
        'tgl_terima',
        'voucher_code',
        'discount_type',
        'discount',
    ];

    public static function generateNis()
    {
        $prefix = date('Ym');
        $data = self::query()
            ->where('nis', 'like', $prefix.'%')
            ->orderBy('nis','desc')
            ->first();
        $last_no = 1;
        if (!empty($data)) {
            $last_no = (int) str_replace($prefix, "", $data->nis);
            if ($last_no < 1) {
                $last_no = 1;
            }else{
                $last_no++;
            }
        }

        $prefix .= str_pad($last_no, 4, "0", STR_PAD_LEFT);
        // error_log($prefix);
        return $prefix;
    }

    public function user_detail()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }

    public function cabang()
    {
        return $this->hasOne(CabangModel::class, 'id', 'cabang_id');
    }

    public function layanan_kelas()
    {
        return $this->hasOne(LayananKelasModel::class, 'id', 'layanan_kelas_id');
    }

    public function paket_kelas()
    {
        return $this->hasOne(PaketKelasModel::class, 'id', 'paket_kelas_id');
    }

    public function paket_spp()
    {
        return $this->hasOne(PaketSppModel::class, 'id', 'paket_spp_id');
    }

    public function kelas()
    {
        return $this->hasOne(KelasModel::class, 'id', 'kelas_id');
    }

    public function kelas_wb()
    {
        return $this->hasOne(KelasWbModel::class, 'wb_id', 'id');
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
