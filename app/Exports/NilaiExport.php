<?php

namespace App\Exports;

use App\Models\KelasModel;
use App\Models\KelasWbModel;
use Exception;
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
use Maatwebsite\Excel\Events\BeforeWriting;
use PhpOffice\PhpSpreadsheet\Style\Alignment;

class NilaiExport implements FromArray, WithHeadings, WithColumnFormatting, ShouldAutoSize, WithMapping, WithEvents
{
    use Exportable, RegistersEventListeners;

    protected $kelas;
    protected $tutorId = null;
    protected $prevNis = null;
    protected $totalWb = 0;

    public function __construct($kelas, $tutorId = null)
    {
        $this->kelas = $kelas;
        $this->tutorId = $tutorId;
    }

    public function array(): array
    {
        $query = KelasModel::from('kelas as k')
            ->selectRaw('
                k.nama as k_name,
                p.nis,
                p.nisn,
                p.nama as wb_name,
                mp.nama as mp_name,
                mp.kelompok as mp_kelompok,
                mp.id as mp_id,
                ut.name as tutor_name,
                ks.kkm, 
                n.p_tugas_1, n.p_ujian_1, n.p_nilai_1, n.p_predikat_1, n.k_nilai_1, n.k_predikat_1,
                n.p_tugas_2, n.p_ujian_2, n.p_nilai_2, n.p_predikat_2, n.k_nilai_2, n.k_predikat_2,
                n.p_tugas_3, n.p_ujian_3, n.p_nilai_3, n.p_predikat_3, n.k_nilai_3, n.k_predikat_3,
                n.sikap_sosial,
                n.sikap_spiritual
            ')
            ->leftJoin('kelas_wb as kwb', 'kwb.kelas_id', '=', 'k.id')
            ->leftJoin('ppdb as p', 'p.id', '=', 'kwb.wb_id')
            ->leftJoin('kelas_mata_pelajaran as kmp', 'kmp.kelas_id', '=', 'k.id')
            ->leftJoin('mata_pelajaran as mp', 'mp.id', '=', 'kmp.mata_pelajaran_id')
            ->leftJoin('tutor as t', 't.id', '=', 'kmp.tutor_id')
            ->leftJoin('users as ut', 'ut.id', '=', 't.user_id')
            ->leftJoin('kmp_setting as ks', 'ks.kmp_id', '=', 'kmp.id')
            ->leftJoin('nilai as n', function ($join) {
                $join->on('n.kelas_id', '=', 'k.id');
                $join->on('n.kmp_id', '=', 'kmp.id');
                $join->on('n.wb_id', '=', 'kwb.wb_id');
            })
            ->where('k.id', $this->kelas->id);

        if (!empty($this->tutorId)) {
            $query->where('kmp.tutor_id', $this->tutorId);
        }

        $query->orderBy('p.id', 'asc')
            ->orderByRaw("field(mp.kelompok,'kelompok_umum','mia','iis','kelompok_khusus')")
            ->orderBy('mp.id', 'asc');
        return $query->get()->toArray();
    }

    public function headings(): array
    {
        return [
            [
                'NO',
                'KELAS',
                'NIS',
                'NISN',
                'NAMA PESERTA DIDIK',
                'MAPELID',
                'MATA PELAJARAN',
                'KELOMPOK',
                'TUTOR',
                'KKM',
                'MODUL 1',
                '',
                '',
                '',
                '',
                '',
                'MODUL 2',
                '',
                '',
                '',
                '',
                '',
                'MODUL 3',
                '',
                '',
                '',
                '',
                '',
                'PENILAIAN SIKAP',
                '',
            ],
            [
                '',
                '',
                '',
                '',
                '',
                '',
                '',
                '',
                '',
                '',
                'NILAI PENGETAHUAN',
                '',
                '',
                '',
                'NILAI KETERAMPILAN',
                '',
                'NILAI PENGETAHUAN',
                '',
                '',
                '',
                'NILAI KETERAMPILAN',
                '',
                'NILAI PENGETAHUAN',
                '',
                '',
                '',
                'NILAI KETERAMPILAN',
                '',
                '',
                '',
            ],
            [
                '',
                '',
                '',
                '',
                '',
                '',
                '',
                '',
                '',
                '',
                'TUGAS MODUL (TM)',
                'UJIAN MODUL (UM)',
                'NILAI MODUL',
                'PREDIKAT',
                'TUGAS PRAKTEK MODUL',
                'PREDIKAT',
                'TUGAS MODUL (TM)',
                'UJIAN MODUL (UM)',
                'NILAI MODUL',
                'PREDIKAT',
                'TUGAS PRAKTEK MODUL',
                'PREDIKAT',
                'TUGAS MODUL (TM)',
                'UJIAN MODUL (UM)',
                'NILAI MODUL',
                'PREDIKAT',
                'TUGAS PRAKTEK MODUL',
                'PREDIKAT',
                'SIKAP SPRITUAL',
                'SIKAP SOSIAL',
            ],
        ];
    }

    public function map($row): array
    {
        // error_log('map');

        $currentNis = $row['nis'];
        if ($currentNis == $this->prevNis) {
            $row['k_name'] = '';
            $row['nis'] = '';
            $row['nisn'] = '';
            $row['wb_name'] = '';
            $no = '';
        } else {
            $this->totalWb++;
            $no = $this->totalWb;
        }
        $this->prevNis = $currentNis;
        return [
            $no,
            $row['k_name'],
            $row['nis'],
            $row['nisn'],
            $row['wb_name'],
            $row['mp_id'],
            $row['mp_name'],
            $row['mp_kelompok'],
            $row['tutor_name'],
            $row['kkm'],
            $row['p_tugas_1'],
            $row['p_ujian_1'],
            $row['p_nilai_1'],
            $row['p_predikat_1'],
            $row['k_nilai_1'],
            $row['k_predikat_1'],
            $row['p_tugas_2'],
            $row['p_ujian_2'],
            $row['p_nilai_2'],
            $row['p_predikat_2'],
            $row['k_nilai_2'],
            $row['k_predikat_2'],
            $row['p_tugas_3'],
            $row['p_ujian_3'],
            $row['p_nilai_3'],
            $row['p_predikat_3'],
            $row['k_nilai_3'],
            $row['k_predikat_3'],
            $row['sikap_sosial'],
            $row['sikap_spiritual'],
        ];
    }

    public function columnFormats(): array
    {
        return [
            // 'C' => DataType::TYPE_STRING,
        ];
    }

    public static function beforeWriting(BeforeWriting $event)
    {
        // error_log('beforeWriting');
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
        // error_log('afterSheet');
        try {
            $workSheet = $event
                ->sheet
                ->getDelegate()
                ->setMergeCells([
                    'A1:A3',
                    'B1:B3',
                    'C1:C3',
                    'D1:D3',
                    'E1:E3',
                    'F1:F3',
                    'G1:G3',
                    'H1:H3',
                    'I1:I3',
                    'J1:J3',
                    'K1:P1',
                    'Q1:V1',
                    'W1:AB1',
                    'AC1:AD2',
                    'K2:N2',
                    'O2:P2',
                    'Q2:T2',
                    'U2:V2',
                    'W2:Z2',
                    'AA2:AB2',
                ])
                ->freezePane('H4');

            $headers = $workSheet->getStyle('A1:AD3');
            $headers
                ->getAlignment()
                ->setHorizontal(Alignment::HORIZONTAL_CENTER)
                ->setVertical(Alignment::VERTICAL_CENTER);
            $headers->getFont()->setBold(true);

            $workSheet->getStyle('A:AD')->getFont()->setBold(true);
            $workSheet->getStyle('J:AD')->getAlignment()
                ->setHorizontal(Alignment::HORIZONTAL_CENTER)
                ->setVertical(Alignment::VERTICAL_CENTER);
            $workSheet->getStyle('A:I')->getAlignment()
                ->setHorizontal(Alignment::HORIZONTAL_LEFT)
                ->setVertical(Alignment::VERTICAL_CENTER);

            $styleArray = [
                'borders' => [
                    // 'outline' => [
                    //     'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK,
                    //     'color' => ['argb' => 'FFFF0000'],
                    // ],
                    'allBorders' => [
                        'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN, // BORDER_THICK BORDER_THIN
                        'color'       => ['rgb' => '2f2f2f']
                    ],
                ],
            ];

            $workSheet->getStyle('A1:AB'.$event->sheet->getHighestRow())->applyFromArray($styleArray);
            // $event->sheet->setCellValue('E' . ($event->sheet->getHighestRow() + 1), '=SUM(E2:E' . $event->sheet->getHighestRow() . ')');
            // $event->sheet->setCellValue('W9', '=U9+10');
            $event->sheet->getDelegate()->getStyle('K1:P'.$event->sheet->getHighestRow())
                ->getFill()
                ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                ->getStartColor()
                ->setARGB('FFF0D6');
            $event->sheet->getDelegate()->getStyle('Q1:V'.$event->sheet->getHighestRow())
                ->getFill()
                ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                ->getStartColor()
                ->setARGB('DED7E6');
            $event->sheet->getDelegate()->getStyle('W1:AB'.$event->sheet->getHighestRow())
                ->getFill()
                ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                ->getStartColor()
                ->setARGB('D3EBB2');
            $event->sheet->getDelegate()->getStyle('AC1:AD'.$event->sheet->getHighestRow())
                ->getFill()
                ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                ->getStartColor()
                ->setARGB('FFF0D6');

            // $this->totalRowPerWb = 0;
            // for ($i=0; $i < $this->totalWb; $i++) { 

            // }
        } catch (Exception $exception) {
            throw $exception;
        }
    }
}
