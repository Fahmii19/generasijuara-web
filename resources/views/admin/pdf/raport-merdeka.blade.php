<!DOCTYPE html>
<html>
<head>
	<title>Raport Merdeka</title>
	<style>

{
        box-sizing: border-box;
        }
		body{
			font-family: "Roboto", sans-serif;
            margin: 0;
            padding: 0;
		}

        table {
            table-layout: fixed;
            width: 100%;
            min-width: 100%;
        }

        td {
            min-width: 20px;
            overflow: hidden;
        }

        .font-size-10 { font-size: 10px; }
        .font-size-9 { font-size: 9px; }
        .font-size-12 { font-size: 12px; }
        .font-size-14 { font-size: 14px; }
        .font-predikat { font-size: 60px; }
        .font-weight-600 { font-weight: 600; }
        .font-bold { font-weight: bolder; }
        .letter-spacing-sm { letter-spacing: 1px; }
        .line-height-sm { line-height: 1.25; }
        .new-page { page-break-before: always; }
        .border-bottom-sm { border-bottom: solid 1px #000; }
        .table-collapse { border-collapse: collapse; }
        .mapel-row > td:first-child { text-align: center; }
        .table-sikap, .table-nilai { margin-left: 15px; }
        .text-center { text-align: center; }
        .text-left { text-align: left; }
        .vertical-middle { vertical-align: middle; }
        .mt-0 { margin-top: 0; }
        .mb-0 { margin-bottom: 0; }
        .petunjuk-pengisian li {
            margin-bottom: 10px;
            text-align: justify;
        }

        .no-divide {
            width: 100%;
            table-layout: fixed;
        }
        .no-divide td {
            width: auto !important;
            min-width: 30px !important;
        }

        /*  */
		.font-size-10{
			font-size: 10px;
		}
		.font-size-9{
			font-size: 9px;
		}
		.font-size-12{
			font-size: 12px;
		}
		.font-size-14{
			font-size: 14px;
		}
		.font-predikat{
			font-size: 60px;
		}
		.font-weight-600{
			font-weight: 600;
		}
		.font-bold{
			font-weight: bolder;
		}
		.letter-spacing-sm{
			letter-spacing: 1px;
		}
		.line-height-sm{
			line-height: 1.25
		}
		.new-page {
			page-break-before: always;
		}
		.border-bottom-sm{
			border-bottom:solid 1px #000;
		}
		.table-collapse{
			border-collapse: collapse;
		}
		.mapel-row >td:first-child{
			text-align: center;
		}
		.table-sikap,.table-nilai{
			margin-left: 15px;
		}
		.text-center{
			text-align: center;
		}

        .text-left{
            text-align: left;
        }

		.vertical-middle{
			vertical-align: middle;
		}
		.mt-0{
			margin-top: 0;
		}
		.mb-0{
			margin-bottom: 0;
		}
		.petunjuk-pengisian li{
			margin-bottom: 10px;
			text-align: justify;
		}
	</style>
	<link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap" rel="stylesheet">
</head>
<body style="padding-top: 0; margin-top:0;">

	<div class="text-center" style="margin-top: 50px;">
		{{-- <h3 style="color: #1f497d">PKBM GENERASI JUARA</h3> --}}
		<img src="{{ public_path('/images/logo.jpeg') }}" style="height: 100px;">
	</div>

    @php
        $keterangan = '';
        if ($fase == 'A') {
            $keterangan = 'SD';
        } elseif ($fase == 'B') {
            $keterangan = 'SMP';
        } elseif ($fase == 'C') {
            $keterangan = 'SMA';
        }
    @endphp
    <div class="text-center">
        <p class="font-bold" style="font-size: 24px; margin: 96px 104px 64px 104px;">LAPORAN HASIL BELAJAR PESERTA DIDIK
            PROGRAM PAKET {{ $fase }} SETARA {{ $keterangan }}</p>
	</div>

	<div class="text-center" style="margin-top: 24px;">
		<div class="font-size-14">NAMA PESERTA DIDIK:</div>
		<div style="margin: auto; width: 60%; background: #c5d9f1; border-top-style: solid; border-top-color: #000; padding: 10px; text-align: center;">
			<strong>
				{{ strtoupper(@$kelas_wb->wb_detail->nama) }}
			</strong>
		</div>
		<br>
		<div class="font-size-14">NIS/NISN:</div>
		<div style="margin: auto; width: 60%; background: #c5d9f1; border-top-style: solid; border-top-color: #000; padding: 10px; text-align: center;">
			<strong>
				{{$kelas_wb->wb_detail->no_induk}} / {{$kelas_wb->wb_detail->nisn}}
			</strong>
		</div>
	</div>

	<div class="text-center" style="margin-top: 280px;">
		<strong style="font-size: 16px;">PKBM GENERASI JUARA</strong>
        <p class="font-size-14" style="margin: 0px">P9970355</p>
		<p class="font-size-12">
			JL. Arjuna Raya No.89 Depok II Tengah Kel. Mekar Jaya Kec. Sukmajaya - Depok <br>
			Tel. 087784164812 / 087882525896 | Web: generasijuara.sch.id, mail :admin@generasijuara.sch.id
		</p>
	</div>


	{{-- PAGE BREAK --}}
	<div class="new-page"></div>

    <div style="margin-left: 70px; margin-right: 80px;">
        <div class="text-center">
            <p style="font-weight: bold;">IDENTITAS SEKOLAH</p>
        </div>
        <table style="width: 100%;">
			<tr>
				<td style="padding: 3px; font-size: 10px;" width="25%">Nama Satuan Pendidikan </td>
				<td width="5%" style="font-size: 10px;">: </td>
				<td width="50%" style="font-size: 10px; border-bottom:solid 1px rgb(161, 161, 161); padding: 3px;">
					PKBM GENERASI JUARA
				</td>
			</tr>
			<tr>
				<td style="padding: 3px; font-size: 10px;" width="25%">NPSN </td>
				<td width="5%" style="font-size: 10px;">: </td>
				<td width="50%" style="font-size: 10px; border-bottom:solid 1px rgb(161, 161, 161); padding: 3px;">
					P9970355
				</td>
			</tr>
			<tr>
				<td style="padding: 3px; font-size: 10px;" width="25%">Alamat </td>
				<td width="5%" style="font-size: 10px;">: </td>
				<td width="50%" style="font-size: 10px; border-bottom:solid 1px rgb(161, 161, 161); padding: 3px;">
					JL. Arjuna Raya No.89 Depok II
				</td>
			</tr>
            <br>
            <tr>
				<td style="padding: 3px; font-size: 10px;" width="25%">Kode Pos </td>
				<td width="5%" style="font-size: 10px;">: </td>
				<td width="50%" style="font-size: 10px; border-bottom:solid 1px rgb(161, 161, 161); padding: 3px;">
					60213
				</td>
			</tr>
            <tr>
				<td style="padding: 3px; font-size: 10px;" width="25%">Website </td>
				<td width="5%" style="font-size: 10px;">: </td>
				<td width="50%" style="font-size: 10px; border-bottom:solid 1px rgb(161, 161, 161); padding: 3px;">
					generasijuara.sch.id
				</td>
			</tr>
            <tr>
				<td style="padding: 3px; font-size: 10px;" width="25%">Email </td>
				<td width="5%" style="font-size: 10px;">: </td>
				<td width="50%" style="font-size: 10px; border-bottom:solid 1px rgb(161, 161, 161); padding: 3px;">
					admin@generasijuara.sch.id
				</td>
			</tr>
            <tr>
				<td style="padding: 3px; font-size: 10px;" width="25%">Telepon </td>
				<td width="5%" style="font-size: 10px;">: </td>
				<td width="50%" style="font-size: 10px; border-bottom:solid 1px rgb(161, 161, 161); padding: 3px;">
					087784164812/087882525896
				</td>
			</tr>

		</table>
    </div>

	<div class="new-page"></div>

    <div class="text-center">
		<h4>KETERANGAN DIRI TENTANG PESERTA DIDIK</h4>
	</div>

	<div style="margin-left: 70px; margin-right: 80px;">
		<table style="width: 100%;">
			<tr>
				<td class="font-size-10" style="padding: 3px;" width="5%">1 </td>
				<td class="font-size-10" style="padding: 3px;" width="25%">Nama Lengkap Peserta Didik </td>
				<td class="font-size-10" width="5%">: </td>
				<td class="font-size-10 border-bottom-sm" width="50%" style="border-bottom:solid 1px rgb(161, 161, 161); padding: 3px;">
					{{ucwords(@$kelas_wb->wb_detail->nama)}}
				</td>
			</tr>

			<tr>
				<td class="font-size-10" style="padding: 3px;" width="5%">2 </td>
				<td class="font-size-10" style="padding: 3px;" width="25%">NIS dan NISN </td>
				<td class="font-size-10" width="5%">: </td>
				<td class="font-size-10 border-bottom-sm" width="50%" style="border-bottom:solid 1px rgb(161, 161, 161); padding: 3px;">
					{{$kelas_wb->wb_detail->no_induk}} / {{$kelas_wb->wb_detail->nisn}}
				</td>
			</tr>

			<tr>
				<td class="font-size-10" style="padding: 3px;" width="5%">3 </td>
				<td class="font-size-10" style="padding: 3px;" width="25%">Tempat, Tanggal Lahir </td>
				<td class="font-size-10" width="5%">: </td>
				<td class="font-size-10 border-bottom-sm" width="50%" style="border-bottom:solid 1px rgb(161, 161, 161); padding: 3px;">
					{{ $kelas_wb->wb_detail->tempat_lahir ?? '-' }}, {{ !empty($kelas_wb->wb_detail->tanggal_lahir) ? Carbon\Carbon::parse($kelas_wb->wb_detail->tanggal_lahir)->translatedFormat('d F Y') : '-' }}
				</td>
			</tr>

			<tr>
				<td class="font-size-10" style="padding: 3px;" width="5%">4 </td>
				<td class="font-size-10" style="padding: 3px;" width="25%">Jenis Kelamin </td>
				<td class="font-size-10" width="5%">: </td>
				<td class="font-size-10 border-bottom-sm" width="50%" style="border-bottom:solid 1px rgb(161, 161, 161); padding: 3px;">
					{{ ($kelas_wb->wb_detail->kelamin == 'l') ? "Laki-laki" : "Perempuan" }}
				</td>
			</tr>

			<tr>
				<td class="font-size-10" style="padding: 3px;" width="5%">5 </td>
				<td class="font-size-10" style="padding: 3px;" width="25%">Agama </td>
				<td class="font-size-10" width="5%">: </td>
				<td class="font-size-10 border-bottom-sm" width="50%" style="border-bottom:solid 1px rgb(161, 161, 161); padding: 3px;">
					{{ ucwords($kelas_wb->wb_detail->agama) ?? '-' }}
				</td>
			</tr>

			<tr>
				<td class="font-size-10" style="padding: 3px;" width="5%">6 </td>
				<td class="font-size-10" style="padding: 3px;" width="25%">Status dalam Keluarga </td>
				<td class="font-size-10" width="5%">: </td>
				<td class="font-size-10 border-bottom-sm" width="50%" style="border-bottom:solid 1px rgb(161, 161, 161); padding: 3px;">
					{{ ucwords($kelas_wb->wb_detail->status_dalam_keluarga) ?? '-' }}
				</td>
			</tr>

			<tr>
				<td class="font-size-10" style="padding: 3px;" width="5%">7 </td>
				<td class="font-size-10" style="padding: 3px;" width="25%">Anak ke </td>
				<td class="font-size-10" width="5%">: </td>
				<td class="font-size-10 border-bottom-sm" width="50%" style="border-bottom:solid 1px rgb(161, 161, 161); padding: 3px;">
					{{ $kelas_wb->wb_detail->anak_ke ?? '-' }}
				</td>
			</tr>

			<tr>
				<td class="font-size-10" style="padding: 3px;" width="5%">8 </td>
				<td class="font-size-10" style="padding: 3px;" width="25%">Alamat Peserta Didik </td>
				<td class="font-size-10" width="5%">: </td>
				<td class="font-size-10 border-bottom-sm" width="50%" style="border-bottom:solid 1px rgb(161, 161, 161); padding: 3px;">
					{{ $kelas_wb->wb_detail->alamat_peserta_didik ?? '-' }}
				</td>
			</tr>

			<tr>
				<td class="font-size-10" style="padding: 3px;" width="5%">9 </td>
				<td class="font-size-10" style="padding: 3px;" width="25%">Alamat Domisili </td>
				<td class="font-size-10" width="5%">: </td>
				<td class="font-size-10 border-bottom-sm" width="50%" style="border-bottom:solid 1px rgb(161, 161, 161); padding: 3px;">
					{{ $kelas_wb->wb_detail->alamat_domisili ?? '-' }}
				</td>
			</tr>

			<tr>
				<td class="font-size-10" style="padding: 3px;" width="5%">10 </td>
				<td class="font-size-10" style="padding: 3px;" width="25%">Nomor Telepon Rumah </td>
				<td class="font-size-10" width="5%">: </td>
				<td class="font-size-10 border-bottom-sm" width="50%" style="border-bottom:solid 1px rgb(161, 161, 161); padding: 3px;">
					{{ $kelas_wb->wb_detail->no_telp_rumah ?? '-' }}
				</td>
			</tr>

			<tr>
				<td class="font-size-10" style="padding: 3px;" width="5%">11 </td>
				<td class="font-size-10" style="padding: 3px;" width="25%">Satuan Pendidikan Asal </td>
				<td class="font-size-10" width="5%">: </td>
				<td class="font-size-10 border-bottom-sm" width="50%" style="border-bottom:solid 1px rgb(161, 161, 161); padding: 3px;">
					{{ $kelas_wb->wb_detail->satuan_pendidikan_asal ?? '-' }}
				</td>
			</tr>

			<tr>
				<td class="font-size-10" style="padding: 3px;" width="5%">12 </td>
				<td class="font-size-10" style="padding: 3px;" width="25%">Diterima di PKBM/SKB ini </td>
				<td colspan="2"></td>
			</tr>

			<tr>
				<td class="font-size-10" style="padding: 3px;" width="5%"> </td>
				<td class="font-size-10" style="padding: 3px;" width="25%">a. Tingkatan/Kelas </td>
				<td class="font-size-10" width="5%">: </td>
				<td class="font-size-10 border-bottom-sm" width="50%" style="border-bottom:solid 1px rgb(161, 161, 161); padding: 3px;">
					{{$tingkatan_diterima}} / {{$kelas_diterima}}
				</td>
			</tr>

			<tr>
				<td class="font-size-10" style="padding: 3px;" width="5%"> </td>
				<td class="font-size-10" style="padding: 3px;" width="25%">b. Pada tanggal </td>
				<td class="font-size-10" width="5%">: </td>
				<td class="font-size-10 border-bottom-sm" width="50%" style="border-bottom:solid 1px rgb(161, 161, 161); padding: 3px;">
					{{ Carbon\Carbon::parse($kelas_wb->wb_detail->tgl_terima)->translatedFormat('d F Y') ?? '-' }}
				</td>
			</tr>

			<tr>
				<td class="font-size-10" style="padding: 3px;" width="5%">13 </td>
				<td class="font-size-10" style="padding: 3px;" width="25%">Orang Tua </td>
				<td colspan="2"></td>
			</tr>

			<tr>
				<td class="font-size-10" style="padding: 3px;" width="5%"> </td>
				<td class="font-size-10" style="padding: 3px;" width="25%">a. Nama Ayah </td>
				<td class="font-size-10" width="5%">: </td>
				<td class="font-size-10 border-bottom-sm" width="50%" style="border-bottom:solid 1px rgb(161, 161, 161); padding: 3px;">
					{{ ucwords($kelas_wb->wb_detail->nama_ayah) }}
				</td>
			</tr>

			<tr>
				<td class="font-size-10" style="padding: 3px;" width="5%"> </td>
				<td class="font-size-10" style="padding: 3px;" width="25%">b. Nama Ibu </td>
				<td class="font-size-10" width="5%">: </td>
				<td class="font-size-10 border-bottom-sm" width="50%" style="border-bottom:solid 1px rgb(161, 161, 161); padding: 3px;">
					{{ ucwords($kelas_wb->wb_detail->nama_ibu) }}
				</td>
			</tr>

			<tr>
				<td class="font-size-10" style="padding: 3px;" width="5%"> </td>
				<td class="font-size-10" style="padding: 3px;" width="25%">c. Alamat </td>
				<td class="font-size-10" width="5%">: </td>
				<td class="font-size-10 border-bottom-sm" width="50%" style="border-bottom:solid 1px rgb(161, 161, 161); padding: 3px;">
					{{ $kelas_wb->wb_detail->alamat_orang_tua ?? '-' }}
				</td>
			</tr>

			<tr>
				<td class="font-size-10" style="padding: 3px;" width="5%"> </td>
				<td class="font-size-10" style="padding: 3px;" width="25%">d. Nomor Telepon/HP </td>
				<td class="font-size-10" width="5%">: </td>
				<td class="font-size-10 border-bottom-sm" width="50%" style="border-bottom:solid 1px rgb(161, 161, 161); padding: 3px;">
					{{$kelas_wb->wb_detail->hp_ayah}} / {{$kelas_wb->wb_detail->hp_ibu}}
				</td>
			</tr>

			<tr>
				<td class="font-size-10" style="padding: 3px;" width="5%">14 </td>
				<td class="font-size-10" style="padding: 3px;" width="25%">Pekerjaan Orang Tua </td>
				<td colspan="2"></td>
			</tr>

			<tr>
				<td class="font-size-10" style="padding: 3px;" width="5%"> </td>
				<td class="font-size-10" style="padding: 3px;" width="25%">a. Ayah </td>
				<td class="font-size-10" width="5%">: </td>
				<td class="font-size-10 border-bottom-sm" width="50%" style="border-bottom:solid 1px rgb(161, 161, 161); padding: 3px;">
					{{ ucwords($kelas_wb->wb_detail->pekerjaan_ayah) ?? '-' }}
				</td>
			</tr>

			<tr>
				<td class="font-size-10" style="padding: 3px;" width="5%"> </td>
				<td class="font-size-10" style="padding: 3px;" width="25%">b. Ibu </td>
				<td class="font-size-10" width="5%">: </td>
				<td class="font-size-10 border-bottom-sm" width="50%" style="border-bottom:solid 1px rgb(161, 161, 161); padding: 3px;">
					{{ ucwords($kelas_wb->wb_detail->pekerjaan_ibu) ?? '-' }}
				</td>
			</tr>

			<tr>
				<td class="font-size-10" style="padding: 3px;" width="5%">15 </td>
				<td class="font-size-10" style="padding: 3px;" width="25%">Wali Peserta Didik </td>
				<td colspan="2"></td>
			</tr>

			<tr>
				<td class="font-size-10" style="padding: 3px;" width="5%"> </td>
				<td class="font-size-10" style="padding: 3px;" width="25%">a. Nama </td>
				<td class="font-size-10" width="5%">: </td>
				<td class="font-size-10 border-bottom-sm" width="50%" style="border-bottom:solid 1px rgb(161, 161, 161); padding: 3px;">
					{{ ucwords($kelas_wb->wb_detail->nama_wali) ?? '-' }}
				</td>
			</tr>

			<tr>
				<td class="font-size-10" style="padding: 3px;" width="5%"> </td>
				<td class="font-size-10" style="padding: 3px;" width="25%">b. Nomor Telepon/HP </td>
				<td class="font-size-10" width="5%">: </td>
				<td class="font-size-10 border-bottom-sm" width="50%" style="border-bottom:solid 1px rgb(161, 161, 161); padding: 3px;">
					{{ $kelas_wb->wb_detail->no_telp_wali ?? '-' }}
				</td>
			</tr>

			<tr>
				<td class="font-size-10" style="padding: 3px;" width="5%"> </td>
				<td class="font-size-10" style="padding: 3px;" width="25%">c. Alamat </td>
				<td class="font-size-10" width="5%">: </td>
				<td class="font-size-10 border-bottom-sm" width="50%" style="border-bottom:solid 1px rgb(161, 161, 161); padding: 3px;">
					{{ $kelas_wb->wb_detail->alamat_wali ?? '-' }}
				</td>
			</tr>

			<tr>
				<td class="font-size-10" style="padding: 3px;" width="5%"> </td>
				<td class="font-size-10" style="padding: 3px;" width="25%">d. Pekerjaan </td>
				<td class="font-size-10" width="5%">: </td>
				<td class="font-size-10 border-bottom-sm" width="50%" style="border-bottom:solid 1px rgb(161, 161, 161); padding: 3px;">
					{{ ucwords($kelas_wb->wb_detail->pekerjaan_wali) ?? '-' }}
				</td>
			</tr>

		</table>


		<table style="width: 100%; margin-top: 35px;">
			<tr>
				<td class="font-size-10" style="padding: 3px;" width="5%"> </td>
				<td class="text-center" style="padding: 3px;" width="25%">
					@if (!empty($kelas_wb->wb_detail->url_foto_wb) && $kelas_wb->wb_detail->url_foto_wb != '')
						@php
							$pas_foto_path = str_replace(url('/') . '/', '', $kelas_wb->wb_detail->url_foto_wb);
						@endphp
						<img src="{{public_path($pas_foto_path)}}" style="width: 3cm; height: 4cm;" class="img-thumbnail"  alt="">
					@else
					<div style="position: relative; background: #fff; border: solid 2px #54b0c9; height: 4cm; width: 3cm;">
						<p class="font-size-10" style="margin: 0; position: absolute; top: 50%; left: 50%; -ms-transform: translate(-50%, -50%); transform: translate(-50%, -50%);">
							PAS FOTO <br>
							3 x 4 CM
						</p>
					</div>
					@endif
				</td>
				<td class="font-size-12" width="5%"> </td>
				<td class="font-size-12" width="50%" style="padding: 3px;">
					<p>
						Depok, {{ ($kelas_wb->wb_detail->tgl_terima != NULL) ? Carbon\Carbon::parse($kelas_wb->wb_detail->tgl_terima)->translatedFormat('d F Y') : Carbon\Carbon::now()->translatedFormat('d F Y') }} <br>
						Kepala SKB/Ketua PKBM, <br>
						@if ($data_ttd && $data_ttd['url_ttd_ketua'] != '')
							<img src="{{'data:image/png;base64,' . base64_encode(file_get_contents(@$data_ttd['url_ttd_ketua']))}}" alt="image" style="height: 100px;"> <br>
						@else
							<img src="{{ public_path('/images/white.png') }}" style="height: 100px;"> <br>
						@endif

						<b>{{ $data_ttd['nama_ketua_pkbm'] ?? '-' }}</b> <br>
						NIP {{ $data_ttd['nip_ketua_pkbm'] ?? '-' }}
					</p>
				</td>
			</tr>
		</table>
	</div>


	{{-- PAGE BREAK --}}
	<div class="new-page"></div>

    <table style="width: 99%;">
        <tr>
            <td class="font-size-10" style="padding: 3px 10px 3px;" width="23%">Nama Satuan Pendidikan </td>
            <td class="font-size-10" width="5%">: </td>
            <td class="font-size-10 letter-spacing-sm" width="40%" style="padding: 3px 10px 3px 0;">
                    <b>PKBM GENERASI JUARA</b>
            </td>
            <td >

            </td>
            <td width="27%" class="font-size-10 letter-spacing-sm">
                Kelas
                <span style="margin-left:66px;">
                    &emsp;:
                </span>
                <span>{{@$kelas_wb->kelas_detail->kelas}}</span>
            </td>
        </tr>
        <tr>
            <td class="font-size-10" style="padding: 3px 10px 3px;" width="20%" rowspan="2">Alamat </td>
            <td class="font-size-10" width="5%" rowspan="2">: </td>
            <td class="font-size-10" style="padding: 3px 10px 3px 0;" width="40%" rowspan="2">{{ $kelas_wb->wb_detail->alamat_peserta_didik ?? '-' }}</td>
            <td rowspan="2"></td>
            <td width="27%" class="font-size-10">
                Semester
                <span style="margin-left:55px;">
                    &emsp;:
                </span>
                <span class="letter-spacing-sm">
                    {{$semester}}
                </span>
            </td>
        </tr>

        @if(!empty($kelas_wb->kelas_detail->jurusan))
        <tr>
            <td width="27%" class="font-size-10">
                Jurusan
                <span style="margin-left:56px;">
                    :
                </span>
                <span class="letter-spacing-sm">
                    {{ ($kelas_wb->kelas_detail->jurusan == 'IPA') ? "MIA" : "IIS"}}
                </span>
            </td>
        </tr>
        @else
        <tr>
            <td width="27%" class="font-size-10">
                <span style="margin-left:56px;"></span>
                <span class="letter-spacing-sm"></span>
            </td>
        </tr>
        @endif

        <tr>
            <td class="font-size-10" style="padding: 3px 10px 3px;">Nama Peserta Didik </td>
            <td class="font-size-10" width="5%">: </td>
            <td class="font-size-10 letter-spacing-sm" style="padding: 3px 10px 3px 0;"><b>{{@$kelas_wb->wb_detail->nama}}</b></td>
            <td >

            </td>
            <td width="27%" class="font-size-10">
                Fase
                <span style="margin-left:75px;">
                    &emsp;:
                </span>
                <span class="letter-spacing-sm">
                    {{$fase}}
                </span>
            </td>
        </tr>

        <tr>
            <td class="font-size-10" style="padding: 3px 10px 3px;">Nomor Induk/NISN </td>
            <td class="font-size-10" width="5%">: </td>
            <td class="font-size-10" style="padding: 3px 10px 3px 0;">{{@$kelas_wb->wb_detail->no_induk}} / {{@$kelas_wb->wb_detail->nisn}}</td>
            <td >

            </td>
            <td width="27%" class="font-size-10">
                Tahun Pelajaran
                <span style="margin-left:24px;">
                    &emsp;:
                </span>
                <span class="">
                    {{@$kelas_wb->kelas_detail->tahun_akademik->tahun_ajar}}
                </span>
            </td>
        </tr>
    </table>

    <table class="font-size-12" style="width: 95%; border-collapse: collapse; margin-top: 16px; margin-right: 16px; margin-left: 10px;">
        <tr class="text-center" style="font-weight: bold;">
            <td class="text-left" width="3%" style="padding-left: 2px;">
                A.
            </td>
            <td class="text-left" width="40%" style="">
                <span style="margin-left: 4px;">Lembar Isi Mata Pelajaran</span>
            </td>
            <td width="7%" style="">

            </td>
            <td width="40%" style="">

            </td>
        </tr>
    </table>

    <table class="font-size-12" style="width: 95%; border-collapse: collapse; margin-top: 16px; margin-right: 16px; margin-left: 10px;">
        <tr class="text-center" style="font-weight: bold;">
            <td class="text-left" width="3%" style="border: 1px solid black; padding-left: 2px;">
                No
            </td>
            <td width="40%" style="border: 1px solid black;">
                <span>Mata Pelajaran/Program</span>
                <br>
                <span>Pemberdayaan dan Keterampilan</span>
            </td>
            <td width="7%" style="border: 1px solid black;">
                Nilai Akhir
            </td>
            <td width="40%" style="border: 1px solid black;">
                Capaian Kompetensi
            </td>
        </tr>

        <tr class="text-left" style="font-weight: bold;">
            <td colspan="4" class="text-left" width="3%" style="border: 1px solid black; padding-left: 2px;">
                Kelompok Mata Pelajaran Umum
            </td>
        </tr>

        @foreach ($kmp as $index => $kmpItem)

            <tr class="text-left" style="">
                <td class="text-center" width="3%" style="border: 1px solid black; padding-left: 2px;">
                    {{ $index+1 }}
                </td>
                <td width="40%" style="border: 1px solid black; padding-left: 4px;">
                    <span>{{ $kmpItem->mata_pelajaran_detail->nama }}</span>
                </td>
                <td class="text-center" width="7%" style="border: 1px solid black;">
                    <span>{{ $kmpItem->p_nilai_1 }}</span>
                </td>
                <td width="40%" style="border: 1px solid black; padding-left: 4px;">
                    <span>{{ $kmpItem->capaian_kompetensi }}</span>
                </td>
            </tr>

            @if($loop->last)
                <tr class="text-left" style="">
                    <td class="text-center" width="3%" style="border: 1px solid black; padding-left: 2px;">
                        {{ $index + 2 }}
                    </td>
                    <td width="40%" style="border: 1px solid black; padding-left: 4px;">
                        <span>Muatan Lokal
                        </span>
                    </td>
                    <td class="text-center" width="7%" style="border: 1px solid black;">

                    </td>
                    <td width="40%" style="border: 1px solid black; padding-left: 4px;">

                    </td>
                </tr>
            @endif
        @endforeach ()



        <tr class="text-left" style="font-weight: bold;">
            <td colspan="4" class="text-left" width="3%" style="border: 1px solid black; padding-left: 2px;">
                Pemberdayaan dan Keterampilan
            </td>
        </tr>

        <tr class="text-left" style="">
            <td class="text-center" width="3%" style="border: 1px solid black; padding-left: 2px;">
                1
            </td>
            <td width="40%" style="border: 1px solid black; padding-left: 4px;">
                <span>Pemberdayaan
                </span>
            </td>
            <td class="text-center" width="7%" style="border: 1px solid black;">
                91.00
            </td>
            <td width="40%" style="border: 1px solid black; padding-left: 4px;">
                Lorem ipsum dolor sit amet.
            </td>
        </tr>

        <tr class="text-left" style="">
            <td class="text-center" width="3%" style="border: 1px solid black; padding-left: 2px;">
                2
            </td>
            <td width="40%" style="border: 1px solid black; padding-left: 4px;">
                <span>Keterampilan
                </span>
            </td>
            <td class="text-center" width="7%" style="border: 1px solid black;">
                91.00
            </td>
            <td width="40%" style="border: 1px solid black; padding-left: 4px;">
                Lorem ipsum dolor sit amet.
            </td>
        </tr>
    </table>

    <table class="font-size-12" style="width: 95%; border-collapse: collapse; margin-top: 24px; margin-right: 16px; margin-left: 10px;">
        <tr class="text-left" style="">
            <td class="text-center" width="3%" style="border: 1px solid black; padding-left: 2px;">
                No
            </td>
            <td width="40%" style="border: 1px solid black; padding-left: 4px;">
                <span>Kegiatan Esktrakulikuler
                </span>
            </td>
            <td class="text-center" width="7%" style="border: 1px solid black;">
                Predikat
            </td>
            <td width="40%" style="border: 1px solid black; padding-left: 4px;">
                Keterangan
            </td>
        </tr>
        @foreach ($ekstrakurikuler as $item)
            <tr class="text-left" style="">
                <td class="text-center" width="3%" style="border: 1px solid black; padding-left: 2px;">
                    {{ $loop->iteration }}
                </td>
                <td width="40%" style="border: 1px solid black; padding-left: 4px;">
                    <span>{{ $item['kegiatan'] }}
                    </span>
                </td>
                <td class="text-center" width="7%" style="border: 1px solid black;">
                    {{ $item['predikat'] }}
                </td>
                <td width="40%" style="border: 1px solid black; padding-left: 4px;">
                    {{ $item['deskripsi'] }}
                </td>
            </tr>
        @endforeach
    </table>

    <table class="font-size-12" style="width: 95%; border-collapse: collapse; margin-top: 24px; margin-right: 16px; margin-left: 10px;">
        <tr class="text-left" style="">
            <td colspan="3" class="text-center" width="3%" style="border: 1px solid black; padding-left: 2px;">
                Ketidakhadiran
            </td>
            <td width="40%">

            </td>
        </tr>
        <tr class="text-left" style="">
            <td class="text-center" width="3%" style="border: 1px solid black; padding-left: 2px;">
                1
            </td>
            <td width="40%" style="border: 1px solid black; padding-left: 4px;">
                <table style="width: 95%; border-collapse: collapse;" class="font-size-12">
                    <tr>
                        <td width="85%">Izin</td>
                        <td width="5%">: </td>
                        <td width="10%" class="text-center">{{ $presensi['izin'] ?? '-'}}</td>
                    </tr>
                </table>
            </td>
            <td class="text-center" width="7%" style="border: 1px solid black;">
                hari
            </td>
            <td width="40%">

            </td>
        </tr>
        <tr class="text-left" style="">
            <td class="text-center" width="3%" style="border: 1px solid black; padding-left: 2px;">
                2
            </td>
            <td width="40%" style="border: 1px solid black; padding-left: 4px;">
                <table style="width: 95%; border-collapse: collapse;" class="font-size-12">
                    <tr>
                        <td width="85%">Sakit</td>
                        <td width="5%">: </td>
                        <td width="10%" class="text-center">{{ $presensi['sakit'] ?? '-'}}</td>
                    </tr>
                </table>
            </td>
            <td class="text-center" width="7%" style="border: 1px solid black;">
                hari
            </td>
            <td width="40%">

            </td>
        </tr>
        <tr class="text-left" style="">
            <td class="text-center" width="3%" style="border: 1px solid black; padding-left: 2px;">
                3
            </td>
            <td width="40%" style="border: 1px solid black; padding-left: 4px;">
                <table style="width: 95%; border-collapse: collapse;" class="font-size-12">
                    <tr>
                        <td width="85%">Alpa</td>
                        <td width="5%">: </td>
                        <td width="10%" class="text-center">{{ $presensi['alpa'] ?? '-' }}</td>
                    </tr>
                </table>
            </td>
            <td class="text-center" width="7%" style="border: 1px solid black;">
                hari
            </td>
            <td width="40%">

            </td>
        </tr>
    </table>

    <!-- TTD PJ -->
    @include('includes.components.ttd_pj_raport_merdeka')

    {{-- PAGE BREAK --}}
	<div class="new-page"></div>

    @include('includes.components.data_siswa_raport_merdeka')

    <table class="font-size-12" style="width: 95%; border-collapse: collapse; margin-top: 16px; margin-right: 16px; margin-left: 10px; margin-bottom: 10px;">
        <tr class="font-size-12" style="font-weight: bold;">
            <td width="5%" style="padding-left: 2px;">B. </td>
            <td width="95%%" colspan="5" style="padding-left: 2px;">Lembar Isi Capaian Dimensi Profil Pelajar Pancasila pada Program Pemberdayaan dan Keterampilan</td>
        </tr>
    </table>

    <table style="width: 100%; border-collapse: collapse; font-size: 12px;">
        <!-- Header -->
        <tr>
            <td style="border: 1px solid black; width: 3%; text-align: center;">1</td>
            <td style="border: 1px solid black; width: 60%; font-weight: bold;">
                Dimensi Beriman, Bertaqwa kepada Tuhan Yang Maha Esa, dan Berakhlak Mulia
            </td>
            <td colspan="4" style="border: 1px solid black; text-align: center; font-weight: bold;">
                Penilaian
            </td>

        </tr>

        <!-- Elemen -->
        <tr>
            <td colspan="2" style="border: 1px solid black; background-color: #f2f2f2; font-weight: bold;">
                Elemen akhlak beragama
            </td>
            <td style="border: 1px solid black; text-align: center; font-weight: bold;">MB</td>
            <td style="border: 1px solid black; text-align: center; font-weight: bold;">SB</td>
            <td style="border: 1px solid black; text-align: center; font-weight: bold;">BSH</td>
            <td style="border: 1px solid black; text-align: center; font-weight: bold;">SAB</td>
        </tr>

        <!-- Baris Isi 1 -->
        <tr>
            <td style="border-left: 1px solid black; border-bottom: 1px solid black;"></td>
            <td style="border: 1px solid black;">
                Mengenal sifat-sifat utama Tuhan Yang Maha Esa bahwa Dia adalah Sang Pencipta yang Maha Pengasih dan Maha Penyayang dan mengenali kebaikan dirinya sebagai cerminan sifat Tuhan.
            </td>
            <td style="border: 1px solid black;"></td>
            <td style="border: 1px solid black;"></td>
            <td style="border: 1px solid black;"></td>
            <td style="border: 1px solid black;"></td>
        </tr>

        <!-- Baris Isi 2 -->
        <tr>
            <td style="border-left: 1px solid black; border-bottom: 1px solid black;"></td>
            <td style="border: 1px solid black;">
                Mengenal unsur-unsur utama agama/kepercayaan (ajaran, ritual keagamaan, kitab suci, dan orang suci/utusan Tuhan YME).
            </td>
            <td style="border: 1px solid black;"></td>
            <td style="border: 1px solid black;"></td>
            <td style="border: 1px solid black;"></td>
            <td style="border: 1px solid black;"></td>
        </tr>

        <!-- Baris Isi 3 -->
        <tr>
            <td style="border-left: 1px solid black; border-bottom: 1px solid black;"></td>
            <td style="border: 1px solid black;">
                Terbiasa melaksanakan ibadah sesuai ajaran agama/kepercayaannya.
            </td>
            <td style="border: 1px solid black;"></td>
            <td style="border: 1px solid black;"></td>
            <td style="border: 1px solid black;"></td>
            <td style="border: 1px solid black;"></td>
        </tr>

        <!-- Catatan Proses -->
        <tr>
            <td colspan="6" style="border: 1px solid black; text-align: center; padding: 6px;">
                <strong>Catatan Proses</strong>
            </td>
        </tr>
    </table>






    <!-- TTD PJ -->
    @include('includes.components.ttd_pj_raport_merdeka')

    {{-- PAGE BREAK --}}
	<div class="new-page"></div>

    <!-- Keterangan Penilaian -->
    <div class="font-size-12" style="margin-top: 16px;">
        <p style="font-weight: bold; margin: 0px;">Keterangan:</p>
        <p style="margin: 0px;">Dimensi, elemen dan subelemen yang dinilai adalah yang dilakukan pada program pemberdayaan dan
            atau keterampilan berbasis profil pelajar Pancasila.
        </p>
        <p style="margin: 0px; margin-top: 12px;">Centang pada kolom, jika pada subelemen: </p>
        <p style="margin: 0px; margin-top: 4px;"><b>MB (Mulai Berkembang)</b>, bila peserta didik melakukannya harus dengan bimbingan atau
            dicontohkan oleh guru.
        </p>
        <p style="margin: 0px; margin-top: 4px;"><b>SB (Sedang Berkembang)</b>, bila peserta didik melakukannya masih harus diingatkan atau
        dibantu oleh guru.</p>
        <p style="margin: 0px; margin-top: 4px;"><b>BSH (Berkembang Sesuai Harapan)</b>, bila peserta didik sudah dapat melakukannya secara
            mandiri dapat konsisten tanpa harus diingatkan atau dicontohkan oleh guru.</p>
        <p style="margin: 0px; margin-top: 4px;"><b>SAB (Sangat Berkembang)</b>, bila peserta didik sudah dapat melakukannya secara mandiri dan
            sudah dapat membantu temannya yang belum mencapai kemampuan sesuai dengan indikator
            yang diharapkan.
        </p>
    </div>

    {{-- PAGE BREAK --}}
	<div class="new-page"></div>

    @include('includes.components.data_siswa_raport_merdeka')

    <!-- Catatan -->
    @include('includes.components.catatan_perkembangan_raport_merdeka')

    @include('includes.components.ttd_akhir_raport_merdeka')
</body>
</html>