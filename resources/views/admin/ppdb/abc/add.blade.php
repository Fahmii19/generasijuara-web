@extends('layouts.admin_layout')

@section('content')
<main>
    <header class="page-header page-header-compact page-header-light border-bottom bg-white mb-4">
        <div class="container-fluid px-4">
            <div class="page-header-content">
                <div class="row align-items-center justify-content-between pt-3">
                    <div class="col-auto mb-3">
                        <h1 class="page-header-title">
                            <div class="page-header-icon"><a href="#" onclick="goBackWithRefresh();"><i data-feather="arrow-left"></i></a></div>
                            <span id="page-header-title-text">Add PPDB ABC</span>
                        </h1>
                    </div>
                </div>
            </div>
        </div>
    </header>
    <!-- Main page content-->
    <div class="container-fluid px-4">
        <div class="card">
            <div class="card-body">
                <form id="formPpdb" method="POST" action="" novalidate>
                    @csrf
                    <input class="form-control" id="id" type="hidden" />
                    <div class="row gx-3">
                        <div class="mb-3 col-md-3">
                            <label class="small mb-1" for="nis">NIS <small>(auto generate)</small></label>
                            <input class="form-control" id="nis" type="text" placeholder="" value="" />
                        </div>
                        <div class="mb-3 col-md-3">
                            <label class="small mb-1" for="nisn">NISN*</label>
                            <input class="form-control" id="nisn" type="text" placeholder="" value="" />
                        </div>
                        <div class="mb-3 col-md-3">
                            <label class="small mb-1" for="email">Email*</label>
                            <input class="form-control" id="email" type="email" placeholder="" value="" />
                        </div>
                        <div class="mb-3 col-md-3">
                            <label class="small mb-1" for="jenis_kelamin">Jenis Kelamin *</label>
                            <select class="form-control" id="jenis_kelamin">
                                <option value="l">Laki-laki</option>
                                <option value="p">Perempuan</option>
                            </select>
                        </div>
                    </div>
                    <div class="row gx-3">
                        <div class="mb-3 col-md-4">
                            <label class="small mb-1" for="nama">Nama Siswa (sesuai AKTE) *</label>
                            <input class="form-control" id="nama" type="text" placeholder="" value="" />
                        </div>
                        <div class="mb-3 col-md-4">
                            <label class="small mb-1" for="nama_ayah">Nama Ayah</label>
                            <input class="form-control" id="nama_ayah" type="text" placeholder="" value="" />
                        </div>
                        <div class="mb-3 col-md-4">
                            <label class="small mb-1" for="nama_ibu">Nama Ibu</label>
                            <input class="form-control" id="nama_ibu" type="text" placeholder="" value="" />
                        </div>
                    </div>
                    <div class="row gx-3">
                        <div class="mb-3 col-md-4">
                            <label class="small mb-1" for="nik_siswa">NIK Siswa (sesuai KK) *</label>
                            <input class="form-control" id="nik_siswa" type="text" placeholder="" value="" />
                        </div>
                        <div class="mb-3 col-md-4">
                            <label class="small mb-1" for="nik_ayah">NIK Ayah (sesuai KK) *</label>
                            <input class="form-control" id="nik_ayah" type="text" placeholder="" value="" />
                        </div>
                        <div class="mb-3 col-md-4">
                            <label class="small mb-1" for="nik_ibu">NIK Ibu (sesuai KK) *</label>
                            <input class="form-control" id="nik_ibu" type="text" placeholder="" value="" />
                        </div>
                    </div>
                    <div class="row gx-3">
                        <div class="mb-3 col-md-4">
                            <label class="small mb-1" for="hp_siswa">HP Siswa (WA Aktif)*</label>
                            <input class="form-control" id="hp_siswa" type="text" placeholder="" value="" />
                        </div>
                        <div class="mb-3 col-md-4">
                            <label class="small mb-1" for="hp_ayah">HP Ayah (WA Aktif)*</label>
                            <input class="form-control" id="hp_ayah" type="text" placeholder="" value="" />
                        </div>
                        <div class="mb-3 col-md-4">
                            <label class="small mb-1" for="hp_ibu">HP Ibu (WA Aktif)*</label>
                            <input class="form-control" id="hp_ibu" type="text" placeholder="" value="" />
                        </div>
                    </div>
                    <div class="row gx-3">
                        <div class="mb-3 col-md-4">
                            <label class="small mb-1" for="telegram_siswa">Telegram Siswa</label>
                            <input class="form-control" id="telegram_siswa" type="text" placeholder="" value="" />
                        </div>
                        <div class="mb-3 col-md-4">
                            <label class="small mb-1" for="telegram_ayah">Telegram Ayah</label>
                            <input class="form-control" id="telegram_ayah" type="text" placeholder="" value="" />
                        </div>
                        <div class="mb-3 col-md-4">
                            <label class="small mb-1" for="telegram_ibu">Telegram Ibu</label>
                            <input class="form-control" id="telegram_ibu" type="text" placeholder="" value="" />
                        </div>
                    </div>
                    <div class="row gx-3">
                        <div class="mb-3 col-md-4">
                            <label class="small mb-1" for="tgl_terima">Tanggal Diterima</label>
                            <input class="form-control" id="tgl_terima" type="date">
                        </div>
                    </div>
                    <hr>
                    <h1>Sebelumnya</h1>
                    <div class="row gx-3">
                        <div class="mb-3 col-md-4">
                            <label class="small mb-1" for="kelas_sebelum">Kelas*</label>
                            <select class="form-control" id="kelas_sebelum">
                                <option value>-- Pilih Kelas--</option>
                                <option value="0">Tidak Sekolah</option>
                                <option value="TK">TK</option>
                                <option value="1">1</option>
                                <option value="2">2</option>
                                <option value="3">3</option>
                                <option value="4">4</option>
                                <option value="5">5</option>
                                <option value="6">6</option>
                                <option value="7">7</option>
                                <option value="8">8</option>
                                <option value="9">9</option>
                                <option value="10">10</option>
                                <option value="11">11</option>
                                <option value="12">12</option>
                            </select>
                        </div>
                        <div class="mb-3 col-md-4" id="div_smt_kelas_sebelum">
                            <label class="small mb-1" for="smt_kelas_sebelum">Semester</label>
                            <select class="form-control" id="smt_kelas_sebelum">
                                <option value>-- Pilih Semester--</option>
                                <option value="1">1</option>
                                <option value="2">2</option>
                            </select>
                        </div>
                        <div class="mb-3 col-md-4" id="div_tipe_kelas_sebelum">
                            <label class="small mb-1" for="tipe_kelas_sebelum">Jenis Kelas</label>
                            <select class="form-control" id="tipe_kelas_sebelum">
                                <option value>-- Pilih Jenis Kelas--</option>
                                <option value="1">FORMAL</option>
                                <option value="2">NONFORMAL</option>
                                <option value="3">INFORMAL</option>
                            </select>
                        </div>
                    </div>
                    <h1>Yang dituju</h1>
                    <div class="row gx-3">
                        <div class="mb-3 col-md-4">
                            <label class="small mb-1" for="cabang_id">Cabang</label>
                            <select class="form-control" id="cabang_id" name="cabang_id">

                            </select>
                        </div>
                        <div class="mb-3 col-md-4">
                            <label class="small mb-1" for="kelas">Kelas*</label>
                            <select class="form-control" id="kelas">
                                <option value>-- Pilih Kelas--</option>
                                <option value="1">1</option>
                                <option value="2">2</option>
                                <option value="3">3</option>
                                <option value="4">4</option>
                                <option value="5">5</option>
                                <option value="6">6</option>
                                <option value="7">7</option>
                                <option value="8">8</option>
                                <option value="9">9</option>
                                <option value="10">10</option>
                                <option value="11">11</option>
                                <option value="12">12</option>
                            </select>
                        </div>
                        <div class="mb-3 col-md-4">
                            <label class="small mb-1" for="smt_kelas">Semester*</label>
                            <select class="form-control" id="smt_kelas">
                                <option value>-- Pilih Semester--</option>
                                <option value="1">1</option>
                                <option value="2">2</option>
                            </select>
                        </div>
                        <div class="mb-3 col-md-4" id="div_peminatan">
                            <label class="small mb-1" for="peminatan">Khusus Paket C (Setara SMA)</label>
                            <select class="form-control" id="peminatan">
                                <option value="">- Pilih Peminatan -</option>
                                <option value="IPA">IPA</option>
                                <option value="IPS">IPS</option>
                            </select>
                        </div>
                        <div class="mb-3 col-md-4">
                            <label class="small mb-1" for="layanan_kelas_id">Layanan Kelas *</label>
                            <select class="form-control" id="layanan_kelas_id"></select>
                        </div>
                        <div class="mb-3 col-md-4">
                            <label class="small mb-1" for="paket_kelas_id">Paket Kelas *</label>
                            <select class="form-control" id="paket_kelas_id"></select>
                        </div>
                        <div class="mb-3 col-md-4">
                            <label class="small mb-1" for="paket_spp_id">Paket SPP *</label>
                            <select class="form-control" id="paket_spp_id"></select>
                        </div>
                        <div class="mb-3 col-md-4">
                            <label class="small mb-1" for="lulusan">Pendidikan Terakhir</label>
                            <select class="form-control" id="lulusan">
                                <option value="">- Pilih -</option>
                                <option value="SD">SD</option>
                                <option value="SMP">SMP</option>
                            </select>
                        </div>
                        <div class="mb-3 col-md-4">
                            <label class="small mb-1" for="tahun_lulus">Tahun Lulus</label>
                            <input class="form-control" id="tahun_lulus" type="text" placeholder="ex. 2018" value="" />
                        </div>
                    </div>
                    <hr>
                    <h1>Biaya</h1>
                    <div class="row gx-3">
                        <div class="mb-3 col-md-3">
                            <label class="small mb-1" for="biaya_daftar">Daftar</label>
                            <input readonly="readonly" class="form-control ribuan-format" id="biaya_daftar" type="text" placeholder="" value="" />
                        </div>
                        <div class="mb-3 col-md-3">
                            <label class="small mb-1" for="biaya_spp">SPP</label>
                            <input readonly="readonly" class="form-control ribuan-format" id="biaya_spp" type="text" placeholder="" value="" />
                        </div>
                        <div class="mb-3 col-md-3">
                            <label class="small mb-1" for="wakaf">Wakaf</label>
                            <input class="form-control ribuan-format" id="wakaf" type="text" placeholder="" value="" readonly=
                            "readonly" />
                        </div>
                        <div class="mb-3 col-md-3">
                            <label class="small mb-1" for="infaq">Infaq</label>
                            <input class="form-control ribuan-format" id="infaq" type="text" placeholder="" value="" readonly=
                            "readonly" />
                        </div>
                    </div>
                    <div id="div_konfirmasi_pembayaran" style="display: none">
                        <h1>Konfirmasi Pembayaran</h1>
                        <div class="row gx-3">
                            <div class="mb-3 col-md-3">
                                <label class="small mb-1" for="bayar_daftar">Transfer Daftar</label>
                                <input class="form-control ribuan-format transfer-input" id="bayar_daftar" type="text" placeholder="" value="" />
                            </div>
                            <div class="mb-3 col-md-3">
                                <label class="small mb-1" for="bayar_spp">Transfer SPP (min. 30%)</label>
                                <input class="form-control ribuan-format transfer-input" id="bayar_spp" type="text" placeholder="" value="" />
                            </div>
                            <div class="mb-3 col-md-3">
                                <label class="small mb-1" for="bayar_wakaf">Transfer Wakaf</label>
                                <input class="form-control ribuan-format transfer-input" id="bayar_wakaf" type="text" placeholder="" value="" />
                            </div>
                            <div class="mb-3 col-md-3">
                                <label class="small mb-1" for="bayar_infaq">Transfer Infaq & Sedekah</label>
                                <input class="form-control ribuan-format transfer-input" id="bayar_infaq" type="text" placeholder="" value="" />
                            </div>
                            <div class="mb-3 col-md-6">
                                <label class="small mb-1" for="total_transfer">Total Transfer</label>
                                <input readonly="readonly" class="form-control ribuan-format" id="total_transfer" type="text" placeholder="" value="" />
                            </div>
                            <div class="mb-3 col-md-6">
                                <label class="small mb-1" for="bukti_tf">Bukti Transfer</label>
                                <input class="form-control" id="bukti_tf" type="file" placeholder="" value="" />
                            </div>
                        </div>
                    </div>

                    <div id="div_pembayaran" style="display:none">
                        <hr>
                        <h1>Pembayaran</h1>
                        <div class="row gx-3">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="tableRiwayatPembayaran" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                           <th style="width: 60%;">Keterangan</th>
                                           <th style="width: 15%;">Nominal</th>
                                           <th style="width: 15%;">Status</th>
                                           <th class="text-center" style="width: 10%;">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody id="pembayaranRiwayatList">
                                        
                                    </tbody>
                                </table>
                                <table class="table table-bordered" id="tableRekapitulasi" width="100%" cellspacing="0">
                                    <tbody id="rekapitulasiPembayaran">
                                        <tr>
                                            <th style="width: 25%;">Grand Total</th>
                                            <td id="rekap_grand_total"></td>
                                        </tr>
                                        <tr>
                                            <th>Kekurangan</th>
                                            <td id="rekap_kekurangan"></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <div id="div_dokumen">
                        <hr>
                        <h1>Dokumen</h1>
                        <div class="row gx-3">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="tableDokumen" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                           <th width="55%">Item</th> 
                                           <th width="30%">Status</th>
                                           <th width="15%" class="text-center">Action</th> 
                                        </tr>
                                    </thead>
                                    <tbody id="dokumenItems">
                                        <tr>
                                            <td>KTP Orang Tua</td>
                                            <td>
                                                {{($data_ppdb->dokumen_ktp_orang_tua != null) ? (($data_ppdb->is_ktp_approved == 1) ? 'Terverifikasi' : 'Menunggu Konfirmasi') : 'Belum Upload'}}
                                            </td>
                                            <td class="text-center">
                                                <a href="{{$data_ppdb->dokumen_ktp_orang_tua}}" target="_blank"
                                                    class="btn btn-sm btn-light text-primary m-1 {{($data_ppdb->dokumen_ktp_orang_tua == null) ? 'disabled' : ''}}">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                                <button type="button" class="btn btn-sm btn-light text-success confirmDocumentBtn m-1 {{($data_ppdb->dokumen_ktp_orang_tua == null || $data_ppdb->is_ktp_approved == 1) ? 'disabled' : ''}}"
                                                    data-doc="dokumen_ktp_orang_tua"
                                                    data-title="Dokumen KTP Orang Tua">
                                                    <i class="fas fa-check"></i>
                                                </button>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Scan/Foto Akta Kelahiran</td>
                                            <td>
                                                {{($data_ppdb->dokumen_akta_kelahiran != null) ? (($data_ppdb->is_akta_approved == 1) ? 'Terverifikasi' : 'Menunggu Konfirmasi') : 'Belum Upload'}}
                                            </td>
                                            <td class="text-center">
                                                <a href="{{$data_ppdb->dokumen_akta_kelahiran}}" target="_blank"
                                                    class="btn btn-sm btn-light text-primary m-1 {{($data_ppdb->dokumen_akta_kelahiran == null) ? 'disabled' : ''}}">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                                <button type="button" class="btn btn-sm btn-light text-success confirmDocumentBtn m-1 {{($data_ppdb->dokumen_akta_kelahiran == null || $data_ppdb->is_akta_approved == 1) ? 'disabled' : ''}}"
                                                    data-doc="dokumen_akta_kelahiran"
                                                    data-title="Dokumen Akta Kelahiran">
                                                    <i class="fas fa-check"></i>
                                                </button>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Scan/Foto SHUN/SKHUN</td>
                                            <td>
                                                {{($data_ppdb->dokumen_shun_skhun != null) ? (($data_ppdb->is_shun_skhun_approved == 1) ? 'Terverifikasi' : 'Menunggu Konfirmasi') : 'Belum Upload'}}
                                            </td>
                                            <td class="text-center">
                                                <a href="{{$data_ppdb->dokumen_shun_skhun}}" target="_blank"
                                                    class="btn btn-sm btn-light text-primary m-1 {{($data_ppdb->dokumen_shun_skhun == null) ? 'disabled' : ''}}">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                                <button type="button" class="btn btn-sm btn-light text-success confirmDocumentBtn m-1 {{($data_ppdb->dokumen_shun_skhun == null || $data_ppdb->is_shun_skhun_approved == 1) ? 'disabled' : ''}}"
                                                    data-doc="dokumen_shun_skhun"
                                                    data-title="Dokumen SHUN/SKHUN">
                                                    <i class="fas fa-check"></i>
                                                </button>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Scan/Foto Kartu Keluarga</td>
                                            <td>
                                                {{($data_ppdb->dokumen_kartu_keluarga != null) ? (($data_ppdb->is_kk_approved == 1) ? 'Terverifikasi' : 'Menunggu Konfirmasi') : 'Belum Upload'}}
                                            </td>
                                            <td class="text-center">
                                                <a href="{{$data_ppdb->dokumen_kartu_keluarga}}" target="_blank"
                                                    class="btn btn-sm btn-light text-primary m-1 {{($data_ppdb->dokumen_kartu_keluarga == null) ? 'disabled' : ''}}">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                                <button type="button" class="btn btn-sm btn-light text-success confirmDocumentBtn m-1 {{($data_ppdb->dokumen_kartu_keluarga == null || $data_ppdb->is_kk_approved == 1) ? 'disabled' : ''}}"
                                                    data-doc="dokumen_kartu_keluarga"
                                                    data-title="Dokumen Kartu Keluarga">
                                                    <i class="fas fa-check"></i>
                                                </button>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Scan/Foto Ijasah</td>
                                            <td>
                                                {{($data_ppdb->dokumen_ijasah != null) ? (($data_ppdb->is_ijasah_approved == 1) ? 'Terverifikasi' : 'Menunggu Konfirmasi') : 'Belum Upload'}}
                                            </td>
                                            <td class="text-center">
                                                <a href="{{$data_ppdb->dokumen_ijasah}}" target="_blank"
                                                    class="btn btn-sm btn-light text-primary m-1 {{($data_ppdb->dokumen_ijasah == null || $data_ppdb->dokumen_ijasah == 1) ? 'disabled' : ''}}">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                                <button type="button" class="btn btn-sm btn-light text-success confirmDocumentBtn m-1 {{($data_ppdb->dokumen_ijasah == null || $data_ppdb->is_ijasah_approved == 1) ? 'disabled' : ''}}"
                                                    data-doc="dokumen_ijasah"
                                                    data-title="Dokumen Ijasah">
                                                    <i class="fas fa-check"></i>
                                                </button>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <hr>

                    <h1>User</h1>

                    <div class="row gx-3">
                        <div class="mb-3 col-md-12">
                            <div class="form-check" id="form-check-is_approved">
                                <input class="form-check-input" id="is_approved" name="is_approved" type="checkbox" value="">
                                <label class="form-check-label" for="is_approved">Approve</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" id="is_active" name="is_active" type="checkbox" value="">
                                <label class="form-check-label" for="is_active">Email Verifikasi</label>
                            </div>
                        </div>
                    </div>
                    <!-- <div class="row gx-3">
                        <div class="mb-3 col-md-4">
                            <label class="small mb-1" for="username">Username</label>
                            <input class="form-control" id="username" type="text" readonly="readonly" placeholder="" value="" />
                        </div>
                        <div class="mb-3 col-md-4">
                            <label class="small mb-1" for="password">Password</label>
                            <input class="form-control" id="password" type="password" placeholder="" value="" />
                        </div>
                    </div> -->
                    <hr class="my-4" />
                    <div class="d-flex justify-content-between">
                        <button class="btn btn-light" type="button" onclick="goBackWithRefresh();">Cancel</button>
                        <button class="btn btn-primary" type="button" id="submitPpdbBtn">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</main>
@stop

@section('style_extra')

@endsection

@section('js_extra')

<script type="text/javascript">
    $(document).ready(function() {
        var table = null
        var cabangSelected = null;
        var layananKelasSelected = null;
        var paketKelasSelected = null;
        var paketSppSelected = null;
        var permintaanSelected = null;
        var kelasSelected = null;
        var smtSelected = null;
        var typeSelected = 0;
        var id = "{{@$id}}";
        var grandTotal = 0;
        var afterDiscount = 0;

        resetForm();

        function resetForm() {
            $('#formPpdb').trigger("reset");
            $("#div_smt_kelas_sebelum").show();
            $("#div_tipe_kelas_sebelum").show();
            // newBuktiTfFile = null;
            // newBuktiTfSrc = null;
            // $('#formPpdb').find('#bukti_tf_preview').attr("src", "{{asset('images')}}/placeholder.png");
        }

        $("#email").on("change", function(e) {
            $('#username').val($("#email").val());
        });

        function recalculateTotalTransfer() {
            let bayar_daftar = parseInt($('#bayar_daftar').val(), 0) || 0;
            let bayar_spp = parseInt($('#bayar_spp').val(), 0) || 0;
            let bayar_wakaf = parseInt($('#bayar_wakaf').val(), 0) || 0;
            let bayar_infaq = parseInt($('#bayar_infaq').val(), 0) || 0;

            let total_transfer = bayar_daftar + bayar_spp + bayar_wakaf + bayar_infaq;
            $('#total_transfer').val(total_transfer)
        }

        $(".transfer-input").on("change", function(e) {
            recalculateTotalTransfer();
        });

        $("#kelas_sebelum").on("change", function(e) {
            if ($("#kelas_sebelum").val() > 0) {
                $("#div_smt_kelas_sebelum").show();
                $("#div_tipe_kelas_sebelum").show();
            }else{
                $("#div_smt_kelas_sebelum").hide();
                $("#div_tipe_kelas_sebelum").hide();

                $("#smt_kelas_sebelum").val(null);
                $("#tipe_kelas_sebelum").val(null);
            }
        });

        $("#kelas").on("change", function(e) {
            // jika sudah SMA
            if ($("#kelas").val() > 9) {
                $("#div_peminatan").show();
            }else{
                $("#div_peminatan").hide();
            }

            kelasSelected = $("#kelas").val();
            fetchPaketSpp()
        });

        $("#smt_kelas").on("change", function(e) {
            smtSelected = $("#smt_kelas").val();
            fetchPaketSpp()
        });

        $("#layanan_kelas_id").on("change", function(e) {
            layananKelasSelected = $("#layanan_kelas_id").val();
            fetchPaketSpp()
        });

        $("#paket_kelas_id").on("change", function(e) {
            paketKelasSelected = $("#paket_kelas_id").val();
            fetchPaketSpp()
        });

        getCabang();
        function getCabang() {
            $.ajax({
                type: "POST",
                url: "{{route('ajax.cabang.get')}}",
                data: {
                    "_token": "{{ csrf_token() }}",
                },
                success: function(res) {
                    console.log(res);
                    var html_results = "<option value=''>-- Pilih Cabang --</option>";
                    $.each(res.data, function (i, row) {
                        html_results += "<option value='"+row.id+"'>"+row.nama_cabang+"</option>";
                    });
                    $('#cabang_id').html(html_results);
                }
            });
        }

        getLayananKelas();
        function getLayananKelas() {
            $.ajax({
                type: "POST",
                url: "{{route('ajax.layanan_kelas.get_all')}}",
                data: {
                    "_token": "{{ csrf_token() }}",
                },
                success: function(res) {
                    // console.log(res);
                    var html_results = "<option value=''>-- Pilih Layanan --</option>";
                    $.each(res.data, function (i, row) {
                        html_results += "<option value='"+row.id+"'>"+row.kode+"</option>";
                    });
                    $('#layanan_kelas_id').html(html_results);

                    if (layananKelasSelected != null) {
                        $('#layanan_kelas_id').val(layananKelasSelected);
                    }
                }
            });
        }

        getPaketKelas();
        function getPaketKelas() {
            $.ajax({
                type: "POST",
                url: "{{route('ajax.paket_kelas.get_all')}}",
                data: {
                    "_token": "{{ csrf_token() }}",
                    "type": "{{ $type }}",
                },
                success: function(res) {
                    // console.log(res);
                    var html_results = "<option value=''>-- Pilih --</option>";
                    $.each(res.data, function (i, row) {
                        html_results += "<option value='"+row.id+"'>"+row.nama+"</option>";
                    });
                    $('#paket_kelas_id').html(html_results);

                    if (paketKelasSelected != null) {
                        $('#paket_kelas_id').val(paketKelasSelected);
                    }
                }
            });
        }

        function fetchPaketSpp(){
            const paramSpp = {
                'cabang_id' : cabangSelected,
                'kelas' : kelasSelected,
                'semester' : smtSelected,
                'layanan_kelas_id' : layananKelasSelected,
                'paket_kelas_id' : paketKelasSelected,
            };

            getPaketSppOptions(paramSpp, function(output){
                $("#paket_spp_id").html(output);
                if (paketSppSelected != null) {
                    $('#paket_spp_id').val(paketSppSelected);
                }
            });
        }

        $("#paket_spp_id").on("change", function(e) {
            paketSppSelected = $('#paket_spp_id').val();
            getPaketSppDetail(paketSppSelected, function(output){
                $('#biaya_daftar').val(output.biaya_pendaftaran)
                $('#biaya_spp').val(output.biaya)
            });
        });

        if (id != null && id != '') {
            $('#page-header-title-text').text("Edit PPDB ABC");
            $('#div_konfirmasi_pembayaran').hide();
            $('#div_pembayaran').show();
            getDetailPPDB();
            getDetailPembayaran();
            $("#cabang_id").prop("disabled", true);
            $("#kelas").prop("disabled", true);
            $("#smt_kelas").prop("disabled", true);
            $("#peminatan").prop("disabled", true);
            $("#layanan_kelas_id").prop("disabled", true);
            $("#paket_kelas_id").prop("disabled", true);
            $("#paket_spp_id").prop("disabled", true);
            $("#lulusan").prop("disabled", true);
            $("#tahun_lulus").prop("readonly", true);

            $("#kelas_sebelum").prop("disabled", true);
            $("#smt_kelas_sebelum").prop("disabled", true);
            $("#tipe_kelas_sebelum").prop("disabled", true);
        }else{
            $('#div_konfirmasi_pembayaran').show();
            $('#div_pembayaran').hide();
        }

        function getDetailPPDB() {
            $.ajax({
                type: "POST",
                url: "{{route('ajax.ppdb.get')}}",
                data: {
                    "_token": "{{ csrf_token() }}",
                    "id": id,
                },
                success: function(res) {
                    // console.log(res);
                    if (!res.error) {
                        $('#formPpdb').find('#username').val(res.data.email);
                        $('#formPpdb').find('#id').val(res.data.id);
                        $('#formPpdb').find('#nis').val(res.data.nis);
                        $('#formPpdb').find('#nisn').val(res.data.nisn);
                        $('#formPpdb').find('#email').val(res.data.email);
                        $('#formPpdb').find('#jenis_kelamin').val(res.data.kelamin);
                        $('#formPpdb').find('#nama').val(res.data.nama);
                        $('#formPpdb').find('#nama_ayah').val(res.data.nama_ayah);
                        $('#formPpdb').find('#nama_ibu').val(res.data.nama_ibu);
                        $('#formPpdb').find('#nik_siswa').val(res.data.nik_siswa);
                        $('#formPpdb').find('#nik_ayah').val(res.data.nik_ayah);
                        $('#formPpdb').find('#nik_ibu').val(res.data.nik_ibu);
                        $('#formPpdb').find('#hp_siswa').val(res.data.hp_siswa);
                        $('#formPpdb').find('#hp_ayah').val(res.data.hp_ayah);
                        $('#formPpdb').find('#hp_ibu').val(res.data.hp_ibu);
                        $('#formPpdb').find('#telegram_siswa').val(res.data.telegram_siswa);
                        $('#formPpdb').find('#telegram_ayah').val(res.data.telegram_ayah);
                        $('#formPpdb').find('#telegram_ibu').val(res.data.telegram_ibu);
                        $('#formPpdb').find('#tgl_terima').val(res.data.tgl_terima);
                        $('#formPpdb').find('#kelas_sebelum').val(res.data.kelas_sebelum);
                        $('#formPpdb').find('#smt_kelas_sebelum').val(res.data.smt_kelas_sebelum);
                        $('#formPpdb').find('#tipe_kelas_sebelum').val(res.data.tipe_kelas_sebelum);
                        $('#formPpdb').find('#cabang_id').val(res.data.cabang_id);
                        $('#formPpdb').find('#kelas').val(res.data.kelas);
                        $('#formPpdb').find('#smt_kelas').val(res.data.smt_kelas);
                        $('#formPpdb').find('#lulusan').val(res.data.lulusan);
                        $('#formPpdb').find('#tahun_lulus').val(res.data.tahun_lulus);
                        $('#formPpdb').find('#biaya_daftar').val(res.data.biaya_daftar);
                        $('#formPpdb').find('#biaya_spp').val(res.data.biaya_spp);
                        $('#formPpdb').find('#wakaf').val(res.data.wakaf);
                        $('#formPpdb').find('#infaq').val(res.data.infaq);
                        $('#formPpdb').find('#is_active').prop("checked", res.data.is_active);
                        $('#formPpdb').find('#is_approved').prop("checked", res.data.is_approved);
                        if (res.data.is_approved) {
                            $('#formPpdb').find('#form-check-is_approved').hide();
                        }

                        // Set total biaya keseluruhan sebelum diskon
                        grandTotal = res.data.biaya_daftar + res.data.biaya_spp + res.data.wakaf + res.data.infaq;

                        cabangSelected = res.data.cabang_id;
                        kelasSelected = res.data.kelas;
                        smtSelected = res.data.smt_kelas;

                        layananKelasSelected = res.data.layanan_kelas_id;
                        $('#formPpdb').find('#layanan_kelas_id').val(layananKelasSelected);
                        
                        paketKelasSelected = res.data.paket_kelas_id;
                        $('#formPpdb').find('#paket_kelas_id').val(paketKelasSelected);
                        
                        paketSppSelected = res.data.paket_spp_id;
                        $('#formPpdb').find('#paket_spp_id').val(paketSppSelected);

                        permintaanSelected = res.data.peminatan;
                        $('#formPpdb').find('#peminatan').val(permintaanSelected);

                        fetchPaketSpp();

                        // // pembayaran
                        // $('#formPpdb').find('#wakaf').val(res.data.wakaf);
                    }
                }
            });
        }

        const tagihanId = '{{@$data_tagihan->id}}';
        if(tagihanId != '' && tagihanId != null) {
            getPembayaran();
        }

        function getPembayaran() {
            $.ajax({
                type: "POST",
                url: "{{route('ajax.keuangan.pembayaran.get_by_tagihan', @$data_tagihan->id)}}",
                data: {
                    "_token": "{{ csrf_token() }}",
                },
                success: function(res) {
                    console.log(res.data);
                    if (!res.error) {
                        var tbody = "";
                        var totalPayment = 0;

                        $.each(res.data, function (i, row) {
                            tbody += ""+
                                "<tr>"+
                                    "<td>"+
                                        row.keterangan+  
                                    "</td>"+
                                    "<td>"+
                                        "Rp. " + formatRibuan(row.nominal)+
                                    "</td>"+
                                    "<td>"+
                                        (row.is_approved == 1 ? "Approved" : "Pending")+
                                    "</td>"+
                                    "<td class='text-center'>"+
                                        '<a href="{{route("web.su.keuangan.pembayaran.detail-item")}}/'+row.id+'" class="btn btn-sm btn-transparent-dark"><i class="fas fa-eye"></i></a>'+
                                    "</td>"+
                                "</tr>";
                        });
                        $("#pembayaranRiwayatList").html(tbody);
                    }
                }
            });

            $.ajax({
                type: "POST",
                url: "{{route('ajax.keuangan.tagihan.get')}}",
                data: {
                    "_token": "{{ csrf_token() }}",
                    "id": tagihanId,
                },
                success: function(res) {
                    if (!res.error) {
                        console.log(res);
                        $('#rekap_grand_total').html(formatRibuan(res.data.total_tagihan));
                        $('#rekap_kekurangan').html(formatRibuan(res.data.total_tagihan - res.data.nominal));
                    }
                }
            });
        }

        function getDetailPembayaran() {
            $.ajax({
                type: "POST",
                url: "{{route('ajax.pembayaran.list')}}",
                data: {
                    "_token": "{{ csrf_token() }}",
                    "ppdb_id": id,
                },
                success: function(res) {
                    // console.log(res);
                    if (!res.error) {
                        var tbody = "";
                        var totalPayment = 0;
                        $.each(res.data, function (i, row) {
                            (row.voucher[0] ? afterDiscount = grandTotal - row.voucher[0].discount : 0);

                            tbody += ""+
                                "<tr>"+
                                    "<td colspan='2'><b>"+row.keterangan+"</b></td>"+
                                "</tr>";
                            $.each(row.items, function (j, item) {
                                totalPayment += item.nominal;
                                tbody += ""+
                                    "<tr>"+
                                        "<td>"+
                                            item.item+  
                                        "</td>"+
                                        "<td>"+
                                            formatRibuan(item.nominal)+
                                        "</td>"+
                                    "</tr>";
                            });
                            tbody += ""+
                                ((row.voucher[0]) ?
                                "<tr>"+
                                    "<td><b>Diskon</b></td>"+
                                    "<td>"+
                                        "<b>"+formatRibuan(row.voucher[0].discount)+"</b>"+
                                    "</td>"+
                                "</tr>"+
                                "<tr>"+
                                    "<td><b>Setelah Diskon</b></td>"+
                                    "<td>"+
                                        "<b>"+formatRibuan(afterDiscount)+"</b>"+
                                    "</td>"+
                                "</tr>" : ""
                                )+
                                "<tr>"+
                                    "<td><b>Total Dibayar</b></td>"+
                                    "<td>"+
                                        "<b>"+formatRibuan(row.nominal)+"</b>"+
                                        ((row.url_bukti_trf) ? " <a target='_blank' class='btn btn-sm btn-info' href='"+row.url_bukti_trf+"'>Bukti Transfer</a>" : "")+
                                    "</td>"+
                                "</tr>";
                                tbody += ""+
                                "<tr>"+
                                    "<td colspan='2'></td>"+
                                "</tr>";
                        });
                        $("#pembayaranItems").html(tbody);
                    }
                }
            });
        }

        $('.confirmDocumentBtn').on('click', function(){
            var document = $(this).data('doc');
            console.log('hai!');
            var data = {
                "_token": "{{ csrf_token() }}",
                'ppdb_id': id,
                'document': document
            };

            sweetAlertAction({
                title: 'Apakah anda yakin?',
                text: 'Mengonfirmasi dokumen tersebut',
                type: 'question',
                withCallback: true,
                callback: function() {
                    ajaxOperation({
                        type: "POST", url: "{{route('ajax.ppdb.confirm-document')}}", data: data,
                        withSuccessMessage: true, successMessage: (data.message || "Success"),
                        reloadWithTimeout: true, reloadTimeout: 1000
                    });
                }
            });

            // Swal.fire({
            //     icon: 'question',
            //     title: 'Apakah anda yakin?',
            //     text: 'Mengonfirmasi dokumen tersebut',
            //     showCancelButton: true,
            //     confirmButtonText: 'Yakin!'
            // }).then((result) => {
            //     if (result.isConfirmed) {
            //         $.ajax({
            //             type: "POST",
            //             url: "{{route('ajax.ppdb.confirm-document')}}",
            //             data: {
            //                 "_token": "{{ csrf_token() }}",
            //                 'ppdb_id': id,
            //                 'document': document
            //             },
            //             success: function (data) {
            //                 showSuccess(data.message || "Success");
            //                 setTimeout(function(){
            //                     location.reload();
            //                 }, 1000);
            //             },
            //             error: function (e) {
            //                 console.log(e);
            //                 $("#btnSubmitDocument").prop("disabled", false);
            //             }
            //         });
            //     }
            // })
        });

        // function confirmDocumentCallback(params) {
        //     ajaxOperation({
        //         type: "POST", url: "{{route('ajax.ppdb.confirm-document')}}", data: params,
        //         withSuccessMessage: true, successMessage: (data.message || "Success"),
        //         reloadWithTimeout: true, reloadTimeout: 1000
        //     });
        // }

        //Submit
        $('#submitPpdbBtn').on('click', function(e){
            e.preventDefault();
            var form = $("#formPpdb");
            
            enableLoadingButton("#submitPpdbBtn");

            var data = {
                "_token": "{{ csrf_token() }}",
                'id' : $('#formPpdb').find('#id').val(),
                'nis' : $('#formPpdb').find('#nis').val(),
                'nisn' : $('#formPpdb').find('#nisn').val(),
                'email' : $('#formPpdb').find('#email').val(),
                'jenis_kelamin' : $('#formPpdb').find('#jenis_kelamin').val(),
                'nama' : $('#formPpdb').find('#nama').val(),
                'nama_ayah' : $('#formPpdb').find('#nama_ayah').val(),
                'nama_ibu' : $('#formPpdb').find('#nama_ibu').val(),
                'nik_siswa' : $('#formPpdb').find('#nik_siswa').val(),
                'nik_ayah' : $('#formPpdb').find('#nik_ayah').val(),
                'nik_ibu' : $('#formPpdb').find('#nik_ibu').val(),
                'hp_siswa' : $('#formPpdb').find('#hp_siswa').val(),
                'hp_ayah' : $('#formPpdb').find('#hp_ayah').val(),
                'hp_ibu' : $('#formPpdb').find('#hp_ibu').val(),
                'telegram_siswa' : $('#formPpdb').find('#telegram_siswa').val(),
                'telegram_ayah' : $('#formPpdb').find('#telegram_ayah').val(),
                'telegram_ibu' : $('#formPpdb').find('#telegram_ibu').val(),
                'tgl_terima' : $('#formPpdb').find('#tgl_terima').val(),
                'kelas_sebelum' : $('#formPpdb').find('#kelas_sebelum').val(),
                'smt_kelas_sebelum' : $('#formPpdb').find('#smt_kelas_sebelum').val(),
                'tipe_kelas_sebelum' : $('#formPpdb').find('#tipe_kelas_sebelum').val(),
                'kelas' : $('#formPpdb').find('#kelas').val(),
                'smt_kelas' : $('#formPpdb').find('#smt_kelas').val(),
                'peminatan' : $('#formPpdb').find('#peminatan').val(),
                'layanan_kelas_id' : $('#formPpdb').find('#layanan_kelas_id').val(),
                'paket_kelas_id' : $('#formPpdb').find('#paket_kelas_id').val(),
                'paket_spp_id' : $('#formPpdb').find('#paket_spp_id').val(),
                'lulusan' : $('#formPpdb').find('#lulusan').val(),
                'tahun_lulus' : $('#formPpdb').find('#tahun_lulus').val(),
                'biaya_daftar' : $('#formPpdb').find('#biaya_daftar').val(),
                'biaya_spp' : $('#formPpdb').find('#biaya_spp').val(),
                'wakaf' : $('#formPpdb').find('#wakaf').val(),
                'password' : $('#formPpdb').find('#password').val(),
                'is_active' : $('#formPpdb').find("#is_active").is(":checked"),
                'is_approved' : $('#formPpdb').find("#is_approved").is(":checked"),

                'bayar_daftar' : $('#formPpdb').find('#bayar_daftar').val(),
                'bayar_spp' : $('#formPpdb').find('#bayar_spp').val(),
                'bayar_wakaf' : $('#formPpdb').find('#bayar_wakaf').val(),
                'bayar_infaq' : $('#formPpdb').find('#bayar_infaq').val(),
                'type' : typeSelected,
            }
            console.log('submit', data);
            $.ajax({
                type: "POST",
                url: "{{empty($id) ? route('ajax.ppdb.create') : route('ajax.ppdb.update')}}",
                data: data,
                success: function(res) {
                    disableLoadingButton("#submitPpdbBtn");
                    if (!res.error) {
                        // showSuccess(res.message || "Success");
                        swalSuccess({text: "Berhasil menyimpan data"});
                    }else{
                        // showError('failed');
                        swalError({text: "Gagal menyimpan data"});
                    }
                },
                error: function(response, textStatus, errorThrown){
                    disableLoadingButton("#submitPpdbBtn");
                    ajaxCallbackError(response);
                }
            });
        });
    });
</script>
@endsection
