<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdminGroupsModel extends Model
{
    use HasFactory;
    protected $table = 'admin_groups';
    protected $fillable = [
        'name', 'deleted_at'
    ];

    function Admin()
    {
        return $this->hasMany(AdminModel::class, 'admin_groups_id', 'id');
    }

    function Authorize()
    {
        return $this->hasMany(AuthorizationsModel::class, 'admin_groups_id', 'id');
    }
}
