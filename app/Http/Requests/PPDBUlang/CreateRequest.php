<?php

namespace App\Http\Requests\PPDBUlang;

use Illuminate\Foundation\Http\FormRequest;

class CreateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'user_id' => 'required|exists:users,id',
            'ppdb_id' => 'required|exists:ppdb,id',
            'type' => 'required',
            'kelas_sebelum_id' => 'nullable',
            'tahun_akademik_id' => 'required|exists:tahun_akademik,id',
            'kelas' => 'nullable',
            'semester' => 'nullable',
            'peminatan' => 'nullable',
            'layanan_kelas_id' => 'required|exists:layanan_kelas,id',
            'paket_kelas_id' => 'required|exists:paket_kelas,id',
            'paket_spp_id' => 'required|exists:paket_spp,id',
            'url_bukti_trf' => 'required',
            'url_bukti_trf2' => 'nullable',
            'biaya_daftar' => 'nullable',
            'biaya_spp' => 'nullable',
            'bayar_daftar' => 'nullable',
            'bayar_spp' => 'nullable',
            'biaya' => 'nullable',
            'wakaf' => 'nullable',
            'infaq' => 'nullable',
            'url_bukti_trf_infaq' => 'nullable',
            'kelas_id' => 'nullable',
            'is_active' => 'nullable',
            'is_approved' => 'nullable',
            'bank_name' => 'required',
            'bank_account_number' => 'required',
            'bank_account_name' => 'required',
        ];
    }
}
