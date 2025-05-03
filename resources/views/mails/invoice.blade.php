<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="utf-8" />
        <title>Invoice | PKBM Generasi Juara</title>
        <style>
        #customers {
            font-family: Arial, Helvetica, sans-serif;
            border-collapse: collapse;
            width: 100%;
        }

        #customers td,
        #customers th {
            border: 1px solid #ddd;
            padding: 8px;
        }

        #customers tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        #customers tr:hover {
            background-color: #ddd;
        }

        #customers th {
            padding-top: 12px;
            padding-bottom: 12px;
            text-align: left;
            background-color: #4CAF50;
            color: white;
        }
        </style>
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
                                <h3 class="mt-0">
                                </h3>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-6">
                                    <address>
                                        <strong>Pembayaran Dari: </strong> {{ @$nama }} / {{ @$nik }}
                                    </address>
                                </div>
                                <div class="col-6 text-right">
                                    <address>
                                        <strong>Tanggal Pendaftaran: </strong> {{ Carbon\Carbon::parse($created_at)->translatedFormat('d F Y') }}<br>
                                        <strong>Tanggal Pembayaran: </strong> {{ Carbon\Carbon::parse($paid_at)->translatedFormat('d F Y') }}<br>
                                        <strong>Status: </strong> {{($is_approved) ? 'Pembayaran Diterima' : 'Sedang diverifikasi'}}<br><br><br>
                                    </address>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- data ppdb -->
                    <div class="row">
                        <div class="col-12">
                            <div>
                                <div class="p-2">
                                    <h3 class="font-size-16"><strong>Detail Profile</strong></h3>
                                </div>
                                <div class="">
                                    <div class="table-responsive">
                                        <table id="customers">
                                            <tr>
                                                <th width="16%">NIS</th>
                                                <td width="16%">{{($is_approved) ? $nis : $ppdb->nis}}</td>

                                                <th width="16%">Email</th>
                                                <td width="16%">{{$ppdb->email}}</td>
                                                
                                                <th width="16%">Kelamin</th>
                                                <td width="16%">{{$ppdb->kelamin}}</td>
                                            </tr>
                                            <tr>
                                                <th>Nama Siswa</th>
                                                <td>{{$ppdb->nama}}</td>
                                                
                                                <th>Nama Ayah</th>
                                                <td>{{$ppdb->nama_ayah}}</td>
                                                
                                                <th>Nama Ibu</th>
                                                <td>{{$ppdb->nama_ibu}}</td>
                                            </tr>
                                            <tr>
                                                <th>NIK Siswa</th>
                                                <td>{{$ppdb->nik_siswa}}</td>
                                                
                                                <th>NIK Ayah</th>
                                                <td>{{$ppdb->nik_ayah}}</td>
                                                
                                                <th>NIK Ibu</th>
                                                <td>{{$ppdb->nik_ibu}}</td>
                                            </tr>
                                            <tr>
                                                <th>HP Siswa</th>
                                                <td>{{$ppdb->hp_siswa}}</td>
                                                
                                                <th>HP Ayah</th>
                                                <td>{{$ppdb->hp_ayah}}</td>
                                                
                                                <th>HP Ibu</th>
                                                <td>{{$ppdb->hp_ibu}}</td>
                                            </tr>
                                            <tr>
                                                <th>Telegram Siswa</th>
                                                <td>{{$ppdb->telegram_siswa}}</td>
                                                
                                                <th>Telegram Ayah</th>
                                                <td>{{$ppdb->telegram_ayah}}</td>
                                                
                                                <th>Telegram Ibu</th>
                                                <td>{{$ppdb->telegram_ibu}}</td>
                                            </tr>
                                            <tr>
                                                <th>Layanan Kelas</th>
                                                <td>{{@$ppdb->layanan_kelas->nama}}</td>

                                                <th>Paket Kelas</th>
                                                <td>{{@$ppdb->paket_kelas->nama}}</td>
                                                
                                                <th>Nama Kelas</th>
                                                <td>{{@$ppdb->kelas->nama}}</td>
                                            </tr>
                                            <tr>
                                                <th>Kelas Sebelumnya</th>
                                                <td>{{@$ppdb->kelas_sebelum}}</td>

                                                <th>Semester Sebelumnya</th>
                                                <td>{{@$ppdb->smt_kelas_sebelum}}</td>

                                                <th>Kelas Tujuan</th>
                                                <td>{{@$ppdb->kelas}}</td>
                                            </tr>
                                            <tr>
                                                <th>Semester Tujuan</th>
                                                <td>{{@$ppdb->smt_kelas}}</td>

                                                <th>Lulusan</th>
                                                <td>{{@$ppdb->lulusan}}</td>

                                                <th>Tahun Lulus</th>
                                                <td>{{@$ppdb->tahun_lulus}}</td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- data invoice -->
                    <div class="row">
                        <div class="col-12">
                            <div>
                                <div class="p-2">
                                    <h3 class="font-size-16"><strong>Invoice Detail</strong></h3>
                                </div>
                                <div class="">
                                    <div class="table-responsive">
                                        <table id="customers">
                                            <tr>
                                                <th scope="col">Deskripsi</th>
                                                <th scope="col">Biaya</th>
                                                <th scope="col">Bayar</th>
                                                <th scope="col">Sisa</th>
                                            </tr>
                                            {{-- JIKA PPDB / PPDB_ULANG --}}
                                            @if ($mail_type == 'new_payment')   
                                            <tr>
                                                <td colspan="4"></td>
                                            </tr>
                                            <tr>
                                                <td>Biaya Pendaftaran</td>
                                                <td>Rp. {{ number_format(@$biaya_daftar) }}</td>
                                                <td>Rp. {{($biaya_daftar_paid) ? number_format(@$biaya_daftar_paid) : 0}}</td>
                                                <td>Rp. {{ number_format(@$biaya_daftar_sisa) }}</td>
                                            </tr>
                                            @if (!empty($biaya_kk))
                                            <tr>
                                                <td>Biaya Kelas Khusus</td>
                                                <td>Rp. {{ number_format(@$biaya_kk) }}</td>
                                                <td>Rp. {{($biaya_kk_paid) ? number_format(@$biaya_kk_paid) : 0}}</td>
                                                <td>Rp. {{ number_format(@$biaya_kk_sisa) }}</td>
                                            </tr>
                                            @endif
                                            @if (!empty($biaya_program))
                                            <tr>
                                                <td>Biaya Program</td>
                                                <td>Rp. {{ number_format(@$biaya_program) }}</td>
                                                <td>Rp. {{($biaya_program_paid) ? number_format(@$biaya_program_paid) : 0}}</td>
                                                <td>Rp. {{ number_format(@$biaya_program_sisa) }}</td>
                                            </tr>
                                            @endif
                                            <tr>
                                                <td>SPP</td>
                                                <td>Rp. {{ number_format(@$biaya_spp) }}</td>
                                                <td>Rp. {{($biaya_spp_paid) ? number_format(@$biaya_spp_paid) : 0}}</td>
                                                <td>Rp. {{ number_format(@$biaya_spp_sisa) }}</td>
                                            </tr>
                                            <tr>
                                                <td>Wakaf</td>
                                                <td>Rp. {{ number_format(@$wakaf) }}</td>
                                                <td>Rp. {{($wakaf_paid) ? number_format(@$wakaf_paid) : 0}}</td>
                                                <td>Rp. {{ number_format(@$wakaf_sisa) }}</td>
                                            </tr>
                                            <tr>
                                                <td>Infaq dan Sedekah</td>
                                                <td>Rp. {{ number_format(@$infaq) }}</td>
                                                <td>Rp. {{($infaq_paid) ? number_format(@$infaq_paid) : 0}}</td>
                                                <td>Rp. {{ number_format(@$infaq_sisa) }}</td>
                                            </tr>
                                            <tr>
                                                <td colspan="4">&nbsp;</td>
                                            </tr>
                                            @if (!empty($biaya_program))
                                            <tr>
                                                <td colspan="2"></td>
                                                <td>
                                                    <strong>Subtotal SPP, Program, dan Pendaftaran</strong>
                                                </td>
                                                <td class="thick-line text-right">Rp. {{ number_format(@$subtotal_spp_program_pendaftaran) }}</td>
                                            </tr>
                                            @else
                                            <tr>
                                                <td colspan="2"></td>
                                                <td>
                                                    <strong>Subtotal SPP & Pendaftaran</strong>
                                                </td>
                                                <td class="thick-line text-right">Rp. {{ number_format(@$subtotal_spp_pendaftaran) }}</td>
                                            </tr>
                                            @endif
                                            <tr>
                                                <td colspan="2"></td>
                                                <td class="thick-line text-center">
                                                    <strong>Subtotal Wakaf, Infaq dan Sedekah</strong>
                                                </td>
                                                <td class="thick-line text-right">Rp. {{ number_format(@$sub_wakaf_infaq) }}</td>
                                            </tr>
                                            <tr>
                                                <td colspan="2"></td>
                                                <td class="thick-line text-center">
                                                    <strong>Discount</strong>
                                                </td>
                                                <td class="thick-line text-right">- Rp. {{ number_format(@$discount) }}</td>
                                            </tr>
                                            <tr>
                                                <td colspan="2"></td>
                                                <td class="thick-line text-center">
                                                    <strong style="color: red;">Deposit</strong>
                                                </td>
                                                <td class="thick-line text-right" style="color: blue;">Rp.
                                                    {{ number_format(@$deposit) }}</td>
                                            </tr>
                                            <tr>
                                                <td colspan="2"></td>
                                                <td class="no-line text-center">
                                                    <strong style="color: green;">Dibayar</strong>
                                                </td>
                                                <td class="no-line text-right" style="color: green;">Rp.
                                                    {{ number_format(@$subtotal_paid) }}</td>
                                            </tr>
                                            <tr>
                                                <td colspan="2"></td>
                                                <td class="no-line text-center">
                                                    <strong>Total Tagihan</strong>
                                                </td>
                                                <td class="no-line text-right">
                                                    <h4 class="m-0">Rp. {{ number_format(@$total_tagihan) }}</h4>
                                                </td>
                                            </tr>
                                            @endif

                                            
                                            {{-- JIKA KONFIRMASI PEMBAYARAN --}}
                                            @if ($mail_type == 'payment_confirmation')
                                            @if (!empty($tagihan_item)) 
                                                @foreach ($tagihan_item as $item)
                                                <tr>
                                                    <td>{{$item['item']}}</td>
                                                    <td>Rp. {{ number_format($item['biaya'] ?? 0) }}</td>
                                                    <td>Rp. {{ number_format($item['bayar']) ?? 0}}</td>
                                                    <td>Rp. {{ number_format($item['sisa']) }}</td>
                                                </tr>
                                                @endforeach
                                            @endif
                                            <tr>
                                                <td colspan="4">&nbsp;</td>
                                            </tr>
                                            <tr>
                                                <td colspan="2"></td>
                                                <td>
                                                    <strong>Subtotal Tagihan</strong>
                                                </td>
                                                <td class="thick-line text-right">Rp. {{ number_format(@$payment_summary[0]['subtotal_tagihan']) }}</td>
                                            </tr>
                                            <tr>
                                                <td colspan="2"></td>
                                                <td class="thick-line text-center">
                                                    <strong>Discount</strong>
                                                </td>
                                                <td class="thick-line text-right">- Rp. {{ number_format(@$payment_summary[0]['discount']) }}</td>
                                            </tr>
                                            <tr>
                                                <td colspan="2"></td>
                                                <td class="thick-line text-center">
                                                    <strong style="color: red;">Deposit</strong>
                                                </td>
                                                <td class="thick-line text-right" style="color: blue;">Rp.
                                                    {{ number_format(@$payment_summary[0]['deposit'] ?? 0) }}</td>
                                            </tr>
                                            <tr>
                                                <td colspan="2"></td>
                                                <td class="no-line text-center">
                                                    <strong style="color: green;">Dibayar</strong>
                                                </td>
                                                <td class="no-line text-right" style="color: green;">Rp.
                                                    {{ number_format(@$payment_summary[0]['terbayar']) }}</td>
                                            </tr>
                                            <tr>
                                                <td colspan="2"></td>
                                                <td class="no-line text-center">
                                                    <strong>Total Tagihan</strong>
                                                </td>
                                                <td class="no-line text-right">
                                                    <h4 class="m-0">Rp. {{ number_format(@$payment_summary[0]['total_tagihan']) }}</h4>
                                                </td>
                                            </tr>
                                            @endif
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