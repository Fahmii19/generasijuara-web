<?php

namespace App\Http\Requests\User;

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
            'id' => 'nullable|numeric',
            'name' => 'required|string|max:255',
            'username' => 'required|string|unique:users|max:255',
            'email' => 'nullable|string|email|unique:users|max:255',
            'phone' => 'nullable|string|unique:users|max:20',
            'password' => 'required|string|confirmed',
            'role' => 'required|numeric',
            'is_active' => 'required|'
        ];
    }
}
