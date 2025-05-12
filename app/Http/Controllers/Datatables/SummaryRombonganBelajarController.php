<?php

namespace App\Http\Controllers\Datatables;

use App\Http\Controllers\Controller;
use App\Models\KelasModel;
use App\Models\PpdbModel;
use App\Models\RombelModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Log;

class SummaryRombonganBelajarController extends Controller
{
    private $select = '
        kelas.nama,
        COUNT(rombel.kelas_id) AS total
    ';

    public function getBaseModel()
    {
        return RombelModel::select(DB::raw($this->select))
            ->leftJoin('kelas', 'kelas.id', '=', 'rombel.kelas_id')
            ->leftJoin('ppdb', 'ppdb.id', '=', 'rombel.ppdb_id')
            ->leftJoin('layanan_kelas', 'layanan_kelas.id', '=', 'ppdb.layanan_kelas_id')
            ->whereNotNull('rombel.kelas_id')
            ->groupBy('rombel.kelas_id', 'kelas.nama');
    }

    public function getAll(Request $request)
    {
        Log::info('Request data:', $request->all());
        $model = $this->getBaseModel();
        if ($request->has('cabang_id') && $request->cabang_id != null) {
            $model = $model->where('ppdb.cabang_id', $request->cabang_id);
        }
        if ($request->has('tahun_akademik_id') && $request->tahun_akademik_id != null) {
            $model = $model->where('rombel.tahun_akademik_id', $request->tahun_akademik_id);
        }
        if ($request->has('ppdb_type') && $request->ppdb_type != null) {
            $model = $model->where('ppdb.type', $request->ppdb_type);
        }
        if ($request->has('layanan_kelas') && $request->layanan_kelas != null) {
            $model = $model->where('layanan_kelas.kode', $request->layanan_kelas);
        }

        Log::info('SQL Query:', [$model->toSql(), $model->getBindings()]);
        return DataTables::of($model)
            ->addIndexColumn()
            ->make(true);
    }

    public function getStatusCount(Request $request)
    {
        $select = "
            COUNT(CASE WHEN rombel.is_active = 1 THEN 1 ELSE NULL END) AS aktif,
            COUNT(CASE WHEN rombel.is_active = 0 AND rombel.keterangan IS NULL THEN 1 ELSE NULL END) AS tidak_aktif,
            COUNT(CASE WHEN rombel.keterangan = 'cuti' THEN 1 ELSE NULL END) AS cuti,
            COUNT(CASE WHEN rombel.keterangan = 'mutasi' THEN 1 ELSE NULL END) AS mutasi,
            COUNT(CASE WHEN rombel.keterangan = 'mengundurkan_diri' THEN 1 ELSE NULL END) AS mengundurkan_diri
        ";

        $model = RombelModel::select(DB::raw($select));

        if ($request->has('tahun_akademik_id') && $request->tahun_akademik_id != null) {
            $model = $model->where('rombel.tahun_akademik_id', $request->tahun_akademik_id);
        }
        if ($request->has('ppdb_type') && $request->ppdb_type != null) {
            $model->whereHas('ppdb', function ($query) use ($request) {
                $query->where('ppdb.type', $request->ppdb_type);
            });
        }

        return DataTables::of($model)
            ->setTotalRecords(1)
            ->make(true);
    }

    public function getStatusWB(Request $request)
    {
        $select = "
            kls.type,
            lk.kode,
            COUNT(CASE WHEN rombel.status_wb = 'Baru' THEN 1 ELSE NULL END) AS baru,
            COUNT(CASE WHEN rombel.status_wb = 'Lama' THEN 1 ELSE NULL END) AS lama,
            COUNT(CASE WHEN rombel.status_wb = 'Alumni' THEN 1 ELSE NULL END) AS alumni
        ";

        $model = RombelModel::select(DB::raw($select))
            ->leftJoin('kelas as kls', 'kls.id', '=', 'rombel.kelas_id')
            ->leftJoin('layanan_kelas as lk', 'lk.id', '=', 'kls.layanan_kelas_id')
            ->groupBy('kls.type', 'lk.kode');

        if ($request->has('tahun_akademik_id') && $request->tahun_akademik_id != null) {
            $model = $model->where('rombel.tahun_akademik_id', $request->tahun_akademik_id);
        }
        if ($request->has('ppdb_type') && $request->ppdb_type != null) {
            $model->where('kls.type', $request->ppdb_type);
        }

        return DataTables::of($model)
            ->addIndexColumn()
            ->make(true);
    }
}
