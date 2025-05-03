<?php

namespace App\Http\Controllers\Ajax;

use App\Http\Controllers\Controller;
use App\Models\PembayaranModel;
use App\Models\TagihanModel;
use App\Models\TahunAkademikModel;
use Illuminate\Http\Request;
use DataTables;
use DB;

class DashboardController extends Controller
{
    public function getPembayaranData(Request $request)
    {
        try {
            $idTahunAkademik =  $request->get('id') ?? -1;
            $data = null;

            if ($idTahunAkademik != -1) {
                $tahunAkademik = TahunAkademikModel::find($idTahunAkademik);
                if ($tahunAkademik) {
                    $periode_start = $tahunAkademik->periode_start;
                    $periode_end = $tahunAkademik->periode_end; 
                }
            }

            $query = TagihanModel::selectRaw('status, COUNT(status) as total')
                        ->groupBy('status')
                        ->orderBy('status', 'ASC');

            if (isset($periode_start) && isset($periode_end)) {
                $query->whereBetween('created_at', [$periode_start, $periode_end]);
            }

            $data = $query->get();

            return response()->json(['error' => false, 'message' => null, 'data' => $data], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => true, 'message' => $e->getMessage()], 400);
        } catch (\Throwable $e) {
            return response()->json(['error' => true, 'message' => $e->getMessage()], 400);
        }

    }

    public function getWakafInfaqSummaryDT(Request $request)
    {
        try {
            $idTahunAkademik =  $request->get('id') ?? -1;
            $data = null;

            if ($idTahunAkademik != -1) {
                $tahunAkademik = TahunAkademikModel::find($idTahunAkademik);
                if ($tahunAkademik) {
                    $periode_start = $tahunAkademik->periode_start;
                    $periode_end = $tahunAkademik->periode_end; 
                }
            }

            $model = DB::query()->selectRaw('inv.*, IFNULL(paid.terbayar,0) lunas, inv.tagihan-IFNULL(paid.terbayar,0) belum_lunas')->fromRaw("(select p.type, lk.kode, sum(ti.nominal) as tagihan, p.created_at from tagihan_items ti 
            left join tagihan t on t.id = ti.tagihan_id
            left join ppdb p on p.id = t.ppdb_id 
            left join layanan_kelas lk on lk.id = p.layanan_kelas_id
            where ti.item in ('Biaya Wakaf', 'Biaya Infaq & Sedekah')
            group by p.type, lk.kode) as inv")
            ->leftJoin( DB::raw( "(select ppdb.type, lk.kode, sum(pi.nominal) as terbayar from pembayaran_items pi
            left join pembayaran p on p.id = pi.pembayaran_id
            left join tagihan t on t.id = p.tagihan_id
            left join ppdb on ppdb.id = t.ppdb_id 
            left join layanan_kelas lk on lk.id = ppdb.layanan_kelas_id
            where p.is_approved = true and pi.item in ('Biaya Infaq & Sedekah', 'Biaya Wakaf')
            group by ppdb.type, lk.kode) as paid" ), function( $join )
            {
                $join->on( 'paid.kode', '=', 'inv.kode' );
                $join->on( 'paid.type', '=', 'inv.type' );
            });

            if (isset($periode_start) && isset($periode_end)) {
                $model->whereBetween('inv.created_at', [$periode_start, $periode_end]);
            }

            return DataTables::of($model)
                ->make(true);
        } catch (\Exception $e) {
            return response()->json(['error' => true, 'message' => $e->getMessage()], 400);
        } catch (\Throwable $e) {
            return response()->json(['error' => true, 'message' => $e->getMessage()], 400);
        }
    }

    public function getSppSummaryDT(Request $request)
    {
        try {
            $idTahunAkademik =  $request->get('id') ?? -1;
            $data = null;

            if ($idTahunAkademik != -1) {
                $tahunAkademik = TahunAkademikModel::find($idTahunAkademik);
                if ($tahunAkademik) {
                    $periode_start = $tahunAkademik->periode_start;
                    $periode_end = $tahunAkademik->periode_end; 
                }
            }

            $model = DB::query()->selectRaw('inv.*, IFNULL(paid.terbayar,0) lunas, inv.tagihan-IFNULL(paid.terbayar,0) belum_lunas')->fromRaw("(select p.type, lk.kode, sum(ti.nominal) as tagihan, p.created_at from tagihan_items ti 
            left join tagihan t on t.id = ti.tagihan_id
            left join ppdb p on p.id = t.ppdb_id 
            left join layanan_kelas lk on lk.id = p.layanan_kelas_id
            where ti.item in ('Biaya Daftar', 'Biaya SPP', 'Biaya Program')
            group by p.type, lk.kode) as inv")
            ->leftJoin( DB::raw( "(select ppdb.type, lk.kode, sum(pi.nominal) as terbayar from pembayaran_items pi
            left join pembayaran p on p.id = pi.pembayaran_id
            left join tagihan t on t.id = p.tagihan_id
            left join ppdb on ppdb.id = t.ppdb_id 
            left join layanan_kelas lk on lk.id = ppdb.layanan_kelas_id
            where p.is_approved = true and pi.item in ('Biaya Program', 'Biaya Daftar', 'Biaya SPP')
            group by ppdb.type, lk.kode) as paid" ), function( $join )
            {
                $join->on( 'paid.kode', '=', 'inv.kode' );
                $join->on( 'paid.type', '=', 'inv.type' );
            });

            if (isset($periode_start) && isset($periode_end)) {
                $model->whereBetween('inv.created_at', [$periode_start, $periode_end]);
            }

            return DataTables::of($model)
                ->make(true);
        } catch (\Exception $e) {
            return response()->json(['error' => true, 'message' => $e->getMessage()], 400);
        } catch (\Throwable $e) {
            return response()->json(['error' => true, 'message' => $e->getMessage()], 400);
        }
    }
}
