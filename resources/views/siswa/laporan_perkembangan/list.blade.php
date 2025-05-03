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
                            Perkembangan
                        </h1>
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
                    <table class="table table-bordered" id="dtPerkembangan" width="100%" cellspacing="0">
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

<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.4/moment.min.js"></script>

<script type="text/javascript">
    $(document).ready(function() {
        var ppdb_id = '00';
        var table = null;
        var kelasSelected = null;

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
            if (this.value != '') {
                ppdb_id = "{{ $data_ppdb->id }}";
                kelasSelected = this.value;
                table.ajax.reload();
            }
        });

        table = $('#dtPerkembangan').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: "{{route('ajax.dt.perkembangan.get')}}",
                dataType: "json",
                "data": function ( d ) {
                    d._token = "{{ csrf_token() }}",
                    d.ppdb_id = ppdb_id,
                    d.kelas_id = kelasSelected
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
                    "width": "8%"
                },
                {
                    "title":"Mata Pelajaran",
                    "width": "30%",
                    "data": "kmp.mata_pelajaran_detail.nama"
                },
                {
                    "title":"Tanggal Laporan",
                    "width":"15%",
                    "data":"created_at",
                    "render":function(data, type, row, meta){
                        return moment(data.created_at).format('DD-MM-YYYY');
                    }
                },
                {
                    "title":"Laporan",
                    "width":"32%",
                    "data":"laporan"
                },
            ],
            order:[[0,'asc']],
            columnDefs:[]
        });
    });

</script>
@endsection
