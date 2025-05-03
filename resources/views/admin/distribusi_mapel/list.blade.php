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
                            Distribusi Mapel List
                        </h1>
                    </div>
                    <div class="col-12 col-xl-auto mb-3">
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
                    </table>
                </div>
            </div>
        </div>
    </div>
</main>

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
                url: "{{route('ajax.dt.distribusi_mapel.get')}}",
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
                    "title":"Kelas",
                    "width":"12%",
                    "data":"kelas_num",
                    "name":"d.kelas_num"
                },
                {
                    "title":"Mapel",
                    "width":"12%",
                    "data":"mp_name",
                    "name":"mp_name"
                },
                {
                    "title":"Tutor",
                    "width":"15%",
                    "data":"tutor_name",
                    "name":"tutor_name"
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
                url: "{{route('ajax.distribusi_mapel.import_excel')}}",
                cache : false,
                processData: false,
                contentType: false,
                data: formData,
                success: function(res) {
                    disableLoadingButton("#submitImportBtn");
                    if (!res.error) {
                        showSuccess(res.message || "Success");
                        $('#modalImport').modal('hide');
                        table.ajax.reload();
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
