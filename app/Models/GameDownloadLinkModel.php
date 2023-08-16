<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GameDownloadLinkModel extends Model
{
    use HasFactory;
    protected $table = 'game_download_links';
    protected $fillable = [
        'name', 'games_id', 'redirect_link'
    ];

    function Game()
    {
        return $this->belongsTo(GamesModel::class, 'games_id', 'id');
    }
}
