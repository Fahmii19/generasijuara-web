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
use DB;
use Excel;
use Log;
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

                // 1. Normalize and validate input
                $kode_kelas = preg_replace('/\s+/', ' ', trim($kode_kelas ?? ''));

                if (empty($kode_kelas) || trim($kode_kelas) === '') {
                    $rowNumber = $key + 1;
                    throw new \Exception("Error pada baris $rowNumber: Kolom kode_kelas harus diisi dengan format yang benar (contoh: A11-REG, B22-HST)");
                }

                // 2. Extract service code (HST/REG/INTENSIF)
                $kodeLayananKelas = $this->extractLayananKelas($kode_kelas);

                // 3. Determine class type (PAUD/ABC/SPECIAL)
                try {
                    [$typeKelas, $kodePaketKelas] = $this->determineTypeKelas($kode_kelas, $kodeLayananKelas);
                } catch (\Exception $e) {
                    throw new \Exception("Gagal menentukan jenis kelas: " . $e->getMessage());
                }

                // 4. Validate and normalize NISN
                $nisn = is_numeric($nisn) ? $nisn : null;

                // 5. Process data based on class type
                if ($typeKelas == Constant::TYPE_KELAS_ABC) {
                    if (!preg_match('/^[A-Ca-c][0-9]/', substr($kode_kelas, 0, 2))) {
                        throw new \Exception(
                            "Format kode kelas ABC tidak valid pada baris " . ($key + 1) . ". " .
                                "Harus diawali A/B/C diikuti angka (contoh: A11, B22). " .
                                "Kode yang diterima: '$kode_kelas'"
                        );
                    }
                    $kodePaketKelas = 'PAKET' . strtoupper(substr($kode_kelas, 0, 1));
                    [$kelasNum, $smtNum] = $this->processKelasABC($kode_kelas);
                } elseif ($typeKelas == Constant::TYPE_KELAS_PAUD) {
                    if (empty($kodePaketKelas)) {
                        throw new \Exception("Kode Paket Kelas PAUD tidak ditemukan untuk: '$kode_kelas'");
                    }
                    [$kelasNum, $smtNum] = [null, substr($kode_kelas, strlen($kodePaketKelas), 1)];
                } else {
                    [$kelasNum, $smtNum] = [null, substr($kode_kelas, -1)];
                    $kodePaketKelas = $kodeLayananKelas;
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
                        'type' => $typeKelas,
                        'is_active' => true,
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
                ], $nisn);

                // Process PPDB data
                $ppdb = $this->processPpdbData([
                    'user_id' => $user->id,
                    'no_pendaftaran' => $no_pendaftaran,
                    'tgl_dikirim_ppdb' => $tgl_dikirim_ppdb,
                    'status_lanjutan_baru' => $status_lanjutan_baru,
                    'layanan_kelas_id' => $layananKelas->id,
                    'paket_kelas_id' => $paketKelas->id,
                    'tahun_akademik_id' => $tahunAkademik->id,
                    'nama_sekolah_asal' => $nama_sekolah_asal,
                    'alamat_sekolah_asal' => $alamat_sekolah_asal,
                    'nama_ayah' => $nama_ayah,
                    'nama_ibu' => $nama_ibu,
                    'pekerjaan_ayah' => $pekerjaan_ayah,
                    'pekerjaan_ibu' => $pekerjaan_ibu,
                    'nik_ayah' => $nik_ayah,
                    'nik_ibu' => $nik_ibu,
                    'no_kk' => $no_kk,
                ], $user, $layananKelas, $paketKelas, $tahunAkademik);

                // Process rombel
                $rombel = $this->processRombel($ppdb, $tahunAkademik, $status_wb, $kelasDB);
            }

            DB::commit();

            return response()->json([
                'error' => false,
                'message' => 'File berhasil dibaca dan diimpor',
                'kode_kelas' => $kode_kelas_ini,
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

    private function determineTypeKelas(string $kode_kelas, string $kodeLayananKelas): array
    {
        // 1. Check PAUD first
        foreach (Constant::KELAS_PAUD as $kelasPaud) {
            if (stripos($kode_kelas, $kelasPaud) !== false) {
                return [Constant::TYPE_KELAS_PAUD, $kelasPaud];
            }
        }

        // 2. Check if it's a special class (HST/REG/INTENSIF)
        if ($kodeLayananKelas !== 'UNKNOWN') {
            return [Constant::TYPE_KELAS_KHUSUS, $kodeLayananKelas];
        }

        // 3. Default to ABC Class
        return [Constant::TYPE_KELAS_ABC, null];
    }

    private function processKelasABC(string $kode_kelas): array
    {
        $kodeKelasPart = explode(' ', $kode_kelas);
        $firstPart = $kodeKelasPart[0];

        // Handle various formats: A1, A11, A-1, A-11, etc
        $cleanPart = preg_replace('/[^A-Z0-9]/i', '', $firstPart);

        $kelasNum = substr($cleanPart, 1, strlen($cleanPart) > 2 ? 2 : 1);
        $smtNum = substr($cleanPart, -1); // Take last digit as semester

        return [$kelasNum, $smtNum];
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

    private function getOrCreateTahunAkademik(string $tahunAjar, string $kodeKelas): TahunAkademikModel
    {
        // Ekstrak semester dari kode kelas (karakter terakhir)
        $semester = substr($kodeKelas, -1);
        $semesterText = ($semester == '1') ? 'Ganjil' : 'Genap';

        // Cari berdasarkan tahun ajar dan semester
        $tahunAkademik = TahunAkademikModel::where('tahun_ajar', $tahunAjar)
            ->where('keterangan', 'like', "%$semesterText%")
            ->first();

        if (!$tahunAkademik) {
            // Jika tidak ditemukan, buat baru
            $tahunMulai = explode('/', $tahunAjar)[0];

            $tahunAkademik = TahunAkademikModel::create([
                'kode' => substr(str_replace('/', '', $tahunAjar), 0, 4) . $semester,
                'tahun_ajar' => $tahunAjar,
                'keterangan' => "Semester $semesterText Tahun Ajaran " . str_replace('/', ' - ', $tahunAjar),
                'periode_start' => $semester == '1' ? "$tahunMulai-07-01" : "$tahunMulai-01-01",
                'periode_end' => $semester == '1' ? "$tahunMulai-12-31" : "$tahunMulai-06-30",
                'is_active' => true,
                'is_generate_rombel' => false
            ]);
        }

        return $tahunAkademik;
    }

    private function processUserData(array $row): User
    {
        try {
            if (empty($row['nisn'])) {
                throw new \Exception("NISN kosong, tidak bisa buat user.");
            }

            // Gunakan NISN sebagai username
            $username = $row['nisn'];

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
        TahunAkademikModel $tahunAkademik
    ): PpdbModel {
        try {
            return PpdbModel::updateOrCreate(
                ['user_id' => $user->id],
                [
                    'nis' => $row['nis'] ?? null,
                    'nisn' => $row['nisn'] ?? null,
                    'nama' => $row['nama'] ?? null,
                    'kelamin' => isset($row['gender']) && strtolower($row['gender']) == 'laki-laki' ? 'l' : 'p',
                    'status_dalam_keluarga' => $row['status_anak'] ?? null,
                    'alamat_peserta_didik' => $row['alamat'] ?? null,
                    'email' => $row['email_ortu'] ?? null,
                    'layanan_kelas_id' => $layananKelas->id,
                    'paket_kelas_id' => $paketKelas->id,
                    'tahun_akademik_id' => $tahunAkademik->id,
                    'tanggal_lahir' => $this->formatTanggalLahir($row['tgl_lahir'] ?? null),
                    'no_telepon_ortu' => $row['hp_ayah'] ?? $row['hp_ibu'] ?? null,
                    'nama_ayah' => $row['nama_ayah'] ?? null,
                    'nama_ibu' => $row['nama_ibu'] ?? null
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
