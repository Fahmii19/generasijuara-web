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
                            Paket Kelas ABC
                        </h1>
                    </div>
                    <div class="col-12 col-xl-auto mb-3">
                        <!-- <a class="btn btn-sm btn-light text-primary" href="#" id="addPaketKelasBtn">
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
                <div class="table-responsive">
                    <table class="table table-bordered" id="dtPaketKelas" width="100%" cellspacing="0">
                    </table>
                </div>
            </div>
        </div>
    </div>
</main>

<!-- Modal -->
<div class="modal fade" id="modalPaketKelas" data-bs-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="modalPaketKelasLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalPaketKelasLabel">Form</h5>
                <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="formPaketKelas" method="POST" action="" novalidate>
                    @csrf
                    <div class="mb-3">
                        <label><strong>Data</strong></label>
                    </div>
                    <input class="form-control" id="id" type="hidden" placeholder="">
                    <div class="mb-3">
                        <label for="kode">Kode</label>
                        <input class="form-control" id="kode" type="text" placeholder="">
                    </div>
                    <div class="mb-3">
                        <label for="nama">Nama</label>
                        <input class="form-control" id="nama" type="text" placeholder="">
                    </div>
                    <div class="mb-3">
                        <label for="type">Tipe Kelas</label>
                        <select class="form-control" id="type"></select>
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
@stop

@section('style_extra')

@endsection

@section('js_extra')

<script type="text/javascript">
    $(document).ready(function() {
        var table = null
        var typeSelected = "{{$type}}";

        $("#type").attr('disabled','disabled')

        getType();
        function getType() {
            $.ajax({
                type: "POST",
                url: "{{route('ajax.kelas.get_type')}}",
                data: {
                    "_token": "{{ csrf_token() }}",
                },
                success: function(res) {
                    // console.log(res);
                    var html_results = "";
                    $.each(res.data, function (i, row) {
                        html_results += "<option value='"+i+"'>"+row+"</option>";
                    });
                    $('#type').html(html_results);

                    if (typeSelected != null) {
                        $('#type').val(typeSelected);
                    }
                }
            });
        }

        table = $('#dtPaketKelas').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: "{{route('ajax.dt.paket_kelas.get')}}",
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
                    "title":"Kode",
                    "width":"12%",
                    "data":"kode"
                },
                {
                    "title":"Nama",
                    "width":"15%",
                    "data":"nama"
                },
                {
                    "title":"Type",
                    "width":"15%",
                    "data":"type",
                    render: function (data, type, row) {
                        if (data == 0) {
                            return 'ABC';
                        }else{
                            return 'PAUD';
                        }
                    }
                },
                {
                    "title":"Status",
                    "width":"12%",
                    "data":"is_active",
                    render: function (data, type, row) {
                        if (data) {
                            return '<span class="badge bg-green-soft text-green">Aktif</span>';
                        }else{
                            return '<span class="badge bg-yellow-soft text-yellow">Tidak Aktif</span>';
                        }
                    }
                },
                // {
                //     "title": "Action",
                //     "data":null,
                //     "width":"15%",
                //     "orderable":false,
                //     "searchable":false,
                //     render: function (data,type, row){
                //         return '<a href="#" class="editPaketKelasBtn btn btn-sm btn-transparent-dark" data-id="'+row.id+'"><i class="fas fa-edit"></i></a>'+
                //         '<a href="#" class="deletePaketKelasBtn btn btn-sm btn-transparent-dark" data-id="'+row.id+'"><i class="fas fa-trash"></i></a>'
                //     }
                // }
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

        $('#dtPaketKelas').on('click', '.editPaketKelasBtn', function(){
            var id = $(this).data('id');
            console.log(id);
            $('#modalPaketKelas').modal('show');
            $('#formPaketKelas').trigger("reset");
            $('#formPaketKelas').find('#id').val(null);
            $.ajax({
                type: "POST",
                url: "{{route('ajax.paket_kelas.get')}}",
                data: {
                    'id' : id,
                    "_token": "{{ csrf_token() }}"
                },
                success: function(res) {
                    console.log(res)
                    if (!res.error) {
                        $('#formPaketKelas').find('#id').val(res.data.id);
                        $('#formPaketKelas').find('#nama').val(res.data.nama);
                        $('#formPaketKelas').find('#kode').val(res.data.kode);
                        $('#formPaketKelas').find('#type').val(res.data.type);
                        $('#formPaketKelas').find('#layanan_kelas_id').val(res.data.layanan_kelas_id);
                        if (res.data.is_active) {
                            $('#formPaketKelas').find('#is_active').prop('checked', true);
                        }else{
                            $('#formPaketKelas').find('#is_active').prop('checked', false);
                        }
                    }
                }
            });
        });

        $('#dtPaketKelas').on('click', '.deletePaketKelasBtn', function(e){
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
                        url: "{{route('ajax.paket_kelas.delete')}}",
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
            //     url: "{{route('ajax.paket_kelas.delete')}}",
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

        $('#addPaketKelasBtn').on('click', function(){
            $('#modalPaketKelas').modal('show');
            $('#formPaketKelas').trigger("reset");
            $('#formPaketKelas').find('#id').val(null);
            if (typeSelected != null) {
                $('#formPaketKelas').find('#type').val(typeSelected);
            }
        });

        //Submit Call
        $('#submitTutorBtn').on('click', function(e){
            e.preventDefault();
            var form = $("#formPaketKelas");
            // if (!checkForm(form)) {
            //     return false;
            // }

            // $('#spinner-toast').modal('show');

            var data = {
                "_token": "{{ csrf_token() }}",
                'id' : $('#formPaketKelas').find('#id').val(),
                'nama' : $('#formPaketKelas').find('#nama').val(),
                'kode' : $('#formPaketKelas').find('#kode').val(),
                'type' : $('#formPaketKelas').find('#type').val(),
                'layanan_kelas_id' : $('#formPaketKelas').find('#layanan_kelas_id').val(),
                'is_active' : $('#formPaketKelas').find("#is_active").is(":checked"),
            }
            console.log('submit', data);
            $.ajax({
                type: "POST",
                url: "{{route('ajax.paket_kelas.save')}}",
                data: data,
                success: function(res) {
                    console.log(res);
                    // $('#spinner-toast').modal('hide');

                    if (!res.error) {
                        $('#modalPaketKelas').modal('hide');
                        // $("#link-next").attr("href", "#");
                        // $('#success-modal').modal('show');
                        // $('#success-modal-btn-ok').on('click', function(){
                        //     $('#success-modal').modal('hide');
                        // });
                        table.ajax.reload();
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
