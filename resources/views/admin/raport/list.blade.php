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
                            Raport
                        </h1>
                    </div>
                    <!-- <div class="col-12 col-xl-auto mb-3">
                        <a class="btn btn-sm btn-light text-primary" href="#">
                            <i class="me-1" data-feather="file"></i>
                            PDF
                        </a>
                        <a class="btn btn-sm btn-light text-primary" href="#">
                            <i class="me-1" data-feather="file"></i>
                            Excel/CSV
                        </a>
                    </div> -->
                </div>
            </div>
        </div>
    </header>
    <!-- Main page content-->
    <div class="container-fluid px-4">
        <div class="card">
            <div class="card-body">
                <form>
                    <div class="row col-lg-12">
                        <!-- <div class="mb-3 col-lg-4">
                            <label for="kelas">Kelas</label>
                            <select class="form-control" id="kelas">
                                <option value>-- Pilih Kelas--</option>
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
                        <div class="mb-3 col-lg-4">
                            <label for="semester">Semester</label>
                            <select class="form-control" id="semester">
                                <option value>-- Pilih Semester--</option>
                                <option value="1">1</option>
                                <option value="2">2</option>
                            </select>
                        </div> -->
                        
                        <div class="mb-3 col-lg-4">
                            <label class="mb-1" for="kelas_id">Kode Kelas</label>
                            <select class="form-control" id="kelas_id" style="100%">
                                <option>-- Pilih Kelas--</option>
                            </select>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <br>
        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dtWB" width="100%" cellspacing="0">
                    </table>
                </div>
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
        
        var table = null
        var kelasSelected = null
        var kelasInt = null
        var smtSelected = null

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
                        limit: 10,
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


        // getKelas();
        // function getKelas() {
        //     $.ajax({
        //         type: "POST",
        //         url: "{{route('ajax.kelas.get_all')}}",
        //         data: {
        //             "_token": "{{ csrf_token() }}",
        //             "kelas" : kelasInt,
        //             "semester" : smtSelected
        //         },
        //         success: function(res) {
        //             // console.log(res);
        //             var html_results = "<option value=''>-- Pilih Kelas --</option>";
        //             $.each(res.data, function (i, row) {
        //                 html_results += "<option value='"+row.id+"'>"+row.nama+"</option>";
        //             });
        //             $('#kelas_id').html(html_results);
        //         }
        //     });
        // }

        $('#kelas').on('change', function() {
            kelasInt = this.value 
            getKelas();
        });

        $('#semester').on('change', function() {
            smtSelected = this.value 
            getKelas();
        });

        $('#kelas_id').on('change', function() {
            kelasSelected = this.value 
            table.ajax.reload();
        });

        table = $('#dtWB').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: "{{route('ajax.dt.kelas_wb.get')}}",
                dataType: "json",
                "data": function ( d ) {
                    d._token = "{{ csrf_token() }}",
                    d.kelas_id = kelasSelected,
                    d.show_all = true
                },
                type: "POST",
            },
            bSort: true,
            searching: true,
            lengthChange: true,
            scrollX: true,
            columns:[
                {
                    "title":"Nama Siswa",
                    "width":"12%",
                    "data":"ppdb_nama",
                    "name": "ppdb.nama"
                },
                {
                    "title":"NIS",
                    "width":"12%",
                    "data":"ppdb_nis",
                    "name": "ppdb.nis"
                },
                {
                    "title": "Action",
                    "data":null,
                    "width":"15%",
                    "orderable":false,
                    "searchable":false,
                    render: function (data,type, row){
                        return '<a target="_blank" href="{{route('web.su.raport.print')}}?kelas_wb='+row.id+'" class="printBtn btn btn-sm btn-transparent-dark" data-wb_id="'+row.wb_id+'"><i class="fas fa-file"></i></a>'+
                            '<a href="{{route('web.su.raport.detail')}}?kelas_wb='+row.id+'" class="editRowBtn btn btn-sm btn-transparent-dark" data-wb_id="'+row.wb_id+'"><i class="fas fa-eye"></i></a>'+
                            '<a target="_blank" href="{{route('web.su.raport-cover.print')}}?kelas_wb='+row.id+'" class="printBtn btn btn-sm btn-transparent-dark" data-wb_id="'+row.wb_id+'"><i class="fas fa-print"></i></a>';
                    }
                }
            ],
            order:[[0,'asc']],
            columnDefs:[]
        });
    });

    // Select2 search autofocus
    $(document).on('select2:open', () => {
        document.querySelector('.select2-search__field').focus();
    });
</script>
@endsection
