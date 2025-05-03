<?php

namespace App\Exports;

use App\Models\KelasWbModel;
use App\Models\MataPelajaranModel;
use App\Models\NilaiModel;
use App\Models\TahunAkademikModel;
use Exception;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\RegistersEventListeners;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Cell\DataType;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;

class LedgerExport implements FromArray, WithHeadings, WithMapping, WithColumnFormatting, ShouldAutoSize, WithEvents
{
    use Exportable, RegistersEventListeners;

    protected $tahun_akademik_id;
    protected $tahun_ajar;
    protected $kelas_num;
    protected $kode_paket;
    protected $tahunAkademik;
    protected $listWb;
    protected static $listMP;

    public function __construct($tahun_akademik_id, $kelas_num)
    {
        $this->tahun_akademik_id = $tahun_akademik_id;
        $this->kelas_num = $kelas_num;
        if ($kelas_num <= 6) {
            $this->kode_paket = 'PAKETA';
        } elseif ($kelas_num <= 9) {
            $this->kode_paket = 'PAKETB';
        } elseif ($kelas_num <= 12) {
            $this->kode_paket = 'PAKETC';
        }

        $this->tahunAkademik = TahunAkademikModel::find($this->tahun_akademik_id);
        $this->listWb = KelasWbModel::from('kelas as k')
            ->selectRaw('p.id, p.nis, p.nisn, p.nama as wb_name, p.kelamin, lk.kode')
            ->leftJoin('paket_kelas as pk', 'pk.id', '=', 'k.paket_kelas_id')
            ->leftJoin('tahun_akademik as ta', 'ta.id', '=', 'k.tahun_akademik_id')
            ->leftJoin('layanan_kelas as lk', 'lk.id', '=', 'k.layanan_kelas_id')
            ->leftJoin('kelas_wb as kwb', 'kwb.kelas_id', '=', 'k.id')
            ->leftJoin('ppdb as p', 'p.id', '=', 'kwb.wb_id')
            ->where('pk.kode', $this->kode_paket)
            ->where('ta.tahun_ajar', $this->tahunAkademik->tahun_ajar)
            ->where('p.tahun_akademik_id', $this->tahun_akademik_id)
            ->where('p.kelas', $this->kelas_num)
            ->groupBy('p.id')
            ->orderBy('p.nama');

        self::$listMP = MataPelajaranModel::from('mata_pelajaran as mp')
            ->selectRaw('distinct mp.*')
            ->leftJoin('kelas_mata_pelajaran as kmp', 'kmp.mata_pelajaran_id', '=', 'mp.id')
            ->leftJoin('kelas as k', 'k.id', '=', 'kmp.kelas_id')
            ->leftJoin('paket_kelas as pk', 'pk.id', '=', 'k.paket_kelas_id')
            ->leftJoin('tahun_akademik as ta', 'ta.id', '=', 'k.tahun_akademik_id')
            ->leftJoin('layanan_kelas as lk', 'lk.id', '=', 'k.layanan_kelas_id')
            ->where('pk.kode', $this->kode_paket)
            ->where('ta.tahun_ajar', $this->tahunAkademik->tahun_ajar)
            ->orderByRaw("field(mp.kelompok,'kelompok_umum','mia','iis','kelompok_khusus'), field(mp.sub_kelompok, null ,'pemberdayaan','keterampilan_wajib', 'keterampilan_pilihan'), mp.id")
            ->get();
    }

    public function array(): array
    {
        return $this->listWb->get()->toArray();
    }

    public function map($row): array
    {
        $result = [
            $row['nisn'],
            $row['wb_name'],
            $row['kelamin'],
            $row['kode'],
        ];

        $nilai = NilaiModel::from('nilai as n')
            ->selectRaw('k.id as k_id, k.kelas , k.semester, mp.id as mp_id, n.* ')
            ->leftJoin('kelas as k', 'k.id', '=', 'n.kelas_id')
            ->leftJoin('kelas_mata_pelajaran as kmp', 'kmp.id', '=', 'n.kmp_id')
            ->leftJoin('mata_pelajaran as mp', 'mp.id', '=', 'kmp.mata_pelajaran_id')
            ->where('n.wb_id', $row['id'])
            ->get();

        $nilaiArr = [];
        foreach ($nilai as $key => $n) {
            $nilaiArr[$n->kelas][$n->mp_id][$n->semester] =
                [
                    'P' => [
                        '1' => $n->p_nilai_1,
                        '2' => $n->p_nilai_2,
                        '3' => $n->p_nilai_3,
                    ],
                    'K' => [
                        '1' => $n->k_nilai_1,
                        '2' => $n->k_nilai_2,
                        '3' => $n->k_nilai_3,
                    ],
                ];
        }


        $startNum = 1;
        $endNum = 6;
        if ($this->kode_paket == 'PAKETB') {
            $startNum = 7;
            $endNum = 9;
        } elseif ($this->kode_paket == 'PAKETC') {
            $startNum = 10;
            $endNum = 12;
        }

        foreach (self::$listMP as $mp) {
            $modulCount = 3;
            for ($kelas = $startNum; $kelas <= $endNum; $kelas++) {
                for ($smt = 1; $smt <= 2; $smt++) {
                    $jenisSection = ['P', 'K'];
                    foreach ($jenisSection as $section) {
                        for ($modul = 1; $modul <= $modulCount; $modul++) {
                            $result[] = $nilaiArr[$kelas][$mp->id][$smt][$section][$modul] ?? '';
                        }
                    }
                }
            }
        }


        return $result;
    }

    public function headings(): array
    {

        $row1 = [
            'NISN',
            'NAMA',
            'L/P',
            'KELAS',
        ];

        $row2 = [
            '',
            '',
            '',
            '',
        ];

        $row3 = [
            '',
            '',
            '',
            '',
        ];

        $startNum = 1;
        $endNum = 6;
        if ($this->kode_paket == 'PAKETB') {
            $startNum = 7;
            $endNum = 9;
        } elseif ($this->kode_paket == 'PAKETC') {
            $startNum = 10;
            $endNum = 12;
        }

        foreach (self::$listMP as $mp) {
            $row1[] = $mp->nama;
            $colCount = 1;
            $modulCount = 3;
            for ($i = $startNum; $i <= $endNum; $i++) {
                for ($smt = 1; $smt <= 2; $smt++) {
                    $row2[] = $i . '#' . $smt;
                    $jenisSection = ['P', 'K'];
                    foreach ($jenisSection as $section) {
                        for ($modul = 1; $modul <= $modulCount; $modul++) {
                            $row3[] = $section . '' . $modul;
                            if ($section != 'K' || $modul != 3) {
                                $row2[] = '';
                            }

                            if ($colCount != 2 * 2 * $modulCount) {
                                $row1[] = '';
                            }
                            $colCount++;
                        }
                    }
                }
            }
            $row1[] = 'RATA-RATA';
            $row2[] = $mp->nama;
            $row3[] = '';
        }

        return [
            $row1,
            $row2,
            $row3,
        ];
    }

    public function columnFormats(): array
    {
        return [
            // 'C' => DataType::TYPE_STRING,
        ];
    }

    /**
     * After sheet handler
     *
     * @param  AfterSheet  $event
     * @return void
     * @throws Exception
     */
    public static function afterSheet(AfterSheet $event)
    {
        try {
            $workSheet = $event->sheet->getDelegate()->freezePane('C4');

            $headers = $workSheet->getStyle('A1:' . $event->sheet->getHighestColumn() . '3');
            $headers->getAlignment()
                ->setHorizontal(Alignment::HORIZONTAL_CENTER)
                ->setVertical(Alignment::VERTICAL_CENTER);
            $headers->getFont()->setBold(true);

            $workSheet->getStyle('A:D')
                ->getAlignment()
                ->setHorizontal(Alignment::HORIZONTAL_LEFT)
                ->setVertical(Alignment::VERTICAL_CENTER);
            $workSheet->getStyle('A:D')->getFont()->setBold(true);

            Log::debug(count(self::$listMP));
        } catch (Exception $exception) {
            throw $exception;
        }
    }
}
