<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Helper\Helper;

class BlogImagesModel extends Model
{
    use HasFactory;
    protected $table = 'blog_images';
    protected $fillable = [
        'blogs_id', 'image_link', 'caption'
    ];

    protected $appends = ['file_link'];

    public function getFileLinkAttribute() 
    {
        $path=$this->attributes['image_link'];
        $explode = explode('.', $path);
        if(end($explode) == 'jpg' || end($explode) == 'jpeg' || end($explode) == 'png' || end($explode) == 'JPG' || end($explode) == 'JPEG' || end($explode) == 'PNG'){
            return Helper::serveImage($path);
        }else{
            return Helper::staticPath($path);
        }

    }

    function Blog()
    {
        return $this->belongsTo(BlogsModel::class, 'blogs_id', 'id');
    }
}
