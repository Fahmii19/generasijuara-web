<?php

namespace App\Http\Controllers\Ajax;

use App\Exports\ExportPembayaran;
use App\Http\Controllers\Controller;
use App\Jobs\SendEmailJob;
use App\Jobs\SendVerificationPpdbJob;
use App\Models\KelasModel;
use App\Models\PembayaranItemsModel;
use Illuminate\Http\Request;
use App\Models\PembayaranModel;
use App\Models\PpdbModel;
use App\Models\PpdbUlangModel;
use App\Models\RombelModel;
use App\Models\TagihanItemsModel;
use App\Models\TagihanModel;
use App\Models\TahunAkademikModel;
use App\Utils\Constant;
use App\Utils\Misc;
use Carbon\Carbon;
use DB;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Concerns\ToArray;
use Maatwebsite\Excel\Facades\Excel;

class PembayaranController extends Controller
{
    public function list(Request $request)
    {
        try {
            $ppdb_id = !empty($request->get('ppdb_id')) ? $request->get('ppdb_id') : null;
            $daftar_ulang = !empty($request->get('daftar_ulang')) ? $request->get('daftar_ulang') : null;
            
            $db = PembayaranModel::query()
                ->with(['items','voucher']);

            if (!empty($daftar_ulang)) {
                $db->where('type', PembayaranModel::TYPE_ULANG);
                $db->where('source_table', 'ppdb_ulang');
                $db->where('source_id', $ppdb_id);
            }
            
            if (!empty($ppdb_id) && $daftar_ulang != true) {
                $db->where('type', PembayaranModel::TYPE_BARU);
                $db->where('source_table', 'ppdb');
                $db->where('source_id', $ppdb_id);
            }
            return response()->json(['error' => false, 'message' => null, 'data' => $db->get() ], 200); 
        } catch (\Exception $e) {
            return response()->json(['error' => true, 'message' => $e->getMessage()], 400); 
        }catch (\Throwable $e) {
            return response()->json(['error' => true, 'message' => $e->getMessage()], 400); 
        }
    }

    public function getPembayaranById(Request $request)
    {
        try {
            $pembayaran_id = !empty($request->id) ? $request->id : null;

            $db = PembayaranModel::with(['items','ppdb','tagihan','tagihan.voucher'])->where('id', $pembayaran_id)->first();
            return response()->json(['error' => false, 'message' => null, 'data' => $db ], 200); 
        } catch (\Exception $e) {
            return response()->json(['error' => true, 'message' => $e->getMessage()], 400);
        } catch (\Throwable $e) {
            return response()->json(['error' => true, 'message' => $e->getMessage()], 400);
        }
    }

    public function getPembayaranItemsById(Request $request)
    {
        try {
            $pembayaran_id = !empty($request->id) ? $request->id : null;

            $db = PembayaranItemsModel::where('pembayaran_id', $pembayaran_id)->get();
            return response()->json(['error' => false, 'message' => null, 'data' => $db ], 200); 
        } catch (\Exception $e) {
            return response()->json(['error' => true, 'message' => $e->getMessage()], 400);
        } catch (\Throwable $e) {
            return response()->json(['error' => true, 'message' => $e->getMessage()], 400);
        }
    }

    public function getPembayaranByTagihanId(Request $request, $id)
    {
        try {
            $db = PembayaranModel::with(['items','ppdb','tagihan','tagihan.voucher'])
                                    ->where('tagihan_id', $id)
                                    ->get();
            return response()->json(['error' => false, 'message' => null, 'data' => $db ], 200); 
        } catch (\Exception $e) {
            return response()->json(['error' => true, 'message' => $e->getMessage()], 400);
        } catch (\Throwable $e) {
            return response()->json(['error' => true, 'message' => $e->getMessage()], 400);
        }
    }

    public function pelunasanPembayaran(Request $request)
    {
        DB::beginTransaction();
        try {
            // Insert into `pembayaran`
            $pembayaran = new PembayaranModel();
            $pembayaran->type = $request->type;
            $pembayaran->keterangan = $request->pelunasan_tagihan_ket;
            $pembayaran->bank_name = $request->bank_name;
            $pembayaran->bank_account_number = $request->bank_account_number;
            $pembayaran->bank_account_name = $request->bank_account_name;
            $pembayaran->source_table = $request->source_table;
            $pembayaran->source_id = $request->source_id;
            $pembayaran->nominal = $request->nominal_pelunasan;
            $pembayaran->tagihan = $request->pelunasan_tagihan;
            $pembayaran->total_tagihan = $request->pelunasan_total_tagihan;
            $storeFilePath = null;
            if (!empty($request->bukti_tf) && $request->bukti_tf != null) {
                $storeFilePath = Storage::disk('public_path')->put('bukti_pembayaran', $request->bukti_tf);
            }
            $pembayaran->url_bukti_trf = !empty($storeFilePath) ? url('/') . '/uploads/' . $storeFilePath : null;
            $pembayaran->is_paid = true;
            $pembayaran->is_approved = false;
            $pembayaran->tagihan_id = $request->tagihan_id;
            $pembayaran->save();

            // Insert into `pembayaran_items`
            $item_pelunasan = $request->item_pelunasan;
            foreach ($request->nominal as $key => $nominal_value) {
                if ($nominal_value != 0) {
                    $pembayaranItem[] = PembayaranItemsModel::create([
                        'pembayaran_id' => $pembayaran->id,
                        'item' => $item_pelunasan[$key],
                        'nominal' => $nominal_value,
                    ]);
                }
            }

            // Update tabel `tagihan`
            $tagihan = TagihanModel::where('id', $request->tagihan_id)->first();
            // $tagihan->nominal = $tagihan->nominal + $request->nominal_pelunasan;
            $tagihan->status = 'perlu konfirmasi';
            $tagihan->save();


            DB::commit();
            return response()->json(['error' => false, 'message' => null, 'data' => null ], 200); 
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => true, 'message' => $e->getMessage(), 'trace' => $e->getTrace()], 400);
        } catch (\Throwable $e) {
            DB::rollBack();
            return response()->json(['error' => true, 'message' => $e->getMessage(), 'trace' => $e->getTrace()], 400);
        }
    }

    public function konfirmasiPembayaran(Request $request)
    {
        DB::beginTransaction();
        try {
            $pembayaran_nominal = null;
            $pembayaran = PembayaranModel::where('id', $request->pembayaran_id)->first();
            $pembayaran_nominal = $pembayaran->nominal;
            $pembayaran->is_paid = true;
            $pembayaran->is_approved = true;

            $ppdb_id = null;
            $tagihan = TagihanModel::where('id', $request->tagihan_id)->first();
            $tagihan_Nominal = $tagihan->nominal + $pembayaran_nominal;
            $ppdb_id = $tagihan->ppdb_id;
            $status_tagihan = '';
            $isPaidOff = false;
            if ($tagihan->total_tagihan == $tagihan_Nominal) {
                $status_tagihan = TagihanModel::STATUS_LUNAS;
                $isPaidOff = true;
            } elseif ($tagihan->total_tagihan > $tagihan_Nominal) {
                $status_tagihan = TagihanModel::STATUS_LUNAS_SEBAGIAN;
            }
            // dd($request->tagihan_id.".".$tagihan."+".$pembayaran_nominal);
            $tagihan->nominal = $tagihan_Nominal;
            $tagihan->status = $status_tagihan;
            
            
            $ppdb = PpdbModel::with(['user_detail'])
                        ->where('id', $ppdb_id)
                        ->first();
            $ppdb->is_approved = true;

            if (!$ppdb->is_active && empty($ppdb->nis)) {
                $nis = PpdbModel::generateNis();
                $password = Constant::PPDB_DEFAULT_PASSWORD;
                $username = $nis ?? $ppdb->user_detail->email;
                $tgl_terima = date('Y-m-d');
                
                $ppdb->nis = $nis;
                $ppdb->is_active = true;
                $ppdb->tgl_terima = $tgl_terima;

                $ppdb->user_detail->password = bcrypt($password);
                $ppdb->user_detail->username = $username;
                $ppdb->user_detail->is_active = true;
                $ppdb->user_detail->save();

                SendVerificationPpdbJob::dispatch(
                    [
                        'name' => $ppdb->user_detail->name,
                        'username' => $username,
                        'nik' => $ppdb->nik_siswa,
                        'password' => $password,
                    ],
                    [
                        'email' => $ppdb->email,
                        'name' => $ppdb->user_detail->name,
                    ]
                );
            }

            $ppdb->save();

            
            // Cek rombel
            $rombel = RombelModel::where('ppdb_id', $ppdb->id)
                ->where('tahun_akademik_id', $ppdb->tahun_akademik_id)
                ->first();
            
            if(!empty($rombel)){
                // Update rombel
                $rombel->is_active = true;
                $rombel->save();
            }else{
                // Create rombel
                $rombel = RombelModel::create([
                    'ppdb_id' => $ppdb->id,
                    'tahun_akademik_id' => !empty($ppdb->tahun_akademik_id) ? $ppdb->tahun_akademik_id : null,
                    'kelas_id' => !empty($ppdb->kelas_id) ? $ppdb->kelas_id : null,
                    'status_wb' => 'Baru',
                    'is_active' => true,
                ]);
            }
            
            // Update is_active rombel & ppdb_ulang
            $tahun_akademik_active = TahunAkademikModel::where('is_active', true)->first();
            if ($tagihan->type == TagihanModel::TYPE_DAFTAR_ULANG) {
                # Update Rombel
                $rombel = RombelModel::where('ppdb_id', $ppdb_id)
                                    ->where('tahun_akademik_id', $tahun_akademik_active->id)
                                    ->first();
                $rombel->is_active = true;
                $rombel->save();

                # Update Ppdb Ulang
                $ppdb_ulang = PpdbUlangModel::where('ppdb_id', $ppdb_id)
                                        ->where('tahun_akademik_id', $tahun_akademik_active->id)
                                        ->first();
                
                $ppdb_ulang->is_active = true;
                $ppdb_ulang->save();
            }
            
            // Mendapatkan data tabel pembayaran_items
            $pembayaran_item = [];
            $pembayaran_item_query = PpdbModel::select('pay_items.id', 'pay_items.pembayaran_id', 'pay_items.item', 'pay_items.nominal')
                                                ->join('pembayaran as pay', 'pay.source_id', '=', 'ppdb.id')
                                                ->join('pembayaran_items as pay_items', 'pay_items.pembayaran_id', '=', 'pay.id')
                                                ->where('ppdb.id', $ppdb_id)
                                                ->where('pay_items.pembayaran_id', $request->pembayaran_id)
                                                ->get()
                                                ->toArray();
            // Mengubah index result menjadi kolom item
            array_map(function ($item) use (&$pembayaran_item) {
                $pembayaran_item[$item['item']] = $item;
            }, $pembayaran_item_query);
            

            // Tagihan Item
            $tagihan_item = [];
            $tagihan_item_query = TagihanItemsModel::selectRaw('item, nominal AS biaya')
                                                    ->where('tagihan_id', $request->tagihan_id)
                                                    ->get()
                                                    ->toArray();
            array_map(function ($item) use (&$tagihan_item) {
                $tagihan_item[$item['item']] = $item;
            }, $tagihan_item_query);


            // Mendapatkan total yang sudah dibayar
            $terbayar = [];
            $terbayar_query = PembayaranItemsModel::selectRaw("pembayaran.tagihan_id, pembayaran_items.item, SUM(pembayaran_items.nominal) as terbayar")
                                ->leftJoin('pembayaran','pembayaran.id','=','pembayaran_items.pembayaran_id')
                                ->where('pembayaran.tagihan_id', $request->tagihan_id)
                                ->where('pembayaran.is_approved', 1)
                                ->groupBy('pembayaran.tagihan_id','pembayaran_items.item')
                                ->get()
                                ->toArray();
            array_map(function ($item) use (&$terbayar) {
                $terbayar[$item['item']] = $item;
            }, $terbayar_query);


            // Mendapatkan data item tagihan
            $tagihan_item_list = [];
            (int) $subtotal_tagihan = 0;
            (int) $subtotal_spp_pendaftaran = 0;

            foreach ($tagihan_item as $key => $value) {
                $tagihan_item_list[] = $key;
                $subtotal_tagihan += $value['biaya'];
                if ($key == 'Biaya Daftar' || $key == 'Biaya SPP') {
                    $subtotal_spp_pendaftaran += $value['biaya'];
                }
            }

            
            // Menambahkan terbayar pada tagihan_item
            $total_terbayar = 0;
            foreach ($tagihan_item_list as $key => $value) {
                if (isset($tagihan_item[$value])) {
                    $bayar_item = !empty($pembayaran_item[$value]['nominal']) ? (int) $pembayaran_item[$value]['nominal'] : 0;
                    $biaya_item = !empty($tagihan_item[$value]['biaya']) ? (int) $tagihan_item[$value]['biaya'] : 0;
                    $terbayar_item = !empty($terbayar[$value]['terbayar']) ? (int) ($terbayar[$value]['terbayar'] + $bayar_item) : $bayar_item;
                    $tagihan_item[$value] += [
                        'bayar' => $bayar_item,
                        'terbayar' => $terbayar_item,
                        'sisa' => $biaya_item - $terbayar_item,
                    ];
                    $total_terbayar += $terbayar_item;
                }
            }

            $payment_summary = [];
            $discount = !empty($ppdb->discount) ? ($ppdb->discount_type == 'fixed_amount' ? $ppdb->discount : $subtotal_spp_pendaftaran * $ppdb->discount / 100) : 0;
            $payment_summary[] = [
                'subtotal_tagihan' => $subtotal_tagihan,
                'discount' => $discount,
                'terbayar' => $total_terbayar + $discount,
                'total_tagihan' => (int) ($subtotal_tagihan) - ($total_terbayar + $discount),
            ];

            $paramsEmail = [];
            $paramsEmail['ppdb'] = $ppdb;
            $paramsEmail['mail_type'] = 'payment_confirmation';
            $paramsEmail['pembayaran_item'] = $pembayaran_item;
            $paramsEmail['tagihan_item'] = $tagihan_item;
            $paramsEmail['payment_summary'] = $payment_summary;
            $paramsEmail['is_approved'] = true;
            $paramsEmail['created_at'] = $ppdb->created_at;
            $paramsEmail['paid_at'] = $pembayaran->created_at;
            $paramsEmail['nama'] = $ppdb->nama;
            $paramsEmail['nis'] = $ppdb->nis;
            $paramsEmail['nik'] = $ppdb->nik_siswa;
            $paramsEmail['biaya_daftar'] = (int) ($tagihan_item['Biaya Daftar']['nominal'] ?? 0);
            $paramsEmail['biaya_daftar_paid'] = (int) ($terbayar['Biaya Daftar']->total_terbayar ?? 0);
            $paramsEmail['biaya_daftar_sisa'] = $paramsEmail['biaya_daftar'] - $paramsEmail['biaya_daftar_paid'];
            $paramsEmail['biaya_program'] = (int) ($tagihan_item['Biaya Program']['nominal'] ?? 0);
            $paramsEmail['biaya_program_paid'] = (int) ($terbayar['Biaya Program']->total_terbayar ?? 0);
            $paramsEmail['biaya_program_sisa'] = $paramsEmail['biaya_program'] - $paramsEmail['biaya_program_paid'];
            $paramsEmail['biaya_spp'] = (int) ($tagihan_item['Biaya SPP']['nominal'] ?? 0);
            $paramsEmail['biaya_spp_paid'] = (int) ($terbayar['Biaya SPP']->total_terbayar ?? 0);
            $paramsEmail['biaya_spp_sisa'] = $paramsEmail['biaya_spp'] - $paramsEmail['biaya_spp_paid'];
            $paramsEmail['wakaf'] = (int) ($tagihan_item['Biaya Wakaf']['nominal'] ?? 0);
            $paramsEmail['wakaf_paid'] = !empty($pembayaran_item['Biaya Wakaf']) ? (int) ($terbayar['Wakaf']->total_terbayar ?? 0) : 0;
            $paramsEmail['wakaf_sisa'] = $paramsEmail['wakaf'] - $paramsEmail['wakaf_paid'];
            $paramsEmail['infaq'] = (int) ($tagihan_item['Biaya Infaq & Sedekah']['nominal'] ?? 0);
            $paramsEmail['infaq_paid'] = !empty($pembayaran_item['Biaya Infaq & Sedekah']) ?
                (int) ($terbayar['Infaq']->total_terbayar ?? 0) :
                0;
            $paramsEmail['infaq_sisa'] = $paramsEmail['infaq'] - $paramsEmail['infaq_paid'];
            $paramsEmail['subtotal_spp_program_pendaftaran'] = $paramsEmail['biaya_daftar'] + $paramsEmail['biaya_program'] + $paramsEmail['biaya_spp'];
            $paramsEmail['subtotal_spp_pendaftaran'] = $paramsEmail['biaya_daftar'] + $paramsEmail['biaya_spp'];
            $paramsEmail['discount'] = !empty($ppdb->discount) ? ($ppdb->discount_type == 'fixed_amount' ? $ppdb->discount
                : $paramsEmail['subtotal_spp_pendaftaran'] * $ppdb->discount / 100) : 0;
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

            SendEmailJob::dispatch(
                $paramsEmail,
                [
                    'email' => $ppdb->email,
                    'name' => $ppdb->user_detail->name,
                ]
            );

            $pembayaran->save();
            $tagihan->save();
            DB::commit();
            return response()->json(['error' => false, 'message' => null, 'data' => null ], 200); 
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => true, 'message' => $e->getMessage(), 'trace' => $e->getTrace()], 400);
        } catch (\Throwable $e) {
            DB::rollBack();
            return response()->json(['error' => true, 'message' => $e->getMessage(), 'trace' => $e->getTrace()], 400);
        }
    }

    public function exportExcelPembayaran(Request $request)
    {
        $file_name = "Semua";
        $date = Carbon::now();
        $kelas_id = !empty($request->kelas_id) ? $request->kelas_id : null;

        if ($kelas_id != null) {
            $data = KelasModel::where('id', $kelas_id)->first();
            $file_name = $data->nama;
        }

        return Excel::download(new ExportPembayaran($kelas_id), 'Pembayaran - '.$file_name.' - ['.$date->format('d M Y').'].xlsx');
    }

    public function sendEmailInvoice(Request $request)
    {
        DB::beginTransaction();
        try {
            $pembayaran_nominal = null;
            $pembayaran = PembayaranModel::where('id', $request->get('pembayaran_id'))->first();
            $pembayaran_nominal = $pembayaran->nominal;
            $pembayaran->is_paid = true;
            $pembayaran->is_approved = true;

            $ppdb_id = null;
            $tagihan = TagihanModel::where('id', $request->get('tagihan_id'))->first();
            $tagihan_Nominal = $tagihan->nominal + $pembayaran_nominal;
            $ppdb_id = $tagihan->ppdb_id;
            $status_tagihan = '';
            $isPaidOff = false;
            if ($tagihan->total_tagihan == $tagihan_Nominal) {
                $status_tagihan = TagihanModel::STATUS_LUNAS;
                $isPaidOff = true;
            } elseif ($tagihan->total_tagihan > $tagihan_Nominal) {
                $status_tagihan = TagihanModel::STATUS_LUNAS_SEBAGIAN;
            }
            // dd($request->tagihan_id.".".$tagihan."+".$pembayaran_nominal);
            $tagihan->nominal = $tagihan_Nominal;
            $tagihan->status = $status_tagihan;
            
            
            $ppdb = PpdbModel::with(['user_detail'])
                        ->where('id', $ppdb_id)
                        ->first();
            $ppdb->is_approved = true;

            if (!$ppdb->is_active && empty($ppdb->nis)) {
                $nis = PpdbModel::generateNis();
                $password = Constant::PPDB_DEFAULT_PASSWORD;
                $username = $nis ?? $ppdb->user_detail->email;
                $tgl_terima = date('Y-m-d');
                
                $ppdb->nis = $nis;
                $ppdb->is_active = true;
                $ppdb->tgl_terima = $tgl_terima;

                $ppdb->user_detail->password = bcrypt($password);
                $ppdb->user_detail->username = $username;
                $ppdb->user_detail->is_active = true;
                $ppdb->user_detail->save();

                SendVerificationPpdbJob::dispatch(
                    [
                        'name' => $ppdb->user_detail->name,
                        'username' => $username,
                        'nik' => $ppdb->nik_siswa,
                        'password' => $password,
                    ],
                    [
                        'email' => $ppdb->email,
                        'name' => $ppdb->user_detail->name,
                    ]
                );
            }

            $ppdb->save();

            
            // Cek rombel
            $rombel = RombelModel::where('ppdb_id', $ppdb->id)
                ->where('tahun_akademik_id', $ppdb->tahun_akademik_id)
                ->first();
            
            if(!empty($rombel)){
                // Update rombel
                $rombel->is_active = true;
                $rombel->save();
            }else{
                // Create rombel
                $rombel = RombelModel::create([
                    'ppdb_id' => $ppdb->id,
                    'tahun_akademik_id' => !empty($ppdb->tahun_akademik_id) ? $ppdb->tahun_akademik_id : null,
                    'kelas_id' => !empty($ppdb->kelas_id) ? $ppdb->kelas_id : null,
                    'status_wb' => 'Baru',
                    'is_active' => true,
                ]);
            }
            
            // Update is_active rombel & ppdb_ulang
            $tahun_akademik_active = TahunAkademikModel::where('is_active', true)->first();
            if ($tagihan->type == TagihanModel::TYPE_DAFTAR_ULANG) {
                # Update Rombel
                $rombel = RombelModel::where('ppdb_id', $ppdb_id)
                                    ->where('tahun_akademik_id', $tahun_akademik_active->id)
                                    ->first();
                $rombel->is_active = true;
                $rombel->save();

                # Update Ppdb Ulang
                $ppdb_ulang = PpdbUlangModel::where('ppdb_id', $ppdb_id)
                                        ->where('tahun_akademik_id', $tahun_akademik_active->id)
                                        ->first();
                
                $ppdb_ulang->is_active = true;
                $ppdb_ulang->save();
            }
            
            // Mendapatkan data tabel pembayaran_items
            $pembayaran_item = [];
            $pembayaran_item_query = PpdbModel::select('pay_items.id', 'pay_items.pembayaran_id', 'pay_items.item', 'pay_items.nominal')
                                                ->join('pembayaran as pay', 'pay.source_id', '=', 'ppdb.id')
                                                ->join('pembayaran_items as pay_items', 'pay_items.pembayaran_id', '=', 'pay.id')
                                                ->where('ppdb.id', $ppdb_id)
                                                ->where('pay_items.pembayaran_id', $request->pembayaran_id)
                                                ->get()
                                                ->toArray();
            // Mengubah index result menjadi kolom item
            array_map(function ($item) use (&$pembayaran_item) {
                $pembayaran_item[$item['item']] = $item;
            }, $pembayaran_item_query);
            

            // Tagihan Item
            $tagihan_item = [];
            $tagihan_item_query = TagihanItemsModel::selectRaw('item, nominal AS biaya')
                                                    ->where('tagihan_id', $request->tagihan_id)
                                                    ->get()
                                                    ->toArray();
            array_map(function ($item) use (&$tagihan_item) {
                $tagihan_item[$item['item']] = $item;
            }, $tagihan_item_query);


            // Mendapatkan total yang sudah dibayar
            $terbayar = [];
            $terbayar_query = PembayaranItemsModel::selectRaw("pembayaran.tagihan_id, pembayaran_items.item, SUM(pembayaran_items.nominal) as terbayar")
                                ->leftJoin('pembayaran','pembayaran.id','=','pembayaran_items.pembayaran_id')
                                ->where('pembayaran.tagihan_id', $request->tagihan_id)
                                ->where('pembayaran.is_approved', 1)
                                ->groupBy('pembayaran.tagihan_id','pembayaran_items.item')
                                ->get()
                                ->toArray();
            array_map(function ($item) use (&$terbayar) {
                $terbayar[$item['item']] = $item;
            }, $terbayar_query);


            // Mendapatkan data item tagihan
            $tagihan_item_list = [];
            (int) $subtotal_tagihan = 0;
            (int) $subtotal_spp_pendaftaran = 0;

            foreach ($tagihan_item as $key => $value) {
                $tagihan_item_list[] = $key;
                $subtotal_tagihan += $value['biaya'];
                if ($key == 'Biaya Daftar' || $key == 'Biaya SPP') {
                    $subtotal_spp_pendaftaran += $value['biaya'];
                }
            }

            
            // Menambahkan terbayar pada tagihan_item
            $total_terbayar = 0;
            foreach ($tagihan_item_list as $key => $value) {
                if (isset($tagihan_item[$value])) {
                    $bayar_item = !empty($pembayaran_item[$value]['nominal']) ? (int) $pembayaran_item[$value]['nominal'] : 0;
                    $biaya_item = !empty($tagihan_item[$value]['biaya']) ? (int) $tagihan_item[$value]['biaya'] : 0;
                    $terbayar_item = !empty($terbayar[$value]['terbayar']) ? (int) ($terbayar[$value]['terbayar'] + $bayar_item) : $bayar_item;
                    $tagihan_item[$value] += [
                        'bayar' => $bayar_item,
                        'terbayar' => $terbayar_item,
                        'sisa' => $biaya_item - $terbayar_item,
                    ];
                    $total_terbayar += $terbayar_item;
                }
            }

            $payment_summary = [];
            $discount = !empty($ppdb->discount) ? ($ppdb->discount_type == 'fixed_amount' ? $ppdb->discount : $subtotal_spp_pendaftaran * $ppdb->discount / 100) : 0;
            $payment_summary[] = [
                'subtotal_tagihan' => $subtotal_tagihan,
                'discount' => $discount,
                'terbayar' => $total_terbayar + $discount,
                'total_tagihan' => (int) ($subtotal_tagihan) - ($total_terbayar + $discount),
            ];

            $paramsEmail = [];
            $paramsEmail['ppdb'] = $ppdb;
            $paramsEmail['mail_type'] = 'reminder_invoice';
            $paramsEmail['pembayaran_item'] = $pembayaran_item;
            $paramsEmail['tagihan_item'] = $tagihan_item;
            $paramsEmail['payment_summary'] = $payment_summary;
            $paramsEmail['is_approved'] = true;
            $paramsEmail['created_at'] = $ppdb->created_at;
            $paramsEmail['paid_at'] = $pembayaran->created_at;
            $paramsEmail['nama'] = $ppdb->nama;
            $paramsEmail['nis'] = $ppdb->nis;
            $paramsEmail['nik'] = $ppdb->nik_siswa;
            $paramsEmail['biaya_daftar'] = (int) ($tagihan_item['Biaya Daftar']['nominal'] ?? 0);
            $paramsEmail['biaya_daftar_paid'] = (int) ($terbayar['Biaya Daftar']->total_terbayar ?? 0);
            $paramsEmail['biaya_daftar_sisa'] = $paramsEmail['biaya_daftar'] - $paramsEmail['biaya_daftar_paid'];
            $paramsEmail['biaya_program'] = (int) ($tagihan_item['Biaya Program']['nominal'] ?? 0);
            $paramsEmail['biaya_program_paid'] = (int) ($terbayar['Biaya Program']->total_terbayar ?? 0);
            $paramsEmail['biaya_program_sisa'] = $paramsEmail['biaya_program'] - $paramsEmail['biaya_program_paid'];
            $paramsEmail['biaya_spp'] = (int) ($tagihan_item['Biaya SPP']['nominal'] ?? 0);
            $paramsEmail['biaya_spp_paid'] = (int) ($terbayar['Biaya SPP']->total_terbayar ?? 0);
            $paramsEmail['biaya_spp_sisa'] = $paramsEmail['biaya_spp'] - $paramsEmail['biaya_spp_paid'];
            $paramsEmail['wakaf'] = (int) ($tagihan_item['Biaya Wakaf']['nominal'] ?? 0);
            $paramsEmail['wakaf_paid'] = !empty($pembayaran_item['Biaya Wakaf']) ? (int) ($terbayar['Wakaf']->total_terbayar ?? 0) : 0;
            $paramsEmail['wakaf_sisa'] = $paramsEmail['wakaf'] - $paramsEmail['wakaf_paid'];
            $paramsEmail['infaq'] = (int) ($tagihan_item['Biaya Infaq & Sedekah']['nominal'] ?? 0);
            $paramsEmail['infaq_paid'] = !empty($pembayaran_item['Biaya Infaq & Sedekah']) ?
                (int) ($terbayar['Infaq']->total_terbayar ?? 0) :
                0;
            $paramsEmail['infaq_sisa'] = $paramsEmail['infaq'] - $paramsEmail['infaq_paid'];
            $paramsEmail['subtotal_spp_program_pendaftaran'] = $paramsEmail['biaya_daftar'] + $paramsEmail['biaya_program'] + $paramsEmail['biaya_spp'];
            $paramsEmail['subtotal_spp_pendaftaran'] = $paramsEmail['biaya_daftar'] + $paramsEmail['biaya_spp'];
            $paramsEmail['discount'] = !empty($ppdb->discount) ? ($ppdb->discount_type == 'fixed_amount' ? $ppdb->discount
                : $paramsEmail['subtotal_spp_pendaftaran'] * $ppdb->discount / 100) : 0;
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

            SendEmailJob::dispatch(
                $paramsEmail,
                [
                    'email' => $ppdb->email,
                    'name' => $ppdb->user_detail->name,
                ]
            );

            $pembayaran->save();
            $tagihan->save();
            DB::commit();
            return response()->json(['error' => false, 'message' => null, 'data' => null ], 200); 
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => true, 'message' => $e->getMessage(), 'trace' => $e->getTrace()], 400);
        } catch (\Throwable $e) {
            DB::rollBack();
            return response()->json(['error' => true, 'message' => $e->getMessage(), 'trace' => $e->getTrace()], 400);
        }
    }
}
