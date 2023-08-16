<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MenusModel extends Model
{
    use HasFactory;
    protected $table = 'menus';
    protected $fillable = [
        'name', 'deleted_at', 'route', 'sort_number', 'menu_groups_id'
    ];

    function Authorization()
    {
        return $this->hasMany(AuthorizationsModel::class, 'menus_id', 'id');
    }
}
