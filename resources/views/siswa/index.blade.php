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
                                    <p class="text-gray-700 mb-0">Apabila mengalami kendala harap hubungi admin kami. Terima kasih.</p>
                                </div>
                            </div>
                            <div class="col-xl-4 col-xxl-12 text-center"><img class="img-fluid" src="{{asset('assets/admin/dist')}}/assets/img/illustrations/at-work.svg" style="max-width: 26rem" /></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xxl-4 col-xl-6 mb-4">
                <div class="card card-header-actions h-100">
                    <div class="card-header">
                        Kartu Pelajar
                    </div>
                    <div class="card-body">
                        <img class="img-fluid" src="{{ $kartu_pelajar }}">
                    </div>
                </div>
            </div>
            <div class="col-xxl-4 col-xl-6 mb-4">
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
    </div>
</main>
@stop

@section('style_extra')

@endsection

@section('js_extra')

<script type="text/javascript">
    getAllNews(function(output) {
        html_results = '';
        $.each(output, function (i, row) {
            html_results += '<div class="timeline-item">'+
                                '<div class="timeline-item-marker">'+
                                    '<div class="timeline-item-marker-indicator bg-green"></div>'+
                                '</div>'+
                                '<div class="timeline-item-content">'+
                                    row.title + ' | ' + row.content+ '<br> '+
                                    row.updated_at +' <hr> '+
                                '</div>'+
                            '</div>';
        });
        $('#timeline_news').html(html_results);
    });
</script>
@endsection
