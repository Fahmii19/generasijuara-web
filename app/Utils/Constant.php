<?php

namespace App\Utils;

/**
 * 
 */
class Constant
{
	public const KELAS_TYPE = ['ABC', 'PAUD', 'Kelas Khusus'];

	public const ROLE_SUPERADMIN_ID = 1;
	public const ROLE_TUTOR_ID = 2;
	public const ROLE_WB_ID = 3;

	public const ROLE_SUPERADMIN = "Superadmin";
	public const ROLE_TUTOR = "Tutor";
	public const ROLE_WB = "WB";

	public const PPDB_DEFAULT_PASSWORD = "pkbmgenju";

	public const JENIS_KELAS = [
		'1' => 'Formal', 
		'2' => 'Nonformal',
	];

	public const JENIS_PENDAFTARAN = [
		'1' => 'Pendaftaran Baru', 
		'2' => 'Pendaftaran Ulang',
		'3' => 'Pendaftaran Alumni',
	];

	public const KELOMPOK_MAPEL = [
		'kelompok_khusus' => 'Kelompok Khusus', 
		'kelompok_umum' => 'Kelompok Umum',
	];

	public const SUB_KELOMPOK_MAPEL = [
		'keterampilan' => 'Keterampilan', 
		'pemberdayaan' => 'Pemberdayaan',
	];

	public const KELAS = [
		'1' => '1 SD',
		'2' => '2 SD',
		'3' => '3 SD',
		'4' => '4 SD',
		'5' => '5 SD',
		'6' => '6 SD',
		'7' => '1 SMP',
		'8' => '2 SMP',
		'9' => '3 SMP',
		'10' => '1 SMA',
		'11' => '2 SMA',
		'12' => '3 SMA',
	];

	public const DATATYPE_STRING = 'string'; 
	public const DATATYPE = [
		'string',
	];
	
	public const IMPORTANT_SETTINGS = [
		'tahun_ajaran_aktif' => null,
		'default_kkm' => 75,
		'nama_kepala_pkbm' => null,
		'nip_kepala_pkbm' => null,
		'ttd_kepala_pkbm' => null,
	];

	public const TYPE_KELAS_ABC = 0;
	public const TYPE_KELAS_PAUD = 1;
	public const TYPE_KELAS_KHUSUS = 2;
	public const TYPE_KELAS = [
		'ABC' => 0,
		'PAUD' => 1,
		'KELAS_KHUSUS' => 2,
	];

	public const KELAS_PAUD = [
		'SHIDDIQ', 
        'AMANAH',
        'KABAR'
	];

	public const STATUS_WB_BARU = "Baru";
	public const STATUS_WB_LAMA = "Lama";
	public const STATUS_WB_ALUMNI = "Alumni";

	public const IMPORTANT_ROLES = ['Superadmin', 'Tutor', 'WB', 'AdminKeuangan', 'AdminKesiswaan','AdminAkademik'];

	public const FASE_MAPPING = [
		'A' => [1, 2],
		'B' => [3, 4],
		'C' => [5, 6],
		'D' => [7, 8, 9],
		'E' => [10],
		'F' => [11, 12],
	];

	public const DIMENSI = [
		'Dimensi Beriman, Bertaqwa kepada Tuhan Yang Maha Esa, dan Berakhlak Mulia',
		'Dimensi Berkebhinekaan Global',
		'Dimensi Bergotong Royong',
		'Dimensi Mandiri',
		'Dimensi Bernalar Kritis',
		'Dimensi Kreatif',
	];

	public const ELEMEN = [
		[
			'Elemen akhlak beragama',
			'Elemen akhlak pribadi',
			'Elemen akhlak kepada manusia',
			'Elemen akhlak kepada alam',
			'Elemen akhlak kepada negara'
		],
		[
			'Elemen mengenal dan menghargai budaya',
			'Elemen komunikasi dan interaksi antar budaya',
			'Elemen refleksi dan bertanggung jawab terhadap pengalaman kebinekaan',
		],
		[
			'Elemen kolaborasi',
			'Elemen kepedulian',
			'Elemen berbagi',
		],
		[
			'Elemen pemahaman diri dan situasi yang dihadapi',
			'Elemen regulasi diri',
		],
		[
			'Elemen memperoleh dan memproses informasi dan gagasan',
			'Elemen menganalisis dan mengevaluasi penalaran dan prosedurnya',
			'Elemen refleksi pemikiran dan proses berpikir'
		],
		[
			'Elemen menghasilkan gagasan yang orisinal',
			'Elemen menghasilkan karya dan tindakan yang orisinal',
			'Elemen memiliki keluwesan berpikir dalam mencari alternatif solusi permasalahan',
		],
	];

	public static function DuplicateValue($col){
		return 'Duplicate '.$col.'. Please try again.';
	}
	public static function NotFound($key){
		return $key.' not found';
	}
}