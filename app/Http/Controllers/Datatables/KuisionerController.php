<?php

namespace App\Http\Controllers\Datatables;

use App\Http\Controllers\Controller;
use App\Models\KuisionerModel;
use App\Models\RombelModel;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class KuisionerController extends Controller
{
    public function getAll(Request $request)
    {
        $data = KuisionerModel::with(['tahun_akademik'])
                    ->selectRaw('kuisioner.id as id_kuisioner, tahun_akademik_id, is_published');

        if ($request->has('tahun_akademik_id') && $request->tahun_akademik_id != null) {
            $data = $data->where('tahun_akademik_id', $request->tahun_akademik_id);
        }

        return DataTables::of($data)
            ->addIndexColumn()
            ->make(true);
    }

    public function getHasilKuisioner(Request $request)
    {
        $model = RombelModel::with(['ppdb', 'tahun_akademik'])
                            ->select('rombel.*');
        
        if ($request->has('tahun_akademik_id') && $request->tahun_akademik_id != null) {
            $model = $model->where('rombel.tahun_akademik_id', $request->tahun_akademik_id);
        }
        if ($request->has('status') && $request->status != null) {
            $model = $model->where('rombel.is_answer_quiz', $request->status);
        }

        $model = $model->orderBy('rombel.tahun_akademik_id','DESC');
        $model = $model->orderBy('rombel.ppdb_id','ASC');

        return DataTables::of($model)
            ->addIndexColumn()
            ->make(true);
    }
}
