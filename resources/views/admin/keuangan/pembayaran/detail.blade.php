@extends('layouts.admin_layout')

@section('content')
<main>
    <header class="page-header page-header-compact page-header-light border-bottom bg-white mb-4">
        <div class="container-fluid px-4">
            <div class="page-header-content">
                <div class="row align-items-center justify-content-between pt-3">
                    <div class="col-auto mb-3">
                        <h1 class="page-header-title">
                            <div class="page-header-icon"><a href="{{route('web.su.keuangan.pembayaran.list')}}"><i data-feather="arrow-left"></i></a></div>
                            <span id="page-header-title-text">Detail Tagihan</span>
                        </h1>
                    </div>
                    <div class="col-12 col-xl-auto mb-3">
                        <a class="btn btn-sm btn-light text-primary" href="#" id="sendEmailInvoice" data-pembayaran-id="{{ $data_pembayaran->id }}" data-tagihan-id="{{ $id }}">
                            <i class="me-1" data-feather="send"></i>
                            Email Invoice
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
                <div class="table-responsive">
                    <table class="table table-bordered" id="tbTagihan" width="100%" cellspacing="0">
                        <tr>
                            <th style="width: 30%;">Nama Siswa</th>
                            <td style="width: 70%;" id="nama"></td>
                        </tr>
                        <tr>
                            <th>Tagihan</th>
                            <td id="tagihan"></td>
                        </tr>
                        <tr>
                            <th>Diskon</th>
                            <td id="diskon"></td>
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
                            <th>Nominal Kekurangan</th>
                            <td id="kekurangan"></td>
                        </tr>
                        <tr>
                            <th>Keterangan</th>
                            <td id="keterangan"></td>
                        </tr>
                        <tr>
                            <th>Status</th>
                            <td id="status"></td>
                        </tr>
                        <tr>
                            <th>Kelas</th>
                            <td id="kelas"></td>
                        </tr>
                        <tr>
                            <th>Semester</th>
                            <td id="semester"></td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
        <br>
        <div class="card">
            <div class="card-body">
                <h2>Item Tagihan</h2>
                <hr>
                <div class="table-responsive">
                    <table class="table table-bordered" id="tablePembayaran" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                               <th width="25%">Item</th> 
                               <th>Nominal</th> 
                               <th>Terbayar</th>
                            </tr>
                        </thead>
                        <tbody id="tagihanItems">
                            
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <br>
        <div class="card">
            <div class="card-body">
                <h2>Riwayat Pembayaran</h2>
                <hr>
                <div class="table-responsive">
                    <table class="table table-bordered" id="tablePembayaran" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                               <th style="width: 60%;">Keterangan</th>
                               <th style="width: 15%;">Nominal</th>
                               <th style="width: 15%;">Status</th>
                               <th class="text-center" style="width: 10%;">Action</th>
                            </tr>
                        </thead>
                        <tbody id="pembayaranList">
                            
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
                    <div class="mb-3">
                        <label class="mb-1" for="pelunasan_tagihan_ket">Bukti Transfer</label>
                        <br>
                        @if (!empty($data_pembayaran) && $data_pembayaran->url_bukti_trf != null)
                            <a href="/uploads/{{$data_pembayaran->url_bukti_trf}}" target="_blank" class="btn btn-primary">Lihat Bukti Transfer</a>
                        @else
                            <b>Tidak ada</b>
                        @endif
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

        getDetailTagihan();
        function getDetailTagihan() {
            $.ajax({
                type: "POST",
                url: "{{route('ajax.keuangan.tagihan.get')}}",
                data: {
                    "_token": "{{ csrf_token() }}",
                    "id": {{@$id}}
                },
                success: function(res) {
                    // console.log(res);
                    if (!res.error) {
                        console.log(res.data)
                        $('#tbTagihan').find('#nama').html(res.data.ppdb.nama);
                        $('#tbTagihan').find('#diskon').html("Rp. " + formatRibuan(res.data.ppdb.discount));
                        $('#tbTagihan').find('#tagihan').html("Rp. " + formatRibuan(res.data.tagihan));
                        $('#tbTagihan').find('#total_tagihan').html("Rp. " + formatRibuan(res.data.total_tagihan));
                        $('#tbTagihan').find('#nominal').html("Rp. " + formatRibuan(res.data.nominal));
                        $('#tbTagihan').find('#kekurangan').html("Rp. " + formatRibuan(res.data.total_tagihan - res.data.nominal));
                        $('#tbTagihan').find('#keterangan').html(res.data.keterangan);
                        $('#tbTagihan').find('#status').html(toUpperCase(res.data.status));
                        $('#tbTagihan').find('#kelas').html(res.data.ppdb.kelas);
                        $('#tbTagihan').find('#semester').html(res.data.ppdb.smt_kelas);
                        
                        getItemTagihan();
                        getPembayaran();
                    }
                }
            });
        }

        function getItemTagihan() {
            $.ajax({
                type: "POST",
                url: "{{route('ajax.keuangan.tagihan-items.get')}}",
                data: {
                    "_token": "{{ csrf_token() }}",
                    "tagihan_id": id,
                },
                success: function(res) {
                    // console.log(res.data);
                    if (!res.error) {
                        var tbody = "";
                        var terbayar = JSON.parse('{!! json_encode($terbayar) !!}');

                        $.each(res.data, function (i, row) {
                            tbody += ""+
                                "<tr>"+
                                    "<td style='width: 30%;'>"+
                                        row.item+  
                                    "</td>"+
                                    "<td style='width: 40%;'>"+
                                        "Rp. " + formatRibuan(row.nominal)+
                                    "</td>"+
                                    "<td style='width: 30%;'>"+
                                        "Rp. " + (typeof terbayar[row.item] === 'undefined' ?
                                                    0 : formatRibuan(terbayar[row.item]['terbayar'])
                                                ) +
                                    "</td>"+
                                "</tr>";
                        });
                        $("#tagihanItems").html(tbody);
                    }
                }
            });
        }

        function getPembayaran() {
            $.ajax({
                type: "POST",
                url: "{{route('ajax.keuangan.pembayaran.get_by_tagihan', @$id)}}",
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
                                        row.keterangan+  
                                    "</td>"+
                                    "<td>"+
                                        "Rp. " + formatRibuan(row.nominal)+
                                    "</td>"+
                                    "<td>"+
                                        (row.is_approved == 1 ? "Approved" : "Pending")+
                                    "</td>"+
                                    "<td class='text-center'>"+
                                        '<a href="{{route("web.su.keuangan.pembayaran.detail-item")}}/'+row.id+'" class="btn btn-sm btn-transparent-dark"><i class="fas fa-eye"></i></a>'+
                                    "</td>"+
                                "</tr>";
                        });
                        $("#pembayaranList").html(tbody);
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
                        showSuccess('Konfirmasi Berhasil');
                        // resetForm();
                    }else{
                        showError('failed');
                    }
                },
                error: function(response, textStatus, errorThrown){
                    disableLoadingButton("#submitKonfirmasi");
                    ajaxCallbackError(response);
                }
            });
        });

        $('#sendEmailInvoice').on('click', function(e){
            e.preventDefault();
            var pembayaran_id = $(this).data('pembayaran-id');
            var tagihan_id = $(this).data('tagihan-id');

            var data = {
                "_token": "{{ csrf_token() }}",
                pembayaran_id,
                tagihan_id
            }

            sweetAlertAction({
                title: 'Apakah anda yakin?',
                text: 'Email tidak dapat dibatalkan',
                type: 'question',
                withCallback: true,
                callback: function() {
                    ajaxOperation({
                        type: "POST",
                        url: "{{route('ajax.keuangan.pembayaran.send_email_invoice')}}",
                        data: data,
                        withSuccessMessage: true,
                        successMessage: 'Email berhasil dikirim',
                    });
                }
            });
        });
    });
</script>
@endsection
