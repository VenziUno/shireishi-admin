<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HashtagsModel extends Model
{
    use HasFactory;
    protected $table = 'hashtags';
    protected $fillable = [
        'name'
    ];

    function HasBlog()
    {
        return $this->hasMany(BlogHasHashtagsModel::class, 'hashtags_id', 'id');
    }
}
