<?php

namespace App\Http\Requests\PPDB;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProfileRequest extends FormRequest
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
            'jenis_kelamin' => 'required',
            'nama' => 'required',
            'nama_ayah' => 'nullable',
            'nama_ibu' => 'nullable',
            'nik_siswa' => 'required',
            'nik_ayah' => 'required',
            'nik_ibu' => 'required',
            'tempat_lahir' => 'required',
            'tanggal_lahir' => 'required',
            'status_dalam_keluarga' => 'required',
            'anak_ke' => 'required',
            'alamat_peserta_didik' => 'required',
            'alamat_domisili' => 'required',
            'alamat_orang_tua' => 'required',
            'no_telp_rumah' => 'nullable',
            'agama' => 'required',
            'pekerjaan_ayah' => 'required',
            'pekerjaan_ibu' => 'required',
            'hp_siswa' => 'required',
            'hp_ayah' => 'required',
            'hp_ibu' => 'required',
            'telegram_siswa' => 'nullable',
            'telegram_ayah' => 'nullable',
            'telegram_ibu' => 'nullable',
            'nama_wali' => 'nullable',
            'no_telp_wali' => 'nullable',
            'alamat_wali' => 'nullable',
            'pekerjaan_wali' => 'nullable',
            'satuan_pendidikan_asal' => 'nullable',
        ];
    }
}
