<?php

namespace App\Http\Controllers\Ajax;

use App\Http\Controllers\Controller;
use App\Http\Requests\PPDBUlang\CreateRequest;
use App\Http\Requests\PPDBUlang\UpdateRequest;
use App\Jobs\SendEmailJob;
use App\Models\PembayaranItemsModel;
use App\Models\PembayaranModel;
use App\Models\PpdbUlangModel;
use App\Models\RombelModel;
use App\Models\TagihanItemsModel;
use App\Models\TagihanModel;
use App\Models\VoucherModel;
use Illuminate\Http\Request;
use App\Utils\Constant;
use App\Utils\Misc;
use DB;
use Illuminate\Support\Facades\Storage;

class PpdbUlangController extends Controller
{
    public function get(Request $request)
    {
        try {
            $ppdb = PpdbUlangModel::with(['layanan_kelas','paket_kelas','paket_spp','kelas_detail','ppdb'])
                                    ->where('ppdb_id', $request->get('ppdb_id'))->first();
               
            return response()->json(['error' => false, 'message' => null, 'data' => $ppdb ], 200); 
        } catch (\Exception $e) {
            return response()->json(['error' => true, 'message' => $e->getMessage()], 400); 
        }catch (\Throwable $e) {
            return response()->json(['error' => true, 'message' => $e->getMessage()], 400); 
        }
    }

    public function create(CreateRequest $request)
    {
        // dd($request->all());
        DB::beginTransaction();
        try {
            $params = $request->validated();

            $storeFIlePath = null;
            if (!empty($params['url_bukti_trf'])) {
                $storeFIlePath = Storage::disk('public_path')->put('bukti_pembayaran', $params['url_bukti_trf']);
            }

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
                    $nominal_diskon = $voucher->discount;
                }

                $voucher->stok -= 1;
                $voucher->save();
            }

            // Pembayaran
            $bayar_program = $params['bayar_program'] ?? null;
            $bayar_daftar = $params['bayar_daftar'] ?? null;
            $bayar_spp = $params['bayar_spp'] ?? null;
            $bayar_wakaf = $params['wakaf'] ?? null;
            $bayar_infaq = $params['infaq'] ?? null;

            unset($params['bayar_program']);
            unset($params['bayar_daftar']);
            unset($params['bayar_spp']);
            unset($params['bayar_wakaf']);
            unset($params['bayar_infaq']);
            unset($params['url_bukti_trf']);

            // PPDB Ulang Creation
            $ppdb = PpdbUlangModel::create($params);

            $bill = (int) $params['biaya_spp'] + (int) $params['biaya_daftar'] + ((int) $params['wakaf'] ?? 0) + ((int) $params['infaq'] ?? 0);
            $already_paid = (int) $bayar_daftar + (int) $bayar_spp + (int) $bayar_wakaf + (int) $bayar_infaq - ((int) $nominal_diskon ?? 0);
            $paramsSavePayment = [
                'type' => TagihanModel::TYPE_DAFTAR_ULANG,
                'type_for_pembayaran' => $params['type'],
                'source_table' => 'ppdb_ulang',
                'source_id' => $params['user_id'],
                'ppdb_id' => $params['ppdb_id'],
                'tagihan' => $bill,
                'total_tagihan' => $bill - ((int) $nominal_diskon ?? 0),
                'nominal' => $already_paid,
                'biaya_daftar' => (int) $params['biaya_daftar'],
                'biaya_spp' => (int) $params['biaya_spp'],

                'subtotal_spp_pendaftaran' => ((int) $ppdb->biaya_daftar ?? 0) + ((int) $ppdb->biaya_spp ?? 0),
                'bayar_program' => $bayar_program ?? 0,
                'bayar_daftar' => $bayar_daftar,
                'bayar_spp' => $bayar_spp,
                'bayar_wakaf' => $bayar_wakaf,
                'bayar_infaq' => $bayar_infaq,
                'voucher_id' => $voucher_id,
                'bank_name' => $params['bank_name'],
                'bank_account_number' => $params['bank_account_number'],
                'bank_account_name' => $params['bank_account_name'],
                'url_bukti_trf' => !empty($storeFIlePath) ? url('/').'/uploads/'.$storeFIlePath : null,
            ];

            $savePayment = $this->savePayment($ppdb, $paramsSavePayment);
            $ppdb = PpdbUlangModel::with([
                'user_detail',
                'layanan_kelas',
                'paket_kelas',
                'paket_spp',
                'kelas_detail',
                'ppdb',
            ])->find((int) $ppdb->id);
            if ($savePayment) {
                $paramsEmail = [];
                $paramsEmail['ppdb'] = $ppdb->ppdb;
                $paramsEmail['mail_type'] = 'new_payment';
                $paramsEmail['is_approved'] = false;
                $paramsEmail['created_at'] = $ppdb->created_at;
                $paramsEmail['paid_at'] = $ppdb->created_at;
                $paramsEmail['nama'] = $ppdb->ppdb->nama;
                $paramsEmail['nis'] = $ppdb->ppdb->nis;
                $paramsEmail['nik'] = $ppdb->ppdb->nik_siswa;
                $paramsEmail['biaya_daftar'] = (int) $ppdb->biaya_daftar ?? 0;
                $paramsEmail['biaya_daftar_paid'] = 0;
                $paramsEmail['biaya_daftar_sisa'] = $paramsEmail['biaya_daftar'] - $paramsEmail['biaya_daftar_paid'];
                $paramsEmail['biaya_spp'] = (int) $ppdb->biaya_spp ?? 0;
                $paramsEmail['biaya_spp_paid'] = 0;
                $paramsEmail['biaya_spp_sisa'] = $paramsEmail['biaya_spp'] - $paramsEmail['biaya_spp_paid'];
                $paramsEmail['wakaf'] = (int) $ppdb->wakaf ?? 0;
                $paramsEmail['wakaf_paid'] = 0;
                $paramsEmail['wakaf_sisa'] = $paramsEmail['wakaf'] - $paramsEmail['wakaf_paid'];
                $paramsEmail['infaq'] = (int) $ppdb->infaq ?? 0;
                $paramsEmail['infaq_paid'] = 0;
                $paramsEmail['infaq_sisa'] = $paramsEmail['infaq'] - $paramsEmail['infaq_paid'];
                $paramsEmail['subtotal_spp_pendaftaran'] = $paramsEmail['biaya_daftar'] + $paramsEmail['biaya_spp'];
                $paramsEmail['discount'] = !empty($ppdb->discount) ? ($ppdb->discount_type == 'fixed_amount' ? $ppdb->discount 
                    : $paramsEmail['subtotal_spp_pendaftaran'] * $ppdb->discount / 100) : 0;
                $paramsEmail['subtotal_spp_pendaftaran_discount'] = $paramsEmail['subtotal_spp_pendaftaran'] - $paramsEmail['discount'];
                $paramsEmail['sub_wakaf_infaq'] = $paramsEmail['wakaf'] + $paramsEmail['infaq'];
                $paramsEmail['subtotal_biaya'] = $paramsEmail['subtotal_spp_pendaftaran_discount'] + $paramsEmail['sub_wakaf_infaq'];
                
                $paramsEmail['subtotal_paid'] = $paramsEmail['biaya_daftar_paid'] + $paramsEmail['biaya_spp_paid'] + $paramsEmail['wakaf_paid'] + $paramsEmail['infaq_paid'] - $paramsEmail['discount'];
                $paramsEmail['deposit'] = ($paramsEmail['subtotal_paid'] > $paramsEmail['subtotal_biaya']) ? $paramsEmail['subtotal_paid'] - $paramsEmail['subtotal_biaya'] : 0;
                $paramsEmail['subtotal_sisa'] = ($paramsEmail['biaya_daftar_sisa'] + $paramsEmail['biaya_spp_sisa'] + $paramsEmail['wakaf_sisa'] + $paramsEmail['infaq_sisa']);
                $paramsEmail['total_tagihan'] = $paramsEmail['subtotal_sisa'] - $paramsEmail['deposit'] - $paramsEmail['discount'];

                SendEmailJob::dispatch(
                    $paramsEmail,
                    [
                        'email' => $ppdb->ppdb->email,
                        'name' => $ppdb->user_detail->name,
                    ]
                );
            }

            DB::commit();
            return response()->json(['error' => false, 'message' => null, 'data' => $ppdb ], 200);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => true, 'message' => $e->getMessage()], 400); 
        }catch (\Throwable $e) {
            DB::rollBack();
            return response()->json(['error' => true, 'message' => $e->getMessage()], 400); 
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

            $ppdb = PpdbUlangModel::with([
                'user_detail',
                'layanan_kelas',
                'paket_kelas',
                'paket_spp',
                'kelas_detail',
                'ppdb',
            ])->find((int) $id);

            // Mendapatkan data tabel pembayaran_items
            $pembayaran_item = [];
            $pembayaran_item_query = PpdbUlangModel::select('pay_items.id','pay_items.pembayaran_id','pay_items.item','pay_items.nominal')
                                        ->join('pembayaran as pay', 'pay.source_id', '=', 'ppdb_ulang.ppdb_id')
                                        ->join('pembayaran_items as pay_items', 'pay_items.pembayaran_id', '=', 'pay.id')
                                        ->where('ppdb_ulang.id', $id)
                                        ->where('pay.source_table', 'ppdb_ulang')
                                        ->get()
                                        ->toArray();

            // Mengubah index result menjadi kolom item
            array_map(function($item) use (&$pembayaran_item) {
                $pembayaran_item[$item['item']] = $item;
            }, $pembayaran_item_query);


            if (empty($ppdb)) {
                return response()->json(['error' => true, 'message' => 'ppdb not found'], 400); 
            }
            
            $params = $request->validated();
            $params['is_approved'] = !empty($params['is_approved']) ? Misc::castBoolean($params['is_approved']) : false;
            $params['nis'] = $ppdb->nis;

            if (!$ppdb->ppdb->is_approved && $params['is_approved']) {
                $paramsEmail = [];
                $paramsEmail['ppdb'] = $ppdb->ppdb;
                $paramsEmail['pembayaran_item'] = $pembayaran_item;
                $paramsEmail['mail_type'] = 'new_payment';
                $paramsEmail['is_approved'] = $params['is_approved'];
                $paramsEmail['created_at'] = $paramsEmail['ppdb']->created_at;
                $paramsEmail['paid_at'] = $paramsEmail['ppdb']->created_at;
                $paramsEmail['nama'] = $paramsEmail['ppdb']->nama;
                $paramsEmail['nis'] = $paramsEmail['ppdb']->nis;
                $paramsEmail['nik'] = $paramsEmail['ppdb']->nik_siswa;
                $paramsEmail['biaya_daftar'] = (int) $ppdb->biaya_daftar ?? 0;
                $paramsEmail['biaya_daftar_paid'] = (int) $pembayaran_item['Biaya Daftar']['nominal'] ?? 0;
                $paramsEmail['biaya_daftar_sisa'] = $paramsEmail['biaya_daftar'] - $paramsEmail['biaya_daftar_paid'];
                $paramsEmail['biaya_spp'] = (int) $ppdb->biaya_spp ?? 0;
                $paramsEmail['biaya_spp_paid'] = (int) $pembayaran_item['Biaya SPP']['nominal'] ?? 0;
                $paramsEmail['biaya_spp_sisa'] = $paramsEmail['biaya_spp'] - $paramsEmail['biaya_spp_paid'];
                $paramsEmail['wakaf'] = (int) $ppdb->wakaf ?? 0;
                $paramsEmail['wakaf_paid'] = (int) $pembayaran_item['Biaya Wakaf']['nominal'] ?? 0;
                $paramsEmail['wakaf_sisa'] = $paramsEmail['wakaf'] - $paramsEmail['wakaf_paid'];
                $paramsEmail['infaq'] = (int) $ppdb->infaq ?? 0;
                $paramsEmail['infaq_paid'] = (int) $pembayaran_item['Biaya Infaq & Sedekah']['nominal'] ?? 0;
                $paramsEmail['infaq_sisa'] = $paramsEmail['infaq'] - $paramsEmail['infaq_paid'];
                $paramsEmail['subtotal_spp_pendaftaran'] = $paramsEmail['biaya_daftar'] + $paramsEmail['biaya_spp'];
                $paramsEmail['discount'] = !empty($ppdb->discount) ? ($ppdb->discount_type == 'fixed_amount' ? $ppdb->discount 
                    : $paramsEmail['subtotal_spp_pendaftaran'] * $ppdb->discount / 100) : 0;
                $paramsEmail['subtotal_spp_pendaftaran_discount'] = $paramsEmail['subtotal_spp_pendaftaran'] - $paramsEmail['discount'];
                $paramsEmail['sub_wakaf_infaq'] = $paramsEmail['wakaf'] + $paramsEmail['infaq'];
                $paramsEmail['subtotal_biaya'] = $paramsEmail['subtotal_spp_pendaftaran_discount'] + $paramsEmail['sub_wakaf_infaq'];
                $paramsEmail['subtotal_paid'] = $paramsEmail['biaya_daftar_paid'] + $paramsEmail['biaya_spp_paid'] + $paramsEmail['wakaf_paid'] + $paramsEmail['infaq_paid'] - $paramsEmail['discount'];
                $paramsEmail['deposit'] = ($paramsEmail['subtotal_paid'] > $paramsEmail['subtotal_biaya']) ? $paramsEmail['subtotal_paid'] - $paramsEmail['subtotal_biaya'] : 0;
                $paramsEmail['subtotal_sisa'] = ($paramsEmail['biaya_daftar_sisa'] + $paramsEmail['biaya_spp_sisa'] + $paramsEmail['wakaf_sisa'] + $paramsEmail['infaq_sisa']);
                $paramsEmail['total_tagihan'] = $paramsEmail['subtotal_sisa'] - $paramsEmail['deposit'];

                // Update status is_paid dan is_approve
                $pembayaran = PembayaranModel::where('source_table', 'ppdb_ulang')
                                    ->where('source_id', $params['source_user_id'])
                                    ->first();
                $pembayaran->is_paid = true;
                $pembayaran->is_approved = true;
                $pembayaran->save();

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
                        'email' => $ppdb->ppdb->email,
                        'name' => $ppdb->user_detail->name,
                    ]
                );
            }

            $ppdb->update($params);

            DB::commit();
            return response()->json(['error' => false, 'message' => null, 'data' => $ppdb ], 200); 
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => true, 'message' => $e->getMessage()], 400); 
        }catch (\Throwable $e) {
            DB::rollBack();
            return response()->json(['error' => true, 'message' => $e->getMessage()], 400); 
        }
    }

    private function savePayment($ppdb, $data)
    {
        // dd($data['source_id']);
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
                'keterangan' => "Pembayaran daftar ulang",
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
            $total_bayar += $data['bayar_spp'] ?? 0;
            $total_bayar += $data['bayar_wakaf'] ?? 0;
            $total_bayar += $data['bayar_infaq'] ?? 0;

            $paramsPayment = [
                'type' => $data['type'],
                'keterangan' => "Pembayaran daftar ulang",
                'bank_name' => $data['bank_name'],
                'bank_account_number' => $data['bank_account_number'],
                'bank_account_name' => $data['bank_account_name'],
                'source_table' => 'ppdb_ulang',
                'source_id' => $data['ppdb_id'],
                'nominal' => $total_bayar - $ppdb->discount,
                'tagihan' => $data['tagihan'],
                'voucher_id' => $data['voucher_id'] ?? null,
                'total_tagihan' => $data['total_tagihan'],
                'note' => null,
                'url_bukti_trf' => $data['url_bukti_trf'] ?? null,
                'is_paid' => false,
                'is_approved' => false,
                'tagihan_id' => $tagihan->id,
            ];
            // dd($paramsPayment);

            $pembayaran = PembayaranModel::where('source_table', 'ppdb_ulang')
                ->where('source_id', $ppdb->id)
                ->where('type', PembayaranModel::TYPE_ULANG)
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
}
