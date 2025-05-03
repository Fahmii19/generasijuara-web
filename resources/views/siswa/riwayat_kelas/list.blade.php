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
                            Riwayat Kelas
                        </h1>
                    </div>
                    <div class="col-12 col-xl-auto mb-3">
                        {{-- BUTTON --}}
                    </div>
                </div>
            </div>
        </div>
    </header>
    <!-- Main page content-->
    <div class="container-fluid px-4">
        <div class="card">
            <div class="card-body">
                <table class="table table-bordered" id="dtRombel" width="100%" cellspacing="0">
                </table>
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

@if($errors->any())
<script>
    $(document).ready(function() {
        showError('{{ $errors->first() }}');
    });
</script>
@endif

<script type="text/javascript">
    $(document).ready(function() {
        var table = null;

        table = $('#dtRombel').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: "{{route('ajax.dt.rombongan_belajar.get')}}",
                dataType: "json",
                "data": function ( d ) {
                    d._token = "{{ csrf_token() }}",
                    d.ppdb_id = {!! json_encode($ppdb_ids) !!}
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
                    "width":"12%",
                    "data":"tahun_akademik.kode"
                },
                {
                    "title":"NIS",
                    "width":"8%",
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
                    "width":"25%",
                    "data":"ppdb.nama",
                    render: function(data, type, row, meta) {
                        if(data == null) {
                            return '-';
                        } else {
                            return data;
                        }
                    }
                },
                {
                    "title":"Kelas",
                    "width":"23%",
                    "data":"kelas.nama",
                    render: function(data, type, row, meta) {
                        if(data == null) {
                            return '-';
                        } else {
                            return data;
                        }
                    }
                },
                {
                    "title":"Status",
                    "width":"7%",
                    "data":"is_active",
                    render: function(data, type, row, meta) {
                        if(data == 1) {
                            return '<span class="badge bg-green-soft text-green">Aktif</span>';
                        } else {
                            return '<span class="badge bg-warning-soft text-warning">Tidak Aktif</span>';
                        }
                    }
                },
                {
                    "title": "Action",
                    "data": "siab_action",
                    "width":"10%",
                    "class": "text-center",
                    "orderable":false,
                    "searchable":false,
                    render: function(data, type, row, meta) {
                        if(row.is_active == 1) {
                            return data;
                        } else {
                            return '—';
                        }
                    }
                }
            ],
            order:[[1,'desc']],
            columnDefs:[]
        });
    });
</script>

@endsection
