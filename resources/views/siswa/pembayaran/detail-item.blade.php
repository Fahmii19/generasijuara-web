@extends('layouts.admin_layout')

@section('content')
<main>
    <header class="page-header page-header-compact page-header-light border-bottom bg-white mb-4">
        <div class="container-fluid px-4">
            <div class="page-header-content">
                <div class="row align-items-center justify-content-between pt-3">
                    <div class="col-auto mb-3">
                        <h1 class="page-header-title">
                            <div class="page-header-icon"><a href="{{route('web.siab.keuangan.detail')}}/{{$data_pembayaran->tagihan_id}}"><i data-feather="arrow-left"></i></a></div>
                            <span id="page-header-title-text">Detail Pembayaran</span>
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
                <div class="table-responsive">
                    <table class="table table-bordered" id="tbPembayaran" width="100%" cellspacing="0">
                        <tr>
                            <th style="width: 30%;">Nama Siswa</th>
                            <td style="width: 70%;" id="nama"></td>
                        </tr>
                        <tr>
                            <th>Total Tagihan</th>
                            <td id="total_tagihan"></td>
                        </tr>
                        <tr>
                            <th>Nominal Terbayar</th>
                            <td id="nominal"></td>
                        </tr>
                        <tr>
                            <th>Keterangan</th>
                            <td id="keterangan"></td>
                        </tr>
                        <tr>
                            <th>Nama Bank</th>
                            <td id="nama_bank"></td>
                        </tr>
                        <tr>
                            <th>Nomor Rekenning</th>
                            <td id="nomor_rekening"></td>
                        </tr>
                        <tr>
                            <th>Nama Akun Bank</th>
                            <td id="nama_akun_bank"></td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
        <br>
        <div class="card">
            <div class="card-body">
                <h2>Item Pembayaran</h2>
                <hr>
                <div class="table-responsive">
                    <table class="table table-bordered" id="tablePembayaran" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                               <th style="width: 60%;">Item</th>
                               <th style="width: 40%;">Nominal</th>
                            </tr>
                        </thead>
                        <tbody id="pembayaranItem">
                            
                        </tbody>
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
        var id = "{{@$id}}";

        getDetailPembayaran();
        function getDetailPembayaran() {
            $.ajax({
                type: "POST",
                url: "{{route('ajax.keuangan.pembayaran.get_by_id', @$id)}}",
                data: {
                    "_token": "{{ csrf_token() }}",
                    "id": {{@$id}}
                },
                success: function(res) {
                    console.log(res);
                    if (!res.error) {
                        $('#tbPembayaran').find('#nama').html(res.data.ppdb.nama);
                        $('#tbPembayaran').find('#diskon').html("Rp. " + formatRibuan(res.data.ppdb.discount));
                        $('#tbPembayaran').find('#tagihan').html("Rp. " + formatRibuan(res.data.tagihan));
                        $('#tbPembayaran').find('#total_tagihan').html("Rp. " + formatRibuan(res.data.total_tagihan));
                        $('#tbPembayaran').find('#nominal').html("Rp. " + formatRibuan(res.data.nominal));
                        $('#tbPembayaran').find('#keterangan').html(res.data.keterangan);
                        $('#tbPembayaran').find('#nama_bank').html((res.data.bank_name ?? '-'));
                        $('#tbPembayaran').find('#nomor_rekening').html((res.data.bank_account_number ?? '-'));
                        $('#tbPembayaran').find('#nama_akun_bank').html((res.data.bank_account_name ?? '-'));

                        getPembayaran();
                    }
                }
            });
        }

        function getPembayaran() {
            $.ajax({
                type: "POST",
                url: "{{route('ajax.keuangan.pembayaran.get_item', @$id)}}",
                data: {
                    "_token": "{{ csrf_token() }}",
                },
                success: function(res) {
                    console.log(res.data);
                    if (!res.error) {
                        var tbody = "";
                        var totalPayment = 0;
                        $.each(res.data, function (i, row) {
                            tbody += ""+
                                "<tr>"+
                                    "<td>"+
                                        row.item+  
                                    "</td>"+
                                    "<td>"+
                                        "Rp. " + formatRibuan(row.nominal)+
                                    "</td>"+
                                "</tr>";
                        });
                        $("#pembayaranItem").html(tbody);
                    }
                }
            });
        }
    });
</script>
@endsection
