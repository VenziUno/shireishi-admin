<?php

namespace App\Repository;

use App\Models\GameNewCategoriesModel;
use App\Helper\Helper;

use Exception;

class GameNewsCategoryRepository
{

    function getData($n = NULL)
    {
        $data = GameNewCategoriesModel::with(['News'])->orderBy('id', 'desc');

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
        $data = GameNewCategoriesModel::find($id);
        return $data;
    }

    function addData()
    {
        $data = GameNewCategoriesModel::create([
            'name' => request('name'),
        ]);

    }

    function updateData($id)
    {
        $data = [
            'name' => request('name'),
        ];
        GameNewCategoriesModel::find($id)->update($data);

    }

    function deleteData($id)
    {
        $data = GameNewCategoriesModel::find($id);
        GameNewCategoriesModel::find($id)->delete();
    }
}
