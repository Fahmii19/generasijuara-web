@extends('layouts.admin_layout')

@section('content')
<main>
    <header class="page-header page-header-compact page-header-light border-bottom bg-white mb-4">
        <div class="container-fluid px-4">
            <div class="page-header-content">
                <div class="row align-items-center justify-content-between pt-3">
                    <div class="col-auto mb-3">
                        <h1 class="page-header-title">
                            <div class="page-header-icon"><a href="{{route('web.dashboard.keuangan.daftar_abc.list')}}"><i data-feather="arrow-left"></i></a></div>
                            Add Konfirmasi Pembayaran
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
                <form>
                    <div class="row gx-3">
                        <div class="mb-3 col-md-6">
                            <label class="small mb-1" for="inputFirstName">Tgl Bayar</label>
                            <input class="form-control" id="inputFirstName" type="text" placeholder="" value="" />
                        </div>
                        <div class="mb-3 col-md-6">
                            <label class="small mb-1" for="inputLastName">Jumlah Transfer</label>
                            <input class="form-control" id="inputLastName" type="text" placeholder="" value="" />
                        </div>
                    </div>
                    <div class="row gx-3">
                        <div class="mb-3 col-md-4">
                            <label for="exampleFormControlSelect1">Bank Tujuan</label>
                            <select class="form-control" id="exampleFormControlSelect1">
                                <option>Bank Syariah Mandiri (BSM)</option>
                                <option>BNI Syariah</option>
                            </select>
                        </div>
                        <div class="mb-3 col-md-4">
                            <label for="exampleFormControlSelect1">Metode Pembayaran</label>
                            <select class="form-control" id="exampleFormControlSelect1">
                                <option>Internet Banking</option>
                                <option>SMS Banking</option>
                                <option>Transfer ATM</option>
                                <option>Setoran Tunai</option>
                            </select>
                        </div>
                        <div class="mb-3 col-md-4">
                            <label for="exampleFormControlSelect1">Jenis Pembayaran</label>
                            <select class="form-control" id="exampleFormControlSelect1">
                                <option>Pendaftaran</option>
                                <option>SPP</option>
                            </select>
                        </div>
                    </div>
                    <div class="row gx-3">
                        <div class="mb-3 col-md-6">
                            <label class="small mb-1" for="inputFirstName">Nama Pengirim</label>
                            <input class="form-control" id="inputFirstName" type="text" placeholder="" value="" />
                        </div>
                        <div class="mb-3 col-md-6">
                            <label class="small mb-1" for="inputLastName">Bukti Transfer</label>
                            <input class="form-control" id="inputLastName" type="file" placeholder="" value="" />
                        </div>
                    </div>
                    <div class="row gx-3">
                        <div class="mb-3 col-md-12">
                            <label class="small mb-1" for="inputFirstName">Pesan</label>
                            <textarea class="form-control" id="inputFirstName"></textarea>
                        </div>
                    </div>
                    <hr class="my-4" />
                    <div class="d-flex justify-content-between">
                        <button class="btn btn-light disabled" type="button" disabled>Cancel</button>
                        <button class="btn btn-primary" type="button">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</main>
@stop

@section('style_extra')

@endsection

@section('js_extra')

@endsection
