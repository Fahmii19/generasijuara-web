<?php

namespace App\Http\Requests\PPDB;

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
            'cabang_id' => 'nullable',
            'nis' => 'nullable|unique:ppdb',
            'email' => 'required|email',
            'jenis_kelamin' => 'required|in:l,p',
            'nama' => 'required',
            'nama_ayah' => 'nullable',
            'nama_ibu' => 'nullable',
            'nik_siswa' => 'required|unique:ppdb',
            'nik_ayah' => 'required',
            'nik_ibu' => 'required',
            'hp_siswa' => 'required',
            'hp_ayah' => 'required',
            'hp_ibu' => 'required',
            'telegram_siswa' => 'nullable',
            'telegram_ayah' => 'nullable',
            'telegram_ibu' => 'nullable',
            'kelas_sebelum' => 'nullable',
            'smt_kelas_sebelum' => 'nullable',
            'tipe_kelas_sebelum' => 'nullable',
            'kelas' => 'nullable',
            'smt_kelas' => 'required',
            'peminatan' => 'nullable',
            'layanan_kelas_id' => 'required|exists:layanan_kelas,id',
            'paket_kelas_id' => 'required|exists:paket_kelas,id',
            'paket_spp_id' => 'required|exists:paket_spp,id',
            'lulusan' => 'nullable',
            'tahun_lulus' => 'nullable',
            'biaya_daftar' => 'nullable',
            'biaya_spp' => 'nullable',
            'biaya_program' => 'nullable',
            'wakaf' => 'nullable',
            'type' => 'required',
            'is_active' => 'nullable',
            'is_approved' => 'nullable',
            'password' => 'nullable',
            'bayar_daftar' => 'nullable',
            'bayar_kk' => 'nullable',
            'bayar_program' => 'nullable',
            'bayar_spp' => 'nullable',
            'bayar_wakaf' => 'nullable',
            'bayar_infaq' => 'nullable',
            'bukti_tf' => 'required',
            'bukti_infaq' => 'nullable',
            'voucher_code' => 'nullable',
            'bank_name' => 'required',
            'bank_account_number' => 'required',
            'bank_account_name' => 'required',
            'created_by_admin' => 'string',
        ];
    }
}
