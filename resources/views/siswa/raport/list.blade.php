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
                    <div class="col-12 col-xl-auto mb-3">
                        <a class="btn btn-sm btn-light text-primary" href="#">
                            <i class="me-1" data-feather="file"></i>
                            PDF
                        </a>
                        <a class="btn btn-sm btn-light text-primary" href="#">
                            <i class="me-1" data-feather="file"></i>
                            Excel/CSV
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
                <table id="datatablesSimple">
                    <thead>
                        <tr>
                            <th>Kelas</th>
                            <th>Semester</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th>Kelas</th>
                            <th>Semester</th>
                            <th>Actions</th>
                        </tr>
                    </tfoot>
                    <tbody>
                        <tr>
                            <td>1</td>
                            <td>1</td>
                            <td>
                                <a target="_blank" class="btn btn-datatable btn-icon btn-transparent-dark me-2" href="{{route('web.dashboard.raport.print')}}"><i data-feather="file"></i></a>
                            </td>
                        </tr>
                        <tr>
                            <td>1</td>
                            <td>2</td>
                            <td>
                                <a target="_blank" class="btn btn-datatable btn-icon btn-transparent-dark me-2" href="{{route('web.dashboard.raport.print')}}"><i data-feather="file"></i></a>
                            </td>
                        </tr>
                        <tr>
                            <td>2</td>
                            <td>1</td>
                            <td>
                                <a target="_blank" class="btn btn-datatable btn-icon btn-transparent-dark me-2" href="{{route('web.dashboard.raport.print')}}"><i data-feather="file"></i></a>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</main>
@stop

@section('style_extra')

@endsection

@section('js_extra')

@endsection
