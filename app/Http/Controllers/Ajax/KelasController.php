<?php

namespace App\Http\Controllers\Ajax;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\KelasModel;
use App\Models\LayananKelasModel;
use App\Models\TutorModel;
use App\Models\PpdbModel;
use App\Utils\Constant;
use App\Imports\RombelImport;
use App\Models\KelasMataPelajaranModel;
use App\Models\KelasWbModel;
use App\Models\RombelModel;
use DB;
use Excel;

class KelasController extends Controller
{
    public function importRombelExcel(Request $request)
    {
        if ($request->hasFile('import_file')) {
            // Ambil isi Excel dalam bentuk array
            $data = Excel::toArray([], $request->file('import_file'));

            // Mulai proses import data Excel
            DB::beginTransaction();
            try {
                $CekDataBisaTidak = [];
                $tahunAjar = '';

                // Loop melalui data Excel untuk memproses tiap baris
                foreach ($data[0] as $key => $row) {

                    if (isset($row[0]) && $row[0] == 'Tahun Ajaran') {
                        $tahunAjar = $row[2]; // Ambil Tahun Ajaran dari kolom yang tepat
                        continue;
                    }

                    // Lewati baris pertama dan kedua yang dianggap header
                    if ($key < 3) continue;  // Lewati header jika ada
                    if (empty($row)) continue;

                    // Mulai membaca data sesuai dengan kolom-kolom yang ada pada data dummy
                    $tempIndex = 0;
                    $no = $row[$tempIndex++] ?? null;
                    $kode_kelas = $row[$tempIndex++] ?? null;
                    $kelas_sebelum = $row[$tempIndex++] ?? null;
                    $nis = $row[$tempIndex++] ?? null;
                    $nisn = $row[$tempIndex++] ?? null;
                    $nama = $row[$tempIndex++] ?? null;
                    $kelamin = $row[$tempIndex++] ?? null;
                    $nama_ibu = $row[$tempIndex++] ?? null;
                    $nama_ayah = $row[$tempIndex++] ?? null;
                    $nik_siswa = $row[$tempIndex++] ?? null;
                    $nik_ayah = $row[$tempIndex++] ?? null;
                    $nik_ibu = $row[$tempIndex++] ?? null;
                    $tempat_lahir = $row[$tempIndex++] ?? null;
                    $tanggal_lahir = $row[$tempIndex++] ?? null;
                    $status_dalam_keluarga = $row[$tempIndex++] ?? null;
                    $anak_ke = $row[$tempIndex++] ?? null;
                    $alamat_peserta_didik = $row[$tempIndex++] ?? null;
                    $alamat_domisili = $row[$tempIndex++] ?? null;
                    $alamat_orang_tua = $row[$tempIndex++] ?? null;
                    $no_telp_rumah = $row[$tempIndex++] ?? null;
                    $satuan_pendidikan_asal = $row[$tempIndex++] ?? null;
                    $agama = $row[$tempIndex++] ?? null;
                    $pekerjaan_ayah = $row[$tempIndex++] ?? null;
                    $pekerjaan_ibu = $row[$tempIndex++] ?? null;
                    $hp_siswa = $row[$tempIndex++] ?? null;
                    $hp_ayah = $row[$tempIndex++] ?? null;
                    $hp_ibu = $row[$tempIndex++] ?? null;
                    $telegram_siswa = $row[$tempIndex++] ?? null;
                    $telegram_ayah = $row[$tempIndex++] ?? null;
                    $telegram_ibu = $row[$tempIndex++] ?? null;
                    $nama_wali = $row[$tempIndex++] ?? null;
                    $no_telp_wali = $row[$tempIndex++] ?? null;
                    $alamat_wali = $row[$tempIndex++] ?? null;
                    $pekerjaan_wali = $row[$tempIndex++] ?? null;
                    $email = $row[$tempIndex++] ?? null;
                    $tahun_akademik_id = $row[$tempIndex++] ?? null;
                    $layanan_kelas_id = $row[$tempIndex++] ?? null;
                    $paket_kelas_id = $row[$tempIndex++] ?? null;
                    $tipe_kelas_sebelum = $row[$tempIndex++] ?? null;
                    $kelas_sebelum = $row[$tempIndex++] ?? null;
                    $smt_kelas_sebelum = $row[$tempIndex++] ?? null;
                    $kelas = $row[$tempIndex++] ?? null;
                    $smt_kelas = $row[$tempIndex++] ?? null;
                    $lulusan = $row[$tempIndex++] ?? null;
                    $tahun_lulus = $row[$tempIndex++] ?? null;
                    $paket_spp_id = $row[$tempIndex++] ?? null;

                    // Menyimpan data jika kolom-kolom tidak kosong
                    if (!empty(array_filter([$nis, $nisn, $nama]))) {
                        PpdbModel::updateOrCreate(
                            ['nisn' => $nisn],  // Menggunakan nisn sebagai unique key
                            [
                                'no' => $no,
                                'kode_kelas' => $kode_kelas,
                                'kelas_sebelum' => $kelas_sebelum,
                                'nis' => $nis,
                                'nama' => $nama,
                                'kelamin' => $kelamin,
                                'nama_ibu' => $nama_ibu,
                                'nama_ayah' => $nama_ayah,
                                'nik_siswa' => $nik_siswa,
                                'nik_ayah' => $nik_ayah,
                                'nik_ibu' => $nik_ibu,
                                'tempat_lahir' => $tempat_lahir,
                                'tanggal_lahir' => $tanggal_lahir,
                                'status_dalam_keluarga' => $status_dalam_keluarga,
                                'anak_ke' => $anak_ke,
                                'alamat_peserta_didik' => $alamat_peserta_didik,
                                'alamat_domisili' => $alamat_domisili,
                                'alamat_orang_tua' => $alamat_orang_tua,
                                'no_telp_rumah' => $no_telp_rumah,
                                'satuan_pendidikan_asal' => $satuan_pendidikan_asal,
                                'agama' => $agama,
                                'pekerjaan_ayah' => $pekerjaan_ayah,
                                'pekerjaan_ibu' => $pekerjaan_ibu,
                                'hp_siswa' => $hp_siswa,
                                'hp_ayah' => $hp_ayah,
                                'hp_ibu' => $hp_ibu,
                                'telegram_siswa' => $telegram_siswa,
                                'telegram_ayah' => $telegram_ayah,
                                'telegram_ibu' => $telegram_ibu,
                                'nama_wali' => $nama_wali,
                                'no_telp_wali' => $no_telp_wali,
                                'alamat_wali' => $alamat_wali,
                                'pekerjaan_wali' => $pekerjaan_wali,
                                'email' => $email,
                                'tahun_akademik_id' => $tahun_akademik_id,
                                'layanan_kelas_id' => $layanan_kelas_id,
                                'paket_kelas_id' => $paket_kelas_id,
                                'tipe_kelas_sebelum' => $tipe_kelas_sebelum,
                                'kelas_sebelum' => $kelas_sebelum,
                                'smt_kelas_sebelum' => $smt_kelas_sebelum,
                                'kelas' => $kelas,
                                'smt_kelas' => $smt_kelas,
                                'lulusan' => $lulusan,
                                'tahun_lulus' => $tahun_lulus,
                                'paket_spp_id' => $paket_spp_id,
                            ]
                        );
                    }
                }

                // Commit transaction jika semua data berhasil diproses
                DB::commit();

                // Return response jika berhasil
                return response()->json([
                    'error' => false,
                    'message' => 'File berhasil dibaca dan diimpor',
                    'data' => [
                        'semua_nama' => $CekDataBisaTidak
                    ]
                ]);
            } catch (\Exception $e) {
                DB::rollBack(); // Rollback jika ada error
                return response()->json([
                    'error' => true,
                    'message' => 'Terjadi kesalahan saat mengimpor data',
                    'exception' => $e->getMessage(),
                ], 500);
            }
        }

        // Return error jika file tidak ditemukan
        return response()->json([
            'error' => true,
            'message' => 'File tidak ditemukan'
        ], 400);
    }

    // dummy_rombongan_belajar
    // public function storeDummyData()
    // {
    //     $dataDummy = [
    //         [
    //             'nis' => '123456789',
    //             'nisn' => '987654321',
    //             'nama' => 'John Doe',
    //             'kelamin' => 'L',
    //             'nama_ibu' => 'Jane Doe',
    //             'nama_ayah' => 'Richard Doe',
    //             'nik_siswa' => '1234567890123456',
    //             'nik_ayah' => '9876543210987654',
    //             'nik_ibu' => '4567891234567890',
    //             'tempat_lahir' => 'Jakarta',
    //             'tanggal_lahir' => '2000-01-01',
    //             'status_dalam_keluarga' => 'Anak ke-1',
    //             'anak_ke' => 1,
    //             'alamat_peserta_didik' => 'Jl. Merdeka No. 1',
    //             'alamat_domisili' => 'Jl. Merdeka No. 1',
    //             'alamat_orang_tua' => 'Jl. Raya No. 2',
    //             'no_telp_rumah' => '02123456789',
    //             'satuan_pendidikan_asal' => 'SMA Negeri 1 Jakarta',
    //             'agama' => 'Islam',
    //             'pekerjaan_ayah' => 'Pegawai Negeri',
    //             'pekerjaan_ibu' => 'Ibu Rumah Tangga',
    //             'hp_siswa' => '081234567890',
    //             'hp_ayah' => '081298765432',
    //             'hp_ibu' => '081234567891',
    //             'telegram_siswa' => '@john_doe',
    //             'telegram_ayah' => '@richard_doe',
    //             'telegram_ibu' => '@jane_doe',
    //             'nama_wali' => 'Nina Smith',
    //             'no_telp_wali' => '082345678901',
    //             'alamat_wali' => 'Jl. Wali No. 3',
    //             'pekerjaan_wali' => 'Pengusaha',
    //             'email' => 'johndoe@example.com',
    //             'tahun_akademik_id' => 14,
    //             'layanan_kelas_id' => 1,
    //             'paket_kelas_id' => 1,
    //             'tipe_kelas_sebelum' => 'Reguler',
    //             'kelas_sebelum' => 'X IPA 1',
    //             'smt_kelas_sebelum' => 1,
    //             'kelas' => 'XI IPA 2',
    //             'smt_kelas' => 2,
    //             'lulusan' => 'Belum Lulus',
    //             'tahun_lulus' => 2025,
    //             'paket_spp_id' => 1,
    //             'dokumen_ktp_orang_tua' => 'ktp_ayah.pdf',
    //             'dokumen_akta_kelahiran' => 'akta_kelahiran.pdf',
    //             'dokumen_shun_skhun' => 'shun.pdf',
    //             'dokumen_kartu_keluarga' => 'kk.pdf',
    //             'dokumen_ijasah' => 'ijasah.pdf',
    //             'is_ktp_approved' => true,
    //             'is_akta_approved' => true,
    //             'is_shun_skhun_approved' => false,
    //             'is_kk_approved' => true,
    //             'is_ijasah_approved' => true,
    //             'url_bukti_trf' => 'transfer_bukti.pdf',
    //             'url_bukti_trf2' => 'transfer_bukti2.pdf',
    //             'biaya_daftar' => 100000,
    //             'biaya_program' => 500000,
    //             'biaya_spp' => 200000,
    //             'biaya' => 800000,
    //             'peminatan' => 'IPA',
    //             'wakaf' => 50000,
    //             'infaq' => 100000,
    //             'url_bukti_trf_zakat' => 'zakat_bukti.pdf',
    //             'kelas_id' => 2,
    //             'is_active' => true,
    //             'is_approved' => true,
    //             'created_by' => 1,
    //             'updated_by' => 1,
    //             'nisn' => '987654321',
    //             'no_induk' => '1234567890',
    //             'user_id' => 1,
    //             'cabang_id' => 2,
    //             'tgl_terima' => '2025-05-01',
    //             'voucher_code' => 'VOUCHER2025',
    //             'discount_type' => 'percent',
    //             'discount' => 10,
    //         ]
    //     ];

    //     // Loop untuk memasukkan data ke database
    //     foreach ($dataDummy as $row) {
    //         // Mengecek jika ada data kosong
    //         if (!empty(array_filter([$row['nis'], $row['nisn'], $row['nama']]))) {
    //             PpdbModel::updateOrCreate(
    //                 ['nisn' => $row['nisn']],
    //                 $row
    //             );
    //         }
    //     }

    //     // Return response untuk memastikan data berhasil dimasukkan
    //     return response()->json(['message' => 'Data berhasil dimasukkan!']);
    // }

    public function get(Request $request)
    {
        try {
            $id = !empty($request->get('id')) ? $request->get('id') : null;
            $kelas = KelasModel::find($id);
            return response()->json(['error' => false, 'message' => null, 'data' => $kelas], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => true, 'message' => $e->getMessage()], 400);
        } catch (\Throwable $e) {
            return response()->json(['error' => true, 'message' => $e->getMessage()], 400);
        }
    }

    public function getAll(Request $request)
    {
        try {
            $kelas_keyword = !empty($request->get('keyword')) ? $request->get('keyword') : null;
            if (!empty($request->user_id_tutor)) {
                $tutor = TutorModel::where('user_id', $request->user_id_tutor)->first();
                $kelas = KelasModel::from('kelas as k')
                    ->select(DB::raw("DISTINCT k.*"))
                    ->rightJoin('kelas_mata_pelajaran as kmp', 'kmp.kelas_id', '=', 'k.id')
                    ->where('kmp.tutor_id', $tutor->id);
                if (!empty($kelas_keyword)) {
                    $kelas = $kelas->where('nama', 'LIKE', "%$kelas_keyword%");
                }
                if (!empty($request->get('limit')) && $request->limit != null) {
                    $kelas = $kelas->limit($request->limit);
                }
                return response()->json(['error' => false, 'message' => null, 'data' => $kelas->get()], 200);
            }
            if (!empty($request->user_id_wb)) {
                $ppdb = PpdbModel::where('user_id', $request->user_id_wb)->first();
                // return response()->json(['error' => false, 'message' => null, 'data' => [$ppdb, $request->user_id_wb] ], 200);
                $kelas = KelasModel::from('kelas as k')
                    ->select(DB::raw("DISTINCT k.*"))
                    ->rightJoin('kelas_wb as kwb', 'kwb.kelas_id', '=', 'k.id')
                    ->where('kwb.wb_id', $ppdb->id);

                if (!empty($kelas_keyword)) {
                    $kelas = $kelas->where('nama', 'LIKE', "%$kelas_keyword%");
                }
                if (!empty($request->get('limit')) && $request->limit != null) {
                    $kelas = $kelas->limit($request->limit);
                }
                return response()->json(['error' => false, 'message' => null, 'data' => $kelas->get()], 200);
            }
            $kelas = KelasModel::get();
            return response()->json(['error' => false, 'message' => null, 'data' => $kelas], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => true, 'message' => $e->getMessage()], 400);
        } catch (\Throwable $e) {
            return response()->json(['error' => true, 'message' => $e->getMessage()], 400);
        }
    }

    public function getByName(Request $request)
    {
        try {
            $keyword = !empty($request->get('keyword')) ? $request->get('keyword') : null;
            $kelas = KelasModel::query();
            $kelas = $kelas->select('id', 'nama');
            if (!empty($keyword)) {
                $kelas = $kelas->where('nama', 'LIKE', "%$keyword%");
            }
            if (!empty($request->get('limit')) && $request->limit != null) {
                $kelas = $kelas->limit($request->limit);
            }
            return response()->json(['error' => false, 'message' => null, 'data' => $kelas->get()], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => true, 'message' => $e->getMessage()], 400);
        } catch (\Throwable $e) {
            return response()->json(['error' => true, 'message' => $e->getMessage()], 400);
        }
    }

    public function getSebelumnya(Request $request)
    {
        try {
            $kelas = RombelModel::with('kelas')
                ->where('ppdb_id', $request->ppdb_id)
                ->where('is_active', 1)
                ->orderBy('tahun_akademik_id', 'DESC')
                ->first();
            return response()->json(['error' => false, 'message' => null, 'data' => $kelas], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => true, 'message' => $e->getMessage()], 400);
        } catch (\Throwable $e) {
            return response()->json(['error' => true, 'message' => $e->getMessage()], 400);
        }
    }

    public function getType(Request $request)
    {
        try {
            $kelas = Constant::KELAS_TYPE;
            return response()->json(['error' => false, 'message' => null, 'data' => $kelas], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => true, 'message' => $e->getMessage()], 400);
        } catch (\Throwable $e) {
            return response()->json(['error' => true, 'message' => $e->getMessage()], 400);
        }
    }

    public function delete(Request $request)
    {
        try {
            $id = !empty($request->get('id')) ? $request->get('id') : null;
            $kelas = KelasModel::find($id);
            if (empty($kelas)) {
                return response()->json(['error' => true, 'message' => 'Kelas tidak ditemukan'], 400);
            }
            $kelas->delete();
            return response()->json(['error' => false, 'message' => null, 'data' => []], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => true, 'message' => $e->getMessage()], 400);
        } catch (\Throwable $e) {
            return response()->json(['error' => true, 'message' => $e->getMessage()], 400);
        }
    }

    public function updateStatusNilai(Request $request)
    {
        try {
            $id = !empty($request->get('id')) ? $request->get('id') : null;
            $kelas = KelasModel::find($id);
            if (empty($kelas)) {
                return response()->json(['error' => true, 'message' => 'Kelas tidak ditemukan'], 400);
            }
            $kelas->is_lock_nilai = !$kelas->is_lock_nilai;
            $kelas->save();
            return response()->json(['error' => false, 'message' => null, 'data' => $kelas], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => true, 'message' => $e->getMessage()], 400);
        } catch (\Throwable $e) {
            return response()->json(['error' => true, 'message' => $e->getMessage()], 400);
        }
    }

    public function updateJenisRapor(Request $request)
    {
        try {
            $id = !empty($request->get('id')) ? $request->get('id') : null;
            $kelas = KelasModel::find($id);
            if (empty($kelas)) {
                return response()->json(['error' => true, 'message' => 'Kelas tidak ditemukan'], 400);
            }
            $kelas->jenis_rapor = $request->get('jenis_rapor');
            $kelas->save();
            return response()->json(['error' => false, 'message' => null, 'data' => $kelas], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => true, 'message' => $e->getMessage()], 400);
        } catch (\Throwable $e) {
            return response()->json(['error' => true, 'message' => $e->getMessage()], 400);
        }
    }

    public function save(Request $request)
    {
        DB::beginTransaction();
        try {
            $id = !empty($request->get('id')) ? $request->get('id') : null;
            $duplicate_source_id = !empty($request->get('duplicate_source_id')) ? $request->get('duplicate_source_id') : null;
            $layanan_kelas_id = !empty($request->get('layanan_kelas_id')) ? $request->get('layanan_kelas_id') : null;
            $nama = !empty($request->get('nama')) ? $request->get('nama') : null;
            $kode = !empty($request->get('kode')) ? $request->get('kode') : null;
            $type = !empty($request->get('type')) ? $request->get('type') : 0;
            $biaya = !empty($request->get('biaya')) ? $request->get('biaya') : 0;
            $kelas = !empty($request->get('kelas')) ? $request->get('kelas') : null;
            $jurusan = !empty($request->get('jurusan')) ? $request->get('jurusan') : null;
            $semester = !empty($request->get('semester')) ? $request->get('semester') : null;
            $tahun_akademik_id = !empty($request->get('tahun_akademik_id')) ? $request->get('tahun_akademik_id') : null;
            $paket_kelas_id = !empty($request->get('paket_kelas_id')) ? $request->get('paket_kelas_id') : null;
            $is_active = !empty($request->get('is_active')) ? filter_var($request->get('is_active'), FILTER_VALIDATE_BOOLEAN) : false;
            $jenis_rapor = !empty($request->get('jenis_rapor')) ? $request->get('jenis_rapor') : null;

            $db = KelasModel::find($id);
            $params = [
                'layanan_kelas_id' => $layanan_kelas_id,
                'nama' => $nama,
                'kode' => $kode,
                'type' => $type,
                'biaya' => $biaya,
                'is_active' => $is_active,
                'kelas' => $kelas,
                'semester' => $semester,
                'jurusan' => $jurusan,
                'tahun_akademik_id' => $tahun_akademik_id,
                'paket_kelas_id' => $paket_kelas_id,
                'jenis_rapor' => $jenis_rapor,
            ];

            if (!empty($db)) {
                // update
                $db->update($params);
            } else {
                // new
                $db = KelasModel::create($params);
                if (!empty($duplicate_source_id)) {
                    $source = KelasModel::with([
                        'mata_pelajaran',
                        'warga_belajar',
                    ])->find($duplicate_source_id);

                    if (!empty($source)) {
                        foreach ($source->mata_pelajaran as $key => $mp) {
                            $kmp = KelasMataPelajaranModel::create([
                                'kelas_id' => $db->id,
                                'mata_pelajaran_id' => $mp['mata_pelajaran_id'],
                                'tutor_id' => $mp['tutor_id'],
                            ]);
                        }

                        foreach ($source->warga_belajar as $key => $wb) {
                            $kwb = KelasWbModel::create([
                                'kelas_id' => $db->id,
                                'wb_id' => $wb['wb_id'],
                            ]);
                            // return response()->json(['error' => true, 'data' => [$kwb]], 400);
                        }
                    }

                    // return response()->json(['error' => true, 'data' => []], 400);
                }
            }

            dd($db);
            DB::commit();
            return response()->json(['error' => false, 'message' => null, 'data' => $db], 200);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => true, 'message' => $e->getMessage()], 400);
        } catch (\Throwable $e) {
            DB::rollBack();
            return response()->json(['error' => true, 'message' => $e->getMessage()], 400);
        }
    }
}
