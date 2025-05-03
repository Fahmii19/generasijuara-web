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
                            Susulan & Remedial
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
                <div class="row col-lg-12">
                    <div class="mb-3 col-lg-6">
                        <label class="mb-1" for="kelas_id">Kelas</label>
                        <div class="input-group mb-3" style="width: 100%">
                            <select class="form-control select2-single" id="kelas_id" aria-describedby="reset_kelas"></select>
                            <button class="btn btn-sm btn-outline-primary" type="button" id="reset_kelas"><i class="fas fa-times"></i></button>
                        </div>
                    </div>
                    <div class="mb-3 col-lg-6">
                        <label class="mb-1" for="mata_pelajaran_id">Mata Pelajaran</label>
                        <div class="input-group mb-3" style="width: 100%">
                            <select class="form-control" id="mata_pelajaran_id" aria-describedby="reset_mapel"></select>
                            <button class="btn btn-sm btn-outline-primary" type="button" id="reset_mapel"><i class="fas fa-times"></i></button>
                        </div>
                    </div>

                    <hr />

                    <div class="col-12-md">
                        <a href="#" id="exportSusulanRemedial" class="btn btn-success">Export Susulan & Remedial</a>
                    </div>
                </div>
            </div>
        </div>
        <br>
        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dtSusulanRemedial" cellspacing="0" style="width: 100%;">
                    </table>
                </div>
            </div>
        </div>
    </div>
</main>

<!-- Modal -->
<div class="modal fade" id="modalNilai" data-bs-backdrop="static" tabindex="-1" role="dialog"
    aria-labelledby="modalNilaiLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">Detail Susulan & Remedial</h5>
                <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="card mb-3">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered" id="tbInformasi" width="100%" cellspacing="0">
                                <tr>
                                    <th style="width: 30%;">Nama Siswa</th>
                                    <td style="width: 70%;" id="detail_nama_siswa"></td>
                                </tr>
                                <tr>
                                    <th>Mata Pelajaran</th>
                                    <td id="detail_mata_pelajaran"></td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
                <form id="formSusulanRemedial">
                    @for ($i = 1; $i <= 3; $i++)
                        <div id="div_modul_{{$i}}" class="p-3">
                            <div class="">
                                <label><strong>Modul {{$i}}</strong></label>
                            </div>
                            <hr>
                            @php($types = ['p' => 'Pengetahuan', 'k' => 'Keterampilan'])
                            @foreach($types as $kt => $type)
                                <div class="mb-3">
                                    <label><strong>{{$type}}</strong></label>
                                </div>
                                <div class="row gx-3">
                                    <div class="mb-3" id="div_{{$kt}}_remedial_{{$i}}">
                                        <div class="form-check">
                                            <input class="form-check-input nilai-input susulan_remedial"
                                                id="{{$kt}}_remedial_tugas_{{$i}}" name="{{$kt}}_remedial_tugas_{{$i}}"
                                                data-type="{{$kt}}" data-category="remedial" data-task="tugas"
                                                data-modul="{{$i}}" type="checkbox" value="" disabled>
                                            <label class="form-check-label text-dark" for="{{$kt}}_remedial_tugas_{{$i}}">Remedial Tugas</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input nilai-input susulan_remedial"
                                                id="{{$kt}}_susulan_tugas_{{$i}}" name="{{$kt}}_susulan_tugas_{{$i}}"
                                                data-type="{{$kt}}" data-category="susulan" data-task="tugas"
                                                data-modul="{{$i}}" type="checkbox" value="" disabled>
                                            <label class="form-check-label text-dark" for="{{$kt}}_susulan_tugas_{{$i}}">Susulan Tugas</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input nilai-input susulan_remedial"
                                                id="{{$kt}}_remedial_ujian_{{$i}}" name="{{$kt}}_remedial_ujian_{{$i}}"
                                                data-type="{{$kt}}" data-category="remedial" data-task="ujian"
                                                data-modul="{{$i}}" type="checkbox" value="" disabled>
                                            <label class="form-check-label text-dark" for="{{$kt}}_remedial_ujian_{{$i}}">Remedial Ujian</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input nilai-input susulan_remedial"
                                                id="{{$kt}}_susulan_ujian_{{$i}}" name="{{$kt}}_susulan_ujian_{{$i}}"
                                                data-type="{{$kt}}" data-category="susulan" data-task="ujian"
                                                data-modul="{{$i}}" type="checkbox" value="" disabled>
                                            <label class="form-check-label text-dark" for="{{$kt}}_susulan_ujian_{{$i}}">Susulan Ujian</label>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endfor
                </form>
            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary" type="button" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal Export -->
<div class="modal fade" id="modalExport" data-bs-backdrop="static" role="dialog" aria-labelledby="modalExportLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <form id="formExport" novalidate>
                <div class="modal-header">
                    <h5 class="modal-title" id="modalExportLabel">Export</h5>
                    <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    @csrf
                    <div class="row">
                        <div class="mb-3 col-12">
                            <label class="small mb-1" for="export_tahun_akademik_id">Tahun Akademik</label>
                            <select class="form-control select2Export" name="tahun_akademik_id" id="export_tahun_akademik_id"></select>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-bs-dismiss="modal">Close</button>
                    <button class="btn btn-primary" type="button" id="submitExportBtn">Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>
@stop

@section('style_extra')

<style>
    .form-check-input:disabled {
        opacity: 1!important;
    }

    input[type="checkbox"]:disabled + label{
        opacity: 1!important;
    }

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
        var tableSusulan = null;
        var kelasSelected = null;
        var kmpSelected = null;
        var tutorId = {{ $tutor_id }};

        // alert("{{ Auth::user()->id }}");

        table = $('#dtSusulanRemedial').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: "{{route('ajax.dt.susulan_remedial.get')}}",
                type: "POST",
                dataType: "json",
                data: function(d) {
                    d._token = "{{ csrf_token() }}",
                    d.is_tutor = true,
                    d.kelas_id = kelasSelected,
                    d.kmp_id = kmpSelected
                },
            },
            bSort: true,
            searching: true,
            lengthChange: true,
            scrollX: true,
            columns: [
                {
                    "data": 'DT_RowIndex',
                    "width": "7%",
                    "title": "No",
                    "name": 'DT_RowIndex',
                    "orderable": false,
                    "searchable": false
                },
                {
                    "title": "WB",
                    "data": "nama_siswa",
                    "name": "nama_siswa"
                },
                {
                    "title": "Kelas",
                    "data": "nama_kelas",
                    "name": "nama_kelas"
                },
                {
                    "title": "Mata Pelajaran",
                    "data": "nama_mapel",
                    "name": "nama_mapel"
                },
                {
                    "title": "Action",
                    "data": null,
                    "width": "10%",
                    "orderable": false,
                    "searchable": false,
                    render: function(data, type, row) {
                        return '<a href="#" class="btn btn-sm btn-transparent-dark detailRowBtn" data-wb_id="' + row.wb_id + '" data-kmp_id="' + row.kmp_id + '" data-nama_siswa="' + row.nama_siswa + '" data-nama_mapel="' + row.nama_mapel + '"><i class="fas fa-eye"></i></a>';
                    }
                }
            ],
            order: [
                [0, 'asc']
            ],
            columnDefs: []
        });

        // Select2 Kelas
        $("#kelas_id").select2({
            theme: 'bootstrap4',
            ajax: {
                url: "{{ route('ajax.kelas.get_all') }}",
                dataType: 'json',
                type: "POST",
                delay: 250,
                data: function(params) {
                    return {
                        _token: "{{ csrf_token() }}",
                        keyword: params.term, // search term
                        user_id_tutor: "{{Auth::user()->id}}",
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

        getTahunAkademik();
        function getTahunAkademik() {
            $.ajax({
                type: "POST",
                url: "{{route('ajax.tahun_akademik.list')}}",
                data: {
                    "_token": "{{ csrf_token() }}",
                },
                success: function(res) {
                    console.log(res);
                    var html_results = "<option value=''>Semua</option>";
                    $.each(res.data, function (i, row) {
                        html_results += "<option value='"+row.id+"'>"+row.kode+" - "+row.keterangan+"</option>";
                    });
                    $('#export_tahun_akademik_id').html(html_results);
                }
            });
        }

        $("#export_tahun_akademik_id").select2({
            theme: 'bootstrap4',
            placeholder: "Pilih Tahun Akademik",
            dropdownParent: $("#modalExport"),
        });

        $('#kelas_id').on('change', function() {
            kelasSelected = this.value;
            kmpSelected = null;
            getMataPelajaran();
            table.ajax.reload();
        });

        $('#mata_pelajaran_id').on('change', function() {
            kmpSelected = this.value;
            table.ajax.reload();
        });

        // Reset Option
        $("#reset_kelas").on("click", function(e) {
            $('#kelas_id').val(null).trigger('change');
            $('#mata_pelajaran_id').val(null).trigger('change');
            table.ajax.reload();
        });

        $("#reset_mapel").on("click", function(e) {
            $('#mata_pelajaran_id').val(null).trigger('change');
            table.ajax.reload();
        });

        $('#dtSusulanRemedial').on('click', '.detailRowBtn', function() {
            var wb_id_selected = $(this).data('wb_id');
            var kmp_id_selected = $(this).data('kmp_id');
            var nama_siswa = $(this).data('nama_siswa');
            var nama_mapel = $(this).data('nama_mapel');
            
            // Reset
            $('#formSusulanRemedial').find('input:checkbox:checked').prop('checked', false);
            $('#tbInformasi').find('#detail_nama_siswa').html('-');
            $('#tbInformasi').find('#detail_mata_pelajaran').html('-');

            $.ajax({
                type: "POST",
                url: "{{route('ajax.nilai.get')}}",
                data: {
                    "_token": "{{ csrf_token() }}",
                    wb_id: wb_id_selected,
                    kmp_id: kmp_id_selected,
                },
                success: function(res) {
                    // console.log(res)
                    if (!res.error) {
                        $('#tbInformasi').find('#detail_nama_siswa').html(nama_siswa ?? '-');
                        $('#tbInformasi').find('#detail_mata_pelajaran').html(nama_mapel ?? '-');

                        if (res.data?.susulan_remedial != null) {
                            susulan_remedial = JSON.parse(res.data?.susulan_remedial);
                            $.each(susulan_remedial, function(i, v) {
                                $.each(v, function(j, w) {
                                    $.each(w, function(k, x) {
                                        // console.log(i, j, x);
                                        if (i == 'susulan') {
                                            if (j == 'p_tugas') {
                                                $('#formSusulanRemedial').find('#p_susulan_tugas_' + x).prop("checked", true);
                                            } else if (j == 'p_ujian') {
                                                $('#formSusulanRemedial').find('#p_susulan_ujian_' + x).prop("checked", true);
                                            } else if (j == 'k_tugas') {
                                                $('#formSusulanRemedial').find('#k_susulan_tugas_' + x).prop("checked", true);
                                            } else if (j == 'k_ujian') {
                                                $('#formSusulanRemedial').find('#k_susulan_ujian_' + x).prop("checked", true);
                                            }
                                        } else if (i == 'remedial') {
                                            if (j == 'p_tugas') {
                                                $('#formSusulanRemedial').find('#p_remedial_tugas_' + x).prop("checked", true);
                                            } else if (j == 'p_ujian') {
                                                $('#formSusulanRemedial').find('#p_remedial_ujian_' + x).prop("checked", true);
                                            } else if (j == 'k_tugas') {
                                                $('#formSusulanRemedial').find('#k_remedial_tugas_' + x).prop("checked", true);
                                            } else if (j == 'k_ujian') {
                                                $('#formSusulanRemedial').find('#k_remedial_ujian_' + x).prop("checked", true);
                                            }
                                        }
                                    });
                                });
                            });
                        }
                    }

                    $('#modalNilai').modal('show');
                }
            });
        });

        $('#exportSusulanRemedial').on('click', function() {
            var kelas_id = $('#kelas_id').val();
            var mata_pelajaran_id = $('#mata_pelajaran_id').val() ?? "";

            if (kelas_id == null) {
                $('#export_tahun_akademik_id').val(null).trigger('change');
                $('#modalExport').modal('show');
            } else {
                exportSusulanRemedial({
                    kelas_id: kelas_id,
                    mata_pelajaran_id: mata_pelajaran_id,
                    tahun_akademik_id: "",
                });
            }
        });

        $('#submitExportBtn').on('click', function() {
            exportSusulanRemedial({
                kelas_id: "",
                mata_pelajaran_id: "",
                tahun_akademik_id: $('#export_tahun_akademik_id').val(),
            });
        });
        
        function exportSusulanRemedial(context) {
            var kelas_id = context['kelas_id'] ?? "";
            var mata_pelajaran_id = context['mata_pelajaran_id'] ?? "";
            var tahun_akademik_id = context['tahun_akademik_id'] ?? "";

            var parameter = "?kelas_id=" + kelas_id + "&kmp_id=" + mata_pelajaran_id + "&tutor_id=" + tutorId + "&tahun_akademik_id=" + tahun_akademik_id;
            var url = "{{route('web.situ.susulan_remedial.export_excel')}}" + parameter;
            window.location.href = url;
        }
    });

    // Select2 search autofocus
    $(document).on('select2:open', () => {
        document.querySelector('.select2-search__field').focus();
    });
</script>
@endsection