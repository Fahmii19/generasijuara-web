<?php

namespace App\Services;

use App\Models\KelasWbModel;
use App\Models\KelasMataPelajaranModel;
use App\Models\PpdbModel;
use App\Models\EkstrakurikulerModel;
use App\Models\NilaiKegiatanModel;
use App\Models\RaportSettingModel;
use App\Models\RombelModel;
use App\Models\SettingsModel;
use App\Models\DimensiModel;
use App\Models\CatatanProsesWBModel;
use App\Models\NilaiPointModel;
use App\Utils\Misc;
use Illuminate\Support\Facades\DB;

use Constant;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Cache;

class RaportService
{
    public function __construct() {}

    // Fungsi-fungsi helper untuk konversi kelas
    public function getTingkatan(int $kelas): int
    {
        $arr_tingkatan = [1, 1, 1, 2, 2, 2, 3, 3, 4, 5, 5, 6];
        return $arr_tingkatan[$kelas - 1] ?? 1;
    }

    public function getPaket(int $kelas): string
    {
        $arr_paket = ['A', 'A', 'A', 'A', 'A', 'A', 'B', 'B', 'B', 'C', 'C', 'C'];
        return $arr_paket[$kelas - 1] ?? 'A';
    }

    public function getKelasAwalDalamTingkatan(int $tingkatan): int
    {
        $arr_start_kelas = [1, 4, 7, 9, 10, 12];
        return $arr_start_kelas[$tingkatan - 1] ?? 1;
    }

    public function getPaketKompetensiByKelas(int $kelas, int $semester): string
    {
        $tingkatan = $this->getTingkatan($kelas);
        $start_kelas = $this->getKelasAwalDalamTingkatan($tingkatan);

        return $tingkatan . '.' . ((($kelas - $start_kelas) * 2) + $semester);
    }

    public function konversiKelasInfo(?int $kelas, ?int $semester): array
    {
        if (!$kelas || !$semester || $kelas < 1 || $kelas > 12 || $semester < 1 || $semester > 2) {
            return [];
        }

        return [
            'kelas' => $kelas,
            'semester' => $semester,
            'tingkatan' => $this->getTingkatan($kelas),
            'paket' => $this->getPaket($kelas),
            'romawi' => Misc::integerToRoman($kelas),
            'paket_kompetensi' => $this->getPaketKompetensiByKelas($kelas, $semester)
        ];
    }

    public function getData(array $data): ?array
    {
        set_time_limit(300); // Set timeout 5 menit khusus untuk proses ini

        try {
            // 1. Ambil data kelas warga belajar dengan eager loading
            $kelas_wb = $this->getKelasWbData($data);
            if (!$kelas_wb) {
                Log::error('Kelas WB tidak ditemukan', ['data' => $data]);
                return null;
            }

            // 2. Konversi info kelas
            $kelasInfo = $this->konversiKelasInfo(
                $kelas_wb->kelas_detail->kelas,
                $kelas_wb->kelas_detail->semester
            );
            if (empty($kelasInfo)) {
                Log::error('Konversi kelas info gagal', ['kelas_wb' => $kelas_wb]);
                return null;
            }

            // 3. Data kelas pertama siswa dengan optimasi query
            $kelasPertama = $this->getKelasPertamaSiswa($kelas_wb->wb_detail->id);
            if (!$kelasPertama) {
                Log::warning('Kelas pertama tidak ditemukan', ['wb_id' => $kelas_wb->wb_detail->id]);
                // Tidak return null karena mungkin tidak critical
            }

            // 4. Kumpulkan data nilai dengan chunking
            $nilaiData = $this->kumpulkanDataNilaiDenganChunking($kelas_wb);

            // 5. Hitung modul dengan caching
            $modulData = Cache::remember(
                "modul-{$kelasInfo['kelas']}-{$kelasInfo['semester']}",
                now()->addDay(),
                function () use ($kelasInfo) {
                    return $this->hitungDataModul($kelasInfo['kelas'], $kelasInfo['semester']);
                }
            );

            // 6. Generate catatan
            $catatan = $this->generateCatatan(
                $kelasInfo['kelas'],
                $kelasInfo['semester'],
                $kelas_wb->wb_detail->nama,
                $kelasInfo['paket_kompetensi']
            );

            // 7. Data TTD dengan caching
            $data_ttd = Cache::remember(
                "ttd-{$kelas_wb->kelas_id}",
                now()->addHours(6),
                function () use ($kelas_wb) {
                    return $this->getDataTtd($kelas_wb->kelas_id);
                }
            );

            // 8. Siapkan data akhir
            return $this->prepareFinalData(
                $kelas_wb,
                $kelasInfo,
                $kelasPertama,
                $nilaiData,
                $modulData,
                $catatan,
                $data_ttd
            );
        } catch (\Exception $e) {
            Log::error('Error dalam RaportService: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString(),
                'data' => $data
            ]);
            return null;
        }
    }

    private function getKelasWbData(array $data): ?KelasWbModel
    {
        $query = KelasWbModel::with([
            'wb_detail:id,nama',
            'kelas_detail:id,kelas,semester,jenis_rapor,tahun_akademik_id,paket_kelas_id',
            'kelas_detail.paket_kelas:id,nama',
            'kelas_detail.tahun_akademik:id,id,tgl_raport' // tambahkan ini!
        ]);

        if (!empty($data['kelas_wb_id'])) {
            return $query->select(['id', 'kelas_id', 'wb_id'])
                ->find($data['kelas_wb_id']);
        }

        if (!empty($data['ppdb_id']) && !empty($data['kelas_id'])) {
            return $query->select(['id', 'kelas_id', 'wb_id'])
                ->where('wb_id', $data['ppdb_id'])
                ->where('kelas_id', $data['kelas_id'])
                ->first();
        }

        return null;
    }

    private function getKelasPertamaSiswa(int $ppdbId): ?object
    {
        $rombel = RombelModel::where('ppdb_id', $ppdbId)
            ->select(['kelas_id', 'tahun_akademik_id'])
            ->with(['kelas:id,kelas'])
            ->orderBy('tahun_akademik_id', 'ASC')
            ->first();

        if (!$rombel || !$rombel->kelas) {
            return null;
        }

        return (object) [
            'kelas' => $rombel->kelas->kelas,
            'romawi' => Misc::integerToRoman($rombel->kelas->kelas),
            'tingkatan' => $this->getTingkatan($rombel->kelas->kelas)
        ];
    }

    private function kumpulkanDataNilaiDenganChunking(KelasWbModel $kelas_wb): array
    {
        $nilaiData = [
            'ekstrakurikuler' => [],
            'nilai_kegiatan' => [],
            'kmp' => [],
            'nilai' => [
                'sikap' => [
                    'spiritual' => null,
                    'spiritual_desc' => null,
                    'sosial' => null,
                    'sosial_desc' => null,
                ],
                'pengetahuan' => [
                    'kelompok_umum' => [],
                    'mia' => [],
                    'iis' => [],
                    'kelompok_khusus' => [
                        'pemberdayaan' => [],
                        'keterampilan_wajib' => [],
                        'keterampilan_pilihan' => [],
                    ]
                ],
                'keterampilan' => [
                    'kelompok_umum' => [],
                    'mia' => [],
                    'iis' => [],
                    'kelompok_khusus' => [
                        'pemberdayaan' => [],
                        'keterampilan_wajib' => [],
                        'keterampilan_pilihan' => [],
                    ]
                ]
            ]
        ];

        // Proses ekstrakurikuler
        $nilaiData['ekstrakurikuler'] = $this->prosesEkstrakurikuler($kelas_wb);
        $nilaiData['nilai_kegiatan'] = $this->getNilaiKegiatan($kelas_wb->id);

        // Proses mata pelajaran dengan chunking
        $this->prosesMataPelajaranDenganChunking($kelas_wb, $nilaiData);

        return $nilaiData;
    }

    private function prosesEkstrakurikuler(KelasWbModel $kelas_wb): array
    {
        return EkstrakurikulerModel::where('kwb_id', $kelas_wb->id)
            ->select(['kegiatan', 'predikat', 'deskripsi'])
            ->get()
            ->toArray();
    }

    private function getNilaiKegiatan(int $kelas_wb_id)
    {
        return NilaiKegiatanModel::where('kwb_id', $kelas_wb_id)
            ->select(['jenis_kegiatan', 'prestasi'])
            ->get();
    }


    private function prosesMataPelajaranDenganChunking(KelasWbModel $kelas_wb, array &$nilaiData): void
    {
        $countMK = 0;
        $sumAVG = 0;
        $chunkSize = 200; // Sesuaikan dengan kebutuhan

        KelasMataPelajaranModel::from('kelas_mata_pelajaran as kmp')
            ->select(DB::raw($this->getNilaiSelectColumns()))
            ->with(['kmp_setting', 'mata_pelajaran_detail'])
            ->leftJoin('nilai', function ($join) use ($kelas_wb) {
                $join->on('nilai.kelas_id', '=', 'kmp.kelas_id')
                    ->on('nilai.kmp_id', '=', 'kmp.id')
                    ->where('nilai.wb_id', '=', $kelas_wb->wb_id);
            })
            ->where('kmp.kelas_id', $kelas_wb->kelas_id)
            ->orderBy('kmp.id', 'asc') //
            ->chunk($chunkSize, function ($kmpChunk) use (&$nilaiData, &$countMK, &$sumAVG, $kelas_wb) {
                foreach ($kmpChunk as $mp) {
                    $this->prosesMataPelajaran($mp, $kelas_wb, $nilaiData, $countMK, $sumAVG);
                }
            });


        // Hitung total rata-rata dengan pengecekan pembagian nol
        $totalAVG = $countMK > 0 ? $sumAVG / $countMK : 0;

        // Tambahkan catatan berdasarkan totalAVG
        $nilaiData['nilai']['catatan_pj_rombel'] = $this->getCatatanPjRombel($totalAVG, $kelas_wb->wb_detail->nama);
    }

    private function getNilaiSelectColumns(): string
    {
        return 'kmp.*,
            nilai.kelas_id, nilai.kmp_id, nilai.wb_id,
            nilai.p_tugas_1, nilai.p_ujian_1, nilai.p_nilai_1, nilai.p_predikat_1,
            nilai.k_nilai_1, nilai.k_predikat_1,
            nilai.p_tugas_2, nilai.p_ujian_2, nilai.p_nilai_2, nilai.p_predikat_2,
            nilai.k_nilai_2, nilai.k_predikat_2,
            nilai.p_tugas_3, nilai.p_ujian_3, nilai.p_nilai_3, nilai.p_predikat_3,
            nilai.k_nilai_3, nilai.k_predikat_3,
            nilai.sikap_spiritual, nilai.sikap_spiritual_desc,
            nilai.sikap_sosial, nilai.sikap_sosial_desc,
            nilai.capaian_kompetensi,
            nilai.p_susulan_1, nilai.p_susulan_2, nilai.p_susulan_3,
            nilai.k_susulan_1, nilai.k_susulan_2, nilai.k_susulan_3,
            nilai.p_remedial_1, nilai.p_remedial_2, nilai.p_remedial_3,
            nilai.k_remedial_1, nilai.k_remedial_2, nilai.k_remedial_3';
    }

    private function prosesMataPelajaran($mp, KelasWbModel $kelas_wb, array &$nilai, int &$countMK, float &$sumAVG): void
    {
        $jumlah_modul = $mp->kmp_setting->jumlah_modul ?? 3;
        $kelasNum = $kelas_wb->kelas_detail->kelas;
        $semester = $kelas_wb->kelas_detail->semester;

        // Proses nilai pengetahuan
        $np = $this->formatNilaiPengetahuan($mp, $kelasNum, $semester, $jumlah_modul);

        // Proses nilai keterampilan
        $nk = $this->formatNilaiKeterampilan($mp, $kelasNum, $semester, $jumlah_modul);

        // Proses sikap
        $this->prosesSikap($mp, $kelas_wb, $nilai['nilai']);

        // Kelompokkan mata pelajaran
        if ($mp->mata_pelajaran_detail) {
            $this->kelompokkanMataPelajaran($mp, $np, $nk, $nilai['nilai'], $countMK, $sumAVG);
        }

        // Tambahkan ke data kmp
        $nilai['kmp'][] = $mp;
    }

    private function formatNilaiPengetahuan($mp, int $kelasNum, int $semester, int $jumlah_modul): array
    {
        $nilai = [
            'kmp_id' => $mp->id,
            'kkm' => $mp->kmp_setting->kkm ?? null,
            'skk' => $mp->kmp_setting->skk ?? null,
            'setting' => $mp->kmp_setting ?? null,
            'mp_name' => $mp->mata_pelajaran_detail->nama ?? '-',
            'nilai_1' => number_format($mp->p_nilai_1, 2),
            'nilai_2' => number_format($mp->p_nilai_2, 2),
            'nilai_3' => number_format($mp->p_nilai_3, 2),
            'predikat_1' => $mp->p_predikat_1,
            'predikat_2' => $mp->p_predikat_2,
            'predikat_3' => $mp->p_predikat_3,
            'jumlah_modul' => $jumlah_modul,
            'capaian_kompetensi' => $mp->capaian_kompetensi
        ];

        // Handle nilai khusus untuk kelas tertentu
        $this->handleNilaiKhusus($mp, $kelasNum, $semester, $nilai, 'p');

        // Hitung rata-rata
        $nilai['avg'] = $this->hitungRataRataNilai($mp, $kelasNum, $semester, 'p', $jumlah_modul);

        return $nilai;
    }

    private function formatNilaiKeterampilan($mp, int $kelasNum, int $semester, int $jumlah_modul): array
    {
        $nilai = [
            'kmp_id' => $mp->id,
            'kkm' => $mp->kmp_setting->kkm ?? null,
            'skk' => $mp->kmp_setting->skk ?? null,
            'setting' => $mp->kmp_setting ?? null,
            'mp_name' => $mp->mata_pelajaran_detail->nama ?? '-',
            'nilai_1' => number_format($mp->k_nilai_1, 2),
            'nilai_2' => number_format($mp->k_nilai_2, 2),
            'nilai_3' => number_format($mp->k_nilai_3, 2),
            'predikat_1' => $mp->k_predikat_1,
            'predikat_2' => $mp->k_predikat_2,
            'predikat_3' => $mp->k_predikat_3,
            'jumlah_modul' => $jumlah_modul,
        ];

        // Handle nilai khusus untuk kelas tertentu
        $this->handleNilaiKhusus($mp, $kelasNum, $semester, $nilai, 'k');

        // Hitung rata-rata
        $nilai['avg'] = $this->hitungRataRataNilai($mp, $kelasNum, $semester, 'k', $jumlah_modul);

        return $nilai;
    }

    private function handleNilaiKhusus($mp, int $kelasNum, int $semester, array &$nilai, string $prefix): void
    {
        $mapelKhusus = [
            12 => ["Pendidikan Pancasila dan Kewarganegaraan (PPKn)", "Matematika"],
            6 => ["Pendidikan Pancasila dan Kewarganegaraan (PPKn)", "Ilmu Pengetahuan Sosial"],
            5 => ["Pendidikan Pancasila dan Kewarganegaraan (PPKn)"]
        ];

        if ($semester == 2 && isset($mapelKhusus[$kelasNum])) {
            $mapel = $mp->mata_pelajaran_detail->nama ?? '';
            if (in_array($mapel, $mapelKhusus[$kelasNum])) {
                $nilai['nilai_2'] = '-';
                $nilai['predikat_2'] = '-';
            }
        }
    }

    private function hitungRataRataNilai($mp, int $kelasNum, int $semester, string $prefix, int $jumlah_modul): string
    {
        $mapelKhusus = [
            12 => ["Pendidikan Pancasila dan Kewarganegaraan (PPKn)", "Matematika"],
            6 => ["Pendidikan Pancasila dan Kewarganegaraan (PPKn)", "Ilmu Pengetahuan Sosial"],
            5 => ["Pendidikan Pancasila dan Kewarganegaraan (PPKn)"]
        ];

        $mapel = $mp->mata_pelajaran_detail->nama ?? '';

        if ($semester == 2 && isset($mapelKhusus[$kelasNum])) {
            if (in_array($mapel, $mapelKhusus[$kelasNum])) {
                return number_format((float) $mp->{$prefix . '_nilai_1'}, 2, '.', '');
            }
        }

        $total = $mp->{$prefix . '_nilai_1'} + $mp->{$prefix . '_nilai_2'} + $mp->{$prefix . '_nilai_3'};
        return number_format((float) $total / $jumlah_modul, 2, '.', '');
    }

    private function prosesSikap($mp, KelasWbModel $kelas_wb, array &$nilai): void
    {
        if ($mp->sikap_spiritual == 'A') {
            $nilai['sikap']['spiritual'] = 'A';
            $nilai['sikap']['spiritual_desc'] = 'Ananda ' . $kelas_wb->wb_detail->nama .
                ' sudah sangat baik dalam bersikap religius, berperilaku syukur, berdoa sebelum dan sesudah melakukan kegiatan, dan bertoleransi antar umat beragama.';
        } elseif (empty($nilai['sikap']['spiritual']) && $mp->sikap_spiritual == 'B') {
            $nilai['sikap']['spiritual'] = 'B';
            $nilai['sikap']['spiritual_desc'] = 'Ananda ' . $kelas_wb->wb_detail->nama .
                ' sudah baik dalam bersikap religius, berperilaku syukur, berdoa sebelum dan sesudah melakukan kegiatan, dan bertoleransi antar umat beragama.';
        }

        if ($mp->sikap_sosial == 'A') {
            $nilai['sikap']['sosial'] = 'A';
            $nilai['sikap']['sosial_desc'] = 'Ananda ' . $kelas_wb->wb_detail->nama .
                ' sudah sangat baik dalam bersikap jujur, tindakan, dan pekerjaan, serta memiliki tingkat kedisiplinan yang baik dalam mengerjakan ujian dan mengumpulkan tugas';
        } elseif (empty($nilai['sikap']['sosial']) && $mp->sikap_sosial == 'B') {
            $nilai['sikap']['sosial'] = 'B';
            $nilai['sikap']['sosial_desc'] = 'Ananda ' . $kelas_wb->wb_detail->nama .
                ' sudah baik dalam bersikap jujur, tindakan, dan pekerjaan, serta memiliki tingkat kedisiplinan yang baik dalam mengerjakan ujian dan mengumpulkan tugas';
        }
    }

    private function kelompokkanMataPelajaran($mp, array $np, array $nk, array &$nilai, int &$countMK, float &$sumAVG): void
    {
        switch ($mp->mata_pelajaran_detail->kelompok) {
            case 'kelompok_umum':
                $nilai['pengetahuan']['kelompok_umum'][] = $np;
                $nilai['keterampilan']['kelompok_umum'][] = $nk;
                $sumAVG += $np['avg'] + $nk['avg'];
                $countMK += 2;
                break;

            case 'kelompok_khusus':
                $subKelompok = $mp->mata_pelajaran_detail->sub_kelompok;
                if (in_array($subKelompok, ['pemberdayaan', 'keterampilan_wajib', 'keterampilan_pilihan'])) {
                    $nilai['pengetahuan']['kelompok_khusus'][$subKelompok][] = $np;
                    $nilai['keterampilan']['kelompok_khusus'][$subKelompok][] = $nk;
                    $sumAVG += $np['avg'] + $nk['avg'];
                    $countMK += 2;
                }
                break;

            case 'mia':
                $np_peminatan = $this->formatNilaiPeminatan($np, $mp, 'p');
                $nk_peminatan = $this->formatNilaiPeminatan($nk, $mp, 'k');
                $nilai['pengetahuan']['mia'][] = $np_peminatan;
                $nilai['keterampilan']['mia'][] = $nk_peminatan;
                $sumAVG += $np_peminatan['avg'] + $nk_peminatan['avg'];
                $countMK += 2;
                break;

            case 'iis':
                $np_peminatan = $this->formatNilaiPeminatan($np, $mp, 'p');
                $nk_peminatan = $this->formatNilaiPeminatan($nk, $mp, 'k');
                $nilai['pengetahuan']['iis'][] = $np_peminatan;
                $nilai['keterampilan']['iis'][] = $nk_peminatan;
                $sumAVG += $np_peminatan['avg'] + $nk_peminatan['avg'];
                $countMK += 2;
                break;
        }
    }

    private function formatNilaiPeminatan(array $nilai, $mp, string $prefix): array
    {
        $nilai['nilai_2'] = number_format($mp->{$prefix . '_nilai_2'}, 2);
        $nilai['predikat_2'] = $mp->{$prefix . '_predikat_2'};
        $nilai['avg'] = number_format((float)(
            $mp->{$prefix . '_nilai_1'} +
            $mp->{$prefix . '_nilai_2'} +
            $mp->{$prefix . '_nilai_3'}
        ) / ($mp->kmp_setting->jumlah_modul ?? 3), 2, '.', '');

        return $nilai;
    }

    private function getCatatanPjRombel(float $totalAVG, string $nama): string
    {
        if ($totalAVG <= 70) {
            return "Terus semangat belajar untuk tingkatkan kemampuanmu";
        } elseif ($totalAVG <= 80) {
            return "Tingkatkan terus kemampuanmu untuk meraih prestasi yang lebih tinggi";
        } else {
            return "Pertahankan prestasimu yang sudah baik, namun tetaplah belajar hingga meraih prestasi yang lebih tinggi";
        }
    }

    private function hitungDataModul(int $kelasNum, int $semester): array
    {
        $modulStartFrom = 1;
        $maximumModul = 3;

        if ($kelasNum % 3 == 1) {
            $modulStartFrom = $semester == 1 ? 1 : 4;
        } elseif ($kelasNum % 3 == 2) {
            $modulStartFrom = $semester == 1 ? 6 : 9;
        } else {
            $modulStartFrom = $semester == 1 ? 11 : 14;
        }

        return [
            'start_from' => $modulStartFrom,
            'maximum_modul' => $maximumModul
        ];
    }

    private function generateCatatan(int $kelasNum, int $semester, string $nama, string $kompetensi): ?string
    {
        if ($semester % 2 != 0) {
            return null;
        }

        if ($kelasNum == 6 || $kelasNum == 9) {
            return "Selamat atas kelulusan ananda " . strtoupper($nama) .
                ", semakin rajin belajar di jenjang berikutnya dan semakin gigih dalam meraih cita-cita yang diimpikan.";
        }

        if ($kelasNum == 12) {
            return "Selamat atas kelulusan ananda " . strtoupper($nama) .
                ", semakin semangat belajar di kehidupan nyata dan semakin gigih dalam meraih cita-cita yang diimpikan.";
        }

        $kelasLanjutan = $kelasNum + 1;
        $pkLanjutan = $this->getPaketKompetensiByKelas($kelasLanjutan, 1);

        return "Berdasarkan pencapaian prestasi ananda pada Paket Kompetensi " . $kompetensi .
            " (setara kelas " . Misc::integerToRoman($kelasNum) . ") maka ananda " .
            strtoupper($nama) . " dinyatakan dapat melanjutkan ke Paket Kompetensi " .
            $pkLanjutan . " (setara kelas " . Misc::integerToRoman($kelasLanjutan) . ")";
    }

    private function getDataTtd(int $kelas_id): array
    {
        // Cari data spesifik kelas dulu
        $raportSetting = RaportSettingModel::where('kelas_id', $kelas_id)->first();

        // Jika tidak ditemukan, cari data dengan kelas_id NULL
        if (!$raportSetting) {
            $raportSetting = RaportSettingModel::whereNull('kelas_id')->first();
        }

        $data_ttd = $raportSetting ? $raportSetting->toArray() : [];

        // Tambahkan data dari SettingsModel
        $data_ttd['nip_ketua_pkbm'] = SettingsModel::getValue('nip_kepala_pkbm', '');
        $data_ttd['url_ttd_ketua'] = SettingsModel::getValue('ttd_kepala_pkbm', '');

        return $data_ttd;
    }

    private function prepareFinalData(
        KelasWbModel $kelas_wb,
        array $kelasInfo,
        ?object $kelasPertama,
        array $nilaiData,
        array $modulData,
        ?string $catatan,
        array $data_ttd
    ): array {
        $catatanPerkembangan = [
            'catatan_perkembangan_profil_pelajar' => $kelas_wb->catatan_perkembangan_profil_pelajar ?? '',
            'catatan_perkembangan_pemberdayaan' => $kelas_wb->catatan_perkembangan_pemberdayaan ?? '',
            'catatan_perkembangan_keterampilan' => $kelas_wb->catatan_perkembangan_keterampilan ?? '',
        ];

        return [
            'kelas_wb' => $kelas_wb,
            'kmp' => $nilaiData['kmp'],
            'kelas_num' => $kelasInfo['kelas'],
            'kelas_romawi' => $kelasInfo['romawi'],
            'semester' => $kelasInfo['semester'],
            'tingkatan' => $kelasInfo['tingkatan'],
            'kompetensi' => $kelasInfo['paket_kompetensi'],
            'kelas_diterima' => $kelasPertama->romawi ?? null,
            'tingkatan_diterima' => $kelasPertama->tingkatan ?? null,
            'data_modul' => $modulData,
            'nilai' => $nilaiData['nilai'],
            'total_avg' => $nilaiData['nilai']['total_avg'] ?? 0,
            'nilai_kegiatan' => $nilaiData['nilai_kegiatan'],
            'catatan_pj_rombel' => $nilaiData['nilai']['catatan_pj_rombel'] ?? '',
            'catatan' => $catatan,
            'catatan_perkembangan' => $catatanPerkembangan,
            'ekstrakurikuler' => $nilaiData['ekstrakurikuler'],
            'data_ttd' => $data_ttd,
            'fase' => $this->getFase($kelasInfo['kelas']),
            'dimensis' => $this->getDimensiData($kelas_wb->id, $kelasInfo['kelas']),
            'catatan_proses' => CatatanProsesWBModel::where('kelas_wb_id', $kelas_wb->id)->get(),
            'nilai_point' => NilaiPointModel::with([
                'point:id,point_name,elemen_id',
                'point.elemen:id,elemen_name,dimensi_id',
                'point.elemen.dimensi:id,dimensi_name'
            ])->where('kelas_wb_id', $kelas_wb->id)->get(),
            'presensi' => KelasWbModel::find($kelas_wb->id)->first(['izin', 'sakit', 'alpa'])->toArray()
        ];
    }

    private function getFase(int $kelasNum): ?string
    {
        foreach (Constant::FASE_MAPPING as $key => $values) {
            if (in_array($kelasNum, $values)) {
                return $key;
            }
        }
        return null;
    }

    private function getDimensiData(int $kelas_wb_id, int $kelasNum): array
    {
        $fase = $this->getFase($kelasNum);

        return DimensiModel::with(['elemens.points' => function ($query) use ($fase) {
            $query->select('point.*', 'nilai_point.point_nilai')
                ->leftJoin('nilai_point', 'point.id', '=', 'nilai_point.point_id');

            if ($fase) {
                $query->where('point.fase', $fase);
            }
        }])->get()->toArray();
    }
}
