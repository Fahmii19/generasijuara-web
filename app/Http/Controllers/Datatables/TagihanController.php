<?php

namespace App\Http\Controllers\Datatables;

use App\Http\Controllers\Controller;
use App\Models\TagihanModel;
use Illuminate\Http\Request;
use DataTables;

class TagihanController extends Controller
{
    public function getBaseModel()
    {
        $model = TagihanModel::with('ppdb','items')->select('tagihan.*');
        return $model;
    }

    public function getAll(Request $request)
    {
        $model = $this->getBaseModel();
        if ($request->has('ppdb_id') && $request->ppdb_id != null) {
            $model = $model->where('ppdb_id', $request->ppdb_id);
        }
        
        return DataTables::of($model)
            ->addIndexColumn()
            ->make(true);
    }
}
