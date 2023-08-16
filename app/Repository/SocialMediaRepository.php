<?php

namespace App\Repository;

use App\Models\SocialMediaModel;
use Carbon\Carbon;
use App\Helper\Helper;

use Exception;

class SocialMediaRepository
{

    function getData($n)
    {
        $data = SocialMediaModel::orderBy('id', 'desc');
        if(request('search')){
            $keyword = request('search');
            $data = $data->where('name', 'LIKE', "%$keyword%");
        };
        return $data->paginate($n);
    }

    function showData()
    {
        $data = SocialMediaModel::orderBy('id', 'desc')->get();
        return $data;
    }

    function getSingleData($id)
    {
        $data = SocialMediaModel::find($id);
        return $data;
    }

    function addData()
    {
        $data = SocialMediaModel::create([
            'name' => request('name'),
            'logo' => request('logo'),
            'link' => request('link'),
        ]);
    }

    function updateData($id)
    {
        $data = [
            'name' => request('name'),
            'logo' => request('logo'),
            'link' => request('link'),
        ];
        SocialMediaModel::find($id)->update($data);
    }

    function deleteData($id)
    {
        $data = SocialMediaModel::find($id);
        SocialMediaModel::find($id)->delete();
    }
}
