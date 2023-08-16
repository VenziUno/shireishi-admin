<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GameHasGameCategoriesModel extends Model
{
    use HasFactory;
    protected $table = 'game_has_game_categories';
    protected $fillable = [
        'games_id', 'game_categories_id'
    ];

    function Game()
    {
        return $this->belongsTo(GamesModel::class, 'games_id', 'id');
    }

    function Category()
    {
        return $this->belongsTo(GameCategoriesModel::class, 'game_categories_id', 'id');
    }
}
