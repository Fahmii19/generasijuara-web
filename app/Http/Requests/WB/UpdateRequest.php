<?php

namespace App\Http\Requests\WB;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRequest extends FormRequest
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
            // 'nis' => 'nullable|required_if:is_active,true',
            'nisn' => 'nullable',
            'nis' => 'required',
            'jenis_kelamin' => 'required',
            'nama' => 'required',
            'nama_ayah' => 'nullable',
            'nama_ibu' => 'nullable',
            'nik_siswa' => 'required',
            'nik_ayah' => 'required',
            'nik_ibu' => 'required',
            'tempat_lahir' => 'required',
            'tanggal_lahir' => 'required',
            'status_dalam_keluarga' => 'nullable',
            'anak_ke' => 'nullable',
            'alamat_peserta_didik' => 'nullable',
            'alamat_domisili' => 'nullable',
            'alamat_orang_tua' => 'nullable',
            'no_telp_rumah' => 'nullable',
            'agama' => 'nullable',
            'pekerjaan_ayah' => 'nullable',
            'pekerjaan_ibu' => 'nullable',
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
            'tgl_terima' => 'nullable',
            'is_active' => 'nullable',
        ];
    }
}
