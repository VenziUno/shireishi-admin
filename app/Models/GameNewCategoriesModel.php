<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GameNewCategoriesModel extends Model
{
    use HasFactory;
    protected $table = 'game_news_categories';
    protected $fillable = [
        'name'
    ];

    function News()
    {
        return $this->hasMany(GameNewsModel::class, 'game_news_categories_id', 'id');
    }
}
