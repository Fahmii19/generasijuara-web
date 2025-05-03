@extends('layouts.admin_layout')

@section('content')
<main>
    <header class="page-header page-header-compact page-header-light border-bottom bg-white mb-4">
        <div class="container-fluid px-4">
            <div class="page-header-content">
                <div class="row align-items-center justify-content-between pt-3">
                    <div class="col-auto mb-3">
                        <h1 class="page-header-title">
                            <div class="page-header-icon"><i data-feather="user"></i></div>
                            Profile
                        </h1>
                    </div>
                    <div class="col-12 col-xl-auto mb-3">
                        <a class="btn btn-sm btn-light text-primary" href="#" id="changePasswordBtn">
                            <i class="me-1" data-feather="key"></i>
                            Change Password
                        </a>
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
                            <label class="small mb-1" for="nis">NIS</label>
                            <input readonly="readonly" class="form-control" id="nis" type="text" placeholder="" value="" />
                        </div>
                        <div class="mb-3 col-md-3">
                            <label class="small mb-1" for="nisn">NISN</label>
                            <input readonly="readonly" class="form-control" id="nisn" type="text" placeholder="" value="" />
                        </div>
                        <div class="mb-3 col-md-3">
                            <label class="small mb-1" for="email">Email*</label>
                            <input readonly="readonly" class="form-control" id="email" type="email" placeholder="" value="" />
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
                        <div class="mb-3 col-md-3">
                            <label class="small mb-1" for="tempat_lahir">Tempat Lahir</label>
                            <input class="form-control" id="tempat_lahir" type="text" placeholder="" value="" />
                        </div>
                        <div class="mb-3 col-md-3">
                            <label class="small mb-1" for="tanggal_lahir">Tanggal Lahir</label>
                            <input class="form-control" id="tanggal_lahir" type="date" placeholder="" value="" />
                        </div>
                        <div class="mb-3 col-md-3">
                            <label class="small mb-1" for="status_dalam_keluarga">Status Dalam Keluarga</label>
                            <input class="form-control" id="status_dalam_keluarga" type="text" placeholder="" value="" />
                        </div>
                        <div class="mb-3 col-md-3">
                            <label class="small mb-1" for="anak_ke">Anak Ke</label>
                            <input class="form-control" id="anak_ke" type="text" placeholder="" value="" />
                        </div>
                    </div>
                    <div class="row gx-3">
                        <div class="mb-3 col-md-3">
                            <label class="small mb-1" for="alamat_peserta_didik">Alamat Peserta Didik</label>
                            <input class="form-control" id="alamat_peserta_didik" type="text" placeholder="" value="" />
                        </div>
                        <div class="mb-3 col-md-3">
                            <label class="small mb-1" for="alamat_domisili">Alamat Domisili</label>
                            <input class="form-control" id="alamat_domisili" type="text" placeholder="" value="" />
                        </div>
                        <div class="mb-3 col-md-3">
                            <label class="small mb-1" for="alamat_orang_tua">Alamat Orang Tua</label>
                            <input class="form-control" id="alamat_orang_tua" type="text" placeholder="" value="" />
                        </div>
                        <div class="mb-3 col-md-3">
                            <label class="small mb-1" for="no_telp_rumah">Nomor Telepon Rumah</label>
                            <input class="form-control" id="no_telp_rumah" type="text" placeholder="" value="" />
                        </div>
                    </div>
                    <div class="row gx-3">
                        <div class="mb-3 col-md-4">
                            <label class="small mb-1" for="agama">Agama</label>
                            <select name="agama" id="agama" class="form-control">
                                <option value="">-- Pilih --</option>
                                <option value="islam">Islam</option>
                                <option value="kristen">Kristen</option>
                                <option value="katolik">Katolik</option>
                                <option value="hindu">Hindu</option>
                                <option value="budha">Budha</option>
                                <option value="konghucu">Konghucu</option>
                            </select>
                        </div>
                        <div class="mb-3 col-md-4">
                            <label class="small mb-1" for="pekerjaan_ayah">Pekerjaan Ayah</label>
                            <input class="form-control" id="pekerjaan_ayah" type="text" placeholder="" value="" />
                        </div>
                        <div class="mb-3 col-md-4">
                            <label class="small mb-1" for="pekerjaan_ibu">Pekerjaan Ibu</label>
                            <input class="form-control" id="pekerjaan_ibu" type="text" placeholder="" value="" />
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
                        <div class="mb-3 col-md-3">
                            <label class="small mb-1" for="nama_wali">Nama Wali</label>
                            <input class="form-control" id="nama_wali" type="text" placeholder="" value="" />
                        </div>
                        <div class="mb-3 col-md-3">
                            <label class="small mb-1" for="no_telp_wali">Nomor Telepon Wali</label>
                            <input class="form-control" id="no_telp_wali" type="text" placeholder="" value="" />
                        </div>
                        <div class="mb-3 col-md-3">
                            <label class="small mb-1" for="alamat_wali">Alamat Wali</label>
                            <input class="form-control" id="alamat_wali" type="text" placeholder="" value="" />
                        </div>
                        <div class="mb-3 col-md-3">
                            <label class="small mb-1" for="pekerjaan_wali">Pekerjaan Wali</label>
                            <input class="form-control" id="pekerjaan_wali" type="text" placeholder="" value="" />
                        </div>
                        <div class="mb-3 col-md-6">
                            <label class="small mb-1" for="satuan_pendidikan_asal">Satuan Pendidikan Asal</label>
                            <input class="form-control" id="satuan_pendidikan_asal" type="text" placeholder="" value="" />
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

                    <div id="div_dokumen">
                        <hr>
                        <h1>Dokumen</h1>
                        <div class="row gx-3">
                            <table class="table table-bordered" id="tableDokumen" width="100%" cellspacing="0">
                                <thead>
                                    <tr>
                                       <th width="55%">Item</th> 
                                       <th width="25%">Status</th>
                                       <th width="20%">Action</th> 
                                    </tr>
                                </thead>
                                <tbody id="dokumenItems">
                                    <tr>
                                        <td>KTP Orang Tua</td>
                                        <td>
                                            {{($data_ppdb->dokumen_ktp_orang_tua != null) ? (($data_ppdb->is_ktp_approved == 1) ? 'Terverifikasi' : 'Menunggu Konfirmasi') : 'Belum Upload'}}
                                        </td>
                                        <td>
                                            <a href="{{$data_ppdb->dokumen_ktp_orang_tua}}" target="_blank"
                                                class="btn btn-sm btn-light text-primary m-1 {{($data_ppdb->dokumen_ktp_orang_tua == null) ? 'disabled' : ''}}">
                                                Preview
                                            </a>
                                            <button type="button" class="btn btn-sm btn-light text-success updateDocumentBtn m-1"
                                                data-doc="dokumen_ktp_orang_tua"
                                                data-title="Dokumen KTP Orang Tua">
                                                Update
                                            </button>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Scan/Foto Akta Kelahiran</td>
                                        <td>
                                            {{($data_ppdb->dokumen_akta_kelahiran != null) ? (($data_ppdb->is_akta_approved == 1) ? 'Terverifikasi' : 'Menunggu Konfirmasi') : 'Belum Upload'}}
                                        </td>
                                        <td>
                                            <a href="{{$data_ppdb->dokumen_akta_kelahiran}}" target="_blank"
                                                class="btn btn-sm btn-light text-primary m-1 {{($data_ppdb->dokumen_akta_kelahiran == null) ? 'disabled' : ''}}">
                                                Preview
                                            </a>
                                            <button type="button" class="btn btn-sm btn-light text-success updateDocumentBtn m-1"
                                                data-doc="dokumen_akta_kelahiran"
                                                data-title="Dokumen Akta Kelahiran">
                                                Update
                                            </button>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Scan/Foto SHUN/SKHUN</td>
                                        <td>
                                            {{($data_ppdb->dokumen_shun_skhun != null) ? (($data_ppdb->is_shun_skhun_approved == 1) ? 'Terverifikasi' : 'Menunggu Konfirmasi') : 'Belum Upload'}}
                                        </td>
                                        <td>
                                            <a href="{{$data_ppdb->dokumen_shun_skhun}}" target="_blank"
                                                class="btn btn-sm btn-light text-primary m-1 {{($data_ppdb->dokumen_shun_skhun == null) ? 'disabled' : ''}}">
                                                Preview
                                            </a>
                                            <button type="button" class="btn btn-sm btn-light text-success updateDocumentBtn m-1"
                                                data-doc="dokumen_shun_skhun"
                                                data-title="Dokumen SHUN/SKHUN">
                                                Update
                                            </button>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Scan/Foto Kartu Keluarga</td>
                                        <td>
                                            {{($data_ppdb->dokumen_kartu_keluarga != null) ? (($data_ppdb->is_kk_approved == 1) ? 'Terverifikasi' : 'Menunggu Konfirmasi') : 'Belum Upload'}}
                                        </td>
                                        <td>
                                            <a href="{{$data_ppdb->dokumen_kartu_keluarga}}" target="_blank"
                                                class="btn btn-sm btn-light text-primary m-1 {{($data_ppdb->dokumen_kartu_keluarga == null) ? 'disabled' : ''}}">
                                                Preview
                                            </a>
                                            <button type="button" class="btn btn-sm btn-light text-success updateDocumentBtn m-1"
                                                data-doc="dokumen_kartu_keluarga"
                                                data-title="Dokumen Kartu Keluarga">
                                                Update
                                            </button>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Scan/Foto Ijasah</td>
                                        <td>
                                            {{($data_ppdb->dokumen_ijasah != null) ? (($data_ppdb->is_ijasah_approved == 1) ? 'Terverifikasi' : 'Menunggu Konfirmasi') : 'Belum Upload'}}
                                        </td>
                                        <td>
                                            <a href="{{$data_ppdb->dokumen_ijasah}}" target="_blank"
                                                class="btn btn-sm btn-light text-primary m-1 {{($data_ppdb->dokumen_ijasah == null) ? 'disabled' : ''}}">
                                                Preview
                                            </a>
                                            <button type="button" class="btn btn-sm btn-light text-success updateDocumentBtn m-1"
                                                data-doc="dokumen_ijasah"
                                                data-title="Dokumen Ijasah">
                                                Update
                                            </button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <hr class="my-4" />
                    <div class="d-flex justify-content-between">
                        <button class="btn btn-primary" type="button" id="submitPpdbBtn">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</main>

<!-- Modal -->
<div class="modal fade" id="modalPwd" data-bs-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="modalPwdLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalPwdLabel">Change Password</h5>
                <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="formPwd" method="POST" action="" novalidate>
                    @csrf
                    <div class="mb-3">
                        <label for="password">New Password</label>
                        <input class="form-control" id="password" type="text" placeholder="">
                    </div>
                </form>
            </div>
            <div class="modal-footer"><button class="btn btn-secondary" type="button" data-bs-dismiss="modal">Close</button><button class="btn btn-primary" type="button" id="submitPwd">Submit</button></div>
        </div>
    </div>
</div>

<!-- Modal Upload Dokumen -->
<div class="modal fade" id="modalDocument" data-bs-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="modalDocumentLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalDocumentLabel">Update Dokumen</h5>
                <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="formDocument" novalidate>
                    @csrf
                    <input type="hidden" name="ppdb_id" value="{{$data_ppdb->id}}">
                    <div class="mb-3">
                        <label id="labelUpdateDocument" for="fileDocument" class="form-label"></label>
                        <input class="form-control" type="file" id="fileDocument" name="" accept="image/png, image/jpg, image/jpeg, application/pdf">
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary" type="button" data-bs-dismiss="modal">Close</button>
                <button class="btn btn-primary" type="button" id="btnSubmitDocument">Submit</button>
            </div>
        </div>
    </div>
</div>

@stop

@section('style_extra')

@endsection

@section('js_extra')

<script type="text/javascript">
    $(document).ready(function() {
        var table = null
        var layananKelasSelected = null;
        var paketKelasSelected = null;
        var paketSppSelected = null;
        var permintaanSelected = null;
        var kelasSelected = null;
        var smtSelected = null;
        var userId = "{{@$id}}";

        resetForm();

        function resetForm() {
            $('#formPpdb').trigger("reset");
            $("#div_smt_kelas_sebelum").show();
            $("#div_tipe_kelas_sebelum").show();
            // newBuktiTfFile = null;
            // newBuktiTfSrc = null;
            // $('#formPpdb').find('#bukti_tf_preview').attr("src", "{{asset('images')}}/placeholder.png");
        }

        $('#changePasswordBtn').on('click', function(){
            $('#modalPwd').modal('show');
            $('#formPwd').trigger("reset");
        });

        $('.updateDocumentBtn').on('click', function(){
            var document = $(this).data('doc');
            $('#labelUpdateDocument').text($(this).data('title'));
            $('#fileDocument').attr('name', document);

            $('#modalDocument').modal('show');
        });

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

        $('#submitPwd').on('click', function(e){
            e.preventDefault();
            var form = $("#formPwd");

            var data = {
                "_token": "{{ csrf_token() }}",
                'password' : $('#formPwd').find('#password').val(),
            }

            console.log('submit', data);
            $.ajax({
                type: "POST",
                url: "{{route('ajax.siab.profile.change_password')}}",
                data: data,
                success: function(res) {
                    console.log(res);

                    if (!res.error) {
                        
                        showSuccess(res.message || "Success");
                        $('#modalPwd').modal('hide');
                    }else{
                        
                        showError('failed');
                    }
                },
                error: function(response, textStatus, errorThrown){
                    // disableLoadingButton("#submitTutorBtn");
                    ajaxCallbackError(response);
                }
            });
        });

        fetchPaketSpp();
        function fetchPaketSpp(){
            const paramSpp = {
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

        $('#div_konfirmasi_pembayaran').hide();
        getDetailPPDB();
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
        


        function getDetailPPDB() {
            $.ajax({
                type: "POST",
                url: "{{route('ajax.ppdb.get')}}",
                data: {
                    "_token": "{{ csrf_token() }}",
                    "user_id": userId,
                },
                success: function(res) {
                    console.log(res);
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
                        $('#formPpdb').find('#tanggal_lahir').val(res.data.tanggal_lahir);
                        $('#formPpdb').find('#tempat_lahir').val(res.data.tempat_lahir);
                        $('#formPpdb').find('#status_dalam_keluarga').val(res.data.status_dalam_keluarga);
                        $('#formPpdb').find('#anak_ke').val(res.data.anak_ke);
                        $('#formPpdb').find('#alamat_peserta_didik').val(res.data.alamat_peserta_didik);
                        $('#formPpdb').find('#alamat_domisili').val(res.data.alamat_domisili);
                        $('#formPpdb').find('#alamat_orang_tua').val(res.data.alamat_orang_tua);
                        $('#formPpdb').find('#no_telp_rumah').val(res.data.no_telp_rumah);
                        $('#formPpdb').find('#satuan_pendidikan_asal').val(res.data.satuan_pendidikan_asal);
                        $('#formPpdb').find('#agama').val(res.data.agama);
                        $('#formPpdb').find('#pekerjaan_ayah').val(res.data.pekerjaan_ayah);
                        $('#formPpdb').find('#pekerjaan_ibu').val(res.data.pekerjaan_ibu);
                        $('#formPpdb').find('#hp_siswa').val(res.data.hp_siswa);
                        $('#formPpdb').find('#hp_ayah').val(res.data.hp_ayah);
                        $('#formPpdb').find('#hp_ibu').val(res.data.hp_ibu);
                        $('#formPpdb').find('#telegram_siswa').val(res.data.telegram_siswa);
                        $('#formPpdb').find('#telegram_ayah').val(res.data.telegram_ayah);
                        $('#formPpdb').find('#telegram_ibu').val(res.data.telegram_ibu);
                        $('#formPpdb').find('#nama_wali').val(res.data.nama_wali);
                        $('#formPpdb').find('#no_telp_wali').val(res.data.no_telp_wali);
                        $('#formPpdb').find('#alamat_wali').val(res.data.alamat_wali);
                        $('#formPpdb').find('#pekerjaan_wali').val(res.data.pekerjaan_wali);
                        $('#formPpdb').find('#kelas_sebelum').val(res.data.kelas_sebelum);
                        $('#formPpdb').find('#smt_kelas_sebelum').val(res.data.smt_kelas_sebelum);
                        $('#formPpdb').find('#tipe_kelas_sebelum').val(res.data.tipe_kelas_sebelum);
                        $('#formPpdb').find('#kelas').val(res.data.kelas);
                        $('#formPpdb').find('#smt_kelas').val(res.data.smt_kelas);
                        $('#formPpdb').find('#lulusan').val(res.data.lulusan);
                        $('#formPpdb').find('#tahun_lulus').val(res.data.tahun_lulus);
                        $('#formPpdb').find('#biaya_daftar').val(res.data.biaya_daftar);
                        $('#formPpdb').find('#biaya_spp').val(res.data.biaya_spp);
                        $('#formPpdb').find('#wakaf').val(res.data.wakaf);
                        $('#formPpdb').find('#is_active').prop("checked", res.data.is_active);
                        $('#formPpdb').find('#is_approved').prop("checked", res.data.is_approved);

                        layananKelasSelected = res.data.layanan_kelas_id;
                        $('#formPpdb').find('#layanan_kelas_id').val(layananKelasSelected);
                        
                        paketKelasSelected = res.data.paket_kelas_id;
                        $('#formPpdb').find('#paket_kelas_id').val(paketKelasSelected);
                        
                        paketSppSelected = res.data.paket_spp_id;
                        $('#formPpdb').find('#paket_spp_id').val(paketSppSelected);

                        permintaanSelected = res.data.peminatan;
                        $('#formPpdb').find('#peminatan').val(permintaanSelected);

                        // // pembayaran
                        // $('#formPpdb').find('#wakaf').val(res.data.wakaf);
                    }
                }
            });
        }

        // Upload Dokumen
        $("#btnSubmitDocument").click(function (event) {
            event.preventDefault();
            var form = $('#formDocument')[0];
            var data = new FormData(form);

            $("#btnSubmitDocument").prop("disabled", true);

            $.ajax({
                type: "POST",
                enctype: 'multipart/form-data',
                url: "{{route('ajax.ppdb.upload-document')}}",
                data: data,
                processData: false,
                contentType: false,
                cache: false,
                timeout: 600000,
                success: function (data) {
                    // showSuccess(data.message || "Success");
                    swalSuccess({
                        text: 'Dokumen berhasil disimpan',
                        timer: 2000,
                        withReloadPage: true
                    });
                    $("#btnSubmitDocument").prop("disabled", false);

                    // setTimeout(function(){
                    //     location.reload();
                    // }, 1000);
                },
                error: function (e) {
                    console.log(e);
                    $("#btnSubmitDocument").prop("disabled", false);
                }
            });
        });

        //Submit
        $('#submitPpdbBtn').on('click', function(e){
            e.preventDefault();
            var form = $("#formPpdb");
            
            enableLoadingButton("#submitPpdbBtn");

            var data = {
                "_token": "{{ csrf_token() }}",
                'id' : $('#formPpdb').find('#id').val(),
                'jenis_kelamin' : $('#formPpdb').find('#jenis_kelamin').val(),
                'nama' : $('#formPpdb').find('#nama').val(),
                'nama_ayah' : $('#formPpdb').find('#nama_ayah').val(),
                'nama_ibu' : $('#formPpdb').find('#nama_ibu').val(),
                'nik_siswa' : $('#formPpdb').find('#nik_siswa').val(),
                'nik_ayah' : $('#formPpdb').find('#nik_ayah').val(),
                'nik_ibu' : $('#formPpdb').find('#nik_ibu').val(),
                'tempat_lahir' : $('#formPpdb').find('#tempat_lahir').val(),
                'tanggal_lahir' : $('#formPpdb').find('#tanggal_lahir').val(),
                'status_dalam_keluarga' : $('#formPpdb').find('#status_dalam_keluarga').val(),
                'anak_ke' : $('#formPpdb').find('#anak_ke').val(),
                'alamat_peserta_didik' : $('#formPpdb').find('#alamat_peserta_didik').val(),
                'alamat_domisili' : $('#formPpdb').find('#alamat_domisili').val(),
                'alamat_orang_tua' : $('#formPpdb').find('#alamat_orang_tua').val(),
                'no_telp_rumah' : $('#formPpdb').find('#no_telp_rumah').val(),
                'satuan_pendidikan_asal' : $('#formPpdb').find('#satuan_pendidikan_asal').val(),
                'agama' : $('#formPpdb').find('#agama').val(),
                'pekerjaan_ayah' : $('#formPpdb').find('#pekerjaan_ayah').val(),
                'pekerjaan_ibu' : $('#formPpdb').find('#pekerjaan_ibu').val(),
                'hp_siswa' : $('#formPpdb').find('#hp_siswa').val(),
                'hp_ayah' : $('#formPpdb').find('#hp_ayah').val(),
                'hp_ibu' : $('#formPpdb').find('#hp_ibu').val(),
                'telegram_siswa' : $('#formPpdb').find('#telegram_siswa').val(),
                'telegram_ayah' : $('#formPpdb').find('#telegram_ayah').val(),
                'telegram_ibu' : $('#formPpdb').find('#telegram_ibu').val(),
                'nama_wali' : $('#formPpdb').find('#nama_wali').val(),
                'no_telp_wali' : $('#formPpdb').find('#no_telp_wali').val(),
                'alamat_wali' : $('#formPpdb').find('#alamat_wali').val(),
                'pekerjaan_wali' : $('#formPpdb').find('#pekerjaan_wali').val(),
            }

            console.log('submit', data);
            $.ajax({
                type: "POST",
                url: "{{route('ajax.siab.profile.update')}}",
                data: data,
                success: function(res) {
                    disableLoadingButton("#submitPpdbBtn");
                    if (!res.error) {
                        // showSuccess(res.message || "Success");
                        swalSuccess({text: 'Data berhasil disimpan'});
                        getDetailPPDB();
                    }else{
                        // showError('failed');
                        swalError('Data gagal disimpan');
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
