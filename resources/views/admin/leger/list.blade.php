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
                            Leger Nilai
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

                    <form id="formExport" action="{{route('ajax.ledger.export_excel')}}" method="post">
                        @csrf
                        <div class="col-md">
                            <label class="mb-1" for="tahun_akademik_id">Tahun Akademik</label>
                            <select class="form-control" id="tahun_akademik_id" name="tahun_akademik_id">
                            </select>
                        </div>

                        <div class="col-md">
                            <label class="mb-1" for="tahun_akademik_id">Kelas</label>
                            <select class="form-control" id="kelas_num" name="kelas_num">
                                <option value>-- Pilih Kelas--</option>
                                <option value="1">1</option>
                                <option value="2">2</option>
                                <option value="3">3</option>
                                <option value="4">4</option>
                                <option value="5">5</option>
                                <option value="6">6</option>
                                <option value="7">7</option>
                                <option value="8">8</option>
                                <option value="9">9</option>
                                <option value="10">10</option>
                                <option value="11">11</option>
                                <option value="12">12</option>
                            </select>
                        </div>
                        <hr class="my-4" />
                        <div class="col-12-md">
                            <a href="#" id="generateBtn" class="btn btn-success">Export Excel</a>
                        </div>
                    </form>
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
        var tahunAkademikSelected = null;
        var kelasNumSelected = null;

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
                    $.each(res.data, function(i, row) {
                        html_results += "<option value='" + row.id + "'>" + row.kode + " - " + row.keterangan + "</option>";
                    });
                    $('#tahun_akademik_id').html(html_results);
                }
            });
        }

        $("#tahun_akademik_id").select2({
            theme: 'bootstrap4'
        });

        $("#tahun_akademik_id").on("change", function(e) {
            tahunAkademikSelected = $("#tahun_akademik_id").val();
        });

        $("#kelas_num").on("change", function(e) {
            kelasNumSelected = $("#kelas_num").val();
        });

        $("#generateBtn").on("click", function(e) {
            if (tahunAkademikSelected && kelasNumSelected) $("#formExport").submit();
            else alert('Silahkan pilih Tahun Akademik dan Kelas terlebih dahulu');
        });
    });
</script>

@endsection