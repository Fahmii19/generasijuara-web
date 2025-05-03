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
                            Daftar Murid Baru - Paket ABC
                        </h1>
                    </div>
                    <div class="col-12 col-xl-auto mb-3">
                        <a class="btn btn-sm btn-light text-primary" href="{{route('web.su.ppdb.abc.add')}}">
                            <i class="me-1" data-feather="plus"></i>
                            Add
                        </a>
                        <!-- <a class="btn btn-sm btn-light text-primary" href="#">
                            <i class="me-1" data-feather="file"></i>
                            PDF
                        </a>
                        <a class="btn btn-sm btn-light text-primary" href="#">
                            <i class="me-1" data-feather="file"></i>
                            Excel/CSV
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
                <table class="table table-bordered" id="dtPPDB" width="100%" cellspacing="0">
                </table>
            </div>
        </div>
    </div>
</main>

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

<!-- Modal Status Akun -->
<div class="modal fade" id="modalStatusAcc" data-bs-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="modalStatusAccLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalStatusAccLabel">Change Account Status</h5>
                <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="formStatusAcc" method="POST" action="" novalidate>
                    @csrf
                    <input class="form-control" id="id" type="hidden" placeholder="">
                    <div class="mb-3">
                        <label for="password">Account Status</label>
                        <select class="form-control" id="status" type="text" placeholder="">
                            <option value="1">Active</option>
                            <option value="0">Blocked</option>
                        </select>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary" type="button" data-bs-dismiss="modal">Close</button>
                <button class="btn btn-primary" type="button" id="submitStatusAcc">Submit</button>
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
        var typeSelected = "{{$type}}";

        table = $('#dtPPDB').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: "{{route('ajax.dt.ppdb.get')}}",
                dataType: "json",
                "data": function ( d ) {
                    d._token = "{{ csrf_token() }}",
                    d.type = "{{$type}}"
                },
                type: "POST",
            },
            bSort: true,
            searching: true,
            lengthChange: true,
            scrollX: true,
            columns:[
                {
                    "title" : "Nama",
                    "width" : "12%",
                    "data"  : "nama"
                },
                {
                    "title" : "NIK",
                    "width" : "15%",
                    "data"  : "nik_siswa"
                },
                {
                    "title" : "NIS",
                    "width" : "15%",
                    "data"  : "nis"
                },
                {
                    "title" : "HP",
                    "width" : "15%",
                    "data"  : "hp_siswa"
                },
                {
                    "title" : "Layanan Kelas",
                    "width" : "15%",
                    "data"  : "lk_nama",
                    "name"  : "lk.nama"
                },
                {
                    "title" : "Paket Kelas",
                    "width" : "15%",
                    "data"  : "pk_nama",
                    "name"  : "pk.nama"
                },
                {
                    "title" : "Kelas Tujuan",
                    "width" : "15%",
                    "data"  :  "kelas"
                },
                {
                    "title" : "Status",
                    "width" : "12%",
                    "data"  : "is_active",
                    render  : function (data, type, row) {
                        if (data) {
                            return '<span class="badge bg-green-soft text-green">Aktif</span>';
                        }else{
                            return '<span class="badge bg-yellow-soft text-yellow">Tidak Aktif</span>';
                        }
                    }
                },
                {
                    "title" : "Status Akun",
                    "width" : "12%",
                    "data"  : "user_detail.is_active",
                    render  : function (data, type, row) {
                        if (data) {
                            return '<span class="badge bg-green-soft text-green">Aktif</span>';
                        }else{
                            return '<span class="badge bg-yellow-soft text-danger">Diblokir</span>';
                        }
                    }
                },
                {
                    "title" :  "Action",
                    "data"  : null,
                    "width" : "15%",
                    "orderable"     : false,
                    "searchable"    : false,
                    render  : function (data,type, row){
                        return '<a href="{{route('web.su.ppdb.abc.edit')}}/'+row.id+'" class="editPPDB btn btn-sm btn-transparent-dark"><i class="fas fa-edit"></i></a>'+
                        '<a href="#" class="editPwdBtn btn-transparent-dark btn btn-sm" data-id="'+row.id+'"><i class="fas fa-key"></i></a>'+
                        '<a href="#" class="editStatusAccBtn btn-transparent-dark btn btn-sm" data-id="'+row.id+'"><i class="fas fa-user"></i></a>'
                        // '<a href="#" class="deletePPDB btn btn-sm btn-transparent-dark" data-id="'+row.id+'"><i class="fas fa-trash"></i></a>'
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

        $('#dtPPDB').on('click', '.editPwdBtn', function(){
            var id = $(this).data('id');
            $('#modalPwd').modal('show');
            $('#formPwd').trigger("reset");
            $('#formPwd').find('#id').val(id);
        });

        $('#dtPPDB').on('click', '.editStatusAccBtn', function(){
            var id = $(this).data('id');
            $('#formStatusAcc').trigger("reset");
            $('#formStatusAcc').find('#id').val(id);

            var url = "{{route('ajax.ppdb.get_account_status', ':id')}}";
            url = url.replace(':id', id);
            $.ajax({
                type: "POST",
                url: url,
                data: {
                    _token: "{{ csrf_token() }}",
                },
                success: function(res) {
                    if (!res.error) {
                        $('#formStatusAcc').find('#status').val(res.data).change();
                        $('#modalStatusAcc').modal('show');
                    }
                }
            });
        });

        $('#dtPPDB').on('click', '.deletePPDB', function(e){
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
                        url: "{{route('ajax.ppdb.delete')}}",
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
            //     url: "{{route('ajax.ppdb.delete')}}",
            //     data: data,
            //     success: function(res) {
            //         if (!res.error) {
            //             table.ajax.reload();
            //         }else{
            //         }
            //     }
            // });
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
                url: "{{route('ajax.ppdb.change_password')}}",
                data: data,
                success: function(res) {
                    console.log(res);

                    if (!res.error) {
                        $('#modalPwd').modal('hide');
                        swalSuccess({
                            text: 'Berhasil mengganti password',
                            withConfirmButton: true,
                            withReloadTable: true,
                            table: table
                        })
                    }else{
                        
                    }
                }
            });
        });

        $('#submitStatusAcc').on('click', function(e){
            e.preventDefault();
            var form = $("#formStatusAcc");

            var data = {
                "_token": "{{ csrf_token() }}",
                'id' : $('#formStatusAcc').find('#id').val(),
                'status' : $('#formStatusAcc').find('#status').val(),
            }

            $.ajax({
                type: "POST",
                url: "{{route('ajax.ppdb.change_account_status')}}",
                data: data,
                success: function(res) {
                    if (!res.error) {
                        $('#modalStatusAcc').modal('hide');
                        swalSuccess({
                            text: 'Berhasil mengganti status akun',
                            withConfirmButton: true,
                            withReloadTable: true,
                            table: table
                        })
                    }
                }
            });
        });
    });
</script>
@endsection
