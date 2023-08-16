<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Helper\Helper;

class BannerModel extends Model
{
    protected $table = 'banners';
    protected $fillable = [
        'title', 'cover_image_path', 'thumbnail_image_path', 'games_id', 'description', 'order', 'status'
    ];

    protected $appends = ['file_link', 'thumbnail_link'];

    public function getFileLinkAttribute() 
    {
        $path=$this->attributes['cover_image_path'];
        $explode = explode('.', $path);
        if(end($explode) == 'jpg' || end($explode) == 'jpeg' || end($explode) == 'png' || end($explode) == 'JPG' || end($explode) == 'JPEG' || end($explode) == 'PNG'){
            return Helper::serveImage($path);
        }else{
            return Helper::staticPath($path);
        }

    }

    public function getThumbnailLinkAttribute() 
    {
        $path=$this->attributes['thumbnail_image_path'];
        $explode = explode('.', $path);
        if(end($explode) == 'jpg' || end($explode) == 'jpeg' || end($explode) == 'png' || end($explode) == 'JPG' || end($explode) == 'JPEG' || end($explode) == 'PNG'){
            return Helper::serveImage($path);
        }else{
            return Helper::staticPath($path);
        }

    }

    function Game()
    {
        return $this->belongsTo(GamesModel::class, 'games_id', 'id');
    }
}
