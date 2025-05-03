@extends('layouts.admin_layout')

@section('content')
<main>
    <header class="page-header page-header-compact page-header-light border-bottom bg-white mb-4">
        <div class="container-fluid px-4">
            <div class="page-header-content">
                <div class="row align-items-center justify-content-between pt-3">
                    <div class="col-auto mb-3">
                        <h1 class="page-header-title">
                            <div class="page-header-icon"><a href="{{route('web.siab.keuangan.list')}}"><i data-feather="arrow-left"></i></a></div>
                            <span id="page-header-title-text">Detail Pembayaran</span>
                        </h1>
                    </div>
                    @if ($data_tagihan->total_tagihan > $data_tagihan->nominal)
                    <div class="col-auto mb-3">
                        <button class="btn btn-sm btn-success" id="btn-payoff">Lunasi Pembayaran</button>
                    </div>
                    @endif
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
                    <table class="table table-bordered" id="riwayatPembayaran" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                               <th style="width: 60%;">Keterangan</th> 
                               <th style="width: 15%;">Nominal</th>
                               <th style="width: 15%;">Status</th>
                               <th style="width: 10%;">Action</th>
                            </tr>
                        </thead>
                        <tbody id="pembayaranHistory">
                            
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</main>

<!-- Modal -->
<div class="modal fade" id="modalPayOff" data-bs-backdrop="static" role="dialog" aria-labelledby="modalPayOffLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <form id="formPayOff" method="POST" action="" novalidate  enctype="multipart/form-data">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalPayOffLabel">Lunasi Pembayaran</h5>
                    <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                        @csrf
                        <input type="hidden" id="tagihan_id" name="tagihan_id" value="{{@$id}}">
                        <input type="hidden" id="pembayaran_id" name="pembayaran_id" value="{{@$pembayaran_id}}">
                        <input type="hidden" id="type" name="type" value="{{@$data_tagihan->pembayaran->type ?? @$data_tagihan->type}}">
                        <input type="hidden" id="source_table" name="source_table" value="{{@$data_tagihan->pembayaran->source_table}}">
                        <input type="hidden" id="source_id" name="source_id" value="{{@$data_tagihan->ppdb_id}}">
                        <input type="hidden" id="pelunasan_tagihan" name="pelunasan_tagihan" value="{{@$data_tagihan->tagihan}}">
                        <input type="hidden" id="pelunasan_total_tagihan" name="pelunasan_total_tagihan" value="{{@$data_tagihan->total_tagihan}}">
                        <div class="mb-3">
                            <label class="mb-1" for="pelunasan_tagihan_ket">Keterangan Tagihan</label>
                            <input type="text" class="form-control" id="pelunasan_tagihan_ket" name="pelunasan_tagihan_ket" required>
                        </div>
                        <div class="mb-3">
                            <table class="table table-bordered" id="itemPelunasan" width="100%" cellspacing="0">
                                <tr>
                                    <th>Item</th>
                                    <th>Nominal</th>
                                    <th>Terbayar</th>
                                    <th>Nominal Pelunasan</th>
                                </tr>
                                @foreach ($tagihan_item as $item)
                                <tr>
                                    <td>{{$item->item}}</td>
                                    <td>{{ number_format($item->nominal) }}</td>
                                    <td>{{ number_format($terbayar[$item->item]['terbayar'] ?? 0) }}</td>
                                    <td>
                                        <input type="hidden" name="item_pelunasan[]" value="{{$item->item}}">
                                        <input type="number" class="form-control nominal_pelunasan" name="nominal[]" value="0"
                                            {{($item->nominal == ($terbayar[$item->item]['terbayar'] ?? 0) ? 'readonly' : '')}}>
                                    </td>
                                </tr>
                                @endforeach
                                <tr>
                                    <th colspan="3" class="align-middle">Total Pelunasan</th>
                                    <td><input type="text" id="total_nominal_pelunasan" name="nominal_pelunasan" class="form-control" readonly></td>
                                </tr>
                            </table>
                        </div>
                        <div class="row gx-3">
                            <div class="mb-3 col-md-4">
                                <label class="small mb-1" for="bank_name">Nama Bank*</label>
                                <input class="form-control" id="bank_name" name="bank_name" type="text" placeholder="" value="" />
                            </div>
                            <div class="mb-3 col-md-4">
                                <label class="small mb-1" for="bank_account_number">Nomor Rekening Bank*</label>
                                <input class="form-control" id="bank_account_number" name="bank_account_number" type="text" placeholder="" value="" />
                            </div>
                            <div class="mb-3 col-md-4">
                                <label class="small mb-1" for="bank_account_name">Nama Akun Bank*</label>
                                <input class="form-control" id="bank_account_name" name="bank_account_name" type="text" placeholder="" value="" />
                            </div>
                        </div>
                        <div class="mb-3">
                            <img id="bukti_tf_preview" style="height: 150px" src="{{asset('images')}}/placeholder.png" alt="" class="img-thumbnail">
                            <br>
                            <label>
                                <input type="file" class="d-none" id="bukti_tf_file" name="bukti_tf" accept="image/png, image/jpg, image/jpeg">
                                <div class="btn btn-sm btn-primary">Unggah Bukti Transfer</div>
                            </label>
                        </div>
                    
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-bs-dismiss="modal">Close</button>
                    <button class="btn btn-primary" type="submit" id="submitPelunasan">Submit</button>
                </div>
            </form>
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
        var newBuktiTfFile = null;
        var newBuktiTfSrc = null;
        var validatorPayOff;

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            }
        });

        getDetailTagihan();
        function getDetailTagihan() {
            $.ajax({
                type: "POST",
                url: "{{route('ajax.keuangan.tagihan.get')}}",
                data: {
                    "_token": "{{ csrf_token() }}",
                    "id": "{{@$id}}"
                },
                success: function(res) {
                    console.log(res);
                    if (!res.error) {
                        var kekurangan = res.data.total_tagihan - res.data.nominal;
                        $('#tbPembayaran').find('#nama').html(res.data.ppdb.nama);
                        $('#tbPembayaran').find('#diskon').html("Rp. " + formatRibuan(res.data.ppdb.discount));
                        $('#tbPembayaran').find('#tagihan').html("Rp. " + formatRibuan(res.data.tagihan));
                        $('#tbPembayaran').find('#total_tagihan').html("Rp. " + formatRibuan(res.data.total_tagihan));
                        $('#tbPembayaran').find('#nominal').html("Rp. " + formatRibuan(res.data.nominal));
                        $('#tbPembayaran').find('#kekurangan').html("Rp. " + formatRibuan(kekurangan));
                        $('#tbPembayaran').find('#keterangan').html(res.data.keterangan);

                        $('#formPayOff').find('#nominal_pelunasan').val(kekurangan);
                        $('#formPayOff').find('#pelunasan_tagihan_display').val(formatRibuan(kekurangan));

                        getItemTagihan();
                        getHistoryPembayaran();
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

        function getHistoryPembayaran() {
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
                                        '<a href="{{route("web.siab.keuangan.detail-item")}}/'+row.id+'" class="btn btn-sm btn-transparent-dark"><i class="fas fa-eye"></i></a>'+
                                    "</td>"+
                                "</tr>";
                        });
                        $("#pembayaranHistory").html(tbody);
                    }
                }
            });
        }

        $('#btn-payoff').on('click', function() {
            $('#modalPayOff').modal('show');
        });

        $(".nominal_pelunasan").keyup(function(){
            var total_nominal_pelunasan = 0;
            $('.nominal_pelunasan').each(function(){
                total_nominal_pelunasan += parseFloat(this.value);
            });
            isNaN(total_nominal_pelunasan) ? $('#total_nominal_pelunasan').val(0) : $('#total_nominal_pelunasan').val(total_nominal_pelunasan);
        });

        $('#bukti_tf_file').on('change',function(){
            if(this.files && this.files[0]){
                newBuktiTfFile = this.files[0]
                var newBuktiTfSrc = URL.createObjectURL(newBuktiTfFile)
                $('#formPayOff').find('#bukti_tf_preview').attr("src", newBuktiTfSrc);
            }
        });

        validatorPayOff = $("#formPayOff").validate({
            focusInvalid: true,
            errorClass: "is-invalid",
            success: "is-valid",
            rules: {
                pelunasan_tagihan_ket: {
                    required: true
                },
                bank_name: {
                    required: true
                },
                bank_account_number: {
                    required: true
                },
                bank_account_name: {
                    required: true
                },
            }
        });

        $('#formPayOff').submit(function(e){
            e.preventDefault();

            var form = $("#formPayOff");
            if (!$(form).valid()) {
                validatorPayOff.focusInvalid();
                return false;
            }
            enableLoadingButton("#submitPelunasan");

            // var formData = new FormData();

            // formData.append('_token', "{{ csrf_token() }}");
            // formData.append('tagihan_id', $('#formPayOff').find('#tagihan_id').val());
            // formData.append('pembayaran_id', $('#formPayOff').find('#pembayaran_id').val());
            // formData.append('source_id', $('#formPayOff').find('#source_id').val());
            // formData.append('nominal_pelunasan', $('#formPayOff').find('#nominal_pelunasan').val());
            // formData.append('pelunasan_tagihan', $('#formPayOff').find('#pelunasan_tagihan').val());
            // formData.append('pelunasan_total_tagihan', $('#formPayOff').find('#pelunasan_total_tagihan').val());
            // formData.append('pelunasan_item', $('#formPayOff').find('#pelunasan_item').val());
            // if (newBuktiTfFile) {
            //     formData.append('bukti_tf', newBuktiTfFile)
            // }

            var formData = $(this).serialize();

            $.ajax({
                type: "POST",
                url: "{{route('ajax.keuangan.pelunasan.save')}}",
                data: new FormData(this),
                success: function(res) {
                    disableLoadingButton("#submitPelunasan");
                    if (!res.error) {
                        // showSuccess('Terima kasih, pembayaran anda sedang diproses. Email akan dikirim setelah proses verifikasi');
                        $('#modalPayOff').modal('hide');
                        // setTimeout(function(){
                        //     location.reload();
                        // }, 1500);
                        swalSuccess({
                            text: 'Terima kasih, pembayaran anda sedang diproses. Email akan dikirim setelah proses verifikasi',
                            withConfirmButton: true,
                            withReloadPage: true
                        })
                    }else{
                        showError('failed');
                    }
                },
                cache: false,
                processData: false,
                contentType: false,
                error: function(response, textStatus, errorThrown){
                    disableLoadingButton("#submitPelunasan");
                    ajaxCallbackError(response);
                }
            });
        });
    });
</script>
@endsection
