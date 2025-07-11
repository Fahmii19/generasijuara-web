<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Web\DashboardController as WebDashboard;
use App\Http\Controllers\Web\SiabController as WebSiab;
use App\Http\Controllers\Web\SuController as WebSu;
use App\Http\Controllers\Web\SirekaController as WebSireka;
use App\Http\Controllers\Web\SiregoController as WebSirego;
use App\Http\Controllers\Web\SialumController as WebSialum;
use App\Http\Controllers\Web\WBController as WebWB;
use App\Http\Controllers\Web\SituController as WebSitu;
use App\Http\Controllers\Web\PpdbController as WebPpdb;
use App\Http\Controllers\Auth\Custom\ForgotPasswordController;

use App\Http\Controllers\Ajax\DashboardController as AjaxDashboard;

use App\Http\Controllers\Datatables\TutorController as DtTutor;
use App\Http\Controllers\Ajax\TutorController as AjaxTutor;

use App\Http\Controllers\Datatables\LayananKelasController as DtLayananKelas;
use App\Http\Controllers\Ajax\LayananKelasController as AjaxLayananKelas;

use App\Http\Controllers\Datatables\CabangController as DtCabang;
use App\Http\Controllers\Ajax\CabangController as AjaxCabang;

use App\Http\Controllers\Datatables\KelasController as DtKelas;
use App\Http\Controllers\Ajax\KelasController as AjaxKelas;

use App\Http\Controllers\Datatables\PaketKelasController as DtPaketKelas;
use App\Http\Controllers\Ajax\PaketKelasController as AjaxPaketKelas;

use App\Http\Controllers\Datatables\PaketSppController as DtPaketSpp;
use App\Http\Controllers\Ajax\PaketSppController as AjaxPaketSpp;

use App\Http\Controllers\Datatables\UserController as DtUser;
use App\Http\Controllers\Ajax\UserController as AjaxUser;

use App\Http\Controllers\Datatables\PpdbController as DtPpdb;
use App\Http\Controllers\Ajax\PpdbController as AjaxPpdb;

use App\Http\Controllers\Datatables\AlumniController as DtAlumni;
use App\Http\Controllers\Ajax\AlumniController as AjaxAlumni;

use App\Http\Controllers\Datatables\PpdbUlangController as DtPpdbUlang;
use App\Http\Controllers\Ajax\PpdbUlangController as AjaxPpdbUlang;

use App\Http\Controllers\Datatables\MataPelajaranController as DtMataPelajaran;
use App\Http\Controllers\Ajax\MataPelajaranController as AjaxMataPelajaran;

use App\Http\Controllers\Datatables\KelasMataPelajaranController as DtKelasMP;
use App\Http\Controllers\Ajax\KelasMataPelajaranController as AjaxKelasMP;

use App\Http\Controllers\Datatables\KelasWbController as DtKelasWB;
use App\Http\Controllers\Ajax\KelasWbController as AjaxKelasWB;

use App\Http\Controllers\Datatables\KmpSettingController as DtKMPSetting;
use App\Http\Controllers\Ajax\KmpSettingController as AjaxKMPSetting;

use App\Http\Controllers\Datatables\NilaiController as DtNilai;
use App\Http\Controllers\Ajax\NilaiController as AjaxNilai;

use App\Http\Controllers\Datatables\CapaianDimensiController as DtCapaianDimensi;
use App\Http\Controllers\Ajax\CapaianDimensiController as AjaxCapaianDimensi;

use App\Http\Controllers\Datatables\SusulanRemedialController as DtSusulanRemedial;
use App\Http\Controllers\Ajax\SusulanRemedialController as AjaxSusulanRemedial;

use App\Http\Controllers\Datatables\SettingsController as DtSettings;
use App\Http\Controllers\Ajax\SettingsController as AjaxSettings;

use App\Http\Controllers\Datatables\TahunAkademikController as DtTahunAkademik;
use App\Http\Controllers\Ajax\TahunAkademikController as AjaxTahunAkademik;

use App\Http\Controllers\Ajax\RaportSettingController as AjaxTTDRaport;

use App\Http\Controllers\Datatables\NewsController as DtNews;
use App\Http\Controllers\Ajax\NewsController as AjaxNews;

use App\Http\Controllers\Datatables\EkstrakulikulerController as DtEkskul;
use App\Http\Controllers\Ajax\EkstrakulikulerController as AjaxEkskul;

use App\Http\Controllers\Datatables\NilaiKegiatanController as DtNilaiKegiatan;
use App\Http\Controllers\Ajax\NilaiKegiatanController as AjaxNilaiKegiatan;

use App\Http\Controllers\Ajax\PembayaranController as AjaxPembayaran;

use App\Http\Controllers\Datatables\TagihanController as DtTagihan;
use App\Http\Controllers\Ajax\TagihanController as AjaxTagihan;

use App\Http\Controllers\Datatables\VoucherController as DtVoucher;
use App\Http\Controllers\Ajax\VoucherController as AjaxVoucher;

use App\Http\Controllers\Datatables\DistribusiMapelController as DtDistribusiMapel;
use App\Http\Controllers\Ajax\DistribusiMapelController as AjaxDistribusiMapel;

use App\Http\Controllers\Ajax\RombonganBelajarController as AjaxRombel;
use App\Http\Controllers\Datatables\RombonganBelajarController as DtRombonganBelajar;
use App\Http\Controllers\Datatables\SummaryRombonganBelajarController as DtSummaryRombonganBelajar;
use App\Http\Controllers\Datatables\PembayaranController as DtPembayaran;

use App\Http\Controllers\Ajax\LedgerController as AjaxLedger;

use App\Http\Controllers\Datatables\KuisionerController as DtKuisioner;
use App\Http\Controllers\Ajax\KuisionerController as AjaxKuisioner;

use App\Http\Controllers\Datatables\KuisionerItemsController as DtKuisionerItems;
use App\Http\Controllers\Ajax\KuisionerItemsController as AjaxKuisionerItems;

use App\Http\Controllers\Datatables\PerkembanganController as DtPerkembangan;
use App\Http\Controllers\Ajax\PerkembanganController as AjaxPerkembangan;

use App\Http\Controllers\Ajax\WBController as AjaxWb;

use Illuminate\Support\Facades\Request;

// Email
use Illuminate\Support\Facades\Mail;
use App\Mail\TestMail;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Auth::routes(['register' => false]);

Route::get('password/reset', [WebDashboard::class, 'forgotPassword'])->name('password.forgot');
Route::get('password/reset-siab', [WebDashboard::class, 'forgotPasswordSiab'])->name('password.forgot-siab');
Route::get('password/reset-siab/{token}', [WebDashboard::class, 'resetPasswordSiab'])->name('password.reset-siab');
Route::post('password/send-reset-siab', [ForgotPasswordController::class, 'sendSiabResetPassword'])->name('password.send-reset-siab');
Route::post('password/update-siab-password', [ForgotPasswordController::class, 'updateSiabPassword'])->name('password.update-siab-password');

// Route::get('/php-info', function(Request $request)
// {
//     $response = phpinfo();
//     return $response;
// });

Route::get('/', [WebDashboard::class, 'index'])->name('web.index');

Route::group(['prefix' => 'ppdb'], function () {
    Route::get('/', [WebPpdb::class, 'home'])->name('web.ppdb.home');
    Route::get('/abc', [WebPpdb::class, 'abc'])->name('web.ppdb.abc');
    Route::get('/paud', [WebPpdb::class, 'paud'])->name('web.ppdb.paud');
});

Route::group(['prefix' => 'su', 'middleware' => ['auth']], function () {
    Route::get('/', [WebSu::class, 'home'])->name('web.su.home');
    Route::get('/tutor/list', [WebSu::class, 'tutorList'])->name('web.su.tutor.list');
    Route::get('/kelas/list', [WebSu::class, 'kelasList'])->name('web.su.kelas.list');
    Route::get('/kelas/detail/{id?}', [WebSu::class, 'detailKelas'])->name('web.su.kelas.detail');
    Route::get('/kelas-mp/setting/{id?}', [WebSu::class, 'settingKMP'])->name('web.su.kelas_mp.setting');
    Route::get('/layanan-kelas/list', [WebSu::class, 'layananKelasList'])->name('web.su.layanan_kelas.list');
    Route::get('/paket-kelas/abc/list', [WebSu::class, 'paketKelasAbcList'])->name('web.su.paket_kelas.abc.list');
    Route::get('/paket-kelas/paud/list', [WebSu::class, 'paketKelasPaudList'])->name('web.su.paket_kelas.paud.list');

    Route::get('/rombel-akademik/list', [WebSu::class, 'rombelAkademikList'])->name('web.su.rombel_akademik.list');
    Route::get('/paket-spp/abc/list', [WebSu::class, 'paketSppAbcList'])->name('web.su.paket_spp.abc.list');
    Route::get('/paket-spp/paud/list', [WebSu::class, 'paketSppPaudList'])->name('web.su.paket_spp.paud.list');
    Route::get('/kota/list', [WebSu::class, 'kotaList'])->name('web.su.kota.list');
    Route::get('/distribusi-mapel/list', [WebSu::class, 'distribusiMapel'])->name('web.su.distribusi_mapel.list');
    Route::get('/jadwal-pelajaran/list', [WebSu::class, 'jadwalPelajaranList'])->name('web.su.jadwal_pelajaran.list');
    Route::get('/kalender-akademik/list', [WebSu::class, 'kalenderAkademikList'])->name('web.su.kalender_akademik.list');
    Route::get('/mata-pelajaran/list', [WebSu::class, 'mataPelajaranList'])->name('web.su.mata_pelajaran.list');
    Route::get('/upload-raport/list', [WebSu::class, 'uploadRaportList'])->name('web.su.upload_raport.list');
    Route::get('/leger/list', [WebSu::class, 'legerList'])->name('web.su.leger.list');
    Route::get('/kuisioner/list', [WebSu::class, 'kuisionerList'])->name('web.su.kuisioner.list');
    Route::get('/kuisioner-items/{kuisioner_id?}', [WebSu::class, 'kuisionerItemsList'])->name('web.su.kuisioner_items.list');
    Route::get('/kuisioner-hasil/list', [WebSu::class, 'kuisionerHasilList'])->name('web.su.kuisioner_hasil.list');
    Route::get('/kuisioner-hasil/detail/{ta_id?}/{ppdb_id?}', [WebSu::class, 'kuisionerHasilDetail'])->name('web.su.kuisioner_hasil.detail');
    Route::get('/susulan-remedial/list', [WebSu::class, 'susulanRemedialList'])->name('web.su.susulan_remedial.list');
    Route::get('/susulan-remedial/export-excel', [WebSu::class, 'susulanRemedialExport'])->name('web.su.susulan_remedial.export_excel');

    Route::get('/cabang/list', [WebSu::class, 'cabangList'])->name('web.su.cabang.list');
    Route::get('/user/list', [WebSu::class, 'userList'])->name('web.su.user.list');

    Route::get('/raport/list', [WebSu::class, 'raportList'])->name('web.su.raport.list');
    Route::get('/raport/print', [WebSu::class, 'raportPrint'])->name('web.su.raport.print');
    Route::get('/raport/detail', [WebSu::class, 'raportDetail'])->name('web.su.raport.detail');
    Route::get('/raport-cover/print', [WebSu::class, 'raportCoverPrint'])->name('web.su.raport-cover.print');

    Route::get('/rombongan-belajar/list', [WebSu::class, 'rombelList'])->name('web.su.rombongan_belajar.list');
    Route::get('/rombongan-belajar/summary', [WebSu::class, 'rombelSummary'])->name('web.su.rombongan_belajar.summary');
    Route::get('/rombongan-belajar/export-excel', [WebSu::class, 'rombelExportExcel'])->name('web.su.rombongan_belajar.export_excel');

    Route::get('/tahun-akademik/list', [WebSu::class, 'tahunAkademikList'])->name('web.su.tahun_akademik.list');

    Route::get('/ttd-raport/list', [WebSu::class, 'ttdRaportList'])->name('web.su.ttd_raport.list');

    Route::get('/wb/edit/{id?}', [WebWB::class, 'edit'])->name('web.su.wb.edit');

    Route::get('/ppdb/abc/list', [WebSu::class, 'ppdbAbcList'])->name('web.su.ppdb.abc.list');
    Route::get('/ppdb/abc/add', [WebSu::class, 'ppdbAbcAdd'])->name('web.su.ppdb.abc.add');
    Route::get('/ppdb/abc/edit/{id?}', [WebSu::class, 'ppdbAbcEdit'])->name('web.su.ppdb.abc.edit');
    Route::get('/ppdb/abc-new/list', [WebSu::class, 'ppdbAbcNewList'])->name('web.su.ppdb.abc_new.list');

    Route::get('/ppdb/paud/list', [WebSu::class, 'ppdbPaudList'])->name('web.su.ppdb.paud.list');
    Route::get('/ppdb/paud/add', [WebSu::class, 'ppdbPaudAdd'])->name('web.su.ppdb.paud.add');
    Route::get('/ppdb/paud/edit/{id?}', [WebSu::class, 'ppdbPaudEdit'])->name('web.su.ppdb.paud.edit');

    Route::get('/ppdb-ulang/abc/list', [WebSu::class, 'ppdbUlangAbcList'])->name('web.su.ppdb_ulang.abc.list');
    Route::get('/ppdb-ulang/abc/add', [WebSu::class, 'ppdbUlangAbcAdd'])->name('web.su.ppdb_ulang.abc.add');
    Route::get('/ppdb-ulang/abc/edit/{id?}', [WebSu::class, 'ppdbUlangAbcEdit'])->name('web.su.ppdb_ulang.abc.edit');

    Route::get('/ppdb-ulang/paud/list', [WebSu::class, 'ppdbUlangPaudList'])->name('web.su.ppdb_ulang.paud.list');
    Route::get('/ppdb-ulang/paud/add', [WebSu::class, 'ppdbUlangPaudAdd'])->name('web.su.ppdb_ulang.paud.add');
    Route::get('/ppdb-ulang/paud/edit/{id?}', [WebSu::class, 'ppdbUlangPaudEdit'])->name('web.su.ppdb_ulang.paud.edit');

    // nilai ongoing
    Route::get('/nilai/list', [WebSu::class, 'nilaiList'])->name('web.su.nilai.list');

    Route::get('/capaian-dimensi/list', [WebSu::class, 'capaianDimensiList'])->name('web.su.capaian_dimensi.list');
    Route::get('/nilai/export-excel', [WebSu::class, 'nilaiExportExcel'])->name('web.su.nilai.export_excel');

    // Perkembangan
    Route::get('/perkembangan/{ppdb_id?}/{kelas_id?}/{kmp_id?}', [WebSu::class, 'perkembanganList'])->name('web.su.perkembangan.list');

    Route::get('/alumni/list', [WebSu::class, 'alumniList'])->name('web.su.alumni.list');
    // keuangan
    Route::get('/keuangan/pembayaran/list', [WebSu::class, 'keuanganPembayaranList'])->name('web.su.keuangan.pembayaran.list');
    Route::get('/keuangan/pembayaran/detail/{id?}', [WebSu::class, 'keuanganPembayaranDetail'])->name('web.su.keuangan.pembayaran.detail');
    Route::get('/keuangan/pembayaran/detail-item/{id?}', [WebSu::class, 'keuanganPembayaranDetailItem'])->name('web.su.keuangan.pembayaran.detail-item');
    Route::get('/keuangan/daftar-abc/list', [WebSu::class, 'keuanganDaftarAbcList'])->name('web.su.keuangan.daftar_abc.list');
    Route::get('/keuangan/daftar-abc/add', [WebSu::class, 'keuanganDaftarAbcAdd'])->name('web.su.keuangan.daftar_abc.add');
    Route::get('/keuangan/slip-gaji/list', [WebSu::class, 'keuanganSlipGajiList'])->name('web.su.keuangan.slip_gaji.list');
    Route::get('/keuangan/slip-gaji/add', [WebSu::class, 'keuanganSlipGajiAdd'])->name('web.su.keuangan.slip_gaji.add');

    Route::get('/alumni/add', [WebSu::class, 'alumniAdd'])->name('web.su.alumni.add');
    Route::get('/alumni/edit/{id?}', [WebSu::class, 'alumniEdit'])->name('web.su.alumni.edit');

    // berita
    Route::get('/news/list', [WebSu::class, 'newsList'])->name('web.su.news.list');
    Route::get('/news/add', [WebSu::class, 'newsAdd'])->name('web.su.news.add');
    Route::get('/news/edit/{id?}', [WebSu::class, 'newsEdit'])->name('web.su.news.edit');

    // voucher
    Route::get('/voucher/list', [WebSu::class, 'voucherList'])->name('web.su.voucher.list');

    // settings
    Route::get('/settings', [WebSu::class, 'settings'])->name('web.su.settings');
});

Route::group(['prefix' => 'sireka', 'middleware' => ['auth']], function () {
    Route::get('/', [WebSireka::class, 'home'])->name('web.sireka.home');

    Route::get('/keuangan/pembayaran/list', [WebSireka::class, 'keuanganPembayaranList'])->name('web.sireka.keuangan.pembayaran.list');
    Route::get('/keuangan/pembayaran/detail/{id?}', [WebSireka::class, 'keuanganPembayaranDetail'])->name('web.sireka.keuangan.pembayaran.detail');
    Route::get('/keuangan/pembayaran/detail-item/{id?}', [WebSireka::class, 'keuanganPembayaranDetailItem'])->name('web.sireka.keuangan.pembayaran.detail-item');
    Route::get('/keuangan/daftar-abc/list', [WebSireka::class, 'keuanganDaftarAbcList'])->name('web.sireka.keuangan.daftar_abc.list');
    Route::get('/keuangan/daftar-abc/add', [WebSireka::class, 'keuanganDaftarAbcAdd'])->name('web.sireka.keuangan.daftar_abc.add');
    Route::get('/keuangan/slip-gaji/list', [WebSireka::class, 'keuanganSlipGajiList'])->name('web.sireka.keuangan.slip_gaji.list');
    Route::get('/keuangan/slip-gaji/add', [WebSireka::class, 'keuanganSlipGajiAdd'])->name('web.sireka.keuangan.slip_gaji.add');
});

Route::group(['prefix' => 'sirego', 'middleware' => ['auth']], function () {
    Route::get('/', [WebSirego::class, 'home'])->name('web.sirego.home');

    Route::post('/user/get', [DTUser::class, 'getAll'])->name('ajax.dt.user.get');
    Route::get('/user/list', [WebSirego::class, 'userList'])->name('web.sirego.user.list');
    Route::post('/user/get', [DTUser::class, 'getAll'])->name('ajax.dt.user.get');

    Route::post('/user/role', [AjaxUser::class, 'getRoles'])->name('ajax.user.get_roles');
    Route::post('/user/get', [AjaxUser::class, 'get'])->name('ajax.user.get');
    Route::post('/user/create', [AjaxUser::class, 'create'])->name('ajax.user.create');
    Route::post('/user/update', [AjaxUser::class, 'update'])->name('ajax.user.update');
    Route::post('/user/delete', [AjaxUser::class, 'delete'])->name('ajax.user.delete');
});

Route::group(['prefix' => 'sialum'], function () {
    Route::get('/add', [WebSialum::class, 'add'])->name('web.sialum.alumni.add');
    Route::get('/edit/{id}', [WebSialum::class, 'add'])->name('web.sialum.alumni.edit');
    Route::post('/store', [WebSialum::class, 'store'])->name('web.sialum.alumni.store');
    Route::post('/update/{id}', [WebSialum::class, 'update'])->name('web.sialum.alumni.update');
});

Route::group(['prefix' => 'siab', 'middleware' => ['auth']], function () {
    Route::get('/', [WebSiab::class, 'home'])->name('web.siab.home');
    Route::get('/profile', [WebSiab::class, 'profile'])->name('web.siab.profile');
    Route::get('/nilai/list', [WebSiab::class, 'nilaiList'])->name('web.siab.nilai.list');
    Route::get('/riwayat-kelas/list', [WebSiab::class, 'riwayatKelasList'])->name('web.siab.riwayat-kelas.list');
    Route::get('/laporan-perkembangan/list', [WebSiab::class, 'laporanPerkembanganList'])->name('web.siab.laporan-perkembangan.list');
    //debugx
    Route::get('/raport/print/{kelas_id?}', [WebSiab::class, 'raportPrint'])->name('web.siab.raport.print');
    Route::post('/raport-cover/print', [WebSiab::class, 'raportCoverPrint'])->name('web.siab.raport-cover.print');
    Route::get('/jadwal-pelajaran/list', [WebSiab::class, 'jadwalPelajaranList'])->name('web.siab.jadwal_pelajaran.list');
    Route::get('/ppdb/daftar-ulang', [WebSiab::class, 'daftarUlang'])->name('web.siab.ppdb.daftar_ulang');
    Route::get('/keuangan/list', [WebSiab::class, 'pembayaranList'])->name('web.siab.keuangan.list');
    Route::get('/keuangan/detail/{id?}', [WebSiab::class, 'pembayaranDetail'])->name('web.siab.keuangan.detail');
    Route::get('/keuangan/detail-item/{id?}', [WebSiab::class, 'pembayaranDetailItem'])->name('web.siab.keuangan.detail-item');
    Route::get('/kuisioner/respon', [WebSiab::class, 'kuisionerRespon'])->name('web.siab.kuisioner.respon');
    Route::get('/susulan-remedial/list', [WebSiab::class, 'susulanRemedialList'])->name('web.siab.susulan_remedial.list');
});

Route::group(['prefix' => 'situ', 'middleware' => ['auth']], function () {
    Route::get('/', [WebSitu::class, 'home'])->name('web.situ.home');
    Route::get('/jadwal-pelajaran/list', [WebSitu::class, 'jadwalPelajaranList'])->name('web.situ.jadwal_pelajaran.list');
    Route::get('/nilai/list', [WebSitu::class, 'nilaiList'])->name('web.situ.nilai.list');
    Route::get('/nilai/export-excel', [WebSitu::class, 'nilaiExportExcel'])->name('web.situ.nilai.export_excel');
    Route::get('/perkembangan/{ppdb_id?}/{kelas_id?}/{kmp_id?}', [WebSitu::class, 'perkembanganList'])->name('web.situ.perkembangan.list');
    Route::get('/susulan-remedial/list', [WebSitu::class, 'susulanRemedialList'])->name('web.situ.susulan_remedial.list');
    Route::get('/susulan-remedial/export-excel', [WebSitu::class, 'susulanRemedialExport'])->name('web.situ.susulan_remedial.export_excel');
});

Route::group(['prefix' => 'ajax-dt'], function () {
    Route::post('/tutor/get', [DtTutor::class, 'getAll'])->name('ajax.dt.tutor.get');
    Route::post('/layanan-kelas/get', [DtLayananKelas::class, 'getAll'])->name('ajax.dt.layanan_kelas.get');
    Route::post('/cabang/get', [DtCabang::class, 'getAll'])->name('ajax.dt.cabang.get');
    Route::post('/user/get', [DTUser::class, 'getAll'])->name('ajax.dt.user.get');
    Route::post('/kelas/get', [DtKelas::class, 'getAll'])->name('ajax.dt.kelas.get');
    Route::post('/paket-kelas/get', [DtPaketKelas::class, 'getAll'])->name('ajax.dt.paket_kelas.get');
    Route::post('/paket-spp/get', [DtPaketSpp::class, 'getAll'])->name('ajax.dt.paket_spp.get');
    Route::post('/ppdb/get', [DtPpdb::class, 'getAll'])->name('ajax.dt.ppdb.get');
    Route::post('/alumni/get', [DtAlumni::class, 'getAll'])->name('ajax.dt.alumni.get');
    Route::post('/ppdb-ulang/get', [DtPpdbUlang::class, 'getAll'])->name('ajax.dt.ppdb_ulang.get');
    Route::post('/mata-pelajaran/get', [DtMataPelajaran::class, 'getAll'])->name('ajax.dt.mata_pelajaran.get');
    Route::post('/kelas-mp/get', [DtKelasMP::class, 'getAll'])->name('ajax.dt.kelas_mp.get');
    Route::post('/kelas-wb/get', [DtKelasWB::class, 'getAll'])->name('ajax.dt.kelas_wb.get');
    Route::post('/kmp-setting/get', [DtKMPSetting::class, 'getAll'])->name('ajax.dt.kmp_setting.get');
    Route::post('/nilai/get', [DtNilai::class, 'getAll'])->name('ajax.dt.nilai.get');
    Route::post('/capaian-dimensi/get', [DtCapaianDimensi::class, 'getAll'])->name('ajax.dt.capaian_dimensi.get');
    Route::post('/nilai/get-by-wb', [DtNilai::class, 'getByWB'])->name('ajax.dt.nilai.get_by_wb');
    Route::post('/susulan-remedial/get', [DtSusulanRemedial::class, 'getAll'])->name('ajax.dt.susulan_remedial.get');
    Route::post('/susulan-remedial/get-siswa', [DtSusulanRemedial::class, 'getDataSiswa'])->name('ajax.dt.susulan_remedial.get_siswa');
    Route::post('/perkembangan/get', [DtPerkembangan::class, 'getAll'])->name('ajax.dt.perkembangan.get');
    Route::post('/settings/get', [DtSettings::class, 'getAll'])->name('ajax.dt.settings.get');
    Route::post('/tahun-akademik/get', [DtTahunAkademik::class, 'getAll'])->name('ajax.dt.tahun_akademik.get');
    Route::post('/news/get', [DtNews::class, 'getAll'])->name('ajax.dt.news.get');
    Route::post('/ekskul/get', [DtEkskul::class, 'getAll'])->name('ajax.dt.ekskul.get');
    Route::post('/nilai-kegiatan/get', [DtNilaiKegiatan::class, 'getAll'])->name('ajax.dt.nilai_kegiatan.get');
    Route::post('/voucher/get', [DtVoucher::class, 'getAll'])->name('ajax.dt.voucher.get');
    Route::post('/distribusi-mapel/get', [DtDistribusiMapel::class, 'getAll'])->name('ajax.dt.distribusi_mapel.get');
    Route::post('/rombongan-belajar/get', [DtRombonganBelajar::class, 'getAll'])->name('ajax.dt.rombongan_belajar.get');

    // dummy
    // Route::get('/rombongan-belajar/get', [DtRombonganBelajar::class, 'getAllDump'])->name('ajax.dt.rombongan_belajar.get');

    // untuk search rombel
    Route::post('/summary-rombel/get', [DtSummaryRombonganBelajar::class, 'getAll'])->name('ajax.dt.summary_rombel.get');
    // untuk menampilkan data rombel di summary rombel
    // Route::get('/summary-rombel/get', [DtSummaryRombonganBelajar::class, 'getAll'])->name('ajax.dt.summary_rombel.get');




    Route::post('/summary-rombel/get-status-count', [DtSummaryRombonganBelajar::class, 'getStatusCount'])->name('ajax.dt.summary_rombel.get_status_count');
    Route::post('/summary-rombel/get-status-wb', [DtSummaryRombonganBelajar::class, 'getStatusWB'])->name('ajax.dt.summary_rombel.get_status_wb');
    Route::post('/pembayaran/get', [DtPembayaran::class, 'getAll'])->name('ajax.dt.pembayaran.get');
    Route::post('/tagihan/get', [DtTagihan::class, 'getAll'])->name('ajax.dt.tagihan.get');
    Route::post(('/kuisioner/get'), [DtKuisioner::class, 'getAll'])->name('ajax.dt.kuisioner.get');
    Route::post('/kuisioner-items/get', [DtKuisionerItems::class, 'getAll'])->name('ajax.dt.kuisioner_items.get');
    Route::post('/kuisioner-hasil/get', [DtKuisioner::class, 'getHasilKuisioner'])->name('ajax.dt.kuisioner_hasil.get');
});

Route::group(['prefix' => 'ajax'], function () {
    Route::get('/dashboard/get-payment', [AjaxDashboard::class, 'getPembayaranData'])->name('ajax.dashboard.get_payment_chart');
    Route::post('/dashboard/wakaf-infaq-summary/dt', [AjaxDashboard::class, 'getWakafInfaqSummaryDT'])->name('ajax.dashboard.get_wakaf_infaq_summary_dt');
    Route::post('/dashboard/spp-summary/dt', [AjaxDashboard::class, 'getSppSummaryDT'])->name('ajax.dashboard.get_spp_summary_dt');

    Route::post('/tutor/save', [AjaxTutor::class, 'save'])->name('ajax.tutor.save');
    Route::post('/tutor/change-password', [AjaxTutor::class, 'changePassword'])->name('ajax.tutor.change_password');
    Route::post('/tutor/import-xls', [AjaxTutor::class, 'importExcel'])->name('ajax.tutor.import_excel');
    Route::post('/tutor/get', [AjaxTutor::class, 'get'])->name('ajax.tutor.get');
    Route::post('/tutor/get-all', [AjaxTutor::class, 'getAll'])->name('ajax.tutor.get_all');
    Route::post('/tutor/get-by-name', [AjaxTutor::class, 'getByName'])->name('ajax.tutor.get_by_name');
    Route::post('/tutor/delete', [AjaxTutor::class, 'delete'])->name('ajax.tutor.delete');

    Route::post('/layanan-kelas/save', [AjaxLayananKelas::class, 'save'])->name('ajax.layanan_kelas.save');
    Route::post('/layanan-kelas/get', [AjaxLayananKelas::class, 'get'])->name('ajax.layanan_kelas.get');
    Route::post('/layanan-kelas/get-all', [AjaxLayananKelas::class, 'getAll'])->name('ajax.layanan_kelas.get_all');
    Route::post('/layanan-kelas/delete', [AjaxLayananKelas::class, 'delete'])->name('ajax.layanan_kelas.delete');

    Route::post('/cabang/get', [AjaxCabang::class, 'getCabang'])->name('ajax.cabang.get');
    Route::post('/cabang/save', [AjaxCabang::class, 'save'])->name('ajax.cabang.save');
    Route::post('/cabang/delete', [AjaxCabang::class, 'delete'])->name('ajax.cabang.delete');

    Route::post('/user/role', [AjaxUser::class, 'getRoles'])->name('ajax.user.get_roles');
    Route::post('/user/get', [AjaxUser::class, 'get'])->name('ajax.user.get');
    Route::post('/user/create', [AjaxUser::class, 'create'])->name('ajax.user.create');
    Route::post('/user/update', [AjaxUser::class, 'update'])->name('ajax.user.update');
    Route::post('/user/delete', [AjaxUser::class, 'delete'])->name('ajax.user.delete');

    Route::post('/kelas/save', [AjaxKelas::class, 'save'])->name('ajax.kelas.save');
    Route::post('/kelas/get', [AjaxKelas::class, 'get'])->name('ajax.kelas.get');
    Route::post('/kelas/get-all', [AjaxKelas::class, 'getAll'])->name('ajax.kelas.get_all');
    Route::post('/kelas/get-by-name', [AjaxKelas::class, 'getByName'])->name('ajax.kelas.get_by_name');
    Route::post('/kelas/get-sebelumnya', [AjaxKelas::class, 'getSebelumnya'])->name('ajax.kelas.get_sebelumnya');
    Route::post('/kelas/type/get', [AjaxKelas::class, 'getType'])->name('ajax.kelas.get_type');
    Route::post('/kelas/delete', [AjaxKelas::class, 'delete'])->name('ajax.kelas.delete');
    Route::post('/kelas/update-status-nilai', [AjaxKelas::class, 'updateStatusNilai'])->name('ajax.kelas.update_status_nilai');
    Route::post('/kelas/update-jenis-rapor', [AjaxKelas::class, 'updateJenisRapor'])->name('ajax.kelas.update_jenis_rapor');
    Route::post('/kelas/import-rombel-xls', [AjaxKelas::class, 'importRombelExcel'])->name('ajax.kelas.import_rombel_excel');

    // dummy_rombongan_belajar
    // Route::get('/store-dummy-data', [AjaxKelas::class, 'storeDummyData']);

    Route::post('/paket-kelas/save', [AjaxPaketKelas::class, 'save'])->name('ajax.paket_kelas.save');
    Route::post('/paket-kelas/get', [AjaxPaketKelas::class, 'get'])->name('ajax.paket_kelas.get');
    Route::post('/paket-kelas/get-all', [AjaxPaketKelas::class, 'getAll'])->name('ajax.paket_kelas.get_all');
    Route::post('/paket-kelas/delete', [AjaxPaketKelas::class, 'delete'])->name('ajax.paket_kelas.delete');

    Route::post('/paket-kelas/save', [AjaxPaketKelas::class, 'save'])->name('ajax.paket_kelas.save');
    Route::post('/paket-kelas/get', [AjaxPaketKelas::class, 'get'])->name('ajax.paket_kelas.get');
    Route::post('/paket-kelas/get-all', [AjaxPaketKelas::class, 'getAll'])->name('ajax.paket_kelas.get_all');
    Route::post('/paket-kelas/delete', [AjaxPaketKelas::class, 'delete'])->name('ajax.paket_kelas.delete');

    Route::post('/paket-spp/save', [AjaxPaketSpp::class, 'save'])->name('ajax.paket_spp.save');
    Route::post('/paket-spp/get', [AjaxPaketSpp::class, 'get'])->name('ajax.paket_spp.get');
    Route::post('/paket-spp/get-all', [AjaxPaketSpp::class, 'getAll'])->name('ajax.paket_spp.get_all');
    Route::post('/paket-spp/delete', [AjaxPaketSpp::class, 'delete'])->name('ajax.paket_spp.delete');

    Route::post('/wb/update', [AjaxWb::class, 'update'])->name('ajax.wb.update');

    Route::post('/ppdb/create', [AjaxPpdb::class, 'create'])->name('ajax.ppdb.create');
    Route::post('/ppdb/update', [AjaxPpdb::class, 'update'])->name('ajax.ppdb.update');
    Route::post('/ppdb/upload-document', [AjaxPpdb::class, 'uploadDocument'])->name('ajax.ppdb.upload-document');
    Route::post('/ppdb/confirm-document', [AjaxPpdb::class, 'confirmDocument'])->name('ajax.ppdb.confirm-document');
    Route::post('/ppdb/get', [AjaxPpdb::class, 'get'])->name('ajax.ppdb.get');
    Route::post('/ppdb/get-all', [AjaxPpdb::class, 'getAll'])->name('ajax.ppdb.get_all');
    Route::post('/ppdb/delete', [AjaxPpdb::class, 'delete'])->name('ajax.ppdb.delete');
    Route::post('/ppdb/change-password', [AjaxPpdb::class, 'changePPDBPassword'])->name('ajax.ppdb.change_password');
    Route::post('/ppdb/update-wb-photo', [AjaxPpdb::class, 'updateWbPhoto'])->name('ajax.ppdb.update_wb_photo');
    Route::post('/ppdb/update-student-card', [AjaxPpdb::class, 'updateStudentCard'])->name('ajax.ppdb.update_student_card');
    Route::post('/ppdb/get-account-status/{ppdb_id}', [AjaxPpdb::class, 'getAccountStatus'])->name('ajax.ppdb.get_account_status');
    Route::post('/ppdb/change-account-status', [AjaxPpdb::class, 'changeAccountStatus'])->name('ajax.ppdb.change_account_status');

    Route::post('/alumni/create', [AjaxAlumni::class, 'create'])->name('ajax.alumni.create');
    Route::post('/alumni/update', [AjaxAlumni::class, 'update'])->name('ajax.alumni.update');
    Route::post('/alumni/delete', [AjaxAlumni::class, 'delete'])->name('ajax.alumni.delete');
    Route::post('/alumni/import', [AjaxAlumni::class, 'importAlumniExcel'])->name('ajax.alumni.import_alumni_excel');

    Route::post('/ppdb-ulang/get', [AjaxPpdbUlang::class, 'get'])->name('ajax.ppdb-ulang.get');
    Route::post('/ppdb-ulang/create', [AjaxPpdbUlang::class, 'create'])->name('ajax.ppdb-ulang.create');
    Route::post('/ppdb-ulang/update', [AjaxPpdbUlang::class, 'update'])->name('ajax.ppdb-ulang.update');

    Route::post('/keuangan/pembayaran/get/{id}', [AjaxPembayaran::class, 'getPembayaranById'])->name('ajax.keuangan.pembayaran.get_by_id');
    Route::post('/keuangan/pembayaran/get-item/{id}', [AjaxPembayaran::class, 'getPembayaranItemsById'])->name('ajax.keuangan.pembayaran.get_item');
    Route::post('/keuangan/pembayaran/get-by-tagihan/{id?}', [AjaxPembayaran::class, 'getPembayaranByTagihanId'])->name('ajax.keuangan.pembayaran.get_by_tagihan');
    Route::post('/keuangan/pembayaran/export-excel', [AjaxPembayaran::class, 'exportExcelPembayaran'])->name('ajax.keuangan.pembayaran.export_excel');
    Route::post('/keuangan/pelunasan/save', [AjaxPembayaran::class, 'pelunasanPembayaran'])->name('ajax.keuangan.pelunasan.save');
    Route::post('/keuangan/pembayaran/konfirmasi', [AjaxPembayaran::class, 'konfirmasiPembayaran'])->name('ajax.keuangan.pembayaran.konfirmasi');
    Route::post('/keuangan/pembayaran/send-invoice', [AjaxPembayaran::class, 'sendEmailInvoice'])->name('ajax.keuangan.pembayaran.send_email_invoice');

    Route::post('/keuangan/tagihan/get', [AjaxTagihan::class, 'getTagihan'])->name('ajax.keuangan.tagihan.get');
    Route::post('/keuangan/tagihan-item/get', [AjaxTagihan::class, 'getTagihanItems'])->name('ajax.keuangan.tagihan-items.get');

    Route::post('/mata-pelajaran/save', [AjaxMataPelajaran::class, 'save'])->name('ajax.mata_pelajaran.save');
    Route::post('/mata-pelajaran/get', [AjaxMataPelajaran::class, 'get'])->name('ajax.mata_pelajaran.get');
    Route::post('/mata-pelajaran/get-by-kelas', [AjaxMataPelajaran::class, 'getByKelas'])->name('ajax.mata_pelajaran.get_by_kelas');
    Route::post('/mata-pelajaran/get-all', [AjaxMataPelajaran::class, 'getAll'])->name('ajax.mata_pelajaran.get_all');
    Route::post('/mata-pelajaran/delete', [AjaxMataPelajaran::class, 'delete'])->name('ajax.mata_pelajaran.delete');

    Route::post('/kelas-mp/save', [AjaxKelasMP::class, 'save'])->name('ajax.kelas_mp.save');
    Route::post('/kelas-mp/get', [AjaxKelasMP::class, 'get'])->name('ajax.kelas_mp.get');
    Route::post('/kelas-mp/get-all', [AjaxKelasMP::class, 'getAll'])->name('ajax.kelas_mp.get_all');
    Route::post('/kelas-mp/delete', [AjaxKelasMP::class, 'delete'])->name('ajax.kelas_mp.delete');

    Route::post('/kelas-wb/save', [AjaxKelasWB::class, 'save'])->name('ajax.kelas_wb.save');
    Route::post('/kelas-wb/get', [AjaxKelasWB::class, 'get'])->name('ajax.kelas_wb.get');
    Route::post('/kelas-wb/get-all', [AjaxKelasWB::class, 'getAll'])->name('ajax.kelas_wb.get_all');
    Route::post('/kelas-wb/delete', [AjaxKelasWB::class, 'delete'])->name('ajax.kelas_wb.delete');
    Route::post('/kelas-wb/update-catatan', [AjaxKelasWB::class, 'updateCatatan'])->name('ajax.kelas_wb.update_catatan');
    Route::post('/kelas-wb/update-presensi', [AjaxKelasWB::class, 'updatePresensi'])->name('ajax.kelas_wb.update_presensi');

    Route::post('/kmp-setting/save', [AjaxKMPSetting::class, 'save'])->name('ajax.kmp_setting.save');
    Route::post('/kmp-setting/get', [AjaxKMPSetting::class, 'get'])->name('ajax.kmp_setting.get');
    Route::post('/kmp-setting/get-all', [AjaxKMPSetting::class, 'getAll'])->name('ajax.kmp_setting.get_all');
    Route::post('/kmp-setting/delete', [AjaxKMPSetting::class, 'delete'])->name('ajax.kmp_setting.delete');

    Route::post('/nilai/get', [AjaxNilai::class, 'get'])->name('ajax.nilai.get');

    // ongoging
    Route::post('/nilai/save', [AjaxNilai::class, 'save'])->name('ajax.nilai.save');
    // perbaikx
    Route::post('/nilai/import-excel', [AjaxNilai::class, 'importExcel'])->name('ajax.nilai.import_excel');
    Route::post('/nilai/calculate-tagihan', [AjaxNilai::class, 'calculateTagihan'])->name('ajax.nilai.calculate_tagihan');

    Route::post('/capaian-dimensi/save-or-update', [AjaxCapaianDimensi::class, 'saveOrUpdate'])->name('ajax.capaian_dimensi.saveOrUpdate');
    Route::post('/capaian-dimensi/save-or-update-nilai', [AjaxCapaianDimensi::class, 'saveOrUpdateNilaiWB'])->name('ajax.capaian_dimensi.saveOrUpdateNilaiWB');
    Route::post('/capaian-dimensi/save-or-update-catatan-proses', [AjaxCapaianDimensi::class, 'saveOrUpdateCatatanProses'])->name('ajax.capaian_dimensi.saveOrUpdateCatatanProses');
    Route::post('/capaian-dimensi/dimensi', [AjaxCapaianDimensi::class, 'getDimensi'])->name('ajax.capaian_dimensi.getDimensi');
    Route::post('/capaian-dimensi/elemen', [AjaxCapaianDimensi::class, 'getElemen'])->name('ajax.capaian_dimensi.getElemen');
    Route::post('/capaian-dimensi/point', [AjaxCapaianDimensi::class, 'getPoint'])->name('ajax.capaian_dimensi.getPoint');
    Route::post('/capaian-dimensi/delete', [AjaxCapaianDimensi::class, 'delete'])->name('ajax.capaian_dimensi.delete');

    Route::post('/perkembangan/save', [AjaxPerkembangan::class, 'save'])->name('ajax.perkembangan.save');
    Route::post('/perkembangan/delete', [AjaxPerkembangan::class, 'delete'])->name('ajax.perkembangan.delete');
    Route::post('/perkembangan/get-data', [AjaxPerkembangan::class, 'getData'])->name('ajax.perkembangan.get-data');
    Route::post('/perkembangan/get-info', [AjaxPerkembangan::class, 'getInfo'])->name('ajax.perkembangan.get-info');

    Route::post('/settings/get', [AjaxSettings::class, 'get'])->name('ajax.settings.get');
    Route::post('/settings/save', [AjaxSettings::class, 'save'])->name('ajax.settings.save');
    Route::post('/settings/delete', [AjaxSettings::class, 'delete'])->name('ajax.settings.delete');
    Route::post('/settings/get-by-key', [AjaxSettings::class, 'getByKey'])->name('ajax.settings.get_by_key');
    Route::get('/settings/kepala-pkbm', [AjaxSettings::class, 'getKepalaPkbm'])->name('ajax.settings.get_kepala_pkbm');

    Route::post('/tahun-akademik/list', [AjaxTahunAkademik::class, 'list'])->name('ajax.tahun_akademik.list');
    Route::post('/tahun-akademik/get', [AjaxTahunAkademik::class, 'get'])->name('ajax.tahun_akademik.get');
    Route::post('/tahun-akademik/save', [AjaxTahunAkademik::class, 'save'])->name('ajax.tahun_akademik.save');
    Route::post('/tahun-akademik/delete', [AjaxTahunAkademik::class, 'delete'])->name('ajax.tahun_akademik.delete');
    Route::post('/tahun-akademik/duplicate-kelas', [AjaxTahunAkademik::class, 'duplicateKelas'])->name('ajax.tahun_akademik.duplicate_kelas');

    Route::post('/ttd_raport/get', [AjaxTTDRaport::class, 'getData'])->name('ajax.ttd_raport.get');
    Route::post('/ttd_raport/saveOrUpdate', [AjaxTTDRaport::class, 'saveOrUpdate'])->name('ajax.ttd_raport.saveOrUpdate');

    Route::post('/news/list', [AjaxNews::class, 'list'])->name('ajax.news.list');
    Route::post('/news/get', [AjaxNews::class, 'get'])->name('ajax.news.get');
    Route::post('/news/save', [AjaxNews::class, 'save'])->name('ajax.news.save');
    Route::post('/news/delete', [AjaxNews::class, 'delete'])->name('ajax.news.delete');

    Route::post('/ekskul/list', [AjaxEkskul::class, 'list'])->name('ajax.ekskul.list');
    Route::post('/ekskul/get', [AjaxEkskul::class, 'get'])->name('ajax.ekskul.get');
    Route::post('/ekskul/save', [AjaxEkskul::class, 'save'])->name('ajax.ekskul.save');
    Route::post('/ekskul/delete', [AjaxEkskul::class, 'delete'])->name('ajax.ekskul.delete');

    Route::post('/nilai-kegiatan/list', [AjaxNilaiKegiatan::class, 'list'])->name('ajax.nilai_kegiatan.list');
    Route::post('/nilai-kegiatan/get', [AjaxNilaiKegiatan::class, 'get'])->name('ajax.nilai_kegiatan.get');
    Route::post('/nilai-kegiatan/save', [AjaxNilaiKegiatan::class, 'save'])->name('ajax.nilai_kegiatan.save');
    Route::post('/nilai-kegiatan/delete', [AjaxNilaiKegiatan::class, 'delete'])->name('ajax.nilai_kegiatan.delete');

    Route::post('/pembayaran/list', [AjaxPembayaran::class, 'list'])->name('ajax.pembayaran.list');

    Route::post('/voucher/list', [AjaxVoucher::class, 'list'])->name('ajax.voucher.list');
    Route::post('/voucher/get', [AjaxVoucher::class, 'get'])->name('ajax.voucher.get');
    Route::post('/voucher/check-code', [AjaxVoucher::class, 'checkCode'])->name('ajax.voucher.check_code');
    Route::post('/voucher/save', [AjaxVoucher::class, 'save'])->name('ajax.voucher.save');
    Route::post('/voucher/delete', [AjaxVoucher::class, 'delete'])->name('ajax.voucher.delete');

    Route::post('/siab/profile/update', [AjaxPpdb::class, 'updateProfile'])->name('ajax.siab.profile.update');
    Route::post('/siab/profile/change-password', [AjaxPpdb::class, 'changePassword'])->name('ajax.siab.profile.change_password');

    Route::post('/distribusi-mapel/import-excel', [AjaxDistribusiMapel::class, 'importExcel'])->name('ajax.distribusi_mapel.import_excel');

    Route::post('/rombel/save', [AjaxRombel::class, 'save'])->name('ajax.rombel.save');
    Route::post('/rombel/get', [AjaxRombel::class, 'get'])->name('ajax.rombel.get');
    Route::post('/rombel/delete', [AjaxRombel::class, 'delete'])->name('ajax.rombel.delete');

    Route::post('/ledger/export-excel', [AjaxLedger::class, 'exportExcel'])->name('ajax.ledger.export_excel');

    Route::post('/kuisioner/save', [AjaxKuisioner::class, 'save'])->name('ajax.kuisioner.save');
    Route::post('/kuisioner/get', [AjaxKuisioner::class, 'get'])->name('ajax.kuisioner.get');
    Route::post('/kuisioner/delete', [AjaxKuisioner::class, 'delete'])->name('ajax.kuisioner.delete');
    Route::post('/kuisioner/duplicate', [AjaxKuisioner::class, 'duplicate'])->name('ajax.kuisioner.duplicate');
    Route::post('/kuisioner/save-respon', [AjaxKuisioner::class, 'saveRespon'])->name('ajax.kuisioner.save_respon');

    Route::post('/kuisioner-items/save', [AjaxKuisionerItems::class, 'save'])->name('ajax.kuisioner_items.save');
    Route::post('/kuisioner-items/get', [AjaxKuisionerItems::class, 'get'])->name('ajax.kuisioner_items.get');
    Route::post('/kuisioner-items/delete', [AjaxKuisionerItems::class, 'delete'])->name('ajax.kuisioner_items.delete');

    Route::post('/susulan-remedial', [AjaxSusulanRemedial::class, 'getData'])->name('ajax.susulan_remedial.get');
});

Route::group(['prefix' => 'dashboard'], function () {
    Route::get('siswa/nilai/list', [WebDashboard::class, 'siswaNilaiList'])->name('web.dashboard.siswa.nilai.list');
    Route::get('siswa/raport/list', [WebDashboard::class, 'siswaRaportList'])->name('web.dashboard.siswa.raport.list');
    Route::get('tutor/nilai/list', [WebDashboard::class, 'tutorNilaiList'])->name('web.dashboard.tutor.nilai.list');
});

// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

// Route::get('/test-email', function () {
//     try {
//         Mail::to('fahmitb70@gmail.com')->send(new TestMail());
//         return 'Email berhasil dikirim!';
//     } catch (\Swift_TransportException $e) {
//         return 'Error transport: ' . $e->getMessage();
//     } catch (\Exception $e) {
//         return 'Error: ' . $e->getMessage();
//     }
// });


// routes/web.php
// Route::get('/test-email', function () {
//     try {
//         Mail::to('fahmitb70@gmail.com')->send(new \App\Mail\KirimEmail([
//             'nis' => '123',
//             'nisn' => '456',
//             'nama' => 'Test Name',
//             'jenis_kelamin' => 'l',
//             'no_hp' => '08123456789',
//             'email' => 'test@example.com',
//             'paket' => 'a',
//             'lanjut_kuliah' => true,
//             'nama_sekolah' => 'Universitas Test',
//             'prodi' => 'Teknik Informatika'
//         ]));

//         return "Email test sent successfully!";
//     } catch (\Exception $e) {
//         return "Failed to send email: " . $e->getMessage();
//     }
// });
