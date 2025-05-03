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
                            Konfirmasi Pembayaran
                        </h1>
                    </div>
                    <div class="col-12 col-xl-auto mb-3">
                        <a class="btn btn-sm btn-light text-primary" href="{{route('web.dashboard.keuangan.daftar_abc.add')}}">
                            <i class="me-1" data-feather="plus"></i>
                            Add
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
                            <th>NIS</th>
                            <th>Nama</th>
                            <th>Tgl</th>
                            <th>Jumlah</th>
                            <th>Bank Tujuan</th>
                            <th>Jenis Pembayaran</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th>NIS</th>
                            <th>Nama</th>
                            <th>Tgl</th>
                            <th>Jumlah</th>
                            <th>Bank Tujuan</th>
                            <th>Jenis Pembayaran</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </tfoot>
                    <tbody>
                        <tr>
                            <td>0000</td>
                            <td>Muhammad Aufa Al Baihaqi</td>
                            <td>2021-07-01</td>
                            <td>Rp 550,000</td>
                            <td>Bank Syariah Mandiri (BSM)</td>
                            <td>SPP</td>
                            <td>
                                <span class="badge bg-green-soft text-green">Approved</span>
                            </td>
                            <td>
                                <a class="btn btn-datatable btn-icon btn-transparent-dark me-2" href="#"><i data-feather="edit"></i></a>
                                <a class="btn btn-datatable btn-icon btn-transparent-dark" href="#!"><i data-feather="trash-2"></i></a>
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
