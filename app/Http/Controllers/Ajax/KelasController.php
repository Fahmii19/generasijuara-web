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
            Excel::import(new RombelImport(), $request->file('import_file'));
        }
        return response()->json([], 200); 
    }

    public function get(Request $request)
    {
        try {
            $id = !empty($request->get('id')) ? $request->get('id') : null;
            $kelas = KelasModel::find($id);
            return response()->json(['error' => false, 'message' => null, 'data' => $kelas ], 200); 
        } catch (\Exception $e) {
            return response()->json(['error' => true, 'message' => $e->getMessage()], 400); 
        }catch (\Throwable $e) {
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
                return response()->json(['error' => false, 'message' => null, 'data' => $kelas->get() ], 200); 
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
                return response()->json(['error' => false, 'message' => null, 'data' => $kelas->get() ], 200); 
            }
            $kelas = KelasModel::get();
            return response()->json(['error' => false, 'message' => null, 'data' => $kelas ], 200); 
        } catch (\Exception $e) {
            return response()->json(['error' => true, 'message' => $e->getMessage()], 400); 
        }catch (\Throwable $e) {
            return response()->json(['error' => true, 'message' => $e->getMessage()], 400); 
        }
    }

    public function getByName(Request $request)
    {
        try {
            $keyword = !empty($request->get('keyword')) ? $request->get('keyword') : null;
            $kelas = KelasModel::query();
            $kelas = $kelas->select('id','nama');
            if (!empty($keyword)) {
                $kelas = $kelas->where('nama', 'LIKE', "%$keyword%");
            }
            if (!empty($request->get('limit')) && $request->limit != null) {
                $kelas = $kelas->limit($request->limit);
            }
            return response()->json(['error' => false, 'message' => null, 'data' => $kelas->get() ], 200); 
        } catch (\Exception $e) {
            return response()->json(['error' => true, 'message' => $e->getMessage()], 400); 
        }catch (\Throwable $e) {
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
            return response()->json(['error' => false, 'message' => null, 'data' => $kelas ], 200); 
        } catch (\Exception $e) {
            return response()->json(['error' => true, 'message' => $e->getMessage()], 400); 
        }catch (\Throwable $e) {
            return response()->json(['error' => true, 'message' => $e->getMessage()], 400); 
        }
    }

    public function getType(Request $request)
    {
        try {
            $kelas = Constant::KELAS_TYPE;
            return response()->json(['error' => false, 'message' => null, 'data' => $kelas ], 200); 
        } catch (\Exception $e) {
            return response()->json(['error' => true, 'message' => $e->getMessage()], 400); 
        }catch (\Throwable $e) {
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
            return response()->json(['error' => false, 'message' => null, 'data' => [] ], 200); 
        } catch (\Exception $e) {
            return response()->json(['error' => true, 'message' => $e->getMessage()], 400); 
        }catch (\Throwable $e) {
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
            return response()->json(['error' => false, 'message' => null, 'data' => $kelas ], 200); 
        } catch (\Exception $e) {
            return response()->json(['error' => true, 'message' => $e->getMessage()], 400); 
        }catch (\Throwable $e) {
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
            return response()->json(['error' => false, 'message' => null, 'data' => $kelas ], 200); 
        } catch (\Exception $e) {
            return response()->json(['error' => true, 'message' => $e->getMessage()], 400); 
        }catch (\Throwable $e) {
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
            }else{
                // new
                $db = KelasModel::create($params);
                if(!empty($duplicate_source_id)){
                    $source = KelasModel::with([
                        'mata_pelajaran',
                        'warga_belajar',
                    ])->find($duplicate_source_id);

                    if(!empty($source)){
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
            return response()->json(['error' => false, 'message' => null, 'data' => $db ], 200); 
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => true, 'message' => $e->getMessage()], 400); 
        }catch (\Throwable $e) {
            DB::rollBack();
            return response()->json(['error' => true, 'message' => $e->getMessage()], 400); 
        }
    }
}
