<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>
	<div class="row">
		<div class="col-md-7">
			<table style="width: 70%;">
				<tr>
					<td style="padding: 10px  10px 10px;">Nama Satuan Pendidikan </td>
					<td>: </td>
					<td style="border-bottom:solid 1px #000; padding: 10px;">PKBM HAMEMAYU </td>
				</tr>
				<tr>
					<td style="padding: 10px  10px 10px;">Alamat Penjab Semester Ganjil </td>
					<td>: </td>
					<td style="border-bottom:solid 1px #000; padding: 10px;">Jl. Margorejo Asri Gang II/29, Tempel,<br> Sleman,  Yogyakarta </td>
				</tr>

				<tr>
					<td style="padding: 10px  10px 10px;">Nama Peserta Didik </td>
					<td>: </td>
					<td style="border-bottom:solid 1px #000; padding: 10px;">YESSI UMMI</td>
				</tr>

				<tr>
					<td style="padding: 10px  10px 10px;">Nomor Induk/NISN </td>
					<td>: </td>
					<td style="border-bottom:solid 1px #000; padding: 10px;">272 / 9988342301</td>
				</tr>
				<tr>
					<td style="padding: 10px  10px 10px;">Paket </td>
					<td>: </td>
					<td style="border-bottom:solid 1px #000; padding: 10px;">Paket B Setara SMP</td>
				</tr>

				<tr>
					<td style="padding: 10px  10px 10px;">Tingkatan/Setara Kls.</td>
					<td>: </td>
					<td style="padding: 10px;border-bottom: solid 1px #000;"><b>3/VII</b></td>
				</tr>

				<tr>
					<td style="padding: 10px  10px 10px;">Paket Kompetensi</td>
					<td>: </td>
					<td style="padding: 10px;border-bottom: solid 1px #000;"><b>3.1</b></td>
				</tr>

				<tr>
					<td style="padding: 10px  10px 10px;">Tahun Pelajaran</td>
					<td>: </td>
					<td style="padding: 10px;border-bottom: solid 1px #000;"><b>2019/2020</b></td>
				</tr>
			</table>
		</div>
		<div class="col-md-12"><br><br></div>
		<div class="col-md-12 mt-3" style="background: #DDD;padding: 10px;text-align: center;">
			CAPAIAN HASIL BELAJAR												
		</div>
		<div class="col-md-12"><br></div>
		<div class="col-md-12">
			<b>A. Sikap</b>
		</div>
		<div class="col-md-12" style="padding: 30px;">
			<b>1. Sikap Spiritual</b>
			<table border="1" style="padding: 10px;" width="100%">
				<tr>
					<td style="padding: 10px;width: 20px;">Predikat</td>
					<td style="padding: 10px;">Deskripsi</td>
				</tr>

				<tr>
					<td style="padding: 30px;font-size: 30px;"><b>
						A
					</b></td>
					<td style="padding: 10px;">
						Sangat bisa mengikuti dan memahami
					</td>
				</tr>
			</table>
		</div>
		<div class="col-md-12" style="padding: 30px;">
			<b>2. Sikap Sosial</b>
			<table border="1" style="padding: 10px;width: 100%;">
				<tr>
					<td style="padding: 10px;width: 20px;">Predikat</td>
					<td style="padding: 10px;">Deskripsi</td>
				</tr>
				<tr>
					<td style="padding: 30px;font-size: 30px;"><b>
						A
					</b></td>
					<td style="padding: 10px;">
						Sangat baik dalam bersosial
					</td>
				</tr>
			</table>
		</div>
		<div class="col-md-12"><br><br></div>
		<div class="col-md-12 mt-3" style="background: #DDD;padding: 10px;text-align: center;">
			CAPAIAN HASIL BELAJAR												
		</div>
		<div class="col-md-12"><br></div>
		<div class="col-md-12">
			<b>B. Pengetahuan</b>
			<table width="100%" border="1" style="text-align: center;">
				<tr>
					<td rowspan="2">No</td>
					<td rowspan="2">Mata Pelajaran</td>
					<td rowspan="2">SKK</td>
					<td rowspan="2">KKM</td>
					<td colspan="3">Nilai</td>
					<td colspan="3">Predikat</td>
				</tr>
				<tr>
					<td>Modul 1</td>
					<td>Modul 2</td>
					<td>Modul 3</td>

					<td>Modul 1</td>
					<td>Modul 2</td>
					<td>Modul 3</td>
				</tr>
				<tr>
					<td colspan="2" style="text-align: left;"><b style="text-align: left;">Kelompok Umum</b></td>
					<td colspan="2"></td>
					<td colspan="6" style="background: #DDD;"></td>
				</tr>
				
				<tr>
					<td>1.</td>
					<td style="text-align: left;padding: 10px;">Pendidikan Agama</td>
					<td><?php echo (!empty($get_raport)) ? $get_raport->pengetahuan_skk : ''; ?></td>
					<td><?php echo (!empty($get_raport)) ? $get_raport->pengetahuan_kkm : ''; ?></td>
					<td><?php echo (!empty($get_raport)) ? $get_raport->pengetahuan_nilai_1 : ''; ?></td>
					<td><?php echo (!empty($get_raport)) ? $get_raport->pengetahuan_nilai_2 : ''; ?></td>
					<td><?php echo (!empty($get_raport)) ? $get_raport->pengetahuan_nilai_3 : ''; ?></td>
					<td><?php echo (!empty($get_raport)) ? $get_raport->pengetahuan_predikat_1 : ''; ?></td>
					<td><?php echo (!empty($get_raport)) ? $get_raport->pengetahuan_predikat_2 : ''; ?></td>
					<td><?php echo (!empty($get_raport)) ? $get_raport->pengetahuan_predikat_3 : ''; ?></td>
				</tr>
				<tr>
					<td>2.</td>
					<td style="text-align: left;padding: 10px;">Pendidikan Pancasila dan Kewarganegaraan (PPKn)		</td>
					<td><?php echo (!empty($get_raport)) ? $get_raport->pengetahuan_skk : ''; ?></td>
					<td><?php echo (!empty($get_raport)) ? $get_raport->pengetahuan_kkm : ''; ?></td>
					<td><?php echo (!empty($get_raport)) ? $get_raport->pengetahuan_nilai_1 : ''; ?></td>
					<td><?php echo (!empty($get_raport)) ? $get_raport->pengetahuan_nilai_2 : ''; ?></td>
					<td><?php echo (!empty($get_raport)) ? $get_raport->pengetahuan_nilai_3 : ''; ?></td>
					<td><?php echo (!empty($get_raport)) ? $get_raport->pengetahuan_predikat_1 : ''; ?></td>
					<td><?php echo (!empty($get_raport)) ? $get_raport->pengetahuan_predikat_2 : ''; ?></td>
					<td><?php echo (!empty($get_raport)) ? $get_raport->pengetahuan_predikat_3 : ''; ?></td>
				</tr>
				<tr>
					<td>3.</td>
					<td style="text-align: left;padding: 10px;">Bahasa Indonesia</td>
					<td><?php echo (!empty($get_raport)) ? $get_raport->pengetahuan_skk : ''; ?></td>
					<td><?php echo (!empty($get_raport)) ? $get_raport->pengetahuan_kkm : ''; ?></td>
					<td><?php echo (!empty($get_raport)) ? $get_raport->pengetahuan_nilai_1 : ''; ?></td>
					<td><?php echo (!empty($get_raport)) ? $get_raport->pengetahuan_nilai_2 : ''; ?></td>
					<td><?php echo (!empty($get_raport)) ? $get_raport->pengetahuan_nilai_3 : ''; ?></td>
					<td><?php echo (!empty($get_raport)) ? $get_raport->pengetahuan_predikat_1 : ''; ?></td>
					<td><?php echo (!empty($get_raport)) ? $get_raport->pengetahuan_predikat_2 : ''; ?></td>
					<td><?php echo (!empty($get_raport)) ? $get_raport->pengetahuan_predikat_3 : ''; ?></td>
				</tr>
				<tr>
					<td>4.</td>
					<td style="text-align: left;padding: 10px;">Bahasa Inggris		</td>
					<td><?php echo (!empty($get_raport)) ? $get_raport->pengetahuan_skk : ''; ?></td>
					<td><?php echo (!empty($get_raport)) ? $get_raport->pengetahuan_kkm : ''; ?></td>
					<td><?php echo (!empty($get_raport)) ? $get_raport->pengetahuan_nilai_1 : ''; ?></td>
					<td><?php echo (!empty($get_raport)) ? $get_raport->pengetahuan_nilai_2 : ''; ?></td>
					<td><?php echo (!empty($get_raport)) ? $get_raport->pengetahuan_nilai_3 : ''; ?></td>
					<td><?php echo (!empty($get_raport)) ? $get_raport->pengetahuan_predikat_1 : ''; ?></td>
					<td><?php echo (!empty($get_raport)) ? $get_raport->pengetahuan_predikat_2 : ''; ?></td>
					<td><?php echo (!empty($get_raport)) ? $get_raport->pengetahuan_predikat_3 : ''; ?></td>
				</tr>
				
				<tr>
					<td>5.</td>
					<td style="text-align: left;padding: 10px;">Matematika		</td>
					<td><?php echo (!empty($get_raport)) ? $get_raport->pengetahuan_skk : ''; ?></td>
					<td><?php echo (!empty($get_raport)) ? $get_raport->pengetahuan_kkm : ''; ?></td>
					<td><?php echo (!empty($get_raport)) ? $get_raport->pengetahuan_nilai_1 : ''; ?></td>
					<td><?php echo (!empty($get_raport)) ? $get_raport->pengetahuan_nilai_2 : ''; ?></td>
					<td><?php echo (!empty($get_raport)) ? $get_raport->pengetahuan_nilai_3 : ''; ?></td>
					<td><?php echo (!empty($get_raport)) ? $get_raport->pengetahuan_predikat_1 : ''; ?></td>
					<td><?php echo (!empty($get_raport)) ? $get_raport->pengetahuan_predikat_2 : ''; ?></td>
					<td><?php echo (!empty($get_raport)) ? $get_raport->pengetahuan_predikat_3 : ''; ?></td>
				</tr>
				<tr>
					<td>6.</td>
					<td style="text-align: left;padding: 10px;">Ilmu Pengetahuan Alam		</td>
					<td><?php echo (!empty($get_raport)) ? $get_raport->pengetahuan_skk : ''; ?></td>
					<td><?php echo (!empty($get_raport)) ? $get_raport->pengetahuan_kkm : ''; ?></td>
					<td><?php echo (!empty($get_raport)) ? $get_raport->pengetahuan_nilai_1 : ''; ?></td>
					<td><?php echo (!empty($get_raport)) ? $get_raport->pengetahuan_nilai_2 : ''; ?></td>
					<td><?php echo (!empty($get_raport)) ? $get_raport->pengetahuan_nilai_3 : ''; ?></td>
					<td><?php echo (!empty($get_raport)) ? $get_raport->pengetahuan_predikat_1 : ''; ?></td>
					<td><?php echo (!empty($get_raport)) ? $get_raport->pengetahuan_predikat_2 : ''; ?></td>
					<td><?php echo (!empty($get_raport)) ? $get_raport->pengetahuan_predikat_3 : ''; ?></td>
				</tr>
				<tr>
					<td>7.</td>
					<td style="text-align: left;padding: 10px;">Ilmu Pengetahuan Sosial		</td>
					<td><?php echo (!empty($get_raport)) ? $get_raport->pengetahuan_skk : ''; ?></td>
					<td><?php echo (!empty($get_raport)) ? $get_raport->pengetahuan_kkm : ''; ?></td>
					<td><?php echo (!empty($get_raport)) ? $get_raport->pengetahuan_nilai_1 : ''; ?></td>
					<td><?php echo (!empty($get_raport)) ? $get_raport->pengetahuan_nilai_2 : ''; ?></td>
					<td><?php echo (!empty($get_raport)) ? $get_raport->pengetahuan_nilai_3 : ''; ?></td>
					<td><?php echo (!empty($get_raport)) ? $get_raport->pengetahuan_predikat_1 : ''; ?></td>
					<td><?php echo (!empty($get_raport)) ? $get_raport->pengetahuan_predikat_2 : ''; ?></td>
					<td><?php echo (!empty($get_raport)) ? $get_raport->pengetahuan_predikat_3 : ''; ?></td>
				</tr>
				<tr>
					<td colspan="2" style="text-align: left;"><b style="text-align: left;">Kelompok Khusus</b></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
				</tr>
				<tr>
					<td>8.</td>
					<td style="text-align: left;padding: 10px;">Pemberdayaan</td>
					<td colspan="2"></td>
					<td colspan="6" style="background: #DDD;"></td>
				</tr>
				<tr>
					<td></td>
					<td style="text-align: left;padding: 10px;">Tahsin/Pembacaan Kitab Suci <br>untuk Non Muslim				</td>
					<td><?php echo (!empty($get_raport)) ? $get_raport->pengetahuan_skk : ''; ?></td>
					<td><?php echo (!empty($get_raport)) ? $get_raport->pengetahuan_kkm : ''; ?></td>
					<td colspan="3"><?php echo (!empty($get_raport)) ? $get_raport->pengetahuan_nilai_1 : ''; ?></td>
					<td colspan="3"><?php echo (!empty($get_raport)) ? $get_raport->pengetahuan_predikat_1 : ''; ?></td>
				</tr>
				<tr>
					<td></td>
					<td style="text-align: left;padding: 10px;">Kunjungan Museum (Outing Class)		</td>
					<td><?php echo (!empty($get_raport)) ? $get_raport->pengetahuan_skk : ''; ?></td>
					<td><?php echo (!empty($get_raport)) ? $get_raport->pengetahuan_kkm : ''; ?></td>
					<td colspan="3"><?php echo (!empty($get_raport)) ? $get_raport->pengetahuan_nilai_1 : ''; ?></td>
					<td colspan="3"><?php echo (!empty($get_raport)) ? $get_raport->pengetahuan_predikat_1 : ''; ?></td>
				</tr>
				<tr>
					<td></td>
					<td style="text-align: left;padding: 10px;">Percakapan Bahasa 		</td>
					<td><?php echo (!empty($get_raport)) ? $get_raport->pengetahuan_skk : ''; ?></td>
					<td><?php echo (!empty($get_raport)) ? $get_raport->pengetahuan_kkm : ''; ?></td>
					<td colspan="3"><?php echo (!empty($get_raport)) ? $get_raport->pengetahuan_nilai_1 : ''; ?></td>
					<td colspan="3"><?php echo (!empty($get_raport)) ? $get_raport->pengetahuan_predikat_1 : ''; ?></td>
				</tr>

				<tr>
					<td>9.</td>
					<td style="text-align: left;padding: 10px;">Keterampilan</td>
					<td colspan="2"></td>
					<td colspan="6" style="background: #DDD;"></td>
				</tr>
				<tr>
					<td></td>
					<td style="text-align: left;padding: 10px;">a. Keterampilan Wajib						</td>
					<td><?php echo (!empty($get_raport)) ? $get_raport->pengetahuan_skk : ''; ?></td>
					<td><?php echo (!empty($get_raport)) ? $get_raport->pengetahuan_kkm : ''; ?></td>
					<td colspan="3"><?php echo (!empty($get_raport)) ? $get_raport->pengetahuan_nilai_1 : ''; ?></td>
					<td colspan="3"><?php echo (!empty($get_raport)) ? $get_raport->pengetahuan_predikat_1 : ''; ?></td>
				</tr>
				<tr>
					<td></td>
					<td style="text-align: left;padding: 10px;">b. Keterampilan Pilihan				</td>
					<td><?php echo (!empty($get_raport)) ? $get_raport->pengetahuan_skk : ''; ?></td>
					<td><?php echo (!empty($get_raport)) ? $get_raport->pengetahuan_kkm : ''; ?></td>
					<td colspan="3"><?php echo (!empty($get_raport)) ? $get_raport->pengetahuan_nilai_1 : ''; ?></td>
					<td colspan="3"><?php echo (!empty($get_raport)) ? $get_raport->pengetahuan_predikat_1 : ''; ?></td>
				</tr>
				<tr>
					<td></td>
					<td style="text-align: left;padding: 10px;">    1) Olah kata (Word processsing)				</td>
					<td><?php echo (!empty($get_raport)) ? $get_raport->pengetahuan_skk : ''; ?></td>
					<td><?php echo (!empty($get_raport)) ? $get_raport->pengetahuan_kkm : ''; ?></td>
					<td colspan="3"><?php echo (!empty($get_raport)) ? $get_raport->pengetahuan_nilai_1 : ''; ?></td>
					<td colspan="3"><?php echo (!empty($get_raport)) ? $get_raport->pengetahuan_predikat_1 : ''; ?></td>
				</tr>
				<tr>
					<td></td>
					<td style="text-align: left;padding: 10px;">    2) Hantaran						</td>
					<td><?php echo (!empty($get_raport)) ? $get_raport->pengetahuan_skk : ''; ?></td>
					<td><?php echo (!empty($get_raport)) ? $get_raport->pengetahuan_kkm : ''; ?></td>
					<td colspan="3"><?php echo (!empty($get_raport)) ? $get_raport->pengetahuan_nilai_1 : ''; ?></td>
					<td colspan="3"><?php echo (!empty($get_raport)) ? $get_raport->pengetahuan_predikat_1 : ''; ?></td>
				</tr>
			</table>
		</div>
	</div>
</body>
</html>