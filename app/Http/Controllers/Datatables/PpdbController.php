<?php

namespace App\Http\Controllers\Datatables;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PpdbModel;
use DataTables;
use DB;

class PpdbController extends Controller
{
    private $select = '
        ppdb.*,
        lk.nama as lk_nama,
        lk.kode as lk_kode,
        pk.nama as pk_nama,
        pk.kode as pk_kode
    ';

    private function getBaseModel()
    {
        $model = PpdbModel::with(['user_detail'])
            ->from('ppdb')
            ->select(DB::raw($this->select))
            ->leftJoin('layanan_kelas as lk', 'lk.id', '=', 'ppdb.layanan_kelas_id')
            ->leftJoin('paket_kelas as pk', 'pk.id', '=', 'ppdb.paket_kelas_id');
            
        return $model;
    }

    public function getAll(Request $request)
    {
        $model = $this->getBaseModel();
        if ($request->has('type')) {
           $model = $model->where('ppdb.type', $request->type);
        }
        return DataTables::of($model)
            ->make(true);
    }
}
