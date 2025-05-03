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
                    {{-- <div class="col-md">
                        <label class="mb-1" for="cabang_id">Cabang</label>
                        <select class="form-control" id="cabang_id" style="100%">
                        </select>
                    </div> --}}
                    <div class="col-md-6">
                        <label class="mb-1" for="ppdb_type">Tipe</label>
                        <select class="form-control" id="ppdb_type" style="100%">
                            <option value="">Semua</option>
                            <option value="0">ABC</option>
                            <option value="1">PAUD</option>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="mb-1" for="tahun_akademik_id">Tahun Akademik</label>
                        <select class="form-control" id="tahun_akademik_id" style="100%">
                        </select>
                    </div>
                </div>
            </div>
        </div>
        <br>
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <h2>Status</h2>
                    <hr>
                    <div class="table-responsive">
                        <table class="table table-bordered" id="dtRekapStatus" width="100%" cellspacing="0">
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <br>
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <h2>Status Warga Belajar</h2>
                    <hr>
                    <div class="table-responsive">
                        <table class="table table-bordered" id="dtRekapStatusWB" width="100%" cellspacing="0">
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <br>
        <div class="card">
            <div class="card-body">
                <h2>Rekapitulasi HST</h2>
                <hr>
                <div class="table-responsive">
                    <table class="table table-bordered" id="dtRekapRombelHST" width="100%" cellspacing="0">
                    </table>
                </div>
            </div>
        </div>
        <br>
        <div class="card">
            <div class="card-body">
                <h2>Rekapitulasi REG</h2>
                <hr>
                <div class="table-responsive">
                    <table class="table table-bordered" id="dtRekapRombelREG" width="100%" cellspacing="0">
                    </table>
                </div>
            </div>
        </div>
        <br>
        <div class="card">
            <div class="card-body">
                <h2>Rekapitulasi INTENSIF</h2>
                <hr>
                <div class="table-responsive">
                    <table class="table table-bordered" id="dtRekapRombelIntensif" width="100%" cellspacing="0">
                    </table>
                </div>
            </div>
        </div>
    </div>
</main>
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
        var tableStatusWB = null;
        var tableHST = null;
        var tableREG = null;
        var tableIntensif = null;
        var cabangSelected = null;
        var tahunAkademikSelected = null;
        var ppdbTypeSelected = null;

        tableStatus = $('#dtRekapStatus').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: "{{route('ajax.dt.summary_rombel.get_status_count')}}",
                dataType: "json",
                "data": function ( d ) {
                    d._token = "{{ csrf_token() }}",
                    d.ppdb_type = ppdbTypeSelected,
                    d.tahun_akademik_id = tahunAkademikSelected
                },
                type: "POST",
            },
            bSort: false,
            bFilter: false,
            paging: false,
            searching: false,
            lengthChange: false,
            scrollX: true,
            columns:[
                {
                    "title":"Aktif",
                    "width":"20%",
                    "data":"aktif"
                },
                {
                    "title":"Tidak Aktif Tanpa Keterangan",
                    "width":"20%",
                    "data":"tidak_aktif"
                },
                {
                    "title":"Cuti",
                    "width":"20%",
                    "data":"cuti"
                },
                {
                    "title":"Mutasi",
                    "width":"20%",
                    "data":"mutasi"
                },
                {
                    "title":"Mengundurkan Diri",
                    "width":"20%",
                    "data":"mengundurkan_diri"
                }
            ],
            columnDefs:[]
        });

        tableStatusWB = $('#dtRekapStatusWB').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: "{{route('ajax.dt.summary_rombel.get_status_wb')}}",
                type: "POST",
                dataType: "json",
                "data": function ( d ) {
                    d._token = "{{ csrf_token() }}",
                    d.tahun_akademik_id = tahunAkademikSelected,
                    d.ppdb_type = ppdbTypeSelected
                },
            },
            bSort: false,
            bFilter: false,
            paging: false,
            searching: false,
            lengthChange: false,
            scrollX: true,
            columns:[
                {
                    "title":"Program / Kelas",
                    "width":"20%",
                    "data":null,
                    render:function(data, type, row, meta){
                        var tipe_kelas = row.type;
                        row.type == 0 ? tipe_kelas = 'PAKET' : tipe_kelas = 'PAUD';

                        return tipe_kelas + ' / ' + row.kode;
                    }
                },
                {
                    "title":"Baru",
                    "width":"20%",
                    "data":"baru"
                },
                {
                    "title":"Lama",
                    "width":"20%",
                    "data":"lama"
                },
                {
                    "title":"Alumni",
                    "width":"20%",
                    "data":"alumni"
                },
                {
                    "title":"Total",
                    "width":"20%",
                    "data":null,
                    render:function(data, type, row, meta){
                        return row.baru + row.lama + row.alumni;
                    }
                },
            ],
            columnDefs:[]
        });

        tableHST = $('#dtRekapRombelHST').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: "{{route('ajax.dt.summary_rombel.get')}}",
                dataType: "json",
                "data": function ( d ) {
                    d._token = "{{ csrf_token() }}",
                    d.cabang_id = cabangSelected,
                    d.ppdb_type = ppdbTypeSelected,
                    d.layanan_kelas = 'HST',
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
                    "width": "7%"
                },
                {
                    "title":"Kelas",
                    "width":"63%",
                    "data":"nama"
                },
                {
                    "title":"Jumlah Siswa",
                    "width":"30%",
                    "data":"total",
                    "searchable": false
                }
            ],
            order:[[0,'desc']],
            columnDefs:[]
        });

        tableREG = $('#dtRekapRombelREG').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: "{{route('ajax.dt.summary_rombel.get')}}",
                dataType: "json",
                "data": function ( d ) {
                    d._token = "{{ csrf_token() }}",
                    d.cabang_id = cabangSelected,
                    d.ppdb_type = ppdbTypeSelected,
                    d.layanan_kelas = 'REG',
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
                    "width": "7%"
                },
                {
                    "title":"Kelas",
                    "width":"63%",
                    "data":"nama"
                },
                {
                    "title":"Jumlah Siswa",
                    "width":"30%",
                    "data":"total",
                    "searchable": false
                }
            ],
            order:[[0,'desc']],
            columnDefs:[]
        });

        tableIntensif = $('#dtRekapRombelIntensif').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: "{{route('ajax.dt.summary_rombel.get')}}",
                dataType: "json",
                "data": function ( d ) {
                    d._token = "{{ csrf_token() }}",
                    d.cabang_id = cabangSelected,
                    d.ppdb_type = ppdbTypeSelected,
                    d.layanan_kelas = 'INTENSIF',
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
                    "width": "7%"
                },
                {
                    "title":"Kelas",
                    "width":"63%",
                    "data":"nama"
                },
                {
                    "title":"Jumlah Siswa",
                    "width":"30%",
                    "data":"total",
                    "searchable": false
                }
            ],
            order:[[0,'desc']],
            columnDefs:[]
        });

        $("#tahun_akademik_id").select2({
            theme: 'bootstrap4'
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
                    var html_results = "<option value=''>-- Pilih Tahun Akademik --</option>";
                    $.each(res.data, function (i, row) {
                        html_results += "<option value='"+row.id+"'>"+row.kode+" - "+row.keterangan+"</option>";
                    });
                    $('#tahun_akademik_id').html(html_results);
                }
            });
        }

        $("#cabang_id").on("change", function(e) {
            cabangSelected = $("#cabang_id").val();
            tableStatus.ajax.reload();
            tableStatusWB.ajax.reload();
            tableHST.ajax.reload();
            tableREG.ajax.reload();
            tableIntensif.ajax.reload();
        });

        $("#tahun_akademik_id").on("change", function(e) {
            tahunAkademikSelected = $("#tahun_akademik_id").val();
            tableStatus.ajax.reload();
            tableStatusWB.ajax.reload();
            tableHST.ajax.reload();
            tableREG.ajax.reload();
            tableIntensif.ajax.reload();
        });

        $("#ppdb_type").on("change", function(e) {
            ppdbTypeSelected = $("#ppdb_type").val();
            tableStatus.ajax.reload();
            tableStatusWB.ajax.reload();
            tableHST.ajax.reload();
            tableREG.ajax.reload();
            tableIntensif.ajax.reload();
        });
    });
</script>

@endsection
