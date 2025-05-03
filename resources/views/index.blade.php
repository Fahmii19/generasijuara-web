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
                                            Selamat Datang @if(Auth::check()) ,{{Auth::user()->name}} <a class="btn btn-sm btn-secondary" href="#" onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">logout</a> @endif
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
                        <h4 class="mb-0 mt-5">Apps</h4>
                        <hr class="mt-2 mb-4" />
                        <div class="row">
                            <div class="col-lg-4 mb-4">
                                <!-- Knowledge base category card 1-->
                                <a class="card lift lift-sm h-100" href="{{route('web.ppdb.home')}}">
                                    <div class="card-body">
                                        <h5 class="card-title text-primary mb-2">
                                            <i class="me-2" data-feather="edit-2"></i>
                                            PPDB
                                        </h5>
                                        <p class="card-text mb-1">Pendaftaran Peserta Didik Baru</p>
                                    </div>
                                </a>
                            </div>
                            <div class="col-lg-4 mb-4">
                                <!-- Knowledge base category card 1-->
                                <a class="card lift lift-sm h-100" href="{{route('web.siab.home')}}">
                                    <div class="card-body">
                                        <h5 class="card-title text-primary mb-2">
                                            <i class="me-2" data-feather="edit-2"></i>
                                            SIAB
                                        </h5>
                                        <p class="card-text mb-1">Sistem Akademik Warga Belajar</p>
                                    </div>
                                    <!-- <div class="card-footer"><div class="small text-muted">3 articles in this category</div></div> -->
                                </a>
                            </div>
                            <div class="col-lg-4 mb-4">
                                <!-- Knowledge base category card 2-->
                                <a class="card lift lift-sm h-100" href="{{route('web.situ.home')}}">
                                    <div class="card-body">
                                        <h5 class="card-title text-yellow mb-2">
                                            <i class="me-2" data-feather="credit-card"></i>
                                            SITU
                                        </h5>
                                        <p class="card-text mb-1">Sistem Pelaporan Online Tutor</p>
                                    </div>
                                    <!-- <div class="card-footer"><div class="small text-muted">2 articles in this category</div></div> -->
                                </a>
                            </div>
                            <!-- <div class="col-lg-4 mb-4">
                                <a class="card lift lift-sm h-100" href="knowledge-base-category.html">
                                    <div class="card-body">
                                        <h5 class="card-title text-teal mb-2">
                                            <i class="me-2" data-feather="code"></i>
                                            API
                                        </h5>
                                        <p class="card-text mb-1">Documentation and integration instructions for our API</p>
                                    </div>
                                    <div class="card-footer"><div class="small text-muted">15 articles in this category</div></div>
                                </a>
                            </div> -->
                            <!-- <div class="col-lg-4 mb-4">
                                <a class="card lift lift-sm h-100" href="knowledge-base-category.html">
                                    <div class="card-body">
                                        <h5 class="card-title text-orange mb-2">
                                            <i class="me-2" data-feather="layers"></i>
                                            Integration
                                        </h5>
                                        <p class="card-text mb-1">App integration policies and related content on connecting to our database</p>
                                    </div>
                                    <div class="card-footer"><div class="small text-muted">5 articles in this category</div></div>
                                </a>
                            </div> -->
                            <div class="col-lg-4 mb-4">
                                <a class="card lift lift-sm h-100" href="{{route('web.sireka.home')}}">
                                    <div class="card-body">
                                        <h5 class="card-title text-secondary mb-2">
                                            <i class="me-2" data-feather="lock"></i>
                                            SIREKA
                                        </h5>
                                        <p class="card-text mb-1">Sistem Informasi Registrasi Keuangan</p>
                                    </div>
                                    <!-- <div class="card-footer"><div class="small text-muted">2 articles in this category</div></div> -->
                                </a>
                            </div>
                            <div class="col-lg-4 mb-4">
                                <a class="card lift lift-sm h-100" href="{{route('web.sirego.home')}}">
                                    <div class="card-body">
                                        <h5 class="card-title text-secondary mb-2">
                                            <i class="me-2" data-feather="lock"></i>
                                            SIREGO
                                        </h5>
                                        <p class="card-text mb-1">Sistem Informasi Registrasi Operator</p>
                                    </div>
                                    <!-- <div class="card-footer"><div class="small text-muted">2 articles in this category</div></div> -->
                                </a>
                            </div>
                            <div class="col-lg-4 mb-4">
                                <a class="card lift lift-sm h-100" href="{{route('web.sialum.alumni.add')}}">
                                    <div class="card-body">
                                        <h5 class="card-title text-primary mb-2">
                                            <i class="me-2" data-feather="user"></i>
                                            SIALUM
                                        </h5>
                                        <p class="card-text mb-1">Sistem Informasi Alumni</p>
                                    </div>
                                    <!-- <div class="card-footer"><div class="small text-muted">2 articles in this category</div></div> -->
                                </a>
                            </div>
                            <div class="col-lg-4 mb-4">
                                <a class="card lift lift-sm h-100" href="{{route('web.su.home')}}">
                                    <div class="card-body">
                                        <h5 class="card-title text-secondary mb-2">
                                            <i class="me-2" data-feather="lock"></i>
                                            SU
                                        </h5>
                                        <p class="card-text mb-1">Super User</p>
                                    </div>
                                    <!-- <div class="card-footer"><div class="small text-muted">2 articles in this category</div></div> -->
                                </a>
                            </div>
                            
                            <!-- <div class="col-lg-4 mb-4">
                                <a class="card lift lift-sm h-100" href="knowledge-base-category.html">
                                    <div class="card-body">
                                        <h5 class="card-title text-red mb-2">
                                            <i class="me-2" data-feather="map"></i>
                                            Miscellaneous
                                        </h5>
                                        <p class="card-text mb-1">Other troubleshooting, help, and support articles related to our products and services</p>
                                    </div>
                                    <div class="card-footer"><div class="small text-muted">2 articles in this category</div></div>
                                </a>
                            </div> -->
                        </div>
                    </div>
                </main>
                <footer class="footer-admin mt-auto footer-light">
                    <div class="container-xl px-4">
                        <div class="row">
                            <div class="col-md-6 small">Copyright &copy; Generasi Juara 2021 <a href="tel:+0818528677">08110239</a></div>
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
