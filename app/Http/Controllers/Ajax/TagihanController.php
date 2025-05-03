<?php

namespace App\Http\Controllers\Ajax;

use App\Http\Controllers\Controller;
use App\Models\TagihanItemsModel;
use App\Models\TagihanModel;
use Illuminate\Http\Request;

class TagihanController extends Controller
{
    public function getTagihan(Request $request)
    {
        try {
            $id = !empty($request->id) ? $request->id : null;
            $tagihan = TagihanModel::query();
            $tagihan = $tagihan->with(['items','ppdb']);

            if (!empty($id)) {
                $tagihan = $tagihan->where('id', $id);
            }
            return response()->json(['error' => false, 'message' => null, 'data' => $tagihan->first() ], 200); 
        } catch (\Exception $e) {
            return response()->json(['error' => true, 'message' => $e->getMessage()], 400);
        } catch (\Throwable $e) {
            return response()->json(['error' => true, 'message' => $e->getMessage()], 400);
        }
    }

    public function getTagihanItems(Request $request)
    {
        try {
            $db = TagihanItemsModel::where('tagihan_id', $request->tagihan_id)->get();
            return response()->json(['error' => false, 'message' => null, 'data' => $db ], 200); 
        } catch (\Exception $e) {
            return response()->json(['error' => true, 'message' => $e->getMessage()], 400);
        } catch (\Throwable $e) {
            return response()->json(['error' => true, 'message' => $e->getMessage()], 400);
        }
    }
}
