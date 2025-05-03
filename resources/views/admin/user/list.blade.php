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
                            User
                        </h1>
                    </div>
                    <div class="col-12 col-xl-auto mb-3">
                        <a class="btn btn-sm btn-light text-primary" href="#" id="addUserBtn">
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
                    <table class="table table-bordered" id="dtUser" width="100%" cellspacing="0">
                    </table>
                </div>
            </div>
        </div>
    </div>
</main>

<!-- Modal -->
<div class="modal fade" id="modalUser" data-bs-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="modalUserLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalUserLabel">Form</h5>
                <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="formUser" novalidate>
                    @csrf
                    <input class="form-control" id="id" type="hidden" placeholder="">
                    <div class="mb-3">
                        <label for="name">Nama User</label>
                        <input class="form-control" id="name" type="text" placeholder="" autocomplete="off">
                    </div>
                    <div class="mb-3">
                        <label for="username">Username</label>
                        <input class="form-control" id="username" type="text" placeholder="" autocomplete="off">
                    </div>
                    <div class="mb-3">
                        <label for="email">Email</label>
                        <input class="form-control" id="email" type="text" placeholder="" autocomplete="off">
                    </div>
                    <div class="mb-3">
                        <label for="phone">Nomor HP</label>
                        <input class="form-control" id="phone" type="text" placeholder="" autocomplete="off">
                    </div>
                    <div class="mb-3" id="password_wrapper">
                        <label for="password">Password</label>
                        <input class="form-control" id="password" type="password" placeholder="" autocomplete="off">
                    </div>
                    <div class="mb-3" id="password_confirmation_wrapper">
                        <label for="password_confirmation">Konfirmasi Password</label>
                        <input class="form-control" id="password_confirmation" type="password" placeholder="" autocomplete="off">
                    </div>
                    <div class="mb-3" id="new_password_wrapper">
                        <label for="new_password">Password Baru</label>
                        <input class="form-control" id="new_password" type="password" placeholder="" autocomplete="off">
                    </div>
                    <div class="mb-3" id="new_password_confirmation_wrapper">
                        <label for="new_password_confirmation">Konfirmasi Password Baru</label>
                        <input class="form-control" id="new_password_confirmation" type="password" placeholder="" autocomplete="off">
                    </div>
                    <div class="mb-3">
                        <label class="mb-1" for="role">Role</label>
                        <div class="input-group mb-3">
                            <select class="form-control" id="role" name="role"></select>
                        </div>
                    </div>
                    <div class="mb-3" id="status">
                        <label>Status</label><br>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="is_active" id="statusAktif" value="1" checked>
                            <label class="form-check-label" for="statusAktif">Aktif</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="is_active" id="statusTidakAktif" value="0">
                            <label class="form-check-label" for="statusTidakAktif">Tidak Aktif</label>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary" type="button" data-bs-dismiss="modal">Close</button>
                <button class="btn btn-primary" type="button" id="submitUserBtn">Submit</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modalUpdateUser" data-bs-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="modalUpdateUserLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalUpdateUserLabel">Form</h5>
                <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="formUpdateUser" novalidate>
                    @csrf
                    <input class="form-control" id="id_update" type="hidden" placeholder="">
                    <div class="mb-3">
                        <label for="name_update">Nama User</label>
                        <input class="form-control" id="name_update" type="text" placeholder="" autocomplete="off">
                    </div>
                    <div class="mb-3">
                        <label for="username_update">Username</label>
                        <input class="form-control" id="username_update" type="text" placeholder="" autocomplete="off">
                    </div>
                    <div class="mb-3">
                        <label for="email_update">Email</label>
                        <input class="form-control" id="email_update" type="text" placeholder="" autocomplete="off">
                    </div>
                    <div class="mb-3">
                        <label for="phone_update">Nomor HP</label>
                        <input class="form-control" id="phone_update" type="text" placeholder="" autocomplete="off">
                    </div>
                    <div class="mb-3" id="new_password_update_wrapper">
                        <label for="new_password_update">Password Baru</label>
                        <input class="form-control" id="new_password_update" type="password" placeholder="" autocomplete="off">
                    </div>
                    <div class="mb-3" id="new_password_update_confirmation_wrapper">
                        <label for="new_password_update_confirmation">Konfirmasi Password Baru</label>
                        <input class="form-control" id="new_password_update_confirmation" type="password" placeholder="" autocomplete="off">
                    </div>
                    <div class="mb-3">
                        <label class="mb-1" for="role_update">Role</label>
                        <div class="input-group mb-3">
                            <select class="form-control" id="role_update" name="role"></select>
                        </div>
                    </div>
                    <div class="mb-3" id="status_update">
                        <label>Status</label><br>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="is_active" id="statusAktif_update" value="1" checked>
                            <label class="form-check-label" for="statusAktif_update">Aktif</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="is_active" id="statusTidakAktif_update" value="0">
                            <label class="form-check-label" for="statusTidakAktif_update">Tidak Aktif</label>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary" type="button" data-bs-dismiss="modal">Close</button>
                <button class="btn btn-primary" type="button" id="submitUpdateUserBtn">Submit</button>
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
        table = $('#dtUser').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: "{{route('ajax.dt.user.get')}}",
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
                    "data": 'DT_RowIndex',
                    "title": 'No.',
                    "orderable": false,
                    "searchable": false,
                    "width": "5%"
                },
                {
                    "title":"Nama",
                    "width":"20%",
                    "data":"name"
                },
                {
                    "title":"Username",
                    "width":"20%",
                    "data":"username"
                },
                {
                    "title":"Email",
                    "width":"20%",
                    "data":"email",
                    render: function(data, type, row) {
                        if (data == null) {
                            return "-";
                        } else {
                            return data;
                        }
                    }
                },
                {
                    "title":"Role",
                    "width":"10%",
                    "data":"role_name"
                },
                {
                    "title":"Status",
                    "width":"10%",
                    "data":"is_active",
                    render: function(data, type, row) {
                        if (data) {
                            return "Aktif";
                        } else {
                            return "Tidak Aktif";
                        }
                    }
                },
                {
                    "title": "Action",
                    "data":null,
                    "width":"10%",
                    "orderable":false,
                    "searchable":false,
                    render: function (data,type,row){
                        return '<a href="#" class="editUserBtn btn btn-sm btn-transparent-dark" data-id="'+row.id+'"><i class="fas fa-edit"></i></a>'+
                        '<a href="#" class="deleteUserBtn btn btn-sm btn-transparent-dark" data-id="'+row.id+'"><i class="fas fa-trash"></i></a>'
                    }
                }
            ],
            order:[[1,'asc']],
            columnDefs:[]
        });
        
        // validatorUser = $("#formUser").validate({
        //     focusInvalid: true,
        //     errorClass: "is-invalid",
        //     success: "is-valid",
        //     rules: {
        //         nama : {
        //             required: true,
        //         },
        //         username : {
        //             required: true,
        //         },
        //         role : {
        //             required: true,
        //         },
        //         email: {
        //             required: false,
        //             email: true
        //         },
        //         phone: {
        //             required: false,
        //         },
        //         password: {
        //             required: true,
        //             minlength: 8
        //         },
        //         password_confirmation: {
        //             required: true,
        //             equalTo: "#password"
        //         },
        //         is_active: {
        //             required: true
        //         },
        //     }
        // });

        $('#input-search-table').on( 'keyup change clear',function() {
            table
                // .columns(2)
                .search( $(this).val())
                .draw()
        })

        $('#dtUser').on('click', '.editUserBtn', function(){
            var id = $(this).data('id');
            console.log(id);
            $('#modalUpdateUser').modal('show');
            $('#formUpdateUser').trigger("reset");
            $('#formUpdateUser').find('#id_update').val(null);

            getRolesOptions()

            $.ajax({
                type: "POST",
                url: "{{route('ajax.user.get')}}",
                data: {
                    'id' : id,
                    "_token": "{{ csrf_token() }}"
                },
                success: function(res) {
                    console.log(res)
                    if (!res.error) {
                        $('#formUpdateUser').find('#id_update').val(res.data.id);
                        $('#formUpdateUser').find('#name_update').val(res.data.name);
                        $('#formUpdateUser').find('#username_update').val(res.data.username);
                        $('#formUpdateUser').find('#email_update').val(res.data.email);
                        $('#formUpdateUser').find('#phone_update').val(res.data.phone);
                        $('#formUpdateUser #role_update option[value="' + res.data.role + '"]').prop('selected', true);
                        
                        $('#statusAktif_update').prop('checked', res.data.status == '1');
                        $('#statusTidakAktif_update').prop('checked', res.data.status == '0');
                    }
                }
            });
        });

        $('#dtUser').on('click', '.deleteUserBtn', function(e){
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
                        url: "{{route('ajax.user.delete')}}",
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
        });

        $('#addUserBtn').on('click', function(){
            $('#modalUser').modal('show');
            $('#formUser').trigger("reset");
            $('#formUser').find('#id').val(null);
            $('#new_password_wrapper').hide();
            $('#new_password_confirmation_wrapper').hide();
            $('#password_wrapper').show();
            $('#password_confirmation_wrapper').show();

            getRolesOptions()
        });

        function getRolesOptions() {
            $.ajax({
                type: "POST",
                url: "{{route('ajax.user.get_roles')}}",
                data: {
                    "_token": "{{ csrf_token() }}"
                },
                success: function(res) {
                    console.log(res)
                    var opt_for_input = "<option value=''>-- Pilih Salah Satu --</option>";
                    $.each(res.data, function (i, row) {
                        opt_for_input += "<option value='"+row.id+"'>"+row.role_name+"</option>";
                    });

                    $('#role').html(opt_for_input);
                    $('#role_update').html(opt_for_input);
                }
            });
        }

        //Submit Call Create User
        $('#submitUserBtn').on('click', function(e){
            e.preventDefault();
            var form = $("#formUser");
            var data = {
                "_token": "{{ csrf_token() }}",
                'id' : $('#formUser').find('#id').val(),
                'name' : $('#formUser').find('#name').val(),
                'username' : $('#formUser').find('#username').val(),
                'email' : $('#formUser').find('#email').val(),
                'phone' : $('#formUser').find('#phone').val(),
                'password' : $('#formUser').find('#password').val(),
                'password_confirmation' : $('#formUser').find('#password_confirmation').val(),
                'role' : $('#formUser').find('#role').val(),
                'is_active' : $("input[name='is_active']:checked").val(),
            }

            $.ajax({
                type: "POST",
                url: "{{route('ajax.user.create')}}",
                data: data,
                success: function(res) {
                    console.log(res);
                    if (!res.error) {
                        $('#modalUser').modal('hide');
                        // showSuccess("Data berhasil disimpan");
                        swalSuccess({
                            text: 'Data berhasil disimpan',
                            withConfirmButton: true,
                            withReloadTable: true,
                            table: table
                        });
                    } else {
                        swalError({
                            text: 'Data gagal disimpan'
                        });
                    }
                }
            });
        });

        // Update User
        $('#submitUpdateUserBtn').on('click', function(e){
            e.preventDefault();
            var form = $("#formUpdateUser");
            var data = {
                "_token": "{{ csrf_token() }}",
                'id' : $('#formUpdateUser').find('#id_update').val(),
                'name' : $('#formUpdateUser').find('#name_update').val(),
                'username' : $('#formUpdateUser').find('#username_update').val(),
                'email' : $('#formUpdateUser').find('#email_update').val(),
                'phone' : $('#formUpdateUser').find('#phone_update').val(),
                'password' : $('#formUpdateUser').find('#new_password_update').val(),
                'password_confirmation' : $('#formUpdateUser').find('#new_password_update_confirmation').val(),
                'role' : $('#formUpdateUser').find('#role_update').val(),
                'is_active' : $('#formUpdateUser').find("input[name='is_active']:checked").val(),
            }

            console.log(data);

            $.ajax({
                type: "POST",
                url: "{{route('ajax.user.update')}}",
                data: data,
                success: function(res) {
                    console.log('after update')
                    console.log(res);
                    if (!res.error) {
                        $('#modalUpdateUser').modal('hide');
                        // showSuccess("Data berhasil disimpan");
                        swalSuccess({
                            text: 'Data berhasil disimpan',
                            withConfirmButton: true,
                            withReloadTable: true,
                            table: table
                        });
                    } else {
                        swalError({
                            text: 'Data gagal disimpan'
                        });
                    }
                }
            });
        });
    });
</script>
@endsection
