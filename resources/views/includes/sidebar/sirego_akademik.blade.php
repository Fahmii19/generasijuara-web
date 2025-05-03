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
            <a class="nav-link" href="{{route('web.sirego.home')}}">
                <div class="nav-link-icon"><i data-feather="activity"></i></div>
                Dashboard 
                <!-- <span class="badge bg-warning-soft text-warning ms-auto">Coming Soon</span> -->
            </a>
            <!-- Sidenav Heading (Custom)-->
            <div class="sidenav-menu-heading">Main</div>
            <!-- Sidenav Accordion (Pages)-->
            {{-- <a class="nav-link collapsed" href="javascript:void(0);" data-bs-toggle="collapse" data-bs-target="#collapseMaster" aria-expanded="false" aria-controls="collapseMaster">
                <div class="nav-link-icon"><i data-feather="grid"></i></div>
                Master
                <div class="sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
            </a>
            <div class="collapse" id="collapseMaster" data-bs-parent="#accordionSidenav">
                <nav class="sidenav-menu-nested nav accordion" id="accordionSidenavMasterMenu">
                    <a class="nav-link" href="{{route('web.sirego.user.list')}}">User</a>
                </nav>
            </div> --}}
            <a class="nav-link collapsed" href="javascript:void(0);" data-bs-toggle="collapse" data-bs-target="#collapseAkademik" aria-expanded="false" aria-controls="collapseAkademik">
                <div class="nav-link-icon"><i data-feather="globe"></i></div>
                Akademik
                <div class="sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
            </a>
            <div class="collapse" id="collapseAkademik" data-bs-parent="#accordionSidenav">
                <nav class="sidenav-menu-nested nav accordion" id="accordionSidenavAkademikMenu">
                    <a class="nav-link" href="{{route('web.su.distribusi_mapel.list')}}">Distribusi Mapel</a>
                    <a class="nav-link" href="{{route('web.su.jadwal_pelajaran.list')}}">Jadwal Pelajaran</a>
                    <!-- <a class="nav-link" href="{{route('web.su.kalender_akademik.list')}}">Kalender Akademik</a> -->
                    <a class="nav-link" href="{{route('web.su.mata_pelajaran.list')}}">Mata Pelajaran</a>
                    <a class="nav-link" href="{{route('web.su.kelas.list')}}">Kelas</a>
                    <a class="nav-link" href="{{route('web.su.nilai.list')}}">Nilai</a>
                    <a class="nav-link" href="{{route('web.su.raport.list')}}">Raport</a>
                    <a class="nav-link" href="{{route('web.su.leger.list')}}">Leger Nilai</a>
                    <a class="nav-link" href="{{route('web.su.kuisioner.list')}}">Kuisioner</a>
                    <a class="nav-link" href="{{route('web.su.kuisioner_hasil.list')}}">Hasil Kuisioner</a>
                    <a class="nav-link" href="{{route('web.su.susulan_remedial.list')}}">Susulan & Remedial</a>
                    <!-- <a class="nav-link" href="{{route('web.su.tahun_akademik.list')}}">Tahun Akademik</a> -->
                    <!-- <a class="nav-link collapsed" href="javascript:void(0);" data-bs-toggle="collapse" data-bs-target="#pagesCollapsePpdbonline" aria-expanded="false" aria-controls="pagesCollapsePpdbonline">
                        PPDB Online
                        <div class="sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                    </a>
                    <div class="collapse" id="pagesCollapsePpdbonline" data-bs-parent="#accordionSidenavPagesMenu">
                        <nav class="sidenav-menu-nested nav">
                            <a class="nav-link" href="{{route('web.su.ppdb.abc.list')}}">Siswa Baru Paket ABC</a>
                            <a class="nav-link" href="{{route('web.su.ppdb.abc_new.list')}}">Daftar PPDB Online</a>
                            <a class="nav-link" href="{{route('web.su.ppdb.paud.list')}}">Siswa Baru Paket Paud</a>
                        </nav>
                    </div> -->
                </nav>
            </div>
            <a class="nav-link collapsed" href="javascript:void(0);" data-bs-toggle="collapse" data-bs-target="#collapseRombel" aria-expanded="false" aria-controls="collapseSettings">
                <div class="nav-link-icon"><i data-feather="grid"></i></div>
                Rombongan Belajar
                <div class="sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
            </a>
            <div class="collapse" id="collapseRombel" data-bs-parent="#accordionSidenav">
                <nav class="sidenav-menu-nested nav accordion" id="accordionSidenavSettings">
                    <a class="nav-link" href="{{route('web.su.rombongan_belajar.list')}}">List</a>
                    <a class="nav-link" href="{{route('web.su.rombongan_belajar.summary')}}">Summary</a>
                </nav>
            </div>
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