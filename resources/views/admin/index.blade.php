@extends('layouts.admin_layout')

@section('content')
<main>
    <header class="page-header page-header-dark bg-gradient-primary-to-secondary pb-10">
        <div class="container-xl px-4">
            <div class="page-header-content pt-4">
                <div class="row align-items-center justify-content-between">
                    <div class="col-auto mt-4">
                        <h1 class="page-header-title">
                            <div class="page-header-icon"><i data-feather="activity"></i></div>
                            Dashboard
                        </h1>
                        <div class="page-header-subtitle">Dashboard Generasi Juara</div>
                    </div>
                    <!-- <div class="col-12 col-xl-auto mt-4">
                        <div class="input-group input-group-joined border-0" style="width: 16.5rem">
                            <span class="input-group-text"><i class="text-primary" data-feather="calendar"></i></span>
                            <input class="form-control ps-0 pointer" id="litepickerRangePlugin" placeholder="Select date range..." />
                        </div>
                    </div> -->
                </div>
            </div>
        </div>
    </header>
    <!-- Main page content-->
    <div class="container-xl px-4 mt-n10">
        <div class="row">
            <div class="col-xxl-4 col-xl-12 mb-4">
                <div class="card h-100">
                    <div class="card-body h-100 p-5">
                        <div class="row align-items-center">
                            <div class="col-xl-8 col-xxl-12">
                                <div class="text-center text-xl-start text-xxl-center mb-4 mb-xl-0 mb-xxl-4">
                                    <h1 class="text-primary">Selamat Datang di Dashboard Baru Generasi Juara</h1>
                                    <p class="text-gray-700 mb-0">Apabila mengalami kendala harap hubungi admin kami.
                                        Terima kasih.</p>
                                </div>
                            </div>
                            <div class="col-xl-4 col-xxl-12 text-center"><img class="img-fluid"
                                    src="{{asset('assets/admin/dist')}}/assets/img/illustrations/at-work.svg"
                                    style="max-width: 26rem" /></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xxl-8 col-xl-12 mb-4">
                <div class="card card-header-actions h-100">
                    <div class="card-header">
                        Berita
                    </div>
                    <div class="card-body">
                        <div class="timeline timeline-xs" id="timeline_news">
                            <!-- Timeline Item 1-->
                            <div class="timeline-item">
                                <div class="timeline-item-marker">
                                    <div class="timeline-item-marker-text">27 min</div>
                                    <div class="timeline-item-marker-indicator bg-green"></div>
                                </div>
                                <div class="timeline-item-content">
                                    Title | Body
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <label class="mb-1" for="tahun_akademik_filter">Tahun Akademik</label>
                <div class="input-group mb-3">
                    <select class="form-control" id="tahun_akademik_filter" aria-describedby="reset_tahun_akademik"></select>
                    <button class="btn btn-sm btn-outline-primary" type="button" id="reset_tahun_akademik"><i class="fas fa-times"></i></button>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-xl-3 col-md-6 mb-4">
                <!-- Dashboard info widget 1-->
                <div class="card border-start-lg border-start-primary h-100">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="flex-grow-1">
                                <div class="small fw-bold text-primary mb-1">Wakaf & Infaq (Belum Lunas)</div>
                                <div class="h5" id="wakaf_infaq_belum_lunas">0</div>
                            </div>
                            <div class="ms-2"><i class="fas fa-dollar-sign fa-2x text-gray-200"></i></div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-md-6 mb-4">
                <!-- Dashboard info widget 1-->
                <div class="card border-start-lg border-start-primary h-100">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="flex-grow-1">
                                <div class="small fw-bold text-primary mb-1">Wakaf & Infaq (Lunas)</div>
                                <div class="h5" id="wakaf_infaq_lunas">0</div>
                            </div>
                            <div class="ms-2"><i class="fas fa-dollar-sign fa-2x text-gray-200"></i></div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-md-6 mb-4">
                <!-- Dashboard info widget 1-->
                <div class="card border-start-lg border-start-primary h-100">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="flex-grow-1">
                                <div class="small fw-bold text-primary mb-1">SPP (Belum Lunas)</div>
                                <div class="h5" id="spp_belum_lunas">0</div>
                            </div>
                            <div class="ms-2"><i class="fas fa-dollar-sign fa-2x text-gray-200"></i></div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-md-6 mb-4">
                <!-- Dashboard info widget 1-->
                <div class="card border-start-lg border-start-primary h-100">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="flex-grow-1">
                                <div class="small fw-bold text-primary mb-1">SPP (Lunas)</div>
                                <div class="h5" id="spp_lunas">0</div>
                            </div>
                            <div class="ms-2"><i class="fas fa-dollar-sign fa-2x text-gray-200"></i></div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xxl-4 col-xl-12 mb-4">
                <div class="card card-header-actions h-100">
                    <div class="card-header">
                        Grafik Status Pembayaran
                        <div class="float-end">
                            <a href="{{route('web.su.keuangan.pembayaran.list')}}"
                                class="btn btn-sm btn-outline-primary">Detail</a>
                        </div>
                    </div>
                    <div class="card-body">
                        <canvas id="myChart" height="350"></canvas>
                    </div>
                </div>
            </div>

            <div class="col-xxl-4 col-xl-12 mb-4">
                <div class="card card-header-actions h-100">
                    <div class="card-header">
                        Summary Wakaf dan Infaq
                        <div class="float-end">
                            <a href="{{route('web.su.keuangan.pembayaran.list')}}"
                                class="btn btn-sm btn-outline-primary">Detail</a>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered" id="dtWakafInfaqSummary" width="100%" cellspacing="0">
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xxl-4 col-xl-12 mb-4">
                <div class="card card-header-actions h-100">
                    <div class="card-header">
                        Summary SPP, Program, dan Pendaftaran
                        <div class="float-end">
                            <a href="{{route('web.su.keuangan.pembayaran.list')}}"
                                class="btn btn-sm btn-outline-primary">Detail</a>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered" id="dtSppSummary" width="100%" cellspacing="0">
                            </table>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</main>
@stop

@section('style_extra')
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.min.css" rel="stylesheet" />
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@ttskch/select2-bootstrap4-theme@x.x.x/dist/select2-bootstrap4.min.css">
@endsection

@section('js_extra')

<script src="https://cdn.jsdelivr.net/npm/chart.js@3.8.0/dist/chart.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.full.js"></script>

<script type="text/javascript">
    tahunAkademikSelected = null;
    let myChart;

    getAllNews(function (output) {
        html_results = '';
        $.each(output, function (i, row) {
            html_results += '<div class="timeline-item">' +
                '<div class="timeline-item-marker">' +
                '<div class="timeline-item-marker-indicator bg-green"></div>' +
                '</div>' +
                '<div class="timeline-item-content">' +
                row.title + ' | ' + row.content + '<br> ' +
                row.updated_at + ' <hr> ' +
                '</div>' +
                '</div>';
        });
        $('#timeline_news').html(html_results);
    });

    getTahunAkademikOptions(function(output) {
        // BARU
        $('#tahun_akademik_filter').html(output);
        $('#tahun_akademik_id').html(output);

        if (tahunAkademikSelected != null) {
            $('#tahun_akademik_id').val(tahunAkademikSelected);
        }
    });

    $("#tahun_akademik_filter").select2({
        theme: 'bootstrap4',
        placeholder: 'Pilih Tahun Akademik',
    });

    $("#tahun_akademik_filter").on("change", function(e) {
        tahunAkademikSelected = $("#tahun_akademik_filter").val();
        getPaymentChart(tahunAkademikSelected);
        dtSppSummary.ajax.reload(null, false);
        dtWakafInfaqSummary.ajax.reload();
        // table.ajax.reload();
    });

    $("#reset_tahun_akademik").on("click", function(e) {
        $('#tahun_akademik_filter').val(null).trigger('change');
        // table.ajax.reload();
    });

    function getPaymentChart(id = -1) {
        var data = {
            id
        }
        console.log('id = ' + id)
        $.ajax({
            url: "{{route('ajax.dashboard.get_payment_chart')}}",
            type: "GET",
            data: data,
            dataType: "json",
            success: function (output) {
                if (myChart) {
                    myChart.destroy();
                }
                let dataTotal = [];
                let labels = []
                $.each(output.data, function (i, row) {
                    dataTotal.push(row.total);
                    labels.push(row.status);
                });

                const ctx = document.getElementById('myChart').getContext('2d');
                myChart = new Chart(ctx, {
                    type: 'pie',
                    data: {
                        labels: labels,
                        datasets: [{
                            label: '# of Votes',
                            data: dataTotal,
                            backgroundColor: [
                                '#c1f18c',
                                '#F18C8E',
                                '#6B7AA1'
                            ],
                            borderWidth: 1
                        }]
                    },
                    options: {
                        maintainAspectRatio: false
                    }
                });
            }
        });
    }

    getPaymentChart();

    let dtWakafInfaqSummary = null;
    let dtSppSummary = null;

    dtWakafInfaqSummary = $('#dtWakafInfaqSummary').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: "{{route('ajax.dashboard.get_wakaf_infaq_summary_dt')}}",
            dataType: "json",
            "data": function (d) {
                d._token = "{{ csrf_token() }}"
            },
            type: "POST",
        },
        bSort: true,
        searching: false,
        lengthChange: true,
        scrollX: true,
        columns: [
            {
                "title": "Layanan",
                "width": "12%",
                "data": "kode",
                render: function (data, type, row) {
                    if (data) {
                        if(row.type == 0){
                            return "ABC - "+data;
                        }else{
                            return "PAUD - "+data;
                        }
                    } else {
                        return "-";
                    }
                }
            },
            {
                "title": "Lunas",
                "width": "12%",
                "data": "lunas",
                render: function (data, type, row) {
                    if (data) {
                        return formatRibuan(data);
                    } else {
                        return "-";
                    }
                }
            },
            {
                "title": "Belum Lunas",
                "width": "12%",
                "data": "belum_lunas",
                render: function (data, type, row) {
                    if (data) {
                        return formatRibuan(data);
                    } else {
                        return "-";
                    }
                }
            },
        ],
        order: [[0, 'asc']],
        columnDefs: [],
        drawCallback: function( settings ) {
            // console.log('drawCallback');
        },
        footerCallback: function (row, data, start, end, display) {      
            // console.log('footerCallback', data);
            let totalLunas = 0;
            let totalBelumLunas = 0;
            for (var i = 0; i < data.length; i++) {
                totalLunas += parseFloat(data[i]['lunas']);
                totalBelumLunas += parseFloat(data[i]['belum_lunas']);
            }

            $("#wakaf_infaq_lunas").text(formatRibuan(totalLunas));
            $("#wakaf_infaq_belum_lunas").text(formatRibuan(totalBelumLunas));
            // console.log(totalLunas, totalBelumLunas);
        }
    });


    dtSppSummary = $('#dtSppSummary').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: "{{route('ajax.dashboard.get_spp_summary_dt')}}",
            dataType: "json",
            "data": function (d) {
                d._token = "{{ csrf_token() }}"
                d.id = tahunAkademikSelected
            },
            type: "POST",
        },
        bSort: true,
        searching: false,
        lengthChange: true,
        scrollX: true,
        columns: [
            {
                "title": "Layanan",
                "width": "12%",
                "data": "kode",
                render: function (data, type, row) {
                    if (data) {
                        if(row.type == 0){
                            return "ABC - "+data;
                        }else{
                            return "PAUD - "+data;
                        }
                    } else {
                        return "-";
                    }
                }
            },
            {
                "title": "Lunas",
                "width": "12%",
                "data": "lunas",
                render: function (data, type, row) {
                    if (data) {
                        return formatRibuan(data);
                    } else {
                        return "-";
                    }
                }
            },
            {
                "title": "Belum Lunas",
                "width": "12%",
                "data": "belum_lunas",
                render: function (data, type, row) {
                    if (data) {
                        return formatRibuan(data);
                    } else {
                        return "-";
                    }
                }
            },
        ],
        order: [[0, 'asc']],
        columnDefs: [],
        drawCallback: function( settings ) {
            // console.log('drawCallback');
        },
        footerCallback: function (row, data, start, end, display) {      
            // console.log('footerCallback', data);
            let totalLunas = 0;
            let totalBelumLunas = 0;
            for (var i = 0; i < data.length; i++) {
                totalLunas += parseFloat(data[i]['lunas']);
                totalBelumLunas += parseFloat(data[i]['belum_lunas']);
            }
            $("#spp_lunas").text(formatRibuan(totalLunas));
            $("#spp_belum_lunas").text(formatRibuan(totalBelumLunas));
            // console.log(totalLunas, totalBelumLunas);
        }
    });

</script>
@endsection