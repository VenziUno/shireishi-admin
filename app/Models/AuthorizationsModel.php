<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AuthorizationsModel extends Model
{
    use HasFactory;
    protected $table = 'authorizations';
    protected $fillable = [
        'admin_groups_id', 'authorization_types_id', 'menus_id'
    ];
    public $timestamps=false;

    function AdminGroup()
    {
        return $this->belongsTo(AdminGroupsModel::class, 'admin_groups_id', 'id');
    }

    function AuthType()
    {
        return $this->belongsTo(AuthorizationTypesModel::class, 'authorization_types_id', 'id');
    }
    
    function Menu()
    {
        return $this->belongsTo(MenusModel::class, 'menus_id', 'id');
    }
    
}
