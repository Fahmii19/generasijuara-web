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
                        <!-- <a class="btn btn-sm btn-light text-primary" href="#">
                            <i class="me-1" data-feather="file"></i>
                            PDF
                        </a>
                        <a class="btn btn-sm btn-light text-primary" href="#">
                            <i class="me-1" data-feather="file"></i>
                            Excel/CSV
                        </a> -->
                        <a class="btn btn-sm btn-light text-primary" href="#" id="importBtn">
                            <i class="me-1" data-feather="file"></i>
                            Import Excel
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
                <div class="row col-lg-12">
                    <div class="mb-3 col-lg-6">
                        <label class="mb-1" for="kelas_id">Kelas</label>
                        <select class="form-control select2-single" id="kelas_id" style="width: 100%">

                        </select>
                    </div>
                    <div class="mb-3 col-lg-6">
                        <label class="mb-1" for="mata_pelajaran_id">Mata Pelajaran</label>
                        <select class="form-control" id="mata_pelajaran_id" style="width: 100%">

                        </select>
                    </div>
                    <hr class="my-4" />
                    <div class="col-12-md">
                        <a href="#" id="generateBtn" class="btn btn-success">Export Excel</a>
                        <a href="#" id="calculateBtn" class="btn btn-warning">Hitung Remedial & Susulan</a>
                    </div>
                </div>
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

<!-- Modal -->
<div class="modal fade" id="modalNilai" data-bs-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="modalNilaiLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">Edit</h5>
                <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="formNilai" method="POST" action="" novalidate>
                    @csrf

                    <!-- Alert jika belum disetting -->
                    <div class="alert alert-red" role="alert" id="alert_kmp_not_setting">
                        <i class="fas fa-exclamation-triangle"></i> Setting nilai belum bisa diatur, silahkan hubungi admin
                    </div>

                    {{-- ongoing --}}
                    <input class="form-control" id="wb_id" name="wb_id" placeholder="wb_id" type="hidden">
                    <input class="form-control" id="kmp_id" name="kmp_id" placeholder="kmp_id" type="hidden">

                    @for ($i = 1; $i <= 3; $i++) <div id="div_modul_{{$i}}">
                        <div class="mb-3">
                            <label><strong>Modul {{$i}}</strong></label>
                        </div>
                        <hr>
                        @php($types = ['p' => 'Pengetahuan', 'k' => 'Keterampilan'])
                        @foreach($types as $kt => $type)
                        <div class="mb-3">
                            <label><strong>Nilai {{$type}}</strong></label>
                        </div>
                        <div class="row gx-3">
                            <div class="mb-3 col-md-6">
                                <label for="{{$kt}}_tugas_{{$i}}">Tugas Modul</label>
                                <input class="form-control nilai-input" id="{{$kt}}_tugas_{{$i}}" type="text" placeholder="">
                            </div>
                            <div class="mb-3 col-md-6">
                                <label for="{{$kt}}_ujian_{{$i}}">Ujian Modul</label>
                                <input class="form-control nilai-input" id="{{$kt}}_ujian_{{$i}}" type="text" placeholder="">
                            </div>
                            <div class="mb-3 col-md-6">
                                <label for="{{$kt}}_nilai_{{$i}}">Nilai Akhir <span class="{{$kt}}_rumus"></span></label>
                                <input class="form-control nilai-input" id="{{$kt}}_nilai_{{$i}}" type="text" placeholder="" readonly="readonly">
                            </div>
                            <div class="mb-3 col-md-6">
                                <label for="{{$kt}}_predikat_{{$i}}">Predikat</label>
                                <input class="form-control nilai-input" id="{{$kt}}_predikat_{{$i}}" type="text" placeholder="" readonly="readonly">
                            </div>
                            <div class="mb-3" id="div_{{$kt}}_remedial_{{$i}}">
                                <div class="alert alert-red" role="alert" id="alert_{{$kt}}_remedial_{{$i}}">
                                    Nilai dibawah KKM.<br>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input nilai-input susulan_remedial" id="{{$kt}}_remedial_tugas_{{$i}}" name="{{$kt}}_remedial_tugas_{{$i}}"
                                            data-type="{{$kt}}" data-category="remedial" data-task="tugas" data-modul="{{$i}}"
                                            type="checkbox" value="">
                                    <label class="form-check-label" for="{{$kt}}_remedial_tugas_{{$i}}">Ajukan Remedial Tugas</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input nilai-input susulan_remedial" id="{{$kt}}_susulan_tugas_{{$i}}" name="{{$kt}}_susulan_tugas_{{$i}}"
                                            data-type="{{$kt}}" data-category="susulan" data-task="tugas" data-modul="{{$i}}"
                                            type="checkbox" value="">
                                    <label class="form-check-label" for="{{$kt}}_susulan_tugas_{{$i}}">Ikut Susulan Tugas</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input nilai-input susulan_remedial" id="{{$kt}}_remedial_ujian_{{$i}}" name="{{$kt}}_remedial_ujian_{{$i}}"
                                            data-type="{{$kt}}" data-category="remedial" data-task="ujian" data-modul="{{$i}}"
                                            type="checkbox" value="">
                                    <label class="form-check-label" for="{{$kt}}_remedial_ujian_{{$i}}">Ajukan Remedial Ujian</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input nilai-input susulan_remedial" id="{{$kt}}_susulan_ujian_{{$i}}" name="{{$kt}}_susulan_ujian_{{$i}}"
                                            data-type="{{$kt}}" data-category="susulan" data-task="ujian" data-modul="{{$i}}"
                                            type="checkbox" value="">
                                    <label class="form-check-label" for="{{$kt}}_susulan_ujian_{{$i}}">Ikut Susulan Ujian</label>
                                </div>
                            </div>
                        </div>
                        @endforeach
            </div>
            @endfor
            <div id="div_sikap">
                <div class="mb-3">
                    <label><strong>Sikap</strong></label>
                </div>
                <hr>
                <div class="mb-3">
                    <label for="sikap_spiritual">Sikap Spiritual</label>
                    <select class="form-control" id="sikap_spiritual">
                        <option value="A">A</option>
                        <option value="B">B</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="sikap_sosial">Sikap Sosial</label>
                    <select class="form-control" id="sikap_sosial">
                        <option value="A">A</option>
                        <option value="B">B</option>
                    </select>
                </div>
            </div>

            <div id="capaian_kompetensi_wrapper" class="mt-4">
                <div class="mb-1">
                    <label for="capaian_kompetensi"><strong>Capaian Kompetensi</strong></label>
                </div>
                <textarea name="capaian_kompetensi" id="capaian_kompetensi" rows="5" style="width: 100%;"></textarea>
            </div>
            </form>
        </div>
        <div class="modal-footer" id="nilai-modal-footer"><button class="btn btn-secondary" type="button" data-bs-dismiss="modal">Close</button><button class="btn btn-primary" type="button" id="submitNilaiBtn">Submit</button></div>
    </div>
</div>
</div>

<!-- Modal -->
<div class="modal fade" id="modalImport" data-bs-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="modalImportLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalImportLabel">Import</h5>
                <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="formImport" method="POST" action="" novalidate>
                    @csrf
                    <div class="mb-3 col-md-6">
                        <label class="small mb-1" for="import_file">File</label>
                        <input class="form-control" id="import_file" type="file" placeholder="" value="" />
                    </div>
                </form>
            </div>
            <div class="modal-footer"><button class="btn btn-secondary" type="button" data-bs-dismiss="modal">Close</button><button class="btn btn-primary" type="button" id="submitImportBtn">Submit</button></div>
        </div>
    </div>
</div>
@stop

@section('style_extra')
<style>
    #div_modul_1,
    #div_modul_3 {
        background-color: #e6fde9;
    }
</style>

<!-- Select2 -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.min.css" rel="stylesheet" />
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@ttskch/select2-bootstrap4-theme@x.x.x/dist/select2-bootstrap4.min.css">
@endsection

@section('js_extra')

<!-- Select2 -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.full.js"></script>

<script type="text/javascript">
    $(document).ready(function() {
        var table = null
        var kelasSelected = null
        var kmpSelected = null

        // var p_tugas = [];
        // var p_ujian = [];
        // var p_nilai = [];
        // var k_tugas = [];
        // var k_nilai = [];
        var susulan_remedial = {
            'susulan': {
                'p_tugas': [],
                'p_ujian': [],
                'k_tugas': [],
                'k_ujian': []
            },
            'remedial': {
                'p_tugas': [],
                'p_ujian': [],
                'k_tugas': [],
                'k_ujian': []
            }
        };

        var persentase_tm = 0;
        var persentase_um = 0;
        var k_persentase_tm = 0;
        var k_persentase_um = 0;
        var kkm = 0;

        function resetModal() {
            $('#modalNilai').find('#nilai-modal-footer').show();
            $('#formNilai').find('#alert_kmp_not_setting').hide();
            $('#formNilai').find('#div_modul_1').show();
            $('#formNilai').find('#div_modul_2').show();
            $('#formNilai').find('#div_modul_3').show();
            $('#formNilai').find('#div_sikap').show();
        }

        // getKelasOptions(function(output) {
        //     $('#kelas_id').html(output);
        // });


        // Select2 Kelas
        $("#kelas_id").select2({
            theme: 'bootstrap4',
            ajax: {
                url: "{{ route('ajax.kelas.get_by_name') }}",
                dataType: 'json',
                type: "POST",
                delay: 250,
                data: function(params) {
                    return {
                        _token: "{{ csrf_token() }}",
                        keyword: params.term, // search term
                        limit: 10,
                    };
                },
                processResults: function(data, params) {
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

        function formatKelas(kelas) {
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

        function formatKelasSelection(kelas) {
            return kelas.nama || kelas.text;
        }

        // Select2 Mata Pelajaran
        $('#mata_pelajaran_id').select2({
            theme: 'bootstrap4',
            placeholder: 'Pilih Mata Pelajaran',
        });

        getMataPelajaran();

        function getMataPelajaran() {
            getMataPelajaranByKelasOptions(kelasSelected, function(output) {
                $('#mata_pelajaran_id').html(output);
            })
        }

        $('#kelas_id').on('change', function() {
            kelasSelected = this.value
            getMataPelajaran()
        });

        $('#mata_pelajaran_id').on('change', function() {
            kmpSelected = this.value
            // console.log('KMP Selected diubah:', kmpSelected)
            getKMPSetting()
            table.ajax.reload();
        });

        function getKMPSetting() {
            resetModal();
            getKMPSettingDetail(kmpSelected, function(output) {
                var dataSetting = output;

                if (dataSetting != null) {
                    if (dataSetting?.jumlah_modul == 2) {
                        $('#formNilai').find('#div_modul_3').hide();
                    } else if (dataSetting?.jumlah_modul == 1) {
                        $('#formNilai').find('#div_modul_3').hide();
                        $('#formNilai').find('#div_modul_2').hide();
                    }

                    if (!dataSetting?.need_nilai_sikap) {
                        $('#formNilai').find('#div_sikap').hide();
                    }

                    persentase_tm = dataSetting?.persentase_tm || 0;
                    persentase_um = dataSetting?.persentase_um || 0;
                    k_persentase_tm = dataSetting?.k_persentase_tm || 0;
                    k_persentase_um = dataSetting?.k_persentase_um || 0;
                    kkm = dataSetting?.kkm || 70;

                    if (persentase_tm == 0) {
                        $('#formNilai').find('input[id*="p_tugas_"]').attr('disabled', true);
                    }
                    if (persentase_um == 0) {
                        $('#formNilai').find('input[id*="p_ujian_"]').attr('disabled', true);
                    }
                    if (k_persentase_tm == 0) {
                        $('#formNilai').find('input[id*="k_tugas_"]').attr('disabled', true);
                    }
                    if (k_persentase_um == 0) {
                        $('#formNilai').find('input[id*="k_ujian_"]').attr('disabled', true);
                    }

                    $('.p_rumus').text('(TM: ' + persentase_tm + '%, UM: ' + persentase_um + '%, KKM: ' + kkm + ')');
                    $('.k_rumus').text('(TM: ' + k_persentase_tm + '%, UM: ' + k_persentase_um + '%, KKM: ' + kkm + ')');
                    // $('.k_rumus').text('(TM: 100%, KKM: '+kkm+')');
                } else {
                    $('#modalNilai').find('#nilai-modal-footer').hide();
                    $('#formNilai').find('#alert_kmp_not_setting').show();
                    $('#formNilai').find('#div_modul_1').hide();
                    $('#formNilai').find('#div_modul_2').hide();
                    $('#formNilai').find('#div_modul_3').hide();
                    $('#formNilai').find('#div_sikap').hide();
                }
            })
        }

            function recalculate() {
                for (var i = 1; i <= 3; i++) {
                // Pengetahuan
                var p_tugas = parseFloat($("#p_tugas_" + i).val()) || 0;
                var p_ujian = parseFloat($("#p_ujian_" + i).val()) || 0;
                var p_nilai = (p_tugas * persentase_tm / 100) + (p_ujian * persentase_um / 100);

                $("#p_nilai_" + i).val(p_nilai.toFixed(2));
                $("#p_predikat_" + i).val(checkPredikat(p_nilai));

                // Tampilkan/sembunyikan remedial jika nilai di bawah KKM
                if (p_nilai < kkm) {
                    $("#div_p_remedial_" + i).show();
                    $("#alert_p_remedial_" + i).show();
                } else {
                    $("#alert_p_remedial_" + i).hide();
                }

                // Keterampilan
                var k_tugas = parseFloat($("#k_tugas_" + i).val()) || 0;
                var k_nilai = k_tugas; // Asumsi nilai keterampilan hanya dari tugas

                $("#k_nilai_" + i).val(k_nilai.toFixed(2));
                $("#k_predikat_" + i).val(checkPredikat(k_nilai));

                if (k_nilai < kkm) {
                    $("#div_k_remedial_" + i).show();
                    $("#alert_k_remedial_" + i).show();
                } else {
                    $("#alert_k_remedial_" + i).hide();
                }
            }
        }


        function checkPredikat(nilai) {
            if (nilai >= 85) return 'A';
            if (nilai >= 70) return 'B';
            if (nilai >= 55) return 'C';
            if (nilai >= 40) return 'D';
            return 'E';
        }

        // Gunakan event input untuk respon lebih cepat
        $('.nilai-input').on('input', function() {
            // Validasi input hanya angka 0-100
            var value = $(this).val();
            if (value && (isNaN(value) || value < 0 || value > 100)) {
                $(this).val('');
                return;
            }
            recalculate();
        });

        table = $('#dtNilai').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: "{{route('ajax.dt.nilai.get')}}",
                dataType: "json",
                "data": function(d) {
                    d._token = "{{ csrf_token() }}",
                        d.kelas_id = kelasSelected
                    d.kmp_id = kmpSelected
                },
                type: "POST",
            },
            bSort: true,
            searching: true,
            lengthChange: true,
            scrollX: true,
            columns: [{
                    "title": "WB",
                    "width": "12%",
                    "data": "nama",
                    "name": "p.nama"
                },
                {
                    "title": "Nilai (P) 1",
                    "width": "12%",
                    "searchable": false,
                    "data": "p_nilai_1",
                    render: function(data, type, row) {
                        if (data == null) return '-';
                        return data + " (" + row.p_predikat_1 + ")";
                    }
                },
                {
                    "title": "Nilai (K) 1",
                    "width": "12%",
                    "searchable": false,
                    "data": "k_nilai_1",
                    render: function(data, type, row) {
                        if (data == null) return '-';
                        return data + " (" + row.k_predikat_1 + ")";
                    }
                },
                {
                    "title": "Nilai (P) 2",
                    "width": "12%",
                    "searchable": false,
                    "data": "p_nilai_2",
                    render: function(data, type, row) {
                        if (data == null) return '-';
                        return data + " (" + row.p_predikat_2 + ")";
                    }
                },
                {
                    "title": "Nilai (K) 2",
                    "width": "12%",
                    "searchable": false,
                    "data": "k_nilai_2",
                    render: function(data, type, row) {
                        if (data == null) return '-';
                        return data + " (" + row.k_predikat_2 + ")";
                    }
                },
                {
                    "title": "Nilai (P) 3",
                    "width": "12%",
                    "searchable": false,
                    "data": "p_nilai_3",
                    render: function(data, type, row) {
                        if (data == null) return '-';
                        return data + " (" + row.p_predikat_3 + ")";
                    }
                },
                {
                    "title": "Nilai (K) 3",
                    "width": "12%",
                    "searchable": false,
                    "data": "k_nilai_3",
                    render: function(data, type, row) {
                        if (data == null) return '-';
                        return data + " (" + row.k_predikat_3 + ")";
                    }
                },
                {
                    "title": "Spiritual",
                    "width": "12%",
                    "searchable": false,
                    "data": "sikap_spiritual"
                },
                {
                    "title": "Sosial",
                    "width": "12%",
                    "searchable": false,
                    "data": "sikap_sosial"
                },
                {
                    "title": "Action",
                    "data": null,
                    "width": "15%",
                    "orderable": false,
                    "searchable": false,
                    render: function(data, type, row) {
                        return '<a href="#" class="editRowBtn btn btn-sm btn-transparent-dark" data-wb_id="' + row.wb_id + '"><i class="fas fa-edit"></i></a>'
                        +'<a href="{{route("web.su.perkembangan.list")}}/'+ row.wb_id +'/'+ kelasSelected +'/'+ kmpSelected +'" target="_blank" class="btn btn-sm btn-transparent-dark lihat-perkembangan"><i class="fas fa-eye"></i></a>';
                    }
                }
            ],
            order: [
                [0, 'asc']
            ],
            columnDefs: []
        });

        $('#dtNilai').on('click', '.editRowBtn', function() {


            var wb_id = $(this).data('wb_id');

            // Isi nilai ke form
            $('#wb_id').val(wb_id);
            $('#kmp_id').val(kmpSelected);

            // console.log('Setelah diisi - WB ID:', $('#wb_id').val());
            // console.log('Setelah diisi - KMP ID:', $('#kmp_id').val());


            reset_susulan_remedial();

           // Reset form dan tampilkan loading
            $('#formNilai').trigger("reset");
            $('#formNilai').find('.is-invalid').removeClass('is-invalid');
            $('#modalNilai').modal('show');
    //
            $.ajax({
                type: "POST",
                url: "{{route('ajax.nilai.get')}}",
                data: {
                    "_token": "{{ csrf_token() }}",
                    wb_id: wb_id,
                    kmp_id: kmpSelected,
                },
                success: function(res) {
                    // console.log(res)
                    if (res.data.jenis_rapor == 'lama') {
                        $('#capaian_kompetensi_wrapper').hide();
                    }

                    if (!res.error) {
                        if (res.data?.nilai.susulan_remedial != null) {
                            susulan_remedial = JSON.parse(res.data?.nilai.susulan_remedial);
                            $.each(susulan_remedial, function(i, v) {
                                $.each(v, function(j, w) {
                                    $.each(w, function(k, x) {
                                        // console.log(i, j, x);
                                        if (i == 'susulan') {
                                            if (j == 'p_tugas') {
                                                $('#formNilai').find('#p_susulan_tugas_' + x).prop("checked", true);
                                            } else if (j == 'p_ujian') {
                                                $('#formNilai').find('#p_susulan_ujian_' + x).prop("checked", true);
                                            } else if (j == 'k_tugas') {
                                                $('#formNilai').find('#k_susulan_tugas_' + x).prop("checked", true);
                                            } else if (j == 'k_ujian') {
                                                $('#formNilai').find('#k_susulan_ujian_' + x).prop("checked", true);
                                            }
                                        } else if (i == 'remedial') {
                                            if (j == 'p_tugas') {
                                                $('#formNilai').find('#p_remedial_tugas_' + x).prop("checked", true);
                                            } else if (j == 'p_ujian') {
                                                $('#formNilai').find('#p_remedial_ujian_' + x).prop("checked", true);
                                            } else if (j == 'k_tugas') {
                                                $('#formNilai').find('#k_remedial_tugas_' + x).prop("checked", true);
                                            } else if (j == 'k_ujian') {
                                                $('#formNilai').find('#k_remedial_ujian_' + x).prop("checked", true);
                                            }
                                        }
                                    });
                                });
                            });
                        }

                        $('#formNilai').find('#wb_id').val(wb_id);
                        $('#formNilai').find('#kmp_id').val(kmpSelected);

                        $('#formNilai').find('#capaian_kompetensi').val(res.data?.nilai.capaian_kompetensi);

                        $('#formNilai').find('#p_tugas_1').val(res.data?.nilai.p_tugas_1);
                        $('#formNilai').find('#p_ujian_1').val(res.data?.nilai.p_ujian_1);
                        $('#formNilai').find('#p_nilai_1').val(res.data?.nilai.p_nilai_1);
                        $('#formNilai').find('#p_predikat_1').val(res.data?.nilai.p_predikat_1);
                        $('#formNilai').find('#k_tugas_1').val(res.data?.nilai.k_nilai_1);
                        $('#formNilai').find('#k_nilai_1').val(res.data?.nilai.k_nilai_1);
                        $('#formNilai').find('#k_predikat_1').val(res.data?.nilai.k_predikat_1);

                        $('#formNilai').find('#p_tugas_2').val(res.data?.nilai.p_tugas_2);
                        $('#formNilai').find('#p_ujian_2').val(res.data?.nilai.p_ujian_2);
                        $('#formNilai').find('#p_nilai_2').val(res.data?.nilai.p_nilai_2);
                        $('#formNilai').find('#p_predikat_2').val(res.data?.nilai.p_predikat_2);
                        $('#formNilai').find('#k_tugas_2').val(res.data?.nilai.k_nilai_2);
                        $('#formNilai').find('#k_nilai_2').val(res.data?.nilai.k_nilai_2);
                        $('#formNilai').find('#k_predikat_2').val(res.data?.nilai.k_predikat_2);

                        $('#formNilai').find('#p_tugas_3').val(res.data?.nilai.p_tugas_3);
                        $('#formNilai').find('#p_ujian_3').val(res.data?.nilai.p_ujian_3);
                        $('#formNilai').find('#p_nilai_3').val(res.data?.nilai.p_nilai_3);
                        $('#formNilai').find('#p_predikat_3').val(res.data?.nilai.p_predikat_3);
                        $('#formNilai').find('#k_tugas_3').val(res.data?.nilai.k_nilai_3);
                        $('#formNilai').find('#k_nilai_3').val(res.data?.nilai.k_nilai_3);
                        $('#formNilai').find('#k_predikat_3').val(res.data?.nilai.k_predikat_3);

                        $('#formNilai').find('#sikap_sosial').val(res.data?.nilai.sikap_sosial);
                        $('#formNilai').find('#sikap_spiritual').val(res.data?.nilai.sikap_spiritual);

                        // $('#formNilai').find('#p_susulan_tugas_1').prop("checked", res.data?.nilai.items?.p_susulan_tugas_1);
                        // $('#formNilai').find('#p_susulan_tugas_2').prop("checked", res.data?.nilai.items?.p_susulan_tugas_2);
                        // $('#formNilai').find('#p_susulan_tugas_3').prop("checked", res.data?.nilai.items?.p_susulan_tugas_3);
                        // $('#formNilai').find('#k_susulan_tugas_1').prop("checked", res.data?.nilai.items?.k_susulan_tugas_1);
                        // $('#formNilai').find('#k_susulan_tugas_2').prop("checked", res.data?.nilai.items?.k_susulan_tugas_2);
                        // $('#formNilai').find('#k_susulan_tugas_3').prop("checked", res.data?.nilai.items?.k_susulan_tugas_3);

                        // $('#formNilai').find('#p_susulan_ujian_1').prop("checked", res.data?.nilai.items?.p_susulan_ujian_1);
                        // $('#formNilai').find('#p_susulan_ujian_2').prop("checked", res.data?.nilai.items?.p_susulan_ujian_2);
                        // $('#formNilai').find('#p_susulan_ujian_3').prop("checked", res.data?.nilai.items?.p_susulan_ujian_3);
                        // $('#formNilai').find('#k_susulan_ujian_1').prop("checked", res.data?.nilai.items?.k_susulan_ujian_1);
                        // $('#formNilai').find('#k_susulan_ujian_2').prop("checked", res.data?.nilai.items?.k_susulan_ujian_2);
                        // $('#formNilai').find('#k_susulan_ujian_3').prop("checked", res.data?.nilai.items?.k_susulan_ujian_3);

                        // $('#formNilai').find('#p_remedial_tugas_1').prop("checked", res.data?.nilai.items?.p_remedial_tugas_1);
                        // $('#formNilai').find('#p_remedial_tugas_2').prop("checked", res.data?.nilai.items?.p_remedial_tugas_2);
                        // $('#formNilai').find('#p_remedial_tugas_3').prop("checked", res.data?.nilai.items?.p_remedial_tugas_3);
                        // $('#formNilai').find('#k_remedial_tugas_1').prop("checked", res.data?.nilai.items?.k_remedial_tugas_1);
                        // $('#formNilai').find('#k_remedial_tugas_2').prop("checked", res.data?.nilai.items?.k_remedial_tugas_2);
                        // $('#formNilai').find('#k_remedial_tugas_3').prop("checked", res.data?.nilai.items?.k_remedial_tugas_3);

                        // $('#formNilai').find('#p_remedial_ujian_1').prop("checked", res.data?.nilai.items?.p_remedial_ujian_1);
                        // $('#formNilai').find('#p_remedial_ujian_2').prop("checked", res.data?.nilai.items?.p_remedial_ujian_2);
                        // $('#formNilai').find('#p_remedial_ujian_3').prop("checked", res.data?.nilai.items?.p_remedial_ujian_3);
                        // $('#formNilai').find('#k_remedial_ujian_1').prop("checked", res.data?.nilai.items?.k_remedial_ujian_1);
                        // $('#formNilai').find('#k_remedial_ujian_2').prop("checked", res.data?.nilai.items?.k_remedial_ujian_2);
                        // $('#formNilai').find('#k_remedial_ujian_3').prop("checked", res.data?.nilai.items?.k_remedial_ujian_3);

                        // Modul 1
                        if (
                            res.data?.nilai.items?.p_susulan_tugas_1 ||
                            res.data?.nilai.items?.p_susulan_ujian_1 ||
                            res.data?.nilai.items?.p_remedial_tugas_1 ||
                            res.data?.nilai.items?.p_remedial_ujian_1
                        ) {
                            $('#formNilai').find('#p_susulan_tugas_1').attr("disabled", true);
                            $('#formNilai').find('#p_susulan_ujian_1').attr("disabled", true);
                            $('#formNilai').find('#p_remedial_tugas_1').attr("disabled", true);
                            $('#formNilai').find('#p_remedial_ujian_1').attr("disabled", true);
                        } else {
                            $('#formNilai').find('#p_susulan_tugas_1').attr("disabled", false);
                            $('#formNilai').find('#p_susulan_ujian_1').attr("disabled", false);
                            $('#formNilai').find('#p_remedial_tugas_1').attr("disabled", false);
                            $('#formNilai').find('#p_remedial_ujian_1').attr("disabled", false);
                        }

                        if (
                            res.data?.nilai.items?.k_susulan_tugas_1 ||
                            res.data?.nilai.items?.k_susulan_ujian_1 ||
                            res.data?.nilai.items?.k_remedial_tugas_1 ||
                            res.data?.nilai.items?.k_remedial_ujian_1
                        ) {
                            $('#formNilai').find('#k_susulan_tugas_1').attr("disabled", true);
                            $('#formNilai').find('#k_susulan_ujian_1').attr("disabled", true);
                            $('#formNilai').find('#k_remedial_tugas_1').attr("disabled", true);
                            $('#formNilai').find('#k_remedial_ujian_1').attr("disabled", true);
                        } else {
                            $('#formNilai').find('#k_susulan_tugas_1').attr("disabled", false);
                            $('#formNilai').find('#k_susulan_ujian_1').attr("disabled", false);
                            $('#formNilai').find('#k_remedial_tugas_1').attr("disabled", false);
                            $('#formNilai').find('#k_remedial_ujian_1').attr("disabled", false);
                        }

                        // Modul 2
                        if (
                            res.data?.nilai.items?.p_susulan_tugas_2 ||
                            res.data?.nilai.items?.p_susulan_ujian_2 ||
                            res.data?.nilai.items?.p_remedial_tugas_2 ||
                            res.data?.nilai.items?.p_remedial_ujian_2
                        ) {
                            $('#formNilai').find('#p_susulan_tugas_2').attr("disabled", true);
                            $('#formNilai').find('#p_susulan_ujian_2').attr("disabled", true);
                            $('#formNilai').find('#p_remedial_tugas_2').attr("disabled", true);
                            $('#formNilai').find('#p_remedial_ujian_2').attr("disabled", true);
                        } else {
                            $('#formNilai').find('#p_susulan_tugas_2').attr("disabled", false);
                            $('#formNilai').find('#p_susulan_ujian_2').attr("disabled", false);
                            $('#formNilai').find('#p_remedial_tugas_2').attr("disabled", false);
                            $('#formNilai').find('#p_remedial_ujian_2').attr("disabled", false);
                        }

                        if (
                            res.data?.nilai.items?.k_susulan_tugas_2 ||
                            res.data?.nilai.items?.k_susulan_ujian_2 ||
                            res.data?.nilai.items?.k_remedial_tugas_2 ||
                            res.data?.nilai.items?.k_remedial_ujian_2
                        ) {
                            $('#formNilai').find('#k_susulan_tugas_2').attr("disabled", true);
                            $('#formNilai').find('#k_susulan_ujian_2').attr("disabled", true);
                            $('#formNilai').find('#k_remedial_tugas_2').attr("disabled", true);
                            $('#formNilai').find('#k_remedial_ujian_2').attr("disabled", true);
                        } else {
                            $('#formNilai').find('#k_susulan_tugas_2').attr("disabled", false);
                            $('#formNilai').find('#k_susulan_ujian_2').attr("disabled", false);
                            $('#formNilai').find('#k_remedial_tugas_2').attr("disabled", false);
                            $('#formNilai').find('#k_remedial_ujian_2').attr("disabled", false);
                        }

                        // Modul 3
                        if (
                            res.data?.nilai.items?.p_susulan_tugas_3 ||
                            res.data?.nilai.items?.p_susulan_ujian_3 ||
                            res.data?.nilai.items?.p_remedial_tugas_3 ||
                            res.data?.nilai.items?.p_remedial_ujian_3
                        ) {
                            $('#formNilai').find('#p_susulan_tugas_3').attr("disabled", true);
                            $('#formNilai').find('#p_susulan_ujian_3').attr("disabled", true);
                            $('#formNilai').find('#p_remedial_tugas_3').attr("disabled", true);
                            $('#formNilai').find('#p_remedial_ujian_3').attr("disabled", true);
                        } else {
                            $('#formNilai').find('#p_susulan_tugas_3').attr("disabled", false);
                            $('#formNilai').find('#p_susulan_ujian_3').attr("disabled", false);
                            $('#formNilai').find('#p_remedial_tugas_3').attr("disabled", false);
                            $('#formNilai').find('#p_remedial_ujian_3').attr("disabled", false);
                        }

                        if (
                            res.data?.nilai.items?.k_susulan_tugas_3 ||
                            res.data?.nilai.items?.k_susulan_ujian_3 ||
                            res.data?.nilai.items?.k_remedial_tugas_3 ||
                            res.data?.nilai.items?.k_remedial_ujian_3
                        ) {
                            $('#formNilai').find('#k_susulan_tugas_3').attr("disabled", true);
                            $('#formNilai').find('#k_susulan_ujian_3').attr("disabled", true);
                            $('#formNilai').find('#k_remedial_tugas_3').attr("disabled", true);
                            $('#formNilai').find('#k_remedial_ujian_3').attr("disabled", true);
                        } else {
                            $('#formNilai').find('#k_susulan_tugas_3').attr("disabled", false);
                            $('#formNilai').find('#k_susulan_ujian_3').attr("disabled", false);
                            $('#formNilai').find('#k_remedial_tugas_3').attr("disabled", false);
                            $('#formNilai').find('#k_remedial_ujian_3').attr("disabled", false);
                        }

                        // $('#formNilai').find('#p_susulan_1').prop("checked", res.data?.nilai.p_susulan_1);
                        // $('#formNilai').find('#p_susulan_2').prop("checked", res.data?.nilai.p_susulan_2);
                        // $('#formNilai').find('#p_susulan_3').prop("checked", res.data?.nilai.p_susulan_3);
                        // $('#formNilai').find('#k_susulan_1').prop("checked", res.data?.nilai.k_susulan_1);
                        // $('#formNilai').find('#k_susulan_2').prop("checked", res.data?.nilai.k_susulan_2);
                        // $('#formNilai').find('#k_susulan_3').prop("checked", res.data?.nilai.k_susulan_3);

                        // $('#formNilai').find('#p_remedial_1').prop("checked", res.data?.nilai.p_remedial_1);
                        // $('#formNilai').find('#p_remedial_2').prop("checked", res.data?.nilai.p_remedial_2);
                        // $('#formNilai').find('#p_remedial_3').prop("checked", res.data?.nilai.p_remedial_3);
                        // $('#formNilai').find('#k_remedial_1').prop("checked", res.data?.nilai.k_remedial_1);
                        // $('#formNilai').find('#k_remedial_2').prop("checked", res.data?.nilai.k_remedial_2);
                        // $('#formNilai').find('#k_remedial_3').prop("checked", res.data?.nilai.k_remedial_3);

                        // if (res.data?.nilai.p_susulan_1 || res.data?.nilai.p_remedial_1) {
                        //     $('#formNilai').find('#p_susulan_1').attr("disabled", true);
                        //     $('#formNilai').find('#p_remedial_1').attr("disabled", true);
                        // } else {
                        //     $('#formNilai').find('#p_susulan_1').attr("disabled", false);
                        //     $('#formNilai').find('#p_remedial_1').attr("disabled", false);
                        // }
                        // if (res.data?.nilai.p_susulan_2 || res.data?.nilai.p_remedial_2) {
                        //     $('#formNilai').find('#p_susulan_2').attr("disabled", true);
                        //     $('#formNilai').find('#p_remedial_2').attr("disabled", true);
                        // } else {
                        //     $('#formNilai').find('#p_susulan_2').attr("disabled", false);
                        //     $('#formNilai').find('#p_remedial_2').attr("disabled", false);
                        // }
                        // if (res.data?.nilai.p_susulan_3 || res.data?.nilai.p_remedial_3) {
                        //     $('#formNilai').find('#p_susulan_3').attr("disabled", true);
                        //     $('#formNilai').find('#p_remedial_3').attr("disabled", true);
                        // } else {
                        //     $('#formNilai').find('#p_susulan_3').attr("disabled", false);
                        //     $('#formNilai').find('#p_remedial_3').attr("disabled", false);
                        // }


                        // if (res.data?.nilai.k_susulan_1 || res.data?.nilai.k_remedial_1) {
                        //     $('#formNilai').find('#k_susulan_1').attr("disabled", true);
                        //     $('#formNilai').find('#k_remedial_1').attr("disabled", true);
                        // } else {
                        //     $('#formNilai').find('#k_susulan_1').attr("disabled", false);
                        //     $('#formNilai').find('#k_remedial_1').attr("disabled", false);
                        // }
                        // if (res.data?.nilai.k_susulan_2 || res.data?.k_remedial_2) {
                        //     $('#formNilai').find('#k_susulan_2').attr("disabled", true);
                        //     $('#formNilai').find('#k_remedial_2').attr("disabled", true);
                        // } else {
                        //     $('#formNilai').find('#k_susulan_2').attr("disabled", false);
                        //     $('#formNilai').find('#k_remedial_2').attr("disabled", false);
                        // }
                        // if (res.data?.k_susulan_3 || res.data?.k_remedial_3) {
                        //     $('#formNilai').find('#k_susulan_3').attr("disabled", true);
                        //     $('#formNilai').find('#k_remedial_3').attr("disabled", true);
                        // } else {
                        //     $('#formNilai').find('#k_susulan_3').attr("disabled", false);
                        //     $('#formNilai').find('#k_remedial_3').attr("disabled", false);
                        // }

                        recalculate();
                    }
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    console.error('AJAX error:', textStatus, 'Error:', errorThrown);
                }
            });
        });

        $('.susulan_remedial').on('change', function () {
            var data_type = $(this).attr('data-type');
            var data_category = $(this).attr('data-category');
            var data_task = $(this).attr('data-task');
            var data_modul = $(this).attr('data-modul');

            if (this.checked) {
                if (data_category == 'susulan') {
                    if (data_task == 'tugas') {
                        if (data_type == 'p') {
                            susulan_remedial.susulan.p_tugas.push(data_modul);
                        } else if (data_type == 'k') {
                            susulan_remedial.susulan.k_tugas.push(data_modul);
                        }
                    } else if (data_task == 'ujian') {
                        if (data_type == 'p') {
                            susulan_remedial.susulan.p_ujian.push(data_modul);
                        } else if (data_type == 'k') {
                            susulan_remedial.susulan.k_ujian.push(data_modul);
                        }
                    }
                } else if (data_category == 'remedial') {
                    if (data_task == 'tugas') {
                        if (data_type == 'p') {
                            susulan_remedial.remedial.p_tugas.push(data_modul);
                        } else if (data_type == 'k') {
                            susulan_remedial.remedial.k_tugas.push(data_modul);
                        }
                    } else if (data_task == 'ujian') {
                        if (data_type == 'p') {
                            susulan_remedial.remedial.p_ujian.push(data_modul);
                        } else if (data_type == 'k') {
                            susulan_remedial.remedial.k_ujian.push(data_modul);
                        }
                    }
                }
            } else {
                if (data_category == 'susulan') {
                    if (data_task == 'tugas') {
                        if (data_type == 'p') {
                            susulan_remedial.susulan.p_tugas.splice(susulan_remedial.susulan.p_tugas.indexOf(data_modul), 1);
                        } else if (data_type == 'k') {
                            susulan_remedial.susulan.k_tugas.splice(susulan_remedial.susulan.k_tugas.indexOf(data_modul), 1);
                        }
                    } else if (data_task == 'ujian') {
                        if (data_type == 'p') {
                            susulan_remedial.susulan.p_ujian.splice(susulan_remedial.susulan.p_ujian.indexOf(data_modul), 1);
                        } else if (data_type == 'k') {
                            susulan_remedial.susulan.k_ujian.splice(susulan_remedial.susulan.k_ujian.indexOf(data_modul), 1);
                        }
                    }
                } else if (data_category == 'remedial') {
                    if (data_task == 'tugas') {
                        if (data_type == 'p') {
                            susulan_remedial.remedial.p_tugas.splice(susulan_remedial.remedial.p_tugas.indexOf(data_modul), 1);
                        } else if (data_type == 'k') {
                            susulan_remedial.remedial.k_tugas.splice(susulan_remedial.remedial.k_tugas.indexOf(data_modul), 1);
                        }
                    } else if (data_task == 'ujian') {
                        if (data_type == 'p') {
                            susulan_remedial.remedial.p_ujian.splice(susulan_remedial.remedial.p_ujian.indexOf(data_modul), 1);
                        } else if (data_type == 'k') {
                            susulan_remedial.remedial.k_ujian.splice(susulan_remedial.remedial.k_ujian.indexOf(data_modul), 1);
                        }
                    }
                }
            }
        });

        function reset_susulan_remedial() {
            susulan_remedial.susulan.p_tugas = [];
            susulan_remedial.susulan.k_tugas = [];
            susulan_remedial.susulan.p_ujian = [];
            susulan_remedial.susulan.k_ujian = [];
            susulan_remedial.remedial.p_tugas = [];
            susulan_remedial.remedial.k_tugas = [];
            susulan_remedial.remedial.p_ujian = [];
            susulan_remedial.remedial.k_ujian = [];
        }

        //Untuk menghitung nilai ongogin
        $('#submitNilaiBtn').on('click', function(e) {
            e.preventDefault();

            // Ambil nilai langsung dari ID, tidak perlu melalui find()
            var wb_id = $('#wb_id').val();
            var kmp_id = $('#kmp_id').val();
            var kelas_id = kelasSelected;

            if (!wb_id || !kmp_id || !kelas_id) {
                swalError({
                    text: 'WB ID, KMP ID, dan Kelas harus diisi!'
                });
                return false;
            }


            var form = $("#formNilai");

            var data = {
                "_token": "{{ csrf_token() }}",
                'wb_id': $('#formNilai').find('#wb_id').val(),
                'kmp_id': $('#formNilai').find('#kmp_id').val(),
                'kelas_id': kelasSelected,
                'p_tugas_1': $('#formNilai').find('#p_tugas_1').val(),
                'p_ujian_1': $('#formNilai').find('#p_ujian_1').val(),
                'p_nilai_1': $('#formNilai').find('#p_nilai_1').val(),
                'p_predikat_1': $('#formNilai').find('#p_predikat_1').val(),
                'k_tugas_1': $('#formNilai').find('#k_tugas_1').val(),
                'k_nilai_1': $('#formNilai').find('#k_nilai_1').val(),
                'k_predikat_1': $('#formNilai').find('#k_predikat_1').val(),
                'capaian_kompetensi': $('#formNilai').find('#capaian_kompetensi').val(),
                'p_tugas_2': $('#formNilai').find('#p_tugas_2').val(),
                'p_ujian_2': $('#formNilai').find('#p_ujian_2').val(),
                'p_nilai_2': $('#formNilai').find('#p_nilai_2').val(),
                'p_predikat_2': $('#formNilai').find('#p_predikat_2').val(),
                'k_tugas_2': $('#formNilai').find('#k_tugas_2').val(),
                'k_nilai_2': $('#formNilai').find('#k_nilai_2').val(),
                'k_predikat_2': $('#formNilai').find('#k_predikat_2').val(),
                'p_tugas_3': $('#formNilai').find('#p_tugas_3').val(),
                'p_ujian_3': $('#formNilai').find('#p_ujian_3').val(),
                'p_nilai_3': $('#formNilai').find('#p_nilai_3').val(),
                'p_predikat_3': $('#formNilai').find('#p_predikat_3').val(),
                'k_tugas_3': $('#formNilai').find('#k_tugas_3').val(),
                'k_nilai_3': $('#formNilai').find('#k_nilai_3').val(),
                'k_predikat_3': $('#formNilai').find('#k_predikat_3').val(),
                'sikap_sosial': $('#formNilai').find('#sikap_sosial').val(),
                'sikap_spiritual': $('#formNilai').find('#sikap_spiritual').val(),
                'susulan_remedial': JSON.stringify(susulan_remedial),

                // 'p_susulan_tugas_1': $('#formNilai').find("#p_susulan_tugas_1").is(":checked"),
                // 'p_susulan_tugas_2': $('#formNilai').find("#p_susulan_tugas_2").is(":checked"),
                // 'p_susulan_tugas_3': $('#formNilai').find("#p_susulan_tugas_3").is(":checked"),
                // 'k_susulan_tugas_1': $('#formNilai').find("#k_susulan_tugas_1").is(":checked"),
                // 'k_susulan_tugas_2': $('#formNilai').find("#k_susulan_tugas_2").is(":checked"),
                // 'k_susulan_tugas_3': $('#formNilai').find("#k_susulan_tugas_3").is(":checked"),
                // 'p_susulan_ujian_1': $('#formNilai').find("#p_susulan_ujian_1").is(":checked"),
                // 'p_susulan_ujian_2': $('#formNilai').find("#p_susulan_ujian_2").is(":checked"),
                // 'p_susulan_ujian_3': $('#formNilai').find("#p_susulan_ujian_3").is(":checked"),
                // 'k_susulan_ujian_1': $('#formNilai').find("#k_susulan_ujian_1").is(":checked"),
                // 'k_susulan_ujian_2': $('#formNilai').find("#k_susulan_ujian_2").is(":checked"),
                // 'k_susulan_ujian_3': $('#formNilai').find("#k_susulan_ujian_3").is(":checked"),
                // 'p_remedial_tugas_1': $('#formNilai').find("#p_remedial_tugas_1").is(":checked"),
                // 'p_remedial_tugas_2': $('#formNilai').find("#p_remedial_tugas_2").is(":checked"),
                // 'p_remedial_tugas_3': $('#formNilai').find("#p_remedial_tugas_3").is(":checked"),
                // 'k_remedial_tugas_1': $('#formNilai').find("#k_remedial_tugas_1").is(":checked"),
                // 'k_remedial_tugas_2': $('#formNilai').find("#k_remedial_tugas_2").is(":checked"),
                // 'k_remedial_tugas_3': $('#formNilai').find("#k_remedial_tugas_3").is(":checked"),
                // 'p_remedial_ujian_1': $('#formNilai').find("#p_remedial_ujian_1").is(":checked"),
                // 'p_remedial_ujian_2': $('#formNilai').find("#p_remedial_ujian_2").is(":checked"),
                // 'p_remedial_ujian_3': $('#formNilai').find("#p_remedial_ujian_3").is(":checked"),
                // 'k_remedial_ujian_1': $('#formNilai').find("#k_remedial_ujian_1").is(":checked"),
                // 'k_remedial_ujian_2': $('#formNilai').find("#k_remedial_ujian_2").is(":checked"),
                // 'k_remedial_ujian_3': $('#formNilai').find("#k_remedial_ujian_3").is(":checked"),

                // 'p_susulan_1': $('#formNilai').find("#p_susulan_1").is(":checked"),
                // 'p_susulan_2': $('#formNilai').find("#p_susulan_2").is(":checked"),
                // 'p_susulan_3': $('#formNilai').find("#p_susulan_3").is(":checked"),
                // 'k_susulan_1': $('#formNilai').find("#k_susulan_1").is(":checked"),
                // 'k_susulan_2': $('#formNilai').find("#k_susulan_2").is(":checked"),
                // 'k_susulan_3': $('#formNilai').find("#k_susulan_3").is(":checked"),
                // 'p_remedial_1': $('#formNilai').find("#p_remedial_1").is(":checked"),
                // 'p_remedial_2': $('#formNilai').find("#p_remedial_2").is(":checked"),
                // 'p_remedial_3': $('#formNilai').find("#p_remedial_3").is(":checked"),
                // 'k_remedial_1': $('#formNilai').find("#k_remedial_1").is(":checked"),
                // 'k_remedial_2': $('#formNilai').find("#k_remedial_2").is(":checked"),
                // 'k_remedial_3': $('#formNilai').find("#k_remedial_3").is(":checked"),
            }

            // console.log('data disubmit dari hitung nilai', data);

            $.ajax({
                type: "POST",
                // ongoing
                url: "{{route('ajax.nilai.save')}}",
                data: data,
                success: function(res) {
                    // console.log('res', res);
                    if (!res.error) {
                        reset_susulan_remedial();
                        $('#modalNilai').modal('hide');
                        // showSuccess("Success");
                        // table.ajax.reload();
                        swalSuccess({
                            text: 'Data berhasil disimpan',
                            withConfirmButton: true,
                            withReloadTable: true,
                            table: table
                        })
                    } else {
                        // showError(res.message);
                        swalError({
                            text: res.message
                        })
                    }
                },
                error: function(response, xhr, error, thrown) {
                    var res = response.responseJSON;

                    switch (response.status) {
                        case (400 || 422):
                            break
                        default:
                            break
                    }

                    showError(res.message);
                }
            });
        });

        // importFile
        var importFile = null;

        $('#import_file').on('change', function() {
            if (this.files && this.files[0]) {
                importFile = this.files[0]
            }
        });

        $('#importBtn').on('click', function() {
            $('#modalImport').modal('show');
            $('#formImport').trigger('reset');
            importFile = null;
        });

        $('#submitImportBtn').on('click', function(e) {
            e.preventDefault();
            var form = $("#formImport");

            if (importFile == null) {
                showError('importFile tidak ditemukan');
                return false;
            }

            enableLoadingButton("#submitImportBtn");

            var formData = new FormData();

            formData.append('_token', "{{ csrf_token() }}");
            formData.append('import_file', importFile);

            $.ajax({
                type: "POST",
                url: "{{route('ajax.nilai.import_excel')}}",
                cache: false,
                processData: false,
                contentType: false,
                data: formData,
                success: function(res) {
                    disableLoadingButton("#submitImportBtn");
                    if (!res.error) {
                        // showSuccess(res.message || "Success");
                        swalSuccess({
                            text: 'Nilai berhasil diimport',
                            withConfirmButton: true
                        });
                        $('#modalImport').modal('hide');
                        table.ajax.reload();
                    } else {
                        // showError('failed');
                        swalError({
                            text: 'Failed'
                        });
                    }
                },
                error: function(response, textStatus, errorThrown) {
                    disableLoadingButton("#submitImportBtn");
                    // ajaxCallbackError(response);
                    swalError({
                        text: response.responseJSON.message,
                        withConfirmButton: true
                    });
                }
            });
        });

        $("#generateBtn").on("click", function(e) {
            if (kelasSelected) {
                const params = {
                    kelas_id: kelasSelected,
                }
                const queryParams = $.param(params);
                window.location = "{{route('web.su.nilai.export_excel')}}?"+queryParams;
            } else {
                swalError({
                    text: 'Silahkan pilih Kelas terlebih dahulu'
                })
            }
            // else alert('Silahkan pilih Kelas terlebih dahulu');
        });

        $("#calculateBtn").on("click", function(e) {
            if (kelasSelected && kmpSelected) {
                sweetAlertAction({
                    title: 'Hitung Remedial dan Susulan?',
                    text: 'Apakah anda yakin ingin menghitung remedial & susulan?',
                    type: 'question',
                    withCallback: true,
                    callback: function() {
                        $('#calculateBtn').addClass('disabled');
                        enableLoadingButton("#calculateBtn");
                        var data = {
                            "_token": "{{ csrf_token() }}",
                            'kelas_id': kelasSelected,
                            'kmp_id': kmpSelected,
                        }

                        ajaxOperation({
                            type: "POST",
                            url: "{{route('ajax.nilai.calculate_tagihan')}}",
                            data: data,
                            withCallback: true,
                            withErrorCallback: true,
                            callback: function() {
                                $('#calculateBtn').removeClass('disabled');
                                disableLoadingButton("#calculateBtn");
                                swalSuccess({
                                    text: 'Data berhasil dihitung',
                                    withConfirmButton: true
                                })
                            },
                            errorCallback: function() {
                                $('#calculateBtn').removeClass('disabled');
                                disableLoadingButton("#calculateBtn");
                            }
                        });
                    }
                })

                // var data = {
                //     "_token": "{{ csrf_token() }}",
                //     'kelas_id': kelasSelected,
                //     'kmp_id': kmpSelected,
                // }

                // enableLoadingButton("#calculateBtn");
                // $.ajax({
                //     type: "POST",
                //     url: "{{route('ajax.nilai.calculate_tagihan')}}",
                //     data: data,
                //     success: function(res) {
                //         disableLoadingButton("#calculateBtn");
                //         if (!res.error) {
                //             // showSuccess("Success");
                //             swalSuccess({
                //                 text: 'Data berhasil dihitung',
                //                 withConfirmButton: true
                //             })
                //         } else {
                //             // showError(res.message);
                //             swalError({
                //                 text: res.message
                //             })
                //         }
                //     },
                //     error: function(response, xhr, error, thrown) {
                //         var res = response.responseJSON;

                //         disableLoadingButton("#calculateBtn");
                //         switch (response.status) {
                //             case (400 || 422):
                //                 break
                //             default:
                //                 break
                //         }

                //         showError(res.message);
                //     }
                // });
            } else {
                swalError({
                    text: 'Silahkan pilih kelas dan mata pelajaran terlebih dahulu'
                });
            }
        });

        // Select2 search autofocus
        $(document).on('select2:open', () => {
            document.querySelector('.select2-search__field').focus();
        });
    });

</script>
@endsection