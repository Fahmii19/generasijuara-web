<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PpdbModel extends Model
{
    use HasFactory;

    // Nama tabel
    protected $table = 'ppdb';

    // Menentukan kolom-kolom yang bisa diisi
    protected $fillable = [
        'nis',
        'nisn',
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
    ];

    // Menghubungkan model dengan tabel terkait lainnya (misalnya relasi)
    public function tahunAkademik()
    {
        return $this->belongsTo(TahunAkademikModel::class, 'tahun_akademik_id');
    }

    public function layananKelas()
    {
        return $this->belongsTo(LayananKelasModel::class, 'layanan_kelas_id');
    }

    public function paketKelas()
    {
        return $this->belongsTo(PaketKelasModel::class, 'paket_kelas_id');
    }

    public function paketSpp()
    {
        return $this->belongsTo(PaketSppModel::class, 'paket_spp_id');
    }

    // Jika ada relasi atau function lain, bisa ditambahkan disini
}
