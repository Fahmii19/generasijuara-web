<?php

namespace App\Http\Controllers\Datatables;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\KelasModel;
use DataTables;
use DB;

class KelasController extends Controller
{
    private $select = '
        kelas.*,
        lk.kode as lk_kode,
        lk.nama as lk_nama,
        pk.nama as pk_nama,
        ta.tahun_ajar as ta_tahun_ajar,
        ta.keterangan as ta_keterangan,
        kwb.kelas_id as kwb_kelas_id,
        COUNT(kwb.kelas_id) as jumlah_siswa
    ';

    private function getBaseModel()
    {
        $model = KelasModel::from('kelas')
            ->select(DB::raw($this->select))
            ->leftJoin('tahun_akademik as ta', 'ta.id', '=', 'kelas.tahun_akademik_id')
            ->leftJoin('layanan_kelas as lk', 'lk.id', '=', 'kelas.layanan_kelas_id')
            ->leftJoin('paket_kelas as pk', 'pk.id', '=', 'kelas.paket_kelas_id')
            ->join('kelas_wb as kwb', 'kwb.kelas_id', '=', 'kelas.id')
            ->groupBy('kwb.kelas_id');
            
        return $model;
    }

    public function getAll(Request $request)
    {
        $model = $this->getBaseModel();

        if ($request->has('type') && $request->type != '') {
            $model = $model->where('kelas.type', $request->type);
        }
        if ($request->has('layanan_kelas_id') && $request->layanan_kelas_id != '') {
            $model = $model->where('kelas.layanan_kelas_id', $request->layanan_kelas_id);
        }
        if ($request->has('tahun_akademik_id') && $request->tahun_akademik_id != '') {
            $model = $model->where('kelas.tahun_akademik_id', $request->tahun_akademik_id);
        }
        if ($request->has('semester') && $request->semester != '') {
            $model = $model->where('kelas.semester', $request->semester);
        }
        
        return DataTables::of($model)
            ->make(true);
    }
}
