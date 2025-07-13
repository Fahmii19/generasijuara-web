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
                            Daftar Alumni
                        </h1>
                    </div>
                    <div class="col-3 col-xl-auto mb-3">
                        <a class="btn btn-sm btn-light text-primary" href="{{route('web.su.alumni.add')}}">
                            <i class="me-1" data-feather="plus"></i>
                            Add
                        </a>
                        <a class="btn btn-sm btn-light text-primary" href="#" id="importAlumniBtn">
                            <i class="me-1" data-feather="file"></i>
                            Import Alumni Excel
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
                <table class="table table-bordered" id="dtAlumni" width="100%" cellspacing="0">
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
                    {{-- <input class="form-control" id="id" type="hidden" placeholder=""> --}}
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

<!-- Modal Import Alumni-->
<div class="modal fade" id="modalImportAlumni" data-bs-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="modalImportAlumniLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalImportAlumniLabel">Import</h5>
                <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="formImportAlumni" method="POST" action="" novalidate>
                    @csrf
                    <div class="mb-3 col-md-6">
                        <label class="small mb-1" for="import_file_alumni">File</label>
                        <input class="form-control" id="import_file_alumni" type="file" placeholder="" value="" />
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary" type="button" data-bs-dismiss="modal">Close</button>
                <button class="btn btn-primary" type="button" id="submitImportAlumniBtn">Submit</button>
            </div>
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

        table = $('#dtAlumni').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: "{{route('ajax.dt.alumni.get')}}",
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
                    "title" : "Nama",
                    "width" : "12%",
                    "data"  : "nama"
                },
                {
                    "title" : "NIS",
                    "width" : "15%",
                    "data"  : "nis"
                },
                {
                    "title" : "HP",
                    "width" : "15%",
                    "data"  : "no_hp"
                },
                {
                    "title" : "Tahun Akademik",
                    "width" : "20%",
                    "data"  : "tahun_akademik_ket",
                },
                {
                    "title": "Status",
                    "width": "10%",
                    "data": "lanjut_kuliah",
                    "render": function(data, type, row) {
                        console.log(data);
                        if (data == 1) {
                            return '<span class="badge bg-green-soft text-green">Lanjut</span>';
                        } else if (data == 0) {
                            return '<span class="badge bg-yellow-soft text-yellow">Tidak Lanjut</span>';
                        }
                        // Optional: handle other cases if needed
                        return ''; // default return if neither 0 nor 1
                    }
                },
                {
                    "title" :  "Action",
                    "data"  : null,
                    "width" : "8%",
                    "orderable"     : false,
                    "searchable"    : false,
                    render  : function (data,type, row){
                        return '<a href="{{route('web.su.alumni.edit')}}/'+row.id+'" class="editAlumni btn btn-sm btn-transparent-dark"><i class="fas fa-edit"></i></a>'+
                        '<a href="#" class="deleteAlumni btn btn-sm btn-transparent-dark" data-id="'+row.id+'"><i class="fas fa-trash"></i></a>'
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

        var importFile = null;

        $('#import_file_alumni').on('change',function(){
            if(this.files && this.files[0]){
                importFile = this.files[0]
            }
        });

        $('#importAlumniBtn').on('click', function(){
            $('#modalImportAlumni').modal('show');
            $('#formImportAlumni').trigger('reset');
            importFile = null;
        });

        $('#submitImportAlumniBtn').on('click', function(e){
            e.preventDefault();
            var form = $("#formImportAlumni");

            if (importFile == null) {
                // showError('importFile tidak ditemukan');
                swalError({text: 'importFile tidak ditemukan'});
                return false;
            }

            enableLoadingButton("#submitImportAlumniBtn");

            var formData = new FormData();

            formData.append('_token', "{{ csrf_token() }}");
            formData.append('import_file_alumni', importFile);

            $.ajax({
                type: "POST",
                url: "{{route('ajax.alumni.import_alumni_excel')}}",
                cache : false,
                processData: false,
                contentType: false,
                data: formData,
                success: function(res) {
                    disableLoadingButton("#submitImportAlumniBtn");
                    if (!res.error) {
                        // showSuccess(res.message || "Success");
                        $('#modalImportAlumni').modal('hide');
                        swalSuccess({
                            text: 'Berhasil diimport',
                            withConfirmButton: true,
                            withReloadTable: true,
                            table: table
                        })
                    }else{
                        // showError('failed');
                        swalError({text: 'Gagal diimport'});
                    }
                },
                error: function(response, textStatus, errorThrown){
                    disableLoadingButton("#submitImportAlumniBtn");
                    ajaxCallbackError(response);
                }
            });
        });

        $('#dtAlumni').on('click', '.deleteAlumni', function(e){
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
                        url: "{{route('ajax.alumni.delete')}}",
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
    });
</script>
@endsection
