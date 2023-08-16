<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AuthorizationTypesModel extends Model
{
    use HasFactory;
    protected $table = 'authorization_types';
    protected $fillable = [
        'name', 'deleted_at'
    ];
    public $timestamps=false;

    function Authorization()
    {
        return $this->hasMany(AuthorizationsModel::class, 'authorization_types_id', 'id');
    }
}
