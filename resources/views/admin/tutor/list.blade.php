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
                            Tutor List
                        </h1>
                    </div>
                    <div class="col-12 col-xl-auto mb-3">
                        <a class="btn btn-sm btn-light text-primary" href="#" id="addTutorBtn">
                            <i class="me-1" data-feather="user-plus"></i>
                            Add Tutor
                        </a>
                        <!-- <a class="btn btn-sm btn-light text-primary" href="#">
                            <i class="me-1" data-feather="file"></i>
                            PDF
                        </a> -->
                        <a class="btn btn-sm btn-light text-primary" href="#" id="importBtn">
                            <i class="me-1" data-feather="file"></i>
                            Import Excel
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
                    <table class="table table-bordered" id="dtTutor" width="100%" cellspacing="0">
                        <!-- <thead>
                            <tr>
                                <th>Name</th>
                                <th>NIP</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th>Name</th>
                                <th>NIP</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </tfoot>
                        <tbody>
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="avatar me-2"><img class="avatar-img img-fluid" src="{{asset('assets/admin/dist')}}/assets/img/illustrations/profiles/profile-1.png" /></div>
                                        Tutor 1
                                    </div>
                                </td>
                                <td>P0000</td>
                                <td>
                                    <span class="badge bg-green-soft text-green">Aktif</span>
                                    <span class="badge bg-yellow-soft text-yellow">Tidak Aktif</span>
                                </td>
                                <td>
                                    <a class="btn btn-datatable btn-icon btn-transparent-dark me-2" href="#"><i data-feather="edit"></i></a>
                                    <a class="btn btn-datatable btn-icon btn-transparent-dark" href="#!"><i data-feather="trash-2"></i></a>
                                </td>
                            </tr>
                        </tbody> -->
                    </table>
                </div>
            </div>
        </div>
    </div>
</main>

<!-- Modal -->
<div class="modal fade" id="modalTutor" data-bs-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="modalTutorLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalTutorLabel">Form</h5>
                <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="formTutor" method="POST" action="" novalidate>
                    @csrf
                    <div class="mb-3">
                        <label><strong>Data</strong></label>
                    </div>
                    <input class="form-control" id="id" type="hidden" placeholder="">
                    <div class="mb-3">
                        <label for="username">Username</label>
                        <input class="form-control" id="username" type="text" placeholder="">
                    </div>
                    <div class="mb-3">
                        <label for="nip">NIP</label>
                        <input class="form-control" id="nip" type="text" placeholder="">
                    </div>
                    <div class="mb-3">
                        <label for="name">Name</label>
                        <input class="form-control" id="name" type="text" placeholder="">
                    </div>
                    <div class="mb-3">
                        <label for="email">Email</label>
                        <input class="form-control" id="email" type="text" placeholder="">
                    </div>
                    <div class="mb-3">
                        <label for="phone">Phone</label>
                        <input class="form-control" id="phone" type="text" placeholder="">
                    </div>
                    <div class="mb-3">
                        <div class="form-check">
                            <input class="form-check-input" id="is_active" name="is_active" type="checkbox" value="">
                            <label class="form-check-label" for="is_active">Set Aktif</label>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer"><button class="btn btn-secondary" type="button" data-bs-dismiss="modal">Close</button><button class="btn btn-primary" type="button" id="submitTutorBtn">Submit</button></div>
        </div>
    </div>
</div>

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
                    <input class="form-control" id="id" type="hidden" placeholder="">
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

<!-- Modal -->
<div class="modal fade" id="modalImport" data-bs-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="modalImportLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalImportLabel">Import</h5>
                <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="formImport" method="POST" action="" novalidate>
                    @csrf
                    <div class="mb-3 col-md-6">
                        <label class="small mb-1" for="import_file">File</label>
                        <input class="form-control" id="import_file" type="file" placeholder="" value="" />
                    </div>
                </form>
            </div>
            <div class="modal-footer"><button class="btn btn-secondary" type="button" data-bs-dismiss="modal">Close</button><button class="btn btn-primary" type="button" id="submitImportBtn">Submit</button></div>
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
        table = $('#dtTutor').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: "{{route('ajax.dt.tutor.get')}}",
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
                    "title":"Username",
                    "width":"12%",
                    "data":"username",
                    "name":"u.username"
                },
                {
                    "title":"NIP",
                    "width":"12%",
                    "data":"nip"
                },
                {
                    "title":"Name",
                    "width":"15%",
                    "data":"name",
                    "name":"u.name"
                },
                {
                    "title":"Email",
                    "width":"15%",
                    "data":"email",
                    "name":"u.email"
                },
                {
                    "title":"Phone",
                    "width":"15%",
                    "data":"phone",
                    "name":"u.phone"
                },
                {
                    "title":"Status",
                    "width":"12%",
                    "data":"is_active",
                    "name":"u.is_active",
                    render: function (data, type, row) {
                        if (data) {
                            return '<span class="badge bg-green-soft text-green">Aktif</span>';
                        }else{
                            return '<span class="badge bg-yellow-soft text-yellow">Tidak Aktif</span>';
                        }
                    }
                },
                {
                    "title": "Action",
                    "data":null,
                    "width":"30%",
                    "orderable":false,
                    "searchable":false,
                    render: function (data,type, row){
                        return ''+
                        '<a href="#" class="tutorEditBtn btn-transparent-dark btn btn-sm" data-id="'+row.id+'"><i class="fas fa-edit"></i></a>'+
                        '<a href="#" class="editPwdBtn btn-transparent-dark btn btn-sm" data-id="'+row.id+'"><i class="fas fa-key"></i></a>'+
                        '<a href="#" class="tutorDeleteBtn btn-transparent-dark btn btn-sm" data-id="'+row.id+'"><i class="fas fa-trash"></i></a>'
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

        // $('#dtTutor').on('click', '.importSAPBtn', function(){
        //     var id = $(this).data('id');
        //     $('#importModal').modal('show');
        //     $('#import_region_id').val(id);
        // });

        $('#dtTutor').on('click', '.tutorEditBtn', function(){
            var id = $(this).data('id');
            console.log(id);
            $('#modalTutor').modal('show');
            $('#formTutor').trigger("reset");
            $('#formTutor').find('#id').val(null);
            $.ajax({
                type: "POST",
                url: "{{route('ajax.tutor.get')}}",
                data: {
                    'id' : id,
                    "_token": "{{ csrf_token() }}"
                },
                success: function(res) {
                    console.log(res)
                    if (!res.error) {
                        $('#formTutor').find('#id').val(res.data.id);
                        $('#formTutor').find('#username').val(res.data?.user_detail.username);
                        $('#formTutor').find('#name').val(res.data?.user_detail.name);
                        $('#formTutor').find('#nip').val(res.data.nip);
                        $('#formTutor').find('#phone').val(res.data?.user_detail.phone);
                        $('#formTutor').find('#email').val(res.data?.user_detail.email);
                        if (res.data?.user_detail.is_active) {
                            $('#formTutor').find('#is_active').prop('checked', true);
                        }else{
                            $('#formTutor').find('#is_active').prop('checked', false);
                        }
                    }
                }
            });
        });

        $('#dtTutor').on('click', '.editPwdBtn', function(){
            var id = $(this).data('id');
            $('#modalPwd').modal('show');
            $('#formPwd').trigger("reset");
            $('#formPwd').find('#id').val(id);
        });

        $('#dtTutor').on('click', '.tutorDeleteBtn', function(e){
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
                        url: "{{route('ajax.tutor.delete')}}",
                        data: data,
                        withSweetAlertTimer: true,
                        swalTitle: 'Sukses',
                        swalText: 'Data berhasil dihapus',
                        swalType: 'success',
                        swalTimer: 2000,
                        withReloadTable: true,
                        table: table
                    });
                }
            });

            // $.ajax({
            //     type: "POST",
            //     url: "{{route('ajax.tutor.delete')}}",
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

        $('#addTutorBtn').on('click', function(){
            $('#modalTutor').modal('show');
            $('#formTutor').trigger("reset");
            $('#formTutor').find('#id').val(null);
        });

        $('#submitTutorBtn').on('click', function(e){
            e.preventDefault();
            var form = $("#formTutor");
            // if (!checkForm(form)) {
            //     return false;
            // }

            // $('#spinner-toast').modal('show');

            var data = {
                "_token": "{{ csrf_token() }}",
                'id' : $('#formTutor').find('#id').val(),
                'username' : $('#formTutor').find('#username').val(),
                'nip' : $('#formTutor').find('#nip').val(),
                'name' : $('#formTutor').find("#name").val(),
                'email' : $('#formTutor').find("#email").val(),
                'phone' : $('#formTutor').find("#phone").val(),
                'is_active' : $('#formTutor').find("#is_active").is(":checked"),
            }
            console.log('submit', data);
            $.ajax({
                type: "POST",
                url: "{{route('ajax.tutor.save')}}",
                data: data,
                success: function(res) {
                    console.log(res);
                    // $('#spinner-toast').modal('hide');

                    if (!res.error) {
                        $('#modalTutor').modal('hide');
                        // $("#link-next").attr("href", "#");
                        // $('#success-modal').modal('show');
                        // $('#success-modal-btn-ok').on('click', function(){
                        //     $('#success-modal').modal('hide');
                        // });
                        swalSuccess({
                            text: 'Data berhasil disimpan',
                            withConfirmButton: true,
                            withReloadTable: true,
                            table: table
                        })
                    }else{
                        // $('#toastModalLabel').text(response.message)
                        // $('#toastModal').modal('show')
                    }
                }
            });
        });

        $('#submitPwd').on('click', function(e){
            e.preventDefault();
            var form = $("#formPwd");
            // if (!checkForm(form)) {
            //     return false;
            // }

            // $('#spinner-toast').modal('show');

            var data = {
                "_token": "{{ csrf_token() }}",
                'id' : $('#formPwd').find('#id').val(),
                'password' : $('#formPwd').find('#password').val(),
            }

            console.log('submit', data);
            $.ajax({
                type: "POST",
                url: "{{route('ajax.tutor.change_password')}}",
                data: data,
                success: function(res) {
                    console.log(res);
                    // $('#spinner-toast').modal('hide');

                    if (!res.error) {
                        $('#modalPwd').modal('hide');
                        // $("#link-next").attr("href", "#");
                        // $('#success-modal').modal('show');
                        // $('#success-modal-btn-ok').on('click', function(){
                        //     $('#success-modal').modal('hide');
                        // });
                        swalSuccess({
                            text: 'Password berhasil diperbarui!',
                            withConfirmButton: true,
                            withReloadTable: true,
                            table: table
                        })
                    }else{
                        // $('#toastModalLabel').text(response.message)
                        // $('#toastModal').modal('show')
                    }
                }
            });
        });

        var importFile = null;

        $('#import_file').on('change',function(){
            if(this.files && this.files[0]){
                importFile = this.files[0]
            }
        });

        $('#importBtn').on('click', function(){
            $('#modalImport').modal('show');
            $('#formImport').trigger('reset');
            importFile = null;
        });
        
        $('#submitImportBtn').on('click', function(e){
            e.preventDefault();
            var form = $("#formImport");

            if (importFile == null) {
                showError('importFile tidak ditemukan');
                return false;
            }

            enableLoadingButton("#submitImportBtn");

            var formData = new FormData();

            formData.append('_token', "{{ csrf_token() }}");
            formData.append('import_file', importFile);

            $.ajax({
                type: "POST",
                url: "{{route('ajax.tutor.import_excel')}}",
                cache : false,
                processData: false,
                contentType: false,
                data: formData,
                success: function(res) {
                    disableLoadingButton("#submitImportBtn");
                    if (!res.error) {
                        showSuccess(res.message || "Success");
                    }else{
                        showError('failed');
                    }
                },
                error: function(response, textStatus, errorThrown){
                    disableLoadingButton("#submitImportBtn");
                    ajaxCallbackError(response);
                }
            });
        });
    });
</script>
@endsection
