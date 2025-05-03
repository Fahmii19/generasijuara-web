<?php

namespace App\Exports;

use App\Models\NilaiModel;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Style\Border;

class SusulanRemedialExport implements FromCollection, WithHeadings, ShouldAutoSize, WithMapping, WithEvents
{
    protected $no = 0;
    protected $kelas_id = null;
    protected $kmp_id = null;
    protected $tutor_id = null;
    protected $tahun_akademik_id = null;

    public function __construct($context)
    {
        $this->kelas_id = $context['kelas_id'];
        $this->kmp_id = $context['kmp_id'];
        $this->tutor_id = $context['tutor_id'];
        $this->tahun_akademik_id = $context['tahun_akademik_id'];
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $nilai = NilaiModel::with(
            'kelas:id,nama',
            'kmp.mata_pelajaran_detail:id,nama',
            'wb:id,nama','kmp:id,mata_pelajaran_id',
        );

        $nilai->select('kelas_id','kmp_id','wb_id','susulan_remedial')
            ->where('susulan_remedial', '!=', '');

        if (!empty($this->kelas_id)) {
            $nilai->where('kelas_id', $this->kelas_id);
        }
        if (!empty($this->kmp_id)) {
            $nilai->where('kmp_id', $this->kmp_id);
        }
        if (!empty($this->tutor_id)) {
            $nilai->whereHas('kmp', function ($query) {
                $query->where('tutor_id', $this->tutor_id);
            });
        }
        if (!empty($this->tahun_akademik_id)) {
            $nilai->whereHas('kelas', function ($query) {
                $query->where('tahun_akademik_id', $this->tahun_akademik_id);
            });
        }
        
        $nilai = $nilai->get();
        
        $nilai->map(function ($item) {
            $item->susulan_remedial = json_decode($item->susulan_remedial);
        });

        $susulan_remedial = [];
        foreach ($nilai as $key => $value) {
            $susulan_remedial_temp = [];
            $susulan_remedial_temp['nama'] = $value->wb->nama ?? '';
            $susulan_remedial_temp['kelas'] = $value->kelas->nama ?? '';
            $susulan_remedial_temp['mp'] = $value->kmp->mata_pelajaran_detail->nama ?? '';

            foreach ($value->susulan_remedial as $key2 => $value2) { // key = susulan | remedial
                $susulan_remedial_temp[$key2] = [];

                foreach ($value2 as $key3 => $value3) { // key = p_ | k_
                    if (empty($value3)) continue;

                    $susulan_remedial_temp[$key2][$key3] = $value3;
                }
            }

            $susulan_remedial[] = $susulan_remedial_temp;
        }

        foreach ($susulan_remedial as $key => $value) {
            if (empty($value['susulan']) && empty($value['remedial'])) {
                unset($susulan_remedial[$key]);
            }
        }

        return collect($susulan_remedial);
    }

    public function headings(): array
    {
        $header_1 = [
            'No',
            'Nama',
            'Kelas',
            'Mata Pelajaran',
            'Susulan Tugas',
            ' ',
            'Remedial Tugas',
            ' ',
            'Susulan Ujian',
            ' ',
            'Remedial Ujian',
            ' ',
        ];

        $header_2 = [
            ' ',
            ' ',
            ' ',
            ' ',
            'Pengetahuan',
            'Keterampilan',
            'Pengetahuan',
            'Keterampilan',
            'Pengetahuan',
            'Keterampilan',
            'Pengetahuan',
            'Keterampilan',
        ];

        return [
            $header_1,
            $header_2,
        ];
    }

    public function map($row): array
    {
        return [
            ++$this->no,
            $row['nama'],
            $row['kelas'],
            $row['mp'],
            !empty($row['susulan']['p_tugas']) ? 'Modul '.implode(' ,', $row['susulan']['p_tugas']) : '',
            !empty($row['susulan']['k_tugas']) ? 'Modul '.implode(' ,', $row['susulan']['k_tugas']) : '',
            !empty($row['remedial']['p_tugas']) ? 'Modul '.implode(' ,', $row['remedial']['p_tugas']) : '',
            !empty($row['remedial']['k_tugas']) ? 'Modul '.implode(' ,', $row['remedial']['k_tugas']) : '',
            !empty($row['susulan']['p_ujian']) ? 'Modul '.implode(' ,', $row['susulan']['p_ujian']) : '',
            !empty($row['susulan']['k_ujian']) ? 'Modul '.implode(' ,', $row['susulan']['k_ujian']) : '',
            !empty($row['remedial']['p_ujian']) ? 'Modul '.implode(' ,', $row['remedial']['p_ujian']) : '',
            !empty($row['remedial']['k_ujian']) ? 'Modul '.implode(' ,', $row['remedial']['k_ujian']) : '',
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function(AfterSheet $event) {
                $event->sheet->getDelegate()
                    ->mergeCells('A1:A2')
                    ->mergeCells('B1:B2')
                    ->mergeCells('C1:C2')
                    ->mergeCells('D1:D2')
                    ->mergeCells('E1:F1')
                    ->mergeCells('G1:H1')
                    ->mergeCells('I1:J1')
                    ->mergeCells('K1:L1');

                $event->sheet->getDelegate()
                    ->getStyle('A1:L2')
                    ->getAlignment()
                    ->setVertical('center')
                    ->setHorizontal('center');
                
                $event->sheet->getDelegate()
                    ->getStyle('A1:L2')
                    ->getFont()
                    ->setBold(true);
                
                $event->sheet->getDelegate()
                    ->getStyle('A')
                    ->getAlignment()
                    ->setHorizontal('center');

                $event->sheet->getDelegate()
                    ->getStyle('E:L')
                    ->getAlignment()
                    ->setHorizontal('center');

                // Border all
                $dataBorderStyle = [
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => Border::BORDER_THIN,
                            'color' => [
                                'argb' => 'FF000000'
                            ],
                        ],
                    ],
                ];

                $event->sheet->getDelegate()
                    ->getStyle('A1:L' . ($this->no + 2))
                    ->applyFromArray($dataBorderStyle);
            },
        ];
    }
}
