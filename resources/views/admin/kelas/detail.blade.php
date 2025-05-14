@extends('layouts.admin_layout')

@section('content')
<main>
    <header class="page-header page-header-compact page-header-light border-bottom bg-white mb-4">
        <div class="container-fluid px-4">
            <div class="page-header-content">
                <div class="row align-items-center justify-content-between pt-3">
                    <div class="col-auto mb-3">
                        <h1 class="page-header-title">
                            <div class="page-header-icon"><a href="{{route('web.su.kelas.list')}}"><i data-feather="arrow-left"></i></a></div>
                            Kelas: Detail
                        </h1>
                    </div>
                    <div class="col-12 col-xl-auto mb-3">
                        <a class="btn btn-sm btn-light text-primary" href="#" id="addMP">
                            <i class="me-1" data-feather="plus"></i>
                            Add Mata Pelajaran
                        </a>
                        <a class="btn btn-sm btn-light text-primary" href="#" id="addWB">
                            <i class="me-1" data-feather="plus"></i>
                            Add Warga Belajar
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
                <h2>Jenis Rapor</h2>
                <hr>
                <div class="sbp-preview-content">
                    <form id="formJenisRaport" action="" method="POST">
                        @csrf
                        <div class="form-check">
                            <input class="form-check-input" id="rapor-lama" type="radio" name="jenis_rapor" value="lama" />
                            <label class="form-check-label" for="rapor-lama">Rapor Lama</label>
                            <br>
                            <input class="form-check-input" id="rapor-merdeka" type="radio" name="jenis_rapor" value="merdeka" />
                            <label class="form-check-label" for="rapor-merdeka">Rapor Merdeka</label>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <br>

        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="tbKelas" width="100%" cellspacing="0">
                        <tr>
                            <th width="20%">Kode Kelas</th>
                            <td id="kode"></td>
                        </tr>
                        <tr>
                            <th>Nama Kelas</th>
                            <td id="nama"></td>
                        </tr>
                        <tr>
                            <th>Biaya</th>
                            <td id="biaya"></td>
                        </tr>
                        <tr>
                            <th>Kelas</th>
                            <td id="kelas"></td>
                        </tr>
                        <tr>
                            <th>Semester</th>
                            <td id="semester"></td>
                        </tr>
                        <tr>
                            <th>Jurusan</th>
                            <td id="jurusan"></td>
                        </tr>
                        <tr>
                            <th>Status Nilai</th>
                            <td>
                                <span id="status_nilai"></span>
                                <button class="btn btn-sm btn-warning" id="change_status_nilai_btn"></button>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
        <br>
        <div class="card">
            <div class="card-body">
                <h2>Mata Pelajaran</h2>
                <hr>
                <div class="table-responsive">
                    <table class="table table-bordered" id="dtKMP" width="100%" cellspacing="0">
                    </table>
                </div>
            </div>
        </div>
        <br>
        <div class="card">
            <div class="card-body">
                <h2>Warga Belajar</h2>
                <hr>
                <div class="table-responsive">
                    <table class="table table-bordered" id="dtKWB" width="100%" cellspacing="0">
                    </table>
                </div>
            </div>
        </div>
    </div>
</main>

<!-- Modal -->
<div class="modal fade" id="modalKMP" data-bs-backdrop="static" role="dialog" aria-labelledby="modalKMPLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalKMPLabel">Form</h5>
                <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="formKMP" method="POST" action="" novalidate>
                    @csrf
                    <div class="mb-3">
                        <label><strong>Data</strong></label>
                    </div>
                    <input class="form-control" id="id" type="hidden" placeholder="">
                    <div class="mb-3">
                        <label class="mb-1" for="mata_pelajaran_id">Mata Pelajaran</label>
                        <select class="form-control" id="mata_pelajaran_id" style="width: 100%;"></select>
                    </div>
                    <div class="mb-3">
                        <label for="tutor_id">Tutor</label>
                        <select class="form-control" id="tutor_id"></select>
                    </div>
                </form>
            </div>
            <div class="modal-footer"><button class="btn btn-secondary" type="button" data-bs-dismiss="modal">Close</button><button class="btn btn-primary" type="button" id="submitKMP">Submit</button></div>
        </div>
    </div>
</div>


<!-- Modal -->
<div class="modal fade" id="modalKWB" data-bs-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="modalKWBLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalKWBLabel">Form</h5>
                <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="formKWB" method="POST" action="" novalidate>
                    @csrf
                    <div class="mb-3">
                        <label><strong>Data</strong></label>
                    </div>
                    <input class="form-control" id="id" type="hidden" placeholder="">
                    <input type="hidden" name="old_wb_id" id="old_wb_id">
                    <div class="mb-3">
                        <label class="mb-1" for="wb_id">Warga Belajar</label>
                        <select class="form-control" id="wb_id" style="width: 100%;"></select>
                    </div>
                </form>
            </div>
            <div class="modal-footer"><button class="btn btn-secondary" type="button" data-bs-dismiss="modal">Close</button><button class="btn btn-primary" type="button" id="submitKWB">Submit</button></div>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="modalSettingKMP" data-bs-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="modalSettingKMPLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalSettingKMPLabel">Form</h5>
                <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="formSettingKMP" method="POST" action="" novalidate>
                    @csrf
                    <div class="mb-3">
                        <label><strong>Data</strong></label>
                    </div>
                    <input class="form-control" id="kmp_id" type="hidden" placeholder="">

                    <div class="mb-3">
                        <label for="persentase_tm">Persentase Tugas Modul - Pengetahuan</label>
                        <input class="form-control" id="persentase_tm" type="text" placeholder="40">
                    </div>
                    <div class="mb-3">
                        <label for="persentase_um">Persentase Ujian Modul - Pengetahuan</label>
                        <input class="form-control" id="persentase_um" type="text" placeholder="60">
                    </div>
                    <div class="mb-3">
                        <label for="k_persentase_tm">Persentase Tugas Modul - Keterampilan</label>
                        <input class="form-control" id="k_persentase_tm" type="text" placeholder="40">
                    </div>
                    <div class="mb-3">
                        <label for="k_persentase_um">Persentase Ujian Modul - Keterampilan</label>
                        <input class="form-control" id="k_persentase_um" type="text" placeholder="60">
                    </div>
                    <div class="mb-3">
                        <label for="jumlah_modul">Jumlah Modul</label>
                        <input class="form-control" id="jumlah_modul" type="text" placeholder="3">
                    </div>
                    <div class="mb-3">
                        <label for="skk">SKK</label>
                        <input class="form-control" id="skk" type="text" placeholder="2">
                    </div>
                    <div class="mb-3">
                        <label for="kkm">KKM</label>
                        <input class="form-control" id="kkm" type="text" placeholder="70">
                    </div>
                    <div class="mb-3">
                        <div class="form-check">
                            <input class="form-check-input" id="need_nilai_sikap" name="need_nilai_sikap" type="checkbox" value="">
                            <label class="form-check-label" for="need_nilai_sikap">Set Nilai Sikap</label>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer"><button class="btn btn-secondary" type="button" data-bs-dismiss="modal">Close</button><button class="btn btn-primary" type="button" id="submitKMPBtn">Submit</button></div>
        </div>
    </div>
</div>
@stop

@section('style_extra')

<!-- Select2 -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.min.css" rel="stylesheet" />
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@ttskch/select2-bootstrap4-theme@x.x.x/dist/select2-bootstrap4.min.css">

@endsection

@section('js_extra')

<!-- Select2 -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.full.js"></script>

<script type="text/javascript">
    $(document).ready(function() {
        var tableMP = null
        var tableWB = null
        var kelasSelected = "{{$kelas_id}}";
        var layananKelasSelected = null;
        var mpSelected = null;
        var tutorSelected = null;
        var typeSelected = null;

        fetchKelas()
        function fetchKelas() {
            getKelasDetail(kelasSelected, function(output) {
                $('#tbKelas').find('#kode').text(output.kode);
                $('#tbKelas').find('#nama').text(output.nama);
                $('#tbKelas').find('#biaya').text(formatRibuan(output.biaya));
                $('#tbKelas').find('#kelas').text(output.kelas);
                $('#tbKelas').find('#semester').text(output.semester);
                $('#tbKelas').find('#jurusan').text(output.jurusan);
                $('input[name="jenis_rapor"]').filter('[value="' + output.jenis_rapor + '"]').prop('checked', true);

                if (output.is_lock_nilai) {
                    $('#tbKelas').find('#status_nilai').text("Sudah Ditutup");
                    $('#tbKelas').find('#change_status_nilai_btn').text("Buka");
                }else{
                    $('#tbKelas').find('#status_nilai').text("Dibuka");
                    $('#tbKelas').find('#change_status_nilai_btn').text("Tutup");
                }
            });
        }

        $('input[name="jenis_rapor"]').change(function() {
            let jenis_rapor = $(this).val();
            let data = {
                "_token": "{{ csrf_token() }}",
                "id": kelasSelected,
                jenis_rapor: jenis_rapor
            }

            $.ajax({
                type: "POST",
                url: "{{route('ajax.kelas.update_jenis_rapor')}}",
                data: data,
                success: function(res) {
                    if (!res.error) {
                        fetchKelas();
                        showSuccess("Success");
                    }else{
                        swalError({
                            text: res.message
                        });
                    }
                },
                error: function(response, xhr, error, thrown) {
                    let res = response.responseJSON;

                    swalError({
                        text: res.message
                    });
                }
            });
        });

        $('#change_status_nilai_btn').on('click', function() {
            var data = {
                "id": kelasSelected,
                "_token": "{{ csrf_token() }}",
            };
            $.ajax({
                type: "POST",
                url: "{{route('ajax.kelas.update_status_nilai')}}",
                data: data,
                success: function(res) {
                    if (!res.error) {
                        fetchKelas();
                        showSuccess("Success");
                    }else{
                        // showError(res.message);
                        swalError({
                            text: res.message
                        });
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

                    // showError(res.message);
                    swalError({
                        text: res.message
                    });
                }
            });
        });

        // Select2 Mata Pelajaran
        $("#mata_pelajaran_id").select2({
            theme: 'bootstrap4',
            dropdownParent: $("#modalKMP"),
            ajax: {
                url: "{{ route('ajax.mata_pelajaran.get_all') }}",
                dataType: 'json',
                type: "POST",
                delay: 250,
                data: function (params) {
                    return {
                        _token: "{{ csrf_token() }}",
                        keyword: params.term, // search term
                    };
                },
                processResults: function (data, params) {
                    return {
                        results: data.data,
                    };
                },
                cache: true
            },
            placeholder: 'Pilih Mata Pelajaran',
            templateResult: formatMapel,
            templateSelection: formatMapelSelection
        });

        function formatMapel (mapel) {
            if (mapel.loading) {
                return mapel.text;
            }

            var $container = $(
                "<div class='select2-result-mapel clearfix'>" +
                    "<div class='select2-result-mapel'>" +
                        "<div class='select2-result-mapel__nama'></div>" +
                    "</div>" +
                "</div>"
            );

            $container.find(".select2-result-mapel__nama").text(mapel.nama);

            return $container;
        }

        function formatMapelSelection (mapel) {
            return mapel.nama || mapel.text;
        }


        // Select2 Tutor
        $("#tutor_id").select2({
            theme: 'bootstrap4',
            dropdownParent: $("#modalKMP"),
            ajax: {
                url: "{{ route('ajax.tutor.get_by_name') }}",
                dataType: 'json',
                type: "POST",
                delay: 250,
                data: function (params) {
                    return {
                        _token: "{{ csrf_token() }}",
                        keyword: params.term, // search term
                    };
                },
                processResults: function (data, params) {
                    return {
                        results: data.data,
                    };
                },
                cache: true
            },
            placeholder: 'Pilih Tutor',
            templateResult: formatTutor,
            templateSelection: formatTutorSelection
        });

        function formatTutor (tutor) {
            if (tutor.loading) {
                return tutor.text;
            }

            var $container = $(
                "<div class='select2-result-tutor clearfix'>" +
                    "<div class='select2-result-tutor'>" +
                        "<div class='select2-result-tutor__nama'></div>" +
                    "</div>" +
                "</div>"
            );

            $container.find(".select2-result-tutor__nama").text(tutor.name);

            return $container;
        }

        function formatTutorSelection (tutor) {
            return tutor.name || tutor.text;
        }

        // getMataPelajaranOptions(function(output) {
        //     $('#mata_pelajaran_id').html(output);

        //     if (mpSelected != null) {
        //         $('#mata_pelajaran_id').val(mpSelected);
        //     }
        // });

        // getTutorOptions(function(output) {
        //     $('#tutor_id').html(output);

        //     if (tutorSelected != null) {
        //         $('#tutor_id').val(tutorSelected);
        //     }
        // });

        tableMP = $('#dtKMP').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: "{{route('ajax.dt.kelas_mp.get')}}",
                dataType: "json",
                "data": function ( d ) {
                    d._token = "{{ csrf_token() }}",
                    d.kelas_id = kelasSelected
                },
                type: "POST",
            },
            bSort: true,
            searching: true,
            lengthChange: true,
            scrollX: true,
            columns:[
                {
                    "title":"Mata Pelajaran",
                    "width":"12%",
                    "data":"mp_nama",
                    "name": "mp.nama",
                },
                {
                    "title":"Kelompok",
                    "width":"12%",
                    "data":"mp_kelompok",
                    "name": "mp.kelompok",
                },
                {
                    "title":"Tutor",
                    "width":"12%",
                    "data":"t_nama",
                    "name": "ut.name",
                },
                {
                    "title": "Action",
                    "data":null,
                    "width":"15%",
                    "orderable":false,
                    "searchable":false,
                    render: function (data,type, row){

                        // var url_setting = "{{route('web.su.kelas_mp.setting')}}";
                        // return '<a href="'+url_setting+'?id='+row.id+'" class="settingKMPBtn btn btn-sm btn-transparent-dark" data-id="'+row.id+'"><i class="fas fa-cog"></i></a>'+
                        return '<a href="#" class="settingKMPBtn btn btn-sm btn-transparent-dark" data-id="'+row.id+'"><i class="fas fa-cog"></i></a>'+
                        '<a href="#" class="editRowBtn btn btn-sm btn-transparent-dark" data-id="'+row.id+'"><i class="fas fa-edit"></i></a>'+
                        '<a href="#" class="deleteRowBtn btn btn-sm btn-transparent-dark" data-id="'+row.id+'"><i class="fas fa-trash"></i></a>'
                    }
                }
            ],
            order:[[0,'asc']],
            columnDefs:[]
        });

        $('#input-search-table').on('keyup change clear',function() {
            tableMP.search($(this).val()).draw()
        })

        $('#dtKMP').on('click', '.settingKMPBtn', function() {
            var kmpId = $(this).data('id');

            $('#modalSettingKMP').modal('show');
            $('#formSettingKMP').trigger("reset");
            $('#formSettingKMP').find('#id').val(null);
            $('#formSettingKMP').find('#kmp_id').val(kmpId);

            getKMPSettingDetail(kmpId, function(output) {
                $('#formSettingKMP').find('#persentase_tm').val(output?.persentase_tm);
                $('#formSettingKMP').find('#persentase_um').val(output?.persentase_um);
                $('#formSettingKMP').find('#k_persentase_tm').val(output?.k_persentase_tm);
                $('#formSettingKMP').find('#k_persentase_um').val(output?.k_persentase_um);
                $('#formSettingKMP').find('#jumlah_modul').val(output?.jumlah_modul);
                $('#formSettingKMP').find('#skk').val(output?.skk);
                $('#formSettingKMP').find('#kkm').val(output?.kkm);
                if (output?.need_nilai_sikap) {
                    $('#formSettingKMP').find('#need_nilai_sikap').prop('checked', true);
                }else{
                    $('#formSettingKMP').find('#need_nilai_sikap').prop('checked', false);
                }
            })
        })

        $('#dtKMP').on('click', '.editRowBtn', function() {
            var id = $(this).data('id');
            console.log(id);
            $('#modalKMP').modal('show');
            $('#formKMP').trigger("reset");
            $('#formKMP').find('#id').val(null);
            $.ajax({
                type: "POST",
                url: "{{route('ajax.kelas_mp.get')}}",
                data: {
                    'id' : id,
                    "_token": "{{ csrf_token() }}"
                },
                success: function(res) {
                    // console.log(res)
                    if (!res.error) {
                        var $optionKMP = $("<option selected></option>")
                            .val(res.data.mata_pelajaran_id)
                            .text(res.data.mata_pelajaran_detail.nama);
                        var $optionTutor = $("<option selected></option>")
                            .val(res.data.tutor_id)
                            .text(res.data.tutor_detail.user_detail.name);

                        $('#formKMP').find('#id').val(res.data.id);
                        $('#formKMP').find('#mata_pelajaran_id').append($optionKMP).trigger('change');
                        $('#formKMP').find('#tutor_id').append($optionTutor).trigger('change');

                        // $('#formKMP').find('#mata_pelajaran_id').val(res.data.mata_pelajaran_id).trigger('change');
                        // $('#formKMP').find('#tutor_id').val(res.data.tutor_id).trigger('change')
                    }
                }
            });
        });

        $('#dtKMP').on('click', '.deleteRowBtn', function(e){
            e.preventDefault();
            var idSelected = $(this).data('id');
            var rowData =  tableMP.row( $(this).parents('tr') ).data();

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
                        url: "{{route('ajax.kelas_mp.delete')}}",
                        data: data,
                        withSweetAlertTimer: true,
                        swalTitle: 'Sukses',
                        swalType: 'success',
                        swalTimer: 2000,
                        swalText: 'Data berhasil dihapus',
                        withReloadTable: true,
                        table: tableMP
                    });
                }
            });

            // $.ajax({
            //     type: "POST",
            //     url: "{{route('ajax.kelas_mp.delete')}}",
            //     data: data,
            //     success: function(res) {
            //         if (!res.error) {
            //             tableMP.ajax.reload();
            //         }else{
            //         }
            //     }
            // });

            // var url = ""
            // var route = "ajax.branch.delete"
            // var params = {
            //     "_token": "{{ csrf_token() }}",
            //     'id' : idSelected
            // }
            // var successCallback = () => {
            //     table.ajax.reload(null,false);
            // }

            // confirmDeleteElement(rowData.region_code, url, route, params, successCallback)
        });

        $('#addMP').on('click', function(){
            $('#formKMP').trigger("reset");
            $('#formKMP').find('#id').val(null);
            $('#formKMP').find('#mata_pelajaran_id').val('').trigger('change');
            $('#formKMP').find('#tutor_id').val('').trigger('change');
            $('#modalKMP').modal('show');
        });

        $('#submitKMP').on('click', function(e){
            e.preventDefault();
            var form = $("#formKMP");
            // if (!checkForm(form)) {
            //     return false;
            // }

            // $('#spinner-toast').modal('show');

            var data = {
                "_token": "{{ csrf_token() }}",
                'id' : $('#formKMP').find('#id').val(),
                'mata_pelajaran_id' : $('#formKMP').find('#mata_pelajaran_id').val(),
                'tutor_id' : $('#formKMP').find('#tutor_id').val(),
                'kelas_id' : kelasSelected,
            }
            console.log('submit', data);
            $.ajax({
                type: "POST",
                url: "{{route('ajax.kelas_mp.save')}}",
                data: data,
                success: function(res) {
                    if (!res.error) {
                        $('#modalKMP').modal('hide');
                        swalSuccess({
                            text: 'Data berhasil disimpan',
                            withConfirmButton: true,
                            withReloadTable: true,
                            table: tableMP
                        })
                        // showSuccess("Success");
                    }else{
                        // showError(res.message);
                        swalError({
                            text: res.message
                        })
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

                    // showError(res.message);
                    swalError({
                        text: res.message
                    });
                }
            });
        });

        $('#submitKMPBtn').on('click', function(e){
            e.preventDefault();
            var form = $("#formSettingKMP");
            // if (!checkForm(form)) {
            //     return false;
            // }

            // $('#spinner-toast').modal('show');

            var data = {
                "_token": "{{ csrf_token() }}",
                'kmp_id' : $('#formSettingKMP').find('#kmp_id').val(),
                'persentase_tm' : $('#formSettingKMP').find("#persentase_tm").val(),
                'persentase_um' : $('#formSettingKMP').find("#persentase_um").val(),
                'k_persentase_tm' : $('#formSettingKMP').find("#k_persentase_tm").val(),
                'k_persentase_um' : $('#formSettingKMP').find("#k_persentase_um").val(),
                'jumlah_modul' : $('#formSettingKMP').find("#jumlah_modul").val(),
                'kkm' : $('#formSettingKMP').find("#kkm").val(),
                'skk' : $('#formSettingKMP').find("#skk").val(),
                'need_nilai_sikap' : $('#formSettingKMP').find("#need_nilai_sikap").is(":checked"),
            }

            console.log('submit', data);

            $.ajax({
                type: "POST",
                url: "{{route('ajax.kmp_setting.save')}}",
                data: data,
                success: function(res) {
                    if (!res.error) {
                        $('#modalSettingKMP').modal('hide');
                        // showSuccess("Success");
                        swalSuccess({
                            text: 'Mata pelajaran berhasil disimpan',
                            withConfirmButton: true
                        })
                    }else{
                        // showError(res.message);
                        swalError({
                            text: res.message
                        })
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

                    // showError(res.message);
                    swalError({
                        text: res.message
                    });
                }
            });
        });

        // Select2 Warga Belajar
        $("#wb_id").select2({
            theme: 'bootstrap4',
            dropdownParent: $("#modalKWB"),
            ajax: {
                url: "{{ route('ajax.ppdb.get_all') }}",
                dataType: 'json',
                type: "POST",
                delay: 250,
                data: function (params) {
                    return {
                        _token: "{{ csrf_token() }}",
                        nama: params.term, // search term
                    };
                },
                processResults: function (data, params) {
                    return {
                        results: data.data,
                    };
                },
                cache: true
            },
            placeholder: 'Pilih Warga Belajar',
            minimumInputLength: 2, // Jika tidak ada minimum input akan crash
            templateResult: formatWB,
            templateSelection: formatWBSelection
        });

        function formatWB (wb) {
            if (wb.loading) {
                return wb.text;
            }

            var $container = $(
                "<div class='select2-result-wb clearfix'>" +
                    "<div class='select2-result-wb'>" +
                        "<div class='select2-result-wb__nama'></div>" +
                    "</div>" +
                "</div>"
            );

            $container.find(".select2-result-wb__nama").text(wb.nama);

            return $container;
        }

        function formatWBSelection (wb) {
            return wb.nama || wb.text;
        }

        // wb
        // getWBOptions(function(output) {
        //     $('#wb_id').html(output);
        // });

        tableWB = $('#dtKWB').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: "{{route('ajax.dt.kelas_wb.get')}}",
                dataType: "json",
                "data": function ( d ) {
                    d._token = "{{ csrf_token() }}",
                    d.kelas_id = kelasSelected
                },
                type: "POST",
            },
            bSort: true,
            searching: true,
            lengthChange: true,
            scrollX: true,
            columns:[
                {
                    "title":"WB",
                    "width":"12%",
                    "data":"ppdb_nama",
                    "name":"ppdb.nama"
                },
                {
                    "title":"NIS",
                    "width":"12%",
                    "data":"ppdb_nis",
                    "name":"ppdb.nis"
                },
                {
                    "title":"NISN",
                    "width":"12%",
                    "data":"ppdb_nisn",
                    "name":"ppdb.nisn",
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
            table.search($(this).val()).draw();
        })

        $('#dtKWB').on('click', '.editRowBtn', function(){
            var id = $(this).data('id');
            console.log(id);
            $('#modalKWB').modal('show');
            $('#formKWB').trigger("reset");
            $('#formKWB').find('#id').val(null);
            $.ajax({
                type: "POST",
                url: "{{route('ajax.kelas_wb.get')}}",
                data: {
                    'id' : id,
                    "_token": "{{ csrf_token() }}"
                },
                success: function(res) {
                    // console.log(res)
                    if (!res.error) {
                        var $optionWB = $("<option selected></option>")
                            .val(res.data.id)
                            .text(res.data.wb_detail.nama);

                        $('#formKWB').find('#id').val(res.data.id);
                        $('#formKWB').find('#old_wb_id').val(res.data.wb_id);
                        $('#formKWB').find('#wb_id').append($optionWB).trigger('change');

                        // $('#formKWB').find('#wb_id').val(res.data.wb_id);
                    }
                }
            });
        });

        $('#dtKWB').on('click', '.deleteRowBtn', function(e){
            e.preventDefault();
            var idSelected = $(this).data('id');
            var rowData =  tableWB.row( $(this).parents('tr') ).data();

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
                        url: "{{route('ajax.kelas_wb.delete')}}",
                        data: data,
                        withSweetAlertTimer: true,
                        swalTitle: 'Sukses',
                        swalType: 'success',
                        swalTimer: 2000,
                        swalText: 'Data berhasil dihapus',
                        withReloadTable: true,
                        table: tableWB
                    });
                }
            });

            // $.ajax({
            //     type: "POST",
            //     url: "{{route('ajax.kelas_wb.delete')}}",
            //     data: data,
            //     success: function(res) {
            //         if (!res.error) {
            //             tableWB.ajax.reload();
            //         }else{
            //         }
            //     }
            // });
        });

        $('#addWB').on('click', function(){
            $('#formKWB').trigger("reset");
            $('#formKWB').find('#id').val(null);
            $('#formKWB').find('#wb_id').val('').trigger('change');
            $('#modalKWB').modal('show');
        });

        $('#submitKWB').on('click', function(e){
            e.preventDefault();
            var form = $("#formKWB");
            // if (!checkForm(form)) {
            //     return false;
            // }

            // $('#spinner-toast').modal('show');

            var data = {
                "_token": "{{ csrf_token() }}",
                'id' : $('#formKWB').find('#id').val(),
                'old_wb_id' : $('#formKWB').find('#old_wb_id').val(),
                'wb_id' : $('#formKWB').find('#wb_id').val(),
                'kelas_id' : kelasSelected,
            }
            console.log('submit', data);
            $.ajax({
                type: "POST",
                url: "{{route('ajax.kelas_wb.save')}}",
                data: data,
                success: function(res) {
                    if (!res.error) {
                        $('#modalKWB').modal('hide');
                        swalSuccess({
                            text: 'Data berhasil disimpan',
                            withConfirmButton: true,
                            withReloadTable: true,
                            table: tableWB
                        })
                        // showSuccess("Success");
                    }else{
                        // showError(res.message);
                        swalError({
                            text: res.message
                        })
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

                    // showError(res.message);
                    swalError({
                        text: res.message
                    });
                }
            });
        });
    });

    // Select2 search autofocus
    $(document).on('select2:open', () => {
        document.querySelector('.select2-search__field').focus();
    });


</script>
@endsection
