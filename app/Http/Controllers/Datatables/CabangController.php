<?php

namespace App\Http\Controllers\Datatables;

use App\Http\Controllers\Controller;
use App\Models\CabangModel;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class CabangController extends Controller
{
    public function getBaseModel()
    {
        $model = CabangModel::all();
        return $model;
    }

    public function getAll(Request $request)
    {
        $model = $this->getBaseModel();
        return DataTables::of($model)
            ->addIndexColumn()
            ->make(true);
    }
}
