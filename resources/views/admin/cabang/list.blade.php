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
                            Cabang
                        </h1>
                    </div>
                    <div class="col-12 col-xl-auto mb-3">
                        <a class="btn btn-sm btn-light text-primary" href="#" id="addCabangBtn">
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
                    <table class="table table-bordered" id="dtCabang" width="100%" cellspacing="0">
                    </table>
                </div>
            </div>
        </div>
    </div>
</main>

<!-- Modal -->
<div class="modal fade" id="modalCabang" data-bs-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="modalCabangLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalCabangLabel">Form</h5>
                <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="formCabang" novalidate>
                    @csrf
                    <input class="form-control" id="id" type="hidden" placeholder="">
                    <div class="mb-3">
                        <label for="nama_cabang">Nama Cabang</label>
                        <input class="form-control" id="nama_cabang" type="text" placeholder="" autocomplete="off">
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary" type="button" data-bs-dismiss="modal">Close</button>
                <button class="btn btn-primary" type="button" id="submitCabangBtn">Submit</button>
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
        table = $('#dtCabang').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: "{{route('ajax.dt.cabang.get')}}",
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
                    "title":"Nama Cabang",
                    "width":"80%",
                    "data":"nama_cabang"
                },
                {
                    "title": "Action",
                    "data":null,
                    "width":"15%",
                    "orderable":false,
                    "searchable":false,
                    render: function (data,type,row){
                        return '<a href="#" class="editCabangBtn btn btn-sm btn-transparent-dark" data-id="'+row.id+'"><i class="fas fa-edit"></i></a>'+
                        '<a href="#" class="deleteCabangBtn btn btn-sm btn-transparent-dark" data-id="'+row.id+'"><i class="fas fa-trash"></i></a>'
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

        $('#dtCabang').on('click', '.editCabangBtn', function(){
            var id = $(this).data('id');
            console.log(id);
            $('#modalCabang').modal('show');
            $('#formCabang').trigger("reset");
            $('#formCabang').find('#id').val(null);
            $.ajax({
                type: "POST",
                url: "{{route('ajax.cabang.get')}}",
                data: {
                    'id' : id,
                    "_token": "{{ csrf_token() }}"
                },
                success: function(res) {
                    console.log(res)
                    if (!res.error) {
                        $('#formCabang').find('#id').val(res.data.id);
                        $('#formCabang').find('#nama_cabang').val(res.data.nama_cabang);
                    }
                }
            });
        });

        $('#dtCabang').on('click', '.deleteCabangBtn', function(e){
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
                        url: "{{route('ajax.cabang.delete')}}",
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
            //     url: "{{route('ajax.cabang.delete')}}",
            //     data: data,
            //     success: function(res) {
            //         if (!res.error) {
            //             table.ajax.reload();
            //             showSuccess("Data berhasil dihapus");
            //         }
            //     }
            // });
        });

        $('#addCabangBtn').on('click', function(){
            $('#modalCabang').modal('show');
            $('#formCabang').trigger("reset");
            $('#formCabang').find('#id').val(null);
        });

        //Submit Call
        $('#submitCabangBtn').on('click', function(e){
            e.preventDefault();
            var form = $("#formCabang");
            var data = {
                "_token": "{{ csrf_token() }}",
                'id' : $('#formCabang').find('#id').val(),
                'nama_cabang' : $('#formCabang').find('#nama_cabang').val(),
            }
            $.ajax({
                type: "POST",
                url: "{{route('ajax.cabang.save')}}",
                data: data,
                success: function(res) {
                    console.log(res);
                    if (!res.error) {
                        $('#modalCabang').modal('hide');
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
