<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Notifications\Notifiable;

class AdminModel extends Authenticatable
{
    use HasFactory;
    protected $table = 'admin';
    protected $fillable = [
        'fullname', 'email', 'password', 'is_active', 'admin_groups_id'
    ];

    function AdminGroup()
    {
        return $this->belongsTo(AdminGroupsModel::class, 'admin_groups_id', 'id');
    }

    function News()
    {
        return $this->hasMany(NewsModel::class, 'admin_id', 'id');
    }
}
