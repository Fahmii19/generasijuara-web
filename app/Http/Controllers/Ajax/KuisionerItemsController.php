<?php

namespace App\Http\Controllers\Ajax;

use App\Http\Controllers\Controller;
use App\Models\KuisionerItemsModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class KuisionerItemsController extends Controller
{
    public function get(Request $request)
    {
        try {
            $id = !empty($request->get('id')) ? $request->get('id') : null;
            $data = KuisionerItemsModel::find($id);
            return response()->json(['error' => false, 'message' => null, 'data' => $data ], 200); 
        } catch (\Exception $e) {
            return response()->json(['error' => true, 'message' => $e->getMessage()], 400); 
        }catch (\Throwable $e) {
            return response()->json(['error' => true, 'message' => $e->getMessage()], 400); 
        }
    }

    public function save(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'no_urut' => 'required',
            'item' => 'required',
            'input_type' => 'required',
            'input_label[]' => 'sometimes|required',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => true, 'message' => $validator->errors()], 400); 
        }

        try {
            $id = !empty($request->get('id')) ? $request->get('id') : null;
            $kuisioner = null;
            $input_label = [];
            $input_value = 0;

            if (!empty($id)) {
                $kuisioner = KuisionerItemsModel::find($id);
            } else {
                $kuisioner = new KuisionerItemsModel();
            }

            $kuisioner->kuisioner_id = $request->kuisioner_id;
            $kuisioner->no_urut = $request->no_urut;
            $kuisioner->item = $request->item;
            $kuisioner->input_type = $request->input_type;
            if ($request->input_type == 'radio') {
                $input_label_request = $request->input_label;
                foreach ($input_label_request as $key => $value) {
                    if (empty($value)) {
                        continue;
                    }
                    
                    $input_label[$key] = $value;
                    $input_value += 1;
                }
                $kuisioner->input_label = json_encode($input_label);
                $kuisioner->input_value = $input_value;
            }

            $kuisioner->save();

            return response()->json(['error' => false, 'message' => 'Success', 'data' => null ], 200); 
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
            $kuisioner = KuisionerItemsModel::find($id);
            $kuisioner->delete();
            return response()->json(['error' => false, 'message' => 'Success', 'data' => null ], 200); 
        } catch (\Exception $e) {
            return response()->json(['error' => true, 'message' => $e->getMessage()], 400); 
        }catch (\Throwable $e) {
            return response()->json(['error' => true, 'message' => $e->getMessage()], 400); 
        }
    }
}
