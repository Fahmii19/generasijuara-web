<?php

namespace App\Http\Controllers\Datatables;

use App\Http\Controllers\Controller;
use App\Models\TagihanModel;
use Illuminate\Http\Request;
use DataTables;

class PembayaranController extends Controller
{

    public function getBaseModel()
    {
        $model = TagihanModel::with('ppdb')->select('tagihan.*');

        return $model;
    }

    public function getAll(Request $request)
    {
        $model = $this->getBaseModel();
        if ($request->has('kelas_id') && $request->kelas_id != null) {
            $model = $model->whereHas('ppdb', function($query) {
                $query->where('ppdb.kelas_id', request('kelas_id'));
            });
        }
        if ($request->has('ppdb_id') && $request->ppdb_id != null) {
            $model = $model->whereHas('ppdb', function($query) {
                $query->where('ppdb.id', request('ppdb_id'));
            });
        }
        
        return DataTables::of($model)
            ->addIndexColumn()
            ->make(true);
    }
}
