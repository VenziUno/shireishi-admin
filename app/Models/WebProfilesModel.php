<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WebProfilesModel extends Model
{
    use HasFactory;
    protected $table = 'web_profiles';
    protected $fillable = [
        'about_us', 'contact_us', 'embedded_twitter'
    ];
}