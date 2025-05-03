<nav class="sidenav shadow-right sidenav-light">
    <div class="sidenav-menu">
        <div class="nav accordion" id="accordionSidenav">
            <!-- Sidenav Menu Heading (Account)-->
            <!-- * * Note: * * Visible only on and above the sm breakpoint-->
            <div class="sidenav-menu-heading d-sm-none">Account</div>
            <!-- Sidenav Link (Alerts)-->
            <!-- * * Note: * * Visible only on and above the sm breakpoint-->
            <!-- <a class="nav-link d-sm-none" href="#!">
                <div class="nav-link-icon"><i data-feather="bell"></i></div>
                Alerts
                <span class="badge bg-warning-soft text-warning ms-auto">4 New!</span>
            </a> -->
            <!-- Sidenav Link (Messages)-->
            <!-- * * Note: * * Visible only on and above the sm breakpoint-->
            <!-- <a class="nav-link d-sm-none" href="#!">
                <div class="nav-link-icon"><i data-feather="mail"></i></div>
                Messages
                <span class="badge bg-success-soft text-success ms-auto">2 New!</span>
            </a> -->
            <!-- Sidenav Menu Heading (Core)-->
            <div class="sidenav-menu-heading">Core</div>
            <!-- Sidenav Accordion (Dashboard)-->
            <a class="nav-link" href="{{route('web.su.home')}}">
                <div class="nav-link-icon"><i data-feather="activity"></i></div>
                Dashboard 
                <!-- <span class="badge bg-warning-soft text-warning ms-auto">Coming Soon</span> -->
            </a>
            <!-- Sidenav Heading (Custom)-->
            <div class="sidenav-menu-heading">Main</div>
            <a class="nav-link collapsed" href="javascript:void(0);" data-bs-toggle="collapse" data-bs-target="#collapsePPDB" aria-expanded="false" aria-controls="collapsePPDB">
                <div class="nav-link-icon"><i data-feather="user"></i></div>
                PPDB
                <div class="sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
            </a>
            <div class="collapse" id="collapsePPDB" data-bs-parent="#accordionSidenav">
                <nav class="sidenav-menu-nested nav accordion" id="accordionSidenavAkademikMenu">
                    <a class="nav-link collapsed" href="javascript:void(0);" data-bs-toggle="collapse" data-bs-target="#pagesCollapsePendaftaranPPDB" aria-expanded="false" aria-controls="pagesCollapsePendaftaranPPDB">
                        Pendaftaran PPDB
                        <div class="sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                    </a>
                    <div class="collapse" id="pagesCollapsePendaftaranPPDB" data-bs-parent="#accordionSidenavPagesMenu">
                        <nav class="sidenav-menu-nested nav">
                            <a class="nav-link" href="{{route('web.su.ppdb.abc.list')}}">Paket ABC</a>
                            <a class="nav-link" href="{{route('web.su.ppdb.paud.list')}}">PAUD</a>
                        </nav>
                    </div>
                    <a class="nav-link collapsed" href="javascript:void(0);" data-bs-toggle="collapse" data-bs-target="#pagesCollapsePendaftaranUlang" aria-expanded="false" aria-controls="pagesCollapsePendaftaranUlang">
                        Pendaftaran Ulang
                        <div class="sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                    </a>
                    <div class="collapse" id="pagesCollapsePendaftaranUlang" data-bs-parent="#accordionSidenavPagesMenu">
                        <nav class="sidenav-menu-nested nav">
                            <a class="nav-link" href="{{route('web.su.ppdb_ulang.abc.list')}}">Paket ABC</a>
                            <a class="nav-link" href="{{route('web.su.ppdb_ulang.paud.list')}}">PAUD</a>
                        </nav>
                    </div>
                    <!-- <a class="nav-link" href="{{route('web.su.keuangan.daftar_abc.list')}}">Form Pembayaran</a>
                    <a class="nav-link" href="{{route('web.su.keuangan.slip_gaji.list')}}">Slip Gaji</a> -->
                </nav>
            </div>
            <a class="nav-link" href="{{route('web.su.alumni.list')}}">
                <div class="nav-link-icon"><i data-feather="user"></i></div> Alumni 
                <!-- <span class="badge bg-warning-soft text-warning ms-auto">Coming Soon</span> -->
            </a>
        </div>
    </div>
    <!-- Sidenav Footer-->
    <div class="sidenav-footer">
        <div class="sidenav-footer-content">
            <div class="sidenav-footer-subtitle">Logged in as:</div>
            <div class="sidenav-footer-title">@if(Auth::check()) {{Auth::user()->name}} @endif</div>
        </div>
    </div>
</nav>