<?php

namespace App\Http\Controllers\Datatables;

use App\Http\Controllers\Controller;
use App\Models\RombelModel;
use Illuminate\Http\Request;
use DataTables;
use DB;

class RombonganBelajarController extends Controller
{
    public function getBaseModel()
    {
        $model = RombelModel::with([
            'kelas',
            'tahun_akademik',
            'ppdb',
            'ppdb.kelas_wb:id,wb_id'
        ])->select('rombel.*');

        return $model;
    }

    public function getAll(Request $request)
    {
        $model = $this->getBaseModel();
        if ($request->has('nama_orang_tua') && $request->nama_orang_tua != null) {
            $model = $model->whereHas('ppdb', function ($query) {
                $query->where('ppdb.nama_ibu', 'LIKE', '%' . request('nama_orang_tua') . '%')
                    ->orWhere('ppdb.nama_ayah', 'LIKE', '%' . request('nama_orang_tua') . '%');
            });
        }
        if ($request->has('tahun_akademik_id') && $request->tahun_akademik_id != null) {
            $model = $model->where('rombel.tahun_akademik_id', $request->tahun_akademik_id);
        }

        if ($request->has('cabang_id') && $request->cabang_id != null) {
            $model->whereHas('ppdb', function ($query) use ($request) {
                $query->where('ppdb.cabang_id', $request->cabang_id);
            });
        }

        if ($request->has('ppdb_type') && $request->ppdb_type != null) {
            $model->whereHas('ppdb', function ($query) use ($request) {
                $query->where('ppdb.type', $request->ppdb_type);
            });
        }

        if ($request->has('ppdb_id') && $request->ppdb_id != null) {
            $model = $model->whereIn('ppdb_id', $request->ppdb_id);
        }

        return DataTables::of($model)
            ->addIndexColumn()
            ->addColumn('siab_action', function ($row) {
                $kelas_wb_id = $row->ppdb->kelas_wb != null ? $row->ppdb->kelas_wb->id : "";

                $btn = '
                                <form action="' . route('web.siab.raport-cover.print') . '" method="POST" target="_blank">
                                    <input type="hidden" name="_token" value="' . csrf_token() . '">
                                    <input type="hidden" name="kelas_id" value="' . $row->kelas_id . '">
                                    <input type="hidden" name="ppdb_id" value="' . $row->ppdb_id . '">
                                    <input type="hidden" name="kelas_wb_id" value="' . $kelas_wb_id . '">
                                    <div class="d-grid gap-2">
                                        <button type="submit" class="btn btn-sm btn-outline-dark btn-block m-1">
                                            <i class="fas fa-file"></i> Cover
                                        </button>
                                        <a href="' . route('web.siab.raport.print', $row->kelas_id) . '"
                                            target="_blank" class="btn btn-sm btn-outline-dark btn-block m-1">
                                            <i class="fas fa-print"></i> Rapor
                                        </a>
                                    </div
                                </form>
                            ';
                return $btn;
            })
            ->rawColumns(['siab_action'])
            ->make(true);
    }
}
