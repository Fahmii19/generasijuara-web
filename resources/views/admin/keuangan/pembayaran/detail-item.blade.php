@extends('layouts.admin_layout')

@section('content')
<main>
    <header class="page-header page-header-compact page-header-light border-bottom bg-white mb-4">
        <div class="container-fluid px-4">
            <div class="page-header-content">
                <div class="row align-items-center justify-content-between pt-3">
                    <div class="col-auto mb-3">
                        <h1 class="page-header-title">
                            <div class="page-header-icon"><a href="{{route('web.su.keuangan.pembayaran.detail')}}/{{$data_pembayaran->tagihan_id}}"><i data-feather="arrow-left"></i></a></div>
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
                        <tr>
                            <th>Bukti Transfer</th>
                            <td id="butki_transfer">
                                @if ($data_pembayaran->url_bukti_trf != null)
                                <span class="badge bg-green-soft text-green">
                                    <a href="{{$data_pembayaran->url_bukti_trf}}" target="_blank">Lihat Bukti Transfer</a>
                                </span>
                                @else
                                    <span class="badge bg-yellow-soft text-yellow">Tidak Ada</span>
                                @endif
                            </td>
                        </tr>
                        @if (!$data_pembayaran->is_approved)
                        <tr>
                            <td colspan="2">
                                <div class="d-grid gap-2">
                                    <button class="btn btn-success" id="btn-konfirmasi">Konfirmasi Pembayaran</button>
                                </div>
                            </td>
                        </tr>
                        @endif
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

<!-- Modal -->
<div class="modal fade" id="modalKonfirmasi" data-bs-backdrop="static" role="dialog" aria-labelledby="modalKonfirmasiLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalKonfirmasiLabel">Konfirmasi Pembayaran</h5>
                <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="formKonfirmasi" method="POST" action="" novalidate>
                    @csrf
                    <input type="hidden" id="pembayaran_id" name="pembayaran_id" value="{{@$id}}">
                    <input type="hidden" id="tagihan_id" name="tagihan_id" value="{{@$data_pembayaran->tagihan_id}}">
                    <div class="mt-3 mb-3">
                        Apakah anda yakin untuk mengonfirmasi pembayaran ini?
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary" type="button" data-bs-dismiss="modal">Close</button>
                <button class="btn btn-primary" type="button" id="submitKonfirmasi">Konfirmasi</button>
            </div>
        </div>
    </div>
</div>

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
                    // console.log(res);
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
                    // console.log(res.data);
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

        $('#btn-konfirmasi').on('click', function() {
            $('#modalKonfirmasi').modal('show');
        });

        $('#submitKonfirmasi').on('click', function(e){
            e.preventDefault();

            var form = $("#formKonfirmasi");
            enableLoadingButton("#submitKonfirmasi");

            var formData = new FormData();

            formData.append('_token', "{{ csrf_token() }}");
            formData.append('pembayaran_id', $('#formKonfirmasi').find('#pembayaran_id').val());
            formData.append('tagihan_id', $('#formKonfirmasi').find('#tagihan_id').val());

            $.ajax({
                type: "POST",
                url: "{{route('ajax.keuangan.pembayaran.konfirmasi')}}",
                cache : false,
                processData: false,
                contentType: false,
                data: formData,
                success: function(res) {
                    disableLoadingButton("#submitKonfirmasi");
                    if (!res.error) {
                        // showSuccess('Konfirmasi Berhasil');
                        swalSuccess({
                            text: 'Konfirmasi Berhasil',
                            withConfirmButton: true,
                        });
                        $("#submitKonfirmasi").attr("disabled", true);
                        $("#btn-konfirmasi").attr("disabled", true);
                        $('#modalKonfirmasi').modal('hide');
                        // location.reload();
                    }else{
                        // showError('failed');
                        swalError({text: 'Konfirmasi Gagal'});
                    }
                },
                error: function(response, textStatus, errorThrown){
                    disableLoadingButton("#submitKonfirmasi");
                    ajaxCallbackError(response);
                }
            });
        });
    });
</script>
@endsection
