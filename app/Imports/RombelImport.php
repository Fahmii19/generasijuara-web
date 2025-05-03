<?php

namespace App\Imports;

use App\Models\DistribusiMapelModel;
use App\Models\KelasMataPelajaranModel;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use App\Models\LayananKelasModel;
use App\Models\PaketKelasModel;
use App\Models\KelasModel;
use App\Models\TahunAkademikModel;
use App\Models\UserRoleModel;
use App\Models\User;
use App\Models\PpdbModel;
use App\Models\KelasWbModel;
use App\Models\KmpSettingModel;
use App\Models\RombelModel;
use DB;
use App\Utils\Constant;

class RombelImport implements ToCollection
{
    public function collection(Collection $rows)
    {
        DB::beginTransaction();
        try {
            $tahunAjar = '';
            foreach ($rows as $key => $row) {
                if ($row[0] == 'Tahun Ajaran') {
                    $tahunAjar = $row[2];
                    continue;
                } elseif ($key < 3) continue;
 
                /*
                    Jika sudah tidak ada data nomor lagi maka akan dilewati hingga selesai.
                    Karena apabila terdapat row yang sebenarnya kosong, tetapi terdapat
                    bekas formatting cells maka dianggap ada data dan import akan gagal.
                */
                if (empty($row[0])) continue;

                $tempIndex = 0;
                $no = $row[$tempIndex++];
                $kode_kelas = $row[$tempIndex++];
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
                $link_yandex = $row[$tempIndex++];
                $status_elcta = $row[$tempIndex++];
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
                $tb = $row[$tempIndex++];
                $bb = $row[$tempIndex++];
                $jarak = $row[$tempIndex++];
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
                $status_perkawinan_orang_tua = $row[$tempIndex++];
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
                $ceklis_pindah_layanan = $row[$tempIndex++];

                $kode_kelas = trim($kode_kelas);

                $typeKelas = Constant::TYPE_KELAS_ABC;

                foreach (Constant::KELAS_PAUD as $kelasPaud) {
                    if (strpos($kode_kelas, $kelasPaud) !== FALSE) {
                        $typeKelas = Constant::TYPE_KELAS_PAUD;
                        $kodePaketKelas = $kelasPaud;
                    }
                }

                // Only allow numbers on NISN
                if (!is_numeric($nisn)) {
                    $nisn = null;
                }

                // KABAR2 REG-2021, A11 HST-2021 NON MODULAR
                if ($typeKelas == Constant::TYPE_KELAS_ABC) {
                    $kodePaketKelas = 'PAKET' . substr($kode_kelas, 0, 1);
                    $kodeKelasPart = explode(' ', $kode_kelas);
                    $kelasNum = (strlen($kodeKelasPart[0]) == 4) ? substr($kode_kelas, 1, 2) : substr($kode_kelas, 1, 1);
                    $smtNum = (strlen($kodeKelasPart[0]) == 4) ? substr($kode_kelas, 3, 1) : substr($kode_kelas, 2, 1);
                } elseif ($typeKelas == Constant::TYPE_KELAS_PAUD) {
                    $kelasNum = null;
                    $smtNum = substr($kode_kelas, strlen($kodePaketKelas), 1);
                }

                $kodeLayananKelas = null;
                if (str_contains($kode_kelas, 'HST')) {
                    $kodeLayananKelas = 'HST';
                } elseif (str_contains($kode_kelas, 'REG')) {
                    $kodeLayananKelas = 'REG';
                } elseif (str_contains($kode_kelas, 'INTENSIF')) {
                    $kodeLayananKelas = 'INTENSIF';
                }

                if (str_contains(strtolower($status_wb), 'baru')) {
                    $status_wb = Constant::STATUS_WB_BARU;
                } elseif (str_contains(strtolower($status_wb), 'lama')) {
                    $status_wb = Constant::STATUS_WB_LAMA;
                } elseif (str_contains(strtolower($status_wb), 'alumni')) {
                    $status_wb = Constant::STATUS_WB_ALUMNI;
                }

                $kodeTahunAjar = substr($tahunAjar, 0, 4) . $smtNum;
                $tahunAjar = $kodeTahunAjar;
                
                $layananKelas = LayananKelasModel::where('kode', $kodeLayananKelas)->firstOrFail();
                $paketKelas = PaketKelasModel::where('kode', $kodePaketKelas)->firstOrFail();
                $tahunAkademik = TahunAkademikModel::where('kode', $kodeTahunAjar)->firstOrFail();

                $jurusan = null;
                $jurusanAlias = null;
                if (str_contains($kode_kelas, 'IPA')) {
                    $jurusan = 'IPA';
                    $jurusanAlias = 'mia';
                } elseif (str_contains($kode_kelas, 'IPS')) {
                    $jurusan = 'IPS';
                    $jurusanAlias = 'iis';
                }

                $kelasDB = KelasModel::updateOrCreate(
                    [
                        'kode' => $kode_kelas,
                        'tahun_akademik_id' => $tahunAkademik->id,
                    ],
                    [
                        'kelas' => $kelasNum,
                        'semester' => $smtNum,
                        'jurusan' => $jurusan,
                        'layanan_kelas_id' => $layananKelas->id,
                        'paket_kelas_id' => $paketKelas->id,
                        'nama' => $kode_kelas,
                        'type' => $typeKelas,
                        'is_active' => true,
                    ]
                );

                $user = User::getByUsername($nis);
                if (empty($user)) {
                    error_log('empty user');
                    $user = User::create([
                        'name' => $nama,
                        'email' => null,
                        'username' => $nis,
                        'phone' => null,
                        'password' => bcrypt(Constant::PPDB_DEFAULT_PASSWORD),
                        'is_active' => true,
                    ]);

                    $userRole = UserRoleModel::updateOrCreate(
                        ['user_id' => $user->id, 'role_id' => Constant::ROLE_WB_ID]
                    );
                }

                if ($tgl_lahir != '') {
                    $tanggal_lahir_string = explode(' ', $tgl_lahir);

                    $tanggal_lahir_string[0] = str_pad($tanggal_lahir_string[0], 2, '0', STR_PAD_LEFT);

                    $bulanToAngka = [
                        'Januari' => '01',
                        'Februari' => '02',
                        'Maret' => '03',
                        'April' => '04',
                        'Mei' => '05',
                        'Juni' => '06',
                        'Juli' => '07',
                        'Agustus' => '08',
                        'September' => '09',
                        'Oktober' => '10',
                        'November' => '11',
                        'Desember' => '12'
                    ];
                    $tanggal_lahir_string[1] = $bulanToAngka[$tanggal_lahir_string[1]];
                    
                    $formatted_tanggal_lahir = $tanggal_lahir_string[2] . '-' . $tanggal_lahir_string[1] . '-' . $tanggal_lahir_string[0];
                } else {
                    $formatted_tanggal_lahir = '0000-00-00';
                }

                $ppdb = PpdbModel::updateOrCreate(
                    ['user_id' => $user->id],
                    [
                        'type' => $typeKelas,
                        'nis' => $nis,
                        'nama' => $nama,
                        'kelamin' => strtolower($gender) == 'laki-laki' ? 'l' : 'p',
                        'anak_ke' => $anak_ke,
                        'status_dalam_keluarga' => $status_anak,
                        'alamat_peserta_didik' => implode(', ', array($alamat, $rt_rw, $kelurahan, $kecamatan, $kota, $provinsi)),
                        'alamat_orang_tua' => implode(', ', array($alamat, $rt_rw, $kelurahan, $kecamatan, $kota, $provinsi)),
                        'nama_ibu' => $nama_ibu,
                        'nama_ayah' => $nama_ayah,
                        'pekerjaan_ayah' => $pekerjaan_ayah,
                        'pekerjaan_ibu' => $pekerjaan_ibu,
                        'nik_siswa' => $nik_siswa,
                        'nik_ayah' => $nik_ayah,
                        'nik_ibu' => $nik_ibu,
                        'hp_siswa' => null,
                        'hp_ayah' => $hp_ayah,
                        'hp_ibu' => $hp_ibu,
                        'tempat_lahir' => $tempat_lahir,
                        'tanggal_lahir' => $formatted_tanggal_lahir,
                        'telegram_siswa' => $telegram_siswa,
                        'telegram_ayah' => null,
                        'telegram_ibu' => null,
                        'email' => $email_ortu,
                        'layanan_kelas_id' => $layananKelas->id,
                        'paket_kelas_id' => $paketKelas->id,
                        'tipe_kelas_sebelum' => null,
                        'kelas_sebelum' => null,
                        'smt_kelas_sebelum' => null,
                        'kelas' => $kelasNum,
                        'smt_kelas' => $smtNum,
                        'lulusan' => null,
                        'tahun_lulus' => null,
                        'paket_spp_id' => null,
                        'url_bukti_trf' => null,
                        'url_bukti_trf2' => null,
                        'biaya_daftar' => null,
                        'biaya_spp' => null,
                        'biaya' => null,
                        'peminatan' => null,
                        'wakaf' => null,
                        'infaq' => null,
                        'url_bukti_trf_zakat' => null,
                        'kelas_id' => $kelasDB->id,
                        'is_active' => true,
                        'is_approved' => true,
                        'created_by' => null,
                        'updated_by' => null,
                        'nisn' => $nisn,
                        'no_induk' => $nis,
                        'user_id' => $user->id,
                        'tahun_akademik_id' => $tahunAkademik->id,
                    ]
                );

                $kelasWb = KelasWbModel::updateOrCreate(
                    [
                        'kelas_id' => $kelasDB->id,
                        'wb_id' => $ppdb->id,
                    ]
                );

                // $rombel = RombelModel::firstOrCreate(
                //     [
                //         'ppdb_id' => $ppdb->id,
                //         'tahun_akademik_id' => $ppdb->tahun_akademik_id,
                //         'kelas_id' => $ppdb->kelas_id,
                //     ],
                //     [
                //         'status_wb' => $status_wb,
                //         'is_active' => true,
                //         'keterangan' => null,
                //     ]
                // );

                $rombel = RombelModel::updateOrCreate(
                    [
                        'ppdb_id' => $ppdb->id,
                        'tahun_akademik_id' => $tahunAkademik->id,
                    ],
                    [
                        'status_wb' => $status_wb,
                        'is_active' => true,
                        'keterangan' => null,
                    ]
                ); 
                
                if (!$rombel->wasRecentlyCreated) {
                    KelasWbModel::where('wb_id', $rombel->ppdb_id)
                                ->where('kelas_id', $rombel->kelas_id)
                                ->delete();

                    // Cek apakah data baru sudah ada di kelas_wb
                    $kelas_wb_check = KelasWbModel::where('wb_id', $rombel->ppdb_id)
                                ->where('kelas_id', $kelasDB->id)
                                ->first();
                    // dd($kelas_wb_check);
                    if (empty($kelas_wb_check)) {
                        // Menambah data baru pada kelas_wb
                        $kelas_wb = new KelasWbModel();
                        $kelas_wb->kelas_id = $kelasDB->id;
                        $kelas_wb->wb_id = $rombel->ppdb_id;
                        $kelas_wb->save();
                        // Mengubah kelas_id pada rombel
                        $rombel->kelas_id = $kelasDB->id;
                    } else {
                        // Mengubah kelas_id pada rombel
                        $rombel->kelas_id = $kelasDB->id;
                        // dd($rombel->id, $rombel);
                        // Mengubah status is_active pada kelas_wb
                        $kelas_wb_check->is_active = true;
                        $kelas_wb_check->save();
                    }
                    $rombel->save();
                } else {
                    // created
                    $rombel->kelas_id = $kelasDB->id;
                    $rombel->save();
                }

                if (!empty($kelasNum)) {
                    $distMapel = DistribusiMapelModel::where('kelas_num', $kelasNum)
                        ->with(['mata_pelajaran'])
                        ->get();

                    foreach ($distMapel as $key => $dm) {
                        if (!empty($jurusanAlias) && in_array($dm->mata_pelajaran->kelompok, ['mia', 'iis']) && $jurusanAlias != $dm->mata_pelajaran->kelompok) continue;

                        $kmp = KelasMataPelajaranModel::updateOrCreate(
                            [
                                'kelas_id' => $kelasDB->id,
                                'mata_pelajaran_id' => $dm->mapel_id,
                            ],
                            [
                                'tutor_id' => $dm->tutor_id,
                            ]
                        );

                        $jmlModul = 3;
                        $persentaseTM = 60;
                        $persentaseUM = 40;
                        if ($dm->mata_pelajaran->kelompok == 'kelompok_khusus') {
                            $jmlModul = 1;
                            $persentaseTM = 100;
                            $persentaseUM = 0;
                        } else {
                            $jmlModul = ($smtNum == 1) ? 3 : 2;
                        }

                        $kmpSetting = KmpSettingModel::updateOrCreate(
                            [
                                'kmp_id' => $kmp->id,
                            ],
                            [
                                'persentase_tm' => $persentaseTM,
                                'persentase_um' => $persentaseUM,
                                'jumlah_modul' => $jmlModul,
                                'need_nilai_sikap' => in_array($dm->mata_pelajaran->nama, ['PPKn', 'PAdBP']) ? true : false,
                                'kkm' => 70
                            ]
                        );
                    }
                }
            }

            $isGenerateRombel = TahunAkademikModel::where('kode', $tahunAjar)->first();
            if (!empty($isGenerateRombel)) {
                $isGenerateRombel->is_generate_rombel = true;
                $isGenerateRombel->save();
            }

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            error_log($e->getMessage());
        }
    }
}
