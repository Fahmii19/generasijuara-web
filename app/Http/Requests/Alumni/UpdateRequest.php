<?php

namespace App\Http\Requests\Alumni;

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
            "nis" => 'nullable',
            "nisn" => 'nullable',
            "email" => 'nullable',
            "jenis_kelamin" => 'nullable',
            "nama" => 'nullable',
            "no_hp" => 'nullable',
            "paket" => 'nullable',
            "tahun_akademik_id" => 'nullable',
            "lanjut_kuliah" => 'nullable',
            "nama_sekolah" => 'nullable',
            "surat_penerimaan" => 'nullable',
            "prodi" => 'nullable',
            "usaha" => 'nullable',
            "sertifikat" => 'nullable'
        ];
    }
}
