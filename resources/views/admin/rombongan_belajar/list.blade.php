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
                            Rombongan Belajar
                        </h1>
                    </div>
                    <div class="col-12 col-xl-auto mb-3">
                        {{-- Place for button --}}
                        <!-- <a class="btn btn-sm btn-light text-primary" href="#">
                            <i class="me-1" data-feather="plus"></i>
                            Button
                        </a> -->
                        <a class="btn btn-sm btn-light text-primary" href="#" id="importBtn">
                            <i class="me-1" data-feather="file"></i>
                            Import Rombel Excel
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
                <div class="row">
                    <div class="col-md">
                        <label class="mb-1" for="cabang_id">Cabang</label>
                        <select class="form-control" id="cabang_id" style="100%">
                        </select>
                    </div>
                    <div class="col-md">
                        <label class="mb-1" for="ppdb_type">Tipe</label>
                        <select class="form-control" id="ppdb_type" style="100%">
                            <option value="">Semua</option>
                            <option value="0">ABC</option>
                            <option value="1">PAUD</option>
                        </select>
                    </div>
                    <div class="col-md">
                        <label class="mb-1" for="nama_orang_tua">Nama Orang Tua</label>
                        <input type="text" class="form-control" id="nama_orang_tua">
                    </div>
                    <div class="col-md">
                        <label class="mb-1" for="tahun_akademik_id">Tahun Akademik</label>
                        <select class="form-control" id="tahun_akademik_id" style="width: 100%; ">
                        </select>
                    </div>

                    <hr class="my-4" />

                    <div class="col-12-md">
                        <a href="#" id="exportRombelBtn" class="btn btn-success">Export Excel</a>
                    </div>
                </div>
            </div>
        </div>
        <br>
        <div class="card">
            <div class="card-body">
                <table class="table table-bordered" id="dtRombel" width="100%" cellspacing="0">
                </table>
            </div>
        </div>
    </div>
</main>

<div class="modal fade" id="modalRombel" data-bs-backdrop="static" role="dialog" aria-labelledby="modalRombelLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalRombelLabel">Form</h5>
                <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="formRombel" method="POST" action="" novalidate>
                    @csrf
                    <div class="mb-3">
                        <label><strong>Data</strong></label>
                    </div>
                    <input class="form-control" id="id" type="hidden" placeholder="">
                    <div class="mb-3">
                        <label for="nama">Nama</label>
                        <input class="form-control" id="nama" type="text" readonly="readonly">
                    </div>
                    <div class="mb-3">
                        <label for="nis">NIS</label>
                        <input class="form-control" id="nis" type="text" readonly="readonly">
                    </div>
                    <div class="mb-3">
                        <label for="tahun_akademik">Tahun Akademik</label>
                        <input class="form-control" id="tahun_akademik" type="text" readonly="readonly">
                    </div>
                    <div class="mb-3">
                        <label class="mb-1" for="kelas_id">Kelas</label>
                        <select class="form-control" id="kelas_id" style="100%">
                            <option value=""></option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <div class="form-check">
                            <input class="form-check-input" id="is_active" name="is_active" type="checkbox" value="">
                            <label class="form-check-label" for="is_active">Set Aktif</label>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="keterangan">Keterangan</label>
                        <select class="form-control" id="keterangan">
                            <option value>-- Pilih Keterangan--</option>
                            <option value="cuti">Cuti</option>
                            <option value="mutasi">Mutasi</option>
                            <option value="mengundurkan_diri">Mengundurkan Diri</option>
                        </select>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <div class="row w-100">
                    <div class="col-auto me-auto">
                        <button class="btn btn-danger float-start" type="button" data-bs-dismiss="modal" id="deleteRombelBtn">Hapus</button>
                    </div>
                    <div class="col-auto">
                        <button class="btn btn-secondary" type="button" data-bs-dismiss="modal">Close</button>
                        <button class="btn btn-primary" type="button" id="submitRombelBtn">Submit</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

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

<!-- Modal Export Rombel -->
<div class="modal fade" id="modalExport" data-bs-backdrop="static" role="dialog" aria-labelledby="modalExportLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <form id="formExport" novalidate>
                <div class="modal-header">
                    <h5 class="modal-title" id="modalExportLabel">Export Rombel</h5>
                    <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    @csrf
                    <div class="row">
                        <div class="mb-3 col-md-6">
                            <label class="small mb-1" for="export_layanan_kelas_id">Layanan Kelas</label>
                            <select class="form-control select2Export" name="layanan_kelas_id" id="export_layanan_kelas_id"></select>
                        </div>
                        <div class="mb-3 col-md-6">
                            <label class="small mb-1" for="export_tahun_akademik_id">Tahun Akademik</label>
                            <select class="form-control select2Export" name="tahun_akademik_id" id="export_tahun_akademik_id"></select>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-bs-dismiss="modal">Close</button>
                    <button class="btn btn-primary" type="button" id="submitExportBtn">Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>
@stop

@section('style_extra')

<!-- Select2 -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.min.css" rel="stylesheet" />
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@ttskch/select2-bootstrap4-theme@x.x.x/dist/select2-bootstrap4.min.css">

@endsection

@section('js_extra')

<!-- Select2 -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.full.js"></script>

<script type="text/javascript">
    $(document).ready(function() {
        var table = null
        var namaOrangTua = null;
        var cabangSelected = null;
        var ppdbTypeSelected = null;
        var tahunAkademikSelected = null;
        var validatorExport;
        var select2ValidatorExportLabel;

        table = $('#dtRombel').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: "{{route('ajax.dt.rombongan_belajar.get')}}",
                dataType: "json",
                "data": function ( d ) {
                    d._token = "{{ csrf_token() }}",
                    d.nama_orang_tua = namaOrangTua,
                    d.cabang_id = cabangSelected,
                    d.ppdb_type = ppdbTypeSelected,
                    d.tahun_akademik_id = tahunAkademikSelected
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
                    "title":"Tahun Akademik",
                    "width":"10%",
                    "data":"tahun_akademik.kode"
                },
                {
                    "title":"Tipe",
                    "width":"10%",
                    "data":"ppdb.type",
                    render: function(data, type, row, meta) {
                        if(data == 0) {
                            return 'ABC';
                        } else if(data == 1) {
                            return 'PAUD';
                        }
                    }
                },
                {
                    "title":"NIS",
                    "width":"10%",
                    "data":"ppdb.nis",
                    render: function(data, type, row, meta) {
                        if(data == null) {
                            return '-';
                        } else {
                            return data;
                        }
                    }
                },
                {
                    "title":"NISN",
                    "width":"10%",
                    "data":"ppdb.nisn",
                    render: function(data, type, row, meta) {
                        if(data == null) {
                            return '-';
                        } else {
                            return data;
                        }
                    }
                },
                {
                    "title":"Nama Siswa",
                    "width":"30%",
                    "data":"ppdb.nama",
                    render: function(data, type, row, meta) {
                        if(data == null) {
                            return '-';
                        } else {
                            return `<a target="_blank" href="{{route('web.su.wb.edit')}}/${row.ppdb_id}">${data}</a>`;
                        }
                    }
                },
                {
                    "title":"Kelas",
                    "width":"25%",
                    "data":"kelas.nama",
                    render: function(data, type, row, meta) {
                        if(data == null) {
                            return '-';
                        } else {
                            return `<a target="_blank" href="{{route('web.su.kelas.detail')}}/${row.kelas_id}">${data}</a>`;
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
                    "title":"Ket",
                    "width":"12%",
                    "data":"keterangan"
                },
                {
                    "title": "Action",
                    "data":null,
                    "width":"30%",
                    "orderable":false,
                    "searchable":false,
                    render: function (data,type, row){
                        return ''+
                        '<a href="#" class="rombelEditBtn btn-transparent-dark btn btn-sm" data-id="'+row.id+'"><i class="fas fa-edit"></i></a>'+
                        `<a target="_blank" class="btn btn-sm btn-info" href="{{route('web.su.wb.edit')}}/${row.ppdb_id}"><i class="fas fa-edit"></i> Info WB</a>`
                    }
                }
            ],
            order:[[0,'desc']],
            columnDefs:[]
        });

        validatorExport = $("#formExport").validate({
            focusInvalid: true,
            errorClass: "is-invalid",
            success: "is-valid",
            rules: {
                layanan_kelas_id: {
                    required: true
                },
                tahun_akademik_id: {
                    required: true
                },
            },
            errorElement: 'span',
            errorPlacement: function (error, element) {
                if(element.hasClass('select2Export')) {
                    error.insertAfter(element.next('.select2-container')).addClass('mt-2 text-danger small');
                    select2ValidatorExportLabel = error;
                }
            },
            highlight: function (element, errorClass, validClass) {
                $(element).addClass('is-invalid');
            },
            unhighlight: function (element, errorClass, validClass) {
                $(element).removeClass('is-invalid');
            }
        });

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
                    var html_results = "<option value=''>Semua Cabang</option>";
                    $.each(res.data, function (i, row) {
                        html_results += "<option value='"+row.id+"'>"+row.nama_cabang+"</option>";
                    });
                    $('#cabang_id').html(html_results);
                }
            });
        }

        $("#cabang_id").on("change", function(e) {
            cabangSelected = $("#cabang_id").val();
            table.ajax.reload();
        });

        getTahunAkademik();
        function getTahunAkademik() {
            $.ajax({
                type: "POST",
                url: "{{route('ajax.tahun_akademik.list')}}",
                data: {
                    "_token": "{{ csrf_token() }}",
                },
                success: function(res) {
                    console.log(res);
                    var html_results = "<option value=''>Semua</option>";
                    $.each(res.data, function (i, row) {
                        html_results += "<option value='"+row.id+"'>"+row.kode+" - "+row.keterangan+"</option>";
                    });
                    $('#tahun_akademik_id').html(html_results);
                    $('#export_tahun_akademik_id').html(html_results);
                }
            });
        }

        $("#tahun_akademik_id").select2({
            theme: 'bootstrap4'
        });

        $("#export_tahun_akademik_id").select2({
            theme: 'bootstrap4',
            placeholder: "Pilih Tahun Akademik",
            dropdownParent: $("#modalExport"),
        });

        getKelas();
        function getKelas() {
            $.ajax({
                type: "POST",
                url: "{{route('ajax.kelas.get_by_name')}}",
                data: {
                    "_token": "{{ csrf_token() }}",
                },
                success: function(res) {
                    console.log(res);
                    var html_results = null;
                    $.each(res.data, function (i, row) {
                        html_results += "<option value='"+row.id+"'>"+row.nama+"</option>";
                    });
                    $('#kelas_id').html(html_results);
                }
            });
        }

        $("#kelas_id").select2({
            theme: 'bootstrap4',
            dropdownParent: $("#modalRombel"),
            placeholder: 'Pilih Kelas',
        });

        getLayananKelasOptions(function(output) {
            $('#export_layanan_kelas_id').html(output);
        });

        $("#export_layanan_kelas_id").select2({
            theme: 'bootstrap4',
            placeholder: "Pilih Layanan Kelas",
            dropdownParent: $("#modalExport"),
        });

        $("#ppdb_type").on("change", function(e) {
            ppdbTypeSelected = $("#ppdb_type").val();
            table.ajax.reload();
        });

        $("#nama_orang_tua").on("keyup change clear", function(e) {
            namaOrangTua = $("#nama_orang_tua").val();
            table.ajax.reload();
        });

        $("#tahun_akademik_id").on("change", function(e) {
            tahunAkademikSelected = $("#tahun_akademik_id").val();
            table.ajax.reload();
        });

        $("#is_active").on("change", function(e) {
            if (this.checked) {
                $('#formRombel').find('#keterangan').prop('disabled', true);
            } else {
                $('#formRombel').find('#keterangan').prop('disabled', false);
            }
        });

        $('#dtRombel').on('click', '.rombelEditBtn', function(){
            var id = $(this).data('id');
            console.log(id);
            $('#modalRombel').modal('show');
            $('#formRombel').trigger("reset");
            $('#formRombel').find('#id').val(null);
            $.ajax({
                type: "POST",
                url: "{{route('ajax.rombel.get')}}",
                data: {
                    'id' : id,
                    "_token": "{{ csrf_token() }}"
                },
                success: function(res) {
                    console.log(res)
                    if (!res.error) {
                        $('#formRombel').find('#id').val(res.data.id);
                        $('#formRombel').find('#nama').val(res.data?.ppdb?.nama);
                        $('#formRombel').find('#nis').val(res.data?.ppdb?.nis);
                        $('#formRombel').find('#tahun_akademik').val(res.data?.tahun_akademik?.kode);
                        $('#formRombel').find('#kelas_id').val(res.data?.kelas_id).change();
                        $('#formRombel').find('#keterangan').val(res.data?.keterangan);
                        if (res.data?.is_active) {
                            $('#formRombel').find('#is_active').prop('checked', true);
                            $('#formRombel').find('#keterangan').prop('disabled', true);
                        }else{
                            $('#formRombel').find('#is_active').prop('checked', false);
                            $('#formRombel').find('#keterangan').prop('disabled', false);
                        }
                    }
                }
            });
        });

        $('#submitRombelBtn').on('click', function(e){
            e.preventDefault();
            var form = $("#formRombel");

            var data = {
                "_token": "{{ csrf_token() }}",
                'id' : $('#formRombel').find('#id').val(),
                'keterangan' : $('#formRombel').find('#keterangan').val(),
                'kelas' : $('#formRombel').find('#kelas_id').val(),
                'is_active' : $('#formRombel').find("#is_active").is(":checked"),
            }
            console.log('submit', data);
            $.ajax({
                type: "POST",
                url: "{{route('ajax.rombel.save')}}",
                data: data,
                success: function(res) {
                    console.log(res);
                    if (!res.error) {
                        $('#modalRombel').modal('hide');
                        swalSuccess({
                            text: 'Data berhasil disimpan',
                            withConfirmButton: true,
                            withReloadTable: true,
                            table: table
                        })
                    }else{
                    }
                }
            });
        });

        $('#deleteRombelBtn').on('click', function(e){
            var data = {
                "_token": "{{ csrf_token() }}",
                'id' : $('#formRombel').find('#id').val(),
            }

            sweetAlertAction({
                title: 'Apakah anda yakin?',
                text: 'Data tidak dapat dikembalikan',
                type: 'question',
                withCallback: true,
                callback: function() {
                    ajaxOperation({
                        type: "POST",
                        url: "{{route('ajax.rombel.delete')}}",
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
                // showError('importFile tidak ditemukan');
                swalError({text: 'importFile tidak ditemukan'});
                return false;
            }

            enableLoadingButton("#submitImportBtn");

            var formData = new FormData();

            formData.append('_token', "{{ csrf_token() }}");
            formData.append('import_file', importFile);

            $.ajax({
                type: "POST",
                url: "{{route('ajax.kelas.import_rombel_excel')}}",
                cache : false,
                processData: false,
                contentType: false,
                data: formData,
                success: function(res) {
                    disableLoadingButton("#submitImportBtn");
                    if (!res.error) {
                        // showSuccess(res.message || "Success");
                        $('#modalImport').modal('hide');
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
                    disableLoadingButton("#submitImportBtn");
                    ajaxCallbackError(response);
                }
            });
        });

        // Export Rombel
        $('#exportRombelBtn').on('click', function(){
            validatorExport.resetForm();
            $('#export_layanan_kelas_id').val(null).trigger('change');
            $('#export_tahun_akademik_id').val(null).trigger('change');
            $('#formExport').find('.is-valid').removeClass('is-valid');
            $('#formExport').find('.is-invalid').removeClass('is-invalid');
            $('#modalExport').modal('show');
        });

        $('#submitExportBtn').on('click', function(e){
            e.preventDefault();
            
            var form = $("#formExport");
            var layanan_kelas_id = $('#formExport').find('#export_layanan_kelas_id').val();
            var tahun_akademik_id = $('#formExport').find('#export_tahun_akademik_id').val();
            
            if (!$(form).valid()) {
                validatorExport.focusInvalid();
                return false;
            }

            window.location.href = "{{route('web.su.rombongan_belajar.export_excel')}}?layanan_kelas_id="+layanan_kelas_id+"&tahun_akademik_id="+tahun_akademik_id;
        });
    });
</script>

@endsection
