<?php

namespace App\Repository;

use App\Models\BlogsModel;
use App\Models\BlogHasHashtagsModel;
use App\Models\BlogImagesModel;
use App\Helper\Helper;

use Exception;

class BlogRepository
{

    function getData($n = NULL)
    {
        $data = BlogsModel::with(['HasHashtag.Hashtag', 'Category', 'Admin', 'Image'])->orderBy('id', 'desc');
        if(request('id')){
            return $data->find(request('id'));
        }
        
        if(request('search')){
            $keyword = request('search');
            $data = $data->where('title', 'LIKE', "%$keyword%");
        }

        if(request('category')){
            $data = $data->where('blog_categories_id', request('category'));
        }
        if(request('hashtag') && (request('hashtag')[0] != NULL || request('hashtag')[0] != "")){
            $hashtag = explode(',', request('hashtag'));
            $data = $data->whereHas('HasHashtag', function($query) use($hashtag){
                $query->whereIn('hashtags_id', $hashtag);
            });
        }
        
        if($n){
            return $data->paginate($n);
        }
        else{
            return $data->get();
        }
    }

    function getSingleData($id)
    {
        $data = BlogsModel::with(['HasHashtag.Hashtag', 'Category', 'Admin', 'Image'])->find($id);
        return $data;
    }

    function addData()
    {
        $data = BlogsModel::create([
            'title' => request('title'),
            'body' => request('body'),
            'cover_image' => request('picture'),
            'admins_id' => request('admin'),
            'blog_categories_id' => request('category'),
            'short_description' => request('short_description'),
        ]);

        if(request('sub_photo')){
            foreach(request('sub_photo') as $key=>$i){
                BlogImagesModel::create([
                    'blogs_id' => $data->id, 
                    'image_link' => $i, 
                    'caption' => request('caption')[$key]
                ]);
            }
        }

        if(request('hashtag')){
            foreach(request('hashtag') as $has){
                BlogHasHashtagsModel::create([
                    'blogs_id' => $data->id, 
                    'hashtags_id' => $has
                ]);
            }
        }
    }

    function updateData($id)
    {
        $data = [
            'title' => request('title'),
            'body' => request('body'),
            'cover_image' => request('picture'),
            'admins_id' => request('admin'),
            'blog_categories_id' => request('category'),
            'short_description' => request('short_description'),
        ];
        BlogsModel::find($id)->update($data);
        
        BlogImagesModel::where('blogs_id', $id)->delete();
        if(request('sub_photo')){
            foreach(request('sub_photo') as $key=>$i){
                BlogImagesModel::create([
                    'blogs_id' => $id, 
                    'image_link' => $i, 
                    'caption' => request('caption')[$key]
                ]);
            }
        }

        BlogHasHashtagsModel::where('blogs_id', $id)->delete();
        if(request('hashtag')){
            foreach(request('hashtag') as $has){
                BlogHasHashtagsModel::create([
                    'blogs_id' => $id, 
                    'hashtags_id' => $has
                ]);
            }
        }

    }

    function deleteData($id)
    {
        BlogHasHashtagsModel::where('blogs_id', $id)->delete();
        BlogsModel::find($id)->delete();
    }
}
