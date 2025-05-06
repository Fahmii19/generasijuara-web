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
                            Pembayaran
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
                <h5 class="card-title">Filter Kelas</h5>
                <div class="row align-items-center">
                    <div class="col-lg-8">
                        <select class="form-control select2-single" id="kelas_id" style="width: 100%">
                            <option value="">Semua</option>
                        </select>
                    </div>
                    <div class="col-lg-4">
                        <button class="btn btn-primary d-none" id="btn_reset">Reset</button>
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
        <br>
        <div class="card">
            <div class="card-body">
                <form action="{{route('ajax.keuangan.pembayaran.export_excel')}}" method="post">
                    @csrf
                    <input type="hidden" id="param_kelas_id" name="kelas_id">
                    <button type="submit" class="btn btn-success">Export Excel</button>
                </form>
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
        var table = null;
        var dtUrl = "{{route('ajax.dt.pembayaran.get')}}";
        var kelas_id = null;

        // Select2 Kelas
        $("#kelas_id").select2({
            theme: 'bootstrap4',
            ajax: {
                url: "{{ route('ajax.kelas.get_by_name') }}",
                dataType: 'json',
                type: "POST",
                delay: 250,
                data: function (params) {
                    return {
                        _token: "{{ csrf_token() }}",
                        keyword: params.term, // search term
                        limit: 30,
                    };
                },
                processResults: function (data, params) {
                    return {
                        results: data.data,
                    };
                },
                cache: true
            },
            placeholder: 'Pilih Kelas',
            templateResult: formatKelas,
            templateSelection: formatKelasSelection
        });

        function formatKelas (kelas) {
            if (kelas.loading) {
                return kelas.text;
            }

            var $container = $(
                "<div class='select2-result-repository clearfix'>" +
                    "<div class='select2-result-kelas'>" +
                        "<div class='select2-result-kelas__nama'></div>" +
                    "</div>" +
                "</div>"
            );

            $container.find(".select2-result-kelas__nama").text(kelas.nama);

            return $container;
        }

        function formatKelasSelection (kelas) {
            return kelas.nama || kelas.text;
        }


        table = $('#dtRombel').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: dtUrl,
                dataType: "json",
                "data": function ( d ) {

                    d._token = "{{ csrf_token() }}",
                    d.kelas_id = kelas_id
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
                    "title":"Nama",
                    "width":"20%",
                    "data":"ppdb.nama"
                },
                {
                    "title":"Kelas",
                    "width":"5%",
                    "data":"ppdb.kelas"
                },
                {
                    "title":"Semester",
                    "width":"10%",
                    "data":"ppdb.smt_kelas"
                },
                {
                    "title":"Keterangan",
                    "width":"15%",
                    "data":"keterangan"
                },
                {
                    "title":"Tagihan",
                    "width":"10%",
                    "data":"tagihan",
                    render: function (data, type, row) {
                        if (data) {
                            return formatRibuan(data);
                        } else {
                            return "-";
                        }
                    }
                },
                {
                    "title":"Total Tagihan",
                    "width":"10%",
                    "data":"total_tagihan",
                    render: function (data, type, row) {
                        if (data) {
                            return formatRibuan(data);
                        } else {
                            return "-";
                        }
                    }
                },
                {
                    "title":"Nominal",
                    "width":"10%",
                    "data":"nominal",
                    render: function (data, type, row) {
                        if (data) {
                            return formatRibuan(data);
                        } else {
                            return "-";
                        }
                    }
                },
                {
                    "title":"Status Bayar",
                    "width":"10%",
                    "data":"status",
                    render: function (data, type, row) {
                        if (data) {
                            if (data == 'lunas') {
                                return '<span class="badge bg-green-soft text-green">Lunas</span>';
                            } else {
                                return '<span class="badge bg-red-soft text-red">'+toUpperCase(data)+'</span>';
                            }
                        } else {
                            return '<span class="badge bg-red-soft text-red">-</span>';
                        }
                    }
                },
                {
                    "title": "Action",
                    "data":null,
                    "width":"5%",
                    "orderable":false,
                    "searchable":false,
                    render: function (data, type, row){
                        return '<a href="{{route('web.su.keuangan.pembayaran.detail')}}/'+row.id+'" class="btn btn-sm btn-transparent-dark"><i class="fas fa-eye"></i></a>';
                    }
                }
            ],
            order:[[0,'desc']],
            columnDefs:[]
        });

        $('#kelas_id').on('change', function() {
            kelas_id = $('#kelas_id').val(); // Pakai jQuery ambil nilainya
            $('#btn_reset').removeClass('d-none');
            $('#param_kelas_id').val(kelas_id);
            table.ajax.reload();
        });

        $('#btn_reset').on('click', function() {
            $('#btn_reset').addClass('d-none');
            $("#kelas_id").val(null);
            $('#param_kelas_id').val(null);
            kelas_id = null;
            table.ajax.reload();
        });
    });
</script>

@endsection