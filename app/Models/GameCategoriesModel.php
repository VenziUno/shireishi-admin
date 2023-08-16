<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GameCategoriesModel extends Model
{
    use HasFactory;
    protected $table = 'game_categories';
    protected $fillable = [
        'name'
    ];

    function HasGame()
    {
        return $this->hasMany(GameHasGameCategoriesModel::class, 'game_categories_id', 'id');
    }
}
