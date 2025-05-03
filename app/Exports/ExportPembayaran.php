<?php

namespace App\Exports;

use App\Models\PembayaranModel;
use App\Models\TagihanModel;
use Maatwebsite\Excel\Concerns\FromCollection;
use DB;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class ExportPembayaran implements FromCollection, WithMapping, WithHeadings, WithStyles, WithColumnWidths
{
    /**
    * @return \Illuminate\Support\Collection
    */

    protected $kelas_id;

    public function __construct($kelas_id) {
        $this->kelas_id = $kelas_id;
    }

    private $select = '
        ppdb.nis,
        ppdb.nisn,
        ppdb.nama,
        pmb.nominal,
        pmb.tagihan,
        pmb.total_tagihan,
        pmb.is_paid,
        pmb.is_approved
    ';

    public function collection()
    {
        $model = TagihanModel::select(
                                'ppdb.nis',
                                'ppdb.nisn',
                                'ppdb.nama',
                                'tagihan',
                                'total_tagihan',
                                'nominal',
                                'status'
                            )
                            ->join('ppdb','ppdb.id','=','tagihan.ppdb_id');

        if ($this->kelas_id != null) {
            $model->where('ppdb.kelas_id', $this->kelas_id);
        }

        return $model->get();
    }

    public function map($tagihan): array {
        return [
            ($tagihan->nis != null) ? $tagihan->nis : '-',
            ($tagihan->nisn != null) ? $tagihan->nisn : '-',
            $tagihan->nama,
            ($tagihan->tagihan != null) ? $tagihan->tagihan : '0',
            ($tagihan->total_tagihan != null) ? $tagihan->total_tagihan : '0',
            ($tagihan->nominal != null) ? $tagihan->nominal : '0',
            ucfirst($tagihan->status),
        ];
    }

    public function headings(): array
    {
        return [
            'NIS',
            'NISN',
            'Nama',
            'Tagihan',
            'Total Tagihan',
            'Nominal',
            'Status',
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true, 'size' => 14]],
        ];
    }

    public function columnWidths(): array
    {
        return [
            'A' => 13,
            'B' => 15,
            'C' => 30,
            'D' => 13,
            'E' => 18,
            'F' => 13,
            'G' => 24,
        ];
    }
}
