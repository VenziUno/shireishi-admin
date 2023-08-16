<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Helper\Helper;

class GamesModel extends Model
{
    use HasFactory;
    protected $table = 'games';
    protected $fillable = [
        'name', 'cover_image', 'color_background', 'redirect_link', 'order', 'status', 'description', 'small_icon', 'web_background_image'
    ];

    protected $appends = ['cover_link', 'icon_link', 'background_link'];

    public function getCoverLinkAttribute() 
    {
        $path=$this->attributes['cover_image'];
        if($path){
            $explode = explode('.', $path);
            if(end($explode) == 'jpg' || end($explode) == 'jpeg' || end($explode) == 'png' || end($explode) == 'JPG' || end($explode) == 'JPEG' || end($explode) == 'PNG'){
                return Helper::serveImage($path);
            }else{
                return Helper::staticPath($path);
            }
        }
    }

    public function getIconLinkAttribute() 
    {
        $path=$this->attributes['small_icon'];
        if($path){
            $explode = explode('.', $path);
            if($explode[1] == 'jpg' || $explode[1] == 'jpeg' || $explode[1] == 'png' || $explode[1] == 'JPG' || $explode[1] == 'JPEG' || $explode[1] == 'PNG'){
                return Helper::serveImage($path);
            }else{
                return Helper::staticPath($path);
            }
        }
    }

    public function getBackgroundLinkAttribute() 
    {
        $path=$this->attributes['web_background_image'];
        if($path){
            $explode = explode('.', $path);
            if($explode[1] == 'jpg' || $explode[1] == 'jpeg' || $explode[1] == 'png' || $explode[1] == 'JPG' || $explode[1] == 'JPEG' || $explode[1] == 'PNG'){
                return Helper::serveImage($path);
            }else{
                return Helper::staticPath($path);
            }
        }
    }

    function Photo()
    {
        return $this->hasMany(GamePhotosModel::class, 'games_id', 'id');
    }

    function Banner()
    {
        return $this->hasMany(BannerModel::class, 'games_id', 'id');
    }

    function HasCategory()
    {
        return $this->hasMany(GameHasGameCategoriesModel::class, 'games_id', 'id');
    }

    function Require()
    {
        return $this->hasOne(GameSystemRequirementModel::class, 'games_id', 'id');
    }

    function DownloadLink()
    {
        return $this->hasMany(GameDownloadLinkModel::class, 'games_id', 'id');
    }


}
