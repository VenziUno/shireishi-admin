<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BlogHasHashtagsModel extends Model
{
    use HasFactory;
    protected $table = 'blog_has_hashtags';
    protected $fillable = [
        'blogs_id', 'hashtags_id'
    ];

    function Blog()
    {
        return $this->belongsTo(BlogsModel::class, 'blogs_id', 'id');
    }

    function Hashtag()
    {
        return $this->belongsTo(HashtagsModel::class, 'hashtags_id', 'id');
    }
}
