@extends('layouts.admin_layout')

@section('content')
<main>
    <header class="page-header page-header-compact page-header-light border-bottom bg-white mb-4">
        <div class="container-fluid px-4">
            <div class="page-header-content">
                <div class="row align-items-center justify-content-between pt-3">
                    <div class="col-auto mb-3">
                        <h1 class="page-header-title">
                            <div class="page-header-icon"><i data-feather="list"></i></div>
                            Tahun Akademik
                        </h1>
                    </div>
                    <div class="col-12 col-xl-auto mb-3">
                        <!-- <a class="btn btn-sm btn-light text-primary" href="#" id="addTahun">
                            <i class="me-1" data-feather="plus"></i>
                            Add
                        </a> -->
                    </div>
                </div>
            </div>
        </div>
    </header>
    <!-- Main page content-->
    <div class="container-fluid px-4">
        <div class="card">
            <div class="card-body">
                <table class="table table-bordered" id="dtTahun" width="100%" cellspacing="0">
                </table>
            </div>
        </div>
    </div>
</main>

<!-- Modal -->
<div class="modal fade" id="modalTahun" data-bs-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="modalTahunLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalTahunLabel">Form</h5>
                <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="formTahun" method="POST" action="" novalidate>
                    @csrf
                    <div class="mb-3">
                        <label><strong>Data</strong></label>
                    </div>
                    <input class="form-control" id="id" type="hidden" placeholder="">
                    <div class="mb-3">
                        <label for="kode">Kode</label>
                        <input readonly="readonly" class="form-control" id="kode" type="text" placeholder="20201">
                    </div>
                    <div class="mb-3">
                        <label for="tahun_ajar">Tahun Ajar</label>
                        <input readonly="readonly" class="form-control" id="tahun_ajar" type="text" placeholder="2020/2021">
                    </div>
                    <div class="mb-3">
                        <label for="keterangan">Keterangan</label>
                        <input class="form-control" id="keterangan" type="text" placeholder="Semester 1">
                    </div>
                    <div class="mb-3">
                        <label for="periode_start">Periode Start</label>
                        <input class="form-control" id="periode_start" type="date">
                    </div>
                    <div class="mb-3">
                        <label for="periode_end">Periode End</label>
                        <input class="form-control" id="periode_end" type="date">
                    </div>
                    <div class="mb-3">
                        <label for="tgl_cover_raport">Tanggal Cover Raport</label>
                        <input class="form-control" id="tgl_cover_raport" type="date">
                    </div>
                    <div class="mb-3">
                        <label for="tgl_raport">Tanggal Raport</label>
                        <input class="form-control" id="tgl_raport" type="date">
                    </div>
                    <div class="mb-3">
                        <div class="form-check">
                            <input class="form-check-input" id="is_active" name="is_active" type="checkbox" value="">
                            <label class="form-check-label" for="is_active">Set Aktif</label>
                            <div id="is_active_error" class="invalid-feedback">
                                Untuk mengaktifkan harus generate rombel terlebih dahulu
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary" type="button" data-bs-dismiss="modal">Close</button>
                <button class="btn btn-primary" type="button" id="submitTahun">Submit</button>
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
        table = $('#dtTahun').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: "{{route('ajax.dt.tahun_akademik.get')}}",
                dataType: "json",
                "data": function ( d ) {
                    d._token = "{{ csrf_token() }}"
                },
                type: "POST",
            },
            bSort: true,
            searching: true,
            lengthChange: true,
            scrollX: true,
            columns:[
                {
                    "title":"Kode",
                    "width":"12%",
                    "data":"kode"
                },
                {
                    "title":"Tahun Ajar",
                    "width":"12%",
                    "data":"tahun_ajar"
                },
                {
                    "title":"Keterangan",
                    "width":"12%",
                    "data":"keterangan"
                },
                {
                    "title":"Periode Start",
                    "width":"12%",
                    "data":"periode_start"
                },
                {
                    "title":"Periode End",
                    "width":"12%",
                    "data":"periode_end"
                },
                {
                    "title":"Tanggal Raport",
                    "width":"12%",
                    "data":"tgl_raport",
                    render: function(data, type, row, meta) {
                        if(data == null) {
                            return '-';
                        } else {
                            return data;
                        }
                    }
                },
                {
                    "title":"Status",
                    "width":"12%",
                    "data":"is_active",
                    render: function (data, type, row) {
                        if (data) {
                            return '<span class="badge bg-green-soft text-green">Aktif</span>';
                        }else{
                            return '<span class="badge bg-yellow-soft text-yellow">Tidak Aktif</span>';
                        }
                    }
                },
                {
                    "title":"Status Rombel",
                    "width":"12%",
                    "data":"is_generate_rombel",
                    "render": function(data, type, row, meta) {
                        if (data == 1) {
                            return '<span class="badge bg-green-soft text-green">Sudah Generate</span>';
                        } else {
                            return '<span class="badge bg-yellow-soft text-yellow">Belum Generate</span>';
                        }
                    }
                },
                {
                    "title": "Action",
                    "data":null,
                    "width":"15%",
                    "style":"text-center",
                    "orderable":false,
                    "searchable":false,
                    render: function (data,type, row){
                        var action = '';
                        // '<a href="#" class="tahunDeleteBtn btn-transparent-dark btn btn-sm" data-id="'+row.id+'"><i class="fas fa-trash"></i></a>'
                        action += '<a href="#" class="tahunEditBtn btn-transparent-dark btn btn-sm" data-id="'+row.id+'"><i class="fas fa-edit"></i></a>';
                        if (row.is_valid_to_generate) {
                            action += '<br>';
                            action += '<button class="btn-success btn btn-sm btnDuplicateRombel" data-id="'+row.id+'" data-kode="'+row.kode+'" data-thn_ajar = "'+row.tahun_ajar+'">Generate Rombel</button>'
                        }
                        return action;
                    }
                }
            ],
            order:[[0,'desc']],
            columnDefs:[]
        });
        
        $('#input-search-table').on( 'keyup change clear',function() {
            table
                // .columns(2)
                .search( $(this).val())
                .draw()
        })

        // $('#dtTahun').on('click', '.importSAPBtn', function(){
        //     var id = $(this).data('id');
        //     $('#importModal').modal('show');
        //     $('#import_region_id').val(id);
        // });

        $('#dtTahun').on('click', '.tahunEditBtn', function(){
            var id = $(this).data('id');
            console.log(id);
            $('#modalTahun').modal('show');
            $('#formTahun').trigger("reset");
            $('#formTahun').find('#id').val(null);
            $.ajax({
                type: "POST",
                url: "{{route('ajax.tahun_akademik.get')}}",
                data: {
                    'id' : id,
                    "_token": "{{ csrf_token() }}"
                },
                success: function(res) {
                    console.log(res)
                    if (!res.error) {
                        $('#formTahun').find('#id').val(res.data.id);
                        $('#formTahun').find('#kode').val(res.data.kode);
                        $('#formTahun').find('#tahun_ajar').val(res.data.tahun_ajar);
                        $('#formTahun').find('#keterangan').val(res.data.keterangan);
                        $('#formTahun').find('#periode_start').val(res.data.periode_start);
                        $('#formTahun').find('#periode_end').val(res.data.periode_end);
                        $('#formTahun').find('#tgl_cover_raport').val(res.data.tgl_cover_raport);
                        $('#formTahun').find('#tgl_raport').val(res.data.tgl_raport);
                        $('#formTahun').find('#is_active').prop('checked', res.data.is_active);
                        if (res.data.is_generate_rombel == false) {
                            $('#formTahun').find('#is_active').attr('disabled', true);
                            $('#formTahun').find('#is_active').addClass('is-invalid');
                        } else {
                            $('#formTahun').find('#is_active').attr('disabled', false);
                            $('#formTahun').find('#is_active').removeClass('is-invalid');
                        }
                    }
                }
            });
        });

        $('#dtTahun').on('click', '.btnDuplicateRombel', function(){
            var id = $(this).data('id');
            var kode = $(this).data('kode');
            var tahun_ajar = $(this).data('thn_ajar');
            // console.log(id + " - " + kode + " - " + tahun_ajar);

            Swal.fire({
                icon: 'question',
                title: 'Apakah anda yakin?',
                text: 'Proses tersebut hanya dapat dilakukan satu kali',
                showCancelButton: true,
                confirmButtonText: 'Yakin!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        type: "POST",
                        url: "{{route('ajax.tahun_akademik.duplicate_kelas')}}",
                        data: {
                            "_token": "{{ csrf_token() }}",
                            'id' : id,
                            'kode' : kode,
                            'tahun_ajar' : tahun_ajar
                        },
                        success: function(res) {
                            console.log(res)
                            if (!res.error) {
                                // showSuccess("Rombel berhasil di duplikat");
                                // table.ajax.reload();
                                swalSuccess({
                                    text: 'Rombel berhasil di duplikat',
                                    withConfirmButton: true,
                                    withReloadTable: true,
                                    table: table
                                })
                            } else {
                                swalError({text: 'Rombel gagal di duplikat'});
                            }
                        },
                        error: function (response, xhr, error, thrown) {
                            var res = response.responseJSON;
                            swalError({text: 'Rombel gagal di duplikat'});
                        }
                    });
                }
            })
        });

        $('#dtTahun').on('click', '.tahunDeleteBtn', function(e){
            e.preventDefault();

            if (!confirmDefault()) return false;
            
            var idSelected = $(this).data('id');
            var rowData =  table.row( $(this).parents('tr') ).data();

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
                        url: "{{route('ajax.tahun_akademik.delete')}}",
                        data: data,
                        withSweetAlertTimer: true,
                        swalTitle: 'Sukses',
                        swalType: 'success',
                        swalTimer: 2000,
                        swalText: 'Data berhasil dihapus',
                        withReloadTable: true,
                        table: table
                    });
                }
            });

            // $.ajax({
            //     type: "POST",
            //     url: "{{route('ajax.tahun_akademik.delete')}}",
            //     data: data,
            //     success: function(res) {
            //         if (!res.error) {
            //             table.ajax.reload();
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

        $('#addTahun').on('click', function(){
            $('#modalTahun').modal('show');
            $('#formTahun').trigger("reset");
            $('#formTahun').find('#id').val(null);
        });

        //Submit Call
        $('#submitTahun').on('click', function(e){
            e.preventDefault();
            var form = $("#formTahun");
            enableLoadingButton("#submitTahun");
            // if (!checkForm(form)) {
            //     return false;
            // }

            // $('#spinner-toast').modal('show');

            var data = {
                "_token": "{{ csrf_token() }}",
                'id' : $('#formTahun').find('#id').val(),
                'kode' : $('#formTahun').find('#kode').val(),
                'tahun_ajar' : $('#formTahun').find('#tahun_ajar').val(),
                'keterangan' : $('#formTahun').find('#keterangan').val(),
                'periode_start' : $('#formTahun').find('#periode_start').val(),
                'periode_end' : $('#formTahun').find('#periode_end').val(),
                'tgl_cover_raport' : $('#formTahun').find('#tgl_cover_raport').val(),
                'tgl_raport' : $('#formTahun').find('#tgl_raport').val(),
                'is_active' : $('#formTahun').find("#is_active").is(":checked"),
            }
            console.log('submit', data);
            $.ajax({
                type: "POST",
                url: "{{route('ajax.tahun_akademik.save')}}",
                data: data,
                success: function(res) {
                    console.log(res);
                    disableLoadingButton("#submitTahun");
                    // $('#spinner-toast').modal('hide');

                    if (!res.error) {
                        $('#modalTahun').modal('hide');
                        // showSuccess("Data berhasil disimpan");
                        // table.ajax.reload();
                        swalSuccess({
                            text: 'Data berhasil disimpan',
                            withConfirmButton: true,
                            withReloadTable: true,
                            table: table
                        })
                    }else{
                        // showError(res.message);
                        swalError({text: res.message});
                    }
                },
                error: function (response, xhr, error, thrown) {
                    var res = response.responseJSON;
                    disableLoadingButton("#submitTahun");

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
</script>

@endsection
