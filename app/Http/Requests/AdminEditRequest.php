<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AdminEditRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'group' => 'required',
            'name' => 'required',
            'email' => 'required',
        ];
    }

    public function messages()
    {
        return[
            'group.required' => "Masukkan Nama Group",
            'name.required' => "Masukkan Nama",
            'email.required' => "Masukkan Email",
        ];
    }
}
