<?php

namespace App\Http\Controllers\Datatables;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\KelasWbModel;
use DataTables;
use DB;

class KelasWbController extends Controller
{
    private $select = '
        kelas_wb.*,
        ppdb.nis as ppdb_nis,
        ppdb.nisn as ppdb_nisn,
        ppdb.nama as ppdb_nama,
        k.nama as k_nama,
        k.kode as k_kode
    ';

    private function getBaseModel()
    {
        $model = KelasWbModel::from('kelas_wb as kelas_wb')
            ->select(DB::raw($this->select))
            ->leftJoin('kelas as k', 'k.id', '=', 'kelas_wb.kelas_id')
            ->leftJoin('ppdb', 'ppdb.id', '=', 'kelas_wb.wb_id')
            ;
            
        return $model;
    }

    public function getAll(Request $request)
    {
        $model = $this->getBaseModel();

        if ($request->has('kelas_id')) {
           $model = $model->where('kelas_wb.kelas_id', $request->kelas_id);
        }
        
        if ($request->has('show_all') && $request->show_all == 'true') {
            $model = $model->whereIn('kelas_wb.is_active', [true, false]);
        } else {
            $model = $model->where('kelas_wb.is_active', true);
        }

        return DataTables::of($model)
            ->make(true);
    }
}
