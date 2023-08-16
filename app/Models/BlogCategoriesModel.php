<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BlogCategoriesModel extends Model
{
    use HasFactory;
    protected $table = 'blog_categories';
    protected $fillable = [
        'name'
    ];

    function Blog()
    {
        return $this->hasMany(BlogsModel::class, 'blog_categories_id', 'id');
    }
}
