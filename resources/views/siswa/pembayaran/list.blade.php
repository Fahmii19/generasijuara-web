@extends('layouts.admin_layout')

@section('content')
<main>
    <header class="page-header page-header-compact page-header-light border-bottom bg-white mb-4">
        <div class="container-fluid px-4">
            <div class="page-header-content">
                <div class="row align-items-center justify-content-between pt-3">
                    <div class="col-auto mb-3">
                        <h1 class="page-header-title">
                            Pembayaran
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
                <table class="table table-bordered" id="dtPembayaran" width="100%" cellspacing="0">
                </table>
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
        var table = null;
        var dtUrl = "{{route('ajax.dt.tagihan.get')}}";
        var ppdb_id = {{@$ppdb_id}};

        table = $('#dtPembayaran').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: dtUrl,
                dataType: "json",
                "data": function ( d ) {
                    d._token = "{{ csrf_token() }}",
                    d.ppdb_id = ppdb_id
                },
                type: "POST"
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
                    "title":"Keterangan",
                    "width":"25%",
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
                    "width":"15%",
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
                        return '<a href="{{route('web.siab.keuangan.detail')}}/'+row.id+'" class="btn btn-sm btn-transparent-dark"><i class="fas fa-eye"></i></a>';
                    }
                }
            ],
            order:[[0,'desc']],
            columnDefs:[]
        });
    });
</script>
@endsection
