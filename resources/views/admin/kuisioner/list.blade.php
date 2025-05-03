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
                            Kuisioner
                        </h1>
                    </div>
                    <div class="col-12 col-xl-auto mb-3">
                        <a class="btn btn-sm btn-light text-primary" href="#" id="addKuisionerBtn">
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
                <div class="row">
                    <div class="col-md">
                        <label class="mb-1" for="tahun_akademik_id_filter">Tahun Akademik</label>
                        <select class="form-control" id="tahun_akademik_id_filter" style="width: 100%; ">
                        </select>
                    </div>
                    <hr class="my-4" />
                    <div class="col-md">
                        <a href="#" id="duplicateBtn" class="btn btn-success">Duplicate Kuisioner</a>
                    </div>
                </div>
            </div>
        </div>
        <br>
        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dtKuisioner" width="100%" cellspacing="0">
                    </table>
                </div>
            </div>
        </div>
    </div>
</main>

<!-- Modal -->
<div class="modal fade" id="modalKuisioner" data-bs-backdrop="static" role="dialog" aria-labelledby="modalKuisionerLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <form id="formKuisioner" method="POST" action="" novalidate>
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalKuisionerLabel">Form</h5>
                    <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input class="form-control" id="id" name="id" type="hidden" placeholder="">
                    <div class="mb-3">
                        <label for="tahun_akademik">Tahun Akademik</label>
                        <select class="form-control" id="tahun_akademik_id" name="tahun_akademik_id" style="width: 100%; ">
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="tahun_akademik">Status</label>
                        <select class="form-control" id="status_kuisioner" name="status_kuisioner" style="width: 100%;">
                            <option value="">-- Pilih Salah Satu --</option>
                            <option value="published">Dipublikasikan</option>
                            <option value="not_publish">Tidak Dipublikasikan</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-bs-dismiss="modal">Close</button>
                    <button class="btn btn-primary" type="submit" id="submitKuisionerBtn">Submit</button>
                </div>
            </div>
        </form>
    </div>
</div>

<div class="modal fade" id="modalDuplicate" data-bs-backdrop="static" role="dialog" aria-labelledby="modalDuplicateLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <form id="formDuplicate" method="POST" action="" novalidate>
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalDuplicateLabel">Form</h5>
                    <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="tahun_akademik_source">Tahun Akademik Asal</label>
                        <select class="form-control" id="tahun_akademik_source" name="tahun_akademik_source" style="width: 100%; ">
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="tahun_akademik_destination">Tahun Akademik Tujuan</label>
                        <select class="form-control" id="tahun_akademik_destination" name="tahun_akademik_destination" style="width: 100%; ">
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-bs-dismiss="modal">Close</button>
                    <button class="btn btn-primary" type="submit" id="submitDuplicateBtn">Duplicate</button>
                </div>
            </div>
        </form>
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
        var table = null;
        var tahunAkademikSelected = null;

        table = $('#dtKuisioner').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: "{{route('ajax.dt.kuisioner.get')}}",
                dataType: "json",
                "data": function ( d ) {
                    d._token = "{{ csrf_token() }}",
                    d.tahun_akademik_id = tahunAkademikSelected
                },
                type: "POST",
            },
            bSort: true,
            searching: true,
            lengthChange: true,
            scrollX: true,
            columns:[
                {
                    "title":"No",
                    "width":"5%",
                    "data":"DT_RowIndex"
                },
                {
                    "title":"Kode Tahun Akademik",
                    "data":"tahun_akademik.kode",
                    "visible": false
                },
                {
                    "title":"Tahun Akademik",
                    "data":"tahun_akademik.keterangan"
                },
                {
                    "title":"Status",
                    "data":"is_published",
                    "width":"25%",
                    render: function (data, type, row) {
                        var status = "";
                        if (data == true) {
                            status = "Dipublikasikan";
                        } else {
                            status = "Tidak Dipublikasikan";
                        }

                        return status;
                    }
                },
                {
                    "title": "Action",
                    "data":null,
                    "width":"15%",
                    "orderable":false,
                    "searchable":false,
                    render: function (data,type, row){
                        return ''+
                        '<a href="{{ route("web.su.kuisioner_items.list") }}/'+row.id_kuisioner+'" class="kuisionerDetailBtn btn-transparent-dark btn btn-sm"><i class="fas fa-eye"></i></a>'+
                        '<a href="#" class="kuisionerEditBtn btn-transparent-dark btn btn-sm" data-id="'+row.id_kuisioner+'"><i class="fas fa-edit"></i></a>'+
                        '<a href="#" class="kuisionerDeleteBtn btn-transparent-dark btn btn-sm" data-id="'+row.id_kuisioner+'"><i class="fas fa-trash"></i></a>'
                    }
                }
            ],
            order:[[1,'desc'],[2,'asc']],
            columnDefs:[]
        });

        // Tahun akademik
        getTahunAkademik();
        function getTahunAkademik() {
            $.ajax({
                type: "POST",
                url: "{{route('ajax.tahun_akademik.list')}}",
                data: {
                    "_token": "{{ csrf_token() }}",
                },
                success: function(res) {
                    console.log(res);
                    var opt_for_filter = "<option value=''>Semua</option>";
                    var opt_for_input = "<option value=''>-- Pilih Salah Satu --</option>";
                    $.each(res.data, function (i, row) {
                        opt_for_filter += "<option value='"+row.id+"'>"+row.kode+" - "+row.keterangan+"</option>";
                        opt_for_input += "<option value='"+row.id+"'>"+row.kode+" - "+row.keterangan+"</option>";
                    });
                    $('#tahun_akademik_id_filter').html(opt_for_filter);
                    $('#tahun_akademik_id').html(opt_for_input);
                    $('#tahun_akademik_source').html(opt_for_input);
                    $('#tahun_akademik_destination').html(opt_for_input);
                }
            });
        }

        $("#tahun_akademik_id_filter").select2({
            theme: 'bootstrap4'
        });

        $("#tahun_akademik_id").select2({
            theme: 'bootstrap4',
            dropdownParent: $("#modalKuisioner")
        });

        $("#tahun_akademik_source, #tahun_akademik_destination").select2({
            theme: 'bootstrap4',
            dropdownParent: $("#modalDuplicate")
        });

        $("#tahun_akademik_id_filter").on("change", function(e) {
            tahunAkademikSelected = $("#tahun_akademik_id_filter").val();
            table.ajax.reload();
        });

        // Simpan atau Update Data Kuisioner
        $('#formKuisioner').submit(function(e){
            e.preventDefault();

            var form = $("#formKuisioner");
            enableLoadingButton("#submitKuisionerBtn");

            var formData = $(this).serialize();

            $.ajax({
                type: "POST",
                url: "{{route('ajax.kuisioner.save')}}",
                data: new FormData(this),
                success: function(res) {
                    disableLoadingButton("#submitKuisionerBtn");
                    if (!res.error) {
                        // showSuccess('Kuisioner berhasil disimpan');
                        $('#modalKuisioner').modal('hide');
                        reset_form();
                        // table.ajax.reload();
                        swalSuccess({
                            text: 'Kuisioner berhasil disimpan',
                            withConfirmButton: true,
                            withReloadTable: true,
                            table: table
                        })
                    }else{
                        showError('failed');
                    }
                },
                cache: false,
                processData: false,
                contentType: false,
                error: function(response, textStatus, errorThrown){
                    disableLoadingButton("#submitKuisionerBtn");
                    ajaxCallbackError(response);
                }
            });
        });

        // Duplicate Kuisioner
        $('#formDuplicate').submit(function(e){
            e.preventDefault();

            var form = $("#formDuplicate");
            enableLoadingButton("#submitDuplicateBtn");

            var formData = $(this).serialize();

            $.ajax({
                type: "POST",
                url: "{{route('ajax.kuisioner.duplicate')}}",
                data: new FormData(this),
                success: function(res) {
                    disableLoadingButton("#submitDuplicateBtn");
                    if (!res.error) {
                        // showSuccess('Kuisioner berhasil diduplikasi');
                        $('#modalDuplicate').modal('hide');
                        $('#formDuplicate')[0].reset();
                        $("#tahun_akademik_source").trigger("change");
                        $("#tahun_akademik_destination").trigger("change");
                        // table.ajax.reload();
                        swalSuccess({
                            text: 'Kuisioner berhasil diduplikasi',
                            withConfirmButton: true,
                            withReloadTable: true,
                            table: table
                        })
                    }else{
                        // showError('Gagal!');
                        swalError({
                            text: 'Gagal mengduplikasi kuisioner'
                        })
                    }
                },
                cache: false,
                processData: false,
                contentType: false,
                error: function(response, textStatus, errorThrown){
                    // showError('Gagal!');
                    disableLoadingButton("#submitDuplicateBtn");

                    if (response.responseJSON.action == 'NEED_CONFIRMATION') {
                        var tahun_akademik_source = response.responseJSON.data.tahun_akademik_source;
                        var tahun_akademik_destination = response.responseJSON.data.tahun_akademik_destination;
                        var message = response.responseJSON.message + ' Data yang sudah ada akan ditimpa dengan data baru';

                        sweetAlertAction({
                            title: 'Apakah anda yakin?',
                            text: message,
                            type: 'question',
                            withCallback: true,
                            callback: function() {
                                ajaxOperation({
                                    type: "POST",
                                    url: "{{route('ajax.kuisioner.duplicate')}}",
                                    data: {
                                        "_token": "{{ csrf_token() }}",
                                        tahun_akademik_source: tahun_akademik_source,
                                        tahun_akademik_destination: tahun_akademik_destination,
                                        force: true
                                    },
                                    withSuccessMessage: true,
                                    successMessage: 'Kuisioner berhasil diduplikasi',
                                    withReloadTable: true,
                                    table: table,
                                    withHideModal: true,
                                    modal: '#modalDuplicate',
                                    withResetForm: true,
                                    form: '#formDuplicate'
                                });
                            }
                        });
                    } else {
                        ajaxCallbackError(response);
                    }
                }
            });
        });

        $('#addKuisionerBtn').on('click', function(){
            reset_form();
            $('#modalKuisioner').modal('show');
        });

        $('#duplicateBtn').on('click', function(){
            $('#modalDuplicate').modal('show');
        });

        // Edit Data
        $('#dtKuisioner').on('click', '.kuisionerEditBtn', function(){
            var id = $(this).data('id');
            reset_form();

            $.ajax({
                type: "POST",
                url: "{{route('ajax.kuisioner.get')}}",
                data: {
                    'id' : id,
                    "_token": "{{ csrf_token() }}"
                },
                success: function(res) {
                    if (!res.error) {
                        var status_kuisioner = res.data.is_published == true ? 'published' : 'not_publish';
                        $('#formKuisioner').find('#id').val(res.data.id);
                        $('#formKuisioner').find('#tahun_akademik_id').val(res.data.tahun_akademik_id).change();
                        $('#formKuisioner').find('#status_kuisioner').val(status_kuisioner);

                        $('#modalKuisioner').modal('show');
                    }
                }
            });
        });

        // Hapus Data
        $('#dtKuisioner').on('click', '.kuisionerDeleteBtn', function(e){
            e.preventDefault();
            var data = {
                "_token": "{{ csrf_token() }}",
                'id' : $(this).data('id'),
            }

            sweetAlertAction({
                title: 'Apakah anda yakin?',
                text: 'Data tidak dapat dikembalikan',
                type: 'question',
                withCallback: true,
                callback: function() {
                    ajaxOperation({
                        type: "POST",
                        url: "{{route('ajax.kuisioner.delete')}}",
                        data: data,
                        withSuccessMessage: true,
                        successMessage: 'Data berhasil dihapus',
                        withReloadTable: true,
                        table: table
                    });
                }
            });
        });


        function reset_form() {
            $('#formKuisioner')[0].reset();
            $('#id').val('');
            $("#tahun_akademik_id").trigger("change");
            $("#status_kuisioner").trigger("change");
        }
    });
</script>

@endsection
