<?php

namespace App\Http\Controllers\Ajax;

use App\Http\Controllers\Controller;
use App\Models\KuisionerItemsModel;
use App\Models\KuisionerModel;
use App\Models\KuisionerResponModel;
use App\Models\KuisionerWbModel;
use App\Models\RombelModel;
use App\Models\TahunAkademikModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class KuisionerController extends Controller
{
    public function get(Request $request)
    {
        try {
            $id = !empty($request->get('id')) ? $request->get('id') : null;
            $data = KuisionerModel::find($id);
            return response()->json(['error' => false, 'message' => null, 'data' => $data ], 200); 
        } catch (\Exception $e) {
            return response()->json(['error' => true, 'message' => $e->getMessage()], 400); 
        }catch (\Throwable $e) {
            return response()->json(['error' => true, 'message' => $e->getMessage()], 400); 
        }
    }

    public function save(Request $request)
    {
        try {
            $id = !empty($request->get('id')) ? $request->get('id') : null;
            $is_published = $request->status_kuisioner == 'published' ? true : false;

            if (!empty($id)) {
                $kuisioner = KuisionerModel::find($id);
            } else {
                $kuisioner = new KuisionerModel();

                $is_already = KuisionerModel::where('tahun_akademik_id', $request->tahun_akademik_id)->first();
                if (!empty($is_already)) {
                    return response()->json([
                        'error' => true,
                        'message' => 'Kuisioner untuk tahun akademik ini sudah ada',
                        'data' => null
                    ], 400);
                }
            }

            $kuisioner->tahun_akademik_id = $request->tahun_akademik_id;
            $kuisioner->is_published = $is_published;
            $kuisioner->save();

            return response()->json([
                'error' => false,
                'message' => null,
                'data' => $kuisioner
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'error' => true,
                'message' => $e->getMessage()
            ], 400);
        } catch (\Throwable $th) {
            return response()->json([
                'error' => true,
                'message' => $th->getMessage(),
                'data' => null
            ], 400);
        }
    }

    public function delete(Request $request)
    {
        try {
            $id = !empty($request->get('id')) ? $request->get('id') : null;
            $kuisioner = KuisionerModel::find($id);
            $is_answer_quiz = RombelModel::where('tahun_akademik_id', $kuisioner->tahun_akademik_id)
                                            ->where('is_answer_quiz', true)
                                            ->update(['is_answer_quiz' => false]);

            $kuisioner->delete();
            return response()->json([
                'error' => false,
                'message' => 'Success',
                'data' => null
            ], 200); 
        } catch (\Exception $e) {
            return response()->json(['error' => true, 'message' => $e->getMessage()], 400); 
        }catch (\Throwable $e) {
            return response()->json(['error' => true, 'message' => $e->getMessage()], 400); 
        }
    }

    public function duplicate(Request $request)
    {
        DB::beginTransaction();
        $tahun_akademik_source = $request->tahun_akademik_source;
        $tahun_akademik_destination = $request->tahun_akademik_destination;
        $force = $request->force ?? false;

        try {
            if ($tahun_akademik_source == $tahun_akademik_destination) {
                return response()->json(['error' => true, 'message' => 'Tahun akademik tidak boleh sama!'], 400);
            } else {
                // Membuat atau memperbarui kuisioner
                $new_kuisioner = KuisionerModel::updateOrCreate(
                    ['tahun_akademik_id' => $tahun_akademik_destination],
                    ['is_published' => false]
                );

                $kuisioner_id_source = KuisionerModel::where('tahun_akademik_id', $tahun_akademik_source)->first()->id;
                $kuisioner_id_destination = KuisionerModel::where('tahun_akademik_id', $tahun_akademik_destination)->first()->id;
                $kuisioner_items_source = KuisionerItemsModel::where('kuisioner_id', $kuisioner_id_source)->get();
                $kuisioner_items_destination = KuisionerItemsModel::where('kuisioner_id', $kuisioner_id_destination)->get();                

                if ((count($kuisioner_items_destination) > 0) && !$force) {
                    return response()->json([
                        'error' => true,
                        'message' => 'Tahun akademik tujuan sudah ada.',
                        'data' => [
                            'tahun_akademik_source' => $tahun_akademik_source,
                            'tahun_akademik_destination' => $tahun_akademik_destination,
                        ],
                        'action' => 'NEED_CONFIRMATION'
                    ], 400);
                }

                // Menghapus item kuisioner sebelumnya
                KuisionerItemsModel::where('kuisioner_id', $new_kuisioner->id)->delete();

                // Membuat kuisioner items baru
                foreach ($kuisioner_items_source as $key => $value) {
                    $kuisioner_destination = new KuisionerItemsModel();
                    $kuisioner_destination->kuisioner_id = $new_kuisioner->id;
                    $kuisioner_destination->no_urut = $value->no_urut;
                    $kuisioner_destination->item = $value->item;
                    $kuisioner_destination->input_type = $value->input_type;
                    $kuisioner_destination->input_label = $value->input_label;
                    $kuisioner_destination->input_value = $value->input_value;
                    $kuisioner_destination->save();
                }

                DB::commit();
                return response()->json(['error' => false, 'message' => 'Success', 'data' => null ], 200);
            }
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['error' => true, 'message' => $e->getMessage(), 'line' => $e->getLine()], 400);
        } catch (\Throwable $th) {
            DB::rollback();
            return response()->json(['error' => true, 'message' => $th->getMessage(), 'line' => $th->getFile() ], 500);
        }

    }


    public function saveRespon(Request $request)
    {
        DB::beginTransaction();
        try {
            $kuisioner_item_id = [];
            $kuisioner_value = [];
    
            // Membuat Kuisioner WB
            $kuisioner_wb = new KuisionerWbModel();
            $kuisioner_wb->ppdb_id = $request->ppdb_id;
            $kuisioner_wb->kuisioner_id = $request->kuisioner_id;
            $kuisioner_wb->save();
    
            // Data Kuisioner ID
            foreach ($request->kuisioner_item_id as $key => $value) {
                $kuisioner_item_id[$key] = $value;
            }
    
            // Data Kuisioner Value
            foreach ($request->kuisioner_value as $key => $value) {
                $kuisioner_value[$key] = $value;
            }
    
            // Menyimpan data respon kuisioner
            foreach ($request->kuisioner_item_id as $key => $value) {
                KuisionerResponModel::create([
                    'kuisioner_wb_id' => $kuisioner_wb->id,
                    'kuisioner_item_id' => $value,
                    'value' => $request->kuisioner_value[$key],
                ]);
            }
    
            // Memperbarui status kuisioner pada rombel
            RombelModel::where('ppdb_id', $request->ppdb_id)
                        ->where('tahun_akademik_id', $request->tahun_akademik_id)
                        ->update(['is_answer_quiz' => '1']);
    
            DB::commit();
            return response()->json(['error' => false, 'message' => 'Success', 'data' => null ], 200);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['error' => true, 'message' => $e->getMessage()], 400);
        } catch (\Throwable $th) {
            DB::rollback();
            return response()->json(['error' => true, 'message' => $th->getMessage(), 'data' => null ], 500);
        }
    }
}
