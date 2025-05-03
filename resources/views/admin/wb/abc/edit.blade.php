@extends('layouts.admin_layout')

@section('content')
    <main>
        <header class="page-header page-header-compact page-header-light border-bottom bg-white mb-4">
            <div class="container-fluid px-4">
                <div class="page-header-content">
                    <div class="row align-items-center justify-content-between pt-3">
                        <div class="col-auto mb-3">
                            <h1 class="page-header-title">
                                <div class="page-header-icon"><a href="#" onclick="goBackWithRefresh();"><i
                                            data-feather="arrow-left"></i></a></div>
                                <span id="page-header-title-text">Edit WB</span>
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
                            <div class="mb-3 col-md-4">
                                <label class="small mb-1" for="nis">NIS <small>(auto generate)</small></label>
                                <input class="form-control" id="nis" type="text" placeholder=""
                                    value="" />
                            </div>
                            <div class="mb-3 col-md-4">
                                <label class="small mb-1" for="nisn">NISN*</label>
                                <input class="form-control" id="nisn" type="text" placeholder="" value="" />
                            </div>
                            <div class="mb-3 col-md-4">
                                <label class="small mb-1" for="email">Email*</label>
                                <input class="form-control" id="email" type="email" placeholder="" value="" />
                            </div>
                            <div class="mb-3 col-md-4">
                                <label class="small mb-1" for="jenis_kelamin">Jenis Kelamin *</label>
                                <select class="form-control" id="jenis_kelamin">
                                    <option value="l">Laki-laki</option>
                                    <option value="p">Perempuan</option>
                                </select>
                            </div>

                            <div class="mb-3 col-md-4">
                                <label class="small mb-1" for="nama">Nama Siswa (sesuai AKTE) *</label>
                                <input class="form-control" id="nama" type="text" placeholder="" value="" />
                            </div>

                            <div class="mb-3 col-md-4">
                                <label class="small mb-1" for="nik_siswa">NIK Siswa (sesuai KK) *</label>
                                <input class="form-control" id="nik_siswa" type="text" placeholder="" value="" />
                            </div>

                            <div class="mb-3 col-md-4">
                                <label class="small mb-1" for="hp_siswa">HP Siswa (WA Aktif)*</label>
                                <input class="form-control" id="hp_siswa" type="text" placeholder="" value="" />
                            </div>

                            <div class="mb-3 col-md-4">
                                <label class="small mb-1" for="telegram_siswa">Telegram Siswa</label>
                                <input class="form-control" id="telegram_siswa" type="text" placeholder=""
                                    value="" />
                            </div>
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

                            <div class="mb-3 col-md-6">
                                <label class="small mb-1" for="satuan_pendidikan_asal">Satuan Pendidikan Asal</label>
                                <input class="form-control" id="satuan_pendidikan_asal" type="text" placeholder=""
                                    value="" />
                            </div>
                            <div class="mb-3 col-md-4">
                                <label class="small mb-1" for="tgl_terima">Tanggal Diterima</label>
                                <input class="form-control" id="tgl_terima" type="date">
                            </div>
                        </div>

                        <div class="row gx-3">
                            <div class="mb-3 col-md-3">
                                <label class="small mb-1" for="tempat_lahir">Tempat Lahir</label>
                                <input class="form-control" id="tempat_lahir" type="text" placeholder=""
                                    value="" />
                            </div>
                            <div class="mb-3 col-md-3">
                                <label class="small mb-1" for="tanggal_lahir">Tanggal Lahir</label>
                                <input class="form-control" id="tanggal_lahir" type="date" placeholder=""
                                    value="" />
                            </div>
                            <div class="mb-3 col-md-3">
                                <label class="small mb-1" for="status_dalam_keluarga">Status Dalam Keluarga</label>
                                <input class="form-control" id="status_dalam_keluarga" type="text" placeholder=""
                                    value="" />
                            </div>
                            <div class="mb-3 col-md-3">
                                <label class="small mb-1" for="anak_ke">Anak Ke</label>
                                <input class="form-control" id="anak_ke" type="text" placeholder=""
                                    value="" />
                            </div>
                        </div>
                        <div class="row gx-3">
                            <div class="mb-3 col-md-3">
                                <label class="small mb-1" for="alamat_peserta_didik">Alamat Peserta Didik</label>
                                <input class="form-control" id="alamat_peserta_didik" type="text" placeholder=""
                                    value="" />
                            </div>
                            <div class="mb-3 col-md-3">
                                <label class="small mb-1" for="alamat_domisili">Alamat Domisili</label>
                                <input class="form-control" id="alamat_domisili" type="text" placeholder=""
                                    value="" />
                            </div>
                            <div class="mb-3 col-md-3">
                                <label class="small mb-1" for="alamat_orang_tua">Alamat Orang Tua</label>
                                <input class="form-control" id="alamat_orang_tua" type="text" placeholder=""
                                    value="" />
                            </div>
                            <div class="mb-3 col-md-3">
                                <label class="small mb-1" for="no_telp_rumah">Nomor Telepon Rumah</label>
                                <input class="form-control" id="no_telp_rumah" type="text" placeholder=""
                                    value="" />
                            </div>
                        </div>

                        <hr>
                        <h1>Ayah</h1>
                        <div class="row gx-3">
                            <div class="mb-3 col-md-4">
                                <label class="small mb-1" for="nama_ayah">Nama Ayah</label>
                                <input class="form-control" id="nama_ayah" type="text" placeholder=""
                                    value="" />
                            </div>
                            <div class="mb-3 col-md-4">
                                <label class="small mb-1" for="nik_ayah">NIK Ayah (sesuai KK) *</label>
                                <input class="form-control" id="nik_ayah" type="text" placeholder=""
                                    value="" />
                            </div>
                            <div class="mb-3 col-md-4">
                                <label class="small mb-1" for="hp_ayah">HP Ayah (WA Aktif)*</label>
                                <input class="form-control" id="hp_ayah" type="text" placeholder=""
                                    value="" />
                            </div>
                            <div class="mb-3 col-md-4">
                                <label class="small mb-1" for="telegram_ayah">Telegram Ayah</label>
                                <input class="form-control" id="telegram_ayah" type="text" placeholder=""
                                    value="" />
                            </div>
                            <div class="mb-3 col-md-4">
                                <label class="small mb-1" for="pekerjaan_ayah">Pekerjaan Ayah</label>
                                <input class="form-control" id="pekerjaan_ayah" type="text" placeholder=""
                                    value="" />
                            </div>
                        </div>

                        <hr>
                        <h1>Ibu</h1>
                        <div class="row gx-3">
                            <div class="mb-3 col-md-4">
                                <label class="small mb-1" for="nama_ibu">Nama Ibu</label>
                                <input class="form-control" id="nama_ibu" type="text" placeholder=""
                                    value="" />
                            </div>
                            <div class="mb-3 col-md-4">
                                <label class="small mb-1" for="nik_ibu">NIK Ibu (sesuai KK) *</label>
                                <input class="form-control" id="nik_ibu" type="text" placeholder=""
                                    value="" />
                            </div>
                            <div class="mb-3 col-md-4">
                                <label class="small mb-1" for="hp_ibu">HP Ibu (WA Aktif)*</label>
                                <input class="form-control" id="hp_ibu" type="text" placeholder=""
                                    value="" />
                            </div>
                            <div class="mb-3 col-md-4">
                                <label class="small mb-1" for="telegram_ibu">Telegram Ibu</label>
                                <input class="form-control" id="telegram_ibu" type="text" placeholder=""
                                    value="" />
                            </div>
                            <div class="mb-3 col-md-4">
                                <label class="small mb-1" for="pekerjaan_ibu">Pekerjaan Ibu</label>
                                <input class="form-control" id="pekerjaan_ibu" type="text" placeholder=""
                                    value="" />
                            </div>
                        </div>

                        <hr>
                        <h1>Wali</h1>
                        <div class="row gx-3">
                            <div class="mb-3 col-md-3">
                                <label class="small mb-1" for="nama_wali">Nama Wali</label>
                                <input class="form-control" id="nama_wali" type="text" placeholder=""
                                    value="" />
                            </div>
                            <div class="mb-3 col-md-3">
                                <label class="small mb-1" for="no_telp_wali">Nomor Telepon Wali</label>
                                <input class="form-control" id="no_telp_wali" type="text" placeholder=""
                                    value="" />
                            </div>
                            <div class="mb-3 col-md-3">
                                <label class="small mb-1" for="alamat_wali">Alamat Wali</label>
                                <input class="form-control" id="alamat_wali" type="text" placeholder=""
                                    value="" />
                            </div>
                            <div class="mb-3 col-md-3">
                                <label class="small mb-1" for="pekerjaan_wali">Pekerjaan Wali</label>
                                <input class="form-control" id="pekerjaan_wali" type="text" placeholder=""
                                    value="" />
                            </div>
                        </div>

                        <hr>
                        <div id="div_dokumen">
                            <h1>Dokumen</h1>
                            <div class="row gx-3">
                                <div class="table-responsive">
                                    <table class="table table-bordered" id="tableDokumen" width="100%"
                                        cellspacing="0">
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
                                                    {{ $data_ppdb->dokumen_ktp_orang_tua != null ? ($data_ppdb->is_ktp_approved == 1 ? 'Terverifikasi' : 'Menunggu Konfirmasi') : 'Belum Upload' }}
                                                </td>
                                                <td class="text-center">
                                                    <a href="{{ $data_ppdb->dokumen_ktp_orang_tua }}" target="_blank"
                                                        class="btn btn-sm btn-light text-primary m-1 {{ $data_ppdb->dokumen_ktp_orang_tua == null ? 'disabled' : '' }}">
                                                        <i class="fas fa-eye"></i>
                                                    </a>
                                                    <button type="button"
                                                        class="btn btn-sm btn-light text-success confirmDocumentBtn m-1 {{ $data_ppdb->dokumen_ktp_orang_tua == null || $data_ppdb->is_ktp_approved == 1 ? 'disabled' : '' }}"
                                                        data-doc="dokumen_ktp_orang_tua"
                                                        data-title="Dokumen KTP Orang Tua">
                                                        <i class="fas fa-check"></i>
                                                    </button>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Scan/Foto Akta Kelahiran</td>
                                                <td>
                                                    {{ $data_ppdb->dokumen_akta_kelahiran != null ? ($data_ppdb->is_akta_approved == 1 ? 'Terverifikasi' : 'Menunggu Konfirmasi') : 'Belum Upload' }}
                                                </td>
                                                <td class="text-center">
                                                    <a href="{{ $data_ppdb->dokumen_akta_kelahiran }}" target="_blank"
                                                        class="btn btn-sm btn-light text-primary m-1 {{ $data_ppdb->dokumen_akta_kelahiran == null ? 'disabled' : '' }}">
                                                        <i class="fas fa-eye"></i>
                                                    </a>
                                                    <button type="button"
                                                        class="btn btn-sm btn-light text-success confirmDocumentBtn m-1 {{ $data_ppdb->dokumen_akta_kelahiran == null || $data_ppdb->is_akta_approved == 1 ? 'disabled' : '' }}"
                                                        data-doc="dokumen_akta_kelahiran"
                                                        data-title="Dokumen Akta Kelahiran">
                                                        <i class="fas fa-check"></i>
                                                    </button>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Scan/Foto SHUN/SKHUN</td>
                                                <td>
                                                    {{ $data_ppdb->dokumen_shun_skhun != null ? ($data_ppdb->is_shun_skhun_approved == 1 ? 'Terverifikasi' : 'Menunggu Konfirmasi') : 'Belum Upload' }}
                                                </td>
                                                <td class="text-center">
                                                    <a href="{{ $data_ppdb->dokumen_shun_skhun }}" target="_blank"
                                                        class="btn btn-sm btn-light text-primary m-1 {{ $data_ppdb->dokumen_shun_skhun == null ? 'disabled' : '' }}">
                                                        <i class="fas fa-eye"></i>
                                                    </a>
                                                    <button type="button"
                                                        class="btn btn-sm btn-light text-success confirmDocumentBtn m-1 {{ $data_ppdb->dokumen_shun_skhun == null || $data_ppdb->is_shun_skhun_approved == 1 ? 'disabled' : '' }}"
                                                        data-doc="dokumen_shun_skhun" data-title="Dokumen SHUN/SKHUN">
                                                        <i class="fas fa-check"></i>
                                                    </button>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Scan/Foto Kartu Keluarga</td>
                                                <td>
                                                    {{ $data_ppdb->dokumen_kartu_keluarga != null ? ($data_ppdb->is_kk_approved == 1 ? 'Terverifikasi' : 'Menunggu Konfirmasi') : 'Belum Upload' }}
                                                </td>
                                                <td class="text-center">
                                                    <a href="{{ $data_ppdb->dokumen_kartu_keluarga }}" target="_blank"
                                                        class="btn btn-sm btn-light text-primary m-1 {{ $data_ppdb->dokumen_kartu_keluarga == null ? 'disabled' : '' }}">
                                                        <i class="fas fa-eye"></i>
                                                    </a>
                                                    <button type="button"
                                                        class="btn btn-sm btn-light text-success confirmDocumentBtn m-1 {{ $data_ppdb->dokumen_kartu_keluarga == null || $data_ppdb->is_kk_approved == 1 ? 'disabled' : '' }}"
                                                        data-doc="dokumen_kartu_keluarga"
                                                        data-title="Dokumen Kartu Keluarga">
                                                        <i class="fas fa-check"></i>
                                                    </button>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Scan/Foto Ijasah</td>
                                                <td>
                                                    {{ $data_ppdb->dokumen_ijasah != null ? ($data_ppdb->is_ijasah_approved == 1 ? 'Terverifikasi' : 'Menunggu Konfirmasi') : 'Belum Upload' }}
                                                </td>
                                                <td class="text-center">
                                                    <a href="{{ $data_ppdb->dokumen_ijasah }}" target="_blank"
                                                        class="btn btn-sm btn-light text-primary m-1 {{ $data_ppdb->dokumen_ijasah == null || $data_ppdb->dokumen_ijasah == 1 ? 'disabled' : '' }}">
                                                        <i class="fas fa-eye"></i>
                                                    </a>
                                                    <button type="button"
                                                        class="btn btn-sm btn-light text-success confirmDocumentBtn m-1 {{ $data_ppdb->dokumen_ijasah == null || $data_ppdb->is_ijasah_approved == 1 ? 'disabled' : '' }}"
                                                        data-doc="dokumen_ijasah" data-title="Dokumen Ijasah">
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

                        <div class="row gx-3">
                            <div class="mb-3 col-md-6">
                                <h1>Foto Warga Belajar</h1>
                                <form id="formFotoWB">
                                    @csrf
                                    <img id="foto_wb_preview" style="height: 200px" src="{{!empty($data_ppdb->url_foto_wb) && $data_ppdb->url_foto_wb != '' ? $data_ppdb->url_foto_wb : asset('images').'/placeholder.png'}}" alt="" class="img-thumbnail">
                                    <br>
                                    <label>
                                        <input type="file" class="d-none" id="foto_warga_belajar" accept="image/png, image/jpg, image/jpeg">
                                        <div class="btn btn-sm btn-primary mt-2">Unggah Foto Warga Belajar</div>
                                    </label>
                                </form>
                            </div>

                            <div class="mb-3 col-md-6">
                                <h1>Kartu Pelajar</h1>
                                <form id="formKartuPelajar">
                                    @csrf

                                    @php
                                        $kartu_pelajar_src = !empty($data_ppdb->url_kartu_pelajar) ? (file_exists(public_path('uploads') . $data_ppdb->url_kartu_pelajar) ? asset('uploads').$data_ppdb->url_kartu_pelajar : asset('images').'/nis.png') : asset('images').'/nis.png';
                                    @endphp

                                    <img id="kartu_pelajar_preview" style="height: 200px" src="{{ $kartu_pelajar_src }}" alt="" class="img-thumbnail">
                                    <br>
                                    <label>
                                        <input type="file" class="d-none" id="kartu_pelajar" accept="image/png, image/jpg, image/jpeg">
                                        <div class="btn btn-sm btn-primary mt-2">Unggah Kartu Pelajar</div>
                                    </label>
                                </form>
                            </div>
                        </div>

                        <hr>

                        <h1>User</h1>

                        <div class="row gx-3">
                            <div class="mb-3 col-md-12">
                                <div class="form-check">
                                    <input class="form-check-input" id="is_active" name="is_active" type="checkbox"
                                        value="">
                                    <label class="form-check-label" for="is_active">Email Verifikasi</label>
                                </div>
                            </div>
                        </div>
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
            let table = null
            let id = "{{ @$id }}";

            var newFotoWBFile = null;
            var newFotoWBSrc = null;
            var oldFotoWBSrc = null;

            let newKartuPelajarFile = null;
            let newKartuPelajarSrc = null;
            let oldKartuPelajarSrc = null;

            if (id != null && id != '') {
                getDetailPPDB();
            }

            function getDetailPPDB() {
                $.ajax({
                    type: "POST",
                    url: "{{ route('ajax.ppdb.get') }}",
                    data: {
                        "_token": "{{ csrf_token() }}",
                        "id": id,
                    },
                    success: function(res) {
                        if (!res.error) {
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
                            $('#formPpdb').find('#tgl_terima').val(res.data.tgl_terima);
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

                            $('#formPpdb').find('#is_active').prop("checked", res.data.is_active);
                        }
                    }
                });
            }

            $('.confirmDocumentBtn').on('click', function() {
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
                            type: "POST",
                            url: "{{ route('ajax.ppdb.confirm-document') }}",
                            data: data,
                            withSuccessMessage: true,
                            successMessage: (data.message || "Success"),
                            reloadWithTimeout: true,
                            reloadTimeout: 1000
                        });
                    }
                });
            });

            $('#foto_warga_belajar').on('click',function(){
                oldFotoWBSrc = $('#foto_wb_preview').attr('src')
                $('#foto_warga_belajar').val('');
            });

            $('#foto_warga_belajar').on('change',function(){
                if(this.files && this.files[0]){
                    newFotoWBFile = this.files[0]
                    newFotoWBSrc = URL.createObjectURL(newFotoWBFile)
                }
                
                sweetAlertAction({
                    title: 'Apakah anda yakin?',
                    text: 'Mengganti foto tersebut',
                    type: 'question',
                    withCallback: true,
                    withCancelCallback: true,
                    callback: function() {
                        $('#formPpdb').find('#foto_wb_preview').attr("src", newFotoWBSrc);

                        var form = $('#formFotoWB');
                        var formData = new FormData(form[0]);
                        formData.append('_token', "{{ csrf_token() }}");
                        formData.append('ppdb_id', id);
                        formData.append('foto_warga_belajar', newFotoWBFile);

                        ajaxOperation({
                            type: "POST",
                            url: "{{route('ajax.ppdb.update_wb_photo')}}",
                            headers: "X-CSRF-TOKEN: {{ csrf_token() }}",
                            cache:false,
                            contentType: false,
                            processData: false,
                            data: formData,
                            withSuccessMessage: true,
                            successMessage: ("Foto warga belajar berhasil diubah"),
                        });
                    },
                    cancelCallback: function() {
                        $('#formPpdb').find('#foto_wb_preview').attr("src", oldFotoWBSrc);
                    }
                });
            });

            // Update Kartu Pelajar
            $('#kartu_pelajar').on('click',function(){
                oldKartuPelajarSrc = $('#kartu_pelajar_preview').attr('src')
                $('#kartu_pelajar').val('');
            });

            $('#kartu_pelajar').on('change',function(){
                if(this.files && this.files[0]){
                    newKartuPelajarFile = this.files[0]
                    newKartuPelajarSrc = URL.createObjectURL(newKartuPelajarFile)
                }
                
                sweetAlertAction({
                    title: 'Update Kartu Pelajar',
                    text: 'Apakah anda yakin ingin mengubah kartu pelajar?',
                    type: 'question',
                    withCallback: true,
                    withCancelCallback: true,
                    callback: function() {
                        $('#formPpdb').find('#kartu_pelajar_preview').attr("src", newKartuPelajarSrc);

                        var form = $('#formKartuPelajar');
                        var formData = new FormData(form[0]);
                        formData.append('_token', "{{ csrf_token() }}");
                        formData.append('ppdb_id', id);
                        formData.append('kartu_pelajar', newKartuPelajarFile);

                        ajaxOperation({
                            type: "POST",
                            url: "{{route('ajax.ppdb.update_student_card')}}",
                            headers: "X-CSRF-TOKEN: {{ csrf_token() }}",
                            cache:false,
                            contentType: false,
                            processData: false,
                            data: formData,
                            withSuccessMessage: true,
                            successMessage: ("Kartu pelajar berhasil diubah"),
                        });
                    },
                    cancelCallback: function() {
                        $('#formPpdb').find('#kartu_pelajar_preview').attr("src", oldKartuPelajarSrc);
                    }
                });
            });

            //Submit
            $('#submitPpdbBtn').on('click', function(e) {
                e.preventDefault();
                var form = $("#formPpdb");

                enableLoadingButton("#submitPpdbBtn");

                var data = {
                    "_token": "{{ csrf_token() }}",
                    'id': $('#formPpdb').find('#id').val(),
                    'nisn': $('#formPpdb').find('#nisn').val(),
                    'nis': $('#formPpdb').find('#nis').val(),
                    'email': $('#formPpdb').find('#email').val(),
                    'jenis_kelamin': $('#formPpdb').find('#jenis_kelamin').val(),
                    'nama': $('#formPpdb').find('#nama').val(),
                    'nama_ayah': $('#formPpdb').find('#nama_ayah').val(),
                    'nama_ibu': $('#formPpdb').find('#nama_ibu').val(),
                    'nik_siswa': $('#formPpdb').find('#nik_siswa').val(),
                    'nik_ayah': $('#formPpdb').find('#nik_ayah').val(),
                    'nik_ibu': $('#formPpdb').find('#nik_ibu').val(),
                    'tempat_lahir': $('#formPpdb').find('#tempat_lahir').val(),
                    'tanggal_lahir': $('#formPpdb').find('#tanggal_lahir').val(),
                    'status_dalam_keluarga': $('#formPpdb').find('#status_dalam_keluarga').val(),
                    'anak_ke': $('#formPpdb').find('#anak_ke').val(),
                    'alamat_peserta_didik': $('#formPpdb').find('#alamat_peserta_didik').val(),
                    'alamat_domisili': $('#formPpdb').find('#alamat_domisili').val(),
                    'alamat_orang_tua': $('#formPpdb').find('#alamat_orang_tua').val(),
                    'no_telp_rumah': $('#formPpdb').find('#no_telp_rumah').val(),
                    'satuan_pendidikan_asal': $('#formPpdb').find('#satuan_pendidikan_asal').val(),
                    'tgl_terima': $('#formPpdb').find('#tgl_terima').val(),
                    'agama': $('#formPpdb').find('#agama').val(),
                    'pekerjaan_ayah': $('#formPpdb').find('#pekerjaan_ayah').val(),
                    'pekerjaan_ibu': $('#formPpdb').find('#pekerjaan_ibu').val(),
                    'hp_siswa': $('#formPpdb').find('#hp_siswa').val(),
                    'hp_ayah': $('#formPpdb').find('#hp_ayah').val(),
                    'hp_ibu': $('#formPpdb').find('#hp_ibu').val(),
                    'telegram_siswa': $('#formPpdb').find('#telegram_siswa').val(),
                    'telegram_ayah': $('#formPpdb').find('#telegram_ayah').val(),
                    'telegram_ibu': $('#formPpdb').find('#telegram_ibu').val(),
                    'nama_wali': $('#formPpdb').find('#nama_wali').val(),
                    'no_telp_wali': $('#formPpdb').find('#no_telp_wali').val(),
                    'alamat_wali': $('#formPpdb').find('#alamat_wali').val(),
                    'pekerjaan_wali': $('#formPpdb').find('#pekerjaan_wali').val(),

                    'is_active': $('#formPpdb').find("#is_active").is(":checked"),
                }

                $.ajax({
                    type: "POST",
                    url: "{{ route('ajax.wb.update') }}",
                    data: data,
                    success: function(res) {
                        disableLoadingButton("#submitPpdbBtn");
                        if (!res.error) {
                            // showSuccess(res.message || "Success");
                            swalSuccess({
                                text: "Berhasil menyimpan data"
                            });
                        } else {
                            // showError('failed');
                            swalError({
                                text: "Gagal menyimpan data"
                            });
                        }
                    },
                    error: function(response, textStatus, errorThrown) {
                        disableLoadingButton("#submitPpdbBtn");
                        ajaxCallbackError(response);
                    }
                });
            });
        });
    </script>
@endsection
