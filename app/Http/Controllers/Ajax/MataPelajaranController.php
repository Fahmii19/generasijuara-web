<?php

namespace App\Http\Controllers\Ajax;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\MataPelajaranModel;
use App\Models\TutorModel;
use App\Models\KelasMataPelajaranModel;
use DB;

class MataPelajaranController extends Controller
{
    public function get(Request $request)
    {
        try {
            $id = !empty($request->get('id')) ? $request->get('id') : null;
            $mata_pelajaran = MataPelajaranModel::find($id);
            return response()->json(['error' => false, 'message' => null, 'data' => $mata_pelajaran ], 200); 
        } catch (\Exception $e) {
            return response()->json(['error' => true, 'message' => $e->getMessage()], 400); 
        }catch (\Throwable $e) {
            return response()->json(['error' => true, 'message' => $e->getMessage()], 400); 
        }
    }

    public function getAll(Request $request)
    {
        try {
            $mata_pelajaran = MataPelajaranModel::query();

            if ($request->has('keyword')) {
                $mata_pelajaran->where('nama', 'LIKE', "%$request->keyword%")->limit(10);
            }

            return response()->json(['error' => false, 'message' => null, 'data' => $mata_pelajaran->get() ], 200); 
        } catch (\Exception $e) {
            return response()->json(['error' => true, 'message' => $e->getMessage()], 400); 
        }catch (\Throwable $e) {
            return response()->json(['error' => true, 'message' => $e->getMessage()], 400); 
        }
    }

    public function getByKelas(Request $request)
    {
        try {
            $mata_pelajaran = KelasMataPelajaranModel::with(['mata_pelajaran_detail'])->where('kelas_id', $request->kelas_id);
            if (!empty($request->user_id_tutor)) {
                $tutor = TutorModel::where('user_id', $request->user_id_tutor)->first();
                $mata_pelajaran->where('tutor_id', $tutor->id);
            }
            return response()->json(['error' => false, 'message' => null, 'data' => $mata_pelajaran->get() ], 200); 
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
            $mata_pelajaran = MataPelajaranModel::find($id);
            if (empty($mata_pelajaran)) {
                return response()->json(['error' => true, 'message' => 'Mata pelajaran tidak ditemukan'], 400); 
            }
            $mata_pelajaran->delete();
            return response()->json(['error' => false, 'message' => null, 'data' => [] ], 200); 
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
            $nama = !empty($request->get('nama')) ? $request->get('nama') : null;
            $kelompok = !empty($request->get('kelompok')) ? $request->get('kelompok') : null;
            $sub_kelompok = !empty($request->get('sub_kelompok')) ? $request->get('sub_kelompok') : null;
            $is_active = !empty($request->get('is_active')) ? filter_var($request->get('is_active'), FILTER_VALIDATE_BOOLEAN) : false;
            $is_mapel_ekskul = !empty($request->get('is_mapel_ekskul')) ? filter_var($request->get('is_mapel_ekskul'), FILTER_VALIDATE_BOOLEAN) : false;
            
            $mata_pelajaran = MataPelajaranModel::find($id);
            if (!empty($mata_pelajaran)) {
                // update
                $mata_pelajaran->nama = $nama;
                $mata_pelajaran->kelompok = $kelompok;
                $mata_pelajaran->sub_kelompok = $sub_kelompok;
                $mata_pelajaran->is_active = $is_active;
                $mata_pelajaran->is_mapel_ekskul = $is_mapel_ekskul;
                $mata_pelajaran->save();
            }else{
                // new
                $mata_pelajaran = MataPelajaranModel::create([
                    'nama' => $nama,
                    'kelompok' => $kelompok,
                    'sub_kelompok' => $sub_kelompok,
                    'is_active' => $is_active,
                    'is_mapel_ekskul' => $is_mapel_ekskul,
                ]);
            }
            DB::commit();
            return response()->json(['error' => false, 'message' => null, 'data' => $mata_pelajaran ], 200); 
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => true, 'message' => $e->getMessage()], 400); 
        }catch (\Throwable $e) {
            DB::rollBack();
            return response()->json(['error' => true, 'message' => $e->getMessage()], 400); 
        }
    }
}
