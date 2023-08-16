<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Helper\Helper;

class BlogsModel extends Model
{
    use HasFactory;
    protected $table = 'blogs';
    protected $fillable = [
        'title', 'body', 'cover_image', 'admins_id', 'blog_categories_id', 'short_description'
    ];

    protected $appends = ['file_link'];

    public function getFileLinkAttribute() 
    {
        $path=$this->attributes['cover_image'];
        $explode = explode('.', $path);
        if(end($explode) == 'jpg' || end($explode) == 'jpeg' || end($explode) == 'png' || end($explode) == 'JPG' || end($explode) == 'JPEG' || end($explode) == 'PNG'){
            return Helper::serveImage($path);
        }else{
            return Helper::staticPath($path);
        }

    }

    function Image()
    {
        return $this->hasMany(BlogImagesModel::class, 'blogs_id', 'id');
    }

    function Category()
    {
        return $this->belongsTo(BlogCategoriesModel::class, 'blog_categories_id', 'id');
    }

    function HasHashtag()
    {
        return $this->hasMany(BlogHasHashtagsModel::class, 'blogs_id', 'id');
    }

    function Admin()
    {
        return $this->belongsTo(AdminModel::class, 'admins_id', 'id');
    }
}
