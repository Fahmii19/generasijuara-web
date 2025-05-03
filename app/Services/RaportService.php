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

/**
 * 
 */
class RaportService
{
    function __construct()
    {
        
    }

    function getTingkatan($kelas) : int {
        $arr_tingkatan = [1,1,1,2,2,2,3,3,4,5,5,6];
        return $arr_tingkatan[$kelas-1];
    }

    function getPaket($kelas) : string {
        $arr_paket = ['A','A','A','A','A','A','B','B','B','C','C','C'];
        return $arr_paket[$kelas-1];
    }

    function getKelasAwalDalamTingkatan($tingkatan) : int {
        $arr_start_kelas = [1,4,7,9,10,12];
        return $arr_start_kelas[$tingkatan-1];
    }

    function getPaketKompetensiByKelas($kelas, $semester) : string {
        $tingkatan = $this->getTingkatan($kelas);
        $start_kelas = $this->getKelasAwalDalamTingkatan($tingkatan);

        $paket_kompetensi = $tingkatan.'.';
        $paket_kompetensi .= (($kelas - $start_kelas) * 2) + $semester;

        return $paket_kompetensi;
    }

    public function konversiKelasInfo($kelas, $semester) : array {
        if ($kelas && $semester) {
            if ($kelas < 1 || $kelas > 12 || $semester < 1 || $semester > 2) return [];
            
            $paket = $this->getPaket($kelas);
            $tingkatan = $this->getTingkatan($kelas);
            $romawi = Misc::integerToRoman($kelas);
            $paket_kompetensi = $this->getPaketKompetensiByKelas($kelas, $semester);
            $result = compact('kelas', 'semester', 'tingkatan', 'paket', 'romawi', 'paket_kompetensi');

            // echo json_encode($result)."\n";
            return $result;
        }
        return [];
    }

    public function getData(array $data)
    {
        if (!empty($data['kelas_wb_id'])) {
            $kelas_wb = KelasWbModel::with([
                'wb_detail',
                'kelas_detail',
                'kelas_detail.paket_kelas',
            ])->find($data['kelas_wb_id']); 
        }
        elseif (!empty($data['ppdb_id']) && !empty($data['kelas_id'])) {
            $kelas_wb = KelasWbModel::with([
                'wb_detail',
                'kelas_detail',
                'kelas_detail.paket_kelas',
            ])
            ->where('wb_id', $data['ppdb_id'])
            ->where('kelas_id', $data['kelas_id'])
            ->first(); 
        }

        if (!$kelas_wb) {
            return null;
        }

        // kelas saat ini
        $konversiKelasData = $this->konversiKelasInfo($kelas_wb->kelas_detail->kelas, $kelas_wb->kelas_detail->semester);
        $tingkatan = $konversiKelasData['tingkatan'];
        $kompetensi = $konversiKelasData['paket_kompetensi'];
        $kelasNum = $konversiKelasData['kelas'];
        $semester = $konversiKelasData['semester'];
        $kelas_romawi = $konversiKelasData['romawi'];

        // kelas pertama siswa
        $kelasDiterimaNum = RombelModel::where('ppdb_id', $kelas_wb->wb_detail->id)
                                ->leftJoin('kelas', 'kelas.id', '=', 'rombel.kelas_id')
                                ->orderBy('rombel.tahun_akademik_id', 'ASC')
                                ->first()
                                ->kelas;
        $kelasDiterimaRomawi = Misc::integerToRoman($kelasDiterimaNum);
        $tingkatanDiterima = $this->getTingkatan($kelasDiterimaNum);

        // data nilai
        $ekstrakurikuler = EkstrakurikulerModel::where('kwb_id', $kelas_wb->id)->select(['kegiatan', 'predikat', 'deskripsi'])->get()->toArray();

        $nilai_kegiatan = NilaiKegiatanModel::where('kwb_id', $kelas_wb->id)->get();
        $kmp = KelasMataPelajaranModel::from('kelas_mata_pelajaran as kmp')
            ->select(DB::raw(
                'kmp.* , 
                nilai.kelas_id ,
                nilai.kmp_id ,
                nilai.wb_id ,
                nilai.p_tugas_1 ,
                nilai.p_ujian_1 ,
                nilai.p_nilai_1 ,
                nilai.p_predikat_1 ,
                nilai.k_nilai_1 ,
                nilai.k_predikat_1 ,
                nilai.p_tugas_2 ,
                nilai.p_ujian_2 ,
                nilai.p_nilai_2 ,
                nilai.p_predikat_2 ,
                nilai.k_nilai_2 ,
                nilai.k_predikat_2 ,
                nilai.p_tugas_3 ,
                nilai.p_ujian_3 ,
                nilai.p_nilai_3 ,
                nilai.p_predikat_3 ,
                nilai.k_nilai_3 ,
                nilai.k_predikat_3 ,
                nilai.sikap_spiritual ,
                nilai.sikap_spiritual_desc ,
                nilai.sikap_sosial ,
                nilai.sikap_sosial_desc ,
                nilai.capaian_kompetensi ,
                nilai.p_susulan_1 ,
                nilai.p_susulan_2 ,
                nilai.p_susulan_3 ,
                nilai.k_susulan_1 ,
                nilai.k_susulan_2 ,
                nilai.k_susulan_3 ,
                nilai.p_remedial_1 ,
                nilai.p_remedial_2 ,
                nilai.p_remedial_3 ,
                nilai.k_remedial_1 ,
                nilai.k_remedial_2 ,
                nilai.k_remedial_3'
            ))
            ->with([
                'kmp_setting',
                'mata_pelajaran_detail'
            ])
            ->leftJoin('nilai', function($join) use($kelas_wb)
            {
                $join->on('nilai.kelas_id', '=', 'kmp.kelas_id');
                $join->on('nilai.kmp_id', '=', 'kmp.id');
                $join->where('nilai.wb_id', '=', $kelas_wb->wb_id);
            })
            ->where('kmp.kelas_id', $kelas_wb->kelas_id)
            ->get();

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

        // define mapel ekskul
        $final_ekskul = [];

        $countMK = 0;
        $sumAVG = 0;
        foreach ($kmp as $key => $mp) {
            if ($kelas_wb->kelas_detail->jenis_rapor == 'merdeka' && $mp->mata_pelajaran_detail && $mp->mata_pelajaran_detail->is_mapel_ekskul) {
                $final_ekskul[] = [
                    'kegiatan' => $mp->mata_pelajaran_detail->nama,
                    'predikat' => $mp->p_predikat_1,
                    'deskripsi' => $mp->capaian_kompetensi
                ];
            }
            $jumlah_modul = !empty($mp->kmp_setting) ? $mp->kmp_setting->jumlah_modul : 3;

            // Define mapel untuk kelas 12 smt 2
            $mapel_ppkn = "Pendidikan Pancasila dan Kewarganegaraan (PPKn)";
            $mapel_matematika = "Matematika";

            // Define mapel untuk kelas 6 smt 2
            $mapel_ips = "Ilmu Pengetahuan Sosial";

            // Inisialisasi kebutuhan custom nilai
            $p_nilai_2 = number_format($mp->p_nilai_2, 2);
            $p_predikat_2 = $mp->p_predikat_2;
            $p_average = number_format((float)($mp->p_nilai_1 + $mp->p_nilai_2 + $mp->p_nilai_3)/$jumlah_modul, 2, '.', '');

            $k_nilai_2 = number_format($mp->k_nilai_2, 2);
            $k_predikat_2 = $mp->k_predikat_2;
            $k_average = number_format((float)($mp->k_nilai_1 + $mp->k_nilai_2 + $mp->k_nilai_3)/$jumlah_modul, 2, '.', '');

            // Kelas 12 smt 2, mapel ppkn & mtk tidak ada nilai 2
            if ($kelasNum == 12 && $semester == 2 && ($mp->mata_pelajaran_detail->nama == $mapel_ppkn || $mp->mata_pelajaran_detail->nama == $mapel_matematika)) {
                $p_nilai_2 = '-';
                $p_predikat_2 = '-';
                $p_average = number_format((float) $mp->p_nilai_1, 2, '.', '');

                $k_nilai_2 = '-';
                $k_predikat_2 = '-';
                $k_average = number_format((float) $mp->k_nilai_1, 2, '.', '');
            }

            // Kelas 6 smt 2, mapel ppkn & ips tidak ada nilai 2
            if ($kelasNum == 6 && $semester == 2 && ($mp->mata_pelajaran_detail->nama == $mapel_ppkn || $mp->mata_pelajaran_detail->nama == $mapel_ips)) {
                $p_nilai_2 = '-';
                $p_predikat_2 = '-';
                $p_average = number_format((float) $mp->p_nilai_1, 2, '.', '');

                $k_nilai_2 = '-';
                $k_predikat_2 = '-';
                $k_average = number_format((float) $mp->k_nilai_1, 2, '.', '');
            }

            // Kelas 5 smt 2, mapel ppkn tidak ada nilai 2
            if ($kelasNum == 5 && $semester == 2 && $mp->mata_pelajaran_detail->nama == $mapel_ppkn) {
                $p_nilai_2 = '-';
                $p_predikat_2 = '-';
                $p_average = number_format((float) $mp->p_nilai_1, 2, '.', '');

                $k_nilai_2 = '-';
                $k_predikat_2 = '-';
                $k_average = number_format((float) $mp->k_nilai_1, 2, '.', '');
            }

            $np = [
                'kmp_id' => @$mp->id,
                'kkm' => @$mp->kmp_setting->kkm,
                'skk' => @$mp->kmp_setting->skk,
                'setting' => @$mp->kmp_setting,
                'mp_name' => $mp->mata_pelajaran_detail ? $mp->mata_pelajaran_detail->nama : '-',
                'nilai_1' => number_format($mp->p_nilai_1, 2),
                'nilai_2' => $p_nilai_2, // kelas [5,6,12] smt 2, nilai 2 custom
                'nilai_3' => number_format($mp->p_nilai_3, 2),
                'predikat_1' => $mp->p_predikat_1,
                'predikat_2' => $p_predikat_2, // kelas [5,6,12] smt 2, nilai 2 custom
                'predikat_3' => $mp->p_predikat_3,
                'jumlah_modul' => $jumlah_modul,
                'avg' => $p_average,
                'capaian_kompetensi' => $mp->capaian_kompetensi
            ];

            $nk = [
                'kmp_id' => @$mp->id,
                'kkm' => @$mp->kmp_setting->kkm,
                'skk' => @$mp->kmp_setting->skk,
                'setting' => @$mp->kmp_setting,
                'mp_name' => $mp->mata_pelajaran_detail ? $mp->mata_pelajaran_detail->nama : '-',
                'nilai_1' => number_format($mp->k_nilai_1, 2),
                'nilai_2' => $k_nilai_2, // kelas [5,6,12] smt 2, nilai 2 custom
                'nilai_3' => number_format($mp->k_nilai_3, 2),
                'predikat_1' => $mp->k_predikat_1,
                'predikat_2' => $k_predikat_2, // kelas [5,6,12] smt 2, nilai 2 custom
                'predikat_3' => $mp->k_predikat_3,
                'jumlah_modul' => $jumlah_modul,
                'avg' => $k_average,
            ];

            // Nilai Peminatan MIA dan IIS
            $np_peminatan = $np;
            $nk_peminatan = $nk;

            $np_peminatan['nilai_2'] = number_format($mp->p_nilai_2, 2);
            $np_peminatan['predikat_2'] = $mp->p_predikat_2;
            $np_peminatan['avg'] = number_format((float)($mp->p_nilai_1 + $mp->p_nilai_2 + $mp->p_nilai_3)/$jumlah_modul, 2, '.', '');

            $nk_peminatan['nilai_2'] = number_format($mp->k_nilai_2, 2);
            $nk_peminatan['predikat_2'] = $mp->k_predikat_2;
            $nk_peminatan['avg'] = number_format((float)($mp->k_nilai_1 + $mp->k_nilai_2 + $mp->k_nilai_3)/$jumlah_modul, 2, '.', '');


            $countMK += 2;
            // $sumAVG += $np['avg'] + $nk['avg'];

            if ($mp->sikap_spiritual == 'A') {
                $nilai['sikap']['spiritual'] = 'A';
                $nilai['sikap']['spiritual_desc'] = 'Ananda '.$kelas_wb->wb_detail->nama.' sudah sangat baik dalam bersikap religius, berperilaku syukur, berdoa sebelum dan sesudah
                melakukan kegiatan, dan bertoleransi antar umat beragama.';
            }elseif (empty($nilai['sikap']['spiritual']) &&  $mp->sikap_spiritual == 'B') {
                $nilai['sikap']['spiritual'] = 'B';
                $nilai['sikap']['spiritual_desc'] = 'Ananda '.$kelas_wb->wb_detail->nama.' sudah baik dalam bersikap religius, berperilaku syukur, berdoa sebelum dan sesudah
                melakukan kegiatan, dan bertoleransi antar umat beragama.';
            }

            if ($mp->sikap_sosial == 'A') {
                $nilai['sikap']['sosial'] = 'A';
                $nilai['sikap']['sosial_desc'] = 'Ananda '.$kelas_wb->wb_detail->nama.' sudah sangat baik dalam bersikap jujur, tindakan, dan pekerjaan, serta memiliki tingkat kedisiplinan yang baik dalam mengerjakan ujian dan mengumpulkan tugas';
            }elseif (empty($nilai['sikap']['sosial']) &&  $mp->sikap_sosial == 'B') {
                $nilai['sikap']['sosial'] = 'B';
                $nilai['sikap']['sosial_desc'] = 'Ananda '.$kelas_wb->wb_detail->nama.' sudah baik dalam bersikap jujur, tindakan, dan pekerjaan, serta memiliki tingkat kedisiplinan yang baik dalam mengerjakan ujian dan mengumpulkan tugas';
            }
            
            if (!empty($mp->mata_pelajaran_detail)) {
                if ($mp->mata_pelajaran_detail->kelompok == 'kelompok_umum') {
                    $nilai['pengetahuan']['kelompok_umum'][] = $np;
                    $nilai['keterampilan']['kelompok_umum'][] = $nk;
                    $sumAVG += $np['avg'] + $nk['avg'];
                }elseif ($mp->mata_pelajaran_detail->kelompok == 'kelompok_khusus') {
                    $nilai['pengetahuan']['kelompok_khusus'][$mp->mata_pelajaran_detail->sub_kelompok][] = $np;
                    $nilai['keterampilan']['kelompok_khusus'][$mp->mata_pelajaran_detail->sub_kelompok][] = $nk;
                    $sumAVG += $np['avg'] + $nk['avg'];
                }elseif ($mp->mata_pelajaran_detail->kelompok == 'mia') {
                    $nilai['pengetahuan']['mia'][] = $np_peminatan;
                    $nilai['keterampilan']['mia'][] = $nk_peminatan;
                    $sumAVG += $np_peminatan['avg'] + $nk_peminatan['avg'];
                }elseif ($mp->mata_pelajaran_detail->kelompok == 'iis') {
                    $nilai['pengetahuan']['iis'][] = $np_peminatan;
                    $nilai['keterampilan']['iis'][] = $nk_peminatan;
                    $sumAVG += $np_peminatan['avg'] + $nk_peminatan['avg'];
                }
            }

        }

        $final_ekskul = array_merge($final_ekskul, $ekstrakurikuler);

        $totalAVG = $sumAVG / $countMK;
        $catatanPJRombel = null;
        if ($totalAVG <= 70) { // 0-70
            $catatanPJRombel = "Terus semangat belajar untuk tingkatkan kemampuanmu";
        }elseif ($totalAVG <= 80) { // 71-80
            $catatanPJRombel = "Tingkatkan terus kemampuanmu untuk meraih prestasi yang lebih tinggi tinggi";
        }elseif ($totalAVG <= 100) { // 81-100
            $catatanPJRombel = "Pertahankan prestasimu yang sudah baik, namun tetaplah belajar hingga meraih prestasi yang lebih tinggi";
        }

        $nilaiWajib = 0;
        $countWajib = count($nilai['pengetahuan']['kelompok_khusus']['keterampilan_wajib']);
        $kkm = 70;
        $skk = 0;
        foreach ($nilai['pengetahuan']['kelompok_khusus']['keterampilan_wajib'] as $key => $n) {
            $kkm = $n['kkm'];
            $skk += $n['skk'];
            $nilaiWajib += $n['nilai_1'];
        }

        $nilai['pengetahuan']['kelompok_khusus']['keterampilan_wajib'] = [
            'kkm' => $kkm,
            'skk' => $skk,
            'jumlah_modul' => 1,
            'nilai' => number_format((float) $nilaiWajib/$countWajib, 2),
            'predikat' => Misc::checkPredikat($nilaiWajib/$countWajib),
            'avg' => number_format($nilaiWajib/$countWajib, 2),
        ];

        $nilaiWajib = 0;
        $countWajib = count($nilai['keterampilan']['kelompok_khusus']['keterampilan_wajib']);
        $kkm = 70;
        $skk = 0;
        foreach ($nilai['keterampilan']['kelompok_khusus']['keterampilan_wajib'] as $key => $n) {
            $kkm = $n['kkm'];
            $skk += $n['skk'];
            $nilaiWajib += $n['nilai_1'];
        }

        $nilai['keterampilan']['kelompok_khusus']['keterampilan_wajib'] = [
            'kkm' => $kkm,
            'skk' => $skk,
            'jumlah_modul' => 1,
            'nilai' => number_format((float) $nilaiWajib/$countWajib, 2),
            'predikat' => Misc::checkPredikat($nilaiWajib/$countWajib),
            'avg' => number_format($nilaiWajib/$countWajib, 2),
        ];

        $modulStartFrom = 1;
        $maximumModul = 3;
        if ($kelasNum % 3 == 1 && $semester % 2 == 1) {
            $modulStartFrom = 1;
            $maximumModul = 3;
        } elseif ($kelasNum % 3 == 1 && $semester % 2 == 0) {
            $modulStartFrom = 4;
            $maximumModul = 3;
        } elseif ($kelasNum % 3 == 2 && $semester % 2 == 1) {
            $modulStartFrom = 6;
            $maximumModul = 3;
        } elseif ($kelasNum % 3 == 2 && $semester % 2 == 0) {
            $modulStartFrom = 9;
            $maximumModul = 3;
        } elseif ($kelasNum % 3 == 0 && $semester % 2 == 1) {
            $modulStartFrom = 11;
            $maximumModul = 3;
        } elseif ($kelasNum % 3 == 0 && $semester % 2 == 0) {
            $modulStartFrom = 14;
            $maximumModul = 3;
        }

        $data_modul = [
            'start_from' => $modulStartFrom,
            'maximum_modul' => $maximumModul
        ];

        // Catatan untuk raport semeter genap
        $catatan = null;
        if ($semester % 2 == 0) {
            if ($kelasNum == 6 || $kelasNum == 9) {
                $catatan = "Selamat atas kelulusan ananda ". strtoupper($kelas_wb->wb_detail->nama) .", semakin rajin belajar di jenjang berikutnya dan semakin gigih dalam meraih cita-cita yang diimpikan.";
            } elseif ($kelasNum == 12) {
                $catatan = "Selamat atas kelulusan ananda ". strtoupper($kelas_wb->wb_detail->nama) .", semakin semangat belajar di kehidupan nyata dan semakin gigih dalam meraih cita-cita yang diimpikan.";
            } else {

                $kelasLanjutan = $kelasNum+1;
                $pkLanjutan = $this->getPaketKompetensiByKelas($kelasLanjutan, 1);
                
                $catatan = "Berdasarkan pencapaian prestasi ananda pada Paket Kompetensi ". $kompetensi ." (setara kelas ".Misc::integerToRoman($kelasNum).
                ") maka ananda ". strtoupper($kelas_wb->wb_detail->nama) ." dinyatakan dapat melanjutkan ke Paket Kompetensi ".$pkLanjutan ." (setara kelas ". Misc::integerToRoman($kelasLanjutan). ")";
            }
            
        }

        // Data TTD Raport
        $data_ttd = RaportSettingModel::where('kelas_id', $kelas_wb->kelas_id)->first();
        $data_ttd['nip_ketua_pkbm'] = SettingsModel::where('key', 'nip_kepala_pkbm')->first()['value'];
        $data_ttd['url_ttd_ketua'] = SettingsModel::where('key', 'ttd_kepala_pkbm')->first()['value'];

        $catatanPerkembangan = [
            'catatan_perkembangan_profil_pelajar' => $kelas_wb['catatan_perkembangan_profil_pelajar'] ?? '',
            'catatan_perkembangan_pemberdayaan' => $kelas_wb['catatan_perkembangan_pemberdayaan'] ?? '',
            'catatan_perkembangan_keterampilan' => $kelas_wb['catatan_perkembangan_keterampilan'] ?? '',
        ];

        $data = [
            'kelas_wb' => $kelas_wb,
            'kmp' => $kmp,
            'kelas_num' => $kelasNum, 
            'kelas_romawi' => $kelas_romawi, 
            'semester' => $semester,
            'tingkatan' => $tingkatan,
            'kompetensi' => $kompetensi,
            'kelas_diterima' => $kelasDiterimaRomawi,
            'tingkatan_diterima' => $tingkatanDiterima,
            'data_modul' => $data_modul,
            'nilai' => $nilai,
            'total_avg' => $totalAVG,
            'nilai_kegiatan' => $nilai_kegiatan,
            'catatan_pj_rombel' => $catatanPJRombel,
            'catatan' => $catatan,
            'catatan_perkembangan' => $catatanPerkembangan,
            'ekstrakurikuler' => $final_ekskul,
            'data_ttd' => $data_ttd,
        ];

        $data['fase'] = null;
        foreach (Constant::FASE_MAPPING as $key => $values) {
            if (in_array($kelasNum, $values)) {
                $data['fase'] = $key;
                break;
            }
        }
        
        $data['dimensis'] = DimensiModel::with(['elemens.points' => function ($query) use ($data) {
            $query->select('point.*', 'nilai_point.point_nilai') // Memilih semua kolom dari 'point' dan 'point_nilai' dari 'nilai_point'
                ->leftJoin('nilai_point', 'point.id', '=', 'nilai_point.point_id'); // Left join ke 'nilai_point' berdasarkan 'point_id'
            if (isset($data['fase'])) {
                $query->where('point.fase', $data['fase']); // Kondisi where untuk 'fase' jika disediakan dalam $data
            }
        }])->get();
        $data['catatan_proses'] = CatatanProsesWBModel::where('kelas_wb_id', $kelas_wb->id)->get();
        $data['nilai_point'] = NilaiPointModel::where('kelas_wb_id', $kelas_wb->id)->get();
        $data['presensi'] = KelasWBModel::find($kelas_wb->id)->first(['izin', 'sakit','alpa'])->toArray();
        // dd($data);
        return $data;
    }
}