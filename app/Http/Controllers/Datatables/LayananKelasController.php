<?php

namespace App\Http\Controllers\Datatables;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\LayananKelasModel;
use DataTables;
use DB;

class LayananKelasController extends Controller
{
    private $select = '
        lk.*
    ';

    private function getBaseModel()
    {
        $model = LayananKelasModel::from('layanan_kelas as lk')
            ->select(DB::raw($this->select));
            
        return $model;
    }

    public function getAll(Request $request)
    {
        $model = $this->getBaseModel();
        
        $datatables = DataTables::of($model)
            ->filterColumn('kode', function($query, $keyword) {
                $query->whereRaw("LOWER(kode) LIKE ?", ["%{$keyword}%"]);
            })
            ->filterColumn('nama', function($query, $keyword) {
                $query->whereRaw("LOWER(nama) LIKE ?", ["%{$keyword}%"]);
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
