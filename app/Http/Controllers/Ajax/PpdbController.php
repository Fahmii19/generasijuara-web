<?php

namespace App\Http\Controllers\Ajax;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PpdbModel;
use App\Models\User;
use App\Models\UserRoleModel;
use App\Models\PembayaranModel;
use App\Models\PembayaranItemsModel;
use App\Models\VoucherModel;
use DB;
use App\Http\Requests\PPDB\CreateRequest;
use App\Http\Requests\PPDB\UpdateProfileRequest;
use App\Http\Requests\PPDB\UpdateRequest;
use App\Utils\Constant;
use App\Utils\Misc;

use App\Services\EmailService;
use App\Jobs\SendEmailJob;
use App\Jobs\SendVerificationPpdbJob;
use App\Models\PaketSppModel;
use App\Models\RombelModel;
use App\Models\TagihanItemsModel;
use App\Models\TagihanModel;
use App\Models\TahunAkademikModel;
use Exception;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class PpdbController extends Controller
{
    public function get(Request $request)
    {
        try {
            $id = !empty($request->get('id')) ? $request->get('id') : null;
            $user_id = !empty($request->get('user_id')) ? $request->get('user_id') : null;
            $ppdb = null;
            if (!empty($id)) {
                $ppdb = PpdbModel::find($id);
            } elseif (!empty($user_id)) {
                $ppdb = PpdbModel::where('user_id', $user_id)->first();
            }

            return response()->json(['error' => false, 'message' => null, 'data' => $ppdb], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => true, 'message' => $e->getMessage()], 400);
        } catch (\Throwable $e) {
            return response()->json(['error' => true, 'message' => $e->getMessage()], 400);
        }
    }

    public function getAll(Request $request)
    {
        try {
            $ppdb = PpdbModel::query();
            if ($request->has('type')) {
                $ppdb->where('type', $request->get('type'));
            }

            if ($request->has('nama')) {
                $ppdb->where('nama', 'LIKE', "%$request->nama%");
            }

            return response()->json(['error' => false, 'message' => null, 'data' => $ppdb->get()], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => true, 'message' => $e->getMessage()], 400);
        } catch (\Throwable $e) {
            return response()->json(['error' => true, 'message' => $e->getMessage()], 400);
        }
    }

    public function delete(Request $request)
    {
        try {
            $id = !empty($request->get('id')) ? $request->get('id') : null;
            $ppdb = PpdbModel::find($id);
            if (empty($ppdb)) {
                return response()->json(['error' => true, 'message' => 'Paket Kelas tidak ditemukan'], 400);
            }
            $ppdb->delete();
            return response()->json(['error' => false, 'message' => null, 'data' => []], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => true, 'message' => $e->getMessage()], 400);
        } catch (\Throwable $e) {
            return response()->json(['error' => true, 'message' => $e->getMessage()], 400);
        }
    }

    public function create(CreateRequest $request)
    {
        DB::beginTransaction();
        try {
            $params = $request->validated();

            $storeFIlePath = null;
            if (!empty($params['bukti_tf'])) {
                $storeFIlePath = Storage::disk('public_path')->put('bukti_pembayaran', $params['bukti_tf']);
            }

            $storeFIleInfaqPath = null;
            if (!empty($params['bukti_infaq'])) {
                $storeFIleInfaqPath = Storage::disk('public_path')->put('bukti_pembayaran_infaq', $params['bukti_infaq']);
            }

            // Paket SPP
            $paket_spp = PaketSppModel::where('id', $params['paket_spp_id'])->first();
            $biaya_spp = !empty($paket_spp) ? $paket_spp->biaya : 0;
            $biaya_daftar = !empty($paket_spp) ? $paket_spp->biaya_pendaftaran : 0;
            $biaya_kk = !empty($paket_spp) ? $paket_spp->biaya_kk : 0;

            $voucher_id = null;
            $nominal_diskon = null;
            if (!empty($params['voucher_code'])) {
                $voucher = VoucherModel::query()
                    ->where('stok', '>', 0)
                    ->where('is_active', true)
                    ->where('kode', $params['voucher_code'])
                    ->first();

                if (!empty($voucher)) {
                    $params['discount_type'] = $voucher->type;
                    $params['discount'] = $voucher->discount;
                    $voucher_id = $voucher->id;
                    if ($params['discount_type'] == 'percentage') {
                        $nominal_diskon = (int) $biaya_spp * $voucher->discount/100;
                    } else {
                        $nominal_diskon = (int) $voucher->discount;
                    }
                    
                    $voucher->stok -= 1;
                    $voucher->save();
                }

            }

            // pembayaran
            $bayar_program = $params['bayar_program'] ?? null;
            $bayar_daftar = $params['bayar_daftar'] ?? null;
            $bayar_kk = $params['bayar_kk'] ?? null;
            $bayar_spp = $params['bayar_spp'] ?? null;
            $bayar_wakaf = $params['bayar_wakaf'] ?? null;
            $bayar_infaq = $params['bayar_infaq'] ?? null;

            $params['wakaf'] = $params['bayar_wakaf'] ?? null;
            $params['infaq'] = $params['bayar_infaq'] ?? null;

            // dd($params);
            unset($params['bayar_program']);
            unset($params['bayar_daftar']);
            unset($params['bayar_kk']);
            unset($params['bayar_spp']);
            unset($params['bayar_wakaf']);
            unset($params['bayar_infaq']);
            unset($params['bukti_tf']);

            // user creation
            $password = $params['password'] ?? null;
            unset($params['password']);

            $params['is_active'] = !empty($params['is_active']) ? Misc::castBoolean($params['is_active']) : false;
            $params['is_approved'] = !empty($params['is_approved']) ? Misc::castBoolean($params['is_approved']) : false;
            $params['kelamin'] = $params['jenis_kelamin'];

            // Jika yang membuat adalah admin
            $nis = null;
            $uid = Str::uuid();
            $password_user = bcrypt($uid);
            $is_active = $params['is_active'];

            if ($request->has('created_by_admin') && $params['created_by_admin'] == true) {
                $nis = isset($params['nis']) && $params['nis'] !== null ? $params['nis'] : PpdbModel::generateNis();
                $uid = $nis;
                $password_user = bcrypt(Constant::PPDB_DEFAULT_PASSWORD);
                $is_active = true;

                $params['no_induk'] = $nis;
                $params['nis'] = $nis;
                $params['tgl_terima'] = date('Y-m-d');
                $params['is_active'] = true;
            }

            
            $user = User::create([
                'name' => $params['nama'],
                'username' => $uid,
                // 'phone' => $params['hp_siswa'],
                'phone' => null,
                'password' => $password_user,
                'is_active' => $is_active,
            ]);

            $user_role = UserRoleModel::where('user_id', $user->id)
                ->where('role_id', Constant::ROLE_WB_ID)
                ->first();
            if (empty($user_role)) {
                $user_role = UserRoleModel::create([
                    'user_id' => $user->id,
                    'role_id' => Constant::ROLE_WB_ID,
                ]);
            }

            // Tahun Akademik
            $tahunAkademik = TahunAkademikModel::where('is_active', 1)->first();
            if (empty($tahunAkademik)) throw new Exception("Tahun akademik tidak ditemukan");
            $tahun_akademik_id = $tahunAkademik->id;

            // ppdb creation
            $params['user_id'] = $user->id;
            $params['tahun_akademik_id'] = $tahun_akademik_id;
            $ppdb = PpdbModel::create($params);

            $biaya_program = !empty($params['biaya_program']) ? $params['biaya_program'] : 0;
            $bill = (int) $biaya_spp + (int) $biaya_daftar + (int) $bayar_kk + ((int) $biaya_program) + ((int) $params['wakaf'] ?? 0) + ((int) $params['infaq'] ?? 0);
            $already_paid = (int) $bayar_daftar + (int) $bayar_kk + (int) $bayar_spp + (int) $bayar_program + (int) $bayar_wakaf + (int) $bayar_infaq - ((int) $nominal_diskon ?? 0);
            $paramsSavePayment = [
                'type' => TagihanModel::TYPE_DAFTAR_BARU,
                'source_table' => 'ppdb',
                'source_id' => $params['user_id'],
                'ppdb_id' => $ppdb->id,
                'tagihan' => $bill,
                'total_tagihan' => $bill - ((int) $nominal_diskon ?? 0),
                'nominal' => $already_paid,
                'biaya_daftar' => (int) $biaya_daftar,
                'biaya_kk' => (int) $biaya_kk,
                'biaya_spp' => (int) $biaya_spp,
                'biaya_program' => (!empty($params['biaya_program']) ? (int) $params['biaya_program'] : null),
                'nominal_diskon' => ((int) $nominal_diskon ?? 0),

                'subtotal_spp_pendaftaran' => ((int) $ppdb->biaya_daftar ?? 0) + ((int) $ppdb->biaya_spp ?? 0),
                'bayar_program' => $bayar_program,
                'bayar_daftar' => $bayar_daftar,
                'bayar_kk' => $bayar_kk,
                'bayar_spp' => $bayar_spp,
                'bayar_wakaf' => $bayar_wakaf,
                'bayar_infaq' => $bayar_infaq,
                'voucher_id' => $voucher_id,
                // 'url_bukti_trf' => !empty($storeFIlePath) ? url('/').Storage::url($storeFIlePath) : null,
                'bank_name' => $params['bank_name'],
                'bank_account_number' => $params['bank_account_number'],
                'bank_account_name' => $params['bank_account_name'],
                'url_bukti_trf' => !empty($storeFIlePath) ? url('/') . '/uploads/' . $storeFIlePath : null,
                'url_bukti_trf_infaq' => !empty($storeFIleInfaqPath) ? url('/') . '/uploads/' . $storeFIleInfaqPath : null,
            ];
            // return response()->json(['error' => true, 'data' => $paramsSavePayment], 400); 
            // Save Pembayaran
            $savePayment = $this->savePayment($ppdb, $paramsSavePayment);

            $ppdb = PpdbModel::with([
                'user_detail',
                'layanan_kelas',
                'paket_kelas',
                'paket_spp',
                'kelas',
            ])->find((int) $ppdb->id);

            if ($request->has('created_by_admin') && $params['created_by_admin'] == true) {
                // Cek rombel
                $rombel = RombelModel::where('ppdb_id', $ppdb->id)
                    ->where('tahun_akademik_id', $ppdb->tahun_akademik_id)
                    ->first();
                
                if(!empty($rombel)){
                    $rombel->is_active = true;
                    $rombel->save();
                }else{
                    $rombel = RombelModel::create([
                        'ppdb_id' => $ppdb->id,
                        'tahun_akademik_id' => !empty($ppdb->tahun_akademik_id) ? $ppdb->tahun_akademik_id : null,
                        'kelas_id' => !empty($ppdb->kelas_id) ? $ppdb->kelas_id : null,
                        'status_wb' => 'Baru',
                        'is_active' => true,
                    ]);
                }
            }

            if ($savePayment) {
                $paramsEmail = [];
                $paramsEmail['ppdb'] = $ppdb;
                $paramsEmail['mail_type'] = 'new_payment';
                $paramsEmail['is_approved'] = $params['is_approved'];
                $paramsEmail['created_at'] = $ppdb->created_at;
                $paramsEmail['paid_at'] = $ppdb->created_at;
                $paramsEmail['nama'] = $ppdb->nama;
                $paramsEmail['nik'] = $ppdb->nik_siswa;
                $paramsEmail['biaya_daftar'] = (int) $ppdb->biaya_daftar ?? 0;
                $paramsEmail['biaya_daftar_paid'] = 0;
                $paramsEmail['biaya_daftar_sisa'] = $paramsEmail['biaya_daftar'] - $paramsEmail['biaya_daftar_paid'];
                $paramsEmail['biaya_kk'] = (int) $ppdb->biaya_kk ?? 0;
                $paramsEmail['biaya_kk_paid'] = 0;
                $paramsEmail['biaya_kk_sisa'] = $paramsEmail['biaya_kk'] - $paramsEmail['biaya_kk_paid'];
                $paramsEmail['biaya_program'] = (int) $ppdb->biaya_program ?? 0;
                $paramsEmail['biaya_program_paid'] = 0;
                $paramsEmail['biaya_program_sisa'] = $paramsEmail['biaya_program'] - $paramsEmail['biaya_program_paid'];
                $paramsEmail['biaya_spp'] = (int) $ppdb->biaya_spp ?? 0;
                $paramsEmail['biaya_spp_paid'] = 0;
                $paramsEmail['biaya_spp_sisa'] = $paramsEmail['biaya_spp'] - $paramsEmail['biaya_spp_paid'];
                $paramsEmail['wakaf'] = (int) $ppdb->wakaf ?? 0;
                $paramsEmail['wakaf_paid'] = 0;
                $paramsEmail['wakaf_sisa'] = $paramsEmail['wakaf'] - $paramsEmail['wakaf_paid'];
                $paramsEmail['infaq'] = (int) $ppdb->infaq ?? 0;
                $paramsEmail['infaq_paid'] = 0;
                $paramsEmail['infaq_sisa'] = $paramsEmail['infaq'] - $paramsEmail['infaq_paid'];
                $paramsEmail['subtotal_spp_program_pendaftaran'] = $paramsEmail['biaya_daftar'] + $paramsEmail['biaya_program'] + $paramsEmail['biaya_spp'];
                $paramsEmail['subtotal_spp_pendaftaran'] = $paramsEmail['biaya_daftar'] + $paramsEmail['biaya_spp'];
                $paramsEmail['discount'] = ((int) $nominal_diskon ?? 0);
                $paramsEmail['subtotal_spp_pendaftaran_discount'] = $paramsEmail['subtotal_spp_pendaftaran'] - $paramsEmail['discount'];
                $paramsEmail['sub_wakaf_infaq'] = $paramsEmail['wakaf'] + $paramsEmail['infaq'];
                $paramsEmail['subtotal_biaya'] = $paramsEmail['subtotal_spp_pendaftaran_discount'] + $paramsEmail['sub_wakaf_infaq'];

                $paramsEmail['subtotal_paid'] = $paramsEmail['biaya_daftar_paid'] + $paramsEmail['biaya_program_paid'] + $paramsEmail['biaya_spp_paid'] + $paramsEmail['wakaf_paid'] + $paramsEmail['infaq_paid'] - $paramsEmail['discount'];
                $paramsEmail['deposit'] = ($paramsEmail['subtotal_paid'] > $paramsEmail['subtotal_biaya']) ? $paramsEmail['subtotal_paid'] - $paramsEmail['subtotal_biaya'] : 0;
                $paramsEmail['subtotal_sisa'] = ($paramsEmail['biaya_daftar_sisa'] + $paramsEmail['biaya_program_sisa'] + $paramsEmail['biaya_spp_sisa'] + $paramsEmail['wakaf_sisa'] + $paramsEmail['infaq_sisa']);
                $paramsEmail['total_tagihan'] = $paramsEmail['subtotal_sisa'] - $paramsEmail['deposit'] - $paramsEmail['discount'];

                /* Client request: do not send email after register, only send email after payment
                 * Remove comment to send email after register
                 * /
                /* SendEmailJob::dispatch(
                    $paramsEmail,
                    [
                        'email' => $ppdb->email,
                        'name' => $ppdb->user_detail->name,
                    ]
                ); */
            }

            DB::commit();
            return response()->json(['error' => false, 'message' => null, 'data' => $ppdb], 200);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => true, 'message' => $e->getMessage(), 'trace' => $e->getTrace()], 400);
        } catch (\Throwable $e) {
            DB::rollBack();
            return response()->json(['error' => true, 'message' => $e->getMessage(), 'trace' => $e->getTrace()], 400);
        }
    }

    public function update(UpdateRequest $request)
    {
        DB::beginTransaction();
        try {
            $id = !empty($request->get('id')) ? $request->get('id') : null;

            if (empty($id)) {
                return response()->json(['error' => true, 'message' => 'ppdb not found'], 400);
            }

            $ppdb = PpdbModel::with([
                'user_detail',
                'layanan_kelas',
                'paket_kelas',
                'paket_spp',
                'kelas',
            ])->find((int) $id);

            // Mendapatkan data tabel pembayaran_items
            $pembayaran_item = [];
            $pembayaran_item_query = PpdbModel::select('pay_items.id', 'pay_items.pembayaran_id', 'pay_items.item', 'pay_items.nominal')
                ->join('pembayaran as pay', 'pay.source_id', '=', 'ppdb.id')
                ->join('pembayaran_items as pay_items', 'pay_items.pembayaran_id', '=', 'pay.id')
                ->where('ppdb.id', $id)
                ->get()
                ->toArray();

            // Mengubah index result menjadi kolom item
            array_map(function ($item) use (&$pembayaran_item) {
                $pembayaran_item[$item['item']] = $item;
            }, $pembayaran_item_query);


            if (empty($ppdb)) {
                return response()->json(['error' => true, 'message' => 'ppdb not found'], 400);
            }

            $params = $request->validated();
            $params['is_active'] = !empty($params['is_active']) ? Misc::castBoolean($params['is_active']) : false;
            $params['is_approved'] = !empty($params['is_approved']) ? Misc::castBoolean($params['is_approved']) : false;
            $params['kelamin'] = $params['jenis_kelamin'];
            $params['nis'] = $ppdb->nis;

            if ($params['is_active'] && empty($ppdb->nis)) {
                $params['nis'] = PpdbModel::generateNis();
            }

            if (!$ppdb->is_active && $params['is_active']) {
                $password = Constant::PPDB_DEFAULT_PASSWORD;
                $username = $params['nis'] ?? $ppdb->user_detail->email;
                $params['tgl_terima'] = $params['tgl_terima'] ?? date('Y-m-d');

                $ppdb->user_detail->password = bcrypt($password);
                $ppdb->user_detail->username = $username;
                $ppdb->user_detail->save();

                SendVerificationPpdbJob::dispatch(
                    [
                        'name' => $ppdb->user_detail->name,
                        'username' => $username,
                        'nik' => $params['nik_siswa'],
                        'password' => $password,
                    ],
                    [
                        'email' => $ppdb->email,
                        'name' => $ppdb->user_detail->name,
                    ]
                );
            }

            if (!$ppdb->is_approved && $params['is_approved']) {
                $paramsEmail = [];
                $paramsEmail['ppdb'] = $ppdb;
                $paramsEmail['pembayaran_item'] = $pembayaran_item;
                $paramsEmail['mail_type'] = 'new_payment';
                $paramsEmail['is_approved'] = $params['is_approved'];
                $paramsEmail['created_at'] = $ppdb->created_at;
                $paramsEmail['paid_at'] = $ppdb->created_at;
                $paramsEmail['nama'] = $ppdb->nama;
                $paramsEmail['nis'] = $params['nis'];
                $paramsEmail['nik'] = $ppdb->nik_siswa;
                $paramsEmail['biaya_daftar'] = (int) $ppdb->biaya_daftar ?? 0;
                $paramsEmail['biaya_daftar_paid'] = (int) ($pembayaran_item['Biaya Daftar']['nominal'] ?? 0);
                $paramsEmail['biaya_daftar_sisa'] = $paramsEmail['biaya_daftar'] - $paramsEmail['biaya_daftar_paid'];
                $paramsEmail['biaya_kk'] = (int) $ppdb->biaya_kk ?? 0;
                $paramsEmail['biaya_kk_paid'] = (int) ($pembayaran_item['Biaya Kelas Khusus']['nominal'] ?? 0);
                $paramsEmail['biaya_kk_sisa'] = $paramsEmail['biaya_kk'] - $paramsEmail['biaya_kk_paid'];
                $paramsEmail['biaya_program'] = (int) $ppdb->biaya_program ?? 0;
                $paramsEmail['biaya_program_paid'] = (int) ($pembayaran_item['Biaya Program']['nominal'] ?? 0);
                $paramsEmail['biaya_program_sisa'] = $paramsEmail['biaya_program'] - $paramsEmail['biaya_program_paid'];
                $paramsEmail['biaya_spp'] = (int) $ppdb->biaya_spp ?? 0;
                $paramsEmail['biaya_spp_paid'] = (int) ($pembayaran_item['Biaya SPP']['nominal'] ?? 0);
                $paramsEmail['biaya_spp_sisa'] = $paramsEmail['biaya_spp'] - $paramsEmail['biaya_spp_paid'];
                $paramsEmail['wakaf'] = (int) $ppdb->wakaf ?? 0;
                $paramsEmail['wakaf_paid'] = !empty($pembayaran_item['Biaya Wakaf']) ?
                    (int) $pembayaran_item['Biaya Wakaf']['nominal'] :
                    0;
                $paramsEmail['wakaf_sisa'] = $paramsEmail['wakaf'] - $paramsEmail['wakaf_paid'];
                $paramsEmail['infaq'] = (int) $ppdb->infaq ?? 0;
                $paramsEmail['infaq_paid'] = !empty($pembayaran_item['Biaya Infaq & Sedekah']) ?
                    (int) $pembayaran_item['Biaya Infaq & Sedekah']['nominal'] :
                    0;
                $paramsEmail['infaq_sisa'] = $paramsEmail['infaq'] - $paramsEmail['infaq_paid'];
                $paramsEmail['subtotal_spp_program_pendaftaran'] = $paramsEmail['biaya_daftar'] + $paramsEmail['biaya_program'] + $paramsEmail['biaya_spp'];
                $paramsEmail['subtotal_spp_pendaftaran'] = $paramsEmail['biaya_daftar'] + $paramsEmail['biaya_spp'];
                $paramsEmail['discount'] = !empty($ppdb->discount) ? ($ppdb->discount_type == 'fixed_amount' ? $ppdb->discount
                    : $paramsEmail['biaya_spp'] * $ppdb->discount / 100) : 0;
                $paramsEmail['subtotal_spp_program_pendaftaran_discount'] = $paramsEmail['subtotal_spp_program_pendaftaran'] - $paramsEmail['discount'];
                $paramsEmail['subtotal_spp_pendaftaran_discount'] = $paramsEmail['subtotal_spp_pendaftaran'] - $paramsEmail['discount'];
                $paramsEmail['sub_wakaf_infaq'] = $paramsEmail['wakaf'] + $paramsEmail['infaq'];
                $paramsEmail['subtotal_biaya'] = (($paramsEmail['biaya_program'] == 0) ? 
                    $paramsEmail['subtotal_spp_pendaftaran_discount'] + $paramsEmail['sub_wakaf_infaq'] :
                    $paramsEmail['subtotal_spp_program_pendaftaran_discount'] + $paramsEmail['sub_wakaf_infaq']
                );
                $paramsEmail['subtotal_paid'] = $paramsEmail['biaya_daftar_paid'] + $paramsEmail['biaya_program_paid'] + $paramsEmail['biaya_spp_paid'] + $paramsEmail['wakaf_paid'] + $paramsEmail['infaq_paid'] - $paramsEmail['discount'];
                $paramsEmail['deposit'] = ($paramsEmail['subtotal_paid'] > $paramsEmail['subtotal_biaya']) ? $paramsEmail['subtotal_paid'] - $paramsEmail['subtotal_biaya'] : 0;
                $paramsEmail['subtotal_sisa'] = ($paramsEmail['biaya_daftar_sisa'] + $paramsEmail['biaya_program_sisa'] + $paramsEmail['biaya_spp_sisa'] + $paramsEmail['wakaf_sisa'] + $paramsEmail['infaq_sisa']);
                $paramsEmail['total_tagihan'] = $paramsEmail['subtotal_sisa'] - $paramsEmail['deposit'];

                // Update status tagihan, is_paid, dan is_approve
                $tagihan_id = null;
                $pembayaran_nominal = null;
                $pembayaran = PembayaranModel::where('source_table', 'ppdb')
                    ->where('source_id', $ppdb->id)
                    ->first();
                $tagihan_id = $pembayaran->tagihan_id;
                $pembayaran_nominal = $pembayaran->nominal;
                $pembayaran->is_paid = true;
                $pembayaran->is_approved = true;
                $pembayaran->save();

                
                $tagihan = TagihanModel::where('id', $tagihan_id)->first();
                $tagihan_TotalTagihan = $tagihan->total_tagihan;
                $tagihan_Nominal = $tagihan->nominal + $pembayaran_nominal;

                $status_tagihan = '';
                if ($tagihan_TotalTagihan == $tagihan_Nominal) {
                    $status_tagihan = TagihanModel::STATUS_LUNAS;
                } elseif ($tagihan_TotalTagihan > $tagihan_Nominal) {
                    $status_tagihan = TagihanModel::STATUS_LUNAS_SEBAGIAN;
                }
                $tagihan->nominal = $tagihan_Nominal;
                $tagihan->status = $status_tagihan;
                $tagihan->save();

                // Cek rombel
                $rombel = RombelModel::where('ppdb_id', $ppdb->id)
                    ->where('tahun_akademik_id', $ppdb->tahun_akademik_id)
                    ->first();
                
                if(!empty($rombel)){
                    $rombel->is_active = true;
                    $rombel->save();
                }else{
                    $rombel = RombelModel::create([
                        'ppdb_id' => $ppdb->id,
                        'tahun_akademik_id' => !empty($ppdb->tahun_akademik_id) ? $ppdb->tahun_akademik_id : null,
                        'kelas_id' => !empty($ppdb->kelas_id) ? $ppdb->kelas_id : null,
                        'is_active' => true,
                    ]);
                }

                SendEmailJob::dispatch(
                    $paramsEmail,
                    [
                        'email' => $ppdb->email,
                        'name' => $ppdb->user_detail->name,
                    ]
                );
            }

            $ppdb->update($params);

            DB::commit();
            return response()->json(['error' => false, 'message' => null, 'data' => $ppdb], 200);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => true, 'message' => $e->getMessage()], 400);
        } catch (\Throwable $e) {
            DB::rollBack();
            return response()->json(['error' => true, 'message' => $e->getMessage()], 400);
        }
    }

    public function changePPDBPassword(Request $request)
    {
        DB::beginTransaction();
        try {
            $id = !empty($request->get('id')) ? $request->get('id') : null;
            $password = !empty($request->get('password')) ? $request->get('password') : null;
            $ppdb = PpdbModel::find($id);
            if (empty($ppdb)) {
                return response()->json(['error' => true, 'message' => 'ppdb tidak ditemukan'], 400); 
            }
            $user = User::where('id', $ppdb->user_id)->update([
                'password' => bcrypt($password),
            ]);

            DB::commit();
            return response()->json(['error' => false, 'message' => null, 'data' => $user], 200);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => true, 'message' => $e->getMessage()], 400);
        }
    }

    public function changePassword(Request $request)
    {
        DB::beginTransaction();
        try {
            if (empty($request->password)) throw new Exception("Mohon isi password dengan benar");
            $user = auth()->user();
            $user->password = bcrypt($request->password);
            $user->save();

            DB::commit();
            return response()->json(['error' => false, 'message' => null, 'data' => $user], 200);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => true, 'message' => $e->getMessage()], 400);
        }
    }

    public function updateProfile(UpdateProfileRequest $request)
    {
        DB::beginTransaction();
        try {
            $id = auth()->user()->id;

            if (empty($id)) {
                return response()->json(['error' => true, 'message' => 'ppdb not found'], 400);
            }

            $ppdb = PpdbModel::with([
                'user_detail',
                'layanan_kelas',
                'paket_kelas',
                'paket_spp',
                'kelas',
            ])->where('user_id', $id)->first();

            if (empty($ppdb)) {
                return response()->json(['error' => true, 'message' => 'ppdb not found'], 400);
            }

            $params = $request->validated();
            $params['kelamin'] = $params['jenis_kelamin'];

            $ppdb->update($params);

            DB::commit();
            return response()->json(['error' => false, 'message' => null, 'data' => $ppdb], 200);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => true, 'message' => $e->getMessage()], 400);
        } catch (\Throwable $e) {
            DB::rollBack();
            return response()->json(['error' => true, 'message' => $e->getMessage()], 400);
        }
    }

    private function savePayment($ppdb, $data)
    {
        if (
            !empty($data['bayar_program']) ||
            !empty($data['bayar_spp']) ||
            !empty($data['bayar_daftar']) ||
            !empty($data['bayar_wakaf']) ||
            !empty($data['bayar_infaq'])
        ) {
            // Params for `tagihan` table
            $paramsBill = [
                'type' => $data['type'],
                'keterangan' => "Pembayaran pertama pendaftaran baru",
                'source_table' => $data['source_table'],
                'source_id' => $data['source_id'],
                'ppdb_id' => $data['ppdb_id'],
                'tagihan' => $data['tagihan'],
                'voucher_id' => $data['voucher_id'],
                'total_tagihan' => $data['total_tagihan'],
                'nominal' => 0,
                'status' => TagihanModel::BELUM_DIKONFIRMASI,
            ];
            // Save
            $tagihan = TagihanModel::create($paramsBill);


            // Pembayaran
            $total_bayar = 0;
            $total_bayar += $data['bayar_program'] ?? 0;
            $total_bayar += $data['bayar_daftar'] ?? 0;
            $total_bayar += $data['bayar_kk'] ?? 0;
            $total_bayar += $data['bayar_spp'] ?? 0;
            $total_bayar += $data['bayar_wakaf'] ?? 0;
            $total_bayar += $data['bayar_infaq'] ?? 0;

            $paramsPayment = [
                'type' => PembayaranModel::TYPE_BARU,
                'keterangan' => "Pembayaran pertama pendaftaran baru",
                'bank_name' => $data['bank_name'],
                'bank_account_number' => $data['bank_account_number'],
                'bank_account_name' => $data['bank_account_name'],
                'source_table' => 'ppdb',
                'source_id' => $ppdb->id,
                'nominal' => $total_bayar - $data['nominal_diskon'],
                'tagihan' => $data['tagihan'],
                'voucher_id' => $data['voucher_id'] ?? null,
                'total_tagihan' => $data['total_tagihan'],
                'note' => null,
                'url_bukti_trf' => $data['url_bukti_trf'] ?? null,
                'url_bukti_trf_infaq' => $data['url_bukti_trf_infaq'] ?? null,
                'is_paid' => false,
                'is_approved' => false,
                'tagihan_id' => $tagihan->id,
            ];

            $pembayaran = PembayaranModel::where('source_table', 'ppdb')
                ->where('source_id', $ppdb->id)
                ->where('type', PembayaranModel::TYPE_BARU)
                ->first();
            if (empty($pembayaran)) {
                $pembayaran = PembayaranModel::create($paramsPayment);
            } else {
                $pembayaran->update($paramsPayment);
            }

            $paramsBillItems = [];
            $paramsPaymentItems = [];
            if (!empty($data['biaya_daftar'])) {
                $paramsBillItems[] = [
                    'tagihan_id' => $tagihan->id,
                    'item' => 'Biaya Daftar',
                    'nominal' => $data['biaya_daftar'],
                ];
            }

            if (!empty($data['biaya_spp'])) {
                $paramsBillItems[] = [
                    'tagihan_id' => $tagihan->id,
                    'item' => 'Biaya SPP',
                    'nominal' => $data['biaya_spp'],
                ];
            }

            if (!empty($data['biaya_program'])) {
                $paramsBillItems[] = [
                    'tagihan_id' => $tagihan->id,
                    'item' => 'Biaya Program',
                    'nominal' => $data['biaya_program'],
                ];
            }

            if (!empty($data['bayar_program'])) {
                $paramsPaymentItems[] = [
                    'pembayaran_id' => $pembayaran->id,
                    'item' => 'Biaya Program',
                    'nominal' => $data['bayar_program'],
                ];
            }

            if (!empty($data['bayar_daftar'])) {
                $paramsPaymentItems[] = [
                    'pembayaran_id' => $pembayaran->id,
                    'item' => 'Biaya Daftar',
                    'nominal' => $data['bayar_daftar'],
                ];
            }

            if (!empty($data['bayar_kk'])) {
                $paramsPaymentItems[] = [
                    'pembayaran_id' => $pembayaran->id,
                    'item' => 'Biaya Kelas Khusus',
                    'nominal' => $data['bayar_kk'],
                ];
            }

            if (!empty($data['bayar_spp'])) {
                $paramsPaymentItems[] = [
                    'pembayaran_id' => $pembayaran->id,
                    'item' => 'Biaya SPP',
                    'nominal' => $data['bayar_spp'],
                ];
            }

            if (!empty($data['bayar_wakaf'])) {
                $paramsBillItems[] = [
                    'tagihan_id' => $tagihan->id,
                    'item' => 'Biaya Wakaf',
                    'nominal' => $data['bayar_wakaf'],
                ];

                $paramsPaymentItems[] = [
                    'pembayaran_id' => $pembayaran->id,
                    'item' => 'Biaya Wakaf',
                    'nominal' => $data['bayar_wakaf'],
                ];
            }

            if (!empty($data['bayar_infaq'])) {
                $paramsBillItems[] = [
                    'tagihan_id' => $tagihan->id,
                    'item' => 'Biaya Infaq & Sedekah',
                    'nominal' => $data['bayar_infaq'],
                ];

                $paramsPaymentItems[] = [
                    'pembayaran_id' => $pembayaran->id,
                    'item' => 'Biaya Infaq & Sedekah',
                    'nominal' => $data['bayar_infaq'],
                ];
            }

            // Save to `tagihan_items` table
            TagihanItemsModel::insert($paramsBillItems);

            PembayaranItemsModel::where('pembayaran_id', $pembayaran->id)->delete();
            PembayaranItemsModel::insert($paramsPaymentItems);

            return true;
        }
        return false;
    }

    public function uploadDocument(Request $request)
    {
        DB::beginTransaction();
        try {
            $ppdb = PpdbModel::where('id', $request->ppdb_id)->first();
            
            $storeDocumentPath = null;
            if (!empty($request->dokumen_ktp_orang_tua)) {
                $storeDocumentPath = Storage::disk('public_path')->put('dokumen_ppdb', $request->dokumen_ktp_orang_tua);
                $ppdb->dokumen_ktp_orang_tua = url('/') . '/uploads/' . $storeDocumentPath;
                $ppdb->is_ktp_approved = 0;
            } else if (!empty($request->dokumen_akta_kelahiran)) {
                $storeDocumentPath = Storage::disk('public_path')->put('dokumen_ppdb', $request->dokumen_akta_kelahiran);
                $ppdb->dokumen_akta_kelahiran = url('/') . '/uploads/' . $storeDocumentPath;
                $ppdb->is_akta_approved = 0;
            } else if (!empty($request->dokumen_shun_skhun)) {
                $storeDocumentPath = Storage::disk('public_path')->put('dokumen_ppdb', $request->dokumen_shun_skhun);
                $ppdb->dokumen_shun_skhun = url('/') . '/uploads/' . $storeDocumentPath;
                $ppdb->is_shun_skhun_approved = 0;
            } else if (!empty($request->dokumen_kartu_keluarga)) {
                $storeDocumentPath = Storage::disk('public_path')->put('dokumen_ppdb', $request->dokumen_kartu_keluarga);
                $ppdb->dokumen_kartu_keluarga = url('/') . '/uploads/' . $storeDocumentPath;
                $ppdb->is_kk_approved = 0;
            } else if (!empty($request->dokumen_ijasah)) {
                $storeDocumentPath = Storage::disk('public_path')->put('dokumen_ppdb', $request->dokumen_ijasah);
                $ppdb->dokumen_ijasah =url('/') . '/uploads/' .  $storeDocumentPath;
                $ppdb->is_ijasah_approved = 0;
            }

            $ppdb->save();
            DB::commit();
            return response()->json(['error' => false, 'message' => 'Upload dokumen berhasil!', 'data' => null], 200);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => true, 'message' => $e->getMessage()], 400);
        } catch (\Throwable $e) {
            DB::rollBack();
            return response()->json(['error' => true, 'message' => $e->getMessage()], 400);
        }
    }

    public function confirmDocument(Request $request)
    {
        DB::beginTransaction();
        try {
            $ppdb = PpdbModel::where('id', $request->ppdb_id)->first();
            $document = $request->document;
            
            if ($document == 'dokumen_ktp_orang_tua') {
                $ppdb->is_ktp_approved = 1;
            } else if ($document == 'dokumen_akta_kelahiran') {
                $ppdb->is_akta_approved = 1;
            } else if ($document == 'dokumen_shun_skhun') {
                $ppdb->is_shun_skhun_approved = 1;
            } else if ($document == 'dokumen_kartu_keluarga') {
                $ppdb->is_kk_approved = 1;
            } else if ($document == 'dokumen_ijasah') {
                $ppdb->is_ijasah_approved = 1;
            }

            $ppdb->save();
            DB::commit();
            return response()->json(['error' => false, 'message' => 'Dokumen berhasil diverifikasi!', 'data' => null], 200);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => true, 'message' => $e->getMessage()], 400);
        } catch (\Throwable $e) {
            DB::rollBack();
            return response()->json(['error' => true, 'message' => $e->getMessage()], 400);
        }
    }

    public function updateWbPhoto(Request $request)
    {
        $request->validate([
            'ppdb_id' => 'required|exists:ppdb,id',
            'foto_warga_belajar' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        DB::beginTransaction();
        try {
            $ppdb = PpdbModel::where('id', $request->ppdb_id)->first();
            $storeDocumentPath = Storage::disk('public_path')->put('foto_wb', $request->foto_warga_belajar);
            // Delete old photo
            if (!empty($ppdb->url_foto_wb)) {
                $oldPhoto = str_replace(url('/') . '/', '', $ppdb->url_foto_wb);
                if (file_exists($oldPhoto)) {
                    unlink($oldPhoto);
                }
            }

            $ppdb->url_foto_wb = url('/') . '/uploads/' . $storeDocumentPath;
            $ppdb->save();

            DB::commit();
            return response()->json(['error' => false, 'message' => 'Foto warga belajar berhasil!', 'data' => null], 200);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => true, 'message' => $e->getMessage()], 400);
        } catch (\Throwable $e) {
            DB::rollBack();
            return response()->json(['error' => true, 'message' => $e->getMessage()], 400);
        }
    }

    public function updateStudentCard(Request $request)
    {
        $request->validate([
            'ppdb_id' => 'required|exists:ppdb,id',
            'kartu_pelajar' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        DB::beginTransaction();
        try {
            $ppdb = PpdbModel::where('id', $request->ppdb_id)->first();

            $extension = $request->file('kartu_pelajar')->getClientOriginalExtension();
            $filename = ($ppdb->nis ?? Str::uuid()) . '.' . $extension;
            $storeDocumentPath = $request->file('kartu_pelajar')->storeAs('kartu_pelajar', $filename, 'public_path');

            // Delete old photo
            if (!empty($ppdb->url_kartu_pelajar)) {
                $kartu_pelajar_path = $ppdb->url_kartu_pelajar;
                if (file_exists(public_path('uploads') . $kartu_pelajar_path)) {
                    unlink(public_path('uploads') . $kartu_pelajar_path);
                }
            }

            $ppdb->url_kartu_pelajar = '/' . $storeDocumentPath;
            $ppdb->save();

            DB::commit();
            return response()->json(['error' => false, 'message' => 'Kartu pelajar berhasil diubah!', 'data' => null], 200);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => true, 'message' => $e->getMessage()], 400);
        } catch (\Throwable $e) {
            DB::rollBack();
            return response()->json(['error' => true, 'message' => $e->getMessage()], 400);
        }
    }

    public function getAccountStatus($ppdb_id)
    {
        $ppdb = PpdbModel::where('id', $ppdb_id)->first();
        $user = User::where('id', $ppdb->user_id)->first();
        $status = $user->is_active;
        return response()->json(['error' => false, 'message' => 'Status akun berhasil didapatkan!', 'data' => $status], 200);
    }

    public function changeAccountStatus(Request $request)
    {
        DB::beginTransaction();
        try {
            $ppdb = PpdbModel::where('id', $request->id)->first();
            $user = User::where('id', $ppdb->user_id)->first();

            $user->is_active = $request->status;
            $user->save();

            DB::commit();
            return response()->json(['error' => false, 'message' => 'Status akun berhasil diubah!', 'data' => null], 200);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => true, 'message' => $e->getMessage()], 400);
        } catch (\Throwable $e) {
            DB::rollBack();
            return response()->json(['error' => true, 'message' => $e->getMessage()], 400);
        }
    }
}
