<?php

namespace App\Http\Controllers\Ajax;

use App\Http\Controllers\Controller;
use App\Models\KelasModel;
use Illuminate\Http\Request;
use App\Models\KelasWbModel;
use App\Models\RombelModel;
use App\Models\PointModel;
use App\Models\NilaiPointModel;
use App\Models\CatatanProsesWBModel;
use App\Models\DimensiModel;
use Constant;
use DB;

class KelasWbController extends Controller
{
    public function get(Request $request)
    {
        try {
            $id = $request->get('id');

            // Ambil data utama dengan relasi yang diperlukan
            $kelas_wb = KelasWbModel::with([
                'wb_detail:id,nama',
                'kelas_detail:id,nama,jenis_rapor,kelas',
                'nilai_points' => function ($query) {
                    $query->select('id', 'point_id', 'kelas_wb_id', 'point_nilai');
                },
                'nilai_points.point' => function ($query) {
                    $query->select('id', 'elemen_id', 'point_name', 'fase')
                        ->with(['elemen:id,dimensi_id,elemen_name']);
                },
                'nilai_points.point.elemen.dimensi:id,dimensi_name',
                'catatan_proses_wb:id,dimensi_id,kelas_wb_id,catatan_proses'
            ])->findOrFail($id);

            // Tentukan fase berdasarkan kelas
            $fase = '';
            foreach (Constant::FASE_MAPPING as $key => $values) {
                if (in_array($kelas_wb->kelas_detail->kelas, $values)) {
                    $fase = $key;
                    break;
                }
            }

            // Ambil poin penilaian dengan struktur yang benar
            $poin_penilaian = DimensiModel::with([
                'elemens' => function ($query) use ($fase) {
                    $query->select('id', 'dimensi_id', 'elemen_name')
                        ->with(['points' => function ($q) use ($fase) {
                            $q->where('fase', $fase)
                                ->select('id', 'elemen_id', 'point_name', 'fase');
                        }]);
                }
            ])->select('id', 'dimensi_name')->get();

            // Format nilai poin penilaian untuk frontend
            $nilai_poin_penilaian = NilaiPointModel::where('kelas_wb_id', $id)
                ->get(['id', 'point_id', 'kelas_wb_id', 'point_nilai']);

            // Format data untuk response
            $data = [
                'kelas_wb' => $kelas_wb,
                'poin_penilaian' => $poin_penilaian->map(function ($dimensi) {
                    return [
                        'id' => $dimensi->id,
                        'dimensi_name' => $dimensi->dimensi_name,
                        'elemens' => $dimensi->elemens->map(function ($elemen) {
                            return [
                                'id' => $elemen->id,
                                'elemen_name' => $elemen->elemen_name,
                                'points' => $elemen->points->map(function ($point) {
                                    return [
                                        'id' => $point->id,
                                        'point_name' => $point->point_name,
                                        'fase' => $point->fase
                                    ];
                                })
                            ];
                        })
                    ];
                }),
                'nilai_poin_penilaian' => $nilai_poin_penilaian->map(function ($nilai) {
                    return [
                        'point_id' => $nilai->point_id,
                        'point_nilai' => $nilai->point_nilai
                    ];
                }),
                'catatan_proses_wb' => $kelas_wb->catatan_proses_wb->map(function ($catatan) {
                    return [
                        'dimensi_id' => $catatan->dimensi_id,
                        'catatan_proses' => $catatan->catatan_proses
                    ];
                })
            ];

            return response()->json([
                'error' => false,
                'message' => null,
                'data' => $data
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'error' => true,
                'message' => $e->getMessage(),
                'line' => $e->getLine()
            ], 400);
        }
    }

    public function getAll(Request $request)
    {
        try {
            $kelas_wb = KelasWbModel::get();
            return response()->json(['error' => false, 'message' => null, 'data' => $kelas_wb], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => true, 'message' => $e->getMessage()], 400);
        } catch (\Throwable $e) {
            return response()->json(['error' => true, 'message' => $e->getMessage()], 400);
        }
    }

    public function delete(Request $request)
    {
        DB::beginTransaction();
        try {
            $id = !empty($request->get('id')) ? $request->get('id') : null;
            $kelas_wb = KelasWbModel::find($id);
            if (empty($kelas_wb)) {
                return response()->json(['error' => true, 'message' => 'Kelas WB tidak ditemukan'], 400);
            }

            // Cek rombel
            $rombel = RombelModel::where('ppdb_id', $kelas_wb->wb_id)
                ->where('tahun_akademik_id', $kelas_wb->kelas_detail->tahun_akademik_id)
                ->first();

            if (!empty($rombel)) {
                $rombel->delete();
            }

            // Delete kelas wb
            $kelas_wb->delete();

            DB::commit();
            return response()->json(['error' => false, 'message' => null, 'data' => []], 200);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['error' => true, 'message' => $e->getMessage()], 400);
        } catch (\Throwable $e) {
            DB::rollback();
            return response()->json(['error' => true, 'message' => $e->getMessage()], 400);
        }
    }

    public function save(Request $request)
    {
        DB::beginTransaction();
        try {
            $id = !empty($request->get('id')) ? $request->get('id') : null;
            $old_wb_id = !empty($request->get('old_wb_id')) ? $request->get('old_wb_id') : null;
            $wb_id = !empty($request->get('wb_id')) ? $request->get('wb_id') : null;
            $kelas_id = !empty($request->get('kelas_id')) ? $request->get('kelas_id') : null;

            $kelas_wb = KelasWbModel::find($id);
            $kelas_detail = KelasModel::find($kelas_id);
            $params = [
                'wb_id' => $wb_id,
                'kelas_id' => $kelas_id,
            ];

            $checkDuplicateData = KelasWbModel::where('wb_id', $wb_id)
                ->where('kelas_id', $kelas_id)
                ->first();
            if (!empty($checkDuplicateData)) {
                return response()->json(['error' => true, 'message' => "Warga Belajar sudah terdaftar sebelumnya"], 400);
            }

            if (!empty($kelas_wb)) {
                // update
                $kelas_wb->update($params);

                // Update Rombel
                RombelModel::where('ppdb_id', $old_wb_id)
                    ->where('tahun_akademik_id', $kelas_detail->tahun_akademik_id)
                    ->update([
                        'kelas_id' => $kelas_id,
                        'ppdb_id' => $wb_id,
                    ]);
            } else {
                // new
                $kelas_wb = KelasWbModel::create($params);

                // New Rombel
                $checkRombel = RombelModel::where('ppdb_id', $wb_id)
                    ->where('tahun_akademik_id', $kelas_detail->tahun_akademik_id)
                    ->first();

                if (empty($checkRombel)) {
                    RombelModel::create([
                        'ppdb_id' => $wb_id,
                        'tahun_akademik_id' => $kelas_detail->tahun_akademik_id,
                        'kelas_id' => $kelas_id,
                        'status_wb' => 'Baru',
                        'is_active' => true,
                    ]);
                }
            }
            DB::commit();
            return response()->json(['error' => false, 'message' => null, 'data' => $kelas_wb], 200);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => true, 'message' => $e->getMessage()], 400);
        } catch (\Throwable $e) {
            DB::rollBack();
            return response()->json(['error' => true, 'message' => $e->getMessage()], 400);
        }
    }

    public function updateCatatan(Request $request)
    {
        DB::beginTransaction();
        try {
            $id = !empty($request->get('id')) ? $request->get('id') : null;
            $catatan_pj_rombel = !empty($request->get('catatan_pj_rombel')) ? $request->get('catatan_pj_rombel') : null;
            $tanggapan_wali = !empty($request->get('tanggapan_wali')) ? $request->get('tanggapan_wali') : null;
            $catatan = !empty($request->get('catatan')) ? $request->get('catatan') : null;

            $catatan_perkembangan_profil_pelajar = !empty($request->get('catatan_perkembangan_profil_pelajar')) ? $request->get('catatan_perkembangan_profil_pelajar') : null;
            $catatan_perkembangan_pemberdayaan = !empty($request->get('catatan_perkembangan_pemberdayaan')) ? $request->get('catatan_perkembangan_pemberdayaan') : null;
            $catatan_perkembangan_keterampilan = !empty($request->get('catatan_perkembangan_keterampilan')) ? $request->get('catatan_perkembangan_keterampilan') : null;

            $kelas_wb = KelasWbModel::find($id);

            if (empty($kelas_wb)) {
                return response()->json(['error' => true, 'message' => 'Kelas WB tidak ditemukan'], 400);
            }

            $params = [
                'catatan_pj_rombel' => $catatan_pj_rombel,
                'tanggapan_wali' => $tanggapan_wali,
                'catatan' => $catatan,

                'catatan_perkembangan_profil_pelajar' => $catatan_perkembangan_profil_pelajar,
                'catatan_perkembangan_pemberdayaan' => $catatan_perkembangan_pemberdayaan,
                'catatan_perkembangan_keterampilan' => $catatan_perkembangan_keterampilan,
            ];

            $kelas_wb->update($params);
            // dd($kelas_wb);
            DB::commit();
            return response()->json(['error' => false, 'message' => null, 'data' => $kelas_wb], 200);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => true, 'message' => $e->getMessage()], 400);
        } catch (\Throwable $e) {
            DB::rollBack();
            return response()->json(['error' => true, 'message' => $e->getMessage()], 400);
        }
    }

    public function updatePresensi(Request $request)
    {
        DB::beginTransaction();
        try {
            $id = !empty($request->get('id')) ? $request->get('id') : null;
            $izin = !empty($request->get('izin')) ? $request->get('izin') : 0;
            $sakit = !empty($request->get('sakit')) ? $request->get('sakit') : 0;
            $alpa = !empty($request->get('alpa')) ? $request->get('alpa') : 0;

            $kelas_wb = KelasWbModel::find($id);

            if (empty($kelas_wb)) {
                return response()->json(['error' => true, 'message' => 'Kelas WB tidak ditemukan'], 400);
            }

            $params = [
                'izin' => $izin,
                'sakit' => $sakit,
                'alpa' => $alpa,
            ];

            $kelas_wb->update($params);
            // dd($kelas_wb);
            DB::commit();
            return response()->json(['error' => false, 'message' => null, 'data' => $kelas_wb], 200);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => true, 'message' => $e->getMessage()], 400);
        } catch (\Throwable $e) {
            DB::rollBack();
            return response()->json(['error' => true, 'message' => $e->getMessage()], 400);
        }
    }
}
