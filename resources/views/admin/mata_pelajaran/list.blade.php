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
                            Mata Pelajaran
                        </h1>
                    </div>
                    <div class="col-12 col-xl-auto mb-3">
                        <a class="btn btn-sm btn-light text-primary" href="#" id="addMataPelajaranBtn">
                            <i class="me-1" data-feather="plus"></i>
                            Add
                        </a>
                        <a class="btn btn-sm btn-light text-primary" href="#">
                            <i class="me-1" data-feather="file"></i>
                            PDF
                        </a>
                        <a class="btn btn-sm btn-light text-primary" href="#">
                            <i class="me-1" data-feather="file"></i>
                            Excel/CSV
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
                    <table class="table table-bordered" id="dtMataPelajaran" width="100%" cellspacing="0">
                    </table>
                </div>
            </div>
        </div>
    </div>
</main>

<!-- Modal -->
<div class="modal fade" id="modalMataPelajaran" data-bs-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="modalMataPelajaranLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalMataPelajaranLabel">Form</h5>
                <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="formMataPelajaran" method="POST" action="" novalidate>
                    @csrf
                    <div class="mb-3">
                        <label><strong>Data</strong></label>
                    </div>
                    <input class="form-control" id="id" type="hidden" placeholder="">
                    <div class="mb-3">
                        <label for="nama">Nama Mata Pelajaran</label>
                        <input class="form-control" id="nama" type="text" placeholder="">
                    </div>
                    <div class="mb-3">
                        <label for="kelompok">Kelompok</label>
                        <select class="form-control" id="kelompok">
                            <option value>-- Pilih Kelompok --</option>
                            <option value="kelompok_khusus">Kelompok Khusus</option>
                            <option value="kelompok_umum">Kelompok Umum</option>
                            <option value="iis">Peminatan IPS (IIS)</option>
                            <option value="mia">Peminatan IPA (MIA)</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="sub_kelompok">Sub Kelompok</label>
                        <select class="form-control" id="sub_kelompok">
                            <option value>-- Pilih Sub Kelompok --</option>
                            <option value="pemberdayaan">Pemberdayaan</option>
                            <option value="keterampilan_wajib">Keterampilan Wajib</option>
                            <option value="keterampilan_pilihan">Keterampilan Pilihan</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <div class="form-check">
                            <input class="form-check-input" id="is_active" name="is_active" type="checkbox" value="">
                            <label class="form-check-label" for="is_active">Set Aktif</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" id="is_mapel_ekskul" name="is_mapel_ekskul" type="checkbox" value="">
                            <label class="form-check-label" for="is_mapel_ekskul">Set Mata Pelajaran Ekstrakuliker</label>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer"><button class="btn btn-secondary" type="button" data-bs-dismiss="modal">Close</button><button class="btn btn-primary" type="button" id="submitMataPelajaranBtn">Submit</button></div>
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

        table = $('#dtMataPelajaran').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: "{{route('ajax.dt.mata_pelajaran.get')}}",
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
                    "title":"Nama",
                    "width":"15%",
                    "data":"nama"
                },
                {
                    "title":"Kelompok",
                    "width":"10%",
                    "data":"kelompok",
                    render: function (data, type, row) {
                        if (data == 'kelompok_khusus') {
                            return 'Kelompok Khusus';
                        }else if (data == 'kelompok_umum') {
                            return 'Kelompok Umum';
                        }else{
                            return data;
                        }
                    }
                },
                {
                    "title":"Sub Kelompok",
                    "width":"10%",
                    "data":"sub_kelompok",
                    render: function (data, type, row) {
                        if (data == 'keterampilan') {
                            return 'Keterampilan';
                        }else if (data == 'pemberdayaan') {
                            return 'Pemberdayaan';
                        }else{
                            return data;
                        }
                    }
                },
                {
                    "title":"Mapel Ekskul",
                    "width":"10%",
                    "data":"is_mapel_ekskul",
                    render: function (data, type, row) {
                        if (data == 1) {
                            return 'Ya';
                        }else {
                            return 'Tidak'
                        }
                    },
                    searchable: false
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
                {
                    "title": "Action",
                    "data":null,
                    "width":"15%",
                    "orderable":false,
                    "searchable":false,
                    render: function (data,type, row){
                        return '<a href="#" class="editRowBtn btn btn-sm btn-transparent-dark" data-id="'+row.id+'"><i class="fas fa-edit"></i></a>'+
                        '<a href="#" class="deleteRowBtn btn btn-sm btn-transparent-dark" data-id="'+row.id+'"><i class="fas fa-trash"></i></a>'
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

        $('#dtMataPelajaran').on('click', '.editRowBtn', function(){
            var id = $(this).data('id');
            console.log(id);
            $('#modalMataPelajaran').modal('show');
            $('#formMataPelajaran').trigger("reset");
            $('#formMataPelajaran').find('#id').val(null);
            $.ajax({
                type: "POST",
                url: "{{route('ajax.mata_pelajaran.get')}}",
                data: {
                    'id' : id,
                    "_token": "{{ csrf_token() }}"
                },
                success: function(res) {
                    console.log(res)
                    if (!res.error) {
                        $('#formMataPelajaran').find('#id').val(res.data.id);
                        $('#formMataPelajaran').find('#nama').val(res.data.nama);
                        $('#formMataPelajaran').find('#kelompok').val(res.data.kelompok);
                        $('#formMataPelajaran').find('#sub_kelompok').val(res.data.sub_kelompok);
                        if (res.data.is_active) {
                            $('#formMataPelajaran').find('#is_active').prop('checked', true);
                        }else{
                            $('#formMataPelajaran').find('#is_active').prop('checked', false);
                        }

                        if (res.data.is_mapel_ekskul) {
                            $('#formMataPelajaran').find('#is_mapel_ekskul').prop('checked', true);
                        }else{
                            $('#formMataPelajaran').find('#is_mapel_ekskul').prop('checked', false);
                        }
                    }
                }
            });
        });

        $('#dtMataPelajaran').on('click', '.deleteRowBtn', function(e){
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
                        url: "{{route('ajax.mata_pelajaran.delete')}}",
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
            //     url: "{{route('ajax.mata_pelajaran.delete')}}",
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

        $('#addMataPelajaranBtn').on('click', function(){
            $('#modalMataPelajaran').modal('show');
            $('#formMataPelajaran').trigger("reset");
            $('#formMataPelajaran').find('#id').val(null);
        });

        //Submit Call
        $('#submitMataPelajaranBtn').on('click', function(e){
            e.preventDefault();
            var form = $("#formMataPelajaran");
            // if (!checkForm(form)) {
            //     return false;
            // }

            // $('#spinner-toast').modal('show');

            var data = {
                "_token": "{{ csrf_token() }}",
                'id' : $('#formMataPelajaran').find('#id').val(),
                'nama' : $('#formMataPelajaran').find('#nama').val(),
                'kelompok' : $('#formMataPelajaran').find('#kelompok').val(),
                'sub_kelompok' : $('#formMataPelajaran').find('#sub_kelompok').val(),
                'is_active' : $('#formMataPelajaran').find("#is_active").is(":checked"),
                'is_mapel_ekskul' : $('#formMataPelajaran').find("#is_mapel_ekskul").is(":checked"),
            }
            console.log('submit', data);
            $.ajax({
                type: "POST",
                url: "{{route('ajax.mata_pelajaran.save')}}",
                data: data,
                success: function(res) {
                    console.log(res);
                    // $('#spinner-toast').modal('hide');

                    if (!res.error) {
                        $('#modalMataPelajaran').modal('hide');
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
    });
</script>
@endsection
