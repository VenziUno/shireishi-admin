<?php

namespace App\Repository;

use App\Models\HashtagsModel;
use App\Helper\Helper;

use Exception;

class HashtagRepository
{

    function getData($n = NULL)
    {
        $data = HashtagsModel::with(['HasBlog.Blog'])->orderBy('id', 'desc');

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
        $data = HashtagsModel::find($id);
        return $data;
    }

    function addData()
    {
        $data = HashtagsModel::create([
            'name' => request('name'),
        ]);
    }

    function updateData($id)
    {
        $data = [
            'name' => request('name'),
        ];
        HashtagsModel::find($id)->update($data);

    }

    function deleteData($id)
    {
        $data = HashtagsModel::find($id);
        HashtagsModel::find($id)->delete();
    }
}
