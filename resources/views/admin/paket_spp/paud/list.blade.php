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
                            Paket SPP PAUD
                        </h1>
                    </div>
                    <div class="col-12 col-xl-auto mb-3">
                        <a class="btn btn-sm btn-light text-primary" href="#" id="addPaketSppBtn">
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
                <div class="table-responsive">
                    <table class="table table-bordered" id="dtPaketSpp" width="100%" cellspacing="0">
                    </table>
                </div>
            </div>
        </div>
    </div>
</main>

<!-- Modal -->
<div class="modal fade" id="modalPaketSpp" data-bs-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="modalPaketSppLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalPaketSppLabel">Form</h5>
                <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="formPaketSpp" method="POST" action="" novalidate>
                    @csrf
                    <div class="mb-3">
                        <label><strong>Data</strong></label>
                    </div>
                    <input class="form-control" id="id" type="hidden" placeholder="">
                    <div class="mb-3">
                        <label for="cabang_id">Cabang</label>
                        <select class="form-control" id="cabang_id" name="cabang_id"></select>
                    </div>

                    <div class="mb-3">
                        <label for="layanan_kelas_id">Layanan Kelas</label>
                        <select class="form-control" id="layanan_kelas_id"></select>
                    </div>
                    <div class="mb-3">
                        <label for="paket_kelas_id">Paket Kelas</label>
                        <select class="form-control" id="paket_kelas_id"></select>
                    </div>
                    <div class="mb-3">
                        <label for="semester">Semester</label>
                        <input class="form-control" id="semester" type="number">
                    </div>
                    <div class="mb-3">
                        <label for="biaya">Biaya</label>
                        <input class="form-control ribuan-format" id="biaya" type="text" placeholder="">
                    </div>
                    <div class="mb-3">
                        <label for="biaya_program">Program</label>
                        <input class="form-control ribuan-format" id="biaya_program" type="text" placeholder="">
                    </div>
                    <div class="mb-3">
                        <label for="biaya_pendaftaran">Pendaftaran</label>
                        <input class="form-control ribuan-format" id="biaya_pendaftaran" type="text" placeholder="">
                    </div>
                    <div class="mb-3">
                        <label for="jenis_pendaftaran">Jenis</label>
                        <select class="form-control" id="jenis_pendaftaran">
                            <option value="1">Pendaftaran Baru</option>
                            <option value="2">Pendaftaran Ulang</option>
                            <option value="3">Pendaftaran Alumni</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="keterangan">Keterangan</label>
                        <input class="form-control" id="keterangan" type="text" placeholder="">
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
            <div class="modal-footer"><button class="btn btn-secondary" type="button" data-bs-dismiss="modal">Close</button><button class="btn btn-primary" type="button" id="submitPaketSpp">Submit</button></div>
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

        getCabang();
        function getCabang() {
            $.ajax({
                type: "POST",
                url: "{{route('ajax.cabang.get')}}",
                data: {
                    "_token": "{{ csrf_token() }}",
                },
                success: function(res) {
                    console.log(res);
                    var html_results = "<option value=''>-- Pilih Cabang --</option>";
                    $.each(res.data, function (i, row) {
                        html_results += "<option value='"+row.id+"'>"+row.nama_cabang+"</option>";
                    });
                    $('#cabang_id').html(html_results);
                    if (cabangSelected != null) {
                        $('#cabang_id').val(cabangSelected);
                    }
                }
            });
        }

        getType();
        function getType() {
            $.ajax({
                type: "POST",
                url: "{{route('ajax.kelas.get_type')}}",
                data: {
                    "_token": "{{ csrf_token() }}",
                },
                success: function(res) {
                    var html_results = "<option value=''>-- Pilih --</option>";
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

        getLayananKelas();
        function getLayananKelas() {
            $.ajax({
                type: "POST",
                url: "{{route('ajax.layanan_kelas.get_all')}}",
                data: {
                    "_token": "{{ csrf_token() }}",
                },
                success: function(res) {
                    var html_results = "<option value=''>-- Pilih --</option>";
                    $.each(res.data, function (i, row) {
                        html_results += "<option value='"+row.id+"'>"+row.kode+"</option>";
                    });
                    $('#layanan_kelas_id').html(html_results);
                }
            });
        }

        getPaketKelas();
        function getPaketKelas() {
            const paramSpp = {
                'type' : typeSelected,
            };
            getPaketKelasWithParamsOptions(paramSpp, function(output){
                $("#paket_kelas_id").html(output);
                if (paketKelasSelected != null) {
                    $('#paket_kelas_id').val(paketKelasSelected);
                }
            });
        }

        table = $('#dtPaketSpp').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: "{{route('ajax.dt.paket_spp.get')}}",
                dataType: "json",
                "data": function ( d ) {
                    d._token = "{{ csrf_token() }}",
                    d.type = typeSelected
                },
                type: "POST",
            },
            bSort: true,
            searching: true,
            lengthChange: true,
            scrollX: true,
            columns:[
                {
                    "title":"Cabang",
                    "width":"12%",
                    "data":"cb_nama",
                    "render": function(data, type, row, meta){
                        return data ?? '-';
                    }
                },
                {
                    "title":"Layanan",
                    "width":"12%",
                    "data":"lk_kode"
                },
                {
                    "title":"Paket",
                    "width":"15%",
                    "data":"pk_kode"
                },
                {
                    "title":"Semester",
                    "width":"15%",
                    "data":"semester",
                    "render": function(data, type, row, meta){
                        return data ?? '-';
                    }
                },
                {
                    "title":"Biaya",
                    "width":"15%",
                    "data":"biaya",
                    render: function (data, type, row) {
                        return formatRibuan(data);
                    }
                },
                {
                    "title":"Program",
                    "width":"15%",
                    "data":"biaya_program",
                    render: function (data, type, row) {
                        return formatRibuan(data);
                    }
                },
                {
                    "title":"Pendaftaran",
                    "width":"15%",
                    "data":"biaya_pendaftaran",
                    render: function (data, type, row) {
                        return formatRibuan(data);
                    }
                },
                {
                    "title":"Jenis",
                    "width":"15%",
                    "data":"jenis_pendaftaran",
                    render: function (data, type, row) {
                        if (data == 1) {
                            return 'Pendaftaran Baru';
                        }else if (data == 2){
                            return 'Pendaftaran Ulang';
                        }else{
                            return 'Pendaftaran Alumni';
                        }
                    }
                },
                {
                    "title":"Ket",
                    "width":"15%",
                    "data":"keterangan"
                },
                {
                    "title":"Type",
                    "width":"15%",
                    "data":"type",
                    render: function (data, type, row) {
                        if (data == 0) {
                            return 'ABC';
                        }else if (data == 0) {
                            return 'PAUD';
                        }else{
                            return 'Kelas Khusus';
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

        $('#dtPaketSpp').on('click', '.editRowBtn', function(){
            var id = $(this).data('id');
            console.log(id);
            $('#modalPaketSpp').modal('show');
            $('#formPaketSpp').trigger("reset");
            $('#formPaketSpp').find('#id').val(null);
            $.ajax({
                type: "POST",
                url: "{{route('ajax.paket_spp.get')}}",
                data: {
                    'id' : id,
                    "_token": "{{ csrf_token() }}"
                },
                success: function(res) {
                    console.log(res.data.semester)
                    if (!res.error) {
                        $('#formPaketSpp').find('#id').val(res.data.id);
                        $('#formPaketSpp').find('#layanan_kelas_id').val(res.data.layanan_kelas_id);
                        $('#formPaketSpp').find('#paket_kelas_id').val(res.data.paket_kelas_id);
                        $('#formPaketSpp').find('#semester').val(res.data.semester);
                        $('#formPaketSpp').find('#biaya').val(res.data.biaya);
                        $('#formPaketSpp').find('#biaya_program').val(res.data.biaya_program);
                        $('#formPaketSpp').find('#biaya_pendaftaran').val(res.data.biaya_pendaftaran);
                        $('#formPaketSpp').find('#jenis_pendaftaran').val(res.data.jenis_pendaftaran);
                        $('#formPaketSpp').find('#keterangan').val(res.data.keterangan);
                        $('#formPaketSpp').find('#type').val(res.data.type);
                        $('#formPaketSpp').find('#cabang_id').val(res.data.cabang_id);
                        if (res.data.is_active) {
                            $('#formPaketSpp').find('#is_active').prop('checked', true);
                        }else{
                            $('#formPaketSpp').find('#is_active').prop('checked', false);
                        }
                    }
                }
            });
        });

        $('#dtPaketSpp').on('click', '.deleteRowBtn', function(e){
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
                        url: "{{route('ajax.paket_spp.delete')}}",
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
            //     url: "{{route('ajax.paket_spp.delete')}}",
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

        $('#addPaketSppBtn').on('click', function(){
            $('#modalPaketSpp').modal('show');
            $('#formPaketSpp').trigger("reset");
            $('#formPaketSpp').find('#id').val(null);
            if (typeSelected != null) {
                $('#formPaketSpp').find('#type').val(typeSelected);
            }
        });

        //Submit Call
        $('#submitPaketSpp').on('click', function(e){
            e.preventDefault();
            var form = $("#formPaketSpp");
            // if (!checkForm(form)) {
            //     return false;
            // }

            // $('#spinner-toast').modal('show');

            var data = {
                "_token": "{{ csrf_token() }}",
                'id' : $('#formPaketSpp').find('#id').val(),
                'layanan_kelas_id' : $('#formPaketSpp').find('#layanan_kelas_id').val(),
                'paket_kelas_id' : $('#formPaketSpp').find('#paket_kelas_id').val(),
                'semester' : $('#formPaketSpp').find('#semester').val(),
                'biaya' : $('#formPaketSpp').find('#biaya').val(),
                'biaya_program' : $('#formPaketSpp').find('#biaya_program').val(),
                'biaya_pendaftaran' : $('#formPaketSpp').find('#biaya_pendaftaran').val(),
                'jenis_pendaftaran' : $('#formPaketSpp').find('#jenis_pendaftaran').val(),
                'keterangan' : $('#formPaketSpp').find('#keterangan').val(),
                'cabang_id' : $('#formPaketSpp').find('#cabang_id').val(),
                'type' : $('#formPaketSpp').find('#type').val(),
                'is_active' : $('#formPaketSpp').find("#is_active").is(":checked"),
            }

            $.ajax({
                type: "POST",
                url: "{{route('ajax.paket_spp.save')}}",
                data: data,
                success: function(res) {
                    console.log(res);
                    // $('#spinner-toast').modal('hide');

                    if (!res.error) {
                        $('#modalPaketSpp').modal('hide');
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
