<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\TahunAkademikModel;

class TahunAkademikSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $startYear = 2019;  // Tahun awal
        $endYear = (int) date('Y');  // Tahun sekarang

        // Looping untuk tahun ajaran dari 2019 hingga tahun sekarang
        for ($year = $startYear; $year <= $endYear; $year++) {
            // Loop untuk semester 1 dan 2
            for ($smt = 1; $smt <= 2; $smt++) {
                $kode = $year . $smt;  // Membuat kode seperti 20191, 20192, dst.
                $nextYear = $year + 1;  // Tahun berikutnya untuk semester
                $tahun_ajar = $year . '/' . $nextYear;  // Format tahun ajaran (misal 2019/2020)

                // Menentukan keterangan dan periode berdasarkan semester
                if ($smt % 2 == 1) {
                    $ket = "Semester Ganjil Tahun Ajaran " . $year . " - " . $nextYear;
                    $periodeStart = $year . '-07-01';  // Tanggal mulai semester ganjil
                    $periodeEnd = $year . '-12-31';    // Tanggal selesai semester ganjil
                } else {
                    $ket = "Semester Genap Tahun Ajaran " . $year . " - " . $nextYear;
                    $periodeStart = ($nextYear) . '-01-01';  // Tanggal mulai semester genap
                    $periodeEnd = ($nextYear) . '-06-30';    // Tanggal selesai semester genap
                }

                // Data yang akan dimasukkan ke tabel tahun_akademik
                $params = [
                    'kode' => $kode,
                    'tahun_ajar' => $tahun_ajar,
                    'keterangan' => $ket,
                    'periode_start' => $periodeStart,  // Tanggal mulai periode
                    'periode_end' => $periodeEnd,      // Tanggal selesai periode
                    'is_active' => true,               // Set is_active ke true, bisa diubah sesuai kebutuhan
                ];

                // Mengecek apakah data dengan kode sudah ada
                $tahunAkademik = TahunAkademikModel::where('kode', $params['kode'])->first();
                if (empty($tahunAkademik)) {
                    // Jika belum ada, maka buat data baru
                    TahunAkademikModel::create($params);
                }
            }
        }
    }
}
