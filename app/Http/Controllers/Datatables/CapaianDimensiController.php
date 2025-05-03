<?php

namespace App\Http\Controllers\Datatables;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class CapaianDimensiController extends Controller
{
    private $select = 'p.id as point_id, p.fase, d.dimensi_name, e.elemen_name, p.point_name';

    private function getBaseModel()
    {
        $results = DB::select("
            SELECT p.id as point_id, p.fase, d.dimensi_name, e.elemen_name, p.point_name FROM dimensi d
            JOIN elemen e ON e.dimensi_id = d.id
            JOIN point p ON p.elemen_id = e.id
        ");
            
        return $results;
    }

    public function getAll()
    {
        $model = $this->getBaseModel();

        return DataTables::of($model)
            ->addIndexColumn()
            ->make(true);
    }
}
