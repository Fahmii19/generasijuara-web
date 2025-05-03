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
                            Poin Capaian Dimensi
                        </h1>
                    </div>
                    <div class="col-12 col-xl-auto mb-3">
                        <a class="btn btn-sm btn-light text-primary" href="#" id="addCapaianDimensiBtn">
                            <i class="me-1" data-feather="plus"></i>
                            Add
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
                <div class="table-responsive">
                    <table class="table table-bordered" id="dtCapaianDimensi" width="100%" cellspacing="0">
                    </table>
                </div>
            </div>
        </div>
    </div>
</main>

<div class="modal fade" id="modalCapaianDimensi" data-bs-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="modalCapaianDimensiLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalCapaianDimensiLabel">Form</h5>
                <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="formCapaianDimensi" method="POST" action="" novalidate>
                    @csrf
                    <div class="mb-3">
                        <label><strong>Data</strong></label>
                    </div>
                    <div class="mb-3">
                        <select class="form-control" id="fase" name="fase">
                            <option value="a">A</option>
                            <option value="b">B</option>
                            <option value="c">C</option>
                            <option value="d">D</option>
                            <option value="e">E</option>
                            <option value="f">F</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="dimensi_id">Nama Dimensi</label>
                        <select class="form-control" id="dimensi_id" name="dimensi_id">
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="elemen_id">Nama Elemen</label>
                        <select class="form-control" id="elemen_id" name="elemen_id">
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="point_name">Poin Dimensi</label>
                        <input class="form-control" id="point_name" type="text" placeholder="" name="point_name">
                    </div>
                </form>
            </div>
            <div class="modal-footer"><button class="btn btn-secondary" type="button" data-bs-dismiss="modal">Close</button><button class="btn btn-primary" type="button" id="submitCapaianDimensiBtn">Submit</button></div>
        </div>
    </div>
</div>

<div class="modal fade" id="modalEditCapaianDimensi" data-bs-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="modalEditCapaianDimensiLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalEditCapaianDimensiLabel">Form</h5>
                <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="formEditCapaianDimensi" method="POST" action="" novalidate>
                    @csrf
                    <input class="form-control" id="id" name="id" type="hidden" placeholder="">
                    <div class="mb-3">
                        <label><strong>Data</strong></label>
                    </div>
                    <div class="mb-3">
                        <select class="form-control" id="faseEdit" name="faseEdit">
                            <option value="a">A</option>
                            <option value="b">B</option>
                            <option value="c">C</option>
                            <option value="d">D</option>
                            <option value="e">E</option>
                            <option value="f">F</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="dimensi_id_edit">Nama Dimensi</label>
                        <select class="form-control" id="dimensi_id_edit" name="dimensi_id_edit">
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="elemen_id_edit">Nama Elemen</label>
                        <select class="form-control" id="elemen_id_edit" name="elemen_id_edit">
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="point_name_edit">Poin Dimensi</label>
                        <input class="form-control" id="point_name_edit" type="text" placeholder="" name="point_name_edit">
                    </div>
                </form>
            </div>
            <div class="modal-footer"><button class="btn btn-secondary" type="button" data-bs-dismiss="modal">Close</button><button class="btn btn-primary" type="button" id="submitEditCapaianDimensiBtn">Submit</button></div>
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
    $(document).ready(function () {
        table = $('#dtCapaianDimensi').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: "{{route('ajax.dt.capaian_dimensi.get')}}",
                dataType: "json",
                "data": function(d) {
                    d._token = "{{ csrf_token() }}"
                },
                type: "POST",
            },
            bSort: true,
            searching: true,
            lengthChange: true,
            scrollX: true,
            columns: [
                {
                    "title": "Fase",
                    "width": "5%",
                    "data": "fase",
                    render: function(data, type, row) {
                        return data.toUpperCase();
                    }
                },
                {
                    "title": "Nama Dimensi",
                    "width": "20%",
                    "data": "dimensi_name",
                },
                {
                    "title": "Nama Elemen",
                    "width": "20%",
                    "data": "elemen_name",
                },
                {
                    "title": "Poin Dimensi",
                    "width": "40%",
                    "data": "point_name",
                },
                {
                    "title": "Action",
                    "data": null,
                    "width": "15%",
                    "orderable": false,
                    "searchable": false,
                    render: function(data, type, row) {
                        return '<a href="#" class="capaianEditBtn btn btn-sm btn-transparent-dark" data-point_edit_id="' + row.point_id + '"><i class="fas fa-edit"></i></a>' + 
                        '<a href="#" class="capaianDeleteBtn btn-transparent-dark btn btn-sm" data-point_delete_id="'+row.point_id+'"><i class="fas fa-trash"></i></a>';
                    }
                }
            ],
            order: [
                [0, 'asc']
            ],
            columnDefs: []
        });

        $('#dtCapaianDimensi').on('click', '.capaianDeleteBtn', function(e){
            e.preventDefault();
            var data = {
                "_token": "{{ csrf_token() }}",
                'id' : $(this).data('point_delete_id'),
            }
            // console.log(data.id)
            sweetAlertAction({
                title: 'Apakah anda yakin?',
                text: 'Data tidak dapat dikembalikan',
                type: 'question',
                withCallback: true,
                callback: function() {
                    ajaxOperation({
                        type: "POST",
                        url: "{{route('ajax.capaian_dimensi.delete')}}",
                        data: data,
                        withSuccessMessage: true,
                        successMessage: 'Data berhasil dihapus',
                        withReloadTable: true,
                        table: table
                    });
                }
            });
        });

        $('#dtCapaianDimensi').on('click', '.capaianEditBtn', function(){
            var dataEdit = {
                "_token": "{{ csrf_token() }}",
                'id' : $(this).data('point_edit_id'),
            }
            $('#modalEditCapaianDimensi').modal('show');
            $('#formEditCapaianDimensi').trigger("reset");
            $('#formEditCapaianDimensi #id').val(dataEdit.id);

            $.ajax({
                type: "POST",
                url: "{{route('ajax.capaian_dimensi.getDimensi')}}",
                data: dataEdit,
                success: function (res) {
                    $('#dimensi_id_edit').empty();
                    let dimensi = res.data.dimensi
                    
                    $.each(dimensi, function(index, row) {
                        $('#dimensi_id_edit').append('<option value="' + row.id + '">' + row.dimensi_name + '</option>');
                    });
                }
            });

            $.ajax({
                type: "POST",
                url: "{{route('ajax.capaian_dimensi.getPoint')}}",
                data: dataEdit,
                success: function (res) {
                    console.log(res)
                    $('#dimensi_id_edit').val(res.data.dimensi.id);

                    var data = {
                        "_token": "{{ csrf_token() }}",
                        "dimensi_id": res.data.dimensi.id
                    }

                    $.ajax({
                        type: "POST",
                        url: "{{route('ajax.capaian_dimensi.getElemen')}}",
                        data: data,
                        success: function (res) {
                            $('#elemen_id_edit').empty();
                            let elemen = res.data.elemen
                            
                            $.each(elemen, function(index, row) {
                                $('#elemen_id_edit').append('<option value="' + row.id + '">' + row.elemen_name + '</option>');
                            });
                        }
                    });

                    $('#faseEdit').val(res.data.fase);
                    $('#point_name_edit').val(res.data.point.point_name);
                }
            });
        });

        $('#addCapaianDimensiBtn').on('click', function(){
            $('#modalCapaianDimensi').modal('show');
            $('#formCapaianDimensi').trigger("reset");
            var data = {
                "_token": "{{ csrf_token() }}",
            }

            $.ajax({
                type: "POST",
                url: "{{route('ajax.capaian_dimensi.getDimensi')}}",
                data: data,
                success: function (res) {
                    $('#dimensi_id').empty();
                    let dimensi = res.data.dimensi
                    
                    $.each(dimensi, function(index, row) {
                        $('#dimensi_id').append('<option value="' + row.id + '">' + row.dimensi_name + '</option>');
                    });
                }
            });

            getDimensiOptions(1)
        });

        function getDimensiOptions(dimensi_id) {
            var data = {
                "_token": "{{ csrf_token() }}",
                "dimensi_id": dimensi_id
            }

            $.ajax({
                type: "POST",
                url: "{{route('ajax.capaian_dimensi.getElemen')}}",
                data: data,
                success: function (res) {
                    $('#elemen_id').empty();
                    let elemen = res.data.elemen
                    
                    $.each(elemen, function(index, row) {
                        $('#elemen_id').append('<option value="' + row.id + '">' + row.elemen_name + '</option>');
                    });
                }
            });
        }

        $('#dimensi_id').on('change', function () {
            let dimensi_id = $(this).val();

            getDimensiOptions(dimensi_id)
        });

        //Submit Call
        $('#submitCapaianDimensiBtn').on('click', function(e){
            e.preventDefault();
            var form = $("#formCapaianDimensi");
            
            enableLoadingButton("#submitCapaianDimensiBtn");
            var data = {
                "_token": "{{ csrf_token() }}",
                'fase' : $('#formCapaianDimensi').find('#fase').val(),
                'elemen_id' : $('#formCapaianDimensi').find('#elemen_id').val(),
                'point_name' : $('#formCapaianDimensi').find('#point_name').val(),
            }

            $.ajax({
                type: "POST",
                url: "{{route('ajax.capaian_dimensi.saveOrUpdate')}}",
                data: data,
                success: function(res) {
                    disableLoadingButton("#submitCapaianDimensiBtn");
                    if (!res.error) {
                        // showSuccess(res.message || "Success");
                        $('#modalCapaianDimensi').modal('hide');
                        swalSuccess({
                            text: 'Data berhasil disimpan',
                            withConfirmButton: true,
                            withReloadTable: true,
                            table: table
                        })
                    }else{
                        swalError({
                            text: 'Gagal menyimpan data'
                        })
                    }
                },
                error: function(response, textStatus, errorThrown){
                    disableLoadingButton("#submitCapaianDimensiBtn");
                    ajaxCallbackError(response);
                }
            });
        });

        $('#submitEditCapaianDimensiBtn').on('click', function(e){
            e.preventDefault();
            var form = $("#formEditCapaianDimensi");
            
            enableLoadingButton("#submitEditCapaianDimensiBtn");
            var data = {
                "_token": "{{ csrf_token() }}",
                'id': $('#formEditCapaianDimensi').find('#id').val(),
                'fase' : $('#formEditCapaianDimensi').find('#faseEdit').val(),
                'elemen_id' : $('#formEditCapaianDimensi').find('#elemen_id_edit').val(),
                'point_name' : $('#formEditCapaianDimensi').find('#point_name_edit').val(),
            }
            console.log(data)
            $.ajax({
                type: "POST",
                url: "{{route('ajax.capaian_dimensi.saveOrUpdate')}}",
                data: data,
                success: function(res) {
                    disableLoadingButton("#submitEditCapaianDimensiBtn");
                    if (!res.error) {
                        // showSuccess(res.message || "Success");
                        $('#modalEditCapaianDimensi').modal('hide');
                        swalSuccess({
                            text: 'Data berhasil diubah',
                            withConfirmButton: true,
                            withReloadTable: true,
                            table: table
                        })
                    }else{
                        swalError({
                            text: 'Gagal menyimpan data'
                        })
                    }
                },
                error: function(response, textStatus, errorThrown){
                    disableLoadingButton("#submitEditCapaianDimensiBtn");
                    ajaxCallbackError(response);
                }
            });

        });
    });
</script>

@endsection
