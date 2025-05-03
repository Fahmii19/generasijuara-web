@extends('layouts.admin_layout')

@section('content')
<main>
    <header class="page-header page-header-compact page-header-light border-bottom bg-white mb-4">
        <div class="container-fluid px-4">
            <div class="page-header-content">
                <div class="row align-items-center justify-content-between pt-3">
                    <div class="col-auto mb-3">
                        <h1 class="page-header-title">
                            Pendaftaran Ulang
                            
                            @if ($is_paid > 0)
                            &nbsp;
                                <span class="badge bg-warning-soft text-warning">Sudah Daftar Ulang</span>
                            @endif
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
                <form id="formPpdb">
                    @csrf
                    <input class="form-control" id="id" type="hidden" />
                    <div class="row gx-3">
                        <div class="mb-3 col-md-6">
                            <label class="small mb-1" for="email">Email*</label>
                            <input readonly="readonly" class="form-control" id="email" name="email" placeholder="" value="" />
                        </div>
                        <div class="mb-3 col-md-4">
                            <label class="small mb-1" for="nama">Nama Siswa (sesuai AKTE) *</label>
                            <input readonly="readonly" class="form-control" id="nama" name="nama" type="text" placeholder="" value="" />
                        </div>
                        <div class="mb-3 col-md-4">
                            <label class="small mb-1" for="nama">NIS</label>
                            <input readonly="readonly" class="form-control" id="nis" name="nis" type="text" placeholder="" value="" />
                        </div>
                    </div>
                    <hr>
                    <h1>Sebelumnya</h1>
                    <div class="row gx-3">
                        <div class="mb-3 col-md-4">
                            <label class="small mb-1" for="kelas_sebelum">Kelas*</label>
                            <input type="hidden" name="kelas_sebelum" id="kelas_sebelum" value="">
                            <input type="text" class="form-control" name="kelas_sebelum_display" id="kelas_sebelum_display" value="" readonly>
                        </div>
                    </div>
                    <h1>Yang dituju</h1>
                    <div class="row gx-3">
                        <div class="mb-3 col-md-3">
                            <label class="small mb-1" for="cabang_id">Cabang</label>
                            <select class="form-control" id="cabang_id" name="cabang_id">

                            </select>
                        </div>
                        <div class="mb-3 col-md-3">
                            <label class="small mb-1" for="kelas">Kelas*</label>
                            <select class="form-control" id="kelas" name="kelas">
                                <option value="" selected>-- Pilih Kelas--</option>
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
                        <div class="mb-3 col-md-3">
                            <label class="small mb-1" for="smt_kelas">Semester*</label>
                            <select class="form-control" id="smt_kelas" name="smt_kelas">
                                <option value="" selected>-- Pilih Semester--</option>
                                <option value="1">1</option>
                                <option value="2">2</option>
                            </select>
                        </div>
                        <div class="mb-3 col-md-3" id="div_peminatan">
                            <label class="small mb-1" for="peminatan">Khusus Paket C (Setara SMA)</label>
                            <select class="form-control" id="peminatan" name="peminatan">
                                <option value="">- Pilih Peminatan -</option>
                                <option value="IPA">IPA</option>
                                <option value="IPS">IPS</option>
                            </select>
                        </div>
                        <div class="mb-3 col-md-4">
                            <label class="small mb-1" for="layanan_kelas_id">Layanan Kelas *</label>
                            <select class="form-control" id="layanan_kelas_id" name="layanan_kelas_id"></select>
                        </div>
                        <div class="mb-3 col-md-4">
                            <label class="small mb-1" for="paket_kelas_id">Paket Kelas *</label>
                            <select class="form-control" id="paket_kelas_id" name="paket_kelas_id"></select>
                        </div>
                        <div class="mb-3 col-md-4">
                            <label class="small mb-1" for="paket_spp_id">Paket SPP *</label>
                            <select class="form-control" id="paket_spp_id" name="paket_spp_id"></select>
                        </div>
                        <div class="card-body mb-3 col-md-4 p-1">
                            <label class="small mb-1" for="kelas_khusus_paket_spp">Semester Kelas Khusus</label>
                            <textarea id="kelas_khusus_paket_spp" class="lh-base form-control" type="text" placeholder="Tidak ada kelas khusus yang dipilih" readonly rows="4"></textarea>
                        </div>
                    </div>
                    <hr>
                    <h1>Biaya</h1>
                    <div class="row gx-3">
                        <div class="mb-3 col-md-4">
                            <label class="small mb-1" for="biaya_daftar">Daftar</label>
                            <input readonly="readonly" class="form-control ribuan-format" id="biaya_daftar" type="text" placeholder="" value="" />
                        </div>
                        <div class="mb-3 col-md-4">
                            <label class="small mb-1" for="biaya_kelas_khusus">Kelas Khusus</label>
                            <input readonly="readonly" class="form-control ribuan-format" id="biaya_kelas_khusus" type="text" placeholder="" value="" />
                        </div>
                        <div class="mb-3 col-md-4">
                            <label class="small mb-1" for="biaya_spp">SPP</label>
                            <input readonly="readonly" class="form-control ribuan-format" id="biaya_spp" type="text" placeholder="" value="" />
                        </div>
                        <div class="mb-3 col-md-4">
                            <label class="small mb-1" for="wakaf">Wakaf</label>
                            <input class="form-control ribuan-format" id="wakaf" type="text" placeholder="" value="" readonly=
                            "readonly" />
                        </div>
                        <div class="mb-3 col-md-4">
                            <label class="small mb-1" for="infaq">Infaq</label>
                            <input class="form-control ribuan-format" id="infaq" type="text" placeholder="" value="" readonly=
                            "readonly" />
                        </div>
                        <div class="mb-3 col-md-4">
                            <label class="small mb-1" for="total_biaya">Total Biaya</label>
                            <input readonly="readonly" class="form-control ribuan-format" id="total_biaya" name="total_biaya" type="text" placeholder="" value="" />
                        </div>
                    </div>
                    <h1>Konfirmasi Pembayaran Anda</h1>
                    <div class="row gx-3">
                        <div class="mb-3 col-md-3">
                            <label class="small mb-1" for="bayar_daftar">Transfer Daftar *</label>
                            <input readonly="readonly" class="form-control ribuan-format transfer-input" id="bayar_daftar" name="bayar_daftar" type="text" placeholder="" value="" />
                        </div>
                        <div class="mb-3 col-md-3">
                            <label class="small mb-1" for="bayar_kelas_khusus">Transfer Kelas Khusus</label>
                            <input class="form-control ribuan-format transfer-input" id="bayar_kelas_khusus" name="bayar_wakaf" type="text" placeholder="" value="" />
                        </div>
                        <div class="mb-3 col-md-3">
                            <label class="small mb-1" for="bayar_spp">Transfer SPP *</label>
                            <input class="form-control ribuan-format transfer-input" id="bayar_spp" name="bayar_spp" type="text" placeholder="" value="" />
                        </div>
                        <div class="mb-3 col-md-3">
                            <label class="small mb-1" for="bayar_wakaf">Transfer Wakaf</label>
                            <input class="form-control ribuan-format transfer-input" id="bayar_wakaf" name="bayar_wakaf" type="text" placeholder="" value="" />
                        </div>
                        <div class="mb-3 col-md-4">
                            <label class="small mb-1" for="bayar_infaq">Transfer Infaq & Sedekah</label>
                            <input class="form-control ribuan-format transfer-input" id="bayar_infaq" name="bayar_infaq" type="text" placeholder="" value="" />
                        </div>
                        <div class="mb-3 col-md-4">
                            <label class="small mb-1" for="voucher_code">Kode Voucher</label>
                            <input class="form-control" id="voucher_code" name="voucher_code" type="text" placeholder="" value="" />
                        </div>
                        <div class="mb-3 col-md-4">
                            <label class="small mb-1" for="discount">Diskon</label>
                            <input readonly="readonly" class="form-control ribuan-format" id="discount" name="discount" type="text" placeholder="" value="0" />
                        </div>
                        <div class="mb-3 col-md-4">
                            <label class="small mb-1" for="total_biaya_setelah_diskon">Total Biaya Setelah Diskon</label>
                            <input readonly="readonly" class="form-control ribuan-format" id="total_biaya_setelah_diskon" name="total_biaya_setelah_diskon" type="text" placeholder="" value="" />
                        </div>
                        <div class="mb-3 col-md-4">
                            <label class="small mb-1" for="total_transfer">Total yang Ditransfer</label>
                            <input readonly="readonly" class="form-control ribuan-format" id="total_transfer" name="total_transfer" type="text" placeholder="" value="" />
                        </div>
                        <div class="mb-3 col-md-4">
                            <label class="small mb-1" for="total_kekurangan_pembayaran">Total Kekurangan
                                Pembayaran</label>
                            <input readonly="readonly" class="form-control ribuan-format"
                                id="total_kekurangan_pembayaran" name="total_kekurangan_pembayaran" type="text"
                                placeholder="" value="" />
                        </div>
                    </div>

                    <h3 class="mt-3">Informasi Bank</h3>
                    <div class="row gx-3">
                        <div class="mb-3 col-md-4">
                            <label class="small mb-1" for="bank_name">Nama Bank*</label>
                            <input class="form-control" id="bank_name" type="text" placeholder="" value="" />
                        </div>
                        <div class="mb-3 col-md-4">
                            <label class="small mb-1" for="bank_account_number">Nomor Rekening Bank*</label>
                            <input class="form-control" id="bank_account_number" type="text" placeholder="" value="" />
                        </div>
                        <div class="mb-3 col-md-4">
                            <label class="small mb-1" for="bank_account_name">Nama Akun Bank*</label>
                            <input class="form-control" id="bank_account_name" type="text" placeholder="" value="" />
                        </div>
                    </div>
                    <div class="row gx-3">
                        <div class="mb-3 col-md-2">
                            <img id="bukti_tf_preview" style="height: 150px" src="{{asset('images')}}/placeholder.png" alt="" class="img-thumbnail">
                            <br>
                            <label>
                                <input type="file" class="d-none" id="bukti_tf_file" accept="image/png, image/jpg, image/jpeg" required>
                                <div class="btn btn-sm btn-primary">Unggah Bukti Transfer *</div>
                            </label>
                        </div>
                        <div class="mb-3 col-md-2">
                            <img id="bukti_infaq_preview" style="height: 150px" src="{{asset('images')}}/placeholder.png" alt="" class="img-thumbnail">
                            <br>
                            <label>
                                <input type="file" class="d-none" id="bukti_infaq_file" name="bukti_infaq_file" accept="image/png, image/jpg, image/jpeg">
                                <div class="btn btn-sm btn-primary">Unggah Bukti Infaq</div>
                            </label>
                        </div>
                    </div>
                    
                    <hr class="my-4" />
                    <div class="d-flex justify-content-between">
                        <button class="btn btn-primary" type="button" id="submitPpdbBtn" {{ $is_paid > 0 ? 'disabled':'' }}>Submit</button>
                    </div>
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
        var cabangSelected = null;
        var layananKelasSelected = null;
        var paketKelasSelected = null;
        var paketSppSelected = null;
        var permintaanSelected = null;
        var kelasSelected = null;
        var smtSelected = null;
        var typeSelected = 0;
        var userId = "{{@$user_id}}";
        var validatorPpdb;
        var newBuktiTfFile = null;
        var newBuktiTfSrc = null;

        var newBuktiInfaqFile = null;
        var newBuktiInfaqSrc = null;

        $('#bukti_tf_file').on('change',function(){
            if(this.files && this.files[0]){
                newBuktiTfFile = this.files[0]
                var newBuktiTfSrc = URL.createObjectURL(newBuktiTfFile)
                $('#formPpdb').find('#bukti_tf_preview').attr("src", newBuktiTfSrc);
            }
        });

        $('#bukti_infaq_file').on('change',function(){
            if(this.files && this.files[0]){
                newBuktiInfaqFile = this.files[0]
                var newBuktiInfaqSrc = URL.createObjectURL(newBuktiInfaqFile)
                $('#formPpdb').find('#bukti_infaq_preview').attr("src", newBuktiInfaqSrc);
            }
        });


        validatorPpdb = $("#formPpdb").validate({
            focusInvalid: true,
            errorClass: "is-invalid",
            success: "is-valid",
            rules: {
                nama : {
                    required: true,
                    minlength: 5
                },
                email: {
                    required: true,
                    email: true
                },
                nik_siswa: {
                    required: true
                },
                nik_ibu: {
                    required: true
                },
                nik_ayah: {
                    required: true
                },
                hp_siswa: {
                    required: true
                },
                hp_ibu: {
                    required: true
                },
                hp_ayah: {
                    required: true
                },
                kelas_sebelum: {
                    required: false
                },
                kelas: {
                    required: true
                },
                smt_kelas: {
                    required: true
                },
                layanan_kelas_id: {
                    required: true
                },
                paket_kelas_id: {
                    required: true
                },
                paket_spp_id: {
                    required: true
                },
                bayar_daftar: {
                    required: true
                },
                bayar_spp: {
                    required: true
                },
                bukti_tf_file: {
                    required: true
                }
            }
        });

        resetForm();

        function resetForm() {
            $('#formPpdb').trigger("reset");
            $("#div_smt_kelas_sebelum").show();
            $("#div_tipe_kelas_sebelum").show();
            newBuktiTfFile = null;
            newBuktiTfSrc = null;
            var newBuktiInfaqFile = null;
            var newBuktiInfaqSrc = null;
            $('#formPpdb').find('#bukti_tf_preview').attr("src", "{{asset('images')}}/placeholder.png");
            $('#formPpdb').find('#bukti_infaq_preview').attr("src", "{{asset('images')}}/placeholder.png");
        }

        $("#email").on("change", function(e) {
            $('#username').val($("#email").val());
        });

        /**
         * Menghitung ulang secara otomati nilai total kekurangan pembayaran 
         * berdasarkan total transfer dan biaya setelah diskon.
        */
        function recalculateTotalKekurangan() {
            let totalTransfer = parseInt($("#total_transfer").val()) || 0;
            let totalBiayaSetelahDiskon = parseInt($("#total_biaya_setelah_diskon").val()) || 0;

            let result = totalBiayaSetelahDiskon - totalTransfer;

            $("#total_kekurangan_pembayaran").val(result);
        }

        function recalculateTotalTransfer() {
            let biaya_spp = parseInt($('#biaya_spp').val(), 0) || 0;
            let bayar_daftar = parseInt($('#bayar_daftar').val(), 0) || 0;
            let bayar_kk = parseInt($('#bayar_kelas_khusus').val(), 0) || 0;
            let bayar_spp = parseInt($('#bayar_spp').val(), 0) || 0;
            let bayar_wakaf = parseInt($('#bayar_wakaf').val(), 0) || 0;
            let bayar_infaq = parseInt($('#bayar_infaq').val(), 0) || 0;

            let total_biaya_setelah_diskon = parseInt($('#total_biaya').val(), 0) || 0;
            let total_transfer = bayar_daftar + bayar_kk +bayar_spp + bayar_wakaf + bayar_infaq;
            let discountAmount = 0;
            if (discount) {
                if (discount.type == 'percentage') {
                    discountAmount = (total_biaya * discount.discount / 100);
                }else{
                    discountAmount = discount.discount;
                }
                total_biaya_setelah_diskon -= discountAmount;
                total_transfer -= discountAmount;
            }

            $('#discount').val(discountAmount)
            $('#total_biaya_setelah_diskon').val(total_biaya_setelah_diskon)
            $('#total_transfer').val(total_transfer)
        }

        $(".transfer-input").on("change", function(e) {
            recalculateTotalTransfer();
            recalculateTotalKekurangan()
        });

        $("#voucher_code").on("change", function(e) {
            checkVoucher();
        });

        var discount = null;
        function checkVoucher() {
            $.ajax({
                type: "POST",
                url: "{{route('ajax.voucher.check_code')}}",
                data: {
                    "_token": "{{ csrf_token() }}",
                    "kode": $("#voucher_code").val(),
                },
                success: function(res) {
                    // console.log(res);
                    if (!res.error) {
                        discount = res.data;
                        recalculateTotalTransfer();
                        recalculateTotalKekurangan()
                    }
                }
            });
        }

        getKelasSebelum();
        function getKelasSebelum() {
            $.ajax({
                type: "POST",
                url: "{{route('ajax.kelas.get_sebelumnya')}}",
                data: {
                    "_token": "{{ csrf_token() }}",
                    "ppdb_id": "{{@$data_ppdb->id}}",
                },
                success: function(res) {
                    console.log(res);
                    if (!res.error) {
                        $("#kelas_sebelum").val(res.data.kelas_id);
                        $("#kelas_sebelum_display").val(res.data.kelas.nama);
                    }
                }
            });
        }

        function formatKelasSebelum (kelas) {
            if (kelas.loading) {
                return kelas.text;
            }

            var $container = $(
                "<div class='select2-result-kelas-sebelum clearfix'>" +
                    "<div class='select2-result-kelas-sebelumnya'>" +
                        "<div class='select2-result-kelas-sebelum__nama'></div>" +
                    "</div>" +
                "</div>"
            );

            $container.find(".select2-result-kelas-sebelum__nama").text(kelas.nama);

            return $container;
        }

        function formatKelasSebelumSelection (kelas) {
            return kelas.nama || kelas.text;
        }


        // $("#kelas_sebelum").on("change", function(e) {
        //     console.log($("#kelas_sebelum").val());
        //     if ($("#kelas_sebelum").val() > 0) {
        //         $("#div_smt_kelas_sebelum").show();
        //         $("#div_tipe_kelas_sebelum").show();
        //     }else{
        //         $("#div_smt_kelas_sebelum").hide();
        //         $("#div_tipe_kelas_sebelum").hide();

        //         $("#smt_kelas_sebelum").val(null);
        //         $("#tipe_kelas_sebelum").val(null);
        //     }
        // });

        $("#kelas").on("change", function(e) {
            // jika sudah SMA
            if ($("#kelas").val() > 9) {
                $("#div_peminatan").show();
            }else{
                $("#div_peminatan").hide();
            }

            kelasSelected = $("#kelas").val();
            fetchPaketSpp()
        });

        $("#cabang_id").on("change", function(e) {
            cabangSelected = $("#cabang_id").val();
            fetchPaketSpp()
        });

        $("#smt_kelas").on("change", function(e) {
            smtSelected = $("#smt_kelas").val();
            fetchPaketSpp()
        });

        $("#layanan_kelas_id").on("change", function(e) {
            layananKelasSelected = $("#layanan_kelas_id").val();
            fetchPaketSpp()
        });

        $("#paket_kelas_id").on("change", function(e) {
            paketKelasSelected = $("#paket_kelas_id").val();
            fetchPaketSpp()
        });

        getCabang();
        function getCabang() {
            $.ajax({
                type: "POST",
                url: "{{route('ajax.cabang.get')}}",
                data: {
                    "_token": "{{ csrf_token() }}",
                },
                success: function(res) {
                    console.log(res);
                    var html_results = "<option value=''>-- Pilih Cabang --</option>";
                    $.each(res.data, function (i, row) {
                        html_results += "<option value='"+row.id+"'>"+row.nama_cabang+"</option>";
                    });
                    $('#cabang_id').html(html_results);
                }
            });
        }

        getLayananKelas();
        function getLayananKelas() {
            $.ajax({
                type: "POST",
                url: "{{route('ajax.layanan_kelas.get_all')}}",
                data: {
                    "_token": "{{ csrf_token() }}",
                },
                success: function(res) {
                    // console.log(res);
                    var html_results = "<option value=''>-- Pilih Layanan --</option>";
                    $.each(res.data, function (i, row) {
                        html_results += "<option value='"+row.id+"'>"+row.kode+"</option>";
                    });
                    $('#layanan_kelas_id').html(html_results);

                    if (layananKelasSelected != null) {
                        $('#layanan_kelas_id').val(layananKelasSelected);
                    }
                }
            });
        }

        getPaketKelas();
        function getPaketKelas() {
            $.ajax({
                type: "POST",
                url: "{{route('ajax.paket_kelas.get_all')}}",
                data: {
                    "_token": "{{ csrf_token() }}",
                    "type": "{{ $type }}",
                },
                success: function(res) {
                    // console.log(res);
                    var html_results = "<option value=''>-- Pilih --</option>";
                    $.each(res.data, function (i, row) {
                        html_results += "<option value='"+row.id+"'>"+row.nama+"</option>";
                    });
                    $('#paket_kelas_id').html(html_results);

                    if (paketKelasSelected != null) {
                        $('#paket_kelas_id').val(paketKelasSelected);
                    }
                }
            });
        }

        $("#paket_spp_id").select2({
            theme: 'bootstrap4',
        });

        fetchPaketSpp();
        function fetchPaketSpp(){
            const paramSpp = {
                'cabang_id' : cabangSelected,
                'kelas' : kelasSelected,
                'semester' : smtSelected,
                'layanan_kelas_id' : layananKelasSelected,
                'paket_kelas_id' : paketKelasSelected,
                'jenis_pendaftaran' : 2,
            };

            getPaketSppOptions(paramSpp, function(output){
                $("#paket_spp_id").html(output);
                if (paketSppSelected != null) {
                    $('#paket_spp_id').val(paketSppSelected);
                }
            });
        }

        $("#paket_spp_id").on("change", function(e) {
            paketSppSelected = $('#paket_spp_id').val();
            getPaketSppDetail(paketSppSelected, function(output){
                $('#biaya_daftar').val(output.biaya_pendaftaran)
                $('#biaya_kelas_khusus').val(output.biaya_kk)
                $('#biaya_spp').val(output.biaya)
                var total_biaya = parseInt(output.biaya_pendaftaran) + parseInt(output.biaya) + parseInt(output.biaya_kk);
                $('#total_biaya').val(total_biaya)

                $('#bayar_daftar').val(output.biaya_pendaftaran)
                $('#bayar_kelas_khusus').val(output.biaya_kk)
                var biayaSpp = parseInt(output.biaya, 0) || 0;
                $('#bayar_spp').val(biayaSpp)
                validatorPpdb
                recalculateTotalTransfer()

                let selected_kk = JSON.parse(output.selected_kk);
                // console.log(selected_kk);
                // let kelas_khusus_from_paket_spp = '';

                let kelas_khusus_from_paket_spp = selected_kk.map(kk => {
                    let kelas = 'Kelas ' + kk[0]; // Mengambil angka pertama sebagai kelas
                    let semester = ' Semester ' + kk[1]; // Mengambil angka kedua sebagai semester
                    return kelas + semester;
                }).join(', ');

                $('#kelas_khusus_paket_spp').val(kelas_khusus_from_paket_spp);
            });
        });

        // Select2 search autofocus
        $(document).on('select2:open', () => {
            document.querySelector('.select2-search__field').focus();
        });

        if (userId != null && userId != '') {
            getDetailPPDB();
        }
        function getDetailPPDB() {
            $.ajax({
                type: "POST",
                url: "{{route('ajax.ppdb.get')}}",
                data: {
                    "_token": "{{ csrf_token() }}",
                    "user_id": userId,
                },
                success: function(res) {
                    // console.log(res);
                    if (!res.error) {
                        $('#formPpdb').find('#id').val(res.data.id);
                        $('#formPpdb').find('#email').val(res.data.email);
                        $('#formPpdb').find('#nis').val(res.data.nis);
                        $('#formPpdb').find('#nama').val(res.data.nama);
                        
                        $('#formPpdb').find('#telegram_siswa').val(res.data.telegram_siswa);
                        $('#formPpdb').find('#telegram_ayah').val(res.data.telegram_ayah);
                        $('#formPpdb').find('#telegram_ibu').val(res.data.telegram_ibu);
                        // $('#formPpdb').find('#kelas_sebelum').val(res.data.kelas_sebelum);
                        $('#formPpdb').find('#smt_kelas_sebelum').val(res.data.smt_kelas_sebelum);
                        $('#formPpdb').find('#tipe_kelas_sebelum').val(res.data.tipe_kelas_sebelum);
                        $('#formPpdb').find('#kelas').val(res.data.kelas);
                        $('#formPpdb').find('#smt_kelas').val(res.data.smt_kelas);
                        $('#formPpdb').find('#lulusan').val(res.data.lulusan);
                        $('#formPpdb').find('#tahun_lulus').val(res.data.tahun_lulus);
                        $('#formPpdb').find('#biaya_daftar').val(res.data.biaya_daftar);
                        $('#formPpdb').find('#biaya_spp').val(res.data.biaya_spp);
                        $('#formPpdb').find('#wakaf').val(res.data.wakaf);
                        $('#formPpdb').find('#is_active').prop("checked", res.data.is_active);
                        $('#formPpdb').find('#is_approved').prop("checked", res.data.is_approved);

                        layananKelasSelected = res.data.layanan_kelas_id;
                        $('#formPpdb').find('#layanan_kelas_id').val(layananKelasSelected);
                        
                        paketKelasSelected = res.data.paket_kelas_id;
                        $('#formPpdb').find('#paket_kelas_id').val(paketKelasSelected);
                        
                        paketSppSelected = res.data.paket_spp_id;
                        $('#formPpdb').find('#paket_spp_id').val(paketSppSelected);

                        permintaanSelected = res.data.peminatan;
                        $('#formPpdb').find('#peminatan').val(permintaanSelected);

                        // // pembayaran
                        // $('#formPpdb').find('#wakaf').val(res.data.wakaf);
                    }
                }
            });
        }

        //Submit

        $('#resetFormBtn').on('click', function(e){
            resetForm();
        });

        $('#submitPpdbBtn').on('click', function(e){
            e.preventDefault();

            var form = $("#formPpdb");
            
            if (!$(form).valid()) {
                validatorPpdb.focusInvalid();
                return false;
            }

            enableLoadingButton("#submitPpdbBtn");

            var formData = new FormData();

            formData.append('_token', "{{ csrf_token() }}");
            formData.append('user_id', "{{@$user_id}}");
            formData.append('ppdb_id', "{{$data_ppdb->id}}");
            formData.append('tahun_akademik_id', "{{$tahun_akademik->id}}");
            formData.append('type', "{{$type}}");
            formData.append('email', "{{$data_ppdb->email}}");
            
            formData.append('semester', $('#formPpdb').find('#smt_kelas').val());
            formData.append('peminatan', $('#formPpdb').find('#peminatan').val());
            formData.append('kelas_sebelum_id', $('#formPpdb').find('#kelas_sebelum').val());
            formData.append('kelas', $('#formPpdb').find('#kelas').val());
            formData.append('layanan_kelas_id', $('#formPpdb').find('#layanan_kelas_id').val());
            formData.append('paket_kelas_id', $('#formPpdb').find('#paket_kelas_id').val());
            formData.append('paket_spp_id', $('#formPpdb').find('#paket_spp_id').val());
            formData.append('biaya_daftar', $('#formPpdb').find('#biaya_daftar').val());
            formData.append('biaya_spp', $('#formPpdb').find('#biaya_spp').val());
            formData.append('bayar_daftar', $('#formPpdb').find('#bayar_daftar').val());
            formData.append('bayar_spp', $('#formPpdb').find('#bayar_spp').val());
            formData.append('wakaf', $('#formPpdb').find('#bayar_wakaf').val());
            formData.append('infaq', $('#formPpdb').find('#bayar_infaq').val());
            formData.append('is_approved', $('#formPpdb').find("#is_approved").is(":checked"));
            formData.append('bank_name', $('#formPpdb').find('#bank_name').val());
            formData.append('bank_account_number', $('#formPpdb').find('#bank_account_number').val());
            formData.append('bank_account_name', $('#formPpdb').find('#bank_account_name').val());
            
            // formData.append('smt_kelas_sebelum', $('#formPpdb').find('#smt_kelas_sebelum').val());
            // formData.append('tipe_kelas_sebelum', $('#formPpdb').find('#tipe_kelas_sebelum').val());
            // formData.append('lulusan', $('#formPpdb').find('#lulusan').val());
            // formData.append('tahun_lulus', $('#formPpdb').find('#tahun_lulus').val());
            // formData.append('wakaf', $('#formPpdb').find('#wakaf').val());
            // formData.append('password', $('#formPpdb').find('#password').val());
            // formData.append('is_active', $('#formPpdb').find("#is_active").is(":checked"));
            // formData.append('voucher_code', $('#formPpdb').find('#voucher_code').val());
            // formData.append('type', typeSelected);
            if (newBuktiTfFile) {
                formData.append('url_bukti_trf', newBuktiTfFile)
            }

            if (newBuktiInfaqFile) {
                formData.append('bukti_infaq', newBuktiInfaqFile)
            }

            $.ajax({
                type: "POST",
                url: "{{route('ajax.ppdb-ulang.create')}}",
                cache : false,
                processData: false,
                contentType: false,
                data: formData,
                success: function(res) {
                    disableLoadingButton("#submitPpdbBtn");
                    $('#submitPpdbBtn').prop('disabled', true);
                    if (!res.error) {
                        showSuccess('Pendaftaran Berhasil, silahkan cek email anda');
                        // resetForm();
                    }else{
                        showError('failed');
                    }
                },
                error: function(response, textStatus, errorThrown){
                    disableLoadingButton("#submitPpdbBtn");
                    ajaxCallbackError(response);
                }
            });
        });
    });
</script>
@endsection
