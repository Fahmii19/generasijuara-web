<?php

namespace App\Exports;

use App\Models\RombelModel;
use App\Models\TahunAkademikModel;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithCustomStartCell;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class RombelExport implements FromCollection, WithMapping, WithHeadings, ShouldAutoSize, WithEvents, WithStyles, WithCustomStartCell, WithColumnFormatting
{
    use Exportable;

    protected $no = 0;

    function __construct(int $layanan_kelas_id, int $tahun_akademik_id)
    {
        $this->layanan_kelas_id = $layanan_kelas_id;
        $this->tahun_akademik_id = $tahun_akademik_id;
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $this->tahun_akademik = TahunAkademikModel::find($this->tahun_akademik_id)->tahun_ajar;

        return RombelModel::with(['kelas','ppdb'])
                ->where('tahun_akademik_id', $this->tahun_akademik_id) 
                ->whereHas('kelas', function($query) {
                    $query->where('layanan_kelas_id', $this->layanan_kelas_id);
                })->get();
    }

    public function startCell(): string
    {
        return 'A2';
    }

    public function map($rombel): array
    {
        return [
            ++$this->no, // No
            $rombel->kelas->nama, // Kelas saat ini
            $rombel->ppdb->kelas_sebelum, // Kelas asal
            $rombel->ppdb->nis, // NIS
            $rombel->ppdb->nisn, // NISN
            $rombel->ppdb->nama, // Nama lengkap
            null, // Status siswa di verval
            null, // Status di dapodik
            null, // Siswa terdaftar di dapodik
            null, // Status kartu pelajar
            null, // Catatam admin
            $rombel->status_wb, // Status WB
            null, // Link Yandex dari admin-siswa
            null, // Status active/inactive electa
            null, // Tgl dibuatkan akun oleh operator
            null, // Username electa
            $rombel->ppdb->email, // Email orang tua
            null, // Username Microsoft Teams
            $rombel->ppdb->cabang->nama_cabang ?? '', // Cabang Genju
            $rombel->ppdb->hp_ayah, // No handphone / wa ayah
            $rombel->ppdb->hp_ibu, // No handphone / wa ibu
            $rombel->ppdb->tempat_lahir, // Tempat lahir
            $rombel->ppdb->tanggal_lahir, // Tanggal lahir
            null, // Usia
            null, // Hobi
            null, // Cita-cita
            null, // TB
            null, // BB
            null, // Jarak/waktu tempuh ke sekolah
            strtoupper($rombel->ppdb->kelamin), // Jenis kelamin
            $rombel->ppdb->anak_ke, // Anak ke
            null, // Jumlah saudara kandung
            null, // Status anak dalam keluarga
            $rombel->ppdb->alamat_peserta_didik, // Alamat lengkap
            null, // RT/RW
            null, // Kelurahan
            null, // Kecamatan
            null, // Kabupaten/Kota
            null, // Provinsi
            $rombel->ppdb->alamat_domisili, // Domisili sekarang
            null, // Kode pos
            $rombel->ppdb->agama, // Agama
            $rombel->ppdb->satuan_pendidikan_asal, // Nama sekolah asal
            null, // Alamat sekolah asal
            null, // Kelas referal
            null, // Kelas matrikulasi
            null, // Kelas pertama yang diikuti di PKBM
            null, // Kelas dan semester terakhir di sekolah sebelumnya
            $rombel->ppdb->tahun_lulus, // Tahun lulus
            null, // Tahun ijazah
            null, // Nomor jazah/SKL
            null, // Tahun SHUN/SKHUN
            !empty($rombel->ppdb->dokumen_ijazah) ? 'v' : 'x', // Scan/foto ijazah
            !empty($rombel->ppdb->dokumen_shun_skhun) ? 'v' : 'x', // Scan/foto SHUN/SKHUN
            null, // Scan/foto butki transfer
            null, // Status pernikahan orang tua
            null, // Nama ayah
            null, // Nama ibu
            $rombel->ppdb->pekerjaan_ayah, // Pekerjaan ayah
            $rombel->ppdb->pekerjaan_ibu, // Pekerjaan ibu
            null, // Honor ayah
            null, // Honor ibu
            !empty($rombel->ppdb->telegram_siswa) ? $rombel->ppdb->telegram_siswa :
                ($rombel->ppdb->telegram_ayah ?? $rombel->ppdb->telegram_ibu), // ID Telegram
            null, // Nama konsultan pendidikan
            null, // Mengetahui PKBM dari
            null, // Jika rekomendari dari teman,...
            null, // Nomor pendafaran
            null, // Tanggal masuk electa
            Date::dateTimeToExcel($rombel->ppdb->created_at), // Tanggal dikirim PPDB
            null, // Status siswa lanjutan/baru
            !empty($rombel->ppdb->dokumen_akta_kelahiran) ? 'v' : 'x', // Akta kelahiran
            null, // FC/foto/scan KTP/SIM/Pasport ayah
            null, // FC/foto/scan KTP/SIM/Pasport ibu
            !empty($rombel->ppdb->url_foto_wb) ? 'v' : 'x', // Pas foto 2x3
            !empty($rombel->ppdb->url_foto_wb) ? 'v' : 'x', // Pas foto 3x4
            !empty($rombel->ppdb->url_foto_wb) ? 'v' : 'x', // Pas foto 4x6
            !empty($rombel->ppdb->dokumen_kartu_keluarga) ? 'v' : 'x', // Foto/scan KK
            null, // Note kesepakatan
            null, // Data raport yang dimiliki
            null, // Surat pernyataan
            !empty($rombel->ppdb->dokumen_ijasah) ? 'v' : 'x', // Ijazah
            $rombel->ppdb->nik_ayah, // NIK ayah
            $rombel->ppdb->nik_ibu, // NIK ibu
            $rombel->ppdb->nik_siswa, // NIK siswa
            null, // No KK
            null, // No reg akte
            null, // Daftar ulang
            null, // Pilihan kelas
            null, // Ceklis pindah layanan
        ];
    }

    public function headings(): array
    {
        $numbering = [];
        $header = [
            'NO',
            'KELAS SAAT INI',
            'KELAS ASAL',
            'NIS',
            'NISN',
            'NAMA LENGKAP',
            'STATUS SISWA DI VERVAL',
            'STATUS DI DAPODIK',
            'SISWA TERDAFTAR DI DAPODIK',
            'STATUS KARTU PELAJAR',
            'CATATAN ADMIN',
            'STATUS WB',
            'LINK YANDEX DARI ADMIN-SISWA',
            'STATUS ACTIVE/INACTIVE ELECTA',
            'TGL DIBUATKAN AKUN OLEH OPERATOR',
            'USERNAME ELECTA',
            'EMAIL ORANG TUA',
            'USERNAME MICROSOFT TEAMS',
            'CABANG GENJU',
            'NOMOR HANDPHONE / WA AYAH',
            'NOMOR HANDPHONE / WA IBU',
            'TEMPAT LAHIR',
            'TANGGAL LAHIR',
            'USIA',
            'HOBI',
            'CITA-CITA',
            'TB (CM)*',
            'BB (CM)*',
            'JARAK(KM)/ WAKTU (JAM) TEMPUH KE SEKOLAH/PKBM*',
            'JENIS KELAMIN',
            'ANAK KE',
            'JUMLAH SAUDARA KANDUNG',
            'STATUS ANAK DALAM KELUARGA',
            'ALAMAT LENGKAP',
            'RT / RW',
            'KELURAHAN',
            'KECAMATAN',
            'KABUPATEN / KOTA',
            'PROVINSI',
            'DOMISILI SEKARANG',
            'KODE POS',
            'AGAMA',
            'NAMA SEKOLAH ASAL',
            'ALAMAT SEKOLAH ASAL',
            'KELAS REFERAL (JIKA MEMILIH/MENGIKUTI)',
            'KELAS MATRIKULASI (KELAS KHUSUS)',
            'KELAS PERTAMA YANG DIIKUTI DI PKBM GENERASI JUARA',
            'KELAS DAN SEMESTER TERAKHIR DI SEKOLAH SEBELUMNYA',
            'TAHUN LULUS',
            'TAHUN IJAZAH',
            'NOMOR IJAZAH/SKL',
            'TAHUN SHUN/SKHUN',
            'SCAN/FOTO IJAZAH',
            'SCAN/FOTO SHUN/SKHUN',
            'SCAN/FOTO BUKTI TRANSFER',
            'STATUS PERKAWINAN ORANG TUA',
            'NAMA AYAH',
            'NAMA IBU',
            'PEKERJAAN AYAH',
            'PEKERJAAN IBU',
            'HONOR AYAH',
            'HONOR IBU',
            'ID TELEGRAM',
            'NAMA KONSULTAN PENDIDIKAN',
            'MENGETAHUI PKBM GENERASI JUARA DARI',
            'JIKA REKOMENDASI DARI TEMAN/SAUDARA/GROUP WA,NAMA TEMAN/SAUDARA/GROUP WA ?',
            'NOMOR PENDAFTARAN',
            'TANGGAL MASUK (ELECTA)',
            'TANGGAL DIKIRM PPDB',
            'STATUS SISWA LANJUTAN/BARU',
            'AKTA KELAHIRAN',
            'FC/FOTO/SCAN  KTP/SIM/PSPOR AYAH',
            'FC/FOTO/SCAN  KTP/SIM/PSPOR IBU',
            'PAS FOTO 2X3',
            'PAS FOTO 3X4',
            'PAS FOTO 4X6',
            'FOTO/SCAN KK',
            'NOTA KESEPAKATAN',
            'DATA RAPORT YANG DIMILIKI',
            'SURAT PERNYATAAN',
            'IJAZAH',
            'NIK AYAH',
            'NIK IBU',
            'NIK SISWA',
            'NO KK',
            'NO REG AKTE',
            'DAFTAR ULANG',
            'PILIHAN KELAS',
            'CEKLIS PINDAH LAYANAN',
        ];

        for ($i=0; $i < count($header); $i++) { 
            $numbering[] = $i+1;
        }

        return [
            $header,
            $numbering
        ];
    }

    public function columnFormats(): array
    {
        return [
            'W' => NumberFormat::FORMAT_DATE_DDMMYYYY,
            'BQ' => NumberFormat::FORMAT_DATE_DDMMYYYY,
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => [
                'font' => [
                    'bold' => true
                ],
                'border' => [
                    'allBorders' => [
                        'borderStyle' => Border::BORDER_THIN,
                        'color' => [
                            'argb' => 'FF000000'
                        ],
                    ],
                ],
            ],
            2  => [
                    'font' => [
                        'bold' => true
                    ],
                    'fill' => [
                        'fillType' => Fill::FILL_SOLID,
                        'startColor' => [
                            'argb' => 'FF08CCFC',
                        ],
                    ],
                ],
            3  => [
                    'font' => [
                        'italic' => true,
                    ],
                    'fill' => [
                        'fillType' => Fill::FILL_SOLID,
                        'startColor' => [
                            'argb' => 'FF08FC04',
                        ],
                    ],
                ],
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function(AfterSheet $event) {
                // Set font family
                // $event->sheet->getDelegate()
                //     ->getParent()
                //     ->getDefaultStyle()
                //     ->getFont()
                //     ->setName('Times New Roman');

                $event->sheet->getDelegate()
                    ->mergeCells('A1:B1')
                    ->setCellValue('A1', 'Tahun Ajaran')
                    ->setCellValue('C1', $this->tahun_akademik);

                $event->sheet->getDelegate()->getRowDimension('2')->setRowHeight(80);

                $event->sheet->getDelegate()
                    ->getStyle('A2:CK2')
                    ->getAlignment()
                    ->setVertical('center')
                    ->setHorizontal('center');

                $event->sheet->getDelegate()
                    ->getStyle('A3:CK3')
                    ->getAlignment()
                    ->setHorizontal('center');

                $headerBorderStyle = [
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
                    ->getStyle('A2:CK3')
                    ->applyFromArray($headerBorderStyle);

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
                    ->getStyle('A4:CK' . ($this->no + 3))
                    ->applyFromArray($dataBorderStyle);
            },
        ];
    }
}
