<?php

namespace App\Http\Controllers\Datatables;

use App\Http\Controllers\Controller;
use App\Models\KelasWbModel;
use App\Models\NilaiModel;
use App\Models\PpdbModel;
use App\Models\TutorModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;

class SusulanRemedialController extends Controller
{
    private $select = "
        kelas_wb.wb_id,
        kelas_wb.kelas_id as kelas_id,
        kmp.id as kmp_id,
        ppdb.nama as nama_siswa,
        kelas.nama as nama_kelas,
        mp.nama as nama_mapel,
        n.susulan_remedial
    ";

    public function getBaseModel()
    {
        $model = KelasWbModel::from('kelas_wb')
            ->select(DB::raw($this->select))
            ->leftJoin('ppdb', 'ppdb.id', '=', 'kelas_wb.wb_id')
            ->leftJoin('kelas', 'kelas.id', '=', 'kelas_wb.kelas_id')
            ->leftJoin('kelas_mata_pelajaran as kmp', 'kmp.kelas_id', '=', 'kelas_wb.kelas_id')
            ->leftJoin('mata_pelajaran as mp', 'mp.id', '=', 'kmp.mata_pelajaran_id')
            ->leftJoin('nilai as n', function($join) {
                $join->on('n.kelas_id', '=', 'kelas.id');
                $join->on('n.kmp_id', '=', 'kmp.id');
                $join->on('n.wb_id', '=', 'kelas_wb.wb_id');
            })
            ->orderBy('kelas_wb.kelas_id', 'asc');

        return $model;
    }

    public function getBaseModelSiswa()
    {
        $model = NilaiModel::with(
            'kelas:id,nama',
            'kmp.mata_pelajaran_detail:id,nama',
            'wb:id,nama',
            'kmp:id,mata_pelajaran_id',
        )
        ->select('kelas_id','kmp_id','wb_id','susulan_remedial')
        ->where('susulan_remedial', '!=', '');

        return $model;
    }

    public function getAll(Request $request)
    {
        $model = $this->getBaseModel();

        if ($request->has('is_tutor') && $request->is_tutor != '') {
            $userAuth = auth()->user();
            $tutorId = TutorModel::where('user_id', $userAuth->id)->first()->id;
            $model = $model->where('kmp.tutor_id', $tutorId);
        }
        if ($request->has('is_wb') && $request->is_wb != '') {
            $userAuth = auth()->user();
            $wbId = PpdbModel::where('user_id', $userAuth->id)->first()->id;
            $model = $model->where('kelas_wb.wb_id', $wbId);
        }
        if ($request->has('kelas_id') && $request->kelas_id != '') {
            $model = $model->where('kelas_wb.kelas_id', $request->kelas_id);
        }
        if ($request->has('kmp_id') && $request->kmp_id != '') {
            $model = $model->where('kmp.id', $request->kmp_id);
        }

        $datatables = DataTables::of($model)
            ->addIndexColumn()
            ->filterColumn('nama_siswa', function($query, $keyword) {
                $query->whereRaw("ppdb.nama like ?", ["%{$keyword}%"]);
            })
            ->filterColumn('nama_kelas', function($query, $keyword) {
                $query->whereRaw("kelas.nama like ?", ["%{$keyword}%"]);
            })
            ->filterColumn('nama_mapel', function($query, $keyword) {
                $query->whereRaw("mp.nama like ?", ["%{$keyword}%"]);
            })
            ->make(true);

        return $datatables;
    }

    public function getDataSiswa(Request $request)
    {
        $model = $this->getBaseModelSiswa();
        $userAuth = auth()->user();
        $wb_id = PpdbModel::where('user_id', $userAuth->id)->first()->id;

        $model->where('wb_id', $wb_id);

        if (!empty($request->kelas_id)) {
            $model->where('kelas_id', $request->kelas_id);
        }
        if (!empty($request->kmp_id)) {
            $model->where('kmp_id', $request->kmp_id);
        }

        $model = $model->get();

        $model->map(function ($item) {
            $item->susulan_remedial = json_decode($item->susulan_remedial);
        });

        $susulan_remedial = [];
        foreach ($model as $key => $value) {
            $susulan_remedial_temp = [];
            $susulan_remedial_temp['wb_id'] = $value->wb_id ?? null;
            $susulan_remedial_temp['kelas_id'] = $value->kelas_id ?? null;
            $susulan_remedial_temp['kmp_id'] = $value->kmp_id ?? null;
            $susulan_remedial_temp['nama_siswa'] = $value->wb->nama ?? '';
            $susulan_remedial_temp['nama_kelas'] = $value->kelas->nama ?? '';
            $susulan_remedial_temp['nama_mapel'] = $value->kmp->mata_pelajaran_detail->nama ?? '';
            $susulan_remedial_temp['susulan_remedial'] = json_encode($value->susulan_remedial);

            foreach ($value->susulan_remedial as $key2 => $value2) { // key = susulan | remedial
                $susulan_remedial_temp[$key2] = [];

                foreach ($value2 as $key3 => $value3) { // key = p_ | k_
                    if (empty($value3)) continue;

                    $susulan_remedial_temp[$key2][$key3] = $value3;
                }
            }

            $susulan_remedial[] = $susulan_remedial_temp;
        }

        foreach ($susulan_remedial as $key => $value) {
            if (empty($value['susulan']) && empty($value['remedial'])) {
                unset($susulan_remedial[$key]);
            }
        }

        $datatables = DataTables::of($susulan_remedial)
            ->addIndexColumn()
            ->make(true);

        return $datatables;
    }
}
