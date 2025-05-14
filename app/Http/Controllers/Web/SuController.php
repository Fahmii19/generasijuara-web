<?php

namespace App\Http\Controllers\Web;

use App\Exports\NilaiExport;
use App\Exports\RombelExport;
use App\Exports\SusulanRemedialExport;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use SnappyPDF;
use App\Models\KelasWbModel;
use App\Models\KelasMataPelajaranModel;
use App\Models\PpdbModel;
use App\Models\EkstrakurikulerModel;
use App\Models\KelasModel;
use App\Models\AlumniModel;
use App\Models\PointModel;
use App\Models\DimensiModel;
use App\Models\CatatanProsesWBModel;
use App\Models\NilaiPointModel;
use App\Models\KuisionerItemsModel;
use App\Models\KuisionerModel;
use App\Models\KuisionerResponModel;
use App\Models\KuisionerWbModel;
use App\Models\LayananKelasModel;
use App\Models\NilaiKegiatanModel;
use App\Models\PembayaranItemsModel;
use App\Models\PembayaranModel;
use App\Models\TagihanModel;
use App\Models\TahunAkademikModel;
use App\Services\RaportService;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Constant;
use DB;
use Maatwebsite\Excel\Facades\Excel;

class SuController extends Controller
{
    public function home(Request $request)
    {
        if (session()->get('apps') != 'su') return redirect()->route('web.index');
        return view('admin.index');
    }

    public function tutorList(Request $request)
    {
        return view('admin.tutor.list');
    }

    public function cabangList(Request $request)
    {
        return view('admin.cabang.list');
    }

    public function userList(Request $request)
    {
        return view('admin.user.list');
    }

    public function rombelAkademikList(Request $request)
    {
        return view('admin.rombel_akademik.list');
    }

    public function kelasList(Request $request)
    {
        return view('admin.kelas.list');
    }

    public function detailKelas(Request $request)
    {
        $data = [
            'kelas_id' => $request->id
        ];
        return view('admin.kelas.detail', $data);
    }

    public function settingKMP(Request $request)
    {
        $data = [
            'kmp_id' => $request->id
        ];
        return view('admin.kelas.kmp_setting', $data);
    }

    public function layananKelasList(Request $request)
    {
        return view('admin.layanan_kelas.list');
    }

    public function paketKelasAbcList(Request $request)
    {
        $data = [
            'type' => Constant::TYPE_KELAS_ABC,
        ];
        return view('admin.paket_kelas.abc.list', $data);
    }

    public function paketKelasPaudList(Request $request)
    {
        $data = [
            'type' => Constant::TYPE_KELAS_PAUD,
        ];
        return view('admin.paket_kelas.paud.list', $data);
    }

    public function paketSppAbcList(Request $request)
    {
        $data = [
            'type' => Constant::TYPE_KELAS_ABC,
        ];
        return view('admin.paket_spp.abc.list', $data);
    }

    public function paketSppPaudList(Request $request)
    {
        $data = [
            'type' => Constant::TYPE_KELAS_PAUD,
        ];
        return view('admin.paket_spp.paud.list', $data);
    }

    public function kotaList(Request $request)
    {
        return view('admin.kota.list');
    }

    public function distribusiMapel(Request $request)
    {
        return view('admin.distribusi_mapel.list');
    }

    public function jadwalPelajaranList(Request $request)
    {
        return view('admin.jadwal_pelajaran.list');
    }

    public function kalenderAkademikList(Request $request)
    {
        return view('admin.kalender_akademik.list');
    }

    public function mataPelajaranList(Request $request)
    {
        return view('admin.mata_pelajaran.list');
    }

    public function uploadRaportList(Request $request)
    {
        return view('admin.upload_raport.list');
    }

    public function raportList(Request $request)
    {
        return view('admin.raport.list');
    }

    public function legerList(Request $request)
    {
        return view('admin.leger.list');
    }

    public function kuisionerList(Request $request)
    {
        $tahun_akademik = TahunAkademikModel::where('is_active', '1')->first()->id;
        $data = [
            'tahun_akademik' => $tahun_akademik,
        ];

        return view('admin.kuisioner.list', $data);
    }

    public function kuisionerItemsList($kuisioner_id)
    {
        $data = [
            'kuisioner_id' => $kuisioner_id,
        ];
        return view('admin.kuisioner.detail-items', $data);
    }

    public function kuisionerHasilList(Request $request)
    {
        return view('admin.kuisioner_hasil.list');
    }

    public function kuisionerHasilDetail(Request $request, $ta_id, $ppdb_id)
    {
        $ppdb = Ppdbmodel::selectRaw('nis, nama')->where('id', $ppdb_id)->first();
        $kuisioner = KuisionerModel::with('tahun_akademik')
            ->where('tahun_akademik_id', $ta_id)
            ->first();

        $kuisioner_items = KuisionerItemsModel::where('kuisioner_id', $kuisioner->id)->get();

        $kuisioner_wb_id = KuisionerWbModel::where('ppdb_id', $ppdb_id)
            ->where('kuisioner_id', $kuisioner->id)
            ->first();

        $kuisioner_respon = KuisionerResponModel::where('kuisioner_wb_id', $kuisioner_wb_id->id)->get();

        $data = [
            'ppdb' => $ppdb,
            'kuisioner' => $kuisioner,
            'kuisioner_items' => $kuisioner_items,
            'kuisioner_respon' => $kuisioner_respon,
        ];
        return view('admin.kuisioner_hasil.detail', $data);
    }

    public function susulanRemedialList(Request $request)
    {
        return view('admin.susulan_remedial.list');
    }

    public function susulanRemedialExport(Request $request)
    {
        $kelas_id = $request->kelas_id ?? null;
        $kmp_id = $request->kmp_id ?? null;
        $tutor_id = $request->tutor_id ?? null;
        $tahun_akademik_id = $request->tahun_akademik_id ?? null;

        $data = [
            'kelas_id' => $kelas_id,
            'kmp_id' => $kmp_id,
            'tutor_id' => $tutor_id,
            'tahun_akademik_id' => $tahun_akademik_id,
        ];

        return Excel::download(
            new SusulanRemedialExport($data),
            'Susulan Remedial_' . time() . '.xlsx'
        );
    }

    public function tahunAkademikList(Request $request)
    {
        return view('admin.tahun_akademik.list');
    }

    public function ttdRaportList(Request $request)
    {
        return view('admin.ttd_raport.list');
    }

    public function ppdbAbcList(Request $request)
    {
        $data = [
            'type' => Constant::TYPE_KELAS_ABC,
        ];
        return view('admin.ppdb.abc.list', $data);
    }

    public function ppdbAbcAdd(Request $request)
    {
        $data = [
            'type' => Constant::TYPE_KELAS_ABC,
        ];
        return view('admin.ppdb.abc.add-new', $data);
    }

    public function ppdbAbcEdit(Request $request, $id)
    {
        $tagihan = TagihanModel::where('ppdb_id', $id)->first();
        $data_ppdb = PpdbModel::where('id', $id)->first();
        $data = [
            'type' => Constant::TYPE_KELAS_ABC,
            'id' => $id,
            'data_tagihan' => $tagihan,
            'data_ppdb' => $data_ppdb,
        ];
        return view('admin.ppdb.abc.add', $data);
    }

    public function ppdbAbcNewList(Request $request)
    {
        return view('admin.ppdb.abc_new.list');
    }

    public function ppdbPaudList(Request $request)
    {
        $data = [
            'type' => Constant::TYPE_KELAS_PAUD,
        ];
        return view('admin.ppdb.paud.list', $data);
    }

    public function ppdbPaudAdd(Request $request)
    {
        $data = [
            'type' => Constant::TYPE_KELAS_PAUD,
        ];
        return view('admin.ppdb.paud.add-new', $data);
    }

    public function ppdbPaudEdit(Request $request, $id)
    {
        $tagihan = TagihanModel::where('ppdb_id', $id)->first();
        $data_ppdb = PpdbModel::where('id', $id)->first();
        $data = [
            'type' => Constant::TYPE_KELAS_PAUD,
            'id' => $id,
            'data_tagihan' => $tagihan,
            'data_ppdb' => $data_ppdb,
        ];
        return view('admin.ppdb.paud.add', $data);
    }

    public function ppdbUlangAbcList(Request $request)
    {
        $data = [
            'type' => Constant::TYPE_KELAS_ABC
        ];
        return view('admin.ppdb_ulang.abc.list', $data);
    }

    public function ppdbUlangAbcAdd(Request $request)
    {
        $data = [
            'type' => Constant::TYPE_KELAS_ABC,
        ];
        return view('admin.ppdb_ulang.abc.add', $data);
    }

    public function ppdbUlangAbcEdit(Request $request, $id)
    {
        $tagihan = TagihanModel::where('ppdb_id', $id)
            ->where('type', TagihanModel::TYPE_DAFTAR_ULANG)
            ->first();
        $data = [
            'type' => Constant::TYPE_KELAS_ABC,
            'id' => $id,
            'data_tagihan' => $tagihan,
        ];
        return view('admin.ppdb_ulang.abc.add', $data);
    }

    public function ppdbUlangPaudList(Request $request)
    {
        $data = [
            'type' => Constant::TYPE_KELAS_PAUD
        ];
        return view('admin.ppdb_ulang.paud.list', $data);
    }

    public function ppdbUlangPaudAdd(Request $request)
    {
        $data = [
            'type' => Constant::TYPE_KELAS_PAUD,
        ];
        return view('admin.ppdb_ulang.paud.add', $data);
    }

    public function ppdbUlangPaudEdit(Request $request, $id)
    {
        $tagihan = TagihanModel::where('ppdb_id', $id)
            ->where('type', TagihanModel::TYPE_DAFTAR_ULANG)
            ->first();
        $data = [
            'type' => Constant::TYPE_KELAS_PAUD,
            'id' => $id,
            'data_tagihan' => $tagihan,
        ];
        return view('admin.ppdb_ulang.paud.add', $data);
    }

    public function keuanganPembayaranList(Request $request)
    {
        return view('admin.keuangan.pembayaran.list');
    }

    public function keuanganPembayaranDetail(Request $request, $id)
    {
        $data_pembayaran = PembayaranModel::where('tagihan_id', $id)->first();
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

        $data = [
            'id' => $id,
            'data_pembayaran' => $data_pembayaran,
            'terbayar' => $terbayar,
        ];
        return view('admin.keuangan.pembayaran.detail', $data);
    }

    public function keuanganPembayaranDetailItem(Request $request, $id)
    {
        $data_pembayaran = PembayaranModel::where('id', $id)->first();
        $data = [
            'id' => $id,
            'data_pembayaran' => $data_pembayaran,
        ];
        return view('admin.keuangan.pembayaran.detail-item', $data);
    }

    // debugx
    public function raportPrint(Request $request)
    {
        $raportService = new RaportService();
        $data = $raportService->getData(['kelas_wb_id' => $request->kelas_wb]);

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
        $raportService = new RaportService();
        $data = $raportService->getData(['kelas_wb_id' => $request->kelas_wb]);

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

    public function raportDetail(Request $request)
    {
        // $raportService = new RaportService();
        // $data = $raportService->getData(['kelas_wb_id'=>$request->kelas_wb]);
        $data = [
            'kwb_id' => $request->kelas_wb,
        ];

        return view('admin.raport.detail', $data);
    }

    public function rombelList()
    {
        return view('admin.rombongan_belajar.list');
    }

    public function rombelSummary()
    {
        return view('admin.rombongan_belajar.summary');
    }

    public function rombelExportExcel(Request $request)
    {
        $layanan_kelas_id = !empty($request->get('layanan_kelas_id')) ? $request->get('layanan_kelas_id') : null;
        $tahun_akademik_id = !empty($request->get('tahun_akademik_id')) ? $request->get('tahun_akademik_id') : null;

        $layanan_kelas = LayananKelasModel::find($layanan_kelas_id);
        $tahun_akademik = TahunAkademikModel::find($tahun_akademik_id);

        return Excel::download(
            new RombelExport($layanan_kelas_id, $tahun_akademik_id),
            'Rombel_' . $layanan_kelas->kode . '_' . $tahun_akademik->kode . '.xlsx'
        );
    }

    public function nilaiList(Request $request)
    {
        return view('admin.nilai.list');
    }

    public function capaianDimensiList(Request $request)
    {
        return view('admin.capaian_dimensi.list');
    }

    public function perkembanganList(Request $request)
    {
        return view('admin.perkembangan.list');
    }

    public function nilaiExportExcel(Request $request)
    {
        // $file_name = "Semua";
        // $date = Carbon::now();

        $kelasId = !empty($request->kelas_id) ? $request->kelas_id : null;
        $kelas = KelasModel::find($kelasId);
        if (empty($kelas)) {
            return back()->with('message', 'Kelas tidak ditemukan');
        }

        return Excel::download(new NilaiExport($kelas), 'Nilai - ' . $kelas->nama . '.xlsx');
    }

    public function siswaNilaiList(Request $request)
    {
        return view('siswa.nilai.list');
    }

    public function siswaRaportList(Request $request)
    {
        return view('siswa.raport.list');
    }

    public function tutorNilaiList(Request $request)
    {
        return view('tutor.nilai.list');
    }

    public function keuanganDaftarAbcList(Request $request)
    {
        return view('admin.keuangan.daftar_abc.list');
    }

    public function keuanganDaftarAbcAdd(Request $request)
    {
        return view('admin.keuangan.daftar_abc.add');
    }

    public function keuanganSlipGajiList(Request $request)
    {
        return view('admin.keuangan.slip_gaji.list');
    }

    public function keuanganSlipGajiAdd(Request $request)
    {
        return view('admin.keuangan.slip_gaji.add');
    }

    public function alumniList(Request $request)
    {
        return view('admin.alumni.list');
    }

    public function alumniAdd(Request $request)
    {
        return view('admin.alumni.add');
    }

    public function alumniEdit(Request $request, $id)
    {
        $alumni = AlumniModel::find($id);

        return view('admin.alumni.add', ['alumni' => $alumni, 'id' => $id]);
    }

    public function newsList(Request $request)
    {
        return view('admin.berita.list');
    }

    public function newsAdd(Request $request)
    {
        $data = [];
        return view('admin.berita.add', $data);
    }

    public function newsEdit(Request $request, $id)
    {
        $data = [
            'id' => $id,
        ];
        return view('admin.berita.add', $data);
    }

    public function voucherList(Request $request)
    {
        return view('admin.voucher.list');
    }

    public function settings(Request $request)
    {
        return view('admin.settings.list');
    }
}
