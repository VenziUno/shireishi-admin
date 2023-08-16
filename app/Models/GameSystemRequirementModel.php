<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GameSystemRequirementModel extends Model
{
    use HasFactory;
    protected $table = 'game_system_requirement';
    protected $fillable = [
        'min_os', 'min_processor', 'min_memory', 'min_graphics', 'min_storage', 'rec_os', 'rec_processor', 'rec_memory', 'rec_graphics', 'rec_storage', 'games_id'
    ];

    function Game()
    {
        return $this->belongsTo(GamesModel::class, 'games_id', 'id');
    }
}
