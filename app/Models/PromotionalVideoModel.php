<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PromotionalVideoModel extends Model
{
    use HasFactory;
    protected $table = 'promotional_videos';
    protected $fillable = [
        'link'
    ];

    // protected $appends = ['file_link'];

    // public function getFileLinkAttribute() 
    // {
    //     $path=$this->attributes['link'];
    //     $explode = explode('.', $path);
    //     if($explode[1] == 'jpg' || $explode[1] == 'jpeg' || $explode[1] == 'png' || $explode[1] == 'JPG' || $explode[1] == 'JPEG' || $explode[1] == 'PNG'){
    //         return Helper::serveImage($path);
    //     }else{
    //         return Helper::staticPath($path);
    //     }

    // }
}
