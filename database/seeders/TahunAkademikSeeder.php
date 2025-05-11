<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\TahunAkademikModel;
use Carbon\Carbon;

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
        $now = Carbon::now();

        // Looping untuk tahun ajaran dari 2019 hingga tahun sekarang
        for ($year = $startYear; $year <= $endYear; $year++) {
            // Loop untuk semester 1 dan 2
            for ($smt = 1; $smt <= 2; $smt++) {
                $kode = $year . $smt;  // Membuat kode seperti 20191, 20192, dst.
                $nextYear = $year + 1;  // Tahun berikutnya untuk semester
                $tahun_ajar = $year . '/' . $nextYear;  // Format tahun ajaran (misal 2019/2020)

                // Menentukan keterangan dan periode berdasarkan semester
                if ($smt == 1) {
                    $ket = "Semester Ganjil Tahun Ajaran " . $tahun_ajar;
                    $periodeStart = $year . '-07-01';
                    $periodeEnd = $year . '-12-31';
                    // Tanggal rapor semester ganjil (misal akhir Januari)
                    $tgl_raport = ($year + 1) . '-01-31';
                    $tgl_cover_raport = ($year + 1) . '-01-31';
                } else {
                    $ket = "Semester Genap Tahun Ajaran " . $tahun_ajar;
                    $periodeStart = $nextYear . '-01-01';
                    $periodeEnd = $nextYear . '-06-30';
                    // Tanggal rapor semester genap (misal akhir Juni)
                    $tgl_raport = $nextYear . '-06-30';
                    $tgl_cover_raport = $nextYear . '-06-30';
                }

                // Data yang akan dimasukkan ke tabel tahun_akademik
                $params = [
                    'kode' => $kode,
                    'tahun_ajar' => $tahun_ajar,
                    'keterangan' => $ket,
                    'periode_start' => $periodeStart,
                    'periode_end' => $periodeEnd,
                    'tgl_raport' => $tgl_raport,
                    'tgl_cover_raport' => $tgl_cover_raport,
                    'is_active' => ($year == $endYear && $smt == 2), // Aktifkan hanya semester genap tahun terakhir
                    'is_generate_rombel' => false,
                    'created_at' => $now,
                    'updated_at' => $now,
                ];

                // Mengecek apakah data dengan kode sudah ada
                $tahunAkademik = TahunAkademikModel::where('kode', $kode)->first();
                if (!$tahunAkademik) {
                    TahunAkademikModel::create($params);
                } else {
                    // Update data yang sudah ada jika diperlukan
                    $tahunAkademik->update($params);
                }
            }
        }
    }
}
