<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\TahunAkademikModel;

class GenerateTahunAkademikCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'generate:tahun-akademik';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate Tahun Akademik';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->info('start');

        $startYear = 2019;
        $endYear = (int) date('Y');

        $this->line('startYear: '.$startYear);
        $this->line('endYear: '.$endYear);

        for($year = $startYear; $year <= $endYear; $year++){
            for ($smt=1; $smt <= 2 ; $smt++) { 
                $kode = $year.$smt;
                $nextYear = $year+1;
                $tahun_ajar = $year.'/'.$nextYear;
                if($smt%2 == 1){
                    $ket = "Semester Ganjil Tahun Ajaran ".$year." - ".$nextYear;
                    $periodeStart = $year.'-07-01';
                    $periodeEnd = $year.'-12-01';
                }else{
                    $ket = "Semester Genap Tahun Ajaran ".$year." - ".$nextYear;
                    $periodeStart = ($nextYear).'-01-01';
                    $periodeEnd = ($nextYear).'-07-01';
                }

                $params = [
                    'kode' => $kode,
                    'tahun_ajar' => $tahun_ajar,
                    'keterangan' => $ket,
                    'periode_start' => $periodeStart,
                    'periode_end' => $periodeEnd,
                    'is_active' => false,
                ];

                $tahunAkademik = TahunAkademikModel::where('kode', $params['kode'])->first();
                if (empty($tahunAkademik)) {
                    $this->line('create: '.$params['tahun_ajar']);
                    TahunAkademikModel::create($params);
                }
            }
        }

        $this->info('end');
        return 0;
    }
}
