<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Helper\Helper;

class GameNewsModel extends Model
{
    use HasFactory;
    protected $table = 'game_news';
    protected $fillable = [
        'title', 'body', 'cover_image', 'admins_id', 'game_news_categories_id', 'games_id'
    ];

    protected $appends = ['file_link'];

    public function getFileLinkAttribute() 
    {
        $path=$this->attributes['cover_image'];
        $explode = explode('.', $path);
        if(end($explode) == 'jpg' || end($explode) == 'jpeg' || end($explode) == 'png' || end($explode) == 'JPG' || end($explode) == 'JPEG' || end($explode) == 'PNG'){
            return Helper::serveImage($path);
        }else{
            return Helper::staticPath($path);
        }

    }

    function Category()
    {
        return $this->belongsTo(GameNewCategoriesModel::class, 'game_news_categories_id', 'id');
    }

    function Game()
    {
        return $this->belongsTo(GamesModel::class, 'games_id', 'id');
    }

    function Admin()
    {
        return $this->belongsTo(AdminModel::class, 'admins_id', 'id');
    }
}
