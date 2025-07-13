<?php

namespace App\Http\Controllers\Datatables;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\KelasModel;
use DataTables;
use DB;
use Illuminate\Support\Facades\Log;

class KelasController extends Controller
{
    private function getBaseModel()
    {
        return KelasModel::query()
            ->select([
                'kelas.*',
                'ta.tahun_ajar as ta_tahun_ajar',
                'ta.keterangan as ta_keterangan',
                'lk.kode as lk_kode',
                'lk.nama as lk_nama',
                'pk.nama as pk_nama',
                DB::raw('COUNT(kwb.id) as jumlah_siswa')
            ])
            ->leftJoin('tahun_akademik as ta', 'ta.id', '=', 'kelas.tahun_akademik_id')
            ->leftJoin('layanan_kelas as lk', 'lk.id', '=', 'kelas.layanan_kelas_id')
            ->leftJoin('paket_kelas as pk', 'pk.id', '=', 'kelas.paket_kelas_id')
            ->leftJoin('kelas_wb as kwb', 'kwb.kelas_id', '=', 'kelas.id')
            ->groupBy('kelas.id'); // Group by primary key tabel utama
    }

    public function getAll(Request $request)
    {
        try {
            $model = $this->getBaseModel();

            // Debug sebelum filter
            // Log::debug('Initial Query', [
            //     'sql' => $model->toSql(),
            //     'bindings' => $model->getBindings()
            // ]);

            // Terapkan filter
            if ($request->filled('type')) {
                $model->where('kelas.type', $request->type);
            }
            if ($request->filled('layanan_kelas_id')) {
                $model->where('kelas.layanan_kelas_id', $request->layanan_kelas_id);
            }
            if ($request->filled('tahun_akademik_id')) {
                $model->where('kelas.tahun_akademik_id', $request->tahun_akademik_id);
            }
            if ($request->filled('semester')) {
                $model->where('kelas.semester', $request->semester);
            }

            // Debug setelah filter
            // Log::debug('Final Query with Filters', [
            //     'sql' => $model->toSql(),
            //     'bindings' => $model->getBindings(),
            //     'filters' => $request->all()
            // ]);

            // Cek data mentah sebelum DataTables
            $sampleData = $model->limit(5)->get();
            // Log::debug('Sample Data', $sampleData->toArray());

            // Cek count data
            // Log::debug('Data Counts', [
            //     'total_kelas' => KelasModel::count(),
            //     'total_kelas_wb' => DB::table('kelas_wb')->count(),
            //     'filtered_count' => $model->count()
            // ]);

            return DataTables::of($model)
                ->make(true);
        } catch (\Exception $e) {
            Log::error('Error in KelasController@getAll', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'error' => true,
                'message' => 'Terjadi kesalahan server'
            ], 500);
        }
    }
}
