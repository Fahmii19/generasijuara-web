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
                            Daftar Ulang - PAUD
                        </h1>
                    </div>
                    <div class="col-12 col-xl-auto mb-3">
                        <!-- <a class="btn btn-sm btn-light text-primary" href="{{route('web.su.ppdb_ulang.paud.add')}}">
                            <i class="me-1" data-feather="plus"></i>
                            Add
                        </a> -->
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
                <table class="table table-bordered" id="dtPPDBUlang" width="100%" cellspacing="0">
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
        var typeSelected = "{{$type}}";

        table = $('#dtPPDBUlang').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: "{{route('ajax.dt.ppdb_ulang.get')}}",
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
                        if (data == 1) {
                            return '<span class="badge bg-green-soft text-green">Aktif</span>';
                        }else{
                            return '<span class="badge bg-yellow-soft text-yellow">Tidak Aktif</span>';
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
                        return '<a href="{{route('web.su.ppdb_ulang.paud.edit')}}/'+row.id+'" class="editPPDB btn btn-sm btn-transparent-dark"><i class="fas fa-edit"></i></a>'
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
    });
</script>
@endsection
