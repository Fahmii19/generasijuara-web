@extends('layouts.admin_layout')

@section('content')
<main>
    <header class="page-header page-header-compact page-header-light border-bottom bg-white mb-4">
        <div class="container-fluid px-4">
            <div class="page-header-content">
                <div class="row align-items-center justify-content-between pt-3">
                    <div class="col-auto mb-3">
                        <h1 class="page-header-title">
                            <div class="page-header-icon"><a href="{{route('web.su.raport.list')}}"><i data-feather="arrow-left"></i></a></div>
                            Raport:
                            <label class="btn btn-sm btn-light text-primary" id="kelas_name"></label> |
                            <label class="btn btn-sm btn-light text-primary" id="wb_name"></label>
                        </h1>
                    </div>
                    <div class="col-12 col-xl-auto mb-3">
                        <a class="btn btn-sm btn-light text-primary" target="_blank" href="{{route('web.su.raport.print', ['kelas_wb' => $kwb_id])}}">
                            <i class="me-1" data-feather="file"></i>
                            Cetak PDF
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
                <h2>Ekstrakulikuler</h2>
                <a class="btn btn-sm btn-light text-primary" href="#" id="addEkskul">
                    <i class="me-1" data-feather="plus"></i>
                    Add
                </a>
                <hr>
                <div class="table-responsive">
                    <table class="table table-bordered" id="dtEkskul" width="100%" cellspacing="0">
                    </table>
                </div>
            </div>
        </div>
        <br>
        <div class="card">
            <div class="card-body">
                <h2>Nilai Kegiatan</h2>
                <a class="btn btn-sm btn-light text-primary" href="#" id="addKegiatan">
                    <i class="me-1" data-feather="plus"></i>
                    Add
                </a>
                <hr>
                <div class="table-responsive">
                    <table class="table table-bordered" id="dtKegiatan" width="100%" cellspacing="0">
                    </table>
                </div>
            </div>
        </div>
        <br>
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <h2 class="col-md-6">Penilaian Capaian Dimensi</h2>
                    <div class="col-md-6 d-flex justify-content-end">
                        <button class="btn btn-sm btn-light text-primary" href="#" id="show-penilaian">
                            Show
                        </button>
                    </div>
                </div>
                <hr>
                <table id="dynamic-table" class="font-size-12 d-none" style="width: 95%; border-collapse: collapse; margin-top: 16px; margin-right: 16px; margin-left: 10px;">
                    <!-- Tabel Penilaian -->
                </table>
            </div>
        </div>
        <br>
        <div class="card">
            <div class="card-body">
                <h2>Data Presensi</h2>
                <a class="btn btn-sm btn-light text-primary" href="#" id="editPresensi">
                    <i class="me-1" data-feather="edit"></i>
                    Edit
                </a>
                <hr>
                <div class="table-responsive">
                    <table class="table table-bordered" id="tbPresensi" width="100%" cellspacing="0">
                        <tr>
                            <th width="20%">Izin</th>
                            <td id="izin_detail"></td>
                        </tr>
                        <tr>
                            <th>Sakit</th>
                            <td id="sakit_detail"></td>
                        </tr>
                        <tr>
                            <th>Alpa</th>
                            <td id="alpa_detail"></td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
        <br>
        <div class="card">
            <div class="card-body">
                <h2>Catatan</h2>
                <a class="btn btn-sm btn-light text-primary" href="#" id="editCatatan">
                    <i class="me-1" data-feather="edit"></i>
                    Edit
                </a>
                <hr>
                <div class="table-responsive">
                    <table class="table table-bordered" id="tbCatatan" width="100%" cellspacing="0">
                        <tr class="catatan-rapor-lama">
                            <th width="20%">Catatan Penanggungjawab Rombel </th>
                            <td id="catatan_pj_rombel"></td>
                        </tr>
                        <tr class="catatan-rapor-lama">
                            <th>Tanggapan Orang Tua/Wali</th>
                            <td id="tanggapan_wali"></td>
                        </tr>
                        <tr class="catatan-rapor-lama">
                            <th>Catatan</th>
                            <td id="catatan"></td>
                        </tr>

                        <!-- Catatan Perkembangan -->
                        <tr class="catatan-rapor-merdeka">
                            <th width="20%">Catatan Perkembangan Profil Pelajar Pancasila</th>
                            <td id="catatan_perkembangan_profil_pelajar_detail"></td>
                        </tr>
                        <tr class="catatan-rapor-merdeka">
                            <th>Catatan Perkembangan Pemberdayaan</th>
                            <td id="catatan_perkembangan_pemberdayaan_detail"></td>
                        </tr>
                        <tr class="catatan-rapor-merdeka">
                            <th>Catatan Perkembangan Keterampilan</th>
                            <td id="catatan_perkembangan_keterampilan_detail"></td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>
</main>

<!-- Modal -->
<div class="modal fade" id="modalEkskul" data-bs-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="modalEkskulLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalEkskulLabel">Form</h5>
                <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="formEkskul" method="POST" action="" novalidate>
                    @csrf
                    <div class="mb-3">
                        <label><strong>Data</strong></label>
                    </div>
                    <input class="form-control" id="id" type="hidden" placeholder="">
                    <div class="mb-3">
                        <label for="kegiatan">Kegiatan</label>
                        <input class="form-control" id="kegiatan" type="text" placeholder="">
                    </div>
                    <div class="mb-3">
                        <label for="predikat">Predikat</label>
                        <input class="form-control" id="predikat" type="text" placeholder="">
                    </div>
                    <div class="mb-3">
                        <label for="deskripsi">Deskripsi</label>
                        <textarea class="form-control" id="deskripsi"></textarea>
                    </div>
                </form>
            </div>
            <div class="modal-footer"><button class="btn btn-secondary" type="button" data-bs-dismiss="modal">Close</button><button class="btn btn-primary" type="button" id="submitEkskul">Submit</button></div>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="modalKegiatan" data-bs-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="modalKegiatanLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalKegiatanLabel">Form</h5>
                <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="formKegiatan" method="POST" action="" novalidate>
                    @csrf
                    <div class="mb-3">
                        <label><strong>Data</strong></label>
                    </div>
                    <input class="form-control" id="id" type="hidden" placeholder="">
                    <div class="mb-3">
                        <label for="jenis_kegiatan">Jenis Kegiatan</label>
                        <input class="form-control" id="jenis_kegiatan" type="text" placeholder="">
                    </div>
                    <div class="mb-3">
                        <label for="prestasi">Prestasi</label>
                        <input class="form-control" id="prestasi" type="text" placeholder="">
                    </div>
                </form>
            </div>
            <div class="modal-footer"><button class="btn btn-secondary" type="button" data-bs-dismiss="modal">Close</button><button class="btn btn-primary" type="button" id="submitKegiatan">Submit</button></div>
        </div>
    </div>
</div>

<!-- Modal Edit Data Presensi-->
<div class="modal fade" id="modalPresensi" data-bs-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="modalPresensiLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalPresensiLabel">Form</h5>
                <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="formPresensi" method="POST" action="" novalidate>
                    @csrf
                    <div class="mb-3">
                        <label><strong>Data Presensi</strong></label>
                    </div>
                    <div class="mb-3">
                        <label for="izin">Izin</label>
                        <input type="number" class="form-control" id="izin" ></input>
                    </div>
                    <div class="mb-3">
                        <label for="sakit">Sakit</label>
                        <input type="number" class="form-control" id="sakit" ></input>
                    </div>
                    <div class="mb-3">
                        <label for="alpa">Alpa</label>
                        <input type="number" class="form-control" id="alpa" ></input>
                    </div>
                </form>
            </div>
            <div class="modal-footer"><button class="btn btn-secondary" type="button" data-bs-dismiss="modal">Close</button><button class="btn btn-primary" type="button" id="submitPresensi">Submit</button></div>
        </div>
    </div>
</div>

<!-- Modal Edit Catatan-->
<div class="modal fade" id="modalCatatan" data-bs-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="modalCatatanLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalCatatanLabel">Form</h5>
                <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="formCatatan" method="POST" action="" novalidate>
                    @csrf
                    <div class="mb-3">
                        <label><strong>Data</strong></label>
                    </div>
                    <div class="mb-3 catatan-rapor-lama">
                        <label for="catatan_pj_rombel">Catatan Penanggung Jawab</label>
                        <textarea class="form-control" id="catatan_pj_rombel" ></textarea>
                    </div>
                    <div class="mb-3 catatan-rapor-lama">
                        <label for="tanggapan_wali">Tanggapan Wali</label>
                        <textarea class="form-control" id="tanggapan_wali" ></textarea>
                    </div>
                    <div class="mb-3 catatan-rapor-lama">
                        <label for="catatan">Catatan</label>
                        <textarea class="form-control" id="catatan" ></textarea>
                    </div>

                    <!-- Catatan Perkembangan -->
                    <div class="mb-3 catatan-rapor-merdeka">
                        <label for="catatan_perkembangan_profil_pelajar">Catatan Perkembangan Profil Pelajar Pancasila</label>
                        <textarea class="form-control" id="catatan_perkembangan_profil_pelajar" ></textarea>
                    </div>
                    <div class="mb-3 catatan-rapor-merdeka">
                        <label for="catatan_perkembangan_pemberdayaan">Catatan Perkembangan Pemberdayaan</label>
                        <textarea class="form-control" id="catatan_perkembangan_pemberdayaan" ></textarea>
                    </div>
                    <div class="mb-3 catatan-rapor-merdeka">
                        <label for="catatan_perkembangan_keterampilan">Catatan Perkembangan Keterampilan</label>
                        <textarea class="form-control" id="catatan_perkembangan_keterampilan" ></textarea>
                    </div>
                </form>
            </div>
            <div class="modal-footer"><button class="btn btn-secondary" type="button" data-bs-dismiss="modal">Close</button><button class="btn btn-primary" type="button" id="submitCatatan">Submit</button></div>
        </div>
    </div>
</div>
@stop

@section('style_extra')

@endsection

@section('js_extra')
<script type="text/javascript">
    $(document).ready(function() {
        var dtEkskul = null
        var kwbId = "{{$kwb_id}}";

        fetchKWB();
        function fetchKWB() {
            $.ajax({
                type: "POST",
                url: "{{route('ajax.kelas_wb.get')}}",
                data: {
                    "_token": "{{ csrf_token() }}",
                    'id' : kwbId,
                },
                success: function(res) {
                    if (!res.error) {
                        $('#wb_name').text(res.data.kelas_wb.wb_detail.nama);
                        $('#kelas_name').text(res.data.kelas_wb.kelas_detail.nama);
                        // poin capaian
                        let poin_penilaian = res.data.poin_penilaian;
                        let nilai_poin_penilaian = res.data.nilai_poin_penilaian;
                        let catatan_proses_wb = res.data.catatan_proses_wb;

                                            $('head').append(
                        '<style>' +
                        '.penilaian-radio {' +
                        '   cursor: pointer;' +
                        '   transform: scale(1.3);' +
                        '   margin: 5px;' +
                        '}' +
                        '</style>'
                    );

                       // Iterate through dimension data
                        $.each(poin_penilaian, function(dimensiIndex, dimensi) {
                            // Add row for dimension
                            $('#dynamic-table').append(
                                '<tr>' +
                                    '<td rowspan="2" width="5%" class="text-center" style="padding: 2px; border: 1px solid black;">' + (dimensiIndex + 1) + '</td>' +
                                    '<td rowspan="2" width="65%" class="text-center" style="padding: 2px 10px 2px 2px; border: 1px solid black; font-weight:bold;">' + dimensi.dimensi_name + '</td>' +
                                    '<td width="30%" colspan="4" class="text-center" style="border: 1px solid black; padding: 2px;">Penilaian</td>' +
                                '</tr>' +
                                '<tr>' +
                                    '<td width="7.5%" style="border: 1px solid black; text-align: center; padding: 2px;">MBb</td>' +
                                    '<td width="7.5%" style="border: 1px solid black; text-align: center; padding: 2px;">SB</td>' +
                                    '<td width="7.5%" style="border: 1px solid black; text-align: center; padding: 2px;">BSH</td>' +
                                    '<td width="7.5%" style="border: 1px solid black; text-align: center; padding: 2px;">SAB</td>' +
                                '</tr>'
                            );

                            $.each(dimensi.elemens, function(elemenIndex, elemen) {
                                    var groupName = 'penilaian_' + elemen.id;

                                    // Cari nilai yang sudah tersimpan
                                    var nilaiTersimpan = nilai_poin_penilaian.find(function(item) {
                                        return item.point_id == elemen.id;
                                    });

                                    $('#dynamic-table').append(
                                        `<tr class="font-size-12 text-center" style="font-weight: bold;">
                                            <td width="5%" style="border: 1px solid black; padding-left: 2px;"></td>
                                            <td width="65%" class="text-left" style="border: 1px solid black; padding-left: 2px; font-weight: normal; background: #d6d3d1;">${elemen.elemen_name}</td>
                                            <td width="7.5%" style="border: 1px solid black; text-align: center;">
                                                <input type="radio" name="${groupName}" value="MB" class="penilaian-radio"
                                                    data-point-id="${elemen.id}" ${nilaiTersimpan?.point_nilai == 'MB' ? 'checked' : ''}>
                                            </td>
                                            <td width="7.5%" style="border: 1px solid black; text-align: center;">
                                                <input type="radio" name="${groupName}" value="SB" class="penilaian-radio"
                                                    data-point-id="${elemen.id}" ${nilaiTersimpan?.point_nilai == 'SB' ? 'checked' : ''}>
                                            </td>
                                            <td width="7.5%" style="border: 1px solid black; text-align: center;">
                                                <input type="radio" name="${groupName}" value="BSH" class="penilaian-radio"
                                                    data-point-id="${elemen.id}" ${nilaiTersimpan?.point_nilai == 'BSH' ? 'checked' : ''}>
                                            </td>
                                            <td width="7.5%" style="border: 1px solid black; text-align: center;">
                                                <input type="radio" name="${groupName}" value="SAB" class="penilaian-radio"
                                                    data-point-id="${elemen.id}" ${nilaiTersimpan?.point_nilai == 'SAB' ? 'checked' : ''}>
                                            </td>
                                        </tr>`
                                    );
                                });

                            // Add process notes section
                            $('#dynamic-table').append(
                                '<tr class="font-size-12 text-center" style="font-weight: normal;">' +
                                    '<td width="5%" style="border: 1px solid black; padding-left: 2px;"></td>' +
                                    '<td width="95%" colspan="5" class="text-center" style="border: 1px solid black; padding: 4px 0px 4px 2px;">Catatan Proses</td>' +
                                '</tr>' +
                                '<tr class="font-size-12 text-center" style="font-weight: normal;">' +
                                    '<td width="5%" style="border: 1px solid black; padding-left: 2px;"></td>' +
                                    '<td width="95%" colspan="5" class="text-center" style="border: 1px solid black; padding-left: 2px;">' +
                                        '<textarea rows="4" class="catatan-proses" data-dimensi-id="' + dimensi.id + '" placeholder="Berikan catatan..." style="width: 100%;"></textarea>' +
                                        '<button class="btn btn-sm btn-light text-primary send-button mb-2" type="button">' +
                                            '<i class="me-1" data-feather="plus"></i>' +
                                            'Submit Catatan' +
                                        '</button>' +
                                    '</td>' +
                                '</tr>'
                            );
                        });

                        // check selected radio button
                        $.each(nilai_poin_penilaian, function (index, nilai_point) {
                            let point_id = nilai_point.point_id;

                            let point_nilai = nilai_point.point_nilai;

                            let radioButton = $('input[type=radio][name="poin_penilaian[' + point_id + ']"][data-point-id="' + point_id + '"][value="' + point_nilai + '"]');

                            if (radioButton.length > 0) {
                                if (!radioButton.is(':checked')) {
                                    radioButton.prop('checked', true);
                                }
                            }
                        });

                        $.each(catatan_proses_wb, function (index, cp) {
                            let dimensi_id = cp.dimensi_id;

                            let catatan_proses = cp.catatan_proses;

                            var textarea = $('.catatan-proses[data-dimensi-id="' + dimensi_id + '"]');

                            $(textarea).val(catatan_proses);
                        });

                        // data presensi
                        $('#tbPresensi').find('#izin_detail').text(res.data.kelas_wb.izin);
                        $('#tbPresensi').find('#sakit_detail').text(res.data.kelas_wb.sakit);
                        $('#tbPresensi').find('#alpa_detail').text(res.data.kelas_wb.alpa);

                        if (res.data.kelas_wb.kelas_detail.jenis_rapor == 'lama') {
                            $('.catatan-rapor-merdeka').hide();
                        } else {
                            $('.catatan-rapor-lama').hide();
                        }

                        // catatan rapor lama
                        $('#tbCatatan').find('#catatan_pj_rombel').text(res.data.kelas_wb.catatan_pj_rombel);
                        $('#tbCatatan').find('#tanggapan_wali').text(res.data.kelas_wb.tanggapan_wali);
                        $('#tbCatatan').find('#catatan').text(res.data.kelas_wb.catatan);

                        // catatan rapor merdeka
                        $('#tbCatatan').find('#catatan_perkembangan_profil_pelajar_detail').text(res.data.kelas_wb.catatan_perkembangan_profil_pelajar);
                        $('#tbCatatan').find('#catatan_perkembangan_pemberdayaan_detail').text(res.data.kelas_wb.catatan_perkembangan_pemberdayaan);
                        $('#tbCatatan').find('#catatan_perkembangan_keterampilan_detail').text(res.data.kelas_wb.catatan_perkembangan_keterampilan);

                        $('#formCatatan').find('#catatan_perkembangan_profil_pelajar').text(res.data.kelas_wb.catatan_perkembangan_profil_pelajar);
                        $('#formCatatan').find('#catatan_perkembangan_pemberdayaan').text(res.data.kelas_wb.catatan_perkembangan_pemberdayaan);
                        $('#formCatatan').find('#catatan_perkembangan_keterampilan').text(res.data.kelas_wb.catatan_perkembangan_keterampilan);
                    }else{
                        showError(res.message);
                    }
                },
                error: function (response, xhr, error, thrown) {
                    var res = response.responseJSON;

                    switch (response.status) {
                        case (400 || 422):
                            break
                        default:
                            break
                    }

                    showError(res.message);
                }
            });
        }

        $('#show-penilaian').click(function(){
            $('#dynamic-table').toggleClass('d-none');
            $(this).text(function(i, text){
                return text === "Show" ? "Hide" : "Show";
            });
        });

        $(document).on('click', '.send-button', function() {
            let catatan_proses = $(this).siblings('.catatan-proses').val();
            let dimensi_id = $(this).siblings('.catatan-proses').data('dimensi-id');
            let kelas_wb_id = kwbId;

            let data = {
                "_token": "{{ csrf_token() }}",
                catatan_proses,
                dimensi_id,
                kelas_wb_id
            }


            $.ajax({
                type: "POST",
                url: "{{route('ajax.capaian_dimensi.saveOrUpdateCatatanProses')}}",
                data: data,
                success: function(res) {
                    if (!res.error) {
                        showSuccess("Success");
                    }else{
                        showError(res.message);
                    }
                },
                error: function (response, xhr, error, thrown) {
                    var res = response.responseJSON;

                    switch (response.status) {
                        case (400 || 422):
                            break
                        default:
                            break
                    }

                    showError(res.message);
                }
            });
        });

        // on change poin capaian
        $(document).on('change', '.penilaian-radio', function() {
            let data = {
                "_token": "{{ csrf_token() }}",
                point_id: $(this).data('point-id'),
                kelas_wb_id: kwbId,
                point_nilai: $(this).val()
            };

            $.ajax({
                type: "POST",
                url: "{{route('ajax.capaian_dimensi.saveOrUpdateNilaiWB')}}",
                data: data,
                success: function(res) {
                    if (!res.error) {
                        showSuccess("Nilai tersimpan!");
                    } else {
                        showError(res.message);
                        $(this).prop('checked', false); // Reset jika gagal
                    }
                }
            });
        });
        //
        dtEkskul = $('#dtEkskul').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: "{{route('ajax.dt.ekskul.get')}}",
                dataType: "json",
                "data": function ( d ) {
                    d._token = "{{ csrf_token() }}",
                    d.kwb_id = kwbId
                },
                type: "POST",
            },
            bSort: true,
            searching: true,
            lengthChange: true,
            scrollX: true,
            columns:[
                {
                    "title":"Kegiatan",
                    "width":"12%",
                    "data":"kegiatan"
                },
                {
                    "title":"Predikat",
                    "width":"12%",
                    "data":"predikat"
                },
                {
                    "title":"Deskripsi",
                    "width":"12%",
                    "data":"deskripsi"
                },
                {
                    "title": "Action",
                    "data":null,
                    "width":"15%",
                    "orderable":false,
                    "searchable":false,
                    render: function (data,type, row){
                        return '<a href="#" class="editRowBtn btn btn-sm btn-transparent-dark" data-id="'+row.id+'"><i class="fas fa-edit"></i></a>'+
                        '<a href="#" class="deleteRowBtn btn btn-sm btn-transparent-dark" data-id="'+row.id+'"><i class="fas fa-trash"></i></a>'
                    }
                }
            ],
            order:[[0,'asc']],
            columnDefs:[]
        });

        $('#input-search-table').on('keyup change clear',function() {
            dtEkskul.search($(this).val()).draw()
        })

        $('#dtEkskul').on('click', '.editRowBtn', function() {
            var id = $(this).data('id');

            $('#modalEkskul').modal('show');
            $('#formEkskul').trigger("reset");
            $('#formEkskul').find('#id').val(null);
            $.ajax({
                type: "POST",
                url: "{{route('ajax.ekskul.get')}}",
                data: {
                    'id' : id,
                    "_token": "{{ csrf_token() }}"
                },
                success: function(res) {

                    if (!res.error) {
                        $('#formEkskul').find('#id').val(res.data.kelas_wb.id);
                        $('#formEkskul').find('#kegiatan').val(res.data.kelas_wb.kegiatan);
                        $('#formEkskul').find('#predikat').val(res.data.kelas_wb.predikat);
                        $('#formEkskul').find('#deskripsi').val(res.data.kelas_wb.deskripsi);
                    }
                }
            });
        });

        $('#dtEkskul').on('click', '.deleteRowBtn', function(e){
            e.preventDefault();
            var idSelected = $(this).data('id');
            var rowData =  dtEkskul.row( $(this).parents('tr') ).data();

            var data = {
                "_token": "{{ csrf_token() }}",
                'id' : idSelected,
            }

            sweetAlertAction({
                title: 'Apakah anda yakin?',
                text: 'Data tidak dapat dikembalikan',
                type: 'question',
                withCallback: true,
                callback: function() {
                    ajaxOperation({
                        type: "POST",
                        url: "{{route('ajax.ekskul.delete')}}",
                        data: data,
                        withSweetAlertTimer: true,
                        swalTitle: 'Sukses',
                        swalType: 'success',
                        swalTimer: 2000,
                        swalText: 'Data berhasil dihapus',
                        withReloadTable: true,
                        table: dtEkskul
                    });
                }
            });

            // $.ajax({
            //     type: "POST",
            //     url: "{{route('ajax.ekskul.delete')}}",
            //     data: data,
            //     success: function(res) {
            //         if (!res.error) {
            //             dtEkskul.ajax.reload();
            //         }else{
            //         }
            //     }
            // });
        });

        $('#addEkskul').on('click', function(){
            $('#modalEkskul').modal('show');
            $('#formEkskul').trigger("reset");
            $('#formEkskul').find('#id').val(null);
        });

        $('#submitEkskul').on('click', function(e){
            e.preventDefault();
            var form = $("#formEkskul");
            // if (!checkForm(form)) {
            //     return false;
            // }

            // $('#spinner-toast').modal('show');

            var data = {
                "_token": "{{ csrf_token() }}",
                'id' : $('#formEkskul').find('#id').val(),
                'kegiatan' : $('#formEkskul').find('#kegiatan').val(),
                'predikat' : $('#formEkskul').find('#predikat').val(),
                'deskripsi' : $('#formEkskul').find('#deskripsi').val(),
                'kwb_id' : kwbId,
            }

            $.ajax({
                type: "POST",
                url: "{{route('ajax.ekskul.save')}}",
                data: data,
                success: function(res) {
                    if (!res.error) {
                        $('#modalEkskul').modal('hide');
                        dtEkskul.ajax.reload();
                        showSuccess("Success");
                    }else{
                        showError(res.message);
                    }
                },
                error: function (response, xhr, error, thrown) {
                    var res = response.responseJSON;

                    switch (response.status) {
                        case (400 || 422):
                            break
                        default:
                            break
                    }

                    showError(res.message);
                }
            });
        });

        // nilai kegiatan
        dtKegiatan = $('#dtKegiatan').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: "{{route('ajax.dt.nilai_kegiatan.get')}}",
                dataType: "json",
                "data": function ( d ) {
                    d._token = "{{ csrf_token() }}",
                    d.kwb_id = kwbId
                },
                type: "POST",
            },
            bSort: true,
            searching: true,
            lengthChange: true,
            scrollX: true,
            columns:[
                {
                    "title":"Jenis Kegiatan",
                    "width":"12%",
                    "data":"jenis_kegiatan"
                },
                {
                    "title":"Prestasi",
                    "width":"12%",
                    "data":"prestasi"
                },
                {
                    "title": "Action",
                    "data":null,
                    "width":"15%",
                    "orderable":false,
                    "searchable":false,
                    render: function (data,type, row){
                        return '<a href="#" class="editRowBtn btn btn-sm btn-transparent-dark" data-id="'+row.id+'"><i class="fas fa-edit"></i></a>'+
                        '<a href="#" class="deleteRowBtn btn btn-sm btn-transparent-dark" data-id="'+row.id+'"><i class="fas fa-trash"></i></a>'
                    }
                }
            ],
            order:[[0,'asc']],
            columnDefs:[]
        });

        $('#input-search-table').on('keyup change clear',function() {
            dtKegiatan.search($(this).val()).draw()
        })

        $('#dtKegiatan').on('click', '.editRowBtn', function() {
            var id = $(this).data('id');

            $('#modalKegiatan').modal('show');
            $('#formKegiatan').trigger("reset");
            $('#formKegiatan').find('#id').val(null);
            $.ajax({
                type: "POST",
                url: "{{route('ajax.nilai_kegiatan.get')}}",
                data: {
                    'id' : id,
                    "_token": "{{ csrf_token() }}"
                },
                success: function(res) {

                    if (!res.error) {
                        $('#formKegiatan').find('#id').val(res.data.kelas_wb.id);
                        $('#formKegiatan').find('#jenis_kegiatan').val(res.data.kelas_wb.jenis_kegiatan);
                        $('#formKegiatan').find('#prestasi').val(res.data.kelas_wb.prestasi);
                    }
                }
            });
        });

        $('#dtKegiatan').on('click', '.deleteRowBtn', function(e){
            e.preventDefault();
            var idSelected = $(this).data('id');
            var rowData =  dtKegiatan.row( $(this).parents('tr') ).data();

            var data = {
                "_token": "{{ csrf_token() }}",
                'id' : idSelected,
            }

            sweetAlertAction({
                title: 'Apakah anda yakin?',
                text: 'Data tidak dapat dikembalikan',
                type: 'question',
                withCallback: true,
                callback: function() {
                    ajaxOperation({
                        type: "POST",
                        url: "{{route('ajax.nilai_kegiatan.delete')}}",
                        data: data,
                        withSweetAlertTimer: true,
                        swalTitle: 'Sukses',
                        swalType: 'success',
                        swalTimer: 2000,
                        swalText: 'Data berhasil dihapus',
                        withReloadTable: true,
                        table: dtKegiatan
                    });
                }
            });

            // $.ajax({
            //     type: "POST",
            //     url: "{{route('ajax.nilai_kegiatan.delete')}}",
            //     data: data,
            //     success: function(res) {
            //         if (!res.error) {
            //             dtKegiatan.ajax.reload();
            //         }else{
            //         }
            //     }
            // });
        });

        $('#addKegiatan').on('click', function(){
            $('#modalKegiatan').modal('show');
            $('#formKegiatan').trigger("reset");
            $('#formKegiatan').find('#id').val(null);
        });

        $('#submitKegiatan').on('click', function(e){
            e.preventDefault();
            var form = $("#formKegiatan");
            // if (!checkForm(form)) {
            //     return false;
            // }

            // $('#spinner-toast').modal('show');

            var data = {
                "_token": "{{ csrf_token() }}",
                'id' : $('#formKegiatan').find('#id').val(),
                'kwb_id' : kwbId,
                'jenis_kegiatan' : $('#formKegiatan').find('#jenis_kegiatan').val(),
                'prestasi' : $('#formKegiatan').find('#prestasi').val(),
            }

            $.ajax({
                type: "POST",
                url: "{{route('ajax.nilai_kegiatan.save')}}",
                data: data,
                success: function(res) {
                    if (!res.error) {
                        $('#modalKegiatan').modal('hide');
                        dtKegiatan.ajax.reload();
                        showSuccess("Success");
                    }else{
                        showError(res.message);
                    }
                },
                error: function (response, xhr, error, thrown) {
                    var res = response.responseJSON;

                    switch (response.status) {
                        case (400 || 422):
                            break
                        default:
                            break
                    }

                    showError(res.message);
                }
            });
        });

        $('#editPresensi').on('click', function(){
            $('#modalPresensi').modal('show');
            $('#formPresensi').trigger("reset");

            $.ajax({
                type: "POST",
                url: "{{route('ajax.kelas_wb.get')}}",
                data: {
                    "_token": "{{ csrf_token() }}",
                    'id' : kwbId,
                },
                success: function(res) {
                    if (!res.error) {

                        $('#formPresensi').find('#izin').val(res.data.kelas_wb.izin);
                        $('#formPresensi').find('#sakit').val(res.data.kelas_wb.sakit);
                        $('#formPresensi').find('#alpa').val(res.data.kelas_wb.alpa);
                    }else{
                        showError(res.message);
                    }
                },
                error: function (response, xhr, error, thrown) {
                    var res = response.responseJSON;

                    switch (response.status) {
                        case (400 || 422):
                            break
                        default:
                            break
                    }

                    showError(res.message);
                }
            });
        });

        $('#editCatatan').on('click', function(){
            $('#modalCatatan').modal('show');
            // $('#formCatatan').trigger("reset");

            $.ajax({
                type: "POST",
                url: "{{route('ajax.kelas_wb.get')}}",
                data: {
                    "_token": "{{ csrf_token() }}",
                    'id' : kwbId,
                },
                success: function(res) {
                    if (!res.error) {


                        if (res.data.kelas_wb.kelas_detail.jenis_rapor == 'lama') {
                            $('.catatan-rapor-merdeka').hide();
                        } else {
                            $('.catatan-rapor-lama').hide();
                        }


                        $('#formCatatan').find('#catatan_pj_rombel').val(res.data.kelas_wb.catatan_pj_rombel);
                        $('#formCatatan').find('#tanggapan_wali').val(res.data.tanggapan_wali);
                        $('#formCatatan').find('#catatan').val(res.data.catatan);

                        $('#formCatatan').find('#catatan_perkembangan_profil_pelajar').text(res.data.catatan_perkembangan_profil_pelajar);
                        $('#formCatatan').find('#catatan_perkembangan_pemberdayaan').text(res.data.catatan_perkembangan_pemberdayaan);
                        $('#formCatatan').find('#catatan_perkembangan_keterampilan').text(res.data.catatan_perkembangan_keterampilan);
                    }else{
                        showError(res.message);
                    }
                },
                error: function (response, xhr, error, thrown) {
                    var res = response.responseJSON;

                    switch (response.status) {
                        case (400 || 422):
                            break
                        default:
                            break
                    }

                    showError(res.message);
                }
            });
        });

        $('#submitPresensi').on('click', function(e){
            e.preventDefault();
            var form = $("#formPresensi");
            // if (!checkForm(form)) {
            //     return false;
            // }

            // $('#spinner-toast').modal('show');

            var data = {
                "_token": "{{ csrf_token() }}",
                'id' : kwbId,
                'izin' : $('#formPresensi').find('#izin').val(),
                'sakit' : $('#formPresensi').find('#sakit').val(),
                'alpa' : $('#formPresensi').find('#alpa').val(),
            }

            $.ajax({
                type: "POST",
                url: "{{route('ajax.kelas_wb.update_presensi')}}",
                data: data,
                success: function(res) {
                    if (!res.error) {
                        $('#modalPresensi').modal('hide');
                        fetchKWB();
                        showSuccess("Success");
                    }else{
                        showError(res.message);
                    }
                },
                error: function (response, xhr, error, thrown) {
                    var res = response.responseJSON;

                    switch (response.status) {
                        case (400 || 422):
                            break
                        default:
                            break
                    }

                    showError(res.message);
                }
            });
        });

        $('#submitCatatan').on('click', function(e){
            e.preventDefault();
            var form = $("#formCatatan");
            // if (!checkForm(form)) {
            //     return false;
            // }

            // $('#spinner-toast').modal('show');

            var data = {
                "_token": "{{ csrf_token() }}",
                'id' : kwbId,
                'catatan_pj_rombel' : $('#formCatatan').find('#catatan_pj_rombel').val(),
                'tanggapan_wali' : $('#formCatatan').find('#tanggapan_wali').val(),
                'catatan' : $('#formCatatan').find('#catatan').val(),
                'catatan_perkembangan_profil_pelajar' : $('#formCatatan').find('#catatan_perkembangan_profil_pelajar').val(),
                'catatan_perkembangan_pemberdayaan' : $('#formCatatan').find('#catatan_perkembangan_pemberdayaan').val(),
                'catatan_perkembangan_keterampilan' : $('#formCatatan').find('#catatan_perkembangan_keterampilan').val(),

            }

            $.ajax({
                type: "POST",
                url: "{{route('ajax.kelas_wb.update_catatan')}}",
                data: data,
                success: function(res) {
                    if (!res.error) {
                        $('#modalCatatan').modal('hide');
                        fetchKWB();
                        showSuccess("Success");
                    }else{
                        showError(res.message);
                    }
                },
                error: function (response, xhr, error, thrown) {
                    var res = response.responseJSON;

                    switch (response.status) {
                        case (400 || 422):
                            break
                        default:
                            break
                    }

                    showError(res.message);
                }
            });
        });
    });


    // function to show only one checkbox checked
    function hanyaSatu(groupName, checkbox) {
    const checkboxes = document.getElementsByName(groupName);
    checkboxes.forEach((cb) => {
        if (cb !== checkbox) cb.checked = false;
    });
}
</script>
@endsection
