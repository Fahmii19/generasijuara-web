<?php

namespace App\Http\Controllers\Datatables;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PaketKelasModel;
use DataTables;
use DB;

class PaketKelasController extends Controller
{
    private $select = '
        pk.*
    ';

    private function getBaseModel()
    {
        $model = PaketKelasModel::from('paket_kelas as pk')
            ->select(DB::raw($this->select));
            
        return $model;
    }

    public function getAll(Request $request)
    {
        $model = $this->getBaseModel();

        if ($request->has('type')) {
           $model = $model->where('type', $request->type);
        }

        $datatables = DataTables::of($model)
            ->filterColumn('kode', function($query, $keyword) {
                $query->whereRaw("LOWER(kode) LIKE ?", ["%{$keyword}%"]);
            })
            ->filterColumn('nama', function($query, $keyword) {
                $query->whereRaw("LOWER(nama) LIKE ?", ["%{$keyword}%"]);
            })
            ->filterColumn('type', function($query, $keyword) {
                if (stristr('ABC', $keyword)) {
                    $keyword = 0;
                } else if (stristr('PAUD', $keyword)) {
                    $keyword = 1;
                }
                
                $query->whereRaw("LOWER(type) LIKE ?", ["%{$keyword}%"]);
            })
            ->filterColumn('is_active', function($query, $keyword) {
                if(stristr('Aktif', $keyword)) {
                    $keyword = 1;
                } else if(stristr('Tidak Aktif', $keyword)) {
                    $keyword = 0;
                }

                $query->whereRaw("LOWER(is_active) LIKE ?", ["%{$keyword}%"]);
            })
            ->make(true);

        return $datatables;
    }
}
