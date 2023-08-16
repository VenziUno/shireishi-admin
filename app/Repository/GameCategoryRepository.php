<?php

namespace App\Repository;

use App\Models\GameCategoriesModel;
use App\Helper\Helper;

use Exception;

class GameCategoryRepository
{

    function getData($n = NULL)
    {
        $data = GameCategoriesModel::with(['HasGame.Game'])->orderBy('id', 'desc');

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
        $data = GameCategoriesModel::find($id);
        return $data;
    }

    function addData()
    {
        $data = GameCategoriesModel::create([
            'name' => request('name'),
        ]);

    }

    function updateData($id)
    {
        $data = [
            'name' => request('name'),
        ];
        GameCategoriesModel::find($id)->update($data);

    }

    function deleteData($id)
    {
        $data = GameCategoriesModel::find($id);
        GameCategoriesModel::find($id)->delete();
    }
}
