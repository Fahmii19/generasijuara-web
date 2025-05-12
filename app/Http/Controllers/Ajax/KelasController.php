<?php

namespace App\Http\Controllers\Ajax;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\KelasModel;
use App\Models\LayananKelasModel;
use App\Models\PpdbModel;
use App\Models\PaketKelasModel;
use App\Models\TahunAkademikModel;
use App\Models\UserRoleModel;
use App\Models\User;
use App\Models\KmpSettingModel;
use App\Models\KelasMataPelajaranModel;
use App\Models\KelasWbModel;
use App\Models\RombelModel;
use App\Models\CabangModel;
use DB;
use Excel;
use Log;
use Carbon\Carbon;
use App\Utils\Constant;
use App\Models\TutorModel;


class KelasController extends Controller
{


    public function importRombelExcel(Request $request)
    {

        if (!$request->hasFile('import_file')) {
            return response()->json([
                'error' => true,
                'message' => 'File tidak ditemukan'
            ], 400);
        }

        $data = Excel::toArray([], $request->file('import_file'));

        DB::beginTransaction();
        try {
            $tahunAjar = '';

            foreach ($data[0] as $key => $row) {
                // Skip empty rows
                if (empty(array_filter($row))) {
                    continue;
                }

                // Get academic year from header
                if (isset($row[0]) && $row[0] == 'Tahun Ajaran') {
                    $tahunAjar = $row[2]; // Get Tahun Ajaran
                    continue;
                }

                // Skip header rows
                if ($key < 3) {
                    continue;
                }

                // Extract all fields from the row
                $tempIndex = 0;
                $no = $row[$tempIndex++] ?? null;
                $kode_kelas_ini = $row[$tempIndex++] ?? null;
                $kelas_sebelum = $row[$tempIndex++] ?? null;
                $nis = $row[$tempIndex++] ?? null;
                $nisn = $row[$tempIndex++] ?? null;
                $nama = $row[$tempIndex++] ?? null;
                $status_diverbal = $row[$tempIndex++] ?? null;
                $status_rombel_dapodik = $row[$tempIndex++] ?? null;
                $status_daftar_dapodik = $row[$tempIndex++] ?? null;
                $status_kartu_pelajar = $row[$tempIndex++] ?? null;
                $catatan_admin = $row[$tempIndex++] ?? null;
                $status_wb = $row[$tempIndex++] ?? null;
                $link_yandex = $row[$tempIndex++] ?? null;
                $status_elcta = $row[$tempIndex++] ?? null;
                $tgl_buat_akun = $row[$tempIndex++] ?? null;
                $username_electa = $row[$tempIndex++] ?? null;
                $email_ortu = $row[$tempIndex++] ?? null;
                $username_ms_team = $row[$tempIndex++] ?? null;
                $cabang_genju = $row[$tempIndex++] ?? null;
                $hp_ayah = $row[$tempIndex++] ?? null;
                $hp_ibu = $row[$tempIndex++] ?? null;
                $tempat_lahir = $row[$tempIndex++] ?? null;
                $tgl_lahir = $row[$tempIndex++] ?? null;
                $usia = $row[$tempIndex++] ?? null;
                $hobi = $row[$tempIndex++] ?? null;
                $cita2 = $row[$tempIndex++] ?? null;
                $tb = $row[$tempIndex++] ?? null;
                $bb = $row[$tempIndex++] ?? null;
                $jarak = $row[$tempIndex++] ?? null;
                $gender = $row[$tempIndex++] ?? null;
                $anak_ke = $row[$tempIndex++] ?? null;
                $jumlah_saudara = $row[$tempIndex++] ?? null;
                $status_anak = $row[$tempIndex++] ?? null; // Anak Kandung
                $alamat = $row[$tempIndex++] ?? null;
                $rt_rw = $row[$tempIndex++] ?? null;
                $kelurahan = $row[$tempIndex++] ?? null;
                $kecamatan = $row[$tempIndex++] ?? null;
                $kota = $row[$tempIndex++] ?? null;
                $provinsi = $row[$tempIndex++] ?? null;
                $alamat_domisili = $row[$tempIndex++] ?? null;
                $kode_pos = $row[$tempIndex++] ?? null;
                $agama = $row[$tempIndex++] ?? null;
                $nama_sekolah_asal = $row[$tempIndex++] ?? null;
                $alamat_sekolah_asal = $row[$tempIndex++] ?? null;
                $kelas_referal = $row[$tempIndex++] ?? null;
                $kelas_matrikulasi = $row[$tempIndex++] ?? null;
                $kelas_pertama_pkbm = $row[$tempIndex++] ?? null;
                $kelas_smt_terakhir_sekolah_sebelum = $row[$tempIndex++] ?? null;
                $tahun_lulus = $row[$tempIndex++] ?? null;
                $tahun_ijazah = $row[$tempIndex++] ?? null;
                $no_ijazah_skl = $row[$tempIndex++] ?? null;
                $tahun_skhun = $row[$tempIndex++] ?? null;
                $scan_foto_ijazah = $row[$tempIndex++] ?? null;
                $scan_foto_skhun = $row[$tempIndex++] ?? null;
                $scan_foto_bukti_tf = $row[$tempIndex++] ?? null;
                $status_perkawinan_orang_tua = $row[$tempIndex++] ?? null;
                $nama_ayah = $row[$tempIndex++] ?? null;
                $nama_ibu = $row[$tempIndex++] ?? null;
                $pekerjaan_ayah = $row[$tempIndex++] ?? null;
                $pekerjaan_ibu = $row[$tempIndex++] ?? null;
                $honor_ayah = $row[$tempIndex++] ?? null;
                $honor_ibu = $row[$tempIndex++] ?? null;
                $telegram_siswa = $row[$tempIndex++] ?? null;
                $nama_konsultasi_pendidikan = $row[$tempIndex++] ?? null;
                $sumber_info_pkbm = $row[$tempIndex++] ?? null;
                $detail_sumber_info = $row[$tempIndex++] ?? null;
                $no_pendaftaran = $row[$tempIndex++] ?? null;
                $tgl_masuk_electa = $row[$tempIndex++] ?? null;
                $tgl_dikirim_ppdb = $row[$tempIndex++] ?? null;
                $status_lanjutan_baru = $row[$tempIndex++] ?? null; // Lanjutan, Baru
                $akta_kelahiran = $row[$tempIndex++] ?? null;
                $foto_id_ayah = $row[$tempIndex++] ?? null;
                $foto_id_ibu = $row[$tempIndex++] ?? null;
                $foto_2x3 = $row[$tempIndex++] ?? null;
                $foto_3x4 = $row[$tempIndex++] ?? null;
                $foto_4x6 = $row[$tempIndex++] ?? null;
                $foto_kk = $row[$tempIndex++] ?? null;
                $nota_kesepakatan = $row[$tempIndex++] ?? null;
                $data_raport_yg_dimiliki = $row[$tempIndex++] ?? null;
                $surat_pernyataan = $row[$tempIndex++] ?? null;
                $ijazah = $row[$tempIndex++] ?? null;
                $nik_ayah = $row[$tempIndex++] ?? null;
                $nik_ibu = $row[$tempIndex++] ?? null;
                $nik_siswa = $row[$tempIndex++] ?? null;
                $no_kk = $row[$tempIndex++] ?? null;
                $no_reg_akte = $row[$tempIndex++] ?? null;
                $daftar_ulang = $row[$tempIndex++] ?? null;
                $pilihan_kelas = $row[$tempIndex++] ?? null; // HST-REG
                $ceklis_pindah_layanan = $row[$tempIndex++] ?? null;

                $kode_kelas = $kode_kelas_ini;

                // Skip if NISN is empty
                if (empty($nisn)) {
                    continue;
                }

                // 1. Normalisasi input
                $kode_kelas = preg_replace('/\s+/', ' ', trim($kode_kelas ?? ''));

                if (empty($kode_kelas)) {
                    $rowNumber = $key + 1;
                    throw new \Exception("Error pada baris $rowNumber: Kolom kode_kelas harus diisi");
                }

                // 2. Ekstrak kode layanan
                $kodeLayananKelas = $this->extractLayananKelas($kode_kelas);

                // 3. Tentukan jenis kelas
                try {
                    [$typeKelas, $kodePaketKelas] = $this->determineTypeKelas($kode_kelas, $kodeLayananKelas);

                    // Debug: Pastikan typeKelas valid
                    if (!in_array($typeKelas, [
                        Constant::TYPE_KELAS_ABC,
                        Constant::TYPE_KELAS_PAUD,
                        Constant::TYPE_KELAS_KHUSUS
                    ])) {
                        throw new \Exception("Jenis kelas tidak valid: $typeKelas");
                    }
                } catch (\Exception $e) {
                    throw new \Exception("Gagal menentukan jenis kelas: " . $e->getMessage());
                }

                // 4. Validasi NISN
                $nisn = is_numeric($nisn) ? $nisn : null;

                // 5. Proses data berdasarkan jenis kelas
                switch ($typeKelas) {
                    case Constant::TYPE_KELAS_ABC:
                        if (!preg_match('/^[A-C][0-9]{1,2}/', substr($kode_kelas, 0, 3))) {
                            throw new \Exception(
                                "Format kode kelas ABC tidak valid pada baris " . ($key + 1) . ". " .
                                    "Harus diawali A/B/C diikuti angka (contoh: A11, B22). " .
                                    "Kode yang diterima: '$kode_kelas'"
                            );
                        }
                        [$kelasNum, $smtNum] = $this->processKelasABC($kode_kelas);
                        break;

                    case Constant::TYPE_KELAS_PAUD:
                        if (empty($kodePaketKelas)) {
                            throw new \Exception("Kode Paket Kelas PAUD tidak ditemukan untuk: '$kode_kelas'");
                        }
                        [$kelasNum, $smtNum] = [null, substr($kode_kelas, strlen($kodePaketKelas), 1)];
                        break;

                    case Constant::TYPE_KELAS_KHUSUS:
                        [$kelasNum, $smtNum] = [null, substr($kode_kelas, -1)];
                        break;

                    default:
                        [$kelasNum, $smtNum] = [null, 1]; // Default semester 1
                        break;
                }

                // 6. Process learner status
                $status_wb = $this->determineStatusWB($status_wb ?? '');

                // 7. Format academic year
                $tahunAjar = $this->formatTahunAkademik($tahunAjar ?? date('Y'), $smtNum ?? '1');

                // 8. Validate and get references
                $references = $this->validateAndGetReferences($kodeLayananKelas, $kodePaketKelas, $tahunAjar, $kode_kelas);
                [$layananKelas, $paketKelas, $tahunAkademik] = array_values($references);

                // Update or create Kelas
                $kelasDB = KelasModel::updateOrCreate(
                    ['kode' => $kode_kelas, 'tahun_akademik_id' => $tahunAkademik->id],
                    [
                        'kelas' => $kelasNum,
                        'semester' => $smtNum,
                        'jurusan' => $this->getJurusan($kode_kelas),
                        'layanan_kelas_id' => $layananKelas->id,
                        'paket_kelas_id' => $paketKelas->id,
                        'nama' => $kode_kelas,
                        'type' => $typeKelas, // Pastikan ini diisi dengan nilai 0, 1, atau 2
                        'is_active' => true,
                        'jenis_rapor' => 'lama', // Default value jika diperlukan
                        'is_lock_nilai' => false, // Default value
                    ]
                );

                // Process user data
                $user = $this->processUserData([
                    'nisn' => $nisn,
                    'nama' => $nama,
                    'gender' => $gender,
                    'tempat_lahir' => $tempat_lahir,
                    'tgl_lahir' => $tgl_lahir,
                    'nik_siswa' => $nik_siswa,
                    'agama' => $agama,
                    'alamat' => $alamat,
                    'rt_rw' => $rt_rw,
                    'kelurahan' => $kelurahan,
                    'kecamatan' => $kecamatan,
                    'kota' => $kota,
                    'provinsi' => $provinsi,
                    'kode_pos' => $kode_pos,
                    'telegram_siswa' => $telegram_siswa,
                    'hp_ayah' => $hp_ayah,
                    'hp_ibu' => $hp_ibu,
                ], $nis ?? $this->generateNIS());

                // Process PPDB data
                $ppdb = $this->processPpdbData([
                    'user_id' => $user->id,
                    'cabang_id' => $this->getCabangId($cabang_genju ?? null),
                    'type' => $typeKelas,
                    'nis' => $nis ?? $this->generateNIS(),
                    'nama' => $nama,
                    'kelamin' => isset($gender) && strtolower($gender) == 'laki-laki' ? 'l' : 'p',
                    'nama_ayah' => $nama_ayah,
                    'nama_ibu' => $nama_ibu,
                    'nik_siswa' => $nik_siswa,
                    'nik_ayah' => $nik_ayah,
                    'nik_ibu' => $nik_ibu,
                    'tempat_lahir' => $tempat_lahir,
                    'tanggal_lahir' => $this->formatTanggalLahir($tgl_lahir),
                    'status_dalam_keluarga' => $status_anak ?? null,
                    'anak_ke' => $anak_ke ?? null,
                    'alamat_peserta_didik' => $alamat,
                    'alamat_domisili' => $alamat_domisili ?? $alamat,
                    'alamat_orang_tua' => $alamat,
                    'no_telp_rumah' => $no_telp_rumah ?? null,
                    'satuan_pendidikan_asal' => $nama_sekolah_asal,
                    'agama' => $agama,
                    'pekerjaan_ayah' => $pekerjaan_ayah,
                    'pekerjaan_ibu' => $pekerjaan_ibu,
                    'hp_siswa' => $hp_siswa ?? null,
                    'hp_ayah' => $hp_ayah,
                    'hp_ibu' => $hp_ibu,
                    'telegram_siswa' => $telegram_siswa,
                    'telegram_ayah' => $telegram_ayah ?? null,
                    'telegram_ibu' => $telegram_ibu ?? null,
                    'nama_wali' => $nama_wali ?? null,
                    'no_telp_wali' => $no_telp_wali ?? null,
                    'alamat_wali' => $alamat_wali ?? null,
                    'pekerjaan_wali' => $pekerjaan_wali ?? null,
                    'email' => $email_ortu,
                    'tahun_akademik_id' => $tahunAkademik->id,
                    'layanan_kelas_id' => $layananKelas->id,
                    'paket_kelas_id' => $paketKelas->id,
                    'tipe_kelas_sebelum' => $kelas_sebelum ?? null,
                    'kelas_sebelum' => $kelas_referal ?? null,
                    'smt_kelas_sebelum' => $kelas_smt_terakhir_sekolah_sebelum ?? null,
                    'kelas' => $kelas_pertama_pkbm ?? null,
                    'smt_kelas' => $smtNum ?? null,
                    'lulusan' => $tahun_lulus,
                    'tahun_lulus' => $tahun_lulus,
                    'paket_spp_id' => $paket_spp_id ?? null,
                    'dokumen_ktp_orang_tua' => $foto_id_ayah ?? null,
                    'dokumen_akta_lahir' => $akta_kelahiran ?? null,
                    'dokumen_skhun' => $scan_foto_skhun ?? null,
                    'dokumen_kartu_keluarga' => $foto_kk ?? null,
                    'dokumen_ijazah' => $ijazah ?? null,
                    'is_ktp_approval' => $is_ktp_approved ?? false,
                    'is_akta_approval' => $is_akta_approved ?? false,
                    'is_skhun_approval' => $is_shun_skhun_approved ?? false,
                    'is_kk_approval' => $is_kk_approved ?? false,
                    'is_ijazah_approval' => $is_ijasah_approved ?? false,
                    'url_bukti_tf' => $scan_foto_bukti_tf ?? null,
                    'url_bukti_trf2' => $scan_foto_bukti_tf2 ?? null,
                    'biaya_daftar' => $biaya_daftar ?? null,
                    'biaya_program' => $biaya_program ?? null,
                    'biaya_spp' => $biaya_spp ?? null,
                    'biaya' => $biaya ?? null,
                    'peminatan' => $peminatan ?? null,
                    'wakaf' => $wakaf ?? null,
                    'infaq' => $infaq ?? null,
                    'url_bukti_zakat' => $url_bukti_trf_zakat ?? null,
                    'kelas_id' => $kelasDB->id ?? null,
                    'is_active' => true,
                    'is_approved' => false,
                    'created_by' => null,
                    'updated_by' => null,
                    'nisn' => $nisn,
                    'no_induk' => $no_induk ?? null,
                    'no_pendaftaran' => $no_pendaftaran,
                    'tgl_dikirim_ppdb' => $tgl_dikirim_ppdb,
                    'status_lanjutan_baru' => $status_lanjutan_baru,
                    'no_kk' => $no_kk,
                    'tgl_terima' => $tgl_terima ?? now(),
                    'voucher_kode' => $voucher_code ?? null,
                    'diskon_kode' => $discount_code ?? null,
                    'diskon_type' => $discount_type ?? null,
                    'discount' => isset($discount) && is_numeric($discount) ? $discount : 0,
                ], $user, $layananKelas, $paketKelas, $tahunAkademik, $typeKelas);

                // Process rombel
                $rombel = $this->processRombel($ppdb, $tahunAkademik, $status_wb, $kelasDB);
            }

            DB::commit();

            $importedKelas = KelasModel::where('kode', $kode_kelas_ini)->first();
            return response()->json([
                'error' => false,
                'message' => 'File berhasil dibaca dan diimpor',
                'kelas' => [
                    'kode' => $importedKelas->kode,
                    'type' => $importedKelas->type,
                    'type_text' => [
                        0 => 'ABC',
                        1 => 'PAUD',
                        2 => 'KHUSUS'
                    ][$importedKelas->type] ?? 'UNKNOWN',
                    'nama' => $importedKelas->nama,
                    'tahun_akademik' => $importedKelas->tahunAkademik->tahun_ajar ?? null
                ],
                'debug' => [
                    'type_determined' => $typeKelas,
                    'kode_paket' => $kodePaketKelas
                ],
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'error' => true,
                'message' => 'Terjadi kesalahan saat mengimpor data',
                'exception' => $e->getMessage(),
            ], 500);
        }
    }


    // Helper methods
    private function formatTahunAkademik(string $tahunAjar, string $semester): string
    {
        // Jika tahun ajaran sudah dalam format lengkap
        if (str_contains($tahunAjar, '-')) {
            return $tahunAjar;
        }

        $semesterText = ($semester == '1' || strtolower($semester) == 'ganjil') ? 'Ganjil' : 'Genap';
        return "{$tahunAjar}-{$semesterText}";
    }

    private function extractLayananKelas(string $kode_kelas): string
    {
        $kelasParts = explode(' ', $kode_kelas);
        foreach ($kelasParts as $part) {
            $partUpper = strtoupper($part);
            if (str_contains($partUpper, 'HST')) return 'HST';
            if (str_contains($partUpper, 'REG')) return 'REG';
            if (str_contains($partUpper, 'INTENSIF')) return 'INTENSIF';
        }
        return 'UNKNOWN';
    }

    private function formatTanggal($date)
    {
        if (empty($date)) return null;

        try {
            return Carbon::createFromFormat('d/m/Y', $date)->format('Y-m-d');
        } catch (\Exception $e) {
            return $date; // Fallback jika format sudah benar
        }
    }


    private function getCabangId($namaCabang)
    {
        if (empty($namaCabang)) {
            return null;
        }

        // Cari berdasarkan nama_cabang
        return CabangModel::where('nama_cabang', $namaCabang)->value('id') ?? null;
    }

    private function generateNIS()
    {
        $tahun = date('y');
        $lastNIS = PpdbModel::max('nis') ?? '0000';
        $sequence = (int)substr($lastNIS, -4) + 1;
        return $tahun . str_pad($sequence, 4, '0', STR_PAD_LEFT);
    }

    protected function determineTypeKelas(string $kode_kelas, string $kodeLayananKelas): array
    {
        $kode_kelas = strtoupper(trim($kode_kelas));

        // 1. Check PAUD classes first
        foreach (Constant::KELAS_PAUD as $kelasPaud) {
            if (strpos($kode_kelas, $kelasPaud) !== false) {
                return [Constant::TYPE_KELAS_PAUD, $kelasPaud];
            }
        }

        // 2. Check ABC classes (format: A11, B22, C33)
        if (preg_match(Constant::KODE_KELAS_ABC_PATTERN, $kode_kelas)) {
            $prefix = substr($kode_kelas, 0, 1);
            return [Constant::TYPE_KELAS_ABC, 'PAKET' . $prefix];
        }

        // 3. Special classes (REG, HST, INTENSIF)
        if (in_array($kodeLayananKelas, ['REG', 'HST', 'INTENSIF'])) {
            return [Constant::TYPE_KELAS_KHUSUS, $kodeLayananKelas];
        }

        // Default to ABC type if uncertain
        return [Constant::TYPE_KELAS_ABC, Constant::DEFAULT_PAKET_KODE];
    }

    protected function processKelasABC(string $kode_kelas): array
    {
        $kode = explode(' ', $kode_kelas)[0];
        $kelasNum = substr($kode, 1, 2);
        $smtNum = (strlen($kode) > 3) ? substr($kode, -1) : Constant::DEFAULT_SEMESTER;

        return [(int)$kelasNum, (int)$smtNum];
    }

    private function determineStatusWB(?string $status_wb): string
    {
        if (!$status_wb) return Constant::STATUS_WB_BARU;

        $statusLower = strtolower($status_wb);
        if (str_contains($statusLower, 'baru')) return Constant::STATUS_WB_BARU;
        if (str_contains($statusLower, 'lama')) return Constant::STATUS_WB_LAMA;
        if (str_contains($statusLower, 'alumni')) return Constant::STATUS_WB_ALUMNI;

        return Constant::STATUS_WB_BARU;
    }

    private function validateAndGetReferences(
        string $kodeLayananKelas,
        string $kodePaketKelas,
        string $tahunAjar,
        string $originalKodeKelas
    ): array {
        // 1. Validasi dan dapatkan Layanan Kelas
        $layananKelas = LayananKelasModel::where('kode', $kodeLayananKelas)->first();
        if (!$layananKelas) {
            throw new \Exception("Layanan kelas dengan kode {$kodeLayananKelas} tidak ditemukan");
        }

        // 2. Validasi dan buat Paket Kelas jika belum ada
        $paketKelas = PaketKelasModel::firstOrCreate(
            ['kode' => $kodePaketKelas],
            [
                'nama' => 'Kelas ' . $kodeLayananKelas,
                'is_active' => true,
                'type' => 'khusus',
                'created_by' => auth()->id() ?? 1,
                'updated_by' => auth()->id() ?? 1
            ]
        );

        // 3. Validasi dan dapatkan Tahun Akademik dengan penanganan khusus
        $tahunAkademik = $this->getOrCreateTahunAkademik($tahunAjar, $originalKodeKelas);

        return [
            'layananKelas' => $layananKelas,
            'paketKelas' => $paketKelas,
            'tahunAkademik' => $tahunAkademik
        ];
    }

    private function getOrCreateTahunAkademik(string $tahunAjar, string $originalKodeKelas): TahunAkademikModel
    {
        // Tentukan semester berdasarkan bulan sekarang (default)
        $currentMonth = date('n'); // 1-12
        $defaultSemester = ($currentMonth >= 1 && $currentMonth <= 6) ? '1' : '2';

        // Coba ekstrak semester dari kode kelas (karakter terakhir)
        $semester = substr($originalKodeKelas, -1);

        // Validasi semester, jika tidak valid gunakan default
        $semester = ($semester == '1' || $semester == '2') ? $semester : $defaultSemester;

        $semesterText = ($semester == '1') ? 'Ganjil' : 'Genap';

        // Format kode tahun akademik: 4 digit tahun + semester (contoh: "20241")
        $kodeTahunAkademik = substr(str_replace('/', '', $tahunAjar), 0, 4) . $semester;

        // Cari berdasarkan kode unik tahun akademik
        $tahunAkademik = TahunAkademikModel::where('kode', $kodeTahunAkademik)->first();

        if (!$tahunAkademik) {
            $tahunParts = explode('/', $tahunAjar);
            $tahunMulai = $tahunParts[0];
            $tahunSelesai = $tahunParts[1] ?? $tahunParts[0] + 1;

            $tahunAkademik = TahunAkademikModel::create([
                'kode' => $kodeTahunAkademik,
                'tahun_ajar' => $tahunAjar,
                'keterangan' => "Semester $semesterText Tahun Ajaran $tahunMulai/$tahunSelesai",
                'periode_start' => $semester == '1' ? "$tahunMulai-01-01" : "$tahunMulai-07-01",
                'periode_end' => $semester == '1' ? "$tahunMulai-06-30" : "$tahunMulai-12-31",
                'is_active' => true,
                'is_generate_rombel' => false
            ]);
        }

        return $tahunAkademik;
    }

    private function processUserData(array $row, $nis): User
    {
        try {
            // Gunakan NISN jika ada, jika tidak gunakan NIS dari PPDB
            $username = $row['nisn'] ?? $nis;

            if (empty($username)) {
                throw new \Exception("NISN dan NIS kosong, tidak bisa buat user.");
            }

            // Buat email default jika tidak ada email ortu
            $email = $row['email_ortu'] ?? $username . '@generasijuara.sch.id';

            $user = User::updateOrCreate(
                ['username' => $username],
                [
                    'name' => $row['nama'] ?? 'Siswa Baru',
                    'email' => $email,
                    'password' => bcrypt(Constant::PPDB_DEFAULT_PASSWORD),
                    'is_active' => true
                ]
            );

            // Tambahkan role jika user baru
            if ($user->wasRecentlyCreated) {
                UserRoleModel::firstOrCreate([
                    'user_id' => $user->id,
                    'role_id' => Constant::ROLE_WB_ID
                ]);
            }

            return $user;
        } catch (\Exception $e) {
            throw new \Exception("Gagal memproses data user: " . $e->getMessage());
        }
    }


    private function processPpdbData(
        array $row,
        User $user,
        LayananKelasModel $layananKelas,
        PaketKelasModel $paketKelas,
        TahunAkademikModel $tahunAkademik,
        int $type
    ): PpdbModel {
        try {
            // Format tanggal terima
            $tglTerima = $this->formatTanggal($row['tgl_terima'] ?? now());

            return PpdbModel::updateOrCreate(
                ['user_id' => $user->id],
                [
                    'cabang_id' => $row['cabang_id'] ?? $this->getCabangId($row['cabang_genju'] ?? null),
                    'type' => $type,
                    'nis' => $row['nis'] ?? $this->generateNIS(),
                    'nama' => $row['nama'] ?? null,
                    'kelamin' => isset($row['gender']) && strtolower($row['gender']) == 'laki-laki' ? 'l' : 'p',
                    'nama_ayah' => $row['nama_ayah'] ?? null,
                    'nama_ibu' => $row['nama_ibu'] ?? null,
                    'nik_siswa' => $row['nik_siswa'] ?? null,
                    'nik_ayah' => $row['nik_ayah'] ?? null,
                    'nik_ibu' => $row['nik_ibu'] ?? null,
                    'tempat_lahir' => $row['tempat_lahir'] ?? null,
                    'tanggal_lahir' => $this->formatTanggalLahir($row['tgl_lahir'] ?? null),
                    'status_dalam_keluarga' => $row['status_anak'] ?? null,
                    'anak_ke' => $row['anak_ke'] ?? null,
                    'alamat_peserta_didik' => $row['alamat'] ?? null,
                    'alamat_domisili' => $row['alamat_domisili'] ?? $row['alamat'] ?? null,
                    'alamat_orang_tua' => $row['alamat'] ?? null,
                    'no_telp_rumah' => $row['no_telp_rumah'] ?? null,
                    'satuan_pendidikan_asal' => $row['nama_sekolah_asal'] ?? null,
                    'agama' => $row['agama'] ?? null,
                    'pekerjaan_ayah' => $row['pekerjaan_ayah'] ?? null,
                    'pekerjaan_ibu' => $row['pekerjaan_ibu'] ?? null,
                    'hp_siswa' => $row['hp_siswa'] ?? null,
                    'hp_ayah' => $row['hp_ayah'] ?? null,
                    'hp_ibu' => $row['hp_ibu'] ?? null,
                    'telegram_siswa' => $row['telegram_siswa'] ?? null,
                    'telegram_ayah' => $row['telegram_ayah'] ?? null,
                    'telegram_ibu' => $row['telegram_ibu'] ?? null,
                    'nama_wali' => $row['nama_wali'] ?? null,
                    'no_telp_wali' => $row['no_telp_wali'] ?? null,
                    'alamat_wali' => $row['alamat_wali'] ?? null,
                    'pekerjaan_wali' => $row['pekerjaan_wali'] ?? null,
                    'email' => $row['email'] ?? null,
                    'tahun_akademik_id' => $tahunAkademik->id,
                    'layanan_kelas_id' => $layananKelas->id,
                    'paket_kelas_id' => $paketKelas->id,
                    'tipe_kelas_sebelum' => $row['kelas_sebelum'] ?? null,
                    'kelas_sebelum' => $row['kelas_referal'] ?? null,
                    'smt_kelas_sebelum' => $row['semester'] ?? null,
                    'kelas' => $row['kelas'] ?? null,
                    'smt_kelas' => $row['semester'] ?? null,
                    'lulusan' => $row['tahun_lulus'] ?? null,
                    'paket_spp_id' => $row['paket_spp_id'] ?? null,
                    'dokumen_ktp_orang_tua' => $row['scan_foto_ktp_ortu'] ?? null,
                    'dokumen_akta_lahir' => $row['scan_foto_akta'] ?? null,
                    'dokumen_skhun' => $row['scan_foto_skhun'] ?? null,
                    'dokumen_kartu_keluarga' => $row['scan_foto_kk'] ?? null,
                    'dokumen_ijazah' => $row['scan_foto_ijazah'] ?? null,
                    'is_ktp_approval' => $row['is_ktp_approval'] ?? null,
                    'is_akta_approval' => $row['is_akta_approval'] ?? null,
                    'is_skhun_approval' => $row['is_skhun_approval'] ?? null,
                    'is_kk_approval' => $row['is_kk_approval'] ?? null,
                    'is_ijazah_approval' => $row['is_ijazah_approval'] ?? null,
                    'url_bukti_tf' => $row['url_bukti_tf'] ?? null,
                    'url_bukti_trf2' => $row['url_bukti_trf2'] ?? null,
                    'biaya_daftar' => $row['biaya_daftar'] ?? null,
                    'biaya_program' => $row['biaya_program'] ?? null,
                    'biaya_spp' => $row['biaya_spp'] ?? null,
                    'biaya' => $row['biaya'] ?? null,
                    'peminatan' => $row['peminatan'] ?? null,
                    'wakaf' => $row['wakaf'] ?? null,
                    'infaq' => $row['infaq'] ?? null,
                    'url_bukti_zakat' => $row['url_bukti_zakat'] ?? null,
                    'kelas_id' => $row['kelas_id'] ?? null,
                    'is_active' => true,
                    'is_approved' => false,
                    'created_by' => null,
                    'updated_by' => null,
                    'nisn' => $row['nisn'] ?? null,
                    'no_induk' => $row['no_induk'] ?? null,
                    'user_id' => $user->id,
                    'tgl_terima' => $tglTerima,
                    'voucher_kode' => $row['voucher_code'] ?? null,
                    'diskon_kode' => $row['diskon_code'] ?? null,
                    'diskon_type' => $row['diskon_type'] ?? null,
                    'discount' => $row['discount'] ?? null,
                ]
            );
        } catch (\Exception $e) {
            throw new \Exception("Gagal memproses data PPDB: " . $e->getMessage());
        }
    }

    private function processRombel(
        PpdbModel $ppdb,
        TahunAkademikModel $tahunAkademik,
        string $status_wb,
        KelasModel $kelasDB
    ): RombelModel {
        try {
            $rombel = RombelModel::updateOrCreate(
                ['ppdb_id' => $ppdb->id, 'tahun_akademik_id' => $tahunAkademik->id],
                [
                    'status_wb' => $status_wb,
                    'is_active' => true,
                    'kelas_id' => $kelasDB->id
                ]
            );

            KelasWbModel::updateOrCreate(
                ['wb_id' => $ppdb->id, 'kelas_id' => $kelasDB->id],
                ['is_active' => true]
            );

            return $rombel;
        } catch (\Exception $e) {
            throw new \Exception("Gagal memproses rombel: " . $e->getMessage());
        }
    }

    private function getJurusan($kode_kelas)
    {
        if (str_contains($kode_kelas, 'IPA')) {
            return 'IPA';
        } elseif (str_contains($kode_kelas, 'IPS')) {
            return 'IPS';
        } elseif (str_contains($kode_kelas, 'BHS')) {
            return 'Bahasa';
        }
        return null;
    }

    private function formatTanggalLahir($tgl_lahir)
    {
        if (empty($tgl_lahir)) {
            return null;
        }

        // Jika sudah format Y-m-d
        if (preg_match('/^\d{4}-\d{2}-\d{2}$/', $tgl_lahir)) {
            return $tgl_lahir;
        }

        // Format Indonesia: "1 Januari 2000"
        if (preg_match('/^(\d{1,2})\s+([a-zA-Z]+)\s+(\d{4})$/', $tgl_lahir, $matches)) {
            $bulanToAngka = [
                'Januari' => '01',
                'Februari' => '02',
                'Maret' => '03',
                'April' => '04',
                'Mei' => '05',
                'Juni' => '06',
                'Juli' => '07',
                'Agustus' => '08',
                'September' => '09',
                'Oktober' => '10',
                'November' => '11',
                'Desember' => '12'
            ];

            $hari = str_pad($matches[1], 2, '0', STR_PAD_LEFT);
            $bulan = $bulanToAngka[$matches[2]] ?? '01';
            $tahun = $matches[3];

            return "{$tahun}-{$bulan}-{$hari}";
        }

        // Format lain bisa ditambahkan disini

        return null;
    }



    // dummy_rombongan_belajar
    // public function storeDummyData()
    // {
    //     $dataDummy = [
    //         [
    //             'nis' => '123456789',
    //             'nisn' => '987654321',
    //             'nama' => 'John Doe',
    //             'kelamin' => 'L',
    //             'nama_ibu' => 'Jane Doe',
    //             'nama_ayah' => 'Richard Doe',
    //             'nik_siswa' => '1234567890123456',
    //             'nik_ayah' => '9876543210987654',
    //             'nik_ibu' => '4567891234567890',
    //             'tempat_lahir' => 'Jakarta',
    //             'tanggal_lahir' => '2000-01-01',
    //             'status_dalam_keluarga' => 'Anak ke-1',
    //             'anak_ke' => 1,
    //             'alamat_peserta_didik' => 'Jl. Merdeka No. 1',
    //             'alamat_domisili' => 'Jl. Merdeka No. 1',
    //             'alamat_orang_tua' => 'Jl. Raya No. 2',
    //             'no_telp_rumah' => '02123456789',
    //             'satuan_pendidikan_asal' => 'SMA Negeri 1 Jakarta',
    //             'agama' => 'Islam',
    //             'pekerjaan_ayah' => 'Pegawai Negeri',
    //             'pekerjaan_ibu' => 'Ibu Rumah Tangga',
    //             'hp_siswa' => '081234567890',
    //             'hp_ayah' => '081298765432',
    //             'hp_ibu' => '081234567891',
    //             'telegram_siswa' => '@john_doe',
    //             'telegram_ayah' => '@richard_doe',
    //             'telegram_ibu' => '@jane_doe',
    //             'nama_wali' => 'Nina Smith',
    //             'no_telp_wali' => '082345678901',
    //             'alamat_wali' => 'Jl. Wali No. 3',
    //             'pekerjaan_wali' => 'Pengusaha',
    //             'email' => 'johndoe@example.com',
    //             'tahun_akademik_id' => 14,
    //             'layanan_kelas_id' => 1,
    //             'paket_kelas_id' => 1,
    //             'tipe_kelas_sebelum' => 'Reguler',
    //             'kelas_sebelum' => 'X IPA 1',
    //             'smt_kelas_sebelum' => 1,
    //             'kelas' => 'XI IPA 2',
    //             'smt_kelas' => 2,
    //             'lulusan' => 'Belum Lulus',
    //             'tahun_lulus' => 2025,
    //             'paket_spp_id' => 1,
    //             'dokumen_ktp_orang_tua' => 'ktp_ayah.pdf',
    //             'dokumen_akta_kelahiran' => 'akta_kelahiran.pdf',
    //             'dokumen_shun_skhun' => 'shun.pdf',
    //             'dokumen_kartu_keluarga' => 'kk.pdf',
    //             'dokumen_ijasah' => 'ijasah.pdf',
    //             'is_ktp_approved' => true,
    //             'is_akta_approved' => true,
    //             'is_shun_skhun_approved' => false,
    //             'is_kk_approved' => true,
    //             'is_ijasah_approved' => true,
    //             'url_bukti_trf' => 'transfer_bukti.pdf',
    //             'url_bukti_trf2' => 'transfer_bukti2.pdf',
    //             'biaya_daftar' => 100000,
    //             'biaya_program' => 500000,
    //             'biaya_spp' => 200000,
    //             'biaya' => 800000,
    //             'peminatan' => 'IPA',
    //             'wakaf' => 50000,
    //             'infaq' => 100000,
    //             'url_bukti_trf_zakat' => 'zakat_bukti.pdf',
    //             'kelas_id' => 2,
    //             'is_active' => true,
    //             'is_approved' => true,
    //             'created_by' => 1,
    //             'updated_by' => 1,
    //             'nisn' => '987654321',
    //             'no_induk' => '1234567890',
    //             'user_id' => 1,
    //             'cabang_id' => 2,
    //             'tgl_terima' => '2025-05-01',
    //             'voucher_code' => 'VOUCHER2025',
    //             'discount_type' => 'percent',
    //             'discount' => 10,
    //         ]
    //     ];

    //     // Loop untuk memasukkan data ke database
    //     foreach ($dataDummy as $row) {
    //         // Mengecek jika ada data kosong
    //         if (!empty(array_filter([$row['nis'], $row['nisn'], $row['nama']]))) {
    //             PpdbModel::updateOrCreate(
    //                 ['nisn' => $row['nisn']],
    //                 $row
    //             );
    //         }
    //     }

    //     // Return response untuk memastikan data berhasil dimasukkan
    //     return response()->json(['message' => 'Data berhasil dimasukkan!']);
    // }

    public function get(Request $request)
    {
        try {
            $id = !empty($request->get('id')) ? $request->get('id') : null;
            $kelas = KelasModel::find($id);
            return response()->json(['error' => false, 'message' => null, 'data' => $kelas], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => true, 'message' => $e->getMessage()], 400);
        } catch (\Throwable $e) {
            return response()->json(['error' => true, 'message' => $e->getMessage()], 400);
        }
    }

    public function getAll(Request $request)
    {
        try {
            $kelas_keyword = !empty($request->get('keyword')) ? $request->get('keyword') : null;
            if (!empty($request->user_id_tutor)) {
                $tutor = TutorModel::where('user_id', $request->user_id_tutor)->first();
                $kelas = KelasModel::from('kelas as k')
                    ->select(DB::raw("DISTINCT k.*"))
                    ->rightJoin('kelas_mata_pelajaran as kmp', 'kmp.kelas_id', '=', 'k.id')
                    ->where('kmp.tutor_id', $tutor->id);
                if (!empty($kelas_keyword)) {
                    $kelas = $kelas->where('nama', 'LIKE', "%$kelas_keyword%");
                }
                if (!empty($request->get('limit')) && $request->limit != null) {
                    $kelas = $kelas->limit($request->limit);
                }
                return response()->json(['error' => false, 'message' => null, 'data' => $kelas->get()], 200);
            }
            if (!empty($request->user_id_wb)) {
                $ppdb = PpdbModel::where('user_id', $request->user_id_wb)->first();
                // return response()->json(['error' => false, 'message' => null, 'data' => [$ppdb, $request->user_id_wb] ], 200);
                $kelas = KelasModel::from('kelas as k')
                    ->select(DB::raw("DISTINCT k.*"))
                    ->rightJoin('kelas_wb as kwb', 'kwb.kelas_id', '=', 'k.id')
                    ->where('kwb.wb_id', $ppdb->id);

                if (!empty($kelas_keyword)) {
                    $kelas = $kelas->where('nama', 'LIKE', "%$kelas_keyword%");
                }
                if (!empty($request->get('limit')) && $request->limit != null) {
                    $kelas = $kelas->limit($request->limit);
                }
                return response()->json(['error' => false, 'message' => null, 'data' => $kelas->get()], 200);
            }
            $kelas = KelasModel::get();
            return response()->json(['error' => false, 'message' => null, 'data' => $kelas], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => true, 'message' => $e->getMessage()], 400);
        } catch (\Throwable $e) {
            return response()->json(['error' => true, 'message' => $e->getMessage()], 400);
        }
    }

    public function getByName(Request $request)
    {
        try {
            $keyword = !empty($request->get('keyword')) ? $request->get('keyword') : null;
            $kelas = KelasModel::query();
            $kelas = $kelas->select('id', 'nama');
            if (!empty($keyword)) {
                $kelas = $kelas->where('nama', 'LIKE', "%$keyword%");
            }
            if (!empty($request->get('limit')) && $request->limit != null) {
                $kelas = $kelas->limit($request->limit);
            }
            return response()->json(['error' => false, 'message' => null, 'data' => $kelas->get()], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => true, 'message' => $e->getMessage()], 400);
        } catch (\Throwable $e) {
            return response()->json(['error' => true, 'message' => $e->getMessage()], 400);
        }
    }

    public function getSebelumnya(Request $request)
    {
        try {
            $kelas = RombelModel::with('kelas')
                ->where('ppdb_id', $request->ppdb_id)
                ->where('is_active', 1)
                ->orderBy('tahun_akademik_id', 'DESC')
                ->first();
            return response()->json(['error' => false, 'message' => null, 'data' => $kelas], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => true, 'message' => $e->getMessage()], 400);
        } catch (\Throwable $e) {
            return response()->json(['error' => true, 'message' => $e->getMessage()], 400);
        }
    }

    public function getType(Request $request)
    {
        try {
            $kelas = Constant::KELAS_TYPE;
            return response()->json(['error' => false, 'message' => null, 'data' => $kelas], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => true, 'message' => $e->getMessage()], 400);
        } catch (\Throwable $e) {
            return response()->json(['error' => true, 'message' => $e->getMessage()], 400);
        }
    }

    public function delete(Request $request)
    {
        try {
            $id = !empty($request->get('id')) ? $request->get('id') : null;
            $kelas = KelasModel::find($id);
            if (empty($kelas)) {
                return response()->json(['error' => true, 'message' => 'Kelas tidak ditemukan'], 400);
            }
            $kelas->delete();
            return response()->json(['error' => false, 'message' => null, 'data' => []], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => true, 'message' => $e->getMessage()], 400);
        } catch (\Throwable $e) {
            return response()->json(['error' => true, 'message' => $e->getMessage()], 400);
        }
    }

    public function updateStatusNilai(Request $request)
    {
        try {
            $id = !empty($request->get('id')) ? $request->get('id') : null;
            $kelas = KelasModel::find($id);
            if (empty($kelas)) {
                return response()->json(['error' => true, 'message' => 'Kelas tidak ditemukan'], 400);
            }
            $kelas->is_lock_nilai = !$kelas->is_lock_nilai;
            $kelas->save();
            return response()->json(['error' => false, 'message' => null, 'data' => $kelas], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => true, 'message' => $e->getMessage()], 400);
        } catch (\Throwable $e) {
            return response()->json(['error' => true, 'message' => $e->getMessage()], 400);
        }
    }

    public function updateJenisRapor(Request $request)
    {
        try {
            $id = !empty($request->get('id')) ? $request->get('id') : null;
            $kelas = KelasModel::find($id);
            if (empty($kelas)) {
                return response()->json(['error' => true, 'message' => 'Kelas tidak ditemukan'], 400);
            }
            $kelas->jenis_rapor = $request->get('jenis_rapor');
            $kelas->save();
            return response()->json(['error' => false, 'message' => null, 'data' => $kelas], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => true, 'message' => $e->getMessage()], 400);
        } catch (\Throwable $e) {
            return response()->json(['error' => true, 'message' => $e->getMessage()], 400);
        }
    }

    public function save(Request $request)
    {
        DB::beginTransaction();
        try {
            $id = !empty($request->get('id')) ? $request->get('id') : null;
            $duplicate_source_id = !empty($request->get('duplicate_source_id')) ? $request->get('duplicate_source_id') : null;
            $layanan_kelas_id = !empty($request->get('layanan_kelas_id')) ? $request->get('layanan_kelas_id') : null;
            $nama = !empty($request->get('nama')) ? $request->get('nama') : null;
            $kode = !empty($request->get('kode')) ? $request->get('kode') : null;
            $type = !empty($request->get('type')) ? $request->get('type') : 0;
            $biaya = !empty($request->get('biaya')) ? $request->get('biaya') : 0;
            $kelas = !empty($request->get('kelas')) ? $request->get('kelas') : null;
            $jurusan = !empty($request->get('jurusan')) ? $request->get('jurusan') : null;
            $semester = !empty($request->get('semester')) ? $request->get('semester') : null;
            $tahun_akademik_id = !empty($request->get('tahun_akademik_id')) ? $request->get('tahun_akademik_id') : null;
            $paket_kelas_id = !empty($request->get('paket_kelas_id')) ? $request->get('paket_kelas_id') : null;
            $is_active = !empty($request->get('is_active')) ? filter_var($request->get('is_active'), FILTER_VALIDATE_BOOLEAN) : false;
            $jenis_rapor = !empty($request->get('jenis_rapor')) ? $request->get('jenis_rapor') : null;

            $db = KelasModel::find($id);
            $params = [
                'layanan_kelas_id' => $layanan_kelas_id,
                'nama' => $nama,
                'kode' => $kode,
                'type' => $type,
                'biaya' => $biaya,
                'is_active' => $is_active,
                'kelas' => $kelas,
                'semester' => $semester,
                'jurusan' => $jurusan,
                'tahun_akademik_id' => $tahun_akademik_id,
                'paket_kelas_id' => $paket_kelas_id,
                'jenis_rapor' => $jenis_rapor,
            ];

            if (!empty($db)) {
                // update
                $db->update($params);
            } else {
                // new
                $db = KelasModel::create($params);
                if (!empty($duplicate_source_id)) {
                    $source = KelasModel::with([
                        'mata_pelajaran',
                        'warga_belajar',
                    ])->find($duplicate_source_id);

                    if (!empty($source)) {
                        foreach ($source->mata_pelajaran as $key => $mp) {
                            $kmp = KelasMataPelajaranModel::create([
                                'kelas_id' => $db->id,
                                'mata_pelajaran_id' => $mp['mata_pelajaran_id'],
                                'tutor_id' => $mp['tutor_id'],
                            ]);
                        }

                        foreach ($source->warga_belajar as $key => $wb) {
                            $kwb = KelasWbModel::create([
                                'kelas_id' => $db->id,
                                'wb_id' => $wb['wb_id'],
                            ]);
                            // return response()->json(['error' => true, 'data' => [$kwb]], 400);
                        }
                    }

                    // return response()->json(['error' => true, 'data' => []], 400);
                }
            }

            dd($db);
            DB::commit();
            return response()->json(['error' => false, 'message' => null, 'data' => $db], 200);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => true, 'message' => $e->getMessage()], 400);
        } catch (\Throwable $e) {
            DB::rollBack();
            return response()->json(['error' => true, 'message' => $e->getMessage()], 400);
        }
    }
}
