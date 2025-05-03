<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Models\PembayaranModel;
use App\Http\Models\PembayaranItemsModel;
use Illuminate\Http\Request;

class SirekaController extends Controller
{
    public function home(Request $request)
    {
        if(session()->get('apps') != 'sireka') return redirect()->route('web.index');
        return view('admin.index');
    }

    public function keuanganPembayaranList(Request $request)
    {
        return view('admin.keuangan.pembayaran.list');
    }

    public function keuanganPembayaranDetail(Request $request, $id)
    {
        $data_pembayaran = PembayaranModel::where('tagihan_id', $id)->first();
        $terbayar = [];
        $terbayar_query = PembayaranItemsModel::selectRaw("pembayaran.tagihan_id, pembayaran_items.item, SUM(pembayaran_items.nominal) as terbayar")
                            ->leftJoin('pembayaran','pembayaran.id','=','pembayaran_items.pembayaran_id')
                            ->where('pembayaran.tagihan_id', $id)
                            ->where('pembayaran.is_approved', 1)
                            ->groupBy('pembayaran.tagihan_id','pembayaran_items.item')
                            ->get()
                            ->toArray();
        
        array_map(function ($item) use (&$terbayar) {
            $terbayar[$item['item']] = $item;
        }, $terbayar_query);
        
        $data = [
            'id' => $id,
            'data_pembayaran' => $data_pembayaran,
            'terbayar' => $terbayar,
        ];
        return view('admin.keuangan.pembayaran.detail', $data);
    }

    public function keuanganPembayaranDetailItem(Request $request, $id)
    {
        $data_pembayaran = PembayaranModel::where('id', $id)->first();
        $data = [
            'id' => $id,
            'data_pembayaran' => $data_pembayaran,
        ];
        return view('admin.keuangan.pembayaran.detail-item', $data);
    }

    public function keuanganDaftarAbcList(Request $request)
    {
        return view('admin.keuangan.daftar_abc.list');
    }

    public function keuanganDaftarAbcAdd(Request $request)
    {
        return view('admin.keuangan.daftar_abc.add');
    }
    
    public function keuanganSlipGajiList(Request $request)
    {
        return view('admin.keuangan.slip_gaji.list');
    }
    
    public function keuanganSlipGajiAdd(Request $request)
    {
        return view('admin.keuangan.slip_gaji.add');
    }
}
