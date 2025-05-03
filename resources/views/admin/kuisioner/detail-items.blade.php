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
                            Item Kuisioner
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
                    <input type="hidden" name="id" id="id">
                    <input type="hidden" name="kuisioner_id" id="kuisioner_id" value="{{ $kuisioner_id }}">
                    <div class="mb-3">
                        <label for="nomor_urut">Nomor Urut</label>
                        <input type="number" class="form-control" name="no_urut" id="no_urut" required>
                    </div>
                    <div class="mb-3">
                        <label for="item">Pertanyaan Kuisioner</label>
                        <textarea class="form-control" id="item" name="item" type="text" placeholder="" required></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="input_type">Tipe Kuisioner</label>
                        <select class="form-control" id="input_type" name="input_type" required>
                            <option value="">-- Pilih Tipe --</option>
                            <option value="text">Isian</option>
                            <option value="radio">Pilihan</option>
                        </select>
                    </div>
                    <div class="mb-3" id="container-radio" style="display: none;">
                        <label for="input_label">Input Label</label>
                        <div id="div-radio-label">
                            <div class="input-group mb-3">
                                <input type="text" class="form-control" placeholder="Label" name="input_label[]" id="input_label_0" autocomplete="off" required>
                                <button class="btn btn-outline-success add-label" type="button"><i class="fa fa-plus"></i></button>
                            </div>
                        </div>
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
        var kuisioner_id = "{{ $kuisioner_id }}";
        var table = null;

        validatorKuisioner = $("#formKuisioner").validate({
            focusInvalid: true,
            errorClass: "is-invalid",
            success: "is-valid",
            rules: {
                'no_urut': {
                    required: true
                },
                'item': {
                    required: true
                },
                'input_type': {
                    required: true
                },
            }
        });

        table = $('#dtKuisioner').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: "{{route('ajax.dt.kuisioner_items.get')}}",
                dataType: "json",
                "data": function ( d ) {
                    d._token = "{{ csrf_token() }}",
                    d.kuisioner_id = kuisioner_id
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
                    "title":"Nomor Urut",
                    "data":"no_urut",
                    "visible":false,
                },
                {
                    "title":"Pertanyaan",
                    "width":"45%",
                    "data":"item"
                },
                {
                    "title":"Tipe",
                    "width":"10%",
                    "data":"input_type",
                    "render": function ( data, type, row, meta ) {
                        if (data == 'text') {
                            return 'Isian';
                        } else if (data == 'radio') {
                            return 'Pilihan';
                        }
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
                        '<a href="#" class="kuisionerEditBtn btn-transparent-dark btn btn-sm" data-id="'+row.id+'"><i class="fas fa-edit"></i></a>'+
                        '<a href="#" class="kuisionerDeleteBtn btn-transparent-dark btn btn-sm" data-id="'+row.id+'"><i class="fas fa-trash"></i></a>'
                    }
                }
            ],
            order:[[1,'asc'],[2,'asc']],
            columnDefs:[]
        });

        // Input type change
        $('#input_type').on('change', function() {
            var input_type = $(this).val();
            if(input_type == 'radio') {
                $("input[name='input_label[]']").rules("add", "required");
                $('#container-radio').show();
            } else {
                $("input[id*='input_label_']").rules("remove", "required");
                $('#container-radio').hide();
            }
        });

        // Button tambah label baru
        $(".add-label").on("click", function(e){
            $("#div-radio-label")
                .append('<div class="input-group mb-3 added-input-label">'+
                            '<input type="text" class="form-control" placeholder="Label" name="input_label[]" autocomplete="off">'+
                            '<button class="btn btn-outline-danger remove-label" type="button"><i class="fa fa-minus"></i>'+
                            '</button>'+
                        '</div>');
        });

        // Button hapus label
        $("#div-radio-label").on("click",".remove-label", function(e){
            $(this).parents(".input-group").remove();
        });

        // Simpan atau Update Data Item Kuisioner
        $('#formKuisioner').submit(function(e){
            e.preventDefault();

            var form = $("#formKuisioner");
            enableLoadingButton("#submitKuisionerBtn");

            if (!$(form).valid()) {
                validatorKuisioner.focusInvalid();
                disableLoadingButton("#submitKuisionerBtn");
                return false;
            }

            var formData = $(this).serialize();

            $.ajax({
                type: "POST",
                url: "{{route('ajax.kuisioner_items.save')}}",
                data: new FormData(this),
                success: function(res) {
                    disableLoadingButton("#submitKuisionerBtn");
                    if (!res.error) {
                        // showSuccess('Item kuisioner berhasil disimpan');
                        $('#modalKuisioner').modal('hide');
                        reset_form();
                        swalSuccess({
                            text: 'Item kuisioner berhasil disimpan',
                            withConfirmButton: true,
                            withReloadTable: true,
                            table: table
                        })
                        $('#formKuisioner').find('.valid').removeClass('valid');
                        // table.ajax.reload();
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

        $('#addKuisionerBtn').on('click', function(){
            reset_form();
            $('#modalKuisioner').modal('show');
        });

        // Edit Data
        $('#dtKuisioner').on('click', '.kuisionerEditBtn', function(){
            var id = $(this).data('id');
            console.log(id);
            reset_form();

            $.ajax({
                type: "POST",
                url: "{{route('ajax.kuisioner_items.get')}}",
                data: {
                    'id' : id,
                    "_token": "{{ csrf_token() }}"
                },
                success: function(res) {
                    if (!res.error) {
                        $('#formKuisioner').find('#id').val(res.data.id);
                        $('#formKuisioner').find('#kuisioner_id').val(res.data.kuisioner_id);
                        $('#formKuisioner').find('#no_urut').val(res.data.no_urut);
                        $('#formKuisioner').find('#item').val(res.data.item);
                        $('#formKuisioner').find('#input_type').val(res.data.input_type).change();
                        if (res.data.input_type == 'radio') {
                            var data_input_label = JSON.parse(res.data.input_label);
                            $('#container-radio').show();
                            $('#formKuisioner').find('[name=input_label]').val(data_input_label);
                            $.each(data_input_label, function(index, value) {
                                if (index == 0) {
                                    $('#input_label_0').val(value);
                                } else {
                                    $('#div-radio-label')
                                        .append('<div class="input-group mb-3 added-input-label">'+
                                                    '<input type="text" class="form-control" placeholder="Label" name="input_label[]" value="'+value+'" autocomplete="off">'+
                                                    '<button class="btn btn-outline-danger remove-label" type="button"><i class="fa fa-minus"></i>'+
                                                    '</button>'+
                                                '</div>');
                                }
                            });
                        }

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
                        url: "{{route('ajax.kuisioner_items.delete')}}",
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
            $('#kuisioner_id').val(kuisioner_id);
            $('#input_type').val('');
            $('#container-radio').hide();
            $('.added-input-label').remove();
        }
    });
</script>

@endsection
