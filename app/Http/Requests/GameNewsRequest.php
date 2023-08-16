<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class GameNewsRequest extends FormRequest
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
            'category' => 'required',
            'title' => 'required',
            // 'body' => 'required',
            'admin' => 'required',
            'picture' => 'required',
            'games_id' => 'required',
        ];
    }

    public function messages()
    {
        return[
            'category.required' => "Pilih Kategori",
            'admin.required' => "Pilih Pembuat",
            'title.required' => "Masukkan Judul",
            'picture.required' => "Masukkan Gambar",
            'hashtag.required' => "Pilih Hashtag",
        ];
    }
}
