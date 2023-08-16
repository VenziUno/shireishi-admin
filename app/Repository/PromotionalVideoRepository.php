<?php

namespace App\Repository;

use App\Models\PromotionalVideoModel;
use App\Helper\Helper;

use Exception;

class PromotionalVideoRepository
{

    function getData($n = NULL)
    {
        $data = PromotionalVideoModel::orderBy('id', 'desc');

        if(request('search')){
            $keyword = request('search');
            $data = $data->where('link', 'LIKE', "%$keyword%");
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
        $data = PromotionalVideoModel::find($id);
        return $data;
    }

    function addData()
    {
        $data = PromotionalVideoModel::create([
            'link' => request('link'),
        ]);

    }

    function updateData($id)
    {
        $data = [
            'link' => request('link'),
        ];
        PromotionalVideoModel::find($id)->update($data);

    }

    function deleteData($id)
    {
        $data = PromotionalVideoModel::find($id);
        PromotionalVideoModel::find($id)->delete();
    }
}
