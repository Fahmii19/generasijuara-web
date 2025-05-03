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
                            Kelas
                        </h1>
                    </div>
                    <div class="col-12 col-xl-auto mb-3">
                        <a class="btn btn-sm btn-light text-primary" href="#" id="addKelasBtn">
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
                        <!-- <a class="btn btn-sm btn-light text-primary" href="#" id="importBtn">
                            <i class="me-1" data-feather="file"></i>
                            Import Rombel Excel
                        </a> -->
                    </div>
                </div>
            </div>
        </div>
    </header>
    <!-- Main page content-->
    <div class="container-fluid px-4">
        {{-- BARU --}}
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-md">
                        <label class="mb-1" for="tipe_kelas_filter">Tipe Kelas</label>
                        <div class="input-group mb-3">
                            <select class="form-control" id="tipe_kelas_filter" aria-describedby="reset_tipe_kelas"></select>
                            <button class="btn btn-sm btn-outline-primary" type="button" id="reset_tipe_kelas"><i class="fas fa-times"></i></button>
                        </div>
                    </div>
                    <div class="col-md">
                        <label class="mb-1" for="layanan_kelas_filter">Layanan Kelas</label>
                        <div class="input-group mb-3">
                            <select class="form-control" id="layanan_kelas_filter" aria-describedby="reset_layanan_kelas"></select>
                            <button class="btn btn-sm btn-outline-primary" type="button" id="reset_layanan_kelas"><i class="fas fa-times"></i></button>
                        </div>
                    </div>
                    <div class="col-md">
                        <label class="mb-1" for="tahun_akademik_filter">Tahun Akademik</label>
                        <div class="input-group mb-3">
                            <select class="form-control" id="tahun_akademik_filter" aria-describedby="reset_tahun_akademik"></select>
                            <button class="btn btn-sm btn-outline-primary" type="button" id="reset_tahun_akademik"><i class="fas fa-times"></i></button>
                        </div>
                    </div>
                    <div class="col-md">
                        <label class="mb-1" for="semester_filter">Semester</label>
                        <div class="input-group mb-3">
                            <select class="form-control" id="semester_filter" aria-describedby="reset_semester"></select>
                            <button class="btn btn-sm btn-outline-primary" type="button" id="reset_semester"><i class="fas fa-times"></i></button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <br>
        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dtKelas" width="100%" cellspacing="0">
                    </table>
                </div>
            </div>
        </div>
    </div>
</main>

<!-- Modal -->
<div class="modal fade" id="modalKelas" data-bs-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="modalKelasLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalKelasLabel">Form</h5>
                <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="formKelas" method="POST" action="" novalidate>
                    @csrf
                    <div class="mb-3">
                        <label><strong>Data</strong></label>
                    </div>
                    <input class="form-control" id="id" type="hidden" placeholder="">
                    <input class="form-control" id="duplicate_source_id" type="hidden" placeholder="">
                    <div class="mb-3">
                        <label for="tahun_akademik_id">Tahun Akademik</label>
                        <select class="form-control" id="tahun_akademik_id"></select>
                    </div>
                    <div class="mb-3">
                        <label for="kode">Kode Kelas</label>
                        <input class="form-control" id="kode" type="text" placeholder="">
                    </div>
                    <div class="mb-3">
                        <label for="nama">Nama Kelas</label>
                        <input class="form-control" id="nama" type="text" placeholder="">
                    </div>
                    <div class="mb-3">
                        <label for="biaya">Biaya Kelas</label>
                        <input class="form-control ribuan-format" id="biaya" type="text" placeholder="">
                    </div>
                    <div class="mb-3">
                        <label for="layanan_kelas_id">Layanan Kelas</label>
                        <select class="form-control" id="layanan_kelas_id"></select>
                    </div>
                    <div class="mb-3">
                        <label for="type">Tipe Kelas</label>
                        <select class="form-control" id="type"></select>
                    </div>
                    <div class="mb-3">
                        <label for="kelas">Kelas</label>
                        <select class="form-control" id="kelas"></select>
                    </div>
                    <div class="mb-3">
                        <label for="semester">Semester</label>
                        <select class="form-control" id="semester"></select>
                    </div>
                    <div class="mb-3">
                        <label for="paket_kelas_id">Paket Kelas</label>
                        <select class="form-control" id="paket_kelas_id"></select>
                    </div>
                    <div class="mb-3">
                        <label for="jurusan">Jurusan</label>
                        <select class="form-control" id="jurusan">
                            <option value="">-- Pilih Jurusan --</option>
                            <option value="IPA">IPA (MIA)</option>
                            <option value="IPS">IPS (IIS)</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <div class="row" id="jenis_rapor">
                            <div class="col-md-3">
                                <input class="form-check-input" id="rapor-lama" type="radio" name="jenis_rapor" value="lama" checked/>
                                <label class="form-check-label" for="rapor-lama">Rapor Lama</label>
                            </div>
                            <br>
                            <div class="col-md-3">
                                <input class="form-check-input" id="rapor-merdeka" type="radio" name="jenis_rapor" value="merdeka" />
                                <label class="form-check-label" for="rapor-merdeka">Rapor Merdeka</label>
                            </div>
                        </div>
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
{{-- BARU --}}
<!-- Select2 -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.min.css" rel="stylesheet" />
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@ttskch/select2-bootstrap4-theme@x.x.x/dist/select2-bootstrap4.min.css">

@endsection

@section('js_extra')

{{-- BARU --}}
<!-- Select2 -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.full.js"></script>

<script type="text/javascript">
    $(document).ready(function() {
        // BARU
        var table = null
        var tahunAkademikSelected = null;
        var layananKelasSelected = null;
        var paketKelasSelected = null;
        var typeSelected = null;
        var semesterSelected = null;

        getSemesterOptions(function(output) {
            // BARU
            $('#semester_filter').html(output);
            $('#semester').html(output);
        });

        getKelasNumOptions(function(output) {
            $('#kelas').html(output);
        });

        getTahunAkademikOptions(function(output) {
            // BARU
            $('#tahun_akademik_filter').html(output);
            $('#tahun_akademik_id').html(output);

            if (tahunAkademikSelected != null) {
                $('#tahun_akademik_id').val(tahunAkademikSelected);
            }
        });

        getLayananKelasOptions(function(output) {
            // BARU
            $('#layanan_kelas_filter').html(output);
            $('#layanan_kelas_id').html(output);

            if (layananKelasSelected != null) {
                $('#layanan_kelas_id').val(layananKelasSelected);
            }
        });

        getPaketKelasOptions(function(output) {
            $('#paket_kelas_id').html(output);

            if (paketKelasSelected != null) {
                $('#paket_kelas_id').val(paketKelasSelected);
            }
        });

        getTypeKelasOptions(function(output) {
            // BARU
            $('#tipe_kelas_filter').html(output);
            $('#type').html(output);

            if (typeSelected != null) {
                $('#type').val(typeSelected);
            }
        });

        table = $('#dtKelas').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: "{{route('ajax.dt.kelas.get')}}",
                dataType: "json",
                "data": function ( d ) {
                    d._token = "{{ csrf_token() }}",
                    // BARU
                    d.type = typeSelected,
                    d.layanan_kelas_id = layananKelasSelected,
                    d.tahun_akademik_id = tahunAkademikSelected,
                    d.semester = semesterSelected
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
                    "title":"Kelas",
                    "width":"12%",
                    "data":"kelas"
                },
                {
                    "title":"Semester",
                    "width":"12%",
                    "data":"semester"
                },
                {
                    "title":"Tahun Ajaran",
                    "width":"12%",
                    "data":"ta_tahun_ajar",
                    "name": "ta.tahun_ajar"
                },
                {
                    "title":"Paket Kelas",
                    "width":"12%",
                    "data":"pk_nama",
                    "name": "pk.nama"
                },
                {
                    "title":"Layanan",
                    "width":"15%",
                    "data":"lk_kode",
                    "name":"lk.kode"
                },
                {
                    "title":"Jurusan",
                    "width":"15%",
                    "data":"jurusan"
                },
                {
                    "title":"Jumlah Siswa",
                    "width":"10%",
                    "searchable": false,
                    "data":"jumlah_siswa"
                },
                {
                    "title":"Status",
                    "width":"12%",
                    "data":"is_active",
                    render: function (data, type, row) {
                        return getActiveStatusStr(data);
                    }
                },
                {
                    "title": "Action",
                    "data":null,
                    "width":"15%",
                    "orderable":false,
                    "searchable":false,
                    render: function (data,type, row){
                        var url_edit = "{{route('web.su.kelas.detail')}}";
                        return '<a href="'+url_edit+'?id='+row.id+'" class="detailKelasBtn btn btn-sm btn-transparent-dark" data-id="'+row.id+'"><i class="fas fa-eye"></i></a>'+
                        '<a href="#" class="editKelasBtn btn btn-sm btn-transparent-dark" data-id="'+row.id+'"><i class="fas fa-edit"></i></a>'+
                        '<a href="#" class="deleteKelasBtn btn btn-sm btn-transparent-dark" data-id="'+row.id+'"><i class="fas fa-trash"></i></a>'+
                        '<a href="#" class="duplicateKelasBtn btn btn-sm btn-primary" data-id="'+row.id+'"><i class="fas fa-copy"></i> Duplikat</a>'
                    }
                }
            ],
            order:[[1,'asc']],
            columnDefs:[]
        });


        // BARU
        $("#tipe_kelas_filter").select2({
            theme: 'bootstrap4',
            placeholder: 'Pilih Tipe Kelas',
        });

        $("#tahun_akademik_filter").select2({
            theme: 'bootstrap4',
            placeholder: 'Pilih Tahun Akademik',
        });

        $("#layanan_kelas_filter").select2({
            theme: 'bootstrap4',
            placeholder: 'Pilih Layanan Kelas',
        });

        // Tipe kelas filter
        $("#tipe_kelas_filter").on("change", function(e) {
            typeSelected = $("#tipe_kelas_filter").val();
            table.ajax.reload();
        });

        $("#reset_tipe_kelas").on("click", function(e) {
            $('#tipe_kelas_filter').val(null).trigger('change');
            table.ajax.reload();
        });

        // Layanan kelas filter
        $("#layanan_kelas_filter").on("change", function(e) {
            layananKelasSelected = $("#layanan_kelas_filter").val();
            table.ajax.reload();
        });

        $("#reset_layanan_kelas").on("click", function(e) {
            $('#layanan_kelas_filter').val(null).trigger('change');
            table.ajax.reload();
        });

        // Tahun akademik filter
        $("#tahun_akademik_filter").on("change", function(e) {
            tahunAkademikSelected = $("#tahun_akademik_filter").val();
            table.ajax.reload();
        });

        $("#reset_tahun_akademik").on("click", function(e) {
            $('#tahun_akademik_filter').val(null).trigger('change');
            table.ajax.reload();
        });

        // Semester filter
        $("#semester_filter").on("change", function(e) {
            semesterSelected = $("#semester_filter").val();
            table.ajax.reload();
        });

        $("#reset_semester").on("click", function(e) {
            $('#semester_filter').val(null).trigger('change');
            table.ajax.reload();
        });
        
        
        $('#input-search-table').on( 'keyup change clear',function() {
            table
                // .columns(2)
                .search( $(this).val())
                .draw()
        })

        $('#dtKelas').on('click', '.editKelasBtn', function(){
            var id = $(this).data('id');
            console.log(id);
            $('#modalKelas').modal('show');
            $('#formKelas').trigger("reset");
            $('#formKelas').find('#id').val(null);
            $('#formKelas').find('#duplicate_source_id').val(null);
            $.ajax({
                type: "POST",
                url: "{{route('ajax.kelas.get')}}",
                data: {
                    'id' : id,
                    "_token": "{{ csrf_token() }}"
                },
                success: function(res) {
                    console.log(res)
                    if (!res.error) {
                        $('#formKelas').find('#id').val(res.data.id);
                        $('#formKelas').find('#kelas').val(res.data.kelas);
                        $('#formKelas').find('#semester').val(res.data.semester);
                        $('#formKelas').find('#jurusan').val(res.data.jurusan);

                        tahunAkademikSelected = res.data.tahun_akademik_id;
                        $('#formKelas').find('#tahun_akademik_id').val(res.data.tahun_akademik_id);
                        
                        paketKelasSelected = res.data.paket_kelas_id;
                        $('#formKelas').find('#paket_kelas_id').val(res.data.paket_kelas_id);

                        $('#formKelas').find('#nama').val(res.data.nama);
                        $('#formKelas').find('#kode').val(res.data.kode);
                        $('#formKelas').find('#type').val(res.data.type);
                        $('#formKelas').find('#biaya').val(res.data.biaya);

                        layananKelasSelected = res.data.layanan_kelas_id;
                        $('#formKelas').find('#layanan_kelas_id').val(res.data.layanan_kelas_id);

                        if (res.data.is_active) {
                            $('#formKelas').find('#is_active').prop('checked', true);
                        }else{
                            $('#formKelas').find('#is_active').prop('checked', false);
                        }
                    }
                }
            });
        });

        $('#dtKelas').on('click', '.deleteKelasBtn', function(e){
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
                        url: "{{route('ajax.kelas.delete')}}",
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
            //     url: "{{route('ajax.kelas.delete')}}",
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

        $('#dtKelas').on('click', '.duplicateKelasBtn', function(e){
            var id = $(this).data('id');
            $('#modalKelas').modal('show');
            $('#formKelas').trigger("reset");
            $('#formKelas').find('#id').val(null);
            $('#formKelas').find('#duplicate_source_id').val(id);

            $.ajax({
                type: "POST",
                url: "{{route('ajax.kelas.get')}}",
                data: {
                    'id' : id,
                    "_token": "{{ csrf_token() }}"
                },
                success: function(res) {
                    console.log(res)
                    if (!res.error) {
                        $('#formKelas').find('#duplicate_source_id').val(res.data.id);
                        $('#formKelas').find('#kelas').val(res.data.kelas);
                        $('#formKelas').find('#semester').val(res.data.semester);
                        $('#formKelas').find('#jurusan').val(res.data.jurusan);

                        tahunAkademikSelected = res.data.tahun_akademik_id;
                        $('#formKelas').find('#tahun_akademik_id').val(res.data.tahun_akademik_id);
                        
                        paketKelasSelected = res.data.paket_kelas_id;
                        $('#formKelas').find('#paket_kelas_id').val(res.data.paket_kelas_id);

                        $('#formKelas').find('#type').val(res.data.type);
                        $('#formKelas').find('#biaya').val(res.data.biaya);

                        layananKelasSelected = res.data.layanan_kelas_id;
                        $('#formKelas').find('#layanan_kelas_id').val(res.data.layanan_kelas_id);

                        if (res.data.is_active) {
                            $('#formKelas').find('#is_active').prop('checked', true);
                        }else{
                            $('#formKelas').find('#is_active').prop('checked', false);
                        }
                    }
                }
            });
        });

        $('#addKelasBtn').on('click', function(){
            $('#modalKelas').modal('show');
            $('#formKelas').trigger("reset");
            $('#formKelas').find('#id').val(null);
            $('#formKelas').find('#duplicate_source_id').val(null);
        });

        //Submit Call
        $('#submitTutorBtn').on('click', function(e){
            e.preventDefault();
            var form = $("#formKelas");
            // if (!checkForm(form)) {
            //     return false;
            // }

            // $('#spinner-toast').modal('show');
            
            enableLoadingButton("#submitTutorBtn");
            var data = {
                "_token": "{{ csrf_token() }}",
                'id' : $('#formKelas').find('#id').val(),
                'duplicate_source_id' : $('#formKelas').find('#duplicate_source_id').val(),
                'kelas' : $('#formKelas').find('#kelas').val(),
                'semester' : $('#formKelas').find('#semester').val(),
                'jurusan' : $('#formKelas').find('#jurusan').val(),
                'tahun_akademik_id' : $('#formKelas').find('#tahun_akademik_id').val(),
                'paket_kelas_id' : $('#formKelas').find('#paket_kelas_id').val(),
                'nama' : $('#formKelas').find('#nama').val(),
                'kode' : $('#formKelas').find('#kode').val(),
                'type' : $('#formKelas').find('#type').val(),
                'biaya' : $('#formKelas').find('#biaya').val(),
                'layanan_kelas_id' : $('#formKelas').find('#layanan_kelas_id').val(),
                'is_active' : $('#formKelas').find("#is_active").is(":checked"),
                'jenis_rapor': $('#formKelas').find('input[name="jenis_rapor"]:checked').val(),
            }

            console.log('submit', data);
            $.ajax({
                type: "POST",
                url: "{{route('ajax.kelas.save')}}",
                data: data,
                success: function(res) {
                    disableLoadingButton("#submitTutorBtn");
                    if (!res.error) {
                        // showSuccess(res.message || "Success");
                        $('#modalKelas').modal('hide');
                        swalSuccess({
                            text: 'Data berhasil disimpan',
                            withConfirmButton: true,
                            withReloadTable: true,
                            table: table
                        })
                    }else{
                        swalError({
                            text: 'Gagal menyimpan data'
                        })
                    }
                },
                error: function(response, textStatus, errorThrown){
                    disableLoadingButton("#submitTutorBtn");
                    ajaxCallbackError(response);
                }
            });
        });

        // var importFile = null;
        // $('#import_file').on('change',function(){
        //     if(this.files && this.files[0]){
        //         importFile = this.files[0]
        //     }
        // });
        
        // $('#importBtn').on('click', function(){
        //     $('#modalImport').modal('show');
        //     $('#formImport').trigger('reset');
        //     importFile = null;
        // });
        
        // $('#submitImportBtn').on('click', function(e){
        //     e.preventDefault();
        //     var form = $("#formImport");

        //     if (importFile == null) {
        //         showError('importFile tidak ditemukan');
        //         return false;
        //     }

        //     enableLoadingButton("#submitImportBtn");

        //     var formData = new FormData();

        //     formData.append('_token', "{{ csrf_token() }}");
        //     formData.append('import_file', importFile);

        //     $.ajax({
        //         type: "POST",
        //         url: "{{route('ajax.kelas.import_rombel_excel')}}",
        //         cache : false,
        //         processData: false,
        //         contentType: false,
        //         data: formData,
        //         success: function(res) {
        //             disableLoadingButton("#submitImportBtn");
        //             if (!res.error) {
        //                 showSuccess(res.message || "Success");
        //                 $('#modalImport').modal('hide');
        //                 table.ajax.reload();
        //             }else{
        //                 showError('failed');
        //             }
        //         },
        //         error: function(response, textStatus, errorThrown){
        //             disableLoadingButton("#submitImportBtn");
        //             ajaxCallbackError(response);
        //         }
        //     });
        // });
    });
</script>
@endsection
