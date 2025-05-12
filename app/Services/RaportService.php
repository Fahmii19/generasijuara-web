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
use DB;
use Constant;
use Illuminate\Support\Facades\Log;

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
        try {
            // Cari data kelas warga belajar
            $kelas_wb = $this->getKelasWbData($data);
            if (!$kelas_wb) {
                Log::error('Kelas WB tidak ditemukan', ['data' => $data]);
                return null;
            }

            // Konversi info kelas
            $kelasInfo = $this->konversiKelasInfo(
                $kelas_wb->kelas_detail->kelas,
                $kelas_wb->kelas_detail->semester
            );
            if (empty($kelasInfo)) {
                Log::error('Konversi kelas info gagal', ['kelas_wb' => $kelas_wb]);
                return null;
            }

            // Data kelas pertama siswa
            $kelasPertama = $this->getKelasPertamaSiswa($kelas_wb->wb_detail->id);
            if (!$kelasPertama) {
                Log::error('Kelas pertama tidak ditemukan', ['wb_id' => $kelas_wb->wb_detail->id]);
                return null;
            }

            // Kumpulkan data nilai
            $nilaiData = $this->kumpulkanDataNilai($kelas_wb);

            // Hitung modul
            $modulData = $this->hitungDataModul($kelasInfo['kelas'], $kelasInfo['semester']);

            // Catatan untuk semester genap
            $catatan = $this->generateCatatan($kelasInfo['kelas'], $kelasInfo['semester'], $kelas_wb->wb_detail->nama, $kelasInfo['paket_kompetensi']);

            // Data TTD Raport
            $data_ttd = $this->getDataTtd($kelas_wb->kelas_id);

            // Siapkan data akhir
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

    // Fungsi-fungsi helper privat
    private function getKelasWbData(array $data): ?KelasWbModel
    {
        if (!empty($data['kelas_wb_id'])) {
            return KelasWbModel::with(['wb_detail', 'kelas_detail', 'kelas_detail.paket_kelas'])
                ->find($data['kelas_wb_id']);
        }

        if (!empty($data['ppdb_id']) && !empty($data['kelas_id'])) {
            return KelasWbModel::with(['wb_detail', 'kelas_detail', 'kelas_detail.paket_kelas'])
                ->where('wb_id', $data['ppdb_id'])
                ->where('kelas_id', $data['kelas_id'])
                ->first();
        }

        return null;
    }

    private function getKelasPertamaSiswa(int $ppdbId): ?object
    {
        $rombel = RombelModel::where('ppdb_id', $ppdbId)
            ->leftJoin('kelas', 'kelas.id', '=', 'rombel.kelas_id')
            ->orderBy('rombel.tahun_akademik_id', 'ASC')
            ->first(['kelas.kelas']);

        if (!$rombel) {
            return null;
        }

        return (object) [
            'kelas' => $rombel->kelas,
            'romawi' => Misc::integerToRoman($rombel->kelas),
            'tingkatan' => $this->getTingkatan($rombel->kelas)
        ];
    }

    private function kumpulkanDataNilai(KelasWbModel $kelas_wb): array
    {
        $ekstrakurikuler = EkstrakurikulerModel::where('kwb_id', $kelas_wb->id)
            ->select(['kegiatan', 'predikat', 'deskripsi'])
            ->get()
            ->toArray();

        $nilai_kegiatan = NilaiKegiatanModel::where('kwb_id', $kelas_wb->id)->get();

        $kmp = KelasMataPelajaranModel::from('kelas_mata_pelajaran as kmp')
            ->select(DB::raw($this->getNilaiSelectColumns()))
            ->with(['kmp_setting', 'mata_pelajaran_detail'])
            ->leftJoin('nilai', function ($join) use ($kelas_wb) {
                $join->on('nilai.kelas_id', '=', 'kmp.kelas_id')
                    ->on('nilai.kmp_id', '=', 'kmp.id')
                    ->where('nilai.wb_id', '=', $kelas_wb->wb_id);
            })
            ->where('kmp.kelas_id', $kelas_wb->kelas_id)
            ->get();

        $nilai = $this->prosesDataNilai($kmp, $kelas_wb);
        $final_ekskul = $this->prosesEkstrakurikuler($kmp, $kelas_wb, $ekstrakurikuler);

        return [
            'ekstrakurikuler' => $final_ekskul,
            'nilai_kegiatan' => $nilai_kegiatan,
            'kmp' => $kmp,
            'nilai' => $nilai
        ];
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

    private function prosesDataNilai($kmp, KelasWbModel $kelas_wb): array
    {
        $nilai = [
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
        ];

        $countMK = 0;
        $sumAVG = 0;

        foreach ($kmp as $mp) {
            $this->prosesMataPelajaran($mp, $kelas_wb, $nilai, $countMK, $sumAVG);
        }

        // Hitung total rata-rata dengan pengecekan pembagian nol
        $totalAVG = $countMK > 0 ? $sumAVG / $countMK : 0;

        // Tambahkan catatan berdasarkan totalAVG
        $nilai['catatan_pj_rombel'] = $this->getCatatanPjRombel($totalAVG, $kelas_wb->wb_detail->nama);

        // Proses nilai keterampilan wajib dengan pengecekan
        $this->prosesNilaiKeterampilanWajib($nilai);

        return $nilai;
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
        $this->prosesSikap($mp, $kelas_wb, $nilai);

        // Kelompokkan mata pelajaran
        if ($mp->mata_pelajaran_detail) {
            $this->kelompokkanMataPelajaran($mp, $np, $nk, $nilai, $countMK, $sumAVG);
        }
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

    private function prosesEkstrakurikuler($kmp, KelasWbModel $kelas_wb, array $ekstrakurikuler): array
    {
        $final_ekskul = [];

        foreach ($kmp as $mp) {
            if (
                $kelas_wb->kelas_detail->jenis_rapor == 'merdeka' &&
                $mp->mata_pelajaran_detail &&
                $mp->mata_pelajaran_detail->is_mapel_ekskul
            ) {
                $final_ekskul[] = [
                    'kegiatan' => $mp->mata_pelajaran_detail->nama,
                    'predikat' => $mp->p_predikat_1,
                    'deskripsi' => $mp->capaian_kompetensi
                ];
            }
        }

        return array_merge($final_ekskul, $ekstrakurikuler);
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

    private function prosesNilaiKeterampilanWajib(array &$nilai): void
    {
        $this->prosesKelompokKhusus($nilai['pengetahuan']['kelompok_khusus']['keterampilan_wajib'], 'pengetahuan');
        $this->prosesKelompokKhusus($nilai['keterampilan']['kelompok_khusus']['keterampilan_wajib'], 'keterampilan');
    }

    private function prosesKelompokKhusus(array &$kelompok, string $jenis): void
    {
        $nilaiWajib = 0;
        $countWajib = count($kelompok);
        $kkm = 70;
        $skk = 0;

        if ($countWajib === 0) {
            $kelompok = [
                'kkm' => 0,
                'skk' => 0,
                'jumlah_modul' => 0,
                'nilai' => 0,
                'predikat' => '-',
                'avg' => 0,
            ];
            return;
        }

        foreach ($kelompok as $n) {
            $kkm = $n['kkm'] ?? $kkm;
            $skk += $n['skk'] ?? 0;
            $nilaiWajib += $n['nilai_1'] ?? 0;
        }

        $avg = $nilaiWajib / $countWajib;

        $kelompok = [
            'kkm' => $kkm,
            'skk' => $skk,
            'jumlah_modul' => 1,
            'nilai' => number_format((float) $avg, 2),
            'predikat' => Misc::checkPredikat($avg),
            'avg' => number_format($avg, 2),
        ];
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
        $data_ttd = RaportSettingModel::where('kelas_id', $kelas_id)->first() ?? [];

        $data_ttd['nip_ketua_pkbm'] = SettingsModel::where('key', 'nip_kepala_pkbm')->first()->value ?? '';
        $data_ttd['url_ttd_ketua'] = SettingsModel::where('key', 'ttd_kepala_pkbm')->first()->value ?? '';

        return $data_ttd;
    }

    private function prepareFinalData(
        KelasWbModel $kelas_wb,
        array $kelasInfo,
        object $kelasPertama,
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

        $data = [
            'kelas_wb' => $kelas_wb,
            'kmp' => $nilaiData['kmp'],
            'kelas_num' => $kelasInfo['kelas'],
            'kelas_romawi' => $kelasInfo['romawi'],
            'semester' => $kelasInfo['semester'],
            'tingkatan' => $kelasInfo['tingkatan'],
            'kompetensi' => $kelasInfo['paket_kompetensi'],
            'kelas_diterima' => $kelasPertama->romawi,
            'tingkatan_diterima' => $kelasPertama->tingkatan,
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
            'nilai_point' => NilaiPointModel::where('kelas_wb_id', $kelas_wb->id)->get(),
            'presensi' => KelasWbModel::find($kelas_wb->id)->first(['izin', 'sakit', 'alpa'])->toArray()
        ];

        return $data;
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
