<?php

namespace App\Utils;

/**
 * Class containing application-wide constants
 */
class Constant
{
	// Authentication and User Management
	public const PPDB_DEFAULT_PASSWORD = "pkbmgenju";

	public const ROLE_SUPERADMIN_ID = 1;
	public const ROLE_TUTOR_ID = 2;
	public const ROLE_WB_ID = 3;

	public const ROLE_SUPERADMIN = "Superadmin";
	public const ROLE_TUTOR = "Tutor";
	public const ROLE_WB = "WB";
	public const IMPORTANT_ROLES = [
		self::ROLE_SUPERADMIN,
		self::ROLE_TUTOR,
		self::ROLE_WB,
		'AdminKeuangan',
		'AdminKesiswaan',
		'AdminAkademik'
	];

	// Class Types and Categories
	public const TYPE_KELAS_ABC = 0;
	public const TYPE_KELAS_PAUD = 1;
	public const TYPE_KELAS_KHUSUS = 2;

	public const KELAS_TYPE = ['ABC', 'PAUD', 'Kelas Khusus'];
	public const TYPE_KELAS = [
		'ABC' => self::TYPE_KELAS_ABC,
		'PAUD' => self::TYPE_KELAS_PAUD,
		'KELAS_KHUSUS' => self::TYPE_KELAS_KHUSUS,
	];

	public const KELAS_PAUD = [
		'SHIDDIQ',
		'AMANAH',
		'KABAR'
	];

	// Student Status
	public const STATUS_WB_BARU = "Baru";
	public const STATUS_WB_LAMA = "Lama";
	public const STATUS_WB_ALUMNI = "Alumni";

	// Class Categories
	public const JENIS_KELAS = [
		1 => 'Formal',
		2 => 'Nonformal',
	];

	// Registration Types
	public const JENIS_PENDAFTARAN = [
		1 => 'Pendaftaran Baru',
		2 => 'Pendaftaran Ulang',
		3 => 'Pendaftaran Alumni',
	];

	// Subject Groups
	public const KELOMPOK_MAPEL = [
		'kelompok_khusus' => 'Kelompok Khusus',
		'kelompok_umum' => 'Kelompok Umum',
	];

	public const SUB_KELOMPOK_MAPEL = [
		'keterampilan' => 'Keterampilan',
		'pemberdayaan' => 'Pemberdayaan',
	];

	// Grade Levels
	public const KELAS = [
		1 => '1 SD',
		2 => '2 SD',
		3 => '3 SD',
		4 => '4 SD',
		5 => '5 SD',
		6 => '6 SD',
		7 => '1 SMP',
		8 => '2 SMP',
		9 => '3 SMP',
		10 => '1 SMA',
		11 => '2 SMA',
		12 => '3 SMA',
	];

	// Phase Mapping
	public const FASE_MAPPING = [
		'A' => [1, 2],
		'B' => [3, 4],
		'C' => [5, 6],
		'D' => [7, 8, 9],
		'E' => [10],
		'F' => [11, 12],
	];

	// Curriculum Dimensions
	public const DIMENSI = [
		'Dimensi Beriman, Bertaqwa kepada Tuhan Yang Maha Esa, dan Berakhlak Mulia',
		'Dimensi Berkebhinekaan Global',
		'Dimensi Bergotong Royong',
		'Dimensi Mandiri',
		'Dimensi Bernalar Kritis',
		'Dimensi Kreatif',
	];

	// Curriculum Elements
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

	// System Settings
	public const IMPORTANT_SETTINGS = [
		'tahun_ajaran_aktif' => null,
		'default_kkm' => 75,
		'nama_kepala_pkbm' => null,
		'nip_kepala_pkbm' => null,
		'ttd_kepala_pkbm' => null,
	];

	// Data Types
	public const DATATYPE_STRING = 'string';
	public const DATATYPE = ['string'];

	// Validation Patterns
	public const KODE_KELAS_ABC_PATTERN = '/^[A-Ca-c][0-9]{1,2}/';
	public const NISN_PATTERN = '/^[0-9]{10}$/';
	public const TAHUN_AJARAN_PATTERN = '/^20\d{2}[12]$/';

	// Default Values
	public const DEFAULT_SEMESTER = 1;
	public const EMPTY_DATE = '0000-00-00';
	public const DEFAULT_PAKET_KODE = 'REG';

	/**
	 * Get formatted duplicate value message
	 */
	public static function DuplicateValue(string $col): string
	{
		return sprintf('Duplicate %s. Please try again.', $col);
	}

	/**
	 * Get formatted not found message
	 */
	public static function NotFound(string $key): string
	{
		return sprintf('%s not found', $key);
	}

	/**
	 * Get class type name by ID
	 */
	public static function getJenisKelas(int $typeId): ?string
	{
		return self::JENIS_KELAS[$typeId] ?? null;
	}

	/**
	 * Get registration type by ID
	 */
	public static function getJenisPendaftaran(int $typeId): ?string
	{
		return self::JENIS_PENDAFTARAN[$typeId] ?? null;
	}
}
