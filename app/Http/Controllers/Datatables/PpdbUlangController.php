<?php

namespace App\Http\Controllers\Datatables;

use App\Http\Controllers\Controller;
use App\Models\PpdbUlangModel;
use Illuminate\Http\Request;
use DB;
use DataTables;

class PpdbUlangController extends Controller
{
    private $select = '
        ppdb_ulang.*,
        ppdb.nama,
        ppdb.nik_siswa,
        ppdb.nis,
        ppdb.hp_siswa,
        lk.nama as lk_nama,
        lk.kode as lk_kode,
        pk.nama as pk_nama,
        pk.kode as pk_kode
    ';

    private function getBaseModel()
    {
        $model = PpdbUlangModel::from('ppdb_ulang')
            ->select(DB::raw($this->select))
            ->leftJoin('ppdb', 'ppdb.id', '=', 'ppdb_ulang.ppdb_id')
            ->leftJoin('layanan_kelas as lk', 'lk.id', '=', 'ppdb_ulang.layanan_kelas_id')
            ->leftJoin('paket_kelas as pk', 'pk.id', '=', 'ppdb_ulang.paket_kelas_id');
            
        return $model;
    }

    public function getAll(Request $request)
    {
        $model = $this->getBaseModel();
        if ($request->has('type')) {
            $model = $model->where('ppdb_ulang.type', $request->type);
         }
        return DataTables::of($model)
            ->addIndexColumn()
            ->make(true);
    }
}
