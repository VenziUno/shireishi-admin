<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class GamesRequest extends FormRequest
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
            'picture' => 'required',
            'color' => 'required',
            'order' => 'required',
            'desc' => 'required',
            'icon' => 'required',
            'web' => 'required',
            'category' => 'required',
            'sub_photo' => 'required',
            'link' => 'required',
            'link_name' => 'required',
            'min_os' => 'required', 
            'min_processor' => 'required', 
            'min_memory' => 'required', 
            'min_graphics' => 'required', 
            'min_storage' => 'required', 
            'rec_os' => 'required', 
            'rec_processor' => 'required', 
            'rec_memory' => 'required', 
            'rec_graphics' => 'required', 
            'rec_storage' => 'required', 
        ];

    }

    public function messages()
    {
        return[
            'category.required' => "Pilih Kategori",
            'name.required' => "Masukkan Nama",
            'color.required' => "Masukkan Warna Latar Belakang",
            'picture.required' => "Masukkan Gambar Sampul",
            'order.required' => "Masukkan Urutan",
            'desc.required' => "Masukkan Deskripsi",
            'icon.required' => "Masukkan Icon",
            'web.required' => "Masukkan Gambar Latar Belakang",
            'sub_photo.required' => "Masukkan Sub-Gambar",
            'link.required' => "Masukkan Link Download",
            'link_name.required' => "Masukkan Nama Link Download",
            'min_os.required' => "Masukkan Minimum sistem OS",
            'min_processor.required' => "Masukkan Minimum sistem Prosesor",
            'min_memory.required' => "Masukkan Minimum sistem Memori",
            'min_graphics.required' => "Masukkan Minimum sistem Grafik",
            'min_storage.required' => "Masukkan Minimum sistem Kapasitas",
            'rec_os.required' => "Masukkan Rekomendasi sistem OS",
            'rec_processor.required' => "Masukkan Rekomendasi sistem Prosesor",
            'rec_memory.required' => "Masukkan Rekomendasi sistem Memori",
            'rec_graphics.required' => "Masukkan Rekomendasi sistem Grafik",
            'rec_storage.required' => "Masukkan Rekomendasi sistem Kapasitas",
        ];
    }
}
