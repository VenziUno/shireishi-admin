<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BannerRequest extends FormRequest
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
            'game' => 'required',
            'title' => 'required', 
            'description' => 'required', 
            'picture' => 'required', 
            'thumbnail_link' => 'required', 
            'order' => 'required'
        ];
    }

    public function messages()
    {
        return[
            'game.required' => "Masukkan Permainan",
            'title.required' => "Masukkan Judul",
            'description.required' => "Masukkan Deskripsi",
            'picture.required' => "Masukkan Gambar",
            'thumbnail_link.required' => "Masukkan Gambar Thumbnail",
            'order.required' => "Masukkan Urutan",
        ];
    }
}
