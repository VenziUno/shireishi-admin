<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Helper\Helper;

class SocialMediaModel extends Model
{
    use HasFactory;
    protected $table = 'social_media';
    protected $fillable = [
        'name', 'logo', 'link'
    ];

    protected $appends = ['file_link'];

    public function getFileLinkAttribute() 
    {
        $path=$this->attributes['logo'];
        $explode = explode('.', $path);
        if(end($explode) == 'jpg' || end($explode) == 'jpeg' || end($explode) == 'png' || end($explode) == 'JPG' || end($explode) == 'JPEG' || end($explode) == 'PNG'){
            return Helper::serveImage($path);
        }else{
            return Helper::staticPath($path);
        }

    }
}
