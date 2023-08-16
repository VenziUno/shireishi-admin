<?php

namespace App\Repository;

use App\Models\BlogCategoriesModel;
use App\Helper\Helper;

use Exception;

class BlogCategoryRepository
{

    function getData($n = NULL)
    {
        $data = BlogCategoriesModel::with(['Blog'])->orderBy('id', 'desc');

        if(request('search')){
            $keyword = request('search');
            $data = $data->where('name', 'LIKE', "%$keyword%");
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
        $data = BlogCategoriesModel::find($id);
        return $data;
    }

    function addData()
    {
        $data = BlogCategoriesModel::create([
            'name' => request('name'),
        ]);

    }

    function updateData($id)
    {
        $data = [
            'name' => request('name'),
        ];
        BlogCategoriesModel::find($id)->update($data);

    }

    function deleteData($id)
    {
        $data = BlogCategoriesModel::find($id);
        BlogCategoriesModel::find($id)->delete();
    }
}
