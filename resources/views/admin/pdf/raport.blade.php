<!DOCTYPE html>
<html>
<head>
	<title>Raport</title>
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
			border-bottom:solid 1px #DDD;
		}
		.table-collapse{
			border-collapse: collapse;
		}
		.mapel-row >td:first-child{
			text-align: center;
		}
		.mapel-row > td{
			padding: 5px;
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
	</style>
	
</head>
<body style="padding-top: 0;margin-top:0; margin-left: 50px; margin-right: 50px;">
	@php
		$alphabet = range('A', 'Z');
		$alamat = "JL. Arjuna Raya No.89 Depok II Tengah Kel. Mekar Jaya Kec. Sukmajaya - Depok";
	@endphp
	<div class="row">
		<div class="col-md-7">
			<table style="width: 99%;">
				<tr>
					<td class="font-size-9" style="padding: 3px 10px 3px;" width="23%">Nama Satuan Pendidikan </td>
					<td class="font-size-9" width="5%">: </td>
					<td class="font-size-9 letter-spacing-sm border-bottom-sm" width="40%" style="border-bottom:solid 1px #DDD; padding: 3px 10px 3px 0;">
							<b>PKBM GENERASI JUARA</b>
					</td>
					<td >

					</td>
					<td width="27%" class="font-size-9 letter-spacing-sm border-bottom-sm">
						<b>{{@$kelas_wb->kelas_detail->paket_kelas->nama}}</b>
					</td>
				</tr>
				<tr>
					<td class="font-size-9" style="padding: 3px 10px 3px;" width="20%" rowspan="2">Alamat </td>
					<td class="font-size-9" width="5%" rowspan="2">: </td>
					<td class="font-size-9" style="border-bottom:solid 1px #DDD; padding: 3px 10px 3px 0;" width="40%" rowspan="2">{{$alamat}}</td>
					<td rowspan="2"></td>
					<td width="27%" class="font-size-9 border-bottom-sm">
						Tingkatan/Setara Kls.
						<span>
							&ensp;&nbsp; :
						</span>
						<span class="letter-spacing-sm">
							{{$tingkatan}}/{{$kelas_romawi}}
						</span>
					</td>
				</tr>

				@if(!empty($kelas_wb->kelas_detail->jurusan))
				<tr>
					<td width="27%" class="font-size-9 border-bottom-sm">
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
					<td width="27%" class="font-size-9 border-bottom-sm">
						<span style="margin-left:56px;"></span>
						<span class="letter-spacing-sm"></span>
					</td>
				</tr>
				@endif

				<tr>
					<td class="font-size-9" style="padding: 3px 10px 3px;">Nama Peserta Didik </td>
					<td class="font-size-9" width="5%">: </td>
					<td class="font-size-9 letter-spacing-sm border-bottom-sm" style="border-bottom:solid 1px #DDD; padding: 3px 10px 3px 0;"><b>{{@$kelas_wb->wb_detail->nama}}</b></td>
					<td >

					</td>
					<td width="27%" class="font-size-9 border-bottom-sm">
						Paket Kompetensi
						<span style="margin-left:15px;">
							&nbsp;:
						</span>
						<span class="letter-spacing-sm">
							{{$kompetensi}}
						</span>
					</td>
				</tr>

				<tr>
					<td class="font-size-9" style="padding: 3px 10px 3px;">Nomor Induk/NISN </td>
					<td class="font-size-9" width="5%">: </td>
					<td class="font-size-9" style="border-bottom:solid 1px #DDD; padding: 3px 10px 3px 0;">{{@$kelas_wb->wb_detail->nis}} / {{@$kelas_wb->wb_detail->nisn}}</td>
					<td >

					</td>
					<td width="27%" class="font-size-9 border-bottom-sm">
						Tahun Pelajaran
						<span style="margin-left:25px;">
							&emsp;:
						</span>
						<span class="">
							{{@$kelas_wb->kelas_detail->tahun_akademik->tahun_ajar}}
						</span>
					</td>
				</tr>
			</table>

		</div>
		<div class="col-md-12"><br><br></div>
		<div class="col-md-12 mt-3" style="background: #DDD;text-align: center;">
			<strong>
				CAPAIAN HASIL BELAJAR												
			</strong>
		</div>
		<div class="col-md-12"><br></div>
		{{-- Sikap --}}
		<div class="col-md-12">
			<b>A. Sikap</b>
		</div>
		<div class="col-md-12" style="padding: 15px 30px 30px 30px;">
			<b>1. Sikap Spiritual</b>
			<table class="table-collapse table-sikap" border="1"  width="100%">
				<tr class="text-center font-size-9 letter-spacing-sm">
					<td width="20%" style="padding: 10px">Predikat</td>
					<td style="">Deskripsi</td>
				</tr>

				<tr>
					<td class="font-predikat text-center" style="padding: 30px;">
						{{$nilai['sikap']['spiritual']}}
					</td>
					<td class="font-size-14 line-height-sm" style="padding: 20px 10px 20px 20px; text-align: justify;">
						{{$nilai['sikap']['spiritual_desc']}}
					</td>
				</tr>
			</table>

		</div>
		<div class="col-md-12" style="padding: 15px 30px 30px 30px;">
			<b>2. Sikap Sosial</b>
			<table class="table-collapse table-sikap" border="1"  width="100%">
				<tr class="text-center font-size-9 letter-spacing-sm">
					<td width="20%" style="padding: 10px">Predikat</td>
					<td style="">Deskripsi</td>
				</tr>

				<tr>
					<td class="font-predikat text-center" style="padding: 30px;">
						{{$nilai['sikap']['sosial']}}
					</td>
					<td class="font-size-14 line-height-sm" style="padding: 20px 10px 20px 20px; text-align: justify;">
						{{$nilai['sikap']['sosial_desc']}}
					</td>
				</tr>
			</table>
		</div>
		{{-- Page 2 --}}
		<div class="col-md-7 new-page">
			<table style="width: 99%;">
				<tr>
					<td class="font-size-9" style="padding: 3px 10px 3px;" width="23%">Nama Satuan Pendidikan </td>
					<td class="font-size-9" width="5%">: </td>
					<td class="font-size-9 letter-spacing-sm border-bottom-sm" width="40%" style="border-bottom:solid 1px #DDD; padding: 3px 10px 3px 0;">
							<b>PKBM GENERASI JUARA</b>
					</td>
					<td >

					</td>
					<td width="27%" class="font-size-9 letter-spacing-sm border-bottom-sm">
						<b>{{@$kelas_wb->kelas_detail->paket_kelas->nama}}</b>
					</td>
				</tr>
				<tr>
					<td class="font-size-9" style="padding: 3px 10px 3px;" width="20%" rowspan="2">Alamat </td>
					<td class="font-size-9" width="5%" rowspan="2">: </td>
					<td class="font-size-9" style="border-bottom:solid 1px #DDD; padding: 3px 10px 3px 0;" width="40%" rowspan="2">{{$alamat}}</td>
					<td rowspan="2"></td>
					<td width="27%" class="font-size-9 border-bottom-sm">
						Tingkatan/Setara Kls.
						<span>
							&ensp;&nbsp; :
						</span>
						<span class="letter-spacing-sm">
							{{$tingkatan}}/{{$kelas_romawi}}
						</span>
					</td>
				</tr>

				@if(!empty($kelas_wb->kelas_detail->jurusan))
				<tr>
					<td width="27%" class="font-size-9 border-bottom-sm">
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
					<td width="27%" class="font-size-9 border-bottom-sm">
						<span style="margin-left:56px;"></span>
						<span class="letter-spacing-sm"></span>
					</td>
				</tr>
				@endif

				<tr>
					<td class="font-size-9" style="padding: 3px 10px 3px;">Nama Peserta Didik </td>
					<td class="font-size-9" width="5%">: </td>
					<td class="font-size-9 letter-spacing-sm border-bottom-sm" style="border-bottom:solid 1px #DDD; padding: 3px 10px 3px 0;"><b>{{@$kelas_wb->wb_detail->nama}}</b></td>
					<td >

					</td>
					<td width="27%" class="font-size-9 border-bottom-sm">
						Paket Kompetensi
						<span style="margin-left:15px;">
							&nbsp;:
						</span>
						<span class="letter-spacing-sm">
							{{$kompetensi}}
						</span>
					</td>
				</tr>

				<tr>
					<td class="font-size-9" style="padding: 3px 10px 3px;">Nomor Induk/NISN </td>
					<td class="font-size-9" width="5%">: </td>
					<td class="font-size-9" style="border-bottom:solid 1px #DDD; padding: 3px 10px 3px 0;">{{@$kelas_wb->wb_detail->no_induk}} / {{@$kelas_wb->wb_detail->nisn}}</td>
					<td >

					</td>
					<td width="27%" class="font-size-9 border-bottom-sm">
						Tahun Pelajaran
						<span style="margin-left:25px;">
							&emsp;:
						</span>
						<span class="">
							{{@$kelas_wb->kelas_detail->tahun_akademik->tahun_ajar}}
						</span>
					</td>
				</tr>
			</table>

		</div>
		<div class="col-md-12"><br><br></div>
		<div class="col-md-12 mt-3" style="background: #DDD;text-align: center;">
			<strong>
				CAPAIAN HASIL BELAJAR												
			</strong>
		</div>
		<div class="col-md-12"><br></div>
		{{-- Pengetahuan --}}
		<div class="col-md-12">
			<b>B. Pengetahuan</b>
			<table width="98%" border="1" class="table-collapse table-nilai font-size-9">
				<tr class="text-center">
					<td rowspan="2">No</td>
					<td rowspan="2" width="30%">Mata Pelajaran</td>
					<td rowspan="2">SKK</td>
					<td rowspan="2">KKM</td>
					<td colspan="3" style="padding:10px 0 10px 0" width="27%">Nilai</td>
					<td colspan="3" width="27%">Predikat</td>
					<td rowspan="2">Rata-Rata Semester {{ $semester == 1 ? 'Ganjil' : 'Genap' }}</td>
				</tr>
				<tr class="text-center">
					@for ($i = $data_modul['start_from']; $i < $data_modul['start_from'] + $data_modul['maximum_modul']; $i++)
						<td style="padding:10px 0 10px 0">Modul {{ $i }}</td>
					@endfor
					@if ($data_modul['maximum_modul'] == 2)
						<td style="padding:10px 0 10px 0; background: #DDD;">
							<div style="visibility: hidden;">Modul X</div>
						</td>
					@endif

					@for ($i = $data_modul['start_from']; $i < $data_modul['start_from'] + $data_modul['maximum_modul']; $i++)
						<td style="padding:10px 0 10px 0">Modul {{ $i }}</td>
					@endfor
					@if ($data_modul['maximum_modul'] == 2)
						<td style="padding:10px 0 10px 0; background: #DDD;">
							<div style="visibility: hidden;">Modul X</div>
						</td>
					@endif
				</tr>
				<tr>
					<td colspan="2" style="text-align: left; padding: 5px 0 5px 5px"><b >Kelompok Umum</b></td>
					<td colspan="2"></td>
					<td colspan="7" style="background: #DDD;"></td>
				</tr>
				@php
					$urutan = 0;
				@endphp
				@foreach($nilai['pengetahuan']['kelompok_umum'] as $key => $n)
				@php
					$urutan++;
				@endphp
				<tr class="mapel-row">
					<td style="text-align: center;">{{$key+1}}.</td>
					<td style="text-align: left;">{{$n['mp_name']}}</td>
					<td style="text-align: center;">{{$n['skk']}}</td>
					<td style="text-align: center;">{{$n['kkm']}}</td>
					@for($i=1; $i<=3; $i++)
						@if($i <= $n['jumlah_modul'])
							<td style="text-align: center; {{ ($n['nilai_'.$i]) < 70 ? (($n['nilai_'.$i] != '-') ? 'color: #FF0000;' : '') : '' }}">{{$n['nilai_'.$i]}}</td>
						@else
							<td style="text-align: center; background: #DDD;"></td>
						@endif
					@endfor
					@for($i=1; $i<=3; $i++)
						@if($i <= $n['jumlah_modul'])
							<td style="text-align: center; {{ ($n['predikat_'.$i]) == 'D' ? 'color: #FF0000;':'' }}">{{$n['predikat_'.$i]}}</td>
						@else
							<td style="text-align: center; background: #DDD;"></td>
						@endif
					@endfor
					<td style="text-align: center;">{{$n['avg']}}</td>
				</tr>
				@endforeach

				{{-- Jika tingkatan 1 --}}
				@if ($tingkatan == 1)
				@php
					$urutan++;
				@endphp
				<tr class="mapel-row">
					<td style="text-align: center;">{{$urutan}}.</td>
					<td style="text-align: left;">Ilmu Pengetahuan Alam</td>
					<td style="text-align: center;"></td>
					<td style="text-align: center;"></td>
					<td style="text-align: center;" colspan="7" rowspan="2">
						Sesuai kurikulum 2013 Program Paket A (setara SD), tidak ada pembelajaran mata pelajaran IPA dan IPS di Tingkatan I (setara kelas I s/d kelas III)
					</td>
				</tr>
				@php
					$urutan++;
				@endphp
				<tr class="mapel-row">
					<td style="text-align: center;">{{$urutan}}.</td>
					<td style="text-align: left;">Ilmu Pengetahuan Sosial</td>
					<td style="text-align: center;"></td>
					<td style="text-align: center;"></td>
				</tr>
				@endif

				<!-- mia -->
				@if(count($nilai['pengetahuan']['mia']))
				<tr>
					<td colspan="2" style="text-align: left; padding: 5px 0 5px 5px"><b >Peminatan Matematika dan Ilmu Alam (MIA)</b></td>
					<td colspan="2"></td>
					<td colspan="7" style="background: #DDD;"></td>
				</tr>
				@endif
				@foreach($nilai['pengetahuan']['mia'] as $key => $n)
				@php
					$urutan++;
				@endphp
				<tr class="mapel-row">
					<td style="text-align: center;">{{$urutan}}.</td>
					<td style="text-align: left;">{{$n['mp_name']}}</td>
					<td style="text-align: center;">{{$n['skk']}}</td>
					<td style="text-align: center;">{{$n['kkm']}}</td>
					@for($i=1; $i<=3; $i++)
						@if($i <= $n['jumlah_modul'])
							<td style="text-align: center;">{{$n['nilai_'.$i]}}</td>
						@else
							<td style="text-align: center; background: #DDD;"></td>
						@endif
					@endfor
					@for($i=1; $i<=3; $i++)
						@if($i <= $n['jumlah_modul'])
							<td style="text-align: center;">{{$n['predikat_'.$i]}}</td>
						@else
							<td style="text-align: center; background: #DDD;"></td>
						@endif
					@endfor
					<td style="text-align: center;">{{$n['avg']}}</td>
				</tr>
				@endforeach
				<!-- iis -->
				@if(count($nilai['pengetahuan']['iis']))
				<tr>
					<td colspan="2" style="text-align: left; padding: 5px 0 5px 5px"><b >Peminatan Ilmu-Ilmu Sosial (IIS)</b></td>
					<td colspan="2"></td>
					<td colspan="7" style="background: #DDD;"></td>
				</tr>
				@endif
				@foreach($nilai['pengetahuan']['iis'] as $key => $n)
				@php
					$urutan++;
				@endphp
				<tr class="mapel-row">
					<td style="text-align: center;">{{$urutan}}.</td>
					<td style="text-align: left;">{{$n['mp_name']}}</td>
					<td style="text-align: center;">{{$n['skk']}}</td>
					<td style="text-align: center;">{{$n['kkm']}}</td>
					@for($i=1; $i<=3; $i++)
						@if($i <= $n['jumlah_modul'])
							<td style="text-align: center;">{{$n['nilai_'.$i]}}</td>
						@else
							<td style="text-align: center; background: #DDD;"></td>
						@endif
					@endfor
					@for($i=1; $i<=3; $i++)
						@if($i <= $n['jumlah_modul'])
							<td style="text-align: center;">{{$n['predikat_'.$i]}}</td>
						@else
							<td style="text-align: center; background: #DDD;"></td>
						@endif
					@endfor
					<td style="text-align: center;">{{$n['avg']}}</td>
				</tr>
				@endforeach
				<tr >
					<td colspan="2" style="text-align: left; padding: 5px 0 5px 5px"><b>Kelompok Khusus</b></td>
					<td colspan="2"></td>
					<td colspan="7"></td>
				</tr>
				<!-- pemberdayaan -->
				@php 
					$urutan++;
					$urutanPemberdayaan = 0;
				@endphp
				<tr class="mapel-row">
					<td style="text-align: center;">{{$urutan}}.</td>
					<td style="text-align: left;">Pemberdayaan</td>
					<td colspan="2"></td>
					<td colspan="7" style="background: #DDD;"></td>
				</tr>
				@foreach($nilai['pengetahuan']['kelompok_khusus']['pemberdayaan'] as $k_mp => $n)
				<tr class="mapel-row">
					<td></td>
					<td style="text-align: left;">{{strtolower($alphabet[$urutanPemberdayaan])}}. {{@$n['mp_name']}}</td>
					<td style="text-align: center;">{{$n['skk']}}</td>
					<td style="text-align: center;">{{@$n['kkm']}}</td>
					<td style="text-align: center;" colspan="3">{{@$n['nilai_1']}}</td>
					<td style="text-align: center;" colspan="3">{{@$n['predikat_1']}}</td>
					<td style="text-align: center;">{{@$n['avg']}}</td>
				</tr>
				@php 
					$urutanPemberdayaan++;
				@endphp
				@endforeach	
				<!-- keterampilan -->
				@php 
					$urutan++;
				@endphp
				<tr class="mapel-row">
					<td style="text-align: center;">{{$urutan}}.</td>
					<td style="text-align: left;">Keterampilan</td>
					<td colspan="2"></td>
					<td colspan="7" style="background: #DDD;"></td>
				</tr>
				<tr class="mapel-row">
					<td></td>
					<td style="text-align: left;">a. Keterampilan Wajib</td>
					<td style="text-align: center;">{{$nilai['pengetahuan']['kelompok_khusus']['keterampilan_wajib']['skk']}}</td>
					<td style="text-align: center;">{{$nilai['pengetahuan']['kelompok_khusus']['keterampilan_wajib']['kkm']}}</td>
					<td style="text-align: center;" colspan="3">{{$nilai['pengetahuan']['kelompok_khusus']['keterampilan_wajib']['nilai']}}</td>
					<td style="text-align: center;" colspan="3">{{$nilai['pengetahuan']['kelompok_khusus']['keterampilan_wajib']['predikat']}}</td>
					<td style="text-align: center;">{{$nilai['pengetahuan']['kelompok_khusus']['keterampilan_wajib']['avg']}}</td>
				</tr>
				<tr class="mapel-row">
					<td></td>
					<td style="text-align: left;">b. Keterampilan Pilihan</td>
					<td colspan="2"></td>
					<td colspan="7" style="background: #DDD;"></td>
				</tr>
				@foreach($nilai['pengetahuan']['kelompok_khusus']['keterampilan_pilihan'] as $k_mp => $n)
				<tr class="mapel-row">
					<td></td>
					<td style="text-align: left;">{{$k_mp+1}}) {{@$n['mp_name']}}</td>
					<td style="text-align: center;">{{@$n['skk']}}</td>
					<td style="text-align: center;">{{@$n['kkm']}}</td>
					<td style="text-align: center;" colspan="3">{{@$n['nilai_1']}}</td>
					<td style="text-align: center;" colspan="3">{{@$n['predikat_1']}}</td>
					<td style="text-align: center;">{{@$n['avg']}}</td>
				</tr>
				@endforeach	
			</table>
		</div>
		{{-- Page 3 --}}
		<div class="col-md-7 new-page">
			<table style="width: 99%;">
				<tr>
					<td class="font-size-9" style="padding: 3px 10px 3px;" width="23%">Nama Satuan Pendidikan </td>
					<td class="font-size-9" width="5%">: </td>
					<td class="font-size-9 letter-spacing-sm border-bottom-sm" width="40%" style="border-bottom:solid 1px #DDD; padding: 3px 10px 3px 0;">
							<b>PKBM GENERASI JUARA</b>
					</td>
					<td >

					</td>
					<td width="27%" class="font-size-9 letter-spacing-sm border-bottom-sm">
						<b>{{@$kelas_wb->kelas_detail->paket_kelas->nama}}</b>
					</td>
				</tr>
				<tr>
					<td class="font-size-9" style="padding: 3px 10px 3px;" width="20%" rowspan="2">Alamat </td>
					<td class="font-size-9" width="5%" rowspan="2">: </td>
					<td class="font-size-9" style="border-bottom:solid 1px #DDD; padding: 3px 10px 3px 0;" width="40%" rowspan="2">{{$alamat}}</td>
					<td rowspan="2"></td>
					<td width="27%" class="font-size-9 border-bottom-sm">
						Tingkatan/Setara Kls.
						<span>
							&ensp;&nbsp; :
						</span>
						<span class="letter-spacing-sm">
							{{$tingkatan}}/{{$kelas_romawi}}
						</span>
					</td>
				</tr>

				@if(!empty($kelas_wb->kelas_detail->jurusan))
				<tr>
					<td width="27%" class="font-size-9 border-bottom-sm">
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
					<td width="27%" class="font-size-9 border-bottom-sm">
						<span style="margin-left:56px;"></span>
						<span class="letter-spacing-sm"></span>
					</td>
				</tr>
				@endif

				<tr>
					<td class="font-size-9" style="padding: 3px 10px 3px;">Nama Peserta Didik </td>
					<td class="font-size-9" width="5%">: </td>
					<td class="font-size-9 letter-spacing-sm border-bottom-sm" style="border-bottom:solid 1px #DDD; padding: 3px 10px 3px 0;"><b>{{@$kelas_wb->wb_detail->nama}}</b></td>
					<td >

					</td>
					<td width="27%" class="font-size-9 border-bottom-sm">
						Paket Kompetensi
						<span style="margin-left:15px;">
							&nbsp;:
						</span>
						<span class="letter-spacing-sm">
							{{$kompetensi}}
						</span>
					</td>
				</tr>

				<tr>
					<td class="font-size-9" style="padding: 3px 10px 3px;">Nomor Induk/NISN </td>
					<td class="font-size-9" width="5%">: </td>
					<td class="font-size-9" style="border-bottom:solid 1px #DDD; padding: 3px 10px 3px 0;">{{@$kelas_wb->wb_detail->no_induk}} / {{@$kelas_wb->wb_detail->nisn}}</td>
					<td >

					</td>
					<td width="27%" class="font-size-9 border-bottom-sm">
						Tahun Pelajaran
						<span style="margin-left:25px;">
							&emsp;:
						</span>
						<span class="">
							{{@$kelas_wb->kelas_detail->tahun_akademik->tahun_ajar}}
						</span>
					</td>
				</tr>
			</table>

		</div>
		<div class="col-md-12"><br><br></div>
		<div class="col-md-12 mt-3" style="background: #DDD;text-align: center;">
			<strong>
				CAPAIAN HASIL BELAJAR												
			</strong>
		</div>
		<div class="col-md-12"><br></div>
		{{-- Keterampilan --}}
		<div class="col-md-12">
			<b>C. Keterampilan</b>
			<table width="98%" border="1" class="table-collapse table-nilai font-size-9">
				<tr class="text-center">
					<td rowspan="2">No</td>
					<td rowspan="2" width="30%">Mata Pelajaran</td>
					<td rowspan="2">SKK</td>
					<td rowspan="2">KKM</td>
					<td colspan="3" style="padding:10px 0 10px 0" width="27%">Nilai</td>
					<td colspan="3" width="27%">Predikat</td>
					<td rowspan="2">Rata-Rata Semester  {{ $semester == 1 ? 'Ganjil' : 'Genap' }}</td>
				</tr>
				<tr class="text-center">
					@for ($i = $data_modul['start_from']; $i < $data_modul['start_from'] + $data_modul['maximum_modul']; $i++)
						<td style="padding:10px 0 10px 0">Modul {{ $i }}</td>
					@endfor
					@if ($data_modul['maximum_modul'] == 2)
						<td style="padding:10px 0 10px 0; background: #DDD;">
							<div style="visibility: hidden;">Modul X</div>
						</td>
					@endif

					@for ($i = $data_modul['start_from']; $i < $data_modul['start_from'] + $data_modul['maximum_modul']; $i++)
						<td style="padding:10px 0 10px 0">Modul {{ $i }}</td>
					@endfor
					@if ($data_modul['maximum_modul'] == 2)
						<td style="padding:10px 0 10px 0; background: #DDD;">
							<div style="visibility: hidden;">Modul X</div>
						</td>
					@endif
				</tr>
				<tr>
					<td colspan="2" style="text-align: left; padding: 5px 0 5px 5px"><b >Kelompok Umum</b></td>
					<td colspan="2"></td>
					<td colspan="7" style="background: #DDD;"></td>
				</tr>
				@php
					$urutan = 0;
				@endphp
				@foreach($nilai['keterampilan']['kelompok_umum'] as $key => $n)
				@php
					$urutan++;
				@endphp
				<tr class="mapel-row">
					<td style="text-align: center;">{{$key+1}}.</td>
					<td style="text-align: left;">{{$n['mp_name']}}</td>
					<td style="text-align: center;">{{$n['skk']}}</td>
					<td style="text-align: center;">{{$n['kkm']}}</td>
					@for($i=1; $i<=3; $i++)
						@if($i <= $n['jumlah_modul'])
							<td style="text-align: center; {{ ($n['nilai_'.$i]) < 70 ? (($n['nilai_'.$i] != '-') ? 'color: #FF0000;' : '') : '' }}">{{$n['nilai_'.$i]}}</td>
						@else
							<td style="text-align: center; background: #DDD;"></td>
						@endif
					@endfor
					@for($i=1; $i<=3; $i++)
						@if($i <= $n['jumlah_modul'])
							<td style="text-align: center; {{ ($n['predikat_'.$i]) == 'D' ? 'color: #FF0000;':'' }}">{{$n['predikat_'.$i]}}</td>
						@else
							<td style="text-align: center; background: #DDD;"></td>
						@endif
					@endfor
					<td style="text-align: center;">{{$n['avg']}}</td>
				</tr>
				@endforeach

				{{-- Jika tingkatan 1 --}}
				@if ($tingkatan == 1)
				@php
					$urutan++;
				@endphp
				<tr class="mapel-row">
					<td style="text-align: center;">{{$urutan}}.</td>
					<td style="text-align: left;">Ilmu Pengetahuan Alam</td>
					<td style="text-align: center;"></td>
					<td style="text-align: center;"></td>
					<td style="text-align: center;" colspan="7" rowspan="2">
						Sesuai kurikulum 2013 Program Paket A (setara SD), tidak ada pembelajaran mata pelajaran IPA dan IPS di Tingkatan I (setara kelas I s/d kelas III)
					</td>
				</tr>
				@php
					$urutan++;
				@endphp
				<tr class="mapel-row">
					<td style="text-align: center;">{{$urutan}}.</td>
					<td style="text-align: left;">Ilmu Pengetahuan Sosial</td>
					<td style="text-align: center;"></td>
					<td style="text-align: center;"></td>
				</tr>
				@endif

				<!-- mia -->
				@if(count($nilai['keterampilan']['mia']))
				<tr>
					<td colspan="2" style="text-align: left; padding: 5px 0 5px 5px"><b >Peminatan Matematika dan Ilmu Alam (MIA)</b></td>
					<td colspan="2"></td>
					<td colspan="7" style="background: #DDD;"></td>
				</tr>
				@endif
				@foreach($nilai['keterampilan']['mia'] as $key => $n)
				@php
					$urutan++;
				@endphp
				<tr class="mapel-row">
					<td style="text-align: center;">{{$urutan}}.</td>
					<td style="text-align: left;">{{$n['mp_name']}}</td>
					<td style="text-align: center;">{{$n['skk']}}</td>
					<td style="text-align: center;">{{$n['kkm']}}</td>
					@for($i=1; $i<=3; $i++)
						@if($i <= $n['jumlah_modul'])
							<td style="text-align: center;">{{$n['nilai_'.$i]}}</td>
						@else
							<td style="text-align: center; background: #DDD;"></td>
						@endif
					@endfor
					@for($i=1; $i<=3; $i++)
						@if($i <= $n['jumlah_modul'])
							<td style="text-align: center;">{{$n['predikat_'.$i]}}</td>
						@else
							<td style="text-align: center; background: #DDD;"></td>
						@endif
					@endfor
					<td style="text-align: center;">{{$n['avg']}}</td>
				</tr>
				@endforeach
				<!-- iis -->
				@if(count($nilai['keterampilan']['iis']))
				<tr>
					<td colspan="2" style="text-align: left; padding: 5px 0 5px 5px"><b >Peminatan Ilmu-Ilmu Sosial (IIS)</b></td>
					<td colspan="2"></td>
					<td colspan="7" style="background: #DDD;"></td>
				</tr>
				@endif
				@foreach($nilai['keterampilan']['iis'] as $key => $n)
				@php
					$urutan++;
				@endphp
				<tr class="mapel-row">
					<td style="text-align: center;">{{$urutan}}.</td>
					<td style="text-align: left;">{{$n['mp_name']}}</td>
					<td style="text-align: center;">{{$n['skk']}}</td>
					<td style="text-align: center;">{{$n['kkm']}}</td>
					@for($i=1; $i<=3; $i++)
						@if($i <= $n['jumlah_modul'])
							<td style="text-align: center;">{{$n['nilai_'.$i]}}</td>
						@else
							<td style="text-align: center; background: #DDD;"></td>
						@endif
					@endfor
					@for($i=1; $i<=3; $i++)
						@if($i <= $n['jumlah_modul'])
							<td style="text-align: center;">{{$n['predikat_'.$i]}}</td>
						@else
							<td style="text-align: center; background: #DDD;"></td>
						@endif
					@endfor
					<td style="text-align: center;">{{$n['avg']}}</td>
				</tr>
				@endforeach
				<tr >
					<td colspan="2" style="text-align: left; padding: 5px 0 5px 5px"><b>Kelompok Khusus</b></td>
					<td colspan="2"></td>
					<td colspan="7"></td>
				</tr>
				<!-- pemberdayaan -->
				@php 
					$urutan++;
					$urutanPemberdayaan = 0;
				@endphp
				<tr class="mapel-row">
					<td style="text-align: center;">{{$urutan}}.</td>
					<td style="text-align: left;">Pemberdayaan</td>
					<td colspan="2"></td>
					<td colspan="7" style="background: #DDD;"></td>
				</tr>
				@foreach($nilai['keterampilan']['kelompok_khusus']['pemberdayaan'] as $k_mp => $n)
				<tr class="mapel-row">
					<td></td>
					<td style="text-align: left;">{{strtolower($alphabet[$urutanPemberdayaan])}}. {{@$n['mp_name']}}</td>
					<td style="text-align: center;">{{$n['skk']}}</td>
					<td style="text-align: center;">{{@$n['kkm']}}</td>
					<td style="text-align: center;" colspan="3">{{@$n['nilai_1']}}</td>
					<td style="text-align: center;" colspan="3">{{@$n['predikat_1']}}</td>
					<td style="text-align: center;">{{@$n['avg']}}</td>
				</tr>
				@php 
					$urutanPemberdayaan++;
				@endphp
				@endforeach	
				<!-- keterampilan -->
				@php 
					$urutan++;
				@endphp
				<tr class="mapel-row">
					<td style="text-align: center;">{{$urutan}}.</td>
					<td style="text-align: left;">Keterampilan</td>
					<td colspan="2"></td>
					<td colspan="7" style="background: #DDD;"></td>
				</tr>
				<tr class="mapel-row">
					<td></td>
					<td style="text-align: left;">a. Keterampilan Wajib</td>
					<td style="text-align: center;">{{$nilai['keterampilan']['kelompok_khusus']['keterampilan_wajib']['skk']}}</td>
					<td style="text-align: center;">{{$nilai['keterampilan']['kelompok_khusus']['keterampilan_wajib']['kkm']}}</td>
					<td style="text-align: center;" colspan="3">{{$nilai['keterampilan']['kelompok_khusus']['keterampilan_wajib']['nilai']}}</td>
					<td style="text-align: center;" colspan="3">{{$nilai['keterampilan']['kelompok_khusus']['keterampilan_wajib']['predikat']}}</td>
					<td style="text-align: center;">{{$nilai['keterampilan']['kelompok_khusus']['keterampilan_wajib']['avg']}}</td>
				</tr>
				<tr class="mapel-row">
					<td></td>
					<td style="text-align: left;">b. Keterampilan Pilihan</td>
					<td colspan="2"></td>
					<td colspan="7" style="background: #DDD;"></td>
				</tr>
				@foreach($nilai['keterampilan']['kelompok_khusus']['keterampilan_pilihan'] as $k_mp => $n)
				<tr class="mapel-row">
					<td></td>
					<td style="text-align: left;">{{$k_mp+1}}) {{@$n['mp_name']}}</td>
					<td style="text-align: center;">{{@$n['skk']}}</td>
					<td style="text-align: center;">{{@$n['kkm']}}</td>
					<td style="text-align: center;" colspan="3">{{@$n['nilai_1']}}</td>
					<td style="text-align: center;" colspan="3">{{@$n['predikat_1']}}</td>
					<td style="text-align: center;">{{@$n['avg']}}</td>
				</tr>
				@endforeach	
			</table>
		</div>
		{{-- Page 4 --}}
		<div class="col-md-7 new-page">
			<table style="width: 99%;">
				<tr>
					<td class="font-size-9" style="padding: 3px 10px 3px;" width="23%">Nama Satuan Pendidikan </td>
					<td class="font-size-9" width="5%">: </td>
					<td class="font-size-9 letter-spacing-sm border-bottom-sm" width="40%" style="border-bottom:solid 1px #DDD; padding: 3px 10px 3px 0;">
							<b>PKBM GENERASI JUARA</b>
					</td>
					<td >

					</td>
					<td width="27%" class="font-size-9 letter-spacing-sm border-bottom-sm">
						<b>{{@$kelas_wb->kelas_detail->paket_kelas->nama}}</b>
					</td>
				</tr>
				<tr>
					<td class="font-size-9" style="padding: 3px 10px 3px;" width="20%" rowspan="2">Alamat </td>
					<td class="font-size-9" width="5%" rowspan="2">: </td>
					<td class="font-size-9" style="border-bottom:solid 1px #DDD; padding: 3px 10px 3px 0;" width="40%" rowspan="2">{{$alamat}}</td>
					<td rowspan="2"></td>
					<td width="27%" class="font-size-9 border-bottom-sm">
						Tingkatan/Setara Kls.
						<span>
							&ensp;&nbsp; :
						</span>
						<span class="letter-spacing-sm">
							{{$tingkatan}}/{{$kelas_romawi}}
						</span>
					</td>
				</tr>

				@if(!empty($kelas_wb->kelas_detail->jurusan))
				<tr>
					<td width="27%" class="font-size-9 border-bottom-sm">
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
					<td width="27%" class="font-size-9 border-bottom-sm">
						<span style="margin-left:56px;"></span>
						<span class="letter-spacing-sm"></span>
					</td>
				</tr>
				@endif

				<tr>
					<td class="font-size-9" style="padding: 3px 10px 3px;">Nama Peserta Didik </td>
					<td class="font-size-9" width="5%">: </td>
					<td class="font-size-9 letter-spacing-sm border-bottom-sm" style="border-bottom:solid 1px #DDD; padding: 3px 10px 3px 0;"><b>{{@$kelas_wb->wb_detail->nama}}</b></td>
					<td >

					</td>
					<td width="27%" class="font-size-9 border-bottom-sm">
						Paket Kompetensi
						<span style="margin-left:15px;">
							&nbsp;:
						</span>
						<span class="letter-spacing-sm">
							{{$kompetensi}}
						</span>
					</td>
				</tr>

				<tr>
					<td class="font-size-9" style="padding: 3px 10px 3px;">Nomor Induk/NISN </td>
					<td class="font-size-9" width="5%">: </td>
					<td class="font-size-9" style="border-bottom:solid 1px #DDD; padding: 3px 10px 3px 0;">{{@$kelas_wb->wb_detail->no_induk}} / {{@$kelas_wb->wb_detail->nisn}}</td>
					<td >

					</td>
					<td width="27%" class="font-size-9 border-bottom-sm">
						Tahun Pelajaran
						<span style="margin-left:25px;">
							&emsp;:
						</span>
						<span class="">
							{{@$kelas_wb->kelas_detail->tahun_akademik->tahun_ajar}}
						</span>
					</td>
				</tr>
			</table>

		</div>
		<div class="col-md-12"><br><br></div>
		<div class="col-md-12 mt-3" style="background: #DDD;text-align: center;">
			<strong>
				CAPAIAN HASIL BELAJAR												
			</strong>
		</div>
		<div class="col-md-12"><br></div>
		{{-- Ekstra Kurikuler --}}
		<div class="col-md-12">
			<b>D. Ektra Kurikuler</b>
			<table width="98%" border="1" class="table-collapse table-nilai font-size-9">
				<tr class="text-center">
					<td width="3%" style="padding: 10px  10px 10px;">No</td>
					<td width="37%" style="padding: 10px  10px 10px;">Kegiatan Ekstra Kurikuler</td>
					<td style="padding: 10px  10px 10px;">Predikat</td>
					<td width="47%" style="padding: 10px  10px 10px;">Deskripsi</td>
				</tr>
				@forelse($ekstrakurikuler as $key => $ek)
				<tr class="mapel-row">
					<td style="text-align: center;">{{$key+1}}</td>
					<td style="text-align: left;;">{{$ek->kegiatan}}</td>
					<td class="text-center">{{$ek->predikat}}</td>
					<td style="padding-left:10px;">{{$ek->deskripsi}}</td>
				</tr>
				@empty
				<tr class="mapel-row">
					<td style="text-align: center;">-</td>
					<td style="text-align: left;;">-</td>
					<td class="text-center">-</td>
					<td style="padding-left:10px;">-</td>
				</tr>
				@endforelse
			</table>
		</div>
		{{-- Kegiatan --}}
		<div class="col-md-12" style="margin-top: 20px;">
			<b>E. Kegiatan</b>
			<table width="98%" border="1" class="table-collapse table-nilai font-size-9">
				<tr class="text-center">
					<td width="3%" style="padding: 10px  10px 10px;">No</td>
					<td width="40%" style="padding: 10px  10px 10px;">Jenis Kegiatan</td>
					<td  style="padding: 10px  10px 10px;">Prestasi</td>
				</tr>
				@forelse($nilai_kegiatan as $key => $nk)
				<tr class="mapel-row">
					<td style="text-align: center;">{{$key+1}}.</td>
					<td style="text-align: left;;">{{$nk->jenis_kegiatan}}</td>
					<td style="padding-left:10px;">{{$nk->prestasi}}</td>
				</tr>
				@empty
				<tr class="mapel-row">
					<td style="text-align: center;">-</td>
					<td style="text-align: left;;">-</td>
					<td style="padding-left:10px;">-</td>
				</tr>
				@endforelse
			</table>
		</div>
		{{-- Catatan Penanggung jawab --}}
		<div class="col-md-12" style="margin-top: 20px;">
			<b>F. Catatan Penanggungjawab Rombel</b>
			<table width="98%" border="1" class="table-collapse table-nilai font-size-9" >
				<tr style="">
					<td style="text-align: left;padding: 15px  10px 15px 10px; height: 30px ">
						{{ !empty($kelas_wb->catatan_pj_rombel) ? $kelas_wb->catatan_pj_rombel : $catatan_pj_rombel}}
					</td>
				</tr>
			</table>
		</div>
		{{-- Tangagpan orang tua --}}
		<div class="col-md-12" style="margin-top: 20px;">
			<b>G. Tanggapan Orang Tua/Wali</b>
			<table width="98%" border="1" class="table-collapse table-nilai font-size-9" >
				<tr style="">
					<td style="text-align: left;padding: 15px  10px 15px 10px; height: 30px ">
						{{@$kelas_wb->tanggapan_wali}}
					</td>
				</tr>
			</table>
		</div>
		{{-- Catatan (cuman muncul semester ganjil) --}}
		<div class="col-md-12" style="margin-top: 20px;">
			<b>H. Catatan</b>
			<table width="98%" border="1" class="table-collapse table-nilai font-size-9" >
				<tr style="">
					@if ($kelas_wb->kelas_detail->semester % 2 == 0)
					<td style="text-align: left;padding: 15px  10px 15px 10px; height: 30px ">
						{{@$catatan}}
					</td>
					@else	
					<td style="text-align: left;padding: 15px  10px 15px 10px; height: 30px ">
						{{@$kelas_wb->catatan}}
					</td>
					@endif
				</tr>
			</table>
		</div>

		{{-- Tanda Tangan --}}
		<div class="col-md-12" style="margin-top: 20px;">
			<table width="98%" class="table-collapse table-nilai font-size-9">
				<tr style="">
					<td width="27%">
						Mengetahui Orang Tua/Wali
					</td>
					<td>
					</td>
					<td width="30%">
						<span>
							Depok, {{ ($kelas_wb->kelas_detail->tahun_akademik->tgl_raport != NULL) ? Carbon\Carbon::parse($kelas_wb->kelas_detail->tahun_akademik->tgl_raport)->translatedFormat('d F Y') : Carbon\Carbon::now()->translatedFormat('d F Y') }}
						</span>
						<br>
						<span>
							Penanggung jawab Rombel
						</span>
					</td>
				</tr>
				<tr style="">
					<td class="border-bottom-sm">
					</td>
					<td>
					</td>
					<td >
						@if ($data_ttd && isset($data_ttd['url_ttd_pj']) && $data_ttd['url_ttd_pj'] != '' && filter_var($data_ttd['url_ttd_pj'], FILTER_VALIDATE_URL) !== false && \Illuminate\Support\Str::startsWith($data_ttd['url_ttd_pj'], url('/')))
							<img src="{{'data:image/png;base64,' . base64_encode(file_get_contents(@$data_ttd['url_ttd_pj']))}}" alt="image" style="height: 100px;"> <br>
						@else
							<img src="{{ public_path($data_ttd['url_ttd_pj'] ?? '/images/white.png') }}" style="height: 100px;">
						@endif
						<br>
						<span class="letter-spacing-sm">
							{{ $data_ttd->nama_pj_rombel ?? '-' }}
						</span>
						<br>
						<span>
							NIP: {{ $data_ttd->nip_pj_rombel ?? '-' }}
						</span>
					</td>
				</tr>
				<tr style="">
					<td >
					</td>
					<td class="text-center">
						<span class="">
							Mengetahui:
						</span>
						<br>
						<span class="">
							Kepala PKBM GENERASI JUARA
						</span>
						<br>
						@if ($data_ttd && $data_ttd['url_ttd_ketua'] != '' && filter_var($data_ttd['url_ttd_ketua'], FILTER_VALIDATE_URL) !== false)
							<img src="{{'data:image/png;base64,' . base64_encode(file_get_contents(@$data_ttd['url_ttd_ketua']))}}" alt="image" style="height: 100px;"> <br>
						@else
							<img src="{{ public_path($data_ttd['url_ttd_ketua'] ?? '/images/white.png') }}" style="height: 100px;">
						@endif

						<br>
						<span class="">
							{{ $data_ttd['nama_ketua_pkbm'] ?? '-' }}
						</span>
						
						<br>
						<span>
							NIP: {{ $data_ttd['nip_ketua_pkbm'] ?? '-' }}
						</span>
					</td>
					<td>
					</td>
				</tr>
			</table>
		</div>

	</div>
</body>
</html>