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
                            Hasil Kuisioner
                        </h1>
                    </div>
                    <div class="col-12 col-xl-auto mb-3">
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
                        <label class="mb-1" for="tahun_akademik_id_filter">Tahun Akademik</label>
                        <select class="form-control" id="tahun_akademik_id_filter" style="width: 100%; ">
                        </select>
                    </div>
                    <div class="col-md">
                        <label class="mb-1" for="status_filter">Status</label>
                        <select class="form-control" id="status_filter" style="width: 100%; ">
                            <option value="">Semua</option>
                            <option value="1">Sudah Mengisi</option>
                            <option value="0">Belum Mengisi</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>
        <br>
        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dtHasilKuisioner" width="100%" cellspacing="0">
                    </table>
                </div>
            </div>
        </div>
    </div>
</main>

<!-- Modal -->
<div class="modal fade" id="modalKuisioner" data-bs-backdrop="static" role="dialog" aria-labelledby="modalKuisionerLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <form id="formKuisioner" method="POST" action="" novalidate>
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalKuisionerLabel">Form</h5>
                    <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input class="form-control" id="id" name="id" type="hidden" placeholder="">
                    <div class="mb-3">
                        <label for="tahun_akademik">Tahun Akademik</label>
                        <select class="form-control" id="tahun_akademik_id" name="tahun_akademik_id" style="width: 100%; ">
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="nomor_urut">Nomor Urut</label>
                        <input type="number" class="form-control" name="no_urut" id="no_urut">
                    </div>
                    <div class="mb-3">
                        <label for="item">Pertanyaan Kuisioner</label>
                        <textarea class="form-control" id="item" name="item" type="text" placeholder=""></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="input_type">Tipe Kuisioner</label>
                        <select class="form-control" id="input_type" name="input_type">
                            <option value="">-- Pilih Tipe --</option>
                            <option value="text">Isian</option>
                            <option value="radio">Pilihan</option>
                        </select>
                    </div>
                    <div class="mb-3" id="container-radio" style="display: none;">
                        <label for="input_label">Input Label</label>
                        <div id="div-radio-label">
                            <div class="input-group mb-3">
                                <input type="text" class="form-control" placeholder="Label" name="input_label[]" id="input_label_0" autocomplete="off">
                                <button class="btn btn-outline-success add-label" type="button"><i class="fa fa-plus"></i></button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-bs-dismiss="modal">Close</button>
                    <button class="btn btn-primary" type="submit" id="submitKuisionerBtn">Submit</button>
                </div>
            </div>
        </form>
    </div>
</div>

<div class="modal fade" id="modalDuplicate" data-bs-backdrop="static" role="dialog" aria-labelledby="modalDuplicateLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <form id="formDuplicate" method="POST" action="" novalidate>
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalDuplicateLabel">Form</h5>
                    <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="tahun_akademik_source">Tahun Akademik Asal</label>
                        <select class="form-control" id="tahun_akademik_source" name="tahun_akademik_source" style="width: 100%; ">
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="tahun_akademik_destination">Tahun Akademik Tujuan</label>
                        <select class="form-control" id="tahun_akademik_destination" name="tahun_akademik_destination" style="width: 100%; ">
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-bs-dismiss="modal">Close</button>
                    <button class="btn btn-primary" type="submit" id="submitDuplicateBtn">Duplicate</button>
                </div>
            </div>
        </form>
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
        var table = null;
        var tahunAkademikSelected = null;
        var statusSelected = null;

        table = $('#dtHasilKuisioner').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: "{{route('ajax.dt.kuisioner_hasil.get')}}",
                dataType: "json",
                "data": function ( d ) {
                    d._token = "{{ csrf_token() }}",
                    d.tahun_akademik_id = tahunAkademikSelected,
                    d.status = statusSelected
                },
                type: "POST",
            },
            bSort: true,
            searching: true,
            lengthChange: true,
            scrollX: true,
            columns:[
                {
                    "title":"No", "width":"5%",
                    "data":"DT_RowIndex", "orderable": false,
                    "searchable": false
                },
                {
                    "title":"NISN",
                    "width":"15%",
                    "data":"ppdb.nisn"
                },
                {
                    "title":"NIS",
                    "width":"15%",
                    "data":"ppdb.nis",
                },
                {
                    "title":"Nama",
                    "width":"25%",
                    "data":"ppdb.nama"
                },
                {
                    "title":"Tahun Ajaran",
                    "width":"15%",
                    "data":"tahun_akademik.kode"
                },
                {
                    "title":"Status",
                    "width":"15%",
                    "data":"is_answer_quiz",
                    render: function(data, type, row, meta) {
                        if (data == 1) {
                            return '<span class="badge bg-green-soft text-green">Sudah</span>';
                        } else {
                            return '<span class="badge bg-yellow-soft text-yellow">Belum</span>';
                        }
                    }
                },
                {
                    "title": "Action",
                    "data":null,
                    "width":"5%",
                    "orderable":false,
                    "searchable":false,
                    render: function (data,type, row){
                        if (row.is_answer_quiz == 1) {
                            return ''+
                            '<a href="{{route("web.su.kuisioner_hasil.detail")}}/'+row.tahun_akademik.id+'/'+row.ppdb.id+'" class="btn-transparent-dark btn btn-sm"><i class="fas fa-eye"></i></a>'
                        } else {
                            return '-';
                        }
                    }
                }
            ],
            // order:[[1,'desc'],[2,'asc']],
            columnDefs:[]
        });

        // Tahun akademik
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
                    var opt_for_filter = "<option value=''>Semua</option>";
                    var opt_for_input = "<option value=''>-- Pilih Salah Satu --</option>";
                    $.each(res.data, function (i, row) {
                        opt_for_filter += "<option value='"+row.id+"'>"+row.kode+" - "+row.keterangan+"</option>";
                        opt_for_input += "<option value='"+row.id+"'>"+row.kode+" - "+row.keterangan+"</option>";
                    });
                    $('#tahun_akademik_id_filter').html(opt_for_filter);
                    $('#tahun_akademik_id').html(opt_for_input);
                    $('#tahun_akademik_source').html(opt_for_input);
                    $('#tahun_akademik_destination').html(opt_for_input);
                }
            });
        }

        $("#tahun_akademik_id_filter,#status_filter").select2({
            theme: 'bootstrap4'
        });

        $("#tahun_akademik_id_filter").on("change", function(e) {
            tahunAkademikSelected = $("#tahun_akademik_id_filter").val();
            table.ajax.reload();
        });

        $("#status_filter").on("change", function(e) {
            statusSelected = $("#status_filter").val();
            table.ajax.reload();
        });
    });
</script>

@endsection
