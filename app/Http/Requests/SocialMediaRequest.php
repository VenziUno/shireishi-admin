<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SocialMediaRequest extends FormRequest
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
            'name' => 'required',
            'link' => "required",
            'logo' => "required",
        ];
    }

    public function messages()
    {
        return[
            'name.required' => "Masukkan Nama",
            'link.required' => "Masukkan Link",
            'logo.required' => "Masukkan Logo",
        ];
    }
}
