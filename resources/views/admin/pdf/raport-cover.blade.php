<!DOCTYPE html>
<html>
<head>
	<title>Cover Raport</title>
	<style>
		body{
			font-family: 'Times New Roman', Times, serif;
		}
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
	
</head>
<body style="padding-top: 0; margin-top:0;">

	<div class="text-center">
		<p class="font-bold" style="font-size: 60px; margin-top: 140px; margin-bottom: 0px; color: #1f497d">RAPOR</p>
		<p class="font-bold" style="font-size: 32px; margin-top: 0px; color: #4f81bd">
			{{$kelas_wb->wb_detail->paket_kelas->nama}}
		</p>
	</div>

	<div class="text-center" style="margin-top: 50px;">
		<h3 style="color: #1f497d">PKBM GENERASI JUARA</h3>
		<img src="{{ public_path('/images/logo.jpeg') }}" style="height: 100px;">
	</div>

	<div class="text-center" style="margin-top: 145px;">
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
				{{$kelas_wb->wb_detail->nis}} / {{$kelas_wb->wb_detail->nisn}}									
			</strong>
		</div>
	</div>

	<div class="text-center" style="margin-top: 140px;">
		<strong style="font-size: 16px;">PKBM GENERASI JUARA</strong>
		<p class="font-size-12">
			JL. Arjuna Raya No.89 Depok II Tengah Kel. Mekar Jaya Kec. Sukmajaya - Depok <br>
			Tel. 087784164812/087882525896 | Web: generasijuara.sch.id, mail :admin@generasijuara.sch.id
		</p>
	</div>


	{{-- PAGE BREAK --}}
	<div class="new-page"></div>


	<div style="margin: auto; margin-top: 45px; background: #ffc000; height: 35px; width: 80%;"></div>

	<div class="text-center" style="margin-top: 50px; margin-bottom: 50px;">
		<h3 class="mb-0">RAPOR</h3>
		<p style="margin-top: 5px;">{{$kelas_wb->wb_detail->paket_kelas->nama}}</p>
	</div>

	<div style="margin-left: 70px; margin-right: 80px;">
		<table style="width: 100%;">
			<tr>
				<td class="font-size-12" style="padding: 10px 10px 10px;" width="20%">Nama Satuan Pendidikan </td>
				<td class="font-size-12" width="5%">: </td>
				<td class="font-size-12 letter-spacing-sm border-bottom-sm" width="40%" style="border-bottom:solid 1px rgb(161, 161, 161); padding: 10px 10px 10px 0;">
					<b>PKBM GENERASI JUARA</b>
				</td>
			</tr>
			<tr>
				<td class="font-size-12" style="padding: 10px 10px 10px;" width="20%">NPSN </td>
				<td class="font-size-12" width="5%">: </td>
				<td class="font-size-12" style="border-bottom:solid 1px rgb(161, 161, 161); padding: 10px 10px 10px 0;" width="40%">
					P9970355
				</td>
			</tr>
	
			<tr>
				<td class="font-size-12" style="padding: 10px 10px 10px;">Alamat Satuan Pendidikan </td>
				<td class="font-size-12" width="5%">: </td>
				<td class="font-size-12 border-bottom-sm" style="border-bottom:solid 1px rgb(161, 161, 161); padding: 10px 10px 10px 0;">
					JL. Arjuna Raya No.89 Depok II
				</td>
			</tr>

			<tr>
				<td class="font-size-12" style="padding: 10px 10px 10px;"></td>
				<td class="font-size-12" width="5%">: </td>
				<td class="font-size-12 border-bottom-sm" style="border-bottom:solid 1px rgb(161, 161, 161); padding: 15px 15px 15px 0;"></td>
			</tr>
			<tr>
				<td class="font-size-12" style="padding: 10px 10px 10px;"></td>
				<td class="font-size-12" width="5%">: </td>
				<td class="font-size-12 border-bottom-sm" style="border-bottom:solid 1px rgb(161, 161, 161); padding: 15px 15px 15px 0;"></td>
			</tr>
	
			<tr>
				<td class="font-size-12" style="padding: 10px 10px 10px;">Telepon </td>
				<td class="font-size-12" width="5%">: </td>
				<td class="font-size-12 letter-spacing-sm" style="border-bottom:solid 1px rgb(161, 161, 161); padding: 10px 10px 10px 0;">
					087784164812 / 087882525896
				</td>
			</tr>

			<tr>
				<td class="font-size-12" style="padding: 10px 10px 10px;">Kelurahan </td>
				<td class="font-size-12" width="5%">: </td>
				<td class="font-size-12 border-bottom-sm" style="border-bottom:solid 1px rgb(161, 161, 161); padding: 10px 10px 10px 0;">
					Mekar Jaya
				</td>
			</tr>

			<tr>
				<td class="font-size-12" style="padding: 10px 10px 10px;">Kecamatan </td>
				<td class="font-size-12" width="5%">: </td>
				<td class="font-size-12 border-bottom-sm" style="border-bottom:solid 1px rgb(161, 161, 161); padding: 10px 10px 10px 0;">
					Sukmajaya
				</td>
			</tr>

			<tr>
				<td class="font-size-12" style="padding: 10px 10px 10px;">Kabupaten/Kota </td>
				<td class="font-size-12" width="5%">: </td>
				<td class="font-size-12 border-bottom-sm" style="border-bottom:solid 1px rgb(161, 161, 161); padding: 10px 10px 10px 0;">
					Depok
				</td>
			</tr>

			<tr>
				<td class="font-size-12" style="padding: 10px 10px 10px;">Provinsi </td>
				<td class="font-size-12" width="5%">: </td>
				<td class="font-size-12 border-bottom-sm" style="border-bottom:solid 1px rgb(161, 161, 161); padding: 10px 10px 10px 0;">
					Jawa Barat
				</td>
			</tr>

			<tr>
				<td class="font-size-12" style="padding: 10px 10px 10px;">Website </td>
				<td class="font-size-12" width="5%">: </td>
				<td class="font-size-12 border-bottom-sm" style="border-bottom:solid 1px rgb(161, 161, 161); padding: 10px 10px 10px 0;">
					<b>generasijuara.sch.id</b>
				</td>
			</tr>

			<tr>
				<td class="font-size-12" style="padding: 10px 10px 10px;">Email </td>
				<td class="font-size-12" width="5%">: </td>
				<td class="font-size-12 border-bottom-sm" style="border-bottom:solid 1px rgb(161, 161, 161); padding: 10px 10px 10px 0;">
					<b>admin@generasijuara.sch.id</b>
				</td>
			</tr>

			<tr>
				<td class="font-size-12" style="padding: 10px 10px 10px;">Facebook </td>
				<td class="font-size-12" width="5%">: </td>
				<td class="font-size-12 border-bottom-sm" style="border-bottom:solid 1px rgb(161, 161, 161); padding: 10px 10px 10px 0;">
					<b>http://www.facebook.com/pkbmgenerasijuara/</b>
				</td>
			</tr>

			<tr>
				<td class="font-size-12" style="padding: 10px 10px 10px;">Twiter </td>
				<td class="font-size-12" width="5%">: </td>
				<td class="font-size-12 border-bottom-sm" style="border-bottom:solid 1px rgb(161, 161, 161); padding: 10px 10px 10px 0;">
					<b>-</b>
				</td>
			</tr>

			<tr>
				<td class="font-size-12" style="padding: 10px 10px 10px;"></td>
				<td class="font-size-12" width="5%">: </td>
				<td class="font-size-12 border-bottom-sm" style="border-bottom:solid 1px rgb(161, 161, 161); padding: 15px 15px 15px 0;"></td>
			</tr>
			<tr>
				<td class="font-size-12" style="padding: 10px 10px 10px;"></td>
				<td class="font-size-12" width="5%">: </td>
				<td class="font-size-12 border-bottom-sm" style="border-bottom:solid 1px rgb(161, 161, 161); padding: 15px 15px 15px 0;"></td>
			</tr>
			<tr>
				<td class="font-size-12" style="padding: 10px 10px 10px;"></td>
				<td class="font-size-12" width="5%">: </td>
				<td class="font-size-12 border-bottom-sm" style="border-bottom:solid 1px rgb(161, 161, 161); padding: 15px 15px 15px 0;"></td>
			</tr>
			<tr>
				<td class="font-size-12" style="padding: 10px 10px 10px;"></td>
				<td class="font-size-12" width="5%">: </td>
				<td class="font-size-12 border-bottom-sm" style="border-bottom:solid 1px rgb(161, 161, 161); padding: 15px 15px 15px 0;"></td>
			</tr>
		</table>
	</div>

	<div style="margin: auto; margin-top: 80px; background: #ffc000; height: 35px; width: 80%;"></div>

	
	{{-- PAGE BREAK --}}
	<div class="new-page"></div>


	<div class="text-center">
		<h4>IDENTITAS PESERTA DIDIK</h4>
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
					{{$kelas_wb->wb_detail->nis}} / {{$kelas_wb->wb_detail->nisn}}
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
						Kepala PKBM GENERASI JUARA <br>
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


	<div style="margin: auto; width: 80%; padding: 15px 0; background: #ffc000; text-align: center;">
		<b>PETUNJUK PENGGUNAAN RAPOR</b>
	</div>

	<div style="margin-left: 85px; margin-right: 90px;">
		<p class="font-size-12" style="text-align: justify; line-height: 1.6; margin-top: 25px;">
			Rapor merupakan ringkasan hasil penilaian terhadap seluruh aktivitas pembelajaran yang dilakukan peserta didik dalam satu paket kompetensi. Rapor dipergunakan selama peserta didik mengikuti seluruh program pembelajaran pendidikan kesetaraan.
		</p>

		<p class="font-size-12" style="margin-top: 25px;">
			<b>Berikut petunjuk pengisian rapor.</b> <br>
			<ol class="petunjuk-pengisian font-size-12" style="padding-left: 1.3em;">
				<li>Identitas satuan pendidikan diisi dengan data yang sesuai dengan keberadaan satuan pendidikan nonformal penyelenggara pendidikan kesetaraan.</li>
				<li>Keterangan tentang diri peserta didik diisi lengkap.</li>
				<li>Rapor harus dilengkapi dengan pas foto berwarna (3 x 4).</li>
				<li>Sikap spiritual dan sikap sosial diisi dengan predikat (Sangat Baik, Baik, Cukup, atau Kurang) dan dilengkapi dengan deskripsi berdasarkan rangkuman hasil penilaian sikap dari semua tutor mata pelajaran, dan tutor penanggungjawab rombongan belajar.</li>
				<li>Deskripsi sikap spiritual dan sikap sosial ditulis menggunakan kalimat positif yang memotivasi untuk butir-butir nilai sikap yang sangat baik dan/atau kurang baik.</li>
				<li>Nilai KKM diisikan pada setiap mata pelajaran. KKM telah ditetapkan dalam dokumen Kurikulum Tingkat Satuan Pendidikan (KTSP).</li>
				<li>Kolom SKK diisi bobot SKK sesuai dengan pengalokasian atau distribusi SKK yang ditetapkan oleh satuan pendidikan dalam dokumen KTSP.</li>
				<li>Kolom nilai modul pada pengetahuan dan keterampilan ditulis dalam bentuk bilangan bulat pada skala 0-100. Nilai modul pengetahuan merupakan nilai gabungan dari penugasan capaian pengetahuan dan ujian modul. Sedangkan nilai modul keterampilan merupakan nilai rata-rata penugasan capaian keterampilan.</li>
				<li>Kolom predikat pada pengetahuan dan keterampilan diisi berdasarkan interval predikat (D, C, B atau A) yang ditetapkan satuan pendidikan.</li>
				<li>Kolom predikat pada ekstrakurikuler (bagi satuan pendidikan yang menyelenggarakan) diisi dengan Sangat Baik, Baik, Cukup, Kurang, yang kriterianya ditetapkan oleh satuan pendidikan. Kolom deskripsi diisi dengan penjelasan sikap dan kecakapan yang dicapai.</li>
				<li>Kolom jenis kegiatan diisi dengan kegiatan yang diikuti oleh peserta didik dalam bidang akademik dan non akademik pada kegiatan yang berkaitan dengan satuan pendidikan pada semester berjalan. Contoh: Lomba Cerdas Cermat Warga Belajar, Jambore Pendidikan Kesetaraan. Kolom prestasi diisi dengan prestasi tingkat wilayah. Contoh: Juara II Tingkat Kabupaten, Juara I Tingkat Provinsi, sebagai peserta, sebagai panitia, dll.</li>
				<li>Catatan penanggungjawab rombongan belajar (rombel) diisi dengan saran-saran bagi peserta didik dan orang tua untuk diperhatikan.</li>
				<li>Tanggapan orang tua/wali adalah komentar atas pencapaian hasil belajar peserta didik.</li>
			</ol>
		</p>
	</div>

	<div style="margin: auto; margin-top: 60px; background: #ffc000; height: 35px; width: 80%;"></div>

</body>
</html>