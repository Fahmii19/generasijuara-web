<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Welcome</title>
        <link href="{{asset('assets/admin/dist/css/styles.css')}}" rel="stylesheet" />
        <link rel="icon" type="image/x-icon" href="{{asset('assets/images/logo_web.png')}}" />
        <script data-search-pseudo-elements defer src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/js/all.min.js" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/feather-icons/4.28.0/feather.min.js" crossorigin="anonymous"></script>
    </head>
    <body class="">
        <div id="layoutSidenav">
            <div id="layoutSidenav_content" style="margin-left: 0rem;">
                <main>
                    <header class="page-header page-header-dark bg-gradient-primary-to-secondary mb-4">
                        <div class="container-xl px-4">
                            <div class="page-header-content pt-4">
                                <div class="row align-items-center justify-content-between">
                                    <div class="col-auto mt-4">
                                        <h1 class="page-header-title">
                                            <div class="page-header-icon"><i data-feather="life-buoy"></i></div>
                                            Selamat Datang
                                        </h1>
                                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                            @csrf
                                        </form>
                                        <div class="page-header-subtitle"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </header>
                    <!-- Main page content-->
                    <div class="container-xl px-4">
                        <h4 class="mb-0 mt-5">Pilih Opsi</h4>
                        <hr class="mt-2 mb-4" />
                        <div class="row">
                            <div class="col-lg-4 mb-4">
                                <!-- Knowledge base category card 1-->
                                <a class="card lift lift-sm h-100" href="{{route('web.ppdb.abc')}}">
                                    <div class="card-body">
                                        <h5 class="card-title text-primary mb-2">
                                            <i class="me-2" data-feather="edit-2"></i>
                                            Peserta ABC
                                        </h5>
                                    </div>
                                </a>
                            </div>
                            <div class="col-lg-4 mb-4">
                                <a class="card lift lift-sm h-100" href="{{route('web.ppdb.paud')}}">
                                    <div class="card-body">
                                        <h5 class="card-title text-primary mb-2">
                                            <i class="me-2" data-feather="edit-2"></i>
                                            Peserta PAUD
                                        </h5>
                                    </div>
                                </a>
                            </div>
                        </div>
                    </div>
                </main>
                <footer class="footer-admin mt-auto footer-light">
                    <div class="container-xl px-4">
                        <div class="row">
                            <div class="col-md-6 small">Copyright &copy; Generasi Juara 2021</div>
                            <!-- <div class="col-md-6 text-md-end small">
                                <a href="#!">Privacy Policy</a>
                                &middot;
                                <a href="#!">Terms &amp; Conditions</a>
                            </div> -->
                        </div>
                    </div>
                </footer>
            </div>
        </div>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
        <script src="{{asset('assets/admin/dist/js/scripts.js')}}"></script>
    </body>
</html>
