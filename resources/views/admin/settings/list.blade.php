@extends('layouts.admin_layout')

@section('content')
<main>
    <header class="page-header page-header-compact page-header-light border-bottom bg-white mb-4">
        <div class="container-fluid px-4">
            <div class="page-header-content">
                <div class="row align-items-center justify-content-between pt-3">
                    <div class="col-auto mb-3">
                        <h1 class="page-header-title">
                            <div class="page-header-icon"><i data-feather="settings"></i></div>
                            Settings
                        </h1>
                    </div>
                    <div class="col-12 col-xl-auto mb-3">
                        <!-- <a class="btn btn-sm btn-light text-primary" href="#" id="addSettingsBtn">
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
                <div class="table-responsive">
                    <table class="table table-bordered" id="dtSettings" width="100%" cellspacing="0">
                    </table>
                </div>
            </div>
        </div>
    </div>
</main>

<!-- Modal -->
<div class="modal fade" id="modalSettings" data-bs-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="modalSettingsLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalSettingsLabel">Form</h5>
                <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="formSettings" method="POST" action="" enctype="multipart/form-data" novalidate>
                    @csrf
                    <div class="mb-3">
                        <label><strong>Data</strong></label>
                    </div>
                    <input class="form-control" id="id" type="hidden" placeholder="">
                    <div class="mb-3">
                        <label for="key">Key</label>
                        <input readonly="readonly" class="form-control" id="key" type="text" placeholder="">
                    </div>
                    <div class="mb-3" id="input_value_string_wrapper">
                        <label for="value">Value</label>
                        <input class="form-control" id="value" type="text" placeholder="">
                    </div>
                    <div class="mb-3" id="input_value_image_wrapper">
                        <img id="ttd_kepala_pkbm_preview" style="height: 150px" src="{{asset('images')}}/placeholder.png" alt="" class="img-thumbnail">
                        <br>
                        <label>
                            <input type="file" class="d-none" id="ttd_kepala_pkbm" name="ttd_kepala_pkbm" accept="image/png, image/jpg, image/jpeg">
                            <div class="btn btn-sm btn-primary">Unggah TTD Kepala PKBM</div>
                        </label>
                    </div>
                </form>
            </div>
            <div class="modal-footer"><button class="btn btn-secondary" type="button" data-bs-dismiss="modal">Close</button><button class="btn btn-primary" type="button" id="submitSettings">Submit</button></div>
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
        newTTD = null;
        newTTDSrc = null;

        table = $('#dtSettings').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: "{{route('ajax.dt.settings.get')}}",
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
                    "title":"Key",
                    "width":"12%",
                    "data":"key"
                },
                {
                    "title":"Value",
                    "width":"12%",
                    "data":"value"
                },
                {
                    "title": "Action",
                    "data":null,
                    "width":"15%",
                    "orderable":false,
                    "searchable":false,
                    render: function (data,type, row){
                        return '<a href="#" class="settingsEditBtn btn-transparent-dark btn btn-sm" data-id="'+row.id+'"><i class="fas fa-edit"></i></a>';
                        // '<a href="#" class="settingsDeleteBtn btn-transparent-dark btn btn-sm" data-id="'+row.id+'"><i class="fas fa-trash"></i></a>'
                    }
                }
            ],
            order:[[1,'asc']],
            columnDefs:[]
        });
        
        $('#input-search-table').on( 'keyup change clear',function() {
            table
                // .columns(2)
                .search( $(this).val())
                .draw()
        })

        // $('#dtSettings').on('click', '.importSAPBtn', function(){
        //     var id = $(this).data('id');
        //     $('#importModal').modal('show');
        //     $('#import_region_id').val(id);
        // });

        $('#dtSettings').on('click', '.settingsEditBtn', function(){
            var id = $(this).data('id');
            console.log(id);
            $('#modalSettings').modal('show');
            $('#formSettings').trigger("reset");
            $('#formSettings').find('#id').val(null);
            $.ajax({
                type: "POST",
                url: "{{route('ajax.settings.get')}}",
                data: {
                    'id' : id,
                    "_token": "{{ csrf_token() }}"
                },
                success: function(res) {
                    console.log(res)
                    if (!res.error) {
                        $('#formSettings').find('#id').val(res.data.id);
                        $('#formSettings').find('#key').val(res.data.key);
                        if (res.data.key == 'ttd_kepala_pkbm') {
                            $('#input_value_string_wrapper').hide();
                            $('#input_value_image_wrapper').show();
                            if (res.data.value != null && res.data.value != '') {
                                $('#formSettings').find('#ttd_kepala_pkbm_preview').attr("src", res.data.value);
                            }
                        } else {
                            $('#input_value_image_wrapper').hide();
                            $('#input_value_string_wrapper').show();
                            $('#formSettings').find('#value').val(res.data.value);
                        }
                    }
                }
            });
        });
        
        $('#ttd_kepala_pkbm').on('change',function(){
            if(this.files && this.files[0]){
                newTTD = this.files[0]
                var newTTDSrc = URL.createObjectURL(newTTD)
                $('#formSettings').find('#ttd_kepala_pkbm_preview').attr("src", newTTDSrc);
            }
        });

        $('#dtSettings').on('click', '.settingsDeleteBtn', function(e){
            e.preventDefault();
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
                        url: "{{route('ajax.settings.delete')}}",
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
            //     url: "{{route('ajax.settings.delete')}}",
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

        $('#addSettingsBtn').on('click', function(){
            $('#modalSettings').modal('show');
            $('#formSettings').trigger("reset");
            $('#formSettings').find('#id').val(null);
        });

        //Submit Call
        $('#submitSettings').on('click', function(e){
            e.preventDefault();
            var form = $("#formSettings");
            // if (!checkForm(form)) {
            //     return false;
            // }

            // $('#spinner-toast').modal('show');

            var formData = new FormData();
            formData.append('_token', "{{ csrf_token() }}");
            formData.append('id', $('#formSettings').find('#id').val());
            formData.append('key', $('#formSettings').find('#key').val());

            // var data = {
            //     "_token": "{{ csrf_token() }}",
            //     'id' : $('#formSettings').find('#id').val(),
            //     'key' : $('#formSettings').find('#key').val(),
            //     'value' : $('#formSettings').find('#value').val(),
            // }
            if ($('#formSettings').find('#key').val() == 'ttd_kepala_pkbm') {
                formData.append('value', newTTD);
            } else {
                formData.append('value', $('#formSettings').find('#value').val());
            }

            $.ajax({
                type: "POST",
                url: "{{route('ajax.settings.save')}}",
                cache : false,
                processData: false,
                contentType: false,
                data: formData,
                success: function(res) {
                    console.log(res);
                    // $('#spinner-toast').modal('hide');

                    if (!res.error) {
                        $('#modalSettings').modal('hide');
                        // $("#link-next").attr("href", "#");
                        // $('#success-modal').modal('show');
                        // $('#success-modal-btn-ok').on('click', function(){
                        //     $('#success-modal').modal('hide');
                        // });
                        // table.ajax.reload();
                        swalSuccess({
                            text: 'Data berhasil disimpan',
                            withReloadTable: true,
                            table: table
                        });
                    }else{
                        // $('#toastModalLabel').text(response.message)
                        // $('#toastModal').modal('show')
                    }
                }
            });
        });
    });
</script>
@endsection
