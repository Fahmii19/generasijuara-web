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
                            Nilai
                        </h1>
                    </div>
                    <div class="col-12 col-xl-auto mb-3">
                        <a class="btn btn-sm btn-light text-primary" href="#" id="pdfBtn">
                            <i class="me-1" data-feather="file"></i>
                            Cetak
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
                <form>
                    <div class="row col-lg-12">
                        
                        <div class="mb-3 col-lg-6">
                            <label for="kelas_id">Kelas</label>
                            <select class="form-control" id="kelas_id">
                                <option>-- Pilih Kelas--</option>
                            </select>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <br>
        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dtNilai" width="100%" cellspacing="0">
                    </table>
                </div>
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
        var kelasSelected = null

        $('#pdfBtn').hide();
        getKelas();
        function getKelas() {
            $.ajax({
                type: "POST",
                url: "{{route('ajax.kelas.get_all')}}",
                data: {
                    "_token": "{{ csrf_token() }}",
                    "user_id_wb": "{{Auth::user()->id}}"
                },
                success: function(res) {
                    // console.log(res);
                    var html_results = "<option value=''>-- Pilih Kelas --</option>";
                    $.each(res.data, function (i, row) {
                        html_results += "<option value='"+row.id+"'>"+row.nama+"</option>";
                    });
                    $('#kelas_id').html(html_results);
                }
            });
        }


        $('#kelas_id').on('change', function() {
            kelasSelected = this.value 
            // console.log(kelasSelected, );
            if (kelasSelected == null || kelasSelected == '') {
                $('#pdfBtn').hide();
                $("#pdfBtn").attr("href", "#")
            }else{
                $('#pdfBtn').show();
                $("#pdfBtn").attr("href", "{{route('web.siab.raport.print')}}/"+kelasSelected)
            }
            table.ajax.reload();
        });

        table = $('#dtNilai').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: "{{route('ajax.dt.nilai.get_by_wb')}}",
                dataType: "json",
                "data": function ( d ) {
                    d._token = "{{ csrf_token() }}",
                    d.kelas_id = kelasSelected,
                    d.user_id_wb = "{{Auth::user()->id}}"
                },
                type: "POST",
            },
            bSort: true,
            searching: true,
            lengthChange: true,
            scrollX: true,
            columns:[
                {
                    "title":"Mata Pelajaran",
                    "width":"12%",
                    "data":"mp_nama"
                },
                {
                    "title":"Nilai (P) 1",
                    "width":"12%",
                    "data":"p_nilai_1",
                    render: function (data,type, row){
                        if (data == null) return '-';
                        return data+" ("+row.p_predikat_1+")";
                    }
                },
                {
                    "title":"Nilai (K) 1",
                    "width":"12%",
                    "data":"k_nilai_1",
                    render: function (data,type, row){
                        if (data == null) return '-';
                        return data+" ("+row.k_predikat_1+")";
                    }
                },
                {
                    "title":"Nilai (P) 2",
                    "width":"12%",
                    "data":"p_nilai_2",
                    render: function (data,type, row){
                        if (data == null) return '-';
                        return data+" ("+row.p_predikat_2+")";
                    }
                },
                {
                    "title":"Nilai (K) 2",
                    "width":"12%",
                    "data":"k_nilai_2",
                    render: function (data,type, row){
                        if (data == null) return '-';
                        return data+" ("+row.k_predikat_2+")";
                    }
                },
                {
                    "title":"Nilai (P) 3",
                    "width":"12%",
                    "data":"p_nilai_3",
                    render: function (data,type, row){
                        if (data == null) return '-';
                        return data+" ("+row.p_predikat_3+")";
                    }
                },
                {
                    "title":"Nilai (K) 3",
                    "width":"12%",
                    "data":"k_nilai_3",
                    render: function (data,type, row){
                        if (data == null) return '-';
                        return data+" ("+row.k_predikat_3+")";
                    }
                },
                {
                    "title":"Spiritual",
                    "width":"12%",
                    "data":"sikap_spiritual"
                },
                {
                    "title":"Sosial",
                    "width":"12%",
                    "data":"sikap_sosial"
                }
            ],
            order:[[0,'asc']],
            columnDefs:[]
        });
    });

</script>
@endsection
