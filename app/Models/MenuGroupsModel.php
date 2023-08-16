<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MenuGroupsModel extends Model
{
    use HasFactory;
    protected $table = 'menu_groups';
    protected $fillable = [
        'name'
    ];

    function Menu()
    {
        return $this->hasMany(MenusModel::class, 'menu_groups_id', 'id');
    }
}
