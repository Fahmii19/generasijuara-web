<!DOCTYPE html>
<html lang="en">
    <head>                  
        <meta charset="utf-8" />
        <title>Verifikasi Pendaftaran Ananda {{$name}}</title>                  
    </head>

    <!-- end page title -->

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-12">
                            <div class="invoice-title">
                                <div class="row">
                                    <div class="col-md-2">
                                        <img src="{{asset('images/logo.jpeg')}}" alt="logo" height="100"/>
                                    </div>
                                    <div class="col-md-10">
                                        <div align="right">
                                            <p class=" font-size-16"><strong>Yayasan Generasi Juara</strong></p>
                                            <span class="font-size-12">Jalan Dewi Sartika No. 17 RT 02
                                                <br>RW 04 Kel. Sukorejo Kec. Gunung
                                                <br>Pati Kota Semarang 50221
                                                <br>NPWP: 80.855.962.9-422.000

                                                <br><br>087825626969
                                                <br>bendahara@generasijuara.sch.id
                                            </span>
                                        
                                        </div>
                                    </div>
                                </div>
                                <h3 class="mt-0"></h3>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-12">
                                    <address>
                                        <strong>Menerangkan bahwa :<br></strong>Ananda {{$name}} / {{$nik}} telah <strong> Diterima</strong> menjadi Siswa Generasi Juara.<br>
                                        Mohon untuk melengkapi data diri di {{route('web.siab.home')}}, dengan Login dan Password sebagai berikut :<br>
                                        <p>
                                            Username : {{$username}}<br>
                                            Password : {{$password}}<br>
                                        </p>
                                        <br>
                                        Kemudian klik menu <strong>Profile - Edit Biodata.</strong><br><br>
                                        Terima Kasih telah menjadi keluarga besar <strong>Generasi Juara</strong>. 
                                    </address>
                                </div>                                        
                            </div>
                        </div>
                    </div>
                </div>
            </div>                       
        </div>
    </div>                      
</html>