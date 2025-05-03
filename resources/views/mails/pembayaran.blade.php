<!DOCTYPE html>
<html lang="en">
    <head>                  
        <meta charset="utf-8" />
        <title>Invoice | PKBM Generasi Juara</title>                    
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
                                        <img src="https://generasijuara.sch.id/wp/wp-content/uploads/2020/08/logo-1.png" alt="logo" height="100"/>
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
                                <div class="col-6">
                                    <address>
                                        <strong>Pembayaran Dari:</strong><br>
                                        <strong>{nama_pengirim}</strong><br>
                                        NIS : {nis}
                                    </address>
                                </div>
                                <div class="col-6 text-right">
                                    <address>
                                        <strong>Tanggal Pembayaran:</strong><br>
                                        {date('d-m-Y')}<br>  
                                    </address>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12">
                            <div>
                                <div class="p-2">
                                    <!-- <h3 class="font-size-16"><strong>Order summary</strong></h3> -->
                                </div>
                                <div class="">
                                    <div class="table-responsive">
                                        <table class="table">
                                            <thead>
                                                <tr>
                                                    <td><strong>Deskripsi</strong></td>
                                                    <td class="text-center"><strong>Quantitas</strong>
                                                    <td class="text-center"><strong>Harga</strong></td>
                                                    </td>
                                                    <td class="text-right"><strong>Total</strong></td>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>Biaya {jenis_bayar}<br>{pesan}</td>
                                                    <td class="text-center">1</td>
                                                    <td class="text-center">Rp. {biaya}</td>
                                                    <td class="text-right">Rp. {biaya}</td>
                                                </tr>

                                                <tr>
                                                    <td class="no-line"></td>
                                                    <td class="no-line"></td>
                                                    <td class="no-line text-center">
                                                        <strong style="color: green;">Dibayar</strong>
                                                    </td>
                                                    <td class="no-line text-right" style="color: green;">- Rp. {biaya}</td>
                                                </tr>
                                                <tr>
                                                    <td class="no-line"></td>
                                                    <td class="no-line"></td>
                                                    <td class="no-line text-center">
                                                        <strong>Total</strong>
                                                    </td>
                                                    <td class="no-line text-right">
                                                        <h4 class="m-0">Rp. {biaya}</h4>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
            
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</html>