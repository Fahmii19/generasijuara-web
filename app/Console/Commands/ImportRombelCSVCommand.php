<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Utils\Misc;

class ImportRombelCSVCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:rombel-csv {--path=} {--delimiter=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

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
        $this->line('---START PROCESS---');

        // path = /import/rombel/2021/HST-GANJIL.csv
        $path = !empty($this->option('path')) ? $this->option('path') : '/import/rombel/2021/example.csv';
        $delimiter = !empty($this->option('delimiter')) ? $this->option('delimiter') : ';';
        $this->line('path: '.$path);
        $this->line('delimiter: '.$delimiter);

        $rows = Misc::csvReader($path, $delimiter);
        foreach ($rows as $key => $row) {
            $this->info('row: '.($key+1).'/'.count($rows));
            $tempIndex = 0;
            $no = $row[$tempIndex++];
            $kelas = $row[$tempIndex++];
            $kelas_sebelum = $row[$tempIndex++];
            $nis = $row[$tempIndex++];
            $nisn = $row[$tempIndex++];
            $nama = $row[$tempIndex++];
            $status_diverbal = $row[$tempIndex++];
            $status_rombel_dapodik = $row[$tempIndex++];
            $status_daftar_dapodik = $row[$tempIndex++];
            $status_kartu_pelajar = $row[$tempIndex++];
            $catatan_admin = $row[$tempIndex++];
            $status_wb = $row[$tempIndex++]; // Baru, Alumni
            $link_yandes = $row[$tempIndex++]; 
            $status_electa = $row[$tempIndex++]; 
            $tgl_buat_akun = $row[$tempIndex++]; 
            $username_electa = $row[$tempIndex++]; 
            $email_ortu = $row[$tempIndex++]; 
            $username_ms_team = $row[$tempIndex++]; 
            $cabang_genju = $row[$tempIndex++]; 
            $hp_ayah = $row[$tempIndex++]; 
            $hp_ibu = $row[$tempIndex++]; 
            $tempat_lahir = $row[$tempIndex++]; 
            $tgl_lahir = $row[$tempIndex++]; 
            $usia = $row[$tempIndex++]; 
            $hobi = $row[$tempIndex++]; 
            $cita2 = $row[$tempIndex++]; 
            $gender = $row[$tempIndex++]; 
            $anak_ke = $row[$tempIndex++]; 
            $jumlah_saudara = $row[$tempIndex++]; 
            $status_anak = $row[$tempIndex++]; // Anak Kandung
            $alamat = $row[$tempIndex++];
            $rt_rw = $row[$tempIndex++];
            $kelurahan = $row[$tempIndex++];
            $kecamatan = $row[$tempIndex++];
            $kota = $row[$tempIndex++];
            $provinsi = $row[$tempIndex++];
            $alamat_domisili = $row[$tempIndex++];
            $kode_pos = $row[$tempIndex++];
            $agama = $row[$tempIndex++];
            $nama_sekolah_asal = $row[$tempIndex++];
            $alamat_sekolah_asal = $row[$tempIndex++];
            $kelas_referal = $row[$tempIndex++];
            $kelas_matrikulasi = $row[$tempIndex++];
            $kelas_pertama_pkbm = $row[$tempIndex++];
            $kelas_smt_terakhir_sekolah_sebelum = $row[$tempIndex++];
            $tahun_lulus = $row[$tempIndex++];
            $tahun_ijazah = $row[$tempIndex++];
            $no_ijazah_skl = $row[$tempIndex++];
            $tahun_skhun = $row[$tempIndex++];
            $scan_foto_ijazah = $row[$tempIndex++];
            $scan_foto_skhun = $row[$tempIndex++];
            $scan_foto_bukti_tf = $row[$tempIndex++];
            $nama_ayah = $row[$tempIndex++];
            $nama_ibu = $row[$tempIndex++];
            $pekerjaan_ayah = $row[$tempIndex++];
            $pekerjaan_ibu = $row[$tempIndex++];
            $honor_ayah = $row[$tempIndex++];
            $honor_ibu = $row[$tempIndex++];
            $telegram_siswa = $row[$tempIndex++];
            $nama_konsultasi_pendidikan = $row[$tempIndex++];
            $sumber_info_pkbm = $row[$tempIndex++];
            $detail_sumber_info = $row[$tempIndex++];
            $no_pendaftaran = $row[$tempIndex++];
            $tgl_masuk_electa = $row[$tempIndex++];
            $tgl_dikirim_ppdb = $row[$tempIndex++];
            $status_lanjutan_baru = $row[$tempIndex++]; // Lanjutan, Baru
            $akta_kelahiran = $row[$tempIndex++];
            $foto_id_ayah = $row[$tempIndex++];
            $foto_id_ibu = $row[$tempIndex++];
            $foto_2x3 = $row[$tempIndex++];
            $foto_3x4 = $row[$tempIndex++];
            $foto_4x6 = $row[$tempIndex++];
            $foto_kk = $row[$tempIndex++];
            $nota_kesepakatan = $row[$tempIndex++];
            $data_raport_yg_dimiliki = $row[$tempIndex++];
            $surat_pernyataan = $row[$tempIndex++];
            $ijazah = $row[$tempIndex++];
            $nik_ayah = $row[$tempIndex++];
            $nik_ibu = $row[$tempIndex++];
            $nik_siswa = $row[$tempIndex++];
            $no_kk = $row[$tempIndex++];
            $no_reg_akte = $row[$tempIndex++];
            $daftar_ulang = $row[$tempIndex++];
            $pilihan_kelas = $row[$tempIndex++]; // HST-REG
            $this->line('>mapping success');
        }

        $this->info('---END PROCESS---');
        return 0;
    }
}
