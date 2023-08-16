<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class WebProfileRequest extends FormRequest
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
            'about' => 'required',
            'link' => "required",
            'contact' => "required",
            // 'twitter' => "required",
        ];
    }

    public function messages()
    {
        return[
            'about.required' => "Masukkan Tentang Kami",
            'link.required' => "Masukkan Link",
            'contact.required' => "Masukkan Kontak",
        ];
    }
}
