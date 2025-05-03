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
            <!-- Sidenav Accordion (Pages)-->
            <a class="nav-link collapsed" href="javascript:void(0);" data-bs-toggle="collapse" data-bs-target="#collapseMaster" aria-expanded="false" aria-controls="collapseMaster">
                <div class="nav-link-icon"><i data-feather="grid"></i></div>
                Master
                <div class="sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
            </a>
            <div class="collapse" id="collapseMaster" data-bs-parent="#accordionSidenav">
                <nav class="sidenav-menu-nested nav accordion" id="accordionSidenavMasterMenu">
                    <a class="nav-link" href="{{route('web.su.tutor.list')}}">Tutor</a>
                    <a class="nav-link" href="{{route('web.su.layanan_kelas.list')}}">Layanan Kelas</a>
                    <a class="nav-link collapsed" href="javascript:void(0);" data-bs-toggle="collapse" data-bs-target="#pagesCollapsePaketKelas" aria-expanded="false" aria-controls="pagesCollapsePaketKelas">
                        Paket Kelas
                        <div class="sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                    </a>
                    <div class="collapse" id="pagesCollapsePaketKelas" data-bs-parent="#accordionSidenavPagesMenu">
                        <nav class="sidenav-menu-nested nav">
                            <a class="nav-link" href="{{route('web.su.paket_kelas.abc.list')}}">Kelas ABC</a>
                            <a class="nav-link" href="{{route('web.su.paket_kelas.paud.list')}}">Kelas Paud-TBM</a>
                        </nav>
                    </div>
                    <a class="nav-link collapsed" href="javascript:void(0);" data-bs-toggle="collapse" data-bs-target="#pagesCollapsePaketSPP" aria-expanded="false" aria-controls="pagesCollapsePaketSPP">
                        Paket SPP
                        <div class="sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                    </a>
                    <div class="collapse" id="pagesCollapsePaketSPP" data-bs-parent="#accordionSidenavPagesMenu">
                        <nav class="sidenav-menu-nested nav">
                            <a class="nav-link" href="{{route('web.su.paket_spp.abc.list')}}">SPP Paket ABC</a>
                            <a class="nav-link" href="{{route('web.su.paket_spp.paud.list')}}">SPP Paket Paud-TBM</a>
                        </nav>
                    </div>
                    <a class="nav-link" href="{{route('web.su.cabang.list')}}">Cabang</a>
                    <a class="nav-link" href="{{route('web.su.user.list')}}">User</a>
                    <!-- <a class="nav-link" href="{{route('web.su.rombel_akademik.list')}}">Rombel Akademik</a> -->
                    <!-- <a class="nav-link" href="{{route('web.su.kota.list')}}">Kota</a> -->
                </nav>
            </div>

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
                    <a class="nav-link" href="{{route('web.su.capaian_dimensi.list')}}">Capaian Dimensi</a>
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

            <a class="nav-link collapsed" href="javascript:void(0);" data-bs-toggle="collapse" data-bs-target="#collapseKeuangan" aria-expanded="false" aria-controls="collapseKeuangan">
                <div class="nav-link-icon"><i data-feather="grid"></i></div>
                Keuangan
                <div class="sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
            </a>
            <div class="collapse" id="collapseKeuangan" data-bs-parent="#accordionSidenav">
                <nav class="sidenav-menu-nested nav accordion" id="accordionSidenavKeuanganMenu">
                    <a class="nav-link" href="{{route('web.su.keuangan.pembayaran.list')}}">Pembayaran</a>
                </nav>
            </div>
            <a class="nav-link" href="{{route('web.su.alumni.list')}}">
                <div class="nav-link-icon"><i data-feather="user"></i></div> Alumni 
                <!-- <span class="badge bg-warning-soft text-warning ms-auto">Coming Soon</span> -->
            </a>
            <a class="nav-link" href="{{route('web.su.news.list')}}">
                <div class="nav-link-icon"><i data-feather="grid"></i></div> Berita 
                <!-- <span class="badge bg-warning-soft text-warning ms-auto">Coming Soon</span> -->
            </a>
            <a class="nav-link" href="{{route('web.su.voucher.list')}}">
                <div class="nav-link-icon"><i data-feather="grid"></i></div> Voucher 
                <!-- <span class="badge bg-warning-soft text-warning ms-auto">Coming Soon</span> -->
            </a>
            <a class="nav-link collapsed" href="javascript:void(0);" data-bs-toggle="collapse" data-bs-target="#collapseSettings" aria-expanded="false" aria-controls="collapseSettings">
                <div class="nav-link-icon"><i data-feather="settings"></i></div>
                Settings
                <div class="sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
            </a>
            <div class="collapse" id="collapseSettings" data-bs-parent="#accordionSidenav">
                <nav class="sidenav-menu-nested nav accordion" id="accordionSidenavSettings">
                    <a class="nav-link" href="{{route('web.su.tahun_akademik.list')}}">Tahun Akademik</a>
                    <a class="nav-link" href="{{route('web.su.ttd_raport.list')}}">TTD Raport</a>
                    <a class="nav-link" href="{{route('web.su.settings')}}">Global</a>
                </nav>
            </div>

            <a class="nav-link collapsed" href="javascript:void(0);" data-bs-toggle="collapse" data-bs-target="#collapseTemplateImport" aria-expanded="false" aria-controls="collapseTemplateImport">
                <div class="nav-link-icon"><i data-feather="file"></i></div>
                Template Import
                <div class="sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
            </a>
            <div class="collapse" id="collapseTemplateImport" data-bs-parent="#accordionSidenav">
                <nav class="sidenav-menu-nested nav accordion" id="accordionSidenavSettings">
                    <a class="nav-link" href="{{asset('import/template_tutor.xlsx')}}">Tutor</a>
                    <a class="nav-link" href="{{asset('import/template_paket_mapel_a.xlsx')}}">Distribusi Mapel Kelas A</a>
                    <a class="nav-link" href="{{asset('import/template_paket_mapel_bc.xlsx')}}">Distribusi Mapel Kelas B&C</a>
                    <a class="nav-link" href="{{asset('import/template_rombel_baru.xlsx')}}">Rombel</a>
                    <!-- <a class="nav-link" href="{{asset('import/template_nilai.xlsx')}}">Nilai</a> -->
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