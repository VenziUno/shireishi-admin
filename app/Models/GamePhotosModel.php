<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Helper\Helper;

class GamePhotosModel extends Model
{
    use HasFactory;
    protected $table = 'game_photos';
    protected $fillable = [
        'link', 'games_id'
    ];

    protected $appends = ['file_link'];

    public function getFileLinkAttribute() 
    {
        $path=$this->attributes['link'];
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
