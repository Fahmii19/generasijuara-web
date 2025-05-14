<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use SnappyPDF;
use App\Models\KelasWbModel;
use App\Models\KelasMataPelajaranModel;
use App\Models\PpdbModel;
use App\Models\EkstrakurikulerModel;
use App\Models\KelasModel;
use App\Models\KuisionerItemsModel;
use App\Models\KuisionerModel;
use App\Models\KuisionerResponModel;
use App\Models\KuisionerWbModel;
use App\Models\NilaiKegiatanModel;
use App\Models\PembayaranItemsModel;
use App\Models\PembayaranModel;
use App\Models\PpdbUlangModel;
use App\Models\TagihanItemsModel;
use App\Models\TagihanModel;
use App\Models\TahunAkademikModel;
use App\Services\RaportService;
use App\Utils\Constant;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class SiabController extends Controller
{
    public function home(Request $request)
    {
        $ppdb_data = PpdbModel::where('user_id', Auth::user()->id)->first();

        $kartu_pelajar_path = 'nis.png';
        $kartu_pelajar_url = asset('images') . '/nis.png';

        // Check if ppdb data is exist
        if (!empty($ppdb_data)) {
            $kartu_pelajar_path = $ppdb_data->url_kartu_pelajar;

            // Check if file is exist
            if (file_exists(public_path('uploads') . $kartu_pelajar_path)) {
                $kartu_pelajar_url = asset('uploads') . $kartu_pelajar_path;
            }
        }

        $data = [
            'kartu_pelajar' => $kartu_pelajar_url,
        ];

        return view('siswa.index', $data);
    }

    public function profile(Request $request)
    {
        $data_ppdb = PpdbModel::where('user_id', Auth::user()->id)->first();
        $data = [
            'id' => auth()->user()->id,
            'data_ppdb' => $data_ppdb,
        ];

        return view('siswa.profile', $data);
    }

    public function nilaiList(Request $request)
    {
        return view('siswa.nilai.list');
    }

    public function jadwalPelajaranList(Request $request)
    {
        return view('siswa.jadwal_pelajaran.list');
    }

    public function riwayatKelasList(Request $request)
    {
        $nik_siswa = PpdbModel::where('user_id', Auth::user()->id)->first()->nik_siswa;
        $data_ppdb = PpdbModel::where('nik_siswa', $nik_siswa)
            ->whereNotNull('nik_siswa')
            ->get();

        $ppdb_ids = [];
        foreach ($data_ppdb as $item) {
            $ppdb_ids[] = $item->id;
        }

        // when current user nik is null
        if (count($ppdb_ids) == 0) {
            $data_ppdb = PpdbModel::where('nis', PpdbModel::where('user_id', Auth::user()->id)->first()->nis)->get();
            foreach ($data_ppdb as $item) {
                $ppdb_ids[] = $item->id;
            }
        }
        // dd($ppdb_ids);
        $data = [
            'id' => auth()->user()->id,
            'ppdb_ids' => $ppdb_ids
        ];

        return view('siswa.riwayat_kelas.list', $data);
    }

    public function laporanPerkembanganList(Request $request)
    {
        $data_ppdb = PpdbModel::where('user_id', Auth::user()->id)->first();
        $data = [
            'data_ppdb' => $data_ppdb,
        ];

        return view('siswa.laporan_perkembangan.list', $data);
    }

    public function raportPrint(Request $request, $kelas_id)
    {
        $user = $request->user();
        $ppdb = PpdbModel::where('user_id', $user->id)->first();
        $tahun_akademik_id = KelasModel::where('id', $kelas_id)->first()->tahun_akademik_id;

        // Cek apakah sudah mengisi kuisioner
        $kuisioner_check = KuisionerWbModel::where('ppdb_id', $ppdb->id)
            ->whereHas('kuisioner', function ($q) use ($tahun_akademik_id) {
                $q->where('tahun_akademik_id', $tahun_akademik_id);
            })->first();

        if (empty($kuisioner_check)) {
            $kuisioner = KuisionerModel::where('tahun_akademik_id', $tahun_akademik_id)
                ->where('is_published', true)
                ->first();

            if (!empty($kuisioner)) {
                return redirect()->route('web.siab.kuisioner.respon', 'tahun_akademik=' . $tahun_akademik_id . '&kelas_id=' . $kelas_id . '&destination=raport');
            }
        }

        $raportService = new RaportService();
        $data = $raportService->getData([
            'ppdb_id'   => $ppdb->id,
            'kelas_id'   => $kelas_id
        ]);
        // dd($data);
        if (!$data) {
            dd('data tidak ditemukan');
        }

        $headerHtml = null;
        $footerHtml = null;

        $view = 'admin.pdf.raport';
        if ($data['kelas_wb']->kelas_detail->jenis_rapor == 'merdeka') {
            $view = 'admin.pdf.raport-merdeka';
        }
        // dd($data);
        $pdf = PDF::loadView($view, $data);

        $pdf->setOptions([
            'header-html' => $headerHtml,
            'footer-html' => $footerHtml,
            'margin-bottom' => '10',
            'margin-top' => '10',
            'isRemoteEnabled' => true,
            'tempDir' => public_path(),
            'chroot'  => public_path(''),
        ]);

        return $pdf->stream('Raport.pdf');
    }

    public function raportCoverPrint(Request $request)
    {
        $kelas_id = $request->kelas_id;
        $ppdb_id =  $request->ppdb_id;
        $kelas_wb_id =  $request->kelas_wb_id;

        $ppdb = PpdbModel::where('user_id', Auth::user()->id)->first();

        if ($ppdb_id != $ppdb->id) {
            return redirect()->route('web.siab.riwayat-kelas.list');
        }

        $tahun_akademik_id = KelasModel::where('id', $kelas_id)->first()->tahun_akademik_id;
        $kuisioner_check = KuisionerWbModel::where('ppdb_id', $ppdb->id)
            ->whereHas('kuisioner', function ($q) use ($tahun_akademik_id) {
                $q->where('tahun_akademik_id', $tahun_akademik_id);
            })->first();

        if (empty($kuisioner_check)) {
            $kuisioner = KuisionerModel::where('tahun_akademik_id', $tahun_akademik_id)
                ->where('is_published', true)
                ->first();

            if (!empty($kuisioner)) {
                return redirect()->route('web.siab.kuisioner.respon', 'tahun_akademik=' . $tahun_akademik_id . '&kelas_id=' . $kelas_id . '&destination=cover_raport');
            }
        }

        $raportService = new RaportService();
        $data = $raportService->getData(['kelas_wb_id' => $kelas_wb_id]);

        if (!$data) {
            dd('data tidak ditemukan');
        }

        $headerHtml = null;
        $footerHtml = null;

        $pdf = PDF::loadView('admin.pdf.raport-cover', $data)
            ->setOptions([
                'header-html' => $headerHtml,
                'footer-html' => $footerHtml,
                'margin-bottom' => '10',
                'margin-top' => '10',
                'tempDir' => public_path(),
                'chroot'  => public_path(''),
            ]);

        return $pdf->stream('Raport-Cover.pdf');
    }

    public function kuisionerRespon(Request $request)
    {
        // dd('masuk');
        $already_filled = false;
        $kuisioner_items = [];
        $destination = '';
        $ppdb = PpdbModel::where('user_id', Auth::user()->id)->first();
        $kuisioner = KuisionerModel::where('tahun_akademik_id', $request->tahun_akademik)
            ->where('is_published', true)
            ->first();

        if ($request->destination == 'cover_raport') {
            $destination = route('web.siab.raport-cover.print', ['kelas_id' => $request->kelas_id, 'ppdb_id' => $ppdb->id]);
        } elseif ($request->destination == 'raport') {
            $destination = route('web.siab.raport.print', request()->kelas_id);
        } else {
            return redirect()->route('web.siab.riwayat-kelas.list')->withErrors(['Destinasi tidak valid']);
        }

        // Cek apakah kuisioner ada
        if (empty($kuisioner)) {
            // return redirect()->back()->withErrors(['Kuisioner belum tersedia']);
            return redirect($destination);
        }

        // Cek apakah item kuisioner ada
        $kuisioner_items = KuisionerItemsModel::where('kuisioner_id', $kuisioner->id)->get();
        if (count($kuisioner_items) == 0) {
            return redirect()->back()->withErrors(['Item kuisioner belum tersedia']);
        }

        // Cek apakah pernah mengisi kuisioner
        $already_filled_check = KuisionerWbModel::where('ppdb_id', $ppdb->id)
            ->where('kuisioner_id', $kuisioner->id)
            ->first();

        if (!empty($already_filled_check)) {
            return redirect()->route('web.siab.riwayat-kelas.list')->withErrors(['Anda sudah pernah mengisi kuisioner']);
        }

        $data = [
            'already_filled' => $already_filled,
            'ppdb' => $ppdb,
            'kuisioner' => $kuisioner,
            'kuisioner_items' => $kuisioner_items,
            'destination' => $destination,
        ];

        return view('siswa.kuisioner.kuisioner_respon', $data);
    }

    public function daftarUlang(Request $request)
    {
        $tahun_akademik = TahunAkademikModel::where('is_active', 1)->first();
        $is_paid = PpdbUlangModel::where('user_id', auth()->user()->id)
            ->where('tahun_akademik_id', $tahun_akademik->id)
            ->count();
        $ppdb = PpdbModel::where('user_id', auth()->user()->id)->first();
        $data = [
            'type' => Constant::TYPE_KELAS_ABC,
            'user_id' => auth()->user()->id,
            'tahun_akademik' => $tahun_akademik,
            'is_paid' => $is_paid,
            'data_ppdb' => $ppdb,
        ];
        return view('siswa.ppdb.daftar_ulang', $data);
    }

    public function pembayaranList(Request $request)
    {
        $data_ppdb = PpdbModel::where('user_id', auth()->user()->id)->first();
        $data = [
            'ppdb_id' => $data_ppdb->id,
        ];
        return view('siswa.pembayaran.list', $data);
    }

    public function pembayaranDetail($id)
    {
        $data_tagihan = TagihanModel::with('pembayaran')->where('id', $id)->first();
        $tagihan_item = TagihanItemsModel::where('tagihan_id', $id)->get();

        // $terbayar = DB::select("
        // SELECT
        // (
        //     CASE
        //     WHEN pemi.item LIKE '%Daftar%' THEN 'Biaya Daftar'
        //     WHEN pemi.item LIKE '%Program%' THEN 'Biaya Program'
        //     WHEN pemi.item LIKE '%SPP%' THEN 'Biaya SPP'
        //     WHEN pemi.item LIKE '%Wakaf%' THEN 'Wakaf'
        //     WHEN pemi.item LIKE '%Infaq%' THEN 'Infaq'
        //     END
        // ) AS slug, SUM(pemi.nominal) total_terbayar
        // FROM pembayaran pemb
        // JOIN pembayaran_items pemi ON pemi.pembayaran_id = pemb.id
        // WHERE pemb.tagihan_id = ".$id."
        // GROUP BY (
        //     CASE
        //     WHEN pemi.item LIKE '%Daftar%' THEN 'Biaya Daftar'
        //     WHEN pemi.item LIKE '%Program%' THEN 'Biaya Program'
        //     WHEN pemi.item LIKE '%SPP%' THEN 'Biaya SPP'
        //     WHEN pemi.item LIKE '%Wakaf%' THEN 'Wakaf'
        //     WHEN pemi.item LIKE '%Infaq%' THEN 'Infaq'
        //     END
        // )
        // ");

        $terbayar = [];
        $terbayar_query = PembayaranItemsModel::selectRaw("pembayaran.tagihan_id, pembayaran_items.item, SUM(pembayaran_items.nominal) as terbayar")
            ->leftJoin('pembayaran', 'pembayaran.id', '=', 'pembayaran_items.pembayaran_id')
            ->where('pembayaran.tagihan_id', $id)
            ->where('pembayaran.is_approved', 1)
            ->groupBy('pembayaran.tagihan_id', 'pembayaran_items.item')
            ->get()
            ->toArray();

        array_map(function ($item) use (&$terbayar) {
            $terbayar[$item['item']] = $item;
        }, $terbayar_query);

        $ppdb_id = PpdbModel::where('user_id', Auth::user()->id)->first()->id;
        if ($ppdb_id == ($data_tagihan->ppdb_id ?? null)) {
            $data = [
                'id' => $id,
                'pembayaran_id' => $data_tagihan->pembayaran->id ?? 0,
                'data_tagihan' => $data_tagihan,
                'tagihan_item' => $tagihan_item,
                'terbayar' => $terbayar,
            ];
            return view('siswa.pembayaran.detail', $data);
        } else {
            return redirect(route('web.siab.keuangan.list'));
        }
    }

    public function pembayaranDetailItem($id)
    {
        $data_pembayaran = PembayaranModel::where('id', $id)->first();
        $data = [
            'id' => $id,
            'data_pembayaran' => $data_pembayaran,
        ];
        return view('siswa.pembayaran.detail-item', $data);
    }

    public function susulanRemedialList()
    {
        return view('siswa.susulan_remedial.list');
    }
}
