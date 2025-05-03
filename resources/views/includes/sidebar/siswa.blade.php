<nav class="sidenav shadow-right sidenav-light">
    <div class="sidenav-menu">
        <div class="nav accordion" id="accordionSidenav">
            <!-- Sidenav Menu Heading (Account)-->
            <!-- * * Note: * * Visible only on and above the sm breakpoint-->
            <div class="sidenav-menu-heading d-sm-none">Account</div>
            <!-- Sidenav Link (Alerts)-->
            <!-- * * Note: * * Visible only on and above the sm breakpoint-->
            <a class="nav-link d-sm-none" href="#!">
                <div class="nav-link-icon"><i data-feather="bell"></i></div>
                Alerts
                <span class="badge bg-warning-soft text-warning ms-auto">4 New!</span>
            </a>
            <!-- Sidenav Link (Messages)-->
            <!-- * * Note: * * Visible only on and above the sm breakpoint-->
            <a class="nav-link d-sm-none" href="#!">
                <div class="nav-link-icon"><i data-feather="mail"></i></div>
                Messages
                <span class="badge bg-success-soft text-success ms-auto">2 New!</span>
            </a>
            <!-- Sidenav Menu Heading (Core)-->
            <div class="sidenav-menu-heading">Core</div>
            <!-- Sidenav Accordion (Dashboard)-->
            <a class="nav-link" href="{{route('web.dashboard.index')}}">
                <div class="nav-link-icon"><i data-feather="activity"></i></div>
                Dashboard <span class="badge bg-warning-soft text-warning ms-auto">Coming Soon</span>
            </a>
            <!-- Sidenav Heading (Custom)-->
            <div class="sidenav-menu-heading">Main</div>
            <!-- Sidenav Accordion (Pages)-->
            
            <a class="nav-link collapsed" href="javascript:void(0);" data-bs-toggle="collapse" data-bs-target="#collapseAkademik" aria-expanded="false" aria-controls="collapseAkademik">
                <div class="nav-link-icon"><i data-feather="globe"></i></div>
                Akademik
                <div class="sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
            </a>
            <div class="collapse" id="collapseAkademik" data-bs-parent="#accordionSidenav">
                <nav class="sidenav-menu-nested nav accordion" id="accordionSidenavAkademikMenu">
                    <a class="nav-link" href="{{route('web.dashboard.jadwal_pelajaran.list')}}">Jadwal Pelajaran</a>
                    <a class="nav-link" href="{{route('web.dashboard.siswa.nilai.list')}}">Nilai</a>
                    <a class="nav-link" href="{{route('web.dashboard.siswa.raport.list')}}">Raport</a>
                </nav>
            </div>

            <a class="nav-link" href="{{route('web.dashboard.siswa.profile')}}">
                <div class="nav-link-icon"><i data-feather="user"></i></div>
                Profile
            </a>
            <a class="nav-link" href="#">
                <div class="nav-link-icon"><i data-feather="bar-chart"></i></div>
                Keuangan <span class="badge bg-warning-soft text-warning ms-auto">Coming Soon</span>
            </a>
            <a class="nav-link" href="#">
                <div class="nav-link-icon"><i data-feather="grid"></i></div>
                Berita <span class="badge bg-warning-soft text-warning ms-auto">Coming Soon</span>
            </a>
        </div>
    </div>
    <!-- Sidenav Footer-->
    <div class="sidenav-footer">
        <div class="sidenav-footer-content">
            <div class="sidenav-footer-subtitle">Logged in as:</div>
            <div class="sidenav-footer-title">Pasha TW</div>
        </div>
    </div>
</nav>