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
                            Berita
                        </h1>
                    </div>
                    <div class="col-12 col-xl-auto mb-3">
                        <a class="btn btn-sm btn-light text-primary" href="{{route('web.su.news.add')}}">
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
                <table class="table table-bordered" id="dtBerita" width="100%" cellspacing="0">
                </table>
            </div>
        </div>
    </div>
</main>
@stop

@section('style_extra')

@endsection

@section('js_extra')
<script type="text/javascript">
    $(document).ready(function() {
        var table = null

        table = $('#dtBerita').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: "{{route('ajax.dt.news.get')}}",
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
                    "title" : "Title",
                    "width" : "12%",
                    "data"  : "title"
                },
                {
                    "title" : "Status",
                    "width" : "12%",
                    "data"  : "is_active",
                    render  : function (data, type, row) {
                        return getActiveStatusStr(data)
                    }
                },
                {
                    "title" :  "Action",
                    "data"  : null,
                    "width" : "15%",
                    "orderable"     : false,
                    "searchable"    : false,
                    render  : function (data,type, row){
                        return '<a href="{{route('web.su.news.edit')}}/'+row.id+'" class="editNewsBtn btn btn-sm btn-transparent-dark"><i class="fas fa-edit"></i></a>'+
                        '<a href="#" class="deleteNewsBtn btn btn-sm btn-transparent-dark" data-id="'+row.id+'"><i class="fas fa-trash"></i></a>'
                    }
                }
            ],
            order:[[1,'asc']],
            columnDefs:[]
        });
        
        $('#input-search-table').on( 'keyup change clear',function() {
            table.search($(this).val()).draw()
        })

        $('#dtBerita').on('click', '.deleteNewsBtn', function(e){
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
                        url: "{{route('ajax.news.delete')}}",
                        data: data,
                        withSuccessMessage: true,
                        successMessage: 'Data berhasil dihapus',
                        withReloadTable: true,
                        table: table
                    });
                }
            });

            // $.ajax({
            //     type: "POST",
            //     url: "{{route('ajax.news.delete')}}",
            //     data: data,
            //     success: function(res) {
            //         if (!res.error) {
            //             table.ajax.reload();
            //         }else{

            //         }
            //     }
            // });
        });
    });
</script>
@endsection
