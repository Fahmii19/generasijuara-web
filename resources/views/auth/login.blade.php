<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Login</title>
        <link href="{{asset('assets/admin/dist/css/styles.css')}}" rel="stylesheet" />
        <link rel="icon" type="image/x-icon" href="{{asset('assets/images/logo_web.png')}}" />
        <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11.4.17/dist/sweetalert2.min.css" rel="stylesheet">
        <script data-search-pseudo-elements defer src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/js/all.min.js" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/feather-icons/4.28.0/feather.min.js" crossorigin="anonymous"></script>
    </head>
    <body class="bg-primary">
        <div id="layoutAuthentication">
            <div id="layoutAuthentication_content">
                <main>
                    <div class="container-xl px-4">
                        <div class="row justify-content-center">
                            <div class="col-lg-5">
                                <!-- Basic login form-->
                                <div class="card shadow-lg border-0 rounded-lg mt-5">
                                    <div class="card-header justify-content-center"><h3 class="fw-light my-4">Login</h3></div>
                                    <div class="card-body">
                                        <!-- Login form-->
                                        <form method="POST" action="{{ route('login') }}">
                                            @csrf
                                            <!-- Form Group (email address)-->
                                            <div class="mb-3">
                                                <label class="small mb-1" for="username">Username</label>
                                                <input name="username" class="form-control @error('username') is-invalid @enderror" id="username" type="username" value="{{ old('username') }}" placeholder="Enter username" />
                                            </div>
                                            <!-- Form Group (password)-->
                                            <div class="mb-3">
                                                <label class="small mb-1" for="password">Password</label>
                                                <input name="password" class="form-control @error('password') is-invalid @enderror" id="password" type="password" value="{{ old('email') }}" placeholder="Enter password" />
                                            </div>
                                            <!-- Form Group (apps)-->
                                            <div class="mb-3">
                                                <input hidden="hidden" name="apps" class="form-control" id="apps" value="{{ app('request')->input('apps') }}" />
                                            </div>
                                            <!-- Form Group (remember password checkbox)-->
                                            <div class="mb-3">
                                                <div class="form-check">
                                                    <input class="form-check-input" id="rememberPasswordCheck" type="checkbox" value="" />
                                                    <label class="form-check-label" for="rememberPasswordCheck">Remember password</label>
                                                </div>
                                            </div>
                                            <!-- Form Group (login box)-->
                                            <div class="d-flex align-items-center justify-content-between mt-4 mb-0">
                                                @if (app('request')->input('apps') == 'siab')
                                                <a class="small" href="{{route('password.forgot-siab')}}">Forgot Password?</a>
                                                @else
                                                <a class="small" href="{{route('password.forgot', ['apps' => app('request')->input('apps')])}}">Forgot Password?</a>    
                                                @endif

                                                <button class="btn btn-primary" type="submit" href="#">Login</button>
                                            </div>
                                        </form>
                                    </div>
                                    <div class="card-footer text-center">
                                        <div class="small"><a href="{{route('web.index')}}">Change Apps</a></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </main>
            </div>
            <div id="layoutAuthentication_footer">
                <footer class="footer-admin mt-auto footer-dark">
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
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.4.17/dist/sweetalert2.min.js"></script>

        @if (session('status'))
        <script>
            Swal.fire({
                icon: "{{session('status.type')}}",
                title: "{{ucwords(session('status.type'))}}",
                text: "{{session('status.message')}}",
            });
        </script>
        @endif
    </body>
</html>
